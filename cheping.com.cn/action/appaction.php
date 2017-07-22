<?php

/**
 * 车评iOS应用数据调用接口
 * $Id: appaction.php 3070 2016-06-12 06:02:51Z david $
 * @author cuiyuanxin
 */
import('dcrypt.class', 'lib');

class appAction extends action {

    public $user;
    public $review;
    public $soapmsg;
    public $shortmsg;
    public $smstpl;
    public $articlepic;
    public $collect;
    public $badword;
    public $article;
    public $tag;
    public $search;
    public $category;
    public $categorys;
    public $pagedata;

    function __construct() {
        parent::__construct();

        $this->user = new users();
        $this->review = new reviews();
        $this->soapmsg = new soapmsg();
        $this->shortmsg = new shortmsg();
        $this->smstpl = new smsTpl();
        $this->articlepic = new articlepic();
        $this->collect = new collect();
        $this->review = new reviews();
        $this->badword = new badword();
        $this->tag = new tag();
        $this->article = new article();
        $this->search = new search();
        $this->category = new article_category();
        $this->categorys = new category();
        $this->pagedata = new pagedata();
    }

    function doDefault() {
        $this->doAppIndex();
    }

    function doAppIndex() {
        global $local_host;

        $page = $this->filter(dcrypt::privDecrypt($_GET['k']), HTTP_FILTER_INT, 1);
        #要求最小页号是第2页
        $page = max($page, 1);
        $page_size = 20;
        $page_start = ($page - 1) * $page_size;

        $value = $this->pagedata->getSomePagedata("value", "name='manual'", 3);
        if ($value) {
            $list = unserialize($value);
            if ($list)
                foreach ($list as $key => $val) {
                    $review = $this->review->getList("article_id='$val[id]' and state=1");
                    $articlepic = $this->articlepic->getCounts("type_id='$val[pic_org_id]'", "id,name,memo,created", array("ppos" => "asc"));

                    if (!empty($articlepic)) {
                        switch ($val['state']) {
                            case 1:
                                $lists[] = array(
                                    'id' => $val['id'],
                                    'title' => $val['title'],
                                    'pic' => replaceImageUrl($local_host . UPLOAD_DIR . $val['pic']),
                                    'uptime' => date("Y-m-d", $val['uptime']),
                                    'state' => $val['state'],
                                    'type' => $val['cname'],
                                    'comment' => count($review)
                                );

                                break;
                            case 2:
                                $lists[] = array(
                                    'id' => $val['id'],
                                    'title' => $val['title'],
                                    'articlepic' => $articlepic,
                                    'uptime' => date("Y-m-d", $val['uptime']),
                                    'pic' => replaceImageUrl($local_host . UPLOAD_DIR . $val['pic']),
                                    'state' => $val['state'],
                                    'type' => $val['cname'],
                                    'comment' => count($review)
                                );
                                break;
                            default:
                                $lists[] = array(
                                    'id' => $val['id'],
                                    'title' => $val['title'],
                                    'pic' => replaceImageUrl($local_host . UPLOAD_DIR . $val['pic']),
                                    'uptime' => date("Y-m-d", $val['uptime']),
                                    'state' => 1,
                                    'type' => $val['cname'],
                                    'comment' => count($review)
                                );
                        }
                    } else {

                        if ($val['cname'] == "video") {
                            $lists[] = array(
                                'id' => $val['id'],
                                'title' => $val['title'],
                                'pic' => replaceImageUrl($local_host . UPLOAD_DIR . $val['pic']),
                                'uptime' => date("Y-m-d", $val['uptime']),
                                'source' => $val['source'],
                                'state' => 1,
                                'type' => $val['cname'],
                                'comment' => count($review)
                            );
                        } else {
                            $lists[] = array(
                                'id' => $val['id'],
                                'title' => $val['title'],
                                'pic' => replaceImageUrl($local_host . UPLOAD_DIR . $val['pic']),
                                'uptime' => date("Y-m-d", $val['uptime']),
                                'state' => 1,
                                'type' => $val['cname'],
                                'comment' => count($review)
                            );
                        }
                    }
                }
        } else {
            $output = array('code' => 0, 'mes' => '获取内容失败');
            exit(json_encode($output));
        }


        //计算总记录条数
        $num = count($lists);
        //计算页数
        $pages = ceil($num / $page_size);

        if (is_numeric($page)) {
            if ($page > $pages) {
                $output = array('code' => 2, 'mes' => '没有数据了');
                exit(json_encode($output));
            } else {
                $newarr = array_slice($lists, $page_start, $page_size);
                if (!$newarr) {
                    $output = array('code' => 1, 'mes' => '获取内容失败');
                    exit(json_encode($output));
                }
            }
        }
        echo json_encode($newarr);
    }

    //验证手机号
    function doChkMoblie() {

        $mobile = dcrypt::privDecrypt($_POST['mobile']);
        if (!empty($mobile)) {
            if (strlen($mobile) == "11") {
                $n = preg_match("/1[3458]{1}\d{9}$/", $mobile, $array);
                if ($n == 0) {
                    $output = array('code' => -3, 'mes' => '手机号不正确'); //手机号不正确
                    exit(json_encode($output));
                }
            } else {
                $output = array('code' => -1, 'mes' => '手机号不足11位'); //手机号不足11位
                exit(json_encode($output));
            }
        } else {
            $output = array('code' => 0, 'mes' => '手机号为空'); //手机号为空
            exit(json_encode($output));
        }
        if ($n == 1) {
            $uid = $this->user->getUser('id', "mobile = '$mobile'", 3);
            if ($uid) {
                $output = array('code' => 1, 'mes' => '手机号码已经存在'); //手机号码已经注册
                exit(json_encode($output));
            } else {
                session("mobile", $mobile);
                $output = array('code' => -4, 'mes' => '手机不存在'); //手机号可注册
                exit(json_encode($output));
            }
        }
    }

    //发送验证码
    function doSendCode() {
        $str_4 = dcrypt::privDecrypt($_GET['mobile']);
        $phone = $str_4;
        if (!empty($phone)) {
            $code = mt_rand(1000, 9999);
            session("reg_code", $code);
            $msgTpl = $this->smstpl->getTpl($this->shortmsg->tpl_flag['reg_code']);

            $msg = str_replace('{$reg_code}', $code, $msgTpl);
            $state = $this->soapmsg->postMsg($phone, $msg);

            if ($state == 2) {
                $this->shortmsg->recordMsg(0, $state, $this->shortmsg->tpl_flag['reg_code'], $phone, $msg);
                $output = array('code' => $state, 'mes' => '验证码发送成功');
                exit(json_encode($output)); //验证码发送成功
            } else {
                $output = array('code' => $state, 'mes' => '验证码发送失败');
                exit(json_encode($output)); //验证码发送失败
            }
        } else {
            $output = array('code' => 0, 'mes' => '手机号为空'); //手机号为空
            exit(json_encode($output));
        }
    }

    //验证验证码
    function doCheckCode() {
        $str_4 = dcrypt::privDecrypt($_GET['code']);
        $code = $str_4;
        if (!empty($code)) {
            $reg_code = session("reg_code");
            if ($reg_code == $code) {
                $output = array('code' => 1, 'mes' => '验证码验证通过'); //验证码验证通过
                exit(json_encode($output));
            } else {
                $output = array('code' => -4, 'mes' => '验证码验证不通过'); //验证码验证不通过
                exit(json_encode($output));
            }
        } else {
            $output = array('code' => 0, 'mes' => '验证码为空'); //验证码为空
            exit(json_encode($output));
        }
    }

