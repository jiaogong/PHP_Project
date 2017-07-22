<?php

/**
 * 广州车展action
 * $Id: $
 */
class guangzhouAction extends action {

    public $article;
    public $tag;
    public $pagedate;
    public $friend;

    function __construct() {
        parent::__construct();
        $this->article = new article();
        $this->tag = new tag();
        $this->pagedate = new pageData();
        $this->friend = new friend();
    }

    function doDefault() {
        $this->doCarShowGuangzhou();
    }

    /**
     * 广州国际车展页面
     */
    function doCarShowGuangzhou() {
        $template = 'guangzhou';
        $uid = session("uid");
        $str_banner = $this->pagedate->getSomePagedata("value", "name='theme_guangzhou_banner'", 3);
        $str_headline = $this->pagedate->getSomePagedata("value", "name='theme_guangzhou_headline'", 3);
        $listTopBanner = unserialize($str_banner);
        $listHeadline = unserialize($str_headline);

        $chezhanvideo_list = $this->article->getArticleByTagname('广州车展2015视频', $limit = 1, $offset = 0, array("uptime" => 'desc'));
        if ($chezhanvideo_list){
            $chezhanvideo_total_num = count($chezhanvideo_list);
            foreach ( $chezhanvideo_list as $key => $value) {
                 $chezhanvideo_list[$key]['pic'] = $this->article->getArticlePic($value['pic'], '280x186');
                 $chezhanvideo_list[$key]['url'] = $this->article->getRewriteUrlByAid($value['id']);
            } 
        }

        $pagetopic = $_GET['page'] ? intval($_GET['page']) : 1;
        $pagetopic = max(1, $pagetopic);
        $page_size_topic = 6;
        $where_topic = '广州车展2015热门话题';
        $page_start_topic = ($pagetopic - 1) * $page_size_topic;
        $remenhuati_list = $this->article->getArticleByTagname($where_topic, $page_size_topic, $page_start_topic, array("uptime" => 'desc'));
        $remenhuati_total = $this->article->total;
        $remenhuati_total = intval($remenhuati_total);
        $remenhuati_page_bar = multipage::guangzho_umulti($remenhuati_total, $page_size_topic, $pagetopic, $_ENV['PHP_SELF'] . 'guangzhou.php?action-carshowguangzhou');
        if ($remenhuati_list) {
            foreach ($remenhuati_list as $key => $value) {
                $remenhuati_list[$key]['pic'] = $this->article->getArticlePic($value['pic'], '280x186');
                $remenhuati_list[$key]['url'] = $this->article->getRewriteUrlByAid($value['id']);
            }
        }

        $where_hotcar = '广州车展2015热门新车';
        $remenxinche_list = $this->article->getArticleByTagname($where_hotcar, 1, $page_start_hotcar, array("uptime" => 'desc'), 2);
        $page_size_hotcar = 6;
        $remenxinche_total = $this->article->total;
        $remenxinche_total = intval($remenxinche_total);
        if ($remenxinche_list){
            foreach ($remenxinche_list as $key => $value) {
                $remenxinche_list[$key]['pic'] = $this->article->getArticlePic($value['pic'], '160x120');
                $remenxinche_list[$key]['url'] = $this->article->getRewriteUrlByAid($value['id']);
            }
        }
        
        $remenxinche_num = ceil($remenxinche_total / $page_size_hotcar) > 0 ? ceil($remenxinche_total / $page_size_hotcar) : 1;
        for ($i = 1; $i <= intval($remenxinche_num); $i++) {
            $page_start_hotcar = ($i - 1) * $page_size_hotcar;
            $remenxinche_page_num[] = array_slice($remenxinche_list, $page_start_hotcar, $page_size_hotcar);
        }
        if ($chezhanvideo_list) {
            foreach ($chezhanvideo_list as $k => $v) {
                $video_tags = explode(',', $v['tagname_list']);
                $keys = array_search('广州车展2015视频', $video_tags);
                if ($keys) {
                    unset($video_tags[$keys]);
                }
                $video_tags_arrs = in_array('广州车展2015热门话题', $video_tags);
                $tags_count_num = count($video_tags);
                if (!$video_tags_arrs) {
                    if ($tags_count_num < 2) {
                        $k_video = array_fill($tags_count_num, 2 - $tags_count_num, 'no');
                        $k_video = $video_tags + $k_video;
                    } else {
                        $k_video = $video_tags;
                    }
                }
                $video_tags_list[] = $k_video;
                $video_tags_num[] = array_rand($k_video, 2);
            }
        }
        if ($remenhuati_list) {
            foreach ($remenhuati_list as $k => $v) {
                $remenhuati_tags = explode(',', $v['tagname_list']);
                $keys = array_search('广州车展2015热门话题', $remenhuati_tags);
                if ($keys) {
                    unset($remenhuati_tags[$keys]);
                }
                $hottopic_tags_arrs = in_array('广州车展2015热门话题', $remenhuati_tags);
                $tags_count_num = count($hottopic_tags_arrs);
                if (!$hottopic_tags_arrs) {
                    if ($tags_count_num < 3) {
                        $k_hottopic = array_fill($tags_count_num, 3 - $tags_count_num, 'no');
                        $k_hottopic = $remenhuati_tags + $k_hottopic;
                    }
                } else {
                    $k_hottopic = array('no', 'no', 'no');
                }
                $remenhuati_tags_list[] = $k_hottopic;
                $remenhuati_tags_num[] = array_rand($k_hottopic, 3);
            }
        }

        $seo_url_page = "/chezhan/guangzhou2015-";
        $page_preg = "/guangzhou.php\?action\-carshowguangzhou\&page=/";
        if(preg_match_all($page_preg,$remenhuati_page_bar,$match)) {
            foreach($match as $k=>$v){
                $remenhuati_page_bar = preg_replace($page_preg, $seo_url_page, $remenhuati_page_bar); 
            }
        }
        $seo_url_page_one = "guangzhou2015";
        $page_preg_one = "/guangzhou2015\-1/";
        if(preg_match_all($page_preg_one,$remenhuati_page_bar,$match)) {
            foreach($match as $k=>$v){
                $remenhuati_page_bar = preg_replace($page_preg_one, $seo_url_page_one, $remenhuati_page_bar); 
            }
        }

        $this->vars("uid", $uid);
        $this->vars("listTopBanner", $listTopBanner);
        $this->vars("listHeadline", $listHeadline);
        $this->vars("chezhanvideo", $chezhanvideo_list);
        $this->vars('chezhanvideo_num', $chezhanvideo_total_num);
        $this->vars("video_tags_list", $video_tags_list);
        $this->vars("video_tags_num", $video_tags_num);
        $this->vars("remenhuati", $remenhuati_list);
        $this->vars("remenhuati_tags_list", $remenhuati_tags_list);
        $this->vars("remenhuati_tags_num", $remenhuati_tags_num);
        $this->vars("remenhuati_page_bar", $remenhuati_page_bar);
        $this->vars("remenxinche_page_num", $remenxinche_page_num);

        $this->template($template, '', 'replaceNewsChannel');
    }

    function dotagAjax() {
        $tagname = $this->filter($_POST['tagname'], HTTP_FILTER_STRING);
        if ($tagname) {
            $where = "tag_name ='" . $tagname . "'";
            $fields = "id";
            $tag_id = $this->tag->getTagFields($fields, $where, 3);
            if ($tag_id) {
                echo $tag_id;
            } else {
                echo -1;
            }
        }
    }

}
