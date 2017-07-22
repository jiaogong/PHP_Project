<?php

//

/**
 * page_data
 * $Id: pagedata.php 2701 2016-05-18 02:31:14Z wangchangjiang $
 */
//class pageData extends model {
//    function __construct() {
//        parent::__construct();
//        $this->table_name = "page_data";
//    }
//
//    function getList($fields, $where, $flag) {
//        $this->fields = $fields;
//        $this->where = $where;
//        return $this->getResult($flag);
//    }
//
//    function getData($id) {
//        $this->fields = "*";
//        $this->where = "id='{$id}'";
//        return $this->getResult();
//    }
//
//    function getAllData() {
//        return $this->getResult(2);
//    }
//
//    function insertPageData($ufields) {
//        $this->ufields = $ufields;
//        $ret = $this->insert();
//        return $ret;
//    }
//
//    function updatePageData($ufields, $where) {
//        $this->ufields = $ufields;
//        $this->where = $where;
//        $ret = $this->update();
//        return $ret;
//    }
//
//    function addIndexPagedata($ufields) {
//        global $timestamp;
//        $ufields['updated'] = $timestamp;
//        $ufields['value'] = serialize($ufields['value']);
//        $getUfields['name'] = $ufields['name'];
//        $getUfields['c1'] = $ufields['c1'];
//        $getUfields['c2'] = $ufields['c2'];
//        if ($ufields['start_time'])
//            $getUfields['start_time'] = $ufields['start_time'];
//        $data = $this->getPageData($getUfields);
//        if (empty($data)) {
//            $ufields['created'] = $timestamp;
//            $this->ufields = $ufields;
//            $ret = $this->insert();
//        } else {
//            $this->ufields = $ufields;
//            $this->where = "name='{$ufields['name']}' and c1='{$ufields['c1']}' and c2='{$ufields['c2']}' and c3='{$ufields['c3']}' ";
//            if ($ufields['start_time'])
//                $this->where .= " AND start_time = '{$ufields['start_time']}'";
//            $ret = $this->update();
//        }
//        return $ret;
//    }
//
//    /**
//     * val = array(
//     *   'name',
//     *   'value',
//     *   'c1',
//     *   'c2',
//     *   'c3'
//     * );
//     * 
//     * @param mixed $val
//     */
//    function addPageData($val, $len = 9) {
//        $index_video = $this->getPageData($val);
//        $data = unserialize($index_video['value']);
//        $data_vl = count($data);
//        $ufields = array(
//            'name' => $val['name'],
//            'c1' => $val['c1'],
//            'c2' => $val['c2'],
//            'updated' => $this->timestamp,
//        );
//
//        if (!$data) {
//            $ufields['value'] = serialize(array($val['value']));
//            $ufields['created'] = $this->timestamp;
//            $ret = $this->insertPageData($ufields);
//        } else {
//            $tmp = $data;
//            $data = $this->addPdValue($data, $val['value']);
//            if ($data == $tmp) {
//                if ($data_vl >= $len) {
//                    array_pop($data);
//                }
//                array_unshift($data, $val['value']);
//                $ufields['value'] = serialize($data);
//            } else {
//                $ufields['value'] = serialize($data);
//            }
//            $where = "name='{$val['name']}' and c1='{$val['c1']}' and c2='{$val['c2']}' and c3='{$val['c3']}'";
//            $ret = $this->updatePageData($ufields, $where);
//        }
//        return $ret;
//    }
//
//    function getPageData($val, $flag = 1, $fields = '*', $order = array('id' => 'ASC')) {
//        $this->where = '';
//        foreach ($val as $k => $v) {
//            if ($k != 'value')
//                $this->where .= " AND $k = '$v'";
//        }
//        $this->where = ltrim($this->where, ' AND');
//        $this->fields = $fields;
//        $this->order = $order;
//        return $this->getResult($flag);
//    }
//
//    function getDiscountValue($pdName, $date) {
//        $this->fields = 'value';
//        $this->where = "name = '$pdName' AND start_time <= '$date' AND state <> 1";
//        $this->order = array('start_time' => 'DESC');
//        $this->limit = 3;
//        //$this->group = 'value';
//        $result = $this->getResult(2);
//        return $result;
//    }
//
//    /**
//     * 返回指定内容中数组的第一个元素
//     * 默认应该为ID
//     * 
//     * @param mixed $pd
//     * @return mixed
//     */
//    function getPdValueId($pd) {
//        $pdvalue = unserialize($pd);
//        $ret = array();
//        foreach ($pdvalue as $k => $v) {
//            $ret[] = array_shift($v);
//        }
//        return $ret;
//    }
//
//    function addPdValue($data, $val) {
//        $ret = array();
//        foreach ($data as $k => $v) {
//            if ($v['id'] == $val['id']) {
//                $ret[] = $val;
//            } else {
//                $ret[] = $v;
//            }
//        }
//        return $ret;
//    }
//
//    function checkPdValue($data, $val) {
//        foreach ($data as $k => $v) {
//            if ($v['id'] == $val['id']) {
//                return true;
//            }
//        }
//        return false;
//    }
//
//    function delPdValue($val) {
//        $ret = array();
//        $pd = $this->getPageData($val);
//        $pdvalue = unserialize($pd['value']);
//        foreach ($pdvalue as $k => $v) {
//            if ($v['id'] != $val['id']) {
//                $ret[] = $v;
//            }
//        }
//        $this->where = "name='{$val['name']}' and c1='{$val['c1']}' and c2='{$val['c2']}' and c3='{$val['c3']}'";
//        $this->ufields = array(
//            'value' => serialize($ret),
//            'updated' => $this->timestamp
//        );
//        $r = $this->update();
//        return $r;
//    }
//
//    function upPopCarComment() {
//        $comment_obj = new comment();
//        $avg_obj = new commentAvg();
//        $series_obj = new series();
//
//        $hotcar_pd = $this->getPageData(
//                array(
//                    'name' => 'popcar',
//                    'c1' => 'popcar',
//                    'c2' => 1,
//                    'c3' => 0,
//                )
//        );
//
//        $hotcar = unserialize($hotcar_pd['value']);
//        if (count($hotcar[0]) > 4) {
//            $popcar = array_slice($hotcar[0], 0, 9);
//        } else {
//            $popcar = $hotcar[0];
//        }
//        $commentavg = new commentAvg();
//
//        foreach ($this->newtype as $key => $value) {
//            #取指定级别数据
//            $temp = $hotcar[0][$key];
//            $newpopcar[$key] = $temp;
//            foreach ($temp['hotcar'] as $k => $v) {
//                $series_id = $v['series_id'];
//                $series = $series_obj->getSeries($series_id);
//
//                $series_score = 0;
//                if ($series['score']) {
//                    $score = explode("||", $series['score']);
//                    $series_score = round($score[5]);
//                }
//
//                $comment = $comment_obj->getCommentBySid($series_id, true);
//                $avg = $avg_obj->getAvgScore('series', $series_id);
//
//                $v["comment_total"] = $avg['s7'] = $comment_obj->total;
//                $v["series_intro"] = $series['series_intro'];
//                $v["series_score"] = $series_score;
//                $v["comment"] = $comment;
//                $v["avgscore"] = $avg;
//                $tem = explode("（", $series['type_name']);
//                $v["type_name"] = $tem[0];
//                $v["s1"] = $series['s1'];
//
//                $newpopcar[$key]['hotcar'][$k] = $v;
//            }
//        }
//
//        $s = $this->addPageData(array(
//            'name' => 'popcar',
//            'value' => $newpopcar,
//            'c1' => 'popcar',
//            'c2' => 1,
//            'c3' => 0
//        ));
//        return $s;
//    }

