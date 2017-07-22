<?php

/**
 * factory action
 * $Id: factoryaction.php 3173 2016-06-23 04:05:05Z wangchangjiang $
 * @author David.Shaw
 */
class factoryAction extends action {

    var $factory;
    var $brand;

    function __construct() {
        parent::__construct();
        $this->factory = new factory();
        $this->brand = new brand();
    }

    function doDefault() {
        $this->doList();
    }

    function doList() {
        $template_name = "factory_list";
        $this->page_title = "汽车厂商列表";

        $extra = $brand_id = $keyword = $rkeyword = null;

        $page = $this->getValue('page')->Int();
        $father_id = $this->getValue('fatherId')->Int();
        $extra = "&fatherId={$father_id}";

        $this->checkAuth($father_id);

        $brand_id = $this->requestValue('brand_id')->Int();
        $keyword = $this->requestValue('keyword')->UrlDecode();
        $rkeyword = $keyword = $this->addValue($keyword)->stripHtml(1);

        $page = max(1, $page);
        $page_size = 20;
        $page_start = ($page - 1) * $page_size;
        $where = "f.brand_id=b.brand_id and f.brand_id='{$father_id}'";
        if ($brand_id) {
            $where .= " and f.brand_id='{$brand_id}'";
            $extra .= "&brand_id={$brand_id}";
        }
        if ($keyword) {
            $where .= " and f.factory_name like '%{$keyword}%'";
            $extra .= "&keyword={$rkeyword}";
        }

        $factory_list = $this->factory->getAllFactory($where, array('f.letter' => 'asc'), $page_size, $page_start);
        $page_bar = $this->multi($this->factory->total, $page_size, $page, $_ENV['PHP_SELF'] . $extra);

        $brand_list = $this->brand->getAllBrand("state=3", array('letter' => 'asc'), 300);

        $this->vars('page_title', $this->page_title);
        $this->vars('list', $factory_list);
        $this->vars('brand_list', $brand_list);
        $this->vars('page_bar', $page_bar);
        $this->vars('brand_id', $brand_id);
        $this->vars('fatherId', $father_id);
        $this->vars('keyword', $keyword);
        $this->vars('rkeyword', $rkeyword);
        $this->template($template_name);
    }

    function doAdd() {
        global $factory_df_state;

        $template_name = "factory_add";
        $this->page_title = "新建汽车厂商";

        if ($_POST) {
            if ($factory_df_state) {
                $fact_state = $factory_df_state;
            } else {
                $fact_state = 1;
            }

            #修改
            $factory_id = $this->postValue('factory_id')->Int();
            $fatherid = $this->postValue('fatherId')->Int();
            $factory_name = $this->postValue('factory_name')->String();
            $factory_alias = $this->postValue('factory_alias')->String();
            $factory_import = $this->postValue('factory_import')->String();
            
            if ($factory_id) {
                $factory_id = $this->postValue('factory_id')->Int();
                $this->checkAuth($fatherid);
                
                $this->factory->ufields = array(
                    'factory_name' => $factory_name,
                    'factory_alias' => $factory_alias,
                    'factory_import' => $factory_import,
                    'state' => $fact_state,
                    'updated' => $this->timestamp,
                    'letter' => util::Pinyin($factory_name),
                );
                $this->factory->where = "factory_id='{$factory_id}'";
                $ret = $this->factory->update();
                if ($ret) {
                    #更新厂商下车系
                    $series_obj = new series();
                    $series_obj->ufields = array(
                        'factory_name' => $factory_name,
                    );
                    $series_obj->where = "factory_id='{$factory_id}'";
                    $series_obj->update();

                    #更新厂商下车款
                    $model_obj = new cardbModel();
                    $model_obj->ufields = array(
                        'factory_name' => $factory_name,
                    );
                    $model_obj->where = "factory_id='{$factory_id}'";
                    $model_obj->update();

                    $msg = "成功";
                } else {
                    $msg = "失败";
                }
                $this->alert("厂商信息修改{$msg}！", 'js', 3, $_ENV['PHP_SELF'] . "&fatherId=" . $fatherid);
            }
            #添加
            else {
                $this->checkAuth(801, 'sys_module');
                $brand_id = $this->postValue('brand_id')->Int();
                $brand_name = $this->postValue('brand_name')->String();
                $this->factory->ufields = array(
                'brand_name' => $brand_name,
                'brand_id' => $brand_id,
                'factory_name' => $factory_name,
                'factory_alias' => $factory_alias,
                'state' => $fact_state,
                'created' => $this->timestamp,
                'updated' => $this->timestamp,
                'letter' => util::Pinyin($factory_name),
                );

                $ret = $this->factory->insert();

                if ($ret) {
                    $msg = "成功";
                } else {
                    $msg = "失败";
                }
                $this->alert("新建厂商{$msg}！", 'js', 3, $_ENV['PHP_SELF'] . "&fatherId=" . $brand_id);
            }
        }
        #显示修改/添加页面
        else {
            $brand = $this->brand->getAllBrand('state=3', array('letter' => 'asc'), 300);

            $this->vars('brand', $brand);
            $fatherid = $this->getValue('fatherId')->Int();
            $factoryid = $this->getValue('factory_id')->Int();
            if ($factoryid) {
                $this->checkAuth($fatherid);

                $this->page_title = "参数修改";
                $factory = $this->factory->getFactory($factoryid, -1);
                $this->vars('factory', $factory);
            } else {
                if ($fatherid) {
                    $this->checkAuth($fatherid);
                } else {
                    $this->checkAuth(801, 'sys_module');
                }
            }
            $this->vars('fi_list', $this->factory->factory_import);
            $this->vars('fatherid', $fatherid);
            $this->template($template_name);
        }
    }

