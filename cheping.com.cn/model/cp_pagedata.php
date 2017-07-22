<?php
  /**
  * page_data
  * $Id: cp_pagedata.php 1997 2016-04-08 09:33:33Z wangchangjiang $
  */
  
  class cp_pageData extends model{

    var $popcar=array(
            "1"=>array("type_name"=>"微型车",
                       "top10"=>array(
                              0=>array(
                                  "id"=>""
                              )
                            )
                        )
    );

    function __construct(){
      parent::__construct();
      $this->table_name = "page_data";
    }
    
    function getData($id){
      $this->fields = "*";
      $this->where = "id='{$id}'";
      return $this->getResult();
    }
    
    function getAllData(){
      return $this->getResult(2);
    }
    
    /**
    * val = array(
    *   'name',
    *   'value',
    *   'c1',
    *   'c2',
    *   'c3'
    * );
    * 
    * @param mixed $val
    */
    function addPageData($val, $len = 9){
      $index_video = $this->getPageData($val);
      $data = unserialize($index_video['value']);
      $data_vl = count($data);
      $this->ufields = array(
        'name' => $val['name'],
        'c1' => $val['c1'],
        'c2' => $val['c2'],
        'c3' => $val['c3'],
        'updated' => $this->timestamp,
      );
      
      if(!$data){
        $this->ufields['value'] = serialize(array($val['value']));
        $this->ufields['created'] = $this->timestamp;
        $ret = $this->insert();
      }else{
        $tmp = $data;
        $data = $this->addPdValue($data, $val['value']);
        if($data == $tmp){
          if($data_vl >= $len){
            array_pop($data);
          }
          array_unshift($data, $val['value']);
          $this->ufields['value'] = serialize($data);
        }else{
          $this->ufields['value'] = serialize($data);
        }
        
        $this->where = "name='{$val['name']}' and c1='{$val['c1']}' and c2='{$val['c2']}' and c3='{$val['c3']}'";
        $ret = $this->update();
      }
      return $ret;
    }
    
    function getPageData($val, $cached = true){
      global $_cache;
      $cache_key = $val['name'] . $val['c1'] . $val['c2'] . $val['c3'];
      $ret = $_cache->getCache($cache_key);
      
      if(is_numeric($cached) && $cached > 0){
        $cache_time = $cached;
      }else
      $cache_time = M_STORE_TIME;
      
      if(!$ret || !$cached){
        $this->where = "name='{$val['name']}' and c1='{$val['c1']}' and c2='{$val['c2']}' and c3='{$val['c3']}'";
        $this->fields = "*";
        $row = $this->getResult();
        $_cache->writeCache($cache_key, $row, $cache_time);
        $ret = $row;
      }else{
        /*echo "used cache";*/
      }
      return $ret;
    }
    
    /**
    * 返回指定内容中数组的第一个元素
    * 默认应该为ID
    * 
    * @param mixed $pd
    * @return mixed
    */
    function getPdValueId($pd){
      $pdvalue = unserialize($pd);
      $ret = array();
      foreach ($pdvalue as $k => $v) {
        $ret[] = array_shift($v);
      }
      return $ret;
    }
    
    function addPdValue($data, $val){
      $ret = array();
      foreach ($data as $k => $v) {
        if($v['name'] == $val['name']){
          $ret[] = $val;
        }else{
          $ret[] = $v;
        }
      }
      return $ret;
    }
    
    function checkPdValue($data, $val){
      foreach ($data as $k => $v) {
        if($v['id'] == $val['id']){
          return true;
        }
      }
      return false;
    }
    
    function delPdValue($val){
      $ret = array();
      $pd = $this->getPageData($val);
      $pdvalue = unserialize($pd['value']);
      foreach ($pdvalue as $k => $v) {
        if($v['id'] != $val['id']){
          $ret[] = $v;
        }
      }
      $this->where = "name='{$val['name']}' and c1='{$val['c1']}' and c2='{$val['c2']}' and c3='{$val['c3']}'";
      $this->ufields = array(
        'value' => serialize($ret),
        'updated' => $this->timestamp
      );  
      $r = $this->update();
      return $r;
    }
    /**
     * 获得图片热门车系搜索
     */
    function  getSeriesHot(){
        $this->fields="name,value";
        $this->where = "name='serieshot'";
        $aaa = $this->getResult();
        if($aaa){
            $arr = unserialize($aaa[value]);
            foreach($arr[0] as $key=>$value){
            $this->table_name = "cardb_series";
            $this->fields = "series_name,brand_name,series_id,brand_id";
            if($value[series]){
                 $this->where = "series_id=$value[series]";
            }else{
                 $this->where = "brand_id=$value[brand]";
            }  
            $ret = $this->getResult();
            $result[$key][brand_name] = $ret[brand_name];
            $result[$key][series_name] = $ret[series_name];
            $result[$key][series_id] = $ret[series_id];
            $result[$key][brand_id] = $ret[brand_id];   
            $result[$key][name] = $value[name];
            $result[$key][link] = $value[link];
             
           }
        }
      
       $this->table_name = "page_data";
       return $result;
    }

    function getSomePagedata($fields,$where,$flag){
        $this->fields = $fields;
        $this->where = $where;
        $res = $this->getResult($flag);
        if($res)
            return $res;
        else
            return false;
    }
    
  }
?>
