<?php
/**
* 发送短信接口  http、webservice方式
* 请使用Http  post调用方式  webservice在某些服务器上可能会有BUG
* 
*/
set_time_limit(0);
class soapmsg extends model {
    private $sn = 'SDK-BBX-010-23058';
    private $password = 'bcEEdE-E';
    private $sms_keyword = '【ams车评网】';
    function __construct() {
        parent::__construct();
        require SITE_ROOT.'lib/soap/nusoap.php';
        //http://sdk2.entinfo.cn/webservice.asmx?wsdl
        //http://sdk3.entinfo.cn:8060/webservice.asmx?wsdl
        $this->client = new nusoap_client('http://sdk2.entinfo.cn/webservice.asmx?wsdl', 'wsdl');    
        $this->client->soap_defencoding = 'GBP312';
        $this->client->decode_utf8 = false;     
    }
    /**
    *  Http Post方式发送短信
    * 
    * @param String $mobile  接收信息手机号   同时发送给多个号码用英文逗号隔开
    * @param String $content  发送的内容   同上发送内容用英文逗号隔开  与$mobile一一对应
    * @param bool   发送状态     2.成功 -4短信条数不足
    */
    function postMsg($mobile, $content) {
        #当短信内容没有匹配到关键字时，返回false
        if(strpos($content, $this->sms_keyword)===FALSE){
            return FALSE;
        }
        $flag = 0;
        $sn = $this->sn;
        $password = $this->password; 
        $pwd = strtoupper(md5($sn.$password));        
        //要post的数据 
        $argv = array( 
                 'sn'=>$sn, //提供的账号
                 'pwd'=>$pwd, //此处密码需要加密 加密方式为 md5(sn+password) 32位大写
                 'content'=> iconv('utf-8', 'gbk', $content),//短信内容
                 'ext'=>'', //扩展码  可为空
                 'rrid'=>'theone',//默认空 如果空返回系统生成的标识串 如果传值保证值唯一 成功则返回传入的值
                 'stime'=>''//定时时间 格式为2011-6-29 11:09:21
        ); 
        //手机号 多个用英文的逗号隔开 post理论没有长度限制.推荐群发一次小于等于10000个手机号
        if(is_array($mobile)) $argv['mobile'] = implode(',', $mobile);
        else $argv['mobile'] = $mobile;
//        var_dump($argv);
//        exit;
        //构造要post的字符串 
        foreach ($argv as $key=>$value) { 
              if ($flag!=0) { 
                $params .= "&"; 
                $flag = 1; 
              } 
             $params.= $key."="; $params.= urlencode($value); 
             $flag = 1; 
        } 
        $length = strlen($params); 
        //创建socket连接 
        $fp = fsockopen("sdk2.entinfo.cn",80,$errno,$errstr,10) or exit($errstr."--->".$errno); 
        //构造post请求的头 
        $header = "POST /z_mdsmssend.aspx HTTP/1.1\r\n"; 
        $header .= "Host:sdk2.entinfo.cn\r\n"; 
        $header .= "Content-Type: application/x-www-form-urlencoded\r\n"; 
        $header .= "Content-Length: ".$length."\r\n"; 
        $header .= "Connection: Close\r\n\r\n"; 
        //添加post的字符串 
        $header .= $params."\r\n"; 
        //发送post的数据 
        fputs($fp,$header); 
        $inheader = 1; 
        while (!feof($fp)) { 
             $line = fgets($fp,1024); //去除请求包的头只显示页面的返回数据 
             if ($inheader && ($line == "\n" || $line == "\r\n")) $inheader = 0; 
        } 
        fclose($fp);         
        if($line === 'theone') $state = 2;
        else $state = $line;
        return $state;
    }
    /**
    * 账户第一次使用时候调用注册
    * @param null
    * @return 0 为成功   其他返回值对照SDK文档说明
    */
    function Register() {
        $sn = $this->sn;
        $password = $this->password;
        $parameters = array(
            'sn'        => $sn,
            'pwd'       => $password,
            'province'  => '北京市',
            'city'      => '北京市',
            'trade'     => '互联网',
            'entname'   => '百同合文化传媒有限公司',
            'linkman'   => '赵研',
            'phone'     => '68688033',
            'mobile'    => '13911918020',
            'email'     => 'zh_yn@hotmail.com',
            'fax'       => '68688033',
            'address'   => '中关村南大街48号九龙商务中心A座907',
            'postcode'  => '100081',
            'sign'      => 'the one',
        );        
        $this->callmsg('Register', $parameters);
    } 
    /**
    * 调用service接口方式发送短信
    *                                         
    * @param String $mobile  接收信息手机号   同时发送给多个号码用英文逗号隔开
    * @param String $content  发送的内容   同上发送内容用英文逗号隔开  与$mobile一一对应
    */
    function sendMsg($mobile, $content) {
        $sn = $this->sn;
        $password = $this->password;
        $pwd = strtoupper(md5($sn.$password));
        $ext = '';//扩展码，可为空
        $stime = '';//定时时间,可为空
        $rrid = '';//唯一标志码，如果为空，将返回系统生成的标志码
        //发送短信
        $parameters=array("sn"=>$sn, "pwd"=>$pwd, "mobile"=>$mobile, "content"=>$content, "ext"=>$ext, "stime"=>$stime, "rrid"=>$rrid);                
        $this->callmsg('mt', $parameters);
    }
    /**
    * 调用service接口
    * 
    * @param String $method  回调函数
    * @param Array $parameters 参数说明参照SDK说明文档
    */
    function callmsg($method, $parameters) {
        $str = $this->client->call($method, array('parameters' =>$parameters), '', '', false, true, 'document', 'encoded'); 
        //echo "所有的返回值均需要判断才可以认定是否成功或者 判断方法为: 返回值非空或者不是以负号开头便是成功.";
        if (!$err = $this->client->getError() && $str === 'theone') return true;
        else return false;        
    }
}
?>