    //注册
    function doRegis() {

        $username = trim(dcrypt::privDecrypt($_POST['username']));
        ;
        $password = dcrypt::privDecrypt($_POST['password']);
        $mobile = session("mobile");
        if (empty($mobile)) {
            $output = array('code' => 3, 'mes' => '注册失败,手机号跑路了'); //注册失败
            exit(json_encode($output));
        }
        if (!empty($username)) {
            $uid = $this->user->getuser('id', "username = '$username'", 3);
            if ($uid) {
                $output = array('code' => -4, 'mes' => '用户名已经存在'); //用户名已经存在
                exit(json_encode($output));
            } else {
                $username_reg = "/^[a-zA-Z0-9_u4e00-u9fa5]{3,20}[^_]$/";
                if (!preg_match($username_reg, $username)) {
                    $output = array('code' => 1, 'mes' => '不符合要求'); //不符合要求
                    exit(json_encode($output));
                } else {
                    $code = 2; //符合要求
                }
            }
        } else {
            $output = array('code' => 0, 'mes' => '用户名不能为空'); //用户名不能为空
            exit(json_encode($output));
        }

        if (!empty($password)) {
            $password_reg = "/^.{6,18}$/";
            if (!preg_match($password_reg, $password)) {
                $output = array('code' => -1, 'mes' => '长度不符合要求'); //长度不符合要求
                exit(json_encode($output));
            } else {
                $code1 = -2; //符合要求
            }
        } else {
            $output = array('code' => 00, 'mes' => '密码不能为空'); //密码不能为空
            exit(json_encode($output));
        }

        $ip = util::getip();
        $password = md5($password);
        $this->user->ufields = array("username" => "$username", "password" => "$password", "mobile" => "$mobile", "state" => "1", "created" => time(), 'regfrom' => 1, "reg_ip" => "$ip");
        $id = $this->user->insert();
        if ($id) {
            session('username', $username);
            session('userid', $id);
            $output = array('ucode' => $code, 'mes' => '符合要求', 'pcode' => $code1, 'mess' => '符合要求', 'code' => -3, 'messs' => '注册成功,并已经登陆成功'); //注册成功
            exit(json_encode($output));
        } else {
            $output = array('code' => 3, 'mes' => '注册失败'); //注册失败
            exit(json_encode($output));
        }
    }

    //登录
    function doLogin() {

        $userid = session("userid");
        if (!empty($userid)) {
            $output = array('code' => 01, 'mes' => '您已经处于登录状态'); //用户名不能为空
            exit(json_encode($output));
        } else {
            $user = dcrypt::privDecrypt($_POST['name']);
            $pwd = dcrypt::privDecrypt($_POST['password']);

            if (empty($user)) {
                $output = array('code' => 0, 'mes' => '用户名不能为空'); //用户名不能为空
                exit(json_encode($output));
            } else if (empty($user)) {
                $output = array('code' => 1, 'mes' => '密码不能为空'); //密码不能为空
                exit(json_encode($output));
            } else {
                $code = 2; //全部正确
            }
            $pwd = md5($pwd);
            $phoneReg = '/^(13|18|15|17)\d{9,}$/';

            if (preg_match($phoneReg, $user)) {
                $uid = $this->user->getUser('id, password,username', "mobile='{$user}'", 1);
            } else {
                $uid = $this->user->getUser('id, password,username', "username='{$user}'", 1);
            }

            if ($uid && $pwd == $uid['password']) {
                session('userid', $uid['id']);
                session('username', $uid['username']);
                $output = array('upcode' => $code, 'mes' => '全部正确', 'code' => 3, 'mess' => '登陆成功'); //
                exit(json_encode($output));
            } else {
                $output = array('code' => 5, 'mes' => '账号密码不正确'); //账号密码不正确
                exit(json_encode($output));
            }
        }
    }

    //退出登录
    function doLogout() {
        unset_session('userid');
        unset_session('userid');
        unset_session('userid');
        cookie('data', 1, 0);
        $output = array('code' => 1, 'mes' => '注销成功'); //账号密码不正确
        exit(json_encode($output));
    }

    //发送验证码
    function doSendCodes() {
        $phone = filter_input(dcrypt::privDecrypt($_POST['mobile']), FILTER_SANITIZE_NUMBER_INT);

        if (!empty($phone)) {
            $code = mt_rand(1000, 9999);
            session("get_code", $code);
            $msgTpl = $this->smstpl->getTpl($this->shortmsg->tpl_flag['get_code']);
            $msg = str_replace('{$get_code}', $code, $msgTpl);

            $state = $this->soapmsg->postMsg($phone, $msg);

            if ($state == 2) {
                $this->shortmsg->recordMsg(0, $state, $this->shortmsg->tpl_flag['reg_code'], $phone, $msg);
                $output = array('code' => $state, 'mes' => '验证码发送成功');
                exit(json_encode($output)); //验证码发送成功
            } else {
                $output = array('code' => $state, 'mes' => '验证码发送失败');
                exit(json_encode($output)); //验证码发送失败
            }
        } else {
            $output = array('code' => 0, 'mes' => '手机号为空'); //手机号为空
            exit(json_encode($output));
        }
    }

    function doCheckCodes() {
        $code = filter_input(dcrypt::privDecrypt($_GET['code']), FILTER_SANITIZE_MAGIC_QUOTES);
        if (!empty($code)) {
            $get_pcode = session("get_code");
            if ($get_pcode == $code) {
                $output = array('code' => 1, 'mes' => '验证码验证通过'); //验证码验证通过
                exit(json_encode($output));
            } else {
                $output = array('code' => -4, 'mes' => '验证码验证不通过'); //验证码验证不通过
                exit(json_encode($output));
            }
        } else {
            $output = array('code' => 0, 'mes' => '验证码为空'); //验证码为空
            exit(json_encode($output));
        }
    }

    //忘记密码
    function doUpdatePassword() {
        $mobile = session("mobile");
        $password = dstring::stripscript(dcrypt::privDecrypt($_POST['password']));

        if ($mobile) {
            $this->user->ufields = array("password" => md5($password));
            $this->user->where = "mobile=$mobile";
            $id = $this->user->update();
            if ($id) {
                $output = array('code' => 1, 'mes' => '修改成功'); //修改成功
                exit(json_encode($output));
            } else {
                $output = array('code' => -1, 'mes' => '修改失败'); //修改失败
                exit(json_encode($output));
            }

//            $user = $this->user->getUser('id,mobile,username', "mobile='{$mobile}'", 1);
//            session('uid', $user['id']);
//            session('username', $user['username']);
//            $url = cookie('getpw_referer');
//            echo json_encode($url);
        } else {
            $output = array('code' => 0, 'mes' => '手机号为空'); //手机号为空
            exit(json_encode($output));
        }
    }

    function doYueLan() {
        global $local_host;
        $page = $this->filter(dcrypt::privDecrypt($_GET['k']), HTTP_FILTER_INT, 1);
        #要求最小页号是第2页
        $page = max($page, 1);
        $page_size = 20;
        $page_start = ($page - 1) * $page_size;

        $value = $this->pagedata->getSomePagedata("value", "name='applist'", 3);

        if ($value) {
            $list = unserialize($value);

            if ($list)
                foreach ($list as $key => $val) {
                    $lists[] = array(
                        'id' => $val['id'],
                        'title' => $val['title'],
                        'pic' => replaceImageUrl($local_host . UPLOAD_DIR . $this->article->getArticlePic($val['pic'], '280x186')),
                        'uptime' => date("Y-m-d", $val['uptime']),
                        'category_id' => $val['p_category_id'],
                        'type' => $val['cname'],
                        'orderby' => $val['orderby']
                    );
                }
        } else {
            $output = array('code' => 0, 'mes' => '获取内容失败');
            exit(json_encode($output));
        }

        //计算总记录条数
        $num = count($lists);
        //计算页数
        $pages = ceil($num / $page_size);

        if (is_numeric($page)) {
            if ($page > $pages) {
                $output = array('code' => 2, 'mes' => '没有数据了');
                exit(json_encode($output));
            } else {
                $newarr = array_slice($lists, $page_start, $page_size);
                if (!$newarr) {
                    $output = array('code' => 1, 'mes' => '获取内容失败');
                    exit(json_encode($output));
                }
            }
        }

        echo json_encode($newarr);
    }

