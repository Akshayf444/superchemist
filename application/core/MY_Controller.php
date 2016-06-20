<?php

class MY_Controller extends CI_Controller {

    public $Emp_Id;
    public $TM_Emp_Id;
    public $BM_Emp_Id;
    public $SM_Emp_Id;
    public $SSM_Emp_Id;
    public $Designation;
    public $Reporting_Id;
    public $Full_Name;
    public $smswayid;

    function __construct() {
        parent::__construct();
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
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($curl, CURLOPT_USERPWD, "username:password");

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $result = curl_exec($curl);

        curl_close($curl);

        return $result;
    }

}
