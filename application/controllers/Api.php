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

            $mobileexist = $this->MobileVerification->mobileexist($mobile);

            if (empty($mobileexist)) {
                $this->Sms->sendsms($mobile, $message);
                $insertVerification = $this->MobileVerification->creater(array('mobile' => $mobile, 'ver_code' => $ver_code, 'user_type' => $user_type, 'created_at' => date('Y-m-d H:i:s')));
                if ($insertVerification) {
                    $output = array('status' => 'success', 'message' => array(array('ver_code' => $ver_code)));
                } else {
                    $output = array('status' => 'error', 'message' => "System Error");
                }
            } else {
                if ($mobileexist->verified == 0) {
                    $this->Sms->sendsms($mobile, $message);
                    $updateVerification = $this->MobileVerification->update(
                            array(
                        'mobile' => $mobile,
                        'ver_code' => $ver_code,
                        'user_type' => $user_type
                            ), $mobile);
                    $output = array('status' => 'success', 'message' => array(array('ver_code' => $ver_code)));
                } elseif ($mobileexist->verified == 1) {
                    $userexist = $this->User_model->userexist($mobile);

                    if (empty($userexist)) {
                        $this->Sms->sendsms($mobile, $message);
                        $updateVerification = $this->MobileVerification->update(array('mobile' => $mobile, 'ver_code' => $ver_code), $mobile);
                        $output = array('status' => 'success', 'message' => array(array('ver_code' => $ver_code)));
                    } else {
                        $output = array('status' => 'error', 'message' => "Already Registered And Verified");
                    }
                }
            }
        } else {
            $output = array('status' => 'error', 'message' => "Please Send Get Request");
        }

        header('content-type: application/json');
        echo json_encode($output);
    }

    public function verifyUser() {
        if ($_GET['mobile'] != '' && $_GET['ver_code'] != '') {
            $mobile = $_GET['mobile'];
            $ver_code = $_GET['ver_code'];
            $getUser = $this->MobileVerification->mobileexist($mobile);
            if (!empty($getUser)) {
                if ($getUser->verified == 0) {
                    if ($getUser->ver_code == $ver_code) {
                        $updateVerification = $this->MobileVerification->update(array('verified' => 1), $mobile);
                        $output = array('status' => 'success', 'message' => array('ver_code' => $ver_code));
                    } else {
                        $output = array('status' => 'error', 'message' => "Invalid Code");
                    }
                } elseif ($getUser->verified == 1) {
                    $userexist = $this->User_model->userexist($mobile);
                    if (empty($userexist)) {
                        $output = array('status' => 'success', 'message' => array('ver_code' => $ver_code));
                    } else {
                        $output = array('status' => 'error', 'message' => "Already Registered And Verified");
                    }
                }
            } else {
                $output = array('status' => 'error', 'message' => "Details Not Found");
            }
        } else {
            $output = array('status' => 'error', 'message' => "Please Send GET Request");
        }

        header('content-type: application/json');
        echo json_encode($output);
    }

    public function register() {
        if (isset($_REQUEST['mobile'])) {
            $mobile = $_REQUEST['mobile'];
            $isverified = $this->MobileVerification->mobileexist($mobile);
            $userexist = $this->User_model->userexist($mobile);
            if (!empty($isverified) && $isverified->verified == 1) {
                if (empty($userexist)) {
                    $data = array(
                        'full_name' => $_REQUEST['full_name'],
                        'address' => $_REQUEST['address'],
                        'city' => $_REQUEST['city'],
                        'state' => $_REQUEST['state'],
                        'mobile' => $_REQUEST['mobile'],
                        'business_name' => $_REQUEST['business_name'],
                        'pincode' => $_REQUEST['pincode'],
                        'password' => $_REQUEST['password'],
                        'email' => $_REQUEST['email'],
                        'device_id' => $_REQUEST['device_id'],
                        'user_type' => $_REQUEST['user_type'],
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
                    $output = array('status' => 'error', 'message' => "Already Registered");
                }
            } else {
                $output = array('status' => 'error', 'message' => "User Not Verified");
            }
        } else {
            $output = array('status' => 'error', 'message' => "Please Send GET Request");
        }
        header('content-type: application/json');
        echo json_encode($output);
    }

    public function login() {
        if ($this->input->get('mobile') != '' && $this->input->get('password') != '') {
            $mobile = $this->input->get('mobile');
            $password = $this->input->get('password');
            $userexist = $this->User_model->authenticate($mobile, $password);
            $device_id = $this->input->get('device_id');
            if (!empty($userexist)) {
                $appVersion = $this->User_model->getAppVersion(); ///GET App Version
                $userexist->version = $appVersion->version;
                $userexist->version_date = $appVersion->date;
                if (trim($device_id) === '') {
                    $device_id = $userexist->device_id;
                }
                $this->User_model->insertLogin(array('user_id' => $userexist->user_id, 'created_at' => date('Y-m-d H:i:s')));
                $this->User_model->update(array('last_login' => date('Y-m-d H:i:s'), 'device_id' => $device_id), $userexist->user_id);
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

    public function getBrandList($page = 1, $per_page = 10) {
        $this->load->model('Brand');

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

    public function renderOutput($output) {
        if (!is_array($output)) {
            $output = array('status' => 'error', 'message' => 'Oops Something Went Wrong');
        }
        header('content-type: application/json');
        echo json_encode($output);
    }

    public function getcompanyList($page = 1, $per_page = 20) {
        $this->load->model('Company');

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

    public function getBonusOffer($page = 1, $perpage = 20) {
        $this->load->model('Bonus');
        $condition = array();
        $brandcondition = array();

        $type = isset($_GET['type']) ? $_GET['type'] : 0;

        if ($type === 'starting') {
            $condition[] = 'starting_days <= 30 AND starting_days > 0 AND (ending_days - starting_days) > 30 ';
            $order_by = " ORDER BY bf.starting_days ASC,cm.priority ASC  ";
        } elseif ($type === 'closing') {
            $condition[] = 'ending_days < 30 && ending_days > 0';
            $order_by = " ORDER BY bf.ending_days ASC,cm.priority ASC  ";
        } elseif ($type === 'continuous') {
            $condition[] = 'starting_days < 0 AND  ending_days > 30 AND ending_days > 0';
            $order_by = " ORDER BY cm.priority ASC  ";
        } elseif ($type === 'company') {
            $order_by = " ORDER BY bf.ending_days DESC,cm.priority ASC ";
        } elseif ($type === '') {
            $order_by = " ORDER BY bf.ending_days DESC,cm.priority ASC ";
        } else {
            $order_by = " ORDER BY bf.ending_days ASC ";
        }

        if ($this->input->get('brand_name') != '') {
            $brand_name = $this->input->get('brand_name');
            $brandcondition[] = "name LIKE '" . $brand_name . "%'";
        }
        if ($this->input->get('company_id') > 0) {
            $brand_name = $this->input->get('company_id');
            $brandcondition[] = "bd.company = {$brand_name} ";
        }

        if ($this->input->get('product_id') > 0) {
            $product_id = $this->input->get('product_id');
            $brandcondition[] = "id = {$product_id} ";
        }

        if ($this->input->get('composition') != '') {
            $composition = $this->input->get('composition');
            $brandcondition[] = "composition = '$composition' ";
            $order_by = " ORDER BY bf.ending_days ASC ";
        }

        if (trim($type) === '' || $type === 'company') {
            $totalCount = $this->Bonus->countBonus($condition, $brandcondition);
            $totalCount = $totalCount->bonusCount;
            $paging = $this->calculatePaging($perpage, $totalCount, $page);
            $bonus_info = $this->Bonus->getBonus($condition, $perpage, $paging[1], $order_by, $brandcondition);
        } else {
            $totalCount = $this->Bonus->countBonus2($condition, $brandcondition);
            $totalCount = $totalCount->bonusCount;
            $paging = $this->calculatePaging($perpage, $totalCount, $page);
            $bonus_info = $this->Bonus->getBonus2($condition, $perpage, $paging[1], $order_by, $brandcondition);
        }

        if (!empty($bonus_info)) {
            $data = array();
            foreach ($bonus_info as $item) {
                $diff = $item->ending_days - $item->starting_days;

                if ((int) $item->starting_days <= 30 && (int) $item->starting_days > 0 && $diff > 30) {
                    $available = 'yes';
                    $date = date('d/m/Y', strtotime($item->start_date));
                    $bonus_ratio = $item->bonus_ratio;
                    $bonus_type = 'Starting';
                } elseif ((int) $item->ending_days < 30 && (int) $item->ending_days > 0) {
                    $available = 'yes';
                    $date = date('d/m/Y', strtotime($item->end_date));
                    $bonus_ratio = $item->bonus_ratio;
                    $bonus_type = 'Closing';
                } elseif ((int) $item->starting_days < 0 && (int) $item->ending_days > 30 && (int) $item->ending_days > 0) {
                    $available = 'yes';
                    $date = 'Till Stock Last';
                    $bonus_ratio = $item->bonus_ratio;
                    $bonus_type = '';
                } else {

                    if ((int) $item->starting_days <= 30 && (int) $item->starting_days > 0) {
                        $available = 'yes';
                        $date = date('d/m/Y', strtotime($item->start_date));
                        $bonus_ratio = $item->bonus_ratio;
                        $bonus_type = 'Starting';
                    } elseif ((int) $item->ending_days < 30 && (int) $item->ending_days > 0) {
                        $available = 'yes';
                        $date = date('d/m/Y', strtotime($item->end_date));
                        $bonus_ratio = $item->bonus_ratio;
                        $bonus_type = 'Closing';
                    } elseif ((int) $item->starting_days < 0 && (int) $item->ending_days > 30 && (int) $item->ending_days > 0) {
                        $available = 'yes';
                        $date = 'Till Stock Last';
                        $bonus_ratio = $item->bonus_ratio;
                        $bonus_type = 'Continuous';
                    } else {
                        $available = 'no';
                        $date = '';
                        $bonus_ratio = 'No Info';
                        $bonus_type = 'No Info';
                    }
                }

                $data[] = array(
                    'product_id' => $item->brand_id,
                    'product_name' => $item->name,
                    'company' => $item->company_name,
                    'bonus_available' => $available,
                    'bonus_type' => $bonus_type,
                    'bonus_ratio' => $bonus_ratio,
                    'date' => $date,
                    'start_date' => $item->start_date,
                    'end_date' => $item->end_date,
                    'composition' => $item->composition,
                    'strength' => $item->strength,
                    'packing' => $item->packing,
                    'mrp' => $item->mrp,
                    'bonus_id' => $item->bonus_id,
                );
            }

            $content = array('status' => 'success', 'message' => $data, 'totalpages' => $paging[0], 'page' => $page);
        } else {
            $content = array('status' => 'error', 'message' => 'Data Not Found');
        }
        $this->renderOutput($content);
    }

    public function searchBrand($page = 1, $perpage = 20) {
        $this->load->model('Bonus');
        $condition = array();
        $brandcondition = array();

        $type = isset($_GET['type']) ? $_GET['type'] : 0;


        if ($this->input->get('brand_name') != '' && $this->input->get('brand_name') != 'all') {
            $brand_name = $this->input->get('brand_name');
            $brandcondition[] = "name LIKE '" . $brand_name . "%'";
        }

        if ($this->input->get('company_id') > 0) {
            $brand_name = $this->input->get('company_id');
            $brandcondition[] = "company = {$brand_name} ";
        }

        if ($this->input->get('product_id') > 0) {
            $product_id = $this->input->get('product_id');
            $condition[] = "id = {$product_id} ";
        }

        if ($this->input->get('composition') != '') {
            $composition = $this->input->get('composition');
            $brandcondition[] = "composition = '$composition' ";
        }

        if ($type == 'all') {
            unset($condition);
            $perpage = 565656565656;
        }

        $totalCount = $this->Brand->countBrands($brandcondition);
        $totalCount = $totalCount->totalcount;
        $paging = $this->calculatePaging($perpage, $totalCount, $page);
        $bonus_info = $this->Brand->getBrands2($brandcondition, $perpage, $paging[1]);
        if (!empty($bonus_info)) {
            $content = array('status' => 'success', 'message' => $bonus_info, 'totalpages' => $paging[0], 'page' => $page);
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

    public function getImages() {
        $this->load->model('Company');
        $imageList = $this->Company->getimage(array('status = 1', 'ending_days BETWEEN 0 AND 7'));
        if (!empty($imageList)) {
            $output = array('status' => 'success', 'message' => $imageList);
        } else {
            $output = array('status' => 'error', 'message' => 'Data Not Found');
        }

        $this->renderOutput($output);
    }

    public function forgotPassword() {
        if (isset($_REQUEST['mobile'])) {
            $mobile = $_REQUEST['mobile'];
            $user_id = ($_REQUEST['user_id']);
            $old_pass = ($_REQUEST['old_pass']);
            $userexist = $this->User_model->userexist($mobile);
            if (!empty($userexist)) {
                $vercode = rand(0, 9999);
                $message = 'This Is Your Password is' . $vercode;
                $this->Sms->sendsms($mobile, $message);
                $data = array(
                    'password' => $vercode
                );
                $data = $this->User_model->updateMobile($mobile, $data);
                $output = array('status' => 'success', 'message' => $vercode);
            } else {
                $output = array('status' => 'error', 'message' => 'User Not Exit ');
            }
        } else {
            $output = array('status' => 'error', 'message' => 'Please Enter Mobile  ');
        }

        header('content-type: application/json');
        echo json_encode($output);
    }

    public function getDivisionDropdown() {
        $this->load->model('Division');
        $this->load->model('Master_Model');
        $condition = array('d.status = 1');
        if ($this->input->get('company_id') > 0) {
            $company_id = $this->input->get('company_id');
            $condition[] = 'd.company_id = ' . $company_id;
        }

        $dropdown = $this->Division->getDivision($condition);
        $dropdown = $this->Master_Model->generateDropdown($dropdown, 'div_id', 'name');
        echo $dropdown;
    }

    public function getVersion() {
        $user_id = $_REQUEST['user_id'];
        $this->User_model->insertLogin(array('user_id' => $user_id, 'created_at' => date('Y-m-d H:i:s')));
        $this->User_model->update(array('last_login' => date('Y-m-d H:i:s')), $user_id);
        $appVersion = $this->User_model->getAppVersion(); ///GET App Version

        $output = array('status' => 'success', 'message' => array(array('version' => $appVersion->version)));
        $this->renderOutput($output);
    }

    public function getNotification($page = 1, $perpage = 20) {
        $this->load->model('Communication');

        $totalCount = $this->Communication->allCount();
        $totalCount = $totalCount->count;
        $paging = $this->calculatePaging($perpage, $totalCount, $page);
        $notification = $this->Communication->get(array("type = 'notification'"), $perpage, $paging[1], array('com_id', 'message'));
        
        $output = array('status' => 'success', 'message' => $notification, 'totalpages' => $paging[0], 'page' => $page);
        $this->renderOutput($output);
    }

}