    //分类
    function doCategory() {
        $ParentCategory = $this->category->getParentCategory("ca.id caid,ca.category_name caname,pca.id,pca.category_name", "pca.parentid=ca.id and pca.state=1 and ca.state and ca.parentid=0", 2);
        
        if ($ParentCategory) {
            $output = array('code' => 1, 'mes' => '分类获取内容成功', 'type' => $ParentCategory, 'mes' => '分类导航');
            exit(json_encode($output));
        } else {
            $output = array('code' => -1, 'mes' => '分类获取内容失败');
            exit(json_encode($output));
        }
    }

    //分类轮播
    function doBanner() {
        global $local_host;
        $type = $this->filter(dcrypt::privDecrypt($_GET['type']), HTTP_FILTER_INT, 7);
        switch ($type) {
            case 7:
                $value = $this->pagedata->getSomePagedata("value", "name='app_news'", 3);
                break;
            case 8:
                $value = $this->pagedata->getSomePagedata("value", "name='app_pingce'", 3);
                break;
            case 9:
                $value = $this->pagedata->getSomePagedata("value", "name='app_video'", 3);
                break;
            case 10:
                $value = $this->pagedata->getSomePagedata("value", "name='app_wenhua'", 3);
                break;
        }

        if ($value) {
            $list = unserialize($value);
            if ($list)
                foreach ($list as $key => $val) {
                    $lists[] = array(
                        'id' => $val['id'],
                        'title' => $val['title'],
                        'pic' => replaceImageUrl($local_host . UPLOAD_DIR . $this->article->getArticlePic($val['pic'], '280x186'))
                    );
                }
            echo json_encode($lists);
        } else {
            $output = array('code' => 0, 'mes' => '获取内容失败');
            exit(json_encode($output));
        }
    }

