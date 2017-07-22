<?php

/**
 * $Id: garageaction.php 1 2016-03-24 10:06:30Z cuiyuanxin $
 */
class garageaction extends action {

    public $friend;

    function __construct() {
        parent::__construct();
//        $this->type = new Type();
//        $this->article = new article();
//        $this->comment = new comment();
//        $this->pageData = new pageData();
//        $this->pricelog = new priceLog();
        $this->vars('garage', 'garage');
    }

    function doDefault() {
        $this->doParseIndex();
    }

//    function doIndex() {
//        $opt = $this->createshow(true);
//        if ($opt['o'] === 'make') {
//            $this->makeIndex();
//        } else {
//            echo $this->parseIndex();
//        }
//    }
//
//    function makeIndex() {
//        $filename = SITE_ROOT . "index.html";
//        $this->makePage(0, "index", $filename);
//    }

    function doparseIndex() {
        $template_name = "parseindex";
        if ($_GET['date'])
            $date = date('Y_m_d', strtotime($_GET['date']));
        else
            $date = date('Y_m_d');
        //各种车型补贴金额
//        $bt = array(
//            'zc' => array(
//                'zk' => array(
//                    '68y' => array(
//                        'w' => 3000,
//                        's' => 4500,
//                        'm' => 4000,
//                        'b' => 14000
//                    ),
//                    '8y' => array(
//                        'w' => 2500,
//                        's' => 4000,
//                        'm' => 3500,
//                        'b' => 12000
//                    )
//                ),
//                'zh' => array(
//                    '68y' => array(
//                        'w' => 2500,
//                        's' => 3000,
//                        'm' => 7000,
//                        'b' => 10000
//                    ),
//                    '8y' => array(
//                        'w' => '--',
//                        's' => 2500,
//                        'm' => 5000,
//                        'b' => 8000
//                    )
//                )
//            ),
//            'bf' => array(
//                'zk' => array(
//                    '68y' => array(
//                        'w' => 3500,
//                        's' => 5000,
//                        'm' => 4500,
//                        'b' => 14500
//                    ),
//                    '8y' => array(
//                        'w' => 3000,
//                        's' => 4500,
//                        'm' => 4000,
//                        'b' => 12500
//                    )
//                ),
//                'zh' => array(
//                    '68y' => array(
//                        'w' => 3000,
//                        's' => 3500,
//                        'm' => 7500,
//                        'b' => 10500
//                    ),
//                    '8y' => array(
//                        'w' => '--',
//                        's' => 3000,
//                        'm' => 5500,
//                        'b' => 8500
//                    )
//                )
//            )
//        );
//        $fields = array(
//            'name' => 'offers',
//            'c1' => 'index',
//            'c2' => 0,
//            'c3' => 0
//        );
//        $offers = array();
//        $result = $this->pageData->getPageData($fields, false);
//        if (!empty($result))
//            $offers = unserialize($result['value']);
//        $day = date('w');
//        $bid = $offers[0]['bid'][$day];
//        $sid = $offers[0]['sid'][$day];
//        if (!$bid || !$sid) {
//            $bid = 114;
//            $sid = 1083;
//        }
//        $offersUrl = "bingoprice.php?action=indexcompare&bid=$bid&sid=$sid";
//        $this->vars('offersUrl', $offersUrl);
//
//        $this->vars('bt', json_encode($bt));
        $page_title = "【车型大全_车型汇总】汽车品牌大全-ams车评网";
        $this->vars('title', $page_title);
        $keywords = "车型大全,汽车品牌大全,汽车大全";
        $this->vars('keyword', $keywords);
        $description = "ams车评网车型频道提供各种汽车品牌型号信息,包括SUV,MPV,大中小微紧凑型车,跑车,新能源等车型,可按价格,级别,排量,变速箱等筛选条件快速精准查找合适车型,最全汽车车型信息尽在ams车评网.";
        $this->vars('description', $description);
        //引入的JS CSS文件
        $this->vars('css', array('common', 'jquery.autocomplete', 'newbase', 'newindex'));
        $this->vars('js', array( 'jquery.cookie','newindex','global', 'brand', 'series', 'jquery.touchSwipe.min', 'jquery.nouislider.min', 'lrscroll'));
        $lujing = array(
            'url' => '/garage.php?action=parseindex',
            'title' => '车型大全',
            'b' => 'garage'
        );
        $this->vars('lujing',$lujing);
        $this->vars('date',$date);
        $this->vars('pageindex', 'index');
        $this->template($template_name, '', 'replaceNewsChannel');
    }

//    function doAttention() {
//        $uid = cookie('uid');
//        $uid = empty($uid) ? session('uid') : $uid;+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++3                     0
//        if (!$uid) {
//            echo '55';
//            exit;
//        }
//        $id = intval($_GET['id']);
//        $this->attention = new attention();
//        $flag = $this->attention->getAttention('state,id', "user_id=$uid and model_id=$id", '', 1);
//        if (empty($flag)) {
//            $state = $this->attention->insertAttention(array('user_id' => $uid, 'model_id' => $id, 'state' => 1, 'created' => time(), 'updated' => time()));
//            echo empty($state) ? '00' : '11';
//        } else {
//            if ($flag['state'] == '0') {
//                $where = "user_id=$uid and model_id=$id";
//                $ufields = array("updated" => time(), "state" => 1);
//                $state = $this->attention->updateAtt($ufields, $where);
//                echo empty($state) ? '00' : '11';
//            } else {
//                echo json_encode('22');
//            }
//        }
//    }
}

?>