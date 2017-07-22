<?php

/**
 * page_data
 * $Id: cp_pagedataseries.php 1789 2016-03-24 08:39:22Z wangchangjiang $
 */
class cp_pageDataSeries extends model {
    function __construct() {
        parent::__construct();
        $this->table_name = 'page_data_series';
    }
    function insertSeries($ufields) {
        global $timestamp;
        $ufields['create_time'] = $timestamp;
        $this->ufields = $ufields;
        $id = $this->insert();
        return $id;
    }
    function updateSeries($ufields, $where) {
        global $timestamp;
        $ufields['update_time'] = $timestamp;
        $this->ufields = $ufields;
        $this->where = $where;
        $result = $this->update();
        return $result;
    }
    function getSeries($fields, $where, $flag) {
        $this->fields = $fields;
        $this->where = $where;
        $result = $this->getResult($flag);
        return $result;
    }
    function getAllPageData($keys, $firstDate, $lastDate, $carType) {
        $name = implode("', '", $keys);
        $this->tables = array(
            'cardb_series' => 'cs',
            'page_data_series' => 'ps'
        );
        $this->where = "cs.series_id = ps.series_id AND ps.state = 0 AND ps.pd_name in ('$name') AND ps.start_time >= '$firstDate' AND ps.start_time <= '$lastDate'";
        $this->fields = 'cs.series_name, ps.start_time, ps.pd_name';
        $result = $this->joinTable(2);
        $ret = array();
        foreach($result as $k => $v) {
            $pdName = $v['pd_name'];
            $date = $v['start_time'];
            $seriesName = $v['series_name'];
            if(!in_array($seriesName, (array)$ret[$pdName][$date])) $ret[$pdName][$date][] = $seriesName;
        }
        return $ret;
    }    
    function getOldPageData() {
        $this->tables = array(
            'cardb_series' => 'cs',
            'page_data_series' => 'ps'
        );
        $this->fields = 'cs.series_name, ps.pd_name, ps.start_time';
        $this->where = 'cs.series_id = ps.series_id AND ps.state = 0';
        $this->order = array('ps.start_time' => 'ASC');
        $result = $this->joinTable(2);
        $ret = array();
        foreach($result as $k => $v) {
            $startTime = $v['start_time'];
            $pdName = $v['pd_name'];
            $seriesName = $v['series_name'];
            if(!in_array($seriesName, (array)$ret[$startTime][$pdName])) {
                $ret[$startTime][$pdName][] = $seriesName;
            }
        }
        return $ret;
    }    
    function getModelCount($startDate, $endDate) {
        $this->fields = 'pd_name, count(*)';
        $this->where = "state = 0 AND start_time >= '$startDate' AND start_time <= '$endDate'";
        $this->group = 'pd_name';
        $result = $this->getResult(4);
        return $result;
    }

	function delPagedataSeries($where){
		$this->limit = 100;
		$this->where = $where;
		return $this->del();
	}
}
?>
