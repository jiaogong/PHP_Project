<?php
namespace Home\Controller;
use Think\Controller;
class OrdersController extends Controller {

	public function index(){
        //检测用户是否登录
        $sid = session('id');
        if(empty($sid)){
        	session('good',$_GET);
        	$this->error('尚未登录，请登录！',U('Home/Login/dologin'),3);
        }
		//创建地址数据表对象
		$address=M('address');
		//查询出会员的所有地址信息
		$uid=session('id');
		$res=$address->where("uid=".$uid)->select();
		//分配地址信息变量
		$this->assign('res',$res);
		//创建购物车数据表对象
		$shopcart=M('shopcart');
		//使用前一页面传递过来的购物车商品id查询出要购买的商品信息	

		for($i=0;$i<count($_GET['ids']);$i++){
			$result[]=$shopcart->where("id={$_GET['ids'][$i]}")->find();
				//dump($result);die;	
		}
		//计算总金额
		foreach($result as $k=>$v){
			$total+=$v['subtotal'];
		}

		//分配结算商品信息变量
		$this->assign('result',$result);
		$this->assign('total',$total);

		$this->display();
	}

	public function sindex(){
        //检测用户是否登录
        $sid = session('id');
        if(empty($sid)){
        	session('good',$_GET);
        	$this->error('尚未登录，请登录！',U('Home/Login/dologin'),3);
        }
		//创建地址数据表对象
		$address=M('address');
		//查询出会员的所有地址信息
		$uid=session('id');
		$res=$address->where("uid=".$uid)->select();
		//分配地址信息变量
		$this->assign('res',$res);

		//获取会员id
		$result['uid']=session('id');
		//创建商品数据表对象
		$goods=M('goods');
		//获取session中商品信息
		$result['gid']=session('good')['gid'];
		$result['num']=session('good')['num'];
		$result['weight']=session('good')['weight'];
		//查询出商品数据表中该商品的信息
		$res=$goods->where("id={$result['gid']}")->find();
		//将商品信息字段处理成页面显示的信息字段
		$result['en_name']=$res['en_gname'];
		$result['cn_name']=$res['cn_gname'];
		$res['price']=explode(',',$res['price'])[$result['weight']-1];
		$res['picname']=explode(',',$res['picname'])[0];
		$res['addtime']=substr($res['addtime'],0,8);
		$res['picname']=$res['addtime'].'/'.s_.$res['picname'];
		$result['price']=$res['price'];
		$result['path']=$res['picname'];
		$result['largesses']=$res['explain'];
		//计算出单类商品的金额小计，并压入$_GET
		$result['subtotal']=$res['price']*$result['num'];

		//销毁session中的商品信息，将新处理的商品信息存入session
		session('good',null);
		session('good',$result);

		//分配结算商品信息变量
		$this->assign('result',$result);
		$this->assign('total',$result['subtotal']);
		//var_dump($result);die;
		$this->display();
	}
	//结算数据修改
	public function edit(){
		//创建购物车数据表对象
		$shopcart=M('shopcart');
		//查询计算出商品总额
		foreach($_GET['ids'] as $k=>$v){
			$totals=$shopcart->where("id={$v}")->find();
			$total+=$totals['subtotal'];
		}
		//返回结果
		echo $total;
	}

	//结算数据整理添加
	public function add(){
		
		//生成订单编号
		$_POST['oid']=time()+1;
		//创建地址信息表对象
		$address=M('address');
		//查询出收货人地址信息
		$addr=$address->where("id={$_POST['id']}")->find();
		//获取收货人姓名，电话，地址
		$_POST['linkman']=$addr['linkman'];
		$_POST['phone']=$addr['phone'];
		$_POST['address']=$addr['address'];
		unset($_POST['id']);

		//获取付款方式
		$payway=$_POST['payway'];
		unset($_POST['payway']);
		//支付与订单关联数据的添加
		$payment['oid']=$_POST['oid'];
		$payment['payway']=$payway;
		//创建支付数据表对象
		$payme=M('payment');
		//执行添加
		$paym=$payme->add($payment);

		//创建购物车数据表对象
		$shopcart=M('shopcart');
		//获取获取购买的商品信息
		foreach($_POST['shopcartid'] as $k=>$v){
			$goods[]=$shopcart->where("id={$v}")->find();
		}
		for($i=0;$i<count($goods);$i++){
			unset($goods[$i]['id']);
			unset($goods[$i]['uid']);
			unset($goods[$i]['en_name']);
			unset($goods[$i]['path']);
			unset($goods[$i]['largesses']);
			unset($goods[$i]['subtotal']);
			$goods[$i]['goodsid']=$goods[$i]['gid'];
			unset($goods[$i]['gid']);
			$goods[$i]['name']=$goods[$i]['cn_name'];
			unset($goods[$i]['cn_name']);
			$goods[$i]['orderid']=$_POST['oid'];
		}
		//unset($_POST['shopcartid']);
		//var_dump($_POST);die;
		//订单详情表数据添加
		$detail=M('detail');
		for($i=0;$i<count($goods);$i++){
			$deta[]=$detail->add($goods[$i]);
		}

		//获取配件名称和配件金额
		$pay=$_POST['canju']+($_POST['lazhu']*2);
		if($_POST['canju']){
			$describe='额外餐具,';
		}
		if($_POST['lazhu']){
			$describe.='额外生日蜡烛';
		}
		unset($_POST['canju']);
		unset($_POST['lazhu']);
		//创建配件数据表对象
		$packing=M('packing');
		$pack['pay']=$pay;
		$pack['describe']=$describe;
		$pack['oid']=$_POST['oid'];
		//dump($pack);die;
		//执行数据添加
		$pac=$packing->add($pack);

		//获取发票信息
		$title='食品';
		$company=$_POST['company'];
		unset($_POST['company']);
		$invoi['title']=$title;
		$invoi['company']=$company;
		$invoi['total']=$_POST['total'];
		$invoi['oid']=$_POST['oid'];
		//创建发票数据表对象
		$invoice=M('invoice');
		//执行添加
		$invo=$invoice->add($invoi);

		//获取会员id
		$_POST['uid']=$_SESSION['id'];
		//压入购买时间
		$_POST['addtime']=date('Y-m-d H:i:s');
		//创建订单数据表对象
		$order=M('orders');
		//执行订单表数据插入
		$order->create();
		$ord=$order->add();
		//dump($ord);die;
//dump($paym);dump($deta);dump($pac);dump($invo);dump($ord);die();
		if($paym && $deta && $pac && $invo && $ord){
			//创建购物车数据表对象，删除结算后的购物车商品
			$shopcart=M('shopcart');
			//获取获取购买的商品信息
			foreach($_POST['shopcartid'] as $k=>$v){
				$shopcart->where("id={$v}")->delete();
			}
			$this->success('恭喜，购买成功！',U('Home/Index/index'),5);
		}else{
			$this->error('额哦~,购买失败再来一次！');
		}
	}

