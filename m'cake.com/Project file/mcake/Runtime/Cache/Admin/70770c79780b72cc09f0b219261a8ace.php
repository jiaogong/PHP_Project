<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>网站后台管理</title>
     <link rel='icon' href='/Public/Index/images/favicon.png' type='image/x-ico'/>
    <!-- Bootstrap core CSS -->
    <link href="/Public/Admin/production/css/bootstrap.min.css" rel="stylesheet">
    <link href="/Public/Admin/production/fonts/css/font-awesome.min.css" rel="stylesheet">
    <link href="/Public/Admin/production/css/animate.min.css" rel="stylesheet">
    <!-- Custom styling plus plugins -->
    <link href="/Public/Admin/production/css/custom.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/Public/Admin/production/css/maps/jquery-jvectormap-2.0.1.css" />
    <link href="/Public/Admin/production/css/icheck/flat/green.css" rel="stylesheet" />
    <link href="/Public/Admin/production/css/floatexamples.css" rel="stylesheet" type="text/css" />

    <script src="/Public/Admin/production/js/jquery.min.js"></script>    
</head>

<body class="nav-md">

    <div class="container body">


        <div class="main_container">

            <div class="col-md-3 left_col">
                <div class="left_col scroll-view">

                   <div class="navbar nav_title" style="border: 0;">
                        <a href="index.html" class="site_title" style="height:100px;"><div class="profile_pic" >
                            <img class="img-circle profile_img" alt="..." src="/Public/Admin/production/images/0.jpg">
                        </div></i> <span style="color:#b0916a;font-size:35px;display:block;">M.cake</span></a>
                                               
                    </div>
                    <div class="clearfix" style="font-size:16px;float:right;margin-right:10px;">上海麦心有限公司</div>
                    <div class="clearfix" style="clear:both;"></div>

                    <!-- menu prile quick info -->
                  <!--  <div class="profile">
                        <div class="profile_pic">
                            <img src="/Public/Admin/production/images/0.jpg" alt="..." class="img-circle profile_img">
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
                                    <img src="/Public/Admin/production/images/0.jpg" alt=""><?php echo (session('admin_ausername')); ?>
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
                                                <img src="/Public/Admin/production/images/img.jpg" alt="Profile Image" />
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
                
                

    
<div class="page-title">
    <div class="title_left">
        <h3>商品添加</h3>
    </div>
