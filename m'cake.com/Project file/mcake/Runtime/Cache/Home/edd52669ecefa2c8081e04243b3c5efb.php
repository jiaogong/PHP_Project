<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="Content-Language" content="zh-CN" />
<title>订单详情 - MCAKE-一直都是巴黎的味道</title>
<meta name="Keywords" content="Mcake,M'cake,蓝莓轻乳拿破仑,经典香草拿破仑,拿破仑莓恋,拿破仑，胡桃布拉吉，榛果摩卡布拉吉，魅影歌剧院，巧克力格调，天使巧克力，魔鬼巧克力，蒸清抹茶，蔓越莓红丝绒，沙布雷巴菲，巧克力狂想曲，卡法香缇，瑞可塔厚爱，法香奶油可丽，莓果青柠慕斯＂" />
<meta name="Description" content="Mcake把法国传统蛋糕文化带入中国，提供纯正的欧式味觉体验，同时也将欧洲的上好材质、经典工艺以及优雅的文艺气质，融入产品的每一个细节之中，带给客户更多的享受与愉悦。" />
<meta http-equiv="X-UA-Compatible" content="IE=7" />
<meta http-equiv="cache-control" content="max-age=1800" />
<link rel="shortcut icon" href="/Public/Index/images/icons/favicon.ico" >
<link rel="stylesheet" type="text/css" href="/Public/Index/css/comm_header.css" />
<link rel="stylesheet" type="text/css" href="/Public/Index/css/Landing_city.css" />

<link rel="stylesheet" type="text/css" href="/Public/Index/css/ebsig.css" />

<script type="text/javascript" src="/Public/Index/js/jquery.js"></script>
<link href="/Public/Index/css/member.css" rel="stylesheet" type="text/css">
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
                                <img src="/Public/Index/images/logo/logo.png">
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
                <span>Lundi ,<?php echo ($time); ?></span>

                <p id="week">今天是星期一</p>
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

            <div class="order_Remarks_top">
                <span>订单编号 ： <?php echo ($order['oid']); ?></span>
                <span>下单时间 ： <?php echo ($order['addtime']); ?></span>
                <span>发货时间 ： <?php echo ($order['sendtime']); ?></span>
            </div>

            <div class="current_state">
                <ul>
                    <li>当前订单状态：<?php echo ($status[$order['status']]); ?></li>
                    <li>本次订单金额：<?php echo ($order['total']); ?></li>
                    
                    <li>您可以：</li>
                    <li><samp class="Grey">如有疑问可以拨打客服热线：4006678678</samp></li>
                </ul>
            </div>

            <ul class="Dis_list">
                <li><b>配送信息</b></li>
                <li><samp><?php echo ($order['addtime']); ?></samp><span>您的订单已建立</span></li>
                <li><samp><?php echo ($order['sendtime']); ?></samp><span>您的订单已自动取消</span></li>
            </ul>
            <p class="Dis_add">
                联系人:    <?php echo ($order['linkman']); ?>会员<br />
                联系电话： <?php echo ($order['phone']); ?><br />
                收货地址： <?php echo ($order['address']); ?><br />
            </p>
            <ul class="order_th">
                <li class="order_pro"style="width:13%">商品图片</li>
                <li class="order_pro"style="width:18%">商品信息</li>
                <li class="order_Price"style="width:13%">单价（元）</li>
                <li class="order_num"style="width:10%">数量</li>
                <li style="width:25%">生日牌</li>
                <li style="width:21%">金额小计</li>
            </ul>
            <ul class="view_list all_list">
                <!--全部订单-->
                <li class="cur">

                    <ul class="order_td">
                        <!--订单1--> 
                        <?php if(is_array($good)): foreach($good as $key=>$vo): ?><li class="order_view">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td  class="border_right">
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                           
                                            <tr class="border_bottom">
                                                <td width="18%">
                                                    
                                                        <img src="/Uploads/Admin/images/GoodsImg/<?php
 $arr=explode(',',$vo['picname']); echo (substr($vo['addtime'],0,8)."/".$arr[0]);?>" width="114" height="114" alt="Mojito 柠•漾"/>
                                                </td>
                                                <td width="20%"  class="aleft">
                                                    商品: <br /> 
                                                    <?php echo ($gvo['name']); ?> <br />
                                                    描述: <br />
                                                    <?php echo ($vo['descr']); ?> <br />
                                                    <br />
                                                    <?php echo ($vo['weight']); ?>磅<br />

                                                </td>

                <!-- 评论所需变量  开始 -->
                <div class="gid_div" style="display: none;"><?php echo ($vo['goodsid']); ?></div> 
                <!-- 评论所需变量  结束 -->
                                                <td width="16%"><?php echo ($vo['price']); ?></td>
                                                <td width="16%"><?php echo ($vo['num']); ?></td>
                                                <td width="30%"></td>
                                            </tr>
                                            
                                                <td colspan="5" class="aleft">赠品： </td>
                                                <td  style="color:#b0916a;display: block;"><div class="pingjia cur" style="background: #e9e9e9;width: 60px;height:25px;line-height: 25px;cursor: pointer;margin-left: 130px;">评价</div></td>
                                        </table>

                                    </td>
                                    <td width="18%"><?php echo ($vo['price']*$vo['num']); ?><br />(免配送费)</td>
                                </tr>
                            </table>
                        </li><?php endforeach; endif; ?>
                        <!--订单1 end-->
                    </ul>

                    <div class="pay_right">本次订单总金额：<strong> ￥<?php echo ($order['total']); ?></strong></div>

                </li>
            <!--全部订单 end-->
            </ul>
            <ul class="Dis_list">
                <li><b>优惠信息</b></li>
                <li style="font-family: "Microsoft YaHei","微软雅黑","黑体",SimHei;font-size: 12px;color: #c4c4c4;">本次消费未享受优惠</li>
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
                    <img src="/Public/Index/images/2015072811191115080.jpg" alt="" width="100%">
                </a>
            </li>
            <li>
                <a href="" target="_blank">
                    <img src="/Public/Index/images/2015082009154299636.jpg" alt="" width="100%">
                </a>
            </li>
            <li>
                <a href="" target="_blank"><img src="/Public/Index/images/2015070313312260770.jpg" alt="" width="100%">
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
            <img src="/Public/Index/images/icons/wx_icon.png" <="" div="">
            <div class="clear"></div>
        </div>
        <div class="clear"></div>
    </div>
