<?php
  /**
  * 参数分类组
  * $Id: seriesloan.php 3144 2013-10-25 12:29:42Z yinliuhui $
  *
  */
  
  class seriesloan extends model{
    
    function __construct(){
      $this->table_name = "cardb_series_loan";
      parent::__construct();
          
    }

    function getLoanList($fields, $where,$flag=2){
        $this->where = $where;
        $this->fields = $fields;
        $result = $this->getResult($flag);
        return $result;
    }
   
  }
?>
