<?php

class User extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Master_Model');
    }

    public function index() {
        $data = array();
        if ($this->input->post('mobile') != '' && $this->input->post('password') != '') {
            $mobile = $this->input->post('mobile');
            $password = $this->input->post('password');
            //$context = $this->returnContext();
            $response = $this->CallAPI('POST', API_URL . 'companyLogin', array('mobile' => $mobile, 'password' => $password));
            $response = json_decode($response, TRUE);
            //var_dump($response);
            if (isset($response['status']) && $response['status'] == 'error') {
                $data['message'] = $response['message'];
            } elseif (isset($response['status']) && $response['status'] == 'success') {

                if (isset($response['message']['admin_id']) && $response['message']['admin_id'] > 0) {
                    $this->full_name = $response['message']['name'];
                    $this->company_id = $response['message']['admin_id'];
                    $this->type = 1;
                } elseif (isset($response['message']['company_id']) && $response['message']['company_id'] > 0) {
                    $this->full_name = $response['message']['company_name'];
                    $this->company_id = $response['message']['company_id'];
                    $this->type = 2;
                }
                redirect('User/brandList', 'refresh');
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

    public function dashboard() {
        
    }

    public function brandList($page = 1) {
        $response = $this->CallAPI('GET', API_URL . 'getBrandList/' . $page);
        $response = json_decode($response, true);
        $data['page'] = $page;
        if ($response['status'] == 'success') {
            $data['total_pages'] = $response['totalpages'];
            $data['response'] = $response['message'];
        } else {
            $data['message'] = $response['message'];
        }

        $data = array('title' => 'Brand List', 'content' => 'User/view_brand', 'page_title' => 'Brand List', 'view_data' => $data);
        $this->load->view('template3', $data);
    }

    public function Division() {
        $this->load->model('Division');
        $data['response'] = $this->Division->getDivision(array('d.status = 1 ', 'cm.status = 1'));
        $data = array('title' => 'Login', 'content' => 'Division/list', 'page_title' => 'Division List', 'view_data' => $data);
        $this->load->view('template3', $data);
    }

    public function addDivision() {

        $this->load->model('Division');
        $this->load->model('Company');
        $companyList = $this->Company->get();

        $data['company'] = $this->Master_Model->generateDropdown($companyList, 'company_id', 'company_name');
        if ($this->input->post()) {
            $data = array(
                'name' => $this->input->post('name'),
                'company_id' => $this->input->post('company_id'),
                'status' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'email' => $this->input->post('email'),
                'password' => $this->input->post('password'),
            );

            $this->Division->insert($data);
        }
        $data = array('title' => 'Login', 'content' => 'Division/add', 'page_title' => 'Add Division', 'view_data' => $data);
        $this->load->view('template3', $data);
    }

    public function update_brand() {
         $this->load->model('Brand');
        $id = $_GET['id'];
        $data['rows'] = $this->Brand->find_by_brand($id);
        if ($this->input->post()) {
            $data = array(
                'name' => $this->input->post('name'),
                'form' => $this->input->post('form'),
                'mrp' => $this->input->post('mrp'),
                'packing' => $this->input->post('packing'),
                'strength' => $this->input->post('strength'),
                'is_active' => 1,
            );
            $this->Brand->brand_updation($this->input->post('id'), $data);
            redirect('User/brandList', 'refresh');
        }
          $data = array('title' => 'Update', 'content' => 'User/edit_doc', 'page_title' => 'Update Brand', 'view_data' => $data);
        $this->load->view('template3', $data);
    }

    public function delete_brand() {
        $this->load->model('Brand');
        $id = $_GET['id'];
        $data = array('status' => 0);
        $this->Brand->brand_updation($id, $data);
        redirect('User/brandList', 'refresh');
    }
 public function update_division() {
        $this->load->model('Division');
         $this->load->model('Company');
        $id = $_GET['id'];
        $data['rows'] = $this->Division->find_by_division($id);
        if ($this->input->post()) {
            $data = array(
                'name' => $this->input->post('name'),
                'form' => $this->input->post('form'),
                'mrp' => $this->input->post('mrp'),
                'packing' => $this->input->post('packing'),
                'strength' => $this->input->post('strength'),
                'is_active' => 1,
            );
            $this->Division->division_updation($this->input->post('id'), $data);
            redirect('User/brandList', 'refresh');
        }
          $data = array('title' => 'Update', 'content' => 'Division/edit_division', 'page_title' => 'Update Brand', 'view_data' => $data);
        $this->load->view('template3', $data);
    }

    public function delete_division() {
        $this->load->model('Division');
        $id = $_GET['id'];
        $data = array('status' => 0);
        $this->Division->division_updation($id, $data);
        redirect('User/brandList', 'refresh');
    }
    
    public function addDivision() {

        $this->load->model('Division');
        $this->load->model('Company');
        $companyList = $this->Company->get();

        $data['company'] = $this->Master_Model->generateDropdown($companyList, 'company_id', 'company_name');
        if ($this->input->post()) {
            $data = array(
                'name' => $this->input->post('name'),
                'company_id' => $this->input->post('company_id'),
                'status' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'email' => $this->input->post('email'),
                'password' => $this->input->post('password'),
            );

            $this->Division->insert($data);
        }
        $data = array('title' => 'Login', 'content' => 'Division/add', 'page_title' => 'Add Division', 'view_data' => $data);
        $this->load->view('template3', $data);
    }
}
