<?php
class cardemand extends model {
    var $table_name = 'cardb_buyinfo';
    function __construct() {
        parent::__construct();        
    }
    function addBuyInfo($receiver_arr) {
        $receiver_arr['createdtime'] = time();
        $this->ufields = $receiver_arr;
        return $this->insert();
    }
    function getPriceQoutes($seriesId) {
        $this->tables = array(
            'cardb_buyinfo' => 'cb',
            'cardb_model' => 'cm'
        );
        $this->fields = 'cb.paytime,cb.user_id, cb.price, cb.paytime, cb.order_num, cm.model_price, cm.model_name, cm.series_name, cm.st27, cm.st28';
        $this->where = "cb.model_id = cm.model_id AND cm.series_id = $seriesId AND cb.price <> 0 AND cb.paytime <> ''";
        $this->order = array(
            'cb.paytime' => 'DESC'
        );
        $this->limit = 8;
        $result = $this->joinTable(2);
        $max = count($result) - 1;
        foreach($result as $key => &$row) {
            $next = $key + 1;
            $price = $row['price'];
            $diffPrice = $row['diff_price'] = $row['model_price'] - $price;            
            $nextDiffPrice = $result[$next]['model_price'] - $result[$next]['price'];
            if($key == $max) $row['trend'] = '_sp';
            else {
                if($diffPrice > $nextDiffPrice) $row['trend'] = '';
                elseif($diffPrice == $nextDiffPrice) $row['trend'] = '_sp';
                else $row['trend'] = '_xj';                
            }
        }
        return $result;
    }
}
?>