</div>
<!-- footer结束 -->



<!--  评论所需变量  开始-->

<div class="uid_div" style="display: none;"><?php echo $_SESSION['id'];?></div>
<div class="uname_div" style="display: none;"><?php echo substr($_SESSION['usercount'],0,3)."*****".substr($_SESSION['usercount'],-3,11);?>会员</div>

        <!-- 评论遮罩层 开始 -->

        <div class="pinglun_ceng" style="width: 520px;height: 160px;background: rgba(240,240,240,0.9);border:1px solid #ddd;border-radius: 3px;display:none;position: absolute;left:0px;top:0px;box-shadow: 3px 3px 6px 1px rgba(200,200,200,0.3);">
            <div>
            </div>
            <div >
                <ul style="margin-top: 0px;margin-left: 5px;">
                <li style="float: left;">
                    <div class="fabu_but_chakan" style="margin-left: 30px;background: #48d1cc;width: 40px;height: 20px;color:#008080;text-align: center;opacity: 0.6;cursor:pointer;">发布
                    </div>
                </li>
                <li style="float: left;">
                    <div class="chakan_but_chakan" style="margin-left: 10px;background: #48d1cc;width: 40px;height: 20px;color:#008080;text-align: center;opacity: 0.6;cursor:pointer;">查看
                    </div>
                </li>
                <li>
                <div style="margin-left: 497px;opacity: 0.6;">
                    <div class="guanbi_pinglun" style="cursor: pointer;width:25px;height: 25px;">
                        <div style="width:17px;height: 17px;background: #aaa;border-radius: 50%;"><span  style="color:#666;margin-left: 4px;">X</span>
                        </div>
                    </div>
                </div>
                </li>
                </ul>
            </div>
            <div class="fabu_ceng" style="position: relative;top:0px;">
                <textarea style="width:440px;height:90px;background: rgba(180,180,180,0);border:0px solid;font:16px 宋体;color:#555;margin-top: 12px;margin-left: 12px;max-width: 440px;max-height: 90px;resize:none;overflow:hidden;" placeholder="请输入不多于100个字符" class="pinglun_content" ></textarea>

                <button class="fasong_pinglun" style="background: rgb(237,85,101);border:0px solid ;border-radius: 2px;color:#eee;width:50px;height: 30px;">发送
                </button>
            </div>
            <div class="chakan_ceng" style="position: relative;top:0px;display: none;margin-top:0px;">
                <div style="width:440px;height:96px;background: rgba(180,180,180,0);border:0px solid;font:16px 宋体;color:#555;margin-top: 12px;margin-left: 22px;max-width: 440px;max-height: 90px;resize:none;overflow:hidden; " class="pinglun_content_chakan" >
            </div>
        </div>  

        <!-- 评论遮罩层 结束 -->


