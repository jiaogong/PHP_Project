<?php
namespace Admin\Controller;
use Think\Controller;
class LoginController extends Controller {
	public function login(){

		$this->display();
	}

	public function dologin(){
		//验证验证码
		$res = check_verify(I('post.vcode'));
		if(!$res){
			$this->error('验证码输入错误,请重新填写');
		}
		//获取数据
		$ausername = I('post.ausername');
		$apass = md5(I('post.apass'));
		//创建对象
		$auser = M('auser');
		//查询数据库
		$where['ausername'] = array('eq',$ausername);
		$where['apass'] = array('eq',$apass);
		$ausers = $auser->where($where)->find();
		if(!empty($ausers)){
			session('admin_ausername',$ausers['ausername']);
			session('admin_id',$ausers['id']);
			$this->success('登陆成功',U('Admin/Index/index'),3);
		}else{
			$this->error('登陆失败,请重新登陆...');
		}
	}

	public function logout(){
		// $ads = unset($_SESSION['admin_id']);
		session('admin_id',null);
		if(!session('admin_id')){
			$this->success('退出成功',U('Admin/Login/login'),3);
		}
	}
}