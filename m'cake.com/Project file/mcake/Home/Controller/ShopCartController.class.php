<?php
namespace Home\Controller;
use Think\Controller;
class ShopCartController extends Controller {

	//购物车列表
    public function index(){
    	//创建购物车数据库对象
    	$shopcart=M('shopcart');
    	//获取会员id
    	$_GET['uid']=session('id');
    	//查询该会员的购物车商品
    	$shop=$shopcart->where("uid={$_GET['uid']}")->select(); 
       // dump($shop);die;   	
    	//计算出总金额
    	// foreach($shop as $k=>$v){
    	// 	$total+=$v['subtotal'];
    	// }
    	//获取购物车商品数量
    	$shopnum=count($shop);
    	//分配变量
    	$this->assign('shop',$shop);
    	$this->assign('shopnum',$shopnum);
    	//$this->assign('total',$total);
    	//解析模板
    	$this->display();
    }

    //购物车列表商品选择后的价格总额
    public function change(){
    	//创建购物车数据库对象
    	$shopcart=M('shopcart');
    	//查询被选中的购物车商品
		foreach($_GET['ids'] as $k=>$v){
			$totals=$shopcart->where("id={$v}")->find();
			$total+=$totals['subtotal'];
		}
		echo $total;
    }

    //购物车商品添加
    public function insert(){
        //var_dump($_GET);die;
        //检测用户是否登录
        $sid = session('id');
        if(empty($sid)){
            echo session('good',$_GET);
            echo '0';
            die;
        }

    	//创建数据库对象
    	$shopcart=M('shopcart');   	
        //$_GET=array('uid'=>1,'gid'=>2,'weight'=>2,'num'=>3);
    	//组装查询购物车匹配商品的数组条件
        $_GET['uid']=session('id');
        $_GETS['uid']=session('id');
    	$_GETS['gid']=$_GET['gid'];
    	$_GETS['weight']=$_GET['weight'];
    	//判断购物车是否已有添加商品
    	if($sp=$shopcart->where($_GETS)->find()){
    		//已有添加商品，修改购买数量
    		$sp['num']+=$_GET['num'];
    		$sp['subtotal']=$sp['num']*$sp['price'];
            $sp['uid']=session('id');
            $sp['gid']=$_GETS['gid'];
            $sp['weight']=$_GETS['weight'];
    		//修改后的购买数量放入购物车
    		if($shopcart->save($sp)){
    			$this->success('购物车添加商品成功!',U('Home/Orders/index'),5);
    		}else{
    			$this->error('购物车添加商品失败!请重试。',U('Home/ShopCart/index'),5);
    		}
    	}else{
    		//没有添加商品，将商品信息放入购物车
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
    		//将添加商品的信息放入购物车
    		if($n=$shopcart->add($_GET)){
    			$this->success('购物车添加商品成功!',U('Home/ShopCart/index'),5);
    		}else{
    			$this->error('购物车添加失败!请重试。',U('Home/ShopCart/index'),5);
    		}
    	}
    }

    //购物车商品购买数量修改
    public function update(){
    	//创建购物车数据库对象
    	$shopcart=M('shopcart');
    	//查询出要修改购买数量的商品信息
    	$shop=$shopcart->where("id={$_POST['id']}")->find();
    	//获取要修改购买数量的原数量，计算出修改后的购买数量
    	$num=$shop['num']+$_POST['num'];
    	//判断购买数量小于1和大于库存量的情况
    	if($num<1){
    		$num=1;
    	}
    	//创建商品数据库对象，查询出要修改购买数量的商品的库存量
    	$goods=M('goods');
    	$good=$goods->where("id={$_POST['gid']}")->find();
    	$stocks=$good['stocks'];
    	if($num>$stocks){
    		$num=$stocks;
    	}
    	//将修改后的购买数量写回购物车数据库
    	$shop['num']=$num;
    	//计算出修改购买数量后的小计
    	$shop['subtotal']=$shop['price']*$num;
    	if($shopcart->save($shop)){
            echo '1';
    	}else{

    	}
    }

    //购物车商品删除
    public function delete(){
    	//创建购物车数据库对象
    	$shopcart=M('shopcart');
    	//删除商品
    	if($shopcart->delete($_POST['id'])){
            echo '1';
    	}else{

    	}
    }

    //清空购物车商品
    public function emptys(){
    	//创建购物车数据库对象
    	$shopcart=M(shopcart);
    	//删除该会员购物车中所有商品
    	if($shopcart->where("uid={$_POST['uid']}")->delete()){
            echo '1';
			//$this->success('清空购物车成功!',U('Home/ShopCart/index'),5);
		}else{
			//$this->error('清空购物车失败!请重试。',U('Home/ShopCart/index'),5);
		}
    }

}