/*
 * 根据条件返回结果
 */

//    function getSomePagedata($fields, $where, $flag) {
//        $this->fields = $fields;
//        $this->where = $where;
//        $res = $this->getResult($flag);
//        if ($res)
//            return $res;
//        else
//            return false;
//    }
//    function getPagedataLimit($fields, $where, $limit, $order, $flag) {
//        $this->fields = $fields;
//        $this->where = $where;
//        if ($limit)
//            $this->limit = $limit;
//        if ($order)
//            $this->order = $order;
//        return $this->getResult($flag);
//    }
//分页显示
//    function getPage($fields, $where, $offset, $limit, $order) {
//        $this->fields = 'count(*) count';
//        $this->where = $where;
//        $total = $this->getResult();
//        $this->total = $total['count'];
//        $this->fields = $fields;
//        $this->offset = $offset;
//        $this->limit = $limit;
//        if ($order)
//            $this->order = $order;
//        else
//            $this->order = '';
//        return $this->getResult(2);
//    }

/**
 * 根据pagedata名字返回记录
 * 
 * @param string $name pagedata名称
 * @return array 满足条件的记录或者空
 */
//    function getPageDataByName($name = '') {
//        $this->fields = "*";
//        $this->where = "name='{$name}'";
//        return $this->getResult();
//    }

