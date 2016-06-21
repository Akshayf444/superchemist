<?php

class MY_model extends CI_Model {

    public $primary_key = 'abstract';
    public $table_name = 'abstract';

    public function __construct() {
        parent::__construct();
    }

    public function returnResult($sql, $type = 'result') {
        $query = $this->db->query($sql);
        $result = $type == 'row' ? $query->row() : $query->result();
        return !empty($result) ? $result : FALSE;
    }

    public function authenticate($mobile, $password) {
        $sql = "SELECT * FROM  " . $this->table_name . " WHERE mobile = '" . $mobile . "' AND password = '" . $password . "' AND status = 1 ";
        return $this->returnResult($sql, 'row');
    }

    public function insert($data) {
        $this->db->insert($this->table_name, $data);
        return $this->db->insert_id();
    }

    public function get($condition = array()) {
        $sql = "SELECT * FROM  " . $this->table_name;
        $sql .=!empty($condition) ? " WHERE " . join(" AND ", $condition) : " ";
        
        //echo $sql;
        return $this->returnResult($sql);
    }

}
