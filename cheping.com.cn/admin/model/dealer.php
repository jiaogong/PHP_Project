<?php
class dealer extends model {
    function __construct() {
        parent::__construct();
        $this->table_name = 'dealer_info';
    }
    function getArticleDealer($sidList, $pid, $cid, $cyid) {
        $this->tables = array(
            'dealer_info' => 'di',
            'service' => 's'
        );
        $this->fields = 'di.dealer_id, di.dealer_name';
        $this->where = "di.dealer_id = s.dealer_id AND s.series_id in ($sidList)";
        if($pid) $this->where .= " AND di.province_id = $pid";
        if($cid) $this->where .= " AND di.city_id = $cid";
        if($cyid) $this->where .= " AND di.county_id = $cyid";
        $result = $this->joinTable(2);
        foreach($result as $k => $v) {
            $result[$k]['dealer_name'] = iconv('gbk', 'utf-8', $v['dealer_name']);
        }
        return $result;
    }
    function getList($condition, $limit, $offset) {
        $this->where = $condition;        
        $this->fields = 'count(*)';
        $this->total = $this->getResult(3);
        
        $this->fields = '*';                
        $this->limit = $limit;
        $this->offset = $offset;
        $list = $this->getResult(2);
        return $list;
    }
    function getDealerList($receiver, $limit, $offset) {
        $province_id = $receiver['province'];
        $city_id = $receiver['city'];
        $county_id = $receiver['county'];
        $dealer_name = $receiver['dealer_name'];
        $brand_id = $receiver['brand_id'];
        $factory_id = $receiver['factory_id'];
        $series_id = $receiver['series_id'];
        $state = intval($receiver['state']);
		switch($state){
			case 1:
				$where = 'state=1';
			break;
			case 2:
				$where = 'state=2';
			break;
			default:
				$where = '1';
		}
        if($brand_id){
            $where = 'i.'.$where. ' and i.dealer_id = s.dealer_id';
//            $this->table_name = 'dealer_info i';
            $this->tables = array(
                'dealer_info' => 'i',
                'service' => 's'
            );
            if($brand_id) $where .= " AND s.brand_id = $brand_id";
            if($factory_id) $where .= " AND s.factory_id = $factory_id";
            if($series_id) $where .=" AND s.series_id = $series_id";
            if($province_id){
                $where .= " AND i.province_id = $province_id";
            }
            if($city_id){
                $where .= " AND i.city_id = $city_id";
            }
            if($county_id){
                $where .= " AND i.county_id = $county_id";
            }
            if($dealer_name) $where .= " AND i.dealer_name like '%$dealer_name%'";
            $this->fields = 'count(*)';
			if($receiver['src_id']){
				$where .= ' and i.' . $receiver['src_id'];
			}
            $this->where = $where;
            $this->group = 's.dealer_id';
            $this->total = count($this->joinTable(2));
            $this->fields = 'i.dealer_id dealer_id,i.dealer_name,i.dealer_name2,i.dealer_area,i.dealer_camp,i.dealer_tel,i.state';
            $this->limit = $limit;
            $this->offset = $offset;
            $this->group = 's.dealer_id';
            $this->order = array('i.dealer_id' => 'desc');
            $list = $this->joinTable(2);
        }
        else{
            #$where = 'state = 0';
            if($province_id) $where .= " AND province_id = $province_id";
            if($city_id) $where .= " AND city_id = $city_id";
            if($county_id) $where .= " AND county_id = $county_id";            
            if($dealer_name) $where .= " AND dealer_name like '%$dealer_name%'";
			if($receiver['src_id']){
				$where .= ' and ' . $receiver['src_id'];
			}
            $this->where = $where;
            $this->fields = 'count(*) count';
            $totalArray = $this->getResult();
            $this->total = $totalArray['count'];
            $this->fields = 'dealer_id,dealer_name,dealer_name2,dealer_area,dealer_camp,dealer_tel,state';
            $this->limit = $limit;
            $this->offset = $offset;
            $this->order = array('dealer_id' => 'desc');
            $list = $this->getResult(2);
        }
        return $list;        
    }
    function getServiceFactory($dealer_id) {
        $this->reset();
        $this->tables = array('service' => 's', 'cardb_factory' => 'f');
        $this->fields = 'distinct(f.factory_name)';
        $this->where = "s.factory_id = f.factory_id AND s.dealer_id = $dealer_id";
        $factory = $this->joinTable(2);
        return $factory;
    }
    function getDetail($id) {
        $this->where = "dealer_id = $id";
        $this->fields = '*';
        $list = $this->getResult();
        return $list;
    }
    function delDealer($id) {
        $this->where = "dealer_id = $id";
        $this->ufields = array('state' => 1);
        $this->update();
    }
    function addDealer($receiver) {
        $receiver['created'] = time();
        $this->ufields = $receiver;
        return $this->insert();
    }   
    function editDealer($receiver, $id) {        
        $this->where = "dealer_id = $id";            
        $this->ufields = $receiver;
        $this->update();
    } 
    function getDealer($fields, $where, $order = array('dealer_name' => 'asc')) {
        $this->where = $where;
        $this->fields = $fields;
        $dealer = $this->getResult(2);
        return $dealer;
    }
    
