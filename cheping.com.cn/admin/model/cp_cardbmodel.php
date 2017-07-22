<?php

/**
 * model
 * $Id: cp_cardbmodel.php 1789 2016-03-24 08:39:22Z wangchangjiang $
 */
class cp_cardbModel extends model {

    function __construct() {
        parent::__construct();
        $this->table_name = "cardb_model";
    }

    function formatModelName($model, $length) {
        $modelName = $model['model_name'];
        $str = '/(\d+款 )/';
        $replacement = "\$1 {$model['series_name']} ";
        $name = preg_replace($str, $replacement, $modelName);
        $model['model_name'] = $name;
        $model['short_name'] = string::get_str($name, $length);
        return $model;
    }
    
    /**
     * 根据车款名称和车系名称，取车款记录
     * 
     * @param string $model_name 车款名称
     * @param string $series_name 车系名称
     * @return array 车款数组
     */
    function getModelByName($model_name, $series_name){
        $this->fields = "*";
        $this->where = "model_name='{$model_name}' and series_name='{$series_name}'";
        return $this->getResult();
    }
    
    function getModelHitsByType($type_id) {
        $counter = new counter();
        $tmptime = time() - 3600 * 24 * 7;
        $counter->group = "c2";
        $counter->order = array("cun" => "DESC");
        $counter->tables = array("counter" => "c", "cardb_model" => "cm");
        $counter->fields = "cm.model_id, cm.model_name, cm.series_name, cm.model_price, IFNULL(cm.bingo_price, cm.dealer_price_low) as bingobang_price, c.c1, c.c2, COUNT(*) AS cun";
        $counter->limit = 10;
        //因统计停用，不使用
        //$counter->where = " c.c1='model' AND c.c2>0 and c.c2 = cm.model_id AND cm.type_id = $type_id AND c.created > $tmptime AND cm.state in (3,7)";
        //取最新的数据
        $counter->where = " c.c1='model' AND c.c2>0 and c.c2 = cm.model_id AND cm.type_id = $type_id AND cm.state in (3,7)";
        $counter->order = array('c.id' => 'DESC');

        $hit = $counter->joinTable(2);
        foreach ($hit as &$row) {
            $row = $this->formatModelName($row, 28);
        }
        return $hit;
    }

    function chkModel($fields, $where, $order, $flag = 2, $limit = 1) {
        $this->fields = $fields;
        $this->where = $where;
        $this->order = $order;
        $result = $this->getResult($flag);
        return $result;
    }
    
    function getAllModel($where = '1', $order = array(), $limit = 1, $offset = 0) {
        $this->tables = array(
            'cardb_brand' => 'b',
            'cardb_factory' => 'f',
            'cardb_series' => 's',
            'cardb_model' => 'm',
        );

        $this->where = $where;
        $this->fields = "count(m.model_id)";
        $this->total = $this->joinTable(3);

        $this->fields = "m.model_id,m.model_name,m.state,m.bingo_price,m.sale_price,m.dealer_price_low,m.model_price,m.date_id,m.views, s.dealer_price_low as series_dealer_price_low, s.series_id,s.last_picid, s.series_name,s.state as ss,s.price_low,s.series_intro,s.series_pic,s.series_pic2,f.factory_id as id, f.factory_id,f.factory_name,f.state as fs,b.brand_name,b.brand_id,b.letter,b.state as bs,m.created,m.updated,m.bingo_updated,m.st4,m.st21,m.unionpic,m.is_sportcar,m.model_pic1";
//      $this->fields = "m.model_id,m.st98,m.st97,m.st95,m.st74,m.st75,m.st86,m.st100,m.st102,m.st171,m.st112,m.st107,m.st150,m.st80,m.st148,m.st69,m.st62,m.st63,m.st64,m.st65,m.st66,m.st67,m.st68";
        $this->limit = $limit;
        $this->offset = $offset;
        if (!empty($order))
            $this->order = $order;

        return $this->joinTable(2, 0, $limit);
    }

    #获取车款，分页
    function getModels($where = '1', $order = array(), $limit = 1, $offset = 0) {
        $this->where = $where;
        $this->fields = "count(*)";
        $this->total = $this->getResult();

        $this->fields = "*";
        $this->limit = $limit;
        $this->offset = $offset;
        if (!empty($order))
            $this->order = $order;

        return array('res' => $this->getResult(2), 'total' => $this->total);
    }

    function getDiscountRank($fields, $where) {
        $this->fields = $fields;
        $this->where = $where;
        $this->order = array('(model_price - bingo_price)' => 'DESC');
        $this->limit = 10;
        $result = $this->getResult(2);
        return $result;
    }

