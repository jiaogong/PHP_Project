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

    function getCount($fields,$where,$type=2) {
        $this->where = $where;
        $this->fields = $fields;
        return $this->getResult($type);
    }
    
    function getUser($limit = 20, $offset = 0){
        $this->tables = array(
            'cp_vote' => 'cv',
            'cp_user' => 'cu',
            'cp_user_profiles' => 'cup'
        );
        $this->fields = "count(cv.id) count";
        $this->where = "cv.uid=cu.id and cv.uid=cup.uid";
        $this->total = $this->joinTable(3);
        
        $this->fields = "cv.id,cv.uid,cv.shouji,cu.realname,cu.email,cu.gender,cup.birthday,cup.address,cup.zipcode,cup.number";
        $this->where = "cv.uid=cu.id and cv.uid=cup.uid GROUP BY cv.uid";
        $this->limit = $limit;
        $this->offset = $offset;
        return $this->joinTable(2);
    }
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
