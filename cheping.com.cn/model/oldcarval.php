<?php
  /**
  * cardb color
  * $Id: oldcarval.php 3199 2013-10-29 06:48:12Z yinliuhui $
  */
  
class oldCarVal extends model {
    public function __construct() {
        parent::__construct();
        $this->table_name = 'cardb_oldcarval';
    }
    function getCompanyBt($modelId) {
        $this->fields = 'car_prize';
        $this->where = "model_id = $modelId";
        $result = $this->getResult(3);
        return $result;
    }
    function getOldCarList($fields,$where,$flag){
        $this->where = $where;
        $this->fields = $fields;
        $result = $this->getResult($flag);
        return $result;
    }
}
?>
