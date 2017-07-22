<?php

class cardbpriceAction extends action
{
	public $limit = 20;

	function __construct()
	{
		parent::__construct();
		$this->cardbprice = new cardbprice();
		$this->pricelog = new cardbpricelog();
		$this->brand = new brand();
		$this->factory = new factory();
		$this->series = new series();
		$this->model = new cardbmodel();
	}

	public function doDefault()
	{
		$this->doMediaprice();
	}

	public function doMediaprice()
	{
		$receiverArr = array('brand_id', 'factory_id', 'series_id', 'model_id');
		$receiver = receiveArray($receiverArr);
		$page = max(1, $_GET['page']);
		$offset = ($page - 1) * $this->limit;
		$brand = $this->brand->getAllBrand('state=3', array('letter' => 'asc'), 200);
		$where = ' AND price_type=5';
		if ($receiver['brand_id'])
		{
			$jump_url = "&brand_id={$receiver['brand_id']}";
			$where .= " AND cm.brand_id={$receiver['brand_id']}";
			$factoryData = $this->factory->getFactoryByBrand($receiver['brand_id']);
			$this->tpl->assign('factory_data', $factoryData);
		}
		if ($receiver['factory_id'])
		{
			$jump_url .= "&factory_id={$receiver['factory_id']}";
			$where .= " AND cm.factory_id={$receiver['factory_id']}";
			$seriesData = $this->series->getSeriesdata('series_id,series_name', "factory_id={$receiver['factory_id']} and state=3");
			$this->tpl->assign('series_data', $seriesData);
		}
		if ($receiver['series_id'])
		{
			$jump_url .= "&series_id={$receiver['series_id']}";
			$where .= " AND cm.series_id={$receiver['series_id']}";
			$modelData = $this->model->chkModel('model_id,model_name', "series_id={$receiver['series_id']} and state in (3,8)", '');
			$this->tpl->assign('model_data', $modelData);
		}
		if ($receiver['model_id']){
			$jump_url = "&model_id={$receiver['model_id']}";
			$where .= " AND cm.model_id={$receiver['model_id']}";
		}
		$mediaInfo = $this->cardbprice->showAllModelPrice($this->limit, $offset, $where);
		//echo $this->cardbprice->sql;exit;
		$modelprice_list = array();
		$_month_begin = mktime(0, 0, 0, date('m'), 1, date('Y'));
		foreach ($mediaInfo['res'] as $key => $value)
		{
			$bingo_price = $this->pricelog->getWhere("price", $value['model_id'], 0, "get_time>='{$_month_begin}'"); 
			//echo $this->pricelog->sql."<br>";exit;
			$value['bingo_price'] = $bingo_price['price'];
			$modelprice_list[] = $value;
			$bingo_price = 0;
		}

		$page_bar = $this->multi($mediaInfo['total']['total'], $this->limit, $page, 'index.php?action=cardbprice-mediaprice' . "$jump_url");
		$this->tpl->assign('brand', $brand);
		$this->tpl->assign('page_bar', $page_bar);
		// $this->tpl->assign('jump_url', 'index.php?action=cardbprice-mediaprice&page=' . $page);
		$this->tpl->assign('jump_url', urlencode('index.php?action=cardbprice-mediaprice' . "$jump_url"));
		$this->tpl->assign('mediainfo', $modelprice_list);
		$this->tpl->assign('brand_id', $receiver['brand_id']);
		$this->tpl->assign('factory_id', $receiver['factory_id']);
		$this->tpl->assign('series_id', $receiver['series_id']);
		$this->tpl->assign('model_id', $receiver['model_id']);
		$this->template('mediaprice');
	}

	public function doUpdateMediaprice()
	{
		$id = $_GET['id'];
		$price = $_GET['price'];
		$oldPrice = $_GET['oldprice'];
		$jump_url = $_GET['jump_url'];
		if ($id && $price && $price != '0.00')
		{ 
			// $this->cardbprice->updateModelPrice(array('price' => $price),$id);
			$pricelogInfo = $this->pricelog->getPriceByModelid('id', "price=$oldPrice AND price_type=5 AND model_id=$id", array('get_time' => 'desc'), 1, 1);
			if ($pricelogInfo)
			{
				$this->cardbprice->updateModelPrice(array('price' => $price, 'updated' => time()), $id);
				$this->pricelog->updatePricelog(array('price' => $price, 'updated' => time()), "id={$pricelogInfo['id']}");
				//$this->model->updatePrice($id, array('dealer_price' => 1));
			}
			$this->alert("修改价格成功", 'js', 3, $jump_url);
		}
		$this->alert("没有修改价格", 'js', 3, $jump_url);
	}
}