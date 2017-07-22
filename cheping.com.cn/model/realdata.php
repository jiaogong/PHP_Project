<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
*/
class realdata extends model {
     function  __construct() {
         $this->table_name = "cardb_realdata";
         parent::__construct();
     }     
     function getDataBySid($seriesId) {
         $this->fields = 'noise, 60perh, 80perh, 120perh';
         $this->where = "series_id = $seriesId";
         $result = $this->getResult();
         return $result;
     }
     function getRealData($where) {
         $this->fields = '*';
         $this->where = $where;
         $result = $this->getResult();
         return $result;
     }     
     //获取车系国家补贴内容
     function getConservate($fields, $where = 1){
         
        $this->fields = $fields;
        $this->where = $where;
        $result = $this->getResult(2);
        return $result;
    }
    function getContryBt($model) {
        $this->fields = 'conservate';
        $this->where = "date_id = '{$model['date_id']}' AND st27 = {$model['st27']} AND st28 = '{$model['st28']}' AND st41 = '{$model['st41']}' AND st48 = '{$model['st48']}' AND series_id = {$model['series_id']}";
        $result = $this->getResult(3);
        return $result;
    }
}            
?>