    //频道
    function doChannel() {
        global $local_host;

        $page = $this->filter(dcrypt::privDecrypt($_GET['k']), HTTP_FILTER_INT, 1);
        #要求最小页号是第2页
        $page = max($page, 1);
        $page_size = 20;
        $page_start = ($page - 1) * $page_size;

        $type = $this->filter(dcrypt::privDecrypt($_GET['type']), HTTP_FILTER_INT, 7);
        $type_id = $this->filter(dcrypt::privDecrypt($_GET['type_id']), HTTP_FILTER_INT, 1);

        switch ($type) {
            case 7:
                switch ($type_id) {
                    case 1:
                        // $c = $this->categorys->getlist("id","parentid='$type' and state=1",2);
                        // $cat = array();
                        // foreach ($c as $key => $value) {
                        //     $cat[] = $value['id'];
                        // }
                        // $cc = implode(',',$cat);
                        $article = $this->article->getAr("ca.category_id=cac.id and ca.type_id=1 and ca.state=3 order by uptime desc", "ca.id,ca.title,ca.title2,ca.type_id,ca.pic,ca.uptime", 2);
                        if ($article) {
                            if ($article)
                                foreach ($article as $key => $val) {
                                    $review = $this->review->getList("article_id='$val[id]' and state=1");
                                    $lists[] = array(
                                        'id' => $val['id'],
                                        'title' => $val['title'],
                                        'title2' => $val['title2'],
                                        'type_id' => $val['type_id'],
                                        'pic' => replaceImageUrl($local_host . UPLOAD_DIR . $this->article->getArticlePic($val['pic'], '280x186')),
                                        'uptime' => date("Y-m-d", $val['uptime']),
                                        'comment' => count($review)
                                    );
                                }
                        } else {
                            $output = array('code' => -1, 'mes' => '获取内容失败');
                            exit(json_encode($output));
                        }

                        break;
                    case 54:
                        $article = $this->article->getlists("id,title,title2,type_id,pic,uptime", "type_id=1 and state=3 and category_id='$type_id' order by uptime desc", 2);

                        if ($article) {
                            if ($article)
                                foreach ($article as $key => $val) {
                                    $review = $this->review->getList("article_id='$val[id]' and state=1");
                                    $lists[] = array(
                                        'id' => $val['id'],
                                        'title' => $val['title'],
                                        'title2' => $val['title2'],
                                        'type_id' => $val['type_id'],
                                        'pic' => replaceImageUrl($local_host . UPLOAD_DIR . $this->article->getArticlePic($val['pic'], '280x186')),
                                        'uptime' => date("Y-m-d", $val['uptime']),
                                        'comment' => count($review)
                                    );
                                }
                        } else {
                            $output = array('code' => -1, 'mes' => '获取内容失败');
                            exit(json_encode($output));
                        }

                        break;
                    case 55:
                        $article = $this->article->getlists("id,title,title2,type_id,pic,uptime", "type_id=1 and state=3 and category_id='$type_id' order by uptime desc", 2);

                        if ($article) {
                            if ($article)
                                foreach ($article as $key => $val) {
                                    $review = $this->review->getList("article_id='$val[id]' and state=1");
                                    $lists[] = array(
                                        'id' => $val['id'],
                                        'title' => $val['title'],
                                        'title2' => $val['title2'],
                                        'type_id' => $val['type_id'],
                                        'pic' => replaceImageUrl($local_host . UPLOAD_DIR . $this->article->getArticlePic($val['pic'], '280x186')),
                                        'uptime' => date("Y-m-d", $val['uptime']),
                                        'comment' => count($review)
                                    );
                                }
                        } else {
                            $output = array('code' => -1, 'mes' => '获取内容失败');
                            exit(json_encode($output));
                        }

                        break;
                    default:
                        $output = array('code' => -4, 'mes' => '获取分类失败');
                        exit(json_encode($output));
                }
                break;
            case 8:
                switch ($type_id) {
                    case 1:
                        // $c = $this->categorys->getlist("id","parentid='$type' and state=1",2);
                        // $cat = array();
                        // foreach ($c as $key => $value) {
                        //     $cat[] = $value['id'];
                        // }
                        // $cc = implode(',',$cat);
                        $article = $this->article->getAr("ca.category_id=cac.id and ca.type_id=1 and ca.state=3 order by uptime desc", "ca.id,ca.title,ca.title2,ca.type_id,ca.pic,ca.uptime", 2);
                        if ($article) {
                            if ($article)
                                foreach ($article as $key => $val) {
                                    $review = $this->review->getList("article_id='$val[id]' and state=1");
                                    $lists[] = array(
                                        'id' => $val['id'],
                                        'title' => $val['title'],
                                        'title2' => $val['title2'],
                                        'type_id' => $val['type_id'],
                                        'pic' => replaceImageUrl($local_host . UPLOAD_DIR . $this->article->getArticlePic($val['pic'], '280x186')),
                                        'uptime' => date("Y-m-d", $val['uptime']),
                                        'comment' => count($review)
                                    );
                                }
                        } else {
                            $output = array('code' => -1, 'mes' => '获取内容失败');
                            exit(json_encode($output));
                        }

                        break;
                    case 16:
                        $article = $this->article->getlists("id,title,title2,type_id,pic,uptime", "type_id=1 and state=3 and category_id='$type_id' order by uptime desc", 2);

                        if ($article) {
                            if ($article)
                                foreach ($article as $key => $val) {
                                    $review = $this->review->getList("article_id='$val[id]' and state=1");
                                    $lists[] = array(
                                        'id' => $val['id'],
                                        'title' => $val['title'],
                                        'title2' => $val['title2'],
                                        'type_id' => $val['type_id'],
                                        'pic' => replaceImageUrl($local_host . UPLOAD_DIR . $this->article->getArticlePic($val['pic'], '280x186')),
                                        'uptime' => date("Y-m-d", $val['uptime']),
                                        'comment' => count($review)
                                    );
                                }
                        } else {
                            $output = array('code' => -1, 'mes' => '获取内容失败');
                            exit(json_encode($output));
                        }

                        break;
                    case 56:
                        $article = $this->article->getlists("id,title,title2,type_id,pic,uptime", "type_id=1 and state=3 and category_id='$type_id' order by uptime desc", 2);

                        if ($article) {
                            if ($article)
                                foreach ($article as $key => $val) {
                                    $review = $this->review->getList("article_id='$val[id]' and state=1");
                                    $lists[] = array(
                                        'id' => $val['id'],
                                        'title' => $val['title'],
                                        'title2' => $val['title2'],
                                        'type_id' => $val['type_id'],
                                        'pic' => replaceImageUrl($local_host . UPLOAD_DIR . $this->article->getArticlePic($val['pic'], '280x186')),
                                        'uptime' => date("Y-m-d", $val['uptime']),
                                        'comment' => count($review)
                                    );
                                }
                        } else {
                            $output = array('code' => -1, 'mes' => '获取内容失败');
                            exit(json_encode($output));
                        }

                        break;
                    case 59:
                        $article = $this->article->getlists("id,title,title2,type_id,pic,uptime", "type_id=1 and state=3 and category_id='$type_id' order by uptime desc", 2);

                        if ($article) {
                            if ($article)
                                foreach ($article as $key => $val) {
                                    $review = $this->review->getList("article_id='$val[id]' and state=1");
                                    $lists[] = array(
                                        'id' => $val['id'],
                                        'title' => $val['title'],
                                        'title2' => $val['title2'],
                                        'type_id' => $val['type_id'],
                                        'pic' => replaceImageUrl($local_host . UPLOAD_DIR . $this->article->getArticlePic($val['pic'], '280x186')),
                                        'uptime' => date("Y-m-d", $val['uptime']),
                                        'comment' => count($review)
                                    );
                                }
                        } else {
                            $output = array('code' => -1, 'mes' => '获取内容失败');
                            exit(json_encode($output));
                        }

                        break;
                    default:
                        $output = array('code' => -4, 'mes' => '获取分类失败');
                        exit(json_encode($output));
                }
                break;
            case 9:
                switch ($type_id) {
                    case 1:
                        // $c = $this->categorys->getlist("id","parentid='$type' and state=1",2);
                        // $cat = array();
                        // foreach ($c as $key => $value) {
                        //     $cat[] = $value['id'];
                        // }
                        // $cc = implode(',',$cat);
                        $article = $this->article->getAr("ca.category_id=cac.id and ca.type_id=2 and ca.state=3 order by uptime desc", "ca.id,ca.title,ca.type_id,ca.source,ca.uptime", 2);
                        if ($article) {
                            if ($article)
                                foreach ($article as $key => $val) {
                                    $review = $this->review->getList("article_id='$val[id]' and state=1");
                                    $lists[] = array(
                                        'id' => $val['id'],
                                        'title' => $val['title'],
                                        'type_id' => $val['type_id'],
                                        'source' => $val['source'],
                                        'pic' => replaceImageUrl($local_host . UPLOAD_DIR . $this->article->getArticlePic($val['pic'], '280x186')),
                                        'uptime' => date("Y-m-d", $val['uptime']),
                                        'comment' => count($review)
                                    );
                                }
                        } else {
                            $output = array('code' => -1, 'mes' => '获取内容失败');
                            exit(json_encode($output));
                        }

                        break;
                    case 33:
                        $article = $this->article->getlists("id,title,type_id,source,uptime", "type_id=2 and state=3 and category_id='$type_id' order by uptime desc", 2);

                        if ($article) {
                            if ($article)
                                foreach ($article as $key => $val) {
                                    $review = $this->review->getList("article_id='$val[id]' and state=1");
                                    $lists[] = array(
                                        'id' => $val['id'],
                                        'title' => $val['title'],
                                        'type_id' => $val['type_id'],
                                        'source' => $val['source'],
                                        'pic' => replaceImageUrl($local_host . UPLOAD_DIR . $this->article->getArticlePic($val['pic'], '280x186')),
                                        'uptime' => date("Y-m-d", $val['uptime']),
                                        'comment' => count($review)
                                    );
                                }
                        } else {
                            $output = array('code' => -1, 'mes' => '获取内容失败');
                            exit(json_encode($output));
                        }

                        break;
                    case 34:
                        $article = $this->article->getlists("id,title,type_id,source,uptime", "type_id=2 and state=3 and category_id='$type_id' order by uptime desc", 2);

                        if ($article) {
                            if ($article)
                                foreach ($article as $key => $val) {
                                    $review = $this->review->getList("article_id='$val[id]' and state=1");
                                    $lists[] = array(
                                        'id' => $val['id'],
                                        'title' => $val['title'],
                                        'type_id' => $val['type_id'],
                                        'source' => $val['source'],
                                        'pic' => replaceImageUrl($local_host . UPLOAD_DIR . $this->article->getArticlePic($val['pic'], '280x186')),
                                        'uptime' => date("Y-m-d", $val['uptime']),
                                        'comment' => count($review)
                                    );
                                }
                        } else {
                            $output = array('code' => -1, 'mes' => '获取内容失败');
                            exit(json_encode($output));
                        }

                        break;
                    case 57:
                        $article = $this->article->getlists("id,title,type_id,source,uptime", "type_id=2 and state=3 and category_id='$type_id' order by uptime desc", 2);

                        if ($article) {
                            if ($article)
                                foreach ($article as $key => $val) {
                                    $review = $this->review->getList("article_id='$val[id]' and state=1");
                                    $lists[] = array(
                                        'id' => $val['id'],
                                        'title' => $val['title'],
                                        'type_id' => $val['type_id'],
                                        'source' => $val['source'],
                                        'pic' => replaceImageUrl($local_host . UPLOAD_DIR . $this->article->getArticlePic($val['pic'], '280x186')),
                                        'uptime' => date("Y-m-d", $val['uptime']),
                                        'comment' => count($review)
                                    );
                                }
                        } else {
                            $output = array('code' => -1, 'mes' => '获取内容失败');
                            exit(json_encode($output));
                        }

                        break;
                    case 61:
                        $article = $this->article->getlists("id,title,type_id,source,uptime", "type_id=2 and state=3 and category_id='$type_id' order by uptime desc", 2);

                        if ($article) {
                            if ($article)
                                foreach ($article as $key => $val) {
                                    $review = $this->review->getList("article_id='$val[id]' and state=1");
                                    $lists[] = array(
                                        'id' => $val['id'],
                                        'title' => $val['title'],
                                        'type_id' => $val['type_id'],
                                        'source' => $val['source'],
                                        'pic' => replaceImageUrl($local_host . UPLOAD_DIR . $this->article->getArticlePic($val['pic'], '280x186')),
                                        'uptime' => date("Y-m-d", $val['uptime']),
                                        'comment' => count($review)
                                    );
                                }
                        } else {
                            $output = array('code' => -1, 'mes' => '获取内容失败');
                            exit(json_encode($output));
                        }

                        break;
                    case 62:
                        $article = $this->article->getlists("id,title,type_id,source,uptime", "type_id=2 and state=3 and category_id='$type_id' order by uptime desc", 2);

                        if ($article) {
                            if ($article)
                                foreach ($article as $key => $val) {
                                    $review = $this->review->getList("article_id='$val[id]' and state=1");
                                    $lists[] = array(
                                        'id' => $val['id'],
                                        'title' => $val['title'],
                                        'type_id' => $val['type_id'],
                                        'source' => $val['source'],
                                        'pic' => replaceImageUrl($local_host . UPLOAD_DIR . $this->article->getArticlePic($val['pic'], '280x186')),
                                        'uptime' => date("Y-m-d", $val['uptime']),
                                        'comment' => count($review)
                                    );
                                }
                        } else {
                            $output = array('code' => -1, 'mes' => '获取内容失败');
                            exit(json_encode($output));
                        }

                        break;
                    default:
                        $output = array('code' => -4, 'mes' => '获取分类失败');
                        exit(json_encode($output));
                }
                break;
            case 10:
                switch ($type_id) {
                    case 1:
                        // $c = $this->categorys->getlist("id","parentid='$type' and state=1",2);
                        // $cat = array();
                        // foreach ($c as $key => $value) {
                        //     $cat[] = $value['id'];
                        // }
                        // $cc = implode(',',$cat);
                        $article = $this->article->getAr("ca.category_id=cac.id and ca.type_id=1 and ca.state=3 order by uptime desc", "ca.id,ca.title,ca.title2,ca.type_id,ca.pic,ca.uptime", 2);

                        if ($article) {
                            if ($article)
                                foreach ($article as $key => $val) {
                                    $review = $this->review->getList("article_id='$val[id]' and state=1");
                                    $lists[] = array(
                                        'id' => $val['id'],
                                        'title' => $val['title'],
                                        'title2' => $val['title2'],
                                        'type_id' => $val['type_id'],
                                        'pic' => replaceImageUrl($local_host . UPLOAD_DIR . $this->article->getArticlePic($val['pic'], '280x186')),
                                        'uptime' => date("Y-m-d", $val['uptime']),
                                        'comment' => count($review)
                                    );
                                }
                        } else {
                            $output = array('code' => -1, 'mes' => '获取内容失败');
                            exit(json_encode($output));
                        }

                        break;
                    case 50:
                        $article = $this->article->getlists("id,title,title2,type_id,pic,uptime", "type_id=1 and state=3 and category_id='$type_id' order by uptime desc", 2);

                        if ($article) {
                            if ($article)
                                foreach ($article as $key => $val) {
                                    $review = $this->review->getList("article_id='$val[id]' and state=1");
                                    $lists[] = array(
                                        'id' => $val['id'],
                                        'title' => $val['title'],
                                        'title2' => $val['title2'],
                                        'type_id' => $val['type_id'],
                                        'pic' => replaceImageUrl($local_host . UPLOAD_DIR . $this->article->getArticlePic($val['pic'], '280x186')),
                                        'uptime' => date("Y-m-d", $val['uptime']),
                                        'comment' => count($review)
                                    );
                                }
                        } else {
                            $output = array('code' => -1, 'mes' => '获取内容失败');
                            exit(json_encode($output));
                        }

                        break;
                    case 51:
                        $article = $this->article->getlists("id,title,title2,type_id,pic,uptime", "type_id=1 and state=3 and category_id='$type_id' order by uptime desc", 2);

                        if ($article) {
                            if ($article)
                                foreach ($article as $key => $val) {
                                    $review = $this->review->getList("article_id='$val[id]' and state=1");
                                    $lists[] = array(
                                        'id' => $val['id'],
                                        'title' => $val['title'],
                                        'title2' => $val['title2'],
                                        'type_id' => $val['type_id'],
                                        'pic' => replaceImageUrl($local_host . UPLOAD_DIR . $this->article->getArticlePic($val['pic'], '280x186')),
                                        'uptime' => date("Y-m-d", $val['uptime']),
                                        'comment' => count($review)
                                    );
                                }
                        } else {
                            $output = array('code' => -1, 'mes' => '获取内容失败');
                            exit(json_encode($output));
                        }

                        break;
                    case 52:
                        $article = $this->article->getlists("id,title,title2,type_id,pic,uptime", "type_id=1 and state=3 and category_id='$type_id' order by uptime desc", 2);
                        if ($article) {
                            if ($article)
                                foreach ($article as $key => $val) {
                                    $review = $this->review->getList("article_id='$val[id]' and state=1");
                                    $lists[] = array(
                                        'id' => $val['id'],
                                        'title' => $val['title'],
                                        'title2' => $val['title2'],
                                        'type_id' => $val['type_id'],
                                        'pic' => replaceImageUrl($local_host . UPLOAD_DIR . $this->article->getArticlePic($val['pic'], '280x186')),
                                        'uptime' => date("Y-m-d", $val['uptime']),
                                        'comment' => count($review)
                                    );
                                }
                        } else {
                            $output = array('code' => -1, 'mes' => '获取内容失败');
                            exit(json_encode($output));
                        }

                        break;
                    default:
                        $output = array('code' => -4, 'mes' => '获取分类失败');
                        exit(json_encode($output));
                }
                break;
            default:
                $output = array('code' => -4, 'mes' => '获取分类失败');
                exit(json_encode($output));
        }

        //计算总记录条数
        $num = count($lists);
        //计算页数
        $pages = ceil($num / $page_size);

        if (is_numeric($page)) {
            if ($page > $pages) {
                $output = array('code' => 2, 'mes' => '没有数据了');
                exit(json_encode($output));
            } else {
                $newarr = array_slice($lists, $page_start, $page_size);
                if (!$newarr) {
                    $output = array('code' => -1, 'mes' => '获取内容失败');
                    exit(json_encode($output));
                }
            }
        }

        echo json_encode($newarr);
    }

