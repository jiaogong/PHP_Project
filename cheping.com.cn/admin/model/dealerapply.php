<?php
class dealerapply extends model {
    function __construct() {
        parent::__construct();
        $this->table_name = 'dealer_apply';
    }
    function getList($condition, $limit, $offset) {
        $this->where = $condition;
        $this->fields = 'count(*)';
        $this->total = $this->getResult(3);

        $this->fields = 'd.*,p.name province_name,c.name city_name';
        $this->limit = $limit;
        $this->offset = $offset;
        $this->order = array('id'=>'desc');
        $this->tables = array(
            'dealer_apply' => 'd',
            'province' => 'p',
            'city' => 'c'
        );
        $this->where = $condition." p.id=d.province_id and c.id=d.city_id ";
        $list = $this->joinTable(2);
        return $list;
    }

    function getApplyById($id){
        $this->fields = 'd.*,p.name province_name,c.name city_name';
        $this->tables = array(
            'dealer_apply' => 'd',
            'province' => 'p',
            'city' => 'c'
        );
        $this->where = "d.id=$id and p.id=d.province_id and c.id=d.city_id ";
        return $this->joinTable(2);
//        return $this->getResult(2);
    }
}
?>