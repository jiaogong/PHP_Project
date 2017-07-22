<?php

/**
 * article action
 * $Id: articleaction.php 2781 2016-05-31 03:44:24Z david $
 */
class articleAction extends action {

    var $article;
    var $articlelogs;
    var $articletype;
    var $cardbfile;
    var $user;
    var $pagedata;
    var $counter;

    function __construct() {
        global $adminauth, $login_uid;
        parent::__construct();
        $this->article = new article();
        $this->articlelogs = new articlelogs();
        $this->cardbfile = new cardbFile();
        $this->brand = new brand();
        $this->factory = new factory();
        $this->series = new series();
        $this->models = new cardbModel();
        $this->tags = new tags();
        $this->articleseries = new articleseries();
        $this->articletags = new articletags();
        $this->articlecomment = new articlecomment();
        $this->category = new category();
        $this->articlepic = new articlepic();
        $this->user = new user();
        $this->pagedata = new pageData();
        $this->counter = new counter();
        $this->checkAuth(401);
    }

    function doDefault() {
        $this->doList();
    }

    function doSeolist() {
        $this->page_title = "seo审核列表";
        $this->tpl_file = "article_seolist";
        $category = $this->category->getlist("*", "parentid=0 and state=1", 2);
        $this->vars("category", $category);
        $page = $this->getValue('page')->Int(1);
        $page = max(1, $page);
        $page_size = 18;
        $page_start = ($page - 1) * $page_size;
        $where = "ca.state=2 and ca.type_id=1";
        $keword = $this->requestValue('keyword')->String();
        if ($keword) {
            $where .=" and title like '%$keword%'";
            $extra .="&keyword=$keword";
            $this->vars('keword', $keword);
        }
        $author = $this->requestValue('author')->String();
        if ($author) {
            $where .=" and author '$author'";
            $extra .="&author=$author";
            $this->vars('author', $author);
        }
        $article_id = $this->requestValue('article_id')->Int();
        if ($article_id) {
            $where .=" and id=$article_id";
        }
        $p_category_id = $this->requestValue('p_category_id')->Int();
        if ($p_category_id) {
            $where .=" and pcac.id ='$p_category_id'";
            $extra .="&p_category_id=$p_category_id";
            $this->vars('p_category_id', $p_category_id);
            $categorylist = $this->category->getlist("*", "parentid=$p_category_id", 2);
            $this->vars('categorylist', $categorylist);
        }
        $category_id = $this->requestValue('category_id')->Int();
        if ($category_id) {
            $where .=" and cac.id ='$category_id'";
            $extra .="&category_id=$category_id";
            $this->vars('category_id', $category_id);
        }

        $order = array("ca.id" => 'desc');
        # 
        $fields = 'ca.*,cac.category_name,pcac.category_name as p_category_name,pcac.id as p_category_id';
        $list = $this->article->getArticleListPage($where, $fields, $page_size, $page_start, $order);
        $total = $this->article->total;
        $page_bar = $this->multi($total, $page_size, $page, $_ENV['PHP_SELF'] . 'seolist' . $extra);
        foreach ($list as $k => $v) {
            $len_info = dstring::strLengthInfo($this->addValue($v['content'])->stripHtml(1, 1));
            $list[$k]['hz_total'] = $len_info['hz_total'];
            $list[$k]['en_total'] = $len_info['en_total'];
        }
        $this->vars('list', $list);
        $this->vars('page_bar', $page_bar);
        $this->template();
    }

    function doList() {
        $this->checkAuth(402);
        $this->page_title = "文章列表";
        $category = $this->category->getlist("*", "parentid=0 and state=1", 2);
        $this->vars("category", $category);
        $this->tpl_file = "article_list";
        $page = $this->getValue('page')->Int(1);
        $page = max(1, $page);
        $page_size = 18;
        $page_start = ($page - 1) * $page_size;
        $where = "ca.state in(4,3) and ca.type_id=1 ";

        $keword = $this->requestValue('keyword')->String();
        if ($keword) {
            $where .=" and ca.title like '%$keword%'";
            $extra .="&keyword=$keword";
            $this->vars('keyword', $keword);
        }

        $author = $this->requestValue('author')->String();
        if ($author) {
            $where .=" and ca.author ='$author'";
            $extra .="&author=$author";
            $this->vars('author', $author);
        }

        $p_category_id = $this->requestValue('p_category_id')->String();
        if ($p_category_id) {
            $where .=" and pcac.id ='$p_category_id'";
            $extra .="&p_category_id=$p_category_id";
            $this->vars('p_category_id', $p_category_id);
            $categorylist = $this->category->getlist("*", "parentid=$p_category_id", 2);
            $this->vars('categorylist', $categorylist);
        }

        $category_id = $this->requestValue('category_id')->Int();
        if ($category_id) {
            $where .=" and cac.id ='$category_id'";
            $extra .="&category_id=$category_id";
            $this->vars('category_id', $category_id);
        }

        $ishot = $this->requestValue('ishot')->Int();
        if ($ishot) {
            if ($ishot == 2) {
                $where .=" and ca.ishot ='0'";
            } else {
                $where .=" and ca.ishot ='$ishot'";
            }

            $extra .="&ishot=$ishot";
            $this->vars('ishot', $ishot);
        }

        $state = $this->requestValue('state')->Int();
        if ($state) {
            $where .=" and ca.state ='$state'";
            $extra .="&state=$state";
            $this->vars('state', $state);
        }

        $article_id = $this->requestValue('article_id')->Int();
        if ($article_id) {
            $where .=" and ca.id=$article_id";
        }

        $order = array("ca.id" => 'desc');
        # 
        $fields = 'ca.*,cac.category_name,pcac.category_name as p_category_name,pcac.id as p_category_id';
        $list = $this->article->getArticleListPage($where, $fields, $page_size, $page_start, $order);

        foreach ($list as $k => $v) {
            $list[$k]['url'] = $this->article->getRewriteUrl($list[$k]);
            $len_info = dstring::strLengthInfo($this->addValue($v['content'])->stripHtml(1, 1));
            $list[$k]['hz_total'] = $len_info['hz_total'];
            $list[$k]['en_total'] = $len_info['en_total'];
            $list[$k]['pv'] = $this->counter->getWebstatcount("SUM(pv) pv", "cname='article' and c1 = '{$v['p_category_id']}' and c2 = '{$v['category_id']}' and c3 = '{$v['id']}'", 3);
            $list[$k]['uv'] = $this->counter->getWebstatcount("SUM(uv) uv", "cname='article' and c1 = '{$v['p_category_id']}' and c2 = '{$v['category_id']}' and c3 = '{$v['id']}'", 3);
        }

        $total = $this->article->total;
        $page_bar = $this->multi($total, $page_size, $page, $_ENV['PHP_SELF'] . $extra);

        $this->vars('list', $list);
        $this->vars('page_bar', $page_bar);
        $this->template();
    }

    function doVerifyList() {
        $this->checkAuth(404, 'sys_module', 'R');
        $category = $this->category->getlist("*", "parentid=0 and state=1", 2);
        $this->vars("category", $category);
        $this->page_title = "文章列表";
        $this->tpl_file = "article_verifylist";
        $page = $this->getValue('page')->Int(1);
        $page = max(1, $page);
        $page_size = 18;
        $page_start = ($page - 1) * $page_size;
        $where = "ca.state=0 and ca.type_id=1 ";

        $keword = $this->requestValue('keyword')->String();
        if ($keword) {
            $where .=" and ca.title like '%$keword%'";
            $extra .="&keyword=$keword";
            $this->vars('keyword', $keword);
        }
        $author = $this->requestValue('author')->String();
        if ($author) {
            $where .=" and ca.author ='$author'";
            $extra .="&author=$author";
            $this->vars('author', $author);
        }
        $p_category_id = $this->requestValue('p_category_id')->String();
        if ($p_category_id) {
            $p_category_id = $this->requestValue('p_category_id')->String();
            $where .=" and pcac.id ='$p_category_id'";
            $extra .="&p_category_id=$p_category_id";
            $this->vars('p_category_id', $p_category_id);
            $categorylist = $this->category->getlist("*", "parentid=$p_category_id", 2);
            $this->vars('categorylist', $categorylist);
        }
        $category_id = $this->requestValue('category_id')->Int();
        if ($category_id) {
            $where .=" and cac.id ='$category_id'";
            $extra .="&category_id=$category_id";
            $this->vars('category_id', $category_id);
        }
        $article_id = $this->requestValue('article_id')->Int();
        if ($article_id) {
            $where .=" and ca.id=$article_id";
        }

        $order = array("ca.id" => 'desc');
        $fields = 'ca.*,cac.category_name,pcac.category_name as p_category_name,pcac.id as p_category_id';
        $list = $this->article->getArticleListPage($where, $fields, $page_size, $page_start, $order);
        $total = $this->article->total;
        $page_bar = $this->multi($total, $page_size, $page, $_ENV['PHP_SELF'] . 'VerifyList' . $extra);
        foreach ($list as $k => $v) {
            $len_info = dstring::strLengthInfo($this->addValue($v['content'])->stripHtml(1, 1));
            $list[$k]['hz_total'] = $len_info['hz_total'];
            $list[$k]['en_total'] = $len_info['en_total'];
        }
        $this->vars('list', $list);
        $this->vars('page_bar', $page_bar);
        $this->template();
    }