    //收藏
    function doCollect() {
        $uid = session("userid");
        $type_id = $this->filter(dcrypt::privDecrypt($_GET['type_id']), HTTP_FILTER_INT, 1);
        $article_id = intval(dcrypt::privDecrypt($_GET['article_id']));

        $uid = intval($uid);

        #通过session数据判断登录用户，然后再查数据，保证安全
        if ($uid) {
            $article = $this->article->getlist("*", "id='{$article_id}'", 1);
            if (empty($article)) {
                $output = array('code' => 0, 'mes' => '数据获取失败');
                exit(json_encode($output));
            }
            $categoryarr = $this->category->getParentCategory("pca.category_name p_category_name,ca.*", "ca.id='{$article['category_id']}' and pca.id=ca.parentid", 1);
            if (empty($categoryarr)) {
                $output = array('code' => 0, 'mes' => '数据获取失败');
                exit(json_encode($output));
            }
            $users = $this->user->getUser('id,username', "id='$uid'", 1);
            if (empty($users)) {
                $output = array('code' => 0, 'mes' => '数据获取失败');
                exit(json_encode($output));
            }
            $id = $this->collect->getlist("id", "uid='{$uid}' and article_id='{$article_id}'", 3);
            if ($id) {
                $this->collect->where = "uid='{$uid}' and id='{$id}'";
                $this->collect->del();
                $arr['state'] = 2;
                $arr['mes'] = '收藏取消';
            } else {
                $this->collect->ufields = array(
                    "uid" => $uid,
                    "uname" => $users['username'],
                    "created" => $this->timestamp,
                    "article_id" => $article_id,
                    "category_name" => $categoryarr['p_category_name'],
                    "category_id" => $categoryarr['parentid'],
                    "type_id" => $type_id,
                );
                $res = $this->collect->insert();
                if ($res) {
                    $arr['state'] = 1;
                    $arr['mes'] = '收藏成功';
                } else {
                    $arr['state'] = -2;
                    $arr['mes'] = '收藏失败';
                }
            }
        }
        #未登录用户，直接返回错误代码，禁止收藏
        else {
            $output = array('code' => -1, 'mes' => '没有登录禁止收藏');
            exit(json_encode($output));
        }
        $output = array('code' => $arr['state'], 'mes' => $arr['mes']);
        exit(json_encode($output));
    }

