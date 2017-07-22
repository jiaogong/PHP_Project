<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
  class County extends model{
      function __construct() {
          parent::__construct();
          $this->table_name = 'county';
      }
      /**
       * 根据地级id取出所有的县级地区
       * @param int $cid
       * @return array
       */
      function getCounty($cid){
          $this->fields = '*';
          $this->where = "city_id=$cid";
          return $this->getResult(2);
      }
      /**
       * 根据县级名称取出该条信息
       * @param string $countyname
       * @return array
       */
      function getCountyByName($countyname){
          $this->fields = '*';
          $this->where = "name = '$countyname'";
          return $this->getResult();
      }
      /**
       * 取所有的县级单位名称
       * @return array
       */
      function getAllCounty(){
          $this->reset();
          $this->table_name = 'county';
          $this->fields = '*';
          $this->where = "city_id=19";
          return $this->getResult(2);
      }
      /**
       * 根据县级id取该条信息
       * 
       */
      function getInfo($id){
          $this->fields = '*';
          $this->where = "id = $id";
          $res = $this->getResult();
          if($res){
              return $res;
          }else{
              return false;
          }
      }

      function getCheck($countyname,$city){
          $this->fields = '*';
          $this->where = "name='$countyname' and city_id=$city";
          return $this->getResult();
      }
  }
?>
