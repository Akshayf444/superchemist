<?php

/**
 * Description of Company
 * This is model class for Company Master Table
 * Business Logic For Companies
 * @author Admin
 */
class Company extends MY_model {

    public function __construct() {
        parent::__construct();
        $this->table_name = 'company_master';
    }

    public function insert($data) {
        $this->db->insert('company_master', $data);
        return $this->db->insert_id();
    }

    public function update($data, $id) {
        $this->db->where('company_id', $id);
        $this->db->update('company_master', $data);
    }
 public function getcompany($condition = array(), $limit, $offset) {
        $sql = "SELECT * FROM company_master ";
        $sql .=!empty($condition) ? " WHERE " . join(" AND ", $condition) : " ";
        $sql .= " LIMIT {$limit} OFFSET {$offset} ";

        return $this->returnResult($sql);
    }
     public function countCompany($condition = array()) {
        $sql = "SELECT COUNT(*) AS totalcount FROM company_master ";
        $sql .=!empty($condition) ? " WHERE " . join(" AND ", $condition) : " ";
        //echo $sql;
        return $this->returnResult($sql, 'row');
    }
public function getimage($condition = array()) {
        $sql = " SELECT * FROM images   ";
        $sql .=!empty($condition) ? " WHERE " . join(" AND ", $condition) : " ";
//         echo $sql;
        return $this->returnResult($sql);
    }
     public function image_add($data){
         $this->db->insert('images',$data);
     }
      public function update_image($data, $id) {
        $this->db->where('image_id', $id);
        $this->db->update('images', $data);
    }
}
