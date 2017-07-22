<?php
/**
 * 
 * $Id: websaleinfo.php 4343 2013-12-12 10:08:14Z jiangweiwei $
 */
class Websaleinfo extends model{
     var $sj = array(
            0 => '全部商家',
            1 => '易车网',
            2 => '汽车之家',
            3 => '搜狐汽车',
            4 => '车多少',
            5 => '天猫',
        );
         var $ct = array(
                0 =>'不限',
                1 => '微型车',
                2 => '小型车',
                3 => '紧凑型车',
                4 => '中型车',
                5 => '中大型车',
                6 => '豪华车',
                7 => '小型SUV',
                8 => '小型MPV',
                9 => '跑车',
                10 => '中大型SUV',
                11 => '中大型MPV'
       );   
        var $pr = array(
            array('low'=>-1),
            array('low' => 0, 'high' => 5),
            array('low' => 5, 'high' => 10),
            array('low' => 10, 'high' => 15),
            array('low' => 15, 'high' => 20),
            array('low' => 20, 'high' => 25),
            array('low' => 25, 'high' => 35),
            array('low' => 35, 'high' => 50),
            array('low' => 50, 'high' => 100),
            array('low' => 100, 'high' => 0),
     );
      var $sort = array(
          "pr" =>"model_price",
          "zk" =>"zk"
      );
  
    function  __construct() {
        
        $this->table_name = "cardb_websaleinfo";
        $this->oldcarval = new oldCarVal();
        $this->realdata = new realdata();
        parent::__construct();
      
    }
    function getSearchPriceInfo($mid, $logId, $priceType) {
        $timestamp = time();
        $this->table_name = 'cardb_websaleinfo cp';
        $this->tables = array(
            'cardb_model' => 'cm'
        );        
        $this->fields = 'cp.model_id, cp.id as pricelog_id, cp.*, cm.st36, cm.st27, cm.st28, cm.date_id, cm.series_id, cm.st41, cm.st48';        
        $this->join_condition = array(
            'cm.model_id = cp.model_id'
        );        
        $this->where = "cp.model_id = $mid AND cp.id = $logId";
        $row = $this->leftJoin();
        
        if(!empty($row)) {
            $modelId = $row['model_id'];            
            //置换补贴
            $row['car_prize'] = $this->oldcarval->getOldCarList("car_prize", "model_id='{$modelId}'  and start_date<$timestamp and end_date>$timestamp", 3);
            $row['jnbt'] = $this->realdata->getContryBt($row);
            $picType = $row['activity_property'];
            switch($picType) {
                case '汽车之家':
                    $row['dealer_pic'] = 'images/sq_ad.jpg';
                    $row['active_url'] = 'http://1111.autohome.com.cn/#pvareaid=102347';
                    break;
                case '易车惠特卖场':
                    $row['dealer_pic'] = 'images/sq_ad3.jpg';
                    $row['active_url'] = 'http://mai.bitauto.com/beijing/';
                    break;
                case '易车惠大团购':
                    $row['dealer_pic'] = 'images/sq_ad3.jpg';
                    $row['active_url'] = 'http://tuan.mai.bitauto.com/index.aspx?provinceid=2';
                    break;                
                case '搜狐汽车':
                    $row['dealer_pic'] = 'images/sq_ad5.jpg';
                    $row['active_url'] = 'http://auto.sohu.com/auto1111/index.shtml';
                    break;
                case '天猫':
                    $row['dealer_pic'] = 'images/sq_ad4.jpg';
                    $row['active_url'] = 'http://www.tmall.com/go/act/sale/rules11.php?spm=3.6842473.1110862389.183.7ARzFo&scm=activity.0.1.1657&acm=activity.0.1.1657';
                    break;
                case '车多少':
                    $row['dealer_pic'] = 'images/sq_ad2.jpg';
                    $row['active_url'] = 'http://www.cheduoshao.com/youhui/';
                    break;                                    
            }            
            $row['price_type_name'] = '优惠活动价';
            $row['get_type'] = '网络双十一';                       
            $row['cp_id'] = $row['pricelog_id'];
            //获取时间：
            if($row['discount_end_date']) $row['get_time'] = '截止时间：' .date('Y-m-d', $row['discount_end_date']);            
            elseif($row['offline_end_date']) $row['get_time'] = '截止时间：'.date('Y-m-d', $row['offline_end_date']);            
            $chouArr = $xianArr = $zengArr = array();
            for($i=1; $i< 9; $i++) {
                if($row['gift_title'.$i]) $chouArr[] = $row['gift_title'.$i];
                if($row['limit_title'.$i]) $xianArr[] = $row['limit_title'.$i];
                if($row['lottery_title'.$i]) $zengArr[] = $row['lottery_title'.$i];
            }
            if(!empty($chouArr)) $row['chou'] = implode('、', $chouArr);
            if(!empty($xianArr)) $row['xian'] = implode('、', $xianArr);
            if(!empty($zengArr)) $row['zeng'] = implode('、', $zengArr);
            
            if(trim($row['rate']) == '有') $row['rate'] = "享受0利率,最短{$row['low_year']},首付{$row['down_payment']}";
            else $row['rate'] = '不祥';
            if($row['car_prize'] > 0) $row['car_prize'] = $row['car_prize'] . '元';
            else $row['car_prize'] = '无';
            if(!$row['jnbt']) $row['jnbt'] = '无';
            foreach($row as $k => $v) {
                $row[$k] = $v;
            }
            return $row;
        }
        else return false;
    }  
    /**
     * 根据条件查询总数
     */
     function getSearchListTotil($a=array()){
       $this->tables = array(
            'cardb_model' => 'cm',
            'cardb_websaleinfo' => 'cw',
        );
       $timestamp = time();
       $this->fields ="count(cw.id)";
       $where ="cw.model_id=cm.model_id and  cm.state in(3,8)";
       $this->order =array("cm.brand_id"=>"asc","cw.model_id"=>"asc");
       if($a){
           foreach($a as $key=>$value){
            //   echo $key.'-'.$value."<br>";
               if($key=='pr'){
                   $pr_a =$this->pr[$value];
                   
                   if($pr_a['low']==-1){ 
                   }elseif($pr_a['high']==0){
                       $where .=" and cm.model_price>$pr_a[low] ";
                   }else{
                       $where .=" and cm.model_price>$pr_a[low] and cm.model_price<$pr_a[high] ";
                   }
               }
               if($key=='ct'){
                   if($value!=0){
                      // $type_name =$this->ct[$value];
                       $where.=" and cm.type_id='$value' ";
                   }
               }
               if($key=='sj'){
                   if($value!=0){
                       $from_channel =$this->sj[$value];
                       $where .=" and cw.from_channel='$from_channel' ";
                   }
               }
               if($key=='model_id'){
                   $where .=" and cm.model_id=$value";
               }
               if($key=='brand_id'){
                   $where .=" and cm.brand_id=$value";
               }
               if($key=='series_id'){
                   $where .=" and cm.series_id=$value";
               }
           }
       }
       //echo $where;
       $this->where =$where;
       $this->group ="";
       $this->order =array();
       $result = $this->joinTable(3);
       return $result;
     }
   /**
    * 条件搜索
    * @param type $a
    * @return type
    */
    