    function getBrandModel($fields, $where, $flag, $order = '', $limit = 1) {
        $this->tables = array(
            'cardb_brand' => 'b',
            'cardb_model' => 'm'
        );
        $this->fields = $fields;
        $this->where = $where;
        $this->order = $order;
        $this->limit = $limit;
        $result = $this->joinTable($flag);
        return $result;
    }    
    function getSelectJson() {
        $timestamp = time();
        $lastTimestamp = $timestamp - 24 * 3600 * 45;
        $this->tables = array(
            'cardb_model' => 'cm',
            'cardb_pricelog' => 'cp'
        );        
        $this->fields = 'cm.model_id, count(*) as count_mid';
        $this->where = "cm.model_id = cp.model_id AND cm.state in (3, 8)  AND cp.price > 0 AND cp.price_type = 0";
        $this->group = 'cm.model_id';
        $modelIds = $this->joinTable(2);
        if(!empty($modelIds)) {
            $idList = '';
            foreach($modelIds as $k => $v) {
                if($v['count_mid'] > 1) $idList .= ','.$v['model_id'];
            }
            $idList = ltrim($idList, ',');
            $this->tables = array(
                'cardb_model' => 'cm',
                'cardb_brand' => 'cb'
            );
            $this->fields = "cb.brand_id, cb.brand_name, cb.letter";
            $this->where = "cm.brand_id = cb.brand_id AND cm.model_id in ($idList)";        
            $this->order = array("cb.letter" => 'ASC');
            $this->group = "brand_id";            
            $result = $this->joinTable(2);
            foreach($result as $k => $v) {
                $result[$k]['brand_name'] = iconv('gbk', 'utf-8', $v['brand_name']);
            }  
            $data['brand_js'] = json_encode($result);
            unset($result);
            $this->fields = 'series_id, series_name, brand_id';
            $this->where = "model_id in ($idList)";
            $this->order = array('series_id' => 'ASC');
            $this->group = 'series_id';
            $result = $this->getResult(2);
            foreach($result as $k => $v) {
                $v['series_name'] = iconv('gbk', 'utf-8', $v['series_name']);
                $seriesJs[$v['brand_id']][$v['series_id']] = $v;
            }    
            $data['series_js'] = json_encode($seriesJs);
            return $data;            
        }                
        else return false;
    }    

    function getJsonData() {
        $brand_js = $series_js = $model_js = $date = array();
        $models = $this->getAllModel(
                'm.series_id=s.series_id and s.factory_id=f.factory_id and f.brand_id=b.brand_id and (m.state=3 or m.state=7 or m.state=8) and f.state=3 and s.state=3 and b.state=3', array('b.letter' => 'asc', 's.series_name' => 'asc'), 0, 4000
        );
        foreach ($models as $k => $v) {
            if (!array_key_exists($v['brand_id'], $brand_js)) {
                $ispic = 0;
                if ($v['last_picid'] > 0) {
                    $ispic = 1;
                }
                $brand_js[$v['brand_id']] = array(
                    'brand_id' => $v['brand_id'],
                    'brand_name' => iconv('gbk', 'utf-8', $v['brand_name']),
                    'letter' => $v['letter'],
                    'ispic' => $ispic,
                );
            } else {
                if ($v['last_picid'] > 0 && $brand_js[$v['brand_id']]['ispic'] != 1) {
                    $brand_js[$v['brand_id']]['ispic'] = 1;
                }
            }

            if (!array_key_exists($v['series_id'], (array) $series_js[$v['brand_id']]))
                $series_js[$v['brand_id']][$v['series_id']] = array(
                    'series_id' => $v['series_id'],
                    'series_name' => iconv('gbk', 'utf-8', $v['series_name']),
                    'brand_id' => $v['brand_id'],
                    'series_pic' => $v["series_pic"],
                    'last_picid' => $v['last_picid'],
                );

            #if(!array_key_exists($v['model_id'], (array)$model_js[$v['series_id']]))
            $tmp[] = array(
                'model_id' => $v['model_id'],
                'model_name' => iconv('gbk', 'utf-8', $v['model_name']),
                'series_id' => $v['series_id'],
                'date_id' => $v['date_id'],
            );
            $date[] = $v['date_id'];
        }

        $brand_js = array_values($brand_js);

        #车款按年代重新排序
        /* foreach ($model_js as $k => $v) {
          $date[$k] = $v['date_id'];
          } */
        array_multisort($date, SORT_DESC, $tmp);
        foreach ($tmp as $k => $v) {
            $model_js[$v['series_id']][$v['model_id']] = $v;
        }
        return array(
            'brand' => json_encode($brand_js),
            'series' => json_encode($series_js),
            'model' => json_encode($model_js),
        );
    }
    
    function geSeriesFromFactory($fid = 0){
        $this->tables = array(
          'cardb_model' => 'm',
          'cardb_series' => 's'
        );
        $this->fields = "s.*";
        $this->where = "s.factory_id='{$fid}' and m.state in (3,8) and m.series_id=s.series_id";
        $this->group = 'm.series_id';
        $series = $this->joinTable(2);
        return $series;
    }

