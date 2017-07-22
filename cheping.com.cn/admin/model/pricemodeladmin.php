<?php
class priceModelAdmin extends model {

    function __construct() {
        parent::__construct();
        $this->table_name = "cardb_model_priceadmin";
    }

	/**
	 * 
	 * @param string $type 信息获取方式类型
	 * @param string $allWhere 搜索时间用到
	 * @param string $where 搜索信息获取方式用到
	 */
	function doCoreFun($type,$where='',$allWhere=''){
		set_time_limit(0);
		$cardbmodel = new cardbModel();
		//$cardbmodel->limit = 100;
		$cardbmodelRes = $cardbmodel->getSimp('model_id,series_id,factory_id,brand_id,model_price,brand_name,factory_name,series_name,model_name,brand_import,type_name', 'state in (3,8)', 2);
		if(!$cardbmodelRes){
			return array(array('brand_name'=>'没有数据'));
		}
		if($type==1 or $allWhere){
			$websaleNmedia = array();
			$whereDB = 3;
			switch($where){
				case '到店暗访':
					$whereDB = 1;
					$where = ' and from_type="到店暗访"';
				break;
				case '电话暗访':
					$whereDB = 1;
					$where = ' and from_type="电话暗访"';
				break;
				case '网络双11':
					$whereDB = 2;
					$where = ' and from_type="网络双11"';
				break;
				case '网络报价':
					$whereDB = 1;
					$where = ' and from_type="网络报价"';
				break;
				default;
			}
			foreach($cardbmodelRes as $val){
				$websaleNmediaRes = $this->getWNMInfo($val['model_id'],$whereDB,$where,$allWhere);
				$websaleNmedia[$val['model_id']] = $websaleNmediaRes;
			}
			return $websaleNmedia;
		}elseif($type==2 or $allWhere){
			$bingoPrice = array();
			foreach($cardbmodelRes as $val){
				$bingoPriceRes = $this->getBingoPriceInfo($val['model_id'],$where,$allWhere);
				$bingoPriceRes['series_id'] = $val['series_id'];
				$bingoPriceRes['factory_id'] = $val['factory_id'];
				$bingoPriceRes['brand_id'] = $val['brand_id'];
				$bingoPriceRes['model_name'] = $val['model_name'];
				$bingoPriceRes['series_name'] = $val['series_name'];
				$bingoPriceRes['factory_name'] = $val['factory_name'];
				$bingoPriceRes['brand_name'] = $val['brand_name'];
				$bingoPriceRes['model_price'] = $val['model_price'];
				$bingoPriceRes['brand_import'] = $val['brand_import'];
				$bingoPriceRes['type_name'] = $val['type_name'];
				$bingoPrice[$val['model_id']] = $bingoPriceRes;
			}
			return $bingoPrice;
		}		
	}

	/**
	 * 获取所有价格信息，有用到下边的获取商情价信息
	 * @param int $mid 车款数据
	 * @param string $whereDB 查询那个数据库
	 * @param string $allWhere 搜索时间用到
	 * @param string $where 搜索信息获取方式用到
	 */
	function getWNMInfo($mid, $whereDB, $where='', $allWhere=''){
		$websaleinfo = new websaleinfo();
		$pricelog = new cardbPriceLog();
		$websaleNmedia = $priceInfo = $temp = array();

		//双11入库总次数
		$i = 0;
		switch($whereDB){
			case 1:
				$mediaRes = $pricelog->getPrices('id,price,price_type,get_time,from_type,from_channel',"model_id={$mid} and price_type in (0,5){$where}".$allWhere,2);
			break;
			case 2:
				$websaleinfoRes = $websaleinfo->getWebsale('id,buy_discount_price as price,from_type,from_channel,get_time', "model_id={$mid}{$where}".$allWhere, 2);
			break;
			default:
				$mediaRes = $pricelog->getPrices('id,price,price_type,get_time,from_type,from_channel',"model_id={$mid} and price_type=5{$allWhere}",2);
				$websaleinfoRes = $websaleinfo->getWebsale('id,buy_discount_price as price,from_type,from_channel,get_time', "model_id={$mid}{$allWhere}", 2);
		}
		if(!is_array($websaleinfoRes))
			$websaleinfoRes = array();
		if(!is_array($mediaRes))
			$mediaRes = array();
		$websaleNmediaRes = array_merge($websaleinfoRes,$mediaRes);
		foreach($websaleNmediaRes as $val){
			//双11均价信息
			if($val['price']>1){
				$i++;
				$websaleNmedia[$val['id']] = $val['price'];

				$priceInfo[$val['id']] = array('price'=>$val['price'],'get_time'=>$val['get_time'],'from_type'=>$val['from_type'],'from_channel'=>$val['from_channel']);
			}
		}
		//入库总次数
		$temp['wnm_total'] = $i;
		if(empty($websaleNmedia)){
			$temp['wnm_avg_price'] = $temp['wnm_low_price'] = $temp['wnm_high_price'] = $temp['wnm_get_time'] = 0;
			$temp['wnm_from_channel'] = '';
		}else{
			$sumPrice = array_sum($websaleNmedia);
			$countPrice = count($websaleNmedia);
			$temp['wnm_avg_price'] = number_format($sumPrice/$countPrice,2,'.','');
			$temp['wnm_low_price'] = min($websaleNmedia);
			$temp['wnm_high_price'] = max($websaleNmedia);
			$xxx = array_keys($websaleNmedia,$temp['wnm_low_price']);
			$temp['wnm_from_type'] = $priceInfo[$xxx[0]]['from_type'];
			$temp['wnm_from_channel'] = $priceInfo[$xxx[0]]['from_channel'];
			$temp['wnm_get_time'] = $priceInfo[$xxx[0]]['get_time'];
		}
		return $temp;
	}