   function getSearchList($a=array(),$page_size,$page){
       $page_state =($page-1)*$page_size;
       $this->tables = array(
            'cardb_model' => 'cm',
            'cardb_websaleinfo' => 'cw',
            'cardb_brand'=>'cb'
        );
       $timestamp = time();
       $this->fields ="cm.model_id,cm.series_id,cm.model_price,cm.model_name,cm.brand_name,cm.type_name,cm.model_pic1,cm.model_pic2,cm.series_name,cb.brand_logo,cw.*";
       $where ="cw.model_id=cm.model_id and cm.brand_id=cb.brand_id and  cm.state in(3,8)";
       $this->order =array("cm.brand_id"=>"asc","cw.model_id"=>"asc");
       if($a){
           foreach($a as $key=>$value){
            //   echo $key.'-'.$value."<br>";
               if($key=='pr'){
                   $pr_a =$this->pr[$value];
                   
                   if($pr_a['low']==-1){ 
                   }elseif($pr_a['high']==0){
                       $where .=" and cm.model_price>$pr_a[low] ";
                   }else{
                       $where .=" and cm.model_price>$pr_a[low] and cm.model_price<$pr_a[high] ";
                   }
               }
               if($key=='ct'){
                   if($value!=0){
                      // $type_name =$this->ct[$value];
                       $where.=" and cm.type_id='$value' ";
                   }
               }
               if($key=='sj'){
                   if($value!=0){
                       $from_channel =$this->sj[$value];
                       $where .=" and cw.from_channel='$from_channel' ";
                   }
               }
               if($key=='model_id'){
                   $where .=" and cm.model_id=$value";
               }
               if($key=='brand_id'){
                   $where .=" and cm.brand_id=$value";
               }
               if($key=='series_id'){
                   $where .=" and cm.series_id=$value";
               }
           }
       }
       //echo $where;
       $this->where =$where;
       $this->group ="";
       $this->offset =$page_state;
       $this->limit =$page_size;
       $result = $this->joinTable(2);
     // echo $this->sql;
       if($result){
           foreach($result as $key=>&$value){
			$result[$key]['timestamp'] = ($value[discount_end_date]>0?$value[discount_end_date]:$value['offline_end_date'])>strtotime(date('Y-m-d')) ? 0 : 1;
               
           if($value[buy_discount_price]!=0){
               $result[$key]['buy_discount_rate']=$value['model_price'] - $value['buy_discount_price'];
           }else if($value['buy_discount_rate']!=0){
               
               $result[$key]['buy_discount_price']=$value['model_price'] - $value['buy_discount_rate'];
           }
           if($value['model_price']!=0){
                   $zk=round(($value['buy_discount_price']/$value['model_price'])*10, 2);
                   if($zk==0){
                       $result[$key]['zk']=15;
                   }else{
                        $result[$key]['zk']=$zk;
                   }

           }else{
               $result[$key]['zk']='16';
           }
           if($value['buy_discount_rate']>=1){
                $result[$key]['buy_discount_rate'] ="直降<br/>".$this->del0($value['buy_discount_rate']).'万';
           }elseif($value['buy_discount_rate']>=0&&$value['buy_discount_rate']<1){
                $result[$key]['buy_discount_rate'] ="直降<br/>".round($value['buy_discount_rate']*10000) .'元';
           }elseif($value['buy_discount_rate']>-1&&$value['buy_discount_rate']<0){
               $result[$key]['buy_discount_rate'] ="加价<br/>".abs(round($value['buy_discount_rate']*10000)).'元';
           }else{
               
               $result[$key]['buy_discount_rate'] ="加价<br/>".abs($this->del0($value['buy_discount_rate'])).'万';
           }
          
           
        
          }
       }
       
       return $result;
   }
   
   
   /**
    * 价格pk
    */
   function getPkModelList($model_id){
       $this->pricelog = new pricelog();
       $price = $this->pricelog->getList11ModelId($model_id);
       $this->tables = array(
            'cardb_model' => 'cm',
            'cardb_websaleinfo' => 'cw',
            'cardb_brand'=>'cb'
        );
       $timestamp = time();
       $this->fields ="cm.model_id,cm.series_id,cm.model_price,cm.model_name,cm.brand_name,cm.type_name,cm.model_pic1,cm.model_pic2,cm.series_name,cb.brand_logo,cw.*";
       $this->where ="cw.model_id=cm.model_id and cm.brand_id=cb.brand_id and cw.model_id=$model_id and cm.state in(3,8) ";
       $this->group  ="cw.from_channel";
    
       $arr = $this->joinTable(2);
     // echo $this->sql;
       foreach($arr as $key=>$value){
           $arr[$key]['timestamp'] = ($value[discount_end_date]>0?$value[discount_end_date]:$value['offline_end_date'])>strtotime(date('Y-m-d')) ? 0 : 1;
           if($value[buy_discount_price]!=0){
               $arr[$key]['buy_discount_rate']=$value['model_price'] - $value['buy_discount_price'];
           }else if($value['buy_discount_rate']!=0){
               
               $arr[$key]['buy_discount_price']=$value['model_price'] - $value['buy_discount_rate'];
           }
           
           $channel[$key] =$value['from_channel'];

       }
       $price['model_pic1'] = $arr[0]['model_pic1'];
       $price['model_pic2'] = $arr[0]['model_pic2'];
       $price['model_name'] = $arr[0]['model_name'];
       $price['series_name'] = $arr[0]['series_name'];
       $price['brand_name'] = $arr[0]['brand_name'];
       $price['brand_logo'] = $arr[0]['brand_logo'];
       $price['model_name'] = $arr[0]['model_name'];
       $price['model_price'] = $arr[0]['model_price'];
       $price['youhui'] = $arr[0]['model_price'] - $price['price'];
       
       $result['price'] =$price;
       $result['web'] =$arr;
       $result['channel'] =$channel;
      
       return $result;
   }
   
   
   /**
    * 处理如果排序
    * @param type $content  array Description
    * @param type $by Description
    * @param type $sort string
    * @return type  $returnt Description
    */
   function getSearchSortList($content,$by,$sort){
       foreach($content as $key=>$value){
           $bysort =$this->sort[$by];
           $byname[$key] =$value[$bysort];
       }
       //var_dump($byname);
       if($sort=='asc'){
           @array_multisort($byname, SORT_ASC, $content);
       }else{
           @array_multisort($byname, SORT_DESC, $content);
       }
       
       
       return $content;
   }
   /**
    * 根据条件查询
    */
   function getWebInfoList($fields,$where,$flag){
        $this->where = $where;
        $this->fields = $fields;
        $result = $this->getResult($flag);
        return $result;
    }
    
