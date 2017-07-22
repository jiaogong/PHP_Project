<?php

/**
 * 文章搜索model，使用sphinx全文检索引擎，检索article表
 * $Id: search.php 79 2015-07-10 07:16:10Z cuiyuanxin$
 */
class search extends model {

    var $cache;
    var $brand;
    var $factory;
    var $series;
    var $model;
    var $file;
    var $type;
    var $match_count = array();
    var $default_sid = array(16, 497, 1022, 42, 119, 296, 295, 69, 247, 260);
    var $series_count = 0;
    var $model_count = 0;
    var $cache_hours = 24;
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
    var $_br;
    var $_pr;
    var $_pl;
    var $_ct;
    var $_fi;
    var $_qg;
    var $_jq;
    var $_dt;
    var $_dr;
    var $_bsx;
    var $_ot;
    var $_cs;
    var $_zw;
    var $_st;
    var $_sc;
    var $_sp;
    var $_bi;
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
        1 => '汽油',
        2 => '柴油',
        3 => '油电混合',
        4 => '纯电动'
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
        7 => 'coupe',
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
    var $pz = array(
        "st28" => "涡轮增压",
        "st42" => "97号油",
        "st58" => "电子驻车",
        "st54" => "电动助力",
        "st84" => "空气悬挂",
        "st183" => "ACC自适应巡航",
        "st82" => "陡坡缓降",
        "st178" => "并线辅助",
        "st99" => "倒车视屏影像",
        "st181" => "夜视系统",
        "st101" => "HUD抬头数字显示",
        "st217" => "可变转向比",
        "st156" => "四门电窗",
        "st160" => "电动后视镜",
        "st87" => "全景天窗",
        "st165" => "后风挡遮阳帘",
        "st162" => "后视镜自动防炫目",
        "st161" => "后视镜加热",
        "st160" => "后视镜电调节",
        "st149" => "日间行车灯",
        "st151" => "转向头灯（辅助灯）",
        "st152" => "前雾灯",
        "st153" => "大灯高度可调",
        "st154" => "大灯清洗",
        "st155" => "车内氛围灯",
        "st94" => "方向盘电动调节",
        "st96" => "方向盘换挡",
        "st221" => "座椅通风",
        "st223" => "座椅按摩",
        "st128" => "电动后备箱",
        "st172" => "后排独立空调",
        "st174" => "温度分区控制",
        "st176" => "车载冰箱",
        "st129" => "GPS",
        "st134" => "蓝牙/车载电话",
        "st147" => "》8喇叭扬声器系统",
        "st95" => "多功能方向盘",
        "st177" => "自动泊车",
        "st70" => "零压续行（防爆轮胎）",
        "st73" => "中控锁",
        "st75" => "无钥匙启动",
        "st62" => "安全气囊",
        'st98' => '泊车辅助',
        'st97' => '定速巡航',
        'st74' => '感应钥匙',
        'st86' => '天窗',
        'st100' => '行车电脑',
        'st102' => '真皮座椅',
        'st171' => '自动空调',
        'st112' => '前排座椅加热',
        'st150' => '自动头灯',
        'st107' => '座椅方向调节',
        'st80' => '车身稳定控制',
        'st148' => '氙灯',
        'st69' => '胎压监测',
        'st85' => '整体主动转向系统',
        'st103' => '运动风格座椅',
        'st104' => '座椅高低调节',
        'st105' => '腰部支撑调节',
        'st106' => '肩部支撑调节',
        'st107' => '前排座椅电动调节',
        'st108' => '第二排靠背角度调节',
        'st109' => '第二排座椅移动',
        'st110' => '后排座椅电动调节',
        'st111' => '电动座椅记忆',
        'st113' => '后排座椅加热',
        'st116' => '后排座椅整体放倒',
        'st117' => '后排座椅比例放倒',
        'st118' => '第三排座椅',
        'st125' => '前座中央扶手',
        'st126' => '后座中央扶手',
        'st127' => '后排杯架',
        'st130' => '定位互动服务',
        'st131' => '中控台彩色大屏',
        'st132' => '人机交互系统',
        'st133' => '内置硬盘',
        'st135' => '车载电视',
        'st136' => '后排液晶屏',
        'st137' => '外接音源接口(AUX/USB/iPod等)',
        'st138' => 'CD支持MP3/WMA',
        'st139' => '单碟CD',
        'st140' => '虚拟多碟CD',
        'st141' => '多碟CD系统',
        'st142' => '单碟DVD',
        'st143' => '多碟DVD系统',
        'st144' => '2-3喇叭扬声器系统',
        'st145' => '4-5喇叭扬声器系统',
        'st146' => '6-7喇叭扬声器系统',
        'st156' => '前电动车窗',
        'st157' => '后电动车窗',
        'st158' => '车窗防夹手功能',
        'st159' => '防紫外线/隔热玻璃',
        'st164' => '后视镜记忆',
        'st166' => '后排侧遮阳帘',
        'st167' => '遮阳板化妆镜',
        'st170' => '手动空调',
        'st173' => '后座出风口',
        'st175' => '车内空气调节/花粉过滤',
        'st179' => '主动刹车/主动安全系统',
        'st182' => '中控液晶屏分屏显示',
        'st221' => '前排座椅通风',
        'st222' => '后排座椅通风',
        'st223' => '前排座椅按摩',
        'st224' => '后排座椅按摩',
        'st226' => '外后视镜自动防眩目',
        'st227' => '主驾驶座椅电动调节',
        'st228' => '副驾驶座椅电动调节',
        'st64' => '前排侧气囊',
        'st65' => '后排侧气囊',
        'st66' => '前排头部气囊(气帘)',
        'st67' => '后排头部气囊(气帘)',
        'st68' => '膝部气囊',
        'st71' => '安全带未系提示',
        'st72' => '发动机电子防盗',
        'st76' => 'ABS防抱死',
        'st77' => '制动力分配(EBD/CBC等)',
        'st78' => '刹车辅助(EBA/BAS/BA等)',
        'st79' => '牵引力控制(ASR/TCS/TRC等)',
        'st81' => '自动驻车/上坡辅助',
        'st83' => '可变悬架',
        'st88' => '运动外观套件',
        'st89' => '铝合金轮毂',
        'st90' => '电动吸合门',
        'st91' => '真皮方向盘',
        'st92' => '方向盘上下调节',
        'st93' => '方向盘前后调节',
        'st62' => '主驾气囊',
        'st63' => '副驾气囊',
        "st184" => "全景摄像头",
        "st169" => "感应雨刷",
        "st168" => "后雨刷",
        'st225' => '内后视镜防炫',
        'st163' => '后视镜电折叠'
    );
    var $pzImg = array(
        "st28" => "xuanwo_zy.png",
        "st42" => "97hao_qy.png",
        "st58" => "dianzi_zc.png",
        "st54" => "diandong_zlzx.png",
        "st84" => "kongqi_xg.png",
        "st183" => "ACC_zishi.png",
        "st82" => "doupo_hj.png",
        "st178" => "bingxian_fz.png",
        "st99" => "daoche_yx.png",
        "st181" => "yeshi_xt.png",
        "st101" => "HUD_ttszxs.png",
        "st217" => "kebian_zxb.png",
        "st156" => "4m_dc.png",
        "st160" => "diandong_hsj.png",
        "st87" => "quanjing_tc.png",
        "st165" => "houfeng_dzyl.png",
        "st162" => "houshi_zdpxm.png",
        "st161" => "houshi_jr.png",
        "st160" => "houshi_dtj.png",
        "st149" => "rijian_xcd.png",
        "st151" => "zhuanxiang_td.png",
        "st152" => "qianwu_deng.png",
        "st153" => "dadeng_gdtj.png",
        "st154" => "dadeng_qx.png",
        "st155" => "fenwei_d.png",
        "st94" => "fangxiangp_ddtj.png",
        "st96" => "fangxiang_hd.png",
        "st221" => "zuoyi_tf.png",
        "st223" => "zuoyi_am.png",
        "st128" => "diandong_hbx.png",
        "st172" => "houpai_kt.png",
        "st174" => "wd_fqkz.png",
        "st176" => "chezai_bx.png",
        "st129" => "GPS.png",
        "st134" => "lanya.png",
        "st147" => "8laba-x.png",
        "st95" => "duogong_fxp.png",
        "st177" => "zidong_bcrw.png",
        "st70" => "lingya_xux.png",
        "st73" => "zhongkong_suo.png",
        "st75" => "wuyaoshi_qd.png",
        "st62" => "st_62.png",
        "st63" => "st_63.png",
        'st98' => 'daoche_ld.png',
        'st97' => 'dingsu_xh.png',
        'st74' => 'yaokong_yaoshi.png',
        'st86' => 'tianchuang.png',
        'st100' => 'xingche_dn.png',
        'st102' => 'zhenpi_zuoyi.png',
        'st171' => 'zidong_kt.png',
        'st112' => 'zuoyi_yaore.png',
        'st150' => 'zidong_daqi.png',
        'st107' => 'dd_zy.png',
        'st80' => 'ESP.png',
        'st148' => 'shanqi.png',
        'st69' => 'taiya_jiance.png',
        'st85' => 'st_85.png',
        'st103' => 'st_103.png',
        'st104' => 'st_104.png',
        'st105' => 'st_105.png',
        'st106' => 'st_106.png',
        'st107' => 'st_107.png',
        'st108' => 'st_108.png',
        'st109' => 'st_109.png',
        'st110' => 'st_110.png',
        'st111' => 'st_111.png',
        'st112' => 'st_112.png',
        'st113' => 'st_113.png',
        'st116' => 'st_116.png',
        'st117' => 'st_117.png',
        'st118' => 'st_118.png',
        'st125' => 'st_125.png',
        'st126' => 'st_126.png',
        'st127' => 'st_127.png',
        'st130' => 'st_130.png',
        'st131' => 'st_131.png',
        'st132' => 'st_132.png',
        'st133' => 'st_133.png',
        'st135' => 'st_135.png',
        'st136' => 'st_136.png',
        'st137' => 'st_137.png',
        'st138' => 'st_138.png',
        'st139' => 'st_139.png',
        'st140' => 'st_140.png',
        'st141' => 'st_141.png',
        'st142' => 'st_142.png',
        'st143' => 'st_143.png',
        'st144' => 'st_144.png',
        'st145' => 'st_145.png',
        'st146' => 'st_146.png',
        'st156' => 'st_156.png',
        'st157' => 'st_157.png',
        'st158' => 'st_158.png',
        'st159' => 'st_159.png',
        'st164' => 'st_164.png',
        'st166' => 'st_166.png',
        'st167' => 'st_167.png',
        'st170' => 'st_170.png',
        'st173' => 'st_173.png',
        'st175' => 'st_175.png',
        'st179' => 'st_179.png',
        'st182' => 'st_182.png',
        'st221' => 'st_221.png',
        'st222' => 'st_222.png',
        'st223' => 'st_223.png',
        'st224' => 'st_224.png',
        'st226' => 'st_226.png',
        'st227' => 'st_227.png',
        'st228' => 'st_228.png',
        'st64' => 'st_64.png',
        'st65' => 'st_65.png',
        'st66' => 'st_66.png',
        'st67' => 'st_67.png',
        'st68' => 'st_68.png',
        'st71' => 'st_71.png',
        'st72' => 'st_72.png',
        'st76' => 'st_76.png',
        'st77' => 'st_77.png',
        'st78' => 'st_78.png',
        'st79' => 'st_79.png',
        'st81' => 'st_81.png',
        'st83' => 'st_83.png',
        'st88' => 'st_88.png',
        'st89' => 'st_89.png',
        'st90' => 'st_90.png',
        'st91' => 'st_91.png',
        'st92' => 'st_92.png',
        'st93' => 'st_93.png',
        'st225' => 'st_225.png',
        'st184' => 'st_184.png',
        'st169' => 'st_169.png',
        'st168' => 'st_168.png',
        'st163' => 'st_163.png',
    );
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
        array('low' => 0, 'high' => '1.0'),
        array('low' => '1.1', 'high' => '1.6'),
        array('low' => '1.7', 'high' => '2.0'),
        array('low' => '2.1', 'high' => '2.5'),
        array('low' => '2.6', 'high' => '3.0'),
        array('low' => '3.1', 'high' => '4.0'),
        array('low' => '4.0', 'high' => '0'),
    );
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
    /*
      var $searchPz = array(
      'sp1' => '泊车辅助',
      'sp2' => '定速巡航',
      'sp4' => '感应钥匙',
      'sp5' => '手动模式',
      'sp7' => '行车电脑',
      'sp8' => '真皮座椅',
      'sp12' => '自动头灯',
      'sc3' => '胎压监测',
      'sc4' => '安全气囊',
      'sp9' => '自动空调',
      'sp10' => '座椅加热',
      'sc2' => '氙灯',
      'sp6' => '天窗',
      'sp3' => '多功能方向盘',
      'sp11' => '座椅方向调节',
      'sc1' => '车辆稳定性控制'
      );
     */
    var $st = array(
        1 => '承载式车身',
        2 => '非承载式车身',
    );
    var $br = array();
    var $bi = array(
        1 => '自主',
        2 => '美系',
        3 => '日系',
        4 => '欧系',
        5 => '韩系',
    );

    /**
     * 缓存时间
     */
    var $cache_time = array(
        'search_result' => 3600,
        'search_options' => 3600,
        'brand' => 3600,
        'series' => 3600,
        'model' => 3600,
        'model_st' => 3600,
        'nullrecord' => 43200,
        'search_price' => 3600
    );

    function __construct() {
        global $_cache;
        parent::__construct();
        $this->table_name = "cp_article";
        $this->cache = $_cache;
        $this->brand = new brand();
        $this->factory = new factory();
        $this->series = new series();
        $this->model = new models();
        $this->file = new Dbfile();
        $this->type = new type();
        $this->br = $this->getBrand(0);
        $this->priceinfo = new cardbPrice();
        $this->realdata = new realdata();
        $this->oldcarval = new oldCarVal();
    }

    function getBrand($type = 1) {
        $cache_key = "brand_" . $type;
        $cache_time = $this->cache_time['brand'];
        #echo "brand cache time:{$cache_time}<br>\n";
        $brand = $this->cache->getCache($cache_key);
        if (!$brand) {
            $brand = $this->model->getBrand($type);
            $this->cache->writeCache($cache_key, $brand, $cache_time);
        }

        return $brand;
    }

    /**
     * 搜索内容
     * 
     * @param mixed $a 搜索选项
     * @param mixed $strip
     * @param mixed $cdp 用户自定义价格区间
     */
    function getIndexSearchResult($a = array('pr' => '')) {
        global $timestamp;
        $cache_key = "search_" . md5(serialize($a));
        $cache_time = $this->cache_time['search_result'];
        #echo "search_result cache time:{$cache_time}<br>\n";

        $st_result = $this->cache->getCache($cache_key);

        if (!$st_result || $timestamp - $st_result['cache_time'] > $this->cache_time['search_result']) {
            #rebuild cache log
            #@error_log("rebuild IndexSearchResult[".date('Y/m/d H:i:s',$timestamp)."]:old_time-{$st_result['cache_time']},new_time-{$timestamp}\nUserAgent:".$_SERVER['HTTP_USER_AGENT']."-".util::getIp()."\nSearch Condition:".var_export($a,true)."\n",3,SITE_ROOT."/data/search.log");    
            $this->table_name = "search_index";
            $this->fields = "*";
            $this->where = "";
            if ($a['sk'])
                $this->where .= "factory_name like '%{$a['sk']}%' or series_name like '%{$a['sk']}%' and ";

            if (!$a['default_sid']) {
                foreach ($a as $k => $v) {
                    if (empty($v) && $k != 'sale' || $k == 'sk')
                        continue;
                    if (!is_array($v)) {
                        #状态
                        if ($k == 'sale') {
                            switch ($v) {
                                case 1: /* 在售 */
                                    $this->where .= "(state='3' or state='7') and ";
                                    break;
                                case 2: /* 停产在售 */
                                    $this->where .= "state='8' and ";
                                    break;
                                default:
                                    $this->where .= "(state='3' or state='7' or state='8') and ";
                            }
                        }
                        #价格区间
                        elseif ($k == 'cdp' && strpos($v, ',') !== false) {
                            $minprice = $maxprice = 0;
                            list($minprice, $maxprice) = explode(',', $v);
                            $minprice = intval($minprice);
                            $maxprice = intval($maxprice);
                            $_min = min($minprice, $maxprice);
                            $_max = max($minprice, $maxprice);
                            $minprice = $_min;
                            $maxprice = $_max;
                            $this->where .= "bingo_price >= '{$minprice}' and bingo_price < '{$maxprice}' and ";
                        } else
                            $this->where .= "{$k}='{$v}' and ";
                    }else {
                        $this->where .= "(";
                        foreach ($v as $vv) {
                            $this->where .= "{$k}='{$vv}' or ";
                        }
                        $this->where = substr($this->where, 0, -4) . ") and ";
                    }
                }
            } else {
                $defaultSids = implode(',', $this->default_sid);
                $this->where = "series_id in ($defaultSids) and ";
            }
            $this->order = array(
                'year' => 'DESC',
                'cs' => 'ASC',
                'model_price' => 'ASC'
            );
            $this->where = substr($this->where, 0, -4);
            $ret = $this->getResult(2);
            
            #echo mysql_error();
            #echo $this->where;
            #exit;
            //车系亮点配置
            $setting = array();
            $this->reset();
            $this->table_name = 'cardb_series_settings';
            $this->fields = 'series_id, st_id';
            $this->where = 'state = 1';
            $setResult = $this->getResult(2);
            foreach ($setResult as $set) {
                $setting[$set['series_id']][] = 'st' . $set['st_id'];
            }

            $result = $seriesModel = array();
            if (!empty($ret)) {
                foreach ($ret as $k => $v) {
                    $seriesId = $v['series_id'];
                    $seriesMid[$seriesId][] = $v['model_id'];
                    if (!array_key_exists($seriesId, $result)) {
                        $result[$seriesId]['model_count'] = 0;
                        $result[$seriesId] = array(
                            'series_id' => $seriesId,
                            'brand_id' => $v['brand_id'],
                            'bingo_price' => $v['bingo_price'],
                            'model_price' => $v['model_price'],
                            'brand_id' => $v['brand_id'],
                            'setting' => $setting[$seriesId]
                        );
                        #var_dump($result[$seriesId]['list']);
                        ++$series_count;
                    }
                    list($st36, $st27, $st28) = explode('_', $v['tk']);
                    $_key = $st36 . '_' . $st27 . '_' . $st28;
                    $v['st36'] = $st36;
                    $v['st27'] = $st27;
                    $v['st28'] = $st28;
                    $result[$seriesId]['list'][$_key][] = $v;
                    $result[$seriesId]['model_count'] ++;
                    ++$model_count;
                }
               
                $st_result = array('result' => $result, 'series_mid' => $seriesMid, 'cache_time' => time());
                $this->cache->writeCache($cache_key . "cnt", $series_count . "," . $model_count, $cache_time);
                $this->cache->writeCache($cache_key, $st_result, $cache_time);
            }
        }
        return $st_result;
    }

    function getSearchModelPrice() {
        global $timestamp;
        $cache_price_key = "bingoprice";
        $result = array();
        $ret = $this->cache->getCache($cache_price_key);
        if (!$ret || $timestamp - $ret['set_time'] > $this->cache_time['search_price']) {
            $this->table_name = "search_index";
            $this->fields = "model_id, price_type, bingo_price, model_price, spread, discount";
            $this->where = "";
            $ret = $this->getResult(4);
            $ret['set_time'] = $timestamp;
            $this->cache->writeCache($cache_price_key, $ret, $this->cache_time['search_price']);
        }
        return $ret;
    }

    function getSearchSeriesPrice($seriesMid, $ret) {
        if (!empty($seriesMid)) {
            foreach ($seriesMid as $seriesId => $mids) {
                foreach ($mids as $mid) {
                    $result[$seriesId]['spread'] = isset($result[$seriesId]['spread']) ? max($result[$seriesId]['spread'], $ret[$mid]['spread']) : $ret[$mid]['spread'];
                    if ($ret[$mid]['discount'] > 0)
                        $result[$seriesId]['discount'] = isset($result[$seriesId]['discount']) ? min($result[$seriesId]['discount'], $ret[$mid]['discount']) : $ret[$mid]['discount'];
                    if ($ret[$mid]['price_type'] == 1)
                        $result[$seriesId]['search_price_low'] = $result[$seriesId]['bingo_price_low'] = isset($result[$seriesId]['bingo_price_low']) ? min($result[$seriesId]['bingo_price_low'], $ret[$mid]['bingo_price']) : $ret[$mid]['bingo_price'];
                    if ($ret[$mid]['price_type'] == 2) {
                        $result[$seriesId]['search_price_low'] = $result[$seriesId]['media_price_low'] = isset($result[$seriesId]['media_price_low']) ? min($result[$seriesId]['media_price_low'], $ret[$mid]['bingo_price']) : $ret[$mid]['bingo_price'];
                    }
                    if ($ret[$mid]['price_type'] == 3) {
                        $result[$seriesId]['search_price_low'] = $result[$seriesId]['shuang11_price_low'] = isset($result[$seriesId]['shuang11_price_low']) ? min($result[$seriesId]['shuang11_price_low'], $ret[$mid]['bingo_price']) : $ret[$mid]['bingo_price'];
                    }
                    if ($ret[$mid]['price_type'] == 0) {
                        $result[$seriesId]['search_price_low'] = $result[$seriesId]['model_price_low'] = isset($result[$seriesId]['model_price_low']) ? min($result[$seriesId]['model_price_low'], $ret[$mid]['model_price']) : $ret[$mid]['model_price'];
                    }
                }
            }
        }
        return $result;
    }

    function sortSearchResult($result, $seriesPrice, $sortby, $sort) {
        $dr = $dv = $pr = array();
        foreach ($seriesPrice as $sid => $v) {
            $dr[] = $v['discount'];
            $dv[] = $v['spread'];
            $pr[] = $v['search_price_low'];
            $result[$sid]['discount'] = $v['discount'];
            $result[$sid]['spread'] = $v['spread'];
            $result[$sid]['search_price_low'] = $v['search_price_low'];
        }
        #处理排序
        if (!empty($result)) {
            switch ($sortby) {
                case 'dr':
                    if ($sort == 'asc') {
                        array_multisort($dr, SORT_ASC, $result);
                    } else {
                        array_multisort($dr, SORT_DESC, $result);
                    }
                    break;
                case 'pr':
                    if ($sort == 'asc') {
                        array_multisort($pr, SORT_ASC, $result);
                    } else {
                        array_multisort($pr, SORT_DESC, $result);
                    }
                    break;
                case 'dv':
                    if ($sort == 'asc') {
                        array_multisort($dv, SORT_ASC, $result);
                    } else {
                        array_multisort($dv, SORT_DESC, $result);
                    }
                    break;
            }
        }
        return $result;
    }

    function getSearchCount($a = array()) {
        $cache_key = "search_" . md5(serialize($a)) . "cnt";
        list($series_count, $model_count) = explode(',', $this->cache->getCache($cache_key));
        $series_count = $series_count ? $series_count : 0;
        $model_count = $model_count ? $model_count : 0;
        return array('series_count' => $series_count, 'model_count' => $model_count);
    }

    /**
     * 筛选搜索选项
     * cdp 用户自行输入的价格，半角逗号分隔
     * @param mixed $a 搜索选项值
     */
    function searchOption($a = array()) {
        global $timestamp;
        $option_cache_key = 'option_set_time';
        $search_index = $this->getModel($a['sale'], $a['cdp']);
        $param = $search_index['param'];
        $cache_key = "search_options_" . md5(serialize($a));
        $cache_time = $this->cache_time['search_options'];
        $option_set_time = $this->cache->getCache($option_cache_key);
        #echo "search_options cache time:{$cache_time}<br>\n";
        $r = $this->cache->getCache($cache_key);
        if (!$r || $timestamp - $option_set_time > $cache_time) {
            $r = array();
            #if(true){
            foreach ($param as $k => $v) {
                $t = $this->splitParam($v['param']);

                #初始化变量
                $_pr = $_pl = $_ct = $_cs = $_ot = $_qg = $_jq = $_st = $_zw = $_fi = $_dt = false;
                $_dr = $_bsx = $_br = $_bi = false;

                $this->_pr[$v['model_id']] = $_pr = (!empty($a['pr']) && in_array($t['pr'], $a['pr']) || empty($a['pr']) );
                $this->_pl[$v['model_id']] = $_pl = (!empty($a['pl']) && in_array($t['pl'], $a['pl']) || empty($a['pl']) );
                $this->_ct[$v['model_id']] = $_ct = (!empty($a['ct']) && in_array($t['ct'], $a['ct']) || empty($a['ct']) );
                $this->_cs[$v['model_id']] = $_cs = (!empty($a['cs']) && in_array($t['cs'], $a['cs']) || empty($a['cs']) );
                $this->_ot[$v['model_id']] = $_ot = (!empty($a['ot']) && in_array($t['ot'], $a['ot']) || empty($a['ot']) );
                $this->_qg[$v['model_id']] = $_qg = (!empty($a['qg']) && in_array($t['qg'], $a['qg']) || empty($a['qg']) );
                $this->_jq[$v['model_id']] = $_jq = (!empty($a['jq']) && in_array($t['jq'], $a['jq']) || empty($a['jq']) );
                $this->_st[$v['model_id']] = $_st = (!empty($a['st']) && in_array($t['st'], $a['st']) || empty($a['st']) );
                $this->_zw[$v['model_id']] = $_zw = (!empty($a['zw']) && in_array($t['zw'], $a['zw']) || empty($a['zw']) );
                $this->_fi[$v['model_id']] = $_fi = (!empty($a['fi']) && in_array($t['fi'], $a['fi']) || empty($a['fi']) );
                $this->_dt[$v['model_id']] = $_dt = (!empty($a['dt']) && in_array($t['dt'], $a['dt']) || empty($a['dt']) );
                $this->_dr[$v['model_id']] = $_dr = (!empty($a['dr']) && in_array($t['dr'], $a['dr']) || empty($a['dr']) );
                $this->_bsx[$v['model_id']] = $_bsx = (!empty($a['bsx']) && in_array($t['bsx'], $a['bsx']) || empty($a['bsx']) );
                $this->_br[$v['model_id']] = $_br = (!empty($a['br']) && in_array($t['br'], $a['br']) || empty($a['br']) );
                $this->_bi[$v['model_id']] = $_bi = (!empty($a['bi']) && in_array($t['bi'], $a['bi']) || empty($a['bi']) );

                $this->_sp[$v['model_id']] = $_sp = (
                        ($a['sp1'] && $t['sp1'] == "1" || !isset($a['sp1']) ) &&
                        ($a['sp2'] && $t['sp2'] == "1" || !isset($a['sp2']) ) &&
                        ($a['sp3'] && $t['sp3'] == "1" || !isset($a['sp3']) ) &&
                        ($a['sp4'] && $t['sp4'] == "1" || !isset($a['sp4']) ) &&
                        ($a['sp5'] && $t['sp5'] == "1" || !isset($a['sp5']) ) &&
                        ($a['sp6'] && $t['sp6'] == "1" || !isset($a['sp6']) ) &&
                        ($a['sp7'] && $t['sp7'] == "1" || !isset($a['sp7']) ) &&
                        ($a['sp8'] && $t['sp8'] == "1" || !isset($a['sp8']) ) &&
                        ($a['sp9'] && $t['sp9'] == "1" || !isset($a['sp9']) ) &&
                        ($a['sp10'] && $t['sp10'] == "1" || !isset($a['sp10']) ) &&
                        ($a['sp11'] && $t['sp11'] == "1" || !isset($a['sp11']) ) &&
                        ($a['sp12'] && $t['sp12'] == "1" || !isset($a['sp12']) ) &&
                        ($a['sp13'] && $t['sp13'] == "1" || !isset($a['sp13']) ) &&
                        ($a['sp14'] && $t['sp14'] == "1" || !isset($a['sp14']) ) &&
                        ($a['sp15'] && $t['sp15'] == "1" || !isset($a['sp15']) )
                        );
                $_sp1 = (
                        ($a['sp2'] && $t['sp2'] == "1" || !isset($a['sp2']) ) &&
                        ($a['sp3'] && $t['sp3'] == "1" || !isset($a['sp3']) ) &&
                        ($a['sp4'] && $t['sp4'] == "1" || !isset($a['sp4']) ) &&
                        ($a['sp5'] && $t['sp5'] == "1" || !isset($a['sp5']) ) &&
                        ($a['sp6'] && $t['sp6'] == "1" || !isset($a['sp6']) ) &&
                        ($a['sp7'] && $t['sp7'] == "1" || !isset($a['sp7']) ) &&
                        ($a['sp8'] && $t['sp8'] == "1" || !isset($a['sp8']) ) &&
                        ($a['sp9'] && $t['sp9'] == "1" || !isset($a['sp9']) ) &&
                        ($a['sp10'] && $t['sp10'] == "1" || !isset($a['sp10']) ) &&
                        ($a['sp11'] && $t['sp11'] == "1" || !isset($a['sp11']) ) &&
                        ($a['sp12'] && $t['sp12'] == "1" || !isset($a['sp12']) ) &&
                        ($a['sp13'] && $t['sp13'] == "1" || !isset($a['sp13']) ) &&
                        ($a['sp14'] && $t['sp14'] == "1" || !isset($a['sp14']) ) &&
                        ($a['sp15'] && $t['sp15'] == "1" || !isset($a['sp15']) )
                        );
                $_sp2 = (
                        ($a['sp1'] && $t['sp1'] == "1" || !isset($a['sp1']) ) &&
                        ($a['sp3'] && $t['sp3'] == "1" || !isset($a['sp3']) ) &&
                        ($a['sp4'] && $t['sp4'] == "1" || !isset($a['sp4']) ) &&
                        ($a['sp5'] && $t['sp5'] == "1" || !isset($a['sp5']) ) &&
                        ($a['sp6'] && $t['sp6'] == "1" || !isset($a['sp6']) ) &&
                        ($a['sp7'] && $t['sp7'] == "1" || !isset($a['sp7']) ) &&
                        ($a['sp8'] && $t['sp8'] == "1" || !isset($a['sp8']) ) &&
                        ($a['sp9'] && $t['sp9'] == "1" || !isset($a['sp9']) ) &&
                        ($a['sp10'] && $t['sp10'] == "1" || !isset($a['sp10']) ) &&
                        ($a['sp11'] && $t['sp11'] == "1" || !isset($a['sp11']) ) &&
                        ($a['sp12'] && $t['sp12'] == "1" || !isset($a['sp12']) ) &&
                        ($a['sp13'] && $t['sp13'] == "1" || !isset($a['sp13']) ) &&
                        ($a['sp14'] && $t['sp14'] == "1" || !isset($a['sp14']) ) &&
                        ($a['sp15'] && $t['sp15'] == "1" || !isset($a['sp15']) )
                        );
                $_sp3 = (
                        ($a['sp1'] && $t['sp1'] == "1" || !isset($a['sp1']) ) &&
                        ($a['sp2'] && $t['sp2'] == "1" || !isset($a['sp2']) ) &&
                        ($a['sp4'] && $t['sp4'] == "1" || !isset($a['sp4']) ) &&
                        ($a['sp5'] && $t['sp5'] == "1" || !isset($a['sp5']) ) &&
                        ($a['sp6'] && $t['sp6'] == "1" || !isset($a['sp6']) ) &&
                        ($a['sp7'] && $t['sp7'] == "1" || !isset($a['sp7']) ) &&
                        ($a['sp8'] && $t['sp8'] == "1" || !isset($a['sp8']) ) &&
                        ($a['sp9'] && $t['sp9'] == "1" || !isset($a['sp9']) ) &&
                        ($a['sp10'] && $t['sp10'] == "1" || !isset($a['sp10']) ) &&
                        ($a['sp11'] && $t['sp11'] == "1" || !isset($a['sp11']) ) &&
                        ($a['sp12'] && $t['sp12'] == "1" || !isset($a['sp12']) ) &&
                        ($a['sp13'] && $t['sp13'] == "1" || !isset($a['sp13']) ) &&
                        ($a['sp14'] && $t['sp14'] == "1" || !isset($a['sp14']) ) &&
                        ($a['sp15'] && $t['sp15'] == "1" || !isset($a['sp15']) )
                        );
                $_sp4 = (
                        ($a['sp1'] && $t['sp1'] == "1" || !isset($a['sp1']) ) &&
                        ($a['sp2'] && $t['sp2'] == "1" || !isset($a['sp2']) ) &&
                        ($a['sp3'] && $t['sp3'] == "1" || !isset($a['sp3']) ) &&
                        ($a['sp5'] && $t['sp5'] == "1" || !isset($a['sp5']) ) &&
                        ($a['sp6'] && $t['sp6'] == "1" || !isset($a['sp6']) ) &&
                        ($a['sp7'] && $t['sp7'] == "1" || !isset($a['sp7']) ) &&
                        ($a['sp8'] && $t['sp8'] == "1" || !isset($a['sp8']) ) &&
                        ($a['sp9'] && $t['sp9'] == "1" || !isset($a['sp9']) ) &&
                        ($a['sp10'] && $t['sp10'] == "1" || !isset($a['sp10']) ) &&
                        ($a['sp11'] && $t['sp11'] == "1" || !isset($a['sp11']) ) &&
                        ($a['sp12'] && $t['sp12'] == "1" || !isset($a['sp12']) ) &&
                        ($a['sp13'] && $t['sp13'] == "1" || !isset($a['sp13']) ) &&
                        ($a['sp14'] && $t['sp14'] == "1" || !isset($a['sp14']) ) &&
                        ($a['sp15'] && $t['sp15'] == "1" || !isset($a['sp15']) )
                        );
                $_sp5 = (
                        ($a['sp1'] && $t['sp1'] == "1" || !isset($a['sp1']) ) &&
                        ($a['sp2'] && $t['sp2'] == "1" || !isset($a['sp2']) ) &&
                        ($a['sp3'] && $t['sp3'] == "1" || !isset($a['sp3']) ) &&
                        ($a['sp4'] && $t['sp4'] == "1" || !isset($a['sp4']) ) &&
                        ($a['sp6'] && $t['sp6'] == "1" || !isset($a['sp6']) ) &&
                        ($a['sp7'] && $t['sp7'] == "1" || !isset($a['sp7']) ) &&
                        ($a['sp8'] && $t['sp8'] == "1" || !isset($a['sp8']) ) &&
                        ($a['sp9'] && $t['sp9'] == "1" || !isset($a['sp9']) ) &&
                        ($a['sp10'] && $t['sp10'] == "1" || !isset($a['sp10']) ) &&
                        ($a['sp11'] && $t['sp11'] == "1" || !isset($a['sp11']) ) &&
                        ($a['sp12'] && $t['sp12'] == "1" || !isset($a['sp12']) ) &&
                        ($a['sp13'] && $t['sp13'] == "1" || !isset($a['sp13']) ) &&
                        ($a['sp14'] && $t['sp14'] == "1" || !isset($a['sp14']) ) &&
                        ($a['sp15'] && $t['sp15'] == "1" || !isset($a['sp15']) )
                        );
                $_sp6 = (
                        ($a['sp1'] && $t['sp1'] == "1" || !isset($a['sp1']) ) &&
                        ($a['sp2'] && $t['sp2'] == "1" || !isset($a['sp2']) ) &&
                        ($a['sp3'] && $t['sp3'] == "1" || !isset($a['sp3']) ) &&
                        ($a['sp4'] && $t['sp4'] == "1" || !isset($a['sp4']) ) &&
                        ($a['sp5'] && $t['sp5'] == "1" || !isset($a['sp5']) ) &&
                        ($a['sp7'] && $t['sp7'] == "1" || !isset($a['sp7']) ) &&
                        ($a['sp8'] && $t['sp8'] == "1" || !isset($a['sp8']) ) &&
                        ($a['sp9'] && $t['sp9'] == "1" || !isset($a['sp9']) ) &&
                        ($a['sp10'] && $t['sp10'] == "1" || !isset($a['sp10']) ) &&
                        ($a['sp11'] && $t['sp11'] == "1" || !isset($a['sp11']) ) &&
                        ($a['sp12'] && $t['sp12'] == "1" || !isset($a['sp12']) ) &&
                        ($a['sp13'] && $t['sp13'] == "1" || !isset($a['sp13']) ) &&
                        ($a['sp14'] && $t['sp14'] == "1" || !isset($a['sp14']) ) &&
                        ($a['sp15'] && $t['sp15'] == "1" || !isset($a['sp15']) )
                        );
                $_sp7 = (
                        ($a['sp1'] && $t['sp1'] == "1" || !isset($a['sp1']) ) &&
                        ($a['sp2'] && $t['sp2'] == "1" || !isset($a['sp2']) ) &&
                        ($a['sp3'] && $t['sp3'] == "1" || !isset($a['sp3']) ) &&
                        ($a['sp4'] && $t['sp4'] == "1" || !isset($a['sp4']) ) &&
                        ($a['sp5'] && $t['sp5'] == "1" || !isset($a['sp5']) ) &&
                        ($a['sp6'] && $t['sp6'] == "1" || !isset($a['sp6']) ) &&
                        ($a['sp8'] && $t['sp8'] == "1" || !isset($a['sp8']) ) &&
                        ($a['sp9'] && $t['sp9'] == "1" || !isset($a['sp9']) ) &&
                        ($a['sp10'] && $t['sp10'] == "1" || !isset($a['sp10']) ) &&
                        ($a['sp11'] && $t['sp11'] == "1" || !isset($a['sp11']) ) &&
                        ($a['sp12'] && $t['sp12'] == "1" || !isset($a['sp12']) ) &&
                        ($a['sp13'] && $t['sp13'] == "1" || !isset($a['sp13']) ) &&
                        ($a['sp14'] && $t['sp14'] == "1" || !isset($a['sp14']) ) &&
                        ($a['sp15'] && $t['sp15'] == "1" || !isset($a['sp15']) )
                        );
                $_sp8 = (
                        ($a['sp1'] && $t['sp1'] == "1" || !isset($a['sp1']) ) &&
                        ($a['sp2'] && $t['sp2'] == "1" || !isset($a['sp2']) ) &&
                        ($a['sp3'] && $t['sp3'] == "1" || !isset($a['sp3']) ) &&
                        ($a['sp4'] && $t['sp4'] == "1" || !isset($a['sp4']) ) &&
                        ($a['sp5'] && $t['sp5'] == "1" || !isset($a['sp5']) ) &&
                        ($a['sp6'] && $t['sp6'] == "1" || !isset($a['sp6']) ) &&
                        ($a['sp7'] && $t['sp7'] == "1" || !isset($a['sp7']) ) &&
                        ($a['sp9'] && $t['sp9'] == "1" || !isset($a['sp9']) ) &&
                        ($a['sp10'] && $t['sp10'] == "1" || !isset($a['sp10']) ) &&
                        ($a['sp11'] && $t['sp11'] == "1" || !isset($a['sp11']) ) &&
                        ($a['sp12'] && $t['sp12'] == "1" || !isset($a['sp12']) ) &&
                        ($a['sp13'] && $t['sp13'] == "1" || !isset($a['sp13']) ) &&
                        ($a['sp14'] && $t['sp14'] == "1" || !isset($a['sp14']) ) &&
                        ($a['sp15'] && $t['sp15'] == "1" || !isset($a['sp15']) )
                        );
                $_sp9 = (
                        ($a['sp1'] && $t['sp1'] == "1" || !isset($a['sp1']) ) &&
                        ($a['sp2'] && $t['sp2'] == "1" || !isset($a['sp2']) ) &&
                        ($a['sp3'] && $t['sp3'] == "1" || !isset($a['sp3']) ) &&
                        ($a['sp4'] && $t['sp4'] == "1" || !isset($a['sp4']) ) &&
                        ($a['sp5'] && $t['sp5'] == "1" || !isset($a['sp5']) ) &&
                        ($a['sp6'] && $t['sp6'] == "1" || !isset($a['sp6']) ) &&
                        ($a['sp7'] && $t['sp7'] == "1" || !isset($a['sp7']) ) &&
                        ($a['sp8'] && $t['sp8'] == "1" || !isset($a['sp8']) ) &&
                        ($a['sp10'] && $t['sp10'] == "1" || !isset($a['sp10']) ) &&
                        ($a['sp11'] && $t['sp11'] == "1" || !isset($a['sp11']) ) &&
                        ($a['sp12'] && $t['sp12'] == "1" || !isset($a['sp12']) ) &&
                        ($a['sp13'] && $t['sp13'] == "1" || !isset($a['sp13']) ) &&
                        ($a['sp14'] && $t['sp14'] == "1" || !isset($a['sp14']) ) &&
                        ($a['sp15'] && $t['sp15'] == "1" || !isset($a['sp15']) )
                        );
                $_sp10 = (
                        ($a['sp1'] && $t['sp1'] == "1" || !isset($a['sp1']) ) &&
                        ($a['sp2'] && $t['sp2'] == "1" || !isset($a['sp2']) ) &&
                        ($a['sp3'] && $t['sp3'] == "1" || !isset($a['sp3']) ) &&
                        ($a['sp4'] && $t['sp4'] == "1" || !isset($a['sp4']) ) &&
                        ($a['sp5'] && $t['sp5'] == "1" || !isset($a['sp5']) ) &&
                        ($a['sp6'] && $t['sp6'] == "1" || !isset($a['sp6']) ) &&
                        ($a['sp7'] && $t['sp7'] == "1" || !isset($a['sp7']) ) &&
                        ($a['sp8'] && $t['sp8'] == "1" || !isset($a['sp8']) ) &&
                        ($a['sp9'] && $t['sp9'] == "1" || !isset($a['sp9']) ) &&
                        ($a['sp11'] && $t['sp11'] == "1" || !isset($a['sp11']) ) &&
                        ($a['sp12'] && $t['sp12'] == "1" || !isset($a['sp12']) ) &&
                        ($a['sp13'] && $t['sp13'] == "1" || !isset($a['sp13']) ) &&
                        ($a['sp14'] && $t['sp14'] == "1" || !isset($a['sp14']) ) &&
                        ($a['sp15'] && $t['sp15'] == "1" || !isset($a['sp15']) )
                        );
                $_sp11 = (
                        ($a['sp1'] && $t['sp1'] == "1" || !isset($a['sp1']) ) &&
                        ($a['sp2'] && $t['sp2'] == "1" || !isset($a['sp2']) ) &&
                        ($a['sp3'] && $t['sp3'] == "1" || !isset($a['sp3']) ) &&
                        ($a['sp4'] && $t['sp4'] == "1" || !isset($a['sp4']) ) &&
                        ($a['sp5'] && $t['sp5'] == "1" || !isset($a['sp5']) ) &&
                        ($a['sp6'] && $t['sp6'] == "1" || !isset($a['sp6']) ) &&
                        ($a['sp7'] && $t['sp7'] == "1" || !isset($a['sp7']) ) &&
                        ($a['sp8'] && $t['sp8'] == "1" || !isset($a['sp8']) ) &&
                        ($a['sp9'] && $t['sp9'] == "1" || !isset($a['sp9']) ) &&
                        ($a['sp10'] && $t['sp10'] == "1" || !isset($a['sp10']) ) &&
                        ($a['sp12'] && $t['sp12'] == "1" || !isset($a['sp12']) ) &&
                        ($a['sp13'] && $t['sp13'] == "1" || !isset($a['sp13']) ) &&
                        ($a['sp14'] && $t['sp14'] == "1" || !isset($a['sp14']) ) &&
                        ($a['sp15'] && $t['sp15'] == "1" || !isset($a['sp15']) )
                        );
                $_sp12 = (
                        ($a['sp1'] && $t['sp1'] == "1" || !isset($a['sp1']) ) &&
                        ($a['sp2'] && $t['sp2'] == "1" || !isset($a['sp2']) ) &&
                        ($a['sp3'] && $t['sp3'] == "1" || !isset($a['sp3']) ) &&
                        ($a['sp4'] && $t['sp4'] == "1" || !isset($a['sp4']) ) &&
                        ($a['sp5'] && $t['sp5'] == "1" || !isset($a['sp5']) ) &&
                        ($a['sp6'] && $t['sp6'] == "1" || !isset($a['sp6']) ) &&
                        ($a['sp7'] && $t['sp7'] == "1" || !isset($a['sp7']) ) &&
                        ($a['sp8'] && $t['sp8'] == "1" || !isset($a['sp8']) ) &&
                        ($a['sp9'] && $t['sp9'] == "1" || !isset($a['sp9']) ) &&
                        ($a['sp10'] && $t['sp10'] == "1" || !isset($a['sp10']) ) &&
                        ($a['sp11'] && $t['sp11'] == "1" || !isset($a['sp11']) ) &&
                        ($a['sp13'] && $t['sp13'] == "1" || !isset($a['sp13']) ) &&
                        ($a['sp14'] && $t['sp14'] == "1" || !isset($a['sp14']) ) &&
                        ($a['sp15'] && $t['sp15'] == "1" || !isset($a['sp15']) )
                        );
                $_sp13 = (
                        ($a['sp1'] && $t['sp1'] == "1" || !isset($a['sp1']) ) &&
                        ($a['sp2'] && $t['sp2'] == "1" || !isset($a['sp2']) ) &&
                        ($a['sp3'] && $t['sp3'] == "1" || !isset($a['sp3']) ) &&
                        ($a['sp4'] && $t['sp4'] == "1" || !isset($a['sp4']) ) &&
                        ($a['sp5'] && $t['sp5'] == "1" || !isset($a['sp5']) ) &&
                        ($a['sp6'] && $t['sp6'] == "1" || !isset($a['sp6']) ) &&
                        ($a['sp7'] && $t['sp7'] == "1" || !isset($a['sp7']) ) &&
                        ($a['sp8'] && $t['sp8'] == "1" || !isset($a['sp8']) ) &&
                        ($a['sp9'] && $t['sp9'] == "1" || !isset($a['sp9']) ) &&
                        ($a['sp10'] && $t['sp10'] == "1" || !isset($a['sp10']) ) &&
                        ($a['sp11'] && $t['sp11'] == "1" || !isset($a['sp11']) ) &&
                        ($a['sp12'] && $t['sp12'] == "1" || !isset($a['sp12']) ) &&
                        ($a['sp14'] && $t['sp14'] == "1" || !isset($a['sp14']) ) &&
                        ($a['sp15'] && $t['sp15'] == "1" || !isset($a['sp15']) )
                        );
                $_sp14 = (
                        ($a['sp1'] && $t['sp1'] == "1" || !isset($a['sp1']) ) &&
                        ($a['sp2'] && $t['sp2'] == "1" || !isset($a['sp2']) ) &&
                        ($a['sp3'] && $t['sp3'] == "1" || !isset($a['sp3']) ) &&
                        ($a['sp4'] && $t['sp4'] == "1" || !isset($a['sp4']) ) &&
                        ($a['sp5'] && $t['sp5'] == "1" || !isset($a['sp5']) ) &&
                        ($a['sp6'] && $t['sp6'] == "1" || !isset($a['sp6']) ) &&
                        ($a['sp7'] && $t['sp7'] == "1" || !isset($a['sp7']) ) &&
                        ($a['sp8'] && $t['sp8'] == "1" || !isset($a['sp8']) ) &&
                        ($a['sp9'] && $t['sp9'] == "1" || !isset($a['sp9']) ) &&
                        ($a['sp10'] && $t['sp10'] == "1" || !isset($a['sp10']) ) &&
                        ($a['sp11'] && $t['sp11'] == "1" || !isset($a['sp11']) ) &&
                        ($a['sp12'] && $t['sp12'] == "1" || !isset($a['sp12']) ) &&
                        ($a['sp13'] && $t['sp13'] == "1" || !isset($a['sp13']) ) &&
                        ($a['sp15'] && $t['sp15'] == "1" || !isset($a['sp15']) )
                        );
                $_sp15 = (
                        ($a['sp1'] && $t['sp1'] == "1" || !isset($a['sp1']) ) &&
                        ($a['sp2'] && $t['sp2'] == "1" || !isset($a['sp2']) ) &&
                        ($a['sp3'] && $t['sp3'] == "1" || !isset($a['sp3']) ) &&
                        ($a['sp4'] && $t['sp4'] == "1" || !isset($a['sp4']) ) &&
                        ($a['sp5'] && $t['sp5'] == "1" || !isset($a['sp5']) ) &&
                        ($a['sp6'] && $t['sp6'] == "1" || !isset($a['sp6']) ) &&
                        ($a['sp7'] && $t['sp7'] == "1" || !isset($a['sp7']) ) &&
                        ($a['sp8'] && $t['sp8'] == "1" || !isset($a['sp8']) ) &&
                        ($a['sp9'] && $t['sp9'] == "1" || !isset($a['sp9']) ) &&
                        ($a['sp10'] && $t['sp10'] == "1" || !isset($a['sp10']) ) &&
                        ($a['sp11'] && $t['sp11'] == "1" || !isset($a['sp11']) ) &&
                        ($a['sp12'] && $t['sp12'] == "1" || !isset($a['sp12']) ) &&
                        ($a['sp13'] && $t['sp13'] == "1" || !isset($a['sp13']) ) &&
                        ($a['sp14'] && $t['sp14'] == "1" || !isset($a['sp14']) )
                        );

                if (
                        $_br && $_pr && $_pl && $_ct && $_cs && $_ot && $_qg && $_jq && $_st && $_zw && $_fi && $_dt && $_bi && $_dr && $_bsx && $_sp2 && $_sp3 && $_sp4 && $_sp5 && $_sp6 && $_sp7 && $_sp8 && $_sp9 && $_sp10 && $_sp11 && $_sp12 && $_sp13 && $_sp14 && $_sp15
                ) {
                    $r['sp1'][$t['sp1']][$v['model_id']] = 1;
                }
                if (
                        $_br && $_pr && $_pl && $_ct && $_cs && $_ot && $_qg && $_jq && $_st && $_zw && $_fi && $_dt && $_bi && $_dr && $_bsx && $_sp1 && $_sp3 && $_sp4 && $_sp5 && $_sp6 && $_sp7 && $_sp8 && $_sp9 && $_sp10 && $_sp11 && $_sp12 && $_sp13 && $_sp14 && $_sp15
                ) {
                    $r['sp2'][$t['sp2']][$v['model_id']] = 1;
                }
                if (
                        $_br && $_pr && $_pl && $_ct && $_cs && $_ot && $_qg && $_jq && $_st && $_zw && $_fi && $_dt && $_bi && $_dr && $_bsx && $_sp1 && $_sp2 && $_sp4 && $_sp5 && $_sp6 && $_sp7 && $_sp8 && $_sp9 && $_sp10 && $_sp11 && $_sp12 && $_sp13 && $_sp14 && $_sp15
                ) {
                    $r['sp3'][$t['sp3']][$v['model_id']] = 1;
                }
                if (
                        $_br && $_pr && $_pl && $_ct && $_cs && $_ot && $_qg && $_jq && $_st && $_zw && $_fi && $_dt && $_bi && $_dr && $_bsx && $_sp1 && $_sp2 && $_sp3 && $_sp5 && $_sp6 && $_sp7 && $_sp8 && $_sp9 && $_sp10 && $_sp11 && $_sp12 && $_sp13 && $_sp14 && $_sp15
                ) {
                    $r['sp4'][$t['sp4']][$v['model_id']] = 1;
                }
                if (
                        $_br && $_pr && $_pl && $_ct && $_cs && $_ot && $_qg && $_jq && $_st && $_zw && $_fi && $_dt && $_bi && $_dr && $_bsx && $_sp1 && $_sp2 && $_sp3 && $_sp4 && $_sp6 && $_sp7 && $_sp8 && $_sp9 && $_sp10 && $_sp11 && $_sp12 && $_sp13 && $_sp14 && $_sp15
                ) {
                    $r['sp5'][$t['sp5']][$v['model_id']] = 1;
                }
                if (
                        $_br && $_pr && $_pl && $_ct && $_cs && $_ot && $_qg && $_jq && $_st && $_zw && $_fi && $_dt && $_bi && $_dr && $_bsx && $_sp1 && $_sp2 && $_sp3 && $_sp4 && $_sp5 && $_sp7 && $_sp8 && $_sp9 && $_sp10 && $_sp11 && $_sp12 && $_sp13 && $_sp14 && $_sp15
                ) {
                    $r['sp6'][$t['sp6']][$v['model_id']] = 1;
                }
                if (
                        $_br && $_pr && $_pl && $_ct && $_cs && $_ot && $_qg && $_jq && $_st && $_zw && $_fi && $_dt && $_bi && $_dr && $_bsx && $_sp1 && $_sp2 && $_sp3 && $_sp4 && $_sp5 && $_sp6 && $_sp8 && $_sp9 && $_sp10 && $_sp11 && $_sp12 && $_sp13 && $_sp14 && $_sp15
                ) {
                    $r['sp7'][$t['sp7']][$v['model_id']] = 1;
                }
                if (
                        $_br && $_pr && $_pl && $_ct && $_cs && $_ot && $_qg && $_jq && $_st && $_zw && $_fi && $_dt && $_bi && $_dr && $_bsx && $_sp1 && $_sp2 && $_sp3 && $_sp4 && $_sp5 && $_sp6 && $_sp7 && $_sp9 && $_sp10 && $_sp11 && $_sp12 && $_sp13 && $_sp14 && $_sp15
                ) {
                    $r['sp8'][$t['sp8']][$v['model_id']] = 1;
                }
                if (
                        $_br && $_pr && $_pl && $_ct && $_cs && $_ot && $_qg && $_jq && $_st && $_zw && $_fi && $_dt && $_bi && $_dr && $_bsx && $_sp1 && $_sp2 && $_sp3 && $_sp4 && $_sp5 && $_sp6 && $_sp7 && $_sp8 && $_sp10 && $_sp11 && $_sp12 && $_sp13 && $_sp14 && $_sp15
                ) {
                    $r['sp9'][$t['sp9']][$v['model_id']] = 1;
                }
                if (
                        $_br && $_pr && $_pl && $_ct && $_cs && $_ot && $_qg && $_jq && $_st && $_zw && $_fi && $_dt && $_bi && $_dr && $_bsx && $_sp1 && $_sp2 && $_sp3 && $_sp4 && $_sp5 && $_sp6 && $_sp7 && $_sp8 && $_sp9 && $_sp11 && $_sp12 && $_sp13 && $_sp14 && $_sp15
                ) {
                    $r['sp10'][$t['sp10']][$v['model_id']] = 1;
                }
                if (
                        $_br && $_pr && $_pl && $_ct && $_cs && $_ot && $_qg && $_jq && $_st && $_zw && $_fi && $_dt && $_bi && $_dr && $_bsx && $_sp1 && $_sp2 && $_sp3 && $_sp4 && $_sp5 && $_sp6 && $_sp7 && $_sp8 && $_sp9 && $_sp10 && $_sp12 && $_sp13 && $_sp14 && $_sp15
                ) {
                    $r['sp11'][$t['sp11']][$v['model_id']] = 1;
                }
                if (
                        $_br && $_pr && $_pl && $_ct && $_cs && $_ot && $_qg && $_jq && $_st && $_zw && $_fi && $_dt && $_bi && $_dr && $_bsx && $_sp1 && $_sp2 && $_sp3 && $_sp4 && $_sp5 && $_sp6 && $_sp7 && $_sp8 && $_sp9 && $_sp10 && $_sp11 && $_sp13 && $_sp14 && $_sp15
                ) {
                    $r['sp12'][$t['sp12']][$v['model_id']] = 1;
                }
                if (
                        $_br && $_pr && $_pl && $_ct && $_cs && $_ot && $_qg && $_jq && $_st && $_zw && $_fi && $_dt && $_bi && $_dr && $_bsx && $_sp1 && $_sp2 && $_sp3 && $_sp4 && $_sp5 && $_sp6 && $_sp7 && $_sp8 && $_sp9 && $_sp10 && $_sp11 && $_sp12 && $_sp14 && $_sp15
                ) {
                    $r['sp13'][$t['sp13']][$v['model_id']] = 1;
                }
                if (
                        $_br && $_pr && $_pl && $_ct && $_cs && $_ot && $_qg && $_jq && $_st && $_zw && $_fi && $_dt && $_bi && $_dr && $_bsx && $_sp1 && $_sp2 && $_sp3 && $_sp4 && $_sp5 && $_sp6 && $_sp7 && $_sp8 && $_sp9 && $_sp10 && $_sp11 && $_sp12 && $_sp13 && $_sp15
                ) {
                    $r['sp14'][$t['sp14']][$v['model_id']] = 1;
                }
                if (
                        $_br && $_pr && $_pl && $_ct && $_cs && $_ot && $_qg && $_jq && $_st && $_zw && $_fi && $_dt && $_bi && $_dr && $_bsx && $_sp1 && $_sp2 && $_sp3 && $_sp4 && $_sp5 && $_sp6 && $_sp7 && $_sp8 && $_sp9 && $_sp10 && $_sp11 && $_sp12 && $_sp13 && $_sp14
                ) {
                    $r['sp15'][$t['sp15']][$v['model_id']] = 1;
                }

                /*
                  foreach ($this->sc as $kk => $vv) {
                  $var = '_sc' . $kk;
                  $$var = $this->checkStatus($a, $t, 1, $kk);
                  }

                  foreach ($this->sp as $kk => $vv) {
                  $var = '_sp' . $kk;
                  $$var = $this->checkStatus($a, $t, 2, $kk);
                  } */

                /*
                  #安全防盗  sc
                  foreach ($this->sc as $kk => $vv) {
                  $var = "_sc" . $kk;
                  if (
                  $_br && $_pr && $_pl && $_ct && $_cs && $_ot && $_qg && $_jq && $_st && $_sp && $_zw && $_fi && $_dt
                  && $_dr && $_bsx && $$var && $_sp
                  ) {
                  $r['sc' . $kk][$t['sc' . $kk]][$v['series_id']] = 1;
                  }
                  }

                  #舒适性    sp
                  foreach ($this->sp as $kk => $vv) {
                  $var = "_sp" . $kk;
                  if (
                  $_br && $_pr && $_pl && $_ct && $_cs && $_ot && $_qg && $_jq && $_st && $_sp && $_zw && $_fi && $_dt
                  && $_dr && $_bsx && $$var
                  ) {
                  $r['sp' . $kk][$t['sp' . $kk]][$v['series_id']] = 1;
                  }
                  }
                 */
                #品牌 br
                if (
                        $_pr && $_pl && $_ct && $_cs && $_ot && $_qg && $_jq && $_st && $_zw && $_fi && $_dt && $_dr && $_bsx && $_sp && $_bi
                ) {
                    #echo "model_id:{$v['model_id']}; series_id:{$v['series_id']}; count:"
                    #.count($r['letter'][$v['letter']][$v['brand_id']])."; brand:{$v['brand_id']}<br>\n";      
                    $r['br'][$t['br']][$v['series_id']] = 1;

                    if (!$r['letter'][$v['letter']][$v['brand_id']][$v['series_id']]) {
                        $r['letter'][$v['letter'] . 'c'][$v['brand_id']] += 1;
                        $r['letter'][$v['letter']][$v['brand_id']][$v['series_id']] = 1;
                    }
                }

                if (!empty($a['br']) && in_array($t['br'], $a['br']) && is_array($r['br'])) {
                    if (!array_key_exists($t['br'], $r['br'])) {
                        $r['br'][$t['br']] = array();
                        $r['letter'][$v['letter']][$v['brand_id']] = array();
                    }
                }


                #价格 pr
                if (
                        $_br && $_pl && $_ct && $_cs && $_ot && $_qg && $_jq && $_st && $_zw && $_fi && $_dt && $_dr && $_bsx && $_sp && $_bi
                ) {
                    $r['pr'][$t['pr']][$v['series_id']] = 1;
                }

                #排量 pl
                if (
                        $_br && $_pr && $_ct && $_cs && $_ot && $_qg && $_jq && $_st && $_zw && $_fi && $_dt && $_dr && $_bsx && $_sp && $_bi
                ) {
                    $r['pl'][$t['pl']][$v['series_id']] = 1;
                }

                #级别  ct
                if (
                        $_br && $_pr && $_pl && $_cs && $_ot && $_qg && $_jq && $_st && $_zw && $_fi && $_dt && $_dr && $_bsx && $_sp && $_bi
                ) {
                    $r['ct'][$t['ct']][$v['series_id']] = 1;
                }

                #车身  cs
                if (
                        $_br && $_pr && $_pl && $_ct && $_ot && $_qg && $_jq && $_st && $_zw && $_fi && $_dt && $_dr && $_bsx && $_sp && $_bi
                ) {
                    $r['cs'][$t['cs']][$v['series_id']] = 1;
                }

                #燃料类型  ot
                if (
                        $_br && $_pr && $_pl && $_ct && $_cs && $_qg && $_jq && $_st && $_zw && $_fi && $_dt && $_dr && $_bsx && $_sp && $_bi
                ) {
                    $r['ot'][$t['ot']][$v['series_id']] = 1;
                }

                #缸数  qg
                if (
                        $_br && $_pr && $_pl && $_ct && $_cs && $_ot && $_jq && $_st && $_zw && $_fi && $_dt && $_dr && $_bsx && $_sp && $_bi
                ) {
                    $r['qg'][$t['qg']][$v['series_id']] = 1;
                }

                #进气形式  jq
                if (
                        $_br && $_pr && $_pl && $_ct && $_cs && $_ot && $_qg && $_st && $_zw && $_fi && $_dt && $_dr && $_bsx && $_sp && $_bi
                ) {
                    $r['jq'][$t['jq']][$v['series_id']] = 1;
                }

                #承载方式   st
                if (
                        $_br && $_pr && $_pl && $_ct && $_cs && $_ot && $_qg && $_jq && $_zw && $_fi && $_dt && $_dr && $_bsx && $_sp && $_bi
                ) {
                    $r['st'][$t['st']][$v['series_id']] = 1;
                }

                #座位数  zw
                if (
                        $_br && $_pr && $_pl && $_ct && $_cs && $_ot && $_qg && $_jq && $_st && $_sp && $_fi && $_dt && $_dr && $_bsx && $_sp && $_bi
                ) {
                    $r['zw'][$t['zw']][$v['series_id']] = 1;
                }

                #厂商类型   fi
                if (
                        $_br && $_pr && $_pl && $_ct && $_cs && $_ot && $_qg && $_jq && $_st && $_zw && $_dt && $_dr && $_bsx && $_sp && $_bi
                ) {
                    $r['fi'][$t['fi']][$v['series_id']] = 1;
                }

                #发动机位置  dt
                if (
                        $_br && $_pr && $_pl && $_ct && $_cs && $_ot && $_qg && $_jq && $_st && $_zw && $_fi && $_dr && $_bsx && $_sp && $_bi
                ) {
                    $r['dt'][$t['dt']][$v['series_id']] = 1;
                }

                #驱动形式 dr
                if (
                        $_br && $_pr && $_pl && $_ct && $_cs && $_ot && $_qg && $_jq && $_st && $_zw && $_fi && $_dt && $_bsx && $_sp && $_bi
                ) {
                    $r['dr'][$t['dr']][$v['series_id']] = 1;
                }

                #变速箱 bsx
                if (
                        $_br && $_pr && $_pl && $_ct && $_cs && $_ot && $_qg && $_jq && $_st && $_zw && $_fi && $_dt && $_dr && $_sp && $_bi
                ) {
                    $r['bsx'][$t['bsx']][$v['series_id']] = 1;
                }

                #国别 bi
                if (
                        $_br && $_pr && $_pl && $_ct && $_cs && $_ot && $_qg && $_jq && $_st && $_zw && $_fi && $_dt && $_dr && $_sp && $_bsx
                ) {
                    $r['bi'][$t['bi']][$v['series_id']] = 1;
                }
            }
            $this->cache->writeCache($option_cache_key, $timestamp, $cache_time);
            $this->cache->writeCache($cache_key, $r, $cache_time);
        }
        return $r;
    }

    /**
     * 获取车款列表。包含搜索的参数需要的值
     * 存储在 cache 中
     * @param mixed cdp 用户自定义价格区间
     */
    function getModel($sale = 1, $cdp = '', $debug = false) {
        global $timestamp;
        if ($cdp) {
            $_tmp = '_' . str_replace(',', '_', $cdp);
        }
        $cache_key = "search_model_list_" . $sale . $_tmp;
        $cache_time = $this->cache_time['model'];
        #echo "model cache time:{$cache_time}<br>\n";
        #$model_list = $this->cache->getCache($cache_key);
        $br_list = $model_list = $param_list = array();

        $br_key = "br_key_" . $sale . $_tmp;
        $model_key = "model_key_" . $sale . $_tmp;
        $param_key = "param_key_" . $sale . $_tmp;
        $param_set_time_key = 'param_set_time';

        $br_list = $this->cache->getCache($br_key);
        $model_list = $this->cache->getCache($model_key);
        $param_list = $this->cache->getCache($param_key);
        $param_set_time = $this->cache->getCache($param_set_time_key);

        if (!$param_list || $timestamp - $param_set_time > $cache_time) {
            #if(true){
            $debug && print("no cache");
            $model_list = $br_list = $param_list = array();
            $model = $this->getAllModel($sale, $cdp);
            foreach ($model as $k => $v) {
                $br_list[$v['br']] = array(
                    'br' => $v['br'], /* brand_id */
                    'brand_id' => $v['brand_id'], /* brand_id */
                    'brand_name' => $v['brand_name'],
                    'brand_import' => $v['brand_import'],
                    'dealer_price_low' => $v['dealer_price'],
                    'letter' => $v['letter'],
                    'model_id' => $v['model_id'],
                    'series_id' => $v['series_id'],
                );

                $model_list[$v['model_id']] = array(
                    'model_id' => $v['model_id'],
                    'model_name' => $v['model_name'],
                    'model_price' => $v['model_price'],
                    'series_name' => $v['series_name'],
                    'series_id' => $v['series_id'],
                    'factory_name' => $v['factory_name'],
                    'letter' => $v['letter'],
                    'st10' => $v['st10'],
                );

                $param_list[] = array(
                    'model_id' => $v['model_id'],
                    'brand_id' => $v['brand_id'],
                    'letter' => $v['letter'],
                    'series_id' => $v['series_id'],
                    'param' => "{$v['br']}-{$v['pr']}-{$v['pl']}-{$v['ct']}-{$v['cs']}-{$v['ot']}-{$v['fi']}-{$v['dt']}-{$v['dr']}-{$v['qg']}-{$v['jq']}-{$v['zw']}-{$v['st']}-{$v['sp1']}-{$v['sp2']}-{$v['sp3']}-{$v['sp4']}-{$v['sp5']}-{$v['sp6']}-{$v['sp7']}-{$v['sp8']}-{$v['sp9']}-{$v['sp10']}-{$v['sp11']}-{$v['sp12']}-{$v['sp13']}-{$v['sp14']}-{$v['sp15']}-{$v['bsx']}-{$v['bi']}",
                );
            }

            /* if(!empty($model_list)){
              echo "value true;";
              } */
            $r = $this->cache->writeCache($br_key, $br_list, $cache_time);
            $debug && print("br:{$r};");
            $r = $this->cache->writeCache($model_key, $model_list, $cache_time);
            $debug && print("model:{$r};len:" . strlen(serialize($model_list)) . ";");
            $r = $this->cache->writeCache($param_key, $param_list, $cache_time);
            $this->cache->writeCache($param_set_time_key, $timestamp, $cache_time);
            $debug && print("param:{$r};len:" . strlen(serialize($param_list)) . ";");
        }

        return array(
            'br' => $br_list,
            'model' => $model_list,
            'param' => $param_list,
            'modelst' => $model_st_list,
        );
    }

    /**
     * 根据条件返回searchIndex中指定的车款记录
     * 
     * @param mixed $sale 0 all, 1 在售, 2 停产在售
     * @param mixed $cdp 用户自定义价格区间，半角逗号分隔
     */
    function getAllModel($sale = 0, $cdp = '') {
        $minprice = $maxprice = 0;
        if (strpos($cdp, ',') !== false) {
            list($minprice, $maxprice) = explode(',', $cdp);
            $minprice = intval($minprice);
            $maxprice = intval($maxprice);
            $_min = min($minprice, $maxprice);
            $_max = max($minprice, $maxprice);
            $minprice = $_min;
            $maxprice = $_max;
        }
        $this->table_name = 'search_index';
        $cache_key = "model_list_" . $sale . '_' . $minprice . '_' . $maxprice;
        $cache_time = $this->cache_time['model'];
        #echo "model cache time:{$cache_time}<br>\n";
        #车款状态
        $state = '(state=3 or state=7 or state=8)';
        switch ($sale) {
            case 1:
                $state = '(state=3 or state=7)';
                break;

            case 2:
                $state = 'state=8';
                break;
        }

        $model = $this->cache->getCache($cache_key);

        if (!$model) {
            $this->where = "{$state}";
            if ($maxprice) {
                $this->where .= " and model_price >= '{$minprice}' and model_price < '{$maxprice}'";
            }

            $this->fields = "*";
            $model = $this->getResult(2);
            $this->cache->writeCache($cache_key, $model, $cache_time);
        }
        return $model;
    }

    /**
     * 将搜索索引字段分隔成名称标识的数组
     * 
     * @param mixed $a 用"-"分隔的索引字段字条串
     * @return $v 数组
     */
    function splitParam($a = array()) {
        $v = array();
        $t = explode('-', $a);

        #var_dump($t);
        $v['br'] = $t[0];
        $v['pr'] = $t[1];
        $v['pl'] = $t[2];
        $v['ct'] = $t[3];
        $v['cs'] = $t[4];
        $v['ot'] = $t[5];
        $v['fi'] = $t[6];
        $v['dt'] = $t[7];
        $v['dr'] = $t[8];
        $v['qg'] = $t[9];
        $v['jq'] = $t[10];
        $v['zw'] = $t[11];
        $v['st'] = $t[12];
        $v['sp1'] = $t[13];
        $v['sp2'] = $t[14];
        $v['sp3'] = $t[15];
        $v['sp4'] = $t[16];
        $v['sp5'] = $t[17];
        $v['sp6'] = $t[18];
        $v['sp7'] = $t[19];
        $v['sp8'] = $t[20];
        $v['sp9'] = $t[21];
        $v['sp10'] = $t[22];
        $v['sp11'] = $t[23];
        $v['sp12'] = $t[24];
        $v['sp13'] = $t[25];
        $v['sp14'] = $t[26];
        $v['sp15'] = $t[27];
        $v['bsx'] = $t[28];
        $v['bi'] = $t[29];
        /* $v['sc'] = explode(',', $t[13]);
          $v['sp'] = explode(',', $t[14]);
          $v['bsx'] = $t[15];
          if(!empty($v['sc']))
          foreach ((array)$v['sc'] as $kk => $vv) {
          $i = $kk + 1;
          $v['sc'.$i] = $vv;
          }
          if(!empty($v['sp']))
          foreach ((array)$v['sp'] as $kk => $vv) {
          $i = $kk + 1;
          $v['sp'.$i] = $vv;
          } */
        #var_dump($a);
        #var_dump($v);

        return $v;
    }

    function getSeriesPic() {
        $series = $this->getSeries();
        return $series['series_pic'];
    }

    function getSeriesInfo() {
        $series = $this->getSeries();
        return $series['series_info'];
    }

    function getSeriesIntro() {
        $series = $this->getSeries();
        return $series['series_intro'];
    }

    /**
     * 返回所有车系评论总数
     * @return $ret array
     */
    function getSeriesCommentTotal() {
        $commentavg = new commentAvg();
        $ret = $commentavg->getCommentTotal();
        return $ret;
    }

    function getSeries() {
        #$series_pic = $series_intro = $series_info = array();
        global $timestamp;
        $sale_value = '';
        $seriesDefaultMid = array();
        $cache_time = $this->cache_time['series'];
        
        #echo "series cache time:{$cache_time}<br>\n";
        $series_pic = $this->cache->getCache('series_pic');
        $series_info = $this->cache->getCache('series_info');
        
        if (empty($series_pic) || empty($series_info) || $timestamp - $series_info['set_time'] > $cache_time) {
            $series = $this->series->getAllSeriess(false);
            if ($series)
                foreach ($series as $k => $v) {
                    if ($v['default_model'])
                        $seriesDefaultMid[] = $v['default_model'];
                    $series_intro[$v['series_id']] = $v['series_intro'];
                    $series_info[$v['series_id']] = array(
                        'series_id' => $v['series_id'],
                        'series_name' => $v['series_name'],
                        'factory_name' => $v['factory_name'],
                        'offical_url' => $v['offical_url'],
                        'ct' => $this->ct[$v['type_id']],
                        's1' => str_replace(',', ' ', $v['s1']),
                        's2' => str_replace(',', ' ', $v['s2']),
                        's3' => str_replace(',', ' ', $v['s3']),
                    );
                }
            $series_info['set_time'] = $timestamp;
            if (!empty($seriesDefaultMid)) {
                $defaultMidList = implode(',', $seriesDefaultMid);
                $fields = 'series_id, model_pic1, model_id';
                $where = "model_id in ($defaultMidList)";
                $result = $this->model->getModel($fields, $where, 2);
                if ($result)
                    foreach ($result as $ret) {
                        $series_pic[$ret['series_id']]['pic'] = $ret['model_pic1'];
                        $series_pic[$ret['series_id']]['default_mid'] = $ret['model_id'];
                    }
            }
            $this->cache->writeCache('series_pic', $series_pic, $cache_time);
            $this->cache->writeCache('series_info', $series_info, $cache_time);
        }
        
        
        return array(
            'series_pic' => $series_pic,
            'series_info' => $series_info,
        );
    }

    /**
     * 返回所有品牌的logo
     * @return array $ret
     */
    function getBrandLogo() {
        $ret = $this->brand->getBrandLogo();
        return $ret;
    }

    /* 获取搜车页车系展开内容 */

    function getSeriesContent($cacheKey, $seriesId) {
        $st_result = $this->cache->getCache($cacheKey);
        $modelPrice = $this->getSearchModelPrice();
        $result = $st_result['result'];
        $modelList = $result[$seriesId];
        
        if (!empty($modelList)) {
            $tableStr = '<table width="1182" border="0" style="text-align:center"><tbody>';
            foreach ($modelList['list'] as $k => $v) {
                
                if ($v[0]['st27']) {
                    $tableStr .= '<tr style="height:22px; background-color:#e61a15; color:#fff;">
                                    <th scope="col" style="width:335px;">' . $v[0]['st27'] . '升 ' . $v[0]['st36'] . '马力 ' . $v[0]['st28'] . '</th>
                                    <th scope="col" style="width:100px;"> 关注度 </th>
                                    <th scope="col" style="width:100px;"> 厂商指导价 </th>
                                    <th scope="col" style="width:100px;"> 媒体价</th>
                                    <th scope="col" style="width:60px;">&nbsp;</th>
                                    <th scope="col" style="width:100px;"> 优惠幅度</th>
                                    <th scope="col" style="width:100px;">折扣</th>
                                    <th scope="col" style="width:110px;">&nbsp;</th>
                                    <th scope="col" style="width:130px;">&nbsp;</th>
                                </tr>';
                    foreach ($v as $vk => $vlist) {
                        
                        $modelId = $vlist['model_id'];
                        $type = $modelPrice[$modelId]['price_type'];
                        $title = preg_replace("/ /", " " . $vlist["series_name"] . " ", $vlist["model_name"], 1);
                        $shortTitle = dstring::substring($title, 0,40);
                        $clickJs = $type != 0 ? 'getPriceInfo(' . $modelId . ', ' . $type . ');' : '';
                        $hotPx = round($vlist['hot'] / 10 + 1) * 8;
                        
                        if($vlist['bingo_price']){
                            $bingoPrice = (float) $vlist['bingo_price'] . '万';
                        }else{
                            $bingoPrice = '未获取';
                        }
                        $spread = $modelPrice[$modelId]['spread'];
                        if ($spread > 0)
                            $spread = '省<font style="color:red;">' . (float) $spread . '</font>万';
                        elseif ($spread < 0)
                            $spread = '<font style="color:red;">加</font>' . -1 * (float) $spread . '万';
                        else
                            $spread = '无优惠';
                        $discount = $modelPrice[$modelId]['discount'];
                        if ($discount > 0 && $discount < 10)
                            $discount = $discount . '折';
                        else
                            $discount = '--';

                        $tableStr .= '<tr class="tr1">
                                        <td>
                                            <span class="sq_title" style="text-indent:1em; cursor:pointer">
                                                <a href="/modelinfo_' . $modelId . '.html" target="_blank" title="' . $title . '">' . $shortTitle . '</a>
                                            </span> 
                                        </td>';
                        $tableStr .= '<td onclick="' . $clickJs . '">
                                          <div class="redu" title="' . $vlist['hot'] . '" style="background-position:-45px -' . $hotPx . 'px;"></div>
                                      </td>
                                      <td onclick="' . $clickJs . '">' . (float) $vlist['model_price'] . '万</td>
                                      <td class="table_color" onclick="' . $clickJs . '">' . $bingoPrice . '</td>';
                        $tableStr .= '<td align="left">';
                        if ($type == 1) {
                            $tableStr .= '<div class="bigo_sqj" style="width:20px; text-align:left; z-index:3;">
                                            <div style="width:20px; height:20px; float:left" class="ckxx2"> 
                                                <a href="javascript:void(0)" style="width:40px;display:block">
                                                    <img style="margin-left:5px;" src="/images/ss_an.jpg">		
                                                </a>
                                                <span style="font-size: 12px; display: none;" id="span1">
                                                    <div class="gzs_jtbg"><img src="/images/qkgc_gzs.png"></div>
                                                    “暗访价”是行情团队以“到店客户”身份获取的价格，优惠中不含官方补贴和礼包；专业的话术和议价流程，保证了我们获取的“行情”信息基本接近个人客户在该店的最终成交价；这里提取的是一定时间内最低的暗访价。
                                                </span>
                                            </div>
                                        </div>';
                        } elseif ($type == 2) {
                            $tableStr .= '<div class="bigo_sqj" style="width:20px; text-align:left; z-index:3;">
                                            <div style="width:20px; height:20px; float:left" class="ckxx2"> 
                                                <a href="javascript:void(0)" style="width:40px;display:block">
                                                    <img style="margin-left:5px;" src="/images/meiti.jpg">		
                                                </a>
                                                <span style="font-size: 12px; display: none;" id="span1">
                                                    <div class="gzs_jtbg"><img src="/images/qkgc_gzs.png"></div>
                                                    “网络媒体价”是网络媒体公开展示的经销商报价，是由经销商报给网站的价格，可能会有概念模糊甚至不实的情况；该价格(或优惠幅度)可能含有官方补贴、置换补贴、贷款额外优惠、礼包宣称价值等；这里提取的是时间最近的网络媒体价。
                                                </span>
                                            </div>
                                        </div>';
                        } elseif ($type == 3) {
                            $tableStr .= '<div class="bigo_sqj" style="width:20px; text-align:left">
                                            <div style="width:20px; height:20px; float:left" class="ckxx2"> 
                                                <a href="javascript:void(0)" style="width:40px;display:block">
                                                    <img style="margin-left:5px;" src="/images/shuang11_biao.jpg">		
                                                </a>
                                                <span style="font-size: 12px; display: none; left:45px;" id="span1">
                                                    <div class="gzs_jtbg"><img src="/images/qkgc_gzs.png"></div>
                                                    “双11价格”来自各网站“双11”活动专题，价格数据来源于电商和汽车行业各大门户、垂直媒体、特殊类型网站已公布的活动价格，由独家汇总、整理和发布。需留意，各家价格标准可能不同，个别价格可能体现的是综合优惠。
                                                </span>
                                            </div>
                                        </div>';
                        }
                        $tableStr .= '</td>';
                        $tableStr .= '<td style="color:black;" class="table_color" onclick="' . $clickJs . '">' . $spread . '</td>';
                        $tableStr .= '<td class="table_11" onclick="' . $clickJs . '">' . $discount . '</td>';
                        $tableStr .= '<td style="line-height:35px; cursor:pointer"><input type="checkbox" class="quick_compare" value="' . $modelId . '">快速对比</td>';
                        if ($type != 0) {
                            $tableStr .= '<td><span style="display: block" id="changechk_' . $modelId . '">
                                              <a class="ckxq" href="javascript:' . $clickJs . '" style="float:left; margin-left:10px; text-decoration:underline;">查看优惠详情</a>
                                              <a class="ckxq2" href="javascript:' . $clickJs . '" style="float:left; margin-left:10px; text-decoration:underline;">收起</a>
                                          </span></td>';
                        } else {
                            $tableStr .= '<td>&nbsp;</td>';
                        }
                        $tableStr .= '</tr>';
                        if ($type != 3) {
                            $tableStr .= '<tr class="tr_' . $modelId . '" style="display:none;">
                                            <td colspan="9">
                                            <div class="table_zhan">
                                                <dl>
                                                    <dt><img width="190" height="143" id="dealer_pic_' . $modelId . '" src="" onerror="this.src=\'images/offerrs_dealer.jpg\'"></dt>
                                                    <dd>
                                                        <p style="font-size:16px; margin-bottom:15px;" id="dealer_name_' . $modelId . '"></p>
                                                        <p style=" font-size:14px;" >地址：<span id="dealer_area_' . $modelId . '"></span></p>
                                                        <p style=" font-size:14px;" >
                                                            电话：<span id="dealer_tel_' . $modelId . '"></span>
                                                        </p>
                                                        <p style=" font-size:14px;">销售姓名：<span id="dealer_linkman_' . $modelId . '"></span></p>
                                                    </dd>
                                                </dl>
                                                <div class="table_zhong">
                                                    <table width="597">
                                                        <tbody><tr>
                                                                <th width="184px" id="price_type_' . $modelId . '"></th>
                                                                <th width="207px" style="text-align:left">补贴政策</th>
                                                                <th width="202px" style="text-align:left">0利率</th>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    获取方式：<span id="get_type_' . $modelId . '"></span>
                                                                </td>
                                                                <td style="text-align:left">
                                                                    节能惠民补贴：<span id="jnbt_' . $modelId . '"></span>
                                                                </td>
                                                                <td style="text-align:left" id="rate_' . $modelId . '"></td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <span id="get_time_' . $modelId . '"></span>
                                                                </td>
                                                                <td style="text-align:left">
                                                                    置换补贴(老旧)：<span id="oldcar_' . $modelId . '"></span>
                                                                </td>
                                                                <td style="text-align:left"></td>
                                                            </tr>
                                                            <tr>
                                                                <td></td>
                                                                <td style="text-align:left"></td>
                                                                <td style="text-align:left"></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <p class="look">
                                                        <a target="_blank" href="/offers_' . $modelId . '.html">查看全部商情</a>
                                                    </p>
                                                </div>
                                                <div class="table_right">
                                                    <p style="text-align:center; height:40px; line-height:40px;">
                                                        报价ID：<span id="cp_id_' . $modelId . '"></span>
                                                    </p>
                                                    <div class="table_img"> 
                                                        <div style="height: 60px;">
                                                            <img src="/images/right_li.jpg" class="0lilv" id="lib_' . $modelId . '" style="display:none;">
                                                            <img src="/images/right_huod.jpg" id="special_' . $modelId . '" style="display:none;">
                                                        </div>
                                                        </div>
                                                    <div class="button close_bingo_price"><a href="javascript:void(0);" onclick="' . $clickJs . '"{/if}></a></div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>';
                        } else {
                            $tableStr .= '<tr class="tr_' . $modelId . '" style="display:none;">
                                        <td class="tr2" colspan="9">
                                            <div style="display:block" class="table_zhan2">
                                                <dl>
                                                    <dt>
                                                    <a id="active_url_' . $modelId . '" href="" target="_blank"><img width="190" height="142" id="dealer_pic_' . $modelId . '" onerror="this.src=\'images/offerrs_dealer.jpg\'"></a>
                                                    </dt>
                                                    <dd style="margin:0 0 0 10px;* margin-left:5px;">
                                                        <p style="border-bottom:solid 3px #e0260b; height:24px; line-height:24px;width:170px;"><span style="color:#df1a00; font-size:18px; float:left;">双11 活动礼遇</span>
                                                            <a id="source_url_' . $modelId . '" style=" float:right; line-height:30px;" href="#" target="_blank">查看详细</a>
                                                        </p>
                                                        <div class="tr2_left">
                                                            <dl id="dl_chou_' . $modelId . '" style="height:30px; width:210px; background:none; display:none;">
                                                                <dt>抽</dt>
                                                                <dd style="width:135px;" id="chou_' . $modelId . '"></dd>
                                                            </dl>
                                                            <dl id="dl_xian_' . $modelId . '" style="height:30px; width:210px; background:none; display:none;">
                                                                <dt>限</dt>
                                                                <dd style="width:135px;" id="xian_' . $modelId . '"></dd>
                                                            </dl>
                                                            <dl id="dl_zeng_' . $modelId . '" style="height:30px; width:210px; background:none; display:none;">
                                                                <dt>赠</dt>
                                                                <dd style="width:135px" id="zeng_' . $modelId . '"></dd>
                                                            </dl>
                                                        </div>
                                                        <div class="clear"></div>
                                                    </dd>
                                                </dl>
                                                <div class="table_zhong">
                                                    <table width="597">
                                                        <tbody><tr>
                                                                <th width="184px" id="price_type_' . $modelId . '"></th>
                                                                <th width="207px" style="text-align:left">补贴政策</th>
                                                                <th width="202px" style="text-align:left">0利率</th>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    获取方式：网络双十一</span>
                                                                </td>
                                                                <td style="text-align:left">
                                                                    节能惠民补贴：<span id="jnbt_' . $modelId . '"></span>
                                                                </td>
                                                                <td style="text-align:left" id="rate_' . $modelId . '"></td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <span id="get_time_' . $modelId . '">有效时间：</span>
                                                                </td>
                                                                <td style="text-align:left">
                                                                    置换补贴(老旧)：<span id="oldcar_' . $modelId . '"></span>
                                                                </td>
                                                                <td style="text-align:left"></td>
                                                            </tr>
                                                            <tr>
                                                                <td></td>
                                                                <td style="text-align:left"></td>
                                                                <td style="text-align:left"></td>
                                                            </tr>
                                                        </tbody></table>
                                                    <p class="look">
                                                        <a target="_blank" href="/offers_' . $modelId . '.html">查看全部商情</a>
                                                    </p>
                                                </div>
                                                <div class="table_right">
                                                    <p style="text-align:center; height:40px; line-height:40px;">
                                                        报价ID：<span id="cp_id_' . $modelId . '"></span>
                                                    </p>
                                                    <div class="table_img"> 
                                                        <div style="height: 60px;">
                                                            <img src="/images/right_li.jpg" class="0lilv" id="lib_' . $modelId . '" style="display:none;">
                                                            <img src="/images/right_huod.jpg" id="special_' . $modelId . '" style="display:none;">
                                                        </div>
                                                        </div>
                                                    <div class="button close_bingo_price"><a href="javascript:void(0);" onclick="' . $clickJs . '"></a></div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>';
                        }
                    }
                }
            }
            $tableStr .= '</tbody></table>';
        }
        return $tableStr;
    }

    function getlisk($where, $limit = 10, $type = 2) {
        $rs = array();
        $this->table_name = "cp_tags";
        $this->fields = "tag_name";
        $a = ereg('[' . chr(0xa1) . '-' . chr(0xff) . ']', $where); //汉字
        $b = ereg('[0-9]', $where); //数字
        $c = ereg('[a-zA-Z]', $where); //英文
        if ($a && !$b && !$c) {//纯汉字
            $this->where = "tag_name like '$where%' ORDER BY CASE WHEN tag_name like '%$where%' THEN 1 ELSE 0 END DESC";
        } else if (!$a && !$b && $c) {//纯英文
            $this->where = "pinyin like '$where%' ORDER BY CASE WHEN pinyin like '%$where%' THEN 1 ELSE 0 END DESC";
        } else if ($a && $b && $c) {//汉字英文数字的混合字符串
            $this->where = "tag_name like '$where%' ORDER BY CASE WHEN tag_name like '%$where%' THEN 1 ELSE 0 END DESC";
        }
        $this->limit = $limit;
        $return = $this->getResult($type);

        if ($return)
            return $return;
        else
            return false;
    }

    function getliek($where, $limit = 20, $type = 2) {
        $rs = array();
        $this->table_name = "cp_tags"; //DBNAME2.
        $this->fields = "id,tag_name";
        $a = ereg('[' . chr(0xa1) . '-' . chr(0xff) . ']', $where); //汉字
        $b = ereg('[0-9]', $where); //数字
        $c = ereg('[a-zA-Z]', $where); //英文
        if ($a && !$b && !$c) {//纯汉字
            $this->where = "tag_name like '$where%' ORDER BY CASE WHEN tag_name like '%$where%' THEN 1 ELSE 0 END DESC";
        } else if (!$a && !$b && $c) {//纯英文
            $this->where = "pinyin like '$where%' ORDER BY CASE WHEN pinyin like '%$where%' THEN 1 ELSE 0 END DESC";
        } else if ($a && $b && $c) {//汉字英文数字的混合字符串
            $this->where = "tag_name like '$where%' ORDER BY CASE WHEN tag_name like '%$where%' THEN 1 ELSE 0 END DESC";
        }
        $this->limit = $limit;
        $return = $this->getResult($type);

        foreach ($return as $key => $val) {
            $this->table_name = DBNAME2 . ".counter"; //DBNAME2.
            $this->fields = "sum(pv) pv";
            $this->where = "cname='tag' and c2=$val[id]";
            $a = $this->getResult(2);
            $return[$key]['count'] = $a[0][pv];
        }

        if ($return)
            return $return;
        else
            return false;
    }

    function getlisks($where, $limit = 10, $type = 2) {
        $rs = array();
        $this->table_name = "cardb_series";
        $this->fields = "series_name";
        $this->where = "series_name like '$where%' ORDER BY CASE WHEN series_name like '%$where%' THEN 1 ELSE 0 END DESC";
        $this->limit = $limit;
        $returns = $this->getResult($type);

        if ($returns)
            return $returns;
        else
            return false;
    }

    function getSphinx($where, $sort, $limit = 10, $offset = 0, $mode = 'extended', $maxmatches = 5000, $weight = 'desc', $type = 2) {
        $this->tables = array(
            'sph_article' => 'sa',
            'cp_article' => 'ca'
        );
        $this->where = "sa.sphinx_id=ca.id  AND QUERY='$where;index=sph_article,delta_article;sort=extended:$sort,@weight $weight;filter=type_id,1;filter=state,3;mode=$mode;maxmatches=$maxmatches;'";
        $this->fields = "count(ca.id) count";
        $this->total = $this->joinTable($type);

        $this->where = "sa.sphinx_id=ca.id AND QUERY='$where;index=sph_article,delta_article;sort=extended:$sort,@weight $weight;maxmatches=$maxmatches;mode=$mode;filter=type_id,1,2;filter=state,3;offset=$offset;limit=$limit'";
        $this->fields = "ca.*,sa.weight";
        $result = $this->joinTable($type);

//        foreach ($result as $key => $val) {
//            $this->table_name = DBNAME2.".counter";//DBNAME2.
//            $this->fields = "sum(pv) pv";
//            $this->where ="cname=article and c3=$val[id]";
//            $a=$this->getResult(2);
//            $result[$key]['count']=$a[0][pv];
//        }

        if ($result)
            return $result;
        else
            return false;
    }

    function getSphinxs($where, $sort, $limit = 10, $offset = 0, $mode = 'extended', $maxmatches = 5000, $weight = 'desc', $type = 2) {
        $this->tables = array(
            'sph_article' => 'sa',
            'cp_article' => 'ca'
        );

        $this->where = "sa.sphinx_id=ca.id AND QUERY='$where;index=sph_article,delta_article;sort=extended:$sort,@weight $weight;maxmatches=$maxmatches;mode=$mode;filter=type_id,2;filter=state,3;offset=$offset;limit=$limit'";
        $this->fields = "ca.*,sa.weight";
        $result = $this->joinTable($type);

        foreach ($result as $key => $val) {
            $this->table_name = DBNAME2 . ".counter"; //DBNAME2.
            $this->fields = "sum(pv) pv";
            $this->where = "cname=video and c3=$val[id]";
            $a = $this->getResult(2);
            $result[$key]['count'] = $a[0][pv];
        }

        if ($result)
            return $result;
        else
            return false;
    }

    function getSphinxss($where, $num, $limit = 10, $offset = 0, $type = 2) {
        $this->tables = array(
            'sph_article' => 'sa',
            'cp_article' => 'ca'
        );
        $this->where = "sa.sphinx_id=ca.id AND 
QUERY='$where;index=sph_article,delta_article;sort=extended:uptime desc,@weight desc;maxmatches=5000;mode=extended;filter=type_id,1;filter=state,3;filter=parentid,$num;offset=$offset;limit=$limit'";
        $this->fields = "count(ca.id) count";
        $this->total = $this->joinTable($type);

        $this->where = "sa.sphinx_id=ca.id AND 
QUERY='$where;index=sph_article,delta_article;sort=extended:uptime desc,@weight desc;maxmatches=5000;mode=extended;filter=type_id,1;filter=state,3;filter=parentid,$num;offset=$offset;limit=$limit'";
        $this->fields = "ca.*,sa.weight";
        $result = $this->joinTable($type);

        foreach ($result as $key => $val) {
            $this->table_name = DBNAME2 . ".counter"; //DBNAME2.
            $this->fields = "sum(pv) pv";
            $this->where = "cname=article and c3=$val[id]";
            $a = $this->getResult(2);
            $result[$key]['count'] = $a[0][pv];
        }

        if ($result)
            return $result;
        else
            return false;
    }

    function getSphinxsss($where, $num, $limit = 10, $offset = 0, $type = 2) {
        $this->tables = array(
            'sph_article' => 'sa',
            'cp_article' => 'ca'
        );
        $this->where = "sa.sphinx_id=ca.id AND 
QUERY='$where;index=sph_article,delta_article;sort=extended:uptime desc,@weight desc;maxmatches=5000;mode=extended;filter=type_id,2;filter=state,3;filter=parentid,$num;offset=$offset;limit=$limit'";
        $this->fields = "count(ca.id) count";
        $this->total = $this->joinTable($type);

        $this->where = "sa.sphinx_id=ca.id AND 
QUERY='$where;index=sph_article,delta_article;sort=extended:uptime desc,@weight desc;maxmatches=5000;mode=extended;filter=type_id,2;filter=state,3;filter=parentid,$num;offset=$offset;limit=$limit'";
        $this->fields = "ca.*,sa.weight";
        $result = $this->joinTable($type);

        foreach ($result as $key => $val) {
            $this->table_name = DBNAME2 . ".counter"; //DBNAME2.
            $this->fields = "sum(pv) pv";
            $this->where = "cname=article and c3=$val[id]";
            $a = $this->getResult(2);
            $result[$key]['count'] = $a[0][pv];
        }

        if ($result)
            return $result;
        else
            return false;
    }

    function getParentCategoryName($where, $sort, $mode = 'extended', $maxmatches = 5000, $weight = 'desc', $type = 2) {
        $this->tables = array(
            'sph_article' => 'sa',
            'cp_article' => 'ca'
        );

        $this->where = "sa.sphinx_id=ca.id AND QUERY='$where;index=sph_article,delta_article;sort=extended:$sort,@weight $weight;maxmatches=$maxmatches;mode=$mode;'";
        $this->fields = "ca.*,sa.weight";
        $result = $this->joinTable($type);

        if ($result)
            return $result;
        else
            return false;
    }

    function getParentCategoryNames($where, $sort, $mode = 'extended', $maxmatches = 5000, $weight = 'desc', $type = 2) {
        $this->tables = array(
            'sph_article' => 'sa',
            'cp_article' => 'ca'
        );

        $this->where = "sa.sphinx_id=ca.id  AND QUERY='$where;index=sph_article,delta_article;sort=extended:$sort,@weight $weight;filter=state,3;mode=$mode;maxmatches=$maxmatches;'";
        $this->fields = "count(ca.id) count";
        $this->total = $this->joinTable($type);
    }

}

?>
