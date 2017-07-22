<?php

class realdataAction extends action {

    function __construct() {
        parent::__construct();
        $this->series = new series();
        $this->brand = new brand();
        $this->factory = new factory();
        $this->model = new cardbModel();
        $this->realdata = new realdata();
    }

    function doDefault() {
        $this->doIndex();
    }

    function doEdit() {
        $rid = $this->postValue('rid')->Int();
        $series_id = $this->postValue('series_id')->Int();
        $type = $this->postValue('type')->Val();
        $jump_url = "index.php?action=realdata-type&type=$type&series_id=$series_id";
        if (!empty($rid)) {
            if ($type == 1) {
                $receiver = array('front_height', 'front_leg', 'front_site', 'front_width', 'back_height', 'back_leg', 'back_site', 'back_width', 'series_id', 'date_id', 'st4', 'st21', 'st15');
                $receiverArr = receiveArray($receiver);
                $receiverArr['type'] = 1;
                $this->realdata->updateRealdata($receiverArr, $rid);
                $this->alert('修改成功！', 'js', 3, $jump_url);
            } else if ($type == 2) {
                $receiver2 = array('is_true', 'road', 'mileage', 'fuel', 'fuel_hour');
                $receiverArr2 = receiveArray($receiver2);
                $receiverArr2['road'] = $receiverArr2['is_true'] . $receiverArr2['road'];
                unset($receiverArr2['is_true']);
                $this->realdata->updateRealdata($receiverArr2, $rid);
                $this->alert('修改成功！', 'js', 3, 'index.php?action=realdata-type&type=2&series_id=' . $series_id);
            } else if ($type == 3) {
                $receiver3 = array('flag', 'noise', '60perh', '80perh', '120perh');
                $receiverArr3 = receiveArray($receiver3);
                $receiverArr3['type'] = '2' . $receiverArr3['flag'];
                unset($receiverArr3['flag']);
                $this->realdata->updateRealdata($receiverArr3, $rid);
                $this->alert('修改成功！', 'js', 3, 'index.php?action=realdata-type&type=2&series_id=' . $series_id);
            } else if ($type == 4) {
                $receiver4 = array('oil_level', 'change_cycle', 'oil_filter', 'oil_3filter');
                $receiverArr4 = receiveArray($receiver4);
                $this->realdata->updateRealdata($receiverArr4, $rid);
                $this->alert('修改成功！', 'js', 3, 'index.php?action=realdata-type&type=2&series_id=' . $series_id);
            } else if ($type == 5) {
                $receiver5 = array('conservate', 'purcharse_tax', 'new_energy');
                $receiverArr5 = receiveArray($receiver5);
                $this->realdata->updateRealdata($receiverArr5, $rid);
                $this->alert('修改成功！', 'js', 3, 'index.php?action=realdata-type&type=2&series_id=' . $series_id);
            }
        } else {
            if ($type == 1) {
                $receiver = array('front_height', 'front_leg', 'front_site', 'front_width', 'back_height', 'back_leg', 'back_site', 'back_width', 'series_id', 'date_id', 'st4', 'st21', 'st15');
                $receiverArr = receiveArray($receiver);
                $receiverArr['type'] = 1;
                $id = $this->realdata->insertRealdata($receiverArr);
                $this->alert('添加成功！', 'js', 3, $jump_url);
            }
        }
    }

    function doEditHtml() {
        $tpl_name = 'realdata';
        $type = $this->getValue('type')->Int();
        $series_id = $this->getValue('series_id')->Int();
        $date_id = $this->getValue('date_id')->Int();
        if ($type == 1) {
            $st4 = $this->getValue('st4')->String();
            $st21 = $this->getValue('st21')->String();
            $st15 = $this->getValue('st15')->String();
            $where = "date_id = $date_id AND series_id = $series_id AND st4 = '$st4' AND st21 = '$st21' AND st15='$st15'";
            $data = $this->realdata->getRealdata('*', $where);
            if (!empty($data))
                $this->vars('rid', $data[0]['id']);
            $this->vars('data', $data);
            $this->vars('st4', $st4);
            $this->vars('st21', $st21);
            $this->vars('st15', $st15);
        }
        else if ($type == 2) {
            $id = $this->getValue('id')->Int();
            $data = $this->realdata->getRealdata('road,mileage,fuel,fuel_hour', "id=$id");
            if (!empty($data)) {
                $this->vars('data', $data);
            }
            $this->vars('rid', $id);
        } else if ($type == 3) {
            $id = $this->getValue('id')->Int();
            $data = $this->realdata->getRealdata('id,type,noise,60perh,80perh,120perh', "id=$id");
            if (!empty($data)) {
                $this->vars('data', $data);
            }
            $this->vars('rid', $id);
        } else if ($type == 4) {
            $id = $this->getValue('id')->Int();
            $where = "id = '$id'";
            $data = $this->realdata->getRealdata('oil_level,change_cycle,oil_filter,oil_3filter', $where);
            if (!empty($data[0]['oil_level']) or !empty($data[0]['change_cycle']) or !empty($data[0]['oil_filter']) or !empty($data[0]['oil_3filter'])) {
                $this->vars('data', $data);
            }
            $this->vars('rid', $id);
        } else if ($type == 5) {
            $id = $this->getValue('id')->Int();
            $where = "id = '$id'";
            $data = $this->realdata->getRealdata('new_energy,purcharse_tax,conservate', $where);
            if (!empty($data[0]['new_energy']) or !empty($data[0]['purcharse_tax']) or !empty($data[0]['conservate'])) {
                $this->vars('data', $data);
            }
            $this->vars('rid', $id);
        }
        $this->vars('series_id', $series_id);
        $this->vars('date_id', $date_id);
        $this->vars('type', $type);
        $this->template($tpl_name);
    }

