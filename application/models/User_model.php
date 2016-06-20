<?php

class User_model extends CI_Model {

    public function __construct() {
        $this->load->database();
        $this->table_name = 'tbl_employee_master';
    }

    public function tmauthentication($username, $password) {
        $this->db->select('*');
        $this->db->from($this->table_name);
        $this->db->where(array('TM_Emp_Id' => $username, 'TM_Emp_Id' => $username));
        $query = $this->db->get();
        // echo $this->db->last_query();
        return $query->row_array();
    }

    public function bmauthentication($username, $password) {
        $this->db->select('*');
        $this->db->from($this->table_name);
        $this->db->where(array('BM_Emp_Id' => $username, 'BM_Emp_Id' => $username));
        $query = $this->db->get();
        // echo $this->db->last_query();
        return $query->row_array();
    }

    public function smauthentication($username, $password) {
        $this->db->select('*');
        $this->db->from($this->table_name);
        $this->db->where(array('SM_Emp_Id' => $username, 'SM_Emp_Id' => $username));
        $query = $this->db->get();
        // echo $this->db->last_query();
        return $query->row_array();
    }
 public function adminauthentication($username,$password){
     $this->db->select('*');
     $this->db->from('admin');
     $this->db->where(array('admin_id'=>$username,'admin_id'=>$username));
     $query=$this->db->get();
     //echo $this->db->last_query();
      return $query->row_array();
 }
    public function addDoctor($data) {
        $this->db->insert('tbl_doctor', $data);
//        return $this->db->insert_id;
    }

    public function del_youngdoc($id, $data) {
        $this->db->where('DoctorId', $id);
        $this->db->update('tbl_doctor', $data);
    }

    public function find_by_id($id) {
        $sql = "Select * from tbl_doctor where DoctorId ='$id'";
        $query = $this->db->query($sql);
        return $query->row();
    }

    public function find_Institution($tm_id) {
        $sql = "SELECT DoctorId, Institution FROM tbl_doctor where TM_EmpID='$tm_id' And DrStatus='2' ";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function getDoctor($conditions = array()) {
        $sql = "SELECT dm.*,em.TM_Emp_Id,em.BM_Name,em.SM_Name FROM ( SELECT * FROM tbl_doctor ";
        if (!empty($conditions)) {
            $sql.=" WHERE " . join(" AND ", $conditions);
        }
        $sql.= " ) AS dm Inner JOIN  tbl_employee_master  em ON dm.TM_EmpID = em.TM_Emp_Id  ";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function getEmployee($conditions = array()) {
        $sql = " select *  FROM tbl_employee_master ";
        if (!empty($conditions)) {
            $sql.=" WHERE " . join(" AND ", $conditions);
        }
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function getbm($conditions = array()) {
        $sql = " SELECT DISTINCT(BM_Emp_Id) AS BM_Emp_Id,`BM_Name` FROM tbl_employee_master ";
        if (!empty($conditions)) {
            $sql.=" WHERE " . join(" AND ", $conditions);
        }
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function view_all($conditions = array()) {
        $sql = "SELECT dm.*,inst.name as Institution, em.* FROM  tbl_employee_master  em INNER JOIN tbl_doctor dm  ON dm.TM_EmpID = em.TM_Emp_Id LEFT JOIN tbl_institute inst ON inst.inst_id = dm.Institution ";

        if (!empty($conditions)) {
            $sql.=" WHERE " . join(" AND ", $conditions);
        }
        $sql.= " GROUP BY dm.DoctorId ";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function addinstitute($data) {
        $this->db->insert('tbl_institute', $data);
    }

    public function updateinstitute($data, $id) {
        $this->db->where('inst_id', $id);
        $this->db->update('tbl_institute', $data);
    }

    public function getInstitute($condition = array()) {
        $sql = "SELECT * FROM tbl_institute WHERE del_status = 0 ";
        if (!empty($condition)) {
            $sql .= " AND " . join(" AND ", $condition);
        }

        //echo $sql;
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function dashboardStatus($condition = array()) {
        $sql = "SELECT SUM(CASE WHEN dm.DrStatus = 1 THEN 1 ELSE 0 END ) AS ydoctor, SUM(CASE WHEN dm.DrStatus = 2 THEN 1 ELSE 0 END) AS pgdoctor "
                . " FROM  tbl_employee_master em INNER JOIN tbl_doctor dm  ON dm.TM_EmpID = em.TM_Emp_Id ";
        if (!empty($condition)) {
            $sql.=" WHERE " . join(" AND ", $condition);
        }
        $sql.= " ";
 
        $query = $this->db->query($sql);
        return $query->row();
    }

    public function getState() {
        $allStates = array();
        $indian_all_states = array(
            'AP' => 'Andhra Pradesh',
            'AR' => 'Arunachal Pradesh',
            'AS' => 'Assam',
            'BR' => 'Bihar',
            'CT' => 'Chhattisgarh',
            'GA' => 'Goa',
            'GJ' => 'Gujarat',
            'HR' => 'Haryana',
            'HP' => 'Himachal Pradesh',
            'JK' => 'Jammu & Kashmir',
            'JH' => 'Jharkhand',
            'KA' => 'Karnataka',
            'KL' => 'Kerala',
            'MP' => 'Madhya Pradesh',
            'MH' => 'Maharashtra',
            'MN' => 'Manipur',
            'ML' => 'Meghalaya',
            'MZ' => 'Mizoram',
            'NL' => 'Nagaland',
            'OR' => 'Odisha',
            'PB' => 'Punjab',
            'RJ' => 'Rajasthan',
            'SK' => 'Sikkim',
            'TN' => 'Tamil Nadu',
            'TL' => 'Telangana',
            'TR' => 'Tripura',
            'UK' => 'Uttarakhand',
            'UP' => 'Uttar Pradesh',
            'WB' => 'West Bengal',
            'AN' => 'Andaman & Nicobar',
            'CH' => 'Chandigarh',
            'DN' => 'Dadra and Nagar Haveli',
            'DD' => 'Daman & Diu',
            'DL' => 'Delhi',
            'LD' => 'Lakshadweep',
            'PY' => 'Puducherry',
        );
        foreach ($indian_all_states as $key => $value) {
            $states = new stdClass();
            $states->state = $value;
            array_push($allStates, $states);
        }
        return $allStates;
    }

    public function deleteinstitute($id) {
        $this->db->where(array('inst_id' => (int)$id));
        $this->db->update('tbl_institute', array('del_status' => 1));
    }
public function getRegion($conditions = array()) {
        $sql = "SELECT DISTINCT(Region) as region FROM tbl_employee_master ";
        if (!empty($conditions)) {
            $sql.=" WHERE " . join(" AND ", $conditions);
        }

        $query = $this->db->query($sql);
        return $query->result();
    }

    public function getZone($conditions = array()) {
        $sql = "SELECT DISTINCT(Zone) as zone FROM tbl_employee_master ";
        if (!empty($conditions)) {
            $sql.=" WHERE " . join(" AND ", $conditions);
        }

        $query = $this->db->query($sql);
        return $query->result();
    }
      public function getSM($conditions = array()) {
        $sql = "SELECT DISTINCT(SM_Emp_Id) as SM_Emp_Id,SM_Name FROM tbl_employee_master ";
        if (!empty($conditions)) {
            $sql.=" WHERE " . join(" AND ", $conditions);
        }

        $query = $this->db->query($sql);
        return $query->result();
    }

}
