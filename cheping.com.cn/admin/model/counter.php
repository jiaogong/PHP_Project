<?php

/**
 * 统计表model
 * $Id: counter.php 2617 2016-05-10 11:43:42Z cuiyuanxin $
 * @author David Shaw <tudibao@163.com>
 */
class counter extends model {

    function __construct() {
        parent::__construct();
        $this->table_name = DBNAME2 . ".counter";
    }

    function addCounter($data) {
        $this->table_name = DBNAME2 . ".counter";
        $this->ufields = $data;
        return $this->insert();
    }

    function updateCounter($data, $where) {
        $this->table_name = DBNAME2 . ".counter";
        $this->ufields = $data;
        return $this->update();
    }

    function getlist($fields, $where, $flag) {
        $this->ufields = $fields;
        $this->where = "$where";
        return $this->getResult($flag);
    }

    function getWherelist($fields, $where, $type = 2, $day, $order = '', $group = '') {
        $this->table_name = DBNAME2 . ".counter" . "_{$day}";
        $this->fields = $fields;
        $this->where = $where;
        $this->order = $order;
        $this->group = $group;
        $result = $this->getResult($type);
        return $result;
    }

    function getArticlelist($fields, $where, $type = 2, $order = '', $group = '', $limit) {
        $this->table_name = DBNAME2 . ".counter";
        $this->fields = $fields;
        $this->where = $where;
        $this->order = $order;
        $this->limit = $limit;
        $this->group = $group;
        $result = $this->getResult($type);
        return $result;
    }

    function getWebstatcount($fields = "*", $where = "1", $type = 3) {
        $this->table_name = DBNAME2 . ".counter";
        $this->where = $where;
        $this->fields = $fields;
        return $this->getResult($type);
    }

    function getselect($table_name, $fields = "*", $where = "1", $type = 3) {
        $this->table_name = $table_name;
        $this->where = $where;
        $this->fields = $fields;
        return $this->getResult($type);
    }

    function getWebstat($fields = "*", $where = "1", $total = 0, $type = 1) {
        $this->where = $where;
        if ($total) {
            $this->fields = "count(id)";
            $this->total = $this->getResult(3);
        }

        $this->fields = $fields;
        return $this->getResult($type);
    }

    //最高纪录
    function getMaxstat($fields = "*", $where = "1") {
        $this->fields = $fields;
        $this->where = $where;
        return $this->getResult(1);
    }

}
