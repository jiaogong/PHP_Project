<?php

class articleAction extends action {

    public $user;
    public $review;
    public $badword;
    public $article;
    public $tag;
    public $article_category;
    public $collect;
    public $pagedate;
    public $friend;
    public $series;

    function __construct() {
        parent::__construct();
        $this->user = new users();
        $this->review = new reviews();
        $this->badword = new badword();
        $this->article = new article();
        $this->article_category = new article_category();
        $this->tag = new tag();
        $this->collect = new collect();
        $this->pagedate = new pageData();
        $this->friend = new friend();
        $this->series = new series();
    }

    function doDefault() {
        $this->doCarReview();
    }

    /**
     * 资讯频道列表页面
     * id文章栏目父栏目，ids对应子栏目号
     */
    function doCarReview() {
        $page_size = 10;
        $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
        $ids = filter_input(INPUT_GET, 'ids', FILTER_SANITIZE_NUMBER_INT);
        $page = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_NUMBER_INT);
        #新闻频道
        if ($id == 7) {
            $template_name = "news";
            $where = "id='{$id}' and state=1";
            $actitle = $this->article_category->getCount($where);
            $linklist = $this->friend->getAllFriendLink("category_id='7' order by seq asc","*",2);
            $page = max(1, $page);
            $page_start = ($page - 1) * $page_size;

            if (!isset($ids)) {
                if ($page !== 1) {
                    $title = "汽车新闻,上市新车资讯,国内外汽车行业最新新闻资讯大全,第" . $page . "页-" . SITE_NAME;
                } else {
                    $title = "汽车新闻,上市新车资讯,国内外汽车行业最新新闻资讯大全-" . SITE_NAME;
                }
                $keyword = "汽车新闻,汽车资讯,上市新车,最新汽车行业新闻, 车评网";
                $description = "车评网汽车新闻频道为您报道最新上市新车资讯，国外及中国汽车行情新闻，汽车行业最新新闻资讯等内容，看汽车新闻资讯就上车评网。";
                $where = "ca.category_id=cac.id and cac.parentid='{$id}' and cac.id!=63 and ca.state=3";
                $lists = $this->article->getArticle($where, $page_size, $page_start, array("ca.uptime" => "DESC"));
                if($lists){
                    foreach ($lists as $key => $value) {
                        $lists[$key]['pic'] = $this->article->getArticlePic($value['pic'], '280x186');
                    }
                }

                $extra.="article.php?action=CarReview&id=" . $id;
            } else {
                if ($ids == 54) {
                    if ($page !== 1) {
                        $title = "进口新车资讯,国内外即将上市的新车,新车大全-汽车新闻,第" . $page . "页-" . SITE_NAME;
                    } else {
                        $title = "进口新车资讯,国内外即将上市的新车,新车大全-汽车新闻-" . SITE_NAME;
                    }
                    $keyword = "进口新车资讯,国内新车,即将上市的新车,新车大全";
                    $description = "车评网新车资讯栏目为您提供进口新车资讯,国内外即将上市的新车新闻,最近新车上市资讯。更多新车资讯新闻大全尽在车评网.看新车资讯新闻就上车评网. ";
                } else if ($ids == 55) {
                    if ($page !== 1) {
                        $title = "最新汽车资讯,中国汽车市场行情-汽车新闻,第" . $page . "页-" . SITE_NAME;
                    } else {
                        $title = "最新汽车资讯,中国汽车市场行情-汽车新闻-" . SITE_NAME;
                    }
                    $keyword = "汽车资讯,汽车新闻资讯,中国汽车市场行情, 车评网";
                    $description = "车评网汽车资讯栏目为您报道汽车行业最新资讯,中国汽车市场行情，更多精彩汽车资讯尽在车评网，看汽车新闻资讯就上车评网.";
                } else if ($ids == 60) {
                    if ($page !== 1) {
                        $title = "汽车趣闻,驾车趣闻,玩车趣闻,汽车趣事-汽车新闻,第" . $page . "页-" . SITE_NAME;
                    } else {
                        $title = "汽车趣闻,驾车趣闻,玩车趣闻,汽车趣事-汽车新闻-" . SITE_NAME;
                    }
                    $keyword = "汽车趣闻,驾车趣闻,玩车趣闻,汽车趣事, 车评网";
                    $description = "车评网汽车趣闻栏目为您提供汽车趣闻,驾车趣闻,玩车趣闻等更多汽车趣事,让您在了解汽车的基础上也能有更愉快的心情。更多汽车趣闻轶事尽在车评网.";
                }else if ($ids == 63) {
                    if ($page !== 1) {
                        $title = "汽车行业动态-汽车资讯,第" . $page . "页-" . SITE_NAME;
                    } else {
                        $title = "汽车行业动态-汽车资讯-" . SITE_NAME;
                    }
                    $keyword = "汽车行业,汽车资讯";
                    $description = "ams车评网汽车行业栏目为您报道汽车行业最新资讯及动 态,更多精彩汽车资讯尽在ams车评网.";
                }
                $where = "ca.category_id=cac.id and ca.category_id='{$ids}' and ca.state=3";
                $lists = $this->article->getArticle($where, $page_size, $page_start, array("ca.uptime" => "DESC"));
                if ($lists){
                    foreach ($lists as $key => $value) {
                        $lists[$key]['pic'] = $this->article->getArticlePic($value['pic'], '280x186');
                    }
                }
                $extra.="article.php?action=CarReview&id=$id&ids=" . $ids;
            }

            $page_bar = multipage::multis($this->article->total, $page_size, $page, $_ENV['PHP_SELF'] . $extra, 0, 6);
        } 
        #评测频道
        elseif ($id == 8) {
            $template_name = "pingce";
            $where = "id='{$id}' and state=1";
            $actitle = $this->article_category->getCount($where);
            $page = max(1, $page);
            $page_start = ($page - 1) * $page_size;
            $linklist = $this->friend->getAllFriendLink("category_id='8' order by seq asc","*",2);
            if (!isset($ids)) {
                if ($page !== 1) {
                    $title = "品牌汽车评测,新车试驾点评,汽车驾驶测试及测评大全,第" . $page . "页-" . SITE_NAME;
                } else {
                    $title = "品牌汽车评测,新车试驾点评,汽车驾驶测试及测评大全-" . SITE_NAME;
                }
                $keyword = "汽车评测,新车试驾,汽车点评,汽车驾驶测试";
                $description = "车评网拥有最专业汽车评测团队,提供专业真实的品牌汽车评测,包括汽车评测,新车试驾,汽车点评,汽车驾驶测试等内容,更多汽车评测信息尽在车评网官网.";
                $where = "ca.category_id=cac.id and cac.parentid='{$id}' and ca.state=3";
                $lists = $this->article->getArticle($where, $page_size, $page_start, array("ca.uptime" => "DESC"));
                if ($lists){
                    foreach ($lists as $key => $value) {
                        $lists[$key]['pic'] = $this->article->getArticlePic($value['pic'], '280x186');
                    }
                }
                $extra.="article.php?action=CarReview&id=" . $id;
            } else {
                if ($ids == 56) {
                    if ($page !== 1) {
                        $title = "汽车测试,品牌新车测试-汽车评测,第" . $page . "页-" . SITE_NAME;
                    } else {
                        $title = "汽车测试,品牌新车测试-汽车评测-" . SITE_NAME;
                    }
                    $keyword = "汽车测试, 品牌新车测试,";
                    $description = "车评网拥有最专业的汽车评测团队，为您提供真实专业的汽车评测,汽车测试资讯等内容，让您在第一时间了解到品牌车型的情况。更多汽车测试信息尽在车评网.";
                } else if ($_GET['ids'] == 16) {
                    if ($page !== 1) {
                        $title = "汽车驾驶,新车试驾,品牌汽车试驾-汽车评测,第" . $page . "页-" . SITE_NAME;
                    } else {
                        $title = "汽车驾驶,新车试驾,品牌汽车试驾-汽车评测-" . SITE_NAME;
                    }
                    $keyword = "汽车驾驶,新车试驾,汽车试驾评测";
                    $description = "车评网官网汽车驾驶栏目为您提供最专业真实的品牌汽车驾驶及新车试驾等精彩内容，让您更容易了解到品牌车型的真实情况。更多汽车驾试试驾信息尽在车评网.";
                } else if ($_GET['ids'] == 59) {
                    if ($page !== 1) {
                        $title = "汽车对比评测,汽车对比测试,对比试驾-汽车评测,第" . $page . "页-" . SITE_NAME;
                    } else {
                        $title = "汽车对比评测,汽车对比测试,对比试驾-汽车评测-" . SITE_NAME;
                    }
                    $keyword = "汽车对比评测,汽车对比,对比测试,对比试驾";
                    $description = "车评网拥有最专业的汽车对比评测及测试团队，为您提供真实专业的汽车对比评测,汽车对比测试,对比试驾等内容，让您在第一时间了解到品牌车型的情况。更多汽车对比评测及测试信息尽在车评网.";
                }
                $where = "ca.category_id=cac.id and ca.category_id='{$ids}' and ca.state=3";
                $lists = $this->article->getArticle($where, $page_size, $page_start, array("ca.uptime" => "DESC"));
                if($lists){
                    foreach ($lists as $key => $value) {
                        $lists[$key]['pic'] = $this->article->getArticlePic($value['pic'], '280x186');
                    }
                }
                $extra.="article.php?action=CarReview&id=$id&ids=" . $ids;
            }
            $page_bar = multipage::multis($this->article->total, $page_size, $page, $_ENV['PHP_SELF'] . $extra, 0, 6);
        } 
        #视频频道
        elseif ($id == 9) {
            $path = "video.php?action=Video&id=" . $id;
            $path = replaceVideoUrl($path);
            $this->alert('', 'js', 3, $path);
        } 
        #文化频道
        elseif ($id == 10) {
            $template_name = "wenhua";
            $where = "id='{$id}' and state=1";
            $actitle = $this->article_category->getCount($where);
            $page = max(1, $page);
            $page_start = ($page - 1) * $page_size;
            $linklist = $this->friend->getAllFriendLink("category_id='10' order by seq asc","*",2);
            if (!isset($ids)) {
                if ($page !== 1) {
                    $title = "汽车品牌文化,赛车文化,最新汽车文化大全,第" . $page . "页-" . SITE_NAME;
                } else {
                    $title = "汽车品牌文化,赛车文化,最新汽车文化大全-" . SITE_NAME;
                }
                $keyword = "汽车品牌文化,赛车文化,汽车文化";
                $description = "车评网汽车文化频道为您提供全面的汽车文化、汽车品牌文化、赛车文化及风云车等等汽车文化知识，了解更多汽车文化就到车评网！";
                $where = "ca.category_id=cac.id and cac.parentid='{$id}' and ca.state=3";
                $lists = $this->article->getArticle($where, $page_size, $page_start, array("ca.uptime" => "DESC"));
                if ($lists){
                    foreach ($lists as $key => $value) {
                        $lists[$key]['pic'] = $this->article->getArticlePic($value['pic'], '280x186');
                    }
                }
                $extra.="article.php?action=CarReview&id=" . $id;
            } else {
                if ($ids == 50) {
                    if ($page !== 1) {
                        $title = "经典车-汽车文化,第" . $page . "页-" . SITE_NAME;
                    } else {
                        $title = "经典车-汽车文化-" . SITE_NAME;
                    }
                    $keyword = "经典车,汽车文化,新车大全";
                    $description = "ams车评网,源自德国auto motor und sport,国内汽车评测开创者,为您提供最专业最准确的经典车文化. ";
                } else if ($ids == 51) {
                    if ($page !== 1) {
                        $title = "赛车-汽车文化,第" . $page . "页-" . SITE_NAME;
                    } else {
                        $title = "赛车-汽车文化-" . SITE_NAME;
                    }
                    $keyword = "赛车,汽车文化, 车评网";
                    $description = " ams车评网,源自德国auto motor und sport,国内汽车评测开创者,为您提供最专业最准确的赛车文化.";
                } else if ($ids == 52) {
                    if ($page !== 1) {
                        $title = "风云车-汽车文化,第" . $page . "页-" . SITE_NAME;
                    } else {
                        $title = "风云车-汽车文化-" . SITE_NAME;
                    }
                    $keyword = "风云车,汽车文化,车评网";
                    $description = "ams车评网,源自德国auto motor und sport,国内汽车评测开创者,为您提供最专业最准确的风云车文化.";
                }
                $where = "ca.category_id=cac.id and ca.category_id='{$ids}' and ca.state=3";
                $lists = $this->article->getArticle($where, $page_size, $page_start, array("ca.uptime" => "DESC"));
                if ($lists){
                    foreach ($lists as $key => $value) {
                        $lists[$key]['pic'] = $this->article->getArticlePic($value['pic'], '280x186');
                    }
                }
                $extra.="article.php?action=CarReview&id=$id&ids=" . $ids;
            }

            $page_bar = multipage::multis($this->article->total, $page_size, $page, $_ENV['PHP_SELF'] . $extra, 0, 6);
        }

