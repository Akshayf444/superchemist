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
  public function create($data) {
        $this->db->insert('company_master', $data);
        return $this->db->insert_id();
    }
}
