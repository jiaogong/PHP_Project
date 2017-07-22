<?php
  /**
  * factory
  * $Id: factory.php 2422 2013-08-13 06:49:10Z yinliuhui $
  */

  class factory extends model{
    function __construct(){
      $this->table_name = "cardb_factory";
      parent::__construct();
    }

    function getFactory($id, $state = '3'){
      $this->fields = "*";
      $this->where = "factory_id='{$id}'" . ($state < 0 ? "" : " and state='{$state}'");
      return $this->getResult();
    }

    //取出所有厂商
    function getAllfactory(){
        global $_cache;
        $this -> reset();
        $key = "factory";
        $factory = $_cache->getCache($key);
        if($factory){
            return $factory;
        }else{
            $this->fields = "*";
            $this->where = "state='3'";
            $factory=$this->getResult(2);
            $_cache->writeCache($key,$factory,7200);
            return $factory;
        }
    }
     /**
      * 取出品牌下的厂商下的车系的图片
      * @param type $brand_id 品牌id
      * @return array Description
     */
    function getFactoryByBrand($brand_id){
         global $_cache;
        $chache_key = "brand_pic_$brand_id";
        $brand = $_cache->getCache($chache_key);
        if ($brand) {
            return $brand;
        } else {
            $result = array();
            $this->table_name = "cardb_model";
            $this->fields = "series_id,series_name,factory_name,brand_name,brand_id,factory_id";
            $this->where ="brand_id=$brand_id and state=3";
            $this->group ="series_id";
            $result = $this->getResult(2);
            if($result){
               foreach($result as $key=>$value){
                    $this->table_name = "cardb_file";
                    $this->fields = "*";
                    $this->where = "s1={$value[series_id]} and ppos<900";
                    $this->order = array('pos'=>'asc','ppos'=>'asc');
                    $this->group ="";
                    $image = $this->getResult(2);
                    $series_number = count($image);
                    if($image){
                        $result[$key][create] = $image[0][created];
                        $result[$key][image] = $image[0][name];
                        $result[$key][model_id] = $image[0][type_id]; 
                    }else{
                        $result[$key][create] = 0;
                        $result[$key][image] = 0;
                        $result[$key][model_id] = 0; 
                    }
                    $result[$key][number] = $series_number;
                    
                   }
                   foreach($result as $kk=>$vv){
                       $return[$vv[factory_name]][factory][] = $vv;
                       $return[$vv[factory_name]]['factory_number'] += $vv[number];
                   }
    
               }
                $_cache->writeCache($chache_key, $return, 24*3600); 
                return $return;
            }
            
       
    }

    function getAllFactoryByBrand($brandId,$fields){
        $this->order = '';
        $this->group = '';
        $this->where = "brand_id=$brandId and state=3";
        $this->fields = $fields;
        $res = $this->getResult(2);
        if($res)
          return $res;
        else
          return false;
    }

  }

?>