    function doTypeList() {
        $this->page_title = "文章列表";
        $category = $this->category->getlist("*", "parentid=0 and state=1", 2);
        $this->vars("category", $category);
        $this->tpl_file = "article_typelist";
        $page = $this->getValue('page')->Int(1);
        $page = max(1, $page);
        $page_size = 18;
        $page_start = ($page - 1) * $page_size;

        $where = "ca.state=1 and ca.type_id=1 ";
        $keword = $this->requestValue('keyword')->String();
        if ($keword) {
            $where .=" and ca.title like '%$keword%'";
            $extra .="&keyword=$keword";
            $this->vars('keyword', $keword);
        }
        $author = $this->requestValue('author')->String();
        if ($author) {
            $where .=" and ca.author ='$author'";
            $extra .="&author=$author";
            $this->vars('author', $author);
        }
        $p_category_id = $this->requestValue('p_category_id')->String();
        if ($p_category_id) {
            $where .=" and pcac.id ='$p_category_id'";
            $extra .="&p_category_id=$p_category_id";
            $this->vars('p_category_id', $p_category_id);
            $categorylist = $this->category->getlist("*", "parentid=$p_category_id", 2);
            $this->vars('categorylist', $categorylist);
        }
        $category_id = $this->requestValue('category_id')->Int();
        if ($category_id) {
            $where .=" and cac.id ='$category_id'";
            $extra .="&category_id=$category_id";
            $this->vars('category_id', $category_id);
        }
        $article_id = $this->requestValue('article_id')->Int();
        if ($article_id) {
            $where .=" and ca.id=$article_id";
        }

        $order = array("ca.id" => 'desc');
        # 
        $fields = 'ca.*,cac.category_name,pcac.category_name as p_category_name,pcac.id as p_category_id';
        $list = $this->article->getArticleListPage($where, $fields, $page_size, $page_start, $order);
        $total = $this->article->total;
        $page_bar = $this->multi($total, $page_size, $page, $_ENV['PHP_SELF'] . 'typelist' . $extra);
        foreach ($list as $k => $v) {
            $len_info = dstring::strLengthInfo($this->addValue($v['content'])->stripHtml(1, 1));
            $list[$k]['hz_total'] = $len_info['hz_total'];
            $list[$k]['en_total'] = $len_info['en_total'];
        }
        $this->vars('list', $list);
        $this->vars('page_bar', $page_bar);
        $this->template();
    }

    function doOldList() {
        $this->page_title = "文章列表";
        $this->tpl_file = "article_oldlist";
        $page = $this->getValue('page')->Int(1);
        $page = max(1, $page);
        $page_size = 18;
        $page_start = ($page - 1) * $page_size;

        $fields = '*';
        $where = "type_id=1 ";
        $keword = $this->requestValue('keyword')->String();
        if ($keword) {
            $where .=" and title like '%$keword%'";
            $extra .="&keyword=$keword";
            $this->vars('keword', $keword);
        }
        $author = $this->requestValue('author')->String();
        if ($author) {
            $where .=" and author = '$author'";
            $extra .="&author=$author";
            $this->vars('author', $author);
        }
        $article_id = $this->requestValue('article_id')->Int();
        if ($article_id) {
            $where .=" and id=$article_id";
        }
        $order = array("created" => "desc");
        $list = $this->articlelogs->getArticleList($where, $fields, $page_size, $page_start, $order);



        $total = $this->articlelogs->total;

        $page_bar = $this->multi($total, $page_size, $page, $_ENV['PHP_SELF'] . 'oldlist' . $extra);

        $this->vars('list', $list);
        $this->vars('page_bar', $page_bar);
        $this->template();
    }

