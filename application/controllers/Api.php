<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Api extends MY_Controller {

    public $alertLabel = 'Doctor';
    public $doctorIds = array();

    public function __construct() {
        parent::__construct();
        $this->load->helper();
        $this->load->model('User_model');
        $this->load->model('Sms');
        $this->load->model('MobileVerification');
    }

    public function index() {
        $data = array();
        $message = '';
        if ($this->input->post()) {
            if ($this->input->post('username') == $this->input->post('password')) {
                $username = $this->input->post('username');
                $password = $this->input->post('password');
                $tmexist = $this->User_model->tmauthentication($username, $password);
                if (!empty($tmexist)) {
                    $this->session->set_userdata('Emp_Id', $tmexist['TM_Emp_Id']);
                    $this->session->set_userdata('smswayid', $tmexist['smsWayID']);
                    $this->session->set_userdata('Full_Name', $tmexist['TM_Name']);
                    $this->session->set_userdata('TM_Emp_Id', $tmexist['TM_Emp_Id']);
                    $this->session->set_userdata('BM_Emp_Id', $tmexist['BM_Emp_Id']);
                    $this->session->set_userdata('SM_Emp_Id', $tmexist['SM_Emp_Id']);
                    $this->session->set_userdata('SSM_Emp_Id', $tmexist['SSM_Emp_Id']);
                    $this->session->set_userdata('Reporting_Id', $tmexist['BM_Emp_Id']);
                    $this->session->set_userdata('Designation', 'TM');
                    redirect('User/dashboard', 'refresh');
                } else {
                    $bmexist = $this->User_model->bmauthentication($username, $password);
                    if (!empty($bmexist)) {
                        $this->session->set_userdata('Emp_Id', $bmexist['BM_Emp_Id']);
                        $this->session->set_userdata('TM_Emp_Id', $bmexist['TM_Emp_Id']);
                        $this->session->set_userdata('BM_Emp_Id', $bmexist['BM_Emp_Id']);
                        $this->session->set_userdata('SM_Emp_Id', $bmexist['SM_Emp_Id']);
                        $this->session->set_userdata('SSM_Emp_Id', $bmexist['SSM_Emp_Id']);
                        $this->session->set_userdata('Reporting_Id', $bmexist['SM_Emp_Id']);
                        $this->session->set_userdata('Full_Name', $bmexist['BM_Name']);
                        $this->session->set_userdata('smswayid', $bmexist['smsWayID']);
                        $this->session->set_userdata('Designation', 'BM');
                        redirect('User/dashboard', 'refresh');
                    } else {
                        $smexist = $this->User_model->smauthentication($username, $password);
                        if (!empty($smexist)) {
                            $this->session->set_userdata('Emp_Id', $smexist['SM_Emp_Id']);
                            $this->session->set_userdata('TM_Emp_Id', $smexist['TM_Emp_Id']);
                            $this->session->set_userdata('BM_Emp_Id', $smexist['BM_Emp_Id']);
                            $this->session->set_userdata('SM_Emp_Id', $smexist['SM_Emp_Id']);
                            $this->session->set_userdata('SSM_Emp_Id', $smexist['SSM_Emp_Id']);
                            $this->session->set_userdata('Reporting_Id', $smexist['SSM_Emp_Id']);
                            $this->session->set_userdata('Full_Name', $smexist['SM_Name']);
                            $this->session->set_userdata('smswayid', $smexist['smsWayID']);
                            $this->session->set_userdata('Designation', 'SM');
                            redirect('User/dashboard', 'refresh');
                        } else {
                            $adminexist = $this->User_model->adminauthentication($username, $password);
                            if (!empty($adminexist)) {
                                $this->session->set_userdata('admin_id', $adminexist['admin_id']);
                                $this->session->set_userdata('Full_Name', $adminexist['name']);

                                $this->session->set_userdata('Designation', 'admin');
                                redirect('User/dashboard', 'refresh');
                            } else {
                                $this->session->set_userdata('message', $this->Master_Model->DisplayAlert('Incorrect Username/Password', 'danger'));
                            }
                        }
                    }
                }
            } else {
                $this->session->set_userdata('message', $this->Master_Model->DisplayAlert('Incorrect Username/Password', 'danger'));
            }
        }
        $data = array('title' => 'Login', 'content' => 'User/login', 'view_data' => $data);
        $this->load->view('template1', $data);
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
                    $output = array('status' => 'success', 'message' => array('ver_code' => $ver_code));
                } else {
                    $output = array('status' => 'error', 'message' => "System Error");
                }
            } else {
                if ($mobileexist->verified == 0) {
                    $updateVerification = $this->MobileVerification->update(array('mobile' => $mobile, 'ver_code' => $ver_code, 'user_type' => $user_type), $mobile);
                    $output = array('status' => 'success', 'message' => array('ver_code' => $ver_code));
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
                );

                $user_id = $this->User_model->create($data);
                if ($user_id > 0) {
                    $output = array('status' => 'success', 'message' => "User Added Successfully");
                } else {
                    $output = array('status' => 'error', 'message' => "System Erroor");
                }
            } else {
                $output = array('status' => 'error', 'message' => "User With Same Mobile No Already Exist");
            }
        } else {
            $output = array('status' => 'error', 'message' => "Please Send POST Request");
        }
        header('content-type: application/json');
        echo json_encode($output);
    }

    public function login() {
        if ($this->input->post('mobile') != '' && $this->input->post('password') != '') {
            $mobile = $this->input->post('mobile');
            $password = $this->input->post('password');
            $userexist = $this->User_model->authenticate($mobile, $password);

            if (!empty($userexist)) {
                $output = array('status' => 'error', 'message' => json_encode($userexist));
            } else {
                $output = array('status' => 'error', 'message' => "Invalid Username/Password");
            }
        } else {
            $output = array('status' => 'error', 'message' => "Please Send Username And Password");
        }
        header('content-type: application/json');
        echo json_encode($output);
    }

}
