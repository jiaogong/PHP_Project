<?php

/**
 * app action
 * $Id: appaction.php 2409 2016-05-03 02:12:35Z david $
 */
class appAction extends action {

    var $article;
    var $category;
    var $pagedate;
    var $advice;

    function __construct() {
        global $adminauth, $login_uid;
        parent::__construct();
        $this->article = new article();
        $this->category = new category();
        $this->pagedate = new pageData();
        $this->advice = new advice();
//        $this->checkAuth(401);
    }

    function doDefault() {
        $this->doAppList();
    }

    function doAppList() {
        $this->page_title = "悦览列表";
        $this->tpl_file = "applist";

        global $local_host;
        $arr = array();
        if ($this->postValue('id')->Exist()) {
            $arrid = $this->postValue('id')->Val();
            $oldpic = $this->postValue('old_pic')->Val();
            $title = $this->postValue('title')->Val();
            $orderby = $this->postValue('orderby')->Val();
            $file = $_FILES['pic'];
            foreach ($arrid as $key => $value) {
                $arr[$key][id] = $value;
                $article = $this->article->getArticleFields("id,title,uptime,pic,title2,type_id,category_id", "id=$value and state=3", 1);
                if (!$article['id']) {
                    $this->alert('不能选择未审核文章/视频', 'js', 3);
                }
                $pid = $this->category->getlist("parentid", "id=$article[category_id]", 3);
                if ($file['error'][$key] === 0) {
                    $pic_name = $file['tmp_name'][$key];
                    $pic_path = $this->uploadPic($pic_name, 'articletitle');
                    $arr[$key]['pic'] = $pic_path;
                } else {
                    $arr[$key]['pic'] = $oldpic[$key];
                }
                $arr[$key]['uptime'] = $article['uptime'];
                if ($article) {
                    $arr[$key]['title'] = $article['title'];
                } else {
                    $arr[$key]['title'] = $title[$key];
                }
                $arr[$key]['orderby'] = $orderby[$key];
                $arr[$key]['p_category_id'] = $pid;
                if ($article['type_id'] == 1) {
                    $arr[$key]['cname'] = 'article';
                } else if ($article['type_id'] == 2) {
                    $arr[$key]['cname'] = 'video';
                } else {
                    $arr[$key]['cname'] = '其他';
                }
                //二维数组排序
                $sort[$key] = $orderby[$key];
            }
            array_multisort($sort, SORT_ASC, $arr);

            $data['name'] = 'applist';
            $data['value'] = serialize($arr);
            $pdid = $this->pagedate->getSomePagedata("id", "name='applist'", 3);
            if ($pdid) {
                $date['updated'] = $this->timestamp;
                $this->pagedate->ufields = $data;
                $this->pagedate->where = "id=$pdid";
                $this->pagedate->update();
            } else {
                $data['created'] = $this->timestamp;
                $data['notice'] = 'APP悦览列表';
                $this->pagedate->ufields = $data;
                $this->pagedate->insert();
            }
        }
        $str = $this->pagedate->getSomePagedata("value", "name='applist'", 3);
        $list = unserialize($str);

        $this->vars("list", $list);
        $this->template();
    }

