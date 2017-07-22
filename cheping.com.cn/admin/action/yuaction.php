<?php

class yuAction extends action {

	public $cmWhereArr = array('brand_id','factory_id','series_id','from_type','brand_import','type_name');

	//缓存保存时间
	public $catchTime = 3000;
	public $cache_key1 = 'yu_cache1';
	public $cache_key2 = 'yu_cache2';

    function __construct() {
        global $_cache;
        parent::__construct();
        $this->cache = $_cache;
		$this->priceadmin = new priceAdmin();
		$this->brand = new brand();
		$this->factory = new factory();
		$this->series = new series();
		$this->cardbmodel = new cardbModel();
		$this->pricelog = new cardbPriceLog();
		$this->websaleinfo = new websaleinfo();
		$this->pricemodeladmin = new priceModelAdmin();
    }

	//全库价格管理
	function doDefault(){
		$page = max($_GET['page'],1);
		$receiverArr = array('date_start', 'date_end', 'from_type', 'from_channel', 'activity_property', 'brand_id', 'factory_id', 'series_id', 'brand_import', 'type_name', 'order_name', 'order_mode', 'rate');
		$receiver = receiveArray($receiverArr);
		$receiver = array_filter($receiver);
		$where = 1;
		$order = '';
		$jumpUrl = 'index.php?action=yu';
		//导出表格用到的连接
		$jumpUrl1 = 'index.php?action=yu-exportSearch';
		$receiverT = $receiverT1 = $receiverT2 = array();
		
		if(!$receiver['order_name']){
			//处理需要排序的字段
			$orderField = array('discount','avg_discount','price_rate','nude_car_price','avg_price','price_low','variation_val','avg_ratio','low_ratio','get_time','model_number');
			$temp_receiver = receiveArray($orderField);
			$temp_receiver = array_filter($temp_receiver);
			$receiver['order_name'] = array_keys($temp_receiver);
			$receiver['order_mode'] = array_values($temp_receiver);
		}
		if($receiver['order_name']){
			$receiver['order_name'] = array_filter($receiver['order_name']);
			$receiver['order_mode'] = array_filter($receiver['order_mode']);
			foreach($receiver['order_name'] as $rrkey=>$rrval){
				$order[$rrval] = $receiver['order_mode'][$rrkey];
				$jumpUrl .= "&$rrval={$receiver['order_mode'][$rrkey]}";
				$jumpUrl1 .= "&$rrval={$receiver['order_mode'][$rrkey]}";
			}
			$receiverT1 = $receiver['order_name'];
			$receiverT2 = $receiver['order_mode'];
		}
		unset($receiver['order_name']);
		unset($receiver['order_mode']);
		if($receiver){
			foreach($receiver as $rkey=>$rval){
				if($rkey=='brand_id'){
					$factoryData = $this->factory->getFactoryByBrand($rval);
					$this->vars('factory', $factoryData);
				}
				if($rkey=='factory_id'){
					$seriesData = $this->series->getSeriesdata('series_id,series_name', "factory_id={$rval} and state=3");
					$this->vars('series', $seriesData);
				}
				if($rkey=='date_start' or $rkey=='date_end'){
					if($receiver['date_start'] && $receiver['date_end']){
						$jumpUrl .= "&date_start={$receiver['date_start']}&date_end={$receiver['date_end']}";
						$jumpUrl1 .= "&date_start={$receiver['date_start']}&date_end={$receiver['date_end']}";
						$where .= " and get_time between ".strtotime($receiver['date_start'])." and ".strtotime($receiver['date_end']);	
						unset($receiver['date_end']);
					}
				}else{
					$where .= " and $rkey='$rval'";
					$jumpUrl .= "&$rkey=$rval";
					$jumpUrl1 .= "&$rkey=$rval";
				}
//				$receiverT[$rkey] = iconv('gbk','utf-8',$rval);
				$receiverT[$rkey] = $rval;
			}
		}
		$where = substr($where,6);
		//var_dump($order);
		$limit = 20;
		$offset = ($page-1)*$limit;
		$priceadminList = $this->priceadmin->getPriceAdminList('*',$where,$order,$offset,$limit);
		//echo $where.'<br/>';
		//echo $this->priceadmin->sql;
		if($priceadminList){
			if(!$this->priceadmin->total){
				$this->priceadmin->total['count(*)'] = '';
			}
			$page_bar = $this->multi($this->priceadmin->total['count(*)'], $limit, $page, $jumpUrl);
			$this->vars('page_bar', $page_bar);
			$this->vars('priceadmin_list', $priceadminList);
		}
		$brand = $this->brand->getAllBrand('state=3', array('letter' => 'asc'), 200);
		$temp_order_arr = array('discount'=>'折扣','avg_discount'=>'平均折扣','price_rate'=>'现惠幅度','nude_car_price'=>'裸车价（万）','avg_price'=>'均价（万）',
			'price_low'=>'最低价（万）','variation_val'=>'变化值（万）','avg_ratio'=>'均比','low_ratio'=>'最低比','get_time'=>'获取时间','model_number'=>'次数'
		);
		$this->vars('temp_order_arr', $temp_order_arr);
		$this->vars('jump_url', urlencode($jumpUrl.'&page='.$page));
		$this->vars('jump_url1', $jumpUrl1);
		$this->vars('receiver', json_encode($receiverT));
		$this->vars('receiver1', json_encode($receiverT1));
		$this->vars('receiver2', json_encode($receiverT2));
		$this->vars('brand', $brand);
		$this->template('yu_search');
	}

