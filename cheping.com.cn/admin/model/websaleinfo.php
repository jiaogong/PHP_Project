<?php

class websaleinfo extends model {
    var $yicheLimit = array();
    var $yicheLottery = array();
    var $autohomeTabi = 0;
    
    function __construct() {
        $this->table_name = "cardb_websaleinfo";
        parent::__construct();
    }
    function getSearchWebsaleinfo($mid, $logId, $priceType) {
        $timestamp = time();
        $this->table_name = 'cardb_pricelog cp';
        $this->tables = array(
            'cardb_model' => 'cm',
            'dealer_info' => 'di'
        );        
        $this->fields = 'cp.model_id, cp.id as pricelog_id, cm.st36, cm.st27, cm.st28, cm.date_id, cm.series_id, cm.st41, cm.st48, cp.price_type, cp.id as cp_id, cp.from_type, cp.oldcar_company_prize, cp.get_time, cp.rate, cp.down_payment, cp.interest_rate_fee, cp.low_year, cp.profess_level, cp.free_promotion_gift, cp.special_event, cp.dealer_name, cp.dealer_addr as dealer_area, cp.saler, di.dealer_linkman, cp.saler_tel, cp.dealer_tel, di.dealer_pic';        
        $this->join_condition = array(
            'cm.model_id = cp.model_id',
            'cp.dealer_name = di.dealer_name'            
        );        
        $this->where = "cp.model_id = $mid AND cp.id = $logId";
        $row = $this->leftJoin();
        
        if(!empty($row)) {
            $modelId = $row['model_id'];            
            //置换补贴
            $row['car_prize'] = $this->oldcarval->getOldCarList("car_prize", "model_id='{$modelId}'  and start_date<$timestamp and end_date>$timestamp", 3);
            $row['jnbt'] = $this->realdata->getContryBt($row);
            $pics = explode('|', $row['dealer_pic']);
            $row['dealer_pic'] = $pics[0];
            if($priceType == 1) {
                $row['price_type_name'] = '冰狗暗访价';
                $row['get_type'] = '到店暗访';
                $row['dealer_tel'] = $row['saler_tel'];
                $row['dealer_linkman'] = $row['saler'];
                $row['cp_id'] = $row['pricelog_id'];
            }
            else {
                $row['price_type_name'] = '网络媒体价';
                $row['get_type'] = '汽车之家';
            }
            if($row['get_time']) $row['get_time'] = date('Y-m-d', $row['get_time']);
            if(trim($row['rate']) == '有') $row['rate'] = "享受0利率,最短{$row['low_year']},首付{$row['down_payment']}";
            else $row['rate'] = '不祥';
            if($row['car_prize'] > 0) $row['car_prize'] = $row['car_prize'] . '元';
            else $row['car_prize'] = '无';
            if(!$row['jnbt']) $row['jnbt'] = '无';
            foreach($row as $k => $v) {
                $row[$k] = iconv('gbk', 'utf-8', $v);
            }
            return $row;
        }
        else return false;        
    }
    
    #关联cardb_model

    function getInfoAndModel($fields, $where, $flag) {
        $this->tables = array(
            'cardb_model' => 'cm',
            'cardb_websaleinfo' => 'cw'
        );
        $this->fields = $fields;
        $this->where = $where;
        return $this->joinTable($flag);
    }

	#关联cardb_model，分页
	function getInfoAndModelPage($fields,$where,$limit,$offset,$flag,$order_mode='',$order=''){
		$this->tables = array(
			'cardb_model' => 'cm',
			'cardb_websaleinfo' => 'cw'
		);
		$this->fields = 'count(*)';
		$this->where = $where;
		$this->total = $this->joinTable();
		if($order_mode){
			$this->fields = $fields . ',' .$order_mode;
		}else{
			$this->fields = $fields;
		}
		if($order){
			$this->order =$order;
		}else{
			$this->order = array();
		}
		$this->limit = $limit;
		$this->offset = $offset;
		return $this->joinTable(2);
	}
    #根据id查询

