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

    public function image_add($data) {
        $this->db->insert('images', $data);
    }

    public function update_image($id, $data) {
        $this->db->where('image_id', $id);
        $query = $this->db->update('images', $data);
    }

    public function countImageDates($company_id = 0) {
        $sql = "SELECT COUNT(*) as imageCount FROM images WHERE company_id = {$company_id} AND ending_days BETWEEN 0 AND 7";
        return $this->returnResult($sql, 'row');
    }

    public function getImageDates($company_id = 0) {
        $sql = "SELECT * FROM images WHERE company_id = {$company_id} AND  ending_days BETWEEN 0 AND 7 ORDER BY ending_days ASC LIMIT 10";
        return $this->returnResult($sql);
    }

    public function returnEndDate($company_id) {
        $date = strtotime(date('Y-m-d'));
        $imageCount = $this->countImageDates($company_id);
        if ($imageCount->imageCount > 10) {
            $lastImage = $this->getImageDates($company_id);
            $lastImage = array_shift($lastImage);
            $date1 = date('Y-m-d', strtotime("+1 days", $lastImage->end_date));
            $date2 = date('Y-m-d', strtotime("+8 days", $lastImage->end_date));

            $difference = $this->dateDifference($date1, $date2);

            return array(
                $date1,
                $date2,
                $difference->d
            );
        } else {
            $date1 = date('Y-m-d');
            $date2 = date('Y-m-d', strtotime("+7 days"));

            $difference = $this->dateDifference($date1, $date2);

            return array(
                $date1,
                $date2,
                $difference->d
            );
        }
    }

}
