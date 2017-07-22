<?php

/**
 * 文章标签表model
 * $Id: articletags.php 970 2015-10-22 04:09:08Z xiaodawei $
 */
class articletags extends model {

    var $total;

    function __construct() {
        $this->table_name = "cp_article_tags";
        parent::__construct();
    }

    //验证标签名称是否存在
    function getTagname($tag_name) {
        $this->where = "tag_name='$tag_name'";
        $this->fields = '*';
        return $this->getResult(1);
    }

    //标签列表
    function getTagList($where, $fields = "*", $limit = 20, $offset = 0, $order = array(), $type = 2) {
        $this->fields = "count(id)";
        $this->where = $where ? $where : 1;
        $this->total = $this->getResult(3);

        $this->fields = $fields ? $fields : "*";
        $this->order = $order;
        $this->limit = $limit;
        $this->offset = $offset;

        return $this->getResult($type);
    }

    //修改查询数据
    function getTag($id) {
        $this->where = "id={$id}";
        $this->fields = '*';
        return $this->getResult();
    }

    function getTags($tag_name) {
        $this->where = "tag_name='$tag_name'";
        $this->fields = '*';
        return $this->getResult(1);
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