    function doAdd() {
        global $login_uid, $login_uname;
        #begin 判断文章权限
        //获取文章的id
        $article_id = $this->getValue('id')->Int();
        if (!$article_id) {
            $article_id = $this->postValue('id')->Int();
        }
        if ($article_id && !$this->checkAuth($article_id, 'article')) {
            $this->alert('没有权限，只有文章原作者及管理员可以操作！', 'js', 2);
        }
        #end 文章权限判断

        $this->tpl_file = "article_add";
        $this->page_title = "发布新文章";
        //判断用户是否登录
        $nickname = $this->user->getFields("nickname", "uid=$login_uid", 3);
        if ($nickname) {
            $login_uname = $nickname;
        }
        $brand = $this->brand->getAllBrand('state=3', array('letter' => 'asc'), 200); //字母排序
        $tags = $this->tags->getTagFields("distinct letter", "type_id=1 and state=1", 2, array("letter" => "asc"));
        $pcategory = $this->category->getlist("*", "parentid=0 and state=1 and id!=9", 2);
        $this->vars("pcategory", $pcategory);
        $this->vars("brand", $brand);
        $this->vars("tag", $tags);
        $edit = $this->article->getArticleFields("*", "id=" . $this->getValue('id')->Int(), 1); //查询get方式获取id的文章所有字段
        //如果表题存在,将获取其他的选项值
        if ($this->postValue('title')->Exist()) {
            $title = $this->postValue('title')->Quote();
            $chief = $this->postValue('chief')->Quote();
            $title2 = $this->postValue('title2')->Quote();
            $title3 = $this->postValue('title3')->Quote();
            $photor = $this->postValue('photor')->String();
            $editor = $this->postValue('editor')->String();
            $pic_name = $this->postValue('pic_name')->String();
//            var_dump($pic_name);die;
            $hot_pic_name = $this->postValue('hot_pic_name')->String();
            $pic_org_id = $this->postValue('pic_org_id')->String();
            $article_id = $this->postValue('article_id')->Int();
            $category_id = $this->postValue('category_id')->Int();
            $tag_maxservice = $this->postValue('tag_maxservice')->Val();
            $maxservice = $this->postValue('maxservice')->Val();
            $uptime = $this->postValue('uptime')->Quote();

            $str_series_name = "";
            $str_tag_name = "";
            $str_series_id = "";
            $str_tag_id = "";
            #修正文章图片标签问题
            $content = $this->postValue('ke_text')->Val();
            $content = stripslashes($content); //去除标题的反斜杠
            $content = $this->article->fixArticleImgTag($content);
            #$content = str_replace('&nbsp;', '&amp;nbsp;', $content);
            $content = $this->addValue(trim($content))->Quote();
            if ($edit['state'] == 0) {
                $this->articlelogs->ufields = array(
                    "title" => "$title",
                    "title2" => "$title2",
                    "title3" => "$title3",
                    "photor" => "$photor",
                    "editor" => "$editor",
                    "chief" => "$chief",
                    "content" => "$content",
                    "pic" => "$pic_name",
                    "hot_pic" => "$hot_pic_name",
                    "created" => $this->timestamp,
                    "type_id" => 1,
                    "uid" => $login_uid,
                    "author" => $login_uname,
                    'pic_org_id' => $pic_org_id,
                    'article_id' => $article_id,
                    'category_id' => $category_id,
                );
            } else {
                $this->articlelogs->ufields = array(
                    "title" => $title,
                    "title2" => $title2,
                    "title3" => $title3,
                    "photor" => $photor,
                    "editor" => $editor,
                    "chief" => $chief,
                    "pic" => $pic_name,
                    "hot_pic" => $hot_pic_names,
                    "created" => $this->timestamp,
                    "type_id" => 1,
                    "uid" => $login_uid,
                    'pic_org_id' => $pic_org_id,
                    'article_id' => $article_id,
                    'category_id' => $category_id,
                );
            }
            $comment = $this->postValue('comment')->Val();
            if ($comment) {
                $this->articlelogs->ufields['comment'] = $comment;
            }
            for ($i = 0; $i < $maxservice; $i++) {
                $j = $i + 1;
                $sname = 'series_id' . $j;
                $series_id = $this->postValue($sname)->Int();
                $series_name = $this->postValue('series_name' . $j)->String();
                if ($series_id) {
                    $str_series_name .=$series_name . ',';
                    $str_series_id .=$series_id . ',';
                }
            }

            $str_series_name = rtrim($str_series_name, ',');
            $str_series_id = rtrim($str_series_id, ',');
            for ($i = 0; $i < $tag_maxservice; $i++) {
                $j = $i + 1;
                $tag_id = $this->postValue('tag_name_id' . $j)->Val();
                $tag_name = $this->postValue('tag_name' . $j)->Val();
                if ($tag_id) {
                    $str_tag_name .=$tag_name . ',';
                    $str_tag_id .=$tag_id . ',';
                }
            }
            #添加文章到草稿箱
            $str_tag_name = rtrim($str_tag_name, ',');
            $str_tag_id = rtrim($str_tag_id, ',');
            $this->articlelogs->ufields["seriesname_list"] = $str_series_name;
            $this->articlelogs->ufields["tagname_list"] = $str_tag_name;
            $this->articlelogs->ufields["series_list"] = $str_series_id;
            $this->articlelogs->ufields["tag_list"] = $str_tag_id;
            $this->articlelogs->ufields['uptime'] = strtotime($uptime);

            $id = $this->articlelogs->insert();
            //添加到正式文章表
            $article = $this->articlelogs->getArticleFields("*", "id=$id", 1);
            $article['content'] = addslashes($article['content']);
            $article['title'] = addslashes($article['title']);
            $article['chief'] = addslashes($article['chief']);
            $article['title2'] = addslashes($article['title2']);
            $article['title3'] = addslashes($article['title3']);
            if ($article['article_id']) {
                $artilce_id = $article['article_id'];
                unset($article['article_id']);
                unset($article['comment']);
                unset($article['state']);
                unset($article['ishot']);
                unset($article['id']);
                unset($article['author']);
                unset($article['uptime']);
                unset($article['created']);
                $this->article->where = "id=$artilce_id"; //写入到正式文章表
                $comment = $this->article->getArticleFields("comment,ishot", "id=$artilce_id", 1); //获取comment字段
                $article = array_merge($article, $comment); //把两个数组拼到一块
                $this->article->ufields = $article; //把拼接的数组当成字段给article
                if ($this->postValue('result')->Int() == 1) {
                    $this->article->ufields['state'] = 0;
                }
                #文章更新的操作
                #检查其它文章是否使用此标题
                $title_used = $this->article->getArticleFields("count(id)", "title='{$article['title']}' and id<>{$artilce_id}", 3); //以id为条件查询标题
                if (!$title_used) {
                    $this->article->where = "id='{$article_id}'";
                    $this->article->ufields['updated'] = $this->timestamp;
                    $ret = $this->article->update(); //文章更新
                } else {
                    $this->alert('已存在相同文章在文章列表查询修改,或重拟标题发布!', 'js', 3, $_ENV['PHP_SELF']);
                    exit;
                }
            } else {
                unset($article['article_id']);
                unset($article['id']);
                unset($article['created']);
                $this->article->ufields = $article;
                $title_used = $this->article->getArticleFields("count(id)", "title='{$article['title']}'", 3);
                if ($title_used) {
                    $this->alert('已存在相同文章在文章列表查询修改,或重拟标题发布!', 'js', 3, $_ENV['PHP_SELF']);
                    exit;
                } else {
                    $this->article->ufields['created'] = $this->timestamp;
                    $article_id = $this->article->insert();
                    $this->articlelogs->ufields = array(
                        "article_id" => "$article_id",
                    );
                    $this->articlelogs->where = "id=$id";
                    $this->articlelogs->update(); //文章更新
                }
            }
            for ($i = 0; $i < $maxservice; $i++) {
                $j = $i + 1;
                $sname = 'series_id' . $j;
                $series_id = $this->postValue($sname)->Int();
                $series_name = $this->postValue('series_name' . $j)->String();
                $article_seriesid = $this->postValue('article_seriesid' . $j)->String();
                if ($series_id) {
                    $this->articleseries->ufields = array("article_id" => "$article_id", "series_id" => "$series_id", "series_name" => "$series_name", "uptime" => $this->timestamp);
                    $article_seriesid = $this->articleseries->getArticleSeries("id", "id='$article_seriesid'", 3);
                    if ($article_seriesid) {
                        $this->articleseries->where = "id=$article_seriesid";
                        $this->articleseries->update(); //更新
                    } else {
                        $this->articleseries->insert(); //插入
                    }
                }
            }

            for ($i = 0; $i < $tag_maxservice; $i++) {
                $j = $i + 1;
                $tag_id = $this->postValue('tag_name_id' . $j)->String();
                $tag_name = $this->postValue('tag_name' . $j)->String();
                $article_tagid = $this->postValue('article_tagid' . $j)->String();
                #文章的修改
                if ($tag_id) {
                    $this->articletags->ufields = array("article_id" => "$article_id", "tag_id" => "$tag_id", "tag_name" => "$tag_name", "uptime" => time());
                    $article_tagid = $this->articletags->getTagFields("id", "id='$article_tagid'", 3);
                    if ($article_tagid) {
                        $this->articletags->where = "id=$article_tagid";
                        $this->articletags->update();
                    } else {
                        $this->articletags->insert();
                    }
                }
            }

            $this->alert('已提交审核，你可以继续修改，也可以等待审核结果', 'js', 3, $_ENV['PHP_SELF'] . 'VerifyList');
        }
        //
        else {
            $type = $this->getValue('type')->String();
            $a = $this->getValue('a')->String();

            if ($type) {
                $this->vars("typetitle", "审核结果");
            }
            $old = $this->getValue('old')->String();
            $id = $this->getValue('id')->Int();
            if ($id) {
                if ($old) {
                    $article = $this->articlelogs->getArticleFields("*", "id='{$id}' order by created desc", 1);

                    $articles = $this->article->getArticleFields("id", "id='{$article[article_id]}'", 1);
                    if ($articles['id']) {
                        unset($article['article_id']);
                    }
                    $this->vars('id', $id);
                } else {
                    $article = $this->article->getArticleFields("*", "id='{$id}' order by created desc", 1);
                    $this->vars('id', $id);
                    $this->vars('a', $a);
                    $article['article_id'] = $article['id'];
                }
            } else {
                if ($old) {
                    $article = $this->articlelogs->getArticleFields("*", "uid='{$login_uid}' and type_id=1 order by created desc", 1);
                    $articles = $this->article->getArticleFields("id", "id='{$article['article_id']}'", 1);
                    if (!$articles['id']) {
                        unset($article['article_id']);
                    }
                }
            }
            if ($article['article_id']) {
                $comment = $this->article->getArticleFields("*", "id={$article['article_id']}", 1);
                $this->vars("type", $type);
                $this->vars("comment", $comment);
            }
            if ($article) {
                $pic_org_id = empty($article['pic_org_id']) ? $article['id'] : $article['pic_org_id'];
                $piclist = $this->cardbfile->getlist("*", "type_id=$pic_org_id and type_name='artile_pic'", 2);
                $this->vars("piclist", $piclist);
            }
            if ($article['category_id']) {
                $category = $this->category->getlist("*", "id={$article['category_id']}", 1);
                $this->vars('category', $category);

                $categorylist = $this->category->getlist("*", "parentid={$category['parentid']}", 2);
                $this->vars('categorylist', $categorylist);
            }
            if ($article['tag_list']) {
                $tagservice = array();
                $tag_maxservice_id = 0;
                $taglist = $this->tags->getTagFields("*", "id in({$article['tag_list']})", 2, array());
                foreach ($taglist as $key => $value) {
                    $tag_maxservice_id++;
                    $tagservice[$key]['tag'] = $tags;
                    $letter = $this->tags->getTagFields("letter", "id='{$value['id']}'", 3, array());
                    $tagname = $this->tags->getTagFields("id,tag_name", "type_id=1 and state=1 and letter = '$letter'", 2, array("letter" => "asc"));
                    $article_tagid = $this->articletags->getTagFields("id", "tag_id='{$value['id']}' and article_id='{$article['article_id']}'", 3);
                    $tagservice[$key]['tagname'] = $tagname;
                    $tagservice[$key]['0'] = $tag_maxservice_id;
                    $tagservice[$key]['1'] = $letter;
                    $tagservice[$key]['2'] = $value[id];
                    $tagservice[$key]['article_tagid'] = $article_tagid;
                    $tagservice[$key]['4'] = $value[tag_name];
                }
                $this->vars('tag_maxservice_id', $tag_maxservice_id);
                $this->vars('tagservice', $tagservice);
            }

            if ($article['series_list']) {
                $service = array();
                $maxservice_id = 0;
                $serieslist = $this->series->getSeriesdata("brand_id,factory_id,series_id,series_name", "series_id in($article[series_list])", 2);

                foreach ($serieslist as $key => $value) {
                    $maxservice_id++;
                    $service[$key]['brand'] = $brand;
                    $idlist = $this->series->getSeriesdata("brand_id,factory_id,series_id", "series_id=$value[series_id]", 1);
                    $factory = $this->factory->getFactorylist("factory_id,factory_name", "brand_id=$idlist[brand_id]", 2);
                    $series = $this->series->getSeriesdata("series_id,series_name", "factory_id=$idlist[factory_id]", 2);
                    $article_seriesid = $this->articleseries->getArticleSeries("id", "series_id='$value[series_id]' and article_id='$article[article_id]'", 3);
                    $service[$key]['factory'] = $factory;
                    $service[$key]['series'] = $series;
                    $service[$key]['0'] = $maxservice_id;
                    $service[$key]['1'] = $idlist[brand_id];
                    $service[$key]['1'] = $idlist[brand_id];
                    $service[$key]['2'] = $idlist[factory_id];
                    $service[$key]['3'] = $value[series_id];
                    $service[$key]['4'] = $value[series_name];
                    $service[$key]['article_seriesid'] = $article_seriesid;
                }
                $this->vars('maxservice_id', $maxservice_id);
                $this->vars('service', $service);
            }

            $article['content'] = str_replace('&nbsp;', '&amp;nbsp;', $article['content']); //把amp替换成一个空格
            $this->vars('article', $article);
            $this->vars('edit', $edit);
            $this->template();
        }
    }

