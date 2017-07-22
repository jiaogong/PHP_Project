<?php

class calculatorAction extends action {

    public function __construct() {
        parent::__construct();
        $this->model = new models ();
        $this->vars('garage', 'garage');
    }

    public function doDefault() {
        $this->doBrand();
    }

    public function doBrand() {
        $page_title = "【车价计算】购车贷款计算-购车费用计算-ams车评网";
        $this->vars('title', $page_title);
        $mid = intval($_GET['mid']);
        $bid = intval($_GET['bid']);
        $sid = intval($_GET['sid']);
        $allid = intval($_GET['all']);
        $allid = $allid ? $allid : 1;
        $model_price = $_GET['price'] * 10000;
        $this->vars('mid', $mid);
        $this->vars('bid', $bid);
        $this->vars('sid', $sid);
        $this->vars('allid', $allid);
        $fileds = "st27";
        $mPrice = $this->model->getOneModel($fileds, $mid);
        $st = $this->chekeed($mPrice[st27]);
        $this->vars('st', $st);
        $this->vars('model_price', $model_price);
        $keywords = "贷款购车计算,购车费用计算,购车计算" . date("Y", time()) . ",按揭购车计算,模拟购车计算,购车保险计算,购车价格计算,全款购车计算,分期购车计算";
        $this->vars('keyword', $keywords);
        $description = "购车计算器：ams车评网购车小工具包括,贷款购车计算、购车费用计算,为您提供准确的购车费用信息，让您的购车决策清晰顺畅。";
        $this->vars('description', $description);
        $template_name = "buycar_calculator";
        $this->tpl->assign('css', array('newbase', 'gcy','common'));
        $this->tpl->assign('js', array('jquery-1.8.3.min', 'brand', 'series', 'global', 'carpurchasecost'));
        $lujing = array(
//            'url' => '/search.php?action=index',
            'title' => '车价计算',
            'b' => 'calcul'
        );
        $this->vars('lujing',$lujing);
        $this->template($template_name);
    }

    public function doGetModelPrice() {
        $mid = $_GET['mid'];
        $fileds = "model_price,st27";
        $mPrice = $this->model->getOneModel($fileds, $mid);
        $mPrice[st] = $this->chekeed($mPrice[st27]);
        echo json_encode($mPrice);
    }

    public function chekeed($st) {
        if ($st > 0 && $st <= 1.0) {
            $mPrice[st27_check] = 1;
        } elseif ($st > 1.0 && $st <= 1.6) {
            $mPrice[st27_check] = 1.6;
        } elseif ($st > 1.6 && $st <= 2.0) {
            $mPrice[st27_check] = 2.0;
        } elseif ($st > 2.0 && $st <= 2.5) {
            $mPrice[st27_check] = 2.5;
        } elseif ($st > 2.5 && $st <= 3.0) {
            $mPrice[st27_check] = 3.0;
        } elseif ($st > 3.0 && $st <= 4.0) {
            $mPrice[st27_check] = 4.0;
        } else {
            $mPrice[st27_check] = 4.1;
        }
        return $mPrice[st27_check];
    }

}
