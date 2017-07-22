<?php

/**
 * $Id: searchindex.php 2363 2016-04-29 06:04:02Z cuiyuanxin $
 */
class searchIndex extends model {

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
//    var $ot = array(
//        1 => '汽油',
//        2 => '柴油',
//        3 => '油电混合',
//        4 => '电动'
//    );
    
    var $ot = array(
        '汽油' => 1,
        '柴油' => 2,
        '插电式混合动力' => 3,
        '油电混合' => 3,
        '增程式' => 3,
        '纯电动' => 4,
        '电动' => 4,
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
        8 => '敞篷车'
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
        array('low' => 100, 'high' => 0),
    );
    var $ct = array(
        1 => '微型车',
        2 => '小型车',
        3 => '紧凑型车',
        4 => '中型车',
        5 => '大型车',
        6 => '豪华车',
        7 => '小型SUV',
        8 => '小型MPV',
        9 => '跑车',
        10 => '中大型SUV',
        11 => '中大型MPV'
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
        2 => 3,
        3 => 4,
        4 => 5,
        5 => 6,
        6 => 7,
        7 => 8,
        8 => 9
    );

    #排量
    var $pl = array(
        array('low' => 0, 'high' => '1.0'),
        array('low' => '1.1', 'high' => '1.6'),
        array('low' => '1.7', 'high' => '2.0'),
        array('low' => '2.1', 'high' => '2.5'),
        array('low' => '2.6', 'high' => '3.0'),
        array('low' => '3.1', 'high' => '4.0'),
        array('low' => '4.0', 'high' => '0'),
    );

    #安全防盗
    var $sc = array(
        1 => '车辆稳定性控制',
        2 => '氙灯',
        3 => '胎压监测',
        4 => '安全气囊',
    );

