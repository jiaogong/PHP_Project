<?php

/**
 * cntv reviews interface
 * $Id: collect.php 77 2015-07-10 07:12:32Z yinliuhui $
 */
class collect extends model {
    var $total;
    function __construct() {
        $this->table_name = "cp_collect";
        parent::__construct();
    }
    
    function getTagList($where, $fields = "*", $limit = 20, $offset = 0, $order = array(), $type = 2){
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
    

    
    function getList($fields = "*",$where,  $type = 2){
        $this->where = $where; 
        $this->fields = $fields ;
        return $this->getResult($type);
    }
    
    
}

?>
