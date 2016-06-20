<?php

class User_model extends CI_Model {

    public function __construct() {
        $this->load->database();
        $this->table_name = 'tbl_employee_master';
    }

    public function userexist($mobile) {
        $sql = "SELECT * FROM users WHERE mobile = '" . $mobile . "'";
        $query = $this->db->query($sql);
        return $query->row();
    }

    public function create($data) {
        $this->db->insert('users', $data);
        return $this->db->insert_id();
    }

}
