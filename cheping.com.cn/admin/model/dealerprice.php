<?php
class dealerprice extends model {
    function __construct() {
        parent::__construct();
        $this->table_name = 'dealer_price';
    }
    function getDealerPrice($dealer_id,$model_id){
        $this->fields = '*';
        $this->where = "dealer_id=$dealer_id AND model_id = $model_id and state!=6";
        return $this->getResult(1);
    }
    function updatePrice($model_id,$series_id) {
        $this->table_name = 'dealer_price';
        $this->fields = 'max(bingo_price) as max_price, min(bingo_price) as min_price';
        $this->where = "model_id = $model_id and state=1";
        $price_info = $this->getResult(1);
        $min_price = floatval($price_info['min_price']);
        $max_price = floatval($price_info['max_price']);
        $this->table_name = 'cardb_model';
        $this->where = "model_id = $model_id";
        $this->ufields = array("dealer_price_low" => $min_price,"dealer_price_high"=>$max_price);
        $this->update();
        
        #更新search_index表中的dealer_price_low
        $this->table_name = 'search_index';
        $this->where = "model_id = $model_id";
        $this->ufields = array("dealer_price_low" => $min_price);
        $this->update();
        #echo $this->sql;
        if($series_id){
            $this->table_name = 'dealer_price';
            $this->fields = 'max(bingo_price) as max_price, min(bingo_price) as min_price';
            $this->where = "series_id = $series_id and state=1";
            $price_info = $this->getResult(1);
            $min_price = floatval($price_info['min_price']);
            $max_price = floatval($price_info['max_price']);
            $this->table_name = 'cardb_series';
            $this->where = "series_id = $series_id";
            $this->ufields = array("dealer_price_low" => $min_price,"dealer_price_high"=>$max_price);
            $this->update();
        }
    }

    function getList($receiver, $limit, $offset) {
        $brand_id = $receiver['brand_id'];
        $factory_id = $receiver['factory_id'];
        $series_id = $receiver['series_id'];
        $model_id = $receiver['model_id'];
        $province_id = $receiver['province_id'];
        $city_id = $receiver['city_id'];
        $dealer_name = $receiver['dealer_name'];
        $state = $receiver['state'];
        $this->table_name = 'dealer_price p, cardb_model m, dealer_info i';
        $this->tables = array('province' => 'pr', 'city' => 'c');
        $this->join_condition = array('i.province_id = pr.id', 'i.city_id = c.id');
        $this->where = 'p.model_id = m.model_id AND p.dealer_id = i.dealer_id AND p.state !=6';
        
        if($brand_id) $this->where .= " AND m.brand_id = $brand_id";
        if($factory_id) $this->where .= " AND m.factory_id = $factory_id";
        if($series_id) $this->where .= " AND m.series_id = $series_id";
        if($model_id) $this->where .= " AND m.model_id = $model_id";
        if($province_id) $this->where .= " AND i.province_id = $province_id";
        if($city_id) $this->where .= " AND i.city_id = $city_id";
        if($dealer_name) $this->where .= " AND i.dealer_name like '%$dealer_name%'";
        if($state) $this->where .= " AND p.state = $state";
        $this->order = array(
            'p.updated' => 'desc',
            'p.model_price' => 'asc',
            'i.dealer_name' => 'asc'            
        );
        $this->fields = 'count(*)';
        $this->total = $this->leftJoin(3);
        
        $this->fields = 'p.id, p.dealer_id, p.state, p.inventory, m.factory_name, m.series_id, m.series_name, m.model_name,m.model_price, m.dealer_price_low, i.dealer_name, i.province_id, p.bingo_price, p.model_id,p.state, p.updated, pr.name as province_name, c.name as city_name';
        $this->limit = $limit;
        $this->offset = $offset;
        $list = $this->leftJoin(2);
        $k = 0;
        if($list) {
            foreach ($list as $row) {
                $j = $k++;
                if ($row['province_id'] > 4) $list[$j]['province_name'] .= '省';
                else $list[$j]['province_name'] .= '市';
            }
        }
        return $list;
    }
    function getPriceDetail($id) {
        $this->tables = array(
            'cardb_model' => 'a',
            'dealer_info' => 'b',
            'dealer_price' => 'c',
        );
        $this->where = "a.model_id = c.model_id AND b.dealer_id = c.dealer_id AND c.id = $id";
        $this->fields = 'a.brand_id, a.factory_id, a.series_id, a.model_id, b.province_id, b.city_id, b.dealer_id, c.id, c.model_price, c.bingo_price, c.updated, c.start_time, c.end_time, c.color, c.inventory, c.drive, c.remark, c.state';
        $list = $this->joinTable();        
        return $list;
    }
    function getCity($pid) {
        if($pid) {
            $this->table_name = 'city';
            $this->where = "province_id = $pid";
            $this->order = array('name' => 'asc');
            $this->fields = 'id, name, letter';
            $city = $this->getResult(2);            
        }
        else {
            $city = false;
        }
        return $city;        
    }
    function delDealerPrice($id) {
        $this->where = "id = $id";
        $this->ufields = array('state' => 6);
        $this->update();
    }
    function getDiscount($id, $receiver) {
        $discount = 0;
        $model_id = $receiver['model_id'];
        $dealer_price = $receiver['model_price'];
        if($id && $model_id && $dealer_price) {
            $this->table_name = 'cardb_model';
            $this->fields = 'model_price';
            $this->where = "model_id = $model_id";
            $model_price = $this->getResult(3);        
            if($model_price > $dealer_price) $discount = floatval($dealer_price / $model_price);
            $this->table_name = 'dealer_price';
            $this->ufields = array('discount' => $discount);
            $this->where = "id = $id";
            $this->update();
        }
    }
    function addDealerPrice($receiver) {
        $receiver['updated'] = time();
        if($receiver) {
            foreach ($receiver as $k => &$v) {
                if (in_array($k, array('start_time', 'end_time'))) {
                    $v = strtotime($v);
                }
            }
        }
        $this->ufields = $receiver;        
        $id = $this->insert();
        $this->getDiscount($id, $receiver);
    }   
    function editDealerPrice($receiver, $id) { 
        $this->where = "id = $id";
        $receiver['updated'] = time();
        if($receiver) {
            foreach ($receiver as $k => &$v) {
                if (in_array($k, array('start_time', 'end_time'))) {
                    $v = strtotime($v);
                }
            }
        }
        $this->ufields = $receiver;        
        $this->update();
        $this->getDiscount($id, $receiver);
    } 
    function getDealer() {
        $brand_id = intval($_GET['brand_id']);
        $factory_id = intval($_GET['factory_id']);
        $series_id = intval($_GET['series_id']);
        $province_id = intval($_GET['province_id']);
        $city_id = intval($_GET['city_id']);
        $this->tables = array(
            'dealer_info' => 'i',
            'dealer_price' => 'p',
            'cardb_model' => 'm'
        );
        $this->where = 'i.dealer_id = p.dealer_id AND p.model_id = m.model_id';
        if($brand_id) $this->where .= " AND m.brand_id = $brand_id";
        if($factory_id) $this->where .= " AND m.factory_id = $factory_id"; 
        if($series_id) $this->where .= " AND m.series_id = $series_id";
        if($province_id) $this->where .= " AND i.province_id = $province_id";
        if($city_id) $this->where .= " AND i.city_id = $city_id";
        $this->fields = 'DISTINCT(i.dealer_name) as dealer_name, i.dealer_id';
        $dealer = $this->joinTable(2);
        return $dealer;
    }