    function getInfoById($id, $fields = '*', $flag = 2) {
        $this->fields = $fields;
        $this->where = "id=$id";
        return $this->getResult($flag);
    }

    #更新

    function updateInfoById($id, $ufields) {
        $this->where = "id=$id";
        $this->ufields = $ufields;
        return $this->update();
    }

    function getWebsale($fields, $where, $flag) {
        $this->fields = $fields;
        $this->where = $where;
        $result = $this->getResult($flag);
        return $result;
    }

	function getWebsaleAndOrder($fields,$where,$order,$flag=2){
		$this->fields = $fields;
        $this->where = $where;
		$this->order = $order;
        $result = $this->getResult($flag);
        return $result;
	}

    function insertWebsale($ufields) {
        $this->ufields = $ufields;
        $id = $this->insert();
        return $id;
    }

    function updateWebsale($ufields, $id) {
        $this->ufields = $ufields;
        $this->where = "id = $id";
        $result = $this->update();
        return $result;
    }
    
    /**
     * 返回易车赠品别名
     * @param type $c 赠品原内容
     * @param type $num 
     * @return string
     */
    function yicheGift($c, $num = 1){
        $_a = "首付1.4万，两年0利率,13000元大礼包,易车补贴现金：1000元,更送1吨油（价值1万元）,3000元，或青春畅享包与无忧畅行包,3，500元油卡,3500元油卡或现金,31000元大礼包,5000元礼包,购MG3送价值6180元礼包,8000元保险礼包三选一,按揭补贴3000元,按揭最高补贴6000元 ，置换3000元,老客户转介绍送500元保养代金券,购CX-5，即有机会可得500元油卡,购车最高可获1500元油卡,双人德国游旅游基金20，000元,注册可5000元购原价万元陈坤出色版套装,购MG5精英版送3158元贴膜+脚垫,购车即送950元交强险,线上注册且购车可享受车载互联免费升级,送万元四重豪礼,首付13900元起，再送13900元,购车最高返现2050元,购车最高可获1500元油卡 ,胎压检测仪或行车记录仪,4980元原厂导航，520元倒车雷达,4980元原厂导航 682元倒车CCD,送原装精品导航,限量版红线真皮运动座椅,购车即送智能技尚选包,3年0利率 三选一,8000元置换补贴三选一,购1.5L自动精英版加99换购超值包围,全系下调4000元,全系优惠12000元,万元现金优惠,现金优惠+精品,指导价直降17000元,置换补贴3000-5000元";
        $_b = "0利率,1.3万礼包,1000元,1吨燃油,3000元,3500油卡,3500油卡,3万礼包,5000礼包,6000礼包,8000元礼包,按揭补贴3000,按揭补贴6000,保养代金券,抽内容：500元油卡,抽内容：千元油卡,抽内容：双人德国游,抽内容：万元基金            限内容：1000元,价值3000贴膜,交强险,软件升级,万元礼包,限：2000元 千元油卡,限：2050元,限：500油卡,行车记录仪,原厂导航+倒车雷达,原厂导航+倒车影像,原装导航,真皮座椅,智能技尚选包,,,,,,,,,,";
        $a = explode(',', $_a);
        $b = explode(',', $_b);
        foreach ($a as $k => $v){
            if($c === trim($v)){
                if(strpos($v, "限：")){
                    $this->yicheLimit[$num] = str_replace('限：', '', $b[$k]);
                }elseif(strpos($v, "抽内容：")){
                    $this->yicheLottery[$num] = str_replace('抽内容：', '', $b[$k]);;
                }else{
                    return $b[$k];
                }
                return '';
            }
        }
        return '';
    }
    