    function doCategoryList() {
        $id = $this->getValue('id')->Int();
        $category = $this->category->getlist("id,category_name", "parentid='{$id}' and state=1", 2);
        if ($category) {
            echo json_encode($category);
        } else {
            echo 1;
        }
    }

    function doEditState() {
        $id = $this->getValue('id')->Int();
        #$state = $this->getValue('state')->Int();
        $this->article->ufields = array(
            "state" => "2"
        );
        $this->article->where = "id='{$id}'";
        $aid = $this->article->update();
        if ($aid) {
            $this->alert('状态已修改', 'js', 3, $_ENV['PHP_SELF'] . 'List');
        } else {
            $this->alert('状态修改失败', 'js', 3, $_ENV['PHP_SELF'] . 'List');
        }
    }

    //第一版草稿，添加标题
    function doAddTitle() {
        global $login_uid, $login_uname;
        $nickname = $this->user->getFields("nickname", "uid=$login_uid", 3);
        if ($nickname) {
            $login_uname = $nickname;
        }
        $title = $this->postValue('title')->String();
        $this->articlelogs->ufields = array(
            "title" => "$title",
            "created" => time(),
            "type_id" => 1,
            "uid" => $login_uid,
            "author" => $login_uname
        );

        $tid = $this->articlelogs->getArticleFields("id", "title='$title'", 3);

        if ($tid) {
            echo -4;
        } else {
            $id = $this->articlelogs->insert();
            echo $id;
        }
    }

    //保存草稿
    function doAddarticleLogs() {
        global $login_uid, $login_uname;
        $nickname = $this->user->getFields("nickname", "uid=$login_uid", 3);
        if ($nickname) {
            $login_uname = $nickname;
        }
        $title = $this->postValue('title')->Quote();
        $chief = $this->postValue('chief')->Quote();
        $title2 = $this->postValue('title2')->Quote();
        $title3 = $this->postValue('title3')->Quote();
        $photor = $this->postValue('photor')->String();
        $editor = $this->postValue('editor')->String();

        $pic_name = $this->postValue('pic_name')->String();
        $hot_pic_name = $this->postValue('hot_pic_name')->String();
        $category_id = $this->postValue('category_id')->Int();
        $pic_org_id = $this->postValue('pic_org_id')->Int();
        $tag_maxservice = $this->postValue('tag_maxservice')->Val();
        $maxservice = $this->postValue('maxservice')->Val();
        $str_series_name = "";
        $str_tag_name = "";
        $str_series_id = "";
        $str_tag_id = "";

        #修正文章图片标签问题
        $content = $this->postValue('ke_text')->Val();
        $content = stripslashes($content);
        $content = $this->article->fixArticleImgTag($content);
        #$content = str_replace('&nbsp;', '&amp;nbsp;', $content);
        $content = $this->addValue($content)->Quote();

        $this->articlelogs->ufields = array(
            "title" => "$title",
            "title2" => "$title2",
            "title3" => "$title3",
            "photor" => "$photor",
            "editor" => "$editor",
            "chief" => "$chief",
            "content" => "$content",
            "pic" => "$pic_name",
            "hot_pic" => "$hot_pic_name",
            "created" => $this->timestamp,
            "type_id" => 1,
            "uid" => $login_uid,
            "author" => $login_uname,
            "category_id" => $category_id,
            'pic_org_id' => $pic_org_id
        );
        $comment = $this->postValue('comment')->Val();
        if ($comment) {
            $this->articlelogs->ufields['comment'] = $comment;
        }
        $id = $this->articlelogs->insert();

        for ($i = 0; $i < $maxservice; $i++) {
            $j = $i + 1;
            $sname = 'series_id' . $j;
            $series_id = $this->postValue($sname)->Int();
            $series_name = $this->postValue('series_name' . $j)->String();
            if ($series_id) {
                $str_series_id .=$series_id . ',';
                $str_series_name .=$series_name . ',';
            }
        }

        $str_series_name = rtrim($str_series_name, ',');
        $str_series_id = rtrim($str_series_id, ',');
        for ($i = 0; $i < $tag_maxservice; $i++) {
            $j = $i + 1;
            $tag_id = $this->postValue('tag_name_id' . $j)->String();
            $tag_name = $this->postValue('tag_name' . $j)->String();
            if ($tag_id) {
                $str_tag_name .=$tag_name . ',';
                $str_tag_id .=$tag_id . ',';
            }
        }

        $str_tag_name = rtrim($str_tag_name, ',');
        $str_tag_id = rtrim($str_tag_id, ',');
        $this->articlelogs->ufields = array(
            "seriesname_list" => "$str_series_name",
            "tagname_list" => "$str_tag_name",
            "series_list" => "$str_series_id",
            "tag_list" => "$str_tag_id",
        );
        $this->articlelogs->where = "id=$id";
        $upid = $this->articlelogs->update();

        if ($id) {
            echo $id;
        } else {
            echo "no";
        }
    }

    //删除文章标签
    function doDelArticleTag() {
        $tag_id = $this->getValue('tag_id')->String();
        $article_id = $this->getValue('article_id')->Int();
        $article_tagid = $this->getValue('article_tagid')->Int();
        $this->articletags->where = "id='{$article_tagid}'";
        $this->articletags->del();

        $tag = $this->articlelogs->getArticleFields("id,tag_list,tagname_list", "id='{$article_id}'", 1);

        $tagArr = explode(',', $tag['tag_list']);
        $tagnameArr = explode(',', $tag['tagname_list']);
        foreach ($tagArr as $key => $value) {
            if ($value == $tag_id) {
                unset($tagArr[$key]);
                unset($tagnameArr[$key]);
            }
        }

        $str_tag_name = implode(',', $tagnameArr);
        $str_tag_id = implode(',', $tagArr);
        $this->articlelogs->ufields = array("tag_list" => $str_tag_id, "tagname_list" => $str_tag_name);
        $this->articlelogs->where = "id=$article_id";
        $this->articlelogs->update();
    }

    //删除文章关联车系车系
    function dodelarticleseries() {
        $series_id = $this->getValue('series_id')->Int();
        $article_id = $this->getValue('article_id')->Int();
        $article_seriesid = $this->getValue('article_seriesid')->Int();
        $this->articleseries->where = "id='$article_seriesid'";
        $this->articleseries->del();

        $series = $this->articlelogs->getArticleFields("id,series_list,seriesname_list", "id='$article_id'", 1);

        $seriesArr = explode(',', $series[series_list]);
        $seriesnameArr = explode(',', $series[seriesname_list]);
        foreach ($seriesArr as $key => $value) {
            if ($value == $series_id) {
                unset($seriesArr[$key]);
                unset($seriesnameArr[$key]);
            }
        }

        $str_series_name = implode(',', $seriesnameArr);
        $str_series_id = implode(',', $seriesArr);
        $this->articlelogs->ufields = array("seriesname_list" => $str_series_name, "series_list" => $str_series_id);
        $this->articlelogs->where = "id=$article_id";
        $this->articlelogs->update();
    }

