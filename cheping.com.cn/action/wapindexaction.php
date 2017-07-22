<?php

session_start();

/**
 * wap首页action
 * $Id: wapindexaction.php 3099 2016-06-13 05:24:22Z wangqin $
 */
class wapindexAction extends action {

    public $article;
    public $category;
    public $pagedata;
    public $categorys;
    public $articlepic;
    public $userinfo;

    function __construct() {
        parent::__construct();
        $this->article = new article();
        $this->category = new article_category();
        $this->pagedata = new pagedata();
        $this->categorys = new category();
        $this->articlepic = new articlepic();
        $this->userinfo = new users_profiles();
        $category = $this->category->getCount("parentid=0 and state=1");
        $array = array();
        $array[0] = array(
            'id' => $category[2]['id'],
            'category_name' => $category[2]['category_name']
        );
        $array[1] = array(
            'id' => $category[1]['id'],
            'category_name' => $category[1]['category_name']
        );
        $array[2] = array(
            'id' => $category[0]['id'],
            'category_name' => $category[0]['category_name']
        );
        $array[3] = array(
            'id' => $category[3]['id'],
            'category_name' => $category[3]['category_name']
        );
        $this->vars("category", $array);
        $agent = $_SERVER['HTTP_USER_AGENT'];
        if (preg_match('/iphone\s*os/i', $agent)) {
            if (strpos($user_agent, 'MicroMessenger') === false) {
                // 非微信浏览器
                $this->vars("iphone", 'iphone');
            } else {
                // 微信浏览器
                $this->vars("iphone", 'iphone');
                $this->vars("weixin", 'weixin');
            }
        }
    }

    function doDefault() {
        $this->doIndex();
    }

    function doIndex() {
        $tpl_name = "wap_index";
        $title = "ams车评官网移动版-汽车评测视频资讯-专业评测网站";
        $keywords = "ams车评网,汽车评测,新车试驾,汽车视频,汽车评测资讯";
        $description = "ams车评网,国内汽车评测开创者,源自德国auto motor und sport,提供专业汽车评测,新车试驾,汽车视频图片资讯的汽车网站.";
        $css = array("wapindex","reset","people");
        $uid = session('uid');
        $username = session('username');
        $avator = $this->userinfo->getUsers($uid);
        $js = array("jquery", "touchScroll", "jquery.flexslider-min", "endlesspage");
        session('__forward-article__', $_SERVER['REQUEST_URI']);
        $this->vars('css', $css);
        $this->vars('js', $js);
        $this->vars('name', $username); //分配名字
        $this->vars("avatar", $avator['avatar']);
        $this->vars("keywords", $keywords);
        $this->vars("description", $description);
        $this->template($tpl_name, '', 'replaceWapNewsUrl');
    }

    function doChannl() {
        $type_id = $this->filter($_GET['id'], HTTP_FILTER_INT, 7);
        switch ($type_id) {
            case 7:
                $this->doZixun(7);
                break;
            case 8:
                $this->doPingce(8);
                break;
            case 9:
                $this->doVideo(9);
                break;
            case 10:
                $this->doWenhua(10);
                break;
            default :
                $this->doPublic();
        }
    }