        $css = array("index", "style");
        $js = array("koala.min.1.5", 'global');
        $this->vars('css', $css);
        $this->vars('js', $js);

        $wheres = "ca.category_id=cac.id and cac.parentid='{$id}' and ca.state=3";
        $list = $this->article->getArticle($wheres, 7, 0 * 7, array("ca.uptime" => "DESC"));
        if($list && is_array($list)){
            foreach ($list as $key => $val) {
                if (empty($val['hot_pic'])) {
                    unset($list[$key]);
                }
            }
        }
        $where = "parentid=" . $id . " and state=1";
        $ac = $this->article_category->getCount($where);
        if ($ac && is_array($ac))
            foreach ($ac as $key => $val) {
                $where = "cac.id=ca.category_id and cac.id='{$val['id']}'";
                $aca = $this->article_category->getCounts($where);
                $tota = $this->article_category->total;
                $ac[$key]['count'] = $tota;
            }

        $page_bar = replaceNewsURL($page_bar);

        $this->vars('page_bar', $page_bar);
        $this->vars('lists', $lists);
        $this->vars('ids', $ids);
        $this->vars('id', $id);
        $this->vars('ac', $ac);
        $this->vars('actitle', $actitle[0][category_name]);
        $this->vars('list', $list);
        $this->vars("title", $title);
        $this->vars("keyword", $keyword);
        $this->vars("description", $description);
        $this->vars('linklist',$linklist);
        $this->template($template_name, '', 'replaceArticleUrl');
    }

    /**
     * 标签文章/视频列表页面
     */
    function doActiveList() {
        $template_name = "article_list";
        $css = array("index", "style");
        $js = array("jquery-1.8.3.min", 'global');
        $this->vars('css', $css);
        $this->vars('js', $js);
        $page_size = 21;
        $page = intval($_GET['page']);
        $id = intval($_GET['id']);
        $ids = intval($_GET['ids']);
        $tag_name = $this->tag->getname($id);
        $where = "cae.id=pcae.parentid and pcae.id=ca.category_id and cae.state=1 and pcae.state=1 and ca.state=3 and cat.article_id=ca.id and cat.tag_id='{$id}'";
        $ac = $this->article_category->getParentCategoryName($where);
        foreach ($ac as $key => $val) {
            $total+=$val[count];
        }
        if (empty($ids)) {
            $page = max(1, $page);
            $page_start = ($page - 1) * $page_size;
            $where = "cae.id=pcae.parentid and cae.state=1 and pcae.state=1 and pcae.id=ca.category_id and ca.state=3 and cat.article_id=ca.id and cat.tag_id='{$id}'";
            $list = $this->article_category->getArticle($where, $page_size, $page_start, array("ca.uptime" => "DESC"));
            if ($list){
                foreach ($list as $key => $value) {
                    $list[$key]['pic'] = $this->article->getArticlePic($value['pic'], '280x186');
                }
            }else{
                $this->doPublic();
            }
            $extra.="article.php?action=ActiveList&id=" . $id;
        } else {
            $page = max(1, $page);
            $page_start = ($page - 1) * $page_size;
            $where = "cae.id=pcae.parentid and pcae.parentid=" . $ids . " and cae.state=1 and pcae.state=1 and pcae.id=ca.category_id and ca.state=3 and cat.article_id=ca.id and cat.tag_id='{$id}'";
            $list = $this->article_category->getArticle($where, $page_size, $page_start, array("ca.uptime" => "DESC"));
            if ($list){
                foreach ($list as $key => $value) {
                    $list[$key]['pic'] = $this->article->getArticlePic($value['pic'], '280x186');
                }
            }else{
                $this->doPublic();
            }
            $extra.="article.php?action=ActiveList&ids=" . $ids . "&id=" . $id;
        }
        $page_bar = multipage::multi($this->article_category->total, $page_size, $page, $_ENV['PHP_SELF'] . $extra, 0, 4);
        $this->vars('page_bar', $page_bar);
        $this->vars('list', $list);
        $linklist = $this->friend->getAllFriendLink("category_id='5' order by seq asc","*",2);
        $title = "{$tag_name[tag_name]}评测, {$tag_name[tag_name]}视频, {$tag_name[tag_name]}怎么样-" . SITE_NAME;
        $keyword = "{$tag_name[tag_name]}评测, {$tag_name[tag_name]}视频, {$tag_name[tag_name]}怎么样";
        $description = "车评网为您提供{$tag_name[tag_name]}评测，{$tag_name[tag_name]}视频, {$tag_name[tag_name]}怎么样等相关内容，让您在第一时间了解{$tag_name[tag_name]}的全部信息。";
        #$page_bar = replaceNewsURL($page_bar);
        $this->vars('id', $id);
        $this->vars('ids', $ids);
        $this->vars('ac', $ac);
        $this->vars('total', $total);
        $this->vars('tag_name', $tag_name[tag_name]);
        $this->vars('type_id', $tag_name[type_id]);
        $this->vars("title", $title);
        $this->vars("keyword", $keyword);
        $this->vars("description", $description);
        $this->vars('linklist',$linklist);
        $this->template($template_name, '', 'replaceNewsChannel');
    }

    /**
     * 显示wap文章页链接的二维码图片
     * @global type $local_host
     */
    function doqrcode() {
        global $local_host;
        import('phpqrcode', 'vendor/qrcode');
        $id = intval($_GET['id']);
        #$uptime = $this->article->getlist("*", "id=$id", 1);
        #$url = date("Ym/d", $uptime['uptime']) . '/' . $id . '.html';
        //清除缓冲输出
        ob_clean();
        $url = $local_host . "waparticle.php?id=$id";
        $url = replaceWapNewsUrl($url);
        QRcode::png($url);
    }

    function doZuiZhong() {
        $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
        $path = $this->article->getRewriteUrlByAid($id);
        $this->alert('', 'js', 3, $path);
        #header("location:/$path");
    }

    function doPublic() {
        @header("http/1.1 404 not found");
        @header("status: 404 not found");
        //exit();
    }

}
