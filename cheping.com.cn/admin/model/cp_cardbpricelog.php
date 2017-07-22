<?php

/**
 * cardb_type
 * $Id: cp_cardbpricelog.php 1789 2016-03-24 08:39:22Z wangchangjiang $
 */
class cp_cardbPriceLog extends model {

    function __construct() {
        parent::__construct();
        $this->table_name = "cardb_pricelog";
        $this->realdata = new realdata();
        $this->oldcarval = new oldCarVal();
    }

    function getIndexHotcar($logId, $priceType) {
        if ($priceType == 3) {
            $this->tables = array(
              'cardb_model' => 'cm',
              'cardb_websaleinfo' => 'cw'
            );
            $this->fields = 'cm.model_id, cm.factory_id, cm.series_id, cm.brand_id, cm.model_name, cm.series_name, cm.model_price, cm.model_pic1, cw.buy_discount_price as bingo_price, cw.dealer_name, if(discount_end_date > 0, discount_end_date, online_end_date) as get_time';
            $this->where = "cm.model_id = cw.model_id AND cw.id = $logId";
            $result = $this->joinTable();
        } else {
            $this->tables = array(
              'cardb_model' => 'cm',
              'cardb_pricelog' => 'cp'
            );
            $this->fields = 'cm.model_id, cm.factory_id, cm.series_id, cm.brand_id, cm.model_name, cm.series_name, cm.model_price, cm.model_pic1, cp.price as bingo_price, cp.dealer_name, cp.get_time';
            $this->where = "cm.model_id = cp.model_id AND cp.id = $logId";
            $result = $this->joinTable();
        }
        if (!empty($result)) {
            switch ($priceType) {
                case 1:
                    $result['price_img'] = 'ss_an.jpg';
                    $result['price_notice'] = '“冰狗暗访价”是冰狗行情团队以“到店客户”身份获取的价格，优惠中不含官方补贴和礼包；专业的话术和议价流程，保证了我们获取的“行情”信息基本接近个人客户在该店的最终成交价；这里提取的是一定时间内最低的暗访价。';
                    break;
                case 2:
                    $result['price_img'] = 'meiti.jpg';
                    $result['price_notice'] = '“网络媒体价”是网络媒体公开展示的经销商报价，是由经销商报给网站的价格，可能会有概念模糊甚至不实的情况；该价格(或优惠幅度)可能含有官方补贴、置换补贴、贷款额外优惠、礼包宣称价值等；这里提取的是时间最近的网络媒体价。';
                    break;
                case 3:
                    $result['price_img'] = 'shuang11_biao.jpg';
                    $result['price_notice'] = '“双11价格”来自各网站“双11”活动专题，价格数据来源于电商和汽车行业各大门户、垂直媒体、特殊类型网站已公布的活动价格，由冰狗独家汇总、整理和发布。需留意，各家价格标准可能不同，个别价格可能体现的是综合优惠。';
                    break;
            }
            $result['discount'] = getDiscount($result['model_price'], $result['bingo_price']);
            $result['discount_val'] = formatDiscount($result['model_price'], $result['bingo_price']);
            $result['get_time'] = date('Y-m-d', $result['get_time']);
        }
        return $result;
    }

    function getBingoPriceInfo($mid, $logId) {
        $timestamp = time();
        $this->table_name = 'cardb_pricelog cp';
        $this->tables = array(
          'cardb_model' => 'cm',
          'dealer_info' => 'di'
        );
        $this->fields = 'cp.model_id, cm.st36, cm.st27, cm.st28, cm.date_id, cm.series_id, cm.st41, cm.st48, cp.price_type, cp.id as cp_id, cp.from_type, cp.oldcar_company_prize, cp.get_time, cp.rate, cp.down_payment, cp.interest_rate_fee, cp.low_year, cp.profess_level, cp.free_promotion_gift, cp.special_event, cp.dealer_name, cp.dealer_addr as dealer_area, cp.saler, di.dealer_linkman, cp.saler_tel, cp.dealer_tel, cp.pricelog_id, di.dealer_pic';
        $this->join_condition = array(
          'cm.model_id = cp.model_id',
          'cp.dealer_name = di.dealer_name'
        );
        $this->where = "cp.model_id = $mid AND cp.id = $logId";
        $row = $this->leftJoin();
        $modelId = $row['model_id'];
        //置换补贴
        $row['car_prize'] = $this->oldcarval->getOldCarList("car_prize", "model_id='{$modelId}'  and start_date<$timestamp and end_date>$timestamp", 3);
        $row['jnbt'] = $this->realdata->getContryBt($row);
        $pics = explode('|', $row['dealer_pic']);
        $priceType = $row['pricelog_id_from'];
        $row['dealer_pic'] = $pics[0];
        if ($priceType == 1) {
            $row['price_type_name'] = '冰狗暗访价';
            $row['get_type'] = '到店暗访';
            $row['dealer_tel'] = $row['saler_tel'];
            $row['dealer_linkman'] = $row['saler'];
            $row['cp_id'] = $row['pricelog_id'];
        } else {
            $row['price_type_name'] = '网络媒体价';
            $row['get_type'] = '汽车之家';
        }
        if ($row['get_time'])
            $row['get_time'] = date('Y-m-d', $row['get_time']);
        if (trim($row['rate']) == '有')
            $row['rate'] = "享受0利率,最短{$row['low_year']},首付{$row['down_payment']}";
        else
            $row['rate'] = '不祥';
        if ($row['car_prize'] > 0)
            $row['car_prize'] = $row['car_prize'] . '元';
        else
            $row['car_prize'] = '无';
        if (!$row['jnbt'])
            $row['jnbt'] = '无';
        foreach ($row as $k => $v) {
            $row[$k] = iconv('gbk', 'utf-8', $v);
        }
        return $row;
    }

