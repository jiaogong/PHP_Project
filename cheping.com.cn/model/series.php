<?php

/**
 * series
 * $Id: series.php 2691 2016-05-16 10:03:07Z cuiyuanxin $
 */
class series extends model {

    var $score_list = array(
        '性能',
        '质量',
        '安全性',
        '配置',
        '设计',
        '平均分',
    );
    var $thumb_size = array(
        '180x100',
        '140x80',
        '130x73',
    );
    var $st4_list = array(
        1 => 'MPV',
        2 => 'SUV',
        3 => '两厢车',
        4 => '旅行车',
        5 => 'coupe', /* '跑车', */
        6 => '软顶敞篷车',
        7 => '三厢车',
        8 => '掀背车',
        9 => '硬顶敞篷车',
        10 => '硬顶跑车',
        11 => '敞篷车',
        11 => '客车',
    );
    var $st21_list = array(
        1 => 2,
        2 => 3,
        3 => 4,
        4 => 5
    );

    function __construct() {
        parent::__construct();
        $this->table_name = "cardb_series";
    }

    function updateSeries($ufields, $series_id) {
        $this->ufields = $ufields;
        $this->where = "series_id = $series_id";
        $this->update();
    }

//根据条件查询数据
//    function getSeriesdata($fields, $where = 1, $type = 2) {
//        $this->fields = $fields;
//        $this->where = $where;
//        return $this->getResult($type);
//    }


    function getSeriesdata($fields, $where = 1, $type = 2, $order = array()) {
        $this->group = "";
        $this->order = $order;
        $this->fields = $fields;
        $this->where = $where;
        return $this->getResult($type);
    }

    /**
     * jquery autocomplete    搜索的自动填充功能
     * @param type $keyword  搜索关键字
     * @return type $return array  搜索结果
     */
    function getAutocomplete($keyword) {
        $this->fields = "distinct brand_name";
        $this->order = array('brand_name' => 'asc');
        $this->where = "state=3 and brand_name like '%$keyword%'";
        $ret = $this->getResult(2);

        if ($ret) {
            foreach ($ret as $key => $value) {
                $this->fields = "distinct series_name";
                $this->order = array('brand_name' => 'asc', 'series_name' => 'asc');
                $this->limit = 9;
                $this->where = "state=3 and brand_name='$value[brand_name]'";
                $resultArr[$value[brand_name]] = $this->getResult(2);
            }

            foreach ($resultArr as $kk => $vv) {
                $result[]['series_name'] = $kk;
                if ($vv) {
                    foreach ($vv as $K => $v) {
                        if ($v[series_name]) {
                            $a = strpos($v[series_name], $keyword);
                            if ($a !== false) {
                                $result[] = $v;
                            }
                        }
                    }
//                      foreach($vv as $K=>$v){                    
//                         $a = strpos($v[series_name],$keyword);
//                         if($a===false){
//                             $result[] = $v;
//                         }             
//                     }
                }
            }
            return array_slice($result, 0, 10);
        } else {
            $this->fields = "series_name,count(distinct series_name)";
            $this->limit = 10;
            $this->group = "series_name";
            $this->order = array('series_name' => 'asc');
            $this->where = "state=3 and  series_name='$keyword' or keyword like '%$keyword%'";
            $result = $this->getResult(2);
            if ($result) {
                return array_slice($result, 0, 10);
            }
        }
    }

    function chkSeries($fields, $where, $order = '', $flag = 2, $limit = 1) {
        $this->fields = $fields;
        $this->where = $where;
        $this->order = $order;
        $this->limit = $limit;
        $result = $this->getResult($flag);
        return $result;
    }