/**
 * 根据当前IP判断，是否在允许的测试IP内
 * 
 * @param string $ip 如果不设置，默认使用用户当前IP
 * @return boolean 当前IP在测试IP范围，返回true，否则返回false
 */
//    function isPrivilegeIP($ip = '') {
//        if (empty($ip))
//            $ip = util::getIP();
//
//        $pd_name = "privilegeip";
//        $val = $this->getPageDataByName($pd_name);
//        if (!empty($val) && !empty($val['value'])) {
//            $arr = unserialize($val['value']);
//            if ($arr['state'] && in_array($ip, $arr['ip_list'])) {
//                return true;
//            }
//        }
//        return false;
//    }
//
//}

/**
 * page_data
 * $Id: pagedata.php 2701 2016-05-18 02:31:14Z wangchangjiang $
 */
class pageData extends model {

    var $popcar = array(
        "1" => array("type_name" => "微型车",
            "top10" => array(
                0 => array(
                    "id" => ""
                )
            )
        )
    );

    function __construct() {
        parent::__construct();
        $this->table_name = "page_data";
    }

    function getData($id) {
        $this->fields = "*";
        $this->where = "id='{$id}'";
        return $this->getResult();
    }

    function getAllData() {
        return $this->getResult(2);
    }

    /**
     * val = array(
     *   'name',
     *   'value',
     *   'c1',
     *   'c2',
     *   'c3'
     * );
     * 
     * @param mixed $val
     */
    function addPageData($val, $len = 9) {
        $index_video = $this->getPageData($val);
        $data = unserialize($index_video['value']);
        $data_vl = count($data);
        $this->ufields = array(
            'name' => $val['name'],
            'c1' => $val['c1'],
            'c2' => $val['c2'],
            'c3' => $val['c3'],
            'updated' => $this->timestamp,
        );

        if (!$data) {
            $this->ufields['value'] = serialize(array($val['value']));
            $this->ufields['created'] = $this->timestamp;
            $ret = $this->insert();
        } else {
            $tmp = $data;
            $data = $this->addPdValue($data, $val['value']);
            if ($data == $tmp) {
                if ($data_vl >= $len) {
                    array_pop($data);
                }
                array_unshift($data, $val['value']);
                $this->ufields['value'] = serialize($data);
            } else {
                $this->ufields['value'] = serialize($data);
            }

            $this->where = "name='{$val['name']}' and c1='{$val['c1']}' and c2='{$val['c2']}' and c3='{$val['c3']}'";
            $ret = $this->update();
        }
        return $ret;
    }

