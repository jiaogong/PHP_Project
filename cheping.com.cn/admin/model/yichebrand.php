<?php

/* 
 * yiche brand
 * @author David Shaw <tudibao@163.com>
 * $Id: yichebrand.php 1792 2016-03-28 01:59:03Z wangchangjiang $
 */

class yicheBrand extends model{
    var $brand;
    function __construct() {
        parent::__construct();
        $this->table_name = "yiche_brand";
        $this->brand = new brand();
    }
    
    function getBrand($id){
        $this->fields = "*";
        $this->where = "id='{$id}'";
        return $this->getResult();
    }
    
    function getBrandByName($brand_name){
        $brand_name = trim($brand_name);
        $this->fields = "*";
        $this->where = "yc_brandname='{$brand_name}'";
        return $this->getResult();
    }
    
    function getList(){
        $this->fields = "*";
        $this->where = "yc_brandname<>''";
        $this->order = array('id' => 'asc');
        return $this->getResult(2);
    }
    
    /**
     * 更新/插入易车品牌表
     * 
     * @param type $brand 含有品牌数据的数组
     * @return mix 返回操作状态
     */
    function updateBrand($brand){
        $this->ufields = array(
            'yc_bid' => $brand['yc_bid'],
            'yc_brandname' => $brand['yc_brandname']
        );
        
        #冰狗品牌
        $bc_brand = $this->brand->getBrandByName($brand['yc_brandname']);
        if(!empty($bc_brand)){
            $this->ufields['brand_name'] = $bc_brand['brand_name'];
            $this->ufields['brand_id'] = $bc_brand['brand_id'];
        }
        
        #检查易车品牌表是否已存在该品牌记录
        $old = $this->getBrandByName($brand['yc_brandname']);
        if(!empty($old)){
            $this->where = "yc_brandname='{$brand['yc_brandname']}' and state<>3";
            $ret = $this->update();
        }else{
            $this->ufields['created'] = $this->timestamp;
            $ret = $this->insert();
        }
        return $ret;
    }
    
}

