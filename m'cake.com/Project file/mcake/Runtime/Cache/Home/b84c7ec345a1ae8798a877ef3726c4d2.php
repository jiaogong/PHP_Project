<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="Content-Language" content="zh-CN" />
<title>我的会员等级 - MCAKE-一直都是巴黎的味道</title>
<meta name="Keywords" content="Mcake,M'cake,蓝莓轻乳拿破仑,经典香草拿破仑,拿破仑莓恋,拿破仑，胡桃布拉吉，榛果摩卡布拉吉，魅影歌剧院，巧克力格调，天使巧克力，魔鬼巧克力，蒸清抹茶，蔓越莓红丝绒，沙布雷巴菲，巧克力狂想曲，卡法香缇，瑞可塔厚爱，法香奶油可丽，莓果青柠慕斯＂" />
<meta name="Description" content="Mcake把法国传统蛋糕文化带入中国，提供纯正的欧式味觉体验，同时也将欧洲的上好材质、经典工艺以及优雅的文艺气质，融入产品的每一个细节之中，带给客户更多的享受与愉悦。" />
<meta http-equiv="X-UA-Compatible" content="IE=7" />
<meta http-equiv="cache-control" content="max-age=1800" />
<link rel="shortcut icon" href="/mcake/Public/Index/images/icons/favicon.ico" >

<link rel="stylesheet" type="text/css" href="/mcake/Public/Index/css/comm_header.css" />
<link rel="stylesheet" type="text/css" href="/mcake/Public/Index/css/ebsig.css" />
<link href="/mcake/Public/Index/css/member.css" rel="stylesheet" type="text/css">

<script type="text/javascript" src="/mcake/Public/Index/js/jquery.js"></script>


