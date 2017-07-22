<?php

/**
 * $Id: updatecache.php 6216 2015-02-25 03:18:14Z xiaodawei $
 */
class updateCache extends model {

    var $cache_hours = 24;
    var $cache;
    var $param_list = array(
        'br',
        'pr',
        'pl',
        'ct',
        'fi',
        'qg',
        'jq',
        'dt',
        'dr',
        'bsx',
        'ot',
        'cs',
        'zw',
        'st',
        'sc',
        'sp',
    );
    var $fi = array(
        1 => '自主',
        2 => '合资',
        3 => '进口',
    );

    #st50
    var $bsx = array(
        1 => array('手动变速箱(MT)', '手动'),
        4 => array('双离合变速箱(DCT)', '双离合'),
        3 => array('无级变速箱(CVT)', 'CVT'),
        5 => array('序列变速箱(AMT)', 'AMT'),
        2 => array('自动变速箱(AT)', '自动'),
    );

    #st51
    var $dr = array(
        1 => '前驱',
        2 => '后驱',
        3 => '四驱',
    );

    #st51
    var $dt = array(
        1 => '前置',
        2 => '中置',
        3 => '后置',
    );
    #st41
    var $ot = array(
        1 => '柴油',
        2 => '汽油',
        3 => '油电混合',
    );

    #st27
    /* var $pl = array(
      1 => '柴油',
      2 => '汽油',
      3 => '油电混合',
      ); */

    #st28
    var $jq = array(
        1 => '自然吸气',
        2 => '涡轮增压',
        3 => '机械增压',
        4 => '机械+涡轮增压',
    );

    #st4
    var $cs = array(
        1 => '两厢车',
        2 => '三厢车',
        3 => '旅行车',
        4 => '掀背车',
        5 => 'SUV',
        6 => 'MPV',
        7 => '硬顶跑车',
        8 => '软顶敞篷车',
        9 => '硬顶敞篷车',
    );
    var $pr = array(
        array('low' => 0, 'high' => 5),
        array('low' => 5, 'high' => 8),
        array('low' => 8, 'high' => 10),
        array('low' => 10, 'high' => 15),
        array('low' => 15, 'high' => 20),
        array('low' => 20, 'high' => 25),
        array('low' => 25, 'high' => 35),
        array('low' => 35, 'high' => 50),
        array('low' => 50, 'high' => 70),
        array('low' => 70, 'high' => 100),
        array('low' => 100, 'high' => 150),
        array('low' => 150, 'high' => 300),
        array('low' => 300, 'high' => 0),
    );
    var $ct = array(
        1 => '微型车',
        2 => '小型车',
        3 => '紧凑型车',
        4 => '中型车',
        5 => '中大型车',
        6 => '豪华车',
        7 => 'SUV',
        8 => 'MPV',
        9 => '跑车',
    );

    #汽缸数
    var $qg = array(
        1 => 3,
        2 => 4,
        3 => 5,
        4 => 6,
        5 => 8,
        6 => 10,
        7 => 12,
        8 => 16,
    );
    var $zw = array(
        1 => 2,
        2 => 4,
        3 => 5,
        4 => 6,
        5 => 7,
        6 => 8,
        7 => 9,
        8 => 10,
        9 => 11,
        10 => 14,
    );

    #排量
    var $pl = array(
        array('low' => 0, 'high' => '1.0'),
        array('low' => '1.0', 'high' => '1.5'),
        array('low' => '1.5', 'high' => '2.0'),
        array('low' => '2.0', 'high' => '2.5'),
        array('low' => '2.5', 'high' => '3.0'),
        array('low' => '3.0', 'high' => '4.0'),
        array('low' => '4.0', 'high' => '6.0'),
        array('low' => '6.0', 'high' => 0),
    );

    #安全防盗
    var $sc = array(
        1 => 'ABS',
        2 => '车辆稳定性控制',
        3 => '副驾气囊',
        4 => '发动机电子防盗',
    );

    #舒适性
    var $sp = array(
        1 => '车载导航',
        2 => '定速巡航',
        3 => '倒车雷达',
        4 => '车窗防夹手功能',
        5 => '中控锁',
        6 => '无钥匙启动',
        7 => '真皮/仿皮座椅',
        8 => '天窗',
    );
    var $st = array(
        1 => '承载式车身',
        2 => '非承载式车身',
    );
    var $bi = array(
        1 => '自主',
        2 => '美系',
        3 => '日系',
        4 => '欧系',
        5 => '韩系',
    );

