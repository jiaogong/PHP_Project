<?php
/*
 * 
 * $id:$
 */
class Prosinfo extends model{
    function  __construct() {
        $this->table_name = "cardb_prosinfo";
        parent::__construct();
    }

    function getData($type_name="model" , $type_id=0 , $state = 1){
        if(!empty($type_id)){
            $this->fields = "*";
            $this->where = "type_name='$type_name' and type_id='$type_id' and state='$state'";
            return $this->getResult(1);
        }else{
            return "";
        }
    }

    /*
     * 
     */
    function getSeriesSale($series_id){
       return $this->getData("series" , $series_id, $state = 1);
    }
    
}