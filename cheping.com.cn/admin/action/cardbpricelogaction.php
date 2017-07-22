<?php
/**
 * series action
 * $Id: cardbpricelogaction.php 1792 2016-03-28 01:59:03Z wangchangjiang $
 */

class cardbpricelogaction extends action
{
	function __construct()
	{
		parent::__construct();
		$this->factory = new factory();
		$this->brand = new brand();
		$this->series = new series();
		$this->model = new cardbModel();
		$this->cardbpricelog = new cardbPriceLog();
		$this->checkAuth();
	}

	function doDefault()
	{
		$this->doList();
	}

	function doList()
	{
		$php_self = $_ENV['PHP_SELF'] . 'list';
		$template_name = "cardbpricelog_list";
		$receiverArr = array('pType', 'brand_id', 'factory_id', 'series_id', 'model_id', 'page', 'creator', 'priceid', 'startdate', 'enddate', 'dateselect', 'isorder');
		$receiver = receiveArray($receiverArr);
		$pType = empty($receiver['pType']) ? 2 : $receiver['pType'];
		$php_self .= "&pType=$pType";
		$brand_id = $receiver['brand_id'];
		$factory_id = $receiver['factory_id'];
		$series_id = $receiver['series_id'];
		$model_id = $receiver['model_id'];
		$priceType = 0;
		if ($pType == '2') $priceType = 2;
		if ($pType == '3') $priceType = 3;
		$brand = $this->brand->getAllBrand('state=3', array('letter' => 'asc'), 200);
		if (!empty($brand_id))
		{
			$factoryData = $this->factory->getFactoryByBrand($brand_id);
			$where = " AND m.brand_id = $brand_id";
			$php_self .= '&brand_id=' . $brand_id;
			$this->tpl->assign('factory_data', $factoryData);
			$this->tpl->assign('brand_id', $brand_id);
		}
		if (!empty($factory_id))
		{
			$seriesData = $this->series->getSeriesdata('series_id,series_name', "factory_id={$factory_id} and state=3");
			$where .= " AND m.factory_id = $factory_id";
			$php_self .= '&factory_id=' . $factory_id;
			$this->tpl->assign('series_data', $seriesData);
			$this->tpl->assign('factory_id', $factory_id);
		}
		if (!empty($series_id))
		{
			$modelData = $this->model->chkModel('model_id,model_name', "series_id={$series_id} and state in (3,7,8,11)", '');
			$where .= " AND m.series_id = $series_id";
			$php_self .= '&series_id=' . $series_id;
			$this->tpl->assign('model_data', $modelData);
			$this->tpl->assign('series_id', $series_id);
		}
		if (!empty($model_id))
		{
			$php_self .= '&model_id=' . $model_id;
			$where .= " AND m.model_id = $model_id";
			$this->tpl->assign('model_id', $model_id);
		}
		if ($pType == 4)
		{
			if ($receiver['creator'])
			{
				switch ($receiver['creator'])
				{
					case 1:
						$where .= " AND cp.creator='田伟'";
						$php_self .= '&creator=1';
						break;
					case 2:
						$where .= " AND cp.creator='麦锐'";
						$php_self .= '&creator=2';
						break;
					case 3:
						$where .= " AND cp.creator='于文浩'";
						$php_self .= '&creator=3';
						break;
					case 4:
						$where .= " AND cp.creator='侯永超'";
						$php_self .= '&creator=4';
						break;
					case 5:
						$where .= " AND (cp.creator IS NULL OR cp.creator='')";
						$php_self .= '&creator=5';
						break;
					default:;
				}
			}
			if ($receiver['startdate'] && $receiver['enddate'])
			{
				$startdate = strpos($receiver['startdate'], '-') ? strtotime($receiver['startdate']) : $receiver['startdate'];
				$enddate = strpos($receiver['enddate'], '-') ? strtotime($receiver['enddate']) : $receiver['enddate'];
				switch ($receiver['dateselect'])
				{
					case 1:
						$where .= " and cp.get_time between {$startdate} and {$enddate}";
						$php_self .= "&dateselect=1&startdate=$startdate&enddate=$enddate";
						break;
					case 2:
						$where .= " and cp.updated between {$startdate} and {$enddate}";
						$php_self .= "&dateselect=2&startdate=$startdate&enddate=$enddate";
						break;
					case 3:
						$where .= " and cp.created between {$startdate} and {$enddate}";
						$php_self .= "&dateselect=3&startdate=$startdate&enddate=$enddate";
						break;
				}
			}
		}
		$limit = 20;
		$page = max(1, intval($_GET['page']));
		$php_self_page = $php_self;
		$php_self .= '&page=' . $page;
		$offset = ($page - 1) * $limit;
		if ($pType == 4)
		{
			$xj_order = max(1, $receiver['isorder']);
			$php_self .= "&isorder=$xj_order";
			$php_self_page .= "&isorder=$xj_order";
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
				case 6:
					$order = 'preferential';
					break;
				default:
					$order = 'id';
			}
			if ($receiver['priceid'])
			{
				$list = $this->cardbpricelog->getPriceAndModel($receiver['priceid']);
				$list = array($list);
				$this->cardbpricelog->total = 1;
				$php_self .= "&priceid={$receiver['priceid']}";
			}
			else
			{
				$list = $this->cardbpricelog->getAllLogs(false, '1', $priceType, $where, $limit, $offset, 2, $order);
			}
			$this->tpl->assign('xj_order', $xj_order);
		}
		else
		{
			$list = $this->cardbpricelog->getAllLogs(false, '1', $priceType, $where, $limit, $offset, 2, 'id');
		}
		$php_self = urlencode($php_self);
		$priceid = $receiver['priceid'] ? $receiver['priceid'] : ''; 
		$page_bar = $this->multi($this->cardbpricelog->total, $limit, $page, $php_self_page);
		$this->tpl->assign('xj_creator', $receiver['creator']);
		$this->tpl->assign('priceid', $priceid);
		$this->tpl->assign('dateselect', $receiver['dateselect']);
		$this->tpl->assign('startdate', (strpos($receiver['startdate'], '-') or $receiver['startdate'] == '') ? $receiver['startdate'] : date('Y-m-d', $receiver['startdate']));
		$this->tpl->assign('enddate', (strpos($receiver['enddate'], '-') or $receiver['startdate'] == '') ? $receiver['enddate'] : date('Y-m-d', $receiver['enddate']));
		$this->tpl->assign('list', $list);
		$this->tpl->assign('type', $pType);
		$this->tpl->assign('brand', $brand);
		$this->tpl->assign('page_bar', $page_bar);
		$this->tpl->assign('php_self', $php_self);
		$this->tpl->assign('total', $this->cardbpricelog->total);
		$this->template($template_name);
	}

	function checkAuth()
	{
		global $adminauth, $login_uid;
		$adminauth->checkAuth($login_uid, 'sys_module', 210, 'A');
	}

	function doDelPrice()
	{
		$delList = $_POST['delist'] ? $_POST['delist'] : $_GET['delist'];
		$phpSelf = $_POST['phpself'] ? urldecode($_POST['phpself']) : $_GET['phpself'];
		$msgArray = $this->cardbpricelog->delPricelog($delList);
		$this->alert("删除了" . $msgArray[0] . "条报价，修改了" . $msgArray[1] . "条价格\\n" . $msgArray[2], 'js', 3, $phpSelf);
	}
}

?>