    function doZixun($id) {
        $tpl_name = "wap_new";
        $uid = session('uid');
        $css = array("reset", 'wapindex',"people");
        $js = array("jquery", "touchScroll", "iscroll", "swiper.min", "jquery.flexslider-min", "endlesspage", 'jquery.touchSwipe.min');
        $this->vars('css', $css);
        $this->vars('js', $js);

        $where = "parentid='{$id}' and state=1";
        $category[0] = array(
            'id' => 0,
            'category_name' => '全部',
            'num' => 1
        );
        $categorys = $this->category->getCount($where);
        if ($categorys)
            foreach ($categorys as $key => $value) {
                $lis = $this->article->getcount("state=3 and category_id=" . $value['id']);
                $categorys[$key]['num'] = $lis['num'];
                $category[] = $value;
            }
        $page = $this->filter($_GET['k'], HTTP_FILTER_INT, 1);
        $page = max(1, $page);
        $page_size = 20;
        $page_start = ($page - 1) * $page_size;

        $type = $this->filter($_GET['type'], HTTP_FILTER_INT, 0);
        switch ($type) {
            case 0:
                $title = "汽车资讯,上市新车,国内外汽车行业资讯大全-ams车评网";
                $keywords = "汽车资讯,汽车新闻,汽车市场行情";
                $description = "ams车评网汽车资讯频道为您报道汽车行业资讯,中国汽车市场行情，更多精彩汽车资讯尽在ams车评网。";

                $where = "ca.category_id=cac.id and cac.parentid='{$id}' and ca.state=3";
                $fields = "ca.id,ca.title,ca.title2,ca.pic,ca.uptime";
                $lists = $this->article->getArticles($where, $fields, $page_size, $page_start, array("ca.uptime" => "DESC"), 2);

                foreach ($lists as $key => $value) {
                    $lists[$key]['pic'] = replaceImageUrl($this->article->getArticlePic($value['pic'], '344x258'));
                }
                break;
            default :
                if ($type == 54) {
                    $title = "进口新车资讯,上市的新车,新车大全-汽车资讯-ams车评网";
                    $keywords = "进口新车资讯, ,即将上市的新车";
                    $description = "ams车评网新车资讯栏目为您提供进口新车资讯,国内外即将上市的新车新闻,最近新车上市资讯。";
                } else if ($type == 55) {
                    $title = "汽车新闻,上市新车,汽车行业新闻大全-汽车资讯-ams车评网";
                    $keywords = "汽车资讯,汽车新闻资讯,中国汽车市场行情";
                    $description = "ams车评网汽车新闻栏目为您报道最新上市新车新闻，国外及中国汽车行情新闻，汽车行业最新新闻资讯等内容。";
                } else if ($type == 63) {
                    $title = "汽车行业动态-汽车资讯-ams车评网";
                    $keywords = "汽车行业,汽车资讯";
                    $description = "ams车评网汽车行业栏目为您报道汽车行业最新资讯及动 态,更多精彩汽车资讯尽在ams车评网.";
                }

                $where = "ca.category_id=cac.id and cac.id='{$type}' and ca.state=3";
                $fields = "ca.id,ca.title,ca.title2,ca.pic,ca.uptime";
                $lists = $this->article->getArticles($where, $fields, $page_size, $page_start, array("ca.uptime" => "DESC"), 2);
                if ($lists)
                    foreach ($lists as $key => $value) {
                        $lists[$key]['pic'] = replaceImageUrl($this->article->getArticlePic($value['pic'], '344x258'));
                    }
        }
        session('__forward-article__', $_SERVER['REQUEST_URI']);
        $avator = $this->userinfo->getUsers($uid);
        $this->vars("avatar", $avator['avatar']);
        $name = session('username');
        $this->vars("name", $name);
        $this->vars("type", $type);
        $this->vars("id", $id);
        $this->vars("p_category", $category);
        $this->vars("list", $lists);
        $this->vars("title", $title);
        $this->vars("keywords", $keywords);
        $this->vars("description", $description);
        $this->template($tpl_name, '', 'replaceWapNewsUrl');
    }

