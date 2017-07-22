<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class models extends model {

    var $cache;

    function __construct() {
        global $_cache;
        $this->table_name = "cardb_model";
        parent::__construct();
        //时间限制
        $this->last_timestamp = time() - 24 * 3600 * 45;
        //条数限制
        $this->limit_price = 1;
        $this->cache = $_cache;
        $this->pzImg = array(
            'ssn' => array(
                'st98' => '泊车辅助',
                'st97' => '定速巡航',
                'st95' => '多功能方向盘',
                'st74' => '感应钥匙',
                'st75' => '手动模式',
                'st86' => '天窗',
                'st100' => '行车电脑',
                'st102' => '真皮座椅',
                'st171' => '自动空调',
                'st112' => '座椅电加热',
                'st150' => '自动头灯',
                'st107' => '座椅方向调节'
            ),
            'aqn' => array(
                'st80' => '车身稳定控制',
                'st148' => '氙灯',
                'st69' => '胎压监测',
                'qinang' => '安全气囊'
            ),
            'ss' => array(
                'st98' => 'bcfz',
                'st97' => 'dsxh',
                'st95' => 'dgnfxp',
                'st74' => 'gyys',
                'st75' => 'sdms',
                'st86' => 'tch',
                'st100' => 'xcdn',
                'st102' => 'zpzy',
                'st171' => 'zdkt',
                'st112' => 'zydjr',
                'st150' => 'zdtd',
                'st107' => 'zyfxtj'
            ),
            'aq' => array(
                'st80' => 'cswdkz',
                'st148' => 'xq',
                'st69' => 'tyjc',
                'qinang' => 'aqqn'
            ),
            'newssn' => array(
                "st28" => "涡轮增压",
                "st42" => "95号汽油",
                "st58" => "电子驻车",
                "st54" => "电动助力",
                "st84" => "空气悬挂",
                "st183" => "自适应巡航",
                "st82" => "陡坡缓降",
                "st178" => "并线辅助",
                "st99" => "倒车视屏影像",
                "st181" => "夜视系统",
                "st101" => "抬头数字显示",
                "st217" => "可变转向比",
                "st156" => "四门电窗",
                "st160" => "电动后视镜",
                "st87" => "全景天窗",
                "st165" => "后风挡遮阳帘",
                "st162" => "自动防炫目",
                "st161" => "后视镜加热",
                "st160" => "后视镜电调节",
                "st149" => "日间行车灯",
                "st151" => "转向辅助头灯",
                "st152" => "前雾灯",
                "st153" => "大灯高度可调",
                "st154" => "大灯清洗",
                "st155" => "车内氛围灯",
                "st94" => "方向盘电调节",
                "st96" => "方向盘换挡",
                "st221" => "座椅通风",
                "st223" => "座椅按摩",
                "st128" => "电动后备箱",
                "st172" => "后排独立空调",
                "st174" => "温度分区控制",
                "st176" => "车载冰箱",
                "st129" => "GPS",
                "st134" => "蓝牙车载电话",
                "st147" => ">8喇叭扬声器",
                "st95" => "多功能方向盘",
                "st177" => "自动泊车",
                "st70" => "轮胎零压续行",
                "st73" => "中控锁",
                "st75" => "无钥匙启动",
                'st98' => '泊车辅助',
                'st97' => '定速巡航',
                'st74' => '感应钥匙',
                'st86' => '天窗',
                'st100' => '行车电脑',
                'st102' => '真皮/仿皮椅',
                'st171' => '自动空调',
                'st112' => '前排座椅加热',
                'st150' => '自动头灯',
                'st80' => '车身稳定控制',
                'st148' => '氙灯',
                'st69' => '胎压监测',
                "st169" => "感应雨刷",
                'st225' => '内后视镜防炫',
                'st85' => '整体主动转向',
                'st103' => '运动风格座椅',
                'st104' => '座椅高低调节',
                'st105' => '腰部支撑调节',
                'st106' => '肩部支撑调节',
                'st107' => '前座椅电调节',
                'st108' => '二排靠背调节',
                'st109' => '二排座椅移动',
                'st110' => '后座椅电调节',
                'st111' => '电动座椅记忆',
                'st113' => '后排座椅加热',
                'st116' => '后排整体放倒',
                'st117' => '后排比例放倒',
                'st118' => '第三排座椅',
                'st125' => '前座中央扶手',
                'st126' => '后座中央扶手',
                'st127' => '后排杯架',
                'st130' => '定位互动服务',
                'st131' => '中控台彩色屏',
                'st132' => '人机交互系统',
                'st133' => '内置硬盘',
                'st135' => '车载电视',
                'st136' => '后排液晶屏',
                'st137' => '外接音源接口',
                'st138' => 'CD支持MP3',
                'st139' => '单碟CD',
                'st140' => '虚拟多碟CD',
                'st141' => '多碟CD系统',
                'st142' => '单碟DVD',
                'st143' => '多碟DVD',
                'st144' => '2-3喇叭音响',
                'st145' => '4-5喇叭音响',
                'st146' => '6-7喇叭音响',
                'st156' => '前电动车窗',
                'st157' => '后电动车窗',
                'st158' => '车窗防夹手',
                'st159' => '防紫外线玻璃',
                'st164' => '后视镜记忆',
                'st166' => '后排侧遮阳帘',
                'st167' => '遮阳板化妆镜',
                'st170' => '手动空调',
                'st173' => '后座出风口',
                'st175' => '花粉过滤',
                'st179' => '主动刹车系统',
                'st182' => '中控分屏显示',
                'st221' => '前排座椅通风',
                'st222' => '后排座椅通风',
                'st223' => '前排座椅按摩',
                'st224' => '后排座椅按摩',
                'st226' => '外后视镜防眩',
                'st227' => '主驾椅电调节',
                'st228' => '副驾椅电调节',
                'st64' => '前排侧气囊',
                'st65' => '后排侧气囊',
                'st66' => '前排头部气囊',
                'st67' => '后排头部气囊',
                'st68' => '膝部气囊',
                'st71' => '安全带提示',
                'st72' => '发动机电防盗',
                'st76' => 'ABS防抱死',
                'st77' => '制动力分配',
                'st78' => '刹车辅助',
                'st79' => '牵引力控制',
                'st81' => '自动驻车',
                'st83' => '可变悬架',
                'st88' => '运动外观套件',
                'st89' => '铝合金轮毂',
                'st90' => '电动吸合门',
                'st91' => '真皮方向盘',
                'st92' => '方向盘上下调',
                'st93' => '方向盘前后调',
                'st62' => '主驾气囊',
                'st63' => '副驾气囊',
                "st184" => "全景摄像头",
                "st168" => "后雨刷",
                'st163' => '后视镜电折叠',
                'st215' => '行李箱防锁',
                'st232' => '发动机启停',
                'st231' => '车道偏离预警'
            ),
            'newss' => array(
                "st28" => "xuanwo_zy",
                "st42" => "97hao_qy",
                "st58" => "dianzi_zc",
                "st54" => "diandong_zlzx",
                "st84" => "kongqi_xg",
                "st183" => "ACC_zishi",
                "st82" => "doupo_hj",
                "st178" => "bingxian_fz",
                "st99" => "daoche_yx",
                "st181" => "yeshi_xt",
                "st101" => "HUD_ttszxs",
                "st217" => "kebian_zxb",
                "st156" => "4m_dc",
                "st160" => "diandong_hsj",
                "st87" => "quanjing_tc",
                "st165" => "houfeng_dzyl",
                "st162" => "houshi_zdpxm",
                "st161" => "houshi_jr",
                "st160" => "houshi_dtj",
                "st149" => "rijian_xcd",
                "st151" => "zhuanxiang_td",
                "st152" => "qianwu_deng",
                "st153" => "dadeng_gdtj",
                "st154" => "dadeng_qx",
                "st155" => "fenwei_d",
                "st94" => "fangxiangp_ddtj",
                "st96" => "fangxiang_hd",
                "st221" => "zuoyi_tf",
                "st223" => "zuoyi_am",
                "st128" => "diandong_hbx",
                "st172" => "houpai_kt",
                "st174" => "wd_fqkz",
                "st176" => "chezai_bx",
                "st129" => "GPS",
                "st134" => "lanya",
                "st147" => "8laba-x",
                "st95" => "duogong_fxp",
                "st177" => "zidong_bcrw",
                "st70" => "lingya_xux",
                "st73" => "zhongkong_suo",
                "st75" => "wuyaoshi_qd",
                "st62" => "anquan_qn",
                "st63" => "anquan_qn",
                'st98' => 'daoche_ld',
                'st97' => 'dingsu_xh',
                'st74' => 'yaokong_yaoshi',
                'st86' => 'tianchuang',
                'st100' => 'xingche_dn',
                'st102' => 'zhenpi_zuoyi',
                'st171' => 'zidong_kt',
                'st112' => 'st_112',
                'st150' => 'zidong_daqi',
                'st80' => 'ESP',
                'st148' => 'shanqi',
                'st69' => 'taiya_jiance',
                'st169' => 'ganying_ys',
                'st163' => 'diandong_hsj',
                'st85' => 'st_85',
                'st103' => 'st_103',
                'st104' => 'st_104',
                'st105' => 'st_105',
                'st106' => 'st_106',
                'st107' => 'st_107',
                'st108' => 'st_108',
                'st109' => 'st_109',
                'st110' => 'st_110',
                'st111' => 'st_111',
                'st113' => 'st_113',
                'st116' => 'st_116',
                'st117' => 'st_117',
                'st118' => 'st_118',
                'st125' => 'st_125',
                'st126' => 'st_126',
                'st127' => 'st_127',
                'st130' => 'st_130',
                'st131' => 'st_131',
                'st132' => 'st_132',
                'st133' => 'st_133',
                'st135' => 'st_135',
                'st136' => 'st_136',
                'st137' => 'st_137',
                'st138' => 'st_138',
                'st139' => 'st_139',
                'st140' => 'st_140',
                'st141' => 'st_141',
                'st142' => 'st_142',
                'st143' => 'st_143',
                'st144' => 'st_144',
                'st145' => 'st_145',
                'st146' => 'st_146',
                'st156' => 'st_156',
                'st157' => 'st_157',
                'st158' => 'st_158',
                'st159' => 'st_159',
                'st164' => 'st_164',
                'st166' => 'st_166',
                'st167' => 'st_167',
                'st170' => 'st_170',
                'st173' => 'st_173',
                'st175' => 'st_175',
                'st179' => 'st_179',
                'st182' => 'st_182',
                'st221' => 'st_221',
                'st222' => 'st_222',
                'st223' => 'st_223',
                'st224' => 'st_224',
                'st226' => 'st_226',
                'st227' => 'st_227',
                'st228' => 'st_228',
                'st64' => 'st_64',
                'st65' => 'st_65',
                'st66' => 'st_66',
                'st67' => 'st_67',
                'st68' => 'st_68',
                'st71' => 'st_71',
                'st72' => 'st_72',
                'st76' => 'st_76',
                'st77' => 'st_77',
                'st78' => 'st_78',
                'st79' => 'st_79',
                'st81' => 'st_81',
                'st83' => 'st_83',
                'st88' => 'st_88',
                'st89' => 'st_89',
                'st90' => 'st_90',
                'st91' => 'st_91',
                'st92' => 'st_92',
                'st93' => 'st_93',
                'st225' => 'st_225',
                'st184' => 'st_184',
                'st168' => 'st_168',
                'st215' => 'st_215',
                'st232' => 'st_232',
                'st231' => 'st_231'
            )
        );
    }

    function getSelectJson() {
        $this->reset();
        $lastTimestamp = $this->last_timestamp;
        $this->tables = array(
            'cardb_model' => 'cm',
            'cardb_pricelog' => 'cp'
        );
        $this->fields = 'cm.model_id, count(*) as count_mid';
        $this->where = "cm.model_id = cp.model_id AND cm.state in (3, 8) AND cp.price > 0 AND cp.price_type = 0";
        $this->group = 'cm.model_id';
        $modelIds = $this->joinTable(2);
        if (!empty($modelIds)) {
            $idList = '';
            foreach ($modelIds as $k => $v) {
                if ($v['count_mid'] >= $this->limit_price)
                    $idList .= ',' . $v['model_id'];
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
            foreach ($result as $k => $v) {
                $result[$k]['brand_name'] = iconv('gbk', 'utf-8', $v['brand_name']);
            }
            $data['brand_js'] = json_encode($result);
            unset($result);
            $this->fields = 'series_id, series_name, brand_id';
            $this->where = "model_id in ($idList)";
            $this->order = array('series_id' => 'ASC');
            $this->group = 'series_id';
            $result = $this->getResult(2);
            foreach ($result as $k => $v) {
                $v['series_name'] = iconv('gbk', 'utf-8', $v['series_name']);
                $seriesJs[$v['brand_id']][$v['series_id']] = $v;
            }
            $data['series_js'] = json_encode($seriesJs);
            return $data;
        } else
            return false;
    }

    function getBrand($type = 1) {
        $this->table_name = 'cardb_brand';
        $this->fields = "brand_id, brand_name, letter";
        $this->where = "state=3 and brand_name<>''";
        $this->order = array('letter' => 'ASC');
        $ret = $this->getResult(4);
        foreach ($ret as $k => $v) {
            $letter = strtoupper(util::Pinyin($v['brand_name']));
            if (empty($letter))
                $letter = $v['letter'];
            if ($type) {
                $brand[$letter][] = array(
                    'brand_id' => $k,
                    'brand_name' => $v['brand_name'],
                    'letter' => $letter
                );
            } else {
                $brand[$k] = array(
                    'brand_id' => $k,
                    'brand_name' => $v['brand_name'],
                    'letter' => $letter
                );
            }
        }
        $this->reset();
        return $brand;
    }

    function getDealerByMid($mid) {
        $this->tables = array(
            'dealer_info' => 'd',
            'dealer_price' => 'p'
        );
        $this->fields = 'd.dealer_id, d.dealer_area, d.dealer_name, p.bingo_price, p.inventory';
        $this->where = "d.dealer_id = p.dealer_id AND p.model_id = $mid";
        $result = $this->joinTable(2);
        return $result;
    }

    function getModel($fields, $where, $flag, $order = array(), $limit = 0) {
        $this->reset();
        $this->fields = $fields;
        $this->where = $where;
        $this->order = $order;
        $this->table_name = "cardb_model";
        if ($limit) {
            $this->limit = $limit;
        }
        $result = $this->getResult($flag);
        return $result;
    }

    function getOneModel($fields, $mid) {
        $this->reset();
        $this->fields = $fields;
        $this->where = "model_id = $mid";
        $result = $this->getResult();
        return $result;
    }

    function getModelColor($mid) {
        $this->tables = array(
            'cardb_model' => 'cm',
            'cardb_color' => 'cc'
        );
        $this->fields = 'color_pic, color_name';
        $this->where = "cc.type_name = 'model' AND cm.model_id = cc.type_id AND cc.type_id = $mid";
        $result = $this->joinTable(2);
        return $result;
    }

    //根据series_id取出车款信息
    function getModelsbyseriesid($seriesid) {
        global $_cache;
        $chache_key = "series_models_$seriesid";
        $models = $_cache->getCache($chache_key);
        if ($models) {
            return $models;
        } else {
            $this->fields = "model_id,model_name,model_pic1,model_pic2,IF(bingo_price>0,bingo_price,dealer_price_low) as bingobang_price, model_price,dealer_price_low,bingo_price";
            $this->where = " (state=3 or state=7 or state=8) and series_id='$seriesid'";
            $this->order = array("model_name" => "asc");
            $result = $this->getResult(2);
            $ret = array();
            if ($result) {

                foreach ($result as $key => $value) {
                    $value["model_name"] = $value["model_name"];
                    if (!empty($value["model_pic1"])) {
                        $value["firstpic"] = "attach/images/model/" . $value['model_id'] . "/180x100" . $value["model_pic1"];
                    } else if (!empty($value["model_pic2"])) {
                        $value["firstpic"] = "attach/images/model/" . $value['model_id'] . "/180x100" . $value["model_pic2"];
                    }
                    $ret[] = $value;
                }
            }
            $_cache->writeCache($chache_key, $ret, 600);
            return $ret;
        }
    }

    //新配置图标
    function newRangeConfigImg($model) {
        $pzImg = $this->pzImg;
        $newss = $pzImg['newss'];
        $ssKey = array_keys($newss);
        $newss = array();
        foreach ($model as $kk => &$vv) {
            if (in_array($kk, $ssKey)) {
                if ($kk != "st156" || $kk != "st221" || $kk != "st223") {
                    if ($vv == "标配") {
                        $newss[$kk] = $kk;
                    }
                }
            }
        }
        if ($model[st28] == "涡轮增压") {
            $newss[st28] = "st28";
        }
        if ($model[st58] == "有") {
            $newss[st58] = "st58";
        }
        if ($model[st54] == "电动助力") {
            $newss[st54] = "st54";
        }
        if (strpos($model[st42], "97") !== false) {
            $newss[st42] = "st42";
        }
        if ($model[st84] == "有") {
            $newss[st84] = "st84";
        }

        asort($newss);
        $model['newss'] = $newss;

        return $model;
    }

    //重排舒适、安全配置小图标
    function rangeConfigImg($model) {
        $pzImg = $this->pzImg;
        $ss = $pzImg['ss'];
        $aq = $pzImg['aq'];
        $ssKey = array_keys($ss);
        $aqKey = array_keys($aq);

        //气囊个数
        $i = 0;
        if ($model["st62"] == "标配") {
            ++$i;
        }
        if ($model["st63"] == "标配") {
            ++$i;
        }
        if ($model["st64"] == "标配") {
            $i+=2;
        }
        if ($model["st65"] == "标配") {
            $i+=2;
        }
        if ($model["st66"] == "标配") {
            ++$i;
        }
        if ($model["st67"] == "标配") {
            ++$i;
        }
        if ($model["st68"] == "标配") {
            $i+=2;
        }
        $model['qinang'] = $i > 0 ? '标配' : '无';
        $model["qinang_count"] = $i;
        $ss = $aq = array();
        foreach ($model as $kk => &$vv) {
            if (in_array($kk, $ssKey)) {
                if ($vv == '' || $vv == '选配' || $vv == NULL)
                    $vv = '无';
                $ss[$kk] = $vv;
            }
            if (in_array($kk, $aqKey)) {
                if ($vv == '' || $vv == '选配' || $vv == NULL)
                    $vv = '无';
                $aq[$kk] = $vv;
            }
        }
        asort($ss);
        asort($aq);
        $model['ss'] = $ss;
        $model['aq'] = $aq;
        return $model;
    }

    function getSeriesmodelsbymid($modelid) {
        $cache_key = 'seriesmodel_mid' . $modelid;
        $cache_time = 86400;
        $result = $this->cache->getCache($cache_key);
        if (!$result) {
            $this->reset();
            $this->fields = "cm.*,cs.pros,cs.offical_url, IF(cm.bingo_price>0, cm.bingo_price, cm.dealer_price_low) as bingobang_price,cs.cons,cs.last_picid,cs.series_intro,cs.series_pic,cs.score,cs.default_model";
            $this->where = "cm.model_id='$modelid'  and cs.series_id=cm.series_id";
            $this->tables = array("cardb_series" => "cs", "cardb_model" => "cm");
            $result = $this->joinTable(1);
            if (!empty($result["model_pic1"])) {
                $result["firstpic"] = "attach/images/model/" . $result['model_id'] . "/180x100" . $result["model_pic1"];
            } else if (!empty($result["model_pic2"])) {
                $result["firstpic"] = "attach/images/model/" . $result['model_id'] . "/180x100" . $result["model_pic2"];
            }
            $this->cache->writeCache($cache_key, $result, $cache_time);
        }
        return $result;
    }

    /**
     * 获取车款亮点配置
     * @param type $model
     * @return string
     */
    function getModelPz($model, $paramArr) {
        $cache_key = 'bo_modelpz' . $model['model_id'];
        $cache_time = 86400;
        $m_pz = $this->cache->getCache($cache_key);
        if (!$m_pz) {
            $model_pz = $this->newRangeConfigImg($model);
            foreach ($paramArr as $key => $value) {
                $m_arr = explode(',', $value['p_id']);
                $p_num = 0;
                foreach ($m_arr as $k => $v) {
                    $p_id = st . $v;
                    if (array_search($p_id, $model_pz['newss'])) {
                        ++$p_num;
                    }
                }
                if ($p_num > 0) {
                    continue;
                } else {
                    $m_st = st . $value['id'];
                    if ($m_st_num < 20) {
                        if (array_search($m_st, $model_pz['newss'])) {
                            $m_pz[] = $m_st;
                            $m_st_num++;
                        }
                    }
                }
            }
            $this->cache->writeCache($cache_key, $m_pz, $cache_time);
        }
        return $m_pz;
    }

    //车款图标配置
    function ModelPz($mdoel, $paramArr) {
        $type = array(
            1 => array(33, 34, 35), //安全  安全+防盗+主动安全
            2 => array(6, 31, 40), //舒适  座椅储物+加热通风+娱乐通讯
            3 => array(38, 39), //驾驶辅助+中控方向盘
            4 => array(5, 36, 37)//车窗后视+车身外饰+灯光照明
        );
        $p_st_num = 0;
        $pz_type = array();
        $row = $this->newRangeConfigImg($mdoel);
        if (strpos($row['st42'], '95')) {
            $resutl['pz_newss']['st42'] = "st42";
        }
        foreach ($paramArr as $key => $value) {
            if ($value['p_id']) {
                // $p_id = st.$value['p_id'];
                $p_arr = explode(',', $value['p_id']);
                $p_num = 0;
                foreach ($p_arr as $k => $v) {
                    $p_id = st . $v;
                    if (array_search($p_id, $row['newss'])) {
                        ++$p_num;
                    }
                }
                if ($p_num > 0) {
                    continue;
                } else {
                    $p_st = st . $value['id'];
                    if (array_search($p_st, $row['newss'])) {

                        $resutl['pz_newss'][$p_st] = $p_st;
                        if (array_search($value['pid3'], $type[1]) !== false) {
                            $pz_type[1][$p_st] = $p_st;
                        }
                        if (array_search($value['pid3'], $type[2]) !== false) {
                            $pz_type[2][$p_st] = $p_st;
                        }
                        if (array_search($value['pid3'], $type[3]) !== false) {
                            $pz_type[3][$p_st] = $p_st;
                        }
                        if (array_search($value['pid3'], $type[4]) !== false) {
                            $pz_type[4][$p_st] = $p_st;
                        }
                    }
                }
            } else {
                $p_st = st . $value['id'];
                if (array_search($p_st, $row['newss'])) {

                    $resutl['pz_newss'][$p_st] = $p_st;
                    if (array_search($value['pid3'], $type[1]) !== false) {
                        $pz_type[1][$p_st] = $p_st;
                    }
                    if (array_search($value['pid3'], $type[2]) !== false) {
                        $pz_type[2][$p_st] = $p_st;
                    }
                    if (array_search($value['pid3'], $type[3]) !== false) {
                        $pz_type[3][$p_st] = $p_st;
                    }
                    if (array_search($value['pid3'], $type[4]) !== false) {
                        $pz_type[4][$p_st] = $p_st;
                    }
                }
            }
        }
        ksort($pz_type);
        foreach ($pz_type as $k => &$v) {
            $v = array_chunk($v, 36, true);
        }

        $resutl['pz_type'] = $pz_type;
        $resutl['pz_newss'] = @array_chunk($resutl['pz_newss'], 36, true);

        return $resutl;
    }

    /**
     * 可以控制显示图片大小的
     * @param $modelid
     */
    function getSeriesmodelsbymidpic($modelid, $picsize) {
        $this->reset();
        $this->fields = "cm.*,cs.pros,cs.offical_url, IF(cm.bingo_price>0, cm.bingo_price, cm.dealer_price_low) as bingobang_price,cs.cons,cs.last_picid,cs.series_intro,cs.series_pic,cs.score,cs.default_model";
        $this->where = "cm.model_id='$modelid'  and cs.series_id=cm.series_id";
        $this->tables = array("cardb_series" => "cs", "cardb_model" => "cm");
        $result = $this->joinTable(1);
        /*
          //修改如下
          if (!empty($result["model_pic1"])) {
          $result["firstpic"] = "attach/images/model/" . $result['model_id'] . "/" . $picsize . $result["model_pic1"];
          } else if (!empty($result["model_pic2"])) {
          $result["firstpic"] = "attach/images/model/" . $result['model_id'] . "/" . $picsize . $result["model_pic2"];
          } */
        $result["firstpic"] = "attach/images/model/" . $result['model_id'] . "/" . $picsize . $result["model_pic2"];

        return $result;
    }

    function getModelbyid($id, $type = "model", $getType = 1, $wheres = "", $state = '') {
        $this->reset();
        if (intval($id) < 1) {
            return "";
        }
        $this->fields = "model_id,model_name,model_memo,model_price,bingo_price,dealer_price_low,brand_id,brand_name,factory_id,factory_name,series_id,series_name,date_id,type_id,type_name,st27,st36,st28,model_pic1,model_pic2";
        if ($type == "model") {
            $this->where = "model_id='$id'";
        } else if ($type == "series") {
            $this->where = "series_id='$id'";
            $this->order = array("date_id" => "DESC", "model_price" => "ASC");
        }
        if (empty($state)) {
            $state = " and (state=3 or state=7 or state=8)";
        }
        $this->where .= $state . $wheres;
        $model = $this->getResult($getType);
        return $model;
    }

    //根据车型信息取出同系列的同年其他车型
    function getModellist($seriesid, $date_id, $limit = null) {
        $this->reset();
        $this->fields = "model_id,model_name,unionpic";
        $this->where = "series_id='$seriesid' and date_id='$date_id' and (state=3 or state=7 or state=8)";
        $this->order = array("model_id" => "DESC");
        if (!empty($limit)) {
            $this->limit = $limit;
        }
        return $this->getResult(2);
    }

    /**
     * 根据series_id取出同系车参数配置信息
     * @param $series_id
     * @return array
     */
    public function getParamBySeriesId($seriesid) {
        $this->reset();
        $this->where = "series_id='$seriesid' and (state=3 or state=7 or state=8)";
        $this->order = array("model_id" => "desc");
        return $this->getResult(2);
    }

    /**
     * 根据model_id取得浏览记录
     * @param $model_id
     * @return array
     */
    function getModelInfoHistory($model_id) {
        $this->reset();
        $this->fields = "model_id,model_name,factory_name,series_name";
        $this->where = "model_id in ($model_id)";
        //$this->order = array("model_id","asc");
        return $this->getResult(2);
    }

    /**
     * 根据model_id取出车参数配置信息
     * @param $model_id
     * @return array
     */
    function getSeriesmodels($bytype = "series", $id, $date_id = null, $order = array(), $type = 2, $pic_size = "180x100", $apendwhere = "") {
        $this->reset();
        if ($bytype == "model") {
            $this->where = " cm.model_id='$id' ";
        } else {
            $this->where = " cs.series_id='$id' ";
        }
        if ($date_id) {
            $this->where .= " and cm.date_id='$date_id' ";
        }
        $this->where .= " and  cs.series_id=cm.series_id " . $apendwhere;
        $this->fields = "cm.*,cs.price_low,cs.price_high,cs.series_pic,cs.price_low,cs.last_picid,cs.series_pic";
        $this->order = $order;
        $this->tables = array("cardb_series" => "cs", "cardb_model" => "cm");
        $result = $this->joinTable($type);
        if ($bytype == "model") {
            if (!empty($result["model_pic1"])) {
                $result["firstpic"] = "attach/images/model/" . $result['model_id'] . "/$pic_size" . $result["model_pic1"];
            } else if (!empty($result["model_pic2"])) {
                $result["firstpic"] = "attach/images/model/" . $result['model_id'] . "/$pic_size" . $result["model_pic2"];
            }
        } else {
            foreach ($result as $key => $value) {
                if (!empty($value["model_pic1"])) {
                    $value["firstpic"] = "attach/images/model/" . $value['model_id'] . "/$pic_size" . $value["model_pic1"];
                } else if (!empty($value["model_pic2"])) {
                    $value["firstpic"] = "attach/images/model/" . $value['model_id'] . "/$pic_size" . $value["model_pic2"];
                }
                $result[$key] = $value;
            }
        }
        return $result;
    }

    /**
     * 根据model_id取出关注车款        关系的车身形式和级别      价格在指导价的上下浮动30%   在线在售
     * 首先按 同车身形式+指导价最接近+在售 找到3个结果
     *
     * 2.然后按 同级别+指导价差值上下30%+在售+与第一部分不通车系，随机找出2个结果
     *  第一部分还得增加一条 不同车系
     *
     * @param $modelid  当前浏览的车款id  $type_id 车身级别   $st4车身形式 3个
     * @return array
     */
    function getAttentionModel($modelid, $modelPrice, $type_id, $st4) {
        if ($modelPrice) {
            $model_prcieStMin = $modelPrice * 0.95;
            $model_prcieStMax = $modelPrice * 1.05;
            $model_priceMin = $modelPrice * 0.7;
            $model_priceMax = $modelPrice * 1.3;
        }
        $this->fields = '*, IF(bingo_price>0,bingo_price,dealer_price_low) as bingobang_price';
        $this->where = " st4 = '$st4' AND state in(3,7) AND model_id !=$modelid AND IF(bingo_price>0,bingo_price,dealer_price_low) >0 ";
        if ($modelPrice) {
            $this->where .=" and model_price between $model_prcieStMin and $model_prcieStMax ";
        }
        $this->group = 'series_id';
        $this->order = array(
            'views' => 'DESC',
            'model_price' => 'ASC'
        );
        $this->limit = 3;
        $this->getall = 0;
        $sameSt = $this->getResult(2);

        if (!empty($sameSt)) {
            $seriesIds = array();
            foreach ($sameSt as $row) {
                $seriesIds[] = $row['series_id'];
            }
            $seriesIdList = implode(',', $seriesIds);
        }

        $this->where = "type_id = '$type_id' AND state in(3,7) AND model_id !=$modelid AND IF(bingo_price>0,bingo_price,dealer_price_low) >0";

        if (!empty($seriesIdList))
            $this->where .= " AND series_id not in ($seriesIdList)";
        if ($modelPrice) {
            $this->where .=" and model_price  between $model_priceMin and $model_priceMax";
        }
        $this->limit = 50;
        $sameType = $this->getResult(2);

        $result['same_st'] = $sameSt;
        if (count($sameType) >= 2) {
            $num = array_rand($sameType, 2);
            $tmp[] = $sameType[$num[0]];
            $tmp[] = $sameType[$num[1]];
            $result['same_type'] = $tmp;
        } else {
            $result['same_type'] = $sameType;
        }


        return $result;
    }

    function getAttentionModel1($modelid, $modelPrice, $type_id, $st4) {
        if ($modelPrice) {
            $model_priceMin = $modelPrice * 0.7;
            $model_priceMax = $modelPrice * 1.3;
        }

        $this->fields = '*, IF(bingo_price>0,bingo_price,dealer_price_low) as bingobang_price';
        $this->where = "type_id = $type_id AND state in(3,7)";
        if ($modelPrice) {
            $this->where .=" and model_price between $model_priceMin and $model_priceMax";
        }
        $this->group = 'series_id';
        $this->order = array(
            'views' => 'DESC',
            'model_price' => 'ASC'
        );
        $this->limit = 21;
        $sameType = $this->getResult(2);

        if (!empty($sameType)) {
            $seriesIds = array();
            foreach ($sameType as $row) {
                $seriesIds[] = $row['series_id'];
            }
            $seriesIdList = implode(',', $seriesIds);
        }
        $this->where = "st4 = '$st4' AND state in(3,7)";

        if (!empty($seriesIdList))
            $this->where .= " AND series_id not in ($seriesIdList)";
        if ($modelPrice) {
            $this->where .=" and model_price  between $model_priceMin and $model_priceMax";
        }
        $this->limit = 20;
        $sameSt = $this->getResult(2);

        if (count($sameType) >= 2) {
            $num = array_rand($sameType, 2);
            $tmp1[] = $sameType[$num[0]];
            $tmp1[] = $sameType[$num[1]];
            $result['same_type'] = $tmp1;
            if (count($sameSt) >= 3) {
                $num = array_rand($sameSt, 3);
                $tmp2[] = $sameSt[$num[0]];
                $tmp2[] = $sameSt[$num[1]];
                $tmp2[] = $sameSt[$num[2]];
                $result['same_st'] = $tmp2;
            } else {
                $result['same_st'] = $sameSt;
            }
        } else {
            $sameTypeNum = count($sameType);
            $result['same_type'] = $sameType;
            if ($sameTypeNum == 1) {
                if (count($sameSt) >= 4) {
                    $num = array_rand($sameSt, 4);
                    $tmp2[] = $sameSt[$num[0]];
                    $tmp2[] = $sameSt[$num[1]];
                    $tmp2[] = $sameSt[$num[3]];
                    $tmp2[] = $sameSt[$num[4]];
                    $result['same_st'] = $tmp2;
                } else {
                    $result['same_st'] = $sameSt;
                }
            } else {
                if (count($sameSt) >= 5) {
                    $num = array_rand($sameSt, 5);
                    $tmp2[] = $sameSt[$num[0]];
                    $tmp2[] = $sameSt[$num[1]];
                    $tmp2[] = $sameSt[$num[2]];
                    $tmp2[] = $sameSt[$num[3]];
                    $tmp2[] = $sameSt[$num[4]];
                    $result['same_st'] = $tmp5;
                } else {
                    $result['same_st'] = $sameSt;
                }
            }
        }

        return $result;
    }

    /**
     * 取配置     modelinfo  
     * @param type $model  车款信息
     * @param type $pzImg  配置信息
     * @return string $model  处理的车款信息
     */
    function getSsSq($model, $pzImg) {
        //$pzImg = $this->pz_img;
        $ssKey = array_keys($pzImg['ss']);
        $aqKey = array_keys($pzImg['aq']);
        //气囊个数
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
        $model['qinang'] = $i > 0 ? '标配' : '无';
        $model["qinang_count"] = $i;

        $ss = $aq = array();
        foreach ($model as $kk => $vv) {
            if (in_array($kk, $ssKey)) {
                if ($vv == '')
                    $vv = '无';
                $ss[$kk] = $vv;
            }
            if (in_array($kk, $aqKey)) {
                if ($vv == '')
                    $vv = '无';
                $aq[$kk] = $vv;
            }
        }
        asort($ss);
        asort($aq);
        $model['ss'] = $ss;
        $model['aq'] = $aq;
        return $model;
    }

    function getParams($model) {
        $paramattr = $this->param->paramattr;
        $attr = array();
        foreach ($paramattr as $key => $value) {
            foreach ($value["attr"] as $k => $v) {
                $tem = explode("-", $v["pid"]);
                $temv = null;
                if (count($tem) > 1) {
                    if ($v["name"] == "比功率(kw/kg)") {
                        if (isset($model["st" . $tem[0]]) && $model["st" . $tem[0]] != "-" && $model["st" . $tem[0]] != "无" && isset($model["st" . $tem[1]]) && $model["st" . $tem[1]] != "-" && $model["st" . $tem[1]] != "无") {
                            $temv = (intval(($model["st" . $tem[0]] / $model["st" . $tem[1]]) * 1000)) / 1000;
                        } else {
                            $temv = "";
                        }
                    } else {
                        $temv = $model["st" . $tem[0]] . "/" . $model["st" . $tem[1]];
                    }
                } else {

                    if ($model["st" . $v["pid"]] == "标配") {
                        $temv = '<img src="images/black.png">';
                    } else if ($model["st" . $v["pid"]] == "选配") {
                        $temv = '<img src="images/white.png">';
                    } else {
                        $temv = $model["st" . $v["pid"]];
                    }
                }
                $temv = strval($temv);
                if ($key < 3) {
                    $j = 0;
                } else {
                    $j = 1;
                }
                if (isset($temv) && $temv != "无" && trim($temv) != "" && trim($temv) != "无/无" && trim($temv) != "/" && trim($temv) != "/无" && trim($temv) != "无/" && trim($temv) != "工信部未公布") {
                    $attr[$j][$value["title"]][$v["name"]]["value"] = $model ? $temv : "";
                } else {
                    $attr[$j][$value["title"]][$v["name"]]["value"] = $model ? "<strong>---</strong>" : "";
                }
            }
        }

        return $attr;
    }

    /**
     * //取出车型图片
     * @param type $seriemodel
     * @param type $returnyear
     * @return string
     */
    function getModelPic($seriemodel, $returnyear = false) {

        $newmodel = $year = array();
        if ($returnyear == true) {
            //判断是否 有优惠车型
            foreach ($seriemodel as $key => $value) {

                $dprice = number_format($value["model_price"] - $value["bingo_price"], 2);
                $value["dprice"] = floatval($dprice) > 0.00 ? $dprice . "万" : "无优惠";

                //气囊个数
                $i = 0;
                if ($value["st62"] == "标配") {
                    $i++;
                }
                if ($value["st63"] == "标配") {
                    $i++;
                }
                if ($value["st64"] == "标配") {
                    $i+=2;
                }
                if ($value["st65"] == "标配") {
                    $i+=2;
                }
                if ($value["st66"] == "标配") {
                    $i++;
                }
                if ($value["st67"] == "标配") {
                    $i++;
                }
                if ($value["st68"] == "标配") {
                    $i+=2;
                }
                $value["qinang"] = $i;

                $newmodel[$value["date_id"]][] = $value;

                if (!array_key_exists($value["date_id"], $year)) {
                    $year[$value["date_id"]] = $value["date_id"];
                }
            }
            ksort($year);
            return $result = array("models" => $newmodel, "year" => $year);
        } else {
            $newmodel = array(
                "在售" => array("sum" => 0),
                "停产在售" => array("sum" => 0),
            );
            foreach ($seriemodel as $key => $value) {
                $tem = explode(" ", $value["st1"]);
                $value["st1"] = $tem[0] . " " . $tem[2] . "<br>" . $tem[1];
                $seriemodel[$key] = $value;
                if ($value['state'] == 3 || $value['state'] == 7) {
                    $newmodel["在售"][] = $seriemodel[$key];
                } else {
                    $newmodel["停产在售"][] = $seriemodel[$key];
                }
            }
            return $newmodel;
        }
    }

    function getmodelidbyseriesid($series_id) {
        $this->fields = "model_id";
        $this->where = "series_id in ($series_id) and  (state=3 or state=7 or state=8)";
        return $result = $this->getResult(2);
    }
    /**
     * 
     */
    function getModelImageList($series_id, $color_name = false) {
        $result = array();
        if ($color_name) {
            $this->fields = "md.model_name,md.model_id,md.date_id,md.series_id,md.series_name";
            $this->where = "md.model_id=fl.type_id and fl.s1=$series_id and fl.pic_color='$color_name' and md.state=3";
            $this->order = array("md.date_id" => "desc");
            $this->group = "fl.type_id";
            $this->tables = array("cardb_model" => "md", "cardb_file" => "fl");
            $arr = $this->joinTable(2);
        } else {
            //如果没有颜色的id.根据车系的id为条件条件从model表查询字段
            $this->fields = "model_name,model_id,date_id,series_id,series_name";
            $this->where = "series_id=$series_id and state=3";
            $this->order = array("date_id" => "desc"); //年份排序
            $arr = $this->getResult(2);
        }
        
        if ($arr) {
            $series_total = '';
            $series_name = $arr[0][series_name];
            foreach ($arr as $key => $value) {
                $this->table_name = "cardb_file";
                $this->fields = "name,count(id) as model_total";
                $this->where = "type_id={$value[model_id]} and ppos<900 and type_name='model'";
                $this->group = '';
                $this->order = array();
                $aaa = $this->getResult(2);

                $series_total += $aaa[model_total]; //+1赋给变量
                $arr[$key][model_total] = $aaa[model_total]; //放到模板数组里面
                $arr[$key][model_image] = $aaa[name];

                //查询颜色
                $this->fields = "pos,pic_color,count(id) as total";
                $this->where = "type_id=$value[model_id] and pos=1 and pic_color!=''";
                $this->group = "pic_color";
                $color = $this->getResult(2);
                $this->color = new color();
                if ($color) {
                    foreach ($color as $kk => $vv) {
                        $color[$kk][color_id] = $this->color->getColorlist("id", "color_name='$vv[pic_color]'", 3); //查到的id赋给变量color_id
                    }
                }
                $arr[$key][color] = $color; //把上面的$color的值赋给$arr
            }
            foreach ($arr as $k => $v) {
                $res[$v[date_id]][] = $v; //赋给年份变量
            }

            $result[series_total] = $series_total; //
            $result[series_name] = $series_name;
            $result[content] = $res; //年份的数组赋给content
        }

        return $result;
    }

    /*
     * 取出车系的颜色
     * 
     */

    function getSeriesColorList($where) {

        $this->table_name = "cardb_file";
        $this->fields = "pic_color,count(id) as color_total";
        $this->order = array();
        $this->group = "pic_color";
        if ($where) {
            $this->where = $where;
            $this->where .=" and pic_color!=''";
        } else {
            $this->where = "s1=$series_id and pic_color!=''";
        }
        $arr = $this->getResult(2);
        if ($arr) {
            foreach ($arr as $key => $value) {
                $this->table_name = "cardb_color";
                $this->fields = "id,color_pic";
                $this->where = "color_name = '$value[pic_color]'";
                $this->group = '';
                $aaa = $this->getResult();
                if ($aaa['color_pic']) {
                    $result[$value[pic_color]][url] = $aaa[color_pic];
                    $result[$value[pic_color]][total] = $value[color_total];
                    $result[$value[pic_color]][color_id] = $aaa[id];
                }
            }
        }
        return $result;
    }

    /**
     * 根据车款id取车款名称
     */
    function getModelNameByid($model_id) {
        $this->fields = "model_name";
        $this->where = "model_id=$model_id";
        $result = $this->getResult(3);
        return $result;
    }

    /* 获取车系的竞争车系 */

    function getCompeteSeries($sid) {
        $this->reset();
        $lastTimestamp = $this->last_timestamp;
        $this->fields = 'compete_id';
        $this->where = "series_id = $sid AND state in(3, 8)";
        $result = $this->getResult(2);
        $competeId = array();
        if (!empty($result)) {
            foreach ($result as $k => $v) {
                if ($v['compete_id'] && strpos($v['compete_id'], ',,') === false)
                    $competeId[] = $v['compete_id'];
            }
            if (!empty($competeId)) {
                $this->tables = array(
                    'cardb_model' => 'cm',
                    'cardb_pricelog' => 'cp'
                );
                $idList = implode(',', $competeId);
                $this->fields = 'distinct(cm.series_id), cm.series_name, cm.brand_id, count(*) as count_mid';
                $this->where = "cm.model_id = cp.model_id AND cm.model_id in ($idList) AND cm.state in (3, 8)  AND cp.price_type = 0";
                $this->group = 'cm.model_id';
                $result = $this->joinTable(2);
                $newResult = array();
                foreach ($result as $k => $v) {
                    if ($v['count_mid'] >= $this->limit_price) {
                        $newResult[$v['series_id']] = $v;
                    }
                }
                $result = array_slice($newResult, 0, 3);
                return $result;
            } else
                return false;
        } else
            return false;
    }

    function getSeriesParam($sid, $st) {
        $bsx = array(
            '\'手动变速箱(MT)\'',
            '\'自动变速箱(AT)\'',
            '\'无级变速箱(CVT)\'',
            '\'双离合变速箱(DCT)\'',
            '\'序列变速箱(AMT)\'',
            '\'机械式自动变速箱(AMT)\'',
            '\'固定齿比变速箱\'',
            '\'ISR变速箱\''
        );
        $jqxs = array(
            '\'自然吸气\'',
            '\'涡轮增压\'',
            '\'机械增压\'',
            '\'双涡轮增压\'',
            '\'机械+涡轮增压\''
        );
        $this->reset();
        $lastTimestamp = $this->last_timestamp;
        $this->tables = array(
            'cardb_model' => 'cm',
            'cardb_pricelog' => 'cp'
        );
        $this->fields = 'cm.model_id, count(*) as count_mid';
        $this->where = "cm.model_id = cp.model_id  AND cp.price > 0 AND cm.state in (3, 8)  AND cp.price_type = 0 AND cm.series_id = $sid";
        $this->group = 'cm.model_id';
        $modelIds = $this->joinTable(2);
        if (!empty($modelIds)) {
            $idList = '';
            foreach ($modelIds as $k => $v) {
                if ($v['count_mid'] >= $this->limit_price)
                    $idList .= ',' . $v['model_id'];
            }
            $idList = ltrim($idList, ',');
            $this->fields = "$st";
            $this->where = "series_id = $sid AND model_id in ($idList)";
            $this->order = array("$st" => 'ASC');
            $this->group = "$st";
            switch ($st) {
                case 'date_id':
                    $this->order = array("$st" => 'DESC');
                    break;
                case 'st50':
                    $bsxStr = implode(',', $bsx);
                    $this->order = array("field(st50, $bsxStr)" => 'ASC');
                    break;
                case 'st28':
                    $jqxsStr = implode(',', $jqxs);
                    $this->order = array("field(st28, $jqxsStr)" => 'ASC');
                    break;
            }
            $result = $this->getResult(2);
            return $result;
        } else
            return false;
    }

    function getBingopriceModel($param, $sid) {
        $this->reset();
        $lastTimestamp = $this->last_timestamp;
        $this->tables = array(
            'cardb_model' => 'cm',
            'cardb_pricelog' => 'cp'
        );
        $this->fields = 'cm.model_id, cm.model_name, count(*) as count_mid, cm.st27, cm.st28, cm.st50, cm.date_id';
        $this->where = "cm.model_id = cp.model_id AND cm.series_id = $sid AND cm.state in (3, 8)  AND cp.price_type = 0";
        $this->order = array('cm.model_price' => 'ASC');
        $this->group = 'cm.model_id';
        foreach ($param as $k => $v) {
            if ($v)
                $this->where .= " AND cm.$k = '$v'";
        }
        $result = $this->joinTable(2);
        foreach ($result as $k => &$v) {
            if ($v['count_mid'] < $this->limit_price)
                unset($result[$k]);
            else {
                $keyword = preg_replace('/\d+款 /sim', '', $v['model_name']);
                $keyword = str_replace(array('CVT', 'AMT', '手动', '自动'), array('', '', '', ''), $keyword);
                $v['keyword'] = string::get_str($keyword, 22);
            }
        }
        return $result;
    }

    //获取车款竞争对手的信息，根据车系分组
    function getCompeteInfo($mid, $fields, $flag = 4) {
        $this->fields = 'series_id, compete_id, st4, type_id, dealer_price_low, model_price';
        $this->where = "model_id=$mid and state in (3,8)";
        $this->group = '';
        $res = $this->getResult();
        $result['st'] = $res;
        if ($res && $res['compete_id']) {
            $this->fields = $fields;
            $this->tables = array(
                'cardb_model' => 'cm',
                'cardb_series' => 'cs',
                'cardb_factory' => 'cf'
            );
            $this->where = "cm.series_id=cs.series_id and cm.factory_id=cf.factory_id and cm.model_id in ({$res['compete_id']}) and cm.state in (3,8)";
            $this->group = 'cm.series_id';
            $result['res'] = $this->joinTable($flag);
        }
        return $result;
    }

    function getJoinTable($fields, $where) {
        $this->fields = $fields;
        $this->tables = array(
            'cardb_model' => 'cm',
            'cardb_series' => 'cs',
            'cardb_factory' => 'cf'
        );
        //$this->join_condition = array('cm.series_id=cs.series_id', 'cm.factory_id=cf.factory_id');
        $this->where = 'cm.series_id=cs.series_id and cm.factory_id=cf.factory_id' . $where . ' and cs.state=3 and cm.state in (3,8)';
        $this->group = 'cm.series_id';
        $res = $this->joinTable(2);
        return $res;
    }

    function getGoodslPrice($modelId) {
        $this->reset();
        $this->table_name = 'ibuycar.cardb_model_goods';
        $this->fields = 'goods_price';
        $this->where = "model_id = $modelId";
        $result = $this->getResult(3);
        return $result;
    }

}

?>