    function dobannerIndex() {
        global $local_host;
        $template_name = "app_index";
        $arr = array();
        if ($this->postValue('id')->Exist()) {
            $arrid = $this->postValue('id')->Val();
            $oldpic = $this->postValue('old_pic')->Val();
            $url = $this->postValue('url')->Val();
            $title = $this->postValue('title')->Val();
            $orderby = $this->postValue('orderby')->Val();
            $file = $_FILES['pic'];
            foreach ($arrid as $key => $value) {
                $arr[$key][id] = $value;
                $article = $this->article->getArticleFields("id,title,uptime,pic,title2,type_id,category_id", "id=$value", 1);

                $pid = $this->category->getlist("parentid", "id=$article[category_id]", 3);

                if ($file['error'][$key] === 0) {
                    $pic_name = $file['tmp_name'][$key];
                    $pic_path = $this->uploadPic($pic_name, 'articlehot');
                    $arr[$key]['pic'] = $pic_path;
                } else {
                    $arr[$key]['pic'] = $oldpic[$key];
                }

                $arr[$key]['uptime'] = $article['uptime'];

                $arr[$key]['url'] = $url[$key];
                if ($article) {
                    $arr[$key]['title'] = $article['title'];
                } else {
                    $arr[$key]['title'] = $title[$key];
                }
                $arr[$key]['orderby'] = $orderby[$key];
                $arr[$key]['p_category_id'] = $pid;
                if ($article['type_id'] == 1) {
                    $arr[$key]['cname'] = 'article';
                } else if ($article['type_id'] == 2) {
                    $arr[$key]['cname'] = 'video';
                } else {
                    $arr[$key]['cname'] = '其他';
                }
                //二维数组排序
                $sort[$key] = $orderby[$key];
            }
            array_multisort($sort, SORT_ASC, $arr);


            $data['name'] = 'app_index';
            $data['value'] = serialize($arr);
            $pdid = $this->pagedate->getSomePagedata("id", "name='app_index'", 3);
            if ($pdid) {
                $date['updated'] = $this->timestamp;
                $this->pagedate->ufields = $data;
                $this->pagedate->where = "id=$pdid";
                $this->pagedate->update();
            } else {
                $data['created'] = $this->timestamp;
                $data['notice'] = 'app首页轮播图';
                $this->pagedate->ufields = $data;
                $this->pagedate->insert();
            }
        }
        $str = $this->pagedate->getSomePagedata("value", "name='app_index'", 3);
        $list = unserialize($str);

        $this->vars("list", $list);
        $this->template($template_name);
    }

    function dobannerNews() {
        global $local_host;
        $template_name = "app_news";
        $arr = array();
        if ($this->postValue('id')->Exist()) {
            $arrid = $this->postValue('id')->Val();
            $oldpic = $this->postValue('old_pic')->Val();
            $url = $this->postValue('url')->Val();
            $title = $this->postValue('title')->Val();
            $orderby = $this->postValue('orderby')->Val();
            $file = $_FILES['pic'];
            foreach ($arrid as $key => $value) {
                $arr[$key][id] = $value;
                $article = $this->article->getArticleFields("id,title,uptime,pic,title2,type_id,category_id", "id=$value", 1);

                $pid = $this->category->getlist("parentid", "id=$article[category_id]", 3);

                if ($file['error'][$key] === 0) {
                    $pic_name = $file['tmp_name'][$key];
                    $pic_path = $this->uploadPic($pic_name, 'articlehot');
                    $arr[$key]['pic'] = $pic_path;
                } else {
                    $arr[$key]['pic'] = $oldpic[$key];
                }


                $arr[$key]['uptime'] = $article['uptime'];

                $arr[$key]['url'] = $url[$key];
                if ($article) {
                    $arr[$key]['title'] = $article['title'];
                } else {
                    $arr[$key]['title'] = $title[$key];
                }
                $arr[$key]['orderby'] = $orderby[$key];
                $arr[$key]['p_category_id'] = $pid;
                if ($article['type_id'] == 1) {
                    $arr[$key]['cname'] = 'article';
                } else if ($article['type_id'] == 2) {
                    $arr[$key]['cname'] = 'video';
                } else {
                    $arr[$key]['cname'] = '其他';
                }
                //二维数组排序
                $sort[$key] = $orderby[$key];
            }
            array_multisort($sort, SORT_ASC, $arr);

            $data['name'] = 'app_news';
            $data['value'] = serialize($arr);
            $pdid = $this->pagedate->getSomePagedata("id", "name='app_news'", 3);
            if ($pdid) {
                $date['updated'] = $this->timestamp;
                $this->pagedate->ufields = $data;
                $this->pagedate->where = "id=$pdid";
                $this->pagedate->update();
            } else {
                $data['created'] = $this->timestamp;
                $data['notice'] = 'app新闻轮播图';
                $this->pagedate->ufields = $data;
                $this->pagedate->insert();
            }
        }
        $str = $this->pagedate->getSomePagedata("value", "name='app_news'", 3);
        $list = unserialize($str);

        $this->vars("list", $list);
        $this->template($template_name);
    }