	//全车款价格管理
	function doYu2(){
		$page = max(1,$_GET['page']);
		$limit = 20;
		$offset = ($page-1)*$limit;
		$jumpUrl = '';
		$jumpUrl1 = 'index.php?action=yu-exportSeries';
		$receiverArr = array('date_start', 'date_end', 'dstate', 'date_end1', 'from_type', 'from_type1', 'fstate', 'from_channel', 'activity_property', 'brand_id', 'factory_id', 'series_id', 'brand_import', 'type_name', 'order_name', 'order_mode');
		$receiver = receiveArray($receiverArr);
//		$receiver = array_filter($receiver);
		$receiverT = $searchSort1 = $searchSort2 = $pageSort = array();
		$cmWhere = $searchFrom = $searchWhere = '';
		$fromTemp = array(
			'到店暗访'=>array('冰狗购车网'=>array('冰狗暗访员')),
			'电话暗访'=>array('冰狗购车网'=>array('冰狗暗访员')),
			'网络双11'=>array('汽车之家'=>array('汽车之家'),'车多少'=>array('车多少'),'搜狐汽车'=>array('搜狐汽车'),'天猫'=>array('天猫'),'易车网'=>array('易车惠大团购','易车惠特卖场')),
			'网络报价'=>array('汽车之家'=>array('汽车之家'))
		);
//		var_dump($receiver);exit;
		if($receiver){
			foreach($receiver as $rkey=>$rval){

				if(in_array($rkey, $this->cmWhereArr)){
					$cmWhere["$rkey"] = $rval;
				}
				if(is_array($rval)){
					if($rval){
						$pageUrl = '';
						foreach($rval as $rvalk=>$rvalv){
							if(!$rvalv)
								continue;
//							$receiverT[$rkey][$rvalk] = iconv('gbk','utf-8',$rvalv);
							$receiverT[$rkey][$rvalk] = $rvalv;
							$pageSort[$rkey][] = $rvalv;
							$pageUrl .= $rvalv.'|';
						}
						$jumpUrl = $jumpUrl ."&$rkey=". urlencode(trim($pageUrl,'|'));
					}
				}elseif($rkey=='order_name' or $rkey=='order_mode'){
					$pageSort[$rkey] = explode('|',urldecode($rval));
					$jumpUrl = $jumpUrl ."&$rkey=". $rval;
				}else{
//					$receiverT[$rkey] = iconv('gbk','utf-8',$rval);
					$receiverT[$rkey] = $rval;
				}
			}
			if($receiver['brand_id']){
				$factoryData = $this->factory->getFactoryByBrand($receiver['brand_id']);
				$this->vars('factory', $factoryData);
			}
			if($receiver['factory']){
				$seriesData = $this->series->getSeriesdata('series_id,series_name', "factory_id={$receiver['factory']} and state=3");
//				var_dump($seriesData);exit;
				$this->vars('series', $seriesData);
			}
			if($receiver['from_type']){
				switch($receiver['from_type']){
					case '到店暗访':
						$allTotalMode = 1;
					break;
					case '电话暗访':
						$allTotalMode = 1;
					break;
					/*case '网络双11':
					break;
					case '网络报价':
					break;*/
					default;
				}
				if($receiver['fstate']=='1' && ($receiver['from_type']!=$receiver['from_type1'])){
					$this->cache->removeCache($this->cache_key1);
				}
				$jumpUrl = $jumpUrl ."&from_type=". $receiver['from_type'];
				$this->vars('from_type1', $receiver['from_type']);
				$this->vars('from_channel', $fromTemp[$receiver['from_type']]);

			}/*
			if($receiver['from_channel']){
				$searchWhere .= " and from_channel='{$receiver['from_channel']}'";
				$this->vars('activity_property', $fromTemp[$receiver['from_type']][$receiver['from_channel']]);
					
			}
			if($receiver['activity_property']){
				$searchWhere .= " and activity_property='{$receiver['activity_property']}'";
			}*/
			$startDate = strtotime($receiver['date_start']);
			$endDate = strtotime($receiver['date_end']);
			$allWhere = " and get_time between $startDate and $endDate";
			if($receiver['dstate']=='1' && $startDate!=$receiver['date_start1'] && $endDate!=$receiver['date_end1']){
				$this->cache->removeCache($this->cache_key1);
				$this->cache->removeCache($this->cache_key2);
				$page = 1;
			}
			$jumpUrl = $jumpUrl ."&date_start={$receiver['date_start']}&date_end={$receiver['date_end']}";
			$this->vars('date_start1', $startDate);
			$this->vars('date_end1', $endDate);
		}
		if($this->cache->getCache($this->cache_key1)){
			$websaleNmedia = $this->cache->getCache($this->cache_key1);
		}else{
			$websaleNmedia = $this->pricemodeladmin->doCoreFun(1,$receiver['from_type'],$allWhere);
			$this->cache->writeCache($this->cache_key1, $websaleNmedia,$this->catchTime);
		}
		if($this->cache->getCache($this->cache_key2)){
			$bingoPrice = $this->cache->getCache($this->cache_key2);
		}else{
			$bingoPrice = $this->pricemodeladmin->doCoreFun(2,$allWhere);
			$this->cache->writeCache($this->cache_key2, $bingoPrice,$this->catchTime);
		}
		$listInfo = $this->pricemodeladmin->getAllData($websaleNmedia,$bingoPrice,$allTotalMode);
		$unsetWhere = count($this->cmWhereArr);
		foreach($listInfo as $mid=>$mval){
			for($i=0; $i<6; $i++){
				//var_dump($mval[$this->cmWhereArr[0]]);exit;
				//var_dump($mval);exit;
				if($mval[$this->cmWhereArr[$i]]!=$cmWhere[$this->cmWhereArr[$i]] && $cmWhere[$this->cmWhereArr[$i]]){
					unset($listInfo[$mid]);
					continue 2;
				}
			}
		}
		$jumpUrl1 .= "&brand_id={$cmWhere['brand_id']}&factory_id={$cmWhere['factory_id']}&series_id={$cmWhere['series_id']}&from_type={$cmWhere['from_type']}&brand_import={$cmWhere['brand_import']}&type_name={$cmWhere['type_name']}&date_start={$startDate}&date_end={$endDate}";
		$jumpUrl = "index.php?action=yu-yu2&brand_id={$cmWhere['brand_id']}&factory_id={$cmWhere['factory_id']}&series_id={$cmWhere['series_id']}&brand_import={$cmWhere['brand_import']}&type_name={$cmWhere['type_name']}".$jumpUrl;
		$allWhere = str_replace(array(' ','\''),array('@','#'),$allWhere);
		//对数组进行排序
		$listInfo = $this->searchSort($listInfo,$pageSort['order_name'],$pageSort['order_mode']);
		$page_bar = $this->multi(count($listInfo), $limit, $page, $jumpUrl);
		if(count($listInfo)>$limit){
			//对数组进行拆分，按分页页数显示
			$listInfoTemp = array_chunk($listInfo, $limit);
			$listInfo = $listInfoTemp[$page-1];
		}
		$brand = $this->brand->getAllBrand('state=3', array('letter' => 'asc'), 200);
		$temp_order_arr = array('all_total'=>'入库总数','model_price'=>'指导价','avg_price'=>'均价','variation_val'=>'变化值','low_price'=>'最低价',
			'bg_avg_price'=>'暗访均价','bg_low_price'=>'暗访最低价','bg_last_price'=>'暗访最近价','bg_total'=>'暗访总数','lowprice_fromchannel'=>'最低价渠道');
		$this->vars('brand', $brand);
		$this->vars('jump_url', $jumpUrl1);
		$this->vars('page_bar', $page_bar);
		$this->vars('list', $listInfo);
		$this->vars('temp_order_arr', $temp_order_arr);
		$this->vars('receiver', json_encode($receiverT));
		$this->vars('receiver1', json_encode($pageSort['order_name']));
		$this->vars('receiver2', json_encode($pageSort['order_mode']));
		$this->template('yu2');
	}

