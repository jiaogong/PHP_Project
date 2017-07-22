<?php

/**
 * search action
 * $Id: searchaction.php 2630 2016-05-11 03:30:07Z wangchangjiang $
 */
class searchAction extends action {

    var $article;
    var $articletype;
    var $category;
    var $article_category;

    function __construct() {
        global $adminauth, $login_uid;
        global $_cache, $_cache2;
        parent::__construct();
        $this->search = new search();
        $this->article = new article();
        $this->article_category = new article_category();
        $this->category = new category();
        $this->series = new Series();
        $this->brand = new brand();
        $this->cardbprice = new cardbPrice();
        $this->pricelog = new cardbPriceLog();
        $this->websaleinfo = new websaleinfo();
        $this->oldcarval = new oldCarVal();
        $this->cache = $_cache2 ? $_cache2 : $_cache;
    }

    function doDefault() {
        $this->doList();
    }

    function doList() {
        $template_name = "search_list";
        $css = array("index", 'search');
        $js = array( "global");
        $this->vars('css', $css);
        $this->vars('js', $js);

        //接收值
        $keywords = preg_replace("/\/|\~|\!|\@|\#|\\$|\%|\^|\&|\*|\(|\)|\_|\+|\{|\}|\:|\<|\>|\?|\[|\]|\,|\.|\/|\;|\'|\`|\-|\=|\\\|\|\"|/", '', preg_replace('/(https?|ftp):\/\/[-A-Z0-9+&@#\/%?=~_|$!:,.;]*[A-Z0-9+&@#\/%=~_|$]/im', '', preg_replace('/<(.*?)>/is', "", strip_tags($_GET['keywords']))));

        if (!empty($keywords)) {
            //推荐标签
            $list = @$this->search->getliek($keywords);
            if (!empty($list)) {
                $pv = array();
                foreach ($list as $k) {
                    $pv[] = $k['count'];
                }
                array_multisort($pv, SORT_DESC, $list);
                $list = array_chunk($list, 2);
            }

            //文章内容
            $page = $_GET['page'];
            $page = max(1, $page);
            $page_size = 10;
            $page_start = ($page - 1) * $page_size;
            $sort = "uptime desc";
            $listc = @$this->search->getSphinx($keywords, $sort, $page_size, $page_start);
            if (!empty($listc)) {
                $pv = array();
                $uptime = array();
                foreach ($listc as $k) {
                    $pv[] = $k['count'];
                    $uptime[] = $k['uptime'];
                }
                array_multisort($pv, SORT_DESC, $uptime, SORT_DESC, $listc);
            }
            foreach ($listc as $key => $value) {
                $listc[$key]['pic'] = $this->article->getArticlePic($value['pic'], '280x186');
                $listc[$key]['p_category_id'] = $this->category->getParentId($value['category_id']);
                $listc[$key]['url'] = $this->article->getRewriteUrl($listc[$key]);
            }
            $extra.="search.php?action=list&id=" . $_GET['id'] . "&keywords=$keywords";
            $page_bar = multipage::multi(@$this->search->total[0][count], $page_size, $page, $_ENV['PHP_SELF'] . $extra, 0, 4);
        } else {
            $listc = "";
        }

        $title = "{$keywords}-" . SITE_NAME;
        $keyword = "{$keywords},ams车评网";
        $description = "ams车评网为您提供{$keywords}的内容，还为您提供最专业最准确的品牌汽车评测,新车试驾,精彩汽车视频以及最新汽车新闻资讯的汽车网站。。";

        $this->vars('listc', $listc);
        $this->vars('page_bar', $page_bar);
        $this->vars('ac', $ac);
        $this->vars('total', $totals);
        $this->vars('keywords', $keywords);
        $this->vars('list', $list[0]);
        $this->vars('lists', $lists);
        $this->vars("title", $title);
        $this->vars("keyword", $keyword);
        $this->vars("description", $description);
        $this->vars("sousuo_nav", 1);
        $this->template($template_name, '', 'replaceNewsChannel');
    }