    function doccoll() {
        $uid = session("userid");
        $article_id = $this->filter(dcrypt::privDecrypt($_GET['article_id']), HTTP_FILTER_INT);

        if ($uid) {
            $num = $this->collect->getlist("id", "article_id='{$article_id}' and uid='$uid'", 3);
            if ($num) {
                $arr = array('code' => 1, 'mes' => "高亮收藏");
            } else {
                $arr = array('code' => -1, 'mes' => "不高亮收藏");
            }
        } else {
            $arr = array('code' => -1, 'mes' => "没有登录不高亮收藏");
        }
        exit(json_encode($arr));
    }

    //评论
    function doReciew() {
        $page = $this->filter(dcrypt::privDecrypt($_REQUEST['k']), HTTP_FILTER_INT, 1);

        $page = max(1, $page);
        $page_size = 10;
        $page_start = ($page - 1) * $page_size;

        $uid = session("userid");
        $article_id = intval(dcrypt::privDecrypt($_REQUEST['article_id']));
        $type_id = $this->filter(dcrypt::privDecrypt($_REQUEST['type_id']), HTTP_FILTER_INT, 1);

        $value = $this->pagedata->getSomePagedata("value", "name='review'", 3);
        $value = unserialize($value);
        $state = $this->filter(dcrypt::privDecrypt($_GET['state']), HTTP_FILTER_INT, $value);
        $article = $this->article->getlist("*", "id='{$article_id}' and state=3", 1);
        $arr[] = array(
            'title' => $article['title'],
            'author' => $article['author'],
            'photor' => $article['photor'],
            'uptime' => date("Y-m-d", $article['uptime'])
        );


        switch ($state) {
            case 0:
                $where = "cr.uid=cu.id and cr.type_id='{$type_id}' and cr.state=1 and cr.parentid=0 and cr.article_id='{$article_id}'";
                $list = $this->review->getPrice($where, $order);

                $code = 1;
                $mes = '数据获取成功';
                break;
            case 1:
                switch ($uid) {
                    case 0:
                        $where = "cr.uid=cu.id and cr.type_id='{$type_id}' and cr.state=1 and cr.parentid=0 and cr.article_id='{$article_id}'";
                        $list = $this->review->getPrice($where, $order);

                        $code = 1;
                        $mes = '数据获取成功';
                        break;
                    default:
                        $where = "cr.uid=cu.id and cr.type_id='{$type_id}' and cr.state!=0 and cr.parentid=0 and cr.article_id='{$article_id}'";
                        $list = $this->review->getPrice($where, $order);
                        if ($list)
                            foreach ($list as $key => $val) {

                                if ($val[state] == 2) {
                                    if ($uid !== $val[uid]) {
                                        unset($list[$key]);
                                    } else {
                                        unset($list[$key][content]);
                                        $list[$key][content] = "提交成功，您的评论内容正在审核中，请耐心等待";
                                    }
                                }
                            }
                        $code = 1;
                        $mes = '数据获取成功';
                }
                break;
            default:
                switch ($uid) {
                    case 0:
                        $where = "cr.uid=cu.id and cr.type_id='{$type_id}' and cr.state=1 and cr.parentid=0 and cr.article_id='{$article_id}'";
                        $list = $this->review->getPrice($where, $order);

                        $code = 1;
                        $mes = '数据获取成功';
                        break;
                    default:
                        $where = "cr.uid=cu.id and cr.type_id='{$type_id}' and cr.state!=0 and cr.parentid=0 and cr.article_id='{$article_id}'";
                        $list = $this->review->getPrice($where, $order);
                        if ($list)
                            foreach ($list as $key => $val) {

                                if ($val[state] == 2) {
                                    if ($uid !== $val[uid]) {
                                        unset($list[$key]);
                                    } else {
                                        unset($list[$key][content]);
                                        $list[$key][content] = "提交成功，您的评论内容正在审核中，请耐心等待";
                                    }
                                }
                            }
                        $code = 1;
                        $mes = '数据获取成功';
                }
        }


        //计算总记录条数
        $num = count($list);
        //计算页数
        $pages = ceil($num / $page_size);

        if (is_numeric($page)) {
            if ($page > $pages) {
                $output = array('code' => 2, 'mes' => '没有数据了');
                exit(json_encode($output));
            } else {
                if (!empty($list)) {
                    $newarr = array_slice($list, $page_start, $page_size);
                } else {
                    $output = array('code' => -1, 'mes' => '获取内容失败');
                    exit(json_encode($output));
                }

                if (!$newarr) {
                    $output = array('code' => -1, 'mes' => '获取内容失败');
                    exit(json_encode($output));
                }
            }
        }
        if ($newarr)
            foreach ($newarr as $k => $v) {
                /* php计算多少分钟前，多少小时前，多少天前的函数调用 */
                $newtime = $v[created];
                $newarr[$k][time] = $this->format_date($newtime);
            }

        $output = array('code' => $code, 'mes' => $mes, 'list' => $newarr, 'article' => $arr, 'total' => $num, 'state' => $state);
        exit(json_encode($output));
    }

    function format_date($time) {
        $t = time() - $time;
        /* 声明一个数组显示多少秒前,多少分钟前，多少小时前，多少天前..... */
        $f = array(
            '31536000' => '年',
            '2592000' => '个月',
            '604800' => '星期',
            '86400' => '天',
            '3600' => '小时',
            '60' => '分钟',
            '1' => '秒'
        );
        /* 使用循环分析多少分钟前等.... */
        foreach ($f as $k => $v) {
            if (0 != $c = floor($t / (int) $k)) {
                return $c . $v . '前';
            }
        }
    }

