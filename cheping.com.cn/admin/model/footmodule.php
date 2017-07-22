<?php
  /**
  * $Id: footmodule.php 2 2015-06-03 04:39:17Z xiaodawei $
  */
  
  class footmodule extends model{
    function __construct(){
      parent::__construct();
      $this->table_name = "foot_module";
    }

    function getAllModule(){
        $this->fields = "*";
        return $this->getResult(2);
    }

    function getModule($id){
      $this->fields = "*";
      $this->where = "id='{$id}'";
      return $this->getResult();
    }
    
  }
?>
