<?php

class remenAction extends action {

    var $state = array(
        "0" => "微型",
        "1" => "小型车",
        "2" => "紧凑型",
        "3" => "中型车",
        "4" => "中大型",
        "5" => "豪华车",
        "6" => "SUV",
        "7" => "MPV",
        "8" => "跑车",
    );

    function __construct() {
        parent::__construct();
        $this->brand = new brand();
        $this->factory = new factory();
        $this->series = new series();
        $this->models = new cardbModel();
        $this->pagedate = new pageData();
    }

    function doDefault() {
        $this->doList();
    }

    function doList() {
        $this->page_title = "热门车型";
        $template_name = "remen_list";
        $state = $this->getValue('state')->Int(0);
        switch ($state) {
            case 0:
                $data['name'] = 'rweixing';
                break;
            case 1:
                $data['name'] = 'rxiaoxingche';
                break;
            case 2:
                $data['name'] = 'rjincouxing';
                break;
            case 3:
                $data['name'] = 'rzhongxingche';
                break;
            case 4:
                $data['name'] = 'zhongdaxing';
                break;
            case 5:
                $data['name'] = 'rhaohuache';
                break;
            case 6:
                $data['name'] = 'rsuv';
                break;
            case 7:
                $data['name'] = 'rmpv';
                break;
            case 8:
                $data['name'] = 'rpaoche';
                break;
        }

        if ($_POST) {
            unset($_POST['maxservice']);
            $array = array();
            foreach ($_POST as $key => $value) {
                if ($value) {
                    foreach ($value as $k => $v) {
                        $array[$k][$key] = $v;
                    }
                }
            }
            if ($array) {
                $data['value'] = serialize($array);
                $res = $this->pagedate->getSomePagedata("id", "name='{$data['name']}'", 3);
                if ($res) {
                    $date['updated'] = $this->timestamp;
                    $this->pagedate->ufields = $data;
                    $this->pagedate->where = "id={$res}";
                    $this->pagedate->update();
//                    echo $this->pagedate->sql;
//            exit;
                } else {
                    $key = array_search($state, $this->state);
                    $data['created'] = $this->timestamp;
                    $data['notice'] = '热门车型-' . $this->state[$key];
                    $this->pagedate->ufields = $data;
                    $this->pagedate->insert();
                }
                $this->alert('处理成功', 'js', 3, $_ENV['PHP_SELF'] . '&state=' . $state);
            }
        } else {
            $str = $this->pagedate->getSomePagedata("value", "name='{$data['name']}'", 3);
            $list = unserialize($str);
            if ($list) {
                foreach ($list as $key => $value) {
                    $list[$key]['factory'] = $this->factory->getFactorylist("factory_id,factory_name", "state=3 and brand_id='{$value['brand_id']}'", 2);
                    $list[$key]['series'] = $this->series->getSeriesdata("series_id,series_name", "state=3 and brand_id='{$value['brand_id']}' and factory_id='{$value['factory_id']}'", 2);
                    $list[$key]['models'] = $this->models->getSimp("model_id,model_name", "state=3 and brand_id='{$value['brand_id']}' and factory_id='{$value['factory_id']}' and series_id='{$value['series_id']}'", 2);
                }
            }
            $status = $this->getValue('state')->Int();
            $brand = $this->brand->getAllBrand('state=3', array('letter' => 'asc'), 200);
            $this->vars('state', $this->state);
            $this->vars('status', $status);
            $this->vars("brand", $brand);
            $this->vars("list", $list);
            $this->template($template_name);
        }
    }

    function doDel() {
        $status = $this->getValue('state')->Int();
        $id = $this->getValue('id')->Int(0);
        switch ($status) {
            case 0:
                $data['name'] = 'rweixing';
                break;
            case 1:
                $data['name'] = 'rxiaoxingche';
                break;
            case 2:
                $data['name'] = 'rjincouxing';
                break;
            case 3:
                $data['name'] = 'rzhongxingche';
                break;
            case 4:
                $data['name'] = 'zhongdaxing';
                break;
            case 5:
                $data['name'] = 'rdaxingche';
                break;
            case 6:
                $data['name'] = 'rsuv';
                break;
            case 7:
                $data['name'] = 'rmpv';
                break;
            case 8:
                $data['name'] = 'rpaoche';
                break;
        }
        $del = $this->pagedate->getSomePagedata("value", "name='{$data['name']}'", 3);
        $list = unserialize($del);
        if ($list) {
            unset($list[$id]);
            $data['value'] = serialize($list);
            $res = $this->pagedate->getSomePagedata("id", "name='{$data['name']}'", 3);
            if ($res) {
                $date['updated'] = $this->timestamp;
                $this->pagedate->ufields = $data;
                $this->pagedate->where = "id={$res}";
                $this->pagedate->update();
            }
        }
        $this->alert('处理成功', 'js', 3, $_ENV['PHP_SELF'] . '$state=' . $status . '&id=' . $id);
    }
}

?>
