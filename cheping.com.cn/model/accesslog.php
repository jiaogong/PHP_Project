<?php

/**
 * access log model
 * $Id: accesslog.php 970 2015-10-22 04:09:08Z xiaodawei $
 * @author David Shaw <tudibao@163.com>
 * 
 * CREATE TABLE `access_log` (
  `timeline` int(10) unsigned DEFAULT NULL,
  `class` varchar(30) DEFAULT '',
  `method` varchar(30) DEFAULT '',
  `useragent` varchar(50) DEFAULT '',
  `ip` varchar(15) DEFAULT '',
  `sid` varchar(50) DEFAULT '',
  KEY `timeline` (`timeline`),
  KEY `class` (`class`,`method`,`ip`,`sid`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8
 */
class accessLog extends model {

    function __construct() {
        parent::__construct();
        $this->table_name = 'access_log';
    }

    /**
     * 根据指定条件，时间，查询访问记录条数
     * 只返回整数值，没有访问记录的具体内容
     * 
     * 注：where字段顺序： class, method, ip, sid
     * 
     * @param array $condition 查询条件的数组
     * @param int $second 设置查询时间范围，单位秒，默认1分钟，即60秒
     * @return int 返回查询到的条数
     */
    function getCount($condition = array(), $second = 60) {
        $start_time = $this->timestamp - $second;
        $this->where = "timeline<='{$this->timestamp}' and timeline>='{$start_time}' and class='{$condition['class']}' and";
        $this->where .= " method='{$condition['method']}' and ip='{$condition['ip']}' and sid='{$condition['sid']}'";
        $this->fields = "count(*)";
        return $this->getResult(3);
    }

    /**
     * 根据指定条件，返回一分钟内的访问记录数
     * 
     * @param array $condition 查询条件的数组
     * @return int 返回查询到的条数
     */
    function getMinCount($condition = array()) {
        return $this->getCount($condition, 60);
    }

    /**
     * 根据指定条件，返回一小时内的访问记录数
     * 
     * @param array $condition 查询条件的数组
     * @return int 返回查询到的条数
     */
    function getHourCount($condition = array()) {
        return $this->getCount($condition, 3600);
    }

    /**
     * 根据指定条件，返回一天内的访问记录数
     * 
     * @param array $condition 查询条件的数组
     * @return int 返回查询到的条数
     */
    function getDayCount($condition = array()) {
        return $this->getCount($condition, 86400);
    }

    function addLog($data = array()) {
        $this->ufields = $data;
        return $this->insert();
    }

}