    function doEdit() {
        $this->doAdd();
    }

    function doDel() {
        $id = $this->getValue('factory_id')->Int();
        $this->checkAuth($this->getValue('fatherId')->Int());

        $this->factory->where = "factory_id='{$id}'";
        $this->factory->ufields = array(
            'state' => 0
        );
        $ret = $this->factory->update();

        if ($ret) {
            #删除厂商下的车系和车款
            $series_obj = new series();
            $model_obj = new cardbModel();
            $series_obj->where = "factory_id='{$id}'";
            $series_obj->ufields = array('state' => 0);
            $sr = $series_obj->update();

            $model_obj->where = "factory_id='{$id}'";
            $model_obj->ufields = array('state' => 0);
            $mr = $model_obj->update();

            $msg = "成功";
        } else {
            $msg = "失败";
        }
        $this->alert("厂商删除{$msg}!", 'js', 3, $_ENV['PHP_SELF']);
    }

    function doJson() {
        $id = $this->getValue('brand_id')->Int();
        #$this->checkAuth($id);

        $list = $this->factory->getAllFactory("f.brand_id=b.brand_id and f.brand_id='{$id}' and f.state=3", array('f.letter' => 'asc'), 100);

        $ret = array();
        foreach ($list as $key => $value) {
            $ret[] = array(
                'factory_id' => $value['factory_id'],
                'factory_name' => $value['factory_name']
            );
        }

        echo json_encode($ret);
    }
    function doAllStateJson() {
        $id = $this->getValue('brand_id')->Int();
        $list = $this->factory->getAllFactory("f.brand_id=b.brand_id and f.brand_id='{$id}' and f.state in (3,8,9,11)", array('f.letter' => 'asc'), 100);
        $ret = array();
        foreach ($list as $key => $value) {
            $ret[] = array(
                'factory_id' => $value['factory_id'],
                'factory_name' => $value['factory_name']
            );
        }
        echo json_encode($ret);
    }
    function doFixData() {

        $count = 0;
        $data = $this->factory->getAllFactory(
                "f.brand_id=b.brand_id and f.brand_name=''", array('f.letter' => 'asc'), 500
        );
        foreach ($data as $key => $v) {
            $this->factory->ufields = array(
                'brand_name' => $v['brand_name'],
            );
            $this->factory->where = "factory_id='{$v['factory_id']}'";
            $r = $this->factory->update();
            if ($r) {
                $count++;
            }
        }
        #echo "count: {$count} ok!";
        return true;
    }

    function checkAuth($id, $module_type = 'brand_module', $type_value = "A") {
        global $adminauth, $login_uid;
        $adminauth->checkAuth($login_uid, $module_type, $id, 'A');
    }

    //判断厂商下是否有在售车系（state=3），没有修改厂商状态为9
    function doStopFactory() {
        $series = new series();
        $factoryResult = $this->factory->getFactorylist('factory_id', "state=3", 2);
        if ($factoryResult) {
            foreach ($factoryResult as $val) {
                $seriesResult = $series->getSeriesdata('count(*) total', "factory_id={$val['factory_id']} and state=3", 3);
                if (empty($seriesResult)) {
                    $this->factory->ufields = array('state' => 9);
                    $this->factory->where = "factory_id={$val['factory_id']}";
                    $this->factory->update();
                    error_log('[' . date('Y-m-d h:i:s') . '] [' . $this->factory->sql . ']' . "\n", 3, SITE_ROOT . 'data/log/stopfactory.log');
                }
            }
        }
    }

}

?>