	//直接结算的数据整理添加
	public function sadd(){
		//dump($_POST);die;
		//var_dump($_POST);die;
		//生成订单编号
		$_POST['oid']=time()+1;
		//创建地址信息表对象
		$address=M('address');
		//查询出收货人地址信息
		$addr=$address->where("id={$_POST['id']}")->find();
		//获取收货人姓名，电话，地址
		$_POST['linkman']=$addr['linkman'];
		$_POST['phone']=$addr['phone'];
		$_POST['address']=$addr['address'];
		unset($_POST['id']);

		//获取付款方式
		$payway=$_POST['payway'];
		unset($_POST['payway']);
		//支付与订单关联数据的添加
		$payment['oid']=$_POST['oid'];
		$payment['payway']=$payway;
		//创建支付数据表对象
		$payme=M('payment');
		//执行添加
		$paym=$payme->add($payment);

		//获取session中的商品信息
		$good=session('good');
		$good['orderid']=$_POST['oid'];
		$good['goodsid']=$good['gid'];
		$good['name']=$good['cn_name'];
		unset($good['uid']);
		unset($good['gid']);
		unset($good['en_name']);
		unset($good['cn_name']);
		unset($good['path']);
		unset($good['largesses']);
		unset($good['subtotal']);
		//订单详情表数据添加
		$detail=M('detail');
		$deta=$detail->add($good);

		//获取配件名称和配件金额
		$pay=$_POST['canju']+($_POST['lazhu']*2);
		if($_POST['canju']){
			$describe='额外餐具,';
		}
		if($_POST['lazhu']){
			$describe.='额外生日蜡烛';
		}
		unset($_POST['canju']);
		unset($_POST['lazhu']);
		//创建配件数据表对象
		$packing=M('packing');
		$pack['pay']=$pay;
		$pack['describe']=$describe;
		$pack['oid']=$_POST['oid'];
		//执行数据添加
		$pac=$packing->add($pack);

		//获取发票信息
		$title='食品';
		$company=$_POST['company'];
		unset($_POST['company']);
		$invoi['title']=$title;
		$invoi['company']=$company;
		$invoi['total']=$_POST['total'];
		$invoi['oid']=$_POST['oid'];
		//创建发票数据表对象
		$invoice=M('invoice');
		//执行添加
		$invo=$invoice->add($invoi);

		//获取会员id
		$_POST['uid']=1;
		//压入购买时间
		$_POST['addtime']=date('Y-m-d H:i:s');
		//创建订单数据表对象
		$order=M('orders');
		//执行订单表数据插入
		$order->create();
		$ord=$order->add();

		if($paym && $deta && $pac && $invo && $ord){
			//清空session中的商品信息
			session('good',null);
			$this->success('恭喜，购买成功！',U('Home/Index/index'),5);
		}else{
			$this->error('额哦~,购买失败再来一次！');
		}
	}

	//收货地址表单的操作
	public function addressadd(){
		//创建地址数据表对象
		$address=M('address');
		//执行新地址添加
		$id=$address->add($_GET);
		//返回添加数据
		if(!empty($id)){
			//修改原默认地址为非默认地址
			$oldaddress=$address->where('status=1')->find();
			$oldaddress['status']=0;
			$address->save($oldaddress);
			//修改新添加地址为默认地址
			$newaddress=$address->where("id={$id}")->find();
			$newaddress['status']=1;
			$address->save($newaddress);
			//返回结果
			echo json_encode($newaddress);
		}
	}

	//默认收货地址修改
	public function addressedit(){
		//创建地址数据表对象
		$address=M('address');
		//修改原默认地址为非默认地址
		$oldaddress=$address->where('status=1')->find();
		$oldaddress['status']=0;
		$address->save($oldaddress);
		//修改传递过来地址id对应的地址为默认地址
		$newaddress=$address->where("id={$_GET['id']}")->find();
		$newaddress['status']=1;
		$address->save($newaddress);
		//返回结果
		echo '0';
	}

	//收货地址删除
	public function addressdel(){
		//创建地址数据表对象
		$address=M('address');
		//执行收货地址删除
		$num=$address->where("id={$_GET['id']}")->delete();
		//判断成功与否，返回结果
		if($num){
			echo '0';
		}
	}

}