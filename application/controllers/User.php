<?php

class User extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Master_Model');
        $this->load->model('Company');
        $this->load->model('Brand');
        $this->load->model('Division');
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
                    $this->session->set_userdata('full_name', $response['message']['name']);
                    $this->session->set_userdata('company_id', $response['message']['admin_id']);
                    $this->session->set_userdata('type', 1);
                } elseif (isset($response['message']['company_id']) && $response['message']['company_id'] > 0) {
                    $this->session->set_userdata('full_name', $response['message']['company_name']);
                    $this->session->set_userdata('company_id', $response['message']['company_id']);
                    $this->session->set_userdata('type', 2);
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

        if ($this->type == 2) {
            $response = $this->CallAPI('GET', API_URL . 'getBrandList/' . $page . '?company_id=' . $this->company_id);
        } else {
            $response = $this->CallAPI('GET', API_URL . 'getBrandList/' . $page);
        }

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

    public function addBrand() {
        $this->load->model('Brand');
        $this->load->model('Company');

        $companyList = $this->Company->get(array('status = 1'));
        $data['company'] = $this->Master_Model->generateDropdown($companyList, 'company_id', 'company_name');
        $data['form'] = $this->Master_Model->generateDropdown($this->Brand->getForm(), 'form', 'form');

        if ($this->input->post()) {
            $name = $this->input->post('name');
            $form = $this->input->post('form');
            $mrp = $this->input->post('mrp');
            $pack = $this->input->post('packing');
            $comp = $this->input->post('company');
            $strength = $this->input->post('strength');

            for ($i = 0; $i < count($name); $i++) {
                if ($name[$i] != "") {

                    $data = array(
                        'name' => $name[$i],
                        'form' => $form[$i],
                        'status' => '1',
                        'mrp' => $mrp[$i],
                        'packing' => $pack[$i],
                        'company' => $comp[$i],
                        'strength' => $strength[$i],
                    );

                    $this->Brand->insert($data);
                }
            }

            redirect('User/brandList', 'refresh');
        }


        $data = array('title' => 'Add Brand', 'content' => 'User/addBrand', 'page_title' => 'Add Brand', 'view_data' => $data);
        $this->load->view('template3', $data);
    }

    public function Division() {
        $this->load->model('Division');
        if ($this->type == 2) {

            $id = $this->company_id;
            $data['response'] = $this->Division->getDivision(array('d.company_id=' . $id . '', 'd.status = 1 ', 'cm.status = 1'));
        } else {
            $data['response'] = $this->Division->getDivision(array('d.status = 1 ', 'cm.status = 1'));
        }
        $data = array('title' => 'Login', 'content' => 'Division/list', 'page_title' => 'Division List', 'view_data' => $data);
        $this->load->view('template3', $data);
    }

    public function CompanyList() {
        $this->load->model('Company');
        $data['response'] = $this->Company->get(array('status = 1'));
        $data = array('title' => 'Company', 'content' => 'Company/list', 'page_title' => 'Company List', 'view_data' => $data);
        $this->load->view('template3', $data);
    }

    public function addDivision() {

        $this->load->model('Division');
        $this->load->model('Company');
        $companyList = $this->Company->get(array('status = 1'));

        $data['company'] = $this->Master_Model->generateDropdown($companyList, 'company_id', 'company_name');
        if ($this->input->post()) {
            $data = array(
                'name' => $this->input->post('name'),
                'company_id' => $this->input->post('company_id'),
                'contact_person' => $this->input->post('contact_person'),
                'status' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'email' => $this->input->post('email'),
                'password' => $this->input->post('password'),
                'mobile' => $this->input->post('mobile'),
            );

            $this->Division->insert($data);
        }
        $data = array('title' => 'Login', 'content' => 'Division/add', 'page_title' => 'Add Division', 'view_data' => $data);
        $this->load->view('template3', $data);
    }

    public function update_brand() {
        $this->load->model('Brand');
        $this->load->model('Company');
        $id = $_GET['id'];
        $data['rows'] = $this->Brand->find_by_brand($id);
        $companyList = $this->Company->get(array('status = 1'));

        $data['company'] = $this->Master_Model->generateDropdown($companyList, 'company_id', 'company_name', $data['rows']['company']);
        if ($this->input->post()) {
            $data = array(
                'name' => $this->input->post('name'),
                'form' => $this->input->post('form'),
                'mrp' => $this->input->post('mrp'),
                'company' => $this->input->post('company_id'),
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
        $companyList = $this->Company->get(array('status = 1'));

        $data['company'] = $this->Master_Model->generateDropdown($companyList, 'company_id', 'company_name', $data['rows']['company_id']);
        if ($this->input->post()) {
            $data = array(
                'name' => $this->input->post('name'),
                'contact_person' => $this->input->post('contact_person'),
                'email' => $this->input->post('email'),
                'company_id' => $this->input->post('company_id'),
                'mobile' => $this->input->post('mobile'),
                'status' => 1,
            );
            $this->Division->division_updation($this->input->post('id'), $data);
            redirect('User/Division', 'refresh');
        }
        $data = array('title' => 'Update', 'content' => 'Division/edit_division', 'page_title' => 'Update Division', 'view_data' => $data);
        $this->load->view('template3', $data);
    }

    public function delete_division() {
        $this->load->model('Division');
        $id = $_GET['id'];
        $data = array('status' => 0);
        $this->Division->division_updation($id, $data);
        redirect('User/Division', 'refresh');
    }

    public function addCompany() {
        $this->load->model('Company');

        if ($this->input->post()) {
            $data = array(
                'company_name' => $this->input->post('company_name'),
                'address' => $this->input->post('address'),
                'city' => $this->input->post('city'),
                'pin_code' => $this->input->post('pin_code'),
                'contact_person_name' => $this->input->post('contact_person_name'),
                'mobile' => $this->input->post('mobile'),
                'status' => 1,
                'email' => $this->input->post('email'),
                'password' => $this->input->post('password'),
            );

            $this->Company->insert($data);
        }

        $data = array('title' => 'Add Company', 'content' => 'Company/add', 'page_title' => 'Add Company', 'view_data' => 'blank');
        $this->load->view('template3', $data);
    }

    public function editCompany($company_id) {
        $companyList = $this->Company->get(array('company_id = ' . $company_id));
        $companyList = array_shift($companyList);
        if ($this->input->post()) {
            $data = array(
                'company_name' => $this->input->post('company_name'),
                'address' => $this->input->post('address'),
                'city' => $this->input->post('city'),
                'pin_code' => $this->input->post('pin_code'),
                'contact_person_name' => $this->input->post('contact_person_name'),
                'mobile' => $this->input->post('mobile'),
                'status' => 1,
                'email' => $this->input->post('email'),
                'password' => $this->input->post('password'),
            );
            $this->Company->update($data, $company_id);
            redirect('User/CompanyList');
        }
        $data['rows'] = $companyList;
        $data = array('title' => 'Login', 'content' => 'Company/edit', 'page_title' => 'Edit Company', 'view_data' => $data);

        $this->load->view('template3', $data);
    }

    public function delete_company() {
        $this->load->model('Company');
        $id = $_GET['id'];
        $data = array('status' => 0);
        $this->Company->update($data, $id);
        redirect('User/CompanyList', 'refresh');
    }

    public function bonus($page = 1) {
        if ($this->type == 2) {
            $response = $this->CallAPI('GET', API_URL . 'getBonusOffer/' . $page . '/500?company_id=' . $this->company_id);
        } else {
            $response = $this->CallAPI('GET', API_URL . 'getBonusOffer/' . $page . '/500');
        }

        $response = json_decode($response, true);
        $data['page'] = $page;
        if ($response['status'] == 'success') {
            $data['total_pages'] = $response['totalpages'];
            $data['response'] = $response['message'];
        } else {
            $data['message'] = $response['message'];
        }

        $data = array('title' => 'Bonus Offer', 'content' => 'Bonus/list', 'page_title' => 'Bonus Offer', 'view_data' => $data);
        $this->load->view('template3', $data);
    }

    public function addBonus() {
        $this->load->model('Bonus');
        $companyList = $this->Company->get(array('status = 1'));
        if ($this->type == 1) {
            $data['disable'] = '';
            $data['company'] = $this->Master_Model->generateDropdown($companyList, 'company_id', 'company_name');
        } else {
            $data['disable'] = 'disable="disable"';
            $data['company'] = $this->Master_Model->generateDropdown($companyList, 'company_id', 'company_name', $this->company_id);
        }

        $data['state'] = $this->Master_Model->generateDropdown($this->Bonus->getState(), 'id', 'state');

        if ($this->input->post()) {
            //var_dump($_POST);

            $company_id = $this->input->post('company_id');
            $brand_name = $this->input->post('brand_name');
            $brand_id = $this->input->post('brand_id');
            $bonus_ratio = $this->input->post('bonus_ratio');
            $title = $this->input->post('title');
            $start_date = $this->input->post('start_date');
            $end_date = $this->input->post('end_date');

            for ($i = 0; $i < count($brand_name); $i++) {
                $state = $this->input->post('state' . $i);
                if (!empty($state)) {
                    $finalState = join(",", $state);

                    if ($brand_id[$i] > 0 && $brand_name[$i] != '') {
                        $field_array = array(
                            'company_id' => $company_id,
                            'brand_id' => $brand_id[$i],
                            'brand_name' => $brand_name[$i],
                            'bonus_ratio' => $bonus_ratio[$i],
                            'start_date' => $start_date[$i],
                            'end_date' => $end_date[$i],
                            'states' => $finalState,
                            'status' => 1
                        );
                        //var_dump($field_array);
                        $bonus_id = $this->Bonus->insert($field_array);

                        foreach ($state as $item) {
                            $this->db->insert('bonus_state', array('state_id' => $item, 'bonus_id' => $bonus_id, 'created_at' => date('Y-m-d H:i:s')));
                        }
                    }
                }
            }

            redirect('User/addBonus', 'refresh');
        }

        $data = array('title' => 'Login', 'content' => 'Bonus/add', 'page_title' => 'Add Bonus', 'view_data' => $data);
        $this->load->view('template3', $data);
    }

    public function calculateBonusDays() {
        $date = date('Y-m-d');
        $sql = "UPDATE 
                `bonus_info` b1 
                INNER JOIN `bonus_info` b2 
                  ON b1.`id` = b2.`id` SET b1.`starting_days` = DATEDIFF(b2.`start_date`,'$date'),
                b1.`ending_days` = DATEDIFF( b2.`end_date`,'$date') ";
        $this->db->query($sql);
    }

    public function closedBonus() {
        $sql = "UPDATE bonus_info SET status = 0 WHERE ending_days <= 0";
        $this->db->query($sql);
    }

}