    function getDealerInfo($fields, $where,$flag=null){
        $this->where = $where;
        $this->fields = $fields;
        if($flag){
           $return = $this->getResult($flag);
        }else{
             $return = $this->getResult();
        }
        return $return;
    }
	function getDealerOrder($fields, $where, $order, $flag=1){
		$this->fields = $fields;
		$this->where = $where;
		$this->order = $order;
		return $this->getResult($flag);
	}
    function getDealerandfactory($fields, $where, $order, $limit=null, $offset=null) {
        $this->where = $where;
        $this->fields = $fields;
        $this->tables = array(
                'service' => 's',
                'dealer_info' => 'd',
                'cardb_factory' => 'c',
        );
        $this->order = $order;
        if($limit) {
            $this->limit = $limit;
        }
        if($offset) {
            $this->offset = $offset;
        }
        $dealer = $this->joinTable(2);
        return $dealer;
    }
	#目前就给抓取经销商用
	function mkdirlog(){
		$_catchDealerDIR = SITE_ROOT . 'data/log/' . date('Ym') . '/' . date('Ymd') . '/';
		@file::forcemkdir($_catchDealerDIR);
		return $_catchDealerDIR;
	}
	/**
	 * 抓取汽车之家经销商，不能匹配经销商地区，需要传值
	 * @ param $srcid int 经销商id
	 * @ param $provinceid int 经销商省级单位
	 * @ param $cityid int 经销商地级单位
	 * @ param $countyid int 经销商县级单位
	 * @ return void or array(dealerid,name,area,tel);
	 */
	function catchDealerFUN($srcid,$provinceid,$cityid,$countyid){
		set_time_limit(0);
		$catchdata = new CatchData();
		$series = new series();
		$serviceinfo = new Service();
		$autohomeScore = 'http://dealer.autohome.com.cn/';
		$srcid = intval($srcid);
		$provinceid = intval($provinceid);
		$cityid = intval($cityid);
		$countyid = intval($countyid);
		if($srcid < 1 or empty($provinceid) or empty($cityid) or empty($countyid))
			return;
		$curl = $autohomeScore . $srcid;
		$catchdata->catchResult($curl);
		#经销商名称
		$dealerName = $catchdata->pregMatch('/>([^<]+)<\/h2>/sim', 1);
		if(empty($dealerName)){
			$catchDIR = $this->mkdirlog();
            $message = "page_content:" . $catchdata->result . "\n";
            $message .= "time:" . date('Y/m/d H:i:s') . "\n";
            $message .= "regex_expr:" . '/>([^<]+)<\/h2>/sim' ."\n";
            error_log($message, 3, $catchDIR . $srcid . '-name_error.log');
            $message = "";
			return;
		}
		#经销商地址
		$dealerArea = $catchdata->pregMatch('/<div class="map_area">\s*<p>\s*地址：(.+?)\s*\(/sim', 1);
		if(empty($dealerArea)){
			$catchDIR = $this->mkdirlog();
            $message = "page_content:" . $catchdata->result . "\n";
            $message .= "time:" . date('Y/m/d H:i:s') . "\n";
            $message .= "regex_expr:" . '/<div class="map_area">\s*<p>\s*地址：(.+?)\s*\(/sim' ."\n";
            error_log($message, 3, $catchDIR . $srcid . '-area_error.log');
            $message = "";
			return;
		}
		#经销商简称
		$dealerAlias = $catchdata->pregMatch('/<h3>\s*<a target="_self" href="[^"]+">\s*(.+?)<\/a><\/h3>/sim', 1);
		if(empty($dealerArea)){
			$catchDIR = $this->mkdirlog();
            $message = "page_content:" . $catchdata->result . "\n";
            $message .= "time:" . date('Y/m/d H:i:s') . "\n";
            $message .= "regex_expr:" . '/<h3>\s*<a target="_self" href="[^"]+">\s*(.+?)<\/a><\/h3>/sim' ."\n";
            error_log($message, 3, $catchDIR . $srcid . '-alias_error.log');
            $message = "";
		}
		#经销商电话
		$dealerTel = $catchdata->pregMatch('/<span class="fontred"><span class="dealer_400_wrap"><span class="dealer_400_big"[^>]+>(\d+-\d+-\d+)<\/span>/sim', 1);
		if(empty($dealerTel)){
			$dealerTel = $catchdata->pregMatch('/<span class="fontred"><span class="dealer_400_wrap dealer_400_normal" style="color:#000;font-family:Arial;font-weight:700;">(\d+-?\d+)&nbsp;&nbsp;/sim', 1);
			if(empty($dealerTel)){
				$catchDIR = $this->mkdirlog();
				$message = "page_content:" . $catchdata->result . "\n";
				$message .= "time:" . date('Y/m/d H:i:s') . "\n";
				$message .= "regex_expr:" . '/<span class="fontred"><span class="dealer_400_wrap"><span class="dealer_400_big"[^>]+>(\d+-\d+-\d+)<\/span>/sim' ."\n";
				error_log($message, 3, $catchDIR . $srcid . '-tel_error.log');
				$message = "";
			}
		}
		#经销商经营车系和厂商
		$seriesString = $seriesArray = $factoryArray = $factoryString = '';
		$dealerService = $catchdata->pregMatch('/<li id="li\d+-\d+"[^>]*><a href="[^>]+" target="_brank">(.+?)<\/a><\/li>/sim');
		if(empty($dealerService)){
			$catchDIR = $this->mkdirlog();
            $message = "page_content:" . $catchdata->result . "\n";
            $message .= "time:" . date('Y/m/d H:i:s') . "\n";
            $message .= "regex_expr:" . '/<li id="li\d+-\d+"[^>]*><a href="[^>]+" target="_brank">(.+?)<\/a><\/li>/sim' ."\n";
            error_log($message, 3, $catchDIR . $srcid . '-series_error.log');
            $message = "";
			return;
		}else{
			foreach($dealerService[1] as $ds){
				$seriesString .= "'" . $ds . "',";
			}
			$seriesString = trim($seriesString, ',');
			$series->group = 'factory_name';
			$factoryArray = $series->getSeriesdata('factory_name',"state=3 and series_name in ($seriesString)");
			if(empty($factoryArray)){
				$catchDIR = $this->mkdirlog();
				$message = "page_content:" . $catchdata->result . "\n";
				$message .= "time:" . date('Y/m/d H:i:s') . "\n";
				$message .= "sql:" . $series->sql . "\n";
				error_log($message, 3, $catchDIR . $srcid . '-factory_error.log');
				$message = "";
				return;
			}else{
				foreach($factoryArray as $fs){
					$factoryString .= $fs['factory_name'] . ',';
				}
				$factoryString = trim($factoryString, ',');
			}
			$series->group = '';
			$seriesArray = $series->getSeriesdata('series_id,brand_id,factory_id',"state=3 and series_name in ($seriesString)");
		}
		#经销商地图
		$dealerMap = $autohomeScore . $srcid . '/contact.html#map';
		if(empty($dealerName[1]) && empty($dealerArea[1]))
			return;
		$dealerName[1] = str_replace(array(' ', '&nbsp;'), array('', ''), $dealerName[1]);
		$dealerArea[1] = str_replace(array(' ', '&nbsp;'), array('', ''), $dealerArea[1]);
		$dealer = $this->getDealerInfo('dealer_id,dealer_pic', "dealer_name='{$dealerName[1]}' and dealer_area='{$dealerArea[1]}' and state!=1");
		$dbid = '';
		if($dealer){
			$dbid = $dealer['dealer_id'];
			if($dealer['dealer_pic']){
				$this->editDealer(array('dealer_camp' => $factoryString, 'dealer_alias' => $dealerAlias[1], 'dealer_map' => $dealerMap, 'dealer_tel' => $dealerTel[1], 'src_id' => $srcid, 'state' => 0, 'province_id' => $provinceid, 'city_id' => $cityid, 'county_id' => $countyid, 'created' => time()), $dealer['dealer_id']);
			}else{
				$dealerImg = $this->catchDealerImg($dbid,$catchdata->result);
				$this->editDealer(array('dealer_camp' => $factoryString, 'dealer_alias' => $dealerAlias[1], 'dealer_map' => $dealerMap, 'dealer_pic' => $dealerImg, 'dealer_tel' => $dealerTel[1], 'src_id' => $srcid, 'state' => 0, 'province_id' => $provinceid, 'city_id' => $cityid, 'county_id' => $countyid, 'created' => time()), $dealer['dealer_id']);
			}
			error_log(date('Y/m/d H:i:s') . '---' . $this->sql . "\n", 3, SITE_ROOT . 'data/log/dealer_update.log');
		}else{
			$dbid = $this->addDealer(array('dealer_name' => $dealerName[1], 'dealer_alias' => $dealerAlias[1], 'dealer_camp' => $factoryString, 'dealer_pic' => '', 'dealer_map' => $dealerMap, 'dealer_tel' => $dealerTel[1], 'dealer_area' => $dealerArea[1], 'src_id' => $srcid, 'state' => 0, 'province_id' => $provinceid, 'city_id' => $cityid, 'county_id' => $countyid));
			error_log(date('Y/m/d H:i:s') . '---' . $this->sql . "\n", 3, SITE_ROOT . 'data/log/dealer_insert.log');
			$dealerImg = $this->catchDealerImg($dbid,$catchdata->result);
			$this->editDealer(array('dealer_pic'=>$dealerImg),$dbid);
			error_log(date('Y/m/d H:i:s') . '---' . $this->sql . "\n", 3, SITE_ROOT . 'data/log/dealer_insert_newpic.log');
		}
		if(empty($srcid) or empty($seriesArray))
			return;
		$dbid = rtrim($dbid);
		$serviceinfo->limit = 100;
		$service = $serviceinfo->deleteByDealerid($dbid);
		foreach($seriesArray as $fa){
			if($dbid && $fa['brand_id'] && $fa['factory_id'] && $fa['series_id']){
				$serviceinfo->insert_service(array('dealer_id' => $dbid, 'brand_id' => $fa['brand_id'], 'factory_id' => $fa['factory_id'], 'series_id' => $fa['series_id']));
				error_log(date('Y/m/d H:i:s') . '---' . $serviceinfo->sql . "\n", 3, SITE_ROOT . 'data/log/service_insert.log');
			}else{
			error_log(date('Y/m/d H:i:s') . '---brand_id=' . $fa['brand_id'] . '-factory_id=' . $fa['factory_id'] . '-series_id=' . $fa['series_id'] . "\n", 3, SITE_ROOT . 'data/log/service_error.log');
			}
		}
		if($dbid && $dealerName[1] && $dealerArea[1]){
			return array('id' => $dbid, 'name' => $dealerName[1], 'area' => $dealerArea[1], 'tel' => $dealerTel[1]);
		}else{
			return;
		}
	}

