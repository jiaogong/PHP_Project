<?php
class dealerPrice extends model {
    function __construct() {
        parent::__construct();
        $this->table_name = 'dealer_price';
    }
    /**
    * 获取报价信息
    * 
    * @param str $fields  sql fields
    * @param str $where   sql where
    * @param str $type    1 getrow, 2 getall, 3 getone, 4 getassoc
    * @return $result
    */
    function getDprice($fields, $where, $type = 1) {
        $this->fields = $fields;
        $this->where = $where;
        $result = $this->getResult($type);
        return $result;
    }

}
?>
