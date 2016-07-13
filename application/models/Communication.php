<?php

class Communication extends MY_model {

    public function __construct() {
        parent::__construct();
        $this->table_name = 'communication';
        $this->primary_key = 'com_id';
    }

    public function getCount($condition = array()) {
        $sql = "SELECT SUM(CASE WHEN type = 'notification' THEN count ELSE 0 END ) as notificationcount,SUM(CASE WHEN type = 'sms' THEN count ELSE 0 END ) as smscount FROM " . $this->table_name . " ";
        $sql .=!empty($condition) ? " WHERE " . join(" AND ", $condition) : '';
        $sql.= " GROUP BY type ";
        return $this->returnResult($sql, 'row');
    }

    public function allCount($condition = array()) {
        $sql = "SELECT COUNT(*) as count FROM " . $this->table_name;
        $sql .=!empty($condition) ? " WHERE " . join(" AND ", $condition) : '';
        return $this->returnResult($sql, 'row');
    }

}
