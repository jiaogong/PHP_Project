<?php

/**
 * factory
 * $Id: factory.php 1799 2016-03-28 08:19:48Z wangchangjiang $
 */
class factory extends model {

    var $factory_import = array(
        1 => '自主',
        2 => '合资',
        3 => '进口',
    );

    function __construct() {
        parent::__construct();
        $this->table_name = "cardb_factory";
    }

    function getFactoryByBrand($bid, $factory_name = '') {
        $this->where = "brand_id='{$bid}' and state=3" . ($factory_name ? " and factory_name='{$factory_name}'" : "");
        $this->fields = "*";
        $this->getall = 1;
        return $this->getResult(2);
    }

    /**
     * 获取品牌跟厂商对应关系
     */
    function getBrandFactory() {
        $this->fields = 'brand_id, factory_id, factory_name';
        $this->where = 'state = 3';
        $result = $this->getResult(2);
        $bfArr = array();
        if (!empty($result)) {
            foreach ($result as $k => $v) {
                $bid = $v['brand_id'];
//                $v['factory_name'] = iconv('gbk', 'utf-8', $v['factory_name']);
                $v['factory_name'] = $v['factory_name'];
                $bfArr[$bid][] = $v;
            }
        }
        return $bfArr;
    }

    //=========================================================

    function getFactory($id, $state = '3') {
        $this->fields = "*";
        $this->where = "factory_id='{$id}'" . ($state < 0 ? "" : " and state='{$state}'");
        return $this->getResult();
    }

    function getAllFactory($where = '1', $order = array(), $limit = 1, $offset = 0) {
        $this->tables = array(
            'cardb_factory' => 'f',
            'cardb_brand' => 'b',
        );
        $this->where = $where;
        $this->fields = "count(f.factory_id)";
        $this->total = $this->joinTable(3);

        $this->fields = "f.factory_id as id, f.factory_id,f.factory_name,f.state,b.brand_name,b.brand_id,b.state as bs,b.letter";
        $this->limit = $limit;
        $this->offset = $offset;
        if (!empty($order))
            $this->order = $order;

        return $this->joinTable(2);
    }

    function upDataState($state, $id) {
        //修改factory状态
        $this->ufields = array('state' => $state);
        $this->where = "factory_id='" . intval($id) . "'";
        $this->update();
        //修改车系状态
        $s = new series();
        $s->ufields = array('state' => $state);
        ;
        $s->where = $this->where;
        $s->update();
        //修改车款状态
        $m = new cardbModel();
        $m->ufields = array('state' => $state);
        ;
        $m->where = $this->where;
        $m->update();
        return 1;
    }

    function getDatabyState($state) {
        $this->fields = "count(*) as sum";
        $this->where = "1 and state='$state'";
        return $this->getResult(3);
    }

    function getData($state) {
        $this->fields = "factory_id as id,factory_name as name";
        $this->where = "1 and state='$state'";
        return $this->getResult(2);
    }

    function getFactorylist($fields, $where, $flag) {
        $this->fields = $fields;
        $this->where = $where;
        return $this->getResult($flag);
    }

    function getFactoryByName($factory_name) {
        $this->where = "factory_name='{$factory_name}'";
        $this->fields = "*";
        return $this->getResult();
    }

}

?>