</div>
<div class="x_panel">
    <div class="x_title">
        <h2>新产品上架信息 <small>填写</small></h2>
        <ul class="nav navbar-right panel_toolbox">
           
            <li class="dropdown">
                <a aria-expanded="false" role="button" data-toggle="dropdown" class="dropdown-toggle" href="#"> 
                </a>
            </li>
                
            
        </ul>
        <div class="clearfix"></div>
    </div>
	<div class="x_content">
	    <br>
	    <form action="<?php echo U('insert');?>" class="form-horizontal form-label-left" data-parsley-validate="" id="demo-form2" name="goods_insert" novalidate="" enctype="multipart/form-data" method="post">

	        <div class="form-group">
	            <label for="first-name" class="control-label col-md-3 col-sm-3 col-xs-12">蛋糕名称(英文)
	            </label>
	            <div class="col-md-6 col-sm-6 col-xs-12">
	                <input type="text" class="form-control col-md-7 col-xs-12" required="required" id="first-name" name="en_gname" data-parsley-id="4702">
	            </div>
	        </div>
	        <div class="form-group">
	            <label for="first-name" class="control-label col-md-3 col-sm-3 col-xs-12">蛋糕名称(中文)
	            </label>
	            <div class="col-md-6 col-sm-6 col-xs-12">
	                <input type="text" class="form-control col-md-7 col-xs-12" required="required" id="first-name" name="cn_gname" data-parsley-id="4702">
	            </div>
	        </div>
	        <div class="form-group">
	            <label for="first-name" class="control-label col-md-3 col-sm-3 col-xs-12">类别
	            </label>
	            <div class="col-md-6 col-sm-6 col-xs-12">
		            <select name="type" style="font-size: 16px;" class="form-control col-md-7 col-xs-12" required="required" id="first-name" data-parsley-id="4702">
		            	<option>选择蛋糕类别</option>	
		            	<option>拿破仑</option>	
		            	<option>鲜奶</option>	
		            	<option>慕斯</option>	
		            	<option>芝士</option>	
		            	<option>巧克力</option>	
		            	<option>咖啡</option>	
		            	<option>坚果</option>	
		            	<option>水果</option>
		            </select>
	            </div>
	        </div>

	        <!-- <div class="form-group">
	            <label for="first-name" class="control-label col-md-3 col-sm-3 col-xs-12">单价
	            </label>
	            <div class="col-md-6 col-sm-6 col-xs-12">
	                <input type="text" name="price" class="form-control col-md-7 col-xs-12" required="required" id="first-name" data-parsley-id="4702">
	            </div>
	        </div> -->
	        <div class="form-group">
	            <label for="first-name" class="control-label col-md-3 col-sm-3 col-xs-12">图片
	            </label>
	            <div class="col-md-6 col-sm-6 col-xs-12">
		           <input type="file" name="picname[]">
		           <input type="file" name="picname[]">
		           <input type="file" name="picname[]">
	            </div>
	        </div>
	        
	        <div class="form-group">
	            <label for="first-name" class="control-label col-md-3 col-sm-3 col-xs-12">可选重量
	            </label>
	            <div class="col-md-6 col-sm-6 col-xs-12">
	                <div class="checkbox" style="width: 400px;">
                       <label class="">
                       <div class="icheckbox_flat-green checked" style="position: relative;"><input name="weights []" value="1" type="checkbox" checked="checked" class="flat" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255) none repeat scroll 0% 0%; border: 0px none; opacity: 0;"></ins></div> 1磅
                    </label>
                    <label class="">
                       <div class="icheckbox_flat-green checked" style="position: relative;"><input name="weights []" value="2" type="checkbox" checked="checked" class="flat" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255) none repeat scroll 0% 0%; border: 0px none; opacity: 0;"></ins></div> 2磅
                    </label>
                    <label class="">
                       <div class="icheckbox_flat-green checked" style="position: relative;"><input name="weights []" value="3" type="checkbox" checked="checked" class="flat" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255) none repeat scroll 0% 0%; border: 0px none; opacity: 0;"></ins></div> 3磅
                             </label>
                     <label class="">
                       <div class="icheckbox_flat-green checked" style="position: relative;"><input name="weights []" value="5" type="checkbox" checked="checked" class="flat" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255) none repeat scroll 0% 0%; border: 0px none; opacity: 0;"></ins></div> 5磅
                       </label>
                     </div>
	            </div>
	        </div>
	         <div class="form-group">
	            <label for="first-name" class="control-label col-md-3 col-sm-3 col-xs-12">可选尺寸
	            </label>
	            <div style="width:450px;height: 110px;margin-top: 8px;" class="col-md-6 col-sm-6 col-xs-12">
	            	<div class="pound_text" style="float: left;margin-right: 12px;">1磅: <input placeholder="格式例如:适合2-3人食用+SIZE:16cm*10cm*5.5cm+需提前5小时预定" style="width:350px;box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset;background-color: #fff;background-image: none;border: 1px solid #dde2e8;height: 28px;transition: border-color 0.15s ease-in-out 0s, box-shadow 0.15s ease-in-out 0s;" type="text" name="sizes[]"/></div> 
	             	<div class="pound_text" style="float: left;">2磅: <input style="width:350px;box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset;background-color: #fff;background-image: none;border: 1px solid #dde2e8;height: 28px;transition: border-color 0.15s ease-in-out 0s, box-shadow 0.15s ease-in-out 0s;" type="text" name="sizes[]"/></div>
	             	<div class="pound_text" style="float: left;margin-right: 12px;">3磅: <input style="width:350px;box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset;background-color: #fff;background-image: none;border: 1px solid #dde2e8;height: 28px;transition: border-color 0.15s ease-in-out 0s, box-shadow 0.15s ease-in-out 0s;" type="text" name="sizes[]"/></div>
	             	<div class="pound_text" style="float: left;">5磅: <input style="width:350px;box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset;background-color: #fff;background-image: none;border: 1px solid #dde2e8;height: 28px;transition: border-color 0.15s ease-in-out 0s, box-shadow 0.15s ease-in-out 0s;" type="text" name="sizes[]"/>
	            </div>
	                <!-- <input type="text" name="size" class="form-control col-md-7 col-xs-12" required="required" id="first-name" data-parsley-id="4702"> -->
	            </div>
	        </div>
            <div class="form-group">
                <label for="first-name" class="control-label col-md-3 col-sm-3 col-xs-12">单价
                </label>
                <div style="width:450px;height: 70px;margin-top: 8px;" class="col-md-6 col-sm-6 col-xs-12">
                    <div class="pound_price" style="float: left;margin-right: 12px;">1磅: <input placeholder="格式例如:300" style="width:130px;box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset;background-color: #fff;background-image: none;border: 1px solid #dde2e8;height: 28px;transition: border-color 0.15s ease-in-out 0s, box-shadow 0.15s ease-in-out 0s;" type="text" name="prices[]"/></div> 
                    <div class="pound_price" style="float: left;">2磅: <input style="width:130px;box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset;background-color: #fff;background-image: none;border: 1px solid #dde2e8;height: 28px;transition: border-color 0.15s ease-in-out 0s, box-shadow 0.15s ease-in-out 0s;" type="text" name="prices[]"/></div>
                    <div class="pound_price" style="float: left;margin-right: 12px;">3磅: <input style="width:130px;box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset;background-color: #fff;background-image: none;border: 1px solid #dde2e8;height: 28px;transition: border-color 0.15s ease-in-out 0s, box-shadow 0.15s ease-in-out 0s;" type="text" name="prices[]"/></div>
                    <div class="pound_price" style="float: left;">5磅: <input style="width:130px;box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset;background-color: #fff;background-image: none;border: 1px solid #dde2e8;height: 28px;transition: border-color 0.15s ease-in-out 0s, box-shadow 0.15s ease-in-out 0s;" type="text" name="prices[]"/>
                </div>
                    <!-- <input type="text" name="size" class="form-control col-md-7 col-xs-12" required="required" id="first-name" data-parsley-id="4702"> -->
                </div>
            </div>
			<div class="form-group">
            <label for="first-name" class="control-label col-md-3 col-sm-3 col-xs-12">原料名称 <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" readonly="true" placeholder="请先到国家中选择" name="material_name" class="form-control input_text2 col-md-7 col-xs-12" required="required" value="" id="first-name" data-parsley-id="4702">
               <!--  <input type="hidden" class="mid" name="material_id" value=""/> -->
            </div>
        	</div>

            <div class="form-group">
                <label for="first-name" class="control-label col-md-3 col-sm-3 col-xs-12">来自国家 <span class="required">*</span><div style=""></div>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12" style="width:550px;">
                	<!-- 点击出现国家层按钮  开始-->
                    <div class="show_guojia" style="width:10px;height:10px;cursor:pointer;margin-left: -2px;margin-top: 8px;"><img class="show_guojia_but" width="22" style="opacity: 0.7;" src="/Public/Admin/images/icons/icon_04.png" ss="/Public/Admin/images/icons/icon_05.png"></div>
                    <!-- 点击出现国家层按钮  结束-->

                <!-- 点击出现国家层  默认隐藏  开始-->
                 <div class="guojia_ceng" style="display:none;width:560px;height:440px;padding:40px;border:1px solid #ededed;">

                <!-- 遍历各个国家 及其图标 开始 -->
                <?php if(is_array($cou)): foreach($cou as $key=>$cou): ?><div style="float:left;height: 55px;">
                    <label class="guojia_list_but" guoid="<?php echo ($cou["id"]); ?>" style="margin-right:15px;width: 140px;margin-bottom: 40px;cursor:pointer;">
                        <img src="<?php echo ($cou["flag_pic"]); ?>">&nbsp;&nbsp;&nbsp;<?php echo ($cou["cname"]); ?>
                    </label>
                    </div><?php endforeach; endif; ?>
                    <!-- 遍历各个国家 及其图标 结束 -->

                </div>
                <!-- 点击出现国家层  默认隐藏  结束-->
	</div>