    //======================================    
    function getModel($id) {
        $this->fields = "*";
        $this->where = "model_id='{$id}'";
        $result = $this->getResult(1);
        return $result;
    }

    function getSeriesId($id) {
        $this->fields = "series_id,series_name";
        $this->where = "model_id='{$id}'";
        $result = $this->getResult(1);
        return $result;
    }

    function getLastModelBySid($sid) {
        $this->fields = "*";
        $this->where = "series_id='{$sid}' and state=3";
        $this->order = array('model_id' => 'desc');
        return $this->getResult();
    }

    //根据$modelid判断series的last_picid是否为本车款id，如果是的话，重设series的last_picid值
    function getSeriesmodels($modelid) {
        $this->tables = array(
            'cardb_series' => 's',
            'cardb_model' => 'm',
        );
        $this->fields = "m.model_id,s.series_id,s.last_picid";
        $this->where = " s.series_id=m.series_id and m.model_id='$modelid'";
        $seriesmodel = $this->joinTable(1);
        //如果series_id==$modelid
        if ($seriesmodel["last_picid"] == $modelid) {
            $this->where = " s.series_id=m.series_id and m.series_id='" . $seriesmodel["series_id"] . "' and (m.state=3 or m.state=7 or m.state=8) and m.unionpic='1'";
            $this->order = array("m.model_id" => "DESC");
            $last_picid = $this->joinTable(3);
            $last_picid = $last_picid ? $last_picid : "0";
            $series = new series();
            $series->ufields = array("last_picid" => "$last_picid");
            $series->where = "series_id='" . $seriesmodel["series_id"] . "'";
            $series->update();
        }
    }

    function getSimpleModel($where = 1, $limit = 1, $offset = 0, $order = array()) {
        $this->fields = "*";
        $this->where = $where;
        $this->limit = $limit;
        $this->order = $order;
        $this->offset = $offset;

        return $this->getResult(2);
    }

    function getSimpleModels($where = 1, $limit = 1, $offset = 0, $order = array(), $tables = array()) {
        $this->where = $where;
        $this->limit = $limit;
        $this->order = $order;
        $this->offset = $offset;
        $this->tables = $tables;
        return $this->joinTable(2);
    }

    function getModelBySid($sid, $model_name = '', $state = '3,8') {
        $this->where = "series_id='{$sid}' and state in($state) "
                . ($model_name ? " and model_name='{$model_name}'" : "");
        $this->fields = "model_id,brand_id,factory_id,brand_name,factory_name,series_name,model_id as new_model_id, model_name,dealer_price_low,st4,st21,date_id,series_id,model_pic1,model_pic2,state";
        $this->getall = 1;
        return $this->getResult(4);
    }

    function getModelParamFields() {
        $sql = "SHOW COLUMNS FROM " . $this->table_name;
        $ret = $this->db->getAll($sql);
        $cols = array();
        foreach ($ret as $key => $value) {
            preg_match('/st(\d+)/', $value['Field'], $st_id);
            if ($st_id[1]) {
                $cols[$st_id[1]] = $value['Type'];
            }
        }
        return $cols;
    }

    function getPriceRange() {
        $this->fields = "MAX(model_price) AS max_price, MIN(model_price) AS min_price";
        $ret = $this->getResult();
        $min = sprintf('%.2f', $ret['min_price']);
        $max = sprintf('%.2f', $ret['max_price']);
        return array('min_price' => $min, 'max_price' => $max);
    }

    function getDealerPriceLowBySid($sid) {
        $this->fields = "dealer_price_low";
        $this->where = "series_id='{$sid}' and dealer_price_low>0 and (state=3 or state=7 or state=8)";
        $this->order = array('dealer_price_low' => 'asc');
        $ret = $this->getResult(3);
        return $ret;
    }

    function convertSt2Txt($id) {
        $paramtxt = new paramtxt();
        $st = $this->getModel($id);
        $ret = $paramtxt->st2ParamTxt($st);
        return $ret;
    }

    function getStyleRange($sid = 0) {
        $this->fields = "st4,st21,date_id,st15";
        $this->where = ($sid ? "series_id='{$sid}' and " : "") . "(state=3 or state=8 or state=7) AND st4<>'' AND st4 IS NOT NULL";
        $this->group = $this->fields;
        $range = $this->getResult(2);
        return $range;
    }

    function getStylePower($sid = 0) {
        $this->fields = "date_id, st27, st41, st28, st48";
        $this->where = ($sid ? "series_id='{$sid}' and " : "") . "(state=3 or state=8 or state=7) AND st4<>'' AND st4 IS NOT NULL";
        $this->group = $this->fields;
        $range = $this->getResult(2);
        return $range;
    }

