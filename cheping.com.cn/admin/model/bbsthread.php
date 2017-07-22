<?php

/**
 * cp_thread
 * $Id: bbsthread.php 2900 2016-06-03 09:36:52Z wangchangjiang $
 */
class bbsthread extends model {

    function __construct() {
        parent::__construct();
        $this->table_name = "cp_thread";
    }

    /**
     * 获取论坛版块相关信息
     *
     * @param $fields
     * @param null $where
     * @param int $flag
     * @return mixed
     */
    function getThreadTypeData($fields, $where=Null, $flag=1){
        $this->fields= $fields;
        $this->where = $where;
        return $this->getResult($flag);
    }
}

?>
