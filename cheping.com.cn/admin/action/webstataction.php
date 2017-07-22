<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
set_time_limit(0);

class webstatAction extends action {

    var $pagetype = array(
        "zongliang" => "车评网总流量",
        "search_result" => "选车总流量",
        "zarticle" => "文章最终页总流量",
        "zvideo" => "视频最终页总流量",
        "index" => "车评首页",
        "video" => "视频(一级频道)",
        "ttsrxvideo" => "汤汤三人行总流量(二级频道)",
        "cxkdpvideo" => "从夏看底盘总流量(二级频道)",
        "scscvideo" => "威sir测试场总流量(二级频道)",
        "ttyhsvideo" => "汤汤有话说总流量(二级频道)",
        "xdpcvideo" => "夏东评车总流量(二级频道)",
        "pcarticle" => "评测总流量(一级频道)",
        "csarticle" => "测试总流量(二级频道)",
        "dbarticle" => "对比总流量(二级频道)",
        "wharticle" => "文化总流量(一级频道)",
        "jdcarticle" => "经典车总流量(二级频道)",
        "ccarticle" => "赛车总流量(二级频道)",
        "fycarticle" => "风云车总流量(二级频道)",
        "lxarticle" => "旅行总流量(二级频道)",
        "zxarticle" => "资讯总流量(一级频道)",
        "xcarticle" => "新车总流量(二级频道)",
        "xwarticle" => "新闻总流量(二级频道)",
        "hyarticle" => "行业总流量(二级频道)",
        "pic" => "图片总流量",
        "huodong" => "活动页总流量",
    );

    function __construct() {
        parent::__construct();
        $this->counter = new counter();
        $this->counters = new counter();
        $this->users = new users();
    }

    function doDefault() {
        $this->tpl_file = "webstat_index";
        $this->page_title = "网站流量统计";

        if ($_POST["search"] || $_GET["startdate"]) {
            $s = $_POST["startdate"];
            $e = $_POST["enddate"];

            $startdate = $s ? strtotime($s) : $_GET["startdate"];
            $enddate = $e ? strtotime($e) : $_GET["enddate"];
            $rstartdate = $startdate > $enddate ? $enddate : $startdate;
            $renddate = $startdate > $enddate ? $startdate : $enddate;
            $extra = "webdetail&pagetype=$type&startdate=$rstartdate&enddate=$renddate";
        } else {
            //取出默认前一天的pv/ip流量统计
            $rstartdate = strtotime(date("Y-m-d", strtotime("-1 day")));
            $renddate = strtotime(date("Y-m-d", time()));
        }

        $array = array();
        //总量
        $array['zongliang'] = $this->counter->getWebstatcount("SUM(pv) pv,SUM(uv) uv,SUM(ip) ip", "cname='zongliang' and c1 = 1 and c2 = 0 and c3 = 0 and timeline BETWEEN '{$rstartdate}' AND '{$renddate}'", 1);
        //选车总量
        $array['search_result'] = $this->counter->getWebstatcount("SUM(pv) pv,SUM(uv) uv,SUM(ip) ip", "cname='search_result' and c1 = 1 and c2 = 0 and c3 = 0 and timeline BETWEEN '{$rstartdate}' AND '{$renddate}'", 1);
        //文章总量
        $array['zarticle'] = $this->counter->getWebstatcount("SUM(pv) pv,SUM(uv) uv,SUM(ip) ip", "cname='article' and c1 >0 and c2 > 0 and c3 > 0 and timeline BETWEEN '{$rstartdate}' AND '{$renddate}'", 1);
        //视频总量
        $array['zvideo'] = $this->counter->getWebstatcount("SUM(pv) pv,SUM(uv) uv,SUM(ip) ip", "cname='video' and c1 >0 and c2 > 0 and c3 > 0 and timeline BETWEEN '{$rstartdate}' AND '{$renddate}'", 1);
        //首页总量
        $array['index'] = $this->counter->getWebstatcount("SUM(pv) pv,SUM(uv) uv,SUM(ip) ip", "cname='index' and c1 = 1 and c2 = 0 and c3 = 0 and timeline BETWEEN '{$rstartdate}' AND '{$renddate}'", 1);
        //视频一级
        $array['video'] = $this->counter->getWebstatcount("SUM(pv) pv,SUM(uv) uv,SUM(ip) ip", "cname='video' and c1 = 9 and c2 = 0 and c3 = 0 and timeline BETWEEN '{$rstartdate}' AND '{$renddate}'", 1);
        $array['huodong'] = $this->counter->getWebstatcount("SUM(pv) pv,SUM(uv) uv,SUM(ip) ip", "cname='huodong' and c1 = 1 and c2 = 0 and c3 = 0 and timeline BETWEEN '{$rstartdate}' AND '{$renddate}'", 1);
        //视频er级
        $ervideo = $this->counter->getWebstatcount("*", "cname='video' and c1 = 9 and c2 > 0 and c3 = 0 and timeline BETWEEN '{$rstartdate}' AND '{$renddate}' order by c2 desc", 2);
        if ($ervideo)
            foreach ($ervideo as $key => $value) {
                switch ($value['c2']) {
                    case 66:
                        $array['ttsrxvideo']['pv'] += $value['pv'];
                        $array['ttsrxvideo']['uv'] += $value['uv'];
                        $array['ttsrxvideo']['ip'] += $value['ip'];
                        break;
                    case 62:
                        $array['cxkdpvideo']['pv'] += $value['pv'];
                        $array['cxkdpvideo']['uv'] += $value['uv'];
                        $array['cxkdpvideo']['ip'] += $value['ip'];
                        break;
                    case 61:
                        $array['scscvideo']['pv'] += $value['pv'];
                        $array['scscvideo']['uv'] += $value['uv'];
                        $array['scscvideo']['ip'] += $value['ip'];
                        break;
                    case 57:
                        $array['ttyhsvideo']['pv'] += $value['pv'];
                        $array['ttyhsvideo']['uv'] += $value['uv'];
                        $array['ttyhsvideo']['ip'] += $value['ip'];
                        break;
                    case 33:
                        $array['xdpcvideo']['pv'] += $value['pv'];
                        $array['xdpcvideo']['uv'] += $value['uv'];
                        $array['xdpcvideo']['ip'] += $value['ip'];
                        break;
                }
            }
        //文章一级
        $yiarticle = $this->counter->getWebstatcount("*", "cname='article' and c1 > 0 and c2 = 0 and c3 = 0 and timeline BETWEEN '{$rstartdate}' AND '{$renddate}' order by c1 desc ", 2);
        if ($yiarticle)
            foreach ($yiarticle as $key => $value) {
                switch ($value['c1']) {
                    case 10:
                        $array['wharticle']['pv'] += $value['pv'];
                        $array['wharticle']['uv'] += $value['uv'];
                        $array['wharticle']['ip'] += $value['ip'];
                        break;
                    case 8:
                        $array['pcarticle']['pv'] += $value['pv'];
                        $array['pcarticle']['uv'] += $value['uv'];
                        $array['pcarticle']['ip'] += $value['ip'];
                        break;
                    case 7:
                        $array['zxarticle']['pv'] += $value['pv'];
                        $array['zxarticle']['uv'] += $value['uv'];
                        $array['zxarticle']['ip'] += $value['ip'];
                        break;
                }
            }
        //文章二级
        $erarticle = $this->counter->getWebstatcount("*", "cname='article' and c1 > 0 and c2 > 0 and c3 = 0 and timeline BETWEEN '{$rstartdate}' AND '{$renddate}' order by c2 asc ", 2);
        if ($erarticle)
            foreach ($erarticle as $key => $value) {
                switch ($value['c2']) {
                    case 50:
                        $array['jdcarticle']['pv'] += $value['pv'];
                        $array['jdcarticle']['uv'] += $value['uv'];
                        $array['jdcarticle']['ip'] += $value['ip'];
                        break;
                    case 51:
                        $array['ccarticle']['pv'] += $value['pv'];
                        $array['ccarticle']['uv'] += $value['uv'];
                        $array['ccarticle']['ip'] += $value['ip'];
                        break;
                    case 52:
                        $array['fycarticle']['pv'] += $value['pv'];
                        $array['fycarticle']['uv'] += $value['uv'];
                        $array['fycarticle']['ip'] += $value['ip'];
                        break;
                    case 54:
                        $array['xcarticle']['pv'] += $value['pv'];
                        $array['xcarticle']['uv'] += $value['uv'];
                        $array['xcarticle']['ip'] += $value['ip'];
                        break;
                    case 55:
                        $array['xwarticle']['pv'] += $value['pv'];
                        $array['xwarticle']['uv'] += $value['uv'];
                        $array['xwarticle']['ip'] += $value['ip'];
                        break;
                    case 56:
                        $array['csarticle']['pv'] += $value['pv'];
                        $array['csarticle']['uv'] += $value['uv'];
                        $array['csarticle']['ip'] += $value['ip'];
                        break;
                    case 59:
                        $array['dbarticle']['pv'] += $value['pv'];
                        $array['dbarticle']['uv'] += $value['uv'];
                        $array['dbarticle']['ip'] += $value['ip'];
                        break;
                    case 63:
                        $array['hyarticle']['pv'] += $value['pv'];
                        $array['hyarticle']['uv'] += $value['uv'];
                        $array['hyarticle']['ip'] += $value['ip'];
                        break;
                    case 65:
                        $array['lxarticle']['pv'] += $value['pv'];
                        $array['lxarticle']['uv'] += $value['uv'];
                        $array['lxarticle']['ip'] += $value['ip'];
                        break;
                }
            }
        //图片总量
        $array['pic'] = $this->counter->getWebstatcount("SUM(pv) pv,SUM(uv) uv,SUM(ip) ip", "cname='pic' and c1 = 1 and c2 = 0 and c3 = 0 and timeline BETWEEN '{$rstartdate}' AND '{$renddate}'", 1);

        // 取得列的列表
        if ($array)
            foreach ($array as $key => $row) {
                if ($key !== 'huodong') {
                    $array['huodong']['pv'] += $row['pv'] * 0.6;
                    $array['huodong']['uv'] += $row['uv'] * 0.6;
                    $array['huodong']['ip'] += $row['ip'] * 0.6;
                }
//                $volume[$key] = $row['pv'];
//                $edition[$key] = $row['uv'];
            }
//        if ($volume['zongliang'] && $edition['zongliang']) {
//            array_multisort($volume, SORT_DESC, $edition, SORT_DESC, $array);
//        }

        $this->tpl->assign('startdate', date("Y-m-d", $rstartdate));
        $this->tpl->assign('enddate', date("Y-m-d", $renddate));
        $this->tpl->assign('stat', $array);
        $this->tpl->assign('pagetype', $this->pagetype);
        $this->tpl->assign('page_title', $this->page_title);
        $this->template();
    }

