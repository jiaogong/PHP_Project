<?php
/**
 * 
 * $Id: type.php 51 2013-01-09 11:19:57Z yizhangdong $
 */
class Type extends model{
    function  __construct() {
        $this->table_name = "cardb_type";
        parent::__construct();
    }
    
    function getType($id){
      $this->fields = "*";
      $this->where = "type_id='{$id}'";
      return $this->getResult();
    }

    function getAllType(){
      global $_cache;
      $key="type";
      $type=$_cache->getCache($key);
      if($type){
          return $type;
      }else{
      $this->fields = "*";
      $this->where = '1';
      $type = $this->getResult(2);
      $_cache->writeCache($key,$type,7200);
      return $type;
      }
    }
    
    function getTypeAssoc(){
      global $_cache;
      $cache_key = "type_assoc";
      $cache_time = 12*3600;
      $type = $_cache->getCache($cache_key);
      if(!$type){
        $this->fields = "type_id, type_name";
        $type = $this->getResult(4);
      }
      return $type;
    }
    //È¥µôÀ¨ºÅÀïÃæ×Ö·û´®
    function getTypearr($alltype){
        foreach ($alltype as $key => $value) {
            $tem=explode("£¨", $value["type_name"]);
            $alltype[$key]["type_name"]=$tem[0];
        }
        return $alltype;
    }
    
}
?>
