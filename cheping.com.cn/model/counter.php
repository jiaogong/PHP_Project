<?php

/**
 * 统计表model
 * $Id: counter.php 2933 2016-06-06 09:29:26Z cuiyuanxin $
 * @author David Shaw <tudibao@163.com>
 */
class counter extends model {

    function __construct() {
        parent::__construct();
        $this->table_name = "counter.counter";
    }

    /**
     * 将统计数据插入到当天的日期表中
     * 例如: counter_20150831
     * 
     * 其中data数组中的 "timeline" 时间戳为必须
     * 
     * @param array $data array('cname' => 英文名称,'c1' => 位置1编号, 'c2' => 位置2编号, 'c3' => 位置3编号)
     * @return boolean true插入成功，false插入失败
     */
    function addCounter($data) {
        //根据时间，判断要存储表
        if (!$data['timeline'])
            return false;
        $date = date('Ymd', $data['timeline']);
        $this->table_name = $this->table_name . "_{$date}";

        $this->logging = 0;
        $this->ufields = $data;
        return $this->insert();
    }

    function getSelect($fields = "*", $where, $type = 2, $date) {
        $this->table_name = $this->table_name . "_{$date}";
        $this->where = $where;
        $this->fields = $fields;
        return $this->getResult($type);
    }

}