</div>
<!-- 产地原材料 遮罩层 开始 -->
<div class="zzz" style="display: none;position:absolute;left:180px;top:120px;z-index:10;">
	<div class="zz" style="background-color: rgba(30,30,30,0.2);border-radius: 7px;width: 600px;height: 400px;box-shadow: 3px 3px 6px 1px #999;" >
		<div style="opacity:none;color:#999;font-size: 20px;position: absolute;margin-left:10px;margin-top: 10px;width: 580px;height: 380px;background: #fff;border-radius: 5px;">
			<div style="margin-top: 40px;margin-left: 30px;width: 550px;height:380px;">
			<div class="close_x1" title="关闭" style="position:absolute;top: -12px;left: 550px;cursor:pointer;"> <img width="40" src="/Public/Admin/images/icons/icon_03.png"></div>
				<ul class="each_lists_chandi" style="list-style: none; height: 235px;"></ul>
				<div class="queren_but" style="margin-left: 180px;"><button type="button" style="width: 90px;" class="btn btn-danger">确 定</button></div>
			</div>	
		</div>
	</div>
</div>
<!-- 产地原材料 遮罩层 结束 -->
	        <div class="form-group">
	            <label for="first-name" class="control-label col-md-3 col-sm-3 col-xs-12">口感
	            </label>
	            <div class="col-md-6 col-sm-6 col-xs-12">
	                <input type="text" name="taste" class="form-control col-md-7 col-xs-12" required="required" id="first-name" data-parsley-id="4702">
	            </div>
	        </div>
			<div class="form-group">
	            <label for="first-name" class="control-label col-md-3 col-sm-3 col-xs-12">口味
	            </label>
	            <div class="col-md-6 col-sm-6 col-xs-12">
	                <input type="text" name="feeling" class="form-control col-md-7 col-xs-12" required="required" id="first-name" data-parsley-id="4702">
	            </div>
	        </div>
	        <div class="form-group">
	            <label for="first-name" class="control-label col-md-3 col-sm-3 col-xs-12">味基底
	            </label>
	            <div class="col-md-6 col-sm-6 col-xs-12">
	                <input type="text" name="basefeel" class="form-control col-md-7 col-xs-12" required="required" id="first-name" data-parsley-id="4702">
	            </div>
	        </div>
	         <div class="form-group">
                <label for="first-name" class="control-label col-md-3 col-sm-3 col-xs-12">甜味度
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12 tian" style="width:220px;">
                 <div style="width:320px;height: 12px;"><img style="opacity: 0.8;" src="/Public/Admin/images/icons/size.png" /></div>
                <div style="width:300px;height: 30px;"><div style="width:185px;height: 12px;background: #ddd;margin-top:10px;" ><div class="tianwei_dian" style="width:12px;height: 12px; border-radius:50%;background: #d2691e;cursor:pointer;margin-left: 100px;"></div></div></div>
                    
                </div><input style="width:30px;height: 30px;margin-top: 8px;opacity: 0.8;" type="text" name="sweet" value="1" class="form-control col-md-7 col-xs-12 tianwei_num" required="required" id="first-name" data-parsley-id="4702">
            </div>
            <div class="form-group">
                <label for="first-name" class="control-label col-md-3 col-sm-3 col-xs-12">酸味度
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12 suan" style="width:220px;">
                <div style="width:320px;height: 12px;"><img style="opacity: 0.8;" src="/Public/Admin/images/icons/size.png" /></div>
                <div style="width:300px;height: 30px;"><div style="width:185px;height: 12px;background: #ddd;margin-top:10px;" ><div class="suanwei_dian" style="width:12px;height: 12px; border-radius:50%;background: #d2691e;cursor:pointer;margin-left: 100px;"></div></div></div></div>
                <div>
                    <input type="text" style="width:30px;height: 30px;margin-top: 8px;opacity: 0.8;" name="sour" value="0" class="form-control col-md-7 col-xs-12 suanwei_num" required="required" id="first-name" data-parsley-id="4702">
                </div>
            </div>
            <div class="form-group">
                <label for="first-name" class="control-label col-md-3 col-sm-3 col-xs-12">累计限购量
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="number" name="stocks" value="20" class="form-control col-md-7 col-xs-12" required="required" id="first-name" data-parsley-id="4702">
                </div>
            </div>

	        <div class="form-group">
	            <label for="first-name" class="control-label col-md-3 col-sm-3 col-xs-12">特别说明
	            </label>
	            <div class="col-md-6 col-sm-6 col-xs-12">
	                <textarea name="state" style="height:50px" class="form-control col-md-7 col-xs-12" requitebiered="required" id="first-name" data-parsley-id="4702"></textarea><!-- <input type="text"> -->
	            </div>
	        </div>
	        <div class="form-group">
	            <label for="first-name" class="control-label col-md-3 col-sm-3 col-xs-12">简介(英文)
	            </label>
	            <div class="col-md-6 col-sm-6 col-xs-12">
	                <textarea name="descr_en"  class="form-control col-md-7 col-xs-12" required="required" id="first-name" data-parsley-id="4702"></textarea><!-- <input type="text"> -->
	            </div>
	        </div>
            <div class="form-group">
                <label for="first-name" class="control-label col-md-3 col-sm-3 col-xs-12">简介(中文)
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <textarea name="descr_cn"  class="form-control col-md-7 col-xs-12" required="required" id="first-name" data-parsley-id="4702"></textarea><!-- <input type="text"> -->
                </div>
            </div>

	        <div class="ln_solid"></div>
	        <div class="form-group">
	            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
	                <button class="btn btn-success" type="submit">添加</button>
	                <button class="btn btn-primary" type="reset">重置</button>
	            </div>
	        </div>

	    </form>
	</div>
