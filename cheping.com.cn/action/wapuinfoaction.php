<?php

/**
 * wap视频页 video
 * $Id: wapvideoaction.php 983 2015-11-23 10:56:45Z cuiyuanxin $
 */
class wapuinfoAction extends action {

    function __construct() {
        parent::__construct();
        $this->user = new users();
        $this->profiles = new users_profiles();
        $this->soapmsg = new soapmsg();
        $this->shortmsg = new shortMsg();
        $this->review = new reviews();
        $this->username = session('username');
        $this->collect = new collect();
        $this->uid = session('uid');
//        $this->uid = 198;
        if (!$this->uid) {
            if (isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER["HTTP_X_REQUESTED_WITH"]) == "xmlhttprequest") {
                echo 90;
                exit;
            } else {
                header('Location:/waplogin.php?action=Login');
            }
        }
    }

    /**
     * 个人页
     */
    function doUinfo() {
        $useinfo = $this->profiles->getUsers($this->uid); //根据uid查询个人头像
        $this->vars('name', $this->username);
        $this->vars('users', $useinfo);
        $this->template('wap_uinfo', '', 'replaceWapNewsUrl');
    }

    /**
     * 修改个人页的地址
     */
    function doAddress() {
        $province = $_POST['province'];
        $city = $_POST['city'];
        $county = $_POST['county'];
        $ufields = array("province" => "$province", "city" => "$city", "county" => "$county");
        $where = 'uid =' . $this->uid;
        $id = $this->profiles->updateUser($ufields, $where);
    }

    /**
     * 修改个人页的姓名
     */
    function doPersons() {
        $key = $_POST['type'];
        $vals = $_POST['editval'];
        $filed = array("$key" => "$vals", "updated" => time()); //按键和值组合成符合要求的数组,成为修改的字段
        $where = "id=" . $this->uid;
        $sucess = $this->user->updateUser($filed, $where);
        if ($sucess) {
            echo 1;
            exit;
        }
    }

    /**
     * 点击修改生日
     */
    function doPerson() {
        if ($_POST) {
            $key = $_POST['type'];
            $vals = $_POST['editval'];
            $regarr = array('birthday' => '/\w/', 'province' => '/\D*/', 'address' => '/\D*/', 'zipcode' => '/[1-9]\d{5}(?!\d)/', 'qq' => '/^\d{5,10}$/');
            if (preg_match($regarr[$key], $vals)) {
                $filed = array("$key" => "$vals"); //按键和值组合成符合要求的数组,成为修改的字段
                $where = "uid=" . $this->uid;
                $sucess = $this->profiles->updateUser($filed, $where);
                if ($sucess) {
                    echo 1;
                    exit;
                }
            }
        } else {
            $info = $this->profiles->getUsers($this->uid); //查询用户的信息
            $user = $this->user->getUsers($this->uid); //查询用户的名字和电话号码
        }

        $title = "wap-个人管理";
        $css = array('reset', 'people');
        $js = array("jquery-1.8.3.min", "address");
        $this->vars('css', $css);
        $this->vars('js', $js);
        $this->vars("title", $title);
        $this->vars("user", $user);
        $this->vars('info', $info);
        $this->vars('name', $this->username);
        $this->template('wap_person', '', 'replaceWapNewsUrl');
    }

    /**
     * 点击修改手机号
     */
    function doSendCode() {
        $this->smstpl = new smsTpl();
        $phone = $_GET['mobile'];
        $code = mt_rand(1000, 9999);
        session("code_o", $code);
        session("mobile", $phone);
        // var_dump(session("code_o"));
        $msgTpl = $this->smstpl->getTpl($this->shortmsg->tpl_flag['code_o']);
        $msg = str_replace('{$code_o}', $code, $msgTpl);
        $state = $this->soapmsg->postMsg($phone, $msg);
        if ($state == 2)
            $this->shortmsg->recordMsg(0, $state, $this->shortmsg->tpl_flag['code_o'], $phone, $msg);
        echo $state;
    }

    /**
     * 点击修改手机号
     */
    function doCheckCode() {
        $code = filter_input(INPUT_GET, 'code', FILTER_SANITIZE_MAGIC_QUOTES);
        $get_pcode = session("code_o"); 
        if ($get_pcode == $code) {
            echo 1;
            exit;
        } else {
            echo -4;
        }
    }

    /**
     * 更改手机号页面
     */
    function doiphone() {
        //根据uid查询手机号写到页面上
        $ic = $this->user->getUsers($this->uid);
        $iphone = substr_replace($ic[mobile], '****', 3, 4);
        $this->vars('mobile', $ic['mobile']);
        $this->vars('iphone', $iphone);
        $this->template('wap_iphone', '', 'replaceWapNewsUrl');
    }

    /**
     * 接受新手机号手机号码
     */
    function doiphoneson() {
        $mobile = $_POST['mobile'];
        $list = $this->user->getUsers($this->uid); //新手机号和旧手机号不能相等
        $filds = "id";
        $where = "mobile=" . $mobile;
        $iphoneId = $this->user->fildss($filds, $where); //查询新换的手机号是不是数据库里有
        $mobile_reg = "/^(13|18|15|17)\d{9,}$/";
        $reg = preg_match($mobile_reg, $mobile);
        if ($reg == 1) {
            if ($iphoneId || $list['mobile'] == $mobile) {
                echo 2;
                exit;
            } 
        }
        $this->template('wap_iphoneson', '', 'replaceWapNewsUrl');
    }

    /**
     * 修改手机的验证码页面
     */
    function doiphoneson2() {
        $code = $_POST['code'];
        $codes = session("code_o");
        $mobile = session("mobile");
        if ($codes == $code) {
            $filed = array("mobile" => "$mobile", "updated" => time()); //按键和值组合成符合要求的数组,成为修改的字段
            $where = "id=" . $this->uid;
            $sucess = $this->user->updateUser($filed, $where);
            if ($sucess) {
                echo 1;
                exit;
            }
        }
        $this->template('wap_iphoneson2', '', 'replaceWapNewsUrl');
    }

    /**
     * 页面无刷新上传图片
     */
    function doAjaxUpload() {
        import("imagemark.class", "lib");
        $maxSize = 1024 * 1024 * 5;
        $date = date("Ym", time());
        $subDir = "/images/avatar/$date/";
        $uploadDir = ATTACH_DIR . $subDir;
        file::forcemkdir($uploadDir);
        $fileExt = file::extname($_FILES['upfile'][name]);
        $fileName = util::random(16) . '.' . $fileExt;
        if (isset($_POST['upload'])) {
            $aa = move_uploaded_file($_FILES['upfile']['tmp_name'], $uploadDir . $fileName); //移动到指定得目录
            $sucess = $this->profiles->updateUser(array('avatar' => $subDir . $fileName), "uid=" . $this->uid); //插入到数据库
            $flag = $subDir . $fileName;
            echo $flag;
        }
    }

    /**
     * 我的收藏
     */
    function douCollect() {
        $this->collect = new collect();
        $fields = "ca.title,ca.title2,ca.pic,ca.source,ca.type_id,ca.seriesname_list,ca.tagname_list,cc.*,ca.id as ids";
        $list = $this->collect->getCollects($this->uid, $fields); //查询我的收藏中文章和视频
        $this->vars('list', $list);
        $this->template('wap_ucollect', '', 'replaceWapNewsUrl');
    }

    /**
     * 我的评论
     */
    function douReview() {
        $filed = "cup.avatar,cr.*,ca.title,ca.type_id,ca.id as ids";
        $where = "cr.article_id = ca.id and cup.uid = cr.uid and cr.parentid=0 and cr.uid=" . $this->uid;
        $list = $this->review->getownReview($where, $filed);
        $this->vars('list', $list);
        $this->template('wap_ureview', '', 'replaceWapNewsUrl');
    }

    /**
     * 别人回复我的
     */
    function doOreview() {
        $result = array(); //声明一个新数组
        $reviewId = $this->review->getTags($fields, $this->uid, 2);
        foreach ($reviewId as $key => $val) {
            $filed = "cup.avatar,cr.*,ca.title,ca.type_id";
            $where = "parentid =" . $val["id"] . " and cr.uid=cup.uid and cr.article_id = ca.id";
            $result[$key] = $this->review->getownReview($where, $filed); //把查到的数据在放回数组
        }
        $this->vars('list', $result);
        $this->template('wap_oreview', '', 'replaceWapNewsUrl');
    }

    //文章评论中的ajax请求
    function doAjaxReview() {
        $revieids = $_POST['rids'];
        $content = trim($_POST['content']);
        $articleId = $_POST['articleId'];
        $ip = util::getip();
        //查询头像
        $val = $this->profiles->getUsers($this->uid);
        if ($content == '') {
            $this->alert('发布内容不能为空', 'js', 3, '');
        } else {
            if ($revieids == 0) {
                //插入数据库
                $this->review->ufields = array(
                    "content" => "$content",
                    "article_id" => "$articleId",
                    "uid" => "$this->uid",
                    "uname" => "$username",
                    "state" => "1",
                    "ip" => "$ip",
                    "created" => time()
                );
                $reviewId = $this->review->insert();
                if ($reviewId) {
                    $wherei = "cr.article_id=" . $articleId . " and cr.uid=" . $this->uid . " and cup.uid=cr.uid and cr.id=" . $reviewId;
                    $result = $this->review->getoReview($wherei); //查询评论表关于我的评论
                    $json = '';
                    if ($result) {
                        $json .= '<div class="model-first"><div class="circleimg fl">';
                        $json .= '<img src="';
                        if ($result['avatar'] == '') {
                            $json .= 'images/cricleimg.png';
                        } else {
                            $json .= '/attach' . $val['avatar'];
                        }
                        $json .= '" width="100%"/></div><div class="discript fl"><p class="padg8">' . $result['uname'] . '</p><p class="padg8 discrp1">' . format_date($result['created']) . '</p>';
                        $json .= '<p class="padg8 discrp2" id="reviewTone"><span id="reviewone">' . $result['content'] . '</span><span class="return fr"><a href="">回复</a></span></p></div><div class="clear"></div></div>';
                        echo $json;
                    }
                }
            } else {
                $this->review->ufields = '';
                $this->review->ufields = array(
                    "content" => "$content",
                    "article_id" => "$articleId",
                    "uid" => "$this->uid",
                    "parentid" => "$revieids",
                    "uname" => "$username",
                    "state" => "1",
                    "ip" => "$ip",
                    "created" => time()
                );
                $reviewId = $this->review->insert();
                if ($reviewId) {
                    $wherei = "cr.article_id=" . $articleId . " and cr.uid=" . $this->uid . " and cup.uid=cr.uid and cr.id=" . $reviewId;
                    $result = $this->review->getoReview($wherei); //查询评论表关于我的评论
                    $json = '';
                    if ($result) {
                        $json .= '<div class="model-first"><div class="circleimg fl">';
                        $json .= '<img src="';
                        if ($result['avatar'] == '') {
                            $json .= 'images/cricleimg.png';
                        } else {
                            $json .= '/attach' . $val['avatar'];
                        }
                        $json .= '" width="100%"/></div><div class="discript fl"><p class="padg8">' . $result['uname'] . '</p><p class="padg8 discrp1">' . format_date($result['created']) . '</p>';
                        $json .= '<p class="padg8 discrp2" id="reviewTone"><span id="reviewone">' . $result['content'] . '</span></p></div><div class="clear"></div></div>';
                        echo $json;
                    }
                }
            }
        }
    }

    /**
     * 处理文章最终页的ajax传值收藏功能
     */
    function doCollect() {
        $n = $_POST["n"];
        $username = "wangqin";
        $articleId = $_POST['articleId'];
        $categoryId = $_POST['categoryId'];
        $typeId = $_POST['typeId'];
        $where = "uid=" . $this->uid . " and article_id=" . $articleId;
        if ($n == 1) {
            $collect = $this->collect->getCollect($where);
            if ($collect) {
                $ufields = array("state" => "1", "updated" => time());
                $ids = $this->collect->updateCpllect($ufields, $where);
                echo 1;
                exit;
            } else {
                $this->collect->ufields = array(
                    "uid" => "$this->uid",
                    "uname" => "$username",
                    "article_id" => "$articleId",
                    "category_id" => "$categoryId",
                    "type_id" => "$typeId",
                    "state" => "1",
                    "created" => time()
                );
                $id = $this->collect->insert();
                echo 2;
                exit;
            }
        } else {
            $ufields = array("state" => "0", "updated" => time());
            $ids = $this->collect->updateCpllect($ufields, $where);
            echo 3;
            exit;
        }
    }

}
