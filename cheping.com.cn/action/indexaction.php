<?php

/**
 * 车评首页action
 * $Id: indexaction.php 2649 2016-05-12 06:18:34Z wangchangjiang $
 * @author David Shaw <tudibao@163.com>
 */
class indexAction extends action {

    public $user;
    public $review;
    public $badword;
    public $article;
    public $tag;
    public $series;
    public $category;
    public $friend;
    public $brand;
    public $pageData;
    public $model;
    var $newtype = array(
        "1" => "微型",
        "2" => "小型车",
        "3" => "紧凑型",
        "4" => "中型车",
        "5" => "中大型",
        "6" => "豪华车",
        "7" => "SUV",
        "8" => "MPV",
        "9" => "跑车"
    );

    function __construct() {
        parent::__construct();
        $this->user = new users();
        $this->review = new reviews();
        $this->badword = new badword();
        $this->article = new article();
        $this->tag = new tag();
        $this->series = new series();
        $this->category = new article_category();
        $this->pageData = new pageData();
        $this->friend = new friend();
        $this->brand = new brand();
        $this->model = new models();
    }

    function doDefault() {
        $this->doIndex();
    }

    function doIndex() {
        $opt = $this->createshow(true);
        if ($opt['o'] === 'make') {
            $this->makeIndex();
        } else {
            echo $this->ParseIndex();
        }
    }

    function makeIndex() {
        $filename = SITE_ROOT . "cp_index.html";
        $this->makePage(0, "index", $filename);
    }

    function ParseIndex() {
        $tpl_name = "index";
        $css = array("index", 'chanpinkumokuai');
        $js = array( 'global', 'koala.min.1.5', 'index');
        $this->vars('css', $css);
        $this->vars('js', $js);
        $uid = session("uid");
        $this->vars("uid", $uid);
        $title = "车评网-品牌汽车评测视频,新车试驾,汽车评测资讯新闻-官方网站";
        $keyword = "车评网,汽车评测,新车试驾,汽车视频,汽车评测资讯";
        $description = "ams车评网, 国内汽车评测开创者,源自德国auto motor und sport ,为您提供最专业最准确的品牌汽车评测,新车试驾,精彩汽车视频图片以及最新汽车新闻资讯的汽车网站。";
        $this->vars("title", $title);
        $this->vars("keyword", $keyword);
        $this->vars("description", $description);
        $linklist = $this->friend->getAllFriendLink("category_id='`0`' order by seq asc", "*", 2);
        $rweixing = $this->pageData->getSomePagedata("value", "name='rweixing'", 3);
        $rxiaoxingche = $this->pageData->getSomePagedata("value", "name='rxiaoxingche'", 3);
        $rjincouxing = $this->pageData->getSomePagedata("value", "name='rjincouxing'", 3);
        $rzhongxingche = $this->pageData->getSomePagedata("value", "name='rzhongxingche'", 3);
        $zhongdaxing = $this->pageData->getSomePagedata("value", "name='zhongdaxing'", 3);
        $rhaohuache = $this->pageData->getSomePagedata("value", "name='rhaohuache'", 3);
        $rsuv = $this->pageData->getSomePagedata("value", "name='rsuv'", 3);
        $rmpv = $this->pageData->getSomePagedata("value", "name='rmpv'", 3);
        $rpaoche = $this->pageData->getSomePagedata("value", "name='rpaoche'", 3);
        $this->vars('rweixing', unserialize($rweixing));
        $this->vars('rxiaoxingche', unserialize($rxiaoxingche));
        $this->vars('rjincouxing', unserialize($rjincouxing));
        $this->vars('rzhongxingche', unserialize($rzhongxingche));
        $this->vars('zhongdaxing', unserialize($zhongdaxing));
        $this->vars('rhaohuache', unserialize($rhaohuache));
        $this->vars('rsuv', unserialize($rsuv));
        $this->vars('rmpv', unserialize($rmpv));
        $this->vars('rpaoche', unserialize($rpaoche));
        $this->vars('type', $this->newtype);
        $this->vars('linklist', $linklist);
        $this->vars('carall', 1);//是否显示车型大全
        $this->template($tpl_name, '', 'replaceNewsChannel');
    }
}
