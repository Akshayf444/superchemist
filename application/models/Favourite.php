<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Favourite
 *
 * @author Admin
 */
class Favourite extends MY_model {

    public function __construct() {
        parent::__construct();
        $this->table_name = 'favourite';
        $this->primary_key = 'id';
    }

}
