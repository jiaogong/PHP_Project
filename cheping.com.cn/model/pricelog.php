<?php

/**
 * cardb_pricelog
 * $Id: pricelog.php 6229 2015-07-02 03:43:46Z wangguodong $
 */
class priceLog extends model {

    function __construct() {
        $this->table_name = "cardb_pricelog";
        $this->savedate = 60 * 60 * 24 * 45; //取值的时间范围
        parent::__construct();
    }

    function getPrice($modelId, $typeId) {
        $this->fields = 'price';
        $this->where = "model_id = $modelId AND price_type = $typeId";
        $this->order = array('created' => 'DESC');
        $result = $this->getResult(3);
        return $result;
    }

    /**
     * 
     * 获取商情价格曲线
     */
    function getModelPriceLog($model_id) {
        global $_cache;
        $cache_key = 'pr_report_' . $model_id;
        $result = $_cache->getCache($cache_key);
        if (!$result) {
            $this->fields = 'price, get_time';
            $this->order = array("price" => "asc");
            $year = date('Y');
            $month = date('m');
            $monthDays = date('t');
            $result1 = array();
            //当月结束时间
            $monthEnd = mktime(23, 59, 59, $month, $monthDays, $year);
            //每个月的时间（秒）
            $monthLong = 30 * 3600 * 24;
            if ($year == 2013) {
                $k = $month - 4;
            } elseif ($year == 2014) {
                if ($month < 5) {
                    $k = 12 - $month;
                }
            }

            for ($i = 1; $i < 13; $i++) {
                $monthOnEnd = $monthEnd - $monthLong * $i;
                $monthstart = $monthOnEnd - $monthLong;
                if ($k) {
                    if ($i < $k) {
                        $this->where = "model_id = $model_id AND price_type in(0,5) and get_time between $monthstart and $monthOnEnd";
                    } else {
                        $this->where = "model_id = $model_id AND price_type =4 and get_time between $monthstart and $monthOnEnd";
                    }
                } else {
                    $this->where = "model_id = $model_id AND price_type in(0,5) and get_time between $monthstart and $monthOnEnd";
                }
                $res = $this->getResult(1);
                if ($res) {
                    $result1[] = $res;
                }
            }
            //反转数组使之时间由小到大
            $result = array_reverse($result1);
            $_cache->writeCache($cache_key, $result, 86400);
        }
        return $result;
    }

    function getPriceLog($fields, $where, $flag) {
        $this->reset();
        $this->fields = $fields;
        $this->where = $where;
        $result = $this->getResult($flag);
        return $result;
    }

