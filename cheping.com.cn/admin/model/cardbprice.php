<?php

class cardbPrice extends model {

    function __construct() {
        parent::__construct();
        $this->table_name = "cardb_price";
    }

    function getPriceBySeries($sid, $field = '', $price_type = 0, $order = array('p.price' => 'desc'), $result_type = 1) {
        $this->tables = array(
            'cardb_model' => 'm',
            'cardb_price' => 'p'
        );
        $this->fields = $field ? $field : "p.*";
        $this->where = "p.series_id='{$sid}' and m.model_id=p.model_id and p.price_type='{$price_type}'";
        if ($order) {
            $this->order = $order;
        }
        return $this->joinTable($result_type);
    }

    /**
     * 根据model_id查询价格
     * @param $fields string 需要查询的字段
     * @param $model_id integer 车款id
     * @return boolean
     */
    function getPriceByModelId($fields, $model_id, $order = array(), $type = 1) {
        $this->fields = $fields;
        $this->where = $model_id;
        $this->order = $order;
        return $this->getResult($type);
    }

    function getPriceByTid($model_id, $type_id) {
        $this->fields = 'price';
        $this->where = "model_id = $model_id AND price_type = $type_id";
        $result = $this->getResult(3);
        return $result;
    }

    function getPrice($fields, $where, $flag) {
        $this->fields = $fields;
        $this->where = $where;
        $result = $this->getResult($flag);
        return $result;
    }

    /**
     * 更新价格
     * @param $ufields array 需要更新的价格
     * @param $id string 需要更新字段的model_id
     */
    function updateModelPrice($ufields, $id, $type = 5) {
        $this->ufields = $ufields;
        $this->where = "model_id=$id and price_type=$type";
        return $this->update();
    }

    /**
     * 根据商情价id更新价格
     */
    function updatePrice($ufields, $where) {
        $this->ufields = $ufields;
        $this->where = $where;
        return $this->update();
    }

    /**
     * 显示所有车款的价格
     */
    function showAllModelPrice($limit, $offset, $where) {
        $this->tables = array(
            'cardb_model' => 'cm',
            'cardb_price' => 'cp'
        );
        $this->fields = 'count(*) AS total';
        $this->where = "cm.model_id=cp.model_id AND cm.state in (3,8)" . $where;
        $this->total = $this->joinTable();
        $this->fields = 'cm.series_name,cm.model_name,cp.price-cp.prev_media_price AS spread,ABS(cp.price-cp.prev_media_price) AS tem,cp.price,cp.prev_media_price,cp.model_id,cp.get_time';
        $this->order = array('tem' => 'desc', 'cp.get_time' => 'desc');
        $this->limit = $limit;
        $this->offset = $offset;
        $res = $this->joinTable(2);
        return array('total' => $this->total, 'res' => $res);
    }

    /**
     * 导出全车款媒体价格专用
     */
    function exportMediaprice() {
        $this->table_name = 'cardb_model cm';
        $this->tables = array(
            //媒体价
            'cardb_price' => 'cp',
            //在售状态
            'cardb_salestate' => 'cs',
            //老旧车企业补贴
            'cardb_oldcarval' => 'co'
        );
        $valid_time = strtotime(date('Y-m-d'));
        $this->fields = 'cm.model_id,cm.brand_name,cm.factory_name,cm.series_name,cm.model_name,cm.state AS cmstate,cm.model_price,cm.series_id,cm.date_id,cm.st27,cm.st28,st48,st41,cp.province,cp.city,cp.area,cp.dealer_name,cp.price,cp.dealer_addr,cp.dealer_tel,cs.state AS csstate,co.car_prize';
        $this->join_condition = array('cm.model_id=cp.model_id and cp.price_type=5', 'cm.model_id=cs.model_id', "cm.model_id=co.model_id and co.start_date<=$valid_time and co.end_date>=$valid_time");
        $this->where = 'cm.state in (3,8)';
        $this->order = array('cm.brand_id' => 'ASC');
        $result = $this->leftJoin(2);
        $this->table_name = 'cardb_price';
        if ($result)
            return $result;
        else
            return false;
    }

    /**
     * 联表查询
     */
    function getPriceAndModelA($type, $where, $fields, $flag = 2) {
        $this->tables = array(
            'cardb_price' => 'cp',
            'cardb_model' => 'cm'
        );
        $this->where = "cp.model_id=cm.model_id and cm.state in (3,8) and cp.price_type=$type" . $where;
        $this->fields = $fields;
        $res = $this->joinTable($flag);
        if ($res)
            return $res;
        else
            return false;
    }

    function addPrice($receiver) {
        $receiver['created'] = time();
        $receiver['updated'] = time();
        $receiver['get_time'] = time();
        $this->ufields = $receiver;
        return $this->insert();
    }

}

?>