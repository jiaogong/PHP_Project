<?php
namespace Admin\Controller;
use Think\Controller;
class UserController extends CommonController {

	//用户添加
	public function add(){
		$this->display();
	}

	//执行插入
	public function insert(){

		//验证验证码
		$res = check_verify(I('post.vcode'));
		if(!$res){
			$this->error('验证码输入错误,请重新填写');
		}
		//创建对象
		$sex = array('0'=>'女','1'=>'男');
		$user = M('user');
		$_POST['pass'] = md5($_POST['pass']);
		$_POST['addtime']= date('Y-m-d',time());
		$_POST['sex']=$sex[I('post.sex')];
		//创建数据
		$user->create();
		//执行添加
		if($user->add()){
			$this->success("用户添加成功",U('Admin/User/index'),3); 
		}else{
			$this->error( "用户添加失败");
		}
	}

	//显示管理员信息
	public function index(){

		//获取参数
		$xianshi = I('get.xianshi');
		$sou = I('get.sou');
		$num = !empty($xianshi) ? $xianshi : 6; //每页显示数据条数
		$keyword = !empty($sou) ? $sou : ''; //账号搜索关键字
		if($keyword != ''){
			$where['usercount'] = array('like',"%$keyword%");
		}

		//创建对象
		$state = array('管理员','启用','禁用');
		$user = M('user');
		
			//读取总的数据条数
			$count = $user->where($where)->count();
			// 创建分页对象
			$Page = new \Think\Page($count,$num);
			//获取分页信息
			$limit = $Page->firstRow.','.$Page->listRows;

			$users = $user->limit($limit)->where($where)->select();
			$pages = $Page->show();

			
			//分配变量
			$this->assign('users',$users);
			$this->assign('pages',$pages);
			$this->assign('xianshi',$xianshi);
			$this->assign('sou',$sou);
			$this->assign('state',$state);
		
			$this->display();
	}


	// 修改管理员信息
	public function edit(){
		$id = I('get.id');
		//创建对象
		$user = M('user');
		//读取
		$users = $user->find($id);

		//分配变量
		$this->assign('users',$users);
		//解析模板
		$this->display();
	}

	//执行修改
	public function update(){
		$sex = array('女','男');
		$state = array('后台管理员','启用','禁用');
		$lll=lv3;

		//创建对象
		$user = M('user');
		$_POST['sex'] = $sex[I('post.sex')];
		$_POST['state'] = $state[I('post.state')];
		//创建数据
		$user->create();
		if($user->save()){
			if(IS_AJAX){
				echo 0;
			}else{
				$this->success('修改成功',U('Admin/User/index'),3);
			}
		}else{
			if(IS_AJAX){
				echo 1;
			}else{
				$this->error('修改失败',U('Admin/User/index'),3);
			}
		}
	}


	// 修改密码
	public function editpass(){
		//获取id
		$id = I('get.id');
		//创建对象
		$user = M('user');
		//读取数据
		$users = $user->find($id);
		//分配变量
		$this->assign('users',$users);

		//解析模板
		$this->display();
	}

	//重置密码
	public function repass(){
		//创建对象
		$user = M('user');
		$_POST['pass'] = md5($_POST['pass']);
		$user->create();
		if($user->save()){
			$this->success('更改密码成功',U('Admin/User/index'),4);
		}else{
			$this->error('更改密码失败',U('Admin/User/index'),4);
		}
	}

	//删除
	public function delete(){
		//获取id
		$id = I('get.id');
		//创建对象
		$user = M('user');
		//执行删除
		if($user->delete($id)){
			$this->success('删除成功',U('Admin/User/index'),3);
		}else{
			$this->error('删除失败',U('Admin/User/index'),3);
		}
	}

	
}