    #品牌国别
    var $brand_import = array(
        1 => '自主',
        2 => '美系',
        3 => '日系',
        4 => '欧系',
        5 => '韩系',
    );

    #经销商最低报价
    var $dealer_price = 0;

    #折扣率，经销商报价/厂商指导价
    var $discount = 0;

    #车系用户评分
    var $series_score = 0;
    var $brand;
    var $series;
    var $model;

    function __construct() {
        global $_cache;
        parent::__construct();
        $this->cache = $_cache;
        $this->table_name = "cardb_series";

        $this->brand = new brand();
        $this->series = new series();
        $this->model = new cardbModel();
    }

    function getModel($debug = false) {
        $cache_key = "search_model_list";
        $cache_time = $this->cache_hours * 3600;
        $model = $this->getAllModel();

        #$model_list = $this->cache->getCache($cache_key);
        $pr_list = $model_list = $param_list = array();

        $br_list = $this->cache->getCache("br_key");
        if ($br_list)
            $debug && print("{$cache_key} cache exist!<br>\n");
        $model_list = $this->cache->getCache("model_key");
        if ($model_list)
            $debug && print("model_key cache exist!<br>\n");
        $param_list = $this->cache->getCache("param_key");
        if ($param_list)
            $debug && print("param_key cache exist!<br>\n");

        #if(!$param_list){
        #$debug && print("{$cache_key} not been cached!<br>\n"); 
        $model_list = array();
        foreach ($model as $k => $v) {
            $v['letter'] = util::Pinyin($v['brand_name']);

            #价格 pr
            foreach ($this->pr as $kk => $vv) {
                if ($vv['high'] == 0) {
                    $high = 99999;
                } else {
                    $high = $vv['high'];
                }
                if ($v['model_price'] >= $vv['low'] && $v['model_price'] < $high) {
                    $v['pr'] = $kk;
                    break;
                }
            }

            #排量 pl
            foreach ($this->pl as $kk => $vv) {
                if ($vv['high'] == 0) {
                    $high = 99999;
                } else {
                    $high = $vv['high'];
                }

                if (floatval($v['st27']) >= $vv['low'] && floatval($v['st27']) < $high) {
                    $v['pl'] = $kk;
                    break;
                }
            }

            #进口 fi
            $v['fi'] = $v['factory_import'];

            #品牌 br
            $v['br'] = $v['brand_id'];

            #级别 ct
            $v['ct'] = $v['type_id'];

            #缸数 qg
            $v['qg'] = array_search($v['st30'], $this->qg);
            ;

            #进气方式 jq
            if ($v['st28'] == '自然吸气') {
                $v['jq'] = 1;
            } elseif ($v['st28'] == '涡轮增压') {
                $v['jq'] = 2;
            } elseif ($v['st28'] == '机械增压') {
                $v['jq'] = 3;
            } elseif ($v['st28'] == '机械+涡轮增压') {
                $v['jq'] = 4;
            }

            #发动机位置 dt
            $v['dt'] = array_search(substr($v['st51'], 0, 4), $this->dt);

            #驱动形式 dr
            $v['dr'] = array_search(substr($v['st51'], 4), $this->dr);

            #燃料类型 ot
            if ($v['st41'] == '柴油') {
                $v['ot'] = 2;
            } elseif ($v['st41'] == '汽油') {
                $v['ot'] = 1;
            } elseif ($v['st41'] == '油电混合') {
                $v['ot'] = 3;
            }
            #车身形式 cs
            $v['cs'] = array_search($v['st4'], $this->cs);

            #座位数 zw
            $v['zw'] = array_search($v['st22'], $this->zw); //$v['st22'];
            #承载方式 st
            $v['st'] = $v['st'];
            if ($v['st55'] == '承载式') {
                $v['st'] = 1;
            } elseif ($v['st55'] == '非承载式') {
                $v['st'] = 2;
            }

            #安全防盗 sc
            $i = 0;
            if ($model["st62"] == "标配") {
                $i++;
            }
            if ($model["st63"] == "标配") {
                $i++;
            }
            if ($model["st64"] == "标配") {
                $i+=2;
            }
            if ($model["st65"] == "标配") {
                $i+=2;
            }
            if ($model["st66"] == "标配") {
                $i++;
            }
            if ($model["st67"] == "标配") {
                $i++;
            }
            if ($model["st68"] == "标配") {
                $i+=2;
            }
            $v['sc'] = array();
            if ($v['st76'] == '标配' || $v['st76'] == '●') {
                $v['sc'][] = 1;
            } else
                $v['sc'][] = 0;
            if ($v['st80'] == '标配' || $v['st80'] == '●') {
                $v['sc'][] = 1;
            } else
                $v['sc'][] = 0;
            if ($v['st63'] == '标配' || $v['st63'] == '●') {
                $v['sc'][] = 1;
            } else
                $v['sc'][] = 0;
            if ($v['st72'] == '标配' || $v['st72'] == '●') {
                $v['sc'][] = 1;
            } else
                $v['sc'][] = 0;

            #舒适及便利性 sp
            if ($v['st129'] == '标配' || $v['st129'] == '●') {
                $v['sp'][] = 1;
            } else
                $v['sp'][] = 0;
            if ($v['st97'] == '标配' || $v['st97'] == '●') {
                $v['sp'][] = 1;
            } else
                $v['sp'][] = 0;
            if ($v['st98'] == '标配' || $v['st98'] == '●') {
                $v['sp'][] = 1;
            } else
                $v['sp'][] = 0;
            if ($v['st158'] == '标配' || $v['st158'] == '●') {
                $v['sp'][] = 1;
            } else
                $v['sp'][] = 0;
            if ($v['st73'] == '标配' || $v['st73'] == '●') {
                $v['sp'][] = 1;
            } else
                $v['sp'][] = 0;
            if ($v['st75'] == '标配' || $v['st75'] == '●') {
                $v['sp'][] = 1;
            } else
                $v['sp'][] = 0;
            if ($v['st102'] == '标配' || $v['st102'] == '●') {
                $v['sp'][] = 1;
            } else
                $v['sp'][] = 0;
            if ($v['st86'] == '标配' || $v['st86'] == '●') {
                $v['sp'][] = 1;
            } else
                $v['sp'][] = 0;

            #变速箱 bsx
            if ($v['st50'] == '手动变速箱(MT)') {
                $v['bsx'] = 1;
            } elseif ($v['st50'] == '双离合变速箱(DCT)') {
                $v['bsx'] = 4;
            } elseif ($v['st50'] == '无级变速箱(CVT)') {
                $v['bsx'] = 3;
            } elseif ($v['st50'] == '序列变速箱(AMT)') {
                $v['bsx'] = 5;
            } elseif ($v['st50'] == '自动变速箱(AT)') {
                $v['bsx'] = 2;
            }
            #$model_list[] = $v;
            #break;
            #$letter_list[$v['letter']][$v['series_id']] = 1;

            $br_list[$v['br']] = array(
                'br' => $v['br'], /* brand_id */
                'brand_id' => $v['brand_id'], /* brand_id */
                'brand_name' => $v['brand_name'],
                'letter' => $v['letter'],
                'model_id' => $v['model_id'],
                'series_id' => $v['series_id'],
            );

            $model_list[$v['model_id']] = array(
                'model_id' => $v['model_id'],
                'model_name' => $v['model_name'],
                'mp' => $v['model_price'], /* model_price */
                'dpl' => $v['dealer_price_low'], /* dealer_price_low */
                'bi' => $v['brand_import'],
                'sn' => $v['series_name'], /* series_name */
                'si' => $v['series_id'], /* series_id */
                'fn' => $v['factory_name'], /* factory_name */
                /* 'fi' => $v['factory_id'],  factory_id */
                'letter' => $v['letter'],
                'state' => $v['state'],
                'st10' => $v['st10'],
            );

            $v['bi'] = $v['brand_import'];
            $param_list[$v['model_id']] = array(
                'model_id' => $v['model_id'],
                'brand_id' => $v['brand_id'],
                'letter' => $v['letter'],
                'series_id' => $v['series_id'],
                'param' => "{$v['br']}-{$v['pr']}-{$v['pl']}-{$v['ct']}-{$v['cs']}-{$v['ot']}-{$v['fi']}-{$v['dt']}-{$v['dr']}-{$v['qg']}-{$v['jq']}-{$v['zw']}-{$v['st']}-{$v['sc'][0]}-{$v['sc'][1]}-{$v['sc'][2]}-{$v['sc'][3]}-{$v['sp'][0]}-{$v['sp'][1]}-{$v['sp'][2]}-{$v['sp'][3]}-{$v['sp'][4]}-{$v['sp'][5]}-{$v['sp'][6]}-{$v['sp'][7]}-{$v['sp'][8]}-{$v['sp'][9]}-{$v['sp'][10]}-{$v['sp'][11]}-{$v['bsx']}-{$v['bi']}",
            );
        }

        /* if(!empty($model_list)){
          echo "value true;";
          } */
        $r = $this->cache->writeCache("br_key", $br_list, $cache_time);
        $debug && print("br:{$r};");
        $r = $this->cache->writeCache("model_key", $model_list, $cache_time);
        $debug && print("model:{$r};len:" . strlen(serialize($model_list)) . ";");

        $r = $this->cache->writeCache("param_key", $param_list, $cache_time);
        $debug && print("param:{$r};len:" . strlen(serialize($param_list)) . ";");

        return array(
            'br_key' => $br_list,
            'model_key' => $model_list,
            'param_key' => $param_list,
        );

        /* }else{
          $debug&&print("{$cache_key} has cached!<br>\n");
          } */
        /* return array(
          'br' => $br_list,
          'model' => $model_list,
          'param' => $param_list,
          ); */
    }

