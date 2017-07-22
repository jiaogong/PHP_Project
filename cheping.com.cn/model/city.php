<?php

/**
 * 城市表model
 * $Id: city.php 970 2015-10-22 04:09:08Z xiaodawei $
 */
class city extends model {

    function __construct() {
        $this->table_name = "cp_city";
        parent::__construct();
    }

    function getList($fields, $where, $flag) {
        $this->fields = $fields;
        $this->where = $where;
        return $this->getResult($flag);
    }

    function updateList($ufields, $where) {
        $this->ufields = $ufields;
        $this->where = $where;
        $this->update();
    }

    function addList($ufields) {
        $this->ufields = $ufields;
        return $this->insert();
    }

}
