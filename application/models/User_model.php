<?php

class User_model extends MY_model {

    public $table_name;

    public function __construct() {
        parent::__construct();
        $this->table_name = 'users';
    }

    public function userexist($mobile) {
        $sql = "SELECT * FROM " . $this->table_name . " WHERE mobile = '" . $mobile . "'";
        return $this->returnResult($sql, 'row');
    }

    public function create($data) {
        $this->db->insert('users', $data);
        return $this->db->insert_id();
    }

    public function authentication($mobile, $password) {
        $sql = "SELECT * FROM  " . $this->table_name . " WHERE mobile = '" . $mobile . "' AND password = '" . $password . "' AND status = 1 ";
        return $this->returnResult($sql, 'row');
    }
     public function update($mobile,$data){
         $this->db->where('mobile',$mobile);
         $this->db->update('users',$data);
     } 

}
