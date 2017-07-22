<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){

         //-------------------友情链接-------

        // 显示有友情链接
        $flink = M('flink');
        //查询
        $flink_list = $flink->where()->limit(0,10)->select();
        //分配变量
        $this->assign('flink',$flink_list);

        //-------------------友情链接-------
		
		//-------------------广告-------

        //显示广告
        $ad = M('ad');
        //查询
        $ad_list = $ad->where('num>0')->find();
        //分配变量
        $this->assign('adimg',$ad_list); 

        // var_dump($ad_list);die;
        //-------------------广告-------
 /**
 *  轮播图 banner
 */
 //购物车商品数量
 $uid=session('id');
 $shopcart=M('shopcart');
$shop=$shopcart->where("uid=".$uid)->find();
//dump($shop);
$shopnum=$shop['num'];  
//dump($shopnum);die;
$_SESSION['goodsnum']=$shopnum;    
//dump(session('goodsnum'));die;
      //计算出总金额
      // foreach($shop as $k=>$v){
      //  $total+=$v['subtotal'];
      // }
      //获取购物车商品数量
 //创建数据库对象
      $banner=M('banner');
      //获取数据
      $res=$banner->select();
      //分配变量
      $this->assign('res',$res);
 /*轮播图结束*/
    import('ORG.Net.IpLocation');
    $Ip = new \Org\Net\IpLocation('UTFWry.dat');
    
    $area = $Ip->getlocation('');
    if($area['country']=="本机地址"){
         $area = $Ip->getlocation('114.113.221.173');
    }else{
        $area = $Ip->getlocation('');
    }
    //网站开关：
    $model = C('WEBPOWER');
   //dump($model);die;
    if($model!='ON'){
    $this->display('403');die;
   }
  
    /*
    * 结果为：
    array(5) {
      ["ip"] => string(15) "114.113.221.173"
      ["beginip"] => string(13) "114.113.208.0"
      ["endip"] => string(15) "114.113.223.255"
      ["country"] => string(9) "北京市"
      ["area"] => string(6) "电信"
    }
    */
    //dump($area);die;
    $country=$area['country'];
    //dump($country);读取到北京
      $this->assign('country',$country);
      //左侧商品分类导航
      $cate=M('type');
      $category=$cate->select();
      //dump($category);die;
      $this->assign('category',$category);

      $id=$_GET['id'];

      //列表 显示 如果存在id那么 显示这个类别，如果不存在返回id，那么显示全部产品。
      if(!isset($id)){
      	//此时显示全部商品：
      	$typeshow="全部产品";
      	$this->assign('typeshow',$typeshow);
      	$goods=M(goods);
        $goodsList=$goods->select();
      }else{
      	//显示左侧分类导航栏点击后的列表
      $type=$cate->where("id=".$id)->find();
      $typename=$type['name'];
     // dump($typename);die;
      $goods=M(goods);
      $goodsList=$goods->where("type='".$typename."'")->select();
      //echo $goods->getLastSql();die;
      //dump($goodsList);die;
      	$typeshow=$typename;
      	$this->assign('typeshow',$typeshow);
  }
      $this->assign('goodsList',$goodsList);
      $this->display();
    }
//-------------------友情链接-------
    public function flink(){
        // 显示有友情链接
        $flink = M('flink');
        //统计总条数
        $c = $flink->count();
        // var_dump($c);die;
        $v = I('get.p');

        if($v<=0){
        $v=0;
        }
        $ck = ceil($c/10)+1;
        if($v>=$ck){
        $v=$ck;
        }

        //查询
        $flink_list = $flink->where()->limit($v*10,10)->select();
        $this->ajaxReturn($flink_list);
    }
    //-------------------友情链接-------


    public function napolen(){
    	$this->display();
    }
    public function mojito(){
    	$this->display();
    }
    public function order(){
      $this->display();
    }
    public function ajaxcaozuo(){
    	// dump($_POST['id']);die;
    	$this->display('index');
    }
    //请出session
    public function clsession(){
      unset($_SESSION['usercount']);
      unset($_SESSION['id']);
      $this->success('退出成功',U('Home/Index/index'));
    }
    //商品详情页
    //商品详情及获取评论9-11
    public function details(){

     //实例化对象
        $goods = M('goods');
        $country = M('country');
        $cou = $country->select();
        //查询关键字
        $id = I('get.id');

        //查询
        $goods_xq = $goods->where('id='.$id)->find();
        // $goods_xq = $goods->where($id)->find();
        // var_dump($goods_xq);die();
        // var_dump($goods_list);die();
        //分配变量
        $this->assign('goods',$goods_xq);

    //实例化评论对象
        $cons = M('content');
        $gid = I('get.id');
        //评论数
        $pnum = $cons->where('gid='.$gid)->count();
        //每页显示
        $num =3;
        //计算共几页
        $totle = ceil($pnum/$num);
        // //创建分页对象
        // $page = new \Think\Page($pnum, $num);
        // //获取limit参数
        // $limit = $page->firstRow.','.$page->listRows;
        //解析结果集
        $cons_dange = $cons->limit(0,$num)->where('gid='.$gid)->select();
        //获取页码的信息字符串
        // $pages = $page->show();
        //分配变量
        $this->assign('pinglun',$cons_dange);
        $this->assign('pNum',$pnum);
        $this->assign('page',$totle);
        $this->assign('cou',$cou);
        // var_dump($cou);die;


        $this->display();
    }
    

    //获取评论信息
    public function cont(){


    //实例化评论对象
        $cons = M('content');
        $gid = I('get.id');
        //评论数
        $pnum = $cons->where('gid='.$gid)->count();
        //每页显示
        $num =3;
        $p = I('get.p');
        $pa=!empty($p)?$p:0;
        $pao=$pa*$num;
        //解析结果集
        $cons_dange = $cons->limit($pao,$num)->where('gid='.$gid)->select();
        
       $this->ajaxReturn($cons_dange);

    }
       
}