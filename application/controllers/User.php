<?php

class User extends MY_Controller {

    const API_URL = '';

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $data = array();
        if ($this->input->post('mobile') != '' && $this->input->post('password') != '') {
            $mobile = $this->input->post('mobile');
            $password = $this->input->post('password');
            //$context = $this->returnContext();
            $response = $this->CallAPI('POST', API_URL . 'companyLogin', array('mobile' => $mobile, 'password' => $password));
            //var_dump($response);
            $response = json_decode($response);
            if (isset($response->status) && $response->status == 'error') {
                $data['message'] = $response->message;
            } elseif (isset($response->status) && $response->status  == 'success') {
                $data['message'] = $response->message;
            }
        }

        $data = array('title' => 'Login', 'content' => 'User/login', 'view_data' => $data);
        $this->load->view('template1', $data);
    }

    public function returnContext($postdata) {
        $data = http_build_query(
                $postdata
        );

        $opts = array('http' =>
            array(
                'method' => 'POST',
                'header' => 'Content-type: application/x-www-form-urlencoded',
                'content' => $data
            )
        );
        return stream_context_create($opts);
    }

}
