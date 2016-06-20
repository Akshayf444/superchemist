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
        $this->Emp_Id = $this->session->userdata('Emp_Id');
        $this->TM_Emp_Id = $this->session->userdata('TM_Emp_Id');
        $this->BM_Emp_Id = $this->session->userdata('BM_Emp_Id');
        $this->SM_Emp_Id = $this->session->userdata('SM_Emp_Id');
        $this->SSM_Emp_Id = $this->session->userdata('SSM_Emp_Id');
        $this->Reporting_Id = $this->session->userdata('Reporting_Id');
        $this->Designation = strtoupper($this->session->userdata('Designation'));
        $this->Full_Name = $this->session->userdata('Full_Name');
        $this->smswayid = $this->session->userdata('smswayid');
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
        $this->session->unset_userdata('Emp_Id');
        $this->session->unset_userdata('TM_Emp_Id');
        $this->session->unset_userdata('BM_Emp_Id');
        $this->session->unset_userdata('SM_Emp_Id');
        $this->session->unset_userdata('SSM_Emp_Id');
        $this->session->unset_userdata('Reporting_Id');
        $this->session->unset_userdata('Designation');
        $this->session->unset_userdata('Full_Name');

        $this->Emp_Id = null;
        $this->TM_Emp_Id = null;
        $this->BM_Emp_Id = null;
        $this->SM_Emp_Id = null;
        $this->SSM_Emp_Id = null;
        $this->Reporting_Id = null;
        $this->Designation = null;
        $this->Full_Name = null;
        redirect('User/index', 'refresh');
    }

}