	//导出车系
	function doExportSeries(){
		$receiver = array('brand_id','factory_id','series_id','brand_import','from_type','type_name','date_start','date_end');
		$cmWhere = receiveArray($receiver);
		$startDate = strtotime($receiver['date_start']);
		$endDate = strtotime($receiver['date_end']);
		$allWhere = " and get_time between $startDate and $endDate";
		if($cmWhere['from_type']){
			switch($cmWhere['from_type']){
				case '到店暗访':
					$allTotalMode = 1;
				break;
				case '电话暗访':
					$allTotalMode = 1;
				break;
				/*case '网络双11':
				break;
				case '网络报价':
				break;*/
				default;
			}
		}
		if($this->cache->getCache($this->cache_key1)){
			$websaleNmedia = $this->cache->getCache($this->cache_key1);
		}else{
			$websaleNmedia = $this->pricemodeladmin->doCoreFun(1,$cmWhere['from_type'],$allWhere);
			$this->cache->writeCache($this->cache_key1, $websaleNmedia,$this->catchTime);
		}
		if($this->cache->getCache($this->cache_key2)){
			$bingoPrice = $this->cache->getCache($this->cache_key2);
		}else{
			$bingoPrice = $this->pricemodeladmin->doCoreFun(2,$allWhere);
			$this->cache->writeCache($this->cache_key2, $bingoPrice,$this->catchTime);
		}
		//var_dump($websaleNmedia);exit;
		$exportList = $this->pricemodeladmin->getAllData($websaleNmedia,$bingoPrice,$allTotalMode);
		//var_dump($listInfo);
		//exit;
		$unsetWhere = count($this->cmWhereArr);
		foreach($exportList as $mid=>$mval){
			for($i=0; $i<$unsetWhere; $i++){
				if($mval[$this->cmWhereArr[$i]]!=$cmWhere[$this->cmWhereArr[$i]] && $cmWhere[$this->cmWhereArr[$i]]){
					unset($exportList[$mid]);
					continue 2;
				}
			}
		}
		if(!$exportList){
			exit('没有信息！');
		}
		$str = '品牌,厂商,车系,车款,入库总数,指导价,均价,变化值,最低价,最低价渠道,最低价时间,暗访均价,暗访最低价,获取时间,暗访最近价,获取时间,暗访总数'."\n";
		$temp = array('brand_name','factory_name','series_name','model_name','all_total','model_price','avg_price','variation_val','low_price','lowprice_fromchannel',
			 'lowprice_gettime','bg_avg_price','bg_low_price','bg_get_time','bg_last_price','bg_last_gettime','bg_total');
		foreach($exportList as $val){
			for($i=0; $i<17; $i++){
				$str .= $val[$temp[$i]].',';
			}
			$str = trim($str,',');
			$str .= "\n";
		}
		$str = trim($str,"\n");
		$str = "\xEF\xBB\xBF".$str;
		@file::forcemkdir(ATTACH_DIR . 'tmp');
		$filePath = ATTACH_DIR . 'tmp/export_yu2.csv';
		file_put_contents($filePath, $str);
		$file = fopen($filePath, "r");
		Header("Content-type: application/octet-stream");
		Header("Accept-Ranges: bytes");
		Header("Accept-Length: " . filesize($filePath));
		Header("Content-Disposition: attachment; filename=全车款价格搜索结果.csv");
		echo fread($file, filesize($filePath));
		fclose($file);
	}

