<?php
namespace Home\Controller;
use Think\Controller;
class MembersController extends Controller {
	//判断是否登录
	public function _initialize(){
		$sid = session('id');
		if(empty($sid)){
			$this->error('您还没有登陆,请登陆...',U('Home/Login/dologin'),3);
		}

		$user = M('user');
		$users = $user->select();
		foreach ($users as $key => $value) {
			// var_dump($value['num']);
			$id = array('id'=>$value['id']);
			$u_scores = $value['u_score'];
		
			// var_dump($orderids);die;
			// var_dump($nums);die;
			$userlevel = array();
				if($u_scores >= 10000){
					$userlevel['userlevel'] = 'lv5';
				}else if($u_scores >=5000 && $u_scores < 10000){
					$userlevel['userlevel'] = 'lv4';
				}else if($u_scores >= 2000 && $u_scores < 5000){
					$userlevel['userlevel'] = 'lv3';
				}else if($u_scores >= 500 && $u_scores < 2000){
					$userlevel['userlevel'] = 'lv2';
				}else{
					$userlevel['userlevel'] = 'lv1';
				}
				// var_dump($userlevel);die;
				$users = $user->where($id)->save($userlevel);
		}
	}

	//个人中心页
	public function center(){
		//设置日期
		$time = date('Y-m-d');
		$id['id'] = session('id');
		//创建数据库对象
		$user = M('user');
		//查看登录用户信息
		$status = array('新订单','已付款','已包装','已生成发货单','已发货','已完成','无效订单' );

		$users = $user->where($id)->find();
		$usercount = $users['usercount'];
		$u_score = $users['u_score'];
		$userlevel = $users['userlevel'];


		//最新订单信息
		$uid['uid'] = session('id');
		$orders = M('orders');
		$fasong = $orders->where('uid='.session('id').' AND status=4')->count();
		$wancheng = $orders->where('uid='.session('id').' AND status=5')->count();
		$order = $orders->where($uid)->limit(1)->order('id desc')->find();
		// var_dump($order);die;

	
		//分配变量
		$this->assign('time',$time);
		$this->assign('order',$order);
		$this->assign('fasong',$fasong);
		$this->assign('wancheng',$wancheng);
		$this->assign('status',$status);
		$this->assign('usercount',$usercount);
		$this->assign('u_score',$u_score);
		$this->assign('userlevel',$userlevel);

		//解析模板
		$this->display();
	}

	//完善个人资料页
	public function edit(){
		$time = date('Y-m-d');
		//获取用户信息
		$where['id'] = session('id');
		$uid['uid'] = session('id'); 

		//创建对象
		$user = M('user');
		$anniversaries = M('anniversaries');

		$users = $user->where($where)->find();
		$anniversarie = $anniversaries->where($uid)->select();

		// var_dump($users);die;
		$this->assign('anniversarie',$anniversarie);
		$this->assign('users',$users);
		$this->assign('time',$time);
		$this->display();
	}

	//执行完善资料操作
	public function doedit(){
		//获取参数
		// var_dump($_POST);die;
		$id['id'] = session('id');
		$uid['uid'] = session('id');
		$nid = I('post.anni_id');
		$calendar = I('post.calendar');
		$year = I('post.year');
		$month = I('post.month');
		$day = I('post.day');

		$user = M('user');
		$anniversaries = M('anniversaries');

		$user->create();
		$users = $user->where($id)->save();

		for($i=0 ; $i<count($nid) ; $i++){
			$where['id'] = $nid[$i];
			$data['calendar'] = $calendar[$i];
			$data['year'] = $year[$i];
			$data['month'] = $month[$i];
			$data['day'] = $day[$i];
			$anniversarie[]= $anniversaries->data($data)->where($where)->save();
			
		}
		if(!$users){
			if(!$anniversarie){
				$this->error('个人信息更新失败');
			}else{
				$this->success('个人信息更新成功',U('Home/Members/edit'),2);
			}
		}
		if(!$anniversarie){
			if(!$users){
				$this->error('个人信息更新失败');
			}else{
				$this->success('个人信息更新成功',U('Home/Members/edit'),2);
			}
		}
		if($anniversarie && $users){
			$this->success('个人信息更新成功',U('Home/Members/edit'),2);
		}
	}

