<?php 
namespace Admin\Controller;
use Think\Controller;

class TestController extends Controller{
	public function index(){
	import('ORG.Net.IpLocation');// 导入IpLocation类
    $Ip = new IpLocation('UTFWry.dat'); // 实例化类 参数表示IP地址库文件
    $area = $Ip->getlocation('203.34.5.66'); // 获取某个IP地址所在的位置
    dump($area);
	}
}