    function doGetList() {
        $keywords = $_POST['keywords'];

        $list = @$this->search->getlisk($keywords);
        $lists = @$this->search->getlisks($keywords);
        if ($list and $lists) {
            $rs = array();
            foreach (array_merge_recursive($list, $lists) as $k => $v) {
                $temp = array_unique($v);

                foreach ($temp as $k => $v) {
                    $rs[]['name'] = $v;   //再将拆开的数组重新组装
                }
            }
            $array = array_chunk($rs, 10);
            if (count($array[0]) < 1) {
                exit;
            } else if (count($array[0]) == 1) {
                echo "[{'keywords':'" . $array[0][0]['name'] . "'}]";
            } else {
                $i = 0;
                $result = "[";
                //var_dump($result);
                while ($row = $array[0][$i++]) {
                    $result.="{'keywords':'" . $row['name'] . "'},";
                }
                $result.=']';
                echo rtrim(trim($result), ',');
            }
        } else if ($list && !$lists) {
            $rs = array();
            foreach ($list as $k => $v) {
                $temp = array_unique($v);
                foreach ($temp as $k => $v) {
                    $rs[]['tag_name'] = $v;   //再将拆开的数组重新组装
                }
            }
            $array = array_chunk($rs, 10);
            if (count($array[0]) < 1) {
                exit;
            } else if (count($array[0]) == 1) {
                echo "[{'keywords':'" . $array[0][0]['tag_name'] . "'}]";
            } else {
                $i = 0;
                $result = "[";
                //var_dump($result);
                while ($row = $array[0][$i++]) {
                    $result.="{'keywords':'" . $row['tag_name'] . "'},";
                }
                $result.=']';
                echo rtrim(trim($result), ',');
            }
        } else if (!$list && $lists) {
            $rs = array();
            foreach ($lists as $k => $v) {
                $temp = array_unique($v);
                foreach ($temp as $k => $v) {
                    $rs[]['series_name'] = $v;   //再将拆开的数组重新组装
                }
            }
            $array = array_chunk($rs, 10);
            if (count($array[0]) < 1) {
                exit;
            } else if (count($array[0]) == 1) {
                echo "[{'keywords':'" . $array[0][0]['series_name'] . "'}]";
            } else {
                $i = 0;
                $result = "[";
                //var_dump($result);
                while ($row = $array[0][$i++]) {
                    $result.="{'keywords':'" . $row['series_name'] . "'},";
                }
                $result.=']';
                echo rtrim(trim($result), ',');
            }
        }
    }

