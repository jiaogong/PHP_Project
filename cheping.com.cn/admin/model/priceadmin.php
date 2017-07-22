<?php
class priceAdmin extends model {

    function __construct() {
        parent::__construct();
        $this->table_name = "cardb_price_administration";
    }

	/**
	 * 查询表中记录，有统计总条数和偏移量
	 */
	function getPriceAdminList($fields,$where,$order,$offset,$limit){
		$this->fields = 'count(*)';
		$this->where = $where;
		$this->total = $this->getResult();
		$this->fields = $fields;
		if($order)
			$this->order = $order;
		if($offset)
			$this->offset = $offset;
		if($limit)
			$this->limit = $limit;
		return $this->getResult(2);
	}

	//计算数据 传车系id有返回值
	//传车系id相关功能没有
	function doCoreFun($array){
		$cardbmodel = new cardbModel();
		$pricelog = new cardbPriceLog();
		$websaleinfo = new websaleinfo();
		$series = new series();
		if($array['condition']=='all'){
			$joinSql = '';
		}elseif(is_int($array['condition'])){
			$joinSql = " and series_id={$array['condition']}";
		}else{
			echo '参数无效';
			return false;
		}
		//$cardbmodel->limit = 100;
		$cardbmodelRes = $cardbmodel->getSimp('brand_id,factory_id,series_id,model_id,model_price,brand_name,factory_name,series_name,model_name,brand_import', 'state in 
		(3,8)'.$joinSql, 2);
		$seriesRes = $series->getSeriesdata('series_id,type_name','state=3',4);
		if(!$cardbmodelRes){
			echo '没有查到数据';
			exit;
		}
		$nowY = date('Y');
		$nowM = date('m');
		$nowD = date('d');

		//$timeEnd = mktime(0,0,0,$nowM,$nowD,$nowY);
		//$timeStart = $timeStart-60*24*60*60;

		foreach($cardbmodelRes as $val){
			//找出最早的报价时间
			$pricelog1Res = $pricelog->getPriceByModelid('get_time,id',"model_id={$val['model_id']} and price_type in (0,5)",array('get_time'=>'asc'),1);
			$websaleinfo1Res = $websaleinfo->getWebsaleAndOrder('get_time',"model_id={$val['model_id']}",array('get_time'=>'asc'),1);
			if(!$pricelog1Res && !$websaleinfo1Res)
				continue;
			$addSQL1 = $this->addSQL($nowY,$nowM,$nowD,$pricelog1Res['get_time']);
			$addSQL2 = $this->addSQL($nowY,$nowM,$nowD,$websaleinfo1Res['get_time']);
			$addSQL = array_merge($addSQL1,$addSQL2);
				/*//这两个是60天报价
				$pricelogRes = $pricelog->getPrices('id,price,rate,price_type,from_type,from_channel,activity_property,get_time',"model_id={$val['model_id']} and price_type in (0,5)$addSQL1",2);
				$websaleinfoRes = $websaleinfo->getWebsale('id,buy_discount_price,get_time,from_type,from_channel,activity_property', "model_id={$val['model_id']}$addSQL2", 2);
				//这两个是全部报价*/
			$pricelogRes = $pricelog->getPrices('id,price,rate,price_type,from_type,from_channel,activity_property,get_time',"model_id={$val['model_id']} and price_type in (0,5)",2);
			$websaleinfoRes = $websaleinfo->getWebsale('id,buy_discount_price,get_time,from_type,from_channel,activity_property', "model_id={$val['model_id']}", 2);

			if(!is_array($pricelogRes)){
				$pricelogRes = array();
			}
			if(is_array($websaleinfoRes)){
				foreach($websaleinfoRes as $wkey=>$wval){
					$websaleinfoRes[$wkey]['price'] = $wval['buy_discount_price'];
					$websaleinfoRes[$wkey]['price_type'] = 6;
					$websaleinfoRes[$wkey]['rate'] = '不详';
					unset($websaleinfoRes[$wkey]['buy_discount_price']);
				}
			}else{
				$websaleinfoRes = array();
			}
			if(!is_array($pricelogRes) && !is_array($websaleinfoRes))
				continue;
			//次数
			$i = 0;
			$allData = array_merge($pricelogRes,$websaleinfoRes);
			if(!is_array($allData) or empty($allData))
				continue;
			//var_dump($allData);
			//var_dump($val);exit;
			$avgDiscountArr = $avgPriceArr = $temp = $share= array();
			foreach($allData as $skey=>$sval){
				if($sval['price']<1 or $val['model_price']<1){
					continue;
				}
				//次数
				$i++;
				if($this->checkGettime($sval['get_time'],$addSQL)){
					//折扣
					$temp[$skey]['discount'] = $avgDiscountArr[$skey] = number_format($sval['price']/$val['model_price'],2,'.','')*100;
					#$avgDiscountArr['avg_discount'];
					//echo "{$skey}-{$temp[$skey]['discount']}-{$avgDiscountArr[$skey]}-{$sval['price']}-{$val['model_price']}\n";
					//裸车价（万）
					$temp[$skey]['nude_car_price'] = $avgPriceArr[$skey] = $sval['price'];
				}else{
					//折扣
					$temp[$skey]['discount'] = number_format($sval['price']/$val['model_price'],2,'.','')*100;
					//裸车价（万）
					$temp[$skey]['nude_car_price'] = $sval['price'];
					$avgDiscountArr[$skey] = $avgPriceArr[$skey] = 0;
				}
				
				//现惠幅度
				$temp[$skey]['price_rate'] = $val['model_price']-$sval['price'];
				//获取时间
				$temp[$skey]['get_time'] = $sval['get_time'];
				//信息获取渠道
				$temp[$skey]['from_channel'] = $sval['from_channel'];
				//信息获取渠道分支
				$temp[$skey]['activity_property'] = $sval['activity_property'];
				//信息获取方式
				$temp[$skey]['from_type'] = $sval['from_type'];
				$temp[$skey]['price_type'] = $sval['price_type'];
				$temp[$skey]['source_id'] = $sval['id'];
				$temp_rate = trim($sval['rate']);
				if($temp_rate=='有'){
					$temp[$skey]['rate'] = $sval['rate'];
				}elseif($temp_rate=='无'){
					$temp[$skey]['rate'] = '无';
				}else{
					$temp[$skey]['rate'] = '不详';
				}
			}
			if($i<1){
				continue;
			}
		/*	if(!$i){
				var_dump($pricelogRes);
				var_dump($websaleinfoRes);
				var_dump($pricelog1Res);
				var_dump($websaleinfo1Res);
				exit;
			}*/
			//次数
			$share['model_number'] = $i;
			//国别
			$share['brand_import'] = $val['brand_import'];
			//级别
			$share['type_name'] = $seriesRes[$val['series_id']];
			//品牌
			$share['brand_name'] = $val['brand_name'];
			//厂商
			$share['factory_name'] = $val['factory_name'];
			//车系
			$share['series_name'] = $val['series_name'];
			//车款
			$share['model_name'] = $val['model_name'];
			$share['model_id'] = $val['model_id'];
			$share['series_id'] = $val['series_id'];
			$share['factory_id'] = $val['factory_id'];
			$share['brand_id'] = $val['brand_id'];
			$avgDiscountArr = array_filter($avgDiscountArr);
			$avgPriceArr = array_filter($avgPriceArr);
			if($avgDiscountArr){
				$sumDiscount = array_sum($avgDiscountArr);
				$countDiscount = count($avgDiscountArr);
				$sumPrice = array_sum($avgPriceArr);
				$countPrice = count($avgPriceArr);
				//平均折扣
				$share['avg_discount'] = number_format($sumDiscount/$countDiscount,2,'.','');
				//均价（万）
				$share['avg_price'] = number_format($sumPrice/$countPrice,2,'.','');
				//最低价（万）
				$share['price_low'] = min($avgPriceArr);
				//变化值（万）
				$share['variation_val'] = max($avgPriceArr)-min($avgPriceArr);
				$share['created'] = time();
				foreach($temp as $tkey=>$tval){
					$ratioInfo = array();
					//均比
					$ratioInfo['avg_ratio'] = number_format($tval['nude_car_price']/$share['avg_price'],2,'.','')*100;
					//最低比
					$ratioInfo['low_ratio'] = number_format($tval['nude_car_price']/$share['price_low'],2,'.','')*100;
					$this->ufields = array_merge($tval,$share,$ratioInfo);
					//var_dump($priceadmin->ufields);exit;
					//var_dump($priceadmin);exit;
					$this->insert();
					//echo $this->sql.'<br/>';exit;
					error_log(date('Y-m-d h:i:s').'='.$this->sql."\n",3,SITE_ROOT.'data/log/priceadmin.log');
				}
			}else{
				//平均折扣、最低价（万）、均价（万）、变化值（万）
				$share['avg_discount'] = $share['avg_price'] = $share['price_low'] = $share['variation_val'] = 0;
				$share['created'] = time();
				foreach($temp as $tkey=>$tval){
					$ratioInfo = array();
					//均比、最低比
					$ratioInfo['avg_ratio'] = $ratioInfo['low_ratio'] = 0;
					$this->ufields = array_merge($tval,$share,$ratioInfo);
					//var_dump($priceadmin->ufields);exit;
					//var_dump($priceadmin);exit;
					$this->insert();
					//echo $this->sql.'<br/>';exit;
					error_log(date('Y-m-d h:i:s').'='.$this->sql."\n",3,SITE_ROOT.'data/log/priceadmin.log');
				}
			}

		}
	}

	//
	function unionTab1($where,$fields,$timestamp,$flag=1){
		$this->table_name = 'cardb_model cm';
		$this->tables = array(
			'cardb_salestate' => 'cs',
			'cardb_oldcarval' => 'co'
		);
		$this->join_condition = array('cm.model_id=cs.model_id and cs.city_id=19',"cm.model_id=co.model_id and co.start_date<=$timestamp and co.end_date>=$timestamp");
		$this->where = 'cm.state in (3,8)'.$where;
		$this->fields = $fields;
		return $this->leftJoin($flag);
	}


	//计算数据取值时间用
	function addSQL($nowY,$nowM,$nowD,$time){
		$addSQL = array();
		if(!$time){
			return $addSQL;
		}
		$maxi = $nowY-date('Y',$time);
		for($i=1;$i<=$maxi+1;$i++){
			$betweenEnd = mktime(0,0,0,$nowM,$nowD+1,$nowY-$i+1);
			$betweenStart = $betweenEnd-60*24*60*60;
			//echo $pricelog1Res['get_time'].'='.$betweenStart;
			$addSQL[] = array($betweenStart,$betweenEnd);
		}
		return $addSQL;
	}

	/*
	 * 判断时间是否为有效时间
	 * @param int $time 当前时间
	 * @param array $timeArr 验证的时间范围 eg: $timeArr = array(array('开始时间1','结束时间1’),array('开始时间2','结束时间2')...);
	 * @return bool
	 */
	function checkGettime($time,$timeArr){
		if(!is_int(intval($time)) or !is_array($timeArr))
			return false;
		$arrLength = count($timeArr);
		for($i=0;$i<$arrLength;$i++){
			//echo $time.'-'.$timeArr[$i][0].'-'.$timeArr[$i][1];exit;
			if($time>=$timeArr[$i][0] && $time<$timeArr[$i][1]){
				return true;
			}
		}
		return false;
	}

}
?>