    /**
     * 计算竞争车款
     * 返回竞争车款id
     * 满足4个条件：
     *  1 同级别 [-最新算法，使用竞争车系]
     *  2 车门数 相同 [-最新算法要求去掉]
     *  3 价格 上下价格差15%
     *  4 动力 上下动力差15%
     *  5 燃油类型
     * @param mixed $model_id
     */
    function getCompeteModel($id) {
        $cardbseries = new series();

        $cur_model = $this->getModel($id);
        $series = $cardbseries->getSeries($cur_model['series_id']);

        #价格区间
        $min_price = $cur_model['model_price'] * (1 - 0.15);
        $max_price = $cur_model['model_price'] * (1 + 0.15);
        
        #如果该车系没有竞争车系信息，返回False
        if(empty($series['compete_id'])) return false;
        
        #价格区间车款
        $this->where = "state=3 and model_price>{$min_price} and model_price<{$max_price} and series_id in (" . $series['compete_id'] . ")";
        $this->fields = "model_id,series_id,model_name,series_name,st21,st36,st41,st37,model_price";
        $allmodel = $this->getResult(2);
        
        if (!$allmodel)
            return '';

        #var_dump($allmodel);
        foreach ($allmodel as $key => $value) {
            $model_ida[] = $value['model_id'];
        }

        #动力
        $min_power = $cur_model['st36'] * (1 - 0.15);
        $max_power = $cur_model['st36'] * (1 + 0.15);
        foreach ($allmodel as $key => $value) {
            if ($value['st36'] > $min_power && $value['st36'] < $max_power) {
                $po_model[] = $value;
                $po_model_id[] = $value['model_id'];
            }
        }
        $this->debug && print_r($po_model);

        if (count($po_model_id) < 2)
            return $model_ida;
        $model_ida = $po_model_id;

        #车系去重 
        foreach ($po_model as $key => $value) {
            $tmp = abs($value['model_price'] - $cur_model['model_price']);
            $series_price[$value['series_id']][$value['model_id']] = $tmp;
        }

        foreach ($series_price as $key => $value) {
            $tmp = $value;
            sort($tmp);
            $min_price_model[] = array_search($tmp[0], $value);
        }
        $this->debug && print_r($po_model);

        return $min_price_model;
    }

    function getDatabyState($state) {
        $this->fields = "count(*) as sum";
        $this->where = "1 and state='$state'";
        return $this->getResult(3);
    }

    function getPic($where) {
        $this->fields = "count(*) as sum";
        $this->where = $where;
        return $this->getResult(3);
    }

    function upDataState($state, $id) {
        //修改车款状态
        $this->ufields = array(
            'state' => $state
        );
        $this->where = " model_id='{$id}'";
        $this->update();

        $model = $this->getModel($id);
        $this->updatebingoprice($model['series_id']);
        var_dump($this->sql);
        return 1;
    }

    //根据seriesid取出最小的model
    function getMinpricemodel($seriesid) {
        $this->fields = "model_id,model_name,series_id,series_name,bingo_price,model_price,model_pic1,model_pic2,brand_id,brand_name,factory_id,factory_name,date_id,compete_id,type_id,type_name,unionpic,state";
        $this->where = " series_id='{$seriesid}'  and (state=3 or state=7 or state=8) ";
        $this->order = array("model_price" => "ASC");
        $result = $this->getResult(1);
        if (!empty($result["model_pic1"])) {
            $result["firstpic"] = "attach/images/model/" . $result['model_id'] . "/180x100" . $result["model_pic1"];
        } else if (!empty($result["model_pic2"])) {
            $result["firstpic"] = "attach/images/model/" . $result['model_id'] . "/180x100" . $result["model_pic2"];
        }
        return $result;
    }

    function getModelbydealer($id) {
        $this->fields = "model_id,model_name,series_id,series_name,brand_id,brand_name,bingo_price,model_price,model_pic1,model_pic2,factory_id,factory_name,date_id,compete_id,type_id,type_name,unionpic,state";
        $this->where = "model_id='{$id}'";
        $result = $this->getResult(1);
        return $result;
    }

    /**
     * 取指定车系的车款冰狗价
     * 最低和最高价格
     * 
     * @param mixed $series_id
     * @return array $result
     */
    function getBingoPriceRange($series_id) {
        $this->fields = "min(bingo_price) as min_price, max(bingo_price) as max_price";
        $this->where = "series_id='{$series_id}' and bingo_price>0 and (state=3 or state=7 or state=8)";
        $result = $this->getResult(1);
        return $result;
    }