    function getAllSeries($where = '1', $order = array(), $limit = 1, $offset = 0) {
        $this->tables = array(
            'cardb_brand' => 'b',
            'cardb_factory' => 'f',
            'cardb_series' => 's',
        );

        $this->where = $where;
        $this->fields = "count(s.series_id)";
        $this->total = $this->joinTable(3);

        $this->fields = "s.series_id as id, s.series_id, s.series_name, s.series_alias, s.state, f.factory_id,f.factory_name,
      f.state as fs,b.brand_name,b.brand_id,b.state as bs,s.cons,s.pros,s.series_intro,s.score,s.series_pic,
      s.price_low,s.price_high,s.keyword,s.last_picid,s.type_id,s.type_name,s.src_id";
        $this->limit = $limit;
        $this->offset = $offset;
        if (!empty($order))
            $this->order = $order;

        return $this->joinTable(2);
    }

    function getAllSeriess($allow_cache = true) {
        global $_cache;
        $cache_key = "series";
        if ($allow_cache) {
            $cache_time = 24 * 3600;
            $series_list = $_cache->getCache($cache_key);
            if (!$series_list) {
                $this->where = "state=3";
                $this->fields = "series_id,series_name,brand_id,brand_name,factory_id,factory_name,type_id,sale_value,
          type_name,dealer_price_low,dealer_price_high,bingo_price_low,series_pic,price_low,score,series_intro,s1,s2,s3,s4, default_model, offical_url";
                $series_list = $this->getResult(2);
                $_cache->writeCache($cache_key, $series_list, $cache_time);
            }
        } else {
            $this->where = "state=3";
            $this->fields = "series_id,series_name,brand_id,brand_name,factory_id,factory_name,type_id,sale_value,
        type_name,dealer_price_low,dealer_price_high,bingo_price_low,series_pic,price_low,score,series_intro,s1,s2,s3,s4, default_model, offical_url";
            $series_list = $this->getResult(2);
        }
        return $series_list;
    }

    /**
     * 获取厂商与车系对应关系
     */
    function getFactorySeries() {
        $this->fields = 'factory_id, series_id, series_name';
        $this->where = 'state = 3';
        $result = $this->getResult(2);
        $fsArr = array();
        if (!empty($result)) {
            foreach ($result as $k => $v) {
                $fid = $v['factory_id'];
                $v['series_name'] = iconv('gbk', 'utf-8', $v['series_name']);
                $fsArr[$fid][] = $v;
            }
        }
        return $fsArr;
    }

    //===============================================================================
    function getSeries($id) {
        $this->fields = "*";
        $this->where = "series_id='{$id}'";
        return $this->getResult();
    }

    /**
     * 
     * @param type $fields   指段
     * @param type $id       
     * @return type
     */
    function getSeriesFields($fields, $where, $id) {
        $this->fields = $fields;
        $this->where = $where;
        return $this->getResult(2);
    }

    //根据名字查询id
    function getSearchSeriesName($series_name) {
        $this->where = "series_name = '$series_name'";
        $this->fields = "series_id";
        $result = $this->getResult(3);
        return $result;
    }

//    function getSerieslist() {
//        $this->fields = "series_id,series_name,brand_id";
//        $this->where = " 1 and state=3";
//        return $this->getResult(2);
//    }
    function getSeriesList($fields, $where, $flag) {
        $this->where = $where;
        $this->fields = $fields;
        $result = $this->getResult($flag);
        return $result;
    }
    
