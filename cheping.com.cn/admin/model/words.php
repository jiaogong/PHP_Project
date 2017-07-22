<?php

/**
 * cntv reviews interface
 * $Id: words.php 41 2015-06-19 10:05:24Z cuiyuanxin $
 */
class words extends model {
    
    function __construct() {
        $this->table_name = "cp_badwords";
        parent::__construct();
    }
    
    function getBadwords($where='1', $fields = "*", $type =1){
        $this->where = $where;
        $this->fields = $fields;
        return $this->getResult($type);
    }
    
}

?>
