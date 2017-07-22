<?php
/**
 * cardb_model_pic_collect 表存储通过model_id抓取车款图片的记录信息
 * $Id: cardbmodelpiccollect.php 2560 2016-05-09 08:30:00Z wangchangjiang $
 */

class cardbModelPicCollect extends model {
    
    function __construct() {
        parent::__construct();
        $this->table_name = "cardb_model_pic_collect";
    }
    /**
     * 添加数据
     * @param array $ufields 更新数据的数组
     */
    function addCollect($ufields){
        $this->ufields = $ufields;
        $this->insert();
    }
    /**
     * 根据model_id(车款id),返回已存在于表中
     * @param int $model_id
     * @return boolean
     */
    function isModelId($model_id){
        $this->fields = "state";
        $this->where = "model_id=$model_id";
        return $this->getResult(3); 
    }
    /**
     * 获取条件下的所有数据列表
     * @param string $where
     * @param array $order 
     * @param int $offset
     * @param int $limit
     * @return 二维array result 二维数组的集合
     */
    function getList($where=Null, $order, $offset = 0, $limit = 0){
        if($where)
            $this->where = $where;
        $this->fields = "count(*)";
        $this->total = $this->getResult(3);
        
        $this->fields = "*";
        if($where)
            $this->where = $where;
        if(order)
            $this->order = $order;
        if ($offset)
            $this->offset = $offset;
        if ($limit)
            $this->limit = $limit;
        return $this->getResult(2);
    }
    /**
     * 更新数据
     * @param string  $where
     * @param array $ufields
     * @return boolean
     */
    function upCollect($where=NULL, $ufields=NULL){
        if($where)
            $this->where = $where;
        if($ufields)
            $this->ufields = $ufields;
        if(!$where || !$ufields){
            return FALSE;
        }
        return $this->update();
    }
    
}

