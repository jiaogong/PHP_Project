<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>网站后台管理</title>
     <link rel='icon' href='/mcake/Public/Index/images/favicon.png' type='image/x-ico'/>
    <!-- Bootstrap core CSS -->
    <link href="/mcake/Public/Admin/production/css/bootstrap.min.css" rel="stylesheet">
    <link href="/mcake/Public/Admin/production/fonts/css/font-awesome.min.css" rel="stylesheet">
    <link href="/mcake/Public/Admin/production/css/animate.min.css" rel="stylesheet">
    <!-- Custom styling plus plugins -->
    <link href="/mcake/Public/Admin/production/css/custom.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/mcake/Public/Admin/production/css/maps/jquery-jvectormap-2.0.1.css" />
    <link href="/mcake/Public/Admin/production/css/icheck/flat/green.css" rel="stylesheet" />
    <link href="/mcake/Public/Admin/production/css/floatexamples.css" rel="stylesheet" type="text/css" />

    <script src="/mcake/Public/Admin/production/js/jquery.min.js"></script>    
</head>

<body class="nav-md">

    <div class="container body">


        <div class="main_container">

            <div class="col-md-3 left_col">
                <div class="left_col scroll-view">

                   <div class="navbar nav_title" style="border: 0;">
                        <a href="index.html" class="site_title" style="height:100px;"><div class="profile_pic" >
                            <img class="img-circle profile_img" alt="..." src="/mcake/Public/Admin/production/images/0.jpg">
                        </div></i> <span style="color:#b0916a;font-size:35px;display:block;">M.cake</span></a>
                                               
                    </div>
                    <div class="clearfix" style="font-size:16px;float:right;margin-right:10px;">上海麦心有限公司</div>
                    <div class="clearfix" style="clear:both;"></div>

                    <!-- menu prile quick info -->
                  <!--  <div class="profile">
                        <div class="profile_pic">
                            <img src="/mcake/Public/Admin/production/images/0.jpg" alt="..." class="img-circle profile_img">
                        </div>
                        <div class="profile_info">
                            <span>欢迎您:</span>
                            <h2>Admin管理员</h2>
                        </div>
                    </div>
                    <!-- /menu prile quick info -->

                    <br />

                    <!-- sidebar menu -->
                    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">

                        <div class="menu_section">
                           
                            <ul class="nav side-menu"> 
                                <?php  $AUTH = new \Think\Auth(); if($AUTH->check("user", session('admin_id'))){ ?>
                                <li><a><i class="fa fa-group (alias)"></i> 用户管理 <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu" style="display: none">
                                        <li><a href="<?php echo U('Admin/auser/index');?>">用户列表</a>
                                        </li>
                                        <li><a href="<?php echo U('Admin/auser/add');?>">用户添加</a>
                                        </li>
                                    </ul>
                                </li>
                                <?php } ?>
                                <?php  $AUTH = new \Think\Auth(); if($AUTH->check("user", session('admin_id'))){ ?>
                                 <li><a><i class="fa fa-group (alias)"></i> 会员管理 <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu" style="display: none">
                                        <li><a href="<?php echo U('Admin/User/index');?>">会员列表</a>
                                        </li>
                                        <li><a href="<?php echo U('Admin/User/add');?>">会员添加</a>
                                        </li>
                                    </ul>
                                </li>                                
                                <?php } ?>
                                <?php  $AUTH = new \Think\Auth(); if($AUTH->check("goods", session('admin_id'))){ ?>
                                <li><a><i class="fa fa-codepen"></i> 商品管理 <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu" style="display: none">
                                        <li><a href="<?php echo U('Admin/Goods/index');?>">商品列表</a>
                                        </li>
                                        <li><a href="<?php echo U('Admin/Goods/add');?>">添加商品</a>
                                        </li>
                                    </ul>
                                </li>
                                <?php } ?>
                                <?php  $AUTH = new \Think\Auth(); if($AUTH->check("type", session('admin_id'))){ ?>
                                <li><a><i class="fa fa-delicious"></i> 类别管理 <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu" style="display: none">
                                        <li><a href="<?php echo U('Admin/Type/index');?>">类别列表</a>
                                        </li>
                                        <li><a href="<?php echo U('Admin/Type/add');?>">类别添加</a>
                                        </li>
                                    </ul>
                                </li>
                                <?php } ?>
                                <?php  $AUTH = new \Think\Auth(); if($AUTH->check("material", session('admin_id'))){ ?>
                                <li><a><i class="fa fa-th-large"></i> 原料管理 <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu" style="display: none">
                                        <li><a href="<?php echo U('Admin/Material/index');?>">原料列表</a>
                                        </li>
                                        <li><a href="<?php echo U('Admin/Material/add');?>">原料添加</a>
                                        </li>
                                    </ul>
                                </li>
                                <?php } ?>
                                <?php  $AUTH = new \Think\Auth(); if($AUTH->check("orders", session('admin_id'))){ ?>
                                <li><a><i class="fa fa-joomla"></i> 订单相关<span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu" style="display: none">
                                        <li><a href="<?php echo U('Admin/Orders/Orders');?>">订单管理</a>
                                        </li>
                                        <li><a href="<?php echo U('Admin/Orders/fahuodan');?>">发货单管理</a>
                                        </li>
                                        <li><a href="<?php echo U('Admin/Orders/fapiao');?>">发票管理</a>
                                        </li>
                                    </ul>
                                </li>
                                <?php } ?>
                                <?php  $AUTH = new \Think\Auth(); if($AUTH->check("banner", session('admin_id'))){ ?>
                                <li><a><i class="fa fa-area-chart"></i> 轮播管理 <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu" style="display: none">
                                        <li><a href="<?php echo U('Admin/Banner/index');?>">BANNER管理</a>
                                        </li>
                                    </ul>
                                </li>
                                <?php } ?>
                                <?php  $AUTH = new \Think\Auth(); if($AUTH->check("help", session('admin_id'))){ ?>
                                 <li><a><i class="fa fa-magic"></i> 帮助管理<span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu" style="display: none">
                                        <li><a href="<?php echo U('Admin/Article/index');?>">文章分类管理
                                        ·发现
                                        ·关于我们·帮助中心</a>
                                        </li>
                                        <li><a href="<?php echo U('Admin/Article/add');?>">添加分类文章</a>
                                        </li>
                                    </ul>
                                </li>
                                <?php } ?>
                                <li><a><i class="fa fa-magic"></i>友情链接<span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu" style="display: none">
                                        <li><a href="<?php echo U('Admin/Flink/index');?>">友链详情</a>
                                        </li>
                                        <li><a href="<?php echo U('Admin/Flink/add');?>">友链添加</a>
                                        </li>
                                    </ul>
                                </li>
                                <li><a><i class="fa fa-magic"></i>广告管理<span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu" style="display: none">
                                        <li><a href="<?php echo U('Admin/Ad/index');?>">广告浏览</a>
                                        </li>
                                        <li><a href="<?php echo U('Admin/Ad/add');?>">广告添加</a>
                                        </li>
                                    </ul>
                                </li>
                                <?php  $AUTH = new \Think\Auth(); if($AUTH->check("rules", session('admin_id'))){ ?>
                                <li><a><i class="fa fa-th-large"></i> 权限管理 <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu" style="display: none">
                                        <li><a href="<?php echo U('Admin/Group/index');?>">管理组列表</a>
                                        </li>
                                        <li><a href="<?php echo U('Admin/Rule/index');?>">权限列表</a>
                                        </li>
                                    </ul>
                                </li>
                                <?php } ?>
                                <?php  $AUTH = new \Think\Auth(); if($AUTH->check("webconfig", session('admin_id'))){ ?>
                                 <li><a><i class="fa fa-cogs"></i> 网站设置<span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu" style="display: none">
                                        <li><a href="<?php echo U('Admin/Webconfig/detail');?>">系统信息详情</a>
                                        </li>
                                        <li><a href="<?php echo U('Admin/Webconfig/index');?>">数据库及网站开关配置</a>
                                        </li>
                                        <li><a href="<?php echo U('Admin/Webconfig/smail');?>">邮件设置</a>
                                        </li>
                                        <li><a href="<?php echo U('Admin/Webconfig/mesg');?>">短信设置</a>
                                        </li>
                                    </ul>
                                </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                    <!-- /sidebar menu -->

                    <!-- /menu footer buttons -->
                    <div class="sidebar-footer hidden-small">
                        <a data-toggle="tooltip" data-placement="top" title="Settings">
                            <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                        </a>
                        <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                            <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
                        </a>
                        <a data-toggle="tooltip" data-placement="top" title="Lock">
                            <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
                        </a>
                        <a data-toggle="tooltip" data-placement="top" title="Logout">
                            <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
                        </a>
                    </div>
                    <!-- /menu footer buttons -->
                </div>
            </div>

            <!-- top navigation -->
            <div class="top_nav">

                <div class="nav_menu">
                    <nav class="" role="navigation">
                        <div class="nav toggle">
                            <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                        </div>
                        <ul class="nav navbar-nav navbar-right">
                            <li class="">
                                <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                    <img src="/mcake/Public/Admin/production/images/0.jpg" alt=""><?php echo (session('admin_ausername')); ?>
                                    <span class=" fa fa-angle-down"></span>
                                </a>
                                <ul class="dropdown-menu dropdown-usermenu animated fadeInDown pull-right">
                                    
                                    <li>
                                        <a href="javascript:;">帮助</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo U('Admin/Login/logout');?>"><i class="fa fa-sign-out pull-right"></i>退出</a>
                                    </li>
                                </ul>
                            </li>
                            <li role="presentation" class="dropdown">
                                <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
                                    <i class="fa fa-envelope-o"></i>
                                    <span class="badge bg-green">1</span>
                                </a>
                                <ul id="menu1" class="dropdown-menu list-unstyled msg_list animated fadeInDown" role="menu">
                                    <li>
                                        <a>
                                            <span class="image">
                                                <img src="/mcake/Public/Admin/production/images/img.jpg" alt="Profile Image" />
                                            </span>
                                            <span>
                                                <span>Admin</span>
                                                <span class="time">3 mins ago</span>
                                            </span>
                                            <span class="message">
                                                Film festivals used to be do-or-die moments for movie makers. They were where... 
                                            </span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </nav>
                </div>

            </div>
            <!-- /top navigation -->


            <!-- page content -->
            <div class="right_col" role="main">
                
                
*****************************************************************************************************
<div class="order_main">
<div class="pack_title">生成发货单：</div>
<form action="/mcake/index.php/Admin/Orders/goodsinvoice" method="post">
    <table class="delivery_table">
        <tbody>
        <tr>
            <th>用户名</th>
            <td><input type="text" value="<?php echo ($username); ?>" name="username"></td>
            <th>订单编号</th>
            <td id="delivery_ordersn" colspan="2"><input type="text" value="<?php echo ($ordersList['oid']); ?>" name="oid"></td>
            <th>付款方式</th>
            <td><input type="text" value="<?php echo ($payway['payway']); ?>" name="payway"></td>
        </tr>
        <tr>
            <th>收货人</th><td><input type="text" value="<?php echo ($ordersList['linkman']); ?>" name="linkman"></td><th>发票</th><td colspan="2"><input type="text" value=""placeholder="请输入发票流水单号" name="invoice_number"></td><th>发票内容</th><td><input type="text" value=""placeholder="请输入发票内容" name="content"></td>
        </tr>
        <tr>
            <th>包装名</th><td><input type="text" value="<?php echo ($packList['name']); ?>" name="packname"></td><th>包装费</th><td colspan="2"><input type="text" value="<?php echo ($packList['pay']); ?>" name="packpay"></td><th>免费额</th><td><input type="text" value="<?php echo ($packList['free']); ?>" name="packfree"></td>
        </tr>
        <tr>
            <th>收货地址</th><td colspan="4"><input type="text" value="<?php echo ($ordersList['address']); ?>" name="address"></td><th>收货时间</th><td><input type="text" value="<?php echo ($ordersList['sendtime']); ?>" name="sendtime"></td>
        </tr>
        <tr>
            <th>商品名</th><th class="g_com">数量</th><th class="g_com">品味</th><th class="g_com">感觉</th><th class="g_com">甜度</th><th class="g_com">商品价</th><th class="g_com">小计</th>
        </tr>

        <!-- 一个订单中每件商品遍历的开始 -->
        <tr>
            <td><input type="text" value="<?php echo ($goodsorder['name']); ?>" name="goodsname"></td>
            <td><input type="text" value="<?php echo ($goodsorder['num']); ?>" name="goodsnum"></td>
            <td><input type="text" value="<?php echo ($goodsList['taste']); ?>" name="taste"></td>
            <td><input type="text" value="<?php echo ($goodsList['feeling']); ?>" name="feeling"></td>
            <td><input type="text" value="<?php echo ($goodsList['sweet']); ?>" name="sweet"></td>
            <td><input type="text" value="<?php echo ($goodsorder['price']); ?>" name="goodsprice"></td>
            <td><input type="text" value="<?php echo ($goodsprice); ?>" name="goodstotalprice"></td>
                    </tr>
        <!-- 一个订单中每件商品遍历的结束 -->
        <tr>
            <th>包装描述</th><td colspan="6"><input type="text" value="<?php echo ($packList['describe']); ?>" name="describe"></td>
        </tr>
        <tr>
            <th>发货描述</th>
            <td colspan="6">
                <textarea name="order_desc" class="delivery_order_desc" rows="5" cols="100"></textarea>
            </td>
        </tr>
        <tr>
            <th>订单备注</th><td colspan="6"><input type="text" value="<?php echo ($ordersList['beizhu']); ?>" name="beizhu"></td>
        </tr>
        <tr>
            <th>总计</th><td colspan="10">商品总价￥<input type="text" value="<?php echo ($goodsprice); ?>" size="4">.00元 + 包装费￥<input type="text" value="<?php echo ($packList['pay']); ?>" name="packpay" size="4">元 - 免费额度￥<input type="text" value="<?php echo ($packList['free']); ?>" name="packfree" size="4">元 = 发货单总价￥<input type="text" value="<?php echo ($total); ?>" name="total" size="4">.00元</td>
        </tr>
        <tr>
            <td colspan="7"><input type="submit" value="确定生成"><span>*将生成与订单对应的发货单号并存入数据库中，同时将录入的发票唯一编号及订单号写入发票单中</span></td>
        </tr>
        </form>
    </tbody></table>
</div>
**********************
               <!--打印-->
            <script language="javascript">
function printsetup(){
// 打印页面设置
web.execwb(8,1);
}
function printpreview(){
// 打印页面预览
        
web.execwb(7,1);      
}
function printit()
{
if (confirm('确定打印吗？')) {
web.execwb(6,6)
}
}
</script>
</head>
<body>
<OBJECT classid="CLSID:8856F961-340A-11D0-A96B-00C04FD705A2"
height=0 id=web name=web width=0>
</OBJECT>
<input type="button" name=button_print value="打印" onclick="javascript:printit()">
<input type="button" name="button_setup" value="打印页面设置"
onclick="javascript:printsetup();"> 
<input type="button" name="button_show" value="打印预览"
onclick="javascript:printpreview();"> 
<input type="button" name="button_fh" value="关闭"
onclick="javascript:window.close();">
                <!--打印结束-->

**********************
                
                <!-- footer content -->
                <footer>
                    <div class="">
                        <p class="pull-right">上海麦心食品有限公司&nbsp;&nbsp;&nbsp;<a>沪ICP备12022075号</a>. |
                            <span class="lead"> <i class="fa fa-birthday-cake" style="margin-left:5px;margin-right:10px;"></i>M.cake</span>
                        </p>
                    </div>
                    <div class="clearfix"></div>
                </footer>
                <!-- /footer content -->
            </div>
            <!-- /page content -->

        </div>
    </div>

    <div id="custom_notifications" class="custom-notifications dsp_none">
        <ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">

        </ul>
        <div class="clearfix"></div>
        <div id="notif-group" class="tabbed_notifications"></div>
    </div>

    <script src="/mcake/Public/Admin/production/js/bootstrap.min.js"></script>
   <!-- chart js -->
    <script src="/mcake/Public/Admin/production/js/chartjs/chart.min.js"></script>
    <!-- bootstrap progress js -->
    <script src="/mcake/Public/Admin/production/js/progressbar/bootstrap-progressbar.min.js"></script>
    <script src="/mcake/Public/Admin/production/js/nicescroll/jquery.nicescroll.min.js"></script>
    <!-- icheck -->
    <script src="/mcake/Public/Admin/production/js/icheck/icheck.min.js"></script>
    <!-- daterangepicker -->
    <script type="text/javascript" src="/mcake/Public/Admin/production/js/moment.min.js"></script>
    
    <script src="/mcake/Public/Admin/production/js/custom.js"></script>

    <!-- worldmap -->
    <script type="text/javascript" src="/mcake/Public/Admin/production/js/maps/jquery-jvectormap-2.0.1.min.js"></script>
    
    <!-- /footer content -->
</body>

</html>