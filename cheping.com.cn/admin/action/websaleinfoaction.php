<?php

class websaleinfoaction extends action
{
	#双11活动字段，忽略后边<!--修改这个数组后还需要修改/admin/action/cardbpricelog.php中的这个数组，复制过去即可-->
	#修改英文名字不要带有date，因为下边遇到strpos(string,'date')会strtotime()
	public $nov11 = array(
		'creator' => '责任人',
		'brand_name' => '品牌',
		'factory_name' => '厂商',
		'series_name' => '车系',
		'model_name' => '车款',
		'model_price' => '指导价（万）',
		'buy_discount_rate' => '新购综合优惠幅度（万）',
		'nude_car_rate' => '新购裸车优惠幅度（万）',
		'buy_discount_price' => '新购综合优惠价（万）',
		'nude_car_price' => '新购裸车优惠价（万）',
		'discount' => '折扣',
		'source_url' => '来源网站链接',
		'price_description' => '价格说明',
		'deposit' => '定金金额',
		'gift_title1' => '赠品标题1',
		'gift_content1' => '赠品内容1',
		'gift1_alias' => '赠品简称1',
		'gift_title2' => '赠品标题2',
		'gift_content2' => '赠品内容2',
		'gift2_alias' => '赠品简称2',
		'gift_title3' => '赠品标题3',
		'gift_content3' => '赠品内容3',
		'gift3_alias' => '赠品简称3',
		'gift_title4' => '赠品标题4',
		'gift_content4' => '赠品内容4',
		'gift4_alias' => '赠品简称4',
		'gift_title5' => '赠品标题5',
		'gift_content5' => '赠品内容5',
		'gift5_alias' => '赠品简称5',
		'limit_title1' => '限量标题1',
		'limit_content1' => '限量内容1',
		'limit1_alias' => '限量简称1',
		'limit_title2' => '限量标题2',
		'limit_content2' => '限量内容2',
		'limit2_alias' => '限量简称2',
		'limit_title3' => '限量标题3',
		'limit_content3' => '限量内容3',
		'limit3_alias' => '限量简称3',
		'limit_title4' => '限量标题4',
		'limit_content4' => '限量内容4',
		'limit4_alias' => '限量简称4',
		'limit_title5' => '限量标题5',
		'limit_content5' => '限量内容5',
		'limit5_alias' => '限量简称5',
		'limit_title6' => '限量标题6',
		'limit_content6' => '限量内容6',
		'limit6_alias' => '限量简称6',
		'limit_title7' => '限量标题7',
		'limit_content7' => '限量内容7',
		'limit7_alias' => '限量简称7',
		'limit_title8' => '限量标题8',
		'limit_content8' => '限量内容8',
		'limit8_alias' => '限量简称8',
		'lottery_title1' => '抽奖标题1',
		'lottery_content1' => '抽奖内容1',
		'lottery1_alias' => '抽奖简称1',
		'lottery_title2' => '抽奖标题2',
		'lottery_content2' => '抽奖内容2',
		'lottery2_alias' => '抽奖简称2',
		'lottery_title3' => '抽奖标题3',
		'lottery_content3' => '抽奖内容3',
		'lottery3_alias' => '抽奖简称3',
		'lottery_title4' => '抽奖标题4',
		'lottery_content4' => '抽奖内容4',
		'lottery4_alias' => '抽奖简称4',
		'lottery_title5' => '抽奖标题5',
		'lottery_content5' => '抽奖内容5',
		'lottery5_alias' => '抽奖简称5',
		'lottery_title6' => '抽奖标题6',
		'lottery_content6' => '抽奖内容6',
		'lottery6_alias' => '抽奖简称6',
		'lottery_title7' => '抽奖标题7',
		'lottery_content7' => '抽奖内容7',
		'lottery7_alias' => '抽奖简称7',
		'lottery_title8' => '抽奖标题8',
		'lottery_content8' => '抽奖内容8',
		'lottery8_alias' => '抽奖简称8',
		'dealer_name' => '经销商名称',
		'dealer_area' => '经销商地址',
		'dealer_range' => '经销商范围',
		'from_type' => '信息获取方式',
		'from_channel' => '信息获取渠道',
		'activity_property' => '信息获取渠道分支',
		'online_start_date' => '选车下单开始日期',
		'online_end_date' => '选车下单结束时间',
		'offline_start_date' => '线下提车开始时间',
		'offline_end_date' => '线下提车结束时间',
		'discount_end_date' => '付订金截止时间',
		'get_time' => '获取时间',
		'memo' => '备注'
		//'modify_info_id' => '修改报价ID'
	);
	#双11活动不保存并不显示字段，忽略后边<!--修改这个数组后还需要修改/admin/action/bingopriceaction.php中的这个数组，复制过去即可-->
	public $notSaveNov11 = array('brand_name','factory_name','series_name','model_name','model_price','discount');
	function __construct()
	{
		parent::__construct();
		$this->factory = new factory();
		$this->brand = new brand();
		$this->series = new series();
		$this->model = new cardbModel();
		$this->websaleinfo = new websaleinfo();
		//$this->checkAuth();
		@file::forcemkdir(SITE_ROOT . 'data/log');
	}