	/**
	 * 获取pricelog表信息
	 * @param int $mid 车款id
	 * @param string $allWhere 搜索时间用到
	 * @param string $where 搜索信息获取方式用到
	 */
	function getBingoPriceInfo($mid,$where,$allWhere){
		
		$pricelog = new cardbPriceLog();
		$bingoPrice = $lastBingoPrice = $temp = $priceInfo = array();

		//$i=暗访总数;
		$i = 0;
		$bingoPriceRes = $pricelog->getPrices('id,price,price_type,get_time,from_type,from_channel',"model_id={$mid} and price_type=0{$where}".$allWhere,2);

		if(!is_array($bingoPriceRes))
			$bingoPriceRes = array();
		foreach($bingoPriceRes as $val){
			//暗访价信息
			if($val['price']>1){
				$i++;
				$bingoPrice[$val['id']] = $val['price'];
				$lastBingoPrice[$val['id']] = $val['get_time'];

				$priceInfo[$val['id']] = array('price'=>$val['price'],'get_time'=>$val['get_time'],'from_type'=>$val['from_type'],'from_channel'=>$val['from_channel']);
			}
		}
		$temp['bg_total'] = $i;
		if(empty($bingoPrice)){
			$temp['bg_avg_price'] = $temp['bg_low_price'] = $temp['bg_high_price'] = $tempListinfo['bg_get_time'] = 0;
			$temp['bg_from_channel'] = '';
		}else{
			$sumPrice = array_sum($bingoPrice);
			$counPrice = count($bingoPrice);
			$temp['bg_avg_price'] = number_format($sumPrice/$counPrice,2,'.','');
			$temp['bg_low_price'] = min($bingoPrice);
			$temp['bg_high_price'] = max($bingoPrice);
			$xxx = array_keys($bingoPrice,$temp['bg_low_price']);
			$temp['bg_from_type'] = $priceInfo[$xxx[0]]['from_type'];
			$temp['bg_from_channel'] = $priceInfo[$xxx[0]]['from_channel'];
			$temp['bg_get_time'] = $priceInfo[$xxx[0]]['get_time'];
		}
		if(empty($lastBingoPrice)){
			$temp['bg_last_gettime'] = $temp['bg_last_price'] = 0;
		}else{
			$temp['bg_last_gettime'] = max($lastBingoPrice);
			$xxx = array_keys($lastBingoPrice,$temp['bg_last_gettime']);
			$temp['bg_last_price'] = $priceInfo[$xxx[0]]['price'];
		}
		return $temp;
	}

