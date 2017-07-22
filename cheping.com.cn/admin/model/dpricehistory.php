<?php
class dpriceHistory extends model {
    function __construct() {
        parent::__construct();
        $this->table_name = 'dprice_history';
    }
    /**
    * 获取报价历史
    * 
    * @param str $fields  sql fields
    * @param str $where   sql where
    * @param str $type    1 getrow, 2 getall, 3 getone, 4 getassoc
    * @return $result
    */

    function getAllPrice($where = 1, $order = array(), $limit, $offset){
    $this->where = $where;
    $this->fields = "count(id)";
    $this->total = $this->getResult(3);

    $this->fields = "*";
    $this->order = $order;
    $this->limit = $limit;
    $this->offset = $offset;

    return $this->getResult(2);
  }
    function getDpriceHistory($fields, $where, $type = 1) {
        $this->fields = $fields;
        $this->where = $where;
        $result = $this->getResult($type);
        return $result;
    }   
    
    function insertDpriceHistory($ufields) {
        $this->ufields = $ufields;
        return $this->insert();
    }
}
?>