	//执行纪念日添加
	public function doadd(){
		// var_dump($_POST);die;
		$_POST['uid'] = session('id');
		$anniversaries = M('anniversaries');
		$anniversaries->create();
		if($anniversaries->add()){
			$this->success('添加纪念日成功',U('Home/Members/edit'),2);
		}else{
			$this->error('添加失败');
		}
	}

	//执行删除纪念日
	public function dodel(){
		$where['id']=I('get.id');
		$anniversaries = M('anniversaries');
		if($anniversaries->where($where)->delete()){
			$this->success('成功删除纪念日',U('Home/Members/edit'),2);
		}else{
			$this->error('删除失败');
		}
	}

	//修改密码页
	public function pwd(){
        $time = date('Y-m-d');
		$id = I('get.id');
		

		$this->assign('time',$time);
		$this->assign('id',$id);
		$this->display();
	}

	//获取手机验证码
    public function scode(){
    	//发送手机验证码
    	$phone = session('phone');
		$code = rand(1000,9999);
		
        sendMessage($phone,$code);
        session('scode',$code);
    }

	//执行密码修改
	public function dopwd(){
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

		$id['id'] = I('post.id');
		$_POST['pass'] = md5(I('post.pass'));
		$user = M('user');
		$user->create();
		if($user->where($id)->save()){
			$this->success('密码修改成功',U('Home/Members/edit'),3);
		}else{
			$this->error('密码修改失败');
		}
	}


	//我的订单页
	public function order(){
		// var_dump(session('id'));die;
		// $time = date('Y-m-d');
		//定义订单搜索和状态分类查询的变量
		$sou = I('post.sou');
		// var_dump($sou);die;
		$fenlei = I('post.fenlei');
		$fen = I('get.status');

		//判断搜索框是否为空,不空的话压入$where数组
		$sousuo = !empty($sou) ? $sou : '';
		if($sousuo != ''){
			$where['oid'] = array('like',"%$sousuo%");
		}
		//判断状态类是否有值,有的话压入$where数组
		$sta = (!empty($fenlei)||$fenlei==0) ? $fenlei : '';
		if($sta !=''){
			$where['status'] = array('eq',$sta);
		}
		$lei = (!empty($fen) || $fen == 0) ? $fen : '';
		if($lei !=''){
			$where['status'] = array('eq',$lei);
		}

		$where['uid'] = array('eq',session('id'));
		// var_dump($where);die;
		$status = array('新订单','已付款','已包装','已生成发货单','已发货','已完成','无效订单' );
		$orders = M('orders');
		// 读取总的数据条数
		$count = $orders->where($where)->count();
		$wancheng = $orders->where('uid='.session("id").' AND status=5')->count();
		$xindan = $orders->where('uid='.session("id").' AND status=0')->count();
		$daishou = $orders->where('uid='.session("id").' AND status=4')->count();
		$quxiao = $orders->where('uid='.session("id").' AND status=6')->count();
		// 创建分页对象
		$Page = new \Think\Page($count,5);
		//获取分页信息
		$limit = $Page->firstRow.','.$Page->listRows;

		$order = $orders->limit($limit)->where($where)->select();
		$pages = $Page->show();

		$this->assign('count',$count);
		$this->assign('status',$status);
		$this->assign('order',$order);
		$this->assign('wancheng',$wancheng);
		$this->assign('xindan',$xindan);
		$this->assign('daishou',$daishou);
		$this->assign('quxiao',$quxiao);
		$this->assign('pages',$pages);
		$this->assign('sou',$sou);
		$this->assign('fenlei',$fenlei);
		// $this->assign('time',$time);
		$this->display();
	}