    /**
     * 修改bingo_price
     * 同时更新cardb_series表bingo_price_low,bingo_price_high
     * @param <type> $model_id
     * @param <type> $series_id
     * @param <type> $bingo_price
     * @return <type>
     */
    function editbingoprice($model_id, $series_id, $bingo_price) {
        $this->ufields = array('bingo_price' => $bingo_price, 'bingo_updated' => time());
        $this->where = "model_id = $model_id";
        $res = $this->update();
        $search_index = new searchIndex();
        $search_index->where = "model_id = $model_id";
        $search_index->ufields = array('bingo_price' => $bingo_price,);
        $search_index->update();
        if ($model_id) {
            $price_info = $this->getBingoPriceRange($series_id);
            $min_price = floatval($price_info['min_price']);
            $max_price = floatval($price_info['max_price']);
            $series = new series();
            $series->where = "series_id = $series_id";
            $series->ufields = array("bingo_price_low" => $min_price, "bingo_price_high" => $max_price, "updated" => time());
            $series->update();
        }
        return $res;
    }

    /**
     * 取指定车系的车款指导价，冰狗价
     * 最低和最高价格
     *
     * @param mixed $series_id
     * @return array $result
     */
    function getSeriesPriceRange($series_id) {
        $this->fields = "min(bingo_price) as min_price, max(bingo_price) as max_price, 
      min(model_price) as min_model_price,max(model_price) as max_model_price,
      min(dealer_price_low) as min_dealer_price, max(dealer_price_high) as max_dealer_price";
        $this->where = "series_id='{$series_id}' and bingo_price>0 and (state=3 or state=7 or state=8)";
        $result = $this->getResult(1);
        return $result;
    }

    function updatebingoprice($series_id) {
        $price_info = $this->getSeriesPriceRange($series_id);
        $min_price = floatval($price_info['min_price']);
        $max_price = floatval($price_info['max_price']);
        $min_model_price = floatval($price_info['min_model_price']);
        $max_model_price = floatval($price_info['max_model_price']);
        $min_dealer_price = floatval($price_info['min_dealer_price']);
        $max_dealer_price = floatval($price_info['max_dealer_price']);
        $series = new series();
        $series->where = "series_id = $series_id";
        $series->ufields = array(
            "bingo_price_low" => $min_price,
            "bingo_price_high" => $max_price,
            "dealer_price_low" => $min_dealer_price,
            "dealer_price_high" => $max_dealer_price,
            "price_low" => $min_model_price,
            "price_high" => $max_model_price,
            "updated" => time());
        $res = $series->update();
        return $res;
    }

    function updateModel($ufields, $where) {
        $this->ufields = $ufields;
        $this->where = $where;
        return $this->update();
    }

    function getModelId($series_name, $model_name) {
        $this->fields = 'model_id';
        $this->where = "series_name='{$series_name}' and model_name='{$model_name}' and (state=3 or state=7 or state=8)";
        return $this->getResult(3);
    }

    /**
     * 根据指定条件取指定字段
     * @param string $fields
     * @param string $where
     * @return array
     */
    function getSimp($fields, $where, $flag = 2) {
        $this->fields = $fields;
        $this->where = $where;
        return $this->getResult($flag);
    }

	#从商情价和媒体价中取有效价格