    //发布评论
    function doSubmitReview() {
        $message = '';
        $uid = session("userid");
        #type_id，为空时，默认为1，代表文章评论
        $type_id = $this->filter(dcrypt::privDecrypt($_POST['type_id']), HTTP_FILTER_INT, 1);
        $content = $_POST['content'];
        $content = preg_replace('/(https?|ftp):\/\/[-A-Z0-9+&@#\/%?=~_|$!:,.;]*[A-Z0-9+&@#\/%=~_|$]/im', '', preg_replace('/<(.*?)>/is', "", trim($content)));
        #只有登录用户及有评论内容，才能写表操作
        if (!empty($uid) && !empty($content)) {
            $users = $this->user->getUser('id,username', "id='$uid'", 1);
            $article_id = dcrypt::privDecrypt($_POST['article_id']);

            $ip = util::getip();
            $badwords = $this->badword->getlist("badwords", "id=1", 3);
            $array = array_filter(explode("|", $badwords));
            $badword1 = array_combine($array, array_fill(0, count($array), '*'));
            $str = strtr($content, $badword1);
            //获取全局开关
            $strs = $this->pagedata->getSomePagedata("value", "name='review'", 3);
            $shenhe = unserialize($strs);
            $this->review->ufields = array(
                "content" => $content,
                "type_id" => $type_id,
                "uid" => $users['id'],
                "uname" => $users['username'],
                "created" => $this->timestamp,
                "article_id" => $article_id,
                "ip" => $ip,
            );
            switch ($shenhe) {
                case 1:
                    $this->review->ufields['state'] = 2;
                    $r = $this->review->insert();
                    if ($r) {
                        $output = array('code' => 1, 'mes' => '发布成功');
                        exit(json_encode($output));
                    } else {
                        $output = array('code' => 2, 'mes' => '评论失败');
                        exit(json_encode($output));
                    }
                    break;
                case 0:
                    $this->review->ufields['state'] = 1;
                    $r = $this->review->insert();
                    if ($r) {
                        $output = array('code' => 1, 'mes' => '发布成功');
                        exit(json_encode($output));
                    } else {
                        $output = array('code' => 2, 'mes' => '评论失败');
                        exit(json_encode($output));
                    }
                    break;
                default:
                    echo "程序出现错误！";
            }
        } else {
            if (empty($uid)) {
                $output = array('code' => 0, 'mes' => '请先登录，再评论！');
                exit(json_encode($output));
            } elseif (empty($content)) {
                $output = array('code' => -1, 'mes' => '评论内容不能为空！');
                exit(json_encode($output));
            }
        }
    }

    // function doceshi(){
    //     $template_name = "ceshi";
    //     $this->template($template_name, '', 'replaceArticleUrl');
    // }
    //评论回复
    function doReviewAnswer() {
        $uid = session("userid");
        if (empty($uid))
            $output = array('code' => 0, 'mes' => '请先登录，再回复！');
        exit(json_encode($output));

        $users = $this->user->getUser('id,username', "id='$uid'", 1);

        $content = $_GET['contents'];
        $content = preg_replace('/(https?|ftp):\/\/[-A-Z0-9+&@#\/%?=~_|$!:,.;]*[A-Z0-9+&@#\/%=~_|$]/im', '', preg_replace('/<(.*?)>/is', "", trim($content)));
        $parentid = intval(dcrypt::privDecrypt($_GET['id']));
        $article_id = intval(dcrypt::privDecrypt($_GET['article_id']));
        $ip = util::getip();
        $strs = $this->pagedata->getSomePagedata("value", "name='review'", 3);
        $shenhe = unserialize($strs);

        if ($shenhe == 1) {
            #关键词过滤，暂时屏蔽不用
            if (0) {
                $badwords = $this->badword->getlist("badwords", "id=1", 3);
                $array = array_filter(explode("|", $badwords));
                $badword1 = array_combine($array, array_fill(0, count($array), '*'));
                $str = strtr($content, $badword1);
            }
            if ($users[id] && $content) {
                $this->review->ufields = array(
                    "content" => $content,
                    "type_id" => 1,
                    "uid" => $users[id],
                    "uname" => $users['username'],
                    "created" => time(),
                    'article_id' => $article_id,
                    "parentid" => $parentid,
                    "ip" => $ip,
                    "state" => 2
                );
                $id = $this->review->insert();
            }
            if ($id) {
                $output = array('code' => 1, 'mes' => '回复成功');
                exit(json_encode($output));
            } else {
                $output = array('code' => 2, 'mes' => '回复失败！');
                exit(json_encode($output));
            }
            echo $html;
        } else {
            #关键词过滤，暂时屏蔽不用
            if (0) {
                $badwords = $this->badword->getlist("badwords", "id=1", 3);
                $array = array_filter(explode("|", $badwords));
                $badword1 = array_combine($array, array_fill(0, count($array), '*'));
                $str = strtr($content, $badword1);
            }
            if ($users[id] && $content) {
                $this->review->ufields = array(
                    "content" => $content,
                    "type_id" => 1,
                    "uid" => $users[id],
                    "uname" => $users['username'],
                    'article_id' => $article_id,
                    "created" => time(),
                    "parentid" => $parentid,
                    "ip" => $ip,
                    "state" => 1
                );
                $id = $this->review->insert();
            }
            if ($id) {
                $output = array('code' => 1, 'mes' => '回复成功');
                exit(json_encode($output));
            } else {
                $output = array('code' => 2, 'mes' => '回复失败！');
                exit(json_encode($output));
            }
        }
    }

    function doReviewPraise() {
        $ip = util::getip();

        $id = dcrypt::privDecrypt($_GET['id']);
        $ltime = 24 * 3600;
        $state = 0;
        $isArr = cookie("review_praise");
        $isArr = unserialize($isArr);
        if ($isArr) {
            $str = array_search($id, $isArr[$ip]);
            if ($str !== FALSE) {
                $state = 1;
            } else {
                $isArr[$ip][] = $id;
                $isArr = serialize($isArr);
                cookie("review_praise", $isArr, $ltime);
            }
        } else {
            $content[$ip][] = $id;
            $content = serialize($content);
            cookie("review_praise", $content, $ltime);
        }

        if ($state) {
            $output = array('code' => -4, 'mes' => '今天已赞，可以明天再来');
            exit(json_encode($output));
        } elseif (!empty($id)) {
            $praise = $this->review->getlist("id='{$id}'", "praise", 3);
            $praise_num = $praise + 1;
            $this->review->ufields = array(
                "praise" => $praise_num,
                "ip" => $ip,
            );
            $this->review->where = "id=$id";
            $res = $this->review->update();
            if ($res) {
                $output = array('code' => 1, 'mes' => '赞成功', 'count' => $praise_num);
                exit(json_encode($output));
            } else {
                $output = array('code' => 0, 'mes' => '赞失败');
                exit(json_encode($output));
            }
        }
    }

    //热门关键词
    function doKey() {
        $value = $this->pagedata->getSomePagedata("value", "name='searchlist'", 3);
        if ($value) {
            $list = unserialize($value);
            foreach ($list as $key => $value) {
                $price[$key] = $value['orderby'];
            }

            array_multisort($price, SORT_NUMERIC, SORT_DESC, $list);
            $lists = array_chunk($list, 9);
            exit(json_encode($lists[0]));
        } else {
            $output = array('code' => 0, 'mes' => '获取数据失败');
            exit(json_encode($output));
        }
    }

    function doGetList() {
        $keywords = dcrypt::privDecrypt($_POST['keywords']);

        $list = $this->search->getlisk($keywords, 5);
        if ($list) {
            $output = array('code' => 1, 'mes' => '获取成功', 'list' => $list);
            exit(json_encode($output));
        } else {
            $output = array('code' => 0, 'mes' => '获取数据失败');
            exit(json_encode($output));
        }
    }

