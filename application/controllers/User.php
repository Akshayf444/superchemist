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
                redirect('User/dashboard', 'refresh');
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
        $this->load->model('Bonus');
        $this->load->model('Division');
        $condition = array('status =  1');
        $bonusCondition = array('status = 1');
        $divisionCondition = array('d.status = 1');
        if ($this->type == 2) {
            $condition[] = "company = '" . $this->company_id . "'";
            $bonusCondition[] = "company_id = '" . $this->company_id . "'";
            $divisionCondition[] = "d.company_id = '" . $this->company_id . "'";
        } elseif ($this->type == 1) {
            
        } else {
            $this->logout();
        }


        $brandCount = $this->Brand->countBrands($condition);
        $bonusCount = $this->Bonus->countBonus2($bonusCondition);
        $countDivision = $this->Division->countDivision($divisionCondition);
        $countCompany = $this->Company->countCompany($bonusCondition);

        $data['brandcount'] = $brandCount->totalcount;
        $data['bonuscount'] = $bonusCount->bonusCount;
        $data['divisioncount'] = $countDivision->divisionCount;
        $data['ctr'] = 0;
        $data['countCompany'] = $countCompany->totalcount;

        $data = array('title' => 'Dashboard', 'content' => 'User/dashboard', 'page_title' => 'Dashboard', 'view_data' => $data);
        $this->load->view('template3', $data);
    }

    public function brandList($page = 1) {

        if ($this->type == 2) {
            $response = $this->CallAPI('GET', API_URL . 'getBrandList/' . $page . '/500?company_id=' . $this->company_id);
        } elseif ($this->type == 1) {
            $response = $this->CallAPI('GET', API_URL . 'getBrandList/' . $page . '/500');
        } else {
            $this->logout();
        }

        $response = json_decode($response, true);
        $data['page'] = $page;
        if (isset($response['status']) && $response['status'] == 'success') {
            $data['total_pages'] = $response['totalpages'];
            $data['response'] = $response['message'];
        } else {
            $data['message'] = isset($response['status']) ? $response['message'] : '';
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
        $data['division'] = $this->Master_Model->generateDropdown($this->Division->returnDivision(), 'div_id', 'name');

        if ($this->input->post()) {
            $name = $this->input->post('name');
            $form = $this->input->post('form');
            $mrp = $this->input->post('mrp');
            $pack = $this->input->post('packing');
            $comp = $this->input->post('company');
            $strength = $this->input->post('strength');
            $generic_id = $this->input->post('generic_id');
            $composition = $this->input->post('composition');
            $is_combination = $this->input->post('is_combination');
            $division = $this->input->post('division');
            $unit = $this->input->post('unit');

            for ($i = 0; $i < count($name); $i++) {
                if ($name[$i] != "" && $generic_id[$i] > 0) {
                    $data = array(
                        'name' => $name[$i],
                        'form' => $form[$i],
                        'status' => '1',
                        'mrp' => $mrp[$i],
                        'packing' => $pack[$i],
                        'company' => $comp,
                        'strength' => $strength[$i] . " " . $unit[$i],
                        'generic_id' => $generic_id[$i],
                        'composition' => $composition[$i],
                        'is_combination' => $is_combination[$i],
                        'division' => $division,
                        'unit' => $unit[$i],
                    );

                    $this->Brand->insert($data);
                } else {
                    $this->session->set_userdata('message', $this->Master_Model->DisplayAlert('Please Select Composition From DropDownlist For ' . $name[$i], 'error'));
                }
            }

            redirect('User/brandList', 'refresh');
        }

        $data = array('title' => 'Add Brand', 'content' => 'User/addBrand', 'page_title' => 'Add Brand', 'view_data' => $data);
        $this->load->view('template3', $data);
    }

    public function Division() {
        $this->load->model('Division');
        $data['response'] = $this->Division->returnDivision();

        $data = array('title' => 'Login', 'content' => 'Division/list', 'page_title' => 'Division List', 'view_data' => $data);
        $this->load->view('template3', $data);
    }

    public function CompanyList($page = 1) {
        if ($this->type == 1) {
            $this->load->model('Company');
            $this->load->model('Bonus');
            $response = $this->CallAPI('GET', API_URL . 'getcompanyList/' . $page);
            $response = json_decode($response);

            $data['page'] = $page;
            if (isset($response->status) && $response->status == 'success') {
                $data['total_pages'] = $response->totalpages;
                $data['response'] = $response->message;
            } else {
                $data['message'] = isset($response->status) ? $response->message : '';
            }
            $data = array('title' => 'Company', 'content' => 'Company/list', 'page_title' => 'Company List', 'view_data' => $data);
            $this->load->view('template3', $data);
        } else {
            $this->logout();
        }
    }

    public function addDivision() {

        $this->load->model('Division');
        $this->load->model('Company');
        if ($this->type == 1) {
            $companyList = $this->Company->get(array('status = 1'));
            $company_id = 0;
        } elseif ($this->type == 2) {
            $companyList = $this->Company->get(array('status = 1', 'company_id = ' . $this->company_id));
            $company_id = $this->company_id;
        } else {
            $this->logout();
        }


        $data['company'] = $this->Master_Model->generateDropdown($companyList, 'company_id', 'company_name', $company_id);
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

            redirect('User/ Division', 'refresh');
        }
        $data = array('title' => 'Add Division', 'content' => 'Division/add', 'page_title' => 'Add Division', 'view_data' => $data);
        $this->load->view('template3', $data);
    }

    public function update_brand() {
        $this->load->model('Brand');
        $this->load->model('Company');
        $id = $_GET['id'];
        $data['rows'] = $this->Brand->find_by_brand($id);
        $companyList = $this->Company->get(array('status = 1'));

        $data['form'] = $this->Master_Model->generateDropdown($this->Brand->getForm(), 'form', 'form', $data['rows']['form']);
        $data['division'] = $this->Master_Model->generateDropdown($this->Division->returnDivision(), 'div_id', 'name', $data['rows']['division']);
        $data['company'] = $this->Master_Model->generateDropdown($companyList, 'company_id', 'company_name', $data['rows']['company']);
        if ($this->input->post()) {
            $data = array(
                'name' => $this->input->post('name'),
                'form' => $this->input->post('form'),
                'mrp' => $this->input->post('mrp'),
                'packing' => $this->input->post('packing'),
                'company' => $this->input->post('company_id'),
                'strength' => $this->input->post('strength'),
                'generic_id' => $this->input->post('generic_id'),
                'composition' => $this->input->post('composition'),
                'is_Combination' => $this->input->post('is_combination'),
                'status' => '1',
                'is_active' => '1',
                'division' => $this->input->post('division'),
                'unit' => $this->input->post('unit')
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
        $condition = array();
        if ($this->type == 2) {
            $condition[] = 'company_id=' . $this->company_id;
        } elseif ($this->type == 1) {
            $condition[] = NULL;
        } else {
            $this->logout();
        }

        if ((int) $this->input->get('company_id') > 0) {
            $company_id = $this->input->get('company_id');
            $condition[] = 'company_id=' . $company_id;
        }

        $condition = !empty($condition) ? join("&", $condition) : '';
        $response = $this->CallAPI('GET', API_URL . 'getBonusOffer/' . $page . '/500?' . $condition);

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

    public function editBonus() {
        $this->load->model('Bonus');
        $id = $this->input->get('id');
        $data['row'] = $this->Bonus->getBonusid($id);
        $data['state'] = $this->Bonus->getState();
        if ($this->input->post()) {
            $brand_name = $this->input->post('brand_name');
            $brand_id = $this->input->post('brand_id');
            $bonus_ratio = $this->input->post('bonus_ratio');
            $start_date = $this->input->post('start_date');
            $end_date = $this->input->post('end_date');
            $state = $this->input->post('state1');

            $finalState = join(",", $state);
            $data = array(
                'brand_id' => $brand_id,
                'brand_name' => $brand_name,
                'bonus_ratio' => $bonus_ratio,
                'start_date' => $start_date,
                'end_date' => $end_date,
                'states' => $finalState
            );

//var_dump($field_array);
            $this->Bonus->updateBonus($this->input->post('id'), $data);

            redirect('User/bonus', 'refresh');
        }

        $data = array('title' => 'Update Bonus', 'content' => 'Bonus/edit', 'page_title' => 'EditBonus', 'view_data' => $data);
        $this->load->view('template3', $data);
    }

    public function del_bonus() {
        $this->load->model('Bonus');
        $data = array(
            'status' => 0
        );

//var_dump($field_array);
        $this->Bonus->updateBonus($this->input->get('id'), $data);
        redirect('User/bonus', 'refresh');
    }

    public function addBonus() {
        $this->load->model('Bonus');
        $companyList = $this->Company->get(array('status = 1'));
        if ($this->type === 1) {
            $data['disable'] = '';
            $data['company'] = $this->Master_Model->generateDropdown($companyList, 'company_id', 'company_name');
        } elseif ($this->type === 2) {
            $data['disable'] = '';
            $data['company'] = $this->Master_Model->generateDropdown($companyList, 'company_id', 'company_name', $this->company_id);
        } else {
            $this->logout();
        }

        $data['state'] = $this->Master_Model->generateDropdown($this->Bonus->getState(), 'id', 'state');

        if ($this->input->post()) {
//var_dump($_POST);

            $company_id = $this->input->post('company_id');
            $brand_name = $this->input->post('brand_name');
            $brand_id = $this->input->post('brand_id');
            $bonus_ratio = $this->input->post('bonus_ratio');
            $start_date = $this->input->post('start_date');
            $end_date = $this->input->post('end_date');

            for ($i = 0; $i < count($brand_name); $i++) {
                $state = $this->input->post('state' . $i);
                if (!empty($state)) {
                    $finalState = join(",", $state);

                    if ($brand_id[$i] > 0 && $brand_name[$i] != '') {
                        $diff1 = $this->Company->dateDifference(date('Y-m-d'), $start_date[$i]);
                        $diff2 = $this->Company->dateDifference(date('Y-m-d'), $end_date[$i]);
                        $field_array = array(
                            'company_id' => $company_id,
                            'brand_id' => $brand_id[$i],
                            'brand_name' => $brand_name[$i],
                            'bonus_ratio' => $bonus_ratio[$i],
                            'start_date' => date('Y-m-d', strtotime($start_date[$i])),
                            'end_date' => date('Y-m-d', strtotime($end_date[$i])),
                            'states' => $finalState,
                            'status' => 1,
                            'starting_days' => $diff1->d,
                            'ending_days' => $diff2->d
                        );
//var_dump($field_array);
                        $bonusExist = $this->Bonus->bonusExist(array('brand_id = ' . $brand_id[$i]));

                        if (empty($bonusExist)) {
                            $bonus_id = $this->Bonus->insert($field_array);

                            foreach ($state as $item) {
                                $this->db->insert('bonus_state', array('state_id' => $item, 'bonus_id' => $bonus_id, 'created_at' => date('Y-m-d H:i:s')));
                            }
                        } else {
                            $this->session->set_userdata('message', $this->Master_Model->DisplayAlert('Bonus Already Exist For ' . $brand_name[$i], 'error'));
                        }
                    }
                }
            }

            $this->calculateBonusDays();
            $this->closedBonus();
            redirect('User/addBonus', 'refresh');
        }

        $data = array('title' => 'Add Bonus', 'content' => 'Bonus/add', 'page_title' => 'Add Bonus', 'view_data' => $data);
        $this->load->view('template3', $data);
    }

    public function Image_list() {
        $this->load->model('Company');
        if ($this->type == 2) {
            $id = $this->company_id;
            $data['response'] = $this->Company->getimage(array('company_id=' . $id . ''));
        }
        $data = array('title' => 'Image List', 'content' => 'Company/image_list', 'page_title' => 'Image List', 'view_data' => $data);
        $this->load->view('template3', $data);
    }

    public function image_add() {
        $this->load->model('Company');

        if ($this->input->post()) {
            $name = $_FILES['file']['name'];
            $tmp = $_FILES['file']['tmp_name'];
            $file_size = $_FILES['file']['size'];
            $date = date('Y-m-d');
            $filename = explode(".", $name);
            $extension = end($filename);
            $name = time() . "." . $extension;

            if ($file_size >= (int) (1024 * 100)) {
                $this->session->set_userdata('message', $this->Master_Model->DisplayAlert('File Size Should Be Less Than 100 KB.', 'danger'));
                redirect('User/image_list', 'refresh');
            } else {
                $image = move_uploaded_file($tmp, "./images/" . $name);

                $ActiveImageCount = $this->Company->returnEndDate($this->company_id);

                $data = array('image_name' => $name,
                    'status' => $ActiveImageCount[3],
                    'company_id' => $this->company_id,
                    'created_at' => $date,
                    'image_path' => "/images/" . $name,
                    'start_date' => $ActiveImageCount[0],
                    'end_date' => $ActiveImageCount[1],
                    'ending_days' => $ActiveImageCount[2],
                    'slot_id' => $ActiveImageCount[4],
                );

                $this->Company->image_add($data);
                redirect('User/image_list', 'refresh');
            }
        }
    }

    public function UploadImage() {
        if ($this->input->post()) {
            $name = $_FILES['file']['name'];
            $tmp = $_FILES['file']['tmp_name'];
            $file_size = $_FILES['file']['size'];
            $date = date('Y-m-d');
            $filename = explode(".", $name);
            $extension = end($filename);
            $name = time() . "." . $extension;

            if ($file_size >= (int) (1024 * 100)) {
                $this->session->set_userdata('message', $this->Master_Model->DisplayAlert('File Size Should Be Less Than 100 KB.', 'danger'));
                redirect('User/CompanyList', 'refresh');
            } else {
                $image = move_uploaded_file($tmp, "./images/" . $name);
                $data = array(
                    'logo' => $name,
                );
                $this->db->where('company_id', $this->input->post('company_id'));
                $this->db->update('company_master', $data);

                redirect('User/CompanyList', 'refresh');
            }
        }
    }

    public function active_image() {
        $this->load->model('Company');
        $id = $_GET['id'];
        $data = array('status' => 1);
        $this->Company->update_image($id, $data);
        redirect('User/image_list', 'refresh');
    }

    public function inactive_image() {
        $this->load->model('Company');
        $id = $_GET['id'];
        $data = array('status' => 0);
        $this->Company->update_image($id, $data);
        redirect('User/image_list', 'refresh');
    }

    public function calculateBonusDays() {
        $date = date('Y-m-d');
        $sql = "UPDATE 
                `bonus_info` b1 
                INNER JOIN `bonus_info` b2 
                  ON b1.`bonus_id` = b2.`bonus_id` SET b1.`starting_days` = DATEDIFF(b2.`start_date`,'$date'),
                b1.`ending_days` = DATEDIFF( b2.`end_date`,'$date') ";
        $this->db->query($sql);
    }

    public function closedBonus() {
        $sql = "UPDATE bonus_info SET status = 0 WHERE ending_days <= 0";
        $this->db->query($sql);
    }

    public function calculateImageDays() {
        $date = date('Y-m-d');
        $sql = "UPDATE 
                `images` b1 
                INNER JOIN `images` b2 
                  ON b1.`image_id` = b2.`image_id` SET 
                b1.`ending_days` = DATEDIFF( b2.`end_date`,'$date') ";
        $this->db->query($sql);
    }

    public function closedImages() {
        $sql = "UPDATE images SET status = 0 WHERE ending_days <= 0";
        $this->db->query($sql);
    }

    public function notification() {
        $this->load->model('User_model');
        $this->load->model('Communication');
        $this->load->model('Sms');
        if ($this->type == 1) {
            $result = $this->User_model->getUserState();
            $data['state'] = $this->Master_Model->generateDropdown($result, 'state', 'state', 0, array('data-count' => 'user_count'));

            $message = $this->input->post('message');

            if (isset($this->input->post('notification'))) {
                $deviceId = $this->User_model->getColumn(array("device_id IS NOT NULL ", "device_id != '' "), 'device_id');
                if (!empty($deviceId)) {
                    $registrationIds = join(",", $deviceId);
                    pushNotification($message, $deviceId);
                    $this->Communication->insert(array('message' => $message, 'to' => $registrationIds, 'count' => count($deviceId), 'created_at' => date('Y-m-d H:i:s'), 'type' => 'notification'));
                }
            }
            if (isset($this->input->post('sms'))) {
                $deviceId = $this->User_model->getColumn(array("mobile IS NOT NULL ", "mobile != '' "), 'mobile');
                if (!empty($deviceId)) {
                    $registrationIds = join(",", $deviceId);
                    $this->Sms->sendsms($registrationIds, $message);
                    $this->Communication->insert(array('message' => $message, 'to' => $registrationIds, 'count' => count($deviceId), 'created_at' => date('Y-m-d H:i:s'), 'type' => 'sms'));
                }
            }

            $data = array('title' => 'Notification', 'page_title' => 'Notification', 'view_data' => $data, 'content' => 'User/notification');
            $this->load->view('template3', $data);
        }
    }

}
