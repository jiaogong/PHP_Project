<?php

class forum extends model {

    function __construct() {
        parent::__construct();
        $this->table_name = "cp_forum";
    }

    function getSelect($field = '*', $where = 1, $type = 2) {
        var_dump($field);
//        $this->reset();
        $this->field = $field;
        $this->where = $where;
        $res = $this->getResult($type);
        echo $this->sql;
        if($res){
            return $res;
        }else{
            return FALSE;
        }
    }
}
?>
