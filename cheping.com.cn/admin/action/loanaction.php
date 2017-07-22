<?php
/**
 * 车系贷款管理
 * $Id: loanaction.php 1791 2016-03-24 08:40:44Z wangchangjiang $
 */
class loanAction extends action {

    var $seriesLoan;
    var $model;
    var $series;
    var $brand;
    var $factory;

    public function __construct() {
        parent::__construct();
        $this->seriesLoan = new seriesLoan();
        $this->model = new cardbModel();
        $this->series = new series();
        $this->brand = new brand();
        $this->factory = new factory();
    }

    function doList() {
        $this->doDefault();
    }

    function doDefault() {
        $where = "";
        $where_loan = "cs.state=3 and ";
        $brandId = intval($_POST['brand_id'] ? $_POST['brand_id'] : $_GET['brand_id']);
        if ($brandId) {
            $where .= 'brand_id=' . $brandId . ' and ';
            $where_loan .='cs.brand_id=' . $brandId . ' and ';
            $factory = $this->factory->getFactorylist('factory_name,factory_id', "brand_id=$brandId", 2);
            $this->tpl->assign('factory', $factory);
            $this->tpl->assign('brand_id', $brandId);
            $factoryId = intval($_POST['factory_id'] ? $_POST['factory_id'] : $_GET['factory_id']);
            if ($factoryId) {
                $where .= 'factory_id=' . $factoryId . ' and ';
                $where_loan .= 'cs.factory_id=' . $factoryId . ' and ';
                $series = $this->series->getSeriesdata('series_name,series_id', "factory_id=$factoryId");
                $this->tpl->assign('series', $series);
                $this->tpl->assign('factory_id', $factoryId);
                $seriesId = intval($_POST['series_id'] ? $_POST['series_id'] : $_GET['series_id']);
                if ($seriesId) {
                    $where .= 'series_id=' . $seriesId . ' and ';
                    $where_loan .= 'cs.series_id=' . $seriesId . ' and ';
                    $this->tpl->assign('series_id', $seriesId);
                }
            }
        }
        if ($_REQUEST[sname]) {
            $ssort = $_REQUEST[ssort] == 'desc' ? asc : desc;
            $order = array("$_REQUEST[sname]" => "$_REQUEST[ssort]");
            $this->vars("ssort", $ssort);
        }
        //$seriesDB =  $this->series->getSeriesdata('series_id,series_name,factory_name,brand_name', $where . 'state=3');
        $where_loan = substr_replace("$where_loan", " ", -4);
        $seriesDB = $this->series->getSeriesLoan("cs.series_id,cs.series_name,cs.factory_name,cs.brand_name,csl.end_date,csl.name", $where_loan, $order, 2);
        // echo $this->series->sql;
        $brand = $this->brand->getAllBrand('state=3', array('letter' => 'asc'), 200);
        $this->tpl->assign('brand', $brand);
        $this->tpl->assign('seriesDB', $seriesDB);
        $this->template('all_series_loan');
    }

    #添加贷款信息