    #舒适性
    var $sp = array(
        1 => '泊车辅助',
        2 => '定速巡航',
        3 => '多功能方向盘',
        4 => '感应钥匙',
        5 => '手动模式',
        6 => '天窗',
        7 => '行车电脑',
        8 => '真皮座椅',
        9 => '自动空调',
        10 => '座椅电加热',
        11 => '座椅方向调节',
        12 => '自动头灯'
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

    function __construct() {
        parent::__construct();
        $this->table_name = "search_index";
        $this->series = new series();
    }

    /**
     * 把传入的车款参数数据，
     * 转化成searchIndex表规格数据
     * 插入searchIndex表
     * 
     * @param array $modeldata 车款数据的数组
     * @return boolean true/false
     */
    function addIndex($v, $debug = false) {
        //必须有厂商指导价
        if ($v['model_price'] <= 0)
            return false;
        $v['letter'] = util::Pinyin($v['brand_name']);
        #价格 pr
        foreach ($this->pr as $kk => $vv) {
            if ($vv['high'] == 0) {
                $high = 99999;
            } else {
                $high = $vv['high'];
            }
            if ($v['price'] >= $vv['low'] && $v['price'] < $high) {
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
        $v['dt'] = array_search(dstring::substring($v['st51'], 0, 2), $this->dt);
        #驱动形式 dr
        $v['dr'] = array_search(dstring::substring($v['st51'], -6, 12), $this->dr);
        #燃料类型 ot
        //$v['ot'] = array_search($v['st41'], $this->ot);
        $v['ot'] = $this->ot[$v['st41']];
        #车身形式 cs
        $v['cs'] = array_search($v['st4'], $this->cs);
        if (in_array($v['st4'], array('硬顶敞篷车', '软顶敞篷车')))
            $v['cs'] = 8;
        #座位数 zw
        $v['zw'] = array_search($v['st22'], $this->zw); //$v['st22'];
        #承载方式 st
        $v['st'] = $v['st'];
        if ($v['st55'] == '承载式') {
            $v['st'] = 1;
        } elseif ($v['st55'] == '非承载式') {
            $v['st'] = 2;
        }
        #配置选项
        $v['sp'] = array();
        $normal = array('标配', '●');
        //GPS导航系统
        $v['sp'][] = in_array($v['st129'], $normal) ? 1 : 0;
        //定速巡航
        $v['sp'][] = in_array($v['st97'], $normal) ? 1 : 0;
        //倒车视频影像
        $v['sp'][] = in_array($v['st99'], $normal) ? 1 : 0;
        //后倒车雷达--后驻车雷达
        $v['sp'][] = in_array($v['st230'], $normal) ? 1 : 0;
        //自动空调
        $v['sp'][] = in_array($v['st171'], $normal) ? 1 : 0;
        //分区空调--温度分区控制
        $v['sp'][] = in_array($v['st174'], $normal) ? 1 : 0;
        //自动天窗--电动天窗
        $v['sp'][] = in_array($v['st86'], $normal) ? 1 : 0;
        //全景天窗
        $v['sp'][] = in_array($v['st87'], $normal) ? 1 : 0;
        //多碟CD--多碟CD系统
        $v['sp'][] = in_array($v['st141'], $normal) ? 1 : 0;
        //座椅加热--前排座椅加热
        $v['sp'][] = in_array($v['st112'], $normal) ? 1 : 0;
        //主动刹车--主动刹车/主动安全系统
        $v['sp'][] = in_array($v['st179'], $normal) ? 1 : 0;
        //自动泊车--自动泊车入位
        $v['sp'][] = in_array($v['st177'], $normal) ? 1 : 0;
        //副驾安全气囊
        $v['sp'][] = in_array($v['st63'], $normal) ? 1 : 0;
        //真/仿皮座椅--真皮/仿皮座椅
        $v['sp'][] = in_array($v['st102'], $normal) ? 1 : 0;
        //第三排座椅       
        $v['sp'][] = in_array($v['st118'], $normal) ? 1 : 0;
//        #安全防盗 sc
//        $v['sc'] = array();
//        //气囊个数
//        $i = 0;        
//        if($v["st62"]=="标配" || $v["st62"] == '●'){$i++;}
//        if($v["st63"]=="标配" || $v["st63"] == '●'){$i++;}
//        if($v["st64"]=="标配" || $v["st64"] == '●'){$i+=2;}
//        if($v["st65"]=="标配" || $v["st65"] == '●'){$i+=2;}
//        if($v["st66"]=="标配" || $v["st66"] == '●'){$i++;}
//        if($v["st67"]=="标配" || $v["st67"] == '●'){$i++;}
//        if($v["st68"]=="标配" || $v["st68"] == '●'){$i+=2;}     
//                
//        if ($v['st80'] == '标配' || $v['st80'] == '●') {
//            $v['sc'][] = 1;
//        }else
//            $v['sc'][] = 0;
//        if ($v['st148'] == '标配' || $v['st148'] == '●') {
//            $v['sc'][] = 1;
//        }else
//            $v['sc'][] = 0;
//        if ($v['st69'] == '标配' || $v['st69'] == '●') {
//            $v['sc'][] = 1;
//        }else
//            $v['sc'][] = 0;
//        if ($i > 1) {
//            $v['sc'][] = 1;
//        }else
//            $v['sc'][] = 0;
//
//        #舒适及便利性 sp
//        if ($v['st98'] == '标配' || $v['st98'] == '●') {
//            $v['sp'][] = 1;
//        }else
//            $v['sp'][] = 0;
//        if ($v['st97'] == '标配' || $v['st97'] == '●') {
//            $v['sp'][] = 1;
//        }else
//            $v['sp'][] = 0;
//        if ($v['st95'] == '标配' || $v['st95'] == '●') {
//            $v['sp'][] = 1;
//        }else
//            $v['sp'][] = 0;
//        if ($v['st74'] == '标配' || $v['st74'] == '●') {
//            $v['sp'][] = 1;
//        }else
//            $v['sp'][] = 0;
//        if ($v['st75'] == '标配' || $v['st75'] == '●') {
//            $v['sp'][] = 1;
//        }else
//            $v['sp'][] = 0;
//        if ($v['st86'] == '标配' || $v['st86'] == '●') {
//            $v['sp'][] = 1;
//        }else
//            $v['sp'][] = 0;
//        if ($v['st100'] == '标配' || $v['st100'] == '●') {
//            $v['sp'][] = 1;
//        }else
//            $v['sp'][] = 0;
//        if ($v['st102'] == '标配' || $v['st102'] == '●') {
//            $v['sp'][] = 1;
//        }else
//            $v['sp'][] = 0;
//        if ($v['st171'] == '标配' || $v['st171'] == '●') {
//            $v['sp'][] = 1;
//        }else
//            $v['sp'][] = 0;        
//        if ($v['st112'] == '标配' || $v['st112'] == '●') {
//            $v['sp'][] = 1;
//        }else
//            $v['sp'][] = 0;       
//        if ($v['st107'] == '标配' || $v['st107'] == '●') {
//            $v['sp'][] = 1;
//        }else
//            $v['sp'][] = 0;        
//        if ($v['st150'] == '标配' || $v['st150'] == '●') {
//            $v['sp'][] = 1;
//        }else
//            $v['sp'][] = 0;        
        #变速箱 bsx
        if ($v['st50'] == '手动变速箱(MT)') {
            $v['bsx'] = 1;
        } elseif ($v['st50'] == '双离合变速箱(DCT)') {
            $v['bsx'] = 4;
        } elseif ($v['st50'] == '无级变速箱(CVT)') {
            $v['bsx'] = 3;
        } elseif ($v['st50'] == '序列变速箱(AMT)' || $v['st50'] == '机械式自动变速箱(AMT)') {
            $v['bsx'] = 5;
        } elseif ($v['st50'] == '自动变速箱(AT)') {
            $v['bsx'] = 2;
        }
        $v['bi'] = $v['brand_import'];

        $bingo_price = $v['price'];

        $priceType = $price['pricelog_id_from'];

        $searchPrice = $bingo_price > 0 ? $bingo_price : $v['model_price'];
        //优惠幅度
        $spread = $v['model_price'] - $searchPrice;
        //折扣
        $discount = round($searchPrice / $v['model_price'], 3) * 10;
        //等级
        $grade = $this->series->getSeriesdata('grade', "series_id = {$v['series_id']}", 3);
        if($searchPrice == 0){
            $bingo_price = $v['model_price'];
        }else{
            $bingo_price = $searchPrice;
        }
        //更新
        $this->ufields = array(
            'br' => $v['br'],
            'pr' => $v['pr'],
            'pl' => $v['pl'],
            'ct' => $v['ct'],
            'cs' => $v['cs'],
            'ot' => $v['ot'],
            'fi' => $v['fi'],
            'dt' => $v['dt'],
            'dr' => $v['dr'],
            'qg' => $v['qg'],
            'jq' => $v['jq'],
            'zw' => $v['zw'],
            'st' => $v['st'],
            'sp1' => $v['sp'][0],
            'sp2' => $v['sp'][1],
            'sp3' => $v['sp'][2],
            'sp4' => $v['sp'][3],
            'sp5' => $v['sp'][4],
            'sp6' => $v['sp'][5],
            'sp7' => $v['sp'][6],
            'sp8' => $v['sp'][7],
            'sp9' => $v['sp'][8],
            'sp10' => $v['sp'][9],
            'sp11' => $v['sp'][10],
            'sp12' => $v['sp'][11],
            'sp13' => $v['sp'][12],
            'sp14' => $v['sp'][13],
            'sp15' => $v['sp'][14],
            'bsx' => $v['bsx'],
            'bi' => $v['bi'],
            'model_id' => $v['model_id'],
            'model_price' => $v['model_price'],
            'letter' => $v['letter'],
            'series_id' => $v['series_id'],
            'series_name' => $v['series_name'],
            'series_alias' => $v['series_alias'],
            'factory_name' => $v['factory_name'],
            'brand_id' => $v['brand_id'],
            'model_name' => $v['model_name'],
            'st10' => floatval($v['st10']), /* 油耗 */
            'bingo_price' => $bingo_price,
            'price_type' => "$priceType",
            'tk' => $v['st36'] . '_' . $v['st27'] . '_' . $v['st28'],
            'state' => $v['state'],
            'updated' => time(),
            'model_pic' => $v['model_pic1'],
            'year' => $v['date_id'],
            'hot' => $v['views'],
            'grade' => $grade,
            //'mt' => $v['date_id'].'_'.$v['series_id'].'_'.$v['st27'].'_'.$v['st28'].'_'.$v['st41'].'_'.$v['st48'],
//            'cost_price' => $costPrice,
//            'most_price' => $mostPrice,
//            'delivery_price' => $delivery_price,
            'discount' => $discount,
            'spread' => $spread
        );
        $this->where = "model_id='{$v['model_id']}'";
        $this->fields = "id";
        $r = $this->getResult(3);
        if ($r) {
            #$t = $uc->update();
            $func = "update";
        } else {
            #$t = $uc->insert();
            $func = "insert";
        }
        if ($searchPrice > 0) {
            $t = $this->$func();
            if ($debug) {
                if ($t) {
                    echo $func . " (model_id:{$v['model_id']}) ok<br>\n";
                } else {
                    echo $func . " (model_id:{$v['model_id']}) err<br>" . $this->errorMsg() . "\n{$this->sql}\n";
                }
            } else {
                return $t;
            }
        }
    }

    /**
     * 把指定的车款
     * 添加到searchindex表
     */
    function addIndexById($modelid) {
        $model_obj = new cardbModel();
        $model = $model_obj->getModel($modelid);

        //必须有厂商指导价
        if ($model['model_price'] <= 0)
            return false;

        //取厂商相关信息
        $fact_obj = new factory();
        $fact = $fact_obj->getFactory($model['factory_id']);
        $model['factory_import'] = $fact['factory_import'];

        if (empty($model)) {
            return false;
        } else {
            return $this->addIndex($model);
        }
    }

    /**
     * 从searchindex表中删除指定车款数据
     * 
     * @param string $type 参数类型，品牌，车系或车款
     * @param mixed $modelid 对应type的ID
     * @return boolean true/false
     */
    function delIndex($type = 'model', $typeid) {
        //传入的type只能是品牌，车系，车款
        if (!in_array($type, array('brand', 'series', 'model'))) {
            return false;
        }

        $this->where = "{$type}_id='{$typeid}'";
        $this->ufields = array(
            'state' => 0,
        );
        $r = $this->update();
        return $r;
    }

}

?>
