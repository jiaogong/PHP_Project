<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

namespace Member\Controller;
use Member\Model\User_infoModel;
use Member\Model\UserinfoModel;
use Member\Model\UserModel;
use OT\DataDictionary;
use User\Api\UserApi;

/**
 * 前台首页控制器
 * 主要获取首页聚合数据
 */
class IndexController extends MemberController
{
    //系统首页
    public function index()
    {
        if(!empty($_SESSION[userid][username]))
        {
            $userid=$_SESSION[userid][uid];
            $UserinfoModel = new User_infoModel();
            $userinfo_list= $UserinfoModel->list_userinfo($userid);
            $this->assign('userinfo_list', $userinfo_list);
            $this->display();
        }else{

            $Url = U("Member/index/login");
            $this->success('您还没有登录，请先登录', $Url);
        }

    }

    public function regist()
    {//注册
        $username = $_POST['username'];
        $usermail = $_POST['username'];
        $password = $_POST['password'];
        $user_type = $_POST['user_type'];
        if (!empty($username) && !empty($password) && !empty($usermail)) {

            $UserModel = new UserModel;
            $result = $UserModel->register($username, $usermail, md5($password), $user_type);
            if ($result == 1) {
                //$this->redirect('Index');
                $Url = U("Member/index/login");
                $this->success('注册成功成功，请先登录', $Url);
                //$this->display('index');
            } else {
                $this->error('注册失败');
            }

        } else {
            $this->display();
        }

    }

    public function login()
    {//登陆
        $username = $_POST['username'];
        $password = md5($_POST['password']);
        if (!empty($username) && !empty($password)) {
            $UserModel1 = new UserModel;
            $userid = $UserModel1->login($username, $password);
            if ($userid == -2) {
                $this->display();
            } else {
                $user = $UserModel1->islogin($userid);
                $this->assign('userid',$userid);//栏目
                $Url = U("Member/index");
                $this->success('注册成功成功，3s后直接跳转到个人用户首页', $Url);
            }
        } else {
            $this->display();
        }

    }
    public function  update_imgurl()
    {
        $userid=$_SESSION[user_id];
        $img_url="http://www.baidu.com";
        $usermodel= new UserModel();
        $usermodel->updateimg_url($userid,$img_url);

    }
    //验证用户名是否存在
    public function valname($username)
    {

        if (!empty($username)) {
            $valname = new UserModel;
            $user1 = $valname->valatename($username);
        }
        $this->ajaxReturn($user1, 'json');

    }
    public function  logout()
    {
        $UserModel1 = new UserModel;
        $UserModel1->logout();
        $this->success('退出成功！', U('Member/Index/login'));
    }




}