    function doPingce($id) {
        $tpl_name = "wap_pingce";
        $uid = session('uid');
        $name = session("username");
        $css = array("wapindex", 'reset',"people");
        $js = array("jquery", "touchScroll", "iscroll", "swiper.min", "jquery.flexslider-min", "endlesspage", 'jquery.touchSwipe.min');
        $avator = $this->userinfo->getUsers($uid);
        $this->vars('css', $css);
        $this->vars('js', $js);
        $this->vars("avatar", $avator['avatar']);
        $where = "parentid='{$id}' and state=1";
        $category[0] = array(
            'id' => 0,
            'category_name' => '全部',
            'num' => 1
        );
        $categorys = $this->category->getCount($where);
        if ($categorys)
            foreach ($categorys as $key => $value) {
                $lis = $this->article->getcount("state=3 and category_id=" . $value['id']);
                $categorys[$key]['num'] = $lis['num'];
                $category[] = $value;
            }
        $page = $this->filter($_GET['k'], HTTP_FILTER_INT, 1);
        $page = max(1, $page);
        $page_size = 20;
        $page_start = ($page - 1) * $page_size;

        $type = $this->filter($_GET['type'], HTTP_FILTER_INT, 0);
        switch ($type) {
            case 0:
                $title = "汽车评测,新车试驾点评,汽车测试大全-ams车评网";
                $keywords = "汽车评测,新车试驾,汽车点评,汽车驾驶测试";
                $description = "ams车评网有专业汽车评测团队,提供专业的汽车评测内容,包括新车试驾点评,汽车驾驶测试等内容。了解更多到ams车评网";

                $where = "ca.category_id=cac.id and cac.parentid='{$id}' and ca.state=3";
                $fields = "ca.id,ca.title,ca.title2,ca.pic,ca.uptime";
                $lists = $this->article->getArticles($where, $fields, $page_size, $page_start, array("ca.uptime" => "DESC"), 2);
                if ($lists) {
                    foreach ($lists as $key => $value) {
                        $lists[$key]['pic'] = replaceImageUrl($this->article->getArticlePic($value['pic'], '344x258'));
                    }
                }

                break;
            default :
                if ($type == 16) {
                    $title = "汽车驾驶,新车试驾,品牌汽车试驾-汽车评测-ams车评网";
                    $keywords = "汽车驾驶,新车试驾,汽车试驾评测";
                    $description = "ams车评网汽车驾驶栏目为您提供品牌汽车驾驶及新车试驾等精彩内容，让您更容易了解到品牌车型的真实情况.";
                } else if ($type == 56) {
                    $title = "汽车测试,品牌新车测试-汽车评测-ams车评网";
                    $keywords = "汽车测试, 品牌新车测试,";
                    $description = "ams车评网拥有最专业的汽车评测团队，为您提供专业汽车评测,测试等内容，让您在第一时间了解到品牌车型的情况。";
                } else if ($type == 59) {
                    $title = "汽车对比评测,对比测试,对比试驾-汽车评测-ams车评网";
                    $keywords = "汽车对比评测,汽车对比,对比测试,对比试驾";
                    $description = "ams车评网有最专业的汽车评测团队，提供专业的汽车对比评测,对比测试,对比试驾等内容，让您第一时间了解到车型的情况。";
                }

                $where = "ca.category_id=cac.id and cac.id='{$type}' and ca.state=3";
                $fields = "ca.id,ca.title,ca.title2,ca.pic,ca.uptime";
                $lists = $this->article->getArticles($where, $fields, $page_size, $page_start, array("ca.uptime" => "DESC"), 2);
                if ($lists)
                    foreach ($lists as $key => $value) {
                        $lists[$key]['pic'] = replaceImageUrl($this->article->getArticlePic($value['pic'], '344x258'));
                    }
        }
        session('__forward-article__', $_SERVER['REQUEST_URI']);
        $this->vars("name", $name);
        $this->vars("type", $type);
        $this->vars("id", $id);
        $this->vars("p_category", $category);
        $this->vars("list", $lists);
        $this->vars("title", $title);
        $this->vars("keywords", $keywords);
        $this->vars("description", $description);
        $this->template($tpl_name, '', 'replaceWapNewsUrl');
    }

