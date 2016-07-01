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
        $this->primary_key = 'company_id';
    }

    public function insert($data) {
        $this->db->insert('company_master', $data);
        return $this->db->insert_id();
    }

    public function update($data, $id) {
        $this->db->where('company_id', $id);
        $this->db->update('company_master', $data);
    }

    public function getcompany($condition = array(), $limit = 0, $offset = 0) {
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

    public function getimage($condition = array(), $limit = 0, $order_by = "") {
        $sql = " SELECT * FROM images   ";
        $sql .=!empty($condition) ? " WHERE " . join(" AND ", $condition) : " ";
        $sql .=" " . $order_by;
        $sql .= $limit > 0 ? " LIMIT {$limit} " : " ";
//         echo $sql;
        return $this->returnResult($sql);
    }

    public function countimage($condition = array()) {
        $sql = " SELECT COUNT(*) as imageCount FROM images   ";
        $sql .=!empty($condition) ? " WHERE " . join(" AND ", $condition) : " ";
//         echo $sql;
        return $this->returnResult($sql, 'row');
    }

    public function image_add($data) {
        $this->db->insert('images', $data);
    }

    public function update_image($id, $data) {
        $this->db->where('image_id', $id);
        $query = $this->db->update('images', $data);
    }

    public function countImageDates($company_id = 0) {
        $sql = "SELECT COUNT(*) as imageCount FROM images WHERE company_id = {$company_id} ";
        //echo $sql;
        return $this->returnResult($sql, 'row');
    }

    public function getImageDates($company_id = 0) {
        $sql = "SELECT * FROM images WHERE company_id = {$company_id} AND  ending_days BETWEEN 0 AND 7 ORDER BY ending_days ASC LIMIT 10";
        return $this->returnResult($sql);
    }

    public function returnEndDate($company_id) {
        $date = strtotime(date('Y-m-d'));
        $imageCount = $this->countImageDates($company_id);

        $slot_id = (int) ($imageCount->imageCount / 10);

        if ($slot_id == 0) {
            $date1 = date('Y-m-d');
            $date2 = date('Y-m-d', strtotime("+7 days"));

            $difference = $this->dateDifference($date1, $date2);

            return array(
                $date1,
                $date2,
                $difference->d,
                1,
                $slot_id
            );
        } else {
            $countCurrentSlot = $this->countimage(array('company_id = ' . $company_id, 'slot_id = ' . $slot_id));
            $searchslot_id = (int) $slot_id - 1;
            $condition = array(
                'company_id = ' . $company_id,
                'slot_id=' . $searchslot_id
            );

            $lastImage = $this->getimage($condition, ($countCurrentSlot->imageCount + 1), ' ORDER BY image_id DESC ');
            $lastImage = array_shift($lastImage);

            $date1 = date('Y-m-d', date(strtotime("+1 day", strtotime($lastImage->end_date))));
            $date2 = date('Y-m-d', date(strtotime("+8 day", strtotime($lastImage->end_date))));

            $difference = $this->dateDifference($date1, $date2);

            return array(
                $date1,
                $date2,
                $difference->d,
                0,
                $slot_id
            );
        }

        /* if ($imageCount->imageCount > 10) {
          $lastImage = $this->getImageDates($company_id);
          $lastImage = array_shift($lastImage);
          $date1 = new DateTime($lastImage->end_date);
          $date1->modify("+1 day");
          $date2 = $date1->modify("+7 day");

          $difference = $this->dateDifference($date1, $date2);

          return array(
          $date1,
          $date2,
          $difference->d,
          $slot_id
          );
          } else {
          $date1 = date('Y-m-d');
          $date2 = date('Y-m-d', strtotime("+7 days"));

          $difference = $this->dateDifference($date1, $date2);

          return array(
          $date1,
          $date2,
          $difference->d,
          $slot_id
          );
          } */
    }

    public function countBonus($id) {
        $sql = " SELECT COUNT(company_id)as count FROM  bonus_info WHERE company_id='$id'";
        $query = $this->db->query($sql);
        return $query->row_array();
    }

}
