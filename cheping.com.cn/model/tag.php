<?php

/**
 * 文章标签表model
 * $Id: tag.php 970 2015-10-22 04:09:08Z xiaodawei $
 */
class tag extends model {

    var $total;

    function __construct() {
        $this->table_name = "cp_tags";
        parent::__construct();
    }

    function getTag($where) {
        $this->where = $where;
        $this->fields = '*';
        return $this->getResult(2);
    }

    function getname($id) {
        $this->where = "id='{$id}'";
        $this->fields = '*';
        return $this->getResult();
    }

    //查出指定数据
    function getTagFields($fields = "*", $where, $flag = 2, $order = array()) {
        $this->fields = $fields;
        $this->where = $where ? $where : 1;
        $this->order = $order;
        return $this->getResult($flag);
    }

}

?>
