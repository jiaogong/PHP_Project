<?php
class pagedataAction extends action {
    function __construct() {
        parent::__construct();                   
        $this->cardbmodel = new cardbModel();
        $this->cardbmodel->table_name = 'cardb_model';
        $this->pagedata = new pageData();
    }

    function doSsi_index_limitcar() {

        $tpl_name = "ssi_index_limitcar";
        $pd_obj = new pageData();
        $result = $pd_obj->getPageData(
                array(
                'name' => 'limitcar',
                'c1' => 'index',
                'c2' => '1',
                'c3' => 0,
                )
        );

        $limitcar = unserialize($result['value']);
        $this->cardbmodel->fields = 'bingo_price';
        foreach($limitcar[0] as $key => $row) {
            $model_id = $row['model']['model_id'];
            $this->cardbmodel->where = "model_id = $model_id";            
            $limitcar[0][$key]['model']['bingo_price'] = $this->cardbmodel->getResult(3);
        }
        $this->vars('limitcar', $limitcar[0]);
        $this->template($tpl_name);

    }

    function doSsi_index_limitbuy() {

        $tpl_name = "ssi_index_limitbuy";
        $pd_obj = new pageData();
        $result = $pd_obj->getPageData(
                array(
                'name' => 'limitbuy',
                'c1' => 'index',
                'c2' => '1',
                'c3' => 0,
                )
        );
        
        $limitcar = unserialize($result['value']);
        $this->cardbmodel->fields = 'bingo_price';
        foreach($limitcar[0] as $key => $row) {
            $model_id = $row['model']['model_id'];
            $this->cardbmodel->where = "model_id = $model_id";
            $limitcar[0][$key]['model']['bingo_price'] = $this->cardbmodel->getResult(3);
        }        
//        print_r($limitcar[0]);
//        echo date("Y-m-d H:i:s",$limitcar[0][0]["starttime"])."<hr>";
//        echo date("Y-m-d H:i:s",$limitcar[0][0]["starttime"]+($limitcar[0][0]["enddate"]*3600));
//        exit;
        $this->vars('limitcar', $limitcar[0]);
        $this->template($tpl_name);

    }

