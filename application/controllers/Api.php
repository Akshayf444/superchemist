<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Api extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper();
        $this->load->model('User_model');
        $this->load->model('Sms');
        $this->load->model('MobileVerification');
        $this->load->model('Brand');
    }

    public function sendVerification() {
        //var_dump($request);

        if ($this->input->get('mobile')) {
            $ver_code = rand(0, 9999);
            $message = "Your verification code is " . $ver_code;
            // var_dump($_POST);
            $mobile = $_GET['mobile'];
            $user_type = $_GET['user_type'];

            $this->Sms->sendsms($mobile, $message);

            $mobileexist = $this->MobileVerification->mobileexist($mobile);

            if (empty($mobileexist)) {
                $insertVerification = $this->MobileVerification->creater(array('mobile' => $mobile, 'ver_code' => $ver_code, 'user_type' => $user_type, 'created_at' => date('Y-m-d H:i:s')));
                if ($insertVerification) {
                    $output = array('status' => 'success', 'message' => array(array('ver_code' => $ver_code)));
                } else {
                    $output = array('status' => 'error', 'message' => "System Error");
                }
            } else {
                if ($mobileexist->verified == 0) {
                    $updateVerification = $this->MobileVerification->update(array('mobile' => $mobile, 'ver_code' => $ver_code, 'user_type' => $user_type), $mobile);
                    $output = array('status' => 'success', 'message' => array(array('ver_code' => $ver_code)));
                } else {
                    $output = array('status' => 'error', 'message' => "Already Verified");
                }
            }
        } else {
            $output = array('status' => 'error', 'message' => "Please Send Get Request");
        }

        header('content-type: application/json');
        echo json_encode($output);
    }

    public function verifyUser() {
        if ($this->input->post('mobile')) {
            $mobile = $_POST['mobile'];
            $ver_code = $_POST['ver_code'];
            $getUser = $this->MobileVerification->mobileexist($mobile);
            if (!empty($getUser)) {
                if ($getUser->verified == 0) {
                    if ($getUser->ver_code == $ver_code) {
                        $updateVerification = $this->MobileVerification->update(array('verified' => 1), $mobile);
                        $output = array('status' => 'success', 'message' => array('ver_code' => $ver_code));
                    } else {
                        $output = array('status' => 'error', 'message' => "Invalid Code");
                    }
                } else {
                    $output = array('status' => 'error', 'message' => "Already Verified");
                }
            } else {
                $output = array('status' => 'error', 'message' => "Details Not Found");
            }
        } else {
            $output = array('status' => 'error', 'message' => "Please Send POST Request");
        }

        header('content-type: application/json');
        echo json_encode($output);
    }

    public function register() {
        if ($this->input->post()) {
            $mobile = $this->input->post('mobile');
            $userexist = $this->User_model->userexist($mobile);
            if (empty($userexist)) {
                $data = array(
                    'full_name' => $this->input->post('full_name'),
                    'address' => $this->input->post('address'),
                    'city' => $this->input->post('city'),
                    'state' => $this->input->post('state'),
                    'mobile' => $this->input->post('mobile'),
                    'business_name' => $this->input->post('business_name'),
                    'pincode' => $this->input->post('pincode'),
                    'password' => $this->input->post('password'),
                    'email' => $this->input->post('email'),
                    'device_id' => $this->input->post('device_id'),
                    'user_type' => $this->input->post('user_type'),
                    'status' => 1,
                    'created_at' => date('Y-m-d H:i:s')
                );

                $user_id = $this->User_model->create($data);
                if ($user_id > 0) {
                    $output = array('status' => 'success', 'message' => "User Added Successfully");
                } else {
                    $output = array('status' => 'error', 'message' => "System Erroor");
                }
            } else {
                $output = array('status' => 'error', 'message' => "User Already Exist");
            }
        } else {
            $output = array('status' => 'error', 'message' => "Please Send POST Request");
        }
        header('content-type: application/json');
        echo json_encode($output);
    }

    public function login() {
        if ($this->input->get('mobile') != '' && $this->input->get('password') != '') {
            $mobile = $this->input->get('mobile');
            $password = $this->input->get('password');
            $userexist = $this->User_model->authenticate($mobile, $password);
            echo $userexist;

            if (!empty($userexist)) {
                $output = array('status' => 'success', 'message' => array($userexist));
            } else {
                $output = array('status' => 'error', 'message' => "Invalid Username/Password");
            }
        } else {
            $output = array('status' => 'error', 'message' => "Please Send Username And Password");
        }

        header('content-type: application/json');
        echo json_encode($output);
    }

    public function companyLogin() {
        $this->load->model('Company');
        $this->load->model('Superadmin');
        if ($this->input->post('mobile') != '' && $this->input->post('password') != '') {
            //var_dump($_POST);
            $mobile = $this->input->post('mobile');
            $password = $this->input->post('password');
            $userexist = $this->Company->authenticate($mobile, $password);
            //var_dump($userexist);
            if (!empty($userexist)) {
                $output = array('status' => 'success', 'message' => $userexist);
            } else {
                $userexist = $this->Superadmin->authenticate($mobile, $password);
                //var_dump($userexist);
                if (!empty($userexist)) {
                    $output = array('status' => 'success', 'message' => $userexist);
                } else {
                    $output = array('status' => 'error', 'message' => "Invalid Username/Password");
                }
            }
        } else {
            $output = array('status' => 'error', 'message' => "Please Send Mobile No And Password");
        }

        header('content-type: application/json');
        echo json_encode($output);
    }

    public function getBrandList($page = 1) {
        $this->load->model('Brand');
        $per_page = 500;


        $condition = array();
        $condition[] = "status = 1";

        if ($this->input->get('company_id') > 0) {
            $company_id = $this->input->get('company_id');
            $condition[] = "company = '" . $company_id . "'";
        }

        if ($this->input->get('brand_name') != '') {
            $company_id = $this->input->get('brand_name');
            $condition[] = "name like '" . $company_id . "%'";
        }
        if ((int) $this->input->get('brand_id') > 0) {
            $brand_id = $this->input->get('brand_id');
            $condition[] = "id='" . $brand_id . "'";
        }

        ///Paging
        $totalcount = $this->Brand->countBrands($condition);

        $totalpages = ceil($totalcount->totalcount / $per_page);
        $offset = ($page - 1) * $per_page;

        $brandlist = $this->Brand->getBrands($condition, $per_page, $offset);

        if (!empty($brandlist)) {
            $output = array('status' => 'success', 'message' => $brandlist, 'totalpages' => $totalpages, 'page' => $page);
        } else {
            $output = array('status' => 'error', 'message' => 'Data Not Found');
        }
        header('content-type: application/json');
        echo json_encode($output);
    }

    public function getBonusBrandList($page = 1) {

        $per_page = 500;


        $condition = array();
        $condition[] = "status = 1";

        if ($this->input->get('company_id') > 0) {
            $company_id = $this->input->get('company_id');
            $condition[] = "company = '" . $company_id . "'";
        }

        if ($this->input->get('brand_name') != '') {
            $company_id = $this->input->get('brand_name');
            $condition[] = "name like '" . $company_id . "%'";
        }

        ///Paging
        $totalcount = $this->Brand->countBrands($condition);

        $totalpages = ceil($totalcount->totalcount / $per_page);
        $offset = ($page - 1) * $per_page;

        $brandlist = $this->Brand->getBrands($condition, $per_page, $offset);

        if (!empty($brandlist)) {
            $content = array();
            foreach ($brandlist as $value) {
                $output[] = array(
                    'label' => $value->name,
                    'category' => '',
                    'id' => $value->id
                );
            }
            header('content-type: application/json');
            echo json_encode($output);
        }
    }

    public function getComposition() {
        $condition = array();
        if ($this->input->get('composition') != '') {
            $composition = $this->input->get('composition');
            $condition[] = "name LIKE '" . $composition . "%'";
        }

        $brandlist = $this->Brand->getComposition($condition);
        if (!empty($brandlist)) {
            $content = array();
            foreach ($brandlist as $value) {
                $output[] = array(
                    'label' => $value->name,
                    'category' => '',
                    'id' => $value->id,
                    'is_combination' => $value->is_combination,
                );
            }
            header('content-type: application/json');
            echo json_encode($output);
        }
    }

    function renderOutput($output) {
        if (!is_array($output)) {
            $output = array('status' => 'error', 'message' => 'Oops Something Went Wrong');
        }
        header('content-type: application/json');
        echo json_encode($output);
    }

    public function getcompanyList($page = 1) {
        $this->load->model('Company');
        $per_page = 20;


        $condition = array();
        $condition[] = "status = 1";


        ///Paging
        $totalcount = $this->Company->countCompany($condition);

        $totalpages = ceil($totalcount->totalcount / $per_page);
        $offset = ($page - 1) * $per_page;

        $Companylist = $this->Company->getcompany($condition, $per_page, $offset);

        if (!empty($Companylist)) {
            $output = array('status' => 'success', 'message' => $Companylist, 'totalpages' => $totalpages, 'page' => $page);
        } else {
            $output = array('status' => 'error', 'message' => 'Data Not Found');
        }
        header('content-type: application/json');
        echo json_encode($output);
    }

    function getBonusOffer($page = 1, $perpage = 20) {
        $this->load->model('Bonus');
        $condition = array();

        $type = $this->input->get('type');

        if ($type == 'starting') {
            $condition[] = 'starting_days <= 30 AND starting_days >= 0';
        } elseif ($type == 'closing') {
            $condition[] = 'ending_days < 30';
        } elseif ($type == 'continuous') {
            $condition[] = 'starting_days > 0 AND  ending_days > 30';
        }

        if ($this->input->get('brand_name') != '') {
            $brand_name = $this->input->get('brand_name');
            $condition[] = "brand_name LIKE '" . $brand_name . "%'";
        }
        if ($this->input->get('company_id') > 0) {
            $brand_name = $this->input->get('company_id');
            $condition[] = "company_id = {$brand_name} ";
        }

        $totalCount = $this->Bonus->countBonus($condition);
        $totalCount = $totalCount->bonusCount;
        $paging = $this->calculatePaging($perpage, $totalCount, $page);

        $bonus_info = $this->Bonus->getBonus($condition, $perpage, $paging[1]);

        if (!empty($bonus_info)) {
            $data = array();
            foreach ($bonus_info as $item) {
                if ($type == 'starting') {
                    $available = 'yes';
                    $date = $item->start_date;
                    $bonus_ratio = $item->bonus_ratio;
                } elseif ($type == 'closing') {
                    $available = 'yes';
                    $date = $item->end_date;
                    $bonus_ratio = $item->bonus_ratio;
                } elseif ($type == 'continuous') {
                    $available = 'yes';
                    $date = 'Till Stock Last';
                    $bonus_ratio = $item->bonus_ratio;
                } else {
                    if ($item->starting_days <= 30 && $item->starting_days > 0) {
                        $available = 'yes';
                        $date = $item->start_date;
                        $bonus_ratio = $item->bonus_ratio;
                    } elseif ($item->ending_days < 30) {
                        $available = 'yes';
                        $date = $item->end_date;
                        $bonus_ratio = $item->bonus_ratio;
                    } elseif ($item->starting_days > 0 && $item->ending_days > 30) {
                        $available = 'yes';
                        $date = 'Till Stock Last';
                        $bonus_ratio = $item->bonus_ratio;
                    } else {
                        $available = 'no';
                        $date = null;
                        $bonus_ratio = null;
                    }
                    $type = null;
                }

                $data[] = array(
                    'product_id' => $item->brand_id,
                    'product_name' => $item->name,
                    'company' => $item->company_name,
                    'bonus_available' => $available,
                    'bonus_type' => $type,
                    'bonus_ratio' => $bonus_ratio,
                    'date' => $date,
                    'start_date' => $item->start_date,
                    'end_date' => $item->end_date,
                );
            }

            $content = array('status' => 'success', 'message' => $data, 'totalpages' => $paging[0], 'page' => $page);
        } else {
            $content = array('status' => 'error', 'message' => 'Data Not Found');
        }
        $this->renderOutput($content);
    }

    public function calculatePaging($per_page = 1, $total = 0, $page = 1) {
        $totalpages = ceil($total / $per_page);
        $offset = ($page - 1) * $per_page;
        return array($totalpages, $offset);
    }

}
