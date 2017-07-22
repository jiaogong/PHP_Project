<?php
  /**
  * cardb_type
  * $Id: cardbpricelog.php 4554 2013-12-30 08:16:40Z yizhangdong $
  */
  
  class cardbPriceLog extends model{
    function __construct(){
        parent::__construct();
        $this->table_name = "cardb_pricelog";
        $this->realdata = new realdata();
        $this->oldcarval = new oldCarVal();        
    }    
    function getBingoPriceInfo($mid, $logId, $priceType) {
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
        $this->where = "cp.model_id = $mid AND cp.id = $logId AND di.state <> 1";
        $row = $this->leftJoin();
        if(empty($row)) {
            $this->tables = array(
                'cardb_model' => 'cm',
                'cardb_pricelog' => 'cp'
            );
            $this->fields = 'cp.dealer_name, cp.dealer_addr as dealer_area, cp.saler, cp.saler_tel, cp.get_time, cp.id as pricelog_id, cm.st36, cm.st27, cm.st28, cm.date_id, cm.series_id, cm.st41, cm.st48';
            $this->where = "cm.model_id = cp.model_id AND cp.model_id = $mid AND cp.id = $logId";
            $row = $this->joinTable();
        }        
        if(!empty($row)) {
            //置换补贴
            $row['car_prize'] = $this->oldcarval->getOldCarList("car_prize", "model_id='{$mid}'  and start_date<$timestamp and end_date>$timestamp", 3);
            $row['jnbt'] = $this->realdata->getContryBt($row);
            $pics = explode('|', $row['dealer_pic']);
            $row['dealer_pic'] = $pics[0] ? $pics[0] : 'images/offerrs_dealer.jpg';
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
            if($row['get_time']) $row['get_time'] = '获取时间：'.date('Y-m-d', $row['get_time']);
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
  }
?>
