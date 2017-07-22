<?php
  /**
  * cardb price
  * $Id: cardbprice.php 3669 2013-11-11 02:27:04Z yizhangdong $
  */
  
class cardbPrice extends model {
    public function __construct() {
        parent::__construct();
        $this->table_name = 'cardb_price';
        $this->realdata = new realdata();
    } 
    function getPrice($fields, $where, $flag) {
        $this->fields = $fields;
        $this->where = $where;
        $result = $this->getResult($flag);
        return $result;
    }    
    function getQuickCompareModel($model_id, $price_type) {
        $this->tables = array(
            'cardb_model' => 'cm',
            'cardb_price' => 'cp'
        );
        $this->fields = 'cm.*, cp.nude_car_rate, cp.free_promotion_gift, cp.rate, cp.down_payment, cp.interest_rate_fee, cp.low_year, cp.special_event, cp.price as media_price, cp.oldcar_company_prize';
        $this->where = "cm.model_id = cp.model_id AND cm.model_id = $model_id AND cp.price_type = $price_type";
        $result = $this->joinTable();
        if(!empty($result)) {
            $result['conservate'] = $this->realdata->getContryBt($result);            
            foreach($result as $k => $ret) {
                $result[$k] = $ret;            
            }
            $result['nude_car_rate'] = floatval($result['nude_car_rate']);            
        }
        return $result;
    }
    function getModelInfo($model_id) {
        $this->table_name = 'cardb_model';
        $this->fields = 'model_pic2, model_name, model_price, series_name';
        $this->where = "model_id = $model_id";
        $result = $this->getResult();
        foreach($result as $k => $ret) {
            $result[$k] = $ret;
        }
        return $result;
    }
    
    
}
?>
