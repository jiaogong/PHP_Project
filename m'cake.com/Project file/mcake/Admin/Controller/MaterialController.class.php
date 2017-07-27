<?php
namespace Admin\Controller;
use Think\Controller;
class MaterialController extends CommonController {
	//原料添加操作
	public function add(){
		$this->display();
	}
	//原料插入操作
	public function insert(){
		//var_dump($_POST);die;
		//创建数据库对象
		$material=M('material');
		//执行添加
		$material->create();
		if($material->add()){
			$this->success('添加成功!',U('Admin/Material/index'),5);
		}else{
			$this->error('添加失败!',5);
		}
	}

	//原料列表操作
	public function index(){
		//获取参数
		$n=I('get.n');
		$k=I('get.k');
		$num=!empty($n)?$n:7;
		$keyword=!empty($k)?$k:'';
		if($keyword!=''){
			$where['name']=array('like',"%$keyword%");
		}
		//创建对象
		$material=M('material');
		//获取数据总条数
		$count=$material->where($where)->count();
		//创建分页对象
		$page=new \Think\Page($count,$num);
		//获取limit
		$limit=$page->firstRow.','.$page->listRows;
		//获取显示分页数据
		$materials=$material->limit($limit)->where($where)->select();

		//获取页码链接
		$pages=$page->show();

		$this->assign('materials',$materials);
		$this->assign('pages',$pages);
		$this->assign('n',$n);
		$this->assign('k',$k);

		$this->display();
	}

	//原料修改操作
	public function update(){
		//创建数据库对象
		$material=M('material');
		//执行修改
		$material->create();
		if($material->save()){
			$this->success('修改成功!',U('Admin/Material/index'),5);
		}else{
			$this->error('修改失败!',5);
		}

	}

	//原料修改操作
	public function edit(){
		//创建数据库对象
		$material=M('material');
		//获取要修改的数据
		$info=$material->find($_GET['id']);
		//var_dump($info);die;
		//分配变量
		$this->assign('info',$info);

		$this->display();
	}

	//删除原料操作
	public function delete(){
		//创建数据库对象
		$material=M('material');
		//执行删除
		if($material->delete($_GET['id'])){
			$this->success('删除成功!',U('Admin/Material/index'),5);
		}else{
			$this->error('删除失败!',5);
		}
	}
	public function go(){
		//获取国家
		$k = I('get.k');
		$where['name']=array('like',"%$k%");
		//创建对象
		$material = M('material');
		//sql
		$data = $material->where($where)->select();
		$this->assign('material',$data);
		$this->display();
	}

}