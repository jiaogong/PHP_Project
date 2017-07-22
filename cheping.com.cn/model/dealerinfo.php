<?php
class dealerinfo extends model {
    function __construct() {
        parent::__construct();
        $this->table_name = 'dealer_info';
    }

    function getOneDealer($fields, $where) {
        $this->fields = $fields;
        $this->where = "state<>1 and " . $where;
        $result = $this->getResult();
        return $result;
    }

	function getDealerInfo($fields, $where,$flag=null){
        $this->where = $where;
        $this->fields = $fields;
        if($flag){
           $return = $this->getResult($flag);
        }else{
             $return = $this->getResult();
        }
        return $return;
    }
}
?>