    function getOffersPrice() {
        $this->tables = array(
          'cardb_model' => 'cm',
          'cardb_pricelog' => 'cp'
        );
        $timestamp = time();
        $lastTimestamp = $timestamp - 3600 * 24 * 45;
        $this->fields = 'cm.model_name, cp.get_time, cp.price, cp.id';
        $this->where = "cm.model_id = cp.model_id AND cp.price <> 0 AND cp.price_type = 0 AND get_time > $lastTimestamp AND get_time < $timestamp";
        $this->order = array('cp.get_time' => 'DESC');
        $this->limit = 15;
        $this->group = 'cp.series_id';
        $result = $this->joinTable(2);
        return $result;
    }

    function getPlogByType($model_id, $type) {
        $this->fields = 'price';
        $this->where = "model_id = $model_id AND price_type = $type";
        $this->order = array('get_time' => 'desc');
        return $this->getResult(3);
    }

    function getLog($model_id, $type) {
        $this->fields = "*";
        $this->where = "model_id={$model_id} and price_type={$type}";
        $this->order = array('updated' => 'desc');
        return $this->getResult();
    }

    function getPriceAndModel($priceid) {
        $this->tables = array(
          'cardb_pricelog' => 'cp',
          'cardb_model' => 'cm'
        );
        $this->where = "cp.model_id=cm.model_id and cm.state in (3,8) and cp.id=$priceid";
        $this->fields = "cm.model_name,cm.model_price,cm.series_name,cp.id,cp.price,cp.updated,cp.get_time,cp.creator,cp.model_id,cm.model_price-cp.price AS preferential";
        $res = $this->joinTable();
        if ($res)
            return $res;
        else
            return false;
    }

