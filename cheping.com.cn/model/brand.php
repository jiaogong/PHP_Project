<?php 
/* $Id: brand.php 6201 2015-02-11 01:44:30Z xiaodawei $ */

class brand extends model {
    public function __construct() {
        parent::__construct();
        $this->table_name = 'cardb_brand';
        $this->bi = array(
            1 => '自主',
            2 => '美系',
            3 => '日系',
            4 => '欧系',
            5 => '韩系',
        );
        #$this->logoDir = 'www.bingocar.cn/attach/images/brand/';
    }
        function getDrand($fields, $where = 1, $type = 2) {
        $this->fields = $fields;
        $this->where = $where;
        return $this->getResult($type);
    }
    /**
     * 返回品牌的LOGO数组
     * @param $id brand_id, 0=all
     * @return array $ret
     */
    function getBrandLogo($id = 0) {
        global $_cache;
        $ret = array();
        $cache_key = "brand_logo_" . $id;
        $cache_time = 86400;
        $result = $_cache->getCache($cache_key);

        if (!$result) {
            $this->fields = "brand_id,brand_logo";
            $this->where = "brand_logo IS NOT NULL";
            $ret = $this->getResult(4);

            $_cache->writeCache($cache_key, $ret, $cache_time);
            $result = $ret;
        }
        return $result;
    }

   /**
     * 检查品牌是否存在
     * @param type $brand  品牌名称
     * @return type  string  $result  品牌id
     */
    function getSearchBrandName($brand) {
        $this->where = "brand_name = '$brand'";
        $this->fields = "brand_id";
        $result = $this->getResult(3);
        return $result;
    }

    function getAllBrand($fileds = null, $where = null, $order = null, $limit = null) {
        global $_cache;
        $key = "brand";
        $brands = $_cache->getCache($key);
        if ($brands) {
            return $brands;
        } else {
            #$this -> reset();
            $this->fields = $fileds ? $fileds : "*";
            if ($where) {
                $this->where = $where . " and 1 and state=3";
            } else {
                $this->where = " 1 and state=3";
            }
            if ($order) {
                $this->order = $order;
            }
            if ($limit) {
                $this->limit = $limit;
            }
            $brands = $this->getResult(2);
            $_cache->writeCache($key, $brands);
            return $brands;
        }
    }

    function getAllBrandFactory($fields, $order) {
        $this->tables = array(
            'cardb_brand' => 'cb',
            'cardb_factory' => 'cf'
        );
        $this->fields = $fields;
        $this->order = $order;
        $this->where = 'cb.brand_id=cf.brand_id and cf.state=3 and cb.state=3';
        $res = $this->joinTable(2);
        return $res;
    }

   function getLeftList($allId) {
        if (!is_numeric($allId)) {
            exit('品牌id格式有错');
        }
        global $_cache;
        $timestamp = time();
        //缓存保存时间
        $cacheTime = 24 * 3600;
        $chache_key = "brand_tree_list";
        $tempAllBrand = $_cache->getCache($chache_key);
        echo $this->$_cache->sql;
        if ( empty($tempAllBrand) || $timestamp - $tempAllBrand['cacheTime'] > $cacheTime) {
            $tempAllBrand = array('cacheTime' => $timestamp);
            $cardbfile = new cardbfile();
            $seriesObj = new series();
            $seriesData = $seriesObj->getSNB('cs.brand_id,cs.factory_id,cs.series_id,cs.brand_name,cs.factory_name,cs.series_name,cb.letter', 'cs.brand_id=cb.brand_id and cb.state=3 and cs.state=3',2, array('cb.letter' => 'asc'));
            $countSeries = $cardbfile->getPNM('s1,count(*) scount');
            $b = $f = array();
            $l = '';
            foreach ($seriesData as $val) {
                if (!in_array($val['brand_id'], $b)) {
                    $tempAllBrand[$val['brand_id']] = array(
                        'count' => 0,
                        'brand_name' => $val['brand_name'],
                        'brand_id' => $val['brand_id'],
                        'letters' => $val['letter'],
                        'letter' => ($val['letter'] != $l) ? $val['letter'] : '&nbsp;&nbsp;',
                        'factory' => array()
                    );
                }
                $l = $val['letter'];
                $b[] = $val['brand_id'];
                if (!in_array($val['factory_id'], $f)) {
                    $tempAllBrand[$val['brand_id']]['factory'][$val['factory_id']] = array(
                        'factory_name' => $val['factory_name'],
                        'count' => 0,
                        'series' => array()
                    );
                }
                $f[] = $val['factory_id'];
                $tempAllBrand[$val['brand_id']]['factory'][$val['factory_id']]['count'] += $countSeries[$val['series_id']];

                $tempAllBrand[$val['brand_id']]['count'] += $countSeries[$val['series_id']];

                $s = array('series_name' => $val['series_name'], 'count' => $countSeries[$val['series_id']]);

                $tempAllBrand[$val['brand_id']]['factory'][$val['factory_id']]['series'][$val['series_id']] = $s;
            }
            $_cache->writeCache($chache_key, $tempAllBrand, $cacheTime);
        }
        unset($tempAllBrand['cacheTime']);
        if ($allId > 0) {
            return $tempAllBrand[$allId];
        }
        return $tempAllBrand;
    }

    function getByBrandId($fields, $where, $flag) {
        $this->where = $where;
        $this->fields = $fields;
        $result = $this->getResult($flag);
        return $result;
    }
    function getBrand($fields, $where, $flag, $order = array()) {
        $this->fields = $fields;
        $this->where = $where;
        $this->order = $order;
        $result = $this->getResult($flag);
        return $result;
    }
    function getSNB($fields, $where, $flag, $order) {
        $this->tables = array(
            'cardb_series' => 'cs',
            'cardb_brand' => 'cb'
        );
        $this->where = $where;
        $this->fields = $fields;
        if ($order)
            $this->order = $order;
        $result = $this->joinTable($flag);
        return $result;
    }
}