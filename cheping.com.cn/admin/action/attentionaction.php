<?php

/**
 * description   关注列表及关注导出表格
 * $Id: attentionaction.php 1174 2015-11-05 01:22:27Z xiaodawei $
 */
class attentionAction extends action {

    function __construct() {
        parent::__construct();
        $this->brand = new brand();
        $this->series = new series();
        $this->user = new user();
        $this->users = new users();
        $this->attention = new attention();
        $this->order = new order();
        $this->ibuycarpricelog = new ibuycarpricelog();
        $this->priceinfo = new priceinfo();
    }

    function doDefault() {
        $this->doList();
    }

    //关注列表
    function doList() {
        $template = 'attention_list';
        $page = max(1, $this->getValue('page')->Int());
        $limit = 20;
        $offset = ($page - 1) * $limit;
        $where = ' and cg.status!=2 and cg.uid = cu.uid and cg.m_id = cmg.model_id';
        $fields = 'cg.create_times,cm.brand_name,cm.factory_name,cm.series_name,cm.model_name,cm.model_price,cg.province_name,cg.buy_time';
        $order = array('cg.create_times' => 'desc');
        $url = $_ENV['PHP_SELF'] . 'list';
        #所有注册用户
        $attentionlist = $this->attention->getInvitedregPage($where, $fields, $limit, $offset, $order);
        $page_bar = $this->multi($this->attention->total, $limit, $page, $url);

        $this->vars('attentionlist', $attentionlist);
        $this->vars('page_bar', $page_bar);
        $this->vars('url', $url);
        $this->vars('orderby', $this->getValue('orderby')->String());

        $this->template($template);
    }

    //导出表格
    function doExport() {

        $template = 'attention_list';
        $page = max(1, $this->getValue('page')->Int());
        $limit = 20;
        $offset = ($page - 1) * $limit;
        $buy_time = $this->getValue('buy_time')->Int();
        $time = time();
        if ($buy_time == 1) {
            $times = strtotime(date('y-m-d', time()));
            $where = "and cg.create_times > $times ";
        }
        if ($buy_time == 7) {
            $times = $time - 7 * 24 * 3600;
            $where = "and cg.create_times < $time and cg.create_times > $times";
        }
        if ($buy_time == 30) {
            $times = $time - 30 * 24 * 3600;
            $where = "and cg.create_times < $time and cg.create_times > $times";
        }
        if ($buy_time == 365) {
            $where = '';
        }
        $where .= ' and cg.status!=2 and cg.uid = cu.uid and cg.m_id = cmg.model_id';
        $fields = 'cg.create_times,cm.brand_name,cm.factory_name,cm.series_name,cm.model_name,cm.model_price,cg.province_name,cg.buy_time,cg.firstcolor,cg.secondcolor,cg.qi_price,cg.m_id,cu.uphone,cmg.price_type,cmg.goods_price';
        $order = array('cg.create_times' => 'desc');
        $url = $_ENV['PHP_SELF'] . 'list';
        #所有注册用户
        $attentionlist = $this->attention->getInvitedregPage($where, $fields, $limit, $offset, $order);
        $str = "序列,用户,关注日期,时间,品牌,厂商,车系,车款,指导价,页面价格,优惠幅度,上牌地区,购车日期,第一颜色,第二颜色,顾客期待售价\n";
        $i = 0;
        foreach ($attentionlist as $val) {
            $i++;
            if (empty($val))
                continue;
            if (empty($val['create_times'])) {
                $create_time = "";
            } else {
                $create_time = date('Y-m-d', $val['create_times']);
                $time = date('H:i', $val['create_times']);
            }
            if ($val['price_type'] == 'A') {
                $this->ibuycarpricelog->order = array('goods_price' => 'asc');
                $goods_price = $this->ibuycarpricelog->getList('goods_price', 'model_id=' . $val['m_id'], 3);
            }
            if ($val['price_type'] == 'B') {
                $goods_price = $val['goods_price'];
            }
            if ($goods_price != '0.00' && $goods_price != '0' && $goods_price != '') {
                $discount_rate = $val['model_price'] - $goods_price;
            }else{
                $discount_rate = 0;
            }
            $str .= $i . ',' . $val['uphone'] . ',' . $create_time . ',' . $time . ',' . $val['brand_name'] . ',' . $val['factory_name'] . ',' . $val['series_name'] . ',' . $val['model_name'] . ',' . $val['model_price'] . ',' . $goods_price . ',' . $discount_rate . ',' . $val['province_name'] . ',' . $val['buy_time'] . ',' . $val['firstcolor'] . ',' . $val['secondcolor'] . ',' . $val['qi_price'] . "\n";
        }
        $this->exportExcel('exportexcel', '关注分析表格', $str);
        // var_dump($userinvitedlist);
    }

    /**
     * @param string $en_name 保存的英文名
     * @param string $cn_name 输出的中文名
     */
    function exportExcel($en_name, $cn_name, $str) {
        if (!is_dir(ATTACH_DIR . 'tmp'))
            file::forcemkdir(ATTACH_DIR . 'tmp');
        $filePath = ATTACH_DIR . "tmp/{$en_name}.csv";

        if (file_exists($filePath))
            unlink($filePath);
        file_put_contents($filePath, $str);
        $file = fopen($filePath, "r");
        Header("Content-type: application/octet-stream");
        Header("Accept-Ranges: bytes");
        Header("Accept-Length: " . filesize($filePath));
        Header("Content-Disposition: attachment; filename={$cn_name}.csv");
        echo fread($file, filesize($filePath));
        fclose($file);
    }

}