    function doVideo($id) {
        $tpl_name = "wap_video";
        $title = "汽车评测视频,新车试驾及新车评测视频大全-ams车评网";
        $keywords = "汽车评测视频,新车试驾视频,试车视频,汽车视频大全";
        $description = "ams车评网有专业汽车评测团队,提供专业的汽车评测视频,汽车试驾测试视频等汽车视频,了解更多到ams车评网.";
        $uid = session('uid');
        $css = array("wapindex", 'reset',"people");
        $js = array("jquery", "touchScroll", "iscroll", "swiper.min", "jquery.flexslider-min", "endlesspage", 'jquery.touchSwipe.min');
        $avator = $this->userinfo->getUsers($uid);
        $this->vars('css', $css);
        $this->vars('js', $js);
        $this->vars("avatar", $avator['avatar']);

        $where = "parentid='{$id}' and state=1";
        $category[0] = array(
            'id' => 0,
            'category_name' => '全部',
            'num' => 1
        );
        $categorys = $this->category->getCount($where);
        if ($categorys)
            foreach ($categorys as $key => $value) {
                $lis = $this->article->getcount("state=3 and category_id=" . $value['id']);
                $categorys[$key]['num'] = $lis['num'];
                $category[] = $value;
            }
        $page = $this->filter($_GET['k'], HTTP_FILTER_INT, 1);
        $page = max(1, $page);
        $page_size = 20;
        $page_start = ($page - 1) * $page_size;

        $type = $this->filter($_GET['type'], HTTP_FILTER_INT, 0);
        switch ($type) {
            case 0:
                $title = "汽车评测视频,新车试驾及新车评测视频大全-ams车评网";
                $keywords = "汽车评测视频,新车试驾视频,试车视频,汽车视频大全";
                $description = "ams车评网有专业汽车评测团队,提供专业的汽车评测视频,汽车试驾测试视频等汽车视频,了解更多到ams车评网.";

                $where = "ca.category_id=cac.id and cac.parentid='{$id}' and ca.state=3";
                $fields = "ca.id,ca.title,ca.title2,ca.pic,ca.uptime";
                $lists = $this->article->getArticles($where, $fields, $page_size, $page_start, array("ca.uptime" => "DESC"), 2);
                if ($lists) {
                    foreach ($lists as $key => $value) {
                        $lists[$key]['pic'] = replaceImageUrl($this->article->getArticlePic($value['pic'], '344x258'));
                    }
                }

                break;
            default :
                if ($type == 33) {
                    $title = "汽车评测视频,新车测试试驾点评-汽车视频-ams车评网";
                    $keywords = "汽车评测视频,新车试驾视频,汽车测试视频";
                    $description = "ams车评网有专业的汽车评测视频制作团队,提供专业汽车评测视频,新车试驾点评,汽车测试视频.看汽车视频就到ams车评网.";
                } else if ($type == 57) {
                    $title = "德国原创汽车视频-汽车视频-ams车评网";
                    $keywords = "德国原创汽车视频, ams车评网";
                    $description = "ams车评网德国原创汽车视频栏目为您提供最全德国原创汽车视频,让您更容易了解到品牌车型的真实情况. ";
                } else if ($type == 61) {
                    $title = "汽车测试,碰撞,性能及安全测试-汽车视频-ams车评网";
                    $keywords = "汽车测试,汽车碰撞测试,汽车安全测试,汽车性能测试";
                    $description = "ams车评网拥为您提供汽车测试视频包括：汽车碰撞测试,安全测试,性能测试,18米蛇形绕桩,加速,刹车,110米紧急变线,ams操控赛道等汽车测试视频.";
                } else if ($type == 62) {
                    $title = "汽车解析,底盘,发动机,悬挂系统及刹车系统解析-汽车视频-ams车评网";
                    $keywords = "汽车解析,汽车发动机解析,底盘解析";
                    $description = "ams车评网为您提供专业的汽车解析视频,包括汽车底盘解析,发动机解析,悬挂系统及刹车系统解析视频等. ";
                }

                $where = "ca.category_id=cac.id and cac.id='{$type}' and ca.state=3";
                $fields = "ca.id,ca.title,ca.title2,ca.pic,ca.uptime";
                $lists = $this->article->getArticles($where, $fields, $page_size, $page_start, array("ca.uptime" => "DESC"), 2);
                if ($lists)
                    foreach ($lists as $key => $value) {
                        $lists[$key]['pic'] = replaceImageUrl($this->article->getArticlePic($value['pic'], '344x258'));
                    }
        }
        session('__forward-article__', $_SERVER['REQUEST_URI']);
        $name = session('username');
        $this->vars("name", $name);
        $this->vars("type", $type);
        $this->vars("id", $id);
        $this->vars("p_category", $category);
        $this->vars("list", $lists);
        $this->vars("title", $title);
        $this->vars("keywords", $keywords);
        $this->vars("description", $description);
        $this->template($tpl_name, '', 'replaceWapNewsUrl');
    }

