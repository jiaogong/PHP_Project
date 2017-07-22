<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

<meta http-equiv="Content-Language" content="zh-CN">
<title>登录 - MCAKE-一直都是巴黎的味道</title>
<meta name="Keywords" content="拿破仑蛋糕,拿破仑蛋糕官网,最好吃的拿破仑蛋糕,Mcake官网">
<meta name="Description" content="MCAKE拿破仑蛋糕，是Mcake经典招牌蛋糕纯正的法国酥皮工艺完美呈现，极尽味觉诱惑，在线便捷预定拿破仑蛋糕，快速的让您感受到拿破仑蛋糕来自巴黎的奇妙美味。">
<meta http-equiv="X-UA-Compatible" content="IE=7">
<meta http-equiv="cache-control" content="max-age=1800">
<link rel="shortcut icon" href="/mcake/Public/Index/images/icons/favicon.ico">
<link rel="stylesheet" type="text/css" href="/mcake/Public/Index/css/comm_header.css">
<link rel="stylesheet" type="text/css" href="/mcake/Public/Index/css/Landing_city.css">

<link rel="stylesheet" type="text/css" href="/mcake/Public/Index/css/ebsig.css">

<script type="text/javascript" src="/mcake/Public/Index/js/jquery.js"></script>

<link href="/mcake/Public/Index/css/login.css" rel="stylesheet" type="text/css">
</head>
<body><iframe style="width: 1px; height: 1px; position: fixed; left: 0px; top: 0px; margin: 0px; padding: 0px; z-index: 2147483647;" src="" scrolling="no" frameborder="0"></iframe>

<!--header 开始 -->

<!--首页客户端地址市区显示供用户选择-->
<div id="cityzhezhao" style="display:none;">
    <div class="tc-con1 tc-con400" id="maximPanel" id="shiqu" >
        <a href="javascript:void(0);" class="close">关闭</a>
        <div class="tc-con12">
            <form action="#" method="POST">
                <ul class="list_c">
                    <li class="Ejectbox_hy">欢迎来到Mcake</li>
                    <li class="Ejectbox_zd">目前，我们提供以下城市的配送服务，请根据您的收货地址选择站点</li>
                    <li>
                        <div class="select_ul_box">
                            <span>你的商品配送至：</span>
                            <div class="select_box_landing chose">
                                <input type="text" value="北京站" readonly="" class="cityres">
                                <ul class="select_ul citya" style="display: none;" id="ul_1">
                                    <li>北京站</li>
                                    <li>上海站</li>
                                    <li>杭州站</li>
                                    <li>苏州站</li>
                                </ul>
                            </div>
                            <div class="clear"></div>
                        </div>
                        <div class="clear"></div>
                    </li>
                    <li class="Ex_btn_box">
                        <input type="button" value="立即体验" class="Experience nowgo" id="buttonYes">
                        <input type="button" value="随便逛逛" class="Experience nowgo" id="buttonNo ">
                    </li>
                </ul>
            </form>
        </div>
        <div class="tc-con13"></div>
    </div>
</div>
<!--市区显示结束-->
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
    <div class="login_box">
        <div class="login_left">
            <span>Veuillez signer</span>
            <p>Inviter des amis<br>peut être mystérieux.</p>
            <font>Vous avez besoin de remplir le numéro de téléphone de votre login</font>


        </div>
        <div class="login_right">
            <form id="login_form" action="<?php echo U('Home/Login/login');?>" method="post" >
                <!--登录开始-->
                <ul>
                    <li>
                        <p class="top_border">
                            <span>用户登录</span>
                        </p>
                    </li>
                    <li>
                    	<input type="hidden" name="path" value="<?php echo ($path); ?>">
                    </li>
                    <li>
                        <input class="input_txt user_icon" placeholder="手机号码" name="phone" type="text">
                        <span class="err" id="loginName_error"></span>
                    </li>
                    <li>
                        <input class="input_txt password_icon" placeholder="请输入密码密码" name="pass" type="password">
                        <span class="err" id="loginPwd_error"></span>
                    </li>
                    <li>
                        <input class="input_txt Mobile_code_icon" style="width:80px;" placeholder="验证码" name="vcode" type="text">&nbsp;
                        <img src="<?php echo U('Home/Public/vcode');?>" name="vcode" >
                        <span class="err" id="loginPwd_error"></span>
                    </li>
                    <li>
                        <input value="登录" class="login_btn right20" name="denglu" type="submit">
                        <a href="<?php echo U('Home/Login/getPwd');?>" class="Grey">忘记密码 ?</a>
                    </li>
                    <li>提示：还不是会员？   <a href="<?php echo U('Home/Login/signin');?>" class="red">立即注册</a></li>
                    <li>
                        <p class="bottom_border">使用合作网站帐号登录</p>
                        <dl>
                            <dd><a href="" class="sina_weibo" onclick="authorize('weibo');"></a></dd>
                            <dd><a href="" class="alipay" onclick="authorize('alipay');"></a></dd>
                        </dl>
                    </li>
                </ul>
                <!--登录 end-->
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
    var R = false;
    var E = false;
    var W = false;
    $('input[name=phone]').blur(function(){
        // alert('hehe');
        var v = $(this).val();
        if(v){
            R = true;
            $(this).next().html('');
        }else{
            R = false;
            $(this).next().html('手机号不能为空').css('color','red');
        }
    })

    $('input[name=pass]').blur(function(){
        var v = $(this).val();
        if(v){
            E = true;
            $(this).next().html('');
        }else{
            E = false;
            $(this).next().html('密码不能为空').css('color','red');
        }
    })

    $('input[name=vcode]').blur(function(){
        var v = $(this).val();
        if(v){
            W = true;
            $(this).parents('li').find('span').html('');
        }else{
            W = false;
            $(this).parents('li').find('span').html('请输入验证码').css('color','red');
        }
    })

    $('img[name=vcode]').click(function(){
        this.src = this.src+'?b';
    })

    $('#login_form').submit(function(){
        // alert('hehe');
        $('input[name=phone]').trigger('blur');
        $('input[name=pass]').trigger('blur');
        $('input[name=vcode]').trigger('blur');
        if(R && E){
            return true;
        }else{
            return false;
        }
    })
</script>
    
</body>
</html>