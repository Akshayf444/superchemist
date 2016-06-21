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
        if ($this->input->post('mobile') != '' && $this->input->post('password') != '') {
            $mobile = $this->input->post('mobile');
            $password = $this->input->post('password');
            $userexist = $this->User_model->authenticate($mobile, $password);

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
        if ($this->input->post('mobile') != '' && $this->input->post('password') != '') {
            $mobile = $this->input->post('mobile');
            $password = $this->input->post('password');
            $userexist = $this->Company->authenticate($mobile, $password);

            if (!empty($userexist)) {
                $output = array('status' => 'success', 'message' => $userexist);
            } else {
                $output = array('status' => 'error', 'message' => "Invalid Username/Password");
            }
        } else {
            $output = array('status' => 'error', 'message' => "Please Send Mobile No And Password");
        }

        header('content-type: application/json');
        echo json_encode($output);
    }

}
