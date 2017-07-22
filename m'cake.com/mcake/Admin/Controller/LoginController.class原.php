<?php
namespace Admin\Controller;
use Think\Controller;
class LoginController extends Controller {
	public function login(){

		$this->display();
	}

	public function dologin(){
        $res = check_verify(I('post.vcode'));
		if(!$res){
			$this->error('验证码输入错误,请重新填写');
		}
		//获取数据
		$usercount = I('post.usercount');
		$pass = md5(I('post.pass'));
		//创建对象
		$user = M('user');
		//查询数据库
		$where['usercount'] = array('eq',$usercount);
		$where['pass'] = array('eq',$pass);
		$users = $user->where($where)->find();
		if(!empty($users)&&isset($res)){
			session('id',$users['id']);
			$this->success('登陆成功',U('Admin/Index/index'),3);
		}else{
			$this->error('登陆失败,请重新登陆...');
		}
	}

	public function logout(){
		$ads = session(null);
		if(empty($ads)){
			$this->success('退出成功',U('Admin/Login/login'),3);
		}
	}
}