	function doDefault(){
		$this->doNov11();
	}

	function doNov11(){
		$curpage = max(1,($_GET['page'] ? $_GET['page'] : $_POST['page']));
		$receiverArr = array('brand_id','factory_id','series_id','model_id','from_channel','order_mode','offline_end_date','export','alias');
		$receiver = receiveArray($receiverArr);
		$where = "";
		if($receiver['brand_id']){
			$where .=  'cm.brand_id=' . $receiver['brand_id'] . ' and ';
			$factory = $this->factory->getFactorylist('factory_name,factory_id',"brand_id={$receiver['brand_id']} and state=3",2);
			$this->tpl->assign('factory', $factory);
			$this->tpl->assign('brand_id', $receiver['brand_id']);
			if($receiver['factory_id']){
				$where .=  'cm.factory_id=' . $receiver['factory_id'] . ' and ';
				$series= $this->series->getSeriesdata('series_name,series_id', "factory_id={$receiver['factory_id']} and state=3");
				$this->tpl->assign('series', $series);
				$this->tpl->assign('factory_id', $receiver['factory_id']);
				if($receiver['series_id']){
					$where .=  'cm.series_id=' . $receiver['series_id'] . ' and ';
					$model = $this->model->getSimp('model_id,model_name', "series_id={$receiver['series_id']} and state in (3,8)");
					$this->tpl->assign('model', $model);
					$this->tpl->assign('series_id', $receiver['series_id']);
					if($receiver['model_id']){
						$where .=  'cm.model_id=' . $receiver['model_id'] . ' and ';
						$this->tpl->assign('model_id', $receiver['model_id']);
					}
				}
			}
		}
		if($receiver['from_channel']){
			$where .= "cw.from_channel='{$receiver['from_channel']}' and ";
			$this->tpl->assign('from_channel', $receiver['from_channel']);
		}
		if($receiver['order_mode']){
			if($receiver['order_mode'] == 'get_time'){
				$order = array($receiver['order_mode']=>'desc');
			}else if($receiver['order_mode'] == 'discount_val'){
				$order = array($receiver['order_mode']=>'desc');
			}else if($receiver['order_mode'] == 'discount'){
				$order = array($receiver['order_mode']=>'asc');
			}
			$this->tpl->assign('order_mode', $receiver['order_mode']);
		}
		if($receiver['offline_end_date']){
			$offline_end_date = strtotime($receiver['offline_end_date']);
			$where .= "{$offline_end_date}<cw.offline_end_date and ";
			$this->tpl->assign('offline_end_date', $receiver['offline_end_date']);
		}
		$limit = 20;
		$offset = ($curpage-1)*$limit;
		$order_mode = 'IF(cw.nude_car_rate>0,cw.nude_car_rate,IF(cw.buy_discount_rate>0,cw.buy_discount_rate,IF(cw.buy_discount_price>0,cm.model_price-cw.buy_discount_price,IF(cw.nude_car_price>0,cm.model_price-cw.nude_car_price,0)))) discount_val';
		if($receiver['export']){
			$exportInfo = $this->websaleinfo->getInfoAndModel('cm.brand_name,cm.factory_name,cm.series_name,cm.model_name,cm.model_price,cw.*', "cm.model_id=cw.model_id and " . $where . "cm.state in (3,8)", 2);
			$str = implode(',', $this->nov11);
			$str .= "\r\n";
			foreach($exportInfo as $eval){
				foreach($this->nov11 as $nov11k=>$nov11v){
					if(strpos($nov11k,'date') or $nov11k=='get_time'){
						if($eval[$nov11k]){
							$eval[$nov11k] = date('Y-m-d',$eval[$nov11k]);
						}else{
							$eval[$nov11k] = '';
						}
					}
					$str .= str_replace(',','，',$eval[$nov11k]).',';
				}
				$str .= "\r\n";
			}
			$filePath = SITE_ROOT . 'data/exportnovl1.csv';
			file_put_contents($filePath, $str);
			$file = fopen($filePath, "r");
			Header("Content-type: application/octet-stream");
			Header("Accept-Ranges: bytes");
			Header("Accept-Length: " . filesize($filePath));
			Header("Content-Disposition: attachment; filename=网络媒体活动专用数据表格.csv");
			echo fread($file, filesize($filePath));
			fclose($file);
			exit;
		}
		/*if($receiver['alias']){
			$where = "cw.model_id=cm.model_id and ".$where;
			$aliasInfo = $this->websaleinfo->getInfoAndModel('cw.id,cw.gift_title1,cw.gift_title2,cw.gift_title3,cw.gift_title4,cw.gift_title5,cw.gift_content1,cw.gift_content2,cw.gift_content3,cw.gift_content4,cw.gift_content5,cw.gift1_alias,cw.gift2_alias,cw.gift3_alias,cw.gift4_alias,cw.gift5_alias,cw.limit_title1,cw.limit_title2,cw.limit_title3,cw.limit_title4,cw.limit_title5,cw.limit_title6,cw.limit_title7,cw.limit_title8,cw.limit_content1,cw.limit_content2,cw.limit_content3,cw.limit_content4,cw.limit_content5,cw.limit_content6,cw.limit_content7,cw.limit_content8,cw.limit1_alias,cw.limit2_alias,cw.limit3_alias,cw.limit4_alias,cw.limit5_alias,limit6_alias,limit7_alias,limit8_alias,cw.lottery_content3,cw.lottery_content4,cw.lottery_content5,cw.lottery_content6,cw.lottery_content7,cw.lottery_content8,cw.lottery1_alias,cw.lottery2_alias,cw.lottery3_alias,cw.lottery4_alias,cw.lottery5_alias,lottery6_alias,lottery7_alias,lottery8_alias,cw.from_channel', $where . '1', 2);
			if($aliasInfo){
				foreach($aliasInfo as $aval){
					if($aval['from_channel'] == '易车网'){
						//$this->makeBitautoAlias($aval['']);
						exit;
					}elseif($aval['from_channel'] == '汽车之家'){
						//$this->makeAutohomeAlias($aval['id']);
						exit;
					}
				}
			}
		}*/
		$websaleinfo = $this->websaleinfo->getInfoAndModelPage('cw.id,cw.get_time,cw.from_channel,cw.discount,cm.brand_name,cm.factory_name,cm.series_name,cm.model_name,cm.model_price',"cm.model_id=cw.model_id and " . $where . "cm.state in (3,8)",$limit,$offset,2,$order_mode,$order);
		/*foreach($websaleinfo as $infok=>$infov){
			//echo number_format($infov['buy_discount_price']/$infov['model_price'],2,'.','')*10;
			//var_dump($infov['model_price']);exit;
			//$websaleinfo[$infok]['discount_rate'] = $this->discountRate($infov['model_price'],$infov['nude_car_price'],$infov['buy_discount_price'],$infov['nude_car_rate'],$infov['buy_discount_rate']);
			//exit;
		}*/
		//var_dump($websaleinfo);exit;
		//echo $this->websaleinfo->sql;
		$page_bar = $this->multi($this->websaleinfo->total['count(*)'], $limit, $curpage, "index.php?action=websaleinfo-nov11&brand_id={$receiver['brand_id']}&factory_id={$receiver['factory_id']}&series_id={$receiver['series_id']}&model_id={$receiver['model_id']}&from_channel={$receiver['from_channel']}&order_mode={$receiver['order_mode']}");
		$brand = $this->brand->getAllBrand('state=3', array('letter' => 'asc'), 200);
		$this->websaleinfo->group = 'cw.from_channel';
		$this->websaleinfo->limit = 1;
		$this->websaleinfo->order = array();
		$from_channel = $this->websaleinfo->getInfoAndModel('cw.from_channel',"cw.model_id=cm.model_id and cm.state in (3,8)",2);
		//echo $this->websaleinfo->sql;
		$this->tpl->assign('from_arr', $from_channel);
		$this->tpl->assign('brand', $brand);
		$this->tpl->assign('page', $curpage);
		$this->tpl->assign('page_bar', $page_bar);
		$this->tpl->assign('websaleinfo', $websaleinfo);
		$this->template('nov11_list');
	}