    //统计前一天流量
    function doallStatCount() {
        $res = $this->doStatCount();
        $this->alert("统计写入完成", "js", 4);
    }

    //循环统计所有流量
    function doAllStat() {
        //counter表最小的 时间
        $mintime = strtotime('2015-08-19 0:0:0');
        $yestory = strtotime(date("Y-m-d", strtotime("-1 day"))); //昨天
        for ($index = $mintime; $index <= $yestory; $index+=86400) {
            $day = date('Ymd', $index);
            $this->doStatCount($day);
        }
        $this->alert("统计写入完成", "js", 4);
    }

    //统计每天访问流量
    function doStatCount($day = null) {
        //取出默认前一天的pv/ip流量统计
        if ($day) {
            $tmp = $day;
        } else {
            $tmp = date("Ymd", strtotime("-1 day"));
        }
        $rstartdate = strtotime($tmp);               //昨天 0点整
        //总量
        $ufields = '';
        $ufields['uv'] = $this->counter->getselect("(SELECT COUNT(sid) FROM " . DBNAME2 . ".counter_{$tmp} where sid<>'' GROUP BY sid) x", "COUNT(*) AS uv", "1", 3);
        $ufields['ip'] = $this->counter->getselect("(SELECT COUNT(ip) FROM " . DBNAME2 . ".counter_{$tmp} where ip<>'' GROUP BY ip) x", "COUNT(*) AS ip", "1", 3);
        $ufields['pv'] = $this->counter->getWherelist("count(*) pv", "1", 3, $tmp);
        $ufields['timeline'] = $rstartdate;
        $ufields['c1'] = 1;
        $ufields['c2'] = 0;
        $ufields['c3'] = 0;
        $ufields['cname'] = 'zongliang';
        $log = $this->counters->getWebstatcount("count(cname) as count", "cname='zongliang' and c1='1' and c2='0' and c3='0' and timeline='{$rstartdate}'", 1);
        if ($log['count'] > 0) {
            $ret = $this->counters->updateCounter($ufields, "cname='{$ufields['cname']}' and c1='{$ufields['c1']}' and c2='{$ufields['c2']}' and c3='{$ufields['c3']}' and timeline='{$rstartdate}'");
        } else {
            $ret = $this->counters->addCounter($ufields);
        }
        //文章视频最终页pv
        $zuipv = $this->counter->getWherelist("count(*) count,cname,c1,c2,c3", "c1 > 0 and c2 > 0 and c3 >0", 2, $tmp, '', 'cname,c1,c2,c3');
        if ($zuipv)
            foreach ($zuipv as $key => $value) {
                $zuiuv = $this->counter->getWherelist("sid", "c1='{$value['c1']}' and c2='{$value['c2']}' and c3='{$value['c3']}' and sid<>''", 2, $tmp, '', 'cname,sid');
                $zuiip = $this->counter->getWherelist("ip", "c1='{$value['c1']}' and c2='{$value['c2']}' and c3='{$value['c3']}' and ip<>''", 2, $tmp, '', 'cname,ip');
                $ufields = '';
                $ufields['uv'] = count($zuiuv);
                $ufields['ip'] = count($zuiip);
                $ufields['pv'] = $value['count'];
                $ufields['timeline'] = $rstartdate;
                $ufields['c1'] = $value['c1'];
                $ufields['c2'] = $value['c2'];
                $ufields['c3'] = $value['c3'];
                $ufields['cname'] = $value['cname'];
                $log = $this->counters->getWebstatcount("count(cname) as count", "cname='{$ufields['cname']}' and c1='{$value['c1']}' and c2='{$value['c2']}' and c3='{$value['c3']}' and timeline='{$rstartdate}'", 1);

                if ($log['count'] > 0) {
                    $ret = $this->counters->updateCounter($ufields, "cname='{$ufields['cname']}' and c1='{$value['c1']}' and c2='{$value['c2']}' and c3='{$value['c3']}' and timeline='{$rstartdate}'");
                } else {
                    $ret = $this->counters->addCounter($ufields);
                }
            }

        //单页pv
        $danpv = $this->counter->getWherelist("count(*) count,cname,c1", "c1 > 0 and c2=0 and c3=0 and cname<>'article' and cname<>'video' and cname<>'index' and cname<>'search_result' and cname<>'pic'", 2, $tmp, '', 'cname,c1');
        if ($danpv)
            foreach ($danpv as $key => $value) {
                $danuv = $this->counter->getWherelist("sid", "c1='{$value['c1']}' and c2=0 and c3 = 0 and cname<>'article' and cname<>'video' and cname<>'index' and cname<>'search_result' and cname<>'pic' and sid<>''", 2, $tmp, '', 'cname,sid');
                $danip = $this->counter->getWherelist("ip", "c1='{$value['c1']}' and c2=0 and c3 = 0 and cname<>'article' and cname<>'video' and cname<>'index' and cname<>'search_result' and cname<>'pic' and ip<>''", 2, $tmp, '', 'cname,ip');
                $ufields = '';
                $ufields['uv'] = count($danuv);
                $ufields['ip'] = count($danip);
                $ufields['pv'] = $value['count'];
                $ufields['timeline'] = $rstartdate;
                $ufields['c1'] = $value['c1'];
                $ufields['c2'] = 0;
                $ufields['c3'] = 0;
                $ufields['cname'] = $value['cname'];
                $log = $this->counters->getWebstatcount("count(cname) as count", "cname='{$ufields['cname']}' and c1='{$value['c1']}' and c2=0 and c3=0 and timeline='{$rstartdate}'", 1);
                if ($log['count'] > 0) {
                    $ret = $this->counters->updateCounter($ufields, "cname='{$ufields['cname']}' and c1='{$value['c1']}' and c2=0 and c3=0 and timeline='{$rstartdate}'");
                } else {
                    $ret = $this->counters->addCounter($ufields);
                }
            }
        //二级板块pv
        $erpv = $this->counter->getWherelist("count(*) count,cname,c1,c2", "c1 > 0 and c2 > 0 and c3=0", 2, $tmp, '', 'cname,c1,c2');
        if ($erpv)
            foreach ($erpv as $key => $value) {
                $eruv = $this->counter->getWherelist("sid", "c1='{$value['c1']}' and c2='{$value['c2']}' and c3 = 0 and sid<>''", 2, $tmp, '', 'cname,sid');
                $erip = $this->counter->getWherelist("ip", "c1='{$value['c1']}' and c2='{$value['c2']}' and c3 = 0 and ip<>''", 2, $tmp, '', 'cname,ip');
                $ufields = '';
                $ufields['uv'] = count($eruv);
                $ufields['ip'] = count($erip);
                $ufields['pv'] = $value['count'];
                $ufields['timeline'] = $rstartdate;
                $ufields['c1'] = $value['c1'];
                $ufields['c2'] = $value['c2'];
                $ufields['c3'] = 0;
                $ufields['cname'] = $value['cname'];
                $log = $this->counters->getWebstatcount("count(cname) as count", "cname='{$ufields['cname']}' and c1='{$value['c1']}' and c2='{$value['c2']}' and c3=0 and timeline='{$rstartdate}'", 1);
                if ($log['count'] > 0) {
                    $ret = $this->counters->updateCounter($ufields, "cname='{$ufields['cname']}' and c1='{$value['c1']}' and c2='{$value['c2']}' and c3=0 and timeline='{$rstartdate}'");
                } else {
                    $ret = $this->counters->addCounter($ufields);
                }
            }
        //一级板块pv
        $yipv = $this->counter->getWherelist("count(*) count,cname,c1", "c1 > 0 and c2 = 0 and c3 = 0 and cname<>'articlepic' and cname<>'model' and cname<>'offer' and cname<>'waparticlepic' and cname<>'bigpic' and cname<>'searchbrandlist' and cname<>'searchlist' and cname<>'param' and cname<>'compareattr'", 2, $tmp, '', 'cname,c1');

        if ($yipv)
            foreach ($yipv as $key => $value) {
                $yiuv = $this->counter->getWherelist("sid", "cname = '{$value['cname']}' and c1='{$value['c1']}' and c2 = 0 and c3 = 0 and cname<>'articlepic' and cname<>'model' and cname<>'offer' and cname<>'waparticlepic' and cname<>'bigpic' and cname<>'searchbrandlist' and cname<>'searchlist' and cname<>'param' and cname<>'compareattr' and sid<>''", 2, $tmp, '', 'cname,sid');
                $yiip = $this->counter->getWherelist("ip", "cname = '{$value['cname']}' and c1='{$value['c1']}' and c2 = 0 and c3 = 0 and cname<>'articlepic' and cname<>'model' and cname<>'offer' and cname<>'waparticlepic' and cname<>'bigpic' and cname<>'searchbrandlist' and cname<>'searchlist' and cname<>'param' and cname<>'compareattr' and ip<>''", 2, $tmp, '', 'cname,ip');

                $ufields = '';
                $ufields['uv'] = count($yiuv);
                $ufields['ip'] = count($yiip);
                $ufields['pv'] = $value['count'];
                $ufields['timeline'] = $rstartdate;
                $ufields['c1'] = $value['c1'];
                $ufields['c2'] = 0;
                $ufields['c3'] = 0;
                $ufields['cname'] = $value['cname'];
                $log = $this->counters->getWebstatcount("count(cname) as count", "cname='{$ufields['cname']}' and c1='{$value['c1']}' and c2=0 and c3=0 and timeline='{$rstartdate}'", 1);
                if ($log['count'] > 0) {
                    $ret = $this->counters->updateCounter($ufields, "cname='{$ufields['cname']}' and c1='{$value['c1']}' and c2=0 and c3=0 and timeline='{$rstartdate}'");
                } else {
                    $ret = $this->counters->addCounter($ufields);
                }
            }

        //tag首页pv
        $tagspv = $this->counter->getWherelist("count(*) count,cname,c2", "c1 = 0 and c2 > 0 and c3=0", 2, $tmp, '', 'cname,c2');
        if ($tagspv)
            foreach ($tagspv as $key => $value) {
                $tagsuv = $this->counter->getWherelist("sid", "c1 = 0 and c2 = '{$value['c2']}' and c3=0 and sid<>''", 2, $tmp, '', 'cname,sid');
                $tagsip = $this->counter->getWherelist("ip", "c1 = 0 and c2 = '{$value['c2']}' and c3=0 and ip<>''", 2, $tmp, '', 'cname,ip');
                $ufields = '';
                $ufields['uv'] = count($tagsuv);
                $ufields['ip'] = count($tagsip);
                $ufields['pv'] = $value['count'];
                $ufields['timeline'] = $rstartdate;
                $ufields['c1'] = 0;
                $ufields['c2'] = $value['c2'];
                $ufields['c3'] = 0;
                $ufields['cname'] = $value['cname'];
                $log = $this->counters->getWebstatcount("count(cname) as count", "cname='{$ufields['cname']}' and c1=0 and c2='{$value['c2']}' and c3=0 and timeline='{$rstartdate}'", 1);
                if ($log['count'] > 0) {
                    $ret = $this->counters->updateCounter($ufields, "cname='{$ufields['cname']}' and c1=0 and c2='{$value['c2']}' and c3=0 and timeline='{$rstartdate}'");
                } else {
                    $ret = $this->counters->addCounter($ufields);
                }
            }
        //搜索pv
        $soupv = $this->counter->getWherelist("count(*) count,cname", "c1 = 0 and c2 = 0 and c3=0 and cname<>'articlepic' and cname<>'notfound'", 2, $tmp, '', 'cname');
        if ($soupv)
            foreach ($soupv as $key => $value) {
                $ufields = '';
                $ufields['pv'] = $value['count'];
                $ufields['timeline'] = $rstartdate;
                $ufields['c1'] = 0;
                $ufields['c2'] = 0;
                $ufields['c3'] = 0;
                $ufields['cname'] = $value['cname'];
                $log = $this->counters->getWebstatcount("count(cname) as count", "cname='{$ufields['cname']}' and c1=0 and c2=0 and c3=0 and timeline='{$rstartdate}'", 1);
                if ($log['count'] > 0) {
                    $ret = $this->counters->updateCounter($ufields, "cname='{$ufields['cname']}' and c1=0 and c2=0 and c3=0 and timeline='{$rstartdate}'");
                } else {
                    $ret = $this->counters->addCounter($ufields);
                }
            }
        //搜索uv
        $souuv = $this->counter->getWherelist("cname,sid", "c1 = 0 and c2 = 0 and c3=0 and cname<>'articlepic' and cname<>'notfound' and sid<>''", 2, $tmp, '', 'cname,sid');
        if ($souuv) {
            $ufields = '';
            $ufields['uv'] = count($souuv);
            $ufields['timeline'] = $rstartdate;
            $ufields['c1'] = 0;
            $ufields['c2'] = 0;
            $ufields['c3'] = 0;
            $ufields['cname'] = $souuv[0]['cname'];
            $log = $this->counters->getWebstatcount("count(cname) as count", "cname='{$ufields['cname']}' and c1=0 and c2=0 and c3=0 and timeline='{$rstartdate}'", 1);
            if ($log['count'] > 0) {
                $ret = $this->counters->updateCounter($ufields, "cname='{$ufields['cname']}' and c1=0 and c2=0 and c3=0 and timeline='{$rstartdate}'");
            } else {
                $ret = $this->counters->addCounter($ufields);
            }
        }
        //搜索ip
        $souip = $this->counter->getWherelist("cname,ip", "c1 = 0 and c2 = 0 and c3=0 and cname<>'articlepic' and cname<>'notfound' and ip<>''", 2, $tmp, '', 'cname,ip');
        if ($souip) {
            $ufields = '';
            $ufields['ip'] = count($souip);
            $ufields['timeline'] = $rstartdate;
            $ufields['c1'] = 0;
            $ufields['c2'] = 0;
            $ufields['c3'] = 0;
            $ufields['cname'] = $souuv[0]['cname'];
            $log = $this->counters->getWebstatcount("count(cname) as count", "cname='{$ufields['cname']}' and c1=0 and c2=0 and c3=0 and timeline='{$rstartdate}'", 1);
            if ($log['count'] > 0) {
                $ret = $this->counters->updateCounter($ufields, "cname='{$ufields['cname']}' and c1=0 and c2=0 and c3=0 and timeline='{$rstartdate}'");
            } else {
                $ret = $this->counters->addCounter($ufields);
            }
        }
    }

