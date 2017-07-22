<?php

/**
 * $Id: index.php 2097 2016-04-15 12:26:02Z david $
 */
class index extends model {
    
    var $allModel = array(
        'focus5' => '轮播图-5',
        'focus2' => '上下图',
        'hotarticle' => '热点新闻',
        'discount' => '综合优惠急诊科',
        'loanreplace' => '置换/贷款',
        'upcoming' => '新车',
        'modelpk' => '车型PK'
    );    
    #车体结构
    var $st = array(
        1 => '承载式车身',
        2 => '非承载式车身',
    );
    #国别
    var $bi = array(
        1 => '自主',
        2 => '美系',
        3 => '日系',
        4 => '欧系',
        5 => '韩系',
    );    
    #车型
    var $ct = array(
        1 => '微型车',
        2 => '小型车',
        3 => '紧凑型车',
        4 => '中型车',
        5 => '中大型车',
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
        7 => 12
    );
    #座位
    var $zw = array(
        1 => 2,
        3 => 4,
        4 => 5,
        5 => 6,
        6 => 7,
        7 => 8,
        8 => 9
    );

    #排量
    var $pl = array(
        '1.0以下',
        '1.0-1.5',
        '1.5-2.0',
        '2.0-3.0',
        '3.0-4.0',
        '4.0-6.0',
        '6.0以上'
    );
    #配置
    var $sp = array(
        'sp1' => 'GPS导航',
        'sp2' => '定速巡航',
        'sp3' => '倒车视频',
        'sp4' => '倒车雷达',
        'sp5' => '自动空调',
        'sp6' => '分区空调',
        'sp7' => '自动天窗',
        'sp8' => '全景天窗',
        'sp9' => '&nbsp;&nbsp;多碟CD',
        'sp10' => '座椅加热',
        'sp11' => '主动刹车',
        'sp12' => '自动泊车',
        'sp13' => '副驾安全气囊',
        'sp14' => '真/仿皮座椅',
        'sp15' => '第三排座椅',
    );    
    var $fi = array(
        1 => '自主',
        2 => '合资',
        3 => '进口',
    );

    #st50
    var $bsx = array(
        1 => '手动变速箱(MT)',
        2 => '双离合变速箱(DCT)',
        3 => '无级变速箱(CVT)',
        4 => '序列变速箱(AMT)',
        5 => '自动变速箱(AT)',
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
//    );

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
        7 => 'coupe',
        8 => '敞篷车'
    );
    var $pr = array(
       1=> '5万以下',
       2=> '5-8万',
       3=>'8-10万',
       4=>'10-15万',
       5=>'15-20万',
       6=>'20-25万',
       7=>'25-35万',
       8=>'35-50万',
       9=>'50-70万',
       10=>'70万以上',
    );    
    function __construct() {
        parent::__construct();
        $this->table_name = 'page_data';
        $this->priceSelect = array(
            '5万以下',
            '5-8万',
            '8-10万',
            '10-15万',
            '15-20万',
            '20-25万',
            '25-35万',
            '35-50万',
            '50-70万',
            '70-100万',
            '100万以上'
        );
    }

    //查找大家都在看
    function getLook() {
        $this->fields = '*';
        $this->where = "name='look'";
        return $this->getResult();
    }

    function getSelectInfo() {
        $brand = new brand();
        $factory = new factory();
        $series = new series();
        $brandSelect = $factorySelect = $seriesSelect = array();
        $brandSelect = $brand->getBrands('brand_id, letter, brand_name', 'state = 3', 4);
        $factorySelect = $factory->getBrandFactory();
        $seriesSelect = $series->getFactorySeries();
        $select = array(
            'brandSelect' => $brandSelect,
            'factorySelect' => $factorySelect,
            'seriesSelect' => $seriesSelect
        );
        return $select;
    }
    
    function getModList($ufields) {
        global $timestamp;
        $dayTimestamp = 3600 * 24;
        $yestoday = $timestamp - $dayTimestamp;
        $startTime = date('Y-m-d', $yestoday);        
        $endTime = date('Y-m-d', $timestamp + 10 * $dayTimestamp);
        $this->where = "start_time >= '$startTime' AND start_time <= '$endTime'";
        foreach($ufields as $k => $v) {
            $this->where .= " AND $k = '$v'";
        }        
        $this->fields = 'start_time, value, state, start_time as date';
        $this->order = array('start_time' => 'ASC');
        $result = $this->getResult(4);
        for($i=0; $i<11; $i++) {
            $timestamp = $yestoday + $i * $dayTimestamp;
            $date = date('Y-m-d', $timestamp);
            if(!isset($result[$date]))
                $modList[$date] = array();
            else
            {
                $modList[$date] = unserialize($result[$date]['value']);
                $modList[$date]['date'] = $result[$date]['date'];
                $modList[$date]['state'] = $result[$date]['state'];
            }
        }
        return $modList;
    }
    function getHotartHistroy($ufields, $limit, $offset) {
        foreach($ufields as $k => $v) {
            $this->where .= " AND $k = '$v'";
        }
        $this->where = ltrim($this->where, ' AND');
        $this->fields = 'count(*)';
        $total = $this->getResult(3);
        $this->fields = 'value, start_time';
        $this->order = array('start_time' => 'DESC');
        $this->limit = $limit;
        $this->offset = $offset;
        $result = $this->getResult(2);
        $history = array();
        foreach($result as $k => $v) {
            $history[$v['start_time']] = mb_unserialize($v['value']);
        }
        $ret = array(
            'total' => $total,
            'history' => $history
        );
        return $ret;
    }
}

?>
