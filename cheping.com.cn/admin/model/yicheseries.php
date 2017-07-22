<?php

/* 
 * yiche series
 * @author David Shaw <tudibao@163.com>
 * $Id: yicheseries.php 1792 2016-03-28 01:59:03Z wangchangjiang $
 */

class yicheSeries extends model{
    var $series;
    var $yc_factory;
    var $total;
    
    function __construct() {
        parent::__construct();
        $this->table_name = "yiche_series";
        $this->series = new series();
        $this->yc_factory = new yicheFactory();
    }
    
    function getSeries($id){
        $this->fields = "*";
        $this->where = "id='{$id}'";
        return $this->getResult();
    }
    function getSeriesByName($series_name){
        $this->fields = "*";
        $this->where = "yc_seriesname='{$series_name}'";
        return $this->getResult();
    }
    
    /**
     * 根据条件返回易车车系列表
     * @param string $where 查询条件，必填项
     * @param int $limit 要求返回的记录条数，默认30条
     * @param int $offset 数据偏移，默认从0开始
     * @return array 车系数组
     */
    function getList($where = '1', $limit = 30, $offset = 0){
        $this->fields = "*";
        $this->where = $where ? $where : 1;
        $this->limit = $limit;
        $this->offset = $offset;
        $this->order = array('id' => 'asc');
        $result = $this->getResult(2);
        
        $this->fields = "count(*)";
        $this->limit = 1;
        $this->offset = 0;
        $this->total = $this->getResult(3);
        return $result;
    }
    
    /**
     * 更新/插入 易车车系信息表
     * 
     * @param array $series 易车车系表数组
     * @param boolean $update_factory 同步更新易车厂商信息表
     * @return mix 更新/插入车系表的状态
     */
    function updateSeries($series, $update_factory = false){
        $this->ufields = array(
            'yc_sid' => $series['yc_sid'],
            'yc_seriesname' => $series['yc_seriesname'],
            'yc_fid' => $series['yc_fid'],
            'yc_factoryname' => $series['yc_factoryname'],
            'yc_bid' => $series['yc_bid'],
            'yc_brandname' => $series['yc_brandname'],
        );
        #检查冰狗车系表
        #$bc_series = $this->series->getSeriesByName($series['yc_seriesname']);
        $this->series->fields = "*";
        $this->series->where = "state=3 and series_name like '%{$series['yc_seriesname']}%' and brand_name='{$series['yc_brandname']}'";
        $bc_series = $this->series->getResult();
        if(!empty($bc_series)){
            $this->ufields['series_name'] = $bc_series['series_name'];
            $this->ufields['series_id'] = $bc_series['series_id'];
            
            if($update_factory){
                $this->yc_factory->ufields = array(
                    'factory_id' => $bc_series['factory_id'],
                    'factory_name' => $bc_series['factory_name'],
                );
                $this->yc_factory->where = "yc_factoryname='{$series['yc_factoryname']}' and state<>3";
                $update_yc_fact = $this->yc_factory->update();
            }
        }
        
        $old = $this->getSeriesByName($series['yc_seriesname']);
        if(!empty($old)){
            $this->where = "yc_seriesname='{$series['yc_seriesname']}' and series_name='{$bc_series['series_name']}' and state<>3";
            $ret = $this->update();
        }else{
            $this->ufields['created'] = $this->timestamp;
            $ret = $this->insert();
        }
        return $ret;
    }
}

