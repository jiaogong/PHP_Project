<?php
  /**
  * brand
  * $Id: seriestype.php 1789 2016-03-24 08:39:22Z wangchangjiang $
  */
  
  class seriestype extends model{
    var $series_type = array(
      1 => '家用舒适',
      2 => '个性运动',
      3 => '商务行政',
      4 => 'SUV/MPV',
    );
    function __construct(){
      parent::__construct();
      $this->table_name = "cardb_series_type";
    }

    function getseriesTypelist($fields,$where,$flag){
        $this->fields = $fields;
        $this->where = $where;
        return $this->getResult($flag);
    }
     /**
         * 车系类型导出
         * @return type
         */
        function getSeriesType($where){
            $this->tables = array(
                'cardb_series_type' => 'cst',
                'cardb_series' => 'cs',
                );
            $this->fields = 'cs.series_id,cst.type1,cst.type2,cst.type3,cst.type4,cst.type5,cs.brand_name,cs.series_name,cs.factory_name,cs.series_alias';
            $this->where = $where;
            $this->join_condition =array("cs.series_id=cst.series_id");
            $res = $this->leftJoin(2);
            return $res;
    }
    function getNewOffers($seriesType) {
        global $_cache, $timestamp;
        $lastTimestamp = $timestamp - 24 * 3600 * 90;
        $this->tables = array(
            'cardb_series' => 'cs',
            'cardb_pricelog' => 'cp',
            'cardb_model' => 'cm',
            'cardb_series_type' => 'ct'
        );
        $this->fields = 'cs.series_id, cs.series_alias, cs.series_alias as alias, cp.id as price_id, cp.id, cp.price, cm.model_pic1 as model_pic, cm.model_name, cm.model_price, cm.model_id';
        $this->order = array('cp.created' => 'DESC');
        $this->group = 'cs.series_id';
        $this->limit = 6;
        $q = $j = 1;
        $ret = array();
        foreach($seriesType as $k => $v) {
            $sid = array();
            $oldSid = $_cache->getCache('ssi_newindex_sid'.$k);        
            $oldTime = $_cache->getCache('ssi_newindex_time'.$k);            
            if(!$oldSid || $timestamp - $oldTime > 3600) $oldSid = array();            
            $this->where = "cp.series_id = cs.series_id AND cp.series_id = ct.series_id AND cp.model_id = cm.model_id AND cm.state in (3, 7, 8) AND cp.price_type = 0 AND (ct.type1 = $k or ct.type2 = $k or ct.type3 = $k or ct.type4 = $k) AND cs.series_alias<>'' and cs.series_alias is not null";// AND cp.get_time > $lastTimestamp
            if(!empty($oldSid)) {
                $sidStr = implode(',', $oldSid);
                switch ($k){
                   case 2;
                        $sid1 = session('sid1');
                        $sidStr .= empty($sid1) ? "" : "," . implode(",", $sid1);
                       break;
                   case 3;
                        $sid1 = session('sid1');
                    $sid2 = session('sid2');
                    $sidStr .= empty($sid1) ? "" : "," . implode(",", $sid1);
                    $sidStr .= empty($sid2) ? "" : "," . implode(",", $sid2);
                       break;
                   case 4;
                       $sid1 = session('sid1');
                    $sid2 = session('sid2');
                    $sid3 = session('sid3');
                    $sidStr .= empty($sid1) ? "" : "," . implode(",", $sid1);
                    $sidStr .= empty($sid2) ? "" : "," . implode(",", $sid2);
                    $sidStr .= empty($sid3) ? "" : "," . implode(",", $sid3);
                       break;
                }
               
                $this->where .= " AND cs.series_id not in ($sidStr)";
            }
            
            $result = $this->joinTable(2);      
            $this->errorMsg(1);
            if(count($result)<6) {
                $this->where = "cp.series_id = cs.series_id AND cp.series_id = ct.series_id AND cp.model_id = cm.model_id AND cm.state in (3, 7, 8) AND cp.price_type = 0 AND (ct.type1 = $k or ct.type2 = $k or ct.type3 = $k or ct.type4 = $k) AND cs.series_alias<>'' and cs.series_alias is not null";// AND cp.get_time > $lastTimestamp
                $result = $this->joinTable(2);   
                $oldSid = array();
            }
            //echo $this->sql;exit;
            if(!empty($result)) {
                for($i=0; $i<6; $i++) {
                    if(!in_array($result[$i]['series_id'], $sid) && $result[$i]['series_id']) $sid[] = $result[$i]['series_id'];                    
                    $ret['article'][$q]['alias'] = $result[$i]['alias'];
                    $ret['article'][$q]['price_id'] = $result[$i]['price_id'];
                    $ret['article'][$q]['model_id'] = $result[$i]['model_id'];
                    if($i > 2) {                        
                        if($result[$i]) $ret['series'][$j] = $result[$i];
                        $j++;
                    }                    
                    $q++;
                }
            }
            session('sid'.$k, $sid);
            $_cache->writeCache('ssi_newindex_sid'.$k, array_merge($sid, $oldSid), 3600);
            $_cache->writeCache('ssi_newindex_time'.$k, $timestamp, 3600);
        }
        return $ret;
    }
    
  }
?>
