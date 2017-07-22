<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class ibuycarsalecar extends model {

    function __construct() {
        $this->table_name = DBNAME2.".page_data";
        parent::__construct();
    }

	function getList($fields, $where, $flag) {
        $this->fields = $fields;
        $this->where = $where;
        return $this->getResult($flag);
    }
	
    function getSomePagedata($fields,$where,$flag){
        $this->fields = $fields;
        $this->where = $where;
        $res = $this->getResult($flag);
        if($res)
            return $res;
        else
            return false;
    }
  
}

?>
