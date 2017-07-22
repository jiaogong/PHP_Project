<?php
  /**
  * cardb color
  * $Id: color.php 2217 2013-08-06 13:58:49Z jiangweiwei $
  */
  
  class color extends model{
    function __construct(){
      $this->table_name = "cardb_color";
      parent::__construct();
    }
    
    function getModelColor($model_id = '', $series_id = '',$order=array()){
      if($model_id && $series_id){
        $this->where = "(type_id='{$model_id}' and type_name='model') or (type_id='{$series_id}' and type_name='series')";
      }elseif($series_id){
        $this->where = "type_id='{$series_id}' and type_name='series'";
      }elseif($model_id){
        $this->where = "type_id='{$model_id}' and type_name='model'";
      }else{
        return false;
      }
      $this->order=$order;
      $this->fields = "*";
      $ret = $this->getResult(2);
      return $ret;
    }

    function getColor($id,$field=Null,$flag=0){
        if($field){
            $this->fields = $field;
        }else{
            $this->fields = "*";
        }
        $this->where = "id=$id";
        if($flag){
             return $this->getResult($flag);
        }else{
            return $this->getResult();
        }
        
    }

    /**
     * 根据提交取值
     */
    function  getColorlist($fields,$where,$flag=0){
        $this->fields = $fields;
        $this->where = $where;
        return $this->getResult($flag);
    }
    
    function getSomeC($fields,$where,$group,$order,$flag){
        $this->fields = $fields;
        $this->where = $where;
        if($group)
            $this->group = $group;
        else
            $this->group = '';
        if($order)
            $this->order = $order;
        else
            $this->order = '';
        $res = $this->getResult($flag);
        if($res)
            return $res;
        else
            return false;
    }
    /**
     * 获取车系外观颜色数据
     * 
     * @param type $where
     * @param type $fields
     * @param type $group
     * @return type
     */
    function getSeriesColorLists($where){
        $this->tables = array(
            'cardb_color' => 'cc',
            'cardb_file' => 'cf'
        );           
        $this->fields = "cc.color_name,cc.color_pic,cc.id,count(cf.pic_color) as total";
        $this->where = $where;
        $this->group = "cf.pic_color";
        return $this->joinTable(2);
    }
  }
?>

