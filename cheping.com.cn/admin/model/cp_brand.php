<?php
  /**
  * brand
  * $Id: cp_brand.php 1789 2016-03-24 08:39:22Z wangchangjiang $
  */
  
  class cp_brand extends model{
    var $brand_import = array(
      1 => '自主',
      2 => '美系',
      3 => '日系',
      4 => '欧系',
      5 => '韩系',
    );
    function __construct(){
      parent::__construct();
      $this->table_name = "cardb_brand";
    }
    /**
     * 
     * @param String $fields
     * @param String $where
     * @param Int $flag 1.getRow 2.getAll 3.getOne 4.getAssoc
     * @param Array $order 
     * @param Int $limit
     * @return Mixed $result
     */
    function getBrands($fields, $where, $flag, $order = '', $limit = 1) {
        $this->fields = $fields;
        $this->where = $where;
        $this->order = $order;
        $this->limit = $limit;
        $result = $this->getResult($flag);
        return $result;
    }
    function getAllBrand($where = '1', $order = array(), $limit = 1, $offset = 0){
      $this->where = $where;
      $this->fields = "count(brand_id)";
      $this->total = $this->getResult(3);
      
      $this->fields = "*";
      $this->limit = $limit;
      $this->offset = $offset;
      if(!empty($order))
       $this->order = $order;
       
      return $this->getResult(2);
    }    
  //==============================
    
    function getBrand($id){
      $this->fields = "*";
      $this->where = "brand_id='{$id}' and state=3";
      return $this->getResult();
    }
    
    function getBrandByName($brand_name){
      $this->where = "brand_name='{$brand_name}' and state=3";
      $this->fields = "*";
      return $this->getResult();
    }
    

    function upDataState($state,$id){
        //修改品牌状态
        $this->ufields = array('state' => $state);
       $this->where=" brand_id ='".intval($id)."'";
       $this->update();
       //修改factory状态
       $f=new factory();
       $f->ufields = array('state' => $state);
       $f->where = $this->where;
       $f->update();
       //修改车系状态
       $s=new series();
       $s->ufields = array('state' => $state);
       $s->where = $this->where;
       $s->update();
       //修改车款状态
       $m=new cardbModel();
       $m->ufields = array('state' => $state);
       $m->where = $this->where;
       $m->update();
       
       return 1;
    }

    function getDatabyState($state){
        $this->fields = "count(*) as sum";
        $this->where ="1 and state='$state'";
        return $this->getResult(3);
    }

    function getData($state){
        $this->fields = "brand_id as id,brand_name as name";
        $this->where ="1 and state='$state'";
        return $this->getResult(2);
    }
    function getBrandlist($fields,$where,$flag){
        $this->fields = $fields;
        $this->where = $where;
        return $this->getResult($flag);
    }
    
    
  }
?>