    //上传文章所需图片
    function doajaxArticlePic() {
        if ($_FILES['pic']) {
            $pic = $_FILES['pic'];
        } else {
            $pic = $_FILES['hot_pic'];
            $hot = 1;
        }

        if ($pic['size']) {
            $pic_name = $pic['tmp_name'];
            if ($hot) {
                $pic_path = $this->uploadPic($pic_name, 'articlehot');
            } else {
                $pic_path = $this->uploadPic($pic_name, 'articletitle');
            }

            if ($pic_path) {
                echo json_encode($pic_path);
            } else {
                echo 1;
            }
        }
    }

    //查询标签
    function doAjaxTag() {
        $letter = $this->getValue("letter")->En();
        $taglist = $this->tags->getTagFields("*", "type_id=1 and state=1 and letter='{$letter}'", 2, array("letter" => "asc"));
        echo json_encode($taglist);
    }

    //上传文章所需图片
    function doArticlePic() {
        $tpl_file = 'article_pic';
        $id = $this->getValue('id')->Int();
        $this->cardbfile->order = array("ppos" => "asc");
        $list = $this->cardbfile->getlist("*", "type_id=$id and type_name='artile_pic'", 2);
        $this->vars("id", $id);
        $this->vars("list", $list);

        $this->template($tpl_file);
    }

    function doaddpic() {
        $typeArr = array("jpg", "png", "gif"); //允许上传文件格式
        if (isset($_POST)) {
            $id = $this->postValue('id')->Int();
            $name = $_FILES['file']['name'];
            $size = $_FILES['file']['size'];
            $name_tmp = $_FILES['file']['tmp_name'];
            if (empty($name)) {
                echo json_encode(array("error" => "您还未选择图片"));
                exit;
            }
            $type = strtolower(substr(strrchr($name, '.'), 1)); //获取文件类型

            if (!in_array($type, $typeArr)) {
                echo json_encode(array("error" => "清上传jpg,png或gif类型的图片！"));
                exit;
            }
            if ($size > (5000 * 1024)) {
                echo json_encode(array("error" => "图片大小已超过500KB！"));
                exit;
            }
            $pic_url = $this->uploadarticlePic($name_tmp); ////临时文件转移到目标文件夹 返回上传后图片路径+名称

            if ($pic_url) {
                $this->cardbfile->ufields = array(
                    "name" => "$pic_url",
                    'file_type' => "jpg",
                    "created" => $this->timestamp,
                    "type_name" => "artile_pic",
                    "type_id" => $id
                );
                $pid = $this->cardbfile->insert();
                $pic_url = 'images/article/' . date("Y/m/d", time()) . '/' . $pic_url;
                echo json_encode(array("error" => "0", "pic" => "$pic_url", "id" => "$pid"));
            } else {
                echo json_encode(array("error" => "上传有误，清检查服务器配置！"));
            }
        }
    }

    function doeditpic() {
        $id = $this->postValue('id')->Int();
        $pic_org_id = $this->postValue('pic_org_id')->Int();
        $content = $this->postValue('content')->String();
        $ppos = $this->postValue('sork')->Int();
        if ($id && $content && $pic_org_id) {
            $this->cardbfile->ufields = array(
                "updated" => $this->timestamp,
                "memo" => "$content",
                "ppos" => "$ppos",
                "type_id" => $pic_org_id
            );
            $this->cardbfile->where = "id=$id";
            $pid = $this->cardbfile->update();
            echo 1;
        } else {
            echo 2;
        }
    }

    function doalleditpic() {
        $id = $this->postValue('id')->Val();
        $pic_org_id = $this->postValue('pic_org_id')->Int();
        $content = $this->postValue('name_title')->Val();
        $ppos = $this->postValue('ppos')->Val();

        if ($id && $content && $pic_org_id) {
            foreach ($id as $k => $v) {
                $this->cardbfile->ufields = array(
                    "updated" => $this->timestamp,
                    "memo" => "$content[$k]",
                    "ppos" => "$ppos[$k]",
                    "type_id" => $pic_org_id
                );
                $this->cardbfile->where = "id=$v";
                $pid = $this->cardbfile->update();
            }
        }

        $this->alert('图片编辑成功', 'js', 3, $_ENV['PHP_SELF'] . 'ArticlePic&id=' . $pic_org_id);
    }

    function dodelpic() {
        $id = $this->postValue('id')->Int();
        $pic = $this->postValue('pic')->Val();
        $arrpic = explode('/', $pic);
        $arr = array('', "360x270");
        if ($id) {
            $this->cardbfile->where = "id=$id";
            $pid = $this->cardbfile->del();
            foreach ($arr as $k => $v) {
                $arrpic[5] = $v . $arrpic[5];
                $pics = implode('/', $arrpic);
                @unlink(ATTACH_DIR . $pics);
            }
            @unlink(ATTACH_DIR . $pic);
            echo 1;
        } else {
            echo 2;
        }
    }

    function doArticleComment() {
        global $login_uid, $login_uname;
        $this->checkAuth(404);
        $content = $this->postValue('content')->Val();
        $article_id = $this->postValue('article_id')->Int();
        $articlelog_id = $this->postValue('articlelog_id')->Int();
        $state = $this->postValue('state')->Int();
        $this->articlecomment->ufields = array(
            "comment" => "$content",
            "article_id" => $article_id,
            "articlelog_id" => $articlelog_id,
            "created" => $this->timestamp,
            "uid" => $login_uid,
            "uname" => "$login_uname"
        );
        $id = $this->articlecomment->insert();

        $this->article->where = "id=$article_id";
        $this->article->ufields = array(
            "state" => "$state",
            "comment" => "$content",
        );
        if ($state == 3) {
            $this->article->ufields['state'] = 1;
            $this->article->ufields['ishot'] = 1;
        }

        $this->article->update();
        echo $id;
    }

