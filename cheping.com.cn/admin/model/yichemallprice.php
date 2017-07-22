<?php

/*
 * 采集易车商城价格
 * 
 * @author David Shaw <tudibao@163.com>
 * $Id: yichemallprice.php 1792 2016-03-28 01:59:03Z wangchangjiang $
 */

class yichemallprice extends model{
    
    function __construct() {
        parent::__construct();
        $this->table_name = "yiche_price";
    }
    
    function getCsvData(){
        $this->fields = "yc_brandname AS '品牌',yc_factoryname AS '厂商',yc_seriesname AS '车系',yc_modelname AS '车款',
yc_modelprice AS '指导价',yc_mallprice AS '商城价',yc_mallprice2 AS '大促价',yc_orderprice AS '订金金额',
yc_saleprovince AS '售卖地区（省）',yc_salecity AS '售卖地区（市）',yc_num AS '数量',
yc_saleinfo AS '促销活动',yc_memo1 AS '购车形式',FROM_UNIXTIME(created) AS '车款建立日期',
IF(sale_stats=1,'未售罄','已售罄') AS '销售状态'";
        $this->where = "1";
        $this->limit = 5000;
        $list = $this->getResult(2);
        $csv = "品牌,厂商,车系,车款,指导价,商城价,大促价,订金金额,售卖地区（省）,售卖地区（市）,数量,促销活动,购车形式,车款建立日期,销售状态\n";
        foreach ($list as $k => $v){
            $csv .= "{$v['品牌']},{$v['厂商']},{$v['车系']},{$v['车款']},{$v['指导价']},{$v['商城价']},{$v['大促价']},{$v['订金金额']},{$v['售卖地区（省）']},{$v['售卖地区（市）']},{$v['数量']},{$v['促销活动']},{$v['购车形式']},{$v['车款建立日期']},{$v['销售状态']}\n";
        }
        return $csv;
    }
}
