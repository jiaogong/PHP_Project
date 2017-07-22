<?php

/*
 * friend Model   2015.10.27 13:51 wangqin
 * friend.php 友情链接Model
 */

class friend extends model {

    function __construct() {
        $this->table_name = "cp_friendlink";
        parent::__construct();
    }
    /**
     * 根据条件获取所有数据
     * @param string $fields
     * @param string $where
     * @param int $type
     * @return boolean
     */
    function getfriend($fields = "*", $where, $type = 2) {
        $this->fields = $fields;
        $this->where = $where;

        $res = $this->getResult($type);
        if ($res)
            return $res;
        else
            return false;
    }
    /**
     * 显示列表所有数据
     * @param int $where
     * @param sting $fields
     * @param int $type
     * @return int
     */
    function getAllFriendLink($where="1",$fields="*",$type=2) {
        $this->fields = $fields;
        $this->where = $where;
        $this->order = $order;
        return $this->getResult($type);
    }
}
