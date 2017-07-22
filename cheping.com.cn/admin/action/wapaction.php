<?php

/**
 * wap action
 * $Id: wapaction.php 816 2015-10-13 15:07:43Z cuiyuanxin $
 */
class wapAction extends action {

    var $article;
    var $category;
    var $pagedate;

    function __construct() {
        global $adminauth, $login_uid;
        parent::__construct();
        $this->article = new article();
        $this->category = new category();
        $this->pagedate = new pageData();
//        $this->checkAuth(401);
    }

    function doDefault() {
        $this->dobannerIndex();
    }

    function doBannerIndex() {
        global $local_host;
        $template_name = "wap_index";
        $arr = array();
        if ($_POST) {
            $arrid = $this->postValue('id')->Val();
            $title = $this->postValue('title')->Val();
            $oldpic = $this->postValue('old_pic')->Val();
            $url = $this->postValue('url')->Val();
            $orderby = $this->postValue('orderby')->Val();
            $file = $_FILES['pic'];
            foreach ($arrid as $key => $value) {
                $arr[$key][id] = $value;
                $article = $this->article->getArticleFields("id,title,uptime,pic,title2,type_id,category_id", "id=$value", 1);

                $pid = $this->category->getlist("parentid", "id=$article[category_id]", 3);

                if ($file['error'][$key] === 0) {
                    $pic_name = $file['tmp_name'][$key];
                    $pic_path = $this->uploadPic($pic_name, 'articlehot');
                    $arr[$key][pic] = $pic_path;
                } else {
                    $arr[$key][pic] = $this->article->getArticlePic($oldpic[$key], '750x254');
                }

                $arr[$key][uptime] = $article[uptime];

                $arr[$key][url] = $url[$key];
                if ($article) {
                    $arr[$key][title] = $article[title];
                } else {
                    $arr[$key][title] = $title[$key];
                }
                $arr[$key][orderby] = $orderby[$key];
                $arr[$key][p_category_id] = $pid;
                if ($article['type_id'] == 1) {
                    $arr[$key][cname] = 'article';
                } else if ($article['type_id'] == 2) {
                    $arr[$key][cname] = 'video';
                } else {
                    $arr[$key][cname] = '其他';
                }
                //二维数组排序
                $sort[$key] = $orderby[$key];
            }
            array_multisort($sort, SORT_ASC, $arr);

            switch ($_GET['a']) {
                case 0:
                    $data['name'] = 'wap_index';
                    break;
                case 1:
                    $data['name'] = 'wap_new';
                    break;
                case 2:
                    $data['name'] = 'wap_pingce';
                    break;
                case 3:
                    $data['name'] = 'wap_video';
                    break;
                case 4:
                    $data['name'] = 'wap_wenhua';
                    break;
            }

            $data['value'] = serialize($arr);
            $pdid = $this->pagedate->getSomePagedata("id", "name='$data[name]'", 3);
            if ($pdid) {
                $date['updated'] = time();
                $this->pagedate->ufields = $data;
                $this->pagedate->where = "id=$pdid";
                $ret = $this->pagedate->update();
                $msg = "修改";
            } else {
                $data['created'] = time();
                switch ($GET['a']) {
                    case 0:
                        $data['notice'] = 'wap首页轮播图';
                        break;
                    case 1:
                        $data['notice'] = 'wap新闻轮播图';
                        break;
                    case 2:
                        $data['notice'] = 'wap评测轮播图';
                        break;
                    case 3:
                        $data['notice'] = 'wap视频轮播图';
                        break;
                    case 4:
                        $data['notice'] = 'wap文化轮播图';
                        break;
                }

                $this->pagedate->ufields = $data;
                $ret = $this->pagedate->insert();
                $msg = "添加";
            }
            if ($ret) {
                $msg .= "成功";
            } else {
                $msg .= "失败";
            }
            $this->alert('WAP轮播' . $msg, 'js', 3);
        } else {
            $a = $this->getValue('a')->Int();
            switch ($a) {
                case 0:
                    $name = "banner_index";
                    break;
                case 1:
                    $name = "banner_news";
                    break;
                case 2:
                    $name = "banner_pingce";
                    break;
                case 3:
                    $name = "banner_video";
                    break;
                case 4:
                    $name = "banner_wenhua";
                    break;
            }


            $str = $this->pagedate->getSomePagedata("value", "name='$name'", 3);
            $list = unserialize($str);

            $b = $a;
            $b++;
            $this->vars("list", $list);
            $this->vars("a", $a);
            $this->vars("b", $b);
            $this->template($template_name);
        }
    }

