<?php
  /**
  * paramtxt model
  * $Id: paramtxt.php 448 2015-08-07 15:26:23Z xiaodawei $
  * @author David.Shaw
  */
  
  class paramtxt extends model{
    function __construct(){
      parent::__construct();
      $this->table_name = "cardb_paramtxt";
    }
    
    function getParamtxt($id){
      $this->fields = "*";
      $this->where = "id='{$id}'";
      return $this->getResult();
    }
    
    /**
    * put your comment there...
    * 
    * @param string $where
    * @param array $order
    * @param int $limit
    * @param int $offset
    * state=1 选配
    */
    function getAllParamtxt($where = '1', $order = array(), $limit = 1, $offset = 0){
      $this->tables = array(
        'cardb_model' => 'm',
        'cardb_paramtxt' => 'pt'
      );
      
      $this->where = "m.model_id=pt.model_id and " . $where;
      $this->fields = "count(pt.id)";
      $this->total = $this->joinTable(3);
      
      $this->order = $order;
      $this->limit = $limit;
      $this->offset = $offset;
      $this->fields = "pt.*, m.model_name,m.series_name,m.series_id,m.factory_name,m.factory_id,m.brand_name,m.brand_id";
      
      $ret = array();
      $category = new paramType();
      $pcate = $category->getParamTypeAssoc();
      
      $subcate = $this->joinTable(2);
      
      foreach ($subcate as $key => $value) {
        foreach ($pcate as $pk => $pv) {
          $pname = $pcate[$value['pid' . $pk]]['pname'];
          $cname = $pcate[$value['pid' . $pk]]['name'];
        }
        $ret[] = $value;
      }
      return $ret;
    }
    
    /**
    * 标准化参数转文本参数
    * 
    * @param mixed $st
    */
    function st2ParamTxt($st = array()){
      $seq = 3;
      
      $param = new param();
      #$paramtxt = new paramtxt();
      $paramtype = new paramType();
      
      $allparam = $param->getAllParam("pid{$seq}>0", array("pid{$seq}" => "asc", "type_order{$seq}" => "asc"), 200);
      
      $allparamtype = $paramtype->getParamTypeByPid($seq);
      
      $tmp = $tmp1 = $tmp2 = $tmp3 = array();
      foreach ($allparamtype as $key => $value) {
        $tmp[$value['id']] = $value['name'];
      }
      
      foreach ($allparam as $key => $value) {
        $tmp1[$value['id']] = $value['name'];
        $tmp2[$value['pid' . $seq]][] = $value['id'];
        $tmp3[$value['id']] = $value['data_type'];
      }
      
      foreach ($tmp2 as $k => $v) {
        $str = $str2 = '';
        $s1 = $s2 = false;
        foreach ($v as $kk => $vv) {
          $st_name = $tmp1[$vv];
          $st_value = $st['st' . $vv];
          $st_type = $tmp3[$vv];
          
          if($st_value === "选配"){
            $str2 .= $st_name . "：" . $st_value . "\r\n";
          }elseif($st_value !=='无' && $st_value && $st_type > 1){
            $str .= $st_name . "\r\n";
          }elseif($st_value !=='无' && $st_value){
            if($st_value == "标配"){
              $str .= $st_name . "\r\n";
            }else{
              $str .= $st_name . "：" . $st_value . "\r\n";
            }
            
          }
        }
        
        #echo $str . "<br>\n";
        $pname = $tmp[$k];
        $this->ufields = array(
          'value' => $str,
          'pid' => $k,
          'pname' => $pname,
          'pt_id' => 3,
          'model_id' => $st['model_id']
        );
        #if($pname && $str)
        if($pname){
          $s1 = $this->insert();
        }
        
        #选配
        if($pname){
          $this->ufields = array(
            'value' => $str2,
            'pid' => $k,
            'pname' => $pname,
            'pt_id' => 3,
            'model_id' => $st['model_id'],
            'state' => 1
          );
          $s2 = $this->insert();
        }
      }
      return $s2 || $s1;
    }
    
    function getParamtxtByModel($model_id){
      $this->fields = "*";
      $this->where = "model_id='{$model_id}'";
      $ret = $this->getResult(2);
      return $ret;
    }
    
    function getModelTxtCount($model_id){
      $this->fields = "count(model_id)";
      $this->where = "model_id='{$model_id}'";
      $ret = $this->getResult(3);
      return $ret;
    }
    
  }  
?>
