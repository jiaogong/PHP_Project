<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 * 投票 model
 */

class vote extends model {

    function __construct() {
        $this->table_name = "cp_vote";
        parent::__construct();
    }

//    function getCount($where = '1') {
//        $this->where = $where;
//        $this->fields = "count(id)";
//        return $this->getResult(3);
//    }
//    
//    function getList($fields,$where,$flag){
//            $this->where = $where;
//            $this->fields = $fields;
//            return $this->total = $this->getResult($flag);
//        }
//
//    function getUser($fields, $where, $flag) {
//        $this->fields = $fields;
//        $this->where = $where;
//        $result = $this->getResult($flag);
//        return $result;
//    }
//
//    function getAllUsers($where = '1', $order = array(), $limit = 1, $offset = 0) {
//        $this->where = $where;
//        $this->fields = "count(id)";
//        $this->total = $this->getResult(3);
//
//        $this->fields = "*";
//        $this->limit = $limit;
//        $this->offset = $offset;
//        if (!empty($order))
//            $this->order = $order;
//
//        return $this->getResult(2);
//    }
//
//    function getUserById($id) {
//        $this->where = "id='{$id}'";
//        $this->fields = "*";
//        return $this->getResult();
//    }
//
//    function getUserByName($username) {
//        $this->where = "username='$username'";
//        $this->fields = "*";
//        $result = $this->getResult();
//        return $result;
//    }
//
//    function getUserByTel($tel) {
//        $this->where = "mobile='$tel'";
//        $this->fields = "*";
//        $result = $this->getResult();
//        return $result;
//    }
//
    function insertUser($ufields) {
        $this->ufields = $ufields;
        return $this->insert();
    }

    function updateUser($ufields, $where) {
        $this->ufields = $ufields;
        $this->where = $where;
        $res = $this->update();
        if ($res) {
            return $res;
        } else {
            return false;
        }
    }



}
