<?php

/**
 * brand
 * $Id: realdata.php 6147 2015-01-13 04:19:31Z xiaodawei $
 */
class realdata extends model {

    function __construct() {
        parent::__construct();
        $this->table_name = 'cardb_realdata';
    }

    function getRealdata($fields, $where = 1, $flag = 2) {
        $this->fields = $fields;
        $this->where = $where;
        $result = $this->getResult($flag);
        return $result;
    }

    function updateRealdata($ufields, $rid) {
        $this->ufields = $ufields;
        $this->where = "id = $rid";
        $this->update();
    }

    /**
     * 插入实测数据
     * 先判断该车型是否存在，不存在则插入
     * 注：要求车型必要参数[series_id,st27,st28,st41,st48,date_id]
     * 
     * @param array $ufields 插入数据的字段
     * @return int 入库之后，返回的自增ID
     */
    function insertRealdata($ufields) {
        $condition = "series_id='{$ufields['series_id']}' and st27='{$ufields['st27']}' "
                . "and st28='{$ufields['28']}' and st41='{$ufields['41']}' and st48='{$ufields['48']}' "
                . "and date_id='{$ufields['date_id']}'";
        $is_exist = $this->getRealdata("count(id)", $condition, 3);
        #如果不存在，入库
        if (!$is_exist) {
            $this->ufields = $ufields;
            $id = $this->insert();
            return $id;
        }
        #存在，返回空
        else {
            return '';
        }
    }

    /**
     * 根据某些字段查询id
     * return array
     */
    function getId($where) {
        $this->fields = 'id';
        $this->where = $where;
        return $this->getResult();
    }

    /**
     * 统计车型数
     */
    function getCarModel($fields, $where, $flag) {
        $this->tables = array(
            'cardb_realdata' => 'r',
            'cardb_series' => 's',
        );
        $this->fields = $fields;
        $this->where = $where;
        $this->join_condition = array('r.series_id = s.series_id');
        $result = $this->leftJoin($flag);
        return $result;
    }

    /**
     * 批量更新停产车辆的实测数据
     * 将state=0
     */
    function updateOldData() {
        #将所有数据置为删除状态
        #$this->table_name = 'cardb_realdata';
        $this->ufields = array('state' => 0);
        $this->update();

        $this->table_name = "cardb_realdata r JOIN cardb_model m
        ON m.series_id=r.series_id AND m.date_id=r.date_id AND m.st27=CAST(m.st27 AS CHAR) AND m.st41=r.st41 AND m.st28=r.st28 AND m.st48=r.st48 
        AND (m.state=3 OR m.state=8)";
        $this->ufields = array('r.state' => 1);
        $r = $this->update();

        #删除重复数据state=3
        $this->table_name = "cardb_realdata a JOIN (SELECT id,series_id,st27,st28,st41,st48,date_id,state,noise,COUNT(*) FROM cardb_realdata WHERE state=1 GROUP BY series_id,st27,st28,st41,st48,date_id HAVING COUNT(*)>1) b ON a.series_id=b.series_id AND (a.noise='' OR a.noise IS NULL)";
        $this->ufields = array('a.state' => 3);
        $ur = $this->update();

        $this->table_name = 'cardb_realdata';
        $this->where = "state=3";
        $this->limit = 0;
        $r = $this->del();
        return $r;
    }

}

?>