    function getPageData($val, $cached = true) {
        global $_cache;
        $cache_key = $val['name'] . $val['c1'] . $val['c2'] . $val['c3'];
        $ret = $_cache->getCache($cache_key);

        if (is_numeric($cached) && $cached > 0) {
            $cache_time = $cached;
        } else
            $cache_time = M_STORE_TIME;

        if (!$ret || !$cached) {
            $this->where = "name='{$val['name']}' and c1='{$val['c1']}' and c2='{$val['c2']}' and c3='{$val['c3']}'";
            $this->fields = "*";
            $row = $this->getResult();
            $_cache->writeCache($cache_key, $row, $cache_time);
            $ret = $row;
        } else {
            /* echo "used cache"; */
        }
        return $ret;
    }

    /**
     * 返回指定内容中数组的第一个元素
     * 默认应该为ID
     * 
     * @param mixed $pd
     * @return mixed
     */
    function getPdValueId($pd) {
        $pdvalue = unserialize($pd);
        $ret = array();
        foreach ($pdvalue as $k => $v) {
            $ret[] = array_shift($v);
        }
        return $ret;
    }

    function addPdValue($data, $val) {
        $ret = array();
        foreach ($data as $k => $v) {
            if ($v['name'] == $val['name']) {
                $ret[] = $val;
            } else {
                $ret[] = $v;
            }
        }
        return $ret;
    }

    function checkPdValue($data, $val) {
        foreach ($data as $k => $v) {
            if ($v['id'] == $val['id']) {
                return true;
            }
        }
        return false;
    }

    function delPdValue($val) {
        $ret = array();
        $pd = $this->getPageData($val);
        $pdvalue = unserialize($pd['value']);
        foreach ($pdvalue as $k => $v) {
            if ($v['id'] != $val['id']) {
                $ret[] = $v;
            }
        }
        $this->where = "name='{$val['name']}' and c1='{$val['c1']}' and c2='{$val['c2']}' and c3='{$val['c3']}'";
        $this->ufields = array(
            'value' => serialize($ret),
            'updated' => $this->timestamp
        );
        $r = $this->update();
        return $r;
    }

    /**
     * 获得图片热门车系搜索
     */
    function getSeriesHot() {
        $this->fields = "name,value";
        $this->where = "name='serieshot'";
        $aaa = $this->getResult();
        if ($aaa) {
            $arr = $this->mb_unserialize($aaa[value]);
         
            if($arr[0]){
                foreach ($arr[0] as $key => $value) {
                    $this->table_name = "cardb_series";
                    $this->fields = "series_name,brand_name,series_id,brand_id";
                    if ($value[series]) {
                        $this->where = "series_id=$value[series]";
                    } else {
                        $this->where = "brand_id=$value[brand]";
                    }
                    $ret = $this->getResult();
                    $result[$key][brand_name] = $ret[brand_name];
                    $result[$key][series_name] = $ret[series_name];
                    $result[$key][series_id] = $ret[series_id];
                    $result[$key][brand_id] = $ret[brand_id];
                    $result[$key][name] = $value[name];
                    $result[$key][link] = $value[link];
                }
            }
        }

        $this->table_name = "page_data";
        return $result;
    }
    
    /**
     * 
     * @param string $where 查询条件
     * @param string $fields 返回的字段
     * @param int $flag 查询方式，同getResult类型
     * @return array or false 查询的文章记录数组 
     */
    function getSomePagedata($fields, $where, $flag) {
        $this->fields = $fields;
        $this->where = $where;
        $res = $this->getResult($flag);
        if ($res)
            return $res;
        else
            return false;
    }
    
        /**
     * 使用处理过单双引号，过滤\r的mb_unserialize方法就能成功反序列化了
     */
    function mb_unserialize($serial_str) {
    $serial_str= preg_replace('!s:(\d+):"(.*?)";!se', "'s:'.strlen('$2').':\"$2\";'", $serial_str );
    $serial_str= str_replace("\r", "", $serial_str);
    return unserialize($serial_str);
}

}

?>
