<?php

/**
 * $Id: cardbstatic.php 709 2015-08-27 03:09:20Z xiaodawei $
 */
class cardbStatic extends model {

    var $type = array(
        array('name' => 'JS脚本文件', 'type' => 'js', 'path' => 'js/'),
        array('name' => '品牌页面文件', 'type' => 'html', 'path' => 'html/brand/'),
        array('name' => '车系页面文件', 'type' => 'html', 'path' => 'html/series/'),
        array('name' => '车款页面文件', 'type' => 'html', 'path' => 'html/model/'),
        array('name' => '包含页面文件', 'type' => 'html', 'path' => 'ssi/'),
        array('name' => '无生成文件', 'type' => '', 'path' => ''),
        array('name' => '其它数据文件', 'type' => 'html', 'path' => 'data/'),
    );

    function __construct() {
        parent::__construct();
        $this->table_name = "cardb_static";
    }

    function getStatic($id) {
        $this->fields = "*";
        $this->where = "id='{$id}'";
        return $this->getResult();
    }

    function getAllStatic($where = '1', $order = array(), $limit = 1, $offset = 0) {
        $this->where = $where;
        $this->fields = "count(id)";
        $this->total = $this->getResult(3);

        $this->limit = $limit;
        $this->offset = $offset;
        $this->order = $order;
        $this->fields = "*";

        return $this->getResult(2);
    }

    function getStaticByPath($path, $id = '') {
        $this->fields = "*";
        $this->where = "savepath='{$path}'" . ($id ? " and id<>'{$id}'" : "");
        return $this->getResult();
    }

}

?>