    function getByModelId($model_id){
        $this->fields ="*";
        $timestamp = time();
        $this->where ="model_id=$model_id";
        $this->order =array();
        $this->group ="from_channel";
        $result = $this->getresult(2);

        return $result;
    }
    
    function getBrandList(){
        global $_cache;
        $brand_11 = "brand_11";
        $series_11 = "series_11";
        $models_11 = "models_11";
        $result_brand = $_cache->getCache($brand_11);
        $result_series = $_cache->getCache($series_11);
        $result_models = $_cache->getCache($models_11);
        
        $this->tables = array(
            'cardb_model' => 'cm',
            'cardb_websaleinfo' => 'cw',
            'cardb_brand'=>'cb'
        );
        $timestamp = time();
        if(!$result_brand||!$result_series||!$result_models){
               $this->fields = 'cm.model_id,cm.series_id,cm.brand_id,cm.model_name,cm.series_name,cm.brand_name,cw.model_id,cw.model_name,cb.letter';
                $this->where = "cm.model_id = cw.model_id AND cb.brand_id=cm.brand_id and cm.state in (3, 7, 8)";
                $this->order =array("cb.letter"=>"asc");
                $this->group = 'cw.model_id';
                $modellist = $this->joinTable(2);
                $brands =$series= $series_a= $models_a =$models =array();
              //  var_dump($modellist);
                foreach($modellist as $key=>$value){
                    
                    if(!array_key_exists($value[brand_id],$brands)){
                         
                         $brands[$value[brand_id]][brand_id] = $value[brand_id];
                         $brands[$value[brand_id]][brand_name] =$value[brand_name];
                         $brands[$value[brand_id]][letter] = $value[letter];
                    }
                    
                    if(!array_key_exists($value[series_id],$series_a)){
                         $series_a[$value[series_id]] = $value[series_id];
                         $series[$value[brand_id]][$value[series_id]][series_id] = $value[series_id];
                         $series[$value[brand_id]][$value[series_id]][series_name] =$value[series_name];
                    }

                    if(!array_key_exists($value[model_id],$models_a)){
                         $models_a[$value[model_id]] = $value[model_id];
                         $models[$value[series_id]][$value[model_id]][model_id] = $value[model_id];
                         $models[$value[series_id]][$value[model_id]][model_name] =$value[model_name];
                    }

               }
               $_cache->writeCache($brand_11, $brands, 24*3600); 
               $_cache->writeCache($series_11, $series, 24*3600); 
               $_cache->writeCache($models_11, $models, 24*3600); 
        }
       
        
    }
	#双11价格
	function getNov11($model_id){
		if(empty($model_id)){
			return false;
		}
		$timestamp = strtotime(date('Y-m-d'));
		$websaleinfo = $this->getAllWebsaleinfoAndModel('cw.*,IF(cw.discount_end_date>0,cw.discount_end_date,cw.offline_end_date) AS valid_date,cm.model_price',"cw.model_id=cm.model_id and cm.state in (3,8) and cw.model_id=$model_id and IF(cw.discount_end_date>0,cw.discount_end_date,cw.offline_end_date)>$timestamp",'valid_date');
		$nov11Price = '';
		if($websaleinfo){
			foreach($websaleinfo as $wsk=>$wsv){
				$nov11Price = getNov11Price($wsv['nude_car_price'],$wsv['buy_discount_price'],$wsv['nude_car_rate'],$wsv['buy_discount_rate'],$wsv['model_price']);
				if(empty($nov11Price)){
					unset($websaleinfo[$wsk]);
				}else{
					if($websaleinfo[$wsk]['from_channel']=='汽车之家'){
						$websaleinfo[$wsk]['info_pic'] = '/images/sq_ad.jpg';
						$websaleinfo[$wsk]['info_index'] = 'http://1111.autohome.com.cn';
						//$websaleinfo[$wsk]['info_rule'] = 'http://1111.autohome.com.cn/rule/index.htm';
					}else if($websaleinfo[$wsk]['from_channel']=='易车网'){
						if($websaleinfo[$wsk]['activity_property']=='易车惠特卖场'){
							$websaleinfo[$wsk]['info_pic'] = '/images/sq_ad3.jpg';	
						}else{
							$websaleinfo[$wsk]['info_pic'] = '/images/sq_ycw.jpg';
						}
						$websaleinfo[$wsk]['info_index'] = 'http://mai.bitauto.com/beijing/';
						//$websaleinfo[$wsk]['info_rule'] = 'http://mai.bitauto.com/help/shengming.shtml';
					}else if($websaleinfo[$wsk]['from_channel']=='搜狐汽车'){
						$websaleinfo[$wsk]['info_pic'] = '/images/sq_ad5.jpg';
						$websaleinfo[$wsk]['info_index'] = 'http://auto.sohu.com/auto1111/index.shtml';
						//$websaleinfo[$wsk]['info_rule'] = 'http://auto.sohu.com/20131101/n389407135.shtml';
					}else if($websaleinfo[$wsk]['from_channel']=='天猫'){
						$websaleinfo[$wsk]['info_pic'] = '/images/sq_ad4.jpg';
						$websaleinfo[$wsk]['info_index'] = 'http://che.tmall.com';
						//$websaleinfo[$wsk]['info_rule'] = 'http://www.tmall.com/go/act/sale/rules11.php';
					}else if($websaleinfo[$wsk]['from_channel']=='车多少'){
						$websaleinfo[$wsk]['info_pic'] = '/images/sq_ad2.jpg';
						$websaleinfo[$wsk]['info_index'] = 'http://www.cheduoshao.com/youhui/';
						//$websaleinfo[$wsk]['info_rule'] = 'http://www.cheduoshao.com/youhui/about/';
					}
					$websaleinfo[$wsk]['info_rule'] = $wsv['source_url'];
					$websaleinfo[$wsk]['lottery_title'] = trim($websaleinfo[$wsk]['lottery_title1'].','. $websaleinfo[$wsk]['lottery_title2'].','.$websaleinfo[$wsk]['lottery_title3'],',');
					$websaleinfo[$wsk]['lottery_title'] = $websaleinfo[$wsk]['lottery_title'] ? $websaleinfo[$wsk]['lottery_title'] : '无抽奖奖品';
					$websaleinfo[$wsk]['limit_title'] = trim($websaleinfo[$wsk]['limit_title1'].','. $websaleinfo[$wsk]['limit_title2'].','.$websaleinfo[$wsk]['limit_title3'].','.$websaleinfo[$wsk]['limit_title4'],',');
					$websaleinfo[$wsk]['limit_title'] = $websaleinfo[$wsk]['limit_title'] ? $websaleinfo[$wsk]['limit_title'] : '无限量礼';
					$websaleinfo[$wsk]['gift_title'] = trim($websaleinfo[$wsk]['gift_title1'].','. $websaleinfo[$wsk]['gift_title2'].','.$websaleinfo[$wsk]['gift_title3'].','.$websaleinfo[$wsk]['gift_title4'],',');
					$websaleinfo[$wsk]['gift_title'] = $websaleinfo[$wsk]['gift_title'] ? $websaleinfo[$wsk]['gift_title'] : '无赠品';
					$websaleinfo[$wsk]['nov11_price'] = $nov11Price;
					$websaleinfo[$wsk]['nov11_price_rate'] = $websaleinfo[$wsk]['model_price']-$nov11Price;
					$websaleinfo[$wsk]['dealer_num'] = ($websaleinfo[$wsk]['dealer_name']=='多家') ? "北京多家<a href='{$websaleinfo[$wsk]['source_url']}'>查看详细</a>" : ($websaleinfo[$wsk]['dealer_name']=='付订金后短信告知' ? '付订金后短信告知
' : 'single_dealer');
				}
			}
		}
		return $websaleinfo;
	}
	
	function getAllWebsaleinfoAndModel($fields,$where,$order,$flag=2){
		$this->tables = array(
			'cardb_websaleinfo' => 'cw',
			'cardb_model' => 'cm'
		);
		$this->fields = $fields;
		$this->where = $where;
		$this->order = array($order=>'desc');
		return $this->joinTable($flag);
	}
    
        //去掉价格最后的0
        function del0($s) {
            $s = trim(strval($s));
            if (preg_match('#^-?\d+?\.0+$#', $s)) {
                return preg_replace('#^(-?\d+?)\.0+$#', '$1', $s);
            }
            if (preg_match('#^-?\d+?\.[0-9]+?0+$#', $s)) {
                return preg_replace('#^(-?\d+\.[0-9]+?)0+$#', '$1', $s);
            }
            return $s;
        }
}
?>
