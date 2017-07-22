<?php

/**
 * theme action
 * $Id: themeaction.php 1327 2015-11-18 07:47:58Z wangchangjiang $
 */
class themeAction extends action {

    public $pagedate;
    public $article;

    function __construct() {
        parent::__construct();

        $this->pagedate = new pageData();
        $this->article = new article();
    }

    function doDefault() {
        $this->doGuangzhouBanner();
    }
    
    function doGuangzhouBanner() {
        global $local_host;
        $template_name = "theme_guangzhou_banner";
        $arr = array();
        if ($this->postValue('title')->Exist()) {
            $arrid = $this->postValue('id')->Val();
            $oldpic = $this->postValue('old_pic')->Val();
            $url = $this->postValue('url')->Val();
            $title = $this->postValue('title')->Val();
            $orderby = $this->postValue('orderby')->Val();
            $file = $_FILES['pic'];
            if ($arrid != "id") {
                foreach ($arrid as $key => $value) {
                    $arr[$key][id] = $value;
                    if ($file['error'][$key] === 0) {
                        $pic_name = $file['tmp_name'][$key];
                        $pic_path = $this->uploadPic($pic_name, 'theme');
                        $arr[$key]['pic'] = $pic_path;
                    } else {
                        $arr[$key]['pic'] = $oldpic[$key];
                    }

                    $arr[$key]['uptime'] = $this->timestamp;
                    $arr[$key]['url'] = $url[$key];
                    $arr[$key]['title'] = $title[$key];
                    $arr[$key]['orderby'] = $orderby[$key];
                    //二维数组排序
                    $sort[$key] = $orderby[$key];
                }
                array_multisort($sort, SORT_ASC, $arr);
                $data['name'] = 'theme_guangzhou_banner';
                $data['value'] = serialize($arr);
                $pdid = $this->pagedate->getSomePagedata("id", "name='theme_guangzhou_banner'", 3);
                if ($pdid) {
                    $data['updated'] = $this->timestamp;
                    $this->pagedate->ufields = $data;
                    $this->pagedate->where = "id = $pdid";
                    $this->pagedate->update();
                } else {
                    $data['created'] = $this->timestamp;
                    $data['notice'] = '广州车展';
                    $this->pagedate->ufields = $data;
                    $this->pagedate->insert();
                }
            }
        }
        $str = $this->pagedate->getSomePagedata("value", "name='theme_guangzhou_banner'", 3);
        $list = unserialize($str);
        $this->vars("list", $list);
        $this->template($template_name);
    }

    function doGuangZhouHeadline() {
        global $local_host;
        $template_name = "theme_guangzhou_headline";
        $arr = array();
        $arrid = $this->postValue('id')->Val();
        if ($this->postValue('title')->Exist()) {
            $arrid = $this->postValue('id')->Val();
            $url = $this->postValue('url')->Val();
            $title = $this->postValue('title')->Val();
            $orderby = $this->postValue('orderby')->Val();
            $state = $this->postValue('state')->Val();

            foreach ($title as $key => $value) {
                if ($arrid['key']) {
                    $arr[$key]['id'] = $arrid[$key];
                } else {
                    $arr[$key]['id'] = $this->timestamp;
                }
                $arr[$key]['title'] = $title[$key];
                $arr[$key]['uptime'] = $this->timestamp;
                $arr[$key]['url'] = $url[$key];
                $arr[$key]['orderby'] = $orderby[$key];
                $arr[$key]['state'] = $state[$key];

                //二维数组排序
                $sort[$key] = $orderby[$key];
            }
            array_multisort($sort, SORT_ASC, $arr);

            $data['name'] = 'theme_guangzhou_headline';
            $data['value'] = serialize($arr);
            $pdid = $this->pagedate->getSomePagedata("id", "name='theme_guangzhou_headline'", 3);
            if ($pdid) {
                $data['updated'] = $this->timestamp;
                $this->pagedate->ufields = $data;
                $this->pagedate->where = "id=$pdid";
                $this->pagedate->update();
            } else {
                $data['created'] = $this->timestamp;
                $data['notice'] = '广州车展头条+热门文章';
                $this->pagedate->ufields = $data;
                $this->pagedate->insert();
            }
        }
        $str = $this->pagedate->getSomePagedata("value", "name='theme_guangzhou_headline'", 3);
        $list = unserialize($str);
        $this->vars("list", $list);
        $this->template($template_name);
    }

