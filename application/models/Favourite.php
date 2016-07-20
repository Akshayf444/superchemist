<?php
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