	//导出搜索
	function doExportSearch(){
		set_time_limit(0);
		$receiver = array('date_start', 'date_end', 'from_type', 'from_channel', 'activity_property', 'brand_id', 'factory_id', 'series_id', 'brand_import', 'type_name', 'rate', 'discount','avg_discount','price_rate','nude_car_price','avg_price','price_low','variation_val','avg_ratio','low_ratio','get_time','model_number');
		$orderF =  array('discount','avg_discount','price_rate','nude_car_price','avg_price','price_low','variation_val','avg_ratio','low_ratio','get_time','model_number');
		$receiverArr = receiveArray($receiver);
		$receiverArr = array_filter($receiverArr);
		$where = '1';
		$order = array();
		if($receiverArr){
			foreach($receiverArr as $tempk=>$tempv){
				if(in_array($tempk,$orderF)){
					$order[$tempk] = $tempv;
				}else{
					$where .= " and $tempk='$tempv'";
				}
			}
		}
		$str = '厂商,车系,车款,指导价,折扣,平均折扣,现惠幅度,裸车价,均价,最低价,变化值,均比,最低比,获取时间,次数,价格ID,责任人,生产状态,北京在售状态,老旧车企业奖励（万）,0利率,0利率最高首付(%),0利率最高年限,0利率手续费,经销商名称,经销商地址,信息获取方式,信息获取渠道,信息获取渠道分支'."\n";
		$where = substr($where,6);
		$priceadminList = $this->priceadmin->getPriceAdminList('*',$where,$order,'','');
		if($priceadminList){
			$timestamp = time();
			foreach($priceadminList as $pricev){
				$info1 = $info2 = '';
				if($pricev['model_id'] && $pricev['source_id']){
					if($pricev['price_type']==='0' or $pricev['price_type']=='5'){
						$info2 = $this->pricelog->getPrices('dealer_name,dealer_addr,creator,down_payment,interest_rate_fee,low_year',"id={$pricev['source_id']}");
						
					}elseif($pricev['price_type']==6){
						$info2 = $this->websaleinfo->getInfoById($pricev['source_id'],'dealer_name,dealer_area,creator',1);
						$info2['dealer_addr'] = $info2['dealer_area'];
						$info2['down_payment'] = $info2['interest_rate_fee'] = $info2['low_year'] = '';
						unset($info2['dealer_area']);
					}
					$this->priceadmin->order = '';
					$info1 = $this->priceadmin->unionTab1(" and cm.model_id={$pricev['model_id']}",'cm.model_price,cm.state cmstate,cs.state csstate,co.car_prize',$timestamp);
					if($info1 && $info2){
						switch($info1['cmstate']){
							case 3:
								$info1['cmstate'] = '在产';
							break;
							case 8:
								$info1['cmstate'] = '停产';
							break;
							default:
								$info1['cmstate'] = '在产';
						}
						switch ($info1['csstate']){
							case 3:
								$info1['csstate'] = '在售';
								break;
							case 8:
								$info1['csstate'] = '停产在售';
								break;
							case 9:
								$info1['csstate'] = '停产停售';
								break;
							default:
								$info1['csstate'] = '在售';
						}
						$str .= $pricev['brand_name'].','.$pricev['series_name'].','.$pricev['model_name'].','.$info1['model_price'].','.$pricev['discount'].','
						.$pricev['avg_discount'].','.$pricev['price_rate'].','.$pricev['nude_car_price'].','.$pricev['avg_price'].','.$pricev['price_low'].','
						.$pricev['variation_val'].','.$pricev['avg_ratio'].','.$pricev['low_ratio'].','.date('Y-m-d',$pricev['get_time']).','.$pricev['model_number'].','
						.$pricev['source_id'].','.$info2['creator'].','.$info1['cmstate'].','.$info1['csstate'].','.$info1['car_prize'].','.$pricev['rate'].','.$pricev['down_payment']
						.','.$info2['low_year'].','.$info2['interest_rate_fee'].','.$info2['dealer_name'].','.$info2['dealer_addr'].','.$pricev['from_type'].','.
						$pricev['from_channel'].','.$pricev['activity_property']."\n";
					}
				}
			}
		}
		@file::forcemkdir(ATTACH_DIR . 'tmp');
		$str = "\xEF\xBB\xBF".$str;
		$filePath = ATTACH_DIR . 'tmp/export_yu.csv';
		file_put_contents($filePath, $str);
		$file = fopen($filePath, "r");
		Header("Content-type: application/octet-stream");
		Header("Accept-Ranges: bytes");
		Header("Accept-Length: " . filesize($filePath));
		Header("Content-Disposition: attachment; filename=价格搜索结果.csv");
		echo fread($file, filesize($filePath));
		fclose($file);

	}


