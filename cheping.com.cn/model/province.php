<?php

/**
 * 省份表model
 * $Id: province.php 970 2015-10-22 04:09:08Z xiaodawei $
 */
class province extends model {

    function __construct() {
        $this->table_name = "cp_province";
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
