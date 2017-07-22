<?php
/**
* dealerMan
* $Id: dealeradvice.php 1847 2016-04-01 06:52:55Z wangchangjiang $
*/

class dealerAdvice extends model{

  function __construct(){
    $this->table_name = "dealer_advice";
    parent::__construct();
  }

  function getAdviceList($where = '1', $order = array(), $limit = 1, $offset = 0){
      $this->where = $where;
      $this->fields = "count(id)";
      $this->total = $this->getResult(3);
      $this->fields = "*";
      $this->limit = $limit;
      $this->offset = $offset;
      if(!empty($order))
          $this->order = $order;
      return $this->getResult(2);
    }
    function getAdvice($id){
      $this->fields = "*";
      $this->where = "id='{$id}'";
      return $this->getResult();
    }
}
?>