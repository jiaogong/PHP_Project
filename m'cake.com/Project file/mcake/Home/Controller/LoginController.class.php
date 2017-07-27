<?php
namespace Home\Controller;
use Think\Controller;
class LoginController extends Controller {
    
    //登录页面
    public function dologin(){
        $this->assign('path',$_SERVER['HTTP_REFERER']);
    	$this->display();
    }

    //执行登录
    public function login(){
        $A = strrchr($_POST['path'],'/');
        $B = "/signin.html";
        $C = "/logout.html";
        // var_dump($A);die;
        $path = ($A != $B && $A!=$C ) ? $_POST['path']: U('Home/Index/index');

        //检测验证码
        $res = check_verify($_POST['vcode']);
        if(!$res){
            $this->error('验证码输入错误,请重新填写');
        }
        //获取参数
        $phone = I('post.phone');
        // var_dump($phone);
        $pass = md5(I('post.pass'));

        //创建对象
        $user = M('user');

        $where['phone'] = array('eq',$phone);
        $where['pass'] = array('eq',$pass);
        $where['state'] = array('eq',1);
        $users = $user->where($where)->find();
       
        // ($users);die;
        if($users){
            session('id',$users['id']);
            session('usercount',$users['usercount']);
            session('phone',$users['phone']);

            //将session中商品信息加入购物车数据表
            $shopcart=M('shopcart');
            //获取商品信息
            $_GET['uid']=session('id');
            $_GET['gid']=session('good')['gid'];
            $_GET['num']=session('good')['num'];
            $_GET['weight']=session('good')['weight'];
            //创建商品数据库对象
            $goods=M('goods');
            //查询出要添加的商品的信息，获取购物车需要的字段信息并压入$_GET
            $res=$goods->where("id={$_GET['gid']}")->find();
            $_GET['en_name']=$res['en_gname'];
            $_GET['cn_name']=$res['cn_gname'];
            $res['price']=explode(',',$res['price'])[$_GET['weight']-1];
            $res['picname']=explode(',',$res['picname'])[0];
            $res['addtime']=substr($res['addtime'],0,8);
            $res['picname']=$res['addtime'].'/'.s_.$res['picname'];
            $_GET['price']=$res['price'];
            $_GET['path']=$res['picname'];
            $_GET['largesses']=$res['explain'];
            //计算出单类商品的金额小计，并压入$_GET
            $_GET['subtotal']=$res['price']*$_GET['num'];
            //执行添加
            $shopcart->add($_GET);

            $this->success('登录成功',$path,2);
        }else{
            $this->error('登录失败,用户名或密码错误');
        }
    }

    //获取手机验证码
    public function scode(){
    	//发送手机验证码
    	$phone = $_GET['phone'];
		$code = rand(1000,9999);
		
        sendMessage($phone,$code);
        session('scode',$code);
    }

    //注册页面
    public function signin(){
    	$this->display();
    }

    //注册添加
    public function dosignin(){
    	$code = session('scode');
        $scode = I('post.scode');
        if($scode != $code){
        	$this->error('手机验证码错误,请重新输入');
        }

		//获取参数
        $_POST['pass'] = md5(I('post.pass'));
        $_POST['usercount'] = I('post.phone');
        $_POST['addtime'] = date('Y-m-d H:i:s',time());
        $_POST['u_score'] = 100;
        //创建对象
        $user = M('user');
        //创建数据
        $user->create();
        //执行添加
        $users = $user->add();
        //创建对象
        $anniversaries = M('anniversaries');
        $uid['uid'] = $users;
        $uid['anni_name'] = '生日';
        $anni = $anniversaries ->add($uid);
        if($users && $anni){
            $this->success('恭喜注册成功,获赠100积分',U('Home/Login/dologin'),3);
        }else{
            $this->error('注册失败,请重新填写');
        }
    }

    public function getPwd(){
        $this->display();
    }


    public function dogetPwd(){
    	//检测手机验证码
    	$code = session('scode');
        $scode = I('post.scode');
        if($scode != $code){
        	$this->error('手机验证码错误,请重新输入');
        }
       //检测验证码
        $res = check_verify($_POST['vcode']);
        if(!$res){
            $this->error('验证码输入错误,请重新填写');
        }
        //获取参数
       
        $phone= I('post.phone');
        $where['phone']= array('eq',$phone);
        // var_dump($where);die;
        $_POST['pass'] = md5(I('post.pass'));

        //创建对象
        $user = M('user');

        $user->create();
        
        // var_dump($res);die;
        if($res = $user->where($where)->save()){
            $this->success('修改密码成功',U('Home/Login/dologin'));
        }else{
            $this->error('修改密码失败');
        }

    }

    public function logout(){
        session('id',null);
        if(!session('id')){
            $this->success('退出成功',U('Home/Login/dologin'),3);
        }
    }

}