<?php

class User extends MY_Controller {

    const API_URL = '';

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        if ($this->input->post('mobile') != '' && $this->input->post('password') != '') {
            $mobile = $this->input->post('mobile');
            $password = $this->input->post('password');
            $context = $this->returnContext(array('mobile' => $mobile, 'password' => $password));
            $response = file_get_contents(API_URL . 'login', FALSE, $context);
            var_dump($response);
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