    /**
     * 文章页面预览及生成功能
     * 
     * @global string $local_host   当前站点域名
     * @param boolean $ret  1：返回文章预览html内容，否则直接输出预览页面
     * @param boolean $make_flag   1: ssi内容不显示，否则将ssi内容同文章页面内容同时显示出来
     * @param int $article_id 文章ID，只有当GET[id]不存在时，才会判断此值
     * @return string 文章页内容
     */
    function doPreview($ret = 0, $make_flag = 0, $article_id = 0) {

        global $local_host, $attach_server;
        #begin 判断是否有文章审核权限
        $allow_audit = $this->checkAuth(404, 'preview', 'A');
        $this->vars('allow_audit', $allow_audit);
        #end 文章审核权限判断
        $seo = $this->getValue('seo')->String();
        $s = $this->getValue('s')->String();
        if(strrpos($local_host, '/', 1) !== false && RELAT_DIR === '/'){
            $local_host = substr($local_host, 0, -1);
        }
        $this->replace = array(
            'href="css/' => 'href="' . $local_host . RELAT_DIR . 'css/',
            'src="js/' => 'src="' . $local_host . RELAT_DIR . 'js/',
            'src="images/' => 'src="' . $local_host . RELAT_DIR . 'images/',
            'src="attach/' => 'src="' . $local_host . RELAT_DIR . 'attach/',
            'href="/css/' => 'href="' . $local_host . RELAT_DIR . 'css/',
            'src="/js/' => 'src="' . $local_host . RELAT_DIR . 'js/',
            'src="/images/' => 'src="' . $local_host . RELAT_DIR . 'images/',
            'src="/attach/' => 'src="' . $local_host . RELAT_DIR . 'attach/',
        );
        if(!empty($attach_server)){
            $this->replace['src="'.$local_host.RELAT_DIR.'attach/images/'] = 'src="' . $attach_server[0] . RELAT_DIR;
            $this->replace['src="/attach/images/'] = 'src="' . $attach_server[0] . RELAT_DIR;
        }
        
        #当GET[id]不存在时，使用传入的$article_id赋值
        if ($article_id) {
            $this->id = $id = $article_id;
        } else {
            $this->id = $id = $this->getValue('id')->Int();
        }

        if (!$make_flag) {
            $make_flag = $this->getValue('make_flag')->Int();
        }

        $this->tpl_file = "article_page";
        $article = $this->article->getArticle($id);
        $articlelog = $this->articlelogs->getArticleFields("*", "article_id='{$id}' order by created desc", 1);
        $taglist = $this->tags->getTagFields("id,tag_name", "type_id=1 and state=1 and id in({$article['tag_list']})", 2);
        $serieslist = $this->series->getSeriesdata("series_id,sereis_name,series_pic", "series_id in({$article['series_list']})", 2);
        $dir = date("Ym/d", $article['uptime']);
        $h = $this->timestamp;
        $this->vars("h", $h);

        /**
         * return first series_id in series_list
         * PHP 5.2+ compatibly
         */
        if (false !== ($pos = strpos($article['series_list'], ','))) {
            $series_id = substr($article['series_list'], 0, $pos);
        } else {
            $series_id = $article['series_list'];
        }

        $series = $this->series->getSeriesdata("*", "series_id='{$series_id}'", 1);
        $logo = $this->brand->getBrandlist("brand_logo", "brand_id='{$series['brand_id']}'", 3);
        $this->vars("brand_logo", $logo);
        //频道
        $category = $this->category->getlist("*", "id='{$article['category_id']}'", 1);
        $p_category = $this->category->getlist("*", "id='{$category['parentid']}'", 1);
        $models = $this->models->getSimp("MAX(model_price) AS max_price,MIN(model_price) AS min_price", "series_id='{$series_id}' and state in(3,8)", 1);
        //相关文章
        $articleseries = $this->articleseries->getCountSeries('ca.title,ca.pic,ca.id,ca.category_id,ca.uptime', "cas.series_id='{$series_id}' and ca.id=cas.article_id and type_id=1 and ca.state=3", 2);
        if ($articleseries) {
            $ii = 0;
            foreach ($articleseries as $key => $value) {
                if ($value['id'] == $article['id']) {
                    unset($articleseries[$key]);
                    continue;
                }
                $ii++;
                if ($ii > 4) {
                    break;
                }
                $categoryarr = $this->category->getParentCategoryName("pca.category_name p_category_name,pca.id pcaid,ca.*", "ca.id='{$value['category_id']}' and pca.id=ca.parentid", 1);
                $articleseries[$key]['category_name'] = $categoryarr['category_name'];
                $articleseries[$key]['p_category_name'] = $categoryarr['p_category_name'];
                $articleseries[$key]['p_category_id'] = $categoryarr['parentid'];
                $articleseries[$key]['pcaid_url'] = replaceNewsChannel("/article.php?action=CarReview&id={$categoryarr['pcaid']}");
                $articleseries[$key]['url'] = $this->article->getRewriteUrl($articleseries[$key]);
                $articleseries[$key]['pic'] = $this->article->getArticlePic($value['pic'], '280x186');
            }
        }

        //相关视频
        $videoseries = $this->articleseries->getCountSeries('ca.title,ca.pic,ca.id,ca.category_id', "cas.series_id='{$series_id}' and ca.id=cas.article_id and type_id=2 and ca.state=3", 2);
        if ($videoseries) {
            foreach ($videoseries as $key => $value) {
                if ($key > 4) {
                    break;
                }
                $categoryarr = $this->category->getParentCategoryName("pca.category_name p_category_name,ca.*", "ca.id='{$value['category_id']}' and pca.id=ca.parentid", 1);
                $videoseries[$key]['category_name'] = $categoryarr['category_name'];
                $videoseries[$key]['p_category_name'] = $categoryarr['p_category_name'];
                $videoseries[$key]['p_category_id'] = $categoryarr['parentid'];
                $videoseries[$key]['url'] = $this->article->getRewriteUrl($videoseries[$key]);
                $videoseries[$key]['pic'] = $this->article->getArticlePic($value['pic'], '160x120');
            }
        }

        //文章读图
        $pic_num = $this->articlepic->getlist("count(id)", "type_id={$article['pic_org_id']} and type_name='artile_pic'", 3);
        $this->vars('pic_num', $pic_num);
        $this->vars('model_price', $models);
        $this->vars('seriercount', count($articleseries));
        $this->vars('articleseries', $articleseries);
        $this->vars('videocount', count($videoseries));
        $this->vars('videoseries', $videoseries);
        $this->vars('category', $category);
        $this->vars('p_category', $p_category);
        $this->vars('series', $series);
        $this->vars('taglist', $taglist);
        $this->vars('serieslist', $serieslist);
        $this->vars('make_flag', $make_flag);
        $this->vars('news_domain', $this->article->getRewriteDomain($category['parentid']));

        $page_title = $article['title'] . '-ams车评网';
        $page_keywords = $article['title'];
        $page_description = $article['title'] . '。' . dstring::substring($article['chief'], 0, 75);
        if (0) {
            #去除空段
            $article['content'] = preg_replace('%(<p[^>]*>\s*</p>)%', '', $article['content']);

            #处理图说标签异常问题
            preg_match_all('%<img\s+src=".+?/\d{4}/\d{2}/\d{2}/820x540([^"]+)"[^/]+/>%sim', $article['content'], $matches);
            if ($matches) {
                foreach ($matches[0] as $k => $v) {
                    $image_name = $matches[1][$k];
                    $image_file = $this->cardbfile->getFileByName($image_name);
                    #echo "$image_name  == $image_alt <br>\n";
                    #var_dump($image_file);
                    if ($image_file['id']) {
                        #$image_path = $local_host . "images/article/" . date('Y/m/d', $image_file['created']) . "/820x540";
                        $article['content'] = preg_replace(
                                '%<img\s+src="(.+?' . $image_name . ')"[^/]+/>%sim', '<img class="tishi_' . $image_file['id'] . ' allview" src="\1" /> ', $article['content']
                        );
                    }
                }
            }

            #处理编辑上传的图片异常问题
            $article['content'] = preg_replace('%<img\s+src="(.+?)(\/\d{6}\/\d{2})/820x540([^"]+)"[^/]+/>%sim', '<img class="allcc" src="\1\2/820x540\3" /> ', $article['content']);

            #更新文章数据
            $this->article->ufields['content'] = $article['content'];
            $this->article->where = "id='{$id}'";
            $this->article->update();
        }

        $page_keywords = str_replace(array('"', "'"), array('', ''), $page_keywords);
        $article['content'] = preg_replace('/<img([^>]+)>/im', '<img alt="' . $page_keywords . '" \1>', $article['content']);
        $article['pic'] = $this->article->getArticlePic($article['pic'], '820x550');
        $this->vars('page_title', $page_title);
        $this->vars('keywords', $page_keywords);
        $this->vars('description', $page_description);
        $this->vars('article', $article);
        $this->vars('articlelog', $articlelog);
        $this->vars('id', $id);
        $this->vars('seo', $seo);
        $this->vars('s', $s);

        $html = $this->fetch($this->tpl_file);
        $html = replaceNewsChannel($html);
        
        if (!$make_flag) {
            $html = $this->getSSIfile($html);
            #去除百度、谷歌统计代码
            $html = preg_replace('%<script>([^<]+)</script>\s*<script>([^<]+)</script>\s*</body>%im', '</body>', $html);
        }
        
        if ($ret) {
            return $this->replaceTpl($html);
        } else {
            echo $this->replaceTpl($html);
        }
    }

//文章管理里面的生成
    function doMake() {
        $id = $this->getValue('id')->Int();
        $article = $this->article->getArticle($id); //根据id查询所有字段
        $type_name = $article['state'];
        $article_time = $article['uptime']; //给变量赋值
        $article_path = date('Ym', $article_time) . '/' . date('d', $article_time) . '/' . $id . '.html'; //文章生成路径
        $r = $this->action2File('index.php?action=article-preview&make_flag=1&id=' . $id, WWW_ROOT . 'html/article/' . $article_path, false); //生成静态文件
        if ($r) {
            $this->article->ufields = array("state" => 3);
            $this->article->where = "id=$id";
            $this->article->update();
            $this->alert('生成成功', 'js', 3, $_ENV['PHP_SELF']);
        } else {
            $this->alert('生成失败', 'js', 3, $_ENV['PHP_SELF']);
        }
    }

//批量生成的js传值
    function doAllMake() {

        $articleid = $this->postValue('articleid')->Val();
        if ($articleid)
            foreach ($articleid as $k => $v) {
                $id = $v;
                $article = $this->article->getArticle($id);
                $article_time = $article['uptime'];
                $article_path = date('Ym', $article_time) . '/' . date('d', $article_time) . '/' . $id . '.html';
                $r = $this->action2File('index.php?action=article-preview&make_flag=1&id=' . $id, WWW_ROOT . 'html/article/' . $article_path, false);
                $this->article->ufields = array("state" => 3);
                $this->article->where = "id='{$id}'";
                $this->article->update();
            }
        echo 1;
    }

//批量生成文章
    function doAllMakeArticle() {
        $articleid = $this->article->getArticleFields("id", "type_id=1 and state=3", 2); //根据字段查询所有符合条件id
        if ($articleid) {
            foreach ($articleid as $k => $vv) {
                $id = $vv['id'];
                $article = $this->article->getArticle($id); //根据id查询字段
                $article_time = $article['uptime'];
                $article_path = date('Ym', $article_time) . '/' . date('d', $article_time) . '/' . $id . '.html';
                $html = $this->doPreview(1, 1, $id); //生成预览页面
                $article_filename = WWW_ROOT . 'html/article/' . $article_path; //生成文件的文章名
                #判断目录，没有创建
                $article_dir = dirname($article_filename);
                if (!is_dir($article_dir)) {
                    file::forcemkdir($article_dir);
                }
                $int = file_put_contents($article_filename, $html);
                if ($int) {
                    $this->article->ufields = array("state" => 3);
                    $this->article->where = "id=$id";
                    $this->article->update();
                }
                unset($html);
            }
            echo 1;
        }
    }

