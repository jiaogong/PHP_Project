<?php

/**
 * 投票action
 * $Id: voteaction.php 1516 2016-02-29 10:43:58Z cuiyuanxin $
 */
class voteAction extends action {

    public $friend;
    public $vote;
    public $user;
    public $users_profiles;
    public $series;
    public $brand;

    function __construct() {
        parent::__construct();
        $this->friend = new friend();
        $this->vote = new vote();
        $this->user = new users();
        $this->users_profiles = new users_profiles();
        $this->series = new series();
        $this->brand = new brand();
        $linklist = $this->friend->getAllFriendLink("category_id='`0`' order by seq asc", "*", 2);
        $this->vars('uid', session('uid'));
        $this->vars('username', session('username'));
        $this->vars('linklist', $linklist);
    }

    function doDefault() {
        $this->doVote();
    }

    function doVote() {
        $tpl_name = "vote";
        if ($_POST) {
            if($_POST['audio']){
                $data['audio'] = implode(',', $_POST['audio']);
            }
            if($_POST['compass']){
                $data['compass'] = implode(',', $_POST['compass']);
            }
            if($_POST['tyre']){
                $data['tyre'] = implode(',', $_POST['tyre']);
            }
            if($_POST['seats']){
                $data['seats'] = implode(',', $_POST['seats']);
            }
            if($_POST['lubricating']){
                $data['lubricating'] = implode(',', $_POST['lubricating']);
            }
            if($_POST['platform']){
                $data['platform'] = implode(',', $_POST['platform']);
            }
            if($_POST['certification']){
                $data['certification'] = implode(',', $_POST['certification']);
            }
            if($_POST['travel']){
                $data['travel'] = implode(',', $_POST['travel']);
            }
            if($_POST['rental']){
                $data['rental'] = implode(',', $_POST['rental']);
            }
            if($_POST['tools']){
                $data['tools'] = implode(',', $_POST['tools']);
            }
            if($_POST['fmcc']){
                $data['fmcc'] = implode(',', $_POST['fmcc']);
            }
            if($_POST['motors']){
                $data['motors'] = implode(',', $_POST['motors']);
            }

            $data['interest'] = $_POST['interest'];
            $res = $this->vote->insertUser($data);
            if ($res) {
                session("toupiao",$res);
                if (session("uid")) {
                    echo "/vote.php?action=draw&id=" . $res;
                } else {
                    echo 1;
                }
                //投票成功
            } else {
                $this->alert("投票失败！！", 'js', 3);
            }
        } else {
            $this->template($tpl_name);
        }
    }

    function doDraw() {
        $tpl_name = "draw";

        if ($_POST) {
            if ($_GET['id']) {
                if($_POST['shouji']){
                    $data['shouji'] = $_POST['mobile'];
                }
                if($_POST['yixiang']){
                    $data['yixiang'] = $_POST['yixiang'];
                }
                if($_POST['audi']){
                    $data['audi'] = $_POST['audi'];
                }
                if($_POST['audis']){
                    $data['audis'] = $_POST['audis'];
                }
                if($_POST['brand']){
                    $data['brand'] = $_POST['brand'];
                }
                if($_POST['brands']){
                    $data['brands'] = $_POST['brands'];
                }
                if($_POST['buy']){
                    $data['buy'] = $_POST['buy'];
                }
                if($_POST['plan']){
                    $data['plan'] = $_POST['plan'];
                }
                if($_POST['mileage']){
                    $data['mileage'] = $_POST['mileage'];
                }
                if($_POST['num']){
                    $data['num'] = $_POST['num'];
                }
                if($_POST['read']){
                    $data['readss'] = $_POST['read'];
                }
                $data['uid'] = session('uid');
                if($_POST['identity']){
                    $data['identity'] = implode(',', $_POST['identity']);
                }
                
                $where['realname'] = $_POST['realname'];
                $where['email'] = $_POST['email'];
                $where['gender'] = $_POST['gender'];
                $where['updated'] = time();
                $r = $this->user->updateUser($where, 'id=' . $data['uid']);
                if ($r) {
                    $re = $this->users_profiles->updateUser(array('number' => $_POST['number'], 'zipcode' => $_POST['zipcode'], 'address' => $_POST['address'], 'birthday' => $_POST['selectAdate1']), 'uid=' . $data['uid']);
                    if ($re) {
                        $res = $this->vote->updateUser($data, 'id=' . $_GET['id']);
                        if ($res) {
                            $this->alert('提交成功！', 'js', 3, '/');
                        }
                    } else {
                        $re = $this->users_profiles->addUser(array('number' => $_POST['number'], 'zipcode' => $_POST['zipcode'], 'address' => $_POST['address'], 'birthday' => $_POST['selectAdate2'], 'uid' => $data['uid']));
                        if ($re) {
                            $res = $this->vote->updateUser($data, 'id=' . $_GET['id']);
                            if ($res) {
                                $this->alert('提交成功！', 'js', 3, '/');
                            }
                        }
                    }
                }else{
                    echo "参数错误！！！";
                }
            } else {
                echo "参数错误！！！";
            }
        } else {
            $brand = $this->brand->getDrand('brand_name', 'state=3 ORDER BY letter asc', 2);
            $this->vars('brand', $brand);
            $this->template($tpl_name);
        }
    }

    function doSeries() {
        echo json_encode($this->series->getSeriesdata('series_name', "brand_name='$_GET[brand_name]' and state=3 GROUP BY series_name" , 2));
    }

    function dosubform() {
        if ($_POST) {
            $username = trim($_POST['username']);
            $mobile = $_POST['mobile'];
            $code = $_POST['code'];
            $password = md5($_POST['password']);
            $mphone_reg = "/^(13|18|15|17)\d{9,9}$/";
            $username_reg = "/^[a-zA-Z0-9_u4e00-u9fa5]{3,20}[^_]$/";
            if (!preg_match($mphone_reg, $mobile)) {
                $this->alert('手机号不正确', 'js', 3, 'register.php?action=register');
            }
            if (!preg_match($username_reg, $username)) {
                $this->alert('用户名不符合要求', 'js', 3, 'register.php?action=register');
            }
            $reg_code = session("reg_code");
            if ($reg_code != $code) {
                $this->alert('验证码不正确', 'js', 3, 'register.php?action=register');
            }
            $is_name = $this->user->getUser('id', "mobile = '$mobile' or username='$username'", 3);
            if ($is_name) {
                $this->alert('手机号或用户名已使用', 'js', 3, 'register.php?action=register');
            }
            $ip = util::getip();
            $this->user->ufields = array("username" => "$username", "password" => "$password", "mobile" => "$mobile", "state" => "1", "created" => time(), "reg_ip" => "$ip");
            $id = $this->user->insert();

            if ($id) {
                session('username', $username);
                session('uid', $id);
                echo 1;
            } else {
                echo -4;
            }
        }
    }
    
    function doFybrand() {
        $tpl_name = "fybrand";
        $this->template($tpl_name);
    }

}
