<?php

/**
 * wap视频页 video
 * $Id: wapvideoaction.php 983 2015-11-23 10:56:45Z cuiyuanxin $
 */
class wapvideoAction extends action {

    public $article;
    public $category;
    public $pagedata;
    public $categorys;
    public $articlepic;

    function __construct() {
        parent::__construct();
        $this->article = new article();
        $this->category = new article_category();
        $this->pagedata = new pagedata();
        $this->categorys = new category();
        $this->articlepic = new articlepic();
    }

    function doDefault() {
        $this->doFinal();
    }

    function doFinal() {
        global $local_host;
        $tpl_name = "wap_video_final";

        $css = array("wapindex", "reset");
        $js = array("jquery-1.8.3.min");
        $this->vars('css', $css);
        $this->vars('js', $js);
        
        $url = session('__forward-article__');
        $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
        $article = $this->article->getlist("*", "id='{$id}' and state=3", 1);
        if ($article) {
            $category = $this->category->getlsit("parentid,category_name", "id='{$article['category_id']}' and state=1", 1);
            $article['category_name'] = $category['category_name'];
            $article['parentid'] = $category['parentid'];

//            foreach ($article as $key => $value) {
            $findme = 'player.youku.com';
            $pos = strpos($article['source'], $findme);

            // 注意这里使用的是 ===。简单的 == 不能像我们期待的那样工作，
            if ($pos === false) {
                //http://yuntv.letv.com/bcloud.html?uu=35hygmrzpc&vu=00fbb433fc&auto_play=1&gpcflag=1&width=800&height=576
                $uu = substr($article['source'], 37, -57);
                $vu = substr($article['source'], 51, -43);
                $type = 1;
                $this->vars("type", $type);
                $this->vars("uu", $uu);
                $this->vars("vu", $vu);
            } else {
                $article['source'] = "http://player.youku.com/embed/" . substr($article['source'], 39, -6);
            }

        } else {
            $this->doPublic();
        }
        $value = $this->pagedata->getSomePagedata("value", "name='video'", 3);
        $video = unserialize($value);
        if ($video)
            foreach ($video as $key => $value) {
                $video[$key]['pic'] = $this->article->getArticlePic($value['pic'], '280x186');
            }
        $title = $article['title'] . "-ams车评网";
        $keywords = $article['title'];
        $description = "ams车评网为您提供".$article['title']."，更多精彩汽车视频请上ams车评网。";
        $this->vars("article", $article);
        $this->vars("video", $video);
        $this->vars("url", $url);
        $this->vars("title", $title);
        $this->vars("keywords", $keywords);
        $this->vars("description", $description);
        $this->template($tpl_name, '', 'replaceWapNewsUrl');
    }

    function doPublic() {
        @header("http/1.1 404 not found");
        @header("status: 404 not found");
        exit();
    }

}
