<?php

/* 
 * yiche model
 * @author David Shaw <tudibao@163.com>
 * $Id: yichemodel.php 1792 2016-03-28 01:59:03Z wangchangjiang $
 */

class yicheModel extends model{
    var $model;
    function __construct() {
        parent::__construct();
        $this->table_name = "yiche_model";
        $this->model = new cardbModel();
    }
    
    function getModel($id){
        $this->fields = "*";
        $this->where = "id='{$id}'";
        return $this->getResult();
    }
    
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
    
    function getModelByName($model_name, $series_name){
        $this->fields = "*";
        $this->where = "yc_modelname='{$model_name}' and yc_seriesname='{$series_name}'";
        return $this->getResult();
    }
    
    /**
     * 更新/插入 易车车款信息表
     * 
     * @param array $model 易车车款表数组
     * @return mix 更新/插入车款表的状态
     */
    function updateModel($model){
        $this->ufields = array(
            'yc_mid' => $model['yc_mid'],
            'yc_modelname' => $model['yc_modelname'],
            'yc_sid' => $model['yc_sid'],
            'yc_seriesname' => $model['yc_seriesname'],
            'yc_factoryname' => $model['yc_factoryname'],
            'yc_brandname' => $model['yc_brandname'],
            'yc_price' => $model['yc_price'],
            'model_price' => $model['model_price'],
            'yc_mallurl' => $model['yc_mallurl'],
            
        );
        
        #检查冰狗车款表
        $bc_model = $this->model->getModelByName($model['yc_modelname'], $model['yc_seriesname']);
        if(!empty($bc_model)){
            $this->ufields['model_name'] = $bc_model['model_name'];
            $this->ufields['model_id'] = $bc_model['model_id'];
        }
        
        $old = $this->getModelByName($model['yc_modelname'], $model['yc_seriesname']);
        if(!empty($old)){
            $this->where = "yc_modelname='{$model['yc_modelname']}' and yc_seriesname='{$model['yc_seriesname']}'";
            $ret = $this->update();
        }else{
            $this->ufields['created'] = $this->timestamp;
            $ret = $this->insert();
        }
        #var_dump($this->sql);
        return $ret;
    }
}

