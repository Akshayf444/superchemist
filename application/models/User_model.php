<?php

class User_model extends MY_model {

    public function __construct() {
        parent::__construct();
        $this->table_name = 'users';
        $this->primary_key = 'user_id';
    }

    public function userexist($mobile) {
        $sql = "SELECT * FROM " . $this->table_name . " WHERE mobile = '" . $mobile . "'";
        return $this->returnResult($sql, 'row');
    }
public function userexistid($id) {
        $sql = "SELECT * FROM " . $this->table_name . " WHERE user_id= '" . $id. "'";
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

    public function updateMobile($mobile, $data) {
        $this->db->where('mobile', $mobile);
        $this->db->update('users', $data);
    }

    public function insertLogin($data) {
        $this->db->insert('login_history', $data);
        return $this->db->insert_id();
    }

    public function getAppVersion() {
        $sql = "SELECT * FROM app_version WHERE status = 1 ORDER BY version_id DESC LIMIT 1";
        return $this->returnResult($sql, 'row');
    }

    public function getUserState($condition = array()) {
        $sql = "SELECT COUNT(user_id) as user_count,SUM(CASE WHEN user_type = 1 THEN 1 ELSE 0 END ) as count1,SUM(CASE WHEN user_type = 2 THEN 1 ELSE 0 END ) as count2,state FROM " . $this->table_name . " WHERE (state IS NOT NULL OR state !='') ";
        $sql .=!empty($condition) ? " AND " . join(" AND ", $condition) : " ";
        $sql .= " GROUP BY state ";
        //echo $sql;
        return $this->returnResult($sql);
    }

    public function getColumn($conditions = array(), $column = 'device_id') {
        $sql = "SELECT DISTINCT(" . $column . ") as " . $column . " FROM " . $this->table_name;
        $sql .=!empty($conditions) ? " WHERE " . join(" AND ", $conditions) : " ";
        //echo $sql;
        $query = $this->db->query($sql);
        return $query->result_array();
    }
   public function updatePassword($id, $data) {
        $this->db->where('user_id', $id);
        $this->db->update('users', $data);
    }
}
