<?php
namespace Admin\Controller;
use Think\Controller;
class PublicController extends Controller {
	//生成验证码
	public function vcode(){
		$config =    array(    
			'fontSize'    =>    20,    // 验证码字体大小    
			'length'      =>    4,     // 验证码位数    
			'useNoise'    =>    true, // 关闭验证码杂点
			'width'		  =>	100,
			'height'	  =>	25,
		);
		$Verify = new \Think\Verify($config);
		$Verify->entry();
	}
}