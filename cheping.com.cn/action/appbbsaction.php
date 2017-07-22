<?php

import('dcrypt.class', 'lib');

class appbbsAction extends action {

    public $bbsforum;
    public $bbspost;
    public $bbsthread;
    public $bbshistory;
    public $users;
    public $article;
    public $counter;

    function __construct() {
        parent::__construct();
        $this->bbsforum = new bbsforum();
        $this->bbspost = new bbspost();
        $this->bbsthread = new bbsthread();
        $this->bbshistory = new bbshistory();
        $this->users = new users();
        $this->article = new article();
        $this->counter = new counter();
    }

    function doDefault() {
        $this->doAppBbs();
    }

    function doAppBbs() {
        $page = dcrypt::privDecrypt($_GET['page']);
        $page = max(1, $page);
        $page_size = 20;
        $page_start = ($page - 1) * $page_size;
        //24小时热帖子
        $list = $this->bbspost->getEven('cp.pid,cp.fid,cp.tid,ct.name,cp.subject,cp.comment,cp.rate', "cp.first in(0,1) and cp.status = 0 and cp.fid = cf.fid and cp.tid = ct.tid and ct.fid = cf.fid", $page_size, $page_start, 'cp.rate desc', 2);
        if ($list[0]['pid']) {
            $output = array('code' => 1, 'mes' => '获取成功', 'list' => $list);
            exit(json_encode($output));
        } else {
            $output = array('code' => -1, 'mes' => '获取失败请检查您的网络');
            exit(json_encode($output));
        }
    }

    //获取首页导航
    function dobbsdh() {
        $bbsdh = $this->bbsforum->getSelect('fid,name', "fup = 0 and type = 'forum' and status = 1 order by displayorder asc", 2);
        if ($bbsdh[0]['fid']) {
            $output = array('code' => 1, 'mes' => '导航列表', 'list' => $bbsdh);
            exit(json_encode($output));
        } else {
            $output = array('code' => -1, 'mes' => '导航列表获取失败请检查您的网络');
            exit(json_encode($output));
        }
    }

    //精选列表
    function dobbschoice() {
        global $local_host;
        $page = dcrypt::privDecrypt($_GET['page']);
        $page = max(1, $page);
        $page_size = 20;
        $page_start = ($page - 1) * $page_size;

        $bbschoice = $this->bbspost->getEven('cp.pid,cp.fid,cp.tid,cp.firstpic,cp.firstdate,cp.firsttitle,cp.subject,cp.popularize,ct.name,cp.comment', "cp.first = 1 and cp.status = 0 and cp.fid = ct.fid and cp.tid = ct.tid", $page_size, $page_start, '', 2);
        if ($bbschoice[0]['pid']) {
            foreach ($bbschoice as $key => $value) {
                $bbschoice[$key]['firstpic'] = $local_host . UPLOAD_DIR . $value['firstpic'];
                $bbschoice[$key]['firstdate'] = date('Y-m-d', $value['firstdate']);
            }
            $output = array('code' => 1, 'mes' => '精选列表', 'list' => $bbschoice);
            exit(json_encode($output));
        } else {
            $output = array('code' => -1, 'mes' => '精选列表获取失败请检查您的网络,或数据加载完成');
            exit(json_encode($output));
        }
    }

