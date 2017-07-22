<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class salestate extends model {

    function __construct() {
        $this->table_name = "cardb_salestate";
        parent::__construct();
    }

    function getSaleStateList($fields,$where,$flag){
        $this->fields = $fields;
        $this->where = $where;
        return $this->getResult($flag);
    }
}

?>