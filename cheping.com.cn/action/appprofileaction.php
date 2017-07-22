<?php

import('dcrypt.class', 'lib');

class appprofileAction extends action {

    public $user;
    public $users;
    public $soapmsg;
    public $shortmsg;
    public $smstpl;


    function __construct() {
        parent::__construct();

        $this->user = new users();
        $this->users = new users_profiles();
        $this->soapmsg = new soapmsg();
        $this->shortmsg = new shortmsg();
        $this->smstpl = new smsTpl();

        
    }

    function doDefault() {
        $this->doAppProfile();
    }

    function say($user, $pwd) {

        $phoneReg = '/^(13|18|15|17)\d{9,}$/';

        if (empty($user)) {
            $output = array('code' => 0, 'mes' => '用户名不能为空' . $user); //用户名不能为空
            exit(json_encode($output));
        } else if (empty($pwd)) {
            $output = array('code' => 1, 'mes' => '密码不能为空'); //密码不能为空
            exit(json_encode($output));
        } else {
            if (preg_match($phoneReg, $user)) {
                $uid = $this->user->getUser('id', "mobile='{$user}' and password='$pwd'", 1);
            } else {
                $uid = $this->user->getUser('id', "username='{$user}' and password='$pwd'", 1);
            }
        }
        if (!empty($uid['id'])) {
            return $uid['id'];
        } else {
            return 0;
        }
    }

    function doProfile() {
        global $local_host;
        $user = dcrypt::privDecrypt($_GET['name']);
        $pwd = dcrypt::privDecrypt($_GET['password']);
        $uid = intval($this->say($user, $pwd));
        if ($uid !== 0) {
            $byte=$_POST['pic'];
            $byte = str_replace(' ','',$byte);   //处理数据 
            $byte = str_ireplace("<",'',$byte);
            $byte = str_ireplace(">",'',$byte);
            $byte=pack("H*",$byte);      //16进制转换成二进制
            global $watermark_opt;
            $uploadRootDir = ATTACH_DIR . "images/avatar/";
            file::forcemkdir($uploadRootDir);
            $uploadDir = $uploadRootDir . date("Y/m/d") . '/';
            file::forcemkdir($uploadDir);
            $fileName = util::random(12);
            $fullPath = $uploadDir.$fileName.'.png';
            $file_name = "images/avatar/". date("Y/m/d") . "/";
            $h = fopen($fullPath, 'a+');

            if($h){
                if(fwrite($h, $byte)){
                    fclose($h);
                    $profiles_id = $this->users->getUser("uid", "uid=$uid", 3);
                    if ($profiles_id) {
                        $this->users->updateUser(array('avatar' => $file_name . $fileName.".png"), "uid=$uid");
                    } else {
                        $this->users->addUser(array('avatar' => $file_name . $fileName.".png", 'uid' => $uid));
                    }
                    $output = array('code' => 1, 'mes' => '头像上传成功', 'pic_path' => $local_host . UPLOAD_DIR . $file_name . $fileName.".png");
                    exit(json_encode($output));
                }else{
                    $output = array('code' => -2, 'mes' => '写文件流失败');
                    exit(json_encode($output));
                }
            }else{
                $output = array('code' => -1, 'mes' => '头像上传失败');
                exit(json_encode($output));
            }
        } else {
            $output = array('code' => 0, 'mes' => '请登录或核对用户信息');
            exit(json_encode($output));
        }

    }

    function doUser() {
        $user = dcrypt::privDecrypt($_GET['name']);
        $pwd = dcrypt::privDecrypt($_GET['password']);
        $uid = intval($this->say($user, $pwd));
        if ($uid !== 0) {
            $user = $this->user->getUser("realname,email,mobile,gender", "id=$uid", 1);
            foreach ($user as $key => $value) {
                if(empty($value)){
                    $user[$key] = '-1';
                }
            }
            $users = $this->users->getUser("uid,birthday,country,province,city,address,qq", "uid=$uid", 1);
            if($users['uid']){
                $users['realname'] = $user['realname'];
                $users['email'] = $user['email'];
                $users['mobile'] = $user['mobile'];
                $users['gender'] = $user['gender'];
                foreach ($users as $key => $value) {
                    if(empty($value)){
                        $users[$key] = '-1';
                    }
                    if($value == '(null)'){
                        $users[$key] = '-1';
                    }
                }
            }else{
                $users['realname'] = $user['realname'];
                $users['email'] = $user['email'];
                $users['mobile'] = $user['mobile'];
                $users['gender'] = $user['gender'];
                $users['birthday'] = '-1';
                $users['country'] = '-1';
                $users['province'] = '-1';
                $users['city'] = '-1';
                $users['address'] = '-1';
                $users['qq'] = '-1';
                $users['uid'] = $uid;
                
            }
             
            $output = array('code' => 1, 'mes' => '数据读取成功', 'list' => $users);
            exit(json_encode($output));
        } else {
            $output = array('code' => 0, 'mes' => '请登录或核对用户信息');
            exit(json_encode($output));
        }
    }

