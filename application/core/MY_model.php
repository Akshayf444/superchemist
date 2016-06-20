<?php

class MY_model extends CI_Model {

    public $primary_key = 'abstract';
    public $table_name = 'abstract';

    public function __construct() {
        parent::__construct();
    }

    public function returnResult($sql, $type = 'row') {
        $query = $this->db->query($sql);
        if ($type == 'row') {
            return $query->row();
        } else {
            return $query->result();
        }
    }

}
