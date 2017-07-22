<?php

/**
 * 
 * $Id: odds.php 2092 2013-07-24 13:48:14Z 
 */
class oldCarVal extends model {

    public function __construct() {
        parent::__construct();
        $this->table_name = 'cardb_oldcarval';
    }

    function getOlds($fields, $where, $flag) {
        $this->fields = $fields;
        $this->where = $where;
        $result = $this->getResult($flag);
        return $result;
    }

    //含分页
    function getList($fields, $where, $page_state, $page_size) {
        $this->fields = $fields;
        $this->where = $where;
        $this->offset = $page_state;
        $this->order = array("updated" => "desc", "car_prize" => "asc", "created" => "asc");
        $this->limit = $page_size;
        $result = $this->getResult(2);
        return $result;
    }

    function updateOlds($ufields, $id) {
        $this->ufields = $ufields;
        $this->where = "id = $id";
        return $this->update();
    }

    function addOlds($ufields) {
        $this->ufields = $ufields;
        $id = $this->insert();
        return $id;
    }

    function delOlds($id) {
        $this->ufields = array('state' => 1);
        $this->where = "id = $id";
        return $this->update();
    }

    //关联车款
    function getOldcarvalModel($fields, $where = '') {
        $this->fields = $fields;
        $this->where = 'co.model_id=cm.model_id and cm.state in (3,8)' . $where;
        $this->tables = array(
            'cardb_oldcarval' => 'co',
            'cardb_model' => 'cm'
        );
        return $this->joinTable(2);
    }

}

?>
