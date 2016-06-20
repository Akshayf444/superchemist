<?php

class MobileVerification extends MY_model {

    public function __construct() {
        parent::__construct();
        $this->table_name = 'mobileverification';
    }

    public function creater($data) {
        $this->db->insert($this->table_name, $data);
        return $this->db->insert_id();
    }

    public function update($data, $id) {
        $this->db->where('mobile', $id);
        $this->db->update($this->table_name, $data);
    }

    public function mobileexist($mobile) {
        $sql = "SELECT * FROM " . $this->table_name . " WHERE mobile = '" . $mobile . "' ";
        return $this->returnResult($sql, 'row');
    }

}
