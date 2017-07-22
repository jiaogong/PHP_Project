<?php
namespace Admin\Controller;
use Think\Controller;
class WebconfigController extends CommonController {
	public function index(){
		$this->display();
	}
	public function update(){
		//接收到ajax传递过来的值
		/*
		$data['DB_TYPE']=$_POST['databasetype'];
		$data['DB_NAME']=$_POST['databasename'];
		$data['DB_USER']=$_POST['databaseuser'];
		$data['DB_PWD']=$_POST['databasepwd'];
		$data['DB_LOCALHOST']=$_POST['databaseht'];
		$data['WEBPOW']=$_POST['WEBPOWER'];
		*/
		//echo $dbtype,$dbname,$dbuser,$dbpwd,$dbht;
        //对更改的配置信息进行更改保存,file是隐藏的input信息一同发送过来。
		$data=$_POST;

		//填充为空的项目		
			if($data["DB_TYPE"]=='')$data["DB_TYPE"]='mysql';
			if($data["DB_NAME"]=='')$data["DB_NAME"]='mcake';
			if($data["DB_USER"]=='')$data["DB_USER"]='root';
			if($data["DB_PWD"]=='')$data["DB_PWD"]='';
			if($data["DB_PREFIX"]=='')$data["DB_PREFIX"]='mcake_';
			if($data["DB_HOST"]=='')$data["DB_HOST"]='localhost';
			if($data['DB_CHARSET']=='')$data['DB_CHARSET']='utf8';
			if($data["WEBPOWER"]=='')$data["WEBPOWER"]='off';
			if($data["OFFLINEMESSAGE"]=='')$data["OFFLINEMESSAGE"]='本站正在维护中，暂不能访问。<br /> 请稍后再访问本站。';
			if($data['__UPLOAD__']=='')$data['__UPLOAD__']="/Uploads/Admin/images";
            //短信sendMessage('18311422275','5211314');
            if($data["MESG_URL"]=='')$data["MESG_URL"]='http://www.xiaohigh.com/SendMessage/send.php';//云之讯强哥账号接口拼接?to=...&code=&web=&class=110
            if($data["WEB"]=='')$data["WEB"]='MCAKE马克西姆蛋糕';
            if($data["class"]=='')$data["class"]='110';
            if($data["CODE"]=='')$data["CODE"]='123456789';//默认发送内容数字
            //邮件发送自动配置
            if($data["Host"]=='')$data["Host"]='smtp.163.com';//设置邮件服务器的地址
            if($data["Port"]=='')$data["Port"]='25';//设置邮件服务器的端口，默认为25   谷歌邮箱 默认端口是443
            if($data["username"]=='')$data["username"]='ruiyi@163.com';//设置发件人的邮箱地址
            if($data["mailname"]=='')$data["mailname"]='mcake马克西姆蛋糕网';//设置发件人的姓名
            if($data["mailpwd"]=='')$data["mailpwd"]='987654321a';//设置密码
            if($data["mailtitle"]=='')$data["mailtitle"]='Mcake蛋糕';//设置邮件的标题
            if($data["COMPANY"]=='')$data["COMPANY"]='上海麦心食品有限公司';
            if($data["ICP"]=='')$data["ICP"]='沪ICP备12022075号';
            if($data["HTTPURL"]=='')$data["HTTPURL"]='www.mcake.com';
            if($data["COMPANYDES"]=='')$data["COMPANYDES"]='马克西姆-法国百年品牌1893';//商家简介
		$content = "<?php\r\nreturn array(\r\n";
        //获取数组
		foreach ($data as $key=>$value){
                    //把字符串转换成大写
			$key=strtoupper($key);
			if(strtolower($value)=="true" || strtolower($value)=="false" || is_numeric($value))
				$content .= "\t'$key'=>$value, \r\n";
			else
				$content .= "\t'$key'=>'$value',\r\n";
			C($key,$value);
		}
		$content .= ");\r\n?>";
		//dump($content);die;
		//$content=$content."foreache ...");得到$content 就是配置文件内容return array('$key'=>'$value',); 
		//dump($content);
	//bool chmod(string $filename,int $mode)注意 mode  不会被自动当成八进制数值，而且也不能用字符串（例如 "g+w"）。要确保正确操作，需要给 mode  前面加上 0： 
        //0777三段 7   7   7  属主 属组  其他  1 2 4 就是具有x w  r s所有者具有读写执行权限。
		$file="/mcake/Common/conf/config.php";
      	$r=@chmod($file,0777);//php函数改变文件模式，改成mode所指定的。
		$hand=file_put_contents("./mcake/Common/conf/config.php",$content);
		//var_dump($hand);die;
		//把$content 写入到$file内。$file在模板中传递过来是siteconfig.inc.php<input type="hidden" name="file" value="siteconfig.inc.php" />单入口文件，默认是在入口文件同级目录下。
		if (!$hand) $this->error('配置文件写入失败！','/index.php/admin/');
       	$this->success('配置文件保存成功!','/index.php/admin/');

		}
		public function detail(){
			$server=array();
			$server=$_SERVER;
			//dump($server);die;
			$this->assign('server',$server);
			$this->display();
		}
		public function mesg(){
			$this->display();
		}
        public function smail(){
            $this->display();
        }
		public function messagea(){
			$to=$_POST['to'];
			$content=$_POST['content'];
			//dump($_POST);
			$res=sendMessage($to,$content);
			//dump($res);
			//echo "ok";
            $this->display('detail');
	
		}
        public function sendMail(){
            $title=$_POST['title'];
			$to=$_POST['to'];
			$content=$_POST['content'];
			//dump($_POST);
			$res=sendMail($title, $to, $content);
			//dump($res);
			//echo "ok";
            $this->display('detail');
	
		}
	}