    //历史统计
    function doHistorystat() {
        $this->tpl_file = "webstat_history";
        $this->page_title = "历史统计";
        //取出默认前一天的pv/ip流量统计
        $rstartdate = strtotime(date("Y-m-d", strtotime("-1 day")));
        $tmp = date("Ymd", strtotime("-1 day"));
        $rstartdate7 = strtotime(date("Y-m-d", strtotime("-7 day")));
        $rstartdate30 = strtotime(date("Y-m-d", strtotime("-30 day")));
        $renddate = strtotime(date("Y-m-d", time()));
        //总流量
        //昨日流量
        $stat['zongliang']["昨日流量"] = $this->counter->getWebstatcount("SUM(pv) pv,SUM(uv) uv,SUM(ip) ip", "cname='zongliang' and c1 = 1 and c2 = 0 and c3 = 0 and timeline='{$rstartdate}'", 1);
        //本周流量
        $stat['zongliang']["过去7天流量"] = $this->counter->getWebstatcount("SUM(pv) pv,SUM(uv) uv,SUM(ip) ip", "cname='zongliang' and c1 = 1 and c2 = 0 and c3 = 0 and timeline BETWEEN '{$rstartdate7}' AND '{$renddate}'", 1);
        //本月流量
        $stat['zongliang']["过去30天流量"] = $this->counter->getWebstatcount("SUM(pv) pv,SUM(uv) uv,SUM(ip) ip", "cname='zongliang' and c1 = 1 and c2 = 0 and c3 = 0 and timeline BETWEEN '{$rstartdate30}' AND '{$renddate}'", 1);
        //历史最高
        $logmax["pv"] = $this->counter->getMaxstat("pv,timeline", "cname='zongliang' and c1 = 1 and c2 = 0 and c3 = 0 and pv=(select max(pv) from counter.counter where cname='zongliang' and c1 = 1 and c2 = 0 and c3 = 0 )");
        $logmax["ip"] = $this->counter->getMaxstat("ip,timeline", "cname='zongliang' and c1 = 1 and c2 = 0 and c3 = 0 and ip=(select max(ip) from counter.counter where cname='zongliang' and c1 = 1 and c2 = 0 and c3 = 0 )");
        $logmax["uv"] = $this->counter->getMaxstat("uv,timeline", "cname='zongliang' and c1 = 1 and c2 = 0 and c3 = 0 and uv=(select max(uv) from counter.counter where cname='zongliang' and c1 = 1 and c2 = 0 and c3 = 0 )");
        $stat['zongliang']["历史最高发生在"] = $logmax;
        //文章总量
        $stat['zarticle']["昨日流量"] = $this->counter->getWebstatcount("SUM(pv) pv,SUM(uv) uv,SUM(ip) ip", "cname='article' and c1 >0 and c2 > 0 and c3 > 0 and timeline='{$rstartdate}'", 1);
        $stat['zarticle']["过去7天流量"] = $this->counter->getWebstatcount("SUM(pv) pv,SUM(uv) uv,SUM(ip) ip", "cname='article' and c1 >0 and c2 > 0 and c3 > 0 and timeline BETWEEN '{$rstartdate7}' AND '{$renddate}'", 1);
        $stat['zarticle']["过去30天流量"] = $this->counter->getWebstatcount("SUM(pv) pv,SUM(uv) uv,SUM(ip) ip", "cname='article' and c1 >0 and c2 > 0 and c3 > 0 and timeline BETWEEN '{$rstartdate30}' AND '{$renddate}'", 1);
        //历史最高
        $logmax["pv"] = $this->counter->getMaxstat("pv,timeline", "cname='article' and c1 >0 and c2 > 0 and c3 > 0 and pv=(select max(pv) from counter.counter where cname='article' and c1 >0 and c2 > 0 and c3 > 0 )");
        $logmax["ip"] = $this->counter->getMaxstat("ip,timeline", "cname='article' and c1 >0 and c2 > 0 and c3 > 0 and ip=(select max(ip) from counter.counter where cname='article' and c1 >0 and c2 > 0 and c3 > 0 )");
        $logmax["uv"] = $this->counter->getMaxstat("uv,timeline", "cname='article' and c1 >0 and c2 > 0 and c3 > 0 and uv=(select max(uv) from counter.counter where cname='article' and c1 >0 and c2 > 0 and c3 > 0 )");
        $stat['zarticle']["历史最高发生在"] = $logmax;
        //视频总量
        $stat['zvideo']["昨日流量"] = $this->counter->getWebstatcount("SUM(pv) pv,SUM(uv) uv,SUM(ip) ip", "cname='video' and c1 >0 and c2 > 0 and c3 > 0 and timeline='{$rstartdate}'", 1);
        $stat['zvideo']["过去7天流量"] = $this->counter->getWebstatcount("SUM(pv) pv,SUM(uv) uv,SUM(ip) ip", "cname='video' and c1 >0 and c2 > 0 and c3 > 0 and timeline BETWEEN '{$rstartdate7}' AND '{$renddate}'", 1);
        $stat['zvideo']["过去30天流量"] = $this->counter->getWebstatcount("SUM(pv) pv,SUM(uv) uv,SUM(ip) ip", "cname='video' and c1 >0 and c2 > 0 and c3 > 0 and timeline BETWEEN '{$rstartdate30}' AND '{$renddate}'", 1);
        //历史最高
        $logmax["pv"] = $this->counter->getMaxstat("pv,timeline", "cname='video' and c1 >0 and c2 > 0 and c3 > 0 and pv=(select max(pv) from counter.counter where cname='video' and c1 >0 and c2 > 0 and c3 > 0 )");
        $logmax["ip"] = $this->counter->getMaxstat("ip,timeline", "cname='video' and c1 >0 and c2 > 0 and c3 > 0 and ip=(select max(ip) from counter.counter where cname='video' and c1 >0 and c2 > 0 and c3 > 0 )");
        $logmax["uv"] = $this->counter->getMaxstat("uv,timeline", "cname='video' and c1 >0 and c2 > 0 and c3 > 0 and uv=(select max(uv) from counter.counter where cname='video' and c1 >0 and c2 > 0 and c3 > 0 )");
        $stat['zvideo']["历史最高发生在"] = $logmax;
        $stat['huodong']["昨日流量"] = $this->counter->getWebstatcount("SUM(pv) pv,SUM(uv) uv,SUM(ip) ip", "cname='huodong' and c1 = 1 and c2 = 0 and c3 = 0 and timeline='{$rstartdate}'", 1);
        $stat['huodong']["过去7天流量"] = $this->counter->getWebstatcount("SUM(pv) pv,SUM(uv) uv,SUM(ip) ip", "cname='huodong' and c1 = 1 and c2 = 0 and c3 = 0 and timeline BETWEEN '{$rstartdate7}' AND '{$renddate}'", 1);
        $stat['huodong']["过去30天流量"] = $this->counter->getWebstatcount("SUM(pv) pv,SUM(uv) uv,SUM(ip) ip", "cname='huodong' and c1 = 1 and c2 = 0 and c3 = 0 and timeline BETWEEN '{$rstartdate30}' AND '{$renddate}'", 1);
        //历史最高
        $logmax["pv"] = $this->counter->getMaxstat("pv,timeline", "cname='huodong' and c1 = 1 and c2 = 0 and c3 = 0 and pv=(select max(pv) from counter.counter where cname='huodong' and c1 = 1 and c2 = 0 and c3 = 0 )");
        $logmax["ip"] = $this->counter->getMaxstat("ip,timeline", "cname='huodong' and c1 = 1 and c2 = 0 and c3 = 0 and ip=(select max(ip) from counter.counter where cname='huodong' and c1 = 1 and c2 = 0 and c3 = 0 )");
        $logmax["uv"] = $this->counter->getMaxstat("uv,timeline", "cname='huodong' and c1 = 1 and c2 = 0 and c3 = 0 and uv=(select max(uv) from counter.counter where cname='huodong' and c1 = 1 and c2 = 0 and c3 = 0 )");
        $stat['huodong']["历史最高发生在"] = $logmax;
        //首页总量
        $stat['index']["昨日流量"] = $this->counter->getWebstatcount("SUM(pv) pv,SUM(uv) uv,SUM(ip) ip", "cname='index' and c1 = 1 and c2 = 0 and c3 = 0 and timeline='{$rstartdate}'", 1);
        $stat['index']["过去7天流量"] = $this->counter->getWebstatcount("SUM(pv) pv,SUM(uv) uv,SUM(ip) ip", "cname='index' and c1 = 1 and c2 = 0 and c3 = 0 and timeline BETWEEN '{$rstartdate7}' AND '{$renddate}'", 1);
        $stat['index']["过去30天流量"] = $this->counter->getWebstatcount("SUM(pv) pv,SUM(uv) uv,SUM(ip) ip", "cname='index' and c1 = 1 and c2 = 0 and c3 = 0 and timeline BETWEEN '{$rstartdate30}' AND '{$renddate}'", 1);
        //历史最高
        $logmax["pv"] = $this->counter->getMaxstat("pv,timeline", "cname='index' and c1 = 1 and c2 = 0 and c3 = 0 and pv=(select max(pv) from counter.counter where cname='index' and c1 = 1 and c2 = 0 and c3 = 0 )");
        $logmax["ip"] = $this->counter->getMaxstat("ip,timeline", "cname='index' and c1 = 1 and c2 = 0 and c3 = 0 and ip=(select max(ip) from counter.counter where cname='index' and c1 = 1 and c2 = 0 and c3 = 0 )");
        $logmax["uv"] = $this->counter->getMaxstat("uv,timeline", "cname='index' and c1 = 1 and c2 = 0 and c3 = 0 and uv=(select max(uv) from counter.counter where cname='index' and c1 = 1 and c2 = 0 and c3 = 0 )");
        $stat['index']["历史最高发生在"] = $logmax;
        //视频一级
        $stat['video']["昨日流量"] = $this->counter->getWebstatcount("SUM(pv) pv,SUM(uv) uv,SUM(ip) ip", "cname='video' and c1 = 9 and c2 = 0 and c3 = 0 and timeline='{$rstartdate}'", 1);
        $stat['video']["过去7天流量"] = $this->counter->getWebstatcount("SUM(pv) pv,SUM(uv) uv,SUM(ip) ip", "cname='video' and c1 = 9 and c2 = 0 and c3 = 0 and timeline BETWEEN '{$rstartdate7}' AND '{$renddate}'", 1);
        $stat['video']["过去30天流量"] = $this->counter->getWebstatcount("SUM(pv) pv,SUM(uv) uv,SUM(ip) ip", "cname='video' and c1 = 9 and c2 = 0 and c3 = 0 and timeline BETWEEN '{$rstartdate30}' AND '{$renddate}'", 1);
        //历史最高
        $logmax["pv"] = $this->counter->getMaxstat("pv,timeline", "cname='video' and c1 = 9 and c2 = 0 and c3 = 0 and pv=(select max(pv) from counter.counter where cname='video' and c1 = 9 and c2 = 0 and c3 = 0 )");
        $logmax["ip"] = $this->counter->getMaxstat("ip,timeline", "cname='video' and c1 = 9 and c2 = 0 and c3 = 0 and ip=(select max(ip) from counter.counter where cname='video' and c1 = 9 and c2 = 0 and c3 = 0 )");
        $logmax["uv"] = $this->counter->getMaxstat("uv,timeline", "cname='video' and c1 = 9 and c2 = 0 and c3 = 0 and uv=(select max(uv) from counter.counter where cname='video' and c1 = 9 and c2 = 0 and c3 = 0 )");
        $stat['video']["历史最高发生在"] = $logmax;
        //视频er级
        $ervideo = $this->counter->getWebstatcount("*", "cname='video' and c1 = 9 and c2 > 0 and c3 = 0 and timeline='{$rstartdate}' order by c2 desc", 2);
        if ($ervideo)
            foreach ($ervideo as $key => $value) {
                switch ($value['c2']) {
                    case 66:
                        $stat['ttsrxvideo']["昨日流量"] = $value;
                        break;
                    case 62:
                        $stat['cxkdpvideo']["昨日流量"] = $value;
                        break;
                    case 61:
                        $stat['scscvideo']["昨日流量"] = $value;
                        break;
                    case 57:
                        $stat['ttyhsvideo']["昨日流量"] = $value;
                        break;
                    case 33:
                        $stat['xdpcvideo']["昨日流量"] = $value;
                        break;
                }
            }
        $ervideo7 = $this->counter->getWebstatcount("*", "cname='video' and c1 = 9 and c2 > 0 and c3 = 0 and timeline BETWEEN '{$rstartdate7}' AND '{$renddate}' order by c2 desc", 2);
        if ($ervideo7)
            foreach ($ervideo7 as $key => $value) {
                switch ($value['c2']) {
                    case 66:
                        $stat['ttsrxvideo']["过去7天流量"]['pv'] += $value['pv'];
                        $stat['ttsrxvideo']["过去7天流量"]['uv'] += $value['uv'];
                        $stat['ttsrxvideo']["过去7天流量"]['ip'] += $value['ip'];
                        break;
                    case 62:
                        $stat['cxkdpvideo']["过去7天流量"]['pv'] += $value['pv'];
                        $stat['cxkdpvideo']["过去7天流量"]['uv'] += $value['uv'];
                        $stat['cxkdpvideo']["过去7天流量"]['ip'] += $value['ip'];
                        break;
                    case 61:
                        $stat['scscvideo']["过去7天流量"]['pv'] += $value['pv'];
                        $stat['scscvideo']["过去7天流量"]['uv'] += $value['uv'];
                        $stat['scscvideo']["过去7天流量"]['ip'] += $value['ip'];
                        break;
                    case 57:
                        $stat['ttyhsvideo']["过去7天流量"]['pv'] += $value['pv'];
                        $stat['ttyhsvideo']["过去7天流量"]['uv'] += $value['uv'];
                        $stat['ttyhsvideo']["过去7天流量"]['ip'] += $value['ip'];
                        break;
                    case 33:
                        $stat['xdpcvideo']["过去7天流量"]['pv'] += $value['pv'];
                        $stat['xdpcvideo']["过去7天流量"]['uv'] += $value['uv'];
                        $stat['xdpcvideo']["过去7天流量"]['ip'] += $value['ip'];
                        break;
                }
            }
        $ervideo30 = $this->counter->getWebstatcount("*", "cname='video' and c1 = 9 and c2 > 0 and c3 = 0 and timeline BETWEEN '{$rstartdate30}' AND '{$renddate}' order by c2 desc", 2);
        if ($ervideo30)
            foreach ($ervideo30 as $key => $value) {
                switch ($value['c2']) {
                    case 66:
                        $stat['ttsrxvideo']["过去30天流量"]['pv'] += $value['pv'];
                        $stat['ttsrxvideo']["过去30天流量"]['uv'] += $value['uv'];
                        $stat['ttsrxvideo']["过去30天流量"]['ip'] += $value['ip'];
                        //历史最高
                        $logmax["pv"] = $this->counter->getWebstatcount("max(pv) pv,timeline", "cname='video' and c1 = 9 and c2 = '{$value['c2']}' and c3 = 0", 1);
                        $logmax["uv"] = $this->counter->getWebstatcount("max(uv) uv,timeline", "cname='video' and c1 = 9 and c2 = '{$value['c2']}' and c3 = 0", 1);
                        $logmax["ip"] = $this->counter->getWebstatcount("max(ip) ip,timeline", "cname='video' and c1 = 9 and c2 = '{$value['c2']}' and c3 = 0", 1);
                        $stat['ttsrxvideo']["历史最高发生在"] = $logmax;
                        break;
                    case 62:
                        $stat['cxkdpvideo']["过去30天流量"]['pv'] += $value['pv'];
                        $stat['cxkdpvideo']["过去30天流量"]['uv'] += $value['uv'];
                        $stat['cxkdpvideo']["过去30天流量"]['ip'] += $value['ip'];
                        //历史最高
                        $logmax["pv"] = $this->counter->getWebstatcount("max(pv) pv,timeline", "cname='video' and c1 = 9 and c2 = '{$value['c2']}' and c3 = 0", 1);
                        $logmax["uv"] = $this->counter->getWebstatcount("max(uv) uv,timeline", "cname='video' and c1 = 9 and c2 = '{$value['c2']}' and c3 = 0", 1);
                        $logmax["ip"] = $this->counter->getWebstatcount("max(ip) ip,timeline", "cname='video' and c1 = 9 and c2 = '{$value['c2']}' and c3 = 0", 1);
                        $stat['cxkdpvideo']["历史最高发生在"] = $logmax;
                        break;
                    case 61:
                        $stat['scscvideo']["过去30天流量"]['pv'] += $value['pv'];
                        $stat['scscvideo']["过去30天流量"]['uv'] += $value['uv'];
                        $stat['scscvideo']["过去30天流量"]['ip'] += $value['ip'];
                        //历史最高
                        $logmax["pv"] = $this->counter->getWebstatcount("max(pv) pv,timeline", "cname='video' and c1 = 9 and c2 = '{$value['c2']}' and c3 = 0", 1);
                        $logmax["uv"] = $this->counter->getWebstatcount("max(uv) uv,timeline", "cname='video' and c1 = 9 and c2 = '{$value['c2']}' and c3 = 0", 1);
                        $logmax["ip"] = $this->counter->getWebstatcount("max(ip) ip,timeline", "cname='video' and c1 = 9 and c2 = '{$value['c2']}' and c3 = 0", 1);
                        $stat['scscvideo']["历史最高发生在"] = $logmax;
                        break;
                    case 57:
                        $stat['ttyhsvideo']["过去30天流量"]['pv'] += $value['pv'];
                        $stat['ttyhsvideo']["过去30天流量"]['uv'] += $value['uv'];
                        $stat['ttyhsvideo']["过去30天流量"]['ip'] += $value['ip'];
                        //历史最高
                        $logmax["pv"] = $this->counter->getWebstatcount("max(pv) pv,timeline", "cname='video' and c1 = 9 and c2 = '{$value['c2']}' and c3 = 0", 1);
                        $logmax["uv"] = $this->counter->getWebstatcount("max(uv) uv,timeline", "cname='video' and c1 = 9 and c2 = '{$value['c2']}' and c3 = 0", 1);
                        $logmax["ip"] = $this->counter->getWebstatcount("max(ip) ip,timeline", "cname='video' and c1 = 9 and c2 = '{$value['c2']}' and c3 = 0", 1);
                        $stat['ttyhsvideo']["历史最高发生在"] = $logmax;
                        break;
                    case 33:
                        $stat['xdpcvideo']["过去30天流量"]['pv'] += $value['pv'];
                        $stat['xdpcvideo']["过去30天流量"]['uv'] += $value['uv'];
                        $stat['xdpcvideo']["过去30天流量"]['ip'] += $value['ip'];
                        //历史最高
                        $logmax["pv"] = $this->counter->getWebstatcount("max(pv) pv,timeline", "cname='video' and c1 = 9 and c2 = '{$value['c2']}' and c3 = 0", 1);
                        $logmax["uv"] = $this->counter->getWebstatcount("max(uv) uv,timeline", "cname='video' and c1 = 9 and c2 = '{$value['c2']}' and c3 = 0", 1);
                        $logmax["ip"] = $this->counter->getWebstatcount("max(ip) ip,timeline", "cname='video' and c1 = 9 and c2 = '{$value['c2']}' and c3 = 0", 1);
                        $stat['xdpcvideo']["历史最高发生在"] = $logmax;
                        break;
                }
            }
        //文章一级
        $yiarticle = $this->counter->getWebstatcount("*", "cname='article' and c1 > 0 and c2 = 0 and c3 = 0 and timeline='{$rstartdate}' order by c1 desc ", 2);
        if ($yiarticle)
            foreach ($yiarticle as $key => $value) {
                switch ($value['c1']) {
                    case 10:
                        $stat['wharticle']["昨日流量"] = $value;
                        break;
                    case 8:
                        $stat['pcarticle']["昨日流量"] = $value;
                        break;
                    case 7:
                        $stat['zxarticle']["昨日流量"] = $value;
                        break;
                }
            }
        $yiarticle7 = $this->counter->getWebstatcount("*", "cname='article' and c1 > 0 and c2 = 0 and c3 = 0 and timeline BETWEEN '{$rstartdate7}' AND '{$renddate}' order by c1 desc ", 2);
        if ($yiarticle7)
            foreach ($yiarticle7 as $key => $value) {
                switch ($value['c1']) {
                    case 10:
                        $stat['wharticle']["过去7天流量"]['pv'] += $value['pv'];
                        $stat['wharticle']["过去7天流量"]['uv'] += $value['uv'];
                        $stat['wharticle']["过去7天流量"]['ip'] += $value['ip'];
                        break;
                    case 8:
                        $stat['pcarticle']["过去7天流量"]['pv'] += $value['pv'];
                        $stat['pcarticle']["过去7天流量"]['uv'] += $value['uv'];
                        $stat['pcarticle']["过去7天流量"]['ip'] += $value['ip'];
                        break;
                    case 7:
                        $stat['zxarticle']["过去7天流量"]['pv'] += $value['pv'];
                        $stat['zxarticle']["过去7天流量"]['uv'] += $value['uv'];
                        $stat['zxarticle']["过去7天流量"]['ip'] += $value['ip'];
                        break;
                }
            }
        $yiarticle30 = $this->counter->getWebstatcount("*", "cname='article' and c1 > 0 and c2 = 0 and c3 = 0 and timeline BETWEEN '{$rstartdate30}' AND '{$renddate}' order by c1 desc ", 2);
        if ($yiarticle30)
            foreach ($yiarticle30 as $key => $value) {
                switch ($value['c1']) {
                    case 10:
                        $stat['wharticle']["过去30天流量"]['pv'] += $value['pv'];
                        $stat['wharticle']["过去30天流量"]['uv'] += $value['uv'];
                        $stat['wharticle']["过去30天流量"]['ip'] += $value['ip'];
                        //历史最高
                        $logmax["pv"] = $this->counter->getWebstatcount("max(pv) pv,timeline", "cname='article' and c1 = '{$value['c1']}' and c2 = 0 and c3 = 0", 1);
                        $logmax["uv"] = $this->counter->getWebstatcount("max(uv) uv,timeline", "cname='article' and c1 = '{$value['c1']}' and c2 = 0 and c3 = 0", 1);
                        $logmax["ip"] = $this->counter->getWebstatcount("max(ip) ip,timeline", "cname='article' and c1 = '{$value['c1']}' and c2 = 0 and c3 = 0", 1);
                        $stat['wharticle']["历史最高发生在"] = $logmax;
                        break;
                    case 8:
                        $stat['pcarticle']["过去30天流量"]['pv'] += $value['pv'];
                        $stat['pcarticle']["过去30天流量"]['uv'] += $value['uv'];
                        $stat['pcarticle']["过去30天流量"]['ip'] += $value['ip'];
                        //历史最高
                        $logmax["pv"] = $this->counter->getWebstatcount("max(pv) pv,timeline", "cname='article' and c1 = '{$value['c1']}' and c2 = 0 and c3 = 0", 1);
                        $logmax["uv"] = $this->counter->getWebstatcount("max(uv) uv,timeline", "cname='article' and c1 = '{$value['c1']}' and c2 = 0 and c3 = 0", 1);
                        $logmax["ip"] = $this->counter->getWebstatcount("max(ip) ip,timeline", "cname='article' and c1 = '{$value['c1']}' and c2 = 0 and c3 = 0", 1);
                        $stat['pcarticle']["历史最高发生在"] = $logmax;
                        break;
                    case 7:
                        $stat['zxarticle']["过去30天流量"]['pv'] += $value['pv'];
                        $stat['zxarticle']["过去30天流量"]['uv'] += $value['uv'];
                        $stat['zxarticle']["过去30天流量"]['ip'] += $value['ip'];
                        //历史最高
                        $logmax["pv"] = $this->counter->getWebstatcount("max(pv) pv,timeline", "cname='article' and c1 = '{$value['c1']}' and c2 = 0 and c3 = 0", 1);
                        $logmax["uv"] = $this->counter->getWebstatcount("max(uv) uv,timeline", "cname='article' and c1 = '{$value['c1']}' and c2 = 0 and c3 = 0", 1);
                        $logmax["ip"] = $this->counter->getWebstatcount("max(ip) ip,timeline", "cname='article' and c1 = '{$value['c1']}' and c2 = 0 and c3 = 0", 1);
                        $stat['zxarticle']["历史最高发生在"] = $logmax;
                        break;
                }
            }
        //文章二级
        $erarticle = $this->counter->getWebstatcount("*", "cname='article' and c1 > 0 and c2 > 0 and c3 = 0 and timeline='{$rstartdate}' order by c2 asc ", 2);
        if ($erarticle)
            foreach ($erarticle as $key => $value) {
                switch ($value['c2']) {
                    case 50:
                        $stat['jdcarticle']["昨日流量"] = $value;
                        break;
                    case 51:
                        $stat['ccarticle']["昨日流量"] = $value;
                        break;
                    case 52:
                        $stat['fycarticle']["昨日流量"] = $value;
                        break;
                    case 54:
                        $stat['xcarticle']["昨日流量"] = $value;
                        break;
                    case 55:
                        $stat['xwarticle']["昨日流量"] = $value;
                        break;
                    case 56:
                        $stat['csarticle']["昨日流量"] = $value;
                        break;
                    case 59:
                        $stat['dbarticle']["昨日流量"] = $value;
                        break;
                    case 63:
                        $stat['hyarticle']["昨日流量"] = $value;
                        break;
                    case 65:
                        $stat['lxarticle']["昨日流量"] = $value;
                        break;
                }
            }
        $erarticle7 = $this->counter->getWebstatcount("*", "cname='article' and c1 > 0 and c2 > 0 and c3 = 0 and timeline BETWEEN '{$rstartdate7}' AND '{$renddate}' order by c2 asc ", 2);
        if ($erarticle7)
            foreach ($erarticle7 as $key => $value) {
                switch ($value['c2']) {
                    case 50:
                        $stat['jdcarticle']["过去7天流量"]['pv'] += $value['pv'];
                        $stat['jdcarticle']["过去7天流量"]['uv'] += $value['uv'];
                        $stat['jdcarticle']["过去7天流量"]['ip'] += $value['ip'];
                        break;
                    case 51:
                        $stat['ccarticle']["过去7天流量"]['pv'] += $value['pv'];
                        $stat['ccarticle']["过去7天流量"]['uv'] += $value['uv'];
                        $stat['ccarticle']["过去7天流量"]['ip'] += $value['ip'];
                        break;
                    case 52:
                        $stat['fycarticle']["过去7天流量"]['pv'] += $value['pv'];
                        $stat['fycarticle']["过去7天流量"]['uv'] += $value['uv'];
                        $stat['fycarticle']["过去7天流量"]['ip'] += $value['ip'];
                        break;
                    case 54:
                        $stat['xcarticle']["过去7天流量"]['pv'] += $value['pv'];
                        $stat['xcarticle']["过去7天流量"]['uv'] += $value['uv'];
                        $stat['xcarticle']["过去7天流量"]['ip'] += $value['ip'];
                        break;
                    case 55:
                        $stat['xwarticle']["过去7天流量"]['pv'] += $value['pv'];
                        $stat['xwarticle']["过去7天流量"]['uv'] += $value['uv'];
                        $stat['xwarticle']["过去7天流量"]['ip'] += $value['ip'];
                        break;
                    case 56:
                        $stat['csarticle']["过去7天流量"]['pv'] += $value['pv'];
                        $stat['csarticle']["过去7天流量"]['uv'] += $value['uv'];
                        $stat['csarticle']["过去7天流量"]['ip'] += $value['ip'];
                        break;
                    case 59:
                        $stat['dbarticle']["过去7天流量"]['pv'] += $value['pv'];
                        $stat['dbarticle']["过去7天流量"]['uv'] += $value['uv'];
                        $stat['dbarticle']["过去7天流量"]['ip'] += $value['ip'];
                        break;
                    case 63:
                        $stat['hyarticle']["过去7天流量"]['pv'] += $value['pv'];
                        $stat['hyarticle']["过去7天流量"]['uv'] += $value['uv'];
                        $stat['hyarticle']["过去7天流量"]['ip'] += $value['ip'];
                        break;
                    case 65:
                        $stat['lxarticle']["过去7天流量"]['pv'] += $value['pv'];
                        $stat['lxarticle']["过去7天流量"]['uv'] += $value['uv'];
                        $stat['lxarticle']["过去7天流量"]['ip'] += $value['ip'];
                        break;
                }
            }
        $erarticle30 = $this->counter->getWebstatcount("*", "cname='article' and c1 > 0 and c2 > 0 and c3 = 0 and timeline BETWEEN '{$rstartdate30}' AND '{$renddate}' order by c2 asc ", 2);
        if ($erarticle30)
            foreach ($erarticle30 as $key => $value) {
                switch ($value['c2']) {
                    case 50:
                        $stat['jdcarticle']["过去30天流量"]['pv'] += $value['pv'];
                        $stat['jdcarticle']["过去30天流量"]['uv'] += $value['uv'];
                        $stat['jdcarticle']["过去30天流量"]['ip'] += $value['ip'];
                        //历史最高
                        $logmax["pv"] = $this->counter->getWebstatcount("max(pv) pv,timeline", "cname='article' and c1 = '{$value['c1']}' and c2 = '{$value['c2']}' and c3 = 0", 1);
                        $logmax["uv"] = $this->counter->getWebstatcount("max(uv) uv,timeline", "cname='article' and c1 = '{$value['c1']}' and c2 = '{$value['c2']}' and c3 = 0", 1);
                        $logmax["ip"] = $this->counter->getWebstatcount("max(ip) ip,timeline", "cname='article' and c1 = '{$value['c1']}' and c2 = '{$value['c2']}' and c3 = 0", 1);
                        $stat['jdcarticle']["历史最高发生在"] = $logmax;
                        break;
                    case 51:
                        $stat['ccarticle']["过去30天流量"]['pv'] += $value['pv'];
                        $stat['ccarticle']["过去30天流量"]['uv'] += $value['uv'];
                        $stat['ccarticle']["过去30天流量"]['ip'] += $value['ip'];
                        //历史最高
                        $logmax["pv"] = $this->counter->getWebstatcount("max(pv) pv,timeline", "cname='article' and c1 = '{$value['c1']}' and c2 = '{$value['c2']}' and c3 = 0", 1);
                        $logmax["uv"] = $this->counter->getWebstatcount("max(uv) uv,timeline", "cname='article' and c1 = '{$value['c1']}' and c2 = '{$value['c2']}' and c3 = 0", 1);
                        $logmax["ip"] = $this->counter->getWebstatcount("max(ip) ip,timeline", "cname='article' and c1 = '{$value['c1']}' and c2 = '{$value['c2']}' and c3 = 0", 1);
                        $stat['ccarticle']["历史最高发生在"] = $logmax;
                        break;
                    case 52:
                        $stat['fycarticle']["过去30天流量"]['pv'] += $value['pv'];
                        $stat['fycarticle']["过去30天流量"]['uv'] += $value['uv'];
                        $stat['fycarticle']["过去30天流量"]['ip'] += $value['ip'];
                        //历史最高
                        $logmax["pv"] = $this->counter->getWebstatcount("max(pv) pv,timeline", "cname='article' and c1 = '{$value['c1']}' and c2 = '{$value['c2']}' and c3 = 0", 1);
                        $logmax["uv"] = $this->counter->getWebstatcount("max(uv) uv,timeline", "cname='article' and c1 = '{$value['c1']}' and c2 = '{$value['c2']}' and c3 = 0", 1);
                        $logmax["ip"] = $this->counter->getWebstatcount("max(ip) ip,timeline", "cname='article' and c1 = '{$value['c1']}' and c2 = '{$value['c2']}' and c3 = 0", 1);
                        $stat['fycarticle']["历史最高发生在"] = $logmax;
                        break;
                    case 54:
                        $stat['xcarticle']["过去30天流量"]['pv'] += $value['pv'];
                        $stat['xcarticle']["过去30天流量"]['uv'] += $value['uv'];
                        $stat['xcarticle']["过去30天流量"]['ip'] += $value['ip'];
                        //历史最高
                        $logmax["pv"] = $this->counter->getWebstatcount("max(pv) pv,timeline", "cname='article' and c1 = '{$value['c1']}' and c2 = '{$value['c2']}' and c3 = 0", 1);
                        $logmax["uv"] = $this->counter->getWebstatcount("max(uv) uv,timeline", "cname='article' and c1 = '{$value['c1']}' and c2 = '{$value['c2']}' and c3 = 0", 1);
                        $logmax["ip"] = $this->counter->getWebstatcount("max(ip) ip,timeline", "cname='article' and c1 = '{$value['c1']}' and c2 = '{$value['c2']}' and c3 = 0", 1);
                        $stat['xcarticle']["历史最高发生在"] = $logmax;
                        break;
                    case 55:
                        $stat['xwarticle']["过去30天流量"]['pv'] += $value['pv'];
                        $stat['xwarticle']["过去30天流量"]['uv'] += $value['uv'];
                        $stat['xwarticle']["过去30天流量"]['ip'] += $value['ip'];
                        //历史最高
                        $logmax["pv"] = $this->counter->getWebstatcount("max(pv) pv,timeline", "cname='article' and c1 = '{$value['c1']}' and c2 = '{$value['c2']}' and c3 = 0", 1);
                        $logmax["uv"] = $this->counter->getWebstatcount("max(uv) uv,timeline", "cname='article' and c1 = '{$value['c1']}' and c2 = '{$value['c2']}' and c3 = 0", 1);
                        $logmax["ip"] = $this->counter->getWebstatcount("max(ip) ip,timeline", "cname='article' and c1 = '{$value['c1']}' and c2 = '{$value['c2']}' and c3 = 0", 1);
                        $stat['xwarticle']["历史最高发生在"] = $logmax;
                        break;
                    case 56:
                        $stat['csarticle']["过去30天流量"]['pv'] += $value['pv'];
                        $stat['csarticle']["过去30天流量"]['uv'] += $value['uv'];
                        $stat['csarticle']["过去30天流量"]['ip'] += $value['ip'];
                        //历史最高
                        $logmax["pv"] = $this->counter->getWebstatcount("max(pv) pv,timeline", "cname='article' and c1 = '{$value['c1']}' and c2 = '{$value['c2']}' and c3 = 0", 1);
                        $logmax["uv"] = $this->counter->getWebstatcount("max(uv) uv,timeline", "cname='article' and c1 = '{$value['c1']}' and c2 = '{$value['c2']}' and c3 = 0", 1);
                        $logmax["ip"] = $this->counter->getWebstatcount("max(ip) ip,timeline", "cname='article' and c1 = '{$value['c1']}' and c2 = '{$value['c2']}' and c3 = 0", 1);
                        $stat['csarticle']["历史最高发生在"] = $logmax;
                        break;
                    case 59:
                        $stat['dbarticle']["过去30天流量"]['pv'] += $value['pv'];
                        $stat['dbarticle']["过去30天流量"]['uv'] += $value['uv'];
                        $stat['dbarticle']["过去30天流量"]['ip'] += $value['ip'];
                        //历史最高
                        $logmax["pv"] = $this->counter->getWebstatcount("max(pv) pv,timeline", "cname='article' and c1 = '{$value['c1']}' and c2 = '{$value['c2']}' and c3 = 0", 1);
                        $logmax["uv"] = $this->counter->getWebstatcount("max(uv) uv,timeline", "cname='article' and c1 = '{$value['c1']}' and c2 = '{$value['c2']}' and c3 = 0", 1);
                        $logmax["ip"] = $this->counter->getWebstatcount("max(ip) ip,timeline", "cname='article' and c1 = '{$value['c1']}' and c2 = '{$value['c2']}' and c3 = 0", 1);
                        $stat['dbarticle']["历史最高发生在"] = $logmax;
                        break;
                    case 63:
                        $stat['hyarticle']["过去30天流量"]['pv'] += $value['pv'];
                        $stat['hyarticle']["过去30天流量"]['uv'] += $value['uv'];
                        $stat['hyarticle']["过去30天流量"]['ip'] += $value['ip'];
                        //历史最高
                        $logmax["pv"] = $this->counter->getWebstatcount("max(pv) pv,timeline", "cname='article' and c1 = '{$value['c1']}' and c2 = '{$value['c2']}' and c3 = 0", 1);
                        $logmax["uv"] = $this->counter->getWebstatcount("max(uv) uv,timeline", "cname='article' and c1 = '{$value['c1']}' and c2 = '{$value['c2']}' and c3 = 0", 1);
                        $logmax["ip"] = $this->counter->getWebstatcount("max(ip) ip,timeline", "cname='article' and c1 = '{$value['c1']}' and c2 = '{$value['c2']}' and c3 = 0", 1);
                        $stat['hyarticle']["历史最高发生在"] = $logmax;
                        break;
                    case 65:
                        $stat['lxarticle']["过去30天流量"]['pv'] += $value['pv'];
                        $stat['lxarticle']["过去30天流量"]['uv'] += $value['uv'];
                        $stat['lxarticle']["过去30天流量"]['ip'] += $value['ip'];
                        //历史最高
                        $logmax["pv"] = $this->counter->getWebstatcount("max(pv) pv,timeline", "cname='article' and c1 = '{$value['c1']}' and c2 = '{$value['c2']}' and c3 = 0", 1);
                        $logmax["uv"] = $this->counter->getWebstatcount("max(uv) uv,timeline", "cname='article' and c1 = '{$value['c1']}' and c2 = '{$value['c2']}' and c3 = 0", 1);
                        $logmax["ip"] = $this->counter->getWebstatcount("max(ip) ip,timeline", "cname='article' and c1 = '{$value['c1']}' and c2 = '{$value['c2']}' and c3 = 0", 1);
                        $stat['lxarticle']["历史最高发生在"] = $logmax;
                        break;
                }
            }
        //选车总量
        $stat['search_result']["昨日流量"] = $this->counter->getWebstatcount("SUM(pv) pv,SUM(uv) uv,SUM(ip) ip", "cname='search_result' and c1 = 1 and c2 = 0 and c3 = 0 and timeline='{$rstartdate}'", 1);
        //本周流量
        $stat['search_result']["过去7天流量"] = $this->counter->getWebstatcount("SUM(pv) pv,SUM(uv) uv,SUM(ip) ip", "cname='search_result' and c1 = 1 and c2 = 0 and c3 = 0 and timeline BETWEEN '{$rstartdate7}' AND '{$renddate}'", 1);
        //本月流量
        $stat['search_result']["过去30天流量"] = $this->counter->getWebstatcount("SUM(pv) pv,SUM(uv) uv,SUM(ip) ip", "cname='search_result' and c1 = 1 and c2 = 0 and c3 = 0 and timeline BETWEEN '{$rstartdate30}' AND '{$renddate}'", 1);
        //历史最高
        $logmax["pv"] = $this->counter->getMaxstat("pv,timeline", "cname='search_result' and c1 = 1 and c2 = 0 and c3 = 0 and pv=(select max(pv) from counter.counter where cname='search_result' and c1 = 1 and c2 = 0 and c3 = 0 )");
        $logmax["ip"] = $this->counter->getMaxstat("ip,timeline", "cname='search_result' and c1 = 1 and c2 = 0 and c3 = 0 and ip=(select max(ip) from counter.counter where cname='search_result' and c1 = 1 and c2 = 0 and c3 = 0 )");
        $logmax["uv"] = $this->counter->getMaxstat("uv,timeline", "cname='search_result' and c1 = 1 and c2 = 0 and c3 = 0 and uv=(select max(uv) from counter.counter where cname='search_result' and c1 = 1 and c2 = 0 and c3 = 0 )");
        $stat['search_result']["历史最高发生在"] = $logmax;
        //图片总量
        $stat['pic']["昨日流量"] = $this->counter->getWebstatcount("SUM(pv) pv,SUM(uv) uv,SUM(ip) ip", "cname='pic' and c1 = 1 and c2 = 0 and c3 = 0 and timeline='{$rstartdate}'", 1);
        //本周流量
        $stat['pic']["过去7天流量"] = $this->counter->getWebstatcount("SUM(pv) pv,SUM(uv) uv,SUM(ip) ip", "cname='pic' and c1 = 1 and c2 = 0 and c3 = 0 and timeline BETWEEN '{$rstartdate7}' AND '{$renddate}'", 1);
        //本月流量
        $stat['pic']["过去30天流量"] = $this->counter->getWebstatcount("SUM(pv) pv,SUM(uv) uv,SUM(ip) ip", "cname='pic' and c1 = 1 and c2 = 0 and c3 = 0 and timeline BETWEEN '{$rstartdate30}' AND '{$renddate}'", 1);
        //历史最高
        $logmax["pv"] = $this->counter->getMaxstat("pv,timeline", "cname='pic' and c1 = 1 and c2 = 0 and c3 = 0 and pv=(select max(pv) from counter.counter where cname='pic' and c1 = 1 and c2 = 0 and c3 = 0 )");
        $logmax["ip"] = $this->counter->getMaxstat("ip,timeline", "cname='pic' and c1 = 1 and c2 = 0 and c3 = 0 and ip=(select max(ip) from counter.counter where cname='pic' and c1 = 1 and c2 = 0 and c3 = 0 )");
        $logmax["uv"] = $this->counter->getMaxstat("uv,timeline", "cname='pic' and c1 = 1 and c2 = 0 and c3 = 0 and uv=(select max(uv) from counter.counter where cname='pic' and c1 = 1 and c2 = 0 and c3 = 0 )");
        $stat['pic']["历史最高发生在"] = $logmax;

        // 取得列的列表
        if ($stat)
            foreach ($stat as $key => $row) {
                if ($key !== 'huodong') {
                    foreach ($row as $k => $v) {
                        if ($k !== '历史最高发生在') {
                            $stat['huodong'][$k]['pv'] += $v['pv'] * 0.6;
                            $stat['huodong'][$k]['uv'] += $v['uv'] * 0.6;
                            $stat['huodong'][$k]['ip'] += $v['ip'] * 0.6;
                        }
                    }
                }
//                
//                $volume[$key] = $row['pv'];
//                $edition[$key] = $row['uv'];
            }
//        if ($volume['zongliang'] && $edition['zongliang']) {
//            array_multisort($volume, SORT_DESC, $edition, SORT_DESC, $array);
//        }

        $this->tpl->assign('stat', $stat);
        $this->tpl->assign('pagetype', $this->pagetype);
        $this->tpl->assign('page_title', $this->page_title);
        $this->template();
    }

