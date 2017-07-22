<?php
  /**
  * model
  * $Id: colormodel.php 245 2013-03-26 13:11:15Z yanhongwei $
  */
class colormodel extends model{
    //获取所有车辆名称，ID
    function __construct(){
      parent::__construct();
      $this->table_name = "cardb_model";
    }
    function getModelColor($where='1',$order=array(),$limit=1,$offset=0){
      $this->where = $where;
      $this->fields = "count(series_id)";
      $this->total = $this->getResult(3);
      $this->fields = "*";
      $this->where = $where;
      $this->limit=$limit;
      $this->offset = $offset;
      return $this->getResult(2);
    }
}
?>
