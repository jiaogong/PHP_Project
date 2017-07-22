<?php

/* 
 * yiche factory
 * @author David Shaw <tudibao@163.com>
 * $Id: yichefactory.php 1792 2016-03-28 01:59:03Z wangchangjiang $
 */

class yicheFactory extends model{
    var $factory;
    function __construct() {
        parent::__construct();
        $this->table_name = "yiche_factory";
        $this->factory = new factory();
    }
    
    function getFactory($id){
        $this->fields = "*";
        $this->where = "id='{$id}'";
        return $this->getResult();
    }
    function getFactoryByName($factory_name){
        $this->fields = "*";
        $this->where = "yc_factoryname='{$factory_name}'";
        return $this->getResult();
    }
    
    function getList($where = '', $litmit = 1, $offset = 0){
        $this->fields = "*";
        $this->where = '1';
        $this->offset = $offset;
        $this->limit = $litmit;
        $result = $this->getResult(2);
        return $result;
    }
    
    function getListByBid($bid){
        $this->fields = "*";
        $this->where = "yc_bid='{$bid}'";
        $list = $this->getResult(2);
        
        $json = array();
        foreach ($list as $k => $v) {
            $json[] = array(
                'id' => $v['id'],
                'yc_fid' => $v['yc_fid'],
                'yc_factoryname' => iconv('gbk', 'utf-8', $v['yc_factoryname']),
                'yc_bid' => $v['yc_bid'],
                'yc_brandname' => iconv('gbk', 'utf-8', $v['yc_brandname']),
                'factory_name' => iconv('gbk', 'utf-8', $v['factory_name']),
                'factory_id' => $v['factory_id'],
            );
        }
        return json_encode($json);
    }
    
    /**
     * 更新/插入 易车厂商信息表
     * 
     * @param array $factory 易车厂商表数组
     * @return mix 更新/插入厂商表的状态
     */
    function updateFactory($factory){
        $this->ufields = array(
            'yc_fid' => $factory['yc_fid'],
            'yc_factoryname' => $factory['yc_factoryname'],
            'yc_bid' => $factory['yc_bid'],
            'yc_brandname' => $factory['yc_brandname'],
        );
        #检查冰狗厂商表
        $bc_factory = $this->factory->getFactoryByName($factory['yc_factoryname']);
        if(!empty($bc_factory)){
            $this->ufields['factory_name'] = $bc_factory['factory_name'];
            $this->ufields['factory_id'] = $bc_factory['factory_id'];
        }
        
        $old = $this->getFactoryByName($factory['yc_factoryname']);
        if(!empty($old)){
            $this->where = "yc_factoryname='{$factory['yc_factoryname']}' and state<>3";
            $ret = $this->update();
        }else{
            $this->ufields['created'] = $this->timestamp;
            $ret = $this->insert();
        }
        return $ret;
    }
}