	function updatePrice2($model_id){
		if(intval($model_id)<1){
			return false;
		}
		$time2 = time();
		$ufield2 = 0;
		$price_type2 = 0;
		$priceDay = 45; //更新价格时间范围，单位（天）
		$firstD = $time2 - 3600 * 24 * $priceDay;
		$pricelog_obj2 = new cardbPriceLog();
		$websaleinfo_obj2 = new websaleinfo();
		$price_obj2 = new cardbPrice();
		$search_obj2 = new searchIndex();
		$this->fields = "model_price";
		$this->where = "model_id=$model_id and state in (3,8)";
		$model_price2 = $this->getResult();
		if($model_price2['model_price']<1){
			return false;
		}
		/*$websaleinfo_info2 = $websaleinfo_obj2->getWebsaleAndOrder('id,nude_car_price,buy_discount_price,nude_car_rate,buy_discount_rate,from_channel', "model_id=$model_id and IF(discount_end_date>0,discount_end_date,offline_end_date)>$time2",array('nude_car_price'=>'asc','buy_discount_price'=>'asc','nude_car_rate'=>'asc','buy_discount_rate'=>'asc'),1);*/
		$pricelog_info2 = $pricelog_obj2->getPriceByModelid('id,price', "model_id=$model_id and price_type=0 and get_time between $firstD and $time2", array('price' => 'asc'), 1);
		if(!$pricelog_info2){
			$pricelog_info2 = $pricelog_obj2->getPriceByModelid('id,price', "model_id=$model_id and price_type=0", array('get_time' => 'desc'), 1);
			/*if(!$pricelog_info2){
				$pricelog_info2 = array('price'=>0);
			}*/
		}
		$pricelog_info_media = $pricelog_obj2->getPriceByModelid('id,price', "model_id=$model_id and price_type=5", array('get_time' => 'desc'), 1);
		/*if(!$pricelog_info_media){
			$pricelog_info_media = array('price'=>0);
		}
		if($websaleinfo_info2){
			$websaleinfo_info2['price'] = $websaleinfo_info2['nude_car_price']>0 ? $websaleinfo_info2['nude_car_price'] : ($websaleinfo_info2['buy_discount_price']>0 ? $websaleinfo_info2['buy_discount_price'] : ($websaleinfo_info2['nude_car_rate']>0 ? $model_price2['model_price']-$websaleinfo_info2['nude_car_rate'] : $model_price2['model_price']-$websaleinfo_info2['buy_discount_rate']));
		}else{
			$websaleinfo_info2 = array('price'=>0);
		}
		if($websaleinfo_info2['price']>0 && $pricelog_info2['price']>0){
			if($websaleinfo_info2['price'] >= $pricelog_info2['price']){
				$ufield2 = array('pricelog_id'=>$pricelog_info2['id'],'price'=>$pricelog_info2['price'],'pricelog_id_from'=>1,'price_type'=>6,'deliver_price'=>getDeliveryPrice($pricelog_info2['price']));
				$price_type2 = 1;
			}else{
				$ufield2 = array('pricelog_id'=>$websaleinfo_info2['id'],'price'=>$websaleinfo_info2['price'],'pricelog_id_from'=>3,'price_type'=>6,'price_from'=>$websaleinfo_info2['from_channel'],'deliver_price'=>getDeliveryPrice($websaleinfo_info2['price']));
				$price_type2 = 3;
			}
		}elseif($websaleinfo_info2['price']>0 && $pricelog_info2['price']==0){
			$ufield2 = array('pricelog_id'=>$websaleinfo_info2['id'],'price'=>$websaleinfo_info2['price'],'pricelog_id_from'=>3,'price_type'=>6,'price_from'=>$websaleinfo_info2['from_channel'],'deliver_price'=>getDeliveryPrice($websaleinfo_info2['price']));
			$price_type2 = 3;
		}elseif($pricelog_info2['price']>0 && $websaleinfo_info2['price']==0){
			$ufield2 = array('pricelog_id'=>$pricelog_info2['id'],'price'=>$pricelog_info2['price'],'pricelog_id_from'=>1,'price_type'=>6,'deliver_price'=>getDeliveryPrice($pricelog_info2['price']));
			$price_type2 = 1;
		}else*/
		if($pricelog_info2){
			$ufield2 = array('pricelog_id'=>$pricelog_info2['id'],'price'=>$pricelog_info2['price'],'pricelog_id_from'=>1,'price_type'=>6,'deliver_price'=>getDeliveryPrice($pricelog_info2['price']));
			$price_type2 = 1;
		}elseif($pricelog_info_media){
			$ufield2 = array('pricelog_id'=>$pricelog_info_media['id'],'price'=>$pricelog_info_media['price'],'pricelog_id_from'=>2,'price_type'=>6,'deliver_price'=>getDeliveryPrice($pricelog_info_media['price']));
			$price_type2 = 2;
		}
		if($ufield2){
			$discount2 = number_format($ufield2['price']/$model_price2['model_price'],3,'.','')*10;
			$this->ufields = array('dealer_price_low'=>$ufield2['price']);
			$this->where = "model_id=$model_id";
			$this->update();
			$this->saveLog('modify_cardb_model_nov11.txt', $i . '--' . date('Y/m/d h:i:s') . '  sql：' . $this->sql . "\n");
			$search_obj2->ufields = array('price_type'=>$price_type2,'bingo_price'=>$ufield2['price'],'discount'=>$discount2,'spread'=>$model_price2['model_price']-$ufield2['price']);
			$search_obj2->where = "model_id=$model_id";
			$search_obj2->update();
			$this->saveLog('modify_search_index_nov11.txt', $i . '--' . date('Y/m/d h:i:s') . '  sql：' . $search_obj2->sql . "\n");
			$price_obj2_flag = $price_obj2->getPriceByModelId('id', "model_id=$model_id and price_type=6");
			if($price_obj2_flag ){
				$price_obj2->updateModelPrice($ufield2, $model_id, 6);
				$this->saveLog('modify_cardb_price_nov11.txt', $i . '--' . date('Y/m/d h:i:s') . '  sql：' . $price_obj2->sql . "\n");
			}else{
				$ufield2['model_id'] = $model_id;
				$price_obj2->ufields = $ufield2;
				$price_obj2->insert();
				$this->saveLog('insert_cardb_price_nov11.txt', $i . '--' . date('Y/m/d h:i:s') . '  sql：' . $price_obj2->sql . "\n");
			}
		}

	}
    /**
     * 更新指定车款价格数据
     * @param int $model_id  车款ID
     * @param array $price_array [model_price=>指导价, bingo_price=>帮买价, dealer_price=>商情价, cost_price=>成本价,most_price=>最多人购买价]
     * @return boolean 
     */
    function updatePrice($model_id, $price_array = array(), $i = 1, $city = '北京') {
        $series_obj = new series();
        $modelprice_obj = new modelprice();
        $search_obj = new searchIndex();
        $pricelog_obj = new cardbPriceLog();
        $price_obj = new cardbprice();
        $modelprice_obj->checkByModelId($model_id);
        #指导价
        if (isset($price_array['model_price'])) {
            $search_obj->ufields['model_price'] = $modelprice_obj->ufields['model_price'] = $this->ufields['model_price'] = $price_array['model_price'];
        }

        #帮买价
        if (isset($price_array['bingo_price'])) {
            $modelprice_obj->ufields['bingo_price'] = $this->ufields['bingo_price'] = $price_array['bingo_price'];
        }

        #商情价,提车价
        if (isset($price_array['dealer_price'])) {
            $priceDay = 45; //更新价格时间范围，单位（天）
            $lastD = time();
            $firstD = $lastD - 3600 * 24 * $priceDay;
            $bingoPrice = $pricelog_obj->getPriceByModelid('*', "model_id=$model_id and price_type=0 and get_time between $firstD and $lastD", array('price' => 'asc'), 1);
			if(!$bingoPrice){
				$bingoPrice = $pricelog_obj->getPriceByModelid('*', "model_id=$model_id and price_type=0", array('get_time' => 'desc'), 1);
			}
            //echo $pricelog_obj->sql;
            //$mediaPrice = $pricelog_obj->getPriceByModelid('*', "model_id=$model_id and price_type=5 and get_time between $firstD and $lastD", array('price' => 'asc'), 1);
			//echo $pricelog_obj->sql;
            //exit;
			$price_state = 0;
            /*if ((($bingoPrice['price'] > $mediaPrice['price']) && $mediaPrice['price'] > 0) or ($bingoPrice['price'] < 1 && $mediaPrice['price'] > 0)) {
                unset($mediaPrice['id']);
                unset($mediaPrice['model_id']);
                $mediaPrice['deliver_price'] = $mediaPrice['deliver_price'] ? $mediaPrice['deliver_price'] : getDeliveryPrice($mediaPrice['price']);
                $modelprice_obj->ufields['dealer_price'] = $search_obj->ufields['bingo_price'] = $this->ufields['dealer_price_low'] = $mediaPrice['price'];
                $search_obj->ufields['delivery_price'] = $modelprice_obj->ufields['delivery_price'] = $mediaPrice['deliver_price'];
                $search_obj->ufields['updated'] = $this->ufields['updated'] = $lastD;
                $price_obj->ufields = $mediaPrice;
                $price_type = $mediaPrice['price_type'];
            } else */if ($bingoPrice) {
                $this->fields = "model_price";
                $this->where = "model_id=$model_id and state in (3,8)";
                $tempInfo = $this->getResult();
				if($tempInfo && $tempInfo['model_price']){
					$bingoPrice['pricelog_id'] = $bingoPrice['id'];
					unset($bingoPrice['id']);
					$bingoPrice['deliver_price'] = ($bingoPrice['deliver_price'] && $bingoPrice['deliver_price'] !='0.00') ? $bingoPrice['deliver_price'] : getDeliveryPrice($bingoPrice['price']);
					$modelprice_obj->ufields['dealer_price'] = $search_obj->ufields['bingo_price'] = $this->ufields['dealer_price_low'] = $bingoPrice['price'];
					$search_obj->ufields['delivery_price'] = $modelprice_obj->ufields['delivery_price'] = $bingoPrice['deliver_price'];
					$search_obj->ufields['updated'] = $this->ufields['updated'] = $lastD;
					$search_obj->ufields['spread'] = ($bingoPrice['price'] && $bingoPrice['price'] != '0.00') ? $tempInfo['model_price'] - $bingoPrice['price'] : 0;
					$search_obj->ufields['discount'] = ($bingoPrice['price'] && $bingoPrice['price'] != '0.00') ? round($bingoPrice['price'] / $tempInfo['model_price'], 3) * 10 : 10;
					$price_obj->ufields = $bingoPrice;
					$price_type = $bingoPrice['price_type'];	
				}else{
					$search_obj->ufields = $modelprice_obj->ufields = $price_obj->ufields = '';
				}
            } else {
                $this->fields = "dealer_price_low,bingo_price";
                $this->where = "model_id=$model_id and state in (3,8)";
                $mminfo = $this->getResult();
                if ($mminfo) {
                    #$tempprice = (empty($mminfo['bingo_price']) || $mminfo['bingo_price'] == '0.00') ? $mminfo['dealer_price_low'] : $mminfo['bingo_price'];
					$tempprice = 0;
                    $modelprice_obj->ufields['dealer_price'] = $search_obj->ufields['bingo_price'] = $this->ufields['dealer_price_low'] = $tempprice;
                    $search_obj->ufields['delivery_price'] = $modelprice_obj->ufields['delivery_price'] = getDeliveryPrice($tempprice);
					$search_obj->ufields['updated'] = $lastD;
					$search_obj->ufields['spread'] = 0;
					$search_obj->ufields['discount'] = 10;
					$price_state = 1;
					$price_type = 0;
					$price_obj->ufields = 1;
                } else {
                    $search_obj->ufields = $modelprice_obj->ufields = $price_obj->ufields = '';
                }
            }
        }
        #成本价
        if (isset($price_array['cost_price'])) {
            $search_obj->ufields['cost_price'] = $modelprice_obj->ufields['cost_price'] = $price_array['cost_price'];
        }

        #最多人购买价
        if (isset($price_array['most_price'])) {
            $search_obj->ufields['most_price'] = $modelprice_obj->ufields['most_price'] = $price_array['most_price'];
        }

        #cardb_model => dealer_price_low
        /*if ($this->ufields) {
            $this->where = "model_id='{$model_id}' and state in (3,8)";
            $mr = $this->update();
            $this->ufields = '';
            $this->saveLog('modify_cardb_model.txt', $i . '--' . date('Y/m/d h:i:s') . '  sql：' . $this->sql . "\n");
        }*/

        #cardb_modelprice => dealer_price,delivery_price
        if ($modelprice_obj->ufields) {
            $modelprice_obj->where = "model_id='{$model_id}'";
            $pr = $modelprice_obj->update();
            $modelprice_obj->ufields = '';
            $this->saveLog('modify_cardb_modelprice.txt', $i . '--' . date('Y/m/d h:i:s') . '  sql：' . $modelprice_obj->sql . "\n");
        }
		#cardb_price => *
        if ($price_obj->ufields) {
			$price_obj->fields = 'id';
            $price_obj->where = "model_id=$model_id and price_type=$price_type and city='$city'";
			$priceIsExist = $price_obj->getResult();
			if($priceIsExist){
				if($price_state){
					$price_obj->del();
				}else{
					unset($bingoPrice['model_id']);
					$price_obj->update();
				}
			}
			elseif(!$price_state && $price_ufields != 1){
				$price_obj->insert();
			}
            $price_obj->ufields = '';
            $this->saveLog('modify_cardb_price.txt', $i . '--' . date('Y/m/d h:i:s') . '  sql：' . $price_obj->sql . "\n");
        }

        /**
         * 更新search_index表中的帮买/商情价 bingo_price
         * 先判断车款价格表 cardb_modelprice中是否有bingo_price/dealer_price
         * 优先取bingo_price，如没有，使用dealer_price
         */
        /*if ($search_obj->ufields) {
            $search_obj->where = "model_id='{$model_id}'";
            $sr = $search_obj->update();
            $search_obj->ufields = '';
            $this->saveLog('modify_cardb_search.txt', $i . '--' . date('Y/m/d h:i:s') . '  sql：' . $search_obj->sql . "\n");
        }*/
		$this->updatePrice2($model_id);
        return true;
    }