    function doEdit() {
        $this->doAdd();
    }

    function doDel() {
        $this->checkAuth(404);
        $article_id = $this->getValue('id')->Int();
        $type = $this->getValue('type')->Int();
        if ($article_id) {
            if ($this->checkAuth($article_id, 'article')) {
                $article = $this->article->getArticle($article_id);
                $this->article->where = "id='{$article_id}'";
                $ret = $this->article->del();
                $msg = "文章删除";
                if ($ret && $article) {
                    #删除文章静态页面文件
                    @unlink(WWW_ROOT . 'html/article/' . date('Ym', $article['uptime']) . '/' . date('d', $article['uptime']) . '/' . $article_id . '.html');
                    $msg .= "成功！";
                } else {
                    $msg .= "失败！";
                }
                #exit;
                $message = array(
                    'type' => 'js',
                    'act' => 3,
                    'message' => $msg,
                    'url' => $_ENV['PHP_SELF']
                );
                if ($type == 2) {
                    $message['url'] = $_ENV['PHP_SELF'] . 'verifylist';
                } else if ($type == 3) {
                    $message['url'] = $_ENV['PHP_SELF'] . 'typelist';
                }
                $this->alert($message);
            } else {
                $this->alert('没有权限，只有文章原作者及管理员可以操作！', 'js', 2);
            }
        } else {
            $this->alert('删除的文章ID不在！', 'js', 2);
        }
    }

    /**
     * 上传文章图片,图说
     * @param type $file 上传的临时文件
     * @param type $dir 上传目录
     * @return type  $file_name. $fileName 图片地址名称
     */
    function uploadarticlePic($file, $dir = 'article') {
        global $watermark_opt;
        $value = $this->pagedata->getSomePagedata("value", "name='waterpic'", 3);
        $list = unserialize($value);
        $waterpic = SITE_ROOT . $list['waterpic'];

        $uploadRootDir = ATTACH_DIR . "images/$dir/";
        file::forcemkdir($uploadRootDir);
        $uploadDir = $uploadRootDir . date("Y/m/d") . '/';
        file::forcemkdir($uploadDir);
        $file_name = "images/$dir/" . date("Y/m/d") . '/';
        $fileName = util::random(12);
        $fileName .= '.jpg';
//        move_uploaded_file($file, $uploadDir . $fileName);
        #计算图片宽、高，以高度为准
        if (move_uploaded_file($file, $uploadDir . $fileName)) {
            $t = @getimagesize($uploadDir . $fileName);
            $_width = 820;
            $_height = 540;
            if ($t[1]) {
                $_a = round($t[0] / 820, 2);
                $_height = $t[1] / $_a;
            }
            $ret = imagemark::resize($uploadDir . $fileName, "820x540", $_width, $_height, '', $watermark_opt);
            $ret = imagemark::resize($uploadDir . $fileName, "344x258", 344, 258, '', $watermark_opt);
            $rets = imagemark::resize($uploadDir . $fileName, "280x186", 280, 186, '', $watermark_opt);
            $retss = imagemark::resize($uploadDir . $fileName, "160x120", 160, 120, '', $watermark_opt);
            //生成水印
            imagemark::watermark($ret['tempurl'], array('type' => 'file', 'file' => $waterpic), 2, '', $watermark_opt);
            //imagemark::watermark($uploadDir . "820x540" . $fileName, array('type' => 'file', 'file' => $waterpic), $list['watermark'], '', $watermark_opt);
            imagemark::watermark($rets['tempurl'], array('type' => 'file', 'file' => $waterpic), 2, '', $watermark_opt);
            //imagemark::watermark($uploadDir . "280x186" . $fileName, array('type' => 'file', 'file' => $waterpic), $list['watermark'], '', $watermark_opt);
            imagemark::watermark($retss['tempurl'], array('type' => 'file', 'file' => $waterpic), 2, '', $watermark_opt);
            //imagemark::watermark($uploadDir . "160x120" . $fileName, array('type' => 'file', 'file' => $waterpic), $list['watermark'], '', $watermark_opt);
        }

        return $fileName;
    }

    /**
     * 上传图片
     * @param type $file 上传的临时文件
     * @param type $dir 上传目录
     * @return type  $file_name. $fileName 图片地址名称
     */
    function uploadPic($file, $dir = 'article') {
        global $watermark_opt;
        $uploadRootDir = ATTACH_DIR . "images/$dir/";
        file::forcemkdir($uploadRootDir);
        $uploadDir = $uploadRootDir . date("Y/m/d") . '/';
        file::forcemkdir($uploadDir);
        $file_name = "images/$dir/" . date("Y/m/d") . '/';
        $fileName = util::random(12);
        $fileName .= '.jpg';
        move_uploaded_file($file, $uploadDir . $fileName);
        if ($dir == 'articletitle') {
            imagemark::resize($uploadDir . $fileName, "820x550", 820, 550, '', $watermark_opt);
            imagemark::resize($uploadDir . $fileName, "344x258", 344, 258, '', $watermark_opt);
            imagemark::resize($uploadDir . $fileName, "280x186", 280, 186, '', $watermark_opt);
            imagemark::resize($uploadDir . $fileName, "160x120", 160, 120, '', $watermark_opt);
        } else {
            imagemark::resize($uploadDir . $fileName, "1180x400", 1180, 400, '', $watermark_opt);
        }
        return $file_name . $fileName;
    }

    function doKindedtorPic() {
        global $local_host, $watermark_opt;
        $value = $this->pagedata->getSomePagedata("value", "name='waterpic'", 3);

        $list = unserialize($value);
        $waterpic = SITE_ROOT . $list['waterpic'];

        $type = $this->getValue('type')->String('article');
        $ret_type = $this->getValue('ret')->String('js');
        #$ret_type = 'js';
        $src_fileid = $this->getValue('sfid')->String();
        $oFile = $_FILES[$src_fileid];
        if (!$src_fileid) {
            $this->alert('文件名称未指定', $ret_type, 1);
        } else {
            if (!is_writable(ATTACH_DIR)) {
                $this->alert('目录无权限', $ret_type, 1);
            }

            $attach_dir = ATTACH_DIR . 'images/';
            $sFileName = $oFile['name'];
            $sFileType = file::extname($sFileName);
            if ($sFileType != 'jpg' && $sFileType != 'png') {
                $this->alert('图片格式不合法，请上传JPG或PNG格式图片', $ret_type, 1);
            }

            $sOriginalFileName = $sFileName;
            $sExtension = substr($sFileName, ( strrpos($sFileName, '.') + 1));
            $sExtension = strtolower($sExtension);
            $dFileName = util::random(16) . "." . $sExtension;
            $sDate = date('Y/m/d');
            $attach_dir .= $type . '/' . $sDate . '/';
            file::forcemkdir($attach_dir);

            $image_url = $local_host . 'attach/images/' . $type . '/' . $sDate . '/820x540' . $dFileName;
            $sFilePath = $attach_dir . $dFileName;
            if (move_uploaded_file($oFile['tmp_name'], $sFilePath)) {
                $ret = imagemark::resize($sFilePath, "820x540", 820, 540, '', $watermark_opt);
                if ($ret) {
                    //$wapic =  $attach_dir . "820x540" . $dFileName;
                    imagemark::watermark($ret['tempurl'], array('type' => 'file', 'file' => $waterpic), 2, '', $watermark_opt);
                    //imagemark::watermark($wapic, array('type' => 'file', 'file' => $waterpic), $list['watermark'], '', $watermark_opt);
                }
                $this->alert('图片上传成功！', $ret_type, 0, $image_url);
            } else {
                $this->alert('图片上传失败！', $ret_type, 4);
            }
        }
    }

