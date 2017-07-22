<?php
  /**
  * 参数分类组
  * $Id: seriessetting.php 2977 2013-10-10 11:34:16Z yinliuhui $
  *
  */
  
  class seriessetting extends model{
    
    function __construct(){
      $this->table_name = "cardb_series_settings";
      parent::__construct();
    }

    
    function getSettingList($fields, $where,$flag=2){
        $this->where = $where;
        $this->fields = $fields;
        $result = $this->getResult($flag);
        return $result;
    }
   
  }
?>
