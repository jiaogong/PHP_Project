<?php
  /**
  * brand
  * $Id: serieslog.php 448 2015-08-07 15:26:23Z xiaodawei $
  */
  
  class seriesLog extends model{
    
    function __construct(){
      parent::__construct();
      $this->table_name = "cardb_serieslog";
    }
    //总数
    function  getListNum($where){
        $this->fields ="count(id)";
        $this->where =$where;
        $result = $this->getResult(3);
        return $result;
    }
    //抓取后的操作记录
    function  getList($where,$offset = 0, $limit = 0){
        $this->fields ="*";
        $this->where =$where;
        $this->order =array("state"=>"asc","update_time"=>"desc",'id'=>"desc");
        if ($offset)
            $this->offset = $offset;
        if ($limit)
            $this->limit = $limit;
        $result = $this->getResult(2);
        return $result;
    }
    /**
     * 根据车系取出在售车款
     * @param type $series_id  
     * @param type $state
     * @return type
     */
    function getModelist($series_id){
        $this->fields = "model_id,series_id,brand_id,model_name,series_name,brand_name,state";
        $this->where ="series_id=$series_id and state=3";
        return $this->getResult(2);
    }
    /**
     * 根据model_id 和状态查看车款是否存在
     * @param $model_id 
     * @param $state
     * @return  $retrun false Description
     */
    function getModelById($model_id,$state){
        $this->fields ="id";
        $this->where ="model_id=$model_id and state=$state";
        return $this->getResult(3);
    }
    /**
     * 程序自动操作停产
     */
    function getAutoStopModel($fields,$where){
        $this->fields = $fields;
        $this->where =$where;
        $result = $this->getResult(2);
        return $result;
    }
      /**
     * 根据内容查找
     */
    function getModelList($fields,$where,$flag){
        $this->fields = $fields;
        $this->where =$where;
        $result = $this->getResult($flag);
        return $result;
    }
  }
?>
