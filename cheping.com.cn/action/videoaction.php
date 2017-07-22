<?php

/**
 * 车评视频页面action
 * $Id: videoaction.php 2805 2016-06-01 03:07:38Z david $
 */
class videoAction extends action {

    public $user;
    public $review;
    public $badword;
    public $article;
    public $tag;
    public $article_category;
    public $collect;
    public $friend;

    function __construct() {
        parent::__construct();
        $this->user = new users();
        $this->review = new reviews();
        $this->badword = new badword();
        $this->article = new article();
        $this->article_category = new article_category();
        $this->tag = new tag();
        $this->series = new series();
        $this->collect = new collect();
        $this->pagedate = new pageData();
        $this->friend = new friend();
    }

    function doDefault() {
        $this->doVideo();
    }

    /**
     * 视频频道列表页面
     */
    function doVideo() {
        $tpl_name = "video_lists";
        $css = array("index", 'style');
        $js = array('koala.min.1.5', 'global');
        $this->vars('css', $css);
        $this->vars('js', $js);
        
        $id = intval($_GET['id']);
        $ids = intval($_GET['ids']);
        $page = intval($_GET['page']);
        $page = max(1, $page);
        $page_size = 24;
        $page_start = ($page - 1) * $page_size;
        $linklist = $this->friend->getAllFriendLink("category_id='9' order by seq asc","*",2);
        $wheres = "ca.category_id=cac.id and cac.parentid='{$id}' and ca.state=3 and type_id=2";
        $listc = $this->article->getArticle($wheres, 7, 0, array("ca.uptime" => "DESC"));
        if ($listc)
            foreach ($listc as $key => $val) {
                if (empty($val['hot_pic'])) {
                    unset($listc[$key]);
                }
            }

        $where = "parentid='{$id}' and state=1";
        $ac = $this->article_category->getCount($where);
        if ($ac)
            foreach ($ac as $key => $val) {
                $where = "cac.id=ca.category_id and cac.id='{$val['id']}'";
                $aca = $this->article_category->getCounts($where);
                $tota = $this->article_category->total;
                $ac[$key]['count'] = $tota;
            }
        if (!isset($ids) || empty($ids)) {
            $where = "id='{$id}' and state=1";
            $actitle = $this->article_category->getCount($where);//按条件查询频道
            //默认title
            $title = "汽车评测视频,品牌新车试驾视频,试车视频,汽车视频大全-" .SITE_NAME;
            $keyword = "汽车评测视频,品牌新车试驾视频,试车视频,汽车视频大全";
            $description = "ams车评网拥有最专业的汽车评测视频制作团队,为您提供最专业的汽车评测视频,试车视频,汽车试驾测试视频,新车静态展示以及品牌官方视频等精彩汽车视频大全，看汽车视频就到ams车评网.";
            $where = "ca.category_id=cac.id and cac.parentid='" . $id . "' and ca.state=3";
            $lists = $this->article->getArticle($where, 30, 0, array("ca.uptime" => "DESC"));
            if ($lists)
                foreach ($lists as $key => $value) {
                    $lists[$key]['pic'] = $this->article->getArticlePic($value['pic'], '280x186');
                }
            $page_bar = multipage::multi($this->article->total, $page_size, $page, $_ENV['PHP_SELF'] . $extra, 0, 4);
        } else {
            // 汤汤三人行
            if ($_GET['ids'] == 66) {
                if ($page !== 1) {
                    $title = "汤汤三人行_汽车评测视频,第" . $page . "页-" .SITE_NAME;
                } else {
                    $title = "汤汤三人行_汽车评测视频-" . SITE_NAME;
                }
                $keyword = "汤汤三人行,汽车评测视频";
                $description = "ams车评网为您提供由汤汤，汤启隆，夏东及王威主持的“汤汤三人行”的汽车评测视频类节目。更多精彩汽车评测视频尽在ams车评网。";
            } else if ($ids == 67) {
               //德国原创汽车
                if ($page !== 1) {
                    $title = "德国原创汽车视频-汽车视频,第" . $page . "页-" . SITE_NAME;
                } else {
                    $title = "德国原创汽车视频-汽车视频-".SITE_NAME;
                }
                $keyword = "德国原创汽车视频, ams车评网";
                $description = "ams车评网德国原创汽车视频栏目为您提供最全德国原创汽车视频,让您更容易了解到品牌车型的真实情况.";
            } else if ($ids == 34) {
                if ($page !== 1) {
                    $title = "新车静态展示视频-汽车视频,第" . $page . "页-" . SITE_NAME;
                } else {
                    $title = "新车静态展示视频-汽车视频-" . SITE_NAME;
                }
                $keyword = "新车静态展示视频, 车评网";
                $description = "车评网拥有最专业的汽车评测视频制作团队,为您提供最专业的新车静态展示视频,让您更容易了解到品牌车型的真实情况及信息.看新车静态展示视频就到车评网.";
            } else if ($ids == 33) {
                //这是夏冬评车
                if ($page !== 1) {
                    $title = "夏东评车_汽车评测视频,第" . $page . "页-" . SITE_NAME;
                } else {
                    $title = "夏东评车_汽车评测视频-" . SITE_NAME;
                }
                $keyword = "夏东评车,汽车评测视频";
                $description = "ams车评网为您提供由夏东主持的“夏东评车”、“从夏看底盘”等精彩的汽车评测视频类节目。夏东老师会针对每一款汽车从外由内详细讲解，让您对每一款车都能了如指掌,更多精彩汽车评测视频尽在ams车评网。";
            } else if ($ids == 57) {
                //糖糖有话说
                if ($page !== 1) {
                    $title = "汤汤有话说_汽车评测视频,第" . $page . "页-" . SITE_NAME;
                } else {
                    $title = "汤汤有话说_汽车评测视频-". SITE_NAME;
                }
                $keyword = "汤汤有话说,汽车评测视频";
                $description = "ams车评网为您提供由汤汤，汤启隆主持的“汤汤有话说”的汽车评测视频类节目，主要内容为汽车技术类解析视频。更多精彩汽车评测视频尽在ams车评网。.";
            } else if ($ids == 61) {
                //这里是威sir测试场
                if ($page !== 1) {
                    $title = "威sir测试场_汽车评测视频,第" . $page . "页-" . SITE_NAME;
                } else {
                    $title = "威sir测试场_汽车评测视频-" . SITE_NAME;
                }
                $keyword = "威sir测试场,汽车评测视频";
                $description = "ams车评网为您提供由王威主持的“威sir测试场”的汽车评测视频类节目，内容包括18米绕桩,紧急变线,操控圈等精彩视频，更多精彩汽车评测视频尽在ams车评网。";
            } else if ($ids == 62) {
                //这里是从夏看底盘     
                if ($page !== 1) {
                    $title = "从夏看底盘_汽车评测视频,第" . $page . "页-" . SITE_NAME;
                } else {
                    $title = "从夏看底盘_汽车评测视频-" . SITE_NAME;
                }
                $keyword = "从夏看底盘,汽车评测视频";
                $description = "ams车评网为您提供由夏东主持的“从夏看底盘”、“夏东评车”等精彩的汽车评测视频类节目。更多更详细的汽车底盘解析及讲解视频尽在ams车评网。";
            } else if ($ids == 70) {
                if ($page !== 1) {
                    $title = "编辑评车_汽车电动车摩托车等评测视频,第" . $page . "页-" . SITE_NAME;
                } else {
                    $title = "编辑评车_汽车电动车摩托车等评测视频-".SITE_NAME;
                }
                $keyword = "编辑评车, 汽车电动车摩托车等评测视频";
                $description = "ams车评网的专业编辑为您提供有关汽车、电动车及摩托车等各类车的评测视频，了解更多关于汽车、电动车及摩托车的评测视频尽在ams车评网。";
            } else if ($ids == 71) {
                if ($page !== 1) {
                    $title = "Sport auto超跑和运动_汽车评测视频,第" . $page . "页-" . SITE_NAME;
                } else {
                    $title = "Sport auto超跑和运动_汽车评测视频-".SITE_NAME;
                }
                $keyword = "Sport auto超跑和运动,汽车评测视频";
                $description = "作为ams车评网旗下子品牌将为读者带来国内外最新的赛事报道、车手动态、超跑测试、资讯及精彩视频。 Sport auto于1969年成立于德国, 是德国权威的汽车媒体。Sport auto超跑和运动于2014年正式在中国上线，致力于推广赛车运动和赛车文化。";
            }

            $where = "ca.category_id=cac.id and ca.category_id='{$ids}' and ca.state=3";
            $list = $this->article->getArticle($where, $page_size, $page_start, array("ca.uptime" => "DESC"));
            if ($list)
                foreach ($list as $key => $value) {
                    $list[$key]['pic'] = $this->article->getArticlePic($value['pic'], '280x186');
                }
            $extra.="video.php?action=Video&id=$id&ids=" . $ids;
            $page_bar = multipage::multi($this->article->total, $page_size, $page, $_ENV['PHP_SELF'] . $extra, 0, 4);
        }
        $this->vars('listc', $listc);
        $this->vars('ids', $ids);
        $this->vars('page_bar', $page_bar);
        $this->vars('lists', $lists);
        $this->vars('list', $list);
        $this->vars('id', $id);
        $this->vars('ac', $ac);
        $this->vars('actitle', $actitle[0][category_name]);
        $this->vars("title", $title);
        $this->vars("keyword", $keyword);
        $this->vars("description", $description);
        $this->vars('linklist',$linklist);
        $this->template($tpl_name, '', 'replaceVideoUrl');
    }

