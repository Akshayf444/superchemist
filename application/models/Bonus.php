<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Bonus
 *
 * @author Admin
 */
class Bonus extends MY_model {

    public function __construct() {
        parent::__construct();
        $this->table_name = 'bonus_info';
    }

    public function createTitle($data) {
        $this->db->insert('bonus_title', array('title' => $data['title'], 'created_at' => date('Y-m-d H:i:s')));
        return $this->db->insert_id();
    }

    public function getState() {
        $allStates = array();
        $indian_all_states = array(
            '1' => 'Andhra Pradesh',
            '2' => 'Arunachal Pradesh',
            '3' => 'Assam',
            '4' => 'Bihar',
            '5' => 'Chhattisgarh',
            '6' => 'Goa',
            '7' => 'Gujarat',
            '8' => 'Haryana',
            '9' => 'Himachal Pradesh',
            '10' => 'Jammu & Kashmir',
            '11' => 'Jharkhand',
            '12' => 'Karnataka',
            '13' => 'Kerala',
            '14' => 'Madhya Pradesh',
            '15' => 'Maharashtra',
            '16' => 'Manipur',
            '17' => 'Meghalaya',
            '18' => 'Mizoram',
            '19' => 'Nagaland',
            '20' => 'Odisha',
            '21' => 'Punjab',
            '22' => 'Rajasthan',
            '23' => 'Sikkim',
            '24' => 'Tamil Nadu',
            '25' => 'Telangana',
            '26' => 'Tripura',
            '27' => 'Uttarakhand',
            '28' => 'Uttar Pradesh',
            '29' => 'West Bengal',
            '30' => 'Andaman & Nicobar',
            '31' => 'Chandigarh',
            '32' => 'Dadra and Nagar Haveli',
            '33' => 'Daman & Diu',
            '34' => 'Delhi',
            '35' => 'Lakshadweep',
            '36' => 'Puducherry',
        );

        foreach ($indian_all_states as $key => $value) {
            $states = new stdClass();
            $states->id = $key;
            $states->state = $value;
            array_push($allStates, $states);
        }
        return $allStates;
    }

    public function getBonus($condition = array(), $limit, $offset) {
        $sql = "SELECT bf.*,bd.name,cm.company_name FROM (SELECT * FROM bonus_info WHERE status = 1 ";
        $sql .=!empty($condition) ? " AND " . join(" AND ", $condition) : " ";
        $sql .= " ) as bf INNER JOIN brands bd ON bd.id = bf.brand_id INNER JOIN company_master cm ON cm.company_id = bd.company LIMIT {$limit} OFFSET {$offset}";
        //echo $sql;
        return $this->returnResult($sql);
    }

    public function countBonus() {
        $sql = "SELECT count(bf.id) as bonusCount FROM (SELECT * FROM bonus_info WHERE status = 1 ";
        $sql .=!empty($condition) ? " AND " . join(" AND ", $condition) : " ";
        $sql .= " ) as bf INNER JOIN brands bd ON bd.id = bf.brand_id INNER JOIN company_master cm ON cm.company_id = bd.company ";
        return $this->returnResult($sql, 'row');
    }

}