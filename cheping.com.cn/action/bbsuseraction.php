<?php

import('dcrypt.class', 'lib');

class bbsuserAction extends action {

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
        $this->doBbsUser();
    }

    function doBbsUser() {
        $user_all = dcrypt::privDecrypt($_GET['parse']);
        $parse_query = parseQuery($user_all);
        $userid = $parse_query["uid"];
        $page = $parse_query["page"];
        $page = max(1, $page);
        $page_size = 20;
        $page_start = ($page - 1) * $page_size;

        $users = $this->users->getUser('id,username,realname,created', "id = '{$userid}'", 1);
        if ($users['id']) {
            $arr = $this->users_profiles->getUser('avatar', "uid = '{$users['id']}'", 3);
            if ($arr) {
                $users['avatars'] = $local_host . UPLOAD_DIR . $arr;
            } else {
                $users['avatars'] = 1;
            }
            $users['daily'] = $this->bbspost->getEven('cp.pid,cp.fid,cp.tid,cp.subject', "cp.fid = ct.fid and cp.tid = ct.tid and cp.status = 0 and cp.first in('1,2') and cp.authorid = '{$userid}' and cp.author = '{$users['username']}'", $page_size, $page_start, 'dateline desc', 2);
            if ($users['daily']) {
                $output = array('code' => 1, 'mes' => '获取成功', 'list' => $users);
                echo json_encode($output);
            } else {
                $output = array('code' => -1, 'mes' => '列表获取失败或没有数据', 'list' => $users);
                echo json_encode($output);
            }
        }
    }

    function doMypost() {
        $user_all = dcrypt::privDecrypt($_GET['parse']);
        $parse_query = parseQuery($user_all);
        $user = $parse_query["name"];
        $pwd = $parse_query["password"];
        $page = $parse_query["page"];
        $page = max(1, $page);
        $page_size = 20;
        $page_start = ($page - 1) * $page_size;
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
                    $users = $this->users->getUser('id,username,realname,created', "id = '{$uid}'", 1);
                    if ($users['id']) {
                        $list = $this->bbspost->getEven('cp.pid,cp.fid,cp.tid,cp.subject,cf.name,cp.comment', "cp.fid = ct.fid and cp.tid = ct.tid and cp.status = 0 and cp.first in('0,1') and cp.authorid = '{$uid}' and cp.author = '{$users['username']}'", $page_size, $page_start, 'dateline desc', 2);
                        if ($list[0]['pid']) {
                            $output = array('code' => 1, 'mes' => '获取成功', 'list' => $list);
                            echo json_encode($output);
                        } else {
                            $output = array('code' => -3, 'mes' => '列表获取失败或没有数据');
                            echo json_encode($output);
                        }
                    }
                }
        }
    }

    function doMycollert() {
        $user_all = dcrypt::privDecrypt($_GET['parse']);
        $parse_query = parseQuery($user_all);
        $user = $parse_query["name"];
        $pwd = $parse_query["password"];
        $page = $parse_query["page"];
        $page = max(1, $page);
        $page_size = 20;
        $page_start = ($page - 1) * $page_size;
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
                    $users = $this->users->getUser('id,username,realname,created', "id = '{$uid}'", 1);
                    if ($users['id']) {
                        $list = $this->collect->getTagList("state = 1 and uid = '{$uid}' and uname = '{$users['username']}' type_id = 3", 'id,article_id', $page_size, $page_start, 'created desc', 2);
                        if ($list[0]['id']) {
                            foreach ($list as $key => $value) {
                                $lists = $this->bbspost->getEvens('cp.pid,cp.fid,cp.tid,cp.subject', "cp.first = in('0,1') and cp.status = 0 and cp.fid = ct.fid and cp.tid = ct.tid and cp.gid = 0 and ct.fid = cf.fid and cp.authorid = cu.id and cp.pid = '{$value['article_id']}'", 'dateline desc', 1);
                                $lists['id'] = $value['id'];
                                if ($lists[0]['pid']) {
                                    $output = array('code' => 1, 'mes' => '列表获取成功', 'list' => $lists);
                                    echo json_encode($output);
                                } else {
                                    $output = array('code' => -1, 'mes' => '列表获取失败或数据加载完成');
                                    echo json_encode($output);
                                }
                            }
                        }
                    }
                }
        }
    }

    function doMycomment() {
        global $local_host;
        $user_all = dcrypt::privDecrypt($_GET['parse']);
        $parse_query = parseQuery($user_all);
        $user = $parse_query["name"];
        $pwd = $parse_query["password"];
        $page = $parse_query["page"];
        $page = max(1, $page);
        $page_size = 20;
        $page_start = ($page - 1) * $page_size;
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
                    $users = $this->users->getUser('id,username,realname,created', "id = '{$uid}'", 1);
                    if ($users['id']) {
                        $list = $this->bbspost->getEvens('cp.pid,cp.fid,cp.tid,cp.subject,cf.name,cp.comment', "cp.fid = ct.fid and cp.tid = ct.tid and cp.status = 0 and cp.first in('0,1') and cp.authorid = '{$uid}' and cp.author = '{$users['username']}'", 'cp.dateline desc', 2);
                        if ($list[0]['pid']) {
                            foreach ($list as $key => $value) {
                                $lists = $this->bbspost->getEvena('cp.author,cp.authorid,cp.pid,cp.fid,cp.tid,cp.message,cp.rate,cp.dateline', "cp.first = 2 and cp.status = 0 and cp.fid = ct.fid and cp.tid = ct.tid and cp.gid = '{$value['pid']}' and ct.fid = cf.fid and cp.authorid = cu.id and cp.comment = '{$value['pid']}'", 'cp.dateline desc', 2);
                                if ($lists[0]['pid']) {
                                    foreach ($lists as $k => $v) {
                                        $arr = $this->users_profiles->getUser('avatar', "uid = '{$v['authorid']}'", 3);
                                        if ($arr) {
                                            $v['avatars'] = $local_host . UPLOAD_DIR . $arr;
                                        } else {
                                            $v['avatars'] = 1;
                                        }
                                        $v['dateline'] = date('Y-m-d', $v['dateline']);
                                        $v['chaild'] = $this->bbspost->getEvena('cp.author,cp.authorid,cp.pid,cp.fid,cp.tid,cp.message,cp.rate,cp.dateline', "cp.first = 2 and cp.status = 0 and cp.fid = ct.fid and cp.tid = ct.tid and cp.gid = '{$value['pid']}' and ct.fid = cf.fid and cp.authorid = cu.id and cp.comment = '{$v['pid']}'", 'cp.dateline desc', 2);
                                        if ($v['chaild'][0]['pid']) {
                                            foreach ($v['chaild'] as $kk => $vv) {
                                                $v['chaild'][$kk]['dateline'] = date('Y-m-d', $vv['dateline']);
                                            }
                                        }
                                        $res[] = $v;
                                    }
                                } else {
                                    continue;
                                }
                            }
                        } else {
                            $output = array('code' => -3, 'mes' => '列表获取失败或数据加载完成');
                            echo json_encode($output);
                        }

                        //计算总记录条数
                        $num = count($res);
                        //计算页数
                        $pages = ceil($num / $page_size);

                        if (is_numeric($page)) {
                            if ($page > $pages) {
                                $output = array('code' => -4, 'mes' => '没有数据了');
                                exit(json_encode($output));
                            } else {
                                $newarr = array_slice($res, $page_start, $page_size);
                                if (!$newarr) {
                                    $output = array('code' => -3, 'mes' => '获取内容失败');
                                    exit(json_encode($output));
                                } else {
                                    $output = array('code' => 1, 'mes' => '获取成功', 'list' => $newarr);
                                    echo json_encode($output);
                                }
                            }
                        }
                    }
                }
        }
    }

}