    function doIndex() {
        global $attach_server;
        $page = max(intval($_GET['page']), 1);
        $css = array('jquery.autocomplete', 'base2', 'soucars', 'comm', 'common');
        $js = array( 'global', 'search');
        $this->vars('css', $css);
        $this->vars('js', $js);
        $this->vars('allow_mobile', 1);
        if ($page == 1) {
            $page_title = "【选车_选车工具】汽车品牌车型选择大全-ams车评网";
        } else {
            $page_title = "【选车_选车工具】汽车品牌车型选择大全,第" . $page . "页-ams车评网";
        }
        $description = "选车工具：ams车评网选车频道为您提供最全最精确的选车服务,让您能够快速精确的查找适合自己的车型,最全汽车车型信息尽在ams车评网.";
        $keywords = "选车,选车工具";
        $tplName = 'search_result';
        $t_cache = false;

        $this->setTplName($tplName, true, $this->search->cache_time['search_result'], 'g', 'findcar');
        $url_querystring = $search_title = "";
        $start_str = "<a href='?";
        $zhong_str = "'>";
        $end_str = "</a>";
        $url_querystring = @preg_replace('/(&?page=\d*)/si', '', $_SERVER['QUERY_STRING']);
        $this->tpl->assign('url_querystring', ltrim($url_querystring, '&'));
        #处理搜索参数 {
        #全部,停产
        $sale = $_GET['sale'] ? $_GET['sale'] : 0;
        $pageTitleArr = array();
        
        #价格
        if (isset($_GET['pr'])) {
            $query_string = $_SERVER['QUERY_STRING'];
            @preg_match_all('%pr=(\d+)%is', $query_string, $match);
            $pr = $match[1];

            foreach ($pr as $k => $v) {
                $price_low = $this->search->pr[$v]['low'];
                $price_high = $this->search->pr[$v]['high'];

                if ($price_high == 0) {
                    $price = "{$price_low}万以上";
                } elseif (!$price_low && $price_high) {
                    $price = "{$price_high}万以下";
                } else {
                    $price = "{$price_low}-{$price_high}万";
                }
                $search_title .= $start_str . qasStrip($url_querystring, 'pr=' . $v) . $zhong_str . $price . $end_str;
            }
            if ($page_title_c) {
                $page_title_c .= $price;
            } else {
                $page_title_c .= $price;
            }
            $description_c = "ams车评网选车频道为您提供最全面的选车条件,包括按汽车级别、汽车价格、汽车厂商、国别、变速方式、汽车排量等方式选择适合您的喜欢的汽车品牌。";
            $keywords_c = "选车,选车工具,ams车评网";
        }
        
        #品牌
        if ($_GET['br']) {
            @preg_match_all('%br=(\d+)%is', $_SERVER['QUERY_STRING'], $match);
            $br = $match[1];
            $selected_brand = "";
            $brand = $this->search->getBrand(0);
            $selectstar = "<a href='javascript:;'>";
            $selectend = "</a>";
            foreach ($br as $k => $v) {
                if ($brand[$v]['brand_name']) {
                    $titleBrand[] = $brand[$v]['brand_name'];
                    $search_title .= $start_str . qasStrip($url_querystring, 'br=' . $brand[$v]['brand_id']) . $zhong_str . $brand[$v]['brand_name'] . $end_str;
                    $selected_brand.=$selectstar . $brand[$v]['brand_name'] . $selectend;
                }
            }
            @$pageTitleArr[] = implode(' ', $titleBrand);
            @$brandStr = implode('-', $titleBrand);
            if ($page_title_c) {
                $page_title_c .= "_" . $titleBrand[0];
                $description_c = "ams车评网选车频道为您提供最全面的选车条件,包括按汽车级别、汽车价格、汽车厂商、国别、变速方式、汽车排量等方式选择适合您的喜欢的汽车品牌。";
                $keywords_c = "选车,选车工具,ams车评网";
            } else {
                if ($page == 1) {
                    $page_title = "【" . $titleBrand[0] . "】" . $titleBrand[0] . "汽车报价_参数_介绍-ams车评网";
                } else {
                    $page_title = "【" . $titleBrand[0] . "】" . $titleBrand[0] . "汽车报价_参数_介绍,第" . $page . "页-ams车评网";
                }

                $description = "ams车评网车型频道为您提供" . $titleBrand[0] . "汽车介绍,全部车款的报价及参数配置,最全汽车车型信息尽在ams车评网.";
                $keywords =  $titleBrand[0];
            }
        }

        $this->tpl->assign('selected_brand', $selected_brand);
        //判断手动输入价格
        if ($_GET["cdp"]) {
            $cdp = $_GET["cdp"];
            $cdparr = explode(",", $cdp);
            $search_title .= $start_str . qasStrip($url_querystring, 'cdp=' . $cdp) . $zhong_str . $cdparr[0] . "-" . $cdparr[1] . "万" . $end_str;
            $this->tpl->assign('cdparr', $cdparr);
            $this->tpl->assign('cdp', $cdp);
            //        $pr=array();
        }

        #车身结构
        if ($_GET['cs']) {
            @preg_match_all('%cs=(\d+)%is', $_SERVER['QUERY_STRING'], $match);
            $cs = $match[1];

            foreach ($cs as $k => $v) {
                $csv = $this->search->cs[$v];
                $search_title .= $start_str . qasStrip($url_querystring, 'cs=' . $v) . $zhong_str . $csv . $end_str;
            }
            if ($page_title_c) {
                $page_title_c .= "_" . $csv;
                $description_c = "ams车评网选车频道为您提供最全面的选车条件,包括按汽车级别、汽车价格、汽车厂商、国别、变速方式、汽车排量等方式选择适合您的喜欢的汽车品牌。";
                $keywords_c = "选车,选车工具,ams车评网";
            } else {
                if ($page == 1) {
                    $page_title = "【" . $csv . "】大全_" . $csv . "报价_" . $csv . "品牌-ams车评网";
                } else {
                    $page_title = "【" . $csv . "】大全_" . $csv . "报价_" . $csv . "品牌,第" . $page . "页-ams车评网";
                }

                $description = "ams车评网" . $csv . "频道,为您提供最新" . $csv . "大全,包括" . $csv . "品牌、" . $csv . "汽车图片,可按各种筛选条件找到您中意的" . $csv . "车,最新" . $csv . "信息尽在ams车评网";
                $keywords = "$csv," . $csv . "报价," . $csv . "品牌";
            }
        }

        #驱动方式
        if ($_GET['dr']) {
            @preg_match_all('%dr=(\d+)%is', $_SERVER['QUERY_STRING'], $match);
            $dr = $match[1];

            foreach ($dr as $k => $v) {
                $drv = $this->search->dr[$v];
                $search_title .= $start_str . qasStrip($url_querystring, 'dr=' . $v) . $zhong_str . $drv . $end_str;
            }
        }

        #排量
        if (isset($_GET['pl'])) {
            @preg_match_all('%pl=(\d+)%is', $_SERVER['QUERY_STRING'], $match);
            $pl = $match[1];

            foreach ($pl as $k => $v) {
                $pl_low = $this->search->pl[$v]['low'];
                $pl_high = $this->search->pl[$v]['high'];

                if ($pl_high == 0) {
                    $pl_str = $pl_low . " L以上";
                } elseif (!$pl_low && $pl_high) {
                    $pl_str = $pl_high . " L以下";
                } else {
                    $pl_str = "{$pl_low}-{$pl_high} L";
                }
                $search_title .= $start_str . qasStrip($url_querystring, 'pl=' . $v) . $zhong_str . $pl_str . $end_str;
            }
            if ($page_title_c) {
                $page_title_c .= "_" . $pl_str;
            } else {
                $page_title_c .= $pl_str;
            }
            $description_c = "ams车评网选车频道为您提供最全面的选车条件,包括按汽车级别、汽车价格、汽车厂商、国别、变速方式、汽车排量等方式选择适合您的喜欢的汽车品牌。";
            $keywords_c = "选车,选车工具,ams车评网";
        }

        #厂商性质
        if ($_GET['fi']) {
            @preg_match_all('%fi=(\d+)%is', $_SERVER['QUERY_STRING'], $match);
            $fi = $match[1];

            foreach ($fi as $k => $v) {
                $factoryImport = $this->search->fi[$v];
                $search_title .= $start_str . qasStrip($url_querystring, 'fi=' . $v) . $zhong_str . $factoryImport . $end_str;
            }
            if ($page_title_c) {
                $page_title_c .= "_" . $factoryImport;
            } else {
                $page_title_c .= $factoryImport;
            }
            $description_c = "ams车评网选车频道为您提供最全面的选车条件,包括按汽车级别、汽车价格、汽车厂商、国别、变速方式、汽车排量等方式选择适合您的喜欢的汽车品牌。";
            $keywords_c = "选车,选车工具,ams车评网";
        }

        #国别
        if (isset($_GET['bi'])) {
            @preg_match_all('%bi=(\d+)%is', $_SERVER['QUERY_STRING'], $match);
            $bi = $match[1];

            foreach ($bi as $k => $v) {
                $guobie = $this->search->bi[$v];
                $search_title .= $start_str . qasStrip($url_querystring, 'bi=' . $v) . $zhong_str . $guobie . $end_str;
            }
            if ($page_title_c) {
                $page_title_c .= "_" . $guobie;
            } else {
                $page_title_c .= $guobie;
            }
            $description_c = "ams车评网选车频道为您提供最全面的选车条件,包括按汽车级别、汽车价格、汽车厂商、国别、变速方式、汽车排量等方式选择适合您的喜欢的汽车品牌。";
            $keywords_c = "选车,选车工具,ams车评网";
        }


        #类型
        if ($_GET['ct']) {
            @preg_match_all('%ct=(\d+)%is', $_SERVER['QUERY_STRING'], $match);
            $ct = $match[1];

            foreach ($ct as $k => $v) {
                $ctype = $this->search->ct[$v];
                $search_title .= $start_str . qasStrip($url_querystring, 'ct=' . $v) . $zhong_str . $ctype . $end_str;
            }

            if ($page_title_c) {
                $page_title_c .= "_" . $ctype;
                $description_c = "ams车评网选车频道为您提供最全面的选车条件,包括按汽车级别、汽车价格、汽车厂商、国别、变速方式、汽车排量等方式选择适合您的喜欢的汽车品牌。";
                $keywords_c = "选车,选车工具,ams车评网";
            } else {
                if ($page == 1) {
                    $page_title = "【" . $ctype . "】大全_" . $ctype . "报价_" . $ctype . "品牌-ams车评网";
                } else {
                    $page_title = "【" . $ctype . "】大全_" . $ctype . "报价_" . $ctype . "品牌,第" . $page . "页-ams车评网";
                }

                $description = "ams车评网" . $ctype . "频道,为您提供最新" . $ctype . "大全,包括" . $ctype . "品牌、" . $ctype . "汽车图片,可按各种筛选条件找到您中意的" . $ctype . "车,最新" . $ctype . "信息尽在ams车评网";
                $keywords = "$ctype," . $ctype . "报价," . $ctype . "品牌";
            }
        }

        #发动机
        if ($_GET['qg']) {
            @preg_match_all('%qg=(\d+)%is', $_SERVER['QUERY_STRING'], $match);
            $qg = $match[1];

            foreach ($qg as $k => $v) {
                $qgv = $this->search->qg[$v];
                $search_title .= $start_str . qasStrip($url_querystring, 'qg=' . $v) . $zhong_str . $qgv . "缸" . $end_str;
            }
        }

        #进气方式
        if ($_GET['jq']) {
            @preg_match_all('%jq=(\d+)%is', $_SERVER['QUERY_STRING'], $match);
            $jq = $match[1];
            foreach ($jq as $k => $v) {
                $jqv = $this->search->jq[$v];
                $search_title .= $start_str . qasStrip($url_querystring, 'jq=' . $v) . $zhong_str . $jqv . $end_str;
            }
        }

        #发动机布置位置
        if ($_GET['dt']) {
            @preg_match_all('%dt=(\d+)%is', $_SERVER['QUERY_STRING'], $match);
            $dt = $match[1];

            foreach ($dt as $k => $v) {
                $dtv = $this->search->dt[$v];
                $search_title .= $start_str . qasStrip($url_querystring, 'dt=' . $v) . $zhong_str . $jqv . $end_str;
            }
        }


        #变速箱
        if ($_GET['bsx']) {
            @preg_match_all('%bsx=(\d+)%is', $_SERVER['QUERY_STRING'], $match);
            $bsx = $match[1];

            foreach ($bsx as $k => $v) {
                $bsxv = $this->search->bsx[$v];
                $search_title .= $start_str . qasStrip($url_querystring, 'bsx=' . $v) . $zhong_str . $bsxv[1] . $end_str;
            }
            if ($page_title_c) {
                $page_title_c .= "_" . $bsxv;
            } else {
                $page_title_c .= $bsxv;
            }
            $description_c = "ams车评网选车频道为您提供最全面的选车条件,包括按汽车级别、汽车价格、汽车厂商、国别、变速方式、汽车排量等方式选择适合您的喜欢的汽车品牌。";
            $keywords_c = "选车,选车工具,ams车评网";
        }

        #燃料类型
        if ($_GET['ot']) {
            @preg_match_all('%ot=(\d+)%is', $_SERVER['QUERY_STRING'], $match);
            $ot = $match[1];

            foreach ($ot as $k => $v) {
                $otv = $this->search->ot[$v];
                $search_title .= $start_str . qasStrip($url_querystring, 'ot=' . $v) . $zhong_str . $otv . $end_str;
            }
        }
        #座位数
        if ($_GET['zw']) {
            @preg_match_all('%zw=(\d+)%is', $_SERVER['QUERY_STRING'], $match);
            $zw = $match[1];

            foreach ($zw as $k => $v) {
                $zwv = $this->search->zw[$v];
                $search_title .= $start_str . qasStrip($url_querystring, 'zw=' . $v) . $zhong_str . $zwv . "座" . $end_str;
            }
        }

        #承载方式
        if ($_GET['st']) {
            @preg_match_all('%st=(\d+)%is', $_SERVER['QUERY_STRING'], $match);
            $st = $match[1];

            foreach ($st as $k => $v) {
                $stv = $this->search->st[$v];
                $search_title .= $start_str . qasStrip($url_querystring, 'st=' . $v) . $zhong_str . $stv . $end_str;
            }
        }
        #模糊搜索车系
        if ($_GET['sk']) {
            @preg_match('%sk=([^&]+)%is', $_SERVER['QUERY_STRING'], $match);
            $sk = urldecode($match[1]);
            $search_title .= $start_str . qasStrip($url_querystring, 'sk=' . $sk) . $zhong_str . $sk . $end_str;
        }
        //手动输入价格
        $inner_price_str = @preg_replace("/&$/si", "", preg_replace("/(pr=\d+&?)/si", "", $url_querystring));
        $this->tpl->assign('inner_price_str', $inner_price_str);

        #search arguments
        $search_param = array(
            'br' => $br, /* 品牌 */
            'pr' => $pr, /* 价格 */
            'bi' => $bi, /* 国别 */
            'pl' => $pl, /* 排量 */
            'ct' => $ct, /* 级别 */
            'fi' => $fi, /* 厂商类型 */
            'qg' => $qg, /* 缸数 */
            'jq' => $jq, /* 进气形式 */
            'dt' => $dt, /* 发动机位置 */
            'dr' => $dr, /* 驱动形式 */
            'bsx' => $bsx, /* 变速箱 */
            'ot' => $ot, /* 燃料类型 */
            'cs' => $cs, /* 车身形式 */
            'zw' => $zw, /* 座位数 */
            'st' => $st, /* 承载方式 */
            'sp' => $sp, /* 配置 */
            'sale' => $sale, /* 0全部,1停产,2在售 */
            'cdp' => $cdp, /* 手动输入价格区间 */
            'sk' => $sk, /* 模糊搜索车系 */
            'default_sid' => 0
        );
        $pregFlag = preg_match_all('%<a href=\'[^\']+\'>([^<]+)</a>%sim', $search_title, $titleMatches);

        //配置
        foreach ($this->search->sp as $k => $v) {
            if ($_GET[$k] == 1) {
                $var = $k;
                $$var = 1;
                $search_param[$var] = 1;
                $search_title .= $start_str . qasStrip($url_querystring, $var . '=1') . $zhong_str . $v . $end_str;
            }
        }
        #排序方式 asc/desc
        $sort = $_GET['sort'] == 'desc' ? 'desc' : 'asc';
        $sortby = in_array($_GET['sortby'], array('pr', 'dv')) ? $_GET['sortby'] : 'dr';
        if ($_GET['sort']) {
            $this->tpl->assign('sort', $sort);
        }
        $this->tpl->assign('sortby', $sortby);

        #如果有查询
        $tmp = $result = array();
        $st_result = $this->search->getIndexSearchResult($search_param);
        if (empty($st_result['result'])) {
            $search_param = array();
            $search_param['default_sid'] = 1;
            $st_result = $this->search->getIndexSearchResult($search_param);
        }
        //所有车款价格、折扣、优惠幅度
        $modelPrice = $this->search->getSearchModelPrice();
        $this->tpl->assign('modelPrice', $modelPrice);
        //搜索到的车系的价格、折扣、优惠幅度

        $seriesPrice = $this->search->getSearchSeriesPrice($st_result['series_mid'], $modelPrice);
        $result = $this->search->sortSearchResult($st_result['result'], $seriesPrice, $sortby, $sort);

        unset($st_result);
        unset($modelPrice);
        $search_count = $this->search->getSearchCount($search_param);
        $match_options = $this->search->searchOption($search_param);

        $this->tpl->assign('sale', $sale);
        $this->tpl->assign('search_param', $search_param);

        $this->tpl->assign('model_count', $search_count['model_count']);
        $this->tpl->assign('series_count', $search_count['series_count']);
        $this->tpl->assign('match_options', $match_options);
        $this->tpl->assign('pzimg', $this->search->pzImg);
        $this->tpl->assign('pz', $this->search->pz);
        $this->tpl->assign('seriesPrice', $seriesPrice);
        #brand select
        $brand_select = $this->search->getBrand();

        $this->tpl->assign('brand_select', $brand_select);

        $brand = $this->search->getBrand(0);
//        var_dump($brand);

        $this->tpl->assign('brand', $brand);

        #price select
        $price_select = $this->search->pr;
        $this->tpl->assign('price_select', $price_select);

        #bi select
        $guobie_select = $this->search->bi;

        $this->tpl->assign('guobie_select', $guobie_select);

        $this->tpl->assign('searchPz', $this->search->sp);

        #cardb type select
        $this->tpl->assign('type_select', $this->search->ct);

        #st4 select
        $this->tpl->assign('cs_select', $this->search->cs);

        #bsx select

        $this->tpl->assign('bsx_select', $this->search->bsx);

        #dr select
        $this->tpl->assign('dr_select', $this->search->dr);

        #dt select
        $this->tpl->assign('dt_select', $this->search->dt);

        #ot_select
        $this->tpl->assign('ot_select', $this->search->ot);

        #汽缸 select
        $this->tpl->assign('qg_select', $this->search->qg);

        #进气形式
        $this->tpl->assign('jq_select', $this->search->jq);

        #排量 select
        $this->tpl->assign('pl_select', $this->search->pl);

        #座位数
//        var_dump($this->search->zw);
        $this->tpl->assign('zw_select', $this->search->zw);
        $this->tpl->assign('st_select', $this->search->st);
        $this->tpl->assign('fi_select', $this->search->fi);

        #series_pic
        $series_pic = $this->search->getSeriesPic();
        $this->tpl->assign('series_pic', $series_pic);
        #series_Info
        $series_info = $this->search->getSeriesInfo();

        $this->tpl->assign('series_info', $series_info);
        #brandlogo
        $brand_logo = $this->search->getBrandLogo();
        $this->tpl->assign('brand_logo', $brand_logo);

        $this->tpl->assign('sea_letter', $sea_letter);
        #分页
        $page_size = 10;

        $page_total = count($result);
        $page_start = ($page - 1) * $page_size;
        $result = array_slice($result, $page_start, $page_size);

        $page_bar = multipage::multis($page_total, $page_size, $page, "/search.php?{$url_querystring}", 0, 6); //  /search/search.html?

        $this->tpl->assign('page_bar', $page_bar);
        $this->tpl->assign('result', $result);
        $this->tpl->assign('search_title', $search_title);
        if ($keywords_c) {
            if ($page == 1) {
                $page_title_c = "【选车工具|汽车车型大全:" . $page_title_c . "】-ams车评网";
            } else {
                $page_title_c = "【选车工具|汽车车型大全:" . $page_title_c . "】,第" . $page . "页-ams车评网";
            }
            $this->tpl->assign('title', $page_title_c);
            $this->tpl->assign('keyword', $keywords_c);
            $this->tpl->assign('description', $description_c);
        } else {
            $this->tpl->assign('title', $page_title);
            $this->tpl->assign('keyword', $keywords);
            $this->tpl->assign('description', $description);
        }

        $this->tpl->assign('cacheKey', "search_" . md5(serialize($search_param)));
        $lujing = array(
//            'url' => '/search.php?action=index',
            'title' => '搜车',
            'b' => 'search'
        );
        $this->vars('lujing', $lujing);
        $this->vars('pageindex', 'search');
        $this->vars('attach_server', empty($attach_server) ? '' : $attach_server[0]);
        $this->vars('search', 1);
        $this->vars('garage', 'garage');
        $this->template($tplName, '', 'replaceNewsChannel');
    }