    /**
     * 返回易车限的别名内容
     * @param type $c
     * @param type $num
     * @return string
     */
    function yicheLimit($c, $num = 1){
        if($this->yicheLimit[$num]){
            $tmp = $this->yicheLimit[$num];
            $this->yicheLimit[$num] = '';
            return $tmp;
        }else{
            $_a = ",,,,1000元加油卡（30份）,购广本车型前100名获2000元返现,,购车享1000元油卡（前50名）,,,前60名购车得1000元加油卡,,,,,,,,,,,,,,,,,报名有机会获得100元手机话费,,,,前50名获1000元现金/礼品,注册机会获得精美好礼,,,,,,,,";
            $_b = ",,,,千元油卡,2000元,,千元油卡,,,千元油卡,,,,,,,,,,,,,,,,,百元话费,,,,1000元,,,,,,,,,";
            
            $a = explode(',', $_a);
            $b = explode(',', $_b);
            $k = array_search($c, $a);
            if($k){
                return $b[$k];
            }
            /*foreach ($a as $k => $v){
                if($c === trim($v)){
                    return $b[$k];
                }
            }*/
            return '';
        }
    }
    
    /**
     * 返回易车抽奖的别名内容
     * @param type $num
     * @return string
     */
    function yicheLottery($c, $num = 1){
        if($this->yicheLottery[$num]){
            $tmp = $this->yicheLottery[$num];
            $this->yicheLottery[$num] = '';
            return $tmp;
        }else{
            $_a = ",,,,500元加油卡，万人得奖！,1000元现金、携程卡、途家卡、加油卡！,,2000元现金、携程卡、途家卡、加油卡,,,,,,,,,,,,,,,,,,,,携程旅行卡、途家网惠住卡、加油卡！,,,,易车抱枕一套,,,,,,,,,";
            $_b = ",,,,500元油卡,5000元携程卡                  2688元途家卡            千元加油卡                      1千元,,5000元携程卡                  2688元途家卡            千元加油卡                      2千元,,,,,,,,,,,,,,,,,,,,5000元携程卡                  2688元途家卡            千元加油卡,,,,,,,,,,,,,";
            
            $a = explode(',', $_a);
            $b = explode(',', $_b);
            $k = array_search($c, $a);
            if($k){
                return $b[$k];
            }
            /*foreach ($a as $k => $v){
                if($c === trim($v)){
                    return $b[$k];
                }
            }*/
            return '';
        }
    }
    
    /**
     * 根据品牌和车系，返回汽车之家翻译表的行号
     * 说明：当前记录插入完成之后，$this->autohomeTabi必须置0
     * 
     * @param type $b
     * @param type $s
     * @return type
     */
    function autohomeTabIndex($b, $s = ''){
        //品牌
        $_a = "大众,别克,本田,奥迪,奥迪,奥迪,奥迪,奥迪,奥迪,奥迪,奥迪,长安,奔腾,标致,长安,克莱斯勒,丰田,雷诺,大众,本田,斯柯达,丰田,起亚,大众,大众,别克,凯迪拉克,雷诺,大众,本田,大众,斯柯达,丰田,丰田,大众,绅宝,大众,斯柯达,本田,长安,长安,Jeep,长安,Jeep,smart,奔驰,东风风神,捷豹,铃木,,,,,";
        //车系
        $_b = "Tiguan,昂科拉ENCORE,奥德赛,奥迪A4(进口),奥迪A4L,奥迪A5,奥迪A8,奥迪Q5(进口),奥迪Q7,奥迪S8,奥迪TT,奔奔MINI,奔腾X80,标致408,长安CS35,大捷龙(进口),丰田RAV4,风朗,高尔夫(进口),歌诗图,昊锐,皇冠,佳乐,甲壳虫,捷达,君威,凯迪拉克XTS,科雷傲,朗行,凌派,迈腾,明锐,普拉多,锐志,桑塔纳,绅宝,夏朗,昕锐,雅阁,悦翔,悦翔V3,指南者,致尚XT,自由客,,,,,,,,,,";
        $_c = array();
        foreach ($_a as $k => $v) {
            if($_b[$k]){
                $_c[$k] = $v . "_" . $_b[$k];
            }elseif($v){
                $_c[$k] = $v;
            }
        }
        if($s){
            $key = $b . "_" . $s;
        }else{
            $key = $b;
        }
        $this->autohomeTabi = array_search($b, $_c);
        return $this->autohomeTabi;
    }
    
