<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MobileVerification
 *
 * @author Admin
 */
class MobileVerification extends CI_Model {

    public function creater($data) {
        $this->db->insert('mobileverification', $data);
        return $this->db->insert_id();
    }

    public function update($data, $id) {
        $this->db->where('mobile', $id);
        $this->db->update('mobileverification', $data);
    }

    public function mobileexist($mobile) {
        $sql = "SELECT * FROM mobileverification WHERE mobile = '" . $mobile . "' ";
        $query = $this->db->query($sql);
        return $query->row();
    }

}