	//详细订单
	public function order_detail(){
		$time = date('Y-m-d');
		$oid = I('get.oid');
		// var_dump($oid);die;
		$status = array('新订单','已付款','已包装','已生成发货单','已发货','已完成','无效订单' );
		$where['oid'] = array('eq',$oid);
		$orderid['mcake_detail.orderid'] = array('eq',$oid);
		$orders = M('orders');
		$order = $orders->where($where)->find();
		$detail = M('detail');

		$good = $detail->field("mcake_detail.*,mcake_goods.cn_gname,mcake_goods.picname,mcake_goods.en_gname,mcake_goods.addtime,mcake_goods.descr_cn")->join("left join mcake_goods on mcake_goods.id = mcake_detail.goodsid")->where($orderid)->select();

		$this->assign('status',$status);
		$this->assign('good',$good);
		$this->assign('order',$order);
		$this->assign('time',$time);
		$this->display();
	}

	//删除订单
	public function delete(){
		$where['id'] = I('get.id');
		$orders = M('orders');
		if($orders->where($where)->delete()){
			$this->success('删除成功');
		}else{
			$this->error('删除失败');
		}
	}

	//添加收藏
	public function shouadd(){
		//判断是否登录
		if(!session('id')){
			$this->error('您还没有登录,请先登录',U('Home/Login/dologin'),3);
		}
		//获取参数
		$data['uid'] = session('id');
		$data['gid'] = I('get.id');
		$data['gname'] = I('get.cn_gname');
		$data['shoutime'] = date('Y-m-d H:i:s',time());
		//创建对象
		$shoucang = M('shoucang');
		//执行添加收藏
		if($shoucang->data($data)->add()){
			$this->success('收藏成功');
		}else{
			$this->error('收藏失败');
		}

	}

	//我的收藏
	public function shoucang(){
		$time = date('Y-m-d');
		$sou = I('post.sou');
		//判断搜索框是否为空,不空的话压入$where数组
		$sousuo = !empty($sou) ? $sou : '';
		if($sousuo != ''){
			$where['mcake_shoucang.gname'] = array('like',"%$sousuo%");
		}
		$where['mcake_shoucang.uid'] = session('id');

		//创建对象
		$shoucang = M('shoucang');
		//查询登录会员收藏的商品
		
		$count = $shoucang->where($where)->count();
		// 创建分页对象
		$Page = new \Think\Page($count,3);
		//获取分页信息
		$limit = $Page->firstRow.','.$Page->listRows;
		$shgoods = $shoucang->field("mcake_shoucang.*,mcake_goods.cn_gname,mcake_goods.picname,mcake_goods.price,mcake_goods.addtime,mcake_goods.basefeel")->join("left join mcake_goods on mcake_goods.id = mcake_shoucang.gid")->limit($limit)->where($where)->select();

		$pages = $Page->show();
		
		$this->assign('count',$count);
		$this->assign('pages',$pages);
		$this->assign('sou',$sou);
		$this->assign('shgoods',$shgoods);
		$this->assign('time',$time);
		$this->display();
	}

	//删除收藏
	public function delshoucang(){
		// var_dump(I('get.id'));die;
		$id['id'] = I('get.id');
		$shoucang = M('shoucang');
		if($shoucang->where($id)->delete()){
			$this->success('删除成功');
		}else{
			$this->error('删除失败');
		}

	}

	public function rank(){
		$time = date('Y-m-d');
		$id['id'] = session('id');
		//创建数据库对象
		$user = M('user');
		$users = $user->where($id)->find();
		$userlevel = $users['userlevel'];
		$u_score = $users['u_score'];

		$this->assign('u_score',$u_score);
		$this->assign('userlevel',$userlevel);
		$this->assign('time',$time);
		$this->display();
	}

	public function coupons(){
		$time = date('Y-m-d');
		
		$this->assign('time',$time);
		$this->display();
	}

	public function points(){
		$time = date('Y-m-d',time());
		
		$this->assign('time',$time);
		$this->display();
	}
	
}