
1：把PHPMailer文件夹放到ThinkPHP\Library\Vendor下
2：系统设置=》配置管理=》增加如下几个配置项：(这里的东西可以自动生成不用手动添加)


            FROM_EMAIL          发件人名称              邮箱 	字符 	
            MAIL_TYPE           邮件类型                邮箱 	枚举 	
            MAIL_SMTP_HOST 	SMTP服务器              邮箱 	字符 	
            MAIL_SMTP_PORT 	SMTP服务器端口          邮箱 	数字 	
            MAIL_SMTP_USER 	SMTP服务器用户名        邮箱 	字符 	
            MAIL_SMTP_PASS 	SMTP服务器密码          邮箱 	字符 	
            MAIL_SMTP_CE        邮件发送测试            邮箱 	字符
3：注册提醒：
    在UserController下的44行添加
    R('Addons://Email/Email/sendRegister',array($uid));
4：修改密码邮件（登陆忘记密码）
    在UserController（也可以是别的控制器）下的申请重置密码的地方添加
    /**
    *$email[用户注册时的邮箱]
    *$url[修改密码地址]
    */
    R('Addons://Email/Email/renPassword', array($email, $url));
注：PHP必须开启sockes扩展和openssl扩展（特别重要，必须开启）