<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Brand
 *
 * @author Admin
 */
class Brand extends MY_model {

    public function __construct() {
        parent::__construct();
        $this->table_name = 'brands';
    }

    public function getBrands($condition = array(), $limit, $offset) {
        $sql = "SELECT * FROM brands ";
        $sql .=!empty($condition) ? " WHERE " . join(" AND ", $condition) : " ";
        $sql .= " LIMIT {$limit} OFFSET {$offset} ";
        echo $sql;
        return $this->returnResult($sql);
    }

public function find_by_brand($id){
    $sql="select * from brands where id=$id and status='1' ";
    $query=$this->db->query($sql);
    return $query->row_array();
}
    
     public  function brand_updation($id,$data){
         $this->db->where(array('id'=>$id,'status'=>1));
         $this->db->update('brands',$data);
     }


    function getForm() {
        $sql = "SELECT DISTINCT(form) as form FROM " . $this->table_name;
        return $this->returnResult($sql);
    }


}