    function doWenhua($id) {
        $tpl_name = "wap_wenhua";
        $uid = session('uid');
        $css = array("wapindex", 'reset',"people");
        $js = array("jquery", "touchScroll", "iscroll", "swiper.min", "jquery.flexslider-min", "endlesspage", 'jquery.touchSwipe.min');
        $avator = $this->userinfo->getUsers($uid);
        $this->vars("avatar", $avator['avatar']);
        $this->vars('css', $css);
        $this->vars('js', $js);

        $where = "parentid='{$id}' and state=1";
        $category[0] = array(
            'id' => 0,
            'category_name' => '全部',
            'num' => 1
        );
        $categorys = $this->category->getCount($where);
        if ($categorys)
            foreach ($categorys as $key => $value) {
                $lis = $this->article->getcount("state=3 and category_id=" . $value['id']);
                $categorys[$key]['num'] = $lis['num'];
                $category[] = $value;
            }
        $page = $this->filter($_GET['k'], HTTP_FILTER_INT, 1);
        $page = max(1, $page);
        $page_size = 20;
        $page_start = ($page - 1) * $page_size;

        $type = $this->filter($_GET['type'], HTTP_FILTER_INT, 0);
        switch ($type) {
            case 0:
                $title = "汽车品牌文化,赛车文化,最新汽车文化大全-ams车评网";
                $keywords = "汽车品牌文化,赛车文化,汽车文化";
                $description = "ams车评网汽车文化频道提供汽车文化、汽车品牌文化、赛车及风云车等汽车文化知识，了解更多到ams车评网！";

                $where = "ca.category_id=cac.id and cac.parentid='{$id}' and ca.state=3";
                $fields = "ca.id,ca.title,ca.title2,ca.pic,ca.uptime";
                $lists = $this->article->getArticles($where, $fields, $page_size, $page_start, array("ca.uptime" => "DESC"), 2);

                if ($lists) {
                    foreach ($lists as $key => $value) {
                        $lists[$key]['pic'] = replaceImageUrl($this->article->getArticlePic($value['pic'], '344x258'));
                    }
                }

                break;
            default :
                if ($type == 50) {
                    $title = "经典车-汽车文化-ams车评网";
                    $keywords = "经典车,汽车文化,新车大全";
                    $description = "ams车评网,源自德国auto motor und sport,国内汽车评测开创者,为您提供最专业最准确的经典车文化. ";
                } else if ($type == 51) {
                    $title = "赛车-汽车文化-ams车评网";
                    $keywords = "赛车,汽车文化, ams车评网";
                    $description = "ams车评网,源自德国auto motor und sport,国内汽车评测开创者,为您提供最专业最准确的赛车文化.";
                } else if ($type == 52) {
                    $title = "风云车-汽车文化-ams车评网";
                    $keywords = "风云车,汽车文化,ams车评网";
                    $description = "ams车评网,源自德国auto motor und sport,国内汽车评测开创者,为您提供最专业最准确的风云车文化.";
                } else if ($type == 65) {
                    $title = "汽车旅行-汽车文化-ams车评网";
                    $keywords = "汽车旅行-汽车文化";
                    $description = "ams车评网为您提供汽车旅行精彩内容，更多汽车旅行信息尽在ams车评网.";
                }

                $where = "ca.category_id=cac.id and cac.id='{$type}' and ca.state=3";
                $fields = "ca.id,ca.title,ca.title2,ca.pic,ca.uptime";
                $lists = $this->article->getArticles($where, $fields, $page_size, $page_start, array("ca.uptime" => "DESC"), 2);
                if ($lists)
                    foreach ($lists as $key => $value) {
                        $lists[$key]['pic'] = replaceImageUrl($this->article->getArticlePic($value['pic'], '344x258'));
                    }
        }
        session('__forward-article__', $_SERVER['REQUEST_URI']);
        $name = session('username');
        $this->vars("name", $name);
        $this->vars("type", $type);
        $this->vars("id", $id);
        $this->vars("p_category", $category);
        $this->vars("list", $lists);
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