    function dobannerPingce() {
        global $local_host;
        $template_name = "app_pingce";
        $arr = array();
        if ($this->postValue('id')->Exist()) {
            $arrid = $this->postValue('id')->Val();
            $oldpic = $this->postValue('old_pic')->Val();
            $url = $this->postValue('url')->Val();
            $title = $this->postValue('title')->Val();
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
                    $arr[$key][pic] = $oldpic[$key];
                }


                $arr[$key]['uptime'] = $article['uptime'];

                $arr[$key]['url'] = $url[$key];
                if ($article) {
                    $arr[$key]['title'] = $article['title'];
                } else {
                    $arr[$key]['title'] = $title[$key];
                }
                $arr[$key]['orderby'] = $orderby[$key];
                $arr[$key]['p_category_id'] = $pid;
                if ($article['type_id'] == 1) {
                    $arr[$key]['cname'] = 'article';
                } else if ($article['type_id'] == 2) {
                    $arr[$key]['cname'] = 'video';
                } else {
                    $arr[$key]['cname'] = '其他';
                }
                //二维数组排序
                $sort[$key] = $orderby[$key];
            }
            array_multisort($sort, SORT_ASC, $arr);

            $data['name'] = 'app_pingce';
            $data['value'] = serialize($arr);
            $pdid = $this->pagedate->getSomePagedata("id", "name='app_pingce'", 3);
            if ($pdid) {
                $date['updated'] = time();
                $this->pagedate->ufields = $data;
                $this->pagedate->where = "id=$pdid";
                $this->pagedate->update();
            } else {
                $data['created'] = time();
                $data['notice'] = 'app评测轮播图';
                $this->pagedate->ufields = $data;
                $this->pagedate->insert();
            }
        }
        $str = $this->pagedate->getSomePagedata("value", "name='app_pingce'", 3);
        $list = unserialize($str);

        $this->vars("list", $list);
        $this->template($template_name);
    }

    function dobannerVideo() {
        global $local_host;
        $template_name = "app_video";
        $arr = array();
        if ($this->postValue('id')->Exist()) {
            $arrid = $this->postValue('id')->Val();
            $oldpic = $this->postValue('old_pic')->Val();
            $url = $this->postValue('url')->Val();
            $title = $this->postValue('title')->Val();
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
                    $arr[$key][pic] = $oldpic[$key];
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

            $data['name'] = 'app_video';
            $data['value'] = serialize($arr);
            $pdid = $this->pagedate->getSomePagedata("id", "name='app_video'", 3);
            if ($pdid) {
                $date['updated'] = time();
                $this->pagedate->ufields = $data;
                $this->pagedate->where = "id=$pdid";
                $this->pagedate->update();
            } else {
                $data['created'] = time();
                $data['notice'] = 'app视频轮播图';
                $this->pagedate->ufields = $data;
                $this->pagedate->insert();
            }
        }
        $str = $this->pagedate->getSomePagedata("value", "name='app_video'", 3);
        $list = unserialize($str);

        $this->vars("list", $list);
        $this->template($template_name);
    }

    function dobannerWenhua() {
        global $local_host;
        $template_name = "app_wenhua";
        $arr = array();
        if ($this->postValue('id')->Exist()) {
            $arrid = $this->postValue('id')->Val();
            $oldpic = $this->postValue('old_pic')->Val();
            $url = $this->postValue('url')->Val();
            $title = $this->postValue('title')->Val();
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
                    $arr[$key][pic] = $oldpic[$key];
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

            $data['name'] = 'app_wenhua';
            $data['value'] = serialize($arr);
            $pdid = $this->pagedate->getSomePagedata("id", "name='app_wenhua'", 3);
            if ($pdid) {
                $date['updated'] = time();
                $this->pagedate->ufields = $data;
                $this->pagedate->where = "id=$pdid";
                $this->pagedate->update();
            } else {
                $data['created'] = time();
                $data['notice'] = 'app文化轮播图';
                $this->pagedate->ufields = $data;
                $this->pagedate->insert();
            }
        }
        $str = $this->pagedate->getSomePagedata("value", "name='app_wenhua'", 3);
        $list = unserialize($str);

        $this->vars("list", $list);
        $this->template($template_name);
    }

    function doSearchList() {
        $this->page_title = "热门关键词";
        $this->tpl_file = "searchlist";

        global $local_host;
        $arr = array();
        if ($this->postValue('id')->Exist()) {
            $arrid = $this->postValue('id')->Val();
            $title = $this->postValue('title')->Val();
            $orderby = $this->postValue('orderby')->Val();
            $arr = array();
            foreach ($arrid as $key => $value) {
                $arr[$key]['id'] = $value;
            }
            foreach ($title as $key => $value) {
                $arr[$key]['title'] = $value;
            }
            foreach ($orderby as $key => $value) {
                $arr[$key]['orderby'] = $value;
            }

            $data['name'] = 'searchlist';
            $data['value'] = serialize($arr);
            $pdid = $this->pagedate->getSomePagedata("id", "name='searchlist'", 3);
            if ($pdid) {
                $this->pagedate->ufields = $data;
                $this->pagedate->where = "id=$pdid";
                $this->pagedate->update();
            } else {
                $data['notice'] = '热门关键词';
                $this->pagedate->ufields = $data;
                $this->pagedate->insert();
            }
        }
        $str = $this->pagedate->getSomePagedata("value", "name='searchlist'", 3);
        $list = unserialize($str);

        $this->vars("list", $list);
        $this->template();
    }

    function doadvice() {
        $this->page_title = "用户反馈";
        $this->tpl_file = "advice";
        $page = $this->getValue('page')->Int(1);
        $page = max(1, $page);
        $page_size = 18;
        $page_start = ($page - 1) * $page_size;
        $id = $this->postValue('id')->Int();
        $where = "1";
        if ($id) {
            $where .=" and id='$id'";
            $extra .="&id=$id";
            $this->vars('id', $id);
        }
        $list = $this->advice->getAdvice("*", "$where order by created desc", 2);
        $total = $this->advice->total;
        $page_bar = $this->multi($total, $page_size, $page, $_ENV['PHP_SELF'] . 'advice' . $extra);
        $this->vars("list", $list);
        $this->template();
    }

    function doadvicef() {
        $this->page_title = "用户反馈详情";
        $this->tpl_file = "advicef";
        $id = $this->postValue('id')->Int();
        if ($id) {
            $state = $this->postValue('state')->Int();
            $this->advice->where = "id='{$id}'";
            $this->advice->ufields['state'] = $state;
            $this->advice->ufields['updated'] = $this->timestamp;
            $ret = $this->advice->update();
            if($ret){
                $this->alert('处理成功', 'js', 3, $_ENV['PHP_SELF'].'advice');
            }
        } else {
            $id = $this->getValue('id')->Int();
            $list = $this->advice->getList("*", "id='$id'", 1);
            $this->vars("list", $list);
            $this->template();
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
        $uploadRootDir = ATTACH_DIR . "images/$dir/app/";
        file::forcemkdir($uploadRootDir);
        $uploadDir = $uploadRootDir . date("Y/m/d", time()) . '/';
        file::forcemkdir($uploadDir);
        $file_name = "images/$dir/app/" . date("Y/m/d", time()) . '/';
        $fileName = util::random(12);
        $fileName .= '.jpg';
        move_uploaded_file($file, $uploadDir . $fileName);
        if ($dir == 'articletitle') {
            imagemark::resize($uploadDir . $fileName, "820x550", 820, 550, '', $watermark_opt);
            imagemark::resize($uploadDir . $fileName, "344x258", 344, 258, '', $watermark_opt);
            imagemark::resize($uploadDir . $fileName, "280x186", 280, 186, '', $watermark_opt);
            imagemark::resize($uploadDir . $fileName, "160x120", 160, 120, '', $watermark_opt);
        } else {
            imagemark::resize($uploadDir . $fileName, "344x258", 344, 258, '', $watermark_opt);
            imagemark::resize($uploadDir . $fileName, "280x186", 280, 186, '', $watermark_opt);
            imagemark::resize($uploadDir . $fileName, "160x120", 160, 120, '', $watermark_opt);
        }
        return $file_name . $fileName;
    }

}

?>
