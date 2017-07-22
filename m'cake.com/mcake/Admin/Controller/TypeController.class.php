<?php
namespace Admin\Controller;
use Think\Controller;
class TypeController extends CommonController {
	//用户添加操作
	public function add(){
		//获取分类信息
		$type=M('type');
		//var_dump($type);die;
		$types=$type->field('mcake_type.*,concat(path,",",id) as paths')->order('paths')->select();
		foreach($tyeps as $key=>$value){
			$arr=explode(',',$value['path']);
			$num=count($arr)-1;
			$str=str_repeat('|---------',$num);
			$cates[$key]['name']=$str.$value['name'];
		}

		//分配变量
		$this->assign('types',$types);
		//解析模板
		$this->display();
	}

	//用户的插入操作
	public function insert(){
		//创建数据库对象
		$type=M('type');
		//拼接psth字段
		if($_POST['pid']==0){
			$_POST['path']=0;
		}else{
			$info=$type->find($_POST['pid']);
			$_POST['path']=$info['path'].','.$info['id'];
		}
		//执行添加
		$type->create();
		if($num=$type->add()){
			$this->success('添加成功!',U('Admin/type/index'),5);
		}else{
			$this->error('添加失败!',U('Admin/type/index'),5);
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
			$where['name']=array('like',"%$keyword%");
		}
		//创建数据库对象
		$type=M('type');
		//获取数据总条数
		$count=$type->where($where)->count();
		//创建分页对象
		$page=new \Think\Page($count,$num);
		//获取limit
		$limit=$page->firstRow.','.$page->listRows;
		//读取当前分页显示的数据
		$types=$type->field('mcake_type.*,concat(path,",",id) as paths')->order('paths')->limit($limit)->where($where)->select();
		foreach($types as $key=>$value){
			$arr=explode(',',$value['path']);
			$num=count($arr)-1;
			$str=str_repeat('|-------------',$num);
			$types[$key]['name']=$str.$value['name'];
		}
		//获取分页链接
		$pages=$page->show();

		//分配变量
		$this->assign('types',$types);
		$this->assign('pages',$pages);
		$this->assign('n',$n);
		$this->assign('k',$k);

		$this->display();
	}

	//用户的修改操作
	public function update(){
		//创建数据库对象
		$type=M('type');
		//拼接path
		if($_POST['pid']==0){
			$_POST['path']=0;
		}else{
			$info=$type->find($_POST['pid']);
			$_POST['path']=$info['path'].','.$info['id'];
		}
		//过滤非法字段
		$type->create();
		//var_dump($_POST);//die;
		//判断
		if($type->save()){
			$this->success('修改成功',U('Admin/Type/index'),5);	
		}else{
			//echo $type->_sql();die;
			$this->error('修改失败',U('/Admin/Type/index'),5);
		}
	}

	//用户的修改操作
	public function edit(){
		//获取修改ID
		$id=I('get.id');
		//创建数据库对象
		$type=M('type');
		$types=$type->field('mcake_type.*,concat(path,",",id) as paths')->order('paths')->select();
		foreach($types as $key=>$value){
			$arr=explode(',',$value['path']);
			$num=count($arr)-1;
			$str=str_repeat('|---------',$num);
			$types[$key]['name']=$str.$value['name'];
		}
		//获取要修改的数据
		$info=$type->find($id);

		//分配变量
		$this->assign('info',$info);
		$this->assign('types',$types);

		$this->display();

	}

	//用户删除操作
	public function delete(){
		$id=I('get.id');
		$type=M('type');
		$info=$type->where("pid=$id")->find();//只要有一条数据的pid和被删除数据的id相等就证明有子类，所以使用查询单条的find()
		if(!empty($info)){
			$this->error('该类下有子类，无法删除！');
		}
		if($type->delete($id)){
			$this->success('删除成功!');
		}else{
			$this->error('删除失败!');
		}
	}
}