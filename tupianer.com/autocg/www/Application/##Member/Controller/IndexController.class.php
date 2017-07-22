<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

namespace Member\Controller;
use Member\Model\UserModel;
use OT\DataDictionary;
use User\Api\UserApi;

/**
 * 前台首页控制器
 * 主要获取首页聚合数据
 */
class IndexController extends MemberController {
    //系统首页
    public function index(){
        $this->display();
    }
    public function regist(){//注册
        $username=$_POST['username'];
        $usermail=$_POST['username'];
        $password=$_POST['password'];
        $user_type = $_POST['user_type'];
        if(!empty($username)&&!empty($password)&&!empty($usermail))
        {

            $UserModel = new UserModel;
            $result=$UserModel->register($username,$usermail,md5($password),$user_type);
            if($result==1)
            {
                //$this->redirect('Index');
                $Url = U("Member/index/index");
                $this->success('注册成功成功，3s后直接跳转到个人用户首页',$Url);
                //$this->display('index');
            }else
            {
                $this->error('注册失败');
            }

        }else
        {
            $this->redirect('login');
        }

    }
    public function login(){//登陆
        $username=$_POST['username'];
        $password=md5($_POST['password']);
        if(!empty($username)&&!empty($password))
        {
                $UserModel1 = new UserModel;
                $userid = $UserModel1->login($username,$password);
                echo $userid;
                if($userid == -2)
                {
                    $this->display();
                }else{
                    $Url = U("Member/index/index");
                    $this->success('登陆成功',$Url);
                    //$this->redirect('Index');
                   // $this->display('index');
                }
        }else
        {
            $this->display();
        }

    }


}