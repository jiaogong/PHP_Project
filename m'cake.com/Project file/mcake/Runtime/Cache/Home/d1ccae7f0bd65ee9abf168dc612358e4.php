<?php if (!defined('THINK_PATH')) exit();?>i<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="Content-Language" content="zh-CN" />
<title>会员中心 - MCAKE-一直都是巴黎的味道</title>
<meta name="Keywords" content="Mcake,M'cake,蓝莓轻乳拿破仑,经典香草拿破仑,拿破仑莓恋,拿破仑，胡桃布拉吉，榛果摩卡布拉吉，魅影歌剧院，巧克力格调，天使巧克力，魔鬼巧克力，蒸清抹茶，蔓越莓红丝绒，沙布雷巴菲，巧克力狂想曲，卡法香缇，瑞可塔厚爱，法香奶油可丽，莓果青柠慕斯＂" />
<meta name="Description" content="Mcake把法国传统蛋糕文化带入中国，提供纯正的欧式味觉体验，同时也将欧洲的上好材质、经典工艺以及优雅的文艺气质，融入产品的每一个细节之中，带给客户更多的享受与愉悦。" />
<meta http-equiv="X-UA-Compatible" content="IE=7" />
<meta http-equiv="cache-control" content="max-age=1800" />
<link rel="shortcut icon" href="/mcake/Public/Index/images/icons/favicon.ico" >
<link rel="stylesheet" type="text/css" href="/mcake/Public/Index/css/comm_header.css" />
<link rel="stylesheet" type="text/css" href="/mcake/Public/Index/css/Landing_city.css" />

<link rel="stylesheet" type="text/css" href="/mcake/Public/Index/css/ebsig.css" />

<script type="text/javascript" src="/mcake/Public/Index/js/jquery.js"></script>

<link href="/mcake/Public/Index/css/member.css" rel="stylesheet" type="text/css">
</head>
<body>

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

            <!--绑定会员卡-->
            <ul class="Member_card_box">

                <li>
                    <p>
                        <span class="red">欢迎您：<?php echo ($usercount); ?></span>
                        <a href="<?php echo U('Home/Members/edit');?>" class="go">完善个人资料 <small>>></small></a>
                    </p>
                </li>

                <li class="Level">
                    <span>会员级别：</span>
                    <i class="vip1" id='userlevel'><?php echo ($userlevel); ?></i>
                </li>

                <li>我的积分：<?php echo ($u_score); ?></li>

                <li class="status">
                    <span>我的订单：</span>
                    <span>
                        配送中 <a href="<?php echo U('Home/Members/order?status=4');?>" class="Gold">(<?php echo ($fasong); ?>)</a><br />
                        已完成 <a href="<?php echo U('Home/Members/order?status=5');?>" class="Gold">(<?php echo ($wancheng); ?>)</a>
                    </span>
                </li>

                <li class="mynews">
                    <span>我的消息：有 <a href="" class="Gold">(0)</a> 条未读</span>
                    <i class="news_icon"></i>
                </li>

                <?php if(empty($order)): ?><li>
                        <p>
                            <span>您还未生成过订单</span>
                            <a href="<?php echo U('Home/Index/index');?>" class="go">去购买蛋糕 <small>>></small></a>
                        </p>
                    </li>
                <?php else: ?>
                    <li>
                        <p>
                            <span>最新订单</span>
                            <a href="<?php echo U('Home/Members/order_detail');?>" class="go">查看详情 <small>>></small></a>
                        </p>
                    </li><?php endif; ?> 
                
            </ul>
            <ul class="view_list hide" id="bill_list">
                <?php if(empty($order)): ?><li class="cur" id="xindingdan" style="font-size:15px;">
                    </li>
                <?php else: ?>
                    <li class="cur" id="xindingdan" style="font-size:15px;">
                        <dl class="all_order_list">
                            <dd>
                            <span class="order_num">订单编号 ：<?php echo ($order["oid"]); ?></span>
                                <samp class="Gold">￥<?php echo ($order['total']); ?></samp>
                                <span><?php echo ($status[$order['status']]); ?></span>
                                <span>
                                    <a class="Grey" href="<?php echo U('Home/Members/order_detail');?>?oid=<?php echo ($order['oid']); ?>">查看详细 >></a>
                                </span>
                            </dd>
                        </dl>
                    </li><?php endif; ?>
            </ul>
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

    //等级设置
    var userlevel = $('#userlevel').html();
    // alert(userlevel);
    switch(userlevel){
        case 'lv1':
            $('#userlevel').attr('class','vip1');
            $('#userlevel').html('');
            break;
        case 'lv2':
            $('#userlevel').attr('class','vip2');
            $('#userlevel').html('');
            break;
        case 'lv3':
            $('#userlevel').attr('class','vip3');
            $('#userlevel').html('');
            break;
        case 'lv4':
            $('#userlevel').attr('class','vip4');
            $('#userlevel').html('');
            break;
        case 'lv5':
            $('#userlevel').attr('class','vip5');
            $('#userlevel').html('');
            break;
    }
    
    // if(!<?php echo ($order); ?>){
    //     $('.Member_card_box li:eq(5) p span').html('您还未生成过订单');
    //     $('.Member_card_box li:eq(5) p a').attr('href',"<?php echo U('Home/Index/index');?>").html('去购买蛋糕>>');
    // }else{
    //     $('.Member_card_box li:eq(5) p span').html('最新订单');
    //     $('.Member_card_box li:eq(5) p a').attr('href',"<?php echo U('Home/Members/order');?>").html('查看全部订单>>');
    //     var dl = $('<dl class="all_order_list"><dd><span class="order_num">订单编号 ：<?php echo ($order["oid"]); ?></span><samp class="Gold">￥<?php echo ($order['total']); ?></samp><span><?php echo ($status[$order['status']]); ?></span><span><a class="Grey" href="<?php echo U('Home/Members/order_detail');?>">查看详细 >></a></span></dd></dl>');
    //     $('#xindingdan').append(dl);
    // }
</script>

</body>
</html>