    /**
     * 返回未上市车系
     * @param string $order 排序字段
     * @param string $orderby 排序方式 asc/desc
     * @param int $limit 返回数组条数
     * 
     * @return array $ret
     */
    function getUnsaleSeries($orderby = 'asc', $limit = 10) {
        $this->where = "state=11";
        $this->fields = "*";
        $series = $this->getResult(2);

        $ret = $tmp = array();
        foreach ($series as $k => $v) {
            $v['sale_date'] = str_replace('年', '/', $v['sale_date']);
            $v['sale_date'] = str_replace('月', '/1', $v['sale_date']);
            $v['sale_date'] = str_replace('上半年', '6/1', $v['sale_date']);
            $v['sale_date'] = str_replace('下半年', '12/1', $v['sale_date']);

            $v['sale_date'] = str_replace(array('一', '二', '三', '四', '五', '六', '七', '八', '九', '十'), array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10'), $v['sale_date']);
            $v['sale_date'] = str_replace('1季度', '3/1', $v['sale_date']);
            $v['sale_date'] = str_replace('2季度', '6/1', $v['sale_date']);
            $v['sale_date'] = str_replace('2季度', '9/1', $v['sale_date']);
            $v['sale_date'] = str_replace('2季度', '12/1', $v['sale_date']);

            $int = strtotime($v['sale_date']);
            $tmp[$k] = $int;
        }

        switch (strtolower($orderby)) {
            case 'asc':
                array_multisort($tmp, SORT_ASC, $series);
                break;
            default:
                array_multisort($tmp, SORT_DESC, $series);
        }

        if (count($series) > $limit) {
            return array_slice($series, 0, $limit);
        } else {
            return $series;
        }
    }

    /*
     * 两辆车专家评分都大于等于8.0分；
     * 两辆车不是同一级别（豪华，中大，紧凑，suv等）
     *  两车不在同一品牌
     */

    function getRandseries() {
        //取出有实拍图的车系
        $this->fields = "*";
        $this->where = " 1 and last_picid<>'0' and price_low<>'0' and price_high<>'0' and score<>'' and series_pic2<>'' ";
        $series = $this->getResult(2);

        $total = count($series);
        $istrue = true;
        $newseries = array();
        $i = 1;
        $oldtype = "";
        $oldbrand = "";
        $oldseries = "";
        if ($total <= 5) {
            foreach ($series as $v => $k) {
                $newseries[$v] = $k;
            }
        } else {
//            $scoremax=array();
//            $scoremin=array();
            while ($istrue) {
                $randnum = rand(0, $total - 1);
                $randnumarr = array();
//                $score=explode("||", $series[$randnum]["score"]);
//                $sumscore=0;
//                foreach ($score as $key => $value) {
//                    $sumscore+=$value;
//                }
//                $avg=floatval($sumscore/count($score));
//                if($avg>8||$avg==8){
//                    if($oldtype!=$series[$randnum]["type_id"]&&$oldbrand!=$series[$randnum]["brand_id"]&&$oldseries!=$series[$randnum]["series_id"]){
//                        if($i<6 && $i <= $total){
//                            $oldtype=$series[$randnum]["type_id"];
//                            $oldbrand=$series[$randnum]["brand_id"];
//                            $oldseries=$series[$randnum]["series_id"];
//                            $newseries[$i]=$series[$randnum];
//                            ++$i;
//                        }
//                    }
//                    $scoremax[$randnum]=$randnum;
//                }else{
//                    $scoremin[$randnum]=$randnum;
//                }
                if (empty($randnumarr[$randnum])) {
                    $newseries[$i] = $series[$randnum];
                    $randnumarr[$randnum] = $randnum;
                    $i++;
                }
                if ($i > $total || $i == 6)
                    break;
            }
        }
        //循环处理两条符合条件的车系
        $ret = array();
        $pd_obj = new pageData();
        $model_obj = new cardbModel();
        foreach ($newseries as $key => $value) {
            $ts = array();
            $title = $value["series_name"];
            $series_id = $value["series_id"];
            $ts['series'] = $value;
            $ts['title'] = $title;
            #取车款
            #$ts['model'] = $model = $model_obj->getLastModelBySid($series_id);
            $ts['pic'] = "attach/images/series/" . $value["series_id"] . "/" . $value["series_pic"];

            #取车系评论
            $comment_obj = new comment();
            $ts['total'] = $total = $comment_obj->getCommentUidCount($series_id);

            #用户评分
            $comm_avg = new commentAvg();
            $avg = $comm_avg->getAvgScore('series', $series_id);
            $ts['avg'] = $avg;
            $ret[] = $ts;
        }

        $s = $pd_obj->addPageData(array(
            'name' => 'hotcarseries',
            'value' => $ret,
            'c1' => 'hotcarseries',
            'c2' => 1,
            'c3' => 0
        ));
    }

    function getScoreStr($score) {
        $ret = '';
        $tmp = explode('||', $score);
        foreach ($tmp as $k => $v) {
            $ret .= $this->score_list[$k] . ":" . $v . ",";
        }
        return substr($ret, 0, -1);
    }

    function getSeriesByName($name, $name2 = '') {
        $this->where = "series_name like '%{$name}%'";
        if ($name2) {
            $this->where .= " or series_name like '%{$name2}%'";
        }
        $this->fields = "*";
        return $this->getResult();
    }

    function getDatabyState($state) {
        $this->fields = "count(*) as sum";
        $this->where = "1 and state='$state'";
        return $this->getResult(3);
    }

    function upDataState($state, $id) {
        //修改车系状态
        $this->ufields = array('state' => $state);
        $this->where = "series_id='" . intval($id) . "'";
        $this->update();
        //修改车款状态
        $m = new cardbModel();
        $m->ufields = array('state' => $state);
        ;
        $m->where = $this->where;
        $m->update();
        return 1;
    }

    function getData($where, $type = 2) {
        $this->fields = "series_id as id,brand_id,brand_name,factory_id,factory_name,series_name,series_pic,series_pic2,price_low,price_high,dealer_price_low,dealer_price_high";
        $this->where = $where;
        return $this->getResult($type);
    }

    function getPic($where) {
        $this->tables = array(
            'cardb_brand' => 'b',
            'cardb_factory' => 'f',
            'cardb_series' => 's',
        );

        $this->where = $where;
        $this->fields = "count(s.series_id)";
        return $this->joinTable(3);
    }

    function getModelname($model_name) {
        $temparr = explode(" ", $model_name);
        unset($temparr[0]);
        $new_name = implode(" ", $temparr);
        return $new_name;
    }

    //获取所有车辆名称，ID
    function getSeriesColor($where = '1', $order = array(), $limit = 1, $offset = 0) {
        $this->where = $where;
        $this->fields = "count(series_id)";
        $this->total = $this->getResult(3);
        $this->fields = "*";
        $this->where = $where;
        $this->limit = $limit;
        $this->offset = $offset;
        return $this->getResult(2);
    }

    /**
     * 在车系表里更新默认的车款id
     * @param $ufields array 更新的字段
     * @param $where string 条件
     */
    function uDefaultModelId($ufields, $where) {
        $this->ufields = $ufields;
        $this->where = $where;
        $this->update();
    }

    /**
     * 首页随机取图
     * @return type
     */
    function getNewColorPic($str) {
        $this->tables = array(
            'cardb_file' => 'cf',
            'cardb_model' => 'cm',);
        $this->fields = 'cf.*,cm.model_name,cm.series_name,cm.factory_name';
        $this->where = "cm.model_id in($str) and cf.type_name='model' and cf.type_id=cm.model_id and pos =1 and cf.ppos=1 and cf.name!=''";
        $res = $this->joinTable(2);
        return $res;
    }

    /**
     * 获取车系类型
     * @return type
     */
    function getSeriesType($where) {
        $this->tables = array(
            'cardb_series' => 'cs',
            'cardb_series_type' => 'cst');
        $this->fields = 'cs.series_id,cst.type1,cst.type2,cst.type3,cst.type4,cst.type5,cs.brand_name,cs.series_name,cs.factory_name';
        $this->where = $where;
        $this->join_condition = array("cs.series_id=cst.series_id");
        $res = $this->leftJoin(2);
        return $res;
    }

    /**
     * 根据厂商id取有暗访价的车系
     */
    function getSeriesPrice($fid) {
        $this->tables = array(
            'cardb_series' => 'cs',
            'cardb_price' => 'cp'
        );
        $this->fields = 'cs.*';
        $this->where = "cs.factory_id=$fid and cs.state=3 and cs.series_id=cp.series_id and cp.price_type=0";
        $this->group = 'series_id';
        $res = $this->joinTable(2);
        return $res;
    }

    /**
     * 贷款分类信息查询
     */
    function getSeriesLoan($fields, $where, $order, $flag) {
        $this->table_name = "cardb_series cs";
        $this->tables = array("cardb_series_loan" => "csl");
        $this->join_condition = array("cs.series_id=csl.series_id");
        $this->fields = $fields;
        if ($where) {
            $this->where = $where;
        }

        if ($order) {
            $this->order = $order;
        }
        $result = $this->leftJoin($flag);
        return $result;
    }

    function getSeriesmodelsCache($series_id, $order = array(), $cache_key = "", $type = 2, $pic_size = "180x100", $apendwhere = "") {
        global $_cache;
        if ($cache_key) {
            $cache_time = 86400;
            $result = $_cache->getCache($cache_key);
            if (!$result) {
                $result = $this->getSeriesmodels("series", $series_id, null, $order, $type, $pic_size, $apendwhere);
                $_cache->writeCache($cache_key, $result, $cache_time);
            }
        } else {
            $result = $this->getSeriesmodels("series", $series_id, null, $order, $type, $pic_size, $apendwhere);
        }
        return $result;
    }

    function getSeriesmodels($bytype = "series", $id, $date_id = null, $order = array(), $type = 2, $pic_size = "180x100", $apendwhere = "",$state = 'cm.state in (3, 8, 9)') {
        $this->reset();
        if ($bytype == "model") {
            $this->where = " cm.model_id='$id' ";
        } else {
            $this->where = " cs.series_id='$id' ";
        }
        if ($date_id) {
            $this->where .= " and cm.date_id='$date_id' ";
        }
        $this->where .= " and {$state} and cs.series_id=cm.series_id " . $apendwhere;
        $this->fields = "cm.*,cs.price_low,cs.price_high,cs.series_pic,cs.price_low,cs.last_picid,cs.series_pic, IF(cm.bingo_price>0, cm.bingo_price, cm.dealer_price_low) as bingobang_price";
        $this->order = $order;
        $this->tables = array("cardb_series" => "cs", "cardb_model" => "cm");
        $result = $this->joinTable($type);
        if ($bytype == "model") {
            /* if(!empty($result["model_pic1"])){
              $result["firstpic"]="attach/images/model/".$result['model_id']."/$pic_size".$result["model_pic1"];
              }else if(!empty($result["model_pic2"])){
              $result["firstpic"]="attach/images/model/".$result['model_id']."/$pic_size".$result["model_pic2"];
              } */
            $result["firstpic"] = "attach/images/model/" . $result['model_id'] . "/$pic_size" . $result["model_pic2"];
        } else {
            foreach ($result as $key => $value) {
                /* if(!empty($value["model_pic1"])) {
                  $value["firstpic"]="attach/images/model/".$value['model_id']."/$pic_size".$value["model_pic1"];
                  }else if(!empty($value["model_pic2"])) {
                  $value["firstpic"]="attach/images/model/".$value['model_id']."/$pic_size".$value["model_pic2"];
                  } */
                $value["firstpic"] = "attach/images/model/" . $value['model_id'] . "/$pic_size" . $value["model_pic2"];
                $result[$key] = $value;
            }
        }
        return $result;
    }

    function getSeriesCache($series_id, $sCache_key = "", $cacheList = '') {
        global $_cache;
        if ($cacheList) {
            $_cache->writeCache($sCache_key, $cacheList, 86400);
            return $cacheList;
        } else {
            return $_cache->getCache($sCache_key);
        }
    }

    /**
     *  根据品牌取车系
     * @param type $brand_id
     * @param type $order
     * @return type
     */
    function getSeriesorderById($brand_id, $order = array()) {
        $this->reset();
        $this->fields = "series_id,series_name";
        $this->where = " brand_id ='$brand_id' and state='3'";
        $this->order = $order;
        $result = $this->getResult(2);

        if ($result) {
            foreach ($result as $key => $value) {

                $result[$key][series_name] = $value[series_name];
            }
        }

        return $result;
    }

    /*
     * 查询车系和厂商
     */

    function getSNB($fields, $where, $flag, $order) {
        $this->tables = array(
            'cardb_series' => 'cs',
            'cardb_brand' => 'cb'
        );
        $this->where = $where;
        $this->fields = $fields;
        if ($order)
            $this->order = $order;
        $result = $this->joinTable($flag);
        return $result;
    }

}

?>
