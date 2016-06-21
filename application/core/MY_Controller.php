<?php

class MY_Controller extends CI_Controller {

    public $type;
    public $company_id;
    public $full_name;

    function __construct() {
        parent::__construct();
        $this->type = $this->session->userdata('type');
        $this->company_id = $this->session->userdata('company_id');
        $this->full_name = $this->session->userdata('full_name');
    }

    function is_logged_in($Profile = "") {
        if (!is_null($this->session->userdata('Emp_Id')) && $this->session->userdata('Emp_Id') != '') {
            if (strtolower($this->session->userdata('Designation')) == strtolower($Profile)) {
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

    function logout() {
        redirect('User/index', 'redirect');
    }

    function CallAPI($method, $url, $data = false) {
        $curl = curl_init();

        switch ($method) {
            case "POST":
                curl_setopt($curl, CURLOPT_POST, 1);

                if ($data)
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                break;
            case "PUT":
                curl_setopt($curl, CURLOPT_PUT, 1);
                break;
            default:
                if ($data)
                    $url = sprintf("%s?%s", $url, http_build_query($data));
        }

        // Optional Authentication:

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        //var_dump(curl_getinfo($curl));
        $result = curl_exec($curl);

        curl_close($curl);

        return $result;
    }

}
