<?php

class cardbsalestate extends model {

  function __construct(){
    $this->table_name = "cardb_salestate";
    parent::__construct();
  }

  function updateState($ufields,$where){
  	$this->ufields = $ufields;
  	$this->where = $where;
  	return $this->update();
  }

  function getState($salestate,$dprice){
  	$this->fields = 'state';
  	$this->where = "model_id=$dprice and city_id={$salestate[1]}";
  	$res = $this->getResult(1);
  	if($res)
  		return $res;
  	else
  		return false;
  }
  function getOneState($field, $where) {
      $this->fields = $field;
      $this->where = $where;
      $result = $this->getResult(3);
      return $result;
  }
  function insertState($ufields) {
      $this->ufields = $ufields;
      $id = $this->insert();
      return $id;
  }
   function getSaleState($field, $where,$flag=2) {
      $this->fields = $field;
      $this->where = $where;
      $result = $this->getResult($flag);
      return $result;
  }
}