    /*     * **********************************************分割线************************************************** */

    //网站流量趋势图
    function doSearchStatPic() {
        $this->tpl_file = "webstat_searchstatpic";
        $this->page_title = "趋势图统计搜索";
        if ($_POST["search"]) {
            $c1 = $_POST["pagetype"];
            $ip = "IP";
            //构造XML输出
            $xmlheader = "<?xml version='1.0' encoding='GBK'?>";
            $xmlpvchart = "<chart caption='PV' subCaption=' ' showValues='1' formatNumberScale='0'>";
            $xmluvchart = "<chart caption='UV' subCaption=' ' showValues='1' formatNumberScale='0'>";
            $xmlipchart = "<chart caption='$ip' subCaption=' ' showValues='1' formatNumberScale='0'>";
            $xmlpvdataset = "<dataset seriesName='PV' color='1D8BD1' anchorBorderColor='1D8BD1' anchorBgColor='1D8BD1'>";
            $xmluvdataset = "<dataset seriesName='UV' color='1D8BD1' anchorBorderColor='1D8BD1' anchorBgColor='1D8BD1'>";
            $xmlipdataset = "<dataset seriesName='$ip' color='1D8BD1' anchorBorderColor='1D8BD1' anchorBgColor='1D8BD1'>";
            $xmlcategories = "<categories>";
            $startdate = strtotime($_POST["startdate"]);
            $enddate = strtotime($_POST["enddate"]);
            $rstartdate = $startdate > $enddate ? $enddate : $startdate;
            $renddate = $startdate > $enddate ? $startdate : $enddate;
            $log = $this->counter->getWebstat("*", "c1='$c1' and timeline >='$rstartdate' and timeline <='$renddate'", 1, 2);
            
            if ($_POST["order"] != "day") {
                if ($_POST["order"] == "week") {
                    $date = "Y年W周";
                } else if ($_POST["order"] == "month") {
                    $date = "Y年m月";
                }
                //循环累加
                $prevtime = "";
                $timearr = array();
                $pv = $uv = $ip = 0;
                foreach ($log as $key => $value) {
                    $datetmp = date($date, $value["time"]);
                    $timearr[$datetmp]["pv"] += $value["pv"];
                    $timearr[$datetmp]["uv"] += $value["uv"];
                    $timearr[$datetmp]["ip"] += $value["ip"];
                }
                foreach ($timearr as $k => $v) {
                    $xmlcategories .= "<category label='$k' />";
                    $xmlpvdataset .= "<set value='" . $v["pv"] . "' />";
                    $xmluvdataset .= "<set value='" . $v["uv"] . "' />";
                    $xmlipdataset .= "<set value='" . $v["ip"] . "' />";
                }
            } else {
                //按天计算
                foreach ($log as $key => $value) {
                    $datetmp = date("Y/m/d", $value["time"]);
                    $xmlcategories .= "<category label='$datetmp' />";
                    $xmlpvdataset .= "<set value='" . $value["pv"] . "' />";
                    $xmluvdataset .= "<set value='" . $value["uv"] . "' />";
                    $xmlipdataset .= "<set value='" . $value["ip"] . "' />";
                }
            }

            //拼接成完整的xml 字符串
            $xmlpv = $xmlheader . $xmlpvchart . $xmlcategories . "</categories>" . $xmlpvdataset . "</dataset></chart>";
            $xmluv = $xmlheader . $xmluvchart . $xmlcategories . "</categories>" . $xmluvdataset . "</dataset></chart>";
            $xmlip = $xmlheader . $xmlipchart . $xmlcategories . "</categories>" . $xmlipdataset . "</dataset></chart>";

            $this->tpl->assign('xmlpv', $xmlpv);
            $this->tpl->assign('xmluv', $xmluv);
            $this->tpl->assign('xmlip', $xmlip);
            $this->tpl->assign('c1', $c1);
            $this->tpl->assign('stime', date("Y-m-d", $rstartdate));
            $this->tpl->assign('etime', date("Y-m-d", $renddate));
            $this->tpl->assign('order', $_POST["order"]);
        }

        $this->tpl->assign('pagetype', $this->pagetype);
        $this->tpl->assign('page_title', $this->page_title);
        $this->template();
    }

//
//    function doWebdetail() {
//        $this->checkAuth();
//        $this->tpl_file = "webstat_detail";
//        $this->page_title = "网站流量统计";
//        if ($_POST["search"] || $_GET["type"]) {
//            $s = $_POST["startdate"];
//            $e = $_POST["enddate"];
//            $type = $_POST["type"] ? $_POST["type"] : $_GET["type"];
//            $startdate = $s ? strtotime($s) : $_GET["startdate"];
//            $enddate = $e ? strtotime($e) : $_GET["enddate"];
//            $rstartdate = $startdate > $enddate ? $enddate : $startdate;
//            $this->tpl->assign('startdate', date("Y-m-d", $rstartdate));
//            $renddate = $startdate > $enddate ? $startdate : $enddate;
//            $this->tpl->assign('enddate', date("Y-m-d", $renddate));
//            $extra = "webdetail&type=$type&startdate=$rstartdate&enddate=$renddate";
//            $page = $_GET['page'];
//            $page = max(1, $page);
//            $page_size = 20;
//            $page_start = ($page - 1) * $page_size;
//
//            if ($type == "count") {
//                $where = "1 and '$rstartdate' < created AND created < '$renddate'";
//            } else {
//                $where = "1 and c1='$type' and '$rstartdate' < created AND created < '$renddate'";
//            }
//
//            $statlist = $this->counter->getCounterbytype($where, array(), $page_size, $page_start);
////            print_r($this->counter->sql);exit;
//            $page_bar = $this->multi($this->counter->total, $page_size, $page, $_ENV['PHP_SELF'] . $extra, 0, 4);
//            $this->tpl->assign('page_bar', $page_bar);
//            $this->tpl->assign('type', $type);
//            $this->tpl->assign('statlist', $statlist);
//        }
//        $this->tpl->assign('pagetype', $this->pagetype);
//        $this->tpl->assign('page_title', $this->page_title);
//        $this->template();
//    }
//
//
    //查看过去30天 流量走势图
    function doStatPic() {
        $this->checkAuth();

        $this->tpl_file = "webstat_pic";

        $c1 = $_GET['c1'];
        if (empty($this->pagetype[$c1])) {
            exit;
        }
        $this->page_title = $this->pagetype[$c1] . "趋势图统计";

        //获取过去30天 浏览量
//        $yestory = strtotime(date("Y-m-d",strtotime("-1 day")));//昨天
        //构造XML输出
        $xmlheader = "<?xml version='1.0' encoding='GBK'?>";
        $xmlpvchart = "<chart caption='PV' subCaption=' ' showValues='1' formatNumberScale='0'>";
        $xmluvchart = "<chart caption='UV' subCaption=' ' showValues='1' formatNumberScale='0'>";
        $xmlipchart = "<chart caption='IP' subCaption=' ' showValues='1' formatNumberScale='0'>";

        $xmlpvdataset = "<dataset seriesName='PV' color='1D8BD1' anchorBorderColor='1D8BD1' anchorBgColor='1D8BD1'>";
        $xmluvdataset = "<dataset seriesName='UV' color='1D8BD1' anchorBorderColor='1D8BD1' anchorBgColor='1D8BD1'>";
        $xmlipdataset = "<dataset seriesName='IP' color='1D8BD1' anchorBorderColor='1D8BD1' anchorBgColor='1D8BD1'>";

        $xmlcategories = "<categories>";

        for ($index = 30; $index > 0; $index--) {
            $day = date("Y/m/d", strtotime("-$index day"));
            $time = strtotime($day);
            $log = $this->counter_log->getWebstat("*", "c1='$c1' and time='$time'");

            $xmlcategories .= "<category label='$day' />";

            $xmlpvdataset .= "<set value='" . ($log["pv"] ? $log["pv"] : 0) . "' />";
            $xmluvdataset .= "<set value='" . ($log["uv"] ? $log["uv"] : 0) . "' />";
            $xmlipdataset .= "<set value='" . ($log["ip"] ? $log["ip"] : 0) . "' />";
        }

        //拼接成完整的xml 字符串
        $xmlpv = $xmlheader . $xmlpvchart . $xmlcategories . "</categories>" . $xmlpvdataset . "</dataset></chart>";
        $xmluv = $xmlheader . $xmluvchart . $xmlcategories . "</categories>" . $xmluvdataset . "</dataset></chart>";
        $xmlip = $xmlheader . $xmlipchart . $xmlcategories . "</categories>" . $xmlipdataset . "</dataset></chart>";

        $this->tpl->assign('xmlpv', $xmlpv);
        $this->tpl->assign('xmluv', $xmluv);
        $this->tpl->assign('xmlip', $xmlip);

        $this->tpl->assign('c1', $c1);
        $this->tpl->assign('pagetype', $this->pagetype);

        $this->tpl->assign('page_title', $this->page_title);
        $this->template();
    }

