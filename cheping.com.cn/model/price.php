<?php

/**
 * cardb_price
 * $Id: price.php 5754 2014-08-12 07:37:22Z xiaodawei $
 */
class price extends model {

    function __construct() {
        $this->table_name = "cardb_price";
        $this->savedate = 60 * 60 * 24 * 45; //取值的时间范围
        parent::__construct();
        $this->pricelog = new priceLog();
    }

    function getPriceList($fields, $where, $flag = 1) {
        $this->reset();
        $this->fields = $fields;
        $this->where = $where;
        $result = $this->getResult($flag);
        return $result;
    }

    /**
     * 获取车款信息
     * @param type $model_id 
     * @return type $result  array()
     */
    function getModelDetail($model_id) {
        $this->tables = array(
            "cardb_price" => "pr",
            "cardb_model" => "md"
        );
        $this->fields = "md.model_id,md.model_name,md.series_name,md.brand_name,md.model_price,md.dealer_price_low,pr.price,pr.price_from,pr.from_type";
        $this->where = "md.model_id=pr.model_id and md.model_id=$model_id and pr.price_type=0";
        $result = $this->joinTable(2);

        return $result;
    }

    /**
     * 车款页的商情价
     * @param type $model_id 
     * @return type $arr  array()
     */
    function getPriceByModelId($model_id, $type = 2) {
        $this->fields = "*";
        //时间范围
        //$end_time = time();
        //$start_time  =time()-45*24*3600;
        $this->where = "price_type=5 and model_id='$model_id'  and price!=''";
        $this->order = array("price" => "asc");
        $this->group = "province";
        $result = $this->getResult($type);
//        if ($result) {
//            $this->salestate = new salestate();
//            foreach ($result as $key => $value) {
//                $state = $this->salestate->getSaleStateList("state", "model_id='$model_id'", 3);
//                echo $this->salestate->sql;
//                $result[$key]['state'] = $state;
//            }
//        }
        return $result;
    }

    /**
     * 商情价
     * @param type $model_id 
     * @return type $arr  array()
     */
    function getSeritePriceByModelId($model_id) {
        $this->fields = "*";
        $this->where = "price_type=5 and model_id='$model_id'  and price!=''";
        $this->order = 'order by price_type,price';
        $result = $this->getResult(1);

        return $result;
    }

    function getPriceAndModelA($type, $where, $fields) {
        $this->tables = array(
            'cardb_price' => 'cp',
            'cardb_model' => 'cm'
        );
        $this->where = "cp.model_id=cm.model_id and cm.state in (3,8) and cp.price_type=$type" . $where;
        $this->fields = $fields;
        $res = $this->joinTable(2);
        if ($res)
            return $res;
        else
            return false;
    }

    function getPrice($type, $where, $fields) {
        $this->tables = array(
            'cardb_price' => 'cp',
            'dealer_info' => 'di'
        );
        $this->where = $where;
        $this->fields = $fields;
        $res = $this->joinTable($type);
        if ($res)
            return $res;
        else
            return false;
    }

}

?>
