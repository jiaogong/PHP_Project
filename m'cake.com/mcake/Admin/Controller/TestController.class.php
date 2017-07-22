<?php 
namespace Admin\Controller;
use Think\Controller;
class TestController extends Controller{
	public function index(){
	import('ORG.Net.IpLocation');// 导入IpLocation类
    //$Ip = new IpLocation('UTFWry.dat'); // 实例化类 参数表示IP地址库文件
    $Ip = new \Org\Net\IpLocation('UTFWry.dat');
   // $area = $Ip->getlocation('114.113.221.173'); // 获取某个IP地址所在的位置，如果空着不填是默认获取当前客户端ip
    $area = $Ip->getlocation('114.113.221.173');
 //   dump($area);
    /*
    * 结果为：
    array(5) {
  ["ip"] => string(15) "114.113.221.173"
  ["beginip"] => string(13) "114.113.208.0"
  ["endip"] => string(15) "114.113.223.255"
  ["country"] => string(9) "北京市"
  ["area"] => string(6) "电信"
}
    */
$country=$area['country'];
dump($country);
	}
}