<style type="text/css">
    .at_update{position:relative;color:#000}
    .at_update .nums .num{*display:inline}
    .at_update .nums.num_level_1 .num_d{width:0}
    .at_update .nums.num_level_1 .num_a ul,.at_update .nums.num_level_1 .num_c ul{top:0}
    .at_update .nums.num_level_1 .num_b ul,.at_update .nums.num_level_1 .num_d ul{bottom:0}
    .at_update .nums.num_level_2 .num_d{width:0}
    .at_update .nums.num_level_2 .num_a ul,.at_update .nums.num_level_2 .num_c ul{top:-42px}
    .at_update .nums.num_level_2 .num_b ul,.at_update .nums.num_level_2 .num_d ul{bottom:-42px}
    .at_update .nums.num_level_3 .num_a ul,.at_update .nums.num_level_3 .num_c ul{top:-84px}
    .at_update .nums.num_level_3 .num_b ul,.at_update .nums.num_level_3 .num_d ul{bottom:-84px}
    .at_update .nums.num_level_4 .num_a ul,.at_update .nums.num_level_4 .num_c ul{top:-126px}
    .at_update .nums.num_level_4 .num_b ul,.at_update .nums.num_level_4 .num_d ul{bottom:-126px}
    .at_update .nums.num_level_5 .num_a ul,.at_update .nums.num_level_5 .num_c ul{top:-168px}
    .at_update .nums.num_level_5 .num_b ul,.at_update .nums.num_level_5 .num_d ul{bottom:-168px}
    .at_update .level{height: 180px;background: transparent url(/mcake/Public/Index/images/vip_line.jpg) no-repeat scroll 0% 0%;}
    .at_update .level.Status1{ background-position:0 0}
    .at_update .level.Status2{ background-position:0 -180px}
    .at_update .level.Status3{ background-position:0 -360px}
    .at_update .level.Status4{ background-position:0 -540px}
    .at_update .level.Status5{ background-position:0 -720px}
    .at_update .level.Status6{ background-position:0 -900px}
    .at_update .level.Status7{ background-position:0 -1080px}
    .at_update .level.Status8{ background-position:0 -1260px}
    .at_update .level.Status9{ background-position:0 -1440px}

    .at_update .level ul{position:relative;width:684px;height:100%;}
    .at_update .level ul li{ overflow:inherit; padding:0;position:absolute;width:50px;height:60px;line-height:22px;font-family:"Source Sans Pro Light",arial,"Microsoft Yahei","Hiragino Sans GB",sans-serif;text-align:center}
    .at_update .level ul li span{display:block; text-align:center; color:#767676;}
    .at_update .level ul li span small{background:url(/mcake/Public/Index/images/icons/icon.png) no-repeat; margin:auto; width:14px; height:14px; display:block}
    .at_update .level ul li span.v1 small{background-position:-5px -410px}
    .at_update .level ul li span.v2 small{background-position:-23px -410px}
    .at_update .level ul li span.v3 small{background-position:-41px -410px}
    .at_update .level ul li span.v4 small{background-position:-58px -410px}
    .at_update .level ul li span.v5 small{background-position:-76px -410px}

    .at_update .level ul li.level_1{left: 12px;bottom: 4px;}
    .at_update .level ul li.level_2{left: 147px;bottom: 12px;}
    .at_update .level ul li.level_3{left: 282px;bottom: 28px;}
    .at_update .level ul li.level_4{left: 417px;bottom: 62px;}
    .at_update .level ul li.level_5{left: 553px;bottom: 116px;}
    .at_update .level ul li.level_c_1{left: 76px;bottom: -15px;}
    .at_update .level ul li.level_c_2{left: 215px;bottom: -3px;}
    .at_update .level ul li.level_c_3{left: 344px;bottom: 20px;}
    .at_update .level ul li.level_c_4{left: 480px;bottom: 62px;}




    .at_update .level ul li i{display:none;position:absolute;left:13px;bottom:1px;width:22px;height:22px;border-radius:50%;background:#d9e8ec}
    .at_update .level ul li em{position:absolute;left:15px;bottom:3px;width:8px;height:8px;border:5px solid #d9e8ec;background:#fff;border-radius:50%}
    .at_update .level ul li.cur em{border:5px solid #7b9196;}
    .at_update .level ul li.current i{display:block;-webkit-animation:currentLevel 1s linear infinite;animation:currentLevel 1s linear infinite}
    @-webkit-keyframes currentLevel{0%{-webkit-transform:scale(1, 1);opacity:1}100%{-webkit-transform:scale(2, 2);opacity:0}}
    @keyframes currentLevel{0%{transform:scale(1, 1);opacity:1}100%{transform:scale(2, 2);opacity:0}}
</style>


</head>
<body>
<!--header 开始 -->
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

<!-- contents 开始-->
<!-- 会员中心 用户等级 开始 -->
<div id="page_mainer">
    <div class="user_box">
        <div class="user_title">
            <p class="user_t_img">
                <i></i><span>会员中心</span>
            </p>
        </div>
        <div class="user_left">
            <div class="showtime">
                <span>Mercredi , <?php echo ($time); ?></span>
                <p id="week"></p>
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
            </ul>
            <div class="user_exit">
                <a href="<?php echo U('Home/Login/dologin');?>">退出登录</a>
            </div>
        </div>
        <div class="login_right mynews_box order_list">
            <ul class="Member_card_box">
                <li class="Level">
                    <span class="vip_title">您当前的会员等级:</span>
                    <div class="vip_box">
                        <i class="vip1" id='userlevel'><?php echo ($userlevel); ?></i>
                    </div>
                    <font class="red" id="xiaji"></font>
                </li>
                <li>
                    <div class="at_update">
                        <div class="" id="jindu">
                            <ul>
                                <li class="level_1" data-level="1">
                                    <span class="v1">0积分<small></small></span>
                                    <i></i><em></em>
                                </li>
                                <li class="level_c_1" data-level="2">
                                    <span></span>
                                </li>
                                <li class="level_2" data-level="2">
                                    <span class="v2">500积分<small></small></span>
                                    <i></i><em></em>
                                </li>
                                <li class="level_c_2" data-level="2"><span></span>
                                </li>
                                <li class="level_3" data-level="3">
                                    <span class="v3">2000积分<small></small></span>
                                    <i></i><em></em>
                                </li>
                                <li class="level_c_3" data-level="2"><span></span>
                                </li>
                                <li class="level_4" data-level="4">
                                    <span class="v4">5000积分<small></small></span>
                                    <i></i><em></em>
                                </li>
                                <li class="level_c_4" data-level="2"><span></span>
                                </li>
                                <li class="level_5" data-level="5">
                                    <span class="v5">1万积分<small></small></span>
                                    <i></i><em></em>
                                </li>
                            </ul>
                        </div>
                    </div>
                </li>
                <li>
                    <ul class="recommend_flow">
                        <li class="Grey"><i></i><a>纪念日优惠</a><em></em></li>
                        <li class="Grey"><i></i><a>邀请好友获得奖励</a><em></em></li>
                        <li class="Grey flow1"><i></i><a>免费领取会员卡</a><em></em></li>
                        <!--grey是级别不够不能参加的活动-->
                        <li class="Grey flow2">
                          <i></i>
                          <a>参加抢红包活动</a>
                          <em></em>
                        </li>
                        <li class="Grey"><i></i><a>进入贵宾尊享特价区</a><em></em></li>
                        <li class="flow3"><i></i><a class="Gold">尊享永久订购9.8折优惠</a><em></em></li>
                        <li class="flow4"><i></i><a class="Gold">尊享永久订购9.5折优惠</a><em></em></li>
                        <li class="flow5"><i></i><a class="Gold"> 进入蛋糕五折购买区</a><em></em></li>
                    </ul>
                    <div class="recommend_pro_img">
                        <img src="/mcake/Public/Index/images/Activities-n-01.jpg" alt=""/>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- 会员中心 用户等级 结束 -->

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
<!-- 公共javascript文件 -->

<script type="text/javascript" src="/mcake/Public/Index/js/jquery-migrate-1.js"></script>
<script type="text/javascript" src="/mcake/Public/Index/js/ebsig.js"></script>
<script type="text/javascript" src="/mcake/Public/Index/js/share.js"></script>
<script type="text/javascript" src="/mcake/Public/Index/js/showDialog.js"></script>
<script src="/mcake/Public/Index/js/base.js"></script>
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
            $('#xiaji').html('还差 '+(500-<?php echo ($u_score); ?>)+' 积分升级至level 2');
            break;
        case 'lv2':
            $('#userlevel').attr('class','vip2');
            $('#userlevel').html('');
            $('#xiaji').html('还差 '+(2000-<?php echo ($u_score); ?>)+' 积分升级至level 3');
            break;
        case 'lv3':
            $('#userlevel').attr('class','vip3');
            $('#userlevel').html('');
            $('#xiaji').html('还差 '+(5000-<?php echo ($u_score); ?>)+' 积分升级至level 4');
            break;
        case 'lv4':
            $('#userlevel').attr('class','vip4');
            $('#userlevel').html('');
            $('#xiaji').html('还差 '+(10000-<?php echo ($u_score); ?>)+' 积分升级至level 5');
            break;
        case 'lv5':
            $('#userlevel').attr('class','vip5');
            $('#userlevel').html('');
            $('#xiaji').html('尊贵的至尊会员,你的累计积分'+<?php echo ($u_score); ?>+'积分').css('color','orange');
            break;
    }

    var jindu = <?php echo ($u_score); ?>;
    if(jindu >= 10000){
        $('#jindu').attr('class','level Status9');
    }else if(jindu > 5000 && jindu < 10000){
        $('#jindu').attr('class','level Status8');
    }else if(jindu == 5000){
        $('#jindu').attr('class','level Status7');
    }else if(jindu > 2000 && jindu < 5000){
        $('#jindu').attr('class','level Status6');
    }else if(jindu == 2000){
        $('#jindu').attr('class','level Status5');
    }else if(jindu > 500 && jindu < 2000){
        $('#jindu').attr('class','level Status4');
    }else if(jindu == 500){
        $('#jindu').attr('class','level Status3');
    }else if(jindu > 0 && jindu < 500){
        $('#jindu').attr('class','level Status2');
    }else{
        $('#jindu').attr('class','level Status1');
    }

</script>

</body>
</html>
<script>
    var raw = '';
    $(function(){
        $(".Grey").on("click",function(){
            raw="<table width='300' border='0' cellpadding='0' cellspacing='0' >";
            raw=raw+"<tr><td style='text-align:center; padding:20px 0 45px 0;'>即将推出，敬请期待</td></tr>";
            raw=raw+"</table>";
            $.My_red(raw);
        });

        $(".flow3").on("click",function(){
            raw="<table width='350' border='0' cellpadding='0' cellspacing='0' >";
            raw=raw+"<tr><td style='text-align:center; padding:20px 15px 45px 15px;'>V3会员尊享永久订购9.8折优惠<br>(与其他优惠共享，订单提交页立减)</td></tr>";
            raw=raw+"</table>";
            $.My_red(raw);
        });

        $(".flow4").on("click",function(){
            raw="<table width='350' border='0' cellpadding='0' cellspacing='0' >";
            raw=raw+"<tr><td style='text-align:center; padding:20px 15px 45px 15px;'>V4 V5会员尊享永久订购9.5折优惠<br>(与其他优惠共享，订单提交页立减)</td></tr>";
            raw=raw+"</table>";
            $.My_red(raw);
        });

        $(".flow5").on("click",function(){
            raw="<table width='300' border='0' cellpadding='0' cellspacing='0' >";
            raw=raw+"<tr><td style='text-align:center; padding:20px 0 45px 0;'>即将推出，敬请期待</td></tr>";
            raw=raw+"</table>";
            $.My_red(raw);
        });
    });
</script>