    function doSearchList() {
        global $local_host;
        //接收值
        $keywords = preg_replace("/\/|\~|\!|\@|\#|\\$|\%|\^|\&|\*|\(|\)|\_|\+|\{|\}|\:|\<|\>|\?|\[|\]|\,|\.|\/|\;|\'|\`|\-|\=|\\\|\|\"|/", '', preg_replace('/(https?|ftp):\/\/[-A-Z0-9+&@#\/%?=~_|$!:,.;]*[A-Z0-9+&@#\/%=~_|$]/im', '', preg_replace('/<(.*?)>/is', "", strip_tags(dcrypt::privDecrypt($_GET['keywords'])))));

        if (!empty($keywords)) {
            //推荐标签

            $list = $this->search->getliek($keywords);
            if (!empty($list)) {
                $pv = array();
                foreach ($list as $k) {
                    $pv[] = $k['count'];
                }
                array_multisort($pv, SORT_DESC, $list);
                $list = array_chunk($list, 2);
            }

            //文章内容
            $page = dcrypt::privDecrypt($_GET['k']);
            $page = max(1, $page);
            $page_size = 10;
            $page_start = ($page - 1) * $page_size;
            $sort = "uptime desc";
            $listc = $this->search->getSphinx($keywords, $sort, $page_size, $page_start);
            if (!empty($listc)) {
                $pv = array();
                $uptime = array();
                foreach ($listc as $k) {
                    $pv[] = $k['count'];
                    $uptime[] = $k['uptime'];
                }
                array_multisort($pv, SORT_DESC, $uptime, SORT_DESC, $listc);
            }
            if ($listc)
                foreach ($listc as $key => $value) {
                    $review = $this->review->getList("article_id='$value[id]' and state=1");
                    if ($value['type_id'] == 1) {
                        $lists[] = array(
                            'id' => $value['id'],
                            'title' => $value['title'],
                            'title2' => $value['title2'],
                            'pic' => replaceImageUrl($local_host . UPLOAD_DIR . $this->article->getArticlePic($value['pic'], '280x186')),
                            'uptime' => date("Y-m-d", $value['uptime']),
                            'chief' => $value['chief'],
                            'type_id' => $value['type_id'],
                            'p_category_id' => $this->categorys->getParentId($value['category_id']),
                            'comment' => count($review)
                        );
                    } else {
                        $lists[] = array(
                            'id' => $value['id'],
                            'title' => $value['title'],
                            'pic' => replaceImageUrl($local_host . UPLOAD_DIR . $this->article->getArticlePic($value['pic'], '280x186')),
                            'uptime' => date("Y-m-d", $value['uptime']),
                            'chief' => $value['chief'],
                            'type_id' => $value['type_id'],
                            'p_category_id' => $this->categorys->getParentId($value['category_id']),
                            'source' => $value['source'],
                            'comment' => count($review)
                        );
                    }
                }
        } else {
            $output = array('code' => -1, 'mes' => '关键词不能为空');
            exit(json_encode($output));
        }

        //计算总记录条数
        $num = count($lists);
        //计算页数
        $pages = ceil($num / $page_size);

        if (is_numeric($page)) {
            if ($page > $pages) {
                $output = array('code' => 2, 'mes' => '没有数据了');
                exit(json_encode($output));
            } else {
                $newarr = array_slice($lists, $page_start, $page_size);
                if (!$newarr) {
                    $output = array('code' => 1, 'mes' => '获取内容失败');
                    exit(json_encode($output));
                }
            }
        }
        echo json_encode($newarr);
    }

    //文章详情
    function doFinal() {
        global $local_host;
        if ($_GET['m'] == 'black') {
            $template_name = "app_bfinal";
        } else {
            $template_name = "app_final";
        }

        $aa = $this->filter(dcrypt::privDecrypt($_GET['aid']), HTTP_FILTER_INT);
        if (!empty($aa)) {
            $aid = $aa;
        } else {
            $aid = $this->filter($_GET['aid'], HTTP_FILTER_INT);
        }
        $article = $this->article->getlist("*", "id='{$aid}' and state=3", 2);
        if ($article) {
            foreach ($article as $key => $value) {
                $a = explode(',', $value['series_list']);
                $tui = $this->article->getlists("id,title,title2,uptime", "FIND_IN_SET('$a[0]', series_list) and state=3 and type_id=1 limit 3", 2);

                $lists[] = array(
                    'id' => $value['id'],
                    'title' => $value['title'],
                    'title2' => $value['title2'],
                    'content' => $value['content'],
                    'chief' => $value['chief'],
                    'editor' => $value['editor'],
                    'author' => $value['author'],
                    'photor' => $value['photor'],
                    'pic' => replaceImageUrl($local_host . UPLOAD_DIR . $this->article->getArticlePic($value['pic'], '280x186')),
                    'uptime' => date("Y-m-d", $value['uptime']),
                    'p_category_id' => $this->categorys->getParentId($value['category_id'])
                );
            }
            $lists[0][content] = preg_replace('/<p>\s+(&nbsp;|<br \/>)\s+<\/p>/sim', '', $lists[0][content]);
            $lists[0][content] = preg_replace('/<([a-z]+)\s+class="MsoNormal"[^>]*>/sim', '<\1>', $lists[0][content]);
            $lists[0][content] = preg_replace('%<p>\s+<img([^>]+)>\s+</p>%sim', '<p style="text-align:center;"><img\1></p>', $lists[0][content]);
            $lists[0][content] = preg_replace('%<p>\s*<span[^>]*>\s*<img([^>]+)>.+?</span>%sim', '<p style="text-align:center;"><img\1>', $lists[0][content]);
            $lists[0]['content'] = replaceImageUrl($lists[0]['content']);
            foreach ($tui as $k => $v) {
                if ($v['id'] == $aid) {
                    unset($tui[$k]);
                }
            }
            $this->vars("list", $lists[0]);
            $this->vars("tui", $tui);
            $this->template($template_name, '', 'replaceArticleUrl');
        } else {
            $output = array('code' => -1, 'mes' => '数据为空');
            exit(json_encode($output));
        }
    }

    //视频详情
    function doVideoFinal(){
        global $local_host;

        if(dcrypt::privDecrypt($_GET['m'])=='black'){
            $template_name = "app_bvfinal";
        }else{
            $template_name = "app_vfinal";
        }

        $a = $this->filter(dcrypt::privDecrypt($_GET['aid']), HTTP_FILTER_INT);
        if(!empty($a)){
            $aid = $a;
        }else{
            $aid = $this->filter($_GET['aid'], HTTP_FILTER_INT);
        }
        $value = $this->pagedata->getSomePagedata("value", "name='video'", 3);
        $video = unserialize($value);
        if($video)
            foreach ($video as $key => $value) {
                $video[$key]['pic'] = $this->article->getArticlePic($value['pic'], '280x186');
            }
        $article = $this->article->getlist("*", "id='{$aid}' and state=3", 2);
        if($article){
            foreach ($article as $key => $value) {
                $findme   = 'player.youku.com';
                $pos = strpos($value['source'], $findme);
                
                // 注意这里使用的是 ===。简单的 == 不能像我们期待的那样工作，
                if ($pos === false) {
                    //http://yuntv.letv.com/bcloud.html?uu=35hygmrzpc&vu=00fbb433fc&auto_play=1&gpcflag=1&width=800&height=576
                    $uu = substr($value['source'],37,-57);
                    $vu = substr($value['source'],51,-43);
                    $type = 1;
                    $this->vars("type", $type);
                    $this->vars("uu", $uu);
                    $this->vars("vu", $vu);
                    
                } else {
                    $source = "http://player.youku.com/embed/".substr($value['source'],39,-6);
                }

                $lists[] = array(
                    'id' => $value['id'],
                    'title' => $value['title'],
                    'chief' => $value['chief'],
                    'source' => $source,
                    'author' => $value['author'],
                    'pic' => replaceImageUrl($local_host . UPLOAD_DIR . $this->article->getArticlePic($value['pic'], '280x186')),
                    'uptime' => date("Y-m-d", $value['uptime'])
                );
            }

            $this->vars("list", $lists[0]);
            $this->vars("video", $video);
            $this->template($template_name, '', 'replaceArticleUrl');
        }else{
            $output = array('code' => -1, 'mes' => '数据为空');
            exit(json_encode($output));
        }
        
    }

}
