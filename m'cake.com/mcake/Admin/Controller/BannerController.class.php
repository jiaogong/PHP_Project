<?php
namespace Admin\Controller;
use Think\Controller;
class BannerController extends CommonController {

	public function index(){
		$this->display();
	}

	public function update(){
		//var_dump($_FILES);//die;
		//var_dump($_POST);die;
		if($_FILES['img']['error']==0){
			$upload = new \Think\Upload();//实例化上传类
			$upload->maxSize = 4096000 ;//设置附件上传大小
			$upload->exts = array('jpg', 'gif', 'png', 'jpeg');//设置附件上传类型
			$upload->rootPath = './Public/';//设置文件上传根目录
			$upload->savePath = 'Banner/';//设置文件上传文件夹
			// 上传文件     
			$info = $upload->upload();    
			if(!$info) {//上传错误提示错误信息        
				$this->error($upload->getError());    
			}else{//上传成功
				$_POST['path']='/Public/'.$info['img']['savepath'].$info['img']['savename'];
			}
		}
		//创建数据库对象
		$banner=M('banner');
		//执行数据修改
		$banner->create();
		$num=$banner->save();
		if($num){
			$this->success('广告发布成功！',U('Admin/Banner/index'),5);
		}else{
			$this->error('广告发布失败,请重试！');
		}

	}
	
}