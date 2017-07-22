<?php
  /**
  * cardb type model
  * $Id: cardbpromotion.php 1792 2016-03-28 01:59:03Z wangchangjiang $
  * @author David.Shaw
  */
  
  class cardbpromotion extends model{
    function __construct(){
      parent::__construct();
      $this->table_name = "cardb_promotion";
    }
    
   function getWhereList($fields,$where,$flag){
       $this->where =$where;
       $this->fields =$fields;
       $result = $this->getResult($flag);
       return $result;
   }
   function getPromotionList($where,$order,$offset = 0,$limit = 1){
        $this->fields ="*";
        $this->where =$where;
        $this->limit = $limit;
        $this->offset = $offset;
        if (!empty($order))
            $this->order = $order;
        $resutl = $this->getResult(2);
        
        return $resutl;
   }
  }
?>