    /**
     * 上传图片
     * @param type $file 上传的临时文件
     * @param type $dir 上传目录
     * @return type  $file_name. $fileName 图片地址名称
     */
    function uploadPic($file, $dir = 'theme') {
        global $watermark_opt;
        $uploadRootDir = ATTACH_DIR . "images/$dir/";
        file::forcemkdir($uploadRootDir);
        $uploadDir = $uploadRootDir . date("Y/m/d", time()) . '/';
        file::forcemkdir($uploadDir);
        $file_name = "images/$dir/" . date("Y/m/d", time()) . '/680x380';
        $fileName = util::random(12);
        $fileName .= '.jpg';
        move_uploaded_file($file, $uploadDir . $fileName);
        if ($dir == 'theme') {
            @imagemark::resize($uploadDir . $fileName, "680x380", 680, 380, '', $watermark_opt);
            @imagemark::resize($uploadDir . $fileName, "72x52", 72, 52, '', $watermark_opt);
        }else{
             @imagemark::resize($uploadDir . $fileName, "1180x400", 1180, 400, '', $watermark_opt);
        }
        return $file_name . $fileName;
    }

    //通过jtip查看图片
    function doPic() {
        $picture = $this->getValue('picture')->String();
        $path = ATTACH_DIR . $picture;
        if (is_file($path)) {
            echo "<img src='/attach/$picture' width='225' height='240'>";
        } else {
            echo iconv('gbk', 'utf-8', '没有图片');
        }
    }

    //设为头条状态
    function doAjaxHeadlineState() {
        $title = $this->postValue('title')->Val();
        $state = $this->postValue('state')->Val();
        $id = $this->postValue('id')->Val();
        $url = $this->postValue('url')->Val();
        $orderby = $this->postValue('orderby')->Val();
        $arr = array();
        if ($id) {
            foreach ($id as $key => $value) {
                $arr[$key]['title'] = $title;
                $arr[$key]['state'] = $state;
                $arr[$key]['id'] = $id;
                $arr[$key]['url'] = $url;
                $arr[$key]['orderby'] = $orderby;
                $data['name'] = 'theme_guangzhou_headline';
                $data['value'] = serialize($arr);
                $pdid = $this->pagedate->getSomePagedata("id", "name='theme_guangzhou_headline'", 3);
                if ($pdid) {
                    $data['updated'] =  $this->timestamp;
                    $data['notice'] = '广州车展头条';
                    $this->pagedate->ufields = $data;
                    $this->pagedate->where = "id=$pdid";
                    $this->pagedate->update();
                }
                if ($this->pagedate->affectedrows) {
                    echo json_encode("ok");
                } else {
                    echo -1;
                }
            }
        } else {
            foreach ($title as $key => $value) {
                $arr[$key]['title'] = $title;
                $arr[$key]['state'] = $state;
                $arr[$key]['id'] = $this->timestamp;
                $arr[$key]['url'] = $url;
                $arr[$key]['orderby'] = $orderby;
                $data['name'] = 'theme_guangzhou_headline';
                $data['value'] = serialize($arr);

                $data['created'] = $this->timestamp;
                $data['notice'] = '广州车展头条';
                $this->pagedate->ufields = $data;
                $this->pagedate->insert();
                if ($this->pagedate->affectedrows) {
                    echo json_encode("ok");
                } else {
                    echo -1;
                }
            }
        }
    }

}

?>