    function doAddLoan() {
        if ($_POST) {
            $seriesLoanState = 0;
            $receiverArr = array('loan_name', 'start_date', 'end_date', 'is_valid', 'loan_offer', 'loan_peroid', 'loan_channel', 'first_pay_rate', 'interest', 'free_period', 'loan_rate', 'month_pay', 'last_pay', 'repay_mode', 'commission', 'memo', 'brand_id', 'factory_id', 'series_id', 'model_info', 'first_pay_val', 'loan_val', 'last_pay_val', 'loan_condition');
            $receiver = receiveArray($receiverArr);
            $receiver['name'] = $receiver['loan_name'];
            $receiver['updated'] = time();
            $receiver['start_date'] = trim($receiver['start_date']);
            $receiver['end_date'] = trim($receiver['end_date']);
            $receiver['start_date'] = strtotime(substr($receiver['start_date'], 0, strrpos($receiver['start_date'], '-') + 3));
            $receiver['end_date'] = strtotime(substr($receiver['end_date'], 0, strrpos($receiver['end_date'], '-') + 3));
            $modelId = $receiver['model_info'];
            if ($receiver['interest'] === "")
                $receiver['interest'] = null;
            if ($receiver['last_pay'] === "")
                $receiver['last_pay'] = null;
            if (is_array($modelId)) {
                $this->model->updateModel(array('hasloan' => 0), "series_id={$receiver['series_id']} and state in (3,8)");
                #error_log($this->model->sql . "\n", 3, SITE_ROOT . 'data/log/xxa.txt');
                foreach ($modelId as $mid => $mnull) {
                    $mid = intval($mid);
                    if ($this->model->getSimp('model_id', "model_id=$mid and series_id={$receiver['series_id']} and state in (3,8)", 1)) {
                        $seriesLoanState = 1;
                        $this->model->updateModel(array('hasloan' => 1), "model_id=$mid");
                        #error_log($this->model->sql . "\n", 3, SITE_ROOT . 'data/log/xxb.txt');
                    }
                }
            } else {
                die("车系下没有车款信息&nbsp;&nbsp;&nbsp;&nbsp;<a href='{$_ENV['PHP_SELF']}loanlist&series_id={$receiver['series_id']}'>返回<a>");
            }
            if ($seriesLoanState) {
                unset($receiver['loan_name']);
                unset($receiver['model_info']);
                $this->seriesLoan->ufields = $receiver;
                if ($_POST['updatestate'] == 'trun') {
                    $id = intval($_POST['id']);
                    if ($id < 1) {
                        echo "信息有误&nbsp;&nbsp;&nbsp;&nbsp;<a href='index.php?action=loan'>返回</a>";
                        exit;
                    }
                    $this->seriesLoan->where = "id={$_POST['id']}";
                    $flag = $this->seriesLoan->update();
                    #error_log($this->seriesLoan->sql . "\n", 3, SITE_ROOT . 'data/log/xxc.txt');
                } else {
                    $this->seriesLoan->ufields['created'] = time();
                    $flag = $this->seriesLoan->insert();
                    #error_log($this->seriesLoan->sql . "\n", 3, SITE_ROOT . 'data/log/xxd.txt');
                }
                //echo $_ENV['PHP_SELF'] . "-loanlist&series_id={$receiver['series_id']}";exit;
                if ($flag)
                    $this->alert("成功！", 'js', 3, $_ENV['PHP_SELF'] . "loanlist&series_id={$receiver['series_id']}");
                else
                    $this->alert("失败！", 'js', 3, $_ENV['PHP_SELF']);
            }else {
                echo "信息有误&nbsp;&nbsp;&nbsp;&nbsp;<a href='index.php?action=loan'>返回</a>";
                exit;
            }
        } else {
            $seriesId = intval($_GET['series_id']);
            $factoryId = intval($_GET['factory_id']);
            $brandId = intval($_GET['brand_id']);
            if ($seriesId < 1)
                exit('车系参数有误');
            $seriesDB = $this->series->getSeriesdata('brand_id,factory_id,series_id,series_name', "series_id=$seriesId and state=3", 1);
            $seriesDB['updatestate'] = 'false';
            $seriesDB['start_date'] = $seriesDB['end_date'] = time();
            $modelDB = $this->model->getSimp('model_id,date_id,model_name,model_price', "series_id=$seriesId and state in (3,8)");
            $this->tpl->assign('selectModelDB', 'null');
            $this->tpl->assign('seriesDB', $seriesDB);
            $this->tpl->assign('modelDB', $modelDB);
            $this->tpl->assign('series_id', $seriesId);
            $this->tpl->assign('factory_id', $factoryId);
            $this->tpl->assign('brand_id', $brandId);
            $this->template('add_loan');
        }
    }

    #显示车系贷款列表