    /**
     * 保存日志
     */
    function saveLog($name, $log) {
        $path = SITE_ROOT . 'data/log';
        file::forcemkdir($path);
        $file = $path . '/' . $name;
        file_put_contents($file, $log, FILE_APPEND);
    }

    /**
     * 根据车系取出在售车款
     * @param type $series_id  
     * @param type $state
     * @return type
     */
    function getModelist($series_id) {
        $this->fields = "model_id,series_id,brand_id,model_name,series_name,brand_name,state";
        $this->where = "series_id=$series_id and state=3";
        return $this->getResult(2);
    }

    function updateUnionPic() {
        $this->table_name = 'cardb_model a INNER JOIN (SELECT type_id AS model_id FROM cardb_file WHERE ppos=1 GROUP BY type_id HAVING COUNT(*)>3) b ON a.model_id=b.model_id';
        $this->ufields = array(
            'a.unionpic' => 1
        );
        $r = $this->update();
        $this->table_name = 'cardb_model';

        if ($r) {
            return $this->affectedrows;
        } else {
            return $r;
        }
    }
    
    function getField($field, $model_id){
        $this->fields = $field;
        $this->where = "model_id='{$model_id}'";
        return $this->getResult(3);
    }
    /**
     * 统计车款北京在售状态
     */
    function getModelNowshow($fields,$where,$flag=2){
        $this->tables = array(
            'cardb_salestate' => 's',
            'cardb_model' => 'm',
        );
        $this->fields = $fields;
        $this->where = $where;
        $seriesmodel = $this->joinTable($flag);
        return $seriesmodel;
    }
    /**
     * 车款颜色块是否已匹配
     */
    function getModelColor($fields,$where,$flag=2){
        $this->tables = array(
            'cardb_color' => 'c',
            'cardb_model' => 'm',
        );
        $this->fields = $fields;
        $this->where = $where;
        $seriesmodel = $this->joinTable($flag);
        return $seriesmodel;
    }
}

?>
