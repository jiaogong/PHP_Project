<?php

/**
 * pic action
 * $Id: picaction.php 1551 2015-12-08 02:40:48Z zuiyuanxin $
 */
class picAction extends action {

    var $cardbfile;
    var $pagedata;

    function __construct() {
        global $adminauth, $login_uid;
        parent::__construct();
        $this->cardbfile = new cardbFile();
        $this->pagedata = new pageData();
        //$this->checkAuth(401);
    }

    function doDefault() {
        $this->doList();
    }
    /**
     * 水印处理
     * @param type $watermark 水印位置,$wxstate 水印状态,waterpic 水印图片
     * @param type $list 分配到前台的变量
     */
    function doList() {
        $this->page_title = "水印处理";
        $this->tpl_file = "pic_list";
        if ($this->postValue('watermark')->Exist()) {
            $watermark = $this->postValue('watermark')->Val(); //获取ams水印的位置值
            if ($_FILES['waterpic']['tmp_name']) {
                $waterpic = $this->uploadPic($_FILES['waterpic']['tmp_name']); //如果有把临时目录给变量$waterpic赋值
            } else {
                $waterpic = $this->postValue('waterpic')->Val(); //如果有把临时目录给变量$waterpic赋值
            }
            $wxwatermark = $this->postValue('wxwatermark')->Val();//获取微信水印位置的值
            $wxstate = $this->postValue('wxstate')->Int();//ams水印状态值
            $watstate = $this->postValue('watstate')->Int();//微信水印位置值
             
            if ($_FILES['wxwaterpic']['tmp_name']) {
                $wxwaterpic = $this->uploadPic($_FILES['wxwaterpic']['tmp_name'], 'wx'); //如果有把临时目录给变量$wxwaterpic赋值
            } else {
                $wxwaterpic = $this->postValue('wxwaterpic')->Val(); //如果有把临时目录给变量$wxwaterpic赋值
            }
            //建立要插入的数组
            $arr = array(
                'waterpic' => $waterpic,
                'watermark' => $watermark,
                'wxwaterpic' => $wxwaterpic,
                'wxstate' => $wxstate,
                'watstate' => $watstate,
                'wxwatermark' => $wxwatermark
            );

            $data['name'] = 'waterpic'; //把值赋给data数组
            $data['value'] = serialize($arr); //把序列化给data
            $value = $this->pagedata->getSomePagedata("id", "name='waterpic'", 3); //按id查询,如果有值就更新,没有值就插入
            if ($value) {
                $data['updated'] = $this->timestamp;
                  $rr = $this->pagedata->updatePageData($data, "id='{$value}'");
            } else {
                $data['created'] = $this->timestamp;
                $data['notice'] = '水印管理';
                $this->pagedata->insertPageData($data);
            }
            $this->alert('配置成功', 'js', 3, $_ENV['PHP_SELF']);
        } 
        else {
            $value = $this->pagedata->getSomePagedata("value", "name='waterpic'", 3);
            $list= mb_unserialize($value);

            $this->vars('list', $list);
            $this->vars('local', ADMIN_PATH); //根目录赋给前台
            $this->template();
        }
    }
    /**
     * 处理批量生成图片水印的ajax
     * @param type $value 查询水印的value值
     * @param type $arr 拼接路径
     * @return -4 生成水印成功  no 是不成功
     */
    function doWaterpic() {
        global $watermark_opt;
        $type = $this->requestValue('i')->Val();
        if ($type == 1) {
            $value = $this->pagedata->getSomePagedata("value", "name='waterpic'", 3); //按name查询
            $list = mb_unserialize($value);
            $waterpic = SITE_ROOT . $list['waterpic']; //赋值
            $piclist = $this->cardbfile->getlist("*", "type_id!=0 and type_name='artile_pic'", 2); //查询符合条件的所有字段
            if ($piclist)
                foreach ($piclist as $key => $value) {
                    $arr = ATTACH_DIR . "images/article/" . date('Y/m/d', $value['created']) . "/" . $value['name']; //拼接路径
                    #计算图片宽、高，以高度为准
                    $t = @getimagesize($arr);
                    $_width = 820;
                    $_height = 540;
                    if ($t[1]) {
                        $_a = round($t[0] / 820, 2);
                        $_height = $t[1] / $_a;
                    }
                    $ret = imagemark::resize($arr, "820x540", $_width, $_height, '', $watermark_opt);
                    $rets = imagemark::resize($arr, "280x186", 280, 186, '', $watermark_opt);
                    $retss = imagemark::resize($arr, "160x120", 160, 120, '', $watermark_opt);
                    if (!$ret['tempurl']) {
                        continue;
                    } else {
                        //生成水印
                        $w = imagemark::watermark($ret['tempurl'], array('type' => 'file', 'file' => $waterpic), $list['watermark'], '', $watermark_opt);
                        $wa = imagemark::watermark($rets['tempurl'], array('type' => 'file', 'file' => $waterpic), $list['watermark'], '', $watermark_opt);
                        $wat = imagemark::watermark($retss['tempurl'], array('type' => 'file', 'file' => $waterpic), $list['watermark'], '', $watermark_opt);
                    }
                }

            if ($w !== 'false' && $wa !== 'false' && $wat !== 'false') {
                echo -4;
            } else {
                echo 'no';
            }
        }
    }

    /**
     * 上传图片
     * @param type $file 上传的临时文件
     * @param type $dir 上传目录
     * @return type  $file_name. $fileName 图片地址名称
     */
    function uploadPic($file, $dir = 'watermark') {
        $uploadRootDir = SITE_ROOT . "images/$dir/";
        file::forcemkdir($uploadRootDir);
        if ($dir == 'wx') {
            $fileName = 'wxwaterpic';
            $fileName .= '.png';
        } else {
            $fileName = 'waterpic';
            $fileName .= '.png';
        }
        move_uploaded_file($file, $uploadRootDir . $fileName);
        return "images/$dir/" . $fileName;
    }

}
