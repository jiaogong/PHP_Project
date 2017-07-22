<?php

import('dcrypt.class', 'lib');

class bbspostAction extends action {

    public $bbsforum;
    public $bbspost;
    public $bbsthread;
    public $bbshistory;
    public $users;
    public $users_profiles;
    public $collect;
    public $counter;

    function __construct() {
        parent::__construct();
        $this->bbsforum = new bbsforum();
        $this->bbspost = new bbspost();
        $this->bbsthread = new bbsthread();
        $this->bbshistory = new bbshistory();
        $this->users = new users();
        $this->users_profiles = new users_profiles();
        $this->collect = new collect();
        $this->counter = new counter();
    }

    function doDefault() {
        $this->doPost();
    }

    //帖子发布
    function doPost() {
        global $local_host;
        $user_all = dcrypt::privDecrypt($_GET['parse']);
        $parse_query = parseQuery($user_all);
        $user = $parse_query["name"];
        $pwd = $parse_query["password"];
        $fid = $parse_query["fid"];
        $pid = $parse_query["pid"];
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
                    $users = $this->users->getUser('id,username,realname', "id = '{$uid}'", 1);
                    //$data['tid'] = dcrypt::privDecrypt($_POST['tid']);
                    $data['fid'] = $fid;
                    $data['tid'] = $_POST['tid'];
                    $data['firstauthor'] = $users['username'];
                    $data['firstauthorid'] = $uid;
                    $data['author'] = $users['username'];
                    $data['authorid'] = $uid;
                    $data['subject'] = $_POST['title'];
                    $data['dateline'] = time();
                    $data['`update`'] = time();
                    $data['message'] = $_POST['message'];
                    $data['usegps'] = $_POST['usegps'];
                    $rest = $this->bbspost->getSelect('pid', "status = 0 and first in(0,1) and pid = '{$pid}'", 3);
                    if($rest){
                        $res = $this->bbspost->getUpdate($data,"status = 0 and first in(0,1) and pid = '{$pid}'");
                    }else{
                        $res = $this->bbspost->getAdd($data);
                    }
                    if ($res) {
                        $form = $this->bbsforum->getSelect('fid,posts', "status = 1 and type = 'forum' and fid = '{$fid}'", 1);
                        if($form){
                            $this->bbsforum->getUpdate(array('posts' => $form['posts'] + 1), "status = 1 and type = 'forum' and fid = '{$fid}'");
                        }
                        $output = array('code' => 1, 'mes' => '发布成功');
                        echo json_encode($output);
                    } else {
                        $output = array('code' => -3, 'mes' => '发布失败');
                        echo json_encode($output);
                    }
                }
        }
    }

    //获取主题
    function doThread() {
        $fid = dcrypt::privDecrypt($_GET['fid']);
        $bbsthread = $this->bbsthread->getSelect('tid,name', "fid = '{$fid}' and status = 0", 2);
        if ($bbsthread[0]['tid']) {
            $output = array('code' => 1, 'mes' => '主题', 'list' => $bbsthread);
            exit(json_encode($output));
        } else {
            $output = array('code' => -1, 'mes' => '主题获取失败请检查您的网络');
            exit(json_encode($output));
        }
    }

    //发帖获取历史阅读
    function doHistory() {
        $type = dcrypt::privDecrypt($_GET['type']);
        $rstartdate30 = strtotime(date("Y-m-d", strtotime("-30 day")));
        $renddate = strtotime(date("Y-m-d", time()));
        $history = $this->bbshistory->getSelect('title,url', "created BETWEEN '{$rstartdate30}' AND '{$renddate}' group by aid", 2);
        if ($history[0]['id']) {
            $output = array('code' => 1, 'mes' => '历史纪录', 'list' => $history);
            exit(json_encode($output));
        } else {
            $output = array('code' => -1, 'mes' => '历史纪录获取失败请检查您的网络');
            exit(json_encode($output));
        }
    }

    //帖子详情
    function doPostf() {
        global $local_host;
        $template_name = "bbspostf";
        $pid = dcrypt::privDecrypt($_GET['pid']);
        $res = $this->bbspost->getEvena('cp.pid,cp.subject,cp.authority,cp.digest,cp.toppost,cp.dateline,cp.message,cp.authorid,cp.author,ct.name,cp.tid,cp.fid,cp.usegps,cp.rate', "ct.fid = cf.fid and cp.first in(0,1) and cp.status = 0 and cp.fid = ct.fid and cp.tid = ct.tid and cp.gid = 0 and cp.authorid = cu.id and cp.pid = '{$pid}'",'', 1);
        if ($res['pid']) {
            $arr = $this->users_profiles->getUser('avatar', "uid = '{$res['authorid']}'", 3);
            if ($arr) {
                $res['avatars'] = $local_host . UPLOAD_DIR . $arr;
            } else {
                $res['avatars'] = '/images/user.png';
            }
            $useragent = util::getUserAgent($_SERVER['HTTP_USER_AGENT']);
            $buid = str_replace(array('+', '=', '/', ' '), array('', '', '', ''), addslashes($_COOKIE['buid']));
            $df = trim(addslashes($_GET['df']));
            $referer = $_SERVER['HTTP_REFERER'];
            $data = array(
                'cname' => 'bbspost',
                'c1' => $pid,
                'c2' => 0,
                'c3' => 0,
                'ip' => util::getip(),
                'os' => $useragent['os'],
                'browser' => $useragent['browser'],
                'browserver' => $useragent['browserver'],
                'referer' => $df ? $df : $referer,
                'timeline' => time(),
                'sid' => $buid,
            );
            $this->counter->addCounter($data);
            $this->bbspost->getUpdate(array('rate' => $res['rate'] + 1),"status = 0 and first in('0,1') and pid = '{$res['pid']}'");
            $this->vars("list", $res);
            $this->template($template_name, '', 'replaceArticleUrl');
        } else {
            $output = array('code' => -1, 'mes' => '数据为空');
            exit(json_encode($output));
        }
    }

    //收藏帖子
    function dobbscollect() {
        $user_all = dcrypt::privDecrypt($_GET['parse']);
        $parse_query = parseQuery($user_all);
        $user = $parse_query["name"];
        $pwd = $parse_query["password"];
        $pid = $parse_query["pid"];
        $state = $parse_query["state"];
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
                    $users = $this->users->getUser('id,username,realname', "id = '{$uid}'", 1);
                    $arr = $this->collect->getList('id', "uid = '{$uid}' and article_id = '{$pid}' and category_id = null and type_id = 3", 1);
                    if ($arr['id']) {
                        if ($state == 1) {
                            $res = $this->collect->updateCpllect(array('state' => $state, 'updated' => time()), "id = '{$arr['id']}' and type_id = 3");
                            $mes = '收藏';
                        } else {
                            $res = $this->collect->updateCpllect(array('state' => $state, 'updated' => time()), "id = '{$arr['id']}' and type_id = 3");
                            $mes = '取消收藏';
                        }
                    } else {
                        if ($state == 1) {
                            $res = $this->collect->getAdd(array('uid' => $uid, 'uname' => $users['username'], 'article_id' => $pid, 'type_id' => 3, 'state' => $state, 'created' => time(), 'updated' => time()));
                            $mes = '收藏';
                        } else {
                            $res = $this->collect->getAdd(array('uid' => $uid, 'uname' => $users['username'], 'article_id' => $pid, 'type_id' => 3, 'state' => $state, 'created' => time(), 'updated' => time()));
                            $mes = '取消收藏';
                        }
                    }
                    if ($res) {
                        $output = array('code' => 1, 'mes' => $mes . '成功');
                        echo json_encode($output);
                    } else {
                        $output = array('code' => -3, 'mes' => $mes . '失败');
                        echo json_encode($output);
                    }
                }
        }
    }

    //回复列表
    function doComment() {
        global $local_host;
        $user_all = dcrypt::privDecrypt($_GET['parse']);
        $parse_query = parseQuery($user_all);
        $pid = $parse_query["pid"];
        $page = $parse_query["page"];
        $page = max(1, $page);
        $page_size = 20;
        $page_start = ($page - 1) * $page_size;
        $list = $this->bbspost->getEvena('cp.author,cp.authorid,cp.pid,cp.fid,cp.tid,cp.message,cp.rate,cp.dateline', "cp.first = 2 and cp.status = 0 and cp.fid = ct.fid and cp.tid = ct.tid and cp.gid = '{$pid}' and ct.fid = cf.fid and cp.authorid = cu.id", 'cp.dateline desc', 2);
        if ($list[0]['pid']) {
            foreach ($list as $key => $value) {
                $arr = $this->users_profiles->getUser('avatar', "uid = '{$value['authorid']}'", 3);
                if ($arr) {
                    $value['avatars'] = $local_host . UPLOAD_DIR . $arr;
                } else {
                    $value['avatars'] = 1;
                }
                $value['dateline'] = date('Y-m-d',$value['dateline']);
                $chaild = $this->bbspost->getEvens('cp.author,cp.authorid,cp.pid,cp.fid,cp.tid,cp.message,cp.subject,cp.rate,cp.dateline', "cp.first = 2 and cp.status = 0 and cp.fid = ct.fid and cp.tid = ct.tid and cp.gid = '{$pid}' and cp.comment = '{$value['pid']}' ", 'cp.dateline asc', 2);
                if($chaild[0]['pid']){
                    foreach ($chaild as $k => $v) {
                        if($k == 0){
                            $value['state'] = 1;
                            $v['dateline'] = date('Y-m-d',$v['dateline']);
                            $sst = $value;
                            $sst['chaild'] = $v;
                            $array[] = $sst;
                        }else{
                            $v['state'] = 1;
                            $v['dateline'] = date('Y-m-d',$v['dateline']);
                            $arrs = $this->users_profiles->getUser('avatar', "uid = '{$v['authorid']}'", 3);
                            if ($arrs) {
                                $v['avatars'] = $local_host . UPLOAD_DIR . $arrs;
                            } else {
                                $v['avatars'] = 1;
                            }
                            $v['chaild'] = $value;
                            $array[] = $v;
                        }
                    }
                }else{
                    $value['state'] = 0;
                    $array[] = $value;
                }
            }
            //计算总记录条数
            $num = count($array);
            //计算页数
            $pages = ceil($num / $page_size);

            if (is_numeric($page)) {
                if ($page > $pages) {
                    $output = array('code' => -2, 'mes' => '没有数据了');
                    exit(json_encode($output));
                } else {
                    $newarr = array_slice($array, $page_start, $page_size);
                    if (!$newarr) {
                        $output = array('code' => -1, 'mes' => '获取内容失败');
                        exit(json_encode($output));
                    }else{
                        $output = array('code' => 1, 'mes' => '列表获取成功', 'list' => $newarr,'count' => $num);
                        echo json_encode($output);
                    }
                }
            }  
        } else {
            $output = array('code' => -1, 'mes' => '列表获取失败或数据加载完成');
            echo json_encode($output);
        }
    }

    //提交回复
    function doRcomment() {
        $user_all = dcrypt::privDecrypt($_GET['parse']);
        $parse_query = parseQuery($user_all);
        $user = $parse_query["name"];
        $pwd = $parse_query["password"];
        $pid = $parse_query["pid"];
        $apid = $parse_query["apid"];
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
                    $users = $this->users->getUser('id,username,realname', "id = '{$uid}'", 1);
                    $data['fid'] = dcrypt::privDecrypt($_POST['fid']);
                    $data['tid'] = dcrypt::privDecrypt($_POST['tid']);
                    $data['first'] = 2;
                    $data['author'] = $users['username'];
                    $data['authorid'] = $users['id'];
                    $data['message'] = dcrypt::privDecrypt($_POST['message']);
                    $data['dateline'] = time();
                    if($pid){
                        $data['comment'] = $pid;
                    }else{
                        $data['comment'] = $apid;
                    }
                    
                    $data['gid'] = $apid;
                    $res = $this->bbspost->getAdd($data);
                    if ($res) {
                        $att = $this->bbspost->getSelect('comment', "first in('0,1') and pid = '{$pid}' and status = 0", 3);
                        $this->bbspost->getUpdate(array('comment' => $att + 1), "first in('0,1') and pid = '{$pid}' and status = 0");
                        $output = array('code' => 1, 'mes' => '回复成功');
                        echo json_encode($output);
                    } else {
                        $output = array('code' => -3, 'mes' => '回复失败');
                        echo json_encode($output);
                    }
                }
        }
    }

    //回复点赞
    function doDcomment() {
        $user_all = dcrypt::privDecrypt($_GET['parse']);
        $parse_query = parseQuery($user_all);
        $user = $parse_query["name"];
        $pwd = $parse_query["password"];
        $pid = $parse_query["pid"];
        $state = $parse_query["state"];
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
                    $arr = $this->bbspost->getSelect('*', "pid = '{$pid}' and first = 2 and status = 0", 1);
                    if ($arr['pid']) {
                        if ($state == 1) {
                            $res = $this->bbspost->getUpdate(array('rate' => $arr['rate'] + 1), "pid = '{$pid}' and first = 2 and status = 0");
                            if ($res) {
                                $output = array('code' => 1, 'mes' => '成功');
                                echo json_encode($output);
                            } else {
                                $output = array('code' => -3, 'mes' => '失败');
                                echo json_encode($output);
                            }
                        } else {
                            $res = $this->bbspost->getUpdate(array('rate' => $arr['rate'] - 1), "pid = '{$pid}' and first = 2 and status = 0");
                            if ($res) {
                                $output = array('code' => 1, 'mes' => '成功');
                                echo json_encode($output);
                            } else {
                                $output = array('code' => -3, 'mes' => '失败');
                                echo json_encode($output);
                            }
                        }
                    } else {
                        $output = array('code' => -4, 'mes' => '数据不存在');
                        echo json_encode($output);
                    }
                }
        }
    }

    //提交举报
    function doJcomment() {
        $user_all = dcrypt::privDecrypt($_GET['parse']);
        $parse_query = parseQuery($user_all);
        $user = $parse_query["name"];
        $pwd = $parse_query["password"];
        $pid = $parse_query["pid"];
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
                    $users = $this->users->getUser('id,username,realname', "id = '{$uid}'", 1);
                    $data['fid'] = dcrypt::privDecrypt($_POST['fid']);
                    $data['tid'] = dcrypt::privDecrypt($_POST['tid']);
                    $data['first'] = 3;
                    $data['author'] = $users['username'];
                    $data['authorid'] = $users['id'];
                    $data['message'] = dcrypt::privDecrypt($_POST['message']);
                    $data['dateline'] = time();
                    $data['comment'] = $pid;
                    $res = $this->bbspost->getAdd($data);
                    if ($res) {
                        $output = array('code' => 1, 'mes' => '成功');
                        echo json_encode($output);
                    } else {
                        $output = array('code' => -3, 'mes' => '失败');
                        echo json_encode($output);
                    }
                }
        }
    }

}