    function autohomeGift($c){
        $_a = "4S经销商礼包,4S经销商礼包,4S经销商礼包,4S经销商礼包,4S礼,4S经销商礼包,4S经销商礼包,4S经销商礼包,4S经销商礼包,4S经销商礼包,4S经销商礼包,4S经销商礼包,4S经销商礼包,4S经销商礼包,4S经销商礼包,4S经销商礼包,4S经销商礼包,4S经销商礼包,4S经销商礼包,4S经销商礼包,4S经销商礼包,4S经销商礼包,4S经销商礼包,4S经销商礼包,4S经销商礼包,4S经销商礼包,4S经销商礼包,4S经销商礼包,4S经销商礼包,4S经销商礼包,4S经销商礼包,4S经销商礼包,4S经销商礼包,4S经销商礼包,4S经销商礼包,4S经销商礼包,4S经销商礼包,4S经销商礼包,4S经销商礼包,4S经销商礼包,4S经销商礼包,4S经销商礼包,4S经销商礼包,4S经销商礼包,4S经销商礼包,4S经销商礼包,4S经销商礼包,4S经销商礼包,4S经销商礼包,补贴,购车即送500元加油卡,议价基础上再降500元,议价基础上再降1000元,";
        $_b = "3M车身膜,5000礼包,导航、贴膜、封釉,0利率,0利率,0利率,0利率,0利率,0利率,0利率,0利率,千元礼包,3000装饰、1000元工时,购置税、5000元油卡,千元礼包,1年延保,车身膜、发动机护板、5次保养,10000礼包,3M车身膜,导航、贴膜、封釉,3000礼包,车身膜、发动机护板、5次保养,加价1000,3M车身膜,原厂贴膜,5000礼包,置换获5年免保,10000礼包,1000元装饰,导航、贴膜、封釉,原厂贴膜,16寸轮毂,车身膜、发动机护板、5次保养,车身膜、发动机护板、5次保养,iPad mini,购置税、全险、8次保养、5年10万延保,3M车身膜,座椅加热、蓝牙、定速巡航,导航、贴膜、封釉,千元礼包,千元礼包,1年延保,千元礼包,1年延保,全险、千元油卡,2万售后、1万精品、1.5万净化,14000礼包,1万元售后,2次养护,1000元,500元油卡,500元,1000元,";
        
        $a = explode(',', $_a);
        $b = explode(',', $_b);
        if($this->autohomeTabi){
            if($a[$this->autohomeTabi] == $c){
                return $b[$this->autohomeTabi];
            }
        }else{
            return '';
        }
    }
    
    function autohomeLimit($c){
        $_a = "上传购车凭证抢10000元油卡,,上传购车凭证抢1000元油卡,上传购车凭证抢2000元油卡,上传购车凭证抢3000元油卡,上传购车凭证抢4000元油卡,上传购车凭证抢5000元油卡,抢千元油卡,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,";
        $_b = "万元油卡,,千元油卡,2千元油卡,3千元油卡,4千元油卡,5千元油卡,千元油卡,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,";
        $a = explode(',', $_a);
        $b = explode(',', $_b);
        if($this->autohomeTabi){
            if($a[$this->autohomeTabi] == $c){
                return $b[$this->autohomeTabi];
            }
        }else{
            return '';
        }
    }
    
    function autohomeLottery($c){
        $_a = "抽行车记录仪,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,";
        $_b = "千元行车记录仪,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,";
        $a = explode(',', $_a);
        $b = explode(',', $_b);
        if($this->autohomeTabi){
            if($a[$this->autohomeTabi] == $c){
                return $b[$this->autohomeTabi];
            }
        }else{
            return '';
        }
    }

}

?>