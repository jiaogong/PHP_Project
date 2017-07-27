<?php
namespace Admin\Controller;
use Think\Controller;
class RuleController extends CommonController {

	//用户的添加操作
	public function insert(){
		//创建数据库对象
		$rule=M('rule');
		//执行添加
		$rule->create();
		if($num=$rule->add()){
			$this->success('添加成功!',U('Admin/Rule/index'),3);
		}else{
			$this->error('添加失败!',U('Admin/Rule/index'),3);
		}
	}

	//用户的列表操作
	public function index(){
		//接收参数
		$n=I('get.n');
		$k=I('get.k');
		$num=!empty($n)?$n:5;
		$keyword=!empty($k)?$k:'';
		if($keyword!=''){
			$where['title']=array('like',"%$keyword%");
		}
		//创建数据库对象
		$rule=M('rule');
		//获取数据总条数
		$count=$rule->where($where)->count();
		//创建分页对象
		$page=new \Think\Page($count,$num);
		//获取limit
		$limit=$page->firstRow.','.$page->listRows;
		//读取当前分页显示的数据
		$rules=$rule->limit($limit)->where($where)->select();
		//获取分页链接
		$pages=$page->show();

		//分配变量
		$this->assign('rules',$rules);
		$this->assign('pages',$pages);
		$this->assign('n',$n);
		$this->assign('k',$k);

		$this->display();
	}

	//用户的修改操作
	public function update(){
		//创建数据库对象
		$rule=M('rule');
		//过滤非法字段
		$rule->create();
		//var_dump($_POST);//die;
		//判断
		if($rule->save()){
			$this->success('修改成功',U('Admin/Rule/index'),3);	
		}else{
			//echo $rule->_sql();die;
			$this->error('修改失败',U('/Admin/Rule/index'),3);
		}
	}

	//用户的修改操作
	public function edit(){
		//获取修改ID
		$id=I('get.id');
		//创建数据库对象
		$rule=M('rule');
		//获取要修改的数据
		$info=$rule->find($id);
		//分配变量
		$this->assign('info',$info);

		$this->display();

	}

	//用户删除操作
	public function delete(){
		$id=I('get.id');
		$rule=M('rule');
		//执行删除
		if($rule->delete($id)){
			$this->success('删除成功!',U('/Admin/Rule/index'),3);
		}else{
			$this->error('删除失败!',U('/Admin/Rule/index'),3);
		}
	}
}