</div>

<script type="text/javascript" src="/Public/Admin/production/js/parsley/parsley.min.js"></script>
	<script type="text/javascript">

		$('.icheckbox_flat-green').each(function(i){
			$(this).click(function(){
				if($(this).children('div').hasClass('checked')){
					$(this).children('div').children('input').val(' ');
					$('.pound_text').eq(i).fadeOut(500);
                    $('.pound_price').eq(i).fadeOut(500);
				}else{
					$('.pound_text').eq(i).fadeIn(500);
                    $('.pound_price').eq(i).fadeIn(500);
					if(i==3){
						$(this).children('div').children('input').val(i+2);
					}else{
						$(this).children('div').children('input').val(i+1);
					}
				}

			})
		})

	</script>

	<!-- 产地原材料 遮罩层 结束 -->
<script type="text/javascript">

	//声明一个收集原材料的变量
	var mc = '';
	//声明一个收集原产地材料字符串长度的变量
	var mcl = 0;

	//声明一个收集原材料id变量
	var mc_id='';
	//声明一个收集原产地材料id字符串长度的变量
	var mcl_id = 0;

	//点击遮罩层产地原材料绑定样式lists_chandi

function lists(i){
 
        var mnvalue =$(i).children('li').children('.lists_chandi_dange').children('.mn').text();
        var sear= new RegExp(mnvalue);
        //如果有被选过的原材料值,
        if(!sear.test(mc) || mc==''){
            $(i).children('li').children('.lists_chandi_dange').css('border','').css('background','');
        }else{
            $(i).children('li').children('.lists_chandi_dange').css('border','1.5px dashed #ddd').css('background','url(/Public/Admin/images/icons/icon_02.png) no-repeat');
            $(i).attr('d','d');
        }

        //如果原材料的值没有被选过
        if(!$(i).attr('d')){
            $(i).children('li').children('.lists_chandi_dange').css('border','1.5px dashed #ddd').css('background','url(/Public/Admin/images/icons/icon_02.png) no-repeat');
            $(i).attr('d','d');
            mc_one =$(i).children('li').children('.lists_chandi_dange').children('.mn').html()+",";
            mc_id_one =$(i).children('li').children('.lists_chandi_dange').children('.chandi_id').html()+"-";
            //单个原材料的字串长度
            mcla = ($(i).children('li').children('.lists_chandi_dange').children('.mn').html()+",").length;
            mcla_id = ($(i).children('li').children('.lists_chandi_dange').children('.chandi_id').html()+"-").length;
            //计算多个原材料的长度相加
            mc += mc_id_one+mc_one;
            //计算多个原材样的长度
            mcl = mc.length;
            
        }else{
            //反选
            $(i).children('li').children('.lists_chandi_dange').css('border','').css('background','');
            $(i).removeAttr('d');
            mc_one =$(i).children('li').children('.lists_chandi_dange').children('.mn').html()+",";
            mc_id_one =$(i).children('li').children('.lists_chandi_dange').children('.chandi_id').html()+"-";
            //单个原材料的字串长度
            mcla = ($(i).children('li').children('.lists_chandi_dange').children('.mn').html()+",").length;
            mcla_id = ($(i).children('li').children('.lists_chandi_dange').children('.chandi_id').html()+"-").length;
            //计算多个原材料的长度相加
            mc_on = mc_id_one+mc_one;
            //计算多个原材样的长度
            mcl_on = mc_on.length;

            //获取反选字符串在所有已选字符串的下标位置
            mc_on_index = mc.indexOf(mc_on);
            //截取字符串
            mc = mc.replace(mc_on,'');
        }
}

	//点击遮罩层点击关闭按钮
	$('.close_x1').click(function(){
		$(this).parents('.zzz').fadeOut("slow");
		$('.input_text2').val(mc);
		$('.mid').val(mc_id);

	})
	//点击遮罩层确定事件
	$('.queren_but').click(function(){
		$(this).parents('.zzz').fadeOut("slow");
		$('.input_text2').val(mc);
		$('.mid').val(mc_id);
	})

	//点击显示国家
	var src = $('.show_guojia_but').attr('src');
	var ss = $('.show_guojia_but').attr('ss');
	$('.show_guojia').click(function(){
		if(!$(this).attr('d')){
			$('.guojia_ceng').slideDown("slow");
			$(this).attr('d','d');
			//修改点击小图标的样式
			$('.show_guojia_but').attr('src',ss);
			$('.show_guojia_but').attr('width',22);
		}else{
			$('.guojia_ceng').slideUp("slow");
			$(this).removeAttr('d');
			//还原点击小图标的样式
			$('.show_guojia_but').attr('src',src);
			$('.show_guojia_but').attr('width',22);
		}
		//移除"法国"前多余的ul
		$('.parsley-errors-list').remove();
	})
	var strs=""
	//点击国家列表中的一个显示遮罩层 显示所属国家的原材料
	$('.guojia_list_but').each(function(){
		$(this).click(function(){
			
			//获取国家相对应的id
			var country = $(this).attr('guoid');
			// console.log(country);
			//发送ajax
			$.ajax({
				//请求的脚本
				url:'<?php echo U("Admin/Goods/show");?>',
				type:'get',//类型
				dataType:'json',//这里对服务器返回的数据进行默认操作
				async:true,// true异步  false同步
				data:{ca:country},
				success:function(data){
					if(data){
						
						$('.each_lists_chandi').empty();
						$.each(data,function(key,value){
						var strsb = $('<label class="lists_chandi" style="cursor:pointer;" onclick="lists(this)"><li  style="width:170px;height:50px;float: left;margin-right: 80px;font-weight: normal;font-size:17px;"><div class="lists_chandi_dange" style="width:160px;height:50px;text-align: center;line-height: 50px;"><img style="margin-right:10px;margin-top:-5px;opacity: 0.6;" src="/Public/Admin/images/icons/icon_01.png"/><span class="mn">'+value['name']+'</span><span class="chandi_id" style="display: none">'+value['country']+'</span></div></li></label>');

                        $('.lists_chandi').each(function(i){
                            var mnvalue =$(this).children('li').children('.lists_chandi_dange').children('.mn').text();
                            var sear= new RegExp(mnvalue);

                            //如果有被选过的原材料值,
                            if(!sear.test(mc) || mc==''){
                                $(this).children('li').children('.lists_chandi_dange').css('border','').css('background','');
                            }else{
                                $(this).children('li').children('.lists_chandi_dange').css('border','1.5px dashed #ddd').css('background','url(/Public/Admin/images/icons/icon_02.png) no-repeat');
                                $(this).attr('d','d');
                            }

                        })

						$('.each_lists_chandi').append(strsb);

						})

					}	
			
				},
			});
			// $.post('<?php echo U("Admin/Material/go");?>',{c:country});

			//获取可视区域的宽高
			var wY = $(window).height();
			var wX = $(window).width();
			//获取滚动条的top距离
			var sY = $(window).scrollTop();
			//计算新的遮罩层的位置
			var wYnew = (wY/2+sY)-400;
			var wXnew = (wX/2)-500;
			// alert(wYnew);
			//修改遮罩层的位置
			$('.zzz').css('left',wXnew+"px");
			$('.zzz').css('top',wYnew+"px");
			//显示所属国家的原材料
			$('.zzz').css('display','block');

		})
	})

	//判断原材料是否有值,如果有可以修改
	$('.input_text2').mouseover(function(){
		if($(this).val()!=''){
			$(this).removeAttr('readonly');
		}
	})

