<?php

/**
 * 收藏表model
 * $Id: collect.php 2918 2016-06-06 02:25:23Z wangqin $
 */
class collect extends model {

    var $total;

    function __construct() {
        $this->table_name = "cp_collect";
        parent::__construct();
    }

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

    function getTag($id) {
        $this->where = "id={$id}";
        $this->fields = '*';
        return $this->getResult(1);
    }

    function delList($where) {
        $this->where = $where;
        return $this->del();
    }

    function UpdateList($ufields, $where) {
        $this->where = $where;
        $this->ufields = $ufields;
        return $this->update();
    }

    function getList($fields = "*", $where, $type = 2) {
        $this->where = $where;
        $this->fields = $fields;
        return $this->getResult($type);
    }

    function getListlimit($where, $fields = "*", $limit, $offset, $order, $type = 2) {
        $this->tables = array(
            'cp_collect' => 'cc',
            'cp_article' => 'ca',
        );
        $this->limit = $limit;
        $this->offset = $offset;
        $this->order = $order;
        $this->where = $where . " and cc.article_id=ca.id";
        $this->fields = $fields;
        return $this->joinTable($type);
    }
      /**
     * 查询用户表collect uid 收藏过的文章和视频
     */  
        function getCollects($uid,$fields) {
        $this->tables = array(
            'cp_collect' => 'cc',
            'cp_article' => 'ca',
        );
        $this->fields = $fields;
        $this->where = "cc.uid=$uid  and cc.article_id=ca.id";
         return $this->joinTable(2);
    }

    function getListlimitPage($where, $fields = "*", $limit, $offset, $order, $type = 2) {
        $this->tables = array(
            'cp_collect' => 'cc',
            'cp_article' => 'ca',
        );
        $this->fields = 'count(*)';
        $this->where = $where . " and cc.article_id=ca.id";
        $this->total = $this->joinTable(3);
        if ($this->total) {
            $this->limit = $limit;
            $this->offset = $offset;
            $this->order = $order;
            $this->fields = $fields;
            return $this->joinTable($type);
        }
    }

    function getCount($uid) {
        $this->tables = array(
            'cp_collect' => 'cc',
            'cp_article' => 'ca',
        );
        $this->fields = "count(*)";
        $this->where = "uid=$uid  and cc.article_id=ca.id";
        return $this->total = $this->getResult(3);
    }

    function getCountss($uid) {
        $this->tables = array(
            'cp_collect' => 'cr',
            'cp_article' => 'ca'
        );
        $this->fields = "count(*)";
        $this->where = "cr.uid=$uid and cr.article_id=ca.id and cr.parentid!=0";
        return $this->total = $this->joinTable(3);
    }

    function getListlimitPages($where, $fields = "*", $type = 2) {
        $this->tables = array(
            'cp_collect' => 'cc',
            'cp_article' => 'ca',
        );
        $this->fields = 'count(*)';
        $this->where = $where . " and cc.article_id=ca.id";
        $this->total = $this->joinTable(3);
    }

    function getCountsss($where) {
        $this->tables = array(
            'cp_collect' => 'cr',
            'cp_article' => 'ca'
        );
        $this->fields = "cr.category_id,cr.category_name";
        $this->where = $where;
        $res = $this->joinTable(2);

        foreach ($res as $key => $val) {
            foreach ($val as $k => $v) {
                if ($val[category_id] == $v) {
                    $res[$key][total] += 1;
                }
            }
        }
        $item = array();
        foreach ($res as $k => $v) {
            if (!isset($item[$v['category_id']])) {
                $item[$v['category_id']] = $v;
            } else {
                $item[$v['category_id']]['total']+=$v['total'];
            }
        }
        return $item;
    }
    /**
     * 更新用户表collect
     */
    function updateCpllect($ufields, $where) {
        $this->ufields = $ufields;
        $this->where = $where;
        return $this->update();
    }
     /**
     * 查询用户表collect是否存在收藏的过的uid
     */       
    function getCollect($where) {
        $this->where = $where;
        $this->fields = '*';
        return $this->getResult(1);
    }
}

?>
