<?php

/**
 * 参数分类组
 * $Id: seriessetting.php 4810 2014-01-22 02:29:27Z yinliuhui $
 *
 */
class seriessetting extends model {

    function __construct() {
        $this->table_name = "cardb_series_settings";
        parent::__construct();
        $this->pzImg = array(
            'newssn' => array(
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
                'st98' => '泊车辅助',
                'st97' => '定速巡航',
                'st74' => '感应钥匙',
                'st86' => '天窗',
                'st100' => '行车电脑',
                'st102' => '真皮座椅',
                'st171' => '自动空调',
                'st112' => '前排座椅加热',
                'st150' => '自动头灯',
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
                "st62" => "st_62",
                "st63" => "st_63",
                'st98' => 'daoche_ld',
                'st97' => 'dingsu_xh',
                'st74' => 'yaokong_yaoshi',
                'st86' => 'tianchuang',
                'st100' => 'xingche_dn',
                'st102' => 'zhenpi_zuoyi',
                'st171' => 'zidong_kt',
                'st150' => 'zidong_daqi',
                'st80' => 'ESP',
                'st148' => 'shanqi',
                'st69' => 'taiya_jiance',
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
                'st112' => 'st_112',
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
                'st169' => 'st_169',
                'st168' => 'st_168',
                'st163' => 'st_163',
            )
        );
    }

    function getSettingList($fields, $where, $flag = 2) {
        $this->where = $where;
        $this->fields = $fields;
        $result = $this->getResult($flag);
        return $result;
    }

    /**
     * 亮点图标配置
     * @param type $seting array
     * @param type $model array
     */
    function getPic($setting, $model) {
        $this->models = new models();
        foreach ($setting as $key => $value) {
            if ($model['st' . $value[st_id]] == "标配") {
                $result[1][pic][$key] = $this->pzImg["newss"]['st' . $value[st_id]] . '.png';
                $result[1][name][$key] = $this->pzImg["newssn"]['st' . $value[st_id]];
                $result[3]['list'][$key] = 'st' . $value[st_id];
                $list['model'][] = 'st' . $value[st_id];
            } else {
                // $result[2][pic][$key] = $this->pzImg["newss"]['st'.$value[st_id]].'_hui.png';//区分颜色
                $result[2][pic][$key] = $this->pzImg["newss"]['st' . $value[st_id]] . '.png';
                $result[2][name][$key] = $this->pzImg["newssn"]['st' . $value[st_id]];
                $result[4]['list'][$key] = 'st' . $value[st_id];
                $list['n_default'][$key] = 'st' . $value[st_id];
            }
        }
        if ($result[1][pic] && $result[2][pic]) {
            $list[pic] = array_merge($result[1][pic], $result[2][pic]);
            $list[name] = array_merge($result[1][name], $result[2][name]);
            $list['list'] = array_merge($result[3]['list'], $result[4]['list']);
        } elseif ($result[1][pic] && !$result[2][pic]) {
            $list[pic] = $result[1][pic];
            $list[name] = $result[1][name];
            $list["list"] = $result[3]['list'];
        } elseif (!$result[1][pic] && $result[2][pic]) {
            $list[pic] = $result[2][pic];
            $list[name] = $result[2][name];
            $list["list"] = $result[4]['list'];
        }
        return $list;
    }

    /**
     * 亮点图标配置
     * @param type $seting array
     */
    function getSeriesPic($setting) {

        foreach ($setting as $key => $value) {

            $result[pic][$key] = $this->pzImg["newss"]['st' . $value[st_id]] . '.png';
            $result[st][$key] = 'st' . $value[st_id];
            $result[name][$key] = $this->pzImg["newssn"]['st' . $value[st_id]];
        }

        return $result;
        //var_dump($result);
    }

}

?>
