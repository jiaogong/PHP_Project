<?php
namespace Admin\Controller;
use Think\Controller;
class GoodsController extends CommonController {
	//用户添加
	public function add(){
		//实例化数据库对象 国家表
		$country = M('country');
		//sql
		$cou = $country->select();
		//分配变量
		$this->assign('cou',$cou); 

		$this->display();
	}
	//添加新商品
	public function insert(){

		
		// var_dump(I());die;
		//上传文件设置项
		$config = array( 
			//设置图片上传时大小   
			'maxSize'=>3145728,
			//设置图片上传时存放根目录    
			'savePath'=>'./Admin/images/GoodsImg/',
			//设置图片上传时的图片名唯一   
			'saveName'   =>    array('uniqid',''),
			//设置图片上传时的格式    
			'exts'       =>    array('jpg', 'gif', 'png', 'jpeg'),
			//设置图片上传时存放根目录的子目录    
			'autoSub'    =>    true,
			 //设置图片上传时存放根目录的子目录的名称   
			'subName'    =>    array('date','Ymd'),
			//设置图片上传时如何重名则替换
			'replace' => true,
			);

		//实例化上传类
		$upload = new \Think\Upload($config);

		$info   =   $upload->upload();
		if(!$info) {
		// 上传错误提示错误信息        
		$this->error($upload->getError());    
		}else{// 上传成功 获取上传文件信息         
			echo $info['savepath'].$info['savename'];    
		}

		//实例化图片对象
		$image = new \Think\Image();
		
		//将多个图片的地址保存在数据库,并缩放
		for($i=0;$i<count($info);$i++){

			//拼接原图片路径,并保存到数据库
			$data['picname'] .= $info[$i]['savename'].",";
			
			//拼接原图片路径+图片名
			$imagePathName = './Uploads/Admin/images/GoodsImg/'.date('Ymd',time()).'/'.$info[$i]['savename'];
			//拼接图片路径
			$imgPath = './Uploads/Admin/images/GoodsImg/'.date('Ymd',time()).'/';
			//打开原图
			$image->open($imagePathName);
			//缩略图并保存
			$image->thumb(100, 100)->save($imgPath.'s_'.$info[$i]['savename']);
			//打开原图
			$image->open($imagePathName);
			$image->thumb(216, 216)->save($imgPath.'m_'.$info[$i]['savename']);
			//打开原图
			$image->open($imagePathName);
			$image->thumb(480, 480)->save($imgPath.'c_'.$info[$i]['savename']);
			//打开原图
			$image->open($imagePathName);
			$image->thumb(960, 960)->save($imgPath.'b_'.$info[$i]['savename']);

		}
		//连接添加时间
		$data['addtime'] = date('YmdHis',time());

		//重量
		$data['weight']=implode(",",I('post.weights_'));
		//尺寸
		$data['size']= implode(",",I('post.sizes'));
		//单价
		$data['price'] = implode(",",I('post.prices'));
		//原材料
		// $data['material_id'] = implode(",",I('post.materials'));



		//拼接数据
		$data = I()+ $data ;
		// var_dump($data);die;
		// var_dump($data);die;
		//将多个数组合并成一个数组(同+)
		// $a = array_merge(I(),$data);
		// var_dump($data);


		//实例化数据库对象
		$goods = M('goods');
		//创建数据库数据
		$goods->create($data);
		//判断并添加
		if($goods->add()){
			//添加成功
			$this->success('添加成功',U(index),5);
		}else{
			$this->error('添加失败',5);
		}
		// $this->display();
		
	}
	//后台商品显示主页
	public function index(){
		//实例化数据库对象
		$goods = M('goods');
		$n = I('get.n');
		$k = I('get.k');
		//每页显示数量
		$num = !empty($n)?$n:6;
		//搜索的关键字
		$key = !empty($k)?$k:'';
		//判断
		if($key!=''){
			$where['en_gname'] = array('like',"%$key%");
			// $where['cn_gname'] = array('like',"%$key%");
		}
		//读取总条数
		$count = $goods->where($where)->count();
		//创建分页对象
		$page = new \Think\Page($count, $num);
		//获取limit参数
		$limit = $page->firstRow.','.$page->listRows;
		//解析结果集
		$ResGoods = $goods->limit($limit)->where($where)->select();
		//获取页码的信息字符串
		$pages = $page->show();
		//计算总页数
		$cou  = ceil($count/$num);
		// dump($ResGoods);die;
		//分配变量
		$this->assign("ResGoods",$ResGoods);
		$this->assign('page',$pages);
		$this->assign('n', $n);
		$this->assign('k', $k);

		$this->assign('count',$cou);
		// var_dump($pages);
		$this->display();
	}
	//删除商品
	public function delete(){
		//实例化数据库对象
		$goods = M('goods');
		$arr=I();
		// var_dump($arr);
		// die();
		if($goods->where($arr)->delete()){
			$this->success('删除成功');
		}else{
			$this->error('删除失败');
		}
	}

	//修改商品
	public function edit(){

		//实例化数据库类
		$goods = M('goods');
		//通过id把要修改的数据显示出来
		$goodsFind = $goods->where(I())->find();


		$this->assign('goodsFind',$goodsFind);

		$this->display();
	}

	//更新商品信息
	public function updata(){

		//实例化数据库类
		$goods = M('goods');
		//创建数据
		$goods->create();
		if($goods->save()){
			$this->success('更新成功', U('Admin/Goods/index'), 5);
		}else{
			$this->error('更新失败', U('Admin/Goods/index'), 5);
		}
	}
//添加商品页显示原材料
	public function show(){
		//获取国家的id
		$c = $_GET['ca'];
		

		$where['country']= $c;
		//创建对象
		$material = M('material2');

		//sql
		$data = $material->where($where)->select();
		echo json_encode($data);

	}


	
}