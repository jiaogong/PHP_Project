<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class cp_friendlink extends model{
        function __construct() {
            $this->table_name = "cardb_friendlink";
            parent::__construct();
        }

        function getFriendLink($ufields,$where,$type){
            $this->fields = $ufields;
            $this->where = $where;
            $this->order = array('queen'=>'asc');
            $result = $this->getResult($type);
            return $result;
        }

}