    /*
    * 更新首页周排行数据
    */
    function doWeekTopdata() {
        $tmptime = time()-(7*86400);

        $pd_obj = new pageData();
        //折扣率
        $model = new cardbModel();
        $model->fields = "series_id,series_name,brand_name, IFNULL(bingo_price, dealer_price) as bingobang_price, bingobang_price/model_price AS mb";
        $model->where = "dealer_price_low > 0";
        $model->group = "series_id";
        $model->order = array("mb"=>"ASC");
        $model->limit = 10;
        $dprice = $model->getResult(2);

        //取出上次折扣率排行
        $topdprice = $pd_obj->getPageData(
                array(
                'name' => 'topdprice',
                'c1' => 'index',
                'c2' => 1,
                'c3' => 0,
                )
        );
        $topdprice = unserialize($topdprice['value']);
        //对比
        if(!empty($dprice)) {
            $temparrdprice = array();
            foreach($dprice as $key=>$value) {
                $temparrdprice[$value["series_id"]] = $value["series_id"];
                $dprice[$key]["mb"] = intval($dprice[$key]["mb"]*100)/10;
                $i = 0;
                if(!empty ($topdprice[0])) {
                    foreach($topdprice[0] as $k=>$v) {
                        if($value["series_id"]==$v["series_id"]) {
                            if($key<$k) {
                                $dprice[$key]["istop"] = "up";
                            }else if($key==$k) {
                                $dprice[$key]["istop"] = "on";
                            }else {
                                $dprice[$key]["istop"] = "dowm";
                            }
                            $i = 1;
                        }
                    }
                }
                
                if($i==0) {
                    $dprice[$key]["istop"] = "up";
                }
            }
        }else {
            $dprice = $topdprice[0];
        }

        $ddprice = 10 - count($dprice);
        if($ddprice>0){
            foreach($topdprice[0] as $k=>$v) {
                if($ddprice==0) {
                    break;
                }
                if(empty ($temparrdprice[$v["series_id"]])) {
                    $v["istop"] = "down";
                    $dprice[] = $v;
                    $ddprice = $ddprice-1;
                }
            }
        }

        $rettopdprice = $pd_obj->addPageData(
                array(
                'name' => 'topdprice',
                'value'=>$dprice,
                'c1' => 'index',
                'c2' => 1,
                'c3' => 0,
                ),2
        );

        //优惠幅度
        $model->fields = "series_id,series_name,brand_name ,model_price-dealer_price_low AS mb";
        $model->where = "dealer_price_low > 0 AND model_price>dealer_price_low ";
        $model->group = "series_id";
        $model->order = array("mb"=>"DESC");
        $model->limit = 10;
        $rprice = $model->getResult(2);

        //取出上次优惠幅度排行
        $toprprice = $pd_obj->getPageData(
                array(
                'name' => 'toprprice',
                'c1' => 'index',
                'c2' => 1,
                'c3' => 0,
                )
        );
        $toprprice = unserialize($toprprice['value']);
        //对比
        if(!empty($rprice)) {
            $temparrrprice = array();
            foreach($rprice as $key=>$value) {
                $tmparrresult[$value["series_id"]] = $value["series_id"];
                $i = 0;
                if(!empty($toprprice[0])) {
                    foreach($toprprice[0] as $k=>$v) {
                        if($value["series_id"]==$v["series_id"]) {
                            if($key<$k) {
                                $rprice[$key]["istop"] = "up";
                            }else if($key==$k) {
                                $rprice[$key]["istop"] = "on";
                            }else {
                                $rprice[$key]["istop"] = "dowm";
                            }
                            $i = 1;
                        }
                    }
                }
                if($i==0) {
                    $rprice[$key]["istop"] = "up";
                }
            }
        }else{
            $rprice = $toprprice[0];
        }

        $drprice = 10 - count($rprice);
        if($drprice>0){
            foreach($toprprice[0] as $k=>$v) {
                if($drprice==0) {
                    break;
                }
                if(empty ($temparrrprice[$v["series_id"]])) {
                    $v["istop"] = "down";
                    $rprice[] = $v;
                    $drprice = $drprice-1;
                }
            }
        }

        $retrprice = $pd_obj->addPageData(
                array(
                'name' => 'toprprice',
                'value'=>$rprice,
                'c1' => 'index',
                'c2' => 1,
                'c3' => 0,
                ),2
        );

        //本周购买量
        $buyinfo = new buycar();
        $buyinfo->group = "series_id";
        $buyinfo->order = array("cun"=>"DESC");
        $buyinfo->tables = array("cardb_buyinfo"=>"cb","cardb_series"=>"cs");
        $buyinfo->fields = "cs.series_name,cs.brand_name,cb.series_id,COUNT(*) AS cun";
        $buyinfo->limit = 10;
        $buyinfo->where = " buystate = 3 and cb.series_id = cs.series_id AND paytime>$tmptime  ";
        $result = $buyinfo->joinTable(2);

        //取出上次购买排行
        $topbuy = $pd_obj->getPageData(
                array(
                'name' => 'topbuy',
                'c1' => 'index',
                'c2' => 1,
                'c3' => 0,
                )
        );
        $topbuy = unserialize($topbuy['value']);

        //对比
        if(!empty ($result)){
            $tmparrresult = array();
            foreach($result as $key=>$value){
                $tmparrresult[$value["series_id"]] = $value["series_id"];
                $i = 0;
                foreach($topbuy[0] as $k=>$v) {
                        if($value["series_id"]==$v["series_id"]) {
                            if($key<$k) {
                                $result[$key]["istop"] = "up";
                            }else if($key==$k) {
                                $result[$key]["istop"] = "on";
                            }else {
                                $result[$key]["istop"] = "dowm";
                            }
                        }
                        $i = 1;
                    }
                   if($i==0) {
                        $result[$key]["istop"] = "up";
                    }
            }
        }else{
             $result = $topbuy[0];
        }
        $dcr = 10 - count($result);
        if($dcr>0){
            foreach($topbuy[0] as $k=>$v) {
                if($dcr==0) {
                    break;
                }
                if(empty ($tmparrresult[$v["series_id"]])) {
                    $v["istop"] = "down";
                    $result[] = $v;
                    $dcr = $dcr-1;
                }
            }
        }

        $result = array_splice($result ,0, 10);

        $rettopbuy = $pd_obj->addPageData(
                array(
                'name' => 'topbuy',
                'value'=>$result,
                'c1' => 'index',
                'c2' => 1,
                'c3' => 0,
                ),2
        );

        //点击量排行
        $counter = new counter();
        $counter->group = "c2";
        $counter->order = array("cun"=>"DESC");
        $counter->tables = array("counter"=>"c","cardb_series"=>"cs");
        $counter->fields = "cs.series_name,cs.brand_name,c.c1,c.c2,COUNT(*) AS cun";
        $counter->limit = 10;
        $counter->where = " c.c1='series' AND c.c2>0 and c.c2=cs.series_id AND c.created>$tmptime ";
        $hit = $counter->joinTable(2);
        //取出上次优惠幅度排行
        $tophit = $pd_obj->getPageData(
                array(
                'name' => 'tophit',
                'c1' => 'index',
                'c2' => 1,
                'c3' => 0,
                )
        );
        $tophit = unserialize($tophit['value']);
        //对比
        if(!empty($hit)){
            $tmparrhit = array();
            foreach($hit as $key=>$value) {
                $tmparrhit[$value["c2"]] = $value["c2"];
                $i = 0;
                foreach($tophit[0] as $k=>$v) {

                    if($value["c2"]==$v["c2"]) {
                        if($key<$k) {
                            $hit[$key]["istop"] = "up";
                        }else if($key==$k) {
                            $hit[$key]["istop"] = "on";
                        }else {
                            $hit[$key]["istop"] = "dowm";
                        }
                        $i = 1;
                    }

                }
                if($i==0) {
                    $hit[$key]["istop"] = "up";
                }

            }
        }else{
            $hit = $tophit[0];
        }
        
        $cdhit = 10-count($hit);
        if($cdhit>0){
            foreach($tophit[0] as $k=>$v) {
                if($cdhit==0) {
                    break;
                }
                if(empty ($tmparrhit[$v["c2"]])) {
                    $v["istop"] = "down";
                    $hit[] = $v;
                    $cdhit = $cdhit-1;
                }
            }
        }

        $rethit = $pd_obj->addPageData(
                array(
                'name' => 'tophit',
                'value'=>$hit,
                'c1' => 'index',
                'c2' => 1,
                'c3' => 0,
                ),2
        );

    }
    function marginSort($a, $b) {
        if ($a['mb'] == $b['mb']) return 0;
        return ($a['mb'] < $b['mb']) ? 1 : -1;
    }
    function countSort($a, $b) {
        if ($a['cun'] == $b['cun']) return 0;
        return ($a['cun'] < $b['cun']) ? 1 : -1;
    }    
    