	#抓取经销商图片
	function catchDealerImg($dbid,$result){
		$catchdata = new CatchData();
		$catchdata->result = $result;
		$dealerImg = '';
		if(empty($result) or empty($dbid)){
			return;
		}
		$dealerImgMathes = $catchdata->pregMatch("/<img style='width:320;height:240px;' src='(.+?)'[^\/]+\/>/sim");
		if ($dealerImgMathes) {
			$path = SITE_ROOT . '../attach/images/dealer_img/' . $dbid . '/';
			$pathDB = '/attach/images/dealer_img/' . $dbid . '/';
			@file::forcemkdir($path);
			foreach ($dealerImgMathes[1] as $imgsrc) {
				$catchdata->catchResult($imgsrc, 0, $curl);
				$fileName = substr($imgsrc, strrpos($imgsrc, '/') + 1);
				$filePath = $path . $fileName;
				file_put_contents($filePath, $catchdata->result);
				$dealerImg .= $pathDB . $fileName . '|';
			}
			$dealerImg = trim($dealerImg, '|');
		}else{
			$catchDIR = $this->mkdirlog();
			$message = "page_content:" . $catchdata->result . "\n";
			$message .= "time:" . date('Y/m/d H:i:s') . "\n";
			$message .= "regex_expr:" . "/<img style='width:320;height:240px;' src='(.+?)'[^\/]+\/>/sim\n";
			error_log($message, 3, $catchDIR . $dbid . '-image_error.log');
			$message = "";
		}
		return $dealerImg;
	}
}
?>
