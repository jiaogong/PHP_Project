<?php

/**
 * model test data CN
 * 车辆测试数据 中国区
 * $Id: cardbmodeldatacn.php 3160 2016-06-22 02:07:35Z wangchangjiang $
 */
class cardbModelDataCN extends model {

    function __construct() {
        parent::__construct();
        $this->table_name = "cardb_model_data_cn";
    }

    /**
     * 根据相关的条件 返回车辆测试数据
     * @param string $fields
     * @param string $where
     * @param bool $total 是否求总条数
     * @param int $falg
     * @param array $order
     * @param int $offset
     * @param int $limit
     * @param array $group
     * @return mixed
     */
    function getList($fields="*", $where="", $total=false, $falg=2, $order=array(), $offset=0, $limit=1, $group=array()){
        if($total) {
            $this->fields = "count(*)";
            $this->where = $where;
            $this->total = $this->getResult(3);
        }

        $this->fields = $fields;
        $this->where = $where;
        if($order)
            $this->order = $order;
        $this->offset = $offset;
        $this->limit = $limit;
        if($group)
            $this->group = $group;
        return $this->getResult($falg);
    }

    /**
     * 根据条件 获取车款的品牌、厂商、车系 和 测试信息
     * @param string $fields
     * @param string $where
     * @param int $falg
     * @return mixed
     */
    function getCarNameAndData($fields="", $where="", $falg=1){
        $this->fields = $fields;
        $this->where = $where;
        return $this->getResult($falg);
    }

}

?>