	function doNov11EditList(){
		$id = intval($_GET['id']);
		$receiverArr = array('brand_id','factory_id','series_id','model_id','from_channel','order_mode','offline_end_date','page');
		$receiver = receiveArray($receiverArr);
		if($_GET['price_admin']){
			$this->vars('price_admin', $_GET['price_admin']);
		}
		$this->tpl->assign('receiver', $receiver);
		$websaleinfo = $this->websaleinfo->getInfoAndModel('cw.*,cm.model_price,cm.brand_name,cm.factory_name,cm.series_name,cm.model_name', "cm.model_id=cw.model_id and cm.state in (3,8) and cw.id=$id", 1);
		$this->tpl->assign('websaleinfo', $websaleinfo);
		foreach($this->nov11 as $nok=>$nov){
			if(in_array($nok, $this->notSaveNov11)){
				unset($this->nov11[$nok]);
				continue;
			}
			$this->nov11[$nok] = $nov;
		}
		$this->tpl->assign('nov11', $this->nov11);
		$this->tpl->assign('id', $id);
		$this->template('nov11_edit');
	}

	function doNov11Save(){
		$id = intval($_POST['id']);
		foreach($this->nov11 as $nok=>$nov){
			if(in_array($nok, $this->notSaveNov11)){
				continue;
			}
			$receiverArr[] = $nok;
		}
		$receiverArr[] = 'model_price';
		$receiver = receiveArray($receiverArr);
		foreach($receiver as $rek=>$rev){
			if(strpos($rek, 'date') or $rek=='get_time'){
				$receiver[$rek] = strtotime(trim($rev));
			}else{
				$receiver[$rek] = trim($rev);
			}
			//$ufields = 
		}
		$receiver['discount'] = $this->discountRate($receiver['model_price'],$receiver['nude_car_price'],$receiver['buy_discount_price'],$receiver['nude_car_rate'],$receiver['buy_discount_rate']);
		unset($receiver['model_price']);
		$flag = $this->websaleinfo->updateInfoById($id, $receiver);
		$receiverArr = array('brand_id','factory_id','series_id','model_id','page','offline_end_date2','order_mode','from_channel2','m_id');
		$receiver = receiveArray($receiverArr);
		$this->model->updatePrice2($receiver['m_id']);
		if($flag){
			$this->alert('成功！', 'js', 3, $_ENV['PHP_SELF'] . "nov11&brand_id={$receiver['brand_id']}&factory_id={$receiver['factory_id']}&series_id={$receiver['series_id']}&model_id={$receiver['model_id']}&offline_end_date={$receiver['offline_end_date2']}&order_mode={$receiver['order_mode']}&from_channel={$receiver['from_channel2']}&page={$receiver['page']}");
		}else{
			$this->alert('失败', 'js', 3, $_ENV['PHP_SELF'] . "nov11&brand_id={$receiver['brand_id']}&factory_id={$receiver['factory_id']}&series_id={$receiver['series_id']}&model_id={$receiver['model_id']}&offline_end_date={$receiver['offline_end_date2']}&order_mode={$receiver['order_mode']}&from_channel={$receiver['from_channel2']}&page={$receiver['page']}");
		}
	}

