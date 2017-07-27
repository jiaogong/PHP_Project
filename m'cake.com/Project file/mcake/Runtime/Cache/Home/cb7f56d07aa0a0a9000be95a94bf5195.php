<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="Content-Language" content="zh-CN" />
<title>我的收藏 - MCAKE-一直都是巴黎的味道</title>
<meta name="Keywords" content="Mcake,M'cake,蓝莓轻乳拿破仑,经典香草拿破仑,拿破仑莓恋,拿破仑，胡桃布拉吉，榛果摩卡布拉吉，魅影歌剧院，巧克力格调，天使巧克力，魔鬼巧克力，蒸清抹茶，蔓越莓红丝绒，沙布雷巴菲，巧克力狂想曲，卡法香缇，瑞可塔厚爱，法香奶油可丽，莓果青柠慕斯＂" />
<meta name="Description" content="Mcake把法国传统蛋糕文化带入中国，提供纯正的欧式味觉体验，同时也将欧洲的上好材质、经典工艺以及优雅的文艺气质，融入产品的每一个细节之中，带给客户更多的享受与愉悦。" />
<meta http-equiv="X-UA-Compatible" content="IE=7" />
<meta http-equiv="cache-control" content="max-age=1800" />
<link rel="shortcut icon" href="/mcake/Public/Index/images/icons/favicon.ico" >
<link rel="stylesheet" type="text/css" href="/mcake/Public/Index/css/comm_header.css" />
<link rel="stylesheet" type="text/css" href="/mcake/Public/Index/css/ebsig.css" />
<script type="text/javascript" src="/mcake/Public/Index/js/jquery.js"></script>

<link href="/mcake/Public/Index/css/member.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="/mcake/Public/Index/css/default.css" type="text/css" media="screen" />

</head>