    function doArticlePicList() {
        $type_id = $this->getValue('id')->Int();
        $piclist = $this->cardbfile->getlist("id,name,DATE_FORMAT(FROM_UNIXTIME(created), '%Y/%m/%d') as created", "type_id='{$type_id}' and type_name='artile_pic'", 2);
        echo json_encode($piclist);
    }

    function doPic() {
        $a = $this->article->getArticle($this->getValue('id')->Int());
        $pic = RELAT_DIR . "attach/images/article/" . date('Ym', $a['created']) . "/" . date('d', $a['created']) . "/" . $a['pic'];
        echo "<img src='{$pic}', width='200'>";
        exit;
    }

    function doRTitle() {
        $this->postValue('title')->String() || exit('0');
        $title = trim($this->postValue('title')->String());
        $article = $this->article->getArticleFields("id", "title='$title' and type_id=1", 3);

        if (!empty($article)) {
            exit('1');
        } else {
            exit('0');
        }
    }

    function doPicPacking($currentdir = "images/article/") {
        global $watermark_opt;
        $filename = ATTACH_DIR . uniqid(mt_rand(), 1);
        //检测文件夹是否存在
        if (!is_dir($filename)) {
            file::forcemkdir($filename); //没有创建
        }
        $id = $this->getValue('id')->Int();
        $uptime = $this->article->getArticle($id);
        $piclist = $this->cardbfile->getlist("*", "type_id='{$uptime['pic_org_id']}' and type_name='artile_pic'", 2);
        $value = $this->pagedata->getSomePagedata("value", "name='waterpic'", 3);
        $list = $this->pagedata->mb_unserialize($value);
        $waterpic = SITE_ROOT . $list['waterpic']; //ams水印
        $wxwaterpic = SITE_ROOT . $list['wxwaterpic'];  //微信水印

        if (!empty($piclist)) {
            $pic = array();
            foreach ($piclist as $key => $value) {
                $filepath = ATTACH_DIR . $currentdir . date('Y/m/d', $value['created']); //原图目录
                if (is_dir($filepath)) {//判断原图目录是否存在
                    #计算图片宽、高，以高度为准
                    $t = @getimagesize($filepath . "/" . $value['name']); //计算原图尺寸
                    $ret = imagemark::resize($filepath . "/" . $value['name'], "wx_", $t[0], $t[1], '', $watermark_opt); //生成原图副本
                    if ($ret['tempurl']) {
                        //判断原图副本是否存在
                        //生成水印
                        if ($list['wxstate'] == 1) {//判断微信水印是否需要
                            imagemark::watermark($ret['tempurl'], array('type' => 'file', 'file' => $wxwaterpic), $list['wxwatermark'], '', $watermark_opt);
                        }
                        if ($list['watstate'] == 1) {//判断微信水印是否需要
                            imagemark::watermark($ret['tempurl'], array('type' => 'file', 'file' => $waterpic), $list['watermark'], '', $watermark_opt);
                        }
                    } else {
                        exit('原图副本不存在'); //即使创建，仍有可能失败
                    }
                    $pic[$key]['tempic'] = $ret['tempurl'];
                    $pic[$key]['pic'] = $filename . "/wx_" . $value['name'];
                } else {
                    echo "<script>alert('当前目录不是有效目录');</script>";
                }
            }
        } else {
            echo "<script>alert('请查看是否上传图片');</script>";
        }

        $filenames = $filename . '/PicPacking.zip'; //最终生成的文件名（含路径）
        //重新生成文件
        $zip = new ZipArchive();
        if ($zip->open($filenames, ZIPARCHIVE::CREATE) === TRUE) {
//            var_dump($pic);die;
            if (!empty($pic)) {
                foreach ($pic as $key => $val) {
                    if (file_exists($val['tempic'])) {
                        rename($val['tempic'], $val['pic']); //拷贝到新目录
                        if (file_exists($val['pic'])) {
                            $zip->addFile($val['pic']);
                        }
                    }
                }
            }
            $zip->close(); //关闭
        } else {
            exit('生成zip失败'); //即使创建，仍有可能失败
        }
        //文件下载
        //打开文件---先判断再操作
        if (!file_exists($filenames)) {
            exit('无法找到文件'); //即使创建，仍有可能失败
        }
        //存在--打开文件
        $fp = fopen($filenames, "r");
        //获取文件大小
        $file_size = filesize($filenames);

        //http 下载需要的响应头
        header("Content-type: application/octet-stream"); //返回的文件
        header("Accept-Ranges: bytes");   //按照字节大小返回
        header("Accept-Length: $file_size"); //返回文件大小
        header("Content-Disposition: attachment; filename=" . $filenames); //这里客户端的弹出对话框，对应的文件名
        //向客户端返回数据
        //设置大小输出
        $buffer = 1024;
        //为了下载安全，我们最好做一个文件字节读取计数器
        $file_count = 0;
        //判断文件指针是否到了文件结束的位置(读取文件是否结束)
        while (!feof($fp) && $file_count < $file_size) {
            $file_data = fread($fp, $buffer);
            //统计读取多少个字节数
            $file_count+=$buffer;
            //把部分数据返回给浏览器
            echo $file_data;
        }
        //关闭文件 下载完成后删除压缩包，临时文件夹  
        if (fclose($fp)) {
            $dh = file::removedir($filename . "/");
        }
    }

    /**
     * 设置权限
     * @global global $adminauth
     * @global int $login_uid
     * @param int $id
     * @param string $module_type sys_module或其它已知
     * @param char $type_value 可选A, W, R, N
     */
    function checkAuth($id, $module_type = 'sys_module', $type_value = "A") {
        global $adminauth, $login_uid;
        #如果是文章页权限，如果是管理员直接通过
        #如果是文章原作者，直接通过
        $is_draft = $this->getValue('old')->Int();
        if (!$is_draft) {
            $article_id = $this->postValue('article_id')->Int();
            $draft_id = $this->postValue('id')->Int();
            $is_draft = $article_id == $draft_id ? false : true;
        }
        $super = $adminauth->superUser($login_uid);
        if ($module_type == 'article') {
            if ($super) {
                return true;
            } else {
                $user = $this->user->getUser($login_uid);
                #管理员组ID = 1
                if ($user['group_id'] == 1) {
                    return true;
                } else {
                    #文章原作者
                    if ($is_draft) {
                        $article = $this->articlelogs->getarticle($id);
                    } else {
                        $article = $this->article->getArticle($id);
                    }
                    #作者UID相同，真实姓名相同，昵称相同，登录名相同，均可编辑文章
                    if ($article['uid'] == $login_uid || $article['author'] == $user['realname'] || $article['author'] == $user['username'] || $article['author'] == $user['nickname']) {
                        return true;
                    }
                }
                return false;
            }
        } elseif ($module_type == 'preview') {
            $auth = $adminauth->getUserModuleAuth($login_uid, $id, $type_value);
            return $auth;
        } else {
            $adminauth->checkAuth($login_uid, $module_type, $id, $type_value);
        }
    }

    function doLiu() {
        $articleid = $this->postValue('articleid')->Val();
        if ($articleid) {
            echo implode(',', $articleid);
        } else {
            if ($_POST["search"] || $_GET["startdate"]) {
                $s = $_POST["startdate"];
                $e = $_POST["enddate"];

                $startdate = $s ? strtotime($s) : $_GET["startdate"];
                $enddate = $e ? strtotime($e) : $_GET["enddate"];
                $rstartdate = $startdate > $enddate ? $enddate : $startdate;
                $renddate = $startdate > $enddate ? $startdate : $enddate;
            } else {
                //取出默认前一天的pv/ip流量统计
                $rstartdate = strtotime(date("Y-m-d", strtotime("-1 day")));
                $renddate = strtotime(date("Y-m-d", time()));
            }
            $articleid = $this->getValue('id')->Val();
            $article_id = explode(',', $articleid);
            if ($article_id)
                foreach ($article_id as $key => $value) {
                    $stat[$value] = $this->counter->getWebstatcount("SUM(pv) pv,SUM(uv) uv,SUM(ip) ip", "cname='article' and c1 >0 and c2 > 0 and c3 = '{$value}' and '{$rstartdate}' <= timeline AND timeline < '{$renddate}'", 1);
                }
            $this->vars('startdate', date("Y-m-d", $rstartdate));
            $this->vars('enddate', date("Y-m-d", $renddate));
            $this->vars('stat', $stat);
            $this->vars('title', '文章');
            $this->template('article_liu');
        }
    }

}

?>
