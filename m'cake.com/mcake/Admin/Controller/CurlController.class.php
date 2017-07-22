<?php
namespace Admin\Controller;
use Think\Controller;
class CurlController extends Controller {
	public function index(){ 
	$curl=new \Org\Util\Curl();
    //var_dump($curl);
    $con=$curl->get("http://www.ucpaas.com/user/verifyMobileForToken");
    $str=serialize($con);
    var_dump($str);
	}
}