	/**
	 * 根据websaleinfo表和pricelog表计算出数据
	 */
	function getAlldata($websaleNmedia,$bingoPrice,$allTotalMode){
		/*var_dump($websaleinfoData);
		var_dump($pricelogData);exit;*/
		if(!is_array($websaleNmedia))
			$websaleNmedia = array();
		if(!is_array($bingoPrice))
			$bingoPrice = array();
		$websaleNmediaKey = array_keys($websaleNmedia);
		$bingoPriceKey = array_keys($bingoPrice);
		$allKey = $websaleNmediaKey+$bingoPriceKey;
//		var_dump($allKey);exit;
		$temp = array();
		foreach($allKey as $val){
			$tmp1 = empty($websaleNmedia[$val]) ? array() : $websaleNmedia[$val];
			$tmp2 = empty($bingoPrice[$val]) ? array() : $bingoPrice[$val];
			$allData = array_merge($tmp1,$tmp2);
//			var_dump($allData);exit;
			if(empty($allData))
				return array();
			$temp[$val]['series_id'] = $allData['series_id'];
			$temp[$val]['factory_id'] = $allData['factory_id'];
			$temp[$val]['brand_id'] = $allData['brand_id'];
			$temp[$val]['model_name'] = $allData['model_name'];
			$temp[$val]['series_name'] = $allData['series_name'];
			$temp[$val]['factory_name'] = $allData['factory_name'];
			$temp[$val]['brand_name'] = $allData['brand_name'];
			$temp[$val]['brand_import'] = $allData['brand_import'];
			$temp[$val]['type_name'] = $allData['type_name'];
			if($allTotalMode==1){
				$temp[$val]['all_total'] = $allData['wnm_total'];
			}else{
				$temp[$val]['all_total'] = $allData['wnm_total']+$allData['bg_total'];
			}
			$temp[$val]['model_price'] = $allData['model_price'];
			$avgMax = max($allData['wnm_avg_price'],$allData['bg_avg_price']);
			$avgSum = $allData['wnm_avg_price']+$allData['bg_avg_price'];
			if($avgSum>$avgMax){
				$temp[$val]['avg_price'] = number_format($avgSum/2,2,'.','');
			}else{
				$temp[$val]['avg_price'] = $avgMax;
			}
			if(($allData['wnm_low_price']>=$allData['bg_low_price'] && $allData['bg_avg_price']>0) || ($allData['bg_low_price']>0 && $allData['wnm_low_price']<=0)){
				$temp[$val]['low_price'] = $allData['bg_low_price'];
				$temp[$val]['from_type'] = $allData['bg_from_type'];
				$temp[$val]['lowprice_fromchannel'] = $allData['bg_from_channel'];
				$temp[$val]['lowprice_gettime'] = $allData['bg_get_time'];
			}else{
				$temp[$val]['low_price'] = $allData['wnm_low_price'];
				$temp[$val]['from_type'] = $allData['wnm_from_type'];
				$temp[$val]['lowprice_fromchannel'] = $allData['wnm_from_channel'];
				$temp[$val]['lowprice_gettime'] = $allData['wnm_get_time'];
			}
			$highPrice = max(array($allData['wnm_high_price'],$allData['bg_high_price']));
			$temp[$val]['variation_val'] = number_format($highPrice-$temp[$val]['low_price'],2,'.','');
			$temp[$val]['bg_avg_price'] = $allData['bg_avg_price'];
			$temp[$val]['bg_low_price'] = $allData['bg_low_price'];
			$temp[$val]['bg_get_time'] = $allData['bg_get_time'];
			$temp[$val]['bg_last_price'] = $allData['bg_last_price'];
			$temp[$val]['bg_last_gettime'] = $allData['bg_last_gettime'];
			$temp[$val]['bg_total'] = $allData['bg_total'];
		}
//		var_dump($temp);exit;
		return $temp;

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

	/**
	 * 多表查询
	 */

	function unionTable1($where,$order,$offset,$limit){
		
		$this->fields = 'count(*)';
		$this->total = $this->getResult();
		$this->table_name = 'cardb_model_priceadmin as cmp';
		$this->tables = array(
			'cardb_model' => 'cm'
		);
		$this->fields = 'cmp.*,cm.model_price,cm.brand_name,cm.factory_name,cm.series_name,cm.model_name';
		$this->join_condition = array('cmp.model_id=cm.model_id');
		$this->where = $where;
		if($order)
			$this->order = $order;
		if($offset)
			$this->offset = $offset;
		if($limit)
			$this->limit = $limit;
		$res = $this->leftJoin(2);
		return $res;
	}
}
?>