    function doYStatCount() {
        $_GET['tr'] = 1;
        $this->doStatCount();
    }

    function doYStatRegUser() {
        $_GET['tr'] = 1;
        $this->doStatRegUser();
    }

    function doYAllStat() {
        $_GET['tr'] = 1;
        $this->doAllstat();
    }

    function doYAllRegStat() {
        $_GET['tr'] = 1;
        $this->doAllRegStat();
    }

    /*
     * 统计每天注册用户量
     * $day 默认null 统计昨天的注册用户量
     */

    function doStatRegUser($day = null) {
        $this->checkAuth('sys_module', 1);
        if ($_GET['tr']) {
            $this->counter->tr = true;
            $countlog = "counterlogs";
        } else {
            $countlog = "counter_log";
        }
        //默认统计昨天的注册用户量
        $tmp = $day ? $day : date("Y-m-d", strtotime("-1 day"));
        $rstartdate = strtotime($tmp);               //昨天 0点整
        $renddate = strtotime($tmp . " 23:59:59");     //昨天 23:59:59

        $ufields = array();
        $ufields['c1'] = "user";
        $num = $this->users->getCount("1 and '$rstartdate' <= created AND created <= '$renddate'");
        $ufields['ip'] = $num;
        $ufields['time'] = $rstartdate;

        //判断是否已经统计了
        $log = $this->$countlog->getWebstat("count(id) as count", "c1='user' and time='$rstartdate'");
        $this->$countlog->ufields = $ufields;
        if ($log['count'] > 0) {
            $this->$countlog->where = "c1='user' and time='$rstartdate'";
            $ret = $this->$countlog->update();
        } else {
            $ret = $this->counter_log->insert();
        }
    }

    //循环统计所有注册用户
    function doAllRegStat() {
        $this->checkAuth('sys_module', 1);
        //获取counter表最小的 时间
        $this->users->fields = "min(created)";
        $this->users->where = "created<>0";
        $mintime = $this->users->getResult(3);

        $mintime = strtotime(date("Y-m-d", $mintime));
        $yestory = strtotime(date("Y-m-d", strtotime("-1 day"))); //昨天

        for ($index = $mintime; $index <= $yestory; $index+=86400) {
            $day = date('Y-m-d', $index);
            $this->doStatRegUser($day);
        }
        exit("完成!");
    }

    function doZcn() {
        $this->checkAuth('sys_module', 1);

        if (0) {
            $start = mktime(0, 0, 0, 6, 6, 2013);
            $end = mktime(0, 0, 0, 6, 16, 2013);
            for ($i = $start; $i < $end; $i = $i + 86400) {
                $set_date = date('Y/m/d', $i);
                echo $set_date . "<br>\n";
                $this->counter_log->zcnCount(
                        "{$set_date}", 6
                );
            }
        } else {
            $this->counter_log->zcnCount(
                    0, 10
            );
        }
    }

}

?>
