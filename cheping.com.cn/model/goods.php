<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class goods extends model {

    function __construct() {
        parent::__construct();
        $this->table_name = 'cardb_model_goods';
    }

    /**
     * 根据地级id取出所有的县级地区
     * @param int $cid
     * @return array
     */
    function getList($fiesld, $where, $flag) {
        $this->fields = $fiesld;
        $this->where = $where;
        return $this->getResult($flag);
    }

    function getGoodslistPage($fields, $where, $offset = 0, $limit = 0, $order = array(), $type = 2) {
        $this->fields = $fields;
        $this->where = $where;
        $this->order = $order;
        if ($offset)
            $this->offset = $offset;
        if ($limit)
            $this->limit = $limit;
        return $this->getResult($type);
    }

    //热门品牌
    function getHotbrandList() {

        global $_cache;
        $chache_key = "hotbrandlist";
        $hotbrandlist = $_cache->getCache($chache_key);
        if (!$hotbrandlist) {
            $this->table_name = "(SELECT  cb.brand_id, cb.brand_name, cmg.goods_rebate, cb.brand_logo  FROM cardb_brand cb,
				cardb_model_goods cmg  WHERE cmg.brand_id = cb.brand_id  AND grade = 'A' AND cmg.goods_price>0 ORDER BY cmg.goods_rebate ASC) as tt";
            $this->fields = "*";
            $this->where = "";
            $this->group = "brand_id";
            $this->order = array("goods_rebate" => "asc");
            $this->getall = 0;
            $this->limit = 15;
            $hotbrandlist = $this->getResult(2);
            $i = 0;
            $brandA = $brandB = $brand = array();
            foreach ($hotbrandlist as $key => $value) {
                $i++;
                if ($i % 3 == 0) {
                    $brandA[] = $value;
                } else {
                    $brandB[] = $value;
                }
                $brand[A] = $brandA;
                $brand[B] = $brandB;
            }
            $_cache->writeCache($chache_key, $brand, 3600 * 24);
            return $brand;
        } else {
            return $hotbrandlist;
        }
    }

    //连接车系表查询
    function getJoinSeriesTable($where, $fields, $order, $flag = 1) {
        $this->tables = array(
            'cardb_model_goods' => 'cg',
            'cardb_series' => 'cs'
        );
        $this->where = "cg.series_id=cs.series_id and cs.state=3" . $where;
        $this->fields = $fields;
        $this->order = $order;
        return $this->joinTable($flag);
    }

    /**
     * jquery autocomplete    搜索的自动填充功能
     * @param type $keyword  搜索关键字
     * @return type $return array  搜索结果
     */
    function getAutocomplete($keyword) {
        $this->fields = "distinct brand_name";
        $this->order = array('brand_name' => 'asc');
        $this->where = "grade in('A','B') and brand_name like '%$keyword%'";
        $ret = $this->getResult(2);

        if ($ret) {
            foreach ($ret as $key => $value) {
                $this->fields = "distinct series_name";
                $this->order = array('brand_name' => 'asc', 'series_name' => 'asc');
                $this->limit = 9;
                $this->where = "grade in('A','B')  and brand_name='$value[brand_name]'";
                $resultArr[$value[brand_name]] = $this->getResult(2);
            }

            foreach ($resultArr as $kk => $vv) {
                $result[]['series_name'] = $kk;
                if ($vv) {
                    foreach ($vv as $K => $v) {

                        $a = strpos($v[series_name], $keyword);
                        if ($a !== false) {
                            $result[] = $v;
                        }
                    }
                    foreach ($vv as $K => $v) {
                        $a = strpos($v[series_name], $keyword);
                        if ($a === false) {
                            $result[] = $v;
                        }
                    }
                }
            }
            return array_slice($result, 0, 10);
        } else {
            $this->fields = "series_name,count(distinct series_name)";
            $this->limit = 10;
            $this->group = "series_name";
            $this->order = array('series_name' => 'asc');
            $this->where = "grade in('A','B')  and  series_name='$keyword' or keyword like '%$keyword%'";
            $result = $this->getResult(2);
            if ($result) {
                return array_slice($result, 0, 10);
            }
        }
    }

    /* 连接车款表查询 */

    function getGoodsModel($fields, $where, $flag) {
        $this->tables = array(
            'cardb_model_goods' => 'cg',
            'cardb_model' => 'cm'
        );
        $this->fields = $fields;
        $this->where = 'cg.model_id=cm.model_id and cg.state=1' . $where . ' and cm.state in (3,8)';
        return $this->joinTable($flag);
    }

    /* 连接品牌表查询 */

    function getGoodsBrand($fields, $where, $order = '', $group = '') {
        $this->tables = array(
            'cardb_model_goods' => 'cg',
            'cardb_brand' => 'cb'
        );
        $this->fields = $fields;
        $this->where = 'cg.brand_id=cb.brand_id and cb.state=3' . $where;
        if ($order)
            $this->order = $order;
        if ($group)
            $this->group = $group;
        return $this->joinTable(2);
    }

    /* 连接价格表查询 */

    function getGoodsJoinPrice($where, $fields, $flag = 2) {
        $this->tables = array(
            'cardb_model_goods' => 'cm',
            'ibuycar_price' => 'ip'
        );
        $this->where = $where;
        $this->fields = $fields;
        return $this->joinTable($flag);
    }

}

?>