    function getAllModel($limit = 10, $debug = false) {
        $this->reset();
        $cache_key = "model_list";
        $cache_time = 12 * 3600;
        $this->table_name = "cardb_model";
        $model = array();
        /* $model = $this->cache->getCache($cache_key);
          if(!$model){ */
        $this->reset();
        $this->tables = array(
            'cardb_model' => 'm',
            'cardb_factory' => 'f',
            'cardb_series' => 's',
            'cardb_price' => 'p'
        );
        $this->where = "m.series_id = s.series_id AND m.factory_id = f.factory_id and s.state=3 and m.state in (3, 8) and m.model_id=p.model_id group by p.model_id limit " . $limit;
        $this->fields = 'f.factory_import,s.series_alias,m.*,p.price';
        $model = $this->joinTable(2);
        $r = $this->cache->writeCache($cache_key, $model, $cache_time);
        $debug && print("{$cache_key} has cached!({$r})<br>\n");
        #}
        #var_dump($model);
        return $model;
    }

    function count() {
        $this->tables = array(
            'cardb_model' => 'm',
            'cardb_factory' => 'f',
            'cardb_series' => 's',
            'cardb_price' => 'p'
        );
        $this->where = "m.series_id = s.series_id AND m.factory_id = f.factory_id and s.state=3 and m.state in (3, 8) and m.model_id=p.model_id";
        $this->fields = 'count(m.model_id) model_id';
        return $this->total = $this->joinTable(1);
    }

