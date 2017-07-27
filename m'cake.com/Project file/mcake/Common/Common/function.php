<?php 
	//声明自定义函数

	function check_verify($code, $id = ''){    
		$verify = new \Think\Verify();    
		return $verify->check($code, $id);
	}

    //获取类别的父级类别名称changjiang
function getTypeName($id){
	if($id==0){
		return '顶级类别';
	}
	$type=M('type');
	$info=$type->find($id);
	return $info['name'];
}


function getRuleStatus($status){
	if($status==1){
		return '启用';
	}
	if($status==0){
		return '禁用';
	}
}


    //获取国旗 changjiang
function getCountry($key){
	$arr=array(
		"country/fg.jpg",
		"country/xxl.jpg",
		"country/bls.jpg",
		"country/mlxy.jpg",
		"country/bdlg.jpg",
		"country/hg.jpg",
		"country/yn.jpg",
		"country/trq.jpg",
		"country/ym.jpg",
		"country/bjst.jpg",
		"country/mg.jpg",
		"country/mdjsj.jpg",
		"country/rs.jpg",
		"country/yl.jpg",
		"country/arl.jpg",
		"country/ydl.jpg",
		"country/mxg.jpg",
		"country/zx.png",
		"country/adly.jpg"
		);

	return $arr[$key];
}
	//发送邮件
	function sendMail($title, $to, $content){
		//注册账号  开通smtp选项
		//1.引入类文件class.phpmailer.php  class.POP3.php  class.smtp.php =>  Org/Util/
		//2.修改名称  修改命名空间
        $mail=new \Org\Util\PHPMailer();
        $mail->CharSet = "utf-8";  //设置采用utf8中文编码
        $mail->IsSMTP();                    //设置采用SMTP方式发送邮件
        $mail->Host = "C('Host')";    //设置邮件服务器的地址
        $mail->Port = "C('Port')";        //设置邮件服务器的端口，默认为25   谷歌邮箱 默认端口是443
        $mail->From = C("username");  //设置发件人的邮箱地址
        $mail->FromName = C("mailname");                      //设置发件人的姓名
        $mail->SMTPAuth = true;                                    //设置SMTP是否需要密码验证，true表示需要
        $mail->Username = C("mailname");
        $mail->Password = C("mailpwd");
        $mail->Subject = C("mailtitle");                                 //设置邮件的标题
        $mail->AltBody = "text/html";         // optional, comment out and test
 
        $mail->Body = $content;
        $mail->IsHTML(true);            //设置内容是否为html类型
		//$mail ->WordWrap = 50;           //设置每行的字符数
        // $mail->AddReplyTo("lamp_testmail@163.com", "我的小站");     //设置回复的收件人的地址
        $mail->AddAddress(trim($to), $name);     //设置收件的地址
        if (!$mail->Send()) {                    //发送邮件
            echo '发送失败:'.$mail->ErrorInfo;
        } else {
            echo "发送成功";
        }
	}

	//发送短信
	function sendMessage($to,$content){
		//http://www.xiaohigh.com/sendMessage/index.php?to=18311422275&code=5211314&web=网站名称&class=110
        $curla=C('MESG_URL');
        $WEB=C('WEB');
        $CLASS=C('CLASS');
		$url =$curla."?to=".$to."&code=".$content."&web=小狗网&class=110";
        //dump($url);
		//创建对象
		$curl = new \Org\Util\Curl();
		//执行发送
		$con = $curl->get($url);
		//处理返回结果(json字符串  使用json_decode)
	}


 ?>