<!--  评论所需变量  结束-->




<!-- 评论所所需js  开始 -->
<script type="text/javascript">
    //声明公共变量
    var gid=0;
    var uid=0;
    var uname='';
    var content='';
    //点击页面评价,跳出发布评价层
    $('.pingjia').each(function(i){
       $(this).click(function(){
       //获取商品id 
        gid = ($('.gid_div').text())[i];
        //获取用户id
        uid = $('.uid_div').text();
        //获取用户名
        uname=$('.uname_div').text();

        var pinglun = $('.pinglun_ceng').clone(true);
        //评论按钮的位置
        var ping_but_x = $(this).offset().left;
        var ping_but_y = $(this).offset().top;
        //获取滚动条的位置
        var st = $(document).scrollTop();
        //计算评论层的位置
        var pinglun_x = ping_but_x-525;
        var pinglun_y = ping_but_y;
        //设置评论层出现的位置
        $('.pinglun_ceng').css('left',pinglun_x+"px").css('top',pinglun_y+"px").show();
        $('.fabu_ceng').show();
         $('.pinglun_content').val('');

        
        $('.fasong_pinglun').click(function(){
            //判断内容是否有值
            if(content==''){
            //获取输入内容
            content = $('.pinglun_content').val();
            //发送ajax
            $.post("<?php echo U('Home/Discuss/add');?>",{gid:gid,uid:uid,uname:uname,content:content},function(data){
                if(data==1){
                    alert('ok,评论成功!');
                    //初始化内容
                    content='';
                }else{
                    alert('评论失败!');
                }
            });
            }
        $('.pinglun_ceng').hide();
        })
        // alert(ping_but_y-st);

        //获取点击评论按钮的位置
        $('.guanbi_pinglun').click(function(){
            $('.pinglun_ceng').hide();
            //清空查看内容评论
            $('.pinglun_content_chakan').empty();
            })
        })
        



    })

      //当点击顶部"查看"按钮,发布层隐藏
        $('.chakan_but_chakan').click(function(){
            $('.fabu_ceng').hide();
            $('.chakan_ceng').show();
            //发送ajax,读取评论
            $.post("<?php echo U('Home/Discuss/look');?>",{gid:gid,uid:uid,uname:uname},function(data){
                if(data){
                    // alert('ok,评论成功!');
                    var chakan='';
                    $.each(data,function(key,val){
                        chakan = $('<div class="dantiao_pinglun"  style="padding:8px;border:1px dashed #aaa;margin-bottom:3px;"><ul><li style="float:left;height:20px;color:#555;font: 16px 宋体;height:20px;">'+val['content']+'</li><li style="float:left;"><span style="font:10px 宋体;margin-left:50px;opacity:0.8;">'+val['addtime']+'</span><div class="pinglun_id" style="display:none;">'+val['id']+'</div></li><li><div class="shanchu_pinglun" style="width:10px;height:10px;background:#aaa;margin-left:400px;cursor:pointer;opacity:0.6;font:12px 黑体;text-align:center;line-height:10px;color:#ccc;" title="删除评论" onclick=shanchu(this);>X</div></li></ul></div>');
                        $('.pinglun_content_chakan').empty();
                        $('.pinglun_content_chakan').append(chakan); 
                    })
                    //初始化变量
                    return {
                            gid:0,
                            uid:0,
                            uname:'',
                        };
                    
                }else{
                    $('.pinglun_content_chakan').append($('<div style="padding:5px;border:1px dashed #aaa;color:#222;font: 16px 宋体;">暂无评论!</div>'));
                }

            });

            
        })
        //当点击顶部"发布"按钮,查看层隐藏
        $('.fabu_but_chakan').click(function(){
            $('.fabu_ceng').show();
            $('.chakan_ceng').hide();
            //清空查看内容评论
            $('.pinglun_content_chakan').empty();
        })

        //当点击删除评论时,删除事件
      function shanchu(i){

            //获取要删除评论的id
            var plid =  $(i).parents('.dantiao_pinglun').find('.pinglun_id').html();
            //发送ajax
            $.post("<?php echo U('Home/Discuss/delete');?>",{id:plid},function(data){
                if(data){
                    alert('删除成功!');
                    $(i).parents('.dantiao_pinglun').remove();
                }else{
                    alert('删除失败');
                }
            })
        }


</script>


<!-- 评论所所需js  结束 -->

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