    /**
     * 更新首页车型点击排行
     */
    function doMonthMtype() {
        $types = array(
            7 => 'SUV', 
            2 => '小型',
            3 => '紧凑',
            4 => '中型', 
            6 => '豪华',             
            8 => 'MPV'
        );
        
        $pageData = $this->pagedata->getPageData(
            array(
            'name' => 'modeltyperank',
            'c1' => 'index',
            'c2' => 1,
            )
        );        
        $lastMonthData = unserialize($pageData['value']);
//        var_dump($lastMonthData);
//        exit;
        
        $monthData = array();
        foreach($types as $key => $row) {
            $hit = $this->cardbmodel->getModelHitsByType($key);
            $nhit = array();
            foreach($hit as $k => $h) {
                $modelId = $h['model_id'];                
                $typeData = $lastMonthData[0][$key];
                $diffPrice = $h['model_price'] - $h['bingobang_price'];                
                $hit[$k]['diff_price'] = $diffPrice;
                $oldPrice = $typeData[$modelId]['diff_price'];
                if(empty($lastMonthData[0])) {
                    $hit[$k]['trend'] = 'equ';
                }
                elseif(empty($typeData[$modelId])) {
                    $hit[$k]['trend'] = 'up';
                }                
                else {
                    if($oldPrice > $diffPrice) {
                        $hit[$k]['trend'] = 'down';
                    }
                    elseif ($oldPrice == $diffPrice) {
                        $hit[$k]['trend'] = 'equ';
                    }
                    else {
                        $hit[$k]['trend'] = 'up';
                    }
                }
            }
            foreach($hit as $h) {
                $nhit[$h['model_id']] = $h;
            }
            $monthData[$key] = $nhit;
        }
        $this->pagedata->addPageData(
                array(
                'name' => 'modeltyperank',
                'value'=> $monthData,
                'c1' => 'index',
                'c2' => 1,
                'c3' => 0,
                ),2
        );        
        
    }
    
