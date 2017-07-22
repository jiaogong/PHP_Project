<?php
//云之讯  5分每条  http://www.xiaohigh.com/SendMessage/send.php?83114222758&code=879876&web=小狗网
/*
    接口名称:发送短信
    参数: to 需要发送的手机号
    web 网站名称
    code 验证码    rand(100000,999999)
    class 110 必传参数
    示例:
http://www.xiaohigh.com/SendMessage/send.php?83114222758&code=879876&web=小狗网
*/
    //创建 Common\function.php 这里直接用强哥封装好的。即可。
//发送邮件 
function sendMail($title,$to,$content){}
//发送短信
function sendMessage($to,$content){
//http://www.xiaohigh.com/SendMessage/send.php?83114222758&code=879876&web=小狗网
    $str=http://www.xiaohigh.com/SendMessage/send.php?$to&$content&web=".C('title')."&class=110;//最后一个是在开通云智讯用户自己设置的，就是使用时必须额外填写的，这个是开通这个功能用户自己定义的。
    //这里的网站名称在配置文件里写公共配置。'title'=>'phpchina.cc'

    $str="http://www.xiaohight.com/sendMessage/index.php?to=".$to."&code=".$content."&web=".C('title')."&class=110;
    //创建对象
    $curl=new \Org\Util\Curl();
    //执行发送
    $curl->get($str);//这就完成勒发送。
}
//当我们需要发送的时候，可以直接写 函数调用就可以额了。
sendMessage("13001901501","060114");//此时是有返回值的，
//在funciton中可以看到 $con=$curl->get($url);得到的是json字符串。
ok

需需要引入 文件:
curl 用于api传送数据。curl 实现传送 通过第三方发送短信。
phpmailer.class.php，class.pop3.php,class.smtp.php这三个文件引入 实现 发送邮件

一个函数 文件。common functions 文件。
在控制器中直接使用方法就可以勒！ok
网站配置修改：
把函数方法体 参数换成 配置变量，来传递。修改配置文件ok。