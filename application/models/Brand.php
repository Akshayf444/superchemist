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
        return $this->returnResult($sql);
    }

}
