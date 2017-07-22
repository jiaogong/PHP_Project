<?php
namespace Home\Controller;
use Think\Controller;
class PublicController extends Controller {
	//生成验证码
	public function vcode(){
		$config =    array(    
			'fontSize'    =>    18,    // 验证码字体大小    
			'length'      =>    4,     // 验证码位数    
			'useNoise'    =>    true, // 关闭验证码杂点
			'width'		  =>	90,
			'height'	  =>	30,
		);
		$Verify = new \Think\Verify($config);
		$Verify->entry();
	}
}