    function getDealers() {
        $brand_id = intval($_GET['brand_id']);
        $factory_id = intval($_GET['factory_id']);
        $series_id = intval($_GET['series_id']);
        $province_id = intval($_GET['province_id']);
        $city_id = intval($_GET['city_id']);
        $this->tables = array(
            'dealer_info' => 'i',
            'service' => 's',
            'cardb_model' => 'm'
        );
        $this->where = 'i.dealer_id = s.dealer_id AND s.series_id = m.series_id';
        if($brand_id) $this->where .= " AND m.brand_id = $brand_id";
        if($factory_id) $this->where .= " AND m.factory_id = $factory_id";
        if($series_id) $this->where .= " AND m.series_id = $series_id";
        if($province_id) $this->where .= " AND i.province_id = $province_id";
        if($city_id) $this->where .= " AND i.city_id = $city_id";
        $this->fields = 'DISTINCT(i.dealer_name) as dealer_name, i.dealer_id';
        $dealer = $this->joinTable(2);
        return $dealer;
    }


    function getTop10($where=" 1 ",$order=array(),$limit=7,$offset=0){
        //取出最新10款新车系
        $this->fields="id,model_id,model_price,discount";
        $this->order=$order;
        $this->group="series_id";
        $this->limit = $limit;
        $this->where = $where;
        $this->offset = $offset;
        $mods = $this->getResult(2);
        
        //循环取出车系的最低价格 车款
        $mod=new cardbModel();
        if($mods) {
            foreach ($mods as $key => $value) {
                $result = $mod->getModelbydealer($value["model_id"]);
                if (!empty($result["model_pic1"])) {
                    $result["firstpic"] = "attach/images/model/" . $result['model_id'] . "/180x100" . $result["model_pic1"];
                } else if (!empty($result["model_pic2"])) {
                    $result["firstpic"] = "attach/images/model/" . $result['model_id'] . "/180x100" . $result["model_pic2"];
                }
                $mods[$key]["modelinfo"] = $result;
            }
        }
        return $mods;
    }

    function getNewsprice($where=" 1 ",$order=array(),$limit=7){
        //取出最新10款新报价
        $this->tables = array(
            'dealer_price' => 'p',
            'cardb_model' => 'm'
        );
        $this->fields="p.bingo_price,m.model_price,m.factory_name,m.factory_id,m.series_id,m.series_name,m.model_id,m.model_name";
        $this->order=$order;
        $this->limit = $limit;
        $this->where = $where." AND p.model_id = m.model_id";
        $mods = $this->joinTable(2);
        return $mods;
    }

}
?>