    function doSendCodess() {
        $mobile = dcrypt::privDecrypt($_GET['mobile']);
        if ($mobile) {
            $code = mt_rand(1000, 9999);
            session("code_o", $code);
            $msgTpl = $this->smstpl->getTpl($this->shortmsg->tpl_flag['code_o']);
            $msg = str_replace('{$code_o}', $code, $msgTpl);
            $state = $this->soapmsg->postMsg($mobile, $msg);
            if ($state == 2) {
                $output = array('code' => 1, 'mes' => '验证码发送成功');
                exit(json_encode($output));
            } else {
                $output = array('code' => -1, 'mes' => '验证码发送失败');
                exit(json_encode($output));
            }
            
        } else {
            $output = array('code' => 0, 'mes' => '手机号为空');
            exit(json_encode($output));
        }
    }

    //检测验证码是否有效
    function doCheckCode() {

        $code = dcrypt::privDecrypt($_GET['code']);
        $findCode = session('code_o');
        if ($code == $findCode) {
            $output = array('code' => 1, 'mes' => '验证码校对成功');
            exit(json_encode($output));
        } else {
            $output = array('code' => -1, 'mes' => '验证码校对失败');
            exit(json_encode($output));
        }
    }

    function doMobile() {
        $user = dcrypt::privDecrypt($_GET['name']);
        $pwd = dcrypt::privDecrypt($_GET['password']);
        $uid = intval($this->say($user, $pwd));
        if ($uid !== 0) {
            $mobile = dcrypt::privDecrypt($_GET['mobile']);
            if (empty($mobile)) {
                $output = array('code' => -1, 'mes' => '手机号不能为空号');
                exit(json_encode($output));
            } else {
                if (strlen($mobile) == "11") {
                    $n = preg_match("/1[3458]{1}\d{9}$/", $mobile, $array);
                    if ($n == 0) {
                        $output = array('code' => -3, 'mes' => '手机号不正确'); //手机号不正确
                        exit(json_encode($output));
                    }
                    if ($n == 1) {
                        $user = $this->user->getUser('id', "mobile = '$mobile'", 3);
                        if ($user) {
                            $output = array('code' => -4, 'mes' => '手机号码已经存在'); //手机号码已经注册
                            exit(json_encode($output));
                        } else {
                            $res = $this->user->updateUser(array('mobile' => $mobile), "id=$uid");
                            if ($res) {
                                $output = array('code' => 1, 'mes' => '手机号修改成功');
                                exit(json_encode($output));
                            } else {
                                $output = array('code' => 2, 'mes' => '手机号修改失败');
                                exit(json_encode($output));
                            }
                        }
                    }
                } else {
                    $output = array('code' => -2, 'mes' => '手机号不足11位'); //手机号不足11位
                    exit(json_encode($output));
                }
            }
        } else {
            $output = array('code' => 0, 'mes' => '请登录或核对用户信息');
            exit(json_encode($output));
        }
    }

    function doAppProfile() {
        $user = dcrypt::privDecrypt($_GET['name']);
        $pwd = dcrypt::privDecrypt($_GET['password']);
        $uid = intval($this->say($user, $pwd));
        if ($uid !== 0) {
            $realname = dcrypt::privDecrypt($_GET['realname']); //真实姓名
            $email = dcrypt::privDecrypt($_GET['email']); //邮箱
            $gender = dcrypt::privDecrypt($_GET['gender']);

            $birthday = dcrypt::privDecrypt($_GET['birthday']); //出生日期
            $country = dcrypt::privDecrypt($_GET['country']); // 0中国，1海外地区
            $province = dcrypt::privDecrypt($_GET['province']); //省
            $city = dcrypt::privDecrypt($_GET['city']); //市
            $address = dcrypt::privDecrypt($_GET['address']); //详细地址
            $qq = dcrypt::privDecrypt($_GET['qq']);

            $where = array(
                'realname' => $realname, 
                'email' => $email, 
                'gender' => $gender
            );
            $wheres = array(
                'birthday' => $birthday, 
                'country' => $country, 
                'province' => $province, 
                'city' => $city, 
                'address' => $address, 
                'qq' => $qq
            );
            
            foreach ($where as $key => $value) {
                if(empty($value)){
                    unset($where[$key]);
                }
            }
            foreach ($wheres as $key => $value) {
                if(empty($value)){
                    unset($wheres[$key]);
                }
            }

            $res = $this->user->updateUser($where, "id=$uid");
            $rse = $this->users->updateUser($wheres, "uid=$uid");
            if ($res || $rse) {
                $output = array('code' => 1, 'mes' => '修改成功');
                exit(json_encode($output));
            }else if($rse || !$rse){
                $output = array('code' => 1, 'mes' => '修改成功');
                exit(json_encode($output));
            }else if(!$rse || $rse){
                $output = array('code' => 1, 'mes' => '修改成功');
                exit(json_encode($output));
            } else {
                $output = array('code' => -1, 'mes' => '修改失败');
                exit(json_encode($output));
            }
        } else {
            $output = array('code' => 0, 'mes' => '请登录或核对用户信息');
            exit(json_encode($output));
        }
    }

}
