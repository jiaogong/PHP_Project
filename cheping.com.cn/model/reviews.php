<?php

/**
 * cntv reviews interface
 * $Id: reviews.php 2748 2016-05-27 09:46:51Z wangqin $
 */
class reviews extends model {

    var $total;

    function __construct() {
        $this->table_name = "cp_review";
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

    /**
     * 查询review表  根据id查找
     * */
    function getTag($id) {
        $this->where = "id={$id}";
        $this->fields = '*';
        return $this->getResult(1);
    }

//    /**
//     * 根据uid查询review表里面的id
//     * */
//    function getTags($uid) {
//        $this->where = "uid={$uid}";
//        $this->fields = '*';
//        return $this->getResult(2);
//    }
    function getTags($fields = '*', $uid, $type = 2) {
        $this->where = "uid={$uid}";
        $this->fields = $fields;
        return $this->getResult($type);
    }

//    /**
//     * 根据uid查询review表里面的id
//     * */
//    function getTags($uid) {
//        $this->where = "uid={$uid}";
//        $this->fields = '*';
//        return $this->getResult(2);
//    }

    /**
     * 根据uid查询review表里面的id
     * */
    function getParent($where) {
//        $this->where = $where;
//        $this->fields = '*';
//        return $this->getResult(2);
        $this->tables = array(
            'cp_review' => 'cr',
            'cp_user_profiles' => 'cup',
        );
        $this->order = 'id desc';
        $this->where = $where;
        $this->fields = 'cup.avatar,cr.*';
        $res = $this->joinTable(2);
        return $res;
    }

    /**
     * 联表查询我回复的文章评论
     * */
    function getReview($where,$order=array()) {
        $this->tables = array(
            'cp_review' => 'cr',
            'cp_user_profiles' => 'cup',
        );

        $this->where = $where;
        $this->order = $order;
        $this->fields = 'cup.avatar,cr.*';
        $res = $this->joinTable(2);
        return $res;
    }

    /**
     * 联表查询其他人对文章的回复
     * */
    function getoReview($where) {
        $this->tables = array(
            'cp_review' => 'cr',
            'cp_user_profiles' => 'cup',
        );
        $this->order = 'id desc';
        $this->where = $where;
        $this->fields = 'cup.avatar,cr.*';
        $res = $this->joinTable(1);
        return $res;
    }

    /**
     * 联表查询其他人对文章的回复
     * */
    function getaReview($where) {
        $this->where = $where;
        $this->fields = 'id';
        $res = $this->getResult(2);
        return $res;
    }

    /**
     * 联表查询我发出的评论
     * $where  条件
     * $filed  需要的字段
     * */
    function getownReview($where, $filed) {
        $this->tables = array(
            'cp_review' => 'cr',
            'cp_user_profiles' => 'cup',
            'cp_article' => 'ca',
        );

        $this->where = $where;
        $this->fields = $filed;
        $res = $this->joinTable(2);
        return $res;
    }

    /**
     * 联表查询
     * */
    function getPriceAndModelA($where, $limit = 20, $offset = 0, $order = array(), $type = 2) {
        $this->tables = array(
            'cp_review' => 'cr',
            'cp_user' => 'cu',
        );
        $this->where = $where;
        $this->fields = "count(cr.id)";
        $this->total = $this->joinTable(3);

        $this->where = "$where";
        $this->fields = "cr.*,cu.username";
        $this->order = $order;
        $this->limit = $limit;
        $this->offset = $offset;
        $res = $this->joinTable($type);
        if ($res) {
            foreach ($res as $key => $value) {
                $this->where = "cr.uid=cu.id and cr.type_id in(1,2) and cr.parentid=$value[id]";
                $this->limit = 0;
                $child = $this->joinTable($type);
                $res[$key][child] = $child;
            }
        }

        if ($res)
            return $res;
        else
            return false;
    }

    function getPrice($where, $order = array(), $type = 2) {
        $this->tables = array(
            'cp_review' => 'cr',
            'cp_user' => 'cu',
        );

        $this->where = "$where";
        $this->fields = "cr.*,cu.username,cu.id cuid";
        $this->order = $order;

        $res = $this->joinTable($type);
        if ($res) {
            foreach ($res as $key => $value) {
                $this->where = "cr.uid=cu.id and cr.type_id='$value[type_id]' and cr.parentid='$value[id]'";
                $this->limit = 0;
                $child = $this->joinTable($type);
                $res[$key][child] = $child;
            }
        }
        if ($res)
            return $res;
        else
            return false;
    }

    /**
     * 联表查询 用户,文章,评论
     * */
    function getAppPrice($where, $order = array(), $type = 2, $offset = Null, $limit = Null) {
        $this->tables = array(
            'cp_article' => 'ca',
            'cp_review' => 'cr',
            'cp_user' => 'cu',
        );
        $this->where = "$where";
        $this->fields = "cr.*,cu.username,cu.id cuid";
        $this->order = $order;
        if ($offset)
            $this->offset = $offset;
        if ($limit)
            $this->limit = $limit;
        $res = $this->joinTable($type);

        if ($res) {
            foreach ($res as $key => $value) {
                $this->where = "cr.article_id=ca.id and cr.article_id='$value[article_id]' and cr.type_id='$value[type_id]' and cr.uid=cu.id and cr.parentid='$value[id]' and cr.state=1 and ca.state=3";
                if ($offset)
                    $this->offset = $offset;
                if ($limit)
                    $this->limit = $limit;
                $child = $this->joinTable($type);
                $res[$key]['child'] = $child;
            }
        }
        if ($res)
            return $res;
        else
            return false;
    }

    /**
     * 联表查询 用户,文章,评论
     * */
    function getReviews($where, $type = 2) {
        $this->tables = array(
            'cp_article' => 'cpa',
            'cp_review' => 'cpr',
            'cp_user_profiles' => 'cpu',
        );
        $this->where = "$where";
        $this->fields = "cpr.*,cpu.username,cpu.id cuid,cpu.avatar";
//        $this->order = $order;
        $res = $this->joinTable($type);
//        if ($res) {
//            foreach ($res as $key => $value) {
//                $this->where = "cpr.article_id=ca.id and cpr.article_id='$value[article_id]' and cpr.type_id='$value[type_id]' and cpr.uid=cu.id and cr.parentid='$value[id]' and cr.state=1 and ca.state=3";
//                if ($offset)
//                    $this->offset = $offset;
//                if ($limit)
//                    $this->limit = $limit;
//                $child = $this->joinTable($type);
//                $res[$key]['child'] = $child;
//            }
//        }
        if ($res)
            return $res;
        else
            return false;
    }

    function getList($where, $fields = "*", $type = 2, $offset = Null, $limit = Null) {
        $this->where = $where;
        $this->fields = "count(*)";
        return $this->total = $this->getResult(3);

        $this->where = $where;
        $this->fields = $fields;
        if ($offset)
            $this->offset = $offset;
        if ($limit)
            $this->limit = $limit;
        return $this->getResult($type);
    }

    function delList($where) {
        $this->where = $where;
        return $this->del();
    }

    function getListlimit($where, $fields = "*", $limit, $offset, $order, $type = 2) {
        $this->tables = array(
            'cp_review' => 'cr',
            'cp_article' => 'ca'
        );
        $this->limit = $limit;
        $this->offset = $offset;
        $this->order = $order;
        $this->where = $where . " and cr.article_id=ca.id";
        $this->fields = $fields;
        return $this->joinTable($type);
    }

    function getListlimitPage($where, $limit, $offset, $order, $type = 2) {
        $this->tables = array(
            'cp_review' => 'cr',
            'cp_article' => 'ca'
        );
        $this->fields = 'count(cr.id) count';
        $this->where = $where;
        $this->total = $this->joinTable(2);
        $this->fields = "cr.id crid,cr.content,cr.created,ca.id caid,ca.title,ca.uptime,ca.type_id,cr.state";
        $this->limit = $limit;
        $this->offset = $offset;
        $this->order = $order;
        return $this->joinTable($type);
    }

    function getCount($uid, $where) {
        $this->tables = array(
            'cp_review' => 'cr',
            'cp_article' => 'ca'
        );
        $this->fields = "count(*)";
        $this->where = "cr.uid=$uid  and cr.article_id=ca.id" . $where;
        return $this->total = $this->getResult(3);
    }

    function getCounts($uid) {
        $this->tables = array(
            'cp_review' => 'cr',
            'cp_article' => 'ca'
        );
        $this->fields = "count(*)";
        $this->where = "cr.uid=$uid and cr.article_id=ca.id";
        return $this->total = $this->joinTable(3);
    }

    function getCountss($where) {
        $this->tables = array(
            'cp_review' => 'cr',
            'cp_article' => 'ca'
        );
        $this->fields = "count(cr.id)";
        $this->where = $where;
        return $this->total = $this->joinTable(3);
    }

    function getCountsss($where, $limit, $offset, $order, $type = 2) {
        $this->tables = array(
            'cr' => 'cp_review',
            'cre' => 'cp_review',
            'ca' => 'cp_article'
        );
        $this->fields = 'count(cre.id) count';
        $this->where = $where;
        $this->total = $this->joinTable(2, 1);

        $this->fields = "cre.id creid,cre.content,cre.created,cre.uname,cr.id crid,ca.id caid,ca.title,ca.type_id,ca.uptime,cre.state,cr.state";
        $this->limit = $limit;
        $this->offset = $offset;
        $this->order = $order;
        return $this->joinTable($type, 1);
    }

    /**
     * 联表查询
     * */
    function getApp($where, $fields, $order = array(), $type = 2) {
        $this->tables = array(
            'cp_review' => 'cr',
            'cp_user' => 'cu',
            'cp_article' => 'ca',
        );
        $this->where = $where;
        $this->fields = $fields;
        $this->order = $order;
        $res = $this->joinTable($type);

        if ($res)
            return $res;
        else
            return false;
    }

}

?>