    function doLoanList() {
        $seriesId = intval($_GET['series_id']);
        $factoryId = intval($_GET['factory_id']);
        $brandId = intval($_GET['brand_id']);
        if ($seriesId < 1)
            exit('车系参数有误');
        $seriesDB = $this->seriesLoan->getSeries("csl.series_id=cs.series_id and csl.series_id=$seriesId", 'csl.*,cs.brand_name,cs.factory_name,cs.series_name', 2, array('created' => 'desc'));
        if (empty($seriesDB)) {
            echo "没有信息&nbsp;&nbsp;&nbsp;&nbsp;<a href='index.php?action=loan&brand_id=$brandId&factory_id=$factoryId'>返回</a>";
            exit;
        }
        $this->tpl->assign('seriesDB', $seriesDB);
        $this->tpl->assign('factory_id', $factoryId);
        $this->tpl->assign('brand_id', $brandId);
        $this->template('one_series_loan');
    }

    #显示车系某个贷款详细信息

    function doLoanInfo() {
        $id = intval($_GET['id']);
        $seriesId = intval($_GET['series_id']);
        if ($id < 1)
            exit('车系贷款列表参数有误');
        $seriesDB = $this->seriesLoan->getSeries("csl.series_id=cs.series_id and csl.id=$id");
        if (empty($seriesDB)) {
            echo "没有信息&nbsp;&nbsp;&nbsp;&nbsp;<a href='index.php?action=loan-loanlist&series_id=$seriesId'>返回</a>";
            exit;
        }
        $modelDB = $this->model->getSimp('model_id,date_id,model_name,model_price', "series_id=$seriesId and state in (3,8)");
        $selectModelDB = $this->model->getSimp('model_id', "series_id=$seriesId and hasloan=1 and state in (3,8)");
        $this->tpl->assign('selectModelDB', json_encode($selectModelDB));
        $this->tpl->assign('modelDB', $modelDB);
        //$seriesDB['series_name'] = $seriesDB['name'];
        $seriesDB['updatestate'] = 'trun';
        $this->tpl->assign('seriesDB', $seriesDB);
        $this->template('add_loan');
    }

    function doDel() {
        $seriesId = intval($_GET['series_id']);
        $this->seriesLoan->where = "series_id=$seriesId";
        $this->seriesLoan->del();
        $this->alert("删除成功", 'js', 3, $_ENV['PHP_SELF']);
    }

    //导出
    function doLoanlive() {
        set_time_limit(0);
        $serieslist = $this->seriesLoan->getSeries("csl.series_id=cs.series_id and cs.state=3", "csl.*,cs.brand_name,cs.factory_name,cs.series_name", 2);
        $title1 = "品牌,厂商,车系,贷款名称,有效期,政策当前有效(1有限，0无效),贷款渠道,贷款提供,首付比例（%）,利率（%）,贷款期限（月）,免息期（月）,贷款比例（%）,月供,尾款比例（%）,手续费,尾款返款方式（1 分期，2 一次性）,备注,适用车款";
        $str = $title1 . "\n";
        // var_dump($serieslist);
        // exit;
        foreach ($serieslist as $key => $value) {
            $selectModelDB = $this->model->getSimp('model_id,model_name,date_id,model_price', "series_id=$value[series_id] and hasloan=1 and state in (3,8)");

            $str .=$value['brand_name'] . ',' . $value['factory_name'] . ',' . $value['series_name'] . ',' . $value['name'] . ',' . date("Y-m-d", $value['start_date']) . '-' . date("Y-m-d", $value['end_date']) . ',' . $value['is_valid'] . ',' . $value['loan_channel'] . ',' . $value['loan_offer'] . ',' . $value['first_pay_rate'] . ',' . $value['interest'] . ',' . $value['loan_peroid'] . ',' . $value['free_period'] . ',' . $value['loan_rate'] . ',' . $value['month_pay'] . ',' . $value['last_pay'] . ',' . $value['commission'] . ',' . $value['repay_mode'] . ',' . $value['memo'] . ',';

            if ($selectModelDB) {
                foreach ($selectModelDB as $k => $v) {
                    $str .="《 $k 》 $v[model_name] ";
                }
                $str .=',';
            } else {
                $str .='' . ',';
            }

            rtrim($str, ',');
            $str .= "\n";
        }

        //@file_put_contents(SITE_ROOT.'data/model/sereistype.csv', $str, FILE_APPEND);
        Header("Content-type: application/vnd.ms-excel");
        Header("Content-Disposition: attachment; filename= sereistype.csv");
        //  trim($str);
        echo $str;
    }

}

?>