    function doAjaxSeriesZk() {
        @header("content-type:text/html; charset=utf-8");
        $cacheKey = $_GET['ck'];
        $seriesId = $_GET['sid'];
        if ($cacheKey && $seriesId) {
            $result = $this->search->getSeriesContent($cacheKey, $seriesId);
            echo $result;
        }
    }

    //展开车款信息
    function doAjaxModelZk() {
        $modelId = $_GET['model_id'];
        $type = $_GET['type'];
        $logId = $this->cardbprice->getPrice('pricelog_id', "model_id = $modelId AND pricelog_id_from = $type AND price_type = 6", 3);
        if ($logId) {
            if ($type == 3)
                $zkModel = $this->websaleinfo->getSearchPriceInfo($modelId, $logId, $type);
            else
                $zkModel = $this->pricelog->getBingoPriceInfo($modelId, $logId, $type);
            echo json_encode($zkModel);
        }
    }

    //快速对比
    function doAjaxQuickCompare() {
        $timestamp = time();
        $model_id = $_GET['model_id'];
        $modelInfo = $this->cardbprice->getQuickCompareModel($model_id, 0);
        if (empty($modelInfo))
            $modelInfo = $this->cardbprice->getQuickCompareModel($model_id, 5);
        if (empty($modelInfo))
            $modelInfo = $this->cardbprice->getModelInfo($model_id);
        $modelInfo['oldcar_company_prize'] = $this->oldcarval->getOldCarList("car_prize", "model_id='$model_id'  and start_date<$timestamp and end_date>$timestamp", 3);
        echo json_encode($modelInfo);
    }

