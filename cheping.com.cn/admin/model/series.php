<?php

/**
 * series
 * $Id: series.php 2651 2016-05-12 08:56:03Z david $
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
        12 => '客车',
    );
    var $st4_list_r = array(
        'MPV' => 1,
        'SUV' => 2,
        '两厢车' => 3,
        '旅行车' => 4,
        'coupe' => 5, /* '跑车', */
        '软顶敞篷车' => 6,
        '三厢车' => 7,
        '掀背车' => 8,
        '硬顶敞篷车' => 9,
        '硬顶跑车' => 10,
        '敞篷车' => 11,
        '客车' => 12,
    );
    var $st21_list = array(
        1 => 2,
        2 => 3,
        3 => 4,
        4 => 5,
        5 => 6,
    );
    var $st21_list_r = array(
        2 => 1,
        3 => 2,
        4 => 3,
        5 => 4,
        6 => 5,
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

    function getSeriesdata($fields, $where = 1, $type = 2) {
        $this->fields = $fields;
        $this->where = $where;
        return $this->getResult($type);
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
//                $v['series_name'] = iconv('gbk', 'utf-8', $v['series_name']);
                $v['series_name'] = $v['series_name'];
                $fsArr[$fid][] = $v;
            }
        }
        return $fsArr;
    }
     /**
     * 
     * @param type $fields 取字段
     * @param type $id   传参数    
     * @return 查询结果
     */
    function getSeries($id) {
        $this->fields = "*";
        $this->where = "series_id='{$id}'";
        return $this->getResult();
    }

   /**
     * 
     * @param type $fields 取字段
     * @param type $id   传参数    
     * @return 查询结果
     */
    function getSeriesFields($fields, $where, $id) {
        $this->fields = $fields;
        $this->where = $where;
//        $this->limit = 20;
        return $this->getResult(2);
    }
    
     /**
     * 
     * @param type $fields 取字段
     * @param type $id   传参数    
     * @return 查询结果
     */
    function getSeriesField($fields, $where, $id) {
        $this->fields = $fields;
        $this->where = $where;
//        $this->limit = 20;
        $this->fields = "count(series_id)";
        $this->total = $this->getResult(2);
        return $this->getResult(2);
    }

    /**
     * 统计正常车款的数目条件外加
     * @param string $order 排序字段
     * @param string $orderby 排序方式 asc/desc
     * @param int $limit 返回数组条数
     * @return array $ret
     */
    function getCarNormal($where) {
        $this->tables = array(
            'cardb_series' => 's',
            'cardb_model' => 'm',);
        $this->where = $where;
        $this->fields = 's.series_id,s.brand_name,s.series_name,s.state,s.factory_name,COUNT(m.model_id) as total';
        $this->group = 's.series_id';
        $this->join_condition = array("s.series_id = m.series_id and m.state in(3,8)");
        $res = $this->leftJoin(2); //查询多条
        return $res;
    }

    /**
     * 统计正常车款的数目条件不外加
     * @param string $order 排序字段
     * @param string $orderby 排序方式 asc/desc
     * @param int $limit 返回数组条数
     * @return array $ret
     */
    function getCarNormals() {
        $this->tables = array(
            'cardb_series' => 's',
            'cardb_model' => 'm',);
        $this->where = 's.state=3';
        $this->fields = 's.series_id,s.brand_name,s.series_name,s.state,s.factory_name,COUNT(m.model_id) as total';
        $this->group = 's.series_id';
        $this->join_condition = array("s.series_id = m.series_id and m.state in(3,8)");
        $res = $this->leftJoin(2); //查询多条
        return $res;
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

}

?>