    /**
     * 生成shmtl文件
     * @global type $local_host
     */
    function doBannerMake() {
        global $local_host;
        $name = $this->getValue('name')->String();
        #type编号说明：1="wap_index",2="wap_news",3="wap_pingce",4="wap_video",5="wap_wenhua"
        $type = $this->getValue('type')->Int();

        if (in_array($type, array(1, 2, 3, 4, 5)) !== false) {
            $str = $this->pagedate->getSomePagedata("value", "name='$name'", 3);
            if ($str) {
                $banner = unserialize($str);
            }
            if ($banner) {
                foreach ($banner as $key => $value) {
                    $banner[$key]['pic'] = $value['pic'];
                }
            }
            $this->vars("banner", $banner);
            $tplName = 'ssi_banner_' . $name;
            $fileName = WWW_ROOT . 'ssi/ssi_banner_' . $name . '.shtml';
        }
        #下面代码无用，暂时屏蔽，不执行
        elseif (0) {
            $arr = array("banner_index", "banner_news", "banner_pingce", "banner_video", "banner_wenhua");
            foreach ($arr as $k => $v) {
                $str = $this->pagedate->getSomePagedata("value", "name='$v'", 3);
                if ($str) {
                    $banner = unserialize($str);
                }
                if ($banner) {
                    foreach ($banner as $key => $value) {
                        $banner[$key]['alt'] = str_replace(array('"', "'"), array('', ''), $value['title']);
                        $tag_list = $this->article->getArticleFields("tag_list", "id=$value[id]", 1);
                        //标签
                        $taglist = $this->tags->getTagFields("id,tag_name", "state=1 and id in($tag_list[tag_list])", 2);
                        $banner[$key]['url'] = $this->article->getRewriteUrlByUrl($banner[$key]['url']);
                        $banner[$key]['taglist'] = $taglist;
                    }
                }

                $this->vars("banner", $banner);
                $tplName = 'ssi_banner_' . $v;
                $fileName = WWW_ROOT . 'ssi/ssi_banner_' . $v . '.shtml';
            }
        }
        $html = $this->fetch($tplName);
        $html = str_replace($local_host, '', $html);
        $html = replaceArticleUrl($html);
        $html = replaceVideoUrl($html);
        $html = preg_replace('/href="(.+?)\.html([^\'">]+)/im', 'href="\1.html', $html);
        //生成文件
        $length = file_put_contents($fileName, $html);
        if (empty($length)) {
            echo 0;
        } else {
            echo 1;
        }
    }

    /**
     * 上传图片
     * @param type $file 上传的临时文件
     * @param type $dir 上传目录
     * @return type  $file_name. $fileName 图片地址名称
     */
    function uploadPic($file, $dir = 'articletitle') {
        global $watermark_opt;
        $uploadRootDir = ATTACH_DIR . "images/$dir/wap/";
        file::forcemkdir($uploadRootDir);
        $uploadDir = $uploadRootDir . date("Y/m/d", time()) . '/';
        file::forcemkdir($uploadDir);
        $file_name = "images/$dir/wap/" . date("Y/m/d", time()) . '/';
        $fileName = util::random(12);
        $fileName .= '.jpg';
        move_uploaded_file($file, $uploadDir . $fileName);
        if ($dir == 'articletitle') {
            imagemark::resize($uploadDir . $fileName, "820x550", 820, 550, '', $watermark_opt);
            imagemark::resize($uploadDir . $fileName, "344x258", 344, 258, '', $watermark_opt);
            imagemark::resize($uploadDir . $fileName, "280x186", 280, 186, '', $watermark_opt);
            imagemark::resize($uploadDir . $fileName, "160x120", 160, 120, '', $watermark_opt);
        } else {
            imagemark::resize($uploadDir . $fileName, "750x360", 750, 254, '', $watermark_opt);
        }
        return $file_name . $fileName;
    }

}

?>
