<?php

/**
 * cntv reviews interface
 * $Id: badword.php 621 2015-08-21 09:34:19Z cuiyuanxin $
 */
class badword extends model {
    var $total;
    function __construct() {
        $this->table_name = "cp_badwords";
        parent::__construct();
    }
    
 
    function getList($fields = "*", $where,  $type = 2){
        $this->where = $where; 
        $this->fields = $fields ;
        return $this->getResult($type);
    }
    
    
}

?>