<body>
<style>
    /*我的订单 新弹窗*/
    ul.Review_box{ width:675px; margin:0 15px 0px 15px}
    ul.Review_box li{overflow:hidden}
    ul.Review_box li + li{ border-top:1px #c4c4c4 solid; padding-top:15px; margin-top:15px;}
    ul.Review_box .left_Review{ float:left; width:110px;}
    ul.Review_box .left_Review p span{ float:right; margin-top:3px}
    ul.Review_box .left_Review p  b{ font-size:18px; font-weight:normal}
    ul.Review_box .right_Review{float:left; padding-left:10px; width:535px; overflow:hidden; line-height:24px;}
    ul.Review_box .right_Review samp{ background:#d9e8ec;color:#767676; padding:0 5px 2px 5px; -moz-border-radius: 3px;-webkit-border-radius: 3px;border-radius:3px; cursor:pointer}
    ul.Review_box .right_Review samp:hover{ color:#b3b3b3}
    ul.Review_box .right_Review samp.cur{ background:#7b9196;color:#fff;}


    ul.Review_box .right_Review p{ padding:10px 15px 0 10px;}
    ul.Review_box .right_Review p textarea{ width:100%; height:90px;}
    div.Review_box{ width:695px; margin-bottom:25px}


    .tc-con-order{
        width:auto;
        height:auto;
        background:#f2f6f7;
        margin-left:-377px;
        margin-top:-90px;
        padding:0;
        margin:0 auto;
        position:absolute;
        z-index:99999;
        _position:absolute;
        font-size:14px;
        left:50%;/*FF IE7*/
        top: 50%;/*FF IE7*/
        margin-top:0px;
        position:fixed!important;/*FF IE7*/

    }
    .re_btn_box { text-align:center; margin: 10px 15px 0px 15px;border-top:1px #c4c4c4 solid; padding-top:10px;}
    .re_btn_box  input{ background:#b0916a; border:none; padding:8px 60px; color:#fff; -moz-border-radius: 3px;-webkit-border-radius: 3px;border-radius:3px;cursor:pointer}


    .Complaint_btn_box { text-align:center; margin: 10px 0; padding-top:10px;}
    .Complaint_btn_box  input{ background:#b0916a; border:none; padding:8px 60px; color:#fff; -moz-border-radius: 3px;-webkit-border-radius: 3px;border-radius:3px; margin:5px 15px; cursor:pointer}

    .Complaint_box{ margin:0 15px 25px 15px; width:700px;}
    .Complaint_t{text-align:center; font-size:18px;}
    .Complaint_textarea textarea{ width:100%; height:120px; margin-top:20px;}
    .Complaint_textarea p{text-align:right; padding:5px 0;}
    .Complaint_box ul{overflow:hidden}
    .Complaint_box ul li{float:left; margin-right:15px; position:relative; cursor:pointer; line-height:0;}
    .Complaint_box ul li .del{ position:absolute; bottom:0px; height:25px; text-align:center; width:100%; line-height:25px;background:rgba(0,0,0,.7);filter:progid:DXImageTransform.Microsoft.gradient(startColorstr=#99000000, endColorstr=#99000000); /* For IE 8*/ -ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr=#99000000, endColorstr=#99000000)"; color:#fff;}
    p.Tagging{ padding:10px 0 0 0;font-size:12px;}
    p.Complaint_c{ padding:0 0 20px 0; }
    p.complaint_time{ padding:10px 0; text-align:right}


    .tc-con-order{z-index:9000}
    #bill_list2 a{margin-left:5px;display:block;float:left;width:20px;font-size:16px;text-align:center;border: solid 1px #eee;}
    #bill_list2 span{margin-left:5px;display:block;float:left;width:20px;font-size:16px;text-align:center;color:blue;border: solid 1px #eee;}
    #bill_list span{width:90px;font-size:15px;}
    #fenlei{height:25px;border: none;background-color:#ddd; text-align: center;}
</style>

<!-- header开始 -->
<a name="top"></a>
<div class="header">
    
    <div class="header_top_box">
        <div class="header_top">
            <div style="width:100%; height:100px; background:#FFF; position:absolute; z-index:9;webkit-box-shadow: 3px 3px 3px #e1e1e1;-moz-box-shadow: 3px 3px 3px #e1e1e1;box-shadow: 3px 3px 3px #e1e1e1">
                <div style="width:100%; height:30px; border-bottom:1px solid #eaeaea">
                    <div class="wallbox wall_top">
                        <div id="scrollobj" style="position:absolute; left:50%;margin-left:-300px;top:0; width:560px; line-height:30px;white-space:nowrap;overflow:hidden; color:#F00"></div>
                        <div class="logoer">
                            <a href="<?php echo U(Home/Index/index);?>">
                                <img src="/mcake/Public/Index/images/logo/logo.png">
                            </a>
                        </div>
                        <ul class="navbar" id="welcome">
                            <?php if(isset($_SESSION['id'])): ?><li><a href="<?php echo U('Home/Members/center');?>" class="Gold">欢迎您<?php echo (session('usercount')); ?></a></li>
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                <li><a href="<?php echo U('Home/Login/logout');?>" class="Gold" id="clearsession">[&nbsp;退出&nbsp;]</a></li>
                            <?php else: ?>
                                <li><a href="<?php echo U('Home/Login/dologin');?>" class="Gold">LOG IN 登录</a></li>
                                <li>
                                    <a href="<?php echo U('Home/Login/signin');?>" class="Gold">SIGN UP 注册</a>
                                </li><?php endif; ?>
                        </ul>
                        <ul class="navbar">
                            <li class="m_mail" style="display: none;">
                                <a href="http://www.mcake.com/shop/member_message.html" class="Gold" target="_blank"><i></i> <span id="msg_count">0</span>封</a>
                            </li>
                            <li class="m_cart">
                                <a href="<?php echo U('Home/ShopCart/index');?>" class="Gold" target="_blank"><i></i>
                                <span id="cart_amount">
                                    <!--判断件数 session['goodsnum']-->
                                     <?php if(isset($_SESSION['goodsnum'])&&isset($_SESSION['id'])): echo (session('goodsnum')); ?>
                                    <?php else: ?>
                                        <!--判断件数 结束-->
                                        0<?php endif; ?>
                                </span>件</a>
                            </li>
                        </ul>
                        <div class="clear"></div>
                    </div>
                </div>
                <div class="wallbox">
                    <div class="header_right">
                        <ul class="phone_delivery">
                            <li class="phone">
                                <span>4006-678-678</span><i></i>
                            </li>
                            <li class="delivery">
                                <span>
                                    <a href="<?php echo U('Home/Article/express');?>" target="_blank" id="addresscity">北京配送范围免费配送</a>
                                </span><i></i>
                            </li>
                        </ul>
                    </div>
                    <ul class="menu">
                        <li>
                            <a href="<?php echo U('Home/Index/index');?>" class="ebsig_all_goods" target="_blank"><samp>Nos Produits</samp><span>全部产品</span>
                            </a>
                        </li>
                        <li>
                                    
                            <a href="<?php echo U('Home/Napolen/napolen');?>" target="_blank"><samp>Napoléon</samp><span>拿破仑系列</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo U('Home/Active/index');?>" target="_blank"><samp>Nouveauté</samp><span>最新活动</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo U('Home/Members/center');?>" target="_blank">
                                <samp>Mon M'CAKE</samp>
                                <span>会员中心</span>
                            </a>
                        </li>
                    </ul>
                    <div class="clear"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--header 结束 -->

<div id="page_mainer">
    <div class="user_box">
        <div class="user_title">
            <p class="user_t_img">
                <i></i><span>会员中心</span>
            </p>
        </div>
        <div class="user_left">

            <div class="showtime">

                <span>Vendredi , <?php echo ($time); ?></span>

                <p id='week'></p>
            </div>

            <ul class="user_nav" style="width: 200px;">
                <li><a href="<?php echo U('Home/Members/edit');?>">完善个人资料</a> <i></i></li>
                <li><a href="<?php echo U('Home/Members/order');?>">我的订单</a> <i id="i_id"></i>
                </li>
                <li><a href="<?php echo U('Home/Members/shoucang');?>">我的收藏</a> <i></i>
                </li>
                <li><a href="<?php echo U('Home/Members/rank');?>">我的权益</a>
                    <dl class="my_Interest">
                        <dd><span></span><a href="<?php echo U('Home/Members/rank');?>">我的会员等级</a> <em></em></dd>
                    </dl>
                </li>
                <li><a href="<?php echo U('Home/Members/coupons');?>">我的优惠/分享券</a> <i></i></li>
                <li><a href="<?php echo U('Home/Members/points');?>">我的积分</a> <i></i></li>
                <li class="userMyMsg" style="display: none;"><a href="">我的消息</a> <i></i></li>
            </ul>
            <div class="user_exit"><a href="<?php echo U('Home/Login/logout');?>">退出登录</a></div>
        </div>
        <div class="login_right mynews_box order_list">
           <form action="<?php echo U('Home/Members/shoucang');?>" method="post">
            <ul>
                <li><p ><span>我的收藏<font color="#b0916a" size="2">（在填写框中输入商品的收藏编号）</font></span></p></li>
                <li class="Coupons">
                    <div>
                        <input type="text" name="sou" value="<?php echo ($sou); ?>" class="input_txt Search_icon" placeholder="收藏编号进行搜索"/>
                    </div>
                    <div class="toModify">
                        <input type="submit" value="搜索" id='sou' class="Search" />
                    </div>
                </li>
            </ul>
            <ul class="view_list all_list">

                <li class="cur">
                    <ul style="height:35px;"></ul>
                    <ul class="order_th">
                        <li style="border:solid 1px #eee;width:180px;">商品图片</li>
                        <li style="border:solid 1px #eee;width:120px;">商品名</li>
                        <li style="border:solid 1px #eee;width:120px;">单价</li>
                        <li style="border:solid 1px #eee;width:120px;">口味</li>
                        <li style="border:solid 1px #eee;width:140px;">收藏时间</li>
                        <li style="border:solid 1px #eee;width:200px;">操作</li>
                    </ul>
                    <?php if(is_array($shgoods)): foreach($shgoods as $key=>$vo): ?><ul class="order_th">
                        <li style="border:solid 1px #eee;width:180px ;height:180px;"><img src="/Uploads/Admin/images/GoodsImg/<?php
 $pic=explode(',',$vo['picname']); echo (substr($vo['addtime'],0,8)."/".$pic[0]);?>"alt="" style="width:160px;margin-top:10px;"/>
                        </li>
                        <li style="border:solid 1px #eee;width:120px;height:180px;line-height:180px;"><?php echo ($vo['cn_gname']); ?></li>
                        <li style="border:solid 1px #eee;width:120px;height:180px;line-height:180px;"><?php
 $arr=explode(',',$vo['price']); echo $arr[0];?></li>
                        <li style="border:solid 1px #eee;width:120px;height:180px;line-height:180px;"><?php echo ($vo['basefeel']); ?></li>
                        <li style="border:solid 1px #eee;width:140px;height:180px;line-height:180px;"><?php echo ($vo['shoutime']); ?></li>
                        <li style="border:solid 1px #eee;width:200px;height:180px;line-height:180px;">
                            <a href="<?php echo U('Home/Index/index');?>">更多商品</a>
                            <a href="<?php echo U('Home/Members/delshoucang');?>?id=<?php echo ($vo['id']); ?>">删除</a>
                        </li>
                    </ul><?php endforeach; endif; ?>
                </li>
                <li class="cur" id="bill_list"style="width:90px;dispaly:block;float:left;"><span>共计&nbsp;<?php echo ($count); ?>&nbsp;条</span></li>

                <li class="cur" id="bill_list2" style="width:500px;dispaly:block;float:left;"><?php echo ($pages); ?></li>

            </ul>
           </form>
        </div>

    </div>
</div>

<!-- footer开始 -->
<div id="footer">
    <!-- 底部小活动li 开始 -->
    <div id="wallbox" class="wallbox">
        <ul class="activity_list" id="activity_list">
            <li>
                <a href="" target="_blank">
                    <img src="/mcake/Public/Index/images/2015072811191115080.jpg" alt="" width="100%">
                </a>
            </li>
            <li>
                <a href="" target="_blank">
                    <img src="/mcake/Public/Index/images/2015082009154299636.jpg" alt="" width="100%">
                </a>
            </li>
            <li>
                <a href="" target="_blank"><img src="/mcake/Public/Index/images/2015070313312260770.jpg" alt="" width="100%">
                </a>
            </li>
        </ul>
        <div class="clear"></div>
    </div>
    <!-- 底部小活动li 结束 -->
    <div class="wallbox_1000">
        <div class="m_copy">
            <ul class="Share">
                <li class="Swb">
                    <a href="http://weibo.com/mcake1893" target="_blank"></a>
                </li>
                <li class="Twx">
                    <a href="javascript:void(0);"></a>
                </li><!--<li class="Tkj"><a href="#"></a></li>-->
            </ul>
            <div class="wxqr"><samp></samp></div>
            <p>Copyright © 2012-2015            </p>
            <p>上海卡法电子商务有限公司 版权所有</p>
            <p class="icp_no">沪ICP备12022075号</p>
            <p class="icp_no">地址：上海市普陀区同普路1130弄3号</p>
            <p class="icp_no">客服热线：4006-678-678</p>
            <p class="icp_no">客服邮箱：cs@mcake.com</p>
        </div>
        <div class="foot_nav_bar">
            <dl>
                <dt>
                    <a href="<?php echo U('Home/Article/express');?>">发现</a>
                </dt>
                <dd>
                    <a href="<?php echo U('Home/Article/express');?>" target="_blank">配送服务</a>
                </dd>
                <dd>
                    <a href="http://weibo.com/mcake1893" target="_blank">微博</a>
                </dd>
            </dl>
            <dl>
                <dt>
                    <a href="<?php echo U('Home/Article/express');?>">关于我们</a>
                </dt>
                <dd>
                    <a href="<?php echo U('Home/Article/index');?>" target="_blank">媒体合作</a>
                </dd>
                <dd>
                    <a href="<?php echo U('Home/Article/job');?>" target="_blank">招贤纳士</a>
                </dd>
                <dd>
                    <a href="<?php echo U('Home/Article/call');?>" target="_blank">呼叫中心</a>
                </dd>
            </dl>
            <dl>
                <dt>
                    <a href="<?php echo U('Home/Article/express');?>">帮助中心</a>
                </dt>
                <dd>
                    <a href="<?php echo U('Home/Article/vip');?>" target="_blank">会员权益</a>
                </dd>
                <dd>
                    <a href="<?php echo U('Home/Article/shop');?>" target="_blank">购物指南</a>
                </dd>
                <dd>
                    <a href="<?php echo U('Home/Article/pay');?>" target="_blank">支付类</a>
                </dd>
                <dd>
                    <a href="<?php echo U('Home/Article/order');?>" target="_blank">订单相关</a>
                </dd>
            </dl>
        </div>
        <div class="m_wb" style="text-align: center;">
            <img src="/mcake/Public/Index/images/icons/wx_icon.png" <="" div="">
            <div class="clear"></div>
        </div>
        <div class="clear"></div>
    </div>
</div>
<!-- footer结束 -->

<script type="text/javascript">

    // 设置星期
    var d = new Date();
    var week = d.getDay();
    switch (week) {
        case 0:
            $('#week').html('今天是星期日');
            break;
        case 1:
            $('#week').html('今天是星期一');
            break;
        case 2:
            $('#week').html('今天是星期二');
            break;
        case 3:
            $('#week').html('今天是星期三');
            break;
        case 4:
            $('#week').html('今天是星期四');
            break;
        case 5:
            $('#week').html('今天是星期五');
            break;
        case 6:
            $('#week').html('今天是星期六');
            break;
    }

</script>

</body>
</html>