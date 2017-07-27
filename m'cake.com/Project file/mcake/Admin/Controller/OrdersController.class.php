<?php 
namespace Admin\Controller;
use Think\Controller;
class OrdersController extends CommonController{
	public function index(){
		echo "hello";
		$this->display();
	}
public function orders(){
/**
*后台首页中，用户点击单项目中的订单列表时触发js的ordersList()该函数首先调用indexController()控制器中的orders()方法。
该方法重定向到OrdersController()控制器中的orders()方法，实例化订单，同时进行分页操作，将数据传递到控制器orders目录下的orders.html
*
*/
//******************************
$xianshi = I('get.xianshi');
		$sou = I('get.sou');
		$num = !empty($xianshi) ? $xianshi : 6; //每页显示数据条数
		$keyword = !empty($sou) ? $sou : ''; //账号搜索关键字
		if($keyword != ''){
			$where['status'] = array('like',"%$keyword%");
		}

		//创建对象
		$order= M('Orders');
		
			//读取总的数据条数
			$count = $order->where($where)->count();
			// 创建分页对象
			$Page = new \Think\Page($count,$num);
			//获取分页信息
			$limit = $Page->firstRow.','.$Page->listRows;

			$orders_list = $order->limit($limit)->where($where)->select();
			$pages = $Page->show();

			
			//分配变量
			$this->assign('orders_list',$orders_list);
			$this->assign('pages',$pages);
			$this->assign('xianshi',$xianshi);
			$this->assign('sou',$sou);
			$this->display();
}
//修改状态时，点击修改后保存
public function save(){
	$orders=M('Orders');
	$id=$_REQUEST['id'];
	$data['status']=$_POST['status'];

	//dump($data['status']);
	if($data['status']==5){
			$data1=$orders->where("id=".$id)->find();
			$oid['oid']=$data1['oid'];
			//dump($oid);die;
 			$uid=$data1['uid'];			
 			$user=M('User')->where("id=".$uid)->find();
 			//dump($user);die;
 			$s=M('goodsinvoice');
 			$res=$s->where("oid='{$oid['oid']}'")->find();
 			//dump($res);die;
 			$total['u_score']=ceil($res['total']+$user['u_score']);
 			//dump($total['u_score']);die;
 			$res2=M('User')->where("id=".$uid)->save($total);
 			//save($total['u_score']);
 			//dump($res2);die;

	}
	$where['id']=$_POST['id'];
	//dump($where['id']);
	$result=$orders->where("id=".$where['id'])->save($data);
	if($result!==false){
		$this->success('修改成功', '../Orders/Orders',1);
	}else{
		$this->error('修改失败','../Orders/Orders',1);
	}
}
 	public function delete(){
 		// echo "hello";
 		$id=$_REQUEST['id'];
 		$orders=M('Orders');
 		//$where['id']=$_REQUEST['id'];
 		$result=$orders->delete($id);
 		if($result!==false){
		$this->success('删除成功', '../../Orders',1);
	}else{
		$this->error('删除失败','../../Orders',1);
	}
 	}
 	//打印发货单详细信息存根，及供库房发货员发货。
 	public function details(){
 		//这里涉及了订单表，订单详情表，商品表，用户表，发货地址表。
 		$o=M('Orders');
 		$oid=$_REQUEST['oid'];
 		$data=$o->where("id=".$oid)->find();
 		//dump($data);die;
 		$this->assign('data',$data);
 		$invoice=M(invoice);
 		//发票
 		$invodata=$invoice->where("oid='{$data['oid']}'")->find();
 		//dump($invodata);die;
 		$type=$invodata['privateperson'].$invodata['company'];
 		$this->assign('type',$type);
 		$this->assign('invodata',$invodata);
 		$detail=M('detail');
 		//dump($data['oid']);die;
 		$detaildata=$detail->where("orderid='{$data['oid']}'")->find();
 		//dump($detaildata);die;
 		//找到商品
 		$this->assign('detaildata',$detaildata);
 		$total=$detaildata['price']*$detaildata['num'];
 		$this->assign('total',$total);
 		$this->display();
 	}
 	public function pack(){
 		$id=$_REQUEST['id'];

 		$orders=M('orders');
 		
 		$ordersData=$orders->where("id=".$id)->find();//通过传递过来的oid找到订单的id,找到订单，然后找到这个订单的订单编码。这样的过程。
 		//echo $orders->getLastSql();
 		//dump($ordersData);die;//订单已经找到
 		//实例化包装表，因为可能含有用户需求的数据，如果用户不需要，那么里面的数据为空。
 		$pack=M('packing');
 		$packData=$pack->where("oid='{$ordersData['oid']}'")->find();
 		//var_dump($packData);
 		$this->assign('packData',$packData);
 		$this->assign('ordersData',$ordersData);
 		$this->display();
 	}
 	public function packsave(){
 		$pack=array();
 		$pack1=$_REQUEST['id'];
 		$pack['oid']=$_REQUEST['oid'];
 		//dump($pack['oid']);die;
 		$pack['pay']=$_REQUEST['pay'];
 		$pack['free']=$_REQUEST['free'];
 		$pack['describe']=$_REQUEST['describe'];
 		$pack['name']=$_REQUEST['name'];
 		$packchange=M('packing');
 		//dump($packchange);
 		$res=$packchange->where("oid='{$pack['oid']}'")->save($pack);
 		if(isset($res)){
 			$orders=M('Orders');
 			$pack2=array();
 			$pack2['status']=2;//把状态修改为包装已生成
 			//$orders
 		$result=$orders->where("oid='{$pack['oid']}'")->save($pack2);
 		//dump($result);
 		$this->success('包装生成成功', '../',1);
 		//包装生成成功，那么订单的状态修改为：包装生成。
	}else{
		$this->error('包装生成失败','../',1);
	}
 	}
 	//下面是发货单：使用的方法
 	public function invoice(){
 		$id=$_REQUEST['id'];
 		//dump($id);4
 		$orders=M('Orders');
 		$ordersList=$orders->where("id=".$id)->find();
 		//echo $orders->getLastSql();die;
 		$this->assign('ordersList',$ordersList);//压入 发货单 
 		//查找用户
 		$user=M('user');
 		$username=$user->where("id='{$ordersList['uid']}'")->find();
 		//echo $user->getLastSql();die;
 		//dump($username);
 		$this->assign('username',$username['name']);
 		$details=M('detail');
 		$goodsorder=$details->where("orderid=".$ordersList['oid'])->find();
 		//echo $relationgoodsorders->getLastSql();die;
 		//dump($goodsorder);die;//已经得到商品和订单关系
 		$this->assign('goodsorder',$goodsorder);//将商品关系压入发货单
 		//下面要做就是把关联到的商品找到然后压入发货单
 		$goods=M('goods');
 		$id=$goodsorder['goodsid'];
 		//dump($id);die;
 		$goodsList=$goods->where("id=".$id)->find();
 		//dump($goodsList);die;
 		
 		//接下来把商品压入 发货单
 		$this->assign('goodsList',$goodsList);
 		//把包装信息压入模板
 		$pack=M('packing');
 		//var_dump($goodsorder['goodsid']);
 		$packList=$pack->where("oid='{$ordersList['oid']}'")->find();
 		//实例化模板
 		//echo $pack->getLastSql();die;//必须是实例化的对象，查看其最后一次的sql.
 		//var_dump($packList);
 		//压入 模板
 		$this->assign('packList',$packList);
 		//还差发票信息没有压入现在做发票信息压入：发票 金额打印发票时后压入。
 		$invoice=M('invoice');
 		$invoiceList=$invoice->find();
 		//dump($invoiceList);
 		$this->assign('invoiceList',$invoiceList);
 		$payment=M('payment');
 		$payway=$payment->where("oid='{$ordersList['oid']}'")->find();
 		//dump($payway);
 		$this->assign('payway',$payway);
 		//商品总价
 		$goodsprice=$goodsorder['price']*$goodsorder['num'];
 		//包装价格
 		$packageprice=$packList['pay']-$packList['free'];
 		//发货单的总价
 		$total=$goodsprice+$packageprice;
 		$this->assign('total',$total);//当订单状态为完成，那么这个total，值将作为积分存入到用户账户中。
 		$this->assign('goodsprice',$goodsprice);
 		//
 		$this->display();
 	}
 	//生成发货单时往发货单表里写数据。下面这个动作是上个动作点击生成发货单时写入数据库的动作
 	public function goodsinvoice(){
 		$data=array();
 		
 		$data['username']=$_REQUEST['username'];
 		$data['oid']=$_REQUEST['oid'];
 		$data['linkman']=$_REQUEST['linkman'];
 		$data['invoice_number']=$_REQUEST['invoice_number'];
 		$data['payway']=$_REQUEST['payway'];
 		$data['packname']=$_REQUEST['packname'];
 		$data['packpay']=$_REQUEST['packpay'];
 		$data['packfree']=$_REQUEST['packfree'];
 		$data['address']=$_REQUEST['address'];
 		$data['sendtime']=$_REQUEST['sendtime'];
 		$data['goodsname']=$_REQUEST['goodsname'];
 		$data['goodsnum']=$_REQUEST['goodsnum'];
 		$data['taste']=$_REQUEST['taste'];
 		$data['feeling']=$_REQUEST['feeling'];
 		$data['sweet']=$_REQUEST['sweet'];
 		$data['goodsprice']=$_REQUEST['goodsprice'];
 		$data['goodstotalprice']=$_REQUEST['goodstotalprice'];
 		//包装描述
 		$data['describe']=$_REQUEST['describe'];
 		$data['beizhu']=$_REQUEST['beizhu'];
 		$data['total']=$_REQUEST['total'];
 		$data['time']=date(YmdHis);
 		//dump($data['time']);
 		//var_dump($data);die;
 		$goodsinvoice=M('goodsinvoice');

		//发货单编号
 		$data['goodsinvoicenum']=date(ymd).time();
 		//var_dump($invoice_number);"1509011441038233" 
 		$resinvoice=$goodsinvoice->add($data);
 		if($resinvoice!==false){
 				$orders=M('Orders');
 			$s=array();
 			$s['status']=3;//把状态修改为包装已生成
 			//$orders
 		$result=$orders->where("oid='{$data['oid']}'")->save($s);

 		//生成发票,当生成发货单的同时发票生成。主要是对原有前台生成的发票信息追加 订单的唯一编码，发票唯一编码。追加完成，即生成发票完成，在发票查询中，可以查询到。
 		$code['oid']=$_REQUEST['oid'];
 		$code['privateperson']=$_REQUEST['linkman'];
 		$code['company']=$_REQUEST['linkman'];
 		$code['title']="明细";
 		$code['uid']=$_REQUEST['username'];
 		$code['total']=$_REQUEST['total'];
 		$code['content']=$_REQUEST['content'];
 		$code['status']=1;
 		$code['code']=$_REQUEST['invoice_number'];
 		$code['addtime']=date(YmdHis);
 		$resutlcode=M('invoice');
 		$resutlcode->create($code);
 		$resutlcode->add();

		$this->success('发货单生成成功', '../',1);
	}else{
		$this->error('生成失败','../',1);
	}
 	}
 	public function fahuodan(){
 		$goodsinvoice=M('goodsinvoice');
 		$resf=$goodsinvoice->select();
 		//dump($resf);
 		//die;
 		$this->assign('resf',$resf);
 		$this->display();
 		/*
 		//把total值传入用户表：用于用户判断等级
 		$users=M('users');
 		$usersdata=$users->where()->find();
 		$total=ceil($usersdata['u_score']+$resf['total']);
 		$yaru=$users->
		*/

 	}
 	//这的订单是前台提交后生成，订单唯一编号，
 	//这里的发票在前端生成能生成含有订单号的，及其无发票号的发票项目，所以后台当发货单单填写发票号时，修改对应含有oid的发票编号，所以测试时，造与订单同号 的发票不含发票编码。这样才可以测试。
 	public function fahuoupdate(){
 		$status['status']=$_REQUEST['status'];
 		$id=$_REQUEST['id'];
 		//dump($_REQUEST);die;
 		if($status['status']==1){
 			$s=M('goodsinvoice');
 			//dump($s);die;
 			$res=$s->where("id=".$id)->save($status);
 			//$res=$s->where($id)->find();
 			//var_dump($res);die;
 			//dump($res->getLastSql);die;
 			if($res!==false){
 			$data=$s->where("id=".$id)->find();
 			//dump($data['total']);die;
 			//订单状态改为已发货。
 			$status['status']=4;
 			$data1=M('Orders')->where("oid='{$data['oid']}'")->save($status);
		$this->success('发货单及发票生成成功', '../',1);
	}else{
		$this->error('生成失败','../',1);
	}
 		}
 	}
 	public function fahuodelete(){
 		$id=$_REQUEST['id'];
 		$s=M('goodsinvoice');
 		$res=$s->delete($id);
 	if($res!==false){
		$this->success('发货单删除成功', '../../fahuodan',1);
	}else{
		$this->error('删除失败','../../fahuodan',1);
	}
 	}
 	public function fahuodanprint(){
 		$id=$_REQUEST['id'];	
 		$data=M('goodsinvoice')->where("id=".$id)->find();
 		$this->assign('data',$data);
 		$goodstotal=$data['goodsprice']*$data['goodsnum'];
 		$this->assign('goodstotal',$goodstotal);
 		$this->display();
 	} 
 	//发票列表
 	public function fapiao(){
//分页
//**************************************************************************
 		$xianshi = I('get.xianshi');
		$sou = I('get.sou');
		$num = !empty($xianshi) ? $xianshi : 6; //每页显示数据条数
		$keyword = !empty($sou) ? $sou : ''; //账号搜索关键字
		if($keyword != ''){
			$where['status'] = array('like',"%$keyword%");
		}

		//创建对象
		$order= M('invoice');
		
			//读取总的数据条数
			$count = $order->where($where)->count();
			// 创建分页对象
			$Page = new \Think\Page($count,$num);
			//获取分页信息
			$limit = $Page->firstRow.','.$Page->listRows;

			$res = $order->limit($limit)->where($where)->select();
			$pages = $Page->show();

			
			//分配变量
			$this->assign('res',$res);
			$this->assign('pages',$pages);
			$this->assign('xianshi',$xianshi);
			$this->assign('sou',$sou);
			$this->display();

//**************************************************************************
		
 	}
 	//删除发票
 	public function fapiaodel(){
 		$id=I('get.id');
 		//dump($id);die;
 		$del=M('invoice');
 		$res=$del->where("id=".$id)->delete();
 		if($res!==false){
		$this->success('删除此发票成功', '../../fapiao',1);
	}else{
		$this->error('删除失败','../../fapiao',1);
	}
 	}
 	public function fapiaoupdate(){
 		$data['status']=$_REQUEST['print'];
 		//dump($_REQUEST['inid']);die;
 		 // if($data['print']===0){
 		 // 	$data['print']=1;
 		 // }else{
 		 // 	$data['print']=0;
 		 // }
 		$update=M('invoice');
 		$res=$update->where("id=".$_REQUEST['inid'])->save($data);
 		//$res=$update->getLastSql();dump($res);die();
 		if($res){
 			$this->success('打印状态已经修改成功','../../Admin/Orders/fapiao',1);
 		}else{
 			$this->error('修改失败','../../Admin/Orders/fapiao',1);
 		}
 	}
 	public function fapiaoprint(){

 		$fpdetail=$_REQUEST['invoice_number'];
 		//dump($fpdetail);die;
 		$print=M('invoice');
 		//dump($print);die;
 		$res=$print->where("code="."'".$fpdetail."'")->select();
 		//echo $print->getLastSql();die;
 		$this->assign('res',$res);
 		$this->display();
 	}
 }