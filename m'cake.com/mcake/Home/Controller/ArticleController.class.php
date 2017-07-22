<?php
namespace Home\Controller;
use Think\Controller;
class ArticleController extends Controller {
    public function index(){
    	$article  = M('article');

        $res = $article->order('id desc')->where(array('type'=>'媒体合作'))->select();
        //分配变量
        $this->assign('article',$res);
        

      	$this->display();
    }
    public function job(){
    	$article  = M('article');

        $res = $article->order('id desc')->where(array('type'=>'招贤纳士'))->select();
        //分配变量
        $this->assign('article',$res);
        

      	$this->display();
    }

    public function call(){
    	$article  = M('article');

        $res = $article->order('id desc')->where(array('type'=>'呼叫中心'))->select();
        //分配变量
        $this->assign('article',$res);
        

      	$this->display();
    }
    public function order(){
    	$article  = M('article');

        $res = $article->order('id desc')->where(array('type'=>'订单相关'))->select();
        //分配变量
        $this->assign('article',$res);
        

      	$this->display();
    }
    public function pay(){
    	$article  = M('article');

        $res = $article->order('id desc')->where(array('type'=>'支付类'))->select();
        //分配变量
        $this->assign('article',$res);
        

      	$this->display();
    }
    public function shop(){
    	$article  = M('article');

        $res = $article->order('id desc')->where(array('type'=>'购物指南'))->select();
        //分配变量
        $this->assign('article',$res);
        

      	$this->display();
    }
    public function vip(){
    	$article  = M('article');

        $res = $article->order('id desc')->where(array('type'=>'会员权益'))->select();
        //分配变量
        $this->assign('article',$res);
        

      	$this->display();
    }
    public function express(){
    	$article  = M('article');

        $res = $article->order('id desc')->where(array('type'=>'配送服务'))->select();
        //分配变量
        $this->assign('article',$res);
        

      	$this->display();
    }
         
}