//甜味度设置 

    var sx=0;
    var xa=0;
    $(document).ready(function(){
        $('.tianwei_dian').css('margin-left',86+"px");
    })
    $('.tian').click(function(ent){

            //兼容IE和火狐浏览器兼容
            var event=ent || window.event;
            //获取事件坐标位置
            x=event.clientX;
            //92 180
            //计算圆点的位置
            sx = x-520;
            //设置边界
            if(sx<=0){
                sx=0;
            }
            if(sx>=175){
                sx=175;
            }
            //设置甜度值的位置
            if(sx<10){
                xa=0;
            }
              if(sx>=10){
                xa=1;
              }
              if(sx>=92){
                xa=2;
              } 
          $('.tianwei_dian').css('margin-left',sx+"px");
        $('.tianwei_num').val(xa);
 

})

        $('.tianwei_num').blur(function(){
            $(this).val(xa);
        })

//酸味度设置 

    var sx=0;
    var xa=0;
    $(document).ready(function(){
        $('.suanwei_dian').css('margin-left',0+"px");
    })
    $('.suan').click(function(ent){

            //兼容IE和火狐浏览器兼容
            var event=ent || window.event;
            //获取事件坐标位置
            x=event.clientX;
            //92 180
            //计算圆点的位置
            sx = x-520;
            //设置边界
            if(sx<=0){
                sx=0;
            }
            if(sx>=175){
                sx=175;
            }
            //设置甜度值的位置
            if(sx<10){
                xa=0;
            }
              if(sx>=10){
                xa=1;
              }
              if(sx>=92){
                xa=2;
              } 
          $('.suanwei_dian').css('margin-left',sx+"px");
        $('.suanwei_num').val(xa);
 

})


</script>
        
       

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

    <script src="/Public/Admin/production/js/bootstrap.min.js"></script>
   <!-- chart js -->
    <script src="/Public/Admin/production/js/chartjs/chart.min.js"></script>
    <!-- bootstrap progress js -->
    <script src="/Public/Admin/production/js/progressbar/bootstrap-progressbar.min.js"></script>
    <script src="/Public/Admin/production/js/nicescroll/jquery.nicescroll.min.js"></script>
    <!-- icheck -->
    <script src="/Public/Admin/production/js/icheck/icheck.min.js"></script>
    <!-- daterangepicker -->
    <script type="text/javascript" src="/Public/Admin/production/js/moment.min.js"></script>
    
    <script src="/Public/Admin/production/js/custom.js"></script>

    <!-- worldmap -->
    <script type="text/javascript" src="/Public/Admin/production/js/maps/jquery-jvectormap-2.0.1.min.js"></script>
    
    <!-- /footer content -->
</body>

</html>