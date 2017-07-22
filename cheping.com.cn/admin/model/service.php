<?php
class Service extends model {
    function __construct() {
        parent::__construct();
        $this->table_name = 'service';
    }
    function chk_service_id($sid) {
        $this->where = "service_id = $sid";
        $this->fields = 'service_id';
        $sid = $this->getResult(1);
        return $sid;
    }
    function update_service($ufields, $sid) {
        $this->where = "service_id = $sid";
        $this->ufields = $ufields;
        $this->update();
    }
    function insert_service($ufields) {
        $this->ufields = $ufields;
        $this->insert();
    }
    function getService($dealer_id) {
        $this->fields = '*';
        $this->where = "dealer_id = $dealer_id";
        $service = $this->getResult(2);
        return $service;
    }  
    function delete_service($id) {
        $this->where = "service_id = $id";
        $this->del();
    }
    function deleteByDealerid($did){
        $this->where = "dealer_id = $did";
        $this->del();
    }
    function getServiceList($fields,$where ,$flag){
        $this->fields =$fields;
        $this->where = $where;
        return $this->getResult($flag);
    }
}
?>