    /**
     * 视频频道首页列表数据，js获取更多功能
     */
    function doAjaxContent() {
        $page = intval($_POST['k']);
        $page_size = 18;
        $page_start = ($page - 1) * $page_size + 12;
        $this->article->order = array("uptime" => "desc");
        $this->article->offset = $page_start;
        $this->article->limit = $page_size;
        $list = $this->article->getlist("id,title,tag_list,series_list,category_id,type_id,uptime,title2,pic", "type_id=2 and state=3", 2);

        foreach ($list as $key => $value) {
            //默认车系
            if (strpos($value[series_list], ',')) {
                $series_id = strstr($value[series_list], ',', true);
            } else {
                $series_id = $value[series_list];
            }
            $series_name = $this->series->getSeriesdata("series_name", "series_id='{$series_id}'", 2);
            $list[$key]['series_name'] = $series_name;
            $list[$key]['series_id'] = $series_id;
            //标签
            $taglist = $this->tag->getTagFields("id,tag_name", "state=1 and id in($value[tag_list])", 2);
            $list[$key]['taglist'] = $taglist;
            $categoryarr = $this->article_category->getParentCategory("pca.category_name p_category_name,ca.*", "ca.id='{$value['category_id']}' and pca.id=ca.parentid", 1);
            $list[$key]['category_name'] = $categoryarr['category_name'];
            $list[$key]['cacid'] = $categoryarr['id'];
            $list[$key]['p_category_name'] = $categoryarr['p_category_name'];
            $list[$key]['p_category_id'] = $categoryarr['parentid'];
            $list[$key]['pic'] = $this->article->getArticlePic($value['pic'], '280x186');
        }

        $html = '';
        if ($list) {
            foreach ($list as $key => $value) {
                $html .= '<h5><div class="left_list1"><span><a href="video.php?action=ZuiZhong&id=' . $value[p_category_id] . '&ids=' . $value[id] . '" target="_blank"><img src="/attach/' . $value[pic] . '" onerror="this.src=\'../images/236x132.jpg\'" style="width:279px;height:187px;" class="lazyimgs"  alt="' . $value[title] . '" /></a></span><span class="span-img"><a href="video.php?action=ZuiZhong&id=' . $value[p_category_id] . '&ids=' . $value[id] . '" target="_blank"><img src="images/player.png"  /></a></span><a target="_blank" href="video.php?action=Video&id=9&ids='.$value['cacid'].'"><span class="span-zixin">' . $value[category_name] . '</span></a><span class="spother" style=" font-size:16px;line-height:22px;   height: 48px; margin-top:8px;overflow: hidden; "><a href="video.php?action=ZuiZhong&id=' . $value[p_category_id] . '&ids=' . $value[id] . '" target="_blank">' . $value[title] . '</a></span><p class="pred" style=" font-size:14px;"><span>';
                foreach ($value['taglist'] as $k => $v) {
                    if ($k < 3) {
                        $html .= '<a href="/article.php?action=ActiveList&id=' . $v[id] . '">' . $v[tag_name] . '</a>';
                    }
                }
                $html .= '</span></p><span class="span-time fr" style="font-size:14px;">' . date('Y.m.d', $value[uptime]) . '</span></div></h5>';
            }
        }
        
        echo replaceVideoUrl($html);
    }

