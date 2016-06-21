<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Division
 *
 * @author Admin
 */
class Division extends MY_model {

    public function __construct() {
        parent::__construct();
        $this->table_name = 'divisions';
    }

    public function getDivision($condition = array()) {
        $sql = " SELECT d.*,cm.company_name FROM " . $this->table_name . " d INNER JOIN company_master cm ON d.company_id = cm.company_id ";
        $sql .=!empty($condition) ? " WHERE " . join(" AND ", $condition) : " ";
        return $this->returnResult($sql);
    }

}
