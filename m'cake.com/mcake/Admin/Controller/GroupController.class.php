<?php
namespace Admin\Controller;
use Think\Controller;
class GroupController extends CommonController {
	//用户添加操作
	public function add(){
		//获取分类信息
		$rule=M('rule');
		//var_dump($group);die;
		//查询出权限信息
		$res=$rule->select();
		//分配变量
		$this->assign('res',$res);
		//解析模板
		$this->display();
	}

	//用户的插入操作
	public function insert(){
		//创建数据库对象
		$group=M('group');
		//拼接rules字段
		$_POST['rules']=implode(',',$_POST['name']);
		unset($_POST['name']);
		//var_dump($_POST);die;
		//执行添加
		$group->create();
		if($num=$group->add()){
			$this->success('添加成功!',U('Admin/Group/index'),3);
		}else{
			$this->error('添加失败!',U('Admin/Group/index'),3);
		}
	}

	//用户的列表操作
	public function index(){
		//获取权限信息
		$rule=M('rule');
		//查询出权限信息
		$res=$rule->select();
		//分配变量
		$this->assign('res',$res);

		//接收参数
		$n=I('get.n');
		$k=I('get.k');
		$num=!empty($n)?$n:5;
		$keyword=!empty($k)?$k:'';
		if($keyword!=''){
			$where['title']=array('like',"%$keyword%");
		}
		//创建数据库对象
		$group=M('group');
		//获取数据总条数
		$count=$group->where($where)->count();
		//创建分页对象
		$page=new \Think\Page($count,$num);
		//获取limit
		$limit=$page->firstRow.','.$page->listRows;
		//读取当前分页显示的数据
		$groups=$group->limit($limit)->where($where)->select();
		//获取分页链接
		$pages=$page->show();

		//分配变量
		$this->assign('groups',$groups);
		$this->assign('pages',$pages);
		$this->assign('n',$n);
		$this->assign('k',$k);

		$this->display();
	}

	//用户的修改操作
	public function update(){
		//print_r($_POST);die;
		//创建数据库对象
		$group=M('group');
		//拼接rules
		$_POST['rules']=implode(',',$_POST['name']);
		unset($_POST['name']);
		//var_dump($_POST);die;
		//过滤非法字段
		$group->create();
		//判断
		if($group->save()){
			$this->success('修改成功',U('Admin/Group/index'),3);	
		}else{
			echo $type->_sql();die;
			$this->error('修改失败',U('/Admin/Group/index'),3);
		}
	}

	//用户的修改操作
	public function edit(){
		//获取权限信息
		$rule=M('rule');
		//查询出权限信息
		$res=$rule->select();
		//分配变量
		$this->assign('res',$res);

		//获取修改ID
		$id=I('get.id');
		//创建数据库对象
		$group=M('group');
		//获取要修改的数据
		$info=$group->find($id);
		$id=explode(',',$info['rules']);

		//分配变量
		$this->assign('info',$info);
		$this->assign('id',$id);

		$this->display();

	}

	//用户删除操作
	public function delete(){
		$id=I('get.id');
		$group=M('group');
		//执行删除
		if($group->delete($id)){
			$this->success('删除成功!',U('Admin/Group/index'),3);
		}else{
			$this->error('删除失败!',U('Admin/Group/index'),3);
		}
	}
}