<?php
namespace Admin\Controller;
use Think\Controller;
class ArticleController extends CommonController {
	//用户添加
	public function add(){
		$this->display();
	}

	public function insert(){
		$where['addtime'] = date('Y-m-d');
		$where +=I();
		if(!empty($_FILES['image'])|| $_FILES['image']!=null){
		//上传文件设置项
		$config = array( 
			//设置图片上传时大小   
			'maxSize'=>3145728,
			//文件上传保存的根路径
			'rootPath'=>'Uploads',
			//设置图片上传时存放根目录    
			'savePath'=>'./Admin/images/ArticleImg/',
			//设置图片上传时的图片名唯一   
			'saveName'   =>    array('uniqid',''),
			//设置图片上传时的格式    
			'exts'       =>    array('jpg', 'gif', 'png', 'jpeg'),
			//设置图片上传时存放根目录的子目录    
			'autoSub'    =>    false,
			//设置图片上传时如何重名则替换
			'replace' => true,
			//图片尺寸
			'size'=>'',
			);

			//实例化上传类
			$upload = new \Think\Upload($config);

			$info   =   $upload->upload();
			if(!$info) {
			// 上传错误提示错误信息        
			$this->error($upload->getError());    
			}else{// 上传成功 获取上传文件信息         
				echo ''; //$info['savepath'].$info['savename'];    
			}

			$where['image'] = '/Uploads/Admin/images/ArticleImg/'.$info['image']['savename'];
			}
			//实例化
			$article = M('article');
			//添加
			if($article->add($where)){
				$this->success('添加成功', U('index'),3);
			}else{
				$this->error('添加失败');
		}

			$this->display();
	}

	public function index(){
		//实例化
		$article = M('article');
		$n = I('get.n');
		$k = I('get.k');
		//每页显示数量
		$num = !empty($n)?$n:6;
		//搜索的关键字
		$key = !empty($k)?$k:'';
		//判断
		if($key!=''){
			$where['title'] = array('like',"%$key%");
			// $where['cn_gname'] = array('like',"%$key%");
		}
		//读取总条数
		$count = $article->where($where)->count();
		//创建分页对象
		$page = new \Think\Page($count, $num);
		//获取limit参数
		$limit = $page->firstRow.','.$page->listRows;
		//解析结果集
		$ResArticle = $article->limit($limit)->where($where)->order('id desc')->select();
		//获取页码的信息字符串
		$pages = $page->show();
		//计算总页数
		$cou  = ceil($count/$num);
		// dump($ResGoods);die;
		//分配变量
		$this->assign("ResArt",$ResArticle);
		$this->assign('page',$pages);
		$this->assign('n', $n);
		$this->assign('k', $k);

		$this->assign('count',$cou);

		$this->display();
	}

	public function edit(){


		//实例化
		$article = M('article');
		$art = $article->where(I())->find();
		$this->assign('art',$art);
		$this->display();
	}
	public function upload(){

		// var_dump(I());die;
		if(!empty($_FILES['image'])|| $_FILES['image']!=null){
		//上传文件设置项
		$config = array( 
			//设置图片上传时大小   
			'maxSize'=>3145728,
			//文件上传保存的根路径
			'rootPath'=>'Uploads',
			//设置图片上传时存放根目录    
			'savePath'=>'./Admin/images/ArticleImg/',
			//设置图片上传时的图片名唯一   
			'saveName'   =>    array('uniqid',''),
			//设置图片上传时的格式    
			'exts'       =>    array('jpg', 'gif', 'png', 'jpeg'),
			//设置图片上传时存放根目录的子目录    
			'autoSub'    =>    false,
			//设置图片上传时如何重名则替换
			'replace' => true,
			//不缩放
			'thumb'=>flase,
			);

			//实例化上传类
			$upload = new \Think\Upload($config);

			$info   =   $upload->upload();
			if(!$info) {
			// 上传错误提示错误信息        
			$this->error($upload->getError());    
			}else{// 上传成功 获取上传文件信息         
				echo ''; //$info['savepath'].$info['savename'];    
			}

			$where['image'] = '/Uploads/Admin/images/ArticleImg/'.$info['image']['savename'];

			$where = I()+$where;
		//实例化数据库类
		$article = M('article');
		//创建数据
		$article->create($where);
		if($article->save()){
			$this->success('更新成功', U('index'), 3);
		}else{
			$this->error('更新失败', U('index'), 5);
		}
	}else{

		//实例化数据库类
		$article = M('article');
		//创建数据
		$article->create();
		if($article->save()){
			$this->success('更新成功', U('index'), 3);
		}else{
			$this->error('更新失败', U('index'), 5);
		}

	}
		
	}

	//删除文章
	public function delete(){
		//实例化数据库对象
		$article = M('article');
		$arr=I();
		if($article->where($arr)->delete()){
			$this->success('删除成功');
		}else{
			$this->error('删除失败');
		}
	}

	
}