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
        $this->primary_key = 'div_id';
    }

    public function getDivision($condition = array()) {
        $sql = " SELECT d.*,cm.company_name FROM " . $this->table_name . " d INNER JOIN company_master cm ON d.company_id = cm.company_id ";
        $sql .=!empty($condition) ? " WHERE " . join(" AND ", $condition) : " ";
         //echo $sql;
        return $this->returnResult($sql);
    }

    public function countDivision($condition = array()) {
        $sql = " SELECT COUNT(d.div_id) as divisionCount FROM " . $this->table_name . " d INNER JOIN company_master cm ON d.company_id = cm.company_id ";
        $sql .=!empty($condition) ? " WHERE " . join(" AND ", $condition) : " ";
//         echo $sql;
        return $this->returnResult($sql,'row');
    }

    public function find_by_division($id) {
        $sql = "select d.* from divisions d INNER JOIN company_master cm ON d.company_id = cm.company_id  where d.div_id = $id and d.status='1' ";
        $query = $this->db->query($sql);
        return $query->row_array();
    }

    public function division_updation($id, $data) {
        $this->db->where(array('div_id' => $id, 'status' => 1));
        $this->db->update('divisions', $data);
    }

    public function returnDivision() {
        $condition = array();
        if ($this->type == 2) {
            $id = $this->company_id;
            $condition = array(
                'd.company_id=' . $id . '', 'd.status = 1 ', 'cm.status = 1'
            );
        } elseif ($this->type == 1) {
            $condition = array('d.status = 1 ', 'cm.status = 1');
        }

        return $this->Division->getDivision($condition);
    }

}