    function getBrand($debug = false) {
        $this->reset();
        $this->table_name = "cardb_brand";

        foreach (array(1, 2) as $type) {
            $cache_key = "brand_" . $type;
            $cache_time = $this->cache_hours * 3600;
            $brand = array();
            $brand = $this->cache->getCache($cache_key);
            if ($brand)
                $debug && print("{$cache_key} exist!<br>\n");
            #if(!$brand){
            #$debug && print("{$cache_key} not been cached!<br>\n");
            $this->fields = "brand_id, brand_name";
            $this->where = "state=3";
            $this->group = "brand_id";
            $ret = $this->getResult(4);

            foreach ($ret as $k => $v) {
                $letter = strtoupper(util::Pinyin($v));
                if (empty($letter))
                    continue;
                if ($type) {
                    $brand[$letter][] = array(
                        'brand_id' => $k,
                        'brand_name' => $v,
                        'letter' => $letter
                    );
                } else {
                    $brand[$k] = array(
                        'brand_id' => $k,
                        'brand_name' => $v,
                        'letter' => $letter
                    );
                }
            }
            $r = $this->cache->writeCache($cache_key, $brand, $cache_time);
            $debug && print("{$cache_key} has cached!({$r})<br>\n");
            /* }else{
              $debug && print("{$cache_key} has cached!<br>\n");
              } */
        }
        return $brand;
    }

    function getSeriesPicAssoc($debug = false) {
        $cache_key = "series_pic";
        $cache_time = 3600;
        $this->table_name = "cardb_series";
        $this->reset();
        $series_pic = $this->cache->getCache($cache_key);
        if ($series_pic)
            $debug && print("{$cache_key} exist!<br>\n");
        #if(!$series_pic){
        #$debug && print("{$cache_key} not been cached!<br>\n");
        $this->fields = "series_id, series_pic";
        $series_pic = $this->getResult(4);
        $this->cache->writeCache($cache_key, $series_pic, $cache_time);
        $debug && print("{$cache_key} has cached!<br>\n");
        /* }else{
          $debug && print("{$cache_key} has cached!<br>\n");
          } */
        return $series_pic;
    }

}

?>
