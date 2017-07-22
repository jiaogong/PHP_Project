<?php

/**
 * series action
 * $Id: bingopriceaction.php 1792 2016-03-28 01:59:03Z wangchangjiang $
 */
class bingopriceaction extends action
{
	function __construct()
	{
		parent::__construct();
		$this->factory = new factory();
		$this->brand = new brand();
		$this->series = new series();
		$this->model = new cardbModel();
		$this->dprice = new dealerprice();
		$this->dealer = new dealer();
		$this->cardbpricelog = new cardbPriceLog();
		$this->dpricehistory = new dpriceHistory();
		$this->salestate = new cardbsalestate();
		$this->county = new county();
		$this->city = new city();
		$this->province = new cp_province();
		$this->priceerrorlog = new priceerrorlog();
		$this->websaleinfo = new websaleinfo();
		$this->checkAuth();
		@file::forcemkdir(SITE_ROOT . 'data/log');
	}
	#通过该属性判断列数，所以应该和表格中的字段一样多
	#可以修改value的值，不能修改key的值
	#不保存到数据库里的字段请再写一次到$notSaveDBFields中
	public $dbfields = array(
		'nude_car_rate' => '新购裸车优惠幅度（万）',
		'nude_car_price' => '新购裸车商情价',
		'creator' => '责任人',
		'model_grade' => '优先级',
		//'model_id' => '车款ID',
		'brand_name' => '品牌',
		'factory_name' => '厂商',
		'series_name' => '车系',
		'model_name' => '车款',
		'modify_id' => '修改报价ID',
		'ismade' => '生产状态',
		'salestate' => '北京在售状态',
		'model_price' => '指导价（万）',
		//'price_target' => '行情目标价',
		'autohome_price' => '汽车之家报价（万）',
		'autohome_dealername' => '汽车之家经销商名称',
		'autohome_dealeraddr' => '汽车之家经销商地址',
		'autohome_dealertel' => '汽车之家经销商电话',
		'get_time' => '获取时间',
		'oldcar_company_prize' => '老旧车企业奖励（万）',
		'buy_discount_rate' => '新购综合优惠幅度（万）',
		//'inquire_cause' => '进店询价目标',
		//'spot_info' => '现车情况',
		//'order_period' => '预定周期',
		//'addition_exists' => '是否有附加条件',
		'addition' => '附加条件',
		'free_promotion_gift_price' => '免费礼包',
		'free_promotion_gift' => '免费礼包内容',
		'promotion_gift_price' => '捆绑礼包（加装）金额（万）',
		'promotion_gift' => '捆绑礼包（加装）内容',
		'replacement_price' => '厂商其他置换补贴（万）',
		'4s_replacement_price' => '店内其他置换补贴（万）',
		//'price_markup' => '急提车加价金额（万）',
		'loans_new_car' => '贷款新购裸车优惠差额幅度（万）',
		'rate' => '0利率',
		'down_payment' => '0利率最低首付(%)',
		'low_year' => '0利率最高年限',
		'interest_rate_fee' => '0利率手续费',
		'profess_level' => '销售专业程度(ABCD)',
		'service_level' => '销售服务态度（ABCD）',
		'lowprice_level' => '销售底价诚意(ABCD)',
		'memo' => '备注',
		'province' => '省级单位',
		'city' => '地级单位',
		'area' => '县级单位',
		'dealer_name' => '经销商名称',
		'dealer_addr' => '经销商地址',
		'saler' => '销售姓名',
		'saler_gender' => '销售性别',
		'saler_tel' => '销售电话',
		'from_type' => '信息获取方式',
		'price_memo' => '价格说明',
		'special_event' => '特别活动',
		'from_channel' => '信息获取渠道',
		'activity_property' => '信息获取渠道分支',
                'report_title1' => '报告标题1',
                'report_content11' => '报告内容1.1',
                'report_content12' => '报告内容1.2',
                'report_title2' => '报告标题2',
                'report_content21' => '报告内容2.1',
                'report_content22' => '报告内容2.2',
                'report_title3' => '报告标题3',
                'report_content31' => '报告内容3.1',
                'report_content32' => '报告内容3.2',
                
	);
	#表格中有，但不保存或者不直接保存到数据中的字段
	public $notSaveDBFields=array('model_grade','brand_name','factory_name','series_name','model_name','modify_id','model_price','autohome_price',
		'autohome_dealername','autohome_dealeraddr','autohome_dealertel','salestate','get_time','saler_gender','price_memo');
	#手动新增和修改商情价格用到
	public $notAddDBFields = array('model_grade','brand_name','factory_name','series_name','model_name','modify_id','model_price','autohome_dealername','autohome_dealeraddr',
		'autohome_price','autohome_dealertel','price_memo');

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
		'memo' => '备注',
		'modify_info_id' => '修改报价ID'
	);
	#双11活动不保存并不显示字段，忽略后边<!--修改这个数组后还需要修改/admin/action/bingopriceaction.php中的这个数组，复制过去即可-->
	public $notSaveNov11 = array('brand_name','factory_name','model_price','modify_info_id','discount');
	function doDefault()
	{
		$this->doList();
	}

	/**
	 * 导入价格表
	 */
	function doImport()
	{
		set_time_limit(0);
		$uploadName = 'dealer_price';
		$ext = end(explode('.', $_FILES[$uploadName]['name']));
		if ($ext != 'csv')
			$this->alert('文件类型不正确,请上传csv文件！', 'js', 3, $_ENV['PHP_SELF'] . 'importView');
		$groupbuy = new groupbuy();
		$dir = 'dealerprice';
		$path = $groupbuy->uploadPic($uploadName, $dir);
		$str = file_get_contents(ATTACH_DIR . 'images/' . $path);
		//var_dump($str);exit;
		$arr = explode("\r\n", $str);
		array_pop($arr);
		$errorMids = array();
		switch ($_POST['price_radio'])
		{
			case 1:
				$flag = 00;
				foreach ($arr as $row)
				{
					$dprice = explode(',', $row);
					if ($flag == 00)
					{
						if (($dprice[0] != '车款id' && $dprice[0] != '车款ID') or $dprice[1] != '价格' or $dprice[2] != '备注')
						{
							echo '成本价表格格式不对，本次操作没有新增和修改任何数据';
							exit;
						}
						$flag = 11;
						continue;
					}
					if (empty($dprice[0]))
						continue;
					if (empty($dprice[1]))
						continue;
					$mId = $dprice[0];
					$price = $dprice[1];
					$memo = $dprice[2];
					$modelInfo = $this->model->getSeriesId($mId);
					$seriesId = $modelInfo['series_id'];
					$timestamp = time();
					$ufields = array('model_id' => $mId,
						'series_id' => $seriesId, 
						// price_type = 2 是成本价
						'price_type' => 2,
						'price' => $price,
						'memo' => $memo,
						'created' => $timestamp,
						'updated' => $timestamp,
						'get_time' => $timestamp
						);
					$hid = $this->cardbpricelog->insertPricelog($ufields); 
					// start 更新cardb_modelprice中对应的价格
					$this->model->updatePrice($mId, array('cost_price' => $price)); 
					// end
					if (!$hid)
						$errorMids[] = $mId;
				}
				break;
			case 2:
				$flag = 00;
				$num = 0;
				$numi = 0;
				$numii = 0;
				$timeArray = array();
				$arr0 = '';
				$csvrows;
				foreach ($arr as $arkey => $row)
				{
					$row = rtrim($row, ',');
					$dprice = explode(',', $row);
					if ($flag === 00)
					{
						$arr0 = $dprice;
						if(!in_array($this->dbfields['creator'], $dprice) or !in_array($this->dbfields['dealer_name'], $dprice) or !in_array($this->dbfields['dealer_addr'], $dprice) or !in_array($this->dbfields['province'], $dprice))
						{
							echo '商情价表格格式不对，请检查表头是否有(责任人，经销商名称，经销商地址，省级单位)，不区分顺序，本次操作没有新增和修改任何数据';
							exit;
						}
						$csvrows = count($dprice);
						$flag = 11;
						continue;
					}
					foreach($this->dbfields as $dbkey => $dbval){
						if(empty($dbkey) or empty($dbval)){
							echo '什么情况？';
							exit;
						}
						${$dbkey.'_key'} = array_merge(array($dbkey),array_keys($arr0, $dbval));
					}
					if (count($dprice) > $csvrows && $dprice[$nude_car_rate_key[1]] !== '' && $dprice[$province_key[1]] != '' && $dprice[$city_key[1]] != '' && $dprice[$area_key[1]] != '')
					{
						$timeArray[$_FILES[$uploadName]['name']][] = array($dprice[0], $arkey + 1, '发现有英文逗号', date('Y/m/d h:i:s'));
						$numii++;
						continue;
					}else{
						if (rtrim($dprice[$nude_car_rate_key[1]]) === '' && ($dprice[$province_key[1]] == '' or $dprice[$city_key[1]] == '' or $dprice[$area_key[1]] == '')){
							continue;
						}
					}
					$validateFields = array($creator_key, $nude_car_rate_key, $province_key, $city_key, $area_key, $dealer_name_key, $dealer_addr_key, $get_time_key, $salestate_key);
					foreach($validateFields as $vdval){
						if($dprice[$vdval[1]] === "" or $dprice[$vdval[1]] == '无'){
							if($vdval[0] == 'nude_car_rate'){
								if($dprice[$buy_discount_rate_key[1]] === "" or $dprice[$buy_discount_rate_key[1]] == "空"){
									$timeArray[$_FILES[$uploadName]['name']][] = array($dprice[0], $arkey + 1, '新购综合优惠幅度或者新购裸车优惠幅度为空', date('Y/m/d h:i:s'));
									$numii++;
									continue 2;
								}
							}else{
								$timeArray[$_FILES[$uploadName]['name']][] = array($dprice[0], $arkey + 1, $this->dbfields[$vdval[0]] . '为空', date('Y/m/d h:i:s'));
								$numii++;
								continue 2;	
							}
						}
					}
					$firstTime = $this->model->chkModel("model_id,series_id,date_id,model_price", "brand_name='{$dprice[$brand_name_key[1]]}' and factory_name='{$dprice[$factory_name_key[1]]}' and series_name='{$dprice[$series_name_key[1]]}' and model_name='{$dprice[$model_name_key[1]]}' and state in (3,8)", array(), 1, 1);
					if (!$firstTime)
					{
						$timeArray[$_FILES[$uploadName]['name']][] = array($dprice[0], $arkey + 1, $dprice[$brand_name_key[1]] . '-' . $dprice[$factory_name_key[1]] . '-' . $dprice[$series_name_key[1]] . '-' . $dprice[$model_name_key[1]] . '(不对)', date('Y/m/d h:i:s'));
						$numii++;
						continue;
					}
					if ($firstTime['model_price'] == '' or $firstTime['model_price'] == '0.00')
					{
						$timeArray[$_FILES[$uploadName]['name']][] = array($dprice[0], $arkey + 1, '数据库里没有指导价', date('Y/m/d h:i:s'));
						$numii++;
						continue;						
					}//指导价
					$getTime = strtotime($dprice[$get_time_key[1]]);
					if($dprice[$nude_car_rate_key[1]]==='' or $dprice[$nude_car_rate_key[1]]==='0'){
						$tt_sql1 = 'nude_car_rate=0';
					}else{
						$tt_sql1 = "nude_car_rate={$dprice[$nude_car_rate_key[1]]}";
					}
					if($dprice[$buy_discount_rate_key[1]]==='' or $dprice[$buy_discount_rate_key[1]]==='0'){
						$tt_sql2 = 'buy_discount_rate=0';
					}else{
						$tt_sql2 = "buy_discount_rate={$dprice[$buy_discount_rate_key[1]]}";
					}
					$secondTime = $this->cardbpricelog->getPrices('id', "model_id={$firstTime['model_id']} and get_time={$getTime} and dealer_name='{$dprice[$dealer_name_key[1]]}' and dealer_addr='{$dprice[$dealer_addr_key[1]]}' and ".$tt_sql1." and ".$tt_sql2." and saler='{$dprice[$saler_key[1]]}'", $type = 1);
					if ($secondTime)
					{
						#北京在售状态
						$salestateUfields = array('province_id' => 0, 'city_id' => 0, 'county_id' => 0, 'state' => 1);
						switch ($dprice[$salestate_key[1]])
						{
							case '在售':
								$salestateUfields['state'] = 3;
								break;
							case '停产停售':
								$salestateUfields['state'] = 9;
								break;
							case '停产在售':
								$salestateUfields['state'] = 8;
								break;
							default:
								$salestateUfields['state'] = 3;
								break;
						}
						$provinceInfo = $this->province->getProvinceByName($dprice[$province_key[1]]);
						if ($provinceInfo)
						{
							$cityInfo = $this->city->getCheck($dprice[$city_key[1]], $provinceInfo['id']);
							if ($cityInfo)
							{
								$countyInfo = $this->county->getCheck($dprice[$area_key[1]], $cityInfo['id']);
								if ($countyInfo)
									$salestateUfields['county_id'] = $countyInfo['id'];
								$salestateUfields['city_id'] = $cityInfo['id'];
							}
							$salestateUfields['province_id'] = $provinceInfo['id'];
						}
						if(empty($salestateUfields['province_id']) or empty($salestateUfields['city_id']) or empty($salestateUfields['county_id'])){
							$timeArray[$_FILES[$uploadName]['name']][] = array($dprice[0], $arkey + 1, '北京在售状态地区匹配不上', date('Y/m/d h:i:s'));
							$numii++;
							continue;
						}
						$saleFlag = $this->salestate->getSaleState('id,state', "model_id={$firstTime['model_id']} and city_id={$salestateUfields['city_id']}", 1);
						if ($saleFlag)
						{
							if($saleFlag['state'] != $salestateUfields['state']){
								$this->salestate->updateState(array("state" => $salestateUfields['state']), "id={$saleFlag['id']}");
								$numii++;
								$num++;
								continue;
							}else{
								$timeArray[$_FILES[$uploadName]['name']][] = array($dprice[0], $arkey + 1, '该条为重复数据', date('Y/m/d h:i:s'));
								$numii++;
								continue;
							}
						}
						else
						{
							$this->salestate->ufields = array('province_id' => $salestateUfields['province_id'],
								'city_id' => $salestateUfields['city_id'],
								'county_id' => $salestateUfields['county_id'],
								'model_id' => $firstTime['model_id'],
								'state' => $salestateUfields['state']
								);
							$this->salestate->insert();
							continue;
						}







						
					}
					$nude_car_rate_val = ($dprice[$nude_car_rate_key[1]] < 0) ? $firstTime['model_price'] + abs($dprice[$nude_car_rate_key[1]]) : $firstTime['model_price'] - $dprice[$nude_car_rate_key[1]];
					$saler_gender_val = ($dprice[$saler_gender_key[1]] == '男') ? 1 : 0;
					$timestamp = time();
					foreach($this->dbfields as $dbfk => $dbfv){
						if(in_array($dbfk,$this->notSaveDBFields))
							continue;
						$ufields[$dbfk] = rtrim($dprice[${$dbfk.'_key'}[1]]);
					}
					$ufields['model_id'] = $firstTime['model_id'];
					$ufields['series_id'] = $firstTime['series_id'];
					$ufields['price_type'] = 0;
					$ufields['price'] = $nude_car_rate_val;
					$ufields['deliver_price'] = getDeliveryPrice($nude_car_rate_val);
					$ufields['date_id'] = $firstTime['date_id'];
					$ufields['updated'] = $timestamp;
					$ufields['get_time'] = strtotime($dprice[$get_time_key[1]]);
					$ufields['saler_gender'] = $saler_gender_val;
					$ufields['nude_car_price'] = $nude_car_rate_val;
					#北京在售状态
					$salestateUfields = array('province_id' => 0, 'city_id' => 0, 'county_id' => 0, 'state' => 1);
					switch ($dprice[$salestate_key[1]])
					{
						case '在售':
							$salestateUfields['state'] = 3;
							break;
						case '停产停售':
							$salestateUfields['state'] = 9;
							break;
						case '停产在售':
							$salestateUfields['state'] = 8;
							break;
						default:
							$salestateUfields['state'] = 3;
							break;
					}
					$provinceInfo = $this->province->getProvinceByName($dprice[$province_key[1]]);
					if ($provinceInfo)
					{
						$cityInfo = $this->city->getCheck($dprice[$city_key[1]], $provinceInfo['id']);
						if ($cityInfo)
						{
							$countyInfo = $this->county->getCheck($dprice[$area_key[1]], $cityInfo['id']);
							if ($countyInfo)
								$salestateUfields['county_id'] = $countyInfo['id'];
							$salestateUfields['city_id'] = $cityInfo['id'];
						}
						$salestateUfields['province_id'] = $provinceInfo['id'];
					}
					if(empty($salestateUfields['province_id']) or empty($salestateUfields['city_id']) or empty($salestateUfields['county_id'])){
						$timeArray[$_FILES[$uploadName]['name']][] = array($dprice[0], $arkey + 1, '北京在售状态地区匹配不上', date('Y/m/d h:i:s'));
						$numii++;
						continue;
					}
					$saleFlag = $this->salestate->getSaleState('id,state', "model_id={$firstTime['model_id']} and city_id={$salestateUfields['city_id']}", 1);
					if ($saleFlag)
					{
						if($saleFlag['state'] != $salestateUfields['state']){
							$this->salestate->updateState(array("state" => $salestateUfields['state']), "id={$saleFlag['id']}");
						}
					}
					else
					{
						$this->salestate->ufields = array('province_id' => $salestateUfields['province_id'],
							'city_id' => $salestateUfields['city_id'],
							'county_id' => $salestateUfields['county_id'],
							'model_id' => $firstTime['model_id'],
							'state' => $salestateUfields['state']
							);
						$this->salestate->insert();
					}
					$numii++;
					if (empty($dprice[$modify_id_key[1]]))
					{
						$ufields['created'] = $timestamp;
						$num++;
						$hid = $this->cardbpricelog->insertPricelog($ufields);
						error_log(date('Y-m-d h:i:s') .'--'. $this->cardbpricelog->sql . "\n", 3, SITE_ROOT . 'data/log/import_dealercsv_insert.log');
					}
					else
					{
						$num++;
						$hid = $this->cardbpricelog->updatePricelog($ufields, "id={$dprice[$modify_id_key]}");
						error_log(date('Y-m-d h:i:s') .'--'. $this->cardbpricelog->sql . "\n", 3, SITE_ROOT . 'data/log/import_dealercsv_update.log');
					}
					if (!$hid)
						$timeArray[$_FILES[$uploadName]['name']][] = array($dprice[0], $arkey + 1, $this->cardbpricelog->sql . '保存出错', date('Y/m/d h:i:s')); 
					// start 更新表中对应的价格
					$this->model->updatePrice($firstTime['model_id'], array('dealer_price' => 1)); 
					// end
				}
				break;
			case 3:
				$flag = 00;
				foreach ($arr as $row)
				{
					$dprice = explode(',', $row);
					if ($flag == 00)
					{
						if (($dprice[0] != '车款id' && $dprice[0] != '车款ID') or $dprice[1] != '价格' or !empty($dprice[2]))
						{
							echo '最多人购买价表格格式不对，本次操作没有新增和修改任何数据';
							exit;
						}
						$flag = 11;
						continue;
					}
					if (empty($dprice[0]))
						continue;
					if (empty($dprice[1]))
						continue;
					$mId = $dprice[0];
					$price = $dprice[1];
					$modelInfo = $this->model->getSeriesId($mId);
					$seriesId = $modelInfo['series_id'];
					$timestamp = time();
					$ufields = array('model_id' => $mId,
						'series_id' => $seriesId, 
						// price_type = 3 是最多人购买价
						'price_type' => 3,
						'price' => $price,
						'created' => $timestamp,
						'updated' => $timestamp,
						'get_time' => $timestamp
						);
					$hid = $this->cardbpricelog->insertPricelog($ufields); 
					// start 更新cardb_modelprice中对应的价格
					$this->model->updatePrice($mId, array('most_price' => $price)); 
					// end
					if (!$hid)
						$errorMids[] = $mId;
				}
				break;
			case 4:
				$flag = 1;
				$tempArray = array();
				foreach ($arr as $row)
				{
					$dprice = explode(',', $row);
					if ($flag == 1)
					{
						if (($dprice[0] != '车系id' && $dprice[0] != '车系ID') or $dprice[1] != '年款' or $dprice[2] != '排量' or $dprice[3] != '进气形式' or $dprice[4] != '轴距')
						{
							echo $dprice[0] . $dprice[1] . $dprice[2] . $dprice[3] . $dprice[4];
							echo '价格趋势表格格式不对，本次操作没有新增和修改任何数据';
							exit;
						}
						$flag = 2;
						for ($j = 5; $j < count($dprice); $j++)
						{
							$tempArray[$j] = $dprice[$j];
						}
						continue;
					}
					if (empty($dprice[0]))
						continue;
					if (empty($dprice[1]) or $dprice[1] == '无')
						continue;
					if (empty($dprice[2]) or $dprice[2] == '无')
						continue;
					if (empty($dprice[3]) or $dprice[3] == '无')
						continue;
					if (empty($dprice[4]) or $dprice[4] == '无')
						continue;
					$fields = 'model_id,model_price';
					$where = "series_id=$dprice[0] and date_id=$dprice[1] and st27=$dprice[2] and st28='$dprice[3]' and st15=$dprice[4] and state in (3,8)";
					$mInfo = $this->model->getSimp($fields, $where);
					foreach ($mInfo as $val)
					{
						for ($i = 5; $i < count($dprice); $i++)
						{
							$temp = (($val['model_price'] * 10000) - $dprice[$i]) / 10000;
							$isNow = $this->cardbpricelog->getPrices("id,price", "model_id='{$val['model_id']}' and created=" . strtotime($tempArray[$i]));
							$tempFields = array('model_id' => $val['model_id'], 'series_id' => $dprice[0], 'price_type' => 4, 'price' => $temp, 'deliver_price' => $dprice[$i], 'created' => strtotime($tempArray[$i]), 'updated' => strtotime($tempArray[$i]), 'get_time' => strtotime($tempArray[$i]));
							$where = "id = {$isNow['id']}";
							if ($isNow['price'] == $temp)
							{
								continue;
							}
							empty($isNow) ? $this->cardbpricelog->insertPricelog($tempFields) : $this->cardbpricelog->updatePricelog($tempFields, $where);
						}
					}
				}
				break;
			case 5:
				$flag = 1;
				foreach ($arr as $row)
				{
					$dprice = explode(',', $row);
					if ($flag == 1)
					{
						if ($dprice[0] != '编号' or $dprice[1] != '品牌' or $dprice[2] != '厂商' or $dprice[3] != '车系' or $dprice[4] != '车款' or $dprice[7] != '是否为默认车款')
						{
							echo '车系默认车款表格格式不对，本次操作没有新增和修改任何数据';
							exit;
						}
						$flag = 2;
						continue;
					}
					if (empty($dprice[0]) or $dprice[7] == '否')
					{
						continue;
					}
					$this->series->uDefaultModelId(array("default_model" => $dprice[0]), "series_name='{$dprice[3]}'");
					$mInfo = $this->model->getModel($dprice[0]);
					if (empty($mInfo))
					{
						$errorMids[] = array($dprice[0], $dprice[1], $dprice[2], $dprice[3], $dprice[4], $dprice[5], $dprice[6], $dprice[7]);
					}
				}
				break;
			case 6:
				//var_dump($this->nov11['online_start_date']);exit;
				$flag = 1;
				$timeArray = array();
				foreach($arr as $arkey=>$row){
					$this->websaleinfo->ufields = array();
					$dprice = explode(',', $row);
					if($flag == 1){
						//判断是否是双11表格
						if(!in_array($this->nov11['online_start_date'], $dprice)){
							exit('双11表格格式不对，请重新上传');
						}
						$arr0 = $dprice;
						$flag = 2;
						continue;
					}
					if($dprice[0] === ""){
						continue;
					}
					$numii ++;
					$requiredArr = array('get_time', 'offline_end_date', 'dealer_name', 'dealer_area', 'from_type', 'from_channel', 'activity_property');
					if(is_array($this->nov11)){
						$where = $modify_id = '';
						$buy_discount_rate_val = $nude_car_rate_val = $buy_discount_price_val = $nude_car_price_val = '';
						foreach($this->nov11 as $nkey=>$nval){
							$fieldkey = array_keys($arr0, $nval);
							if($nkey == 'brand_name' or $nkey == 'factory_name' or $nkey == 'series_name' or $nkey == 'model_name'){
								$where .=  "$nkey='{$dprice[$fieldkey[0]]}' and ";
							}
							if($nkey == 'modify_info_id'){
								$modify_id = $dprice[$fieldkey[0]];
							}
							if(in_array($nkey, $this->notSaveNov11)){
								continue;
							}
							if(in_array($nkey, $requiredArr)){
								if($dprice[$fieldkey[0]] == ''){
									$timeArray[$_FILES[$uploadName]['name']][] = array($dprice[0], $arkey + 1, $this->nov11[$nkey] . '为空', date('Y/m/d h:i:s'));
									continue 2;
								}
							}
							if($nkey == 'buy_discount_rate' or $nkey == 'nude_car_rate' or $nkey == 'buy_discount_price' or $nkey == 'nude_car_price'){
								${$nkey.'_val'} = $dprice[$fieldkey[0]];
							}
							if(strpos($nkey, 'date') or $nkey=='get_time'){
								if($nkey=='discount_end_date' or $nkey=='offline_end_date' or $nkey=='online_end_date'){
									$this->websaleinfo->ufields[$nkey] = trim($dprice[$fieldkey[0]]) ? strtotime(trim($dprice[$fieldkey[0]]))+24*60*60-1 : 0;
								}else{
									$this->websaleinfo->ufields[$nkey] = trim($dprice[$fieldkey[0]]) ? strtotime(trim($dprice[$fieldkey[0]])) : 0;
								}
							}else{
								$this->websaleinfo->ufields[$nkey] = trim($dprice[$fieldkey[0]]);
							}
						}
						if($buy_discount_rate_val === '' && $nude_car_rate_val === '' && $buy_discount_price_val === '' && $nude_car_price_val === ''){
							$timeArray[$_FILES[$uploadName]['name']][] = array($dprice[0], $arkey + 1, '请检查四个价格必填项', date('Y/m/d h:i:s'));
							continue;
						}
						if($where){
							$model_id = $this->model->getSimp('model_id,model_price', $where . 'state in (3,8)', 1);
							if($model_id){
								$this->websaleinfo->ufields['model_id'] = $model_id['model_id'];
								/*if($this->websaleinfo->ufields['from_channel'] == '搜狐汽车'){
									$this->websaleinfo->ufields['buy_discount_price'] = $this->websaleinfo->ufields['nude_car_rate']>0 ? $model_id['model_price']-$this->websaleinfo->ufields['nude_car_rate'] : $model_id['model_price']-$this->websaleinfo->ufields['buy_discount_rate'];
								}elseif($this->websaleinfo->ufields['from_channel'] == '天猫'){
									$this->websaleinfo->ufields['buy_discount_price'] = $this->websaleinfo->ufields['buy_discount_price']>0 ? $this->websaleinfo->ufields['buy_discount_price'] : ($this->websaleinfo->ufields['nude_car_price']>0 ? $this->websaleinfo->ufields['nude_car_price'] : $model_id['model_price']-$this->websaleinfo->ufields['buy_discount_rate']);
								}*/
								$this->websaleinfo->ufields['discount'] = number_format($this->websaleinfo->ufields['buy_discount_price']/$model_id['model_price'],3,'.','')*10;
								if($modify_id){
									$insertID = $this->websaleinfo->update();
								}else{
									$this->websaleinfo->ufields['created'] = time();
									$insertID = $this->websaleinfo->insert();
								}
								if($insertID){
									$num++;
									$this->model->updatePrice2($model_id['model_id']);
									error_log(date('Y-m-d h:i:s') . '---' . $this->websaleinfo->sql . "\n", 3, SITE_ROOT . 'data/log/nov11.txt');
								}
							}else{
								$timeArray[$_FILES[$uploadName]['name']][] = array($dprice[0], $arkey + 1, '车款名称信息对不上数据库', date('Y/m/d h:i:s'));
							}
						}else{
							$timeArray[$_FILES[$uploadName]['name']][] = array($dprice[0], $arkey + 1, '缺少品牌、厂商、车系、车款', date('Y/m/d h:i:s'));
						}
					}else{
						exit('$nov11不是数组');
					}
				}
				break;
			default:
				echo '上传失败!';
		}
		if ($num == $numii)
		{
			echo '全部上传成功，总共' . $num . '条';
		}
		else
		{
			echo max(0,$num) . '条上传成功<br/>';
			echo $numii - $num . '条上传失败，请检查必填项和是否有重复内容！';
		}
		if ($timeArray)
		{
			foreach ($timeArray[$_FILES[$uploadName]['name']] as $timeakey => $timealist)
			{
				$this->priceerrorlog->ufields = array('csv_name' => $_FILES[$uploadName]['name'],
					'creator' => $timealist[0],
					'excel_row' => $timealist[1],
					'content' => $timealist[2],
					'created' => time()
					);
				$this->priceerrorlog->insert();
			}
		}
		echo '<a href="?action=bingoprice-importView">返回</a>';
	}

	function doImportView()
	{
		$tplName = 'bingoprice_import';
		$this->template($tplName);
	}

	function doAddPricelog()
	{
		$receiverArr = array('series_id', 'model_id');
		$receiver = receiveArray($receiverArr);
		$priceType = $_POST['price_radio'];
		$time = time();
		if ($priceType == '2')
		{
			$price = $_POST['price2'];
			$memo = $_POST['memo2']; 
			$this->cardbpricelog->ufields = array('model_id' => $receiver['model_id'], 'series_id' => $receiver['series_id'], 'price' => $price, 'price_type' => $priceType, 'memo' => $memo, 'created' => $time, 'updated' => $time, 'get_time' => $time);
			// start 更新cardb_modelprice中对应的价格
			$this->model->updatePrice($receiver['model_id'], array('cost_price' => $price)); 
			// end
		}elseif ($priceType == '3')
		{
			$price = $_POST['price3']; 
			$this->cardbpricelog->ufields = array('model_id' => $receiver['model_id'], 'series_id' => $receiver['series_id'], 'price' => $price, 'price_type' => $priceType,  'created' => $time, 'updated' => $time, 'get_time' => $time);
			// start 更新cardb_modelprice中对应的价格
			$this->model->updatePrice($receiver['model_id'], array('most_price' => $price)); 
			// end
		}elseif ($priceType == '4')
		{
			$addDBFields = $this->dbfields;
			foreach($this->notAddDBFields as $notv){
				unset($addDBFields[$notv]);
			}
			if(empty($addDBFields) or !is_array($addDBFields)){
				echo '什么情况？';
				exit;
			}
			$receiverArr = '';
			foreach($addDBFields as $addVk=>$addVv){
				$receiverArr[] = $addVk;
			}
			$receiver = array_merge($receiver,receiveArray($receiverArr));
			if(!strpos($receiver['province'], '|') or !strpos($receiver['city'], '|') or !strpos($receiver['area'], '|') or empty($receiver['model_id']) or empty($receiver['creator']) or empty($receiver['get_time']) or (empty($receiver['nude_car_price']) && empty($receiver['buy_discount_rate']))){
				echo '必填项为空';
				exit;
			}
			$province = explode('|', $receiver['province']);
			$city = explode('|', $receiver['city']);
			$area = explode('|', $receiver['area']);
			$beijing = $this->salestate->getState(array($province[0], $city[0], $area[0]), $receiver['model_id']);
			if ($beijing)
			{
				if ($receiver['salestate'] != $beijing['state'])
				{
					$this->salestate->updateState(array("state" => $receiver['salestate']), "province_id={$province[0]} and city_id={$city[0]} and county_id={$city[0]} and model_id={$receiver['model_id']}");
				}
			}
			else
			{
				$this->salestate->ufields = array('province_id' => $province[0],
					'city_id' => $city[0],
					'county_id' => $area[0],
					'model_id' => $receiver['model_id'],
					'state' => $receiver['salestate']
					);
				$this->salestate->insert();
			}
			foreach($addDBFields as $addIVk=>$addIVv){
				switch($addIVk){
					case 'get_time':
						$receiver[$addIVk] = strtotime($receiver[$addIVk]);
					break;
					case 'province':
						$receiver[$addIVk] = $province[1];
					break;
					case 'city':
						$receiver[$addIVk] = $city[1];
					break;
					case 'area':
						$receiver[$addIVk] = $area[1];
					break;
					case 'nude_car_price':
						$receiver['price'] = $receiver['nude_car_price'];
						$receiver['deliver_price'] = getDeliveryPrice($receiver['nude_car_price']);
						$receiver['price_type'] = 0;
					break;
					case 'sale_gender':
						if($addIVv == '男')
							$receiver['sale_gender'] = 1;
						else
							$receiver['sale_gender'] = 0;
					break;
				}
			}
			unset($receiver['salestate']);
			$this->cardbpricelog->ufields = $receiver;
		}
		$flag = $this->cardbpricelog->insert();
		error_log(date('Y-m-d h:i:s') .'-notcsvadd-'. $this->cardbpricelog->sql . "\n", 3, SITE_ROOT . 'data/log/import_dealercsv_insert.log');
		// start 更新cardb_modelprice中的价格
		if ($priceType == '4')
			$this->model->updatePrice($receiver['model_id'], array('dealer_price' => 1)); 
		// end
		if (!$flag)
		{ 
			// var_dump($this->series->sql);exit;
			$this->alert("失败！", 'js', 3, $_ENV['PHP_SELF'] . 'addView');
		}
		else
		{
			$this->alert("成功！", 'js', 3, $_ENV['PHP_SELF'] . 'addView');
		}
	}

	function doAddView()
	{
		$tplName = 'bingoprice_add';
		$brand = $this->brand->getAllBrand('state=3', array('letter' => 'asc'), 200);
		$this->tpl->assign('brand', $brand);
		$addDBFields = $this->dbfields;
		foreach($this->notAddDBFields as $notv){
			unset($addDBFields[$notv]);
		}
		$this->tpl->assign('dbfields', $addDBFields);
		$this->template($tplName);
	}

	function doList()
	{
		$php_self = $_ENV['PHP_SELF'] . 'list';
		$template_name = "bingoprice_list";
		$type = empty($_REQUEST['type']) ? 2 : $_REQUEST['type'];
		$receiverArr = array('isquote', 'brand_id', 'factory_id', 'series_id', 'model_id', 'page');
		$receiver = receiveArray($receiverArr);
		$php_self .= "&isquote={$receiver['isquote']}";
		$isquote = (empty($receiver['isquote']) or $receiver['isquote'] == 1) ? "price>0" : "(price = '' or price is null)";
		$isquote1 = empty($receiver['isquote']) ? 2 : $receiver['isquote'];
		$brand_id = $receiver['brand_id'];
		$factory_id = $receiver['factory_id'];
		$series_id = $receiver['series_id'];
		$model_id = $receiver['model_id'];
		$where1 = 'state in (3,7,8,11)';
		$where1 .= $isquote1 == 1 ? ' and bingo_price <> ""' : ' and (bingo_price = "" or bingo_price is null)';
		$brand = $this->brand->getAllBrand('state=3', array('letter' => 'asc'), 200);
		if (!empty($brand_id))
		{
			$factoryData = $this->factory->getFactoryByBrand($brand_id);
			$php_self .= '&brand_id=' . $brand_id;
			$this->tpl->assign('factory_data', $factoryData);
			$this->tpl->assign('brand_id', $brand_id);
			$where = " AND m.brand_id = {$brand_id}";
			$where1 .= " and brand_id = {$brand_id}";
		}
		if (!empty($factory_id))
		{
			$seriesData = $this->series->getSeriesdata('series_id,series_name', "factory_id={$factory_id} and state=3");
			$php_self .= '&factory_id=' . $factory_id;
			$this->tpl->assign('series_data', $seriesData);
			$this->tpl->assign('factory_id', $factory_id);
			$where .= " and m.factory_id = {$factory_id}";
			$where1 .= " and factory_id = {$factory_id}";
		}
		if (!empty($series_id))
		{
			$modelData = $this->model->chkModel('model_id,model_name', "series_id={$series_id} and state in (3,7,8,11)", '');
			$php_self .= '&series_id=' . $series_id;
			$this->tpl->assign('model_data', $modelData);
			$this->tpl->assign('series_id', $series_id);
			$where .= " and m.series_id = {$series_id}";
			$where1 .= " and series_id = {$series_id}";
		}
		if (!empty($model_id))
		{
			$this->tpl->assign('model_id', $model_id);
			$php_self .= '&model_id=' . $model_id;
			$where .= " and m.model_id = {$model_id}";
			$where1 .= " and model_id = {$model_id}";
		}
		if ($type == 2)
		{
			$priceType = 2;
			$php_self .= '&type=2';
		}
		if ($type == 3)
		{
			$priceType = 3;
			$php_self .= '&type=3';
		}
		if ($type == 4)
		{
			$priceType = 0;
			$php_self .= '&type=4';
		}
		$limit = 20;
		$page = max(1, intval($_GET['page']));
		$offset = ($page - 1) * $limit;
		$php_self_page = $php_self;
		$php_self .= '&page=' . $page;
		if ($type == 5)
		{
			$php_self .= '&type=5';
			$model = $this->model->getModels($where1, '', $limit, $offset);
			$total = $model['total']['count(*)'];
			$model = $model['res'];
			$page_bar = $this->multi($total, $limit, $page, $php_self_page . "&type=5&isquote={$isquote1}");
			$this->tpl->assign('xj_isquote', $isquote1);
		}
		else
		{
			if ($type == 4)
			{
				$xj_order = max(1, $_POST['isorder']);
				$php_self .= "&isorder={$_POST['isorder']}";
				$php_self_page .= "&isorder={$_POST['isorder']}";
				switch ($xj_order)
				{
					case 1:
						$order = 'updated';
						break;
					case 2:
						$order = 'get_time';
						break;
					case 3:
						$order = 'price';
						break;
					// case 4:
					// $order = array('cp.model_price' => 'desc');
					// break;
					default:
						$order = 'id';
				}
				$model = $this->cardbpricelog->getAllLogs(trun, $isquote, $priceType, $where, $limit, $offset, 2, $order);
				$this->tpl->assign('xj_order', $xj_order);
			}
			else
			{
				$model = $this->cardbpricelog->getAllLogs(trun, $isquote, $priceType, $where, $limit, $offset, 2, 'id');
			}
			//echo $php_self_page;
			$page_bar = $this->multi($this->cardbpricelog->total, $limit, $page, $php_self_page);
			$this->tpl->assign('xj_isquote', $receiver['isquote']);
			$total = $this->cardbpricelog->total;
		}
		$this->tpl->assign('page_title', $this->page_title);
		$this->tpl->assign('list', $model);
		$this->tpl->assign('brand', $brand);
		$this->tpl->assign('page_bar', $page_bar);
		$this->tpl->assign('type', $type);
		$this->tpl->assign('php_selfs', urlencode($php_self));
		$this->tpl->assign('total', $total);
		$this->tpl->assign('page', $page);
		$this->template($template_name);
	}

	function doedit()
	{
		global $adminauth, $login_uid;
		$adminauth->checkAuth($login_uid, 'sys_module', 304, 'W');

		$tpl_name = "bingoprice_edit";
		$model_id = $_GET['model_id'];
		$type = $_GET['type'];
		$priceId = $_GET['id'];
		$php_self = $_GET['phpself'];
		$model = $this->model->getModel($model_id);
		if ($type != 5)
		{
			$this->province = new Province();
			$this->city = new City();
			$this->county = new County();
			$price = $this->cardbpricelog->getPrice($priceId);
			// $price['spot_info'] = ($price['spot_info'] == '1') ? '有' : '无';
			$areaIdArr = array('0', '0', '0');
			$pId = $this->province->getProvinceByName($price['province']);
			if ($pId)
			{
				$areaIdArr[0] = $pId['id'];
			}
			$province = $this->province->getProvince();
			$cId = $this->city->getCityByName($price['city']);
			if ($cId)
			{
				$areaIdArr[1] = $cId['id'];
			}
			$city = $this->city->getCity($pId['id']);
			$countyId = $this->county->getCountyByName($price['area']);
			if ($countyId)
			{
				$areaIdArr[2] = $countyId['id'];
			}
			$county = $this->county->getCounty($cId['id']);
			$beijings = '';
			$beijing = $this->salestate->getState($areaIdArr, $model_id);
			if ($beijing)
			{
				switch ($beijing['state'])
				{
					case '3':
						$beijings = '在售';
						break;
					case '8':
						$beijings = '停产在售';
						break;
					case '9':
						$beijings = '停产停售';
						break;
					default:
						$beijings = '在售';
						break;
				}
			}
			if ($type == 4)
			{
				$brand = $this->brand->getAllBrand('state=3', array('letter' => 'asc'), 200);
				$this->tpl->assign('brand', $brand);
				if ($model)
				{
					$factory = $this->factory->getFactoryByBrand($model['brand_id']);
					$series = $this->series->getAllSeries("s.state=3 and s.factory_id=f.factory_id and f.brand_id=b.brand_id and s.factory_id='{$model['factory_id']}'", array('s.letter' => 'asc'), 100);
					$modelList = $this->model->getAllModel("m.state in (3,8) and m.series_id=s.series_id and s.factory_id=f.factory_id and f.brand_id=b.brand_id and m.series_id='{$model['series_id']}'", array(), 100);
					$this->tpl->assign('factory', $factory);
					$this->tpl->assign('series', $series);
					$this->tpl->assign('modellist', $modelList);
					$addDBFields = $this->dbfields;
					foreach($this->notAddDBFields as $notv){
						unset($addDBFields[$notv]);
					}
					$this->tpl->assign('dbfields', $addDBFields);
				}
			}
			$this->tpl->assign('beijing', $beijings);
			$this->tpl->assign('price', $price);
			$this->tpl->assign('province', $province);
			$this->tpl->assign('pid', $pId);
			$this->tpl->assign('city', $city);
			$this->tpl->assign('cid', $cId);
			$this->tpl->assign('area', $county);
			$this->tpl->assign('countyid', $countyId);
			$this->tpl->assign('id', $priceId);
		}
		$this->tpl->assign('type', $type);
		$this->tpl->assign('model', $model);
		$this->tpl->assign('php_self', $php_self);
		$this->template($tpl_name);
	}

	function doEdits()
	{
		global $adminauth, $login_uid;
		$adminauth->checkAuth($login_uid, 'sys_module', 304, 'W');

		$receiverArr = array('price2', 'memo');
		$receiver = receiveArray($receiverArr);
		$type = $_POST['type'];
		$id = $_POST['id'];
		$mId = $_POST['mId'];
		$php_self = urldecode($_POST['phpself']);
		if ($type == 5)
		{
			$flag = $this->model->updateModel(array("bingo_price" => $receiver['price2'], "model_memo" => $receiver['memo']), "model_id=$mId");
		}elseif ($type == 4)
		{
			$addDBFields = $this->dbfields;
			foreach($this->notAddDBFields as $notv){
				unset($addDBFields[$notv]);
			}
			if(empty($addDBFields) or !is_array($addDBFields)){
				echo '什么情况？';
				exit;
			}
			$receiverArr = '';
			foreach($addDBFields as $addVk=>$addVv){
				$receiverArr[] = $addVk;
			}
			$receiver = receiveArray($receiverArr);
			if(!strpos($receiver['province'], '|') or !strpos($receiver['city'], '|') or !strpos($receiver['area'], '|') or empty($mId) or empty($receiver['creator']) or empty($receiver['get_time']) or empty($receiver['nude_car_price'])){
				echo '必填项为空';
				exit;
			}
			$province = explode('|', $receiver['province']);
			$city = explode('|', $receiver['city']);
			$area = explode('|', $receiver['area']); 
			// 在售状态
			$saleFlag = $this->salestate->getState(array($province[0], $city[0], $area[0]), $mId);
			switch ($receiver['salestate'])
			{
				case '在售':
					$receiver['salestate'] = 3;
					break;
				case '停产停售':
					$receiver['salestate'] = 9;
					break;
				case '停产在售':
					$receiver['salestate'] = 8;
					break;
				default:
					$receiver['salestate'] = 3;
					break;
			}
			if ($saleFlag)
			{
				if ($receiver['salestate'] != $saleFlag['state'])
				{
					$this->salestate->updateState(array("state" => $receiver['salestate']), "province_id={$province[0]} and city_id={$city[0]} and county_id={$area[0]} and model_id={$mId}");
				}
			}
			else
			{
				$this->salestate->ufields = array('province_id' => $province[0],
					'city_id' => $city[0],
					'county_id' => $area[0],
					'model_id' => $mId,
					'state' => $receiver['salestate']
					);
				$this->salestate->insert();
			}
			// $receiver['spot_info'] = ($receiver['spot_info'] == '有') ? 1 : 0; //现车情况
			if ($receiver['modelchange'])
			{
				$this->cardbpricelog->ufields = array('model_id' => $receiver['modelchange']);
				$this->cardbpricelog->where = "id=$id";
				$this->cardbpricelog->update();
			}
			foreach($addDBFields as $addIVk=>$addIVv){
				switch($addIVk){
					case 'get_time':
						$receiver[$addIVk] = strtotime($receiver[$addIVk]);
					break;
					case 'province':
						$receiver[$addIVk] = $province[1];
					break;
					case 'city':
						$receiver[$addIVk] = $city[1];
					break;
					case 'area':
						$receiver[$addIVk] = $area[1];
					break;
					case 'nude_car_price':
						$receiver['price'] = $receiver['nude_car_price'];
						$receiver['deliver_price'] = getDeliveryPrice($receiver['nude_car_price']);
						$receiver['price_type'] = 0;
					break;
					case 'sale_gender':
						if($addIVv == '男')
							$receiver['sale_gender'] = 1;
						else
							$receiver['sale_gender'] = 0;
					break;
				}
			}
			unset($receiver['salestate']);
			$this->cardbpricelog->ufields = $receiver;
//                        if($this->cardbpricelog->ufields['report_content11']){
//                           
//                              $this->cardbpricelog->ufields['report_content11'] = str_replace('&nbsp;', '', $this->cardbpricelog->ufields['report_content11']);
//                        }

			$this->cardbpricelog->where = "id=$id";
			$flag = $this->cardbpricelog->update();
//                        echo $this->cardbpricelog->sql;exit;
		}elseif ($type == 2)
		{
			$this->cardbpricelog->ufields = array('price' => $receiver['price2'], 'memo' => $receiver['memo']);
			$this->cardbpricelog->where = "id=$id";
			$flag = $this->cardbpricelog->update();
		}elseif ($type == 3)
		{
			$this->cardbpricelog->ufields = array('price' => $receiver['price2']);
			$this->cardbpricelog->where = "id=$id";
			$flag = $this->cardbpricelog->update();
		}
		switch ($type)
		{ 
			// 更新对应车款cardb_modelprice的成本价
			case 2: $this->model->updatePrice($mId, array('cost_price' => $receiver['price2']));
				break; 
			// 更新对应车款cardb_modelprice的最多人购买价
			case 3: $this->model->updatePrice($mId, array('most_price' => $receiver['price2']));
				break; 
			// 更新对应车款cardb_modelprice的商情价
			case 4: $this->model->updatePrice($mId, array('dealer_price' => 1));
				break; 
			// 更新对应车款cardb_modelprice的帮买价
			case 5: $this->model->updatePrice($mId, array('bingo_price' => $receiver['price2']));
				break;

			default:;
		}
		if ($flag)
		{
			$this->alert("成功!", 'js', 3, $php_self);
		}
		else
		{
			$this->alert("失败!", 'js', 3, $php_self);
		}
	} 
	// 冰狗价、用户反馈价历史记录
	function doPriceLog()
	{
		$tpl_name = "bingoprice_log";
		$this->page_title = "车款报价历史记录";
		$phpSelf = $_ENV['PHP_SELF'] . 'list';
		$receiverArr = array('isquote', 'brand_id', 'factory_id', 'series_id', 'model_id', 'page');
		$receiver = receiveArray($receiverArr);
		foreach ($receiver as $k => $v)
		{
			if ($v)
			{
				$condition .= "&$k=$v";
			}
		}
		$condition = str_replace('model_id', '', $condition);
		$model_id = $_GET['model_id'];
		$where = " m.series_id=s.series_id AND s.factory_id=f.factory_id AND f.brand_id=b.brand_id AND (m.state=3 or m.state=7 or m.state=8) AND m.model_id = $model_id";
		$tmp = $this->model->getAllModel($where);
		$model = $tmp[0];
		$bingoprice = $this->cardbpricelog->getLogs($model_id, 0);
		$saleprice = $this->cardbpricelog->getLogs($model_id, 1);

		$this->dpricehistory->limit = 10;
		$this->dpricehistory->order = array('updated' => 'desc');
		$dealerprice = $this->dpricehistory->getDpriceHistory('*', "model_id = $model_id", 2);

		$this->tpl->assign('bingoprice', $bingoprice);
		$this->tpl->assign('saleprice', $saleprice);
		$this->tpl->assign('dealerprice', $dealerprice);
		$this->tpl->assign('model', $model);
		$this->tpl->assign('condition', $condition);
		$this->template($tpl_name);
	}

	/**
	 * 将所有dealer_price_low赋值到bingo_price
	 */

	function doCopy()
	{
		$this->model->fields = "model_id,series_id,dealer_price_low";
		$this->model->where = "dealer_price_low<>0";
		$model = $this->model->getResult(2);
		foreach ($model as $key => $val)
		{
			$this->model->editbingoprice($val[model_id], $val[series_id], $val['dealer_price_low']);
		}
		echo "冰狗价格复制完成！";
	}

	/**
	 * 将新添加dealer_price_low赋值到bingo_price
	 */

	/**
	 * function doAddbingoprice() {
	 * $this->model->fields = "model_id,series_id,dealer_price_low";
	 * $this->model->where = "dealer_price_low<>0 AND bingo_price=0";
	 * $model = $this->model->getResult(2);
	 * foreach ($model as $key => $val) {
	 * $this->model->editbingoprice($val[model_id], $val[series_id], $val['dealer_price_low']);
	 * }
	 * echo "新增冰狗价格复制完成！";
	 * }
	 */ 
	// 更新series表中bingo_price_low、bingo_price_high字段
	/**
	 * function doUpdateBingoPriceLow() {
	 * $this->series->fields = "series_id,series_name,brand_id,state";
	 * $this->series->where = " 1 and (state=3 or state=7 or state=8)";
	 * $res = $this->series->getResult(2);
	 * foreach ($res as $key => $val) {
	 * $result = $this->model->updatebingoprice($val['series_id']);
	 * }
	 * echo "series表中price_low、price_high、dealer_price_low、dealer_price_high、bingo_price_low、bingo_price_high价格更新完成！";
	 * }
	 */

	function doDeletePrice()
	{
		global $adminauth, $login_uid;
		$adminauth->checkAuth($login_uid, 'sys_module', 304, 'A');

		$delList = $_POST['delist'] ? $_POST['delist'] : $_GET['delist'];
		$phpSelf = $_POST['phpself'] ? urldecode($_POST['phpself']) : $_GET['phpself'];
		$msgArray = $this->cardbpricelog->delPricelog($delList);
		$this->alert("删除了" . $msgArray[0] . "条报价，修改了" . $msgArray[1] . "条价格\\n" . $msgArray[2], 'js', 3, $phpSelf);
	}

	function checkAuth()
	{
		global $adminauth, $login_uid;
		$adminauth->checkAuth($login_uid, 'sys_module', 210, 'A');
	}
}

?>