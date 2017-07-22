<?php
    $con=file_get_contents('采集');
    include"./Curl.class.php";//引入curl插件
    //实例化对象
    $curl=new Curl();//得到对象
    //发起请求.将curl里的方法get传入进来,get($url,$timeout=10);指定路径发起get请求,超出时间10秒。超时就停止get请求。这是与file_get_contents明显区别。没有超时检测。采集要采用curl类的get方法来采集，而不用file_get_contents设置了超时时间，请求灵活性也很强，不仅post请求还可以post请求。
    $con=$curl->get("http://localhost/class/lamp/2.html");
    //把$_POST的数组储存起来，变成字符串，用serise
    $str=serialize($_POST);
    //储存起来
    file_put_contents('cache.php',$str);
    //怎么写？可写为如下：格式为$curl->post(接收参数地址，传过去接收的参数数组)；这两个参数。
    $con=$curl->post('http://localhost/class/lamp/project/t2.php',array('love'=>'iloveyou','like'=>'ilikeyou');
    //此时打开 http://localhost/class/lamp/project/t2.php，在t2.php中写入 $str=serialize($_POST);file_put_content("post.php",$str);可以看到接收的$str已经写入到post.php中，说明参数传递成功。a:2:{s:4:"love";s:8:"iloveyou";s:4:"like";s:8:"ilikeyou";}
//优势对于向远程服务器发送请求非常灵活。可见现在发送请求的技术三种。一种是form,ajax,curl。这三种。灵活度各有优势。curl适用于第三方接口，优势最明显，几乎api接口都用curl方式发送。

//引入第三方扩展类curl.class.php放到 library/org/util中。
//第三方扩展类常放在org中。当然也可以自定义目录随意放也可以，因为可以用命名空间来找到。当然也可以改名。格式保持一致。Curl.class.php
//用命名空间找到curl.
// 打开 Curl.class.php 写入空间 namespace Org\Util;class Curl{}
//ok,其他控制器就可以引入外部类文件 
public function t(){
    //引入外部php 类文件操作
    Think/Libary/Org/Util
        //2修改名字a.php =>A.class.php
    //3修改命名空间 文件最上面写入 namespace Org\Util；
    //文件修改完成 第三步：
//脚本里就可以直接使用了

    $curl=new \Org\Util\Curl();
    //var_dump($curl);
    /*
    6个属性。
    */
    //此时get和post方法就可以随意用了。
    //api 淘宝 微博 微信  这些api都可以额。
    $con=$curl->get("http://www.taobao.com");
    var_dump($con);die;//此时得到就是淘宝首页的html文档所有内容。


}