	/**
	 * @param array $arr 排序数组
	 * @param array $sort1 排序字段
	 * @param array $sort2 排序字段模式（升序，降序）
	 * @param string $flag 是否需要对中文进行转译
	 */
	function searchSort($arr, $sort1, $sort2, $flag=''){
		if(count($sort1)!=count($sort2) or empty($sort1))
			return $arr;
		if(!is_array($arr) or empty($arr))
			return $arr;
		//$temp1 = $temp2 = $temp3 = $temp4 = $temp5 = $temp6 = $temp7 = $temp8 = $temp9 = array();
		$temp = array();

		foreach($arr as $key=>$val){
			for($i=0;$i<4;$i++){
				if($sort1[$i]){
					$key_name = $sort1[$i];
					$temp[$key_name][] = $val[$key_name];
					//var_dump($val['price0_total']);exit;
				}
			}
			if($flag){
				foreach($val as $k=>$v){
					//echo "$arr[$key][$k]";exit;
					$arr[$key][$k] = iconv('gbk','utf-8',$v);
				}
			}
		}
		$str = "";
		foreach($sort1 as $k => $keyname){
			if($keyname=='lowprice_fromchannel'){
				$str .= "\$temp['$keyname'],$sort2[$k],SORT_STRING,";
			}else{
				$str .= "\$temp['$keyname'],$sort2[$k],SORT_NUMERIC,";
			}
		}
		$str = "array_multisort(".$str."\$arr);";
		//echo $str;
//		eval($str);
		return $arr;
	}

}

?>
