<?php

/**
 * video action
 * $Id: videoaction.php 2729 2016-05-25 03:28:38Z cuiyuanxin $
 */
class videoAction extends action {

    var $article;
    var $articletype;
    var $cardbfile;
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
        $this->counter = new counter();
        $this->checkAuth(501);
    }

    function doDefault() {
        $this->doList();
    }

    //发布视频
    function doAdd() {
        global $login_uid, $login_uname;
        $this->tpl_file = "video_add";
        $this->page_title = "发布视频";

        $brand = $this->brand->getAllBrand('state=3', array('letter' => 'asc'), 200);
        $tags = $this->tags->getTagFields("distinct letter", "type_id=1 and state=1", 2, array("letter" => "asc"));
        $pcategory = $this->category->getlist("*", "parentid=0 and state=1", 2);
        $this->vars("pcategory", $pcategory[2]);
        $this->vars("brand", $brand);
        $this->vars("tag", $tags);


        if ($_POST) {
            $title = $this->postValue('title')->String();
            $title3 = $this->postValue('title3')->String();
            $photor = $this->postValue('photor')->String();
            $url = $this->postValue('source')->String();
            $pic_name = $this->postValue('pic_name')->String();
            ;
            $hot_pic_name = $this->postValue('hot_pic_name')->String();
            $chief = $this->postValue('chief')->String();
            $maxservice = $this->postValue('maxservice')->String();
            $cagegory = $this->postValue('cagegory')->String();
            $cagegory_id = $this->postValue('cagegory_id')->Int();
            $pic_org_id = $this->postValue('pic_org_id')->Int();
            $article_id = $this->postValue('article_id')->Int();
            $tag_maxservice = $this->postValue('tag_maxservice')->Val();
            $str_series_name = "";
            $str_tag_name = "";
            $str_series_id = "";
            $str_tag_id = "";
            $article = $this->articlelogs->getArticleFields("*", "id=" . $this->postValue('id')->Int(), 1);
            if (preg_match_all('/http:\/\/v\.youku\.com\/v_show\/id_(.*)?\.html/', $url, $url_array)) {
                $source = 'http://player.youku.com/player.php/sid/' . str_replace('/', '', $url_array[1][0]) . '/v.swf';
            } else {
                $source = $url;
            }

            $this->articlelogs->ufields = array(
                "title" => $title,
                "title3" => "$title3",
                "photor" => "$photor",
                "source" => $source,
                "chief" => $chief,
                "relative_title" => $this->postValue('relative_title')->String(),
                "relative_url" => $this->postValue('relative_url')->String(),
                "content" => "$content",
                "pic" => $pic_name,
                "hot_pic" => "$hot_pic_name",
                "created" => time(),
                "type_id" => 2,
                "uid" => $login_uid,
                "author" => $login_uname,
                'pic_org_id' => $pic_org_id,
                'article_id' => $article_id,
                "category_id" => $cagegory_id,
            );
            $uptime = $this->postValue('uptime')->String();
            if ($uptime) {
                $this->articlelogs->ufields['uptime'] = strtotime($uptime);
            }
            $comment = $this->postValue('comment')->String();
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
                $tag_id = $this->postValue('tag_name_id' . $j)->String();
                $tag_name = $this->postValue('tag_name' . $j)->String();
                if ($tag_id) {
                    $str_tag_name .=$tag_name . ',';
                    $str_tag_id .=$tag_id . ',';
                }
            }

            $str_tag_name = rtrim($str_tag_name, ',');
            $str_tag_id = rtrim($str_tag_id, ',');
            $this->articlelogs->ufields["seriesname_list"] = $str_series_name;
            $this->articlelogs->ufields["tagname_list"] = $str_tag_name;
            $this->articlelogs->ufields["series_list"] = $str_series_id;
            $this->articlelogs->ufields["tag_list"] = $str_tag_id;
            $id = $this->articlelogs->insert();

            //添加到正式文章表
            $article = $this->articlelogs->getArticleFields("*", "id=$id", 1);

            if ($article[article_id]) {
                $artilce_id = $article[article_id];
                unset($article[article_id]);
                unset($article[comment]);
                unset($article[state]);
                unset($article[ishot]);
                unset($article[id]);
                unset($article[author]);
                $this->article->where = "id=$artilce_id";
                $comment = $this->article->getArticleFields("comment,ishot", "id=$artilce_id", 1);
                $article = array_merge($article, $comment);
                $this->article->ufields = $article;
                $result1 = $this->postValue('resutl')->Int();
                if ($result1 == 1) {
                    $this->article->ufields['state'] = 0;
                }
                $this->article->ufields['updated'] = time();
                $this->article->update();
//               
            } else {
                unset($article['article_id']);
                unset($article['id']);
                $this->article->ufields = $article;
                $article_id = $this->article->insert();
//               
                $this->articlelogs->ufields = array(
                    "article_id" => "$article_id",
                );
                $this->articlelogs->where = "id=$id";
                $this->articlelogs->update();
            }

            for ($i = 0; $i < $maxservice; $i++) {
                $j = $i + 1;
                $sname = 'series_id' . $j;
                $series_id = $this->postValue($sname)->Int();
                $series_name = $this->postValue('series_name' . $j)->Val();
                $article_seriesid = $this->postValue('article_seriesid' . $j)->Val();
                if ($series_id) {
                    $this->articleseries->ufields = array("article_id" => "$article_id", "series_id" => "$series_id", "series_name" => "$series_name", "created" => time());
                    $article_seriesid = $this->articleseries->getArticleSeries("id", "id='$article_seriesid'", 3);
                    if ($article_seriesid) {
                        $this->articleseries->where = "id=$article_seriesid";
                        $this->articleseries->update();
                    } else {
                        $this->articleseries->insert();
                    }
                }
            }

            for ($i = 0; $i < $tag_maxservice; $i++) {
                $j = $i + 1;
                $tag_id = $this->postValue('tag_name_id' . $j)->String();
                $tag_name = $this->postValue('tag_name' . $j)->String();
                $article_tagid = $this->postValue('article_tagid' . $j)->String();
                if ($tag_id) {
                    $this->articletags->ufields = array("article_id" => "$article_id", "tag_id" => "$tag_id", "tag_name" => "$tag_name", "created" => time());
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
        } else {
            $type = $this->getValue('type')->Int();

            if ($type) {
                $this->vars("typetitle", "审核结果");
            }
            $old = $this->getValue('old')->Int();
            $id = $this->getValue('id')->Int();
            if ($id) {
                $article = $this->articlelogs->getArticleFields("*", "article_id='{$id}' order by created desc", 1);
                $this->vars('id', $id);
            } else {
                if ($old) {
                    $article = $this->articlelogs->getArticleFields("*", "uid=$login_uid order by created desc", 1);
                    //var_dump($article);
                }
            }
            if ($article['article_id']) {
                $comment = $this->article->getArticleFields("*", "id=$article[article_id]", 1);
                $this->vars("type", $type);
                $this->vars("comment", $comment);
            }
            if ($article) {
                $pic_org_id = empty($article[pic_org_id]) ? $article[id] : $article[pic_org_id];
                $piclist = $this->cardbfile->getlist("*", "type_id=$pic_org_id", 2);
                $this->vars("piclist", $piclist);
            }
            if ($article[category_id]) {
                $category = $this->category->getlist("*", "id=$article[category_id]", 1);
                $this->vars('category', $category);

                $categorylist = $this->category->getlist("*", "parentid=$category[parentid]", 2);
                $this->vars('cagegorylist', $categorylist);
            }
            if ($article['tag_list']) {
                $tagservice = array();
                $tag_maxservice_id = 0;
                $taglist = $this->tags->getTagFields("*", "id in($article[tag_list])", 2, array());
                foreach ($taglist as $key => $value) {
                    $tag_maxservice_id++;
                    $tagservice[$key]['tag'] = $tags;
                    $letter = $this->tags->getTagFields("letter", "id=$value[id]", 3, array());
                    $tagname = $this->tags->getTagFields("id,tag_name", "type_id=1 and state=1 and letter = '$letter'", 2, array("letter" => "asc"));
                    $article_tagid = $this->articletags->getTagFields("id", "tag_id='$value[id]' and article_id='$article[article_id]'", 3);
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
            $this->vars('article', $article);
            $this->template();
        }
    }

    //保存草稿
    function doAddarticlelogs() {
        global $login_uid, $login_uname;

        $title = $this->postValue('title')->String();
        $source = $this->postValue('source')->String();
        $pic_name = $this->postValue('pic_name')->String();
        $chief = $this->postValue('chief')->String();
        $maxservice = $this->postValue('maxservice')->String();
        $cagegory = $this->postValue('cagegory')->Val();
        $hot_pic_name = $this->postValue('hot_pic_name')->String();
        $pic_org_id = $this->postValue('pic_org_id')->Int();
        $article_id = $this->postValue('article_id')->Int();
        $cagegory_id = $this->postValue('cagegory_id')->Int();
        $tag_maxservice = $this->postValue('tag_maxservice')->Val();
        $str_series_name = "";
        $str_tag_name = "";
        $str_series_id = "";
        $str_tag_id = "";

        $this->articlelogs->ufields = array(
            "title" => "$title",
            "source" => "$source",
            "chief" => "$chief",
            "relative_title" => $this->postValue('relative_title')->Val(),
            "relative_url" => $this->postValue('relative_url')->Val(),
            "content" => "$content",
            "pic" => "$pic_name",
            "hot_pic" => "$hot_pic_name",
            "created" => $this->timestamp,
            "type_id" => 2,
            "uid" => $login_uid,
            "author" => $login_uname,
            'pic_org_id' => $pic_org_id,
            'article_id' => $article_id,
            'category_id' => $cagegory_id,
        );
        $uptime = ($this->postValue('uptime')->Int());
        if ($uptime) {
            $this->articlelogs->ufields['uptime'] = strtotime($uptime);
        }
        $comment = $this->postValue('comment')->String();
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
            $tag_id = $this->postValue('tag_name_id' . $j)->Int();
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

    function doRTitle() {
        $title = $this->postValue('title')->String();
        $title || exit('0');

        $article = $this->article->getArticleFields("id", "title='$title'", 3);

        if (!empty($article)) {
            exit('1');
        } else {
            exit('0');
        }
    }

    function doPreview() {
        global $local_host;
        $s = $this->getValue('s')->String();
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

        $this->id = $id = $this->getValue('id')->Int();
        $this->tpl_file = "video_page";
        $article = $this->article->getArticle($this->getValue('id')->Int());
        $articlelog = $this->articlelogs->getArticleFields("*", "article_id=$this->getValue('id')->Int() order by created desc", 1);
        $taglist = $this->tags->getTagFields("id,tag_name", "type_id=1 and state=1 and id in($article[tag_list])", 2);

        $serieslist = $this->series->getSeriesdata("series_id,sereis_name,series_pic", "series_id in($article[series_list])", 2);
        $dir = date("Ym/d", $article['uptime']);

        /**
         * return first series_id in series_list
         * compatible PHP 5.2
         */
        if (false !== ($pos = strpos($article['series_list'], ','))) {
            $series_id = substr($article['series_list'], 0, $pos);
        } else {
            $series_id = $article['series_list'];
        }

        $series = $this->series->getSeriesdata("*", "series_id =$series_id", 1);

        //频道
        $category = $this->category->getlist("*", "id=$article[category_id]", 1);
        $p_category = $this->category->getlist("*", "id=$category[parentid]", 1);

        $models = $this->models->getSimp("MAX(model_price) AS max_price,MIN(model_price) AS min_price", "series_id=$series_id and state in(3,8)", 1);

        $this->vars('model_price', $models);
        $this->vars('category', $category);
        $this->vars('p_category', $p_category);
        $this->vars('series', $series);
        $this->vars('taglist', $taglist);
        $this->vars('serieslist', $serieslist);
        $this->vars('make_flag', $make_flag);

        if ($article['source']) {
            $page_title = $article['title'] . $article['source'] . '_' . $navstr . '_车评网';
            $page_titleTemp = $article['title'] . $article['source'];
        } else {
            $page_title = $article['title'] . '_车评网';
            $page_titleTemp = $article['title'];
        }

        #去除空段
        $article['content'] = preg_replace('%(<p[^>]*>\s*</p>)%', '', $article['content']);
//       var_dump($article);
        $this->vars('page_title', $page_title);
        $this->vars('keywords', $page_titleTemp);
        $this->vars('description', $page_titleTemp);
        $this->vars('article', $article);
        $this->vars('articlelog', $articlelog);
        $this->vars('id', $id);
        $this->vars('s', $s);

        $html = $this->fetch($this->tpl_file);
        if (!$make_flag)
            $html = $this->getSSIfile($html);
        echo $this->replaceTpl($html);
//      
    }

    //视频列表
    function doList() {
        $this->page_title = "视频列表";
        $this->tpl_file = "video_list";
        $page = $this->getValue('page')->Int();
        $page = max(1, $page);
        $page_size = 18;
        $page_start = ($page - 1) * $page_size;
        $where = "state in(2,3) and type_id=2";

        if ($_REQUEST[keyword]) {
            $keword = trim($_REQUEST[keyword]);
            $where .=" and title like '%$keword%'";
            $extra .="&keyword=$keword";
            $this->vars('keword', $keword);
        }
        if ($_REQUEST[author]) {
            $author = trim($_REQUEST[author]);
            $where .=" and author like '%$author%'";
            $extra .="&author=$author";
            $this->vars('author', $author);
        }
        if ($_REQUEST[article_id]) {
            $article_id = trim($_REQUEST[article_id]);
            $where .=" and id=$article_id";
        }

        # 
        $order = array("uptime" => 'desc');
        $fields = '*';
        $list = $this->article->getArticleList($where, $fields, $page_size, $page_start, $order);
        foreach ($list as $k => $v) {
            $list[$k]['url'] = $this->article->getRewriteUrlByAid($v['id']);
            $list[$k]['pv'] = $this->counter->getWebstatcount("SUM(pv) pv", "cname='video' and c1 = 9 and c2 = '{$v['category_id']}' and c3 = '{$v['id']}'", 3);
            $list[$k]['uv'] = $this->counter->getWebstatcount("SUM(uv) uv", "cname='video' and c1 = 9 and c2 = '{$v['category_id']}' and c3 = '{$v['id']}'", 3);
        }
        $total = $this->article->total;
        $page_bar = $this->multi($total, $page_size, $page, $_ENV['PHP_SELF'] . $extra);

        $this->vars('list', $list);
        $this->vars('page_bar', $page_bar);
        $this->template();
    }

    //待审核视频列表
    function doVerifyList() {
        global $adminauth, $login_uid;
        #$adminauth->checkAuth($login_uid, 'sys_module', 501, 'A');
        $this->page_title = "待审核视频列表";
        $this->tpl_file = "video_verifylist";
        $page = $this->getValue('page')->Int();
        $page = max(1, $page);
        $page_size = 18;
        $page_start = ($page - 1) * $page_size;
        $where = "state=0 and type_id=2";
        if ($_REQUEST[keyword]) {
            $keword = trim($_REQUEST[keyword]);
            $where .=" and title like '%$keword%'";
            $extra .="&keyword=$keword";
            $this->vars('keword', $keword);
        }
        if ($_REQUEST[author]) {
            $author = trim($_REQUEST[author]);
            $where .=" and author '$author'";
            $extra .="&author=$author";
            $this->vars('author', $author);
        }
        if ($_REQUEST[article_id]) {
            $article_id = trim($_REQUEST[article_id]);
            $where .=" and id=$article_id";
        }
        $fields = '*';

        $list = $this->article->getArticleList($where, $fields, $page_size, $page_start);
        $total = $this->article->total;

        $page_bar = $this->multi($total, $page_size, $page, $_ENV['PHP_SELF'] . 'VerifyList' . $extra);

        $this->vars('list', $list);
        $this->vars('page_bar', $page_bar);
        $this->template();
    }

    //审核意见待处理视频列表
    function dotypeList() {
        $this->page_title = "审核意见待处理视频列表";
        $this->tpl_file = "video_typelist";
        $page = $this->getValue('page')->Int();
        $page = max(1, $page);
        $page_size = 18;
        $page_start = ($page - 1) * $page_size;

        $fields = '*';
        $where = "state=1 and type_id=2";
        if ($_REQUEST[keyword]) {
            $keword = trim($_REQUEST[keyword]);
            $where .=" and title like '%$keword%'";
            $extra .="&keyword=$keword";
            $this->vars('keword', $keword);
        }
        if ($_REQUEST[author]) {
            $author = trim($_REQUEST[author]);
            $where .=" and author '$author'";
            $extra .="&author=$author";
            $this->vars('author', $author);
        }
        if ($_REQUEST[article_id]) {
            $article_id = trim($_REQUEST[article_id]);
            $where .=" and id=$article_id";
        }
        $list = $this->article->getArticleList($where, $fields, $page_size, $page_start);

        $total = $this->article->total;

        $page_bar = $this->multi($total, $page_size, $page, $_ENV['PHP_SELF'] . 'typelist' . $extra);

        $this->vars('list', $list);
        $this->vars('page_bar', $page_bar);
        $this->template();
    }

    function dooldList() {
        $this->page_title = "文章列表";
        $this->tpl_file = "article_oldlist";
        $page = $this->getValue('page')->Int();
        $page = max(1, $page);
        $page_size = 18;
        $page_start = ($page - 1) * $page_size;

        $fields = '*';
        $where = "1";
        if ($_REQUEST[keyword]) {
            $keword = trim($_REQUEST[keyword]);
            $where .=" and title like '%$keword%'";
            $extra .="&keyword=$keword";
            $this->vars('keword', $keword);
        }
        if ($_REQUEST[author]) {
            $author = trim($_REQUEST[author]);
            $where .=" and author '$author'";
            $extra .="&author=$author";
            $this->vars('author', $author);
        }
        if ($_REQUEST[article_id]) {
            $article_id = trim($_REQUEST[article_id]);
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

    function docategorylist() {
        $id = $this->getValue('id')->Int();
        $category = $this->category->getlist("id,category_name", "parentid=$id and state=1", 2);
        if ($category) {
            echo json_encode($category);
        } else {
            echo 1;
        }
    }

    //第一版草稿，添加标题
    function doAddTitle() {
        global $login_uid, $login_uname;

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
            echo "no";
        } else {
            $id = $this->articlelogs->insert();
            echo $id;
        }
    }

    //删除文章标签
    function doDelArticleTag() {
        $tag_id = $this->getValue('tag_id')->Int();
        $article_id = $this->getValue('article_id')->Int();
        $article_tagid = $this->getValue('article_tagid')->Int();
        $this->articletags->where = "id=$article_tagid";
        $this->articletags->del();

        $tag = $this->articlelogs->getArticleFields("id,tag_list", "id='$article_id'", 1);

        $tagArr = explode(',', $tag['tag_list']);
        foreach ($tagArr as $key => $value) {
            if ($value == $tag_id) {
                unset($tagArr[$key]);
            }
        }

        $str_tag_name = implode(',', $tagArr);
        $this->articlelogs->ufields = array("tag_list" => $str_tag_name);
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

        $tag = $this->articlelogs->getArticleFields("id,series_list", "id='$article_id'", 1);

        $tagArr = explode(',', $tag[series_list]);
        foreach ($tagArr as $key => $value) {
            if ($value == $series_id) {
                unset($tagArr[$key]);
            }
        }

        $str_series_name = implode(',', $tagArr);
        $this->articlelogs->ufields = array("series_list" => $str_series_name);
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
        $letter = $this->getValue('letter')->En();
        $taglist = $this->tags->getTagFields("*", "type_id=1 and state=1 and letter='$letter'", 2, array("letter" => "asc"));
        echo json_encode($taglist);
    }

    function doajaxcagegory() {
        $id = $this->getValue('id')->Int();
        $fields = "pca.id pcaid,pca.category_name";
        $where = "ca.id=pca.parentid and pca.state=1 and pca.parentid=" . $id;
        $aa = $this->category->getFields($fields, $where);
        if (!empty($aa)) {
            echo json_encode($aa);
        } else {
            echo 1;
        }
    }

    //上传文章所需图片
    function doArticlePic() {
        $tpl_file = 'article_pic';
        $id = $this->getValue('id')->Int();
        $list = $this->cardbfile->getlist("*", "type_id=$id", 2);

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
                    "created" => time(),
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
        $content = $this->postValue('content')->Trim();
        if ($id && $content && $pic_org_id) {
            $this->cardbfile->ufields = array(
                "updated" => time(),
                "memo" => "$content",
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
        $id = $this->postValue('id')->Int();
        $pic_org_id = $this->postValue('pic_org_id')->Int();
        $content = $this->postValue('name_title')->Trim();

        if ($id && $content && $pic_org_id) {
            foreach ($id as $k => $v) {
                $this->cardbfile->ufields = array(
                    "updated" => $this->timestamp,
                    "memo" => "$content[$k]",
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

    function doarticlecomment() {
        global $login_uid, $login_uname;
        $this->checkAuth(503);
        $content = $this->postValue('content')->Trim();
        $article_id = $this->postValue('article_id')->Int();
        $articlelog_id = $this->postValue('articlelog_id')->Int();
        $state = $this->postValue('state')->Int();
        $this->articlecomment->ufields = array(
            "comment" => "$content",
            "article_id" => $article_id,
            "articlelog_id" => $articlelog_id,
            "created" => time(),
            "uid" => $login_uid,
            "uname" => "$login_uname"
        );
        $id = $this->articlecomment->insert();

        $this->article->where = "id=$article_id";
        $this->article->ufields = array(
            "state" => "$state",
            "comment" => "$content",
        );
        if ($state == 2) {
            $this->article->ufields['state'] = 1;
            $this->article->ufields['ishot'] = 1;
        }

        $this->article->update();
        echo $id;
    }

    function doEdit() {
        $this->doAdd();
    }

    function doDel() {
        $id = $this->getValue('id')->Int();
        $this->article->where = "id='{$id}'";
        $ret = $this->article->del();

        $msg = "删除";
        if ($ret) {
            $msg .= "成功！";
        } else {
            $msg .= "失败！";
        }
        $message = array(
            'type' => 'js',
            'act' => 3,
            'message' => $msg,
            'url' => $_ENV['PHP_SELF']
        );
        $this->alert($message);
    }

    //上传文章图片
    /**
     * @param type $file 上传的临时文件
     * @param type $dir 上传目录
     * @return type  $file_name. $fileName 图片地址名称
     */
    function uploadarticlePic($file, $dir = 'article') {
        global $watermark_opt;
        $waterpic = SITE_ROOT . "images/watermark/waterpic.png";

        $uploadRootDir = ATTACH_DIR . "images/$dir/";
        file::forcemkdir($uploadRootDir);
        $uploadDir = $uploadRootDir . date("Y/m/d", time()) . '/';
        file::forcemkdir($uploadDir);
        $file_name = "images/$dir/" . date("Y/m/d", time()) . '/';
        $fileName = util::random(12);
        $fileName .= '.jpg';
        move_uploaded_file($file, $uploadDir . $fileName);
        //生成水印
        $ret = imagemark::resize($uploadDir . $fileName, "360x270", 360, 270, '', $watermark_opt);
        imagemark::watermark($ret['tempurl'], array('type' => 'file', 'file' => $waterpic), 3, '', $watermark_opt);
        imagemark::watermark($uploadDir . $fileName, array('type' => 'file', 'file' => $waterpic), 3, '', $watermark_opt);
        return $fileName;
    }

    function uploadPic($file, $dir = 'article') {
        global $watermark_opt;
        $uploadRootDir = ATTACH_DIR . "images/$dir/";
        file::forcemkdir($uploadRootDir);
        $uploadDir = $uploadRootDir . date("Y/m/d", time()) . '/';
        file::forcemkdir($uploadDir);
        $file_name = "images/$dir/" . date("Y/m/d", time()) . '/';
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

    function doPic() {
        $a = $this->article->getArticle($this->getValue('id')->Int());
        $pic = RELAT_DIR . "attach/images/article/" . date('Ym', $a['created']) . "/" . date('d', $a['created']) . "/" . $a['pic'];
        echo "<img src='{$pic}', width='200'>";
        exit;
    }

    function checkAuth($id, $module_type = 'sys_module', $type_value = "A") {
        global $adminauth, $login_uid;
        $adminauth->checkAuth($login_uid, $module_type, $id, 'A');
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
                    $stat[$value] = $this->counter->getWebstatcount("SUM(pv) pv,SUM(uv) uv,SUM(ip) ip", "cname='video' and c1 >0 and c2 > 0 and c3 = '{$value}' and '{$rstartdate}' <= timeline AND timeline < '{$renddate}'", 1);
                }
            $this->vars('startdate', date("Y-m-d", $rstartdate));
            $this->vars('enddate', date("Y-m-d", $renddate));
            $this->vars('stat', $stat);
            $this->vars('title', '视频');
            $this->template('article_liu');
        }
    }

}

?>