    //同步历史阅读
    function doHistory() {
        $user_all = dcrypt::privDecrypt($_GET['parse']);
        $parse_query = parseQuery($user_all);
        $user = $parse_query["name"];
        $pwd = $parse_query["password"];
        $uid = $this->users->verifyUser($user, $pwd);
        switch ($uid) {
            case -1:
                $output = array('code' => -1, 'mes' => '用户名不能为空');
                echo json_encode($output);
                break;
            case -2:
                $output = array('code' => -2, 'mes' => '密码不能为空');
                echo json_encode($output);
                break;
            case 0:
                $output = array('code' => 0, 'mes' => '该用户不存在');
                echo json_encode($output);
                break;
            default:
                if ($uid) {
                    $data['uid'] = $uid;
                    $array = $_POST['arr'];
                    $arr = json_decode($array,true);
                    if (is_array($arr)) {
                        foreach ($arr as $key => $value) {
                            if ($value) {
                                foreach ($value as $k => $v) {
                                    $data['aid'] = $v['aid'];
                                    $data['title'] = $this->article->getSelect('title', "state = 3 and id = '{$v['aid']}'", 3);
                                    $data['type'] = $v['type'];
                                    $data['url'] = $v['url'];
                                    $data['created'] = strtotime($v['created']);
                                    $res = $this->bbshistory->getAdd($data);
                                }
                            }
                        }
                        if ($res) {
                            $output = array('code' => 1, 'mes' => '同步成功');
                            echo json_encode($output);
                        } else {
                            $output = array('code' => -3, 'mes' => '同步失败');
                            echo json_encode($output);
                        }
                    }
                }
        }
    }

    //最新发布
    function doLatestrelease() {
        $user_all = dcrypt::privDecrypt($_GET['parse']);
        $parse_query = parseQuery($user_all);
        $time = $parse_query["time"];
        $fid = $parse_query["fid"];
        $page = $parse_query["page"];
        $page = max(1, $page);
        $page_size = 20;
        $page_start = ($page - 1) * $page_size;
        if ($time == 1) {//精华
            $release = $this->bbspost->getEven('cp.pid,cp.fid,cp.tid,cp.subject,cp.comment,cp.authority,cp.toppost,cp.digest,cp.dateline', "cp.first in('0,1') and cp.status = 0 and cp.fid = ct.fid and cp.tid = ct.tid and cp.gid = 0 and cp.fid = '{$fid}'", $page_size, $page_start, 'toppost desc, digest desc', 2);
        } else if ($time == 2) {//最新
            $release = $this->bbspost->getEven('cp.pid,cp.fid,cp.tid,cp.subject,cp.comment,cp.authority,cp.toppost,cp.digest,cp.dateline', "cp.first in('0,1') and cp.status = 0 and cp.fid = ct.fid and cp.tid = ct.tid and cp.gid = 0 and cp.fid = '{$fid}'", $page_size, $page_start, 'dateline desc,toppost desc, digest desc', 2);
        } else {
            $release = $this->bbspost->getEven('cp.pid,cp.fid,cp.tid,cp.subject,cp.comment,cp.authority,cp.toppost,cp.digest,cp.dateline', "cp.first in('0,1') and cp.status = 0 and cp.fid = ct.fid and cp.tid = ct.tid and cp.gid = 0 and cp.fid = '{$fid}'", $page_size, $page_start, 'dateline desc,toppost desc, digest desc', 2);
        }
        if ($release[0]['pid']) {//format_date
            foreach ($release as $key => $value) {
                $release[$key]['dateline'] = $this->bbspost->getEvens('cp.dateline', "cp.first = 2 and cp.status = 0 and cp.fid = ct.fid and cp.tid = ct.tid and cp.gid = '{$value['pid']}'", 'dateline desc', 3);
                if ($release[$key]['dateline']) {
                    $release[$key]['time'] = format_date($this->bbspost->getEvens('cp.dateline', "cp.first = 2 and cp.status = 0 and cp.fid = ct.fid and cp.tid = ct.tid and cp.gid = '{$value['pid']}'", 'dateline desc', 3));
                } else {
                    $release[$key]['time'] = date('Y-m-d', $value['dateline']);
                }
            }
            if ($time == 3) {//回复
                // 取得列的列表
                foreach ($release as $k => $row) {
                    $volume[$k] = $row['dateline'];
                }
                array_multisort($volume, SORT_DESC, $release);
            }
            $output = array('code' => 1, 'mes' => '最新发布', 'list' => $release, 'count' => $this->bbspost->total);
            exit(json_encode($output));
        } else {
            $output = array('code' => -1, 'mes' => '最新发布获取失败请检查您的网络,或数据加载完成');
            exit(json_encode($output));
        }
    }

}