    /*
     * 更新首页月排行数据
     */

    function doMonthTopdata(){
        $tmptime = time()-(30*86400);

        $pd_obj = new pageData();
        //折扣率
        $model = new cardbModel();
        $model->fields = "model_id, model_name, IFNULL(bingo_price, dealer_price_low) as bingobang_price, IFNULL(bingo_price, dealer_price_low)/model_price AS mb";
        $model->where = "dealer_price_low > 0";
        $model->group = "series_id";
        $model->order = array("mb"=>"asc");
        $model->limit = 10;
        $dprice = $model->getResult(2);

        //取出上次折扣率排行
        $topdprice = $pd_obj->getPageData(
                array(
                'name' => 'mtopdprice',
                'c1' => 'index',
                'c2' => 1,
                'c3' => 0,
                )
        );
        $topdprice = unserialize($topdprice['value']);

        //对比
        if(!empty($dprice)) {
            $temparrdprice = array();
            foreach($dprice as $key=>$value) {
                $temparrdprice[] = $value["model_id"];
            }
        }else {
            $dprice = $topdprice[0];
        }

        $ddprice = 10 - count($dprice);
        if($ddprice>0) {
            if(!empty($topdprice[0])) {
                foreach($topdprice[0] as $k=>$v) {
                    if($ddprice==0) {
                        break;
                    }
                    if(!in_array($v['model_id'], $temparrdprice)) {
                        $dprice[] = $v;
                        $ddprice = $ddprice-1;
                    }
                }                
            }
        }
        usort($dprice, array($this, 'marginSort'));

        //优惠幅度
        $model->fields = "model_id, model_name, IFNULL(bingo_price, dealer_price_low) as bingobang_price, IFNULL(bingo_price, dealer_price_low) - dealer_price_low AS mb";
        $model->where = "dealer_price_low > 0 AND model_price > bingo_price AND model_price > dealer_price_low";
        $model->group = "series_id";
        $model->order = array("mb"=>"desc");
        $model->limit = 10;
        $rprice = $model->getResult(2);

        //取出上次优惠幅度排行
        $toprprice = $pd_obj->getPageData(
                array(
                'name' => 'mtoprprice',
                'c1' => 'index',
                'c2' => 1,
                'c3' => 0,
                )
        );
        $toprprice = unserialize($toprprice['value']);

        //对比
        if(!empty($rprice)) {
            $temparrrprice = array();
            foreach($rprice as $key=>$value) {
                $temparrrprice[] = $value["model_id"];
            }
        }else {
            $rprice = $toprprice[0];
        }

        $drprice = 10 - count($rprice);
        if($drprice>0) {
            if(!empty($toprprice[0])) {
                foreach($toprprice[0] as $k=>$v) {
                    if($drprice==0) {
                        break;
                    }
                    if(!in_array($v['model_id'], $temparrrprice)) {
                        $rprice[] = $v;
                        $drprice = $drprice-1;
                    }
                }
            }
        }
        usort($rprice, array($this, 'marginSort'));        

        //本周购买量
        $buyinfo = new buycar();
        $buyinfo->group = "cm.series_id";
        $buyinfo->order = array("cun"=>"DESC");
        $buyinfo->tables = array("cardb_buyinfo"=>"cb","cardb_model"=>"cm");
        $buyinfo->fields = "cm.model_id, cm.model_name, COUNT(*) AS cun";
        $buyinfo->limit = 10;
        $buyinfo->where = " buystate = 3 and cm.model_id = cb.model_id AND cb.paytime > $tmptime  ";
        $result = $buyinfo->joinTable(2);        

        //取出上次购买排行
        $topbuy = $pd_obj->getPageData(
                array(
                'name' => 'mtopbuy',
                'c1' => 'index',
                'c2' => 1,
                'c3' => 0,
                )
        );
        $topbuy = unserialize($topbuy['value']);

        //对比
        if(!empty ($result)) {
            $tmparrresult = array();
            foreach($result as $key=>$value) {
                $tmparrresult[] = $value["model_id"];
            }
        }else {
            $result = $topbuy[0];
        }
        $dcr = 10 - count($result);
        if($dcr>0) {
            if(!empty($topbuy[0])) {
                foreach($topbuy[0] as $k=>$v) {
                    if($dcr==0) {
                        break;
                    }
                    if(!in_array($v['model_id'], $tmparrresult)) {
                        $result[] = $v;
                        $dcr = $dcr-1;
                    }
                }
            }
        }
        usort($result, array($this, 'countSort'));

        //点击量排行
        $counter = new counter();
        $counter->group = "c2";
        $counter->order = array("cun"=>"DESC");
        $counter->tables = array("counter"=>"c","cardb_model"=>"cm");
        $counter->fields = "cm.model_id, cm.model_name, c.c1, c.c2, COUNT(*) AS cun";
        $counter->limit = 10;
        $counter->where = " c.c1='model' AND c.c2>0 and c.c2 = cm.model_id AND c.created > $tmptime ";
        $hit = $counter->joinTable(2);

        //取出上次优惠幅度排行
        $tophit = $pd_obj->getPageData(
                array(
                'name' => 'mtophit',
                'c1' => 'index',
                'c2' => 1,
                'c3' => 0,
                )
        );
        $tophit = unserialize($tophit['value']);

        //对比
        if(!empty($hit)){
            $tmparrhit = array();
            foreach($hit as $key=>$value) {
                $tmparrhit[] = $value["model_id"];
            }
        }else{
            $hit = $tophit[0];
        }

        $cdhit = 10-count($hit);
        if($cdhit>0){
            if(!empty($tophit[0])) {
                foreach($tophit[0] as $k=>$v) {
                    if($cdhit==0) {
                        break;
                    }
                    if(!in_array($v['model_id'], $tmparrhit)) {
                        $hit[] = $v;
                        $cdhit = $cdhit-1;
                    }
                }                
            }
        }

        //折扣率
        $retdprice = $pd_obj->addPageData(
                array(
                'name' => 'mtopdprice',
                'value'=>$dprice,
                'c1' => 'index',
                'c2' => 1,
                'c3' => 0,
                ),2
        );
        //优惠幅度
        $retrprice = $pd_obj->addPageData(
                array(
                'name' => 'mtoprprice',
                'value'=>$rprice,
                'c1' => 'index',
                'c2' => 1,
                'c3' => 0,
                ),2
        );
        //购买量
        $retmtopbuy = $pd_obj->addPageData(
                array(
                'name' => 'mtopbuy',
                'value'=>$result,
                'c1' => 'index',
                'c2' => 1,
                'c3' => 0,
                ),2
        );
        //点击量
        $retmtophit = $pd_obj->addPageData(
                array(
                'name' => 'mtophit',
                'value'=>$hit,
                'c1' => 'index',
                'c2' => 1,
                'c3' => 0,
                ),2
        );
        //var_dump($result);
    }
    
}