    function getPricelogDealer($fields, $mid, $flag) {
        $this->fields = $fields;
        $this->where = "";
        $media_time = strtotime(date('Y-m-d')) - 30 * 24 * 60 * 60;
        $this->table_name = "cardb_pricelog WHERE model_id=$mid AND price_type=0 UNION (SELECT $fields FROM cardb_pricelog WHERE model_id=$mid AND price_type=5
 AND get_time>$media_time ORDER BY price LIMIT 1)
 UNION (SELECT $fields FROM cardb_pricelog WHERE model_id=$mid AND price_type=5 ORDER BY get_time DESC LIMIT 1)";
        $result = $this->getResult($flag);
        return count($result);
    }

    function getPricelogListDealer($fields, $mid, $flag) {
        $this->getall = 0;
        $this->fields = $fields;
        $this->where = "";
        //$timestamp = time();
        //$lastTimestamp = $timestamp - $this->savedate;
        $media_time = strtotime(date('Y-m-d')) - 30 * 24 * 60 * 60;
        $this->table_name = "cardb_pricelog WHERE model_id=$mid AND price_type=0 UNION (SELECT * FROM cardb_pricelog WHERE model_id=$mid AND price_type=5
 AND get_time>$media_time ORDER BY price LIMIT 1)
 UNION (SELECT * FROM cardb_pricelog WHERE model_id=$mid AND price_type=5 ORDER BY get_time DESC LIMIT 1)";
        $this->order = array("get_time" => "DESC");
        $result = $this->getResult($flag);
        if ($result) {
            foreach ($result as $key => $value) {
                #去除抓取时出现的经销商名称后的换行符
                $value['dealer_name'] = trim($value['dealer_name']);

                $this->reset();
                $this->table_name = "dealer_info";
                $this->where = "state=2 and (dealer_name='{$value['dealer_name']}' or dealer_name2='{$value['dealer_name']}')";
                $a = $this->getResult(1);

                if ($a) {
                    $result[$key]['dealer_tel'] = $a['dealer_tel'];
                    $result[$key]['dealer_pic'] = $a['dealer_pic'];
                    $result[$key]['dealer_pic_alt'] = $a['dealer_pic_alt'];
                }
            }
        }
        $this->reset();
        return $result;
    }

    function insertPricelog($ufields) {
        $this->ufields = $ufields;
        return $this->insert();
    }

    function updatePrice($ufields, $where) {
        $this->ufields = $ufields;
        $this->where = $where;
        return $this->update();
    }

    /**
     * 车款页的商情价
     * @param type $model_id 
     * @return type $arr  array()
     */
    function getPriceByModelId($model_id) {
        $this->fields = "id,price,price_type,model_id,province,city,deliver_price,nude_car_price";
        //时间范围
        $end_time = time();
        $start_time = time() - 45 * 24 * 3600;
        $this->where = "price_type=0 and model_id=$model_id and get_time>$start_time and get_time<$end_time and price!='' and province!=''";
        $this->order = array("price" => "asc");
        $this->group = "province";
        $result = $this->getResult(2);

        if ($result) {
            $this->province = new Province();
            $this->city = new City();
            $this->salestate = new salestate();

            foreach ($result as $key => $value) {
                $province_id = $this->province->getProvinceList('id', "name='$value[province]'", 3);
                $city_id = $this->city->getCityList('id', "name='$value[city]'", 3);
                $state = $this->salestate->getSaleStateList("state", "province_id=$province_id and city_id=$city_id and model_id=$model_id", 3);
                $result[$key][state] = $state;
            }
        }

        return $result;
    }

    function getPriceLogByid($model_id, $id) {
        $this->fields = "id,price,price_type,model_id,province,city,deliver_price,nude_car_price";
        $this->where = "id=$id and model_id=$model_id";
        $res = $this->getResult(1);
        if ($res) {
            $this->province = new Province();
            $this->city = new City();
            $this->salestate = new salestate();
            $province_id = $this->province->getProvinceList('id', "name='$value[province]'", 3);
            $city_id = $this->city->getCityList('id', "name='$value[city]'", 3);
            $state = $this->salestate->getSaleStateList("state", "province_id=$province_id and city_id=$city_id and model_id=$model_id", 3);
            $result[$key][state] = $state;
            $result[price] = $res[price];
        }

        return $result;
    }

    function getMinMediaPrice($mid) {
        $time = time();
        $lastTime = $time - 90 * 24 * 3600;
        $this->fields = 'min(price)';
        $this->where = "model_id = $mid AND price_type = 5 AND created > $lastTime AND created < $time";
        $result = $this->getResult(3);
        return $result;
    }

    #

    function getBingoprice($mid) {
        $time = time();
        $lastTime = $time - 45 * 24 * 3600;

        $this->tables = array(
            'cardb_pricelog' => 'cp',
            "(SELECT SUBSTRING_INDEX(GROUP_CONCAT( id ORDER BY get_time DESC),',',1) AS id 
FROM cardb_pricelog WHERE model_id = $mid AND price_type=0  GROUP BY dealer_name,saler,saler_tel,model_id,get_time)" => 'temcp',
            'cardb_model' => 'cm'
        );
        $this->fields = 'cp.dealer_name, cp.model_id, cp.saler, cp.saler_tel, cp.price, cp.free_promotion_gift, cp.rate, cp.down_payment, cp.interest_rate_fee, cp.low_year, cp.get_time, cm.model_price';
        $this->order = array('cp.get_time' => 'DESC');
        $this->limit = 5;
        $this->where = "cm.state in (3, 8) AND cp.id = temcp.id and cp.model_id = cm.model_id";
        $result = $this->joinTable(2);
        return $result;
    }

    function getCountBingoprice($mid) {
        $time = time();
        $lastTime = $time - 90 * 24 * 3600;
        $this->fields = 'count(*)';
        $this->where = "model_id = $mid AND price_type in (0, 5) AND created > $lastTime";
        $count = $this->getResult(3);
        return $count;
    }

    function getPriceLogList($fields, $where, $flag = 2) {
        $this->fields = $fields;
        $this->where = $where;
        $result = $this->getResult($flag);
        return $result;
    }

    /**
     * 11活动页商情价
     * @param type $model_id 
     * @return type $arr  array()
     */
    function getList11ModelId($model_id) {
        $this->fields = "*";
        //时间范围
        $end_time = time();
        $start_time = time() - 45 * 24 * 3600;
        $this->where = "price_type=0 and model_id=$model_id and get_time>$start_time and get_time<$end_time";
        $result = $this->getResult(1);
        if (!$result) {
            $result = $this->getPriceLogList("*", "price_type =0 and model_id=$model_id and  price!='' order by price asc", 1);
            if (!$result) {
                $result = $this->getPriceLogList("*", "price_type=5 and model_id=$model_id and  price!='' order by get_time desc ", 1);
            }
        }

        return $result;
    }

    /**
     * 新版首页最新报价30天 （*3个月内  后加的为了填充页面数据）
     * @param type $name Description
     * 
     * @return type Description
     */
    function getNewPriceList() {
        $timestamp = time() - 3600 * 24 * 30 * 3;
        $this->tables = array(
            'cardb_pricelog' => 'cp',
            'cardb_model' => 'cm',
            'cardb_series' => 'cs',
        );

        $this->fields = "cs.series_alias,cs.series_name,cm.model_id,cm.model_price,cm.model_name,cp.dealer_name,cp.nude_car_rate,cp.get_time";
        $this->where = "cp.model_id=cm.model_id and cp.get_time>$timestamp and cp.price_type=0 and cm.series_id=cs.series_id and  cm.state in(3,8) order by  cp.get_time desc";
        $return = $this->joinTable(2);

        return $return;
    }

}

?>
