<?php
namespace Admin\Controller;
use Think\Controller;
class AuserController extends CommonController {

	//用户添加
	public function add(){
		$group = M('group');
		$groups = $group->select();

		$this->assign('groups',$groups);
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
		$auser = M('auser');
		$_POST['apass'] = md5($_POST['apass']);
		$_POST['addtime']= date('Y-m-d H:i:s',time());
		
		//创建数据
		$auser->create();
		//执行添加
		$uid = $auser->add();

		
		$data['uid'] = $uid;
		$data['group_id'] = $_POST['group_id'];
		$group = M('group_access');
		$groups = $group -> data($data) -> add();
		if($uid && $groups){
			$this->success("用户添加成功",U('Admin/Auser/index'),3); 
		}else{
			$this->error( "用户添加失败");
		}
	}

	//显示管理员信息
	public function index(){
		$group = M('group');
		$groups = $group->select();
		foreach($groups as $key=>$value){
		$group_id[$value['id']] = $value['title'];
		
		}
		//获取参数
		$xianshi = I('get.xianshi');
		$sou = I('get.sou');
		$num = !empty($xianshi) ? $xianshi : 5; //每页显示数据条数
		$keyword = !empty($sou) ? $sou : ''; //账号搜索关键字
		if($keyword != ''){
			$where['ausername'] = array('like',"%$keyword%");
		}

		//创建对象
		$asex = array('0'=>'女','1'=>'男');
		// $group_id = array(1=>'编辑',2=>'管理员');
		$auser = M('auser');
		
			//读取总的数据条数
			$count = $auser->where($where)->count();
			// 创建分页对象
			$Page = new \Think\Page($count,$num);
			//获取分页信息
			$limit = $Page->firstRow.','.$Page->listRows;

			$ausers = $auser -> table('mcake_group_access')->field("mcake_group_access.group_id,mcake_auser.*")->join("left join mcake_auser on mcake_auser.id = mcake_group_access.uid")->where($where)->limit($limit)->select();
			$pages = $Page->show();

			
			//分配变量
			$this->assign('groups',$groups);
			$this->assign('group_id',$group_id);
			$this->assign('asex',$asex);
			$this->assign('ausers',$ausers);
			$this->assign('pages',$pages);
			$this->assign('xianshi',$xianshi);
			$this->assign('sou',$sou);
			$this->assign('state',$state);
		
			$this->display();
	}


	// 修改管理员信息
	public function edit(){
		$id['id'] = I('get.id');
		$uid['uid'] = I('get.id');
		//创建对象
		$auser = M('auser');
		//读取
		$ausers = $auser->where($id)->find();
		$group = M('group');
		$groups = $group->select();
		

		$group_id = M('group_access');
		$group_ids = $group_id->where($uid)->find();

		//分配变量
		$this->assign('group_ids',$group_ids);
		$this->assign('ausers',$ausers);
		$this->assign('groups',$groups);
		//解析模板
		$this->display();
	}

	//执行修改
	public function update(){
		// var_dump($_POST);die;
		// 获取数据
		$id['id'] = I('post.id');
		$uid['uid'] = I('post.id');
		//创建对象
		$auser = M('auser');
		$group = M('group_access');
		$group->create();
		$group->where($uid)->save();
		// if($group->where($uid)->save()){
		// 	$this->success('成功');
		// }else{
		// 	$this->error('失败');
		// }


		//创建数据
		$auser->create();
		if($auser->where($id)->save()){
			if(IS_AJAX){
				echo 0;
			}else{
				$this->success('修改成功',U('Admin/Auser/index'),3);
			}
		}else{
			if(IS_AJAX){
				echo 1;
			}else{
				$this->error('修改失败',U('Admin/Auser/index'),3);
			}
		}
	}


	// 修改密码
	public function editpass(){
		//获取id
		$id['id'] = I('get.id');
		//创建对象
		$auser = M('auser');
		//读取数据
		$ausers = $auser->where($id)->find();

		//分配变量
		$this->assign('ausers',$ausers);

		//解析模板
		$this->display();
	}

	//重置密码
	public function repass(){
		$id['id'] = I('post.id');
		//创建对象
		$auser = M('auser');
		$_POST['apass'] = md5($_POST['apass']);
		$auser->create();
		if($auser->save()){
			$this->success('更改密码成功',U('Admin/Auser/index'),4);
		}else{
			$this->error('更改密码失败',U('Admin/Auser/index'),4);
		}
	}

	//删除
	public function delete(){
		//获取id
		$id['id'] = I('get.id');
		$uid['uid'] = I('get.id');
		//创建对象
		$auser = M('auser');
		$group = M('group_access');
		//执行删除
		$groups = $group->where($uid)->delete();
		$ausers = $auser->where($id)->delete();
		if( $groups){
			$this->success('删除成功',U('Admin/Auser/index'),3);
		}else{
			$this->error('删除失败',U('Admin/Auser/index'),3);
		}
	}

	
}