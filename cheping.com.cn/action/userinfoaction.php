<?php

/**
 * $Id: userinfoaction.php 1254 2015-11-13 09:16:34Z xiaodawei $
 */
class userinfoAction extends action {

    var $genderArray = array(
        '0' => '女',
        '1' => '男'
    );
    var $countryArray = array(
        '0' => '中国',
        '1' => '海外'
    );

    function __construct() {
        parent::__construct();
        $this->collect = new collect();
        $this->reviews = new reviews();
        $this->users = new users();
        $this->users_profiles = new users_profiles();
        $this->province = new province();
        $this->city = new city();
        $this->article = new article();
        $this->smstpl = new smstpl();
        $this->soapmsg = new soapmsg();
        $this->smslog = new shortmsg();


        $this->uid = session("uid");
        if (!$this->uid) {
            header("location:login.php");
        }
        $reviewscount = @$this->reviews->getCounts($this->uid);
        $collectcount = @$this->collect->getCountss($this->uid);
        $users = @$this->users->getList("cu.id=$this->uid and cu.state=1", "cu.username,cup.avatar", 1);
        $this->vars("users", $users);
        $this->vars("collectcount", $collectcount ? $collectcount : 0);
        $this->vars("reviewscount", $reviewscount ? $reviewscount : 0);
    }

    function doDefault() {
        $this->doIndex();
    }