	#排序用到的方法
	/*function quickSort($websaleinfo){
		if(count($websaleinfo) <=1 ){
			return $websaleinfo;
		}
		$basekey = $this->discountRate($websaleinfo[0]['model_price'],$websaleinfo[0]['nude_car_price'],$websaleinfo[0]['buy_discount_price'],$websaleinfo[0]['nude_car_rate'],$websaleinfo[0]['buy_discount_rate']);
		$websaleinfo[0]['discount_rate'] = $basekey;
		$baseval = $websaleinfo[0];
		$left = array();
		$right = array();
		$len = count($websaleinfo);
		for($i=1;$i<$len;$i++){
			$xx = $this->discountRate($websaleinfo[$i]['model_price'],$websaleinfo[$i]['nude_car_price'],$websaleinfo[$i]['buy_discount_price'],$websaleinfo[$i]['nude_car_rate'],$websaleinfo[$i]['buy_discount_rate']);
			$xx==0 && $xx=10;
			$websaleinfo[$i]['discount_rate'] = $xx;
			if($xx>$basekey){
				$right[] = $websaleinfo[$i];
			}else{
				$left[] = $websaleinfo[$i];
			}
		}
		$left = $this->quickSort($left);
		$right = $this->quickSort($right);
		return array_merge($left,array($baseval),$right);
	}*/

	#计算折扣
	function discountRate($model_price,$nude_car_price,$buy_discount_price,$nude_car_rate,$buy_discount_rate){
		return $nude_car_price>0 ? number_format($nude_car_price/$model_price,3,'.','')*10 : ($buy_discount_price>0 ? number_format($buy_discount_price/$model_price,3,'.','')*10 : ($nude_car_rate>0 ? number_format(($model_price-$nude_car_rate)/$model_price,3,'.','')*10 : ($buy_discount_rate>0 ? number_format(($model_price-$buy_discount_rate)/$model_price,3,'.','')*10 : 10)));
	}
}
?>