    function doType() {
        $tpl_name = 'series_type';
        $series_id = $this->getValue('series_id')->Int();
        $type = $this->getValue('type')->Int();
        if ($type == 1) {
            //车款按照实测数据分类
            $series_type = $this->model->getStyleRange($series_id);
        } else if ($type == 2) {
            //车款按照动力相关数据分类
            $series_type = $this->model->getStylePower($series_id);
            $tempArr = array();
            foreach ($series_type as $key => $temp) {
                $tempArr[$key]['date_id'] = $temp['date_id'];
                $tempArr[$key]['st27'] = $temp['st27'];
                $tempArr[$key]['st41'] = $temp['st41'];
                $tempArr[$key]['st28'] = $temp['st28'];
                $tempArr[$key]['st48'] = $temp['st48'];
            }
            foreach ($tempArr as $key => $temp) {
                $where = "series_id=$series_id and type like '{$type}%'";
                foreach ($temp as $k => $temps) {
                    if ($k == 'st27') {
                        $where .= is_float($temps) ? " and $k={$temps}" : " and $k=".  floatval($temps);
                    } else {
                        $where .= " and $k='{$temps}'";
                    }
                }
                $tempVal = $this->realdata->getId($where);
                $series_type[$key]['id'] = $tempVal['id'];
                if (empty($tempVal)) {
                    $ufields = array('series_id' => $series_id, 'date_id' => $tempArr[$key]['date_id'], 'st27' => $tempArr[$key]['st27'], 'st41' => $tempArr[$key]['st41'], 'st28' => $tempArr[$key]['st28'], 'st48' => $tempArr[$key]['st48'], 'type' => $type);
                    $tempId = $this->realdata->insertRealdata($ufields);
                    $series_type[$key]['id'] = $tempId;
                }
            }
        }
        $this->vars('series_id', $series_id);
        $this->vars('series_type', $series_type);
        $this->vars('type', $type);
        $this->template($tpl_name);
    }

    function doIndex() {
        $tpl_name = 'series';
        $extra = $brand_id = $factory_id = $keyword = $rkeyword = null;
        $page = $this->getValue('page')->Int();
        $father_id = $this->getValue('fatherId')->Int();
        $extra = "&fatherId={$father_id}";
        $brand_id = $this->requestValue('brand_id')->Int();
        $factory_id = $this->requestValue('factory_id')->Int();
        $keyword = $this->requestValue('keyword')->UrlDecode();
        $rkeyword = $keyword = $this->addValue($keyword)->stripHtml(1);
        $page = max(1, $page);
        $page_size = 20;
        $page_start = ($page - 1) * $page_size;
        $where = "s.state=3 and s.brand_id=b.brand_id and f.factory_id=s.factory_id" . ($father_id ? " and s.factory_id='{$father_id}'" : "");
        if ($factory_id) {
            $where .= " and s.brand_id='{$brand_id}' and s.factory_id='{$factory_id}'";
            $extra .= "&brand_id={$brand_id}&factory_id={$factory_id}";

            $factory_list = $this->factory->getAllFactory("f.brand_id=b.brand_id and f.brand_id='{$brand_id}'", array('f.letter' => 'asc'), 100);

            $this->tpl->assign('factory_list', $factory_list);
            $this->tpl->assign('factory_id', $factory_id);
        }
        if ($keyword) {
            $where .= " and s.series_name like '%{$keyword}%'";
            $extra .= "&keyword={$rkeyword}";
        }

        $list = $this->series->getAllSeries($where, array('s.letter' => 'asc'), $page_size, $page_start);
        $page_bar = $this->multi($this->series->total, $page_size, $page, $_ENV['PHP_SELF'] . $extra);

        $brand_list = $this->brand->getAllBrand("state=3", array('letter' => 'asc'), 300);

        $this->tpl->assign('page_title', $this->page_title);
        $this->tpl->assign('list', $list);
        $this->tpl->assign('brand_list', $brand_list);
        $this->tpl->assign('page_bar', $page_bar);
        $this->tpl->assign('brand_id', $brand_id);
        $this->tpl->assign('fatherId', $father_id);
        $this->tpl->assign('keyword', $keyword);
        $this->tpl->assign('rkeyword', $rkeyword);
        $this->template($tpl_name);
    }

}

?>