    function getPriceAndModelA($type, $where, $fields) {
        $this->tables = array(
          'cardb_pricelog' => 'cp',
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

    function getPriceAndModelB($fields) {
        $this->tables = array(
          'cardb_pricelog' => 'cp',
          'cardb_model' => 'cm',
          'cardb_salestate' => 'cs'
        );
        $this->join_condition = array('(cp.model_id=cm.model_id)', 'cm.model_id=cs.model_id');
        $this->where = 'cp.price_type=0 and cm.state in (3,8,11)';
        $this->fields = $fields;
        $this->order = array('cp.model_id' => 'ASC');
        $res = $this->leftJoin(2);
        if ($res)
            return $res;
        else
            return false;
    }

    function getWhere($fields, $model_id, $type, $extra = '') {
        $this->fields = $fields;
        $this->where = "model_id={$model_id} and price_type={$type}" . ($extra ? " and {$extra}" : "");
        $this->order = array('created' => 'desc');
        return $this->getResult();
    }

    function getLogs($model_id, $type, $limit = 10, $offset = 0) {
        $this->fields = "*";
        $this->where = "model_id={$model_id} and price_type={$type}";
        $this->order = array('updated' => 'desc');
        $this->limit = $limit;
        $this->offset = $offset;
        return $this->getResult(2);
    }

    function getAllLogs($isGroup, $isQuote, $price_type, $where = 1, $limit = 10, $offset = 0, $flag = '', $order = 'id') {
        if ($isGroup) {
            $this->tables = array(
              "(SELECT distinct(model_id) FROM cardb_pricelog where price_type=$price_type and $isQuote order by id desc)" => 'cp',
              'cardb_model' => 'm',
            );
        } else {
            $this->tables = array(
              "(SELECT model_id,price,get_time,id,updated,created,creator FROM cardb_pricelog where price_type=$price_type and $isQuote order by id desc)" => 'cp',
              'cardb_model' => 'm',
            );
        }
        $this->where = "cp.model_id=m.model_id AND m.state IN (3,7,8,11)" . $where;
        $this->fields = 'count(*) count';
        $totalInfo = $this->joinTable();
        //echo $this->sql;
        $this->total = $totalInfo['count'];

        if ($isGroup) {
            $this->tables = array(
              "(SELECT t.* FROM cardb_pricelog t, (SELECT SUBSTRING_INDEX(GROUP_CONCAT(id ORDER BY $order DESC),',',1) AS id FROM cardb_pricelog WHERE price_type=$price_type AND $isQuote GROUP BY model_id) p WHERE t.id=p.id)" => 'cp',
              'cardb_model' => 'm',
            );
        }
        $this->fields = "cp.model_id,cp.price,cp.creator,cp.get_time,cp.id,cp.updated,cp.created,m.model_name,m.series_name,m.brand_name,m.model_price,m.model_price-cp.price AS preferential";
        $this->limit = $limit;
        $this->offset = $offset;
        $this->order = array($order => 'desc');
        $res = $this->joinTable(2);
        //echo $this->sql;
        return $res;
    }

    function getPrice($id) {
        $this->fields = "*";
        $this->where = "id={$id}";
        return $this->getResult();
    }

    function getPriceTid($modelId, $typeId) {
        $this->fields = 'price';
        $this->where = "model_id = $modelId AND price_type = $typeId";
        $this->order = array('created' => 'DESC');
        $result = $this->getResult(3);
        return $result;
    }

    function getPrices($fields, $where, $type = 1) {
        $this->fields = $fields;
        $this->where = $where;
        $result = $this->getResult($type);
        return $result;
    }

    function getAllType() {
        $this->fields = "*";
        $cartype = $this->getResult(2);
        return $cartype;
    }

    function insertPricelog($ufields) {
        $this->ufields = $ufields;
        $id = $this->insert();
        return $id;
    }

    function updatePricelog($ufields, $where) {
        $this->ufields = $ufields;
        $this->where = $where;
        return $this->update();
    }

    function getPriceByModelid($fields, $where, $order, $limit, $type = 1) {
        $this->fields = $fields;
        $this->where = $where;
        $this->order = $order;
        $this->limit = $limit;
        $res = $this->getResult($type);
        if ($res) {
            return $res;
        } else {
            return false;
        }
    }

    function delPricelog($priceandmodel) {
        $msg;
        $msgNum1 = 0;
        $msgNum2 = 0;
        $msgError;
        $model = new cardbmodel();
        if (is_array($priceandmodel)) {
            foreach ($priceandmodel as $pmkey => $pmlist) {
                $pml = explode('-', $pmlist);
                if ($pml[0]) {
                    $this->where = "id={$pml[0]}";
                    $delFlag = $this->del();
                    if ($delFlag)
                        $msgNum1 ++;
                    else
                        $msgError .= $this->sql . "\r\n";
                }
                if ($pml[1]) {
                    #start 更新cardb_modelprice中对应的价格
                    $upFlag = $model->updatePrice($pml[1], array('dealer_price' => 1));
                    #end
                    if ($upFlag)
                        $msgNum2 ++;
                    else
                        $msgError .= $model->sql . "\r\n";
                }
            }
        }else {
            $pml = explode('-', $priceandmodel);
            if ($pml[0]) {
                $this->where = "id={$pml[0]}";
                $delFlag = $this->del();
                if ($delFlag)
                    $msgNum1 = 1;
                else
                    $msgError .= $this->sql . "\r\n";
            }
            if ($pml[1]) {
                #start 更新cardb_modelprice中对应的价格
                $upFlag = $model->updatePrice($pml[1], array('dealer_price' => 1));
                #end
                if ($upFlag)
                    $msgNum2 = 1;
                else
                    $msgError = $model->sql . "\r\n";
            }
        }
        return array($msgNum1, $msgNum2, $msgError);
    }

    function joinTableCardbmodel($fields, $where, $order, $limit, $group, $flag = 1) {
        $this->tables = array(
          'cardb_pricelog' => 'cp',
          'cardb_model' => 'cm'
        );
        $this->fields = $fields;
        $this->where = $where;
        if ($order)
            $this->order = $order;
        else
            $this->order = '';
        $this->limit = $limit;
        if ($group)
            $this->group = $group;
        else
            $this->group = '';
        return $this->joinTable($flag);
    }

    function getIndexRmdArticle($logId) {
        if (empty($logId))
            return false;
        $this->tables = array(
          'cardb_series' => 'cs',
          'cardb_model' => 'cm',
          'cardb_pricelog' => 'cp'
        );
        $this->fields = 'cm.model_id, cm.series_name, cm.model_name, cm.model_pic1, cm.model_price, cs.series_alias, cp.price, cp.id, cs.series_id';
        $this->where = "cs.series_id = cm.series_id AND cm.model_id = cp.model_id AND cp.id = $logId";
        $result = $this->joinTable();
        return $result;
    }

}

?>