    function doIndex() {
        $template = "user_user";
        $users = @$this->users->getList("cu.id=$this->uid and cu.state=1", "cu.username,cup.avatar", 1);
        $title = $users['username'] . "的个人主页-" . SITE_NAME;
        $keyword = $users['username'] . "的个人主页,车评网";
        $description = $users['username'] . "的个人主页！";
        $reviewlist = $this->reviews->getListlimit("cr.uid=$this->uid", "cr.id,cr.content,cr.article_id,ca.title,ca.id caid,ca.type_id,ca.uptime,ca.pic,cr.created,cr.state", 4, 0, array('cr.id' => 'desc'), 2);
        foreach ($reviewlist as $k => $v) {
            /* php计算多少分钟前，多少小时前，多少天前的函数调用 */
            $newtime = $v[created];
            $reviewlist[$k][time] = $this->format_date($newtime);
        }

        $collectlist = $this->collect->getListlimit("cc.uid=$this->uid", "ca.title,ca.id caid,ca.type_id,ca.uptime,cc.created,cc.id,ca.pic", 4, 0, array('cc.id' => 'desc'), $type = 2);
        foreach ($collectlist as $k => $v) {
            /* php计算多少分钟前，多少小时前，多少天前的函数调用 */
            $newtime = $v[created];
            $collectlist[$k][time] = $this->format_date($newtime);
            $collectlist[$k]['pic'] = $this->article->getArticlePic($v['pic'], '280x186');
        }

        $this->vars("reviewlist", $reviewlist);
        $this->vars("collectlist", $collectlist);
        $this->vars("title", $title);
        $this->vars("keyword", $keyword);
        $this->vars("description", $description);
        $this->vars("css", array('gerencommom', 'geren', 'sousuo', 'gerenxinxi'));
        $this->vars("js", array('global'));


        $this->template($template);
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

    function douserinfo() {
        if ($_POST) {
            $userinfoid = $this->users_profiles->getUser("uid", "uid=$this->uid", 3);
            $receiveArr = array('birthday', 'country', 'province', 'city', 'address', 'zipcode', 'qq');
            foreach ($receiveArr as $key => $value) {
                $ufields[$value] = $_POST[$value];
            }
            if ($userinfoid) {
                $profiles_id = $this->users_profiles->updateUser($ufields, "uid=$this->uid");
            } else {
                $ufields['uid'] = $this->uid;
                $profiles_id = $this->users_profiles->addUser($ufields);
            }
            $user_id = $this->users->updateUser(array("realname" => $_POST['realname'], "gender" => $_POST['gender']), "id=$this->uid");
            if ($profiles_id || $user_id)
//                $this->alert("修改信息成功！", 'js', 3, "user.php?action=userinfo");
                header("location:user.php?action=userinfo");
            else
//                $this->alert("修改信息失败！", 'js', 3, "user.php?action=userinfo");
                header("location:user.php?action=userinfo");
        } else {
            $template = "userinfo";
            $user = $this->users->getUser("username,realname,email,mobile,gender,id", "id=$this->uid and state=1", 1);
            foreach ($user as $k => $v) {
                $user[mobiles] = preg_replace("/(1\d{1,2})\d\d(\d{0,3})/", "\$1*****\$3", $user[mobile]);
            }
            $userinfo = $this->users_profiles->getUser("*", "uid=$this->uid", 1);
            $list = $this->province->getList("name", "id=" . $userinfo[province], 3);
            $lists = $this->city->getList("name", "id=" . $userinfo[city], 3);
            foreach ($userinfo as $k => $v) {
                $userinfo[provinces] = $list;
                $userinfo[citys] = $lists;
            }

            $province = $this->province->getList("id,name", "region_id=" . $userinfo[country], 2);
            $city = $this->city->getList("id,name", "province_id=" . $userinfo[province], 2);



            $this->vars("code", $_GET[code]);
            $this->vars("flag", session("flag"));
            $this->vars("user", $user);
            $this->vars("userinfo", $userinfo);
            $this->vars("province", $province);
            $this->vars("city", $city);
            $this->vars('genderArray', $this->genderArray);
            $this->vars('countryArray', $this->countryArray);
            $this->vars("title", "个人中心详情-车评");
            $this->vars("css", array('jquery.Jcrop', 'gerencommom', 'gerenxinxi', 'sousuo'));
            $this->vars("js", array('userinfo', 'global', 'geren', 'jquery.min', 'jquery.Jcrop', 'ajaxfileupload'));
            $this->template($template);
        }
    }

    function docollect() {
        $template = "usercollect";

        $where = "cr.uid=$this->uid and cr.article_id=ca.id";
        $category = $this->collect->getCountsss($where);
        $where = "cc.uid=$this->uid";
        $this->collect->getListlimitPages($where, "cc.id,ca.title,ca.pic,ca.type_id,cc.created", 2);
        $totals = $this->collect->total;

        $page = max(1, $_GET['page']);
        $limit = 20;
        $offset = ($page - 1) * $limit;

        if (!$_GET['category_id']) {
            $where = "cc.uid=$this->uid";
            $list = $this->collect->getListlimitPage($where, "cc.id,ca.title,ca.id caid,ca.pic,ca.type_id,ca.uptime,cc.created", $limit, $offset, array('cc.id' => 'desc'), 2);
            $total = $this->collect->total;
            $url = "user.php?action=collect";
            $page_bar = multipage::multi($total, $limit, $page, $url);
        } else {
            $where = "cc.uid=$this->uid and cc.category_id=$_GET[category_id]";
            $list = $this->collect->getListlimitPage($where, "cc.id,ca.title,ca.id caid,ca.pic,ca.type_id,ca.uptime,cc.created", $limit, $offset, array('cc.id' => 'desc'), 2);
            $total = $this->collect->total;
            $url = "user.php?action=collect";
            $page_bar = multipage::multi($total, $limit, $page, $url);
        }

        foreach ($list as $k => $v) {
            $list[$k]['pic'] = $this->article->getArticlePic($v['pic'], '280x186');
        }

        $this->vars("list", $list);
        $this->vars("category_id", $_GET['category_id']);
        $this->vars("category", $category);
        $this->vars("allnum", $totals);
        $this->vars("page_bar", $page_bar);
        $this->vars("title", "个人中心收藏-车评");
        $this->vars("css", array('gerencommom', 'geren', 'sousuo', 'gerenxinxi'));
        $this->vars("js", array('global'));
        $this->template($template);
    }

    function doreview() {
        $template = "userreview";
        //$where = "cr.uid=$this->uid and cre.parentid=cr.id and cre.parentid!=0 and cr.article_id=ca.id and ca.state=3";
        //$lists = $this->reviews->getCountsss($where,$page_size, $page_start, array('cre.created' => 'desc'));

        $page = $_GET['page'];
        $page = max(1, $page);
        $page_size = 2;
        $page_start = ($page - 1) * $page_size;
        $type = $_GET['type'];
        switch ($type) {
            case 1:
                //我的评论
                $where = "cr.uid=$this->uid and cr.article_id=ca.id and ca.state=3 and cr.parentid=0";
                $list = $this->reviews->getListlimitPage($where, $page_size, $page_start, array('cr.created' => 'desc'));
                if($list)
                foreach ($list as $k => $v) {
                    /* php计算多少分钟前，多少小时前，多少天前的函数调用 */
                    $newtime = $v[created];
                    $list[$k][time] = $this->format_date($newtime);
                }
                $extra.="/user.php?action=review&type=1";
                $page_bar = multipage::multi($this->reviews->total[0][count], $page_size, $page, $_ENV['PHP_SELF'] . $extra, 0, 4);

                break;
            case 2:
                //被评论
                $where = "cr.uid=$this->uid and cre.parentid=cr.id and cre.parentid!=0 and cr.article_id=ca.id and ca.state=3";
                $lists = $this->reviews->getCountsss($where, $page_size, $page_start, array('cre.created' => 'desc'));
                if($lists)
                foreach ($lists as $k => $v) {
                    /* php计算多少分钟前，多少小时前，多少天前的函数调用 */
                    $newtime = $v[created];
                    $lists[$k][time] = $this->format_date($newtime);
                }
                $extra.="/user.php?action=review&type=2";
                $page_bar = multipage::multi($this->reviews->total[0][count], $page_size, $page, $_ENV['PHP_SELF'] . $extra, 0, 4);

                break;
        }


        $this->vars("type", $_GET['type']);
        $this->vars("list", $list);
        $this->vars("lists", $lists);
        $this->vars("page_bar", $page_bar);

        $this->vars("downlistcount", $this->reviews->total[0][count]);
        $this->vars("title", "个人中心评论-车评");
        $this->vars("css", array('gerencommom', 'geren', 'sousuo', 'gerenxinxi')); //, 'index'
        $this->vars("js", array('global'));
        $this->template($template);
    }

    function dodelreview() {
        $id = $_GET['id'];
        $type = $_GET['type'];
        $where = "id=$id";
        if ($type == 1) {
            $ret = $this->reviews->delList($where);
            if ($ret)
            //$this->alert("删除失败！", 'js', 3, "user.php");
                header("location:/user.php?action=reviews&type=1");
            else
            //$this->alert("删除成功！", 'js', 3, "user.php");
                header("location:/user.php?action=reviews&type=1");
        }else if ($type == "1c") {
            $ret = $this->reviews->delList($where);
            if ($ret)
            //$this->alert("删除失败！", 'js', 3, "user.php");
                header("location:/user.php");
            else
            //$this->alert("删除成功！", 'js', 3, "user.php");
                header("location:/user.php");
        }else {
            $ret = $this->reviews->delList($where);
            if ($ret)
            //$this->alert("删除失败！", 'js', 3, "user.php");
                header("location:/user.php?action=reviews&type=2");
            else
            //$this->alert("删除成功！", 'js', 3, "user.php");
                header("location:/user.php?action=reviews&type=2");
        }
    }

    function doupdatecollect() {
        $id = $_GET['id'];
        $where = "id=$id";
        //$ufields = array("state"=>2);
        $ret = $this->collect->delList($where);
        if ($ret)
        //$this->alert("取消失败！", 'js', 3, "user.php");
            header("location:user.php");
        else
        //$this->alert("取消成功！", 'js', 3, "user.php");
            header("location:user.php");
    }

    //检测验证码是否有效
    function doCheckCode() {

        $code = $_GET['code'];
        $findCode = session('code_o');
        if ($code == $findCode) {
            echo 1;
        } else {
            echo 0;
        }
    }

    function doCheckCodes() {

        $code = $_GET['code'];
        $findCode = session('code_os');
        if ($code == $findCode) {
            echo 1;
        } else {
            echo 0;
        }
    }

    function doCheckCodess() {

        $code = $_GET['code'];
        $findCode = session('code_oss');
        if ($code == $findCode) {
            echo 1;
        } else {
            echo 0;
        }
    }

    //发送验证码
    function doSendCode() {
        $mobile = $_GET['mobile'];
        //var_dump($mobile);
        if ($mobile) {
            $code = mt_rand(1000, 9999);
            session("code_o", $code);
            $msgTpl = $this->smstpl->getTpl($this->smslog->tpl_flag['code_o']);

            $msg = str_replace('{$code_o}', $code, $msgTpl);
            $state = $this->soapmsg->postMsg($mobile, $msg);

            $this->smslog->recordMsg(0, $state, $this->smslog->tpl_flag['code_o'], $mobile, $msg);
            if ($state == 2) {
                echo json_encode(array('ok'));
            } else {
                echo json_encode(array('error'));
            }
        }
    }

    function doSendCodes() {

        $mobile = $_POST['dealType3'];
        $id = $_POST['uid3'];
        $code = $_POST['code3'];
        if ($mobile) {
            session("code_os", $code);
            $msgTpl = $this->smstpl->getTpl($this->smslog->tpl_flag['code_os']);
            $msg = str_replace('{$code_os}', $code, $msgTpl);
            $state = $this->soapmsg->postMsg($mobile, $msg);

            $this->smslog->recordMsg(0, $state, $this->smslog->tpl_flag['code_os'], $mobile, $msg);
//            $msg = $code . '（请在十分钟内输入有效验证码！）';
//            $state = $this->soapmsg->postMsg($mobile, $msg);
//            $this->smslog->recordMsg(0, $state, 10, $mobile, $msg);
//            $this->smstpl = new smstpl();
//        $this->soapmsg = new soapmsg();
//        $this->smslog = new shortmsg();

            if ($state == 2) {
                echo json_encode(array('ok'));
            } else {
                echo json_encode(array('error'));
            }
        }
    }

    function doSendCodess() {

        $mobile = $_POST['dealType2'];
        $id = $_POST['uid2'];
        $code = $_POST['code2'];
        if ($mobile) {
            session("code_oss", $code);
            $msgTpl = $this->smstpl->getTpl($this->smslog->tpl_flag['code_o']);

            $msg = str_replace('{$code_o}', $code, $msgTpl);
            $state = $this->soapmsg->postMsg($mobile, $msg);

            $this->smslog->recordMsg(0, $state, $this->smslog->tpl_flag['code_o'], $mobile, $msg);
////            $msg = $code . '（请在十分钟内输入有效验证码！）';
////            $state = $this->soapmsg->postMsg($mobile, $msg);
////            $this->smslog->recordMsg(0, $state, 10, $mobile, $msg);
            if ($state == 2) {
                echo json_encode(array('ok'));
            } else {
                echo json_encode(array('error'));
            }
        }
    }

    function uploadpic($dir, $name) {
        $upfile = $_FILES[$name];
        $subDir = "images/$dir/";
        $uploadDir = ATTACH_DIR . $subDir;
        file::forcemkdir($uploadDir);

        $fileExt = file::extname($upfile['name']);
        $fileName = util::random(16) . '.' . $fileExt;
        move_uploaded_file($upfile['tmp_name'], $uploadDir . $fileName);

        return $flag = $subDir . $fileName;
    }

    function domobile() {
        if ($_GET[type] == 1) {
            $code = $_POST[code];
            //session("codes", $code);
            //return $code;
            header("location:user.php?action=userinfo&code=$code");
        } else {
            $mobile = $_POST['mobile'];
            $id = $_POST['id'];
            $res = $this->users->updateUser(array('mobile' => $mobile), "id=$id");
            if ($res) {
                //$this->alert("修改成功！", 'js', 3, "user.php?action=userinfo");
                header("location:user.php?action=userinfo");
            } else {
                //$this->alert("修改失败！", 'js', 3, "user.php?action=userinfo");
                header("location:user.php?action=userinfo");
            }
        }
    }

    function dopassword() {
        $password = md5($_POST['password']);
        $id = $_POST['id'];
        $res = $this->users->updateUser(array('password' => $password), "id=$id");
        if ($res) {
            //$this->alert("修改成功！", 'js', 3, "user.php?action=userinfo");
            header("location:user.php?action=userinfo");
        } else {
            //$this->alert("修改失败！", 'js', 3, "user.php?action=userinfo");
            header("location:user.php?action=userinfo");
        }
    }

//    function doUpload() {
//        import("imagemark.class", "lib");
//        //$name = $_POST['f'];
//        $maxSize = 1024 * 1024 * 5;
//        $ext = array('jpg', 'jpeg', 'gif', 'bmp','png');
//        $date = date("Ym", time());
//        $subDir = "images/123/$date/";
//        $uploadDir = ATTACH_DIR . $subDir;
//        file::forcemkdir($uploadDir);
//        $upfile = $_FILES['f'];
//        $fileExt = file::extname($upfile['name']);
//        $fileName = util::random(16) . '.' . $fileExt;
//        //var_dump($upfile);
//        #文件超过最大限制
//        if ($upfile['size'] > $maxSize)
//            $flag = 1;
//        #上传文件格式错误
//        elseif (!in_array($fileExt, $ext))
//            $flag = 2;
//        elseif ($upfile['error'] > 0)
//            $flag = 0;
//        else {
//            if (move_uploaded_file($upfile['tmp_name'], $uploadDir . $fileName))
//                $flag = $subDir . "s_" . $fileName;
//            $a = imagemark::resize($uploadDir . $fileName, $prefix = 's_', $width = 200, $height = 200);
//        }
//        if($flag){
//            $profiles_id = $this->users_profiles->getUser("uid", "uid=$this->uid", 3);
//            if ($profiles_id) {
//                $this->users_profiles->updateUser(array('avatar' => $flag), "uid=$this->uid");
//            } else {
//                $this->users_profiles->addUser(array('avatar' => $flag, 'uid' => $this->uid));
//            }
//             header("location:user.php?action=userinfo");
//        }else{
//             //$this->alert("上传失败！", 'js', 3, "user.php?action=userinfo");
//            header("location:user.php?action=userinfo");
//        }
//        
//    }

    function doUpload() {
        import("imagemark.class", "lib");
        $name = $_GET['name'];
        $maxSize = 1024 * 1024 * 5;
        $ext = array('jpg', 'jpeg', 'gif', 'bmp');
        $date = date("Ym", time());
        $subDir = "images/$name/$date/";
        $uploadDir = ATTACH_DIR . $subDir;
        file::forcemkdir($uploadDir);
        $upfile = $_FILES[$name];
        $fileExt = file::extname($upfile['name']);
        $fileName = util::random(16) . '.' . $fileExt;
        #文件超过最大限制
        if ($upfile['size'] > $maxSize)
            $flag = 1;
        #上传文件格式错误
        elseif (!in_array($fileExt, $ext))
            $flag = 2;
        elseif ($upfile['error'] > 0)
            $flag = 0;
        else {
            if (move_uploaded_file($upfile['tmp_name'], $uploadDir . $fileName))
                $flag = $subDir . "s_" . $fileName;
            $a = imagemark::resize($uploadDir . $fileName, $prefix = 's_', $width = 250, $height = 250);
//            $profiles_id = $this->users_profiles->getUser("uid", "uid=$this->uid", 3);
//            if ($profiles_id) {
//                $this->users_profiles->updateUser(array('avatar' => $flag), "uid=$this->uid");
//            } else {
//                $this->users_profiles->addUser(array('avatar' => $flag, 'uid' => $this->uid));
//            }
        }
        echo json_encode($flag);
    }

    function doUploads() {
        $image = $_POST["imgsrc"];
        if ($image) {
            $profiles_id = $this->users_profiles->getUser("uid", "uid=$this->uid", 3);
            if ($profiles_id) {
                $this->users_profiles->updateUser(array('avatar' => $image), "uid=$this->uid");
            } else {
                $this->users_profiles->addUser(array('avatar' => $image, 'uid' => $this->uid));
            }
            header("location:user.php");
        } else {
            $this->alert("请上传图片！", 'js', 3, "user.php?action=userinfo");
        }
    }

//    function doresizeImage() {
//        $image = $_POST["imgsrc"];
//        $width = $_POST["w"];
//        $height = $_POST["h"];     
//        $x = $_POST["x"];
//        $y = $_POST["y"];
//
//	$res = $this->thumb($image,false,1);
//              //substr($a,0,strrpos($a,'attach'))
//	if($res == false){
//                unset_session('flag');
//                $this->alert("裁剪失败！", 'js', 3, "user.php?action=userinfo");
//	}elseif(is_array($res)){
//            $res['big']= substr($res['big'],strrpos($res['big'],'images/'));
//            $res['small']= substr($res['small'],strrpos($res['small'],'images/'));
//            
//            $profiles_id = $this->users_profiles->getUser("uid", "uid=$this->uid", 3);
//            if ($profiles_id) {
//                $this->users_profiles->updateUser(array('avatar' => $res['big']), "uid=$this->uid");
//            } else {
//                $this->users_profiles->addUser(array('avatar' => $res['big'], 'uid' => $this->uid));
//            }
//            
//            unset_session('flag');
//            $this->alert("裁剪成功！", 'js', 3, "user.php?action=userinfo");
//
//	}elseif(is_string($res)){
//		echo '<img src="'.$res.'">';
//	}
//    }

    function getImageInfo($img) {
        $imageInfo = getimagesize($img);
        if ($imageInfo !== false) {
            $imageType = strtolower(substr(image_type_to_extension($imageInfo[2]), 1));
            $imageSize = filesize($img);
            $info = array(
                "width" => $imageInfo[0],
                "height" => $imageInfo[1],
                "type" => $imageType,
                "size" => $imageSize,
                "mime" => $imageInfo['mime'],
            );
            return $info;
        } else {
            return false;
        }
    }

    function thumb($image, $is_save = true, $suofang = 0, $type = '', $maxWidth = 500, $maxHeight = 500, $interlace = true) {
        $image = SITE_ROOT . $image;
        // 获取原图信息
        $info = $this->getImageInfo($image);

        if ($info !== false) {
            $srcWidth = $info['width'];
            $srcHeight = $info['height'];
            $type = empty($type) ? $info['type'] : $type;
            $type = strtolower($type);
            $interlace = $interlace ? 1 : 0;
            unset($info);

            if ($suofang == 1) {
                $width = $srcWidth;
                $height = $srcHeight;
            } else {
                $scale = min($maxWidth / $srcWidth, $maxHeight / $srcHeight); // 计算缩放比例
                if ($scale >= 1) {
                    // 超过原图大小不再缩略
                    $width = $srcWidth;
                    $height = $srcHeight;
                } else {
                    // 缩略图尺寸
                    $width = (int) ($srcWidth * $scale); //147
                    $height = (int) ($srcHeight * $scale); //199
                }
            }
            // 载入原图
            $createFun = 'ImageCreateFrom' . ($type == 'jpg' ? 'jpeg' : $type);
            $srcImg = $createFun($image);

            //创建缩略图
            if ($type != 'gif' && function_exists('imagecreatetruecolor'))
                $thumbImg = imagecreatetruecolor($width, $height);
            else
                $thumbImg = imagecreate($width, $height);

            // 复制图片
            if (function_exists("ImageCopyResampled"))
                imagecopyresampled($thumbImg, $srcImg, 0, 0, 0, 0, $width, $height, $srcWidth, $srcHeight);
            else
                imagecopyresized($thumbImg, $srcImg, 0, 0, 0, 0, $width, $height, $srcWidth, $srcHeight);
            if ('gif' == $type || 'png' == $type) {
                //imagealphablending($thumbImg, false);//取消默认的混色模式
                //imagesavealpha($thumbImg,true);//设定保存完整的 alpha 通道信息
                $background_color = imagecolorallocate($thumbImg, 0, 255, 0);  //  指派一个绿色
                imagecolortransparent($thumbImg, $background_color);  //  设置为透明色，若注释掉该行则输出绿色的图
            }
            // 对jpeg图形设置隔行扫描
            if ('jpg' == $type || 'jpeg' == $type)
                imageinterlace($thumbImg, $interlace);
            //$gray=ImageColorAllocate($thumbImg,255,0,0);
            //ImageString($thumbImg,2,5,5,"ThinkPHP",$gray);
            // 生成图片
            $imageFun = 'image' . ($type == 'jpg' ? 'jpeg' : $type);
            $length = strlen("00." . $type) * (-1);
            $_type = substr($image, -4);
            $length = ($type != $_type ? $length + 1 : $length);
            //裁剪
            if ($suofang == 1) {

                $thumbname01 = substr_replace($image, "01." . $type, $length);  //大头像
                $thumbname02 = substr_replace($image, "02." . $type, $length);  //小头像
                $imageFun($thumbImg, $thumbname01, 100);
                $imageFun($thumbImg, $thumbname02, 100);

                $thumbImg01 = imagecreatetruecolor(190, 195);
                imagecopyresampled($thumbImg01, $thumbImg, 0, 0, $_POST['x'], $_POST['y'], 190, 195, $_POST['w'], $_POST['h']);

                $thumbImg02 = imagecreatetruecolor(48, 48);
                imagecopyresampled($thumbImg02, $thumbImg, 0, 0, $_POST['x'], $_POST['y'], 48, 48, $_POST['w'], $_POST['h']);

                $imageFun($thumbImg01, $thumbname01, 100);
                $imageFun($thumbImg02, $thumbname02, 100);
//				unlink($image);
                imagedestroy($thumbImg01);
                imagedestroy($thumbImg02);
                imagedestroy($thumbImg);
                imagedestroy($srcImg);

                return array('big' => $thumbname01, 'small' => $thumbname02); //返回包含大小头像路径的数组
            } else {
                if ($is_save == false) {           //缩略图覆盖原图，缩略图的路径还是原图路径
                    $imageFun($thumbImg, $image, 100);
                } else {
                    $thumbname03 = substr_replace($image, "03." . $type, $length); //缩略图与原图同时存在，
                    $imageFun($thumbImg, $thumbname03, 100);

                    imagedestroy($thumbImg);
                    imagedestroy($srcImg);
                    return $thumbname03;     //返回缩略图的路径，字符串
                }
            }
//
        }
        return false;
    }

}

?>