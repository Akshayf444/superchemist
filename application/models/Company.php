<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Company
 *
 * @author Admin
 */
class Company extends MY_model {

    public function __construct() {
        parent::__construct();
        $this->table_name = 'company_master';
    }

    public function authenticate($mobile, $password) {
        $sql = "SELECT * FROM  " . $this->table_name . " WHERE mobile = '" . $mobile . "' AND password = '" . $password . "' AND status = 1 ";
        return $this->returnResult($sql, 'row');
    }

}