    function doCheckName() {

        $s_name = $_POST['keyword'];
        //  echo $_GET['keyword'];
//        $s_name = $_GET['keyword'];
//        $code = mb_detect_encoding($s_name, 'UTF-8');
//        $s_name = $code == 'UTF-8' ? mb_convert_encoding($s_name, 'gbk', 'UTF-8') : $s_name;        
//        $s_name = $_POST['keyword'];

        $br = $this->brand->getSearchBrandName($s_name);
        if ($br) {
            $url = "/search/search.html?br=" . $br;
            echo $url;
        } else {
            $s_id = $this->series->getSearchSeriesName($s_name);
            if ($s_id) {
                $url = "modelinfo.php?series_id=" . $s_id;
                echo $url;
            } else {
                $id_arr = $this->series->getSeriesList("series_id", "state=3 and keyword like '%$s_name%'", 2);
                if ($id_arr) {
                    if (count($s_id) == 1) {
                        $url = "modelinfo.php?series_id=" . $id_arr[0]['series_id'];
                        echo $url;
                    } else {
                        $s_name = $s_name;
                        $url = "/search/search.html?sk=" . $s_name;
                        echo $url;
                    }
                } else {
                    $s_name = $s_name;
                    $url = "/search/search.html?sk=" . $s_name;
                    echo $url;
                }
            }
        }
    }

}
