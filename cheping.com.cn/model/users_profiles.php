<?php

/**
 * 用户扩展信息model
 * $Id: users_profiles.php 2748 2016-05-27 09:46:51Z wangqin $
 * @author David Shaw <tudibao@163.com>
 */
class users_profiles extends model {

    function __construct() {
        $this->table_name = "cp_user_profiles";
        parent::__construct();
    }

    function addUser($ufields) {
        $this->ufields = $ufields;
        return $this->insert();
    }

    function updateUser($ufields, $where) {
        $this->ufields = $ufields;
        $this->where = $where;
        return $this->update();
    }

    /* 查询
     * $where 条件
     * fields 查询的字段
     * $flag 查询的条数 1是单条 2是多条
     * return 查询的结果姐
     */
    function getUsers($uid) {
        $this->fields = "*";
        $this->where = "uid=".$uid;
        return $this->getResult();
    }
      /* 查询
     * $where 条件
     * fields 查询的字段
     * $flag 查询的条数 1是单条 2是多条
     * return 查询的结果姐
     */
    function getUser($fields, $where, $flag) {
        $this->fields = $fields;
        $this->where = $where;
        return $this->getResult($flag);
    }

}

?>
