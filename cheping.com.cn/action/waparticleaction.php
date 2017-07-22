<?php

/**
 * wap文章页action
 * $Id: waparticleaction.php 3102 2016-06-13 05:45:18Z wangqin $
 */
class waparticleAction extends action {

    public $article;
    public $category;
    public $pagedata;
    public $categorys;
    public $articlepic;
    public $collect;

    function __construct() {
        parent::__construct();
        $this->article = new article();
        $this->category = new article_category();
        $this->pagedata = new pagedata();
        $this->categorys = new category();
        $this->articlepic = new articlepic();
        $this->collect = new collect();
        $this->userinfo = new users_profiles();
//        $this->collect = new collect();
    }

    function doDefault() {
        $this->doFinal();
    }

    function doFinal() {
        global $local_host;
//        $this->uid = 198;
        $uid = session('uid');//这里是用户uid
        $tpl_name = "wap_article";
        $username = session('username');
        $avator = $this->userinfo->getUsers($uid);
        $this->vars('name', $username); //分配名字
        $this->vars("avatar", $avator['avatar']);
        $css = array('wapindex','reset',"wenzhangzuizhongt");
        $js = array("jquery-1.8.3.min");
        $this->vars('css', $css);
        $this->vars('js', $js);
        
        $url = session('__forward-article__');
        $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
        $where = "uid=" . $uid . " and article_id=" . $id;
        $collect = $this->collect->getCollect($where);
        $article = $this->article->getlist("*", "id='{$id}' and state=3", 1); //查询文章存在的情况下
        if ($article) {
            $category = $this->category->getlsit("parentid,category_name", "id='{$article['category_id']}' and state=1", 1);
            $article['category_name'] = $category['category_name'];
            $article['parentid'] = $category['parentid'];

            $article['content'] = str_replace(array('allview', 'class="Img"', 'class="jiao"', 'alt="" '), array('allcc', 'class="Img allcc"', '', ''), $article['content']);
            $article['content'] = preg_replace('/<o:p><\/o:p>/sim', '', $article['content']);
            $article['content'] = preg_replace('/<p>\s+(&nbsp;|<br \/>)\s+<\/p>/sim', '', $article['content']);
            $article['content'] = preg_replace('/<([a-z]+)\s+class="MsoNormal"[^>]*>/sim', '<\1>', $article['content']);
            $article['content'] = preg_replace('%<p>\s*&[^<]+<img([^>]+)>\s+</p>%sim', '<p style="text-align:center;"><img\1></p>', $article['content']);
            $article['content'] = preg_replace('%<p>\s+<img([^>]+)>\s+</p>%sim', '<p style="text-align:center;"><img\1></p>', $article['content']);
            $article['content'] = preg_replace('%<p>\s*<span[^>]*>\s*<img([^>]+)>.+?</span>%sim', '<p style="text-align:center;"><img\1>', $article['content']);
            $article['content'] = preg_replace('%<img src="' . $local_host . '([^"]+)" /> %sim', '<img class="allcc" src="' . $local_host . '\1" /> ', $article['content']);
            $article['content'] = replaceImageUrl($article['content']);
            #处理文章中出现的视频，适配wap页面显示效果
            @preg_match_all('%<embed src="http://player\.youku\.com/player\.php/sid/([^/]+)/v\.swf" type="application/x-shockwave-flash" width="820" height="540" autostart="false" loop="true" />%im', $article['content'], $video);
            if (count($video)) {
                foreach ($video[0] as $k => $v) {
                    $article['content'] = str_replace(
                            $v, "<div id='youkuplayer{$k}' class='objectVideo' style='width:100%;height:220px;'><script>player = new YKU.Player('youkuplayer{$k}', {client_id: '01166f752ffdfaa1',vid: '{$video[1][$k]}==',show_related: false});</script></div>", $article['content']
                    );
                }
            }
            $a = explode(',', $article['series_list']);
            $tui = $this->article->getlists("id,title,title2,uptime,category_id", "FIND_IN_SET('$a[0]', series_list) and state=3 and type_id=1 limit 3", 2);

            foreach ($tui as $k => $v) {
                if ($v['id'] == $aid) {
                    unset($tui[$k]);
                }

                $category = $this->category->getlsit("parentid,category_name", "id='{$v['category_id']}' and state=1", 1);
                $tui[$k]['category_name'] = $category['category_name'];
                $tui[$k]['parentid'] = $category['parentid'];
            }
        } else {
//            $this->doPublic();
        }
        $title = $article['title'] . "-ams车评网";
        $keywords = $article['title'];
        $description = $article['title'] . dstring::substring($article['chief'], 0, 20) . '...';
        $this->vars("article", $article); //查询的文章的结果分配到页面
        $this->vars("state", $collect["state"]);
        $this->vars("tui", $tui);
        $this->vars("url", $url);
        $this->vars("title", $title);
        $this->vars("keywords", $keywords);
        $this->vars("description", $description);
        $this->template($tpl_name, '', 'replaceWapNewsUrl');
    }
    function doWaparticlepic() {
        $tpl_name = "wap_articlepic";
        $uid = session('uid');//这里是用户uid
        $username = session('username');
        $avator = $this->userinfo->getUsers($uid);
        $this->vars('name', $username); //分配名字
        $this->vars("avatar", $avator['avatar']);
        $css = array("main",'wapindex','reset','people');
        $js = array("jquery.min", 'hammer.min', 'hammer.jquery.min', 'itemslide.min', 'sliding');
        $this->vars('css', $css);
        $this->vars('js', $js);

        $type_id = filter_input(INPUT_GET, 'type_id', FILTER_SANITIZE_NUMBER_INT);

        $where = "cf.type_id=ca.pic_org_id and cf.type_id='{$type_id}'";
        $list = $this->articlepic->getCount($where, array("ppos" => "asc"));

        $total = $this->articlepic->total;
        if ($total)
            foreach ($total as $key => $val) {
                $this->vars('total', $val);
            }
        $title = "【" . $list[0][title] . "_高清图片】-" . SITE_NAME;
        $list[0]['p_category_id'] = $this->article->getlists("id", "pic_org_id='$type_id'", 1);
        $this->vars('list', $list);
        $this->vars("title", $title);
        $this->template($tpl_name);
    }

}
