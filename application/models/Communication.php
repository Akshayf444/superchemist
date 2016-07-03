<?php

class Communication extends MY_model {

    public function __construct() {
        parent::__construct();
        $this->table_name = 'communication';
        $this->primary_key = 'com_id';
    }

}