    /**
     * 视频最终页面
     * 目前没有静态化，待完善……
     */
    function doZuiZhong() {
        $template_name = "video_final";
        $css = array('wenzhangzuizhong');
        $js = array('global');
        $this->vars('css', $css);
        $this->vars('js', $js);

        $id = intval($_GET['id']);
        $where = "id='" . $id . "' and state=1";
        $category = $this->article_category->getCount($where);

        $ids = intval($_GET['ids']);
        $where = "parentid='" . $id . "' and state=1";
        $ac = $this->article_category->getCount($where);
        if ($ac)
            foreach ($ac as $key => $val) {
                $where = "cac.id=ca.category_id and cac.id='{$val['id']}'";
                $aca = $this->article_category->getCounts($where);
                $tota = $this->article_category->total;
                $ac[$key]['count'] = $tota;
            }

        $where = "ca.category_id=cac.id and cac.parentid='{$id}' and ca.state=3 and ca.id='{$ids}' and type_id=2";
        $list = $this->article->getArticle($where, $page_size, $page_start, array("ca.uptime" => "DESC"));
        if($list === false){
            $this->doPublic();
        }
        $title = $list[0][title] . "-" . SITE_NAME;
        $keyword = $list[0][title];
        $description = "车评网为您提供" . $list[0][title] . "，更多精彩汽车视频请上车评网。";
        $uid = session("uid");
        $this->vars("uid", $uid);
        $this->vars('ac', $ac);
        $this->vars('id', $id);
        $this->vars('category', $category[0]);
        $this->vars('list', $list);
        $this->vars('lists', $list[0]);
        $this->vars("title", $title);
        $this->vars("keyword", $keyword);
        $this->vars("description", $description);
        $this->template($template_name, '', 'replaceVideoUrl');
    }

    function doPublic() {
        @header("http/1.1 404 not found");
        @header("status: 404 not found");
        //exit();
    }

}
