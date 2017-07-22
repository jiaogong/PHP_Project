<?php

/* 
页面下方友链列表model
 *$Id: friend.php 970 2015-10-29 04:09:08Z caolin$
 * @author caolin
 */
class friend extends model {

    function __construct() {
        $this->table_name = "cp_friendlink";
        parent::__construct();
    }
  //根据条件获取所有数据
    function getfriend($fields = "*", $where, $type = 2) {
        $this->fields = $fields;
        $this->where = $where;

        $res = $this->getResult($type);
        if ($res)
            return $res;
        else
            return false;
    }
    //显示列表所有数据
    function getAllFriendLink($where="1",$fields="*",$type=2) {
        $this->fields = $fields;
        $this->where = $where;
        $this->order = $order;
        return $this->getResult($type);
    }
}