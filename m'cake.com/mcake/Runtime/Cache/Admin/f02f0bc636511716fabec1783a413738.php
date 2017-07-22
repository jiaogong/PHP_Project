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
                
                
<div class="page-title">
    <div class="title_left">
        <h3>商品修改</h3>
    </div>
</div>
<div class="x_panel">
    <div class="x_title">
        <h2>修改商品信息 <small></small></h2>
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
	    <form action="<?php echo U(updata);?>" class="form-horizontal form-label-left" data-parsley-validate="" id="demo-form2" name="goods_insert" novalidate="" method="post">
	    <input type="hidden" name="id" value="<?php echo ($goodsFind["id"]); ?>" >
				
	        <div class="form-group">
	            <label for="first-name" class="control-label col-md-3 col-sm-3 col-xs-12">蛋糕名称(英文)
	            </label>
	            <div class="col-md-6 col-sm-6 col-xs-12">
	                <input type="text" class="form-control col-md-7 col-xs-12" required="required" id="first-name" name="en_gname" data-parsley-id="4702" value="<?php echo ($goodsFind["en_gname"]); ?>">
	            </div>
	        </div>
	        <div class="form-group">
	            <label for="first-name" class="control-label col-md-3 col-sm-3 col-xs-12">蛋糕名称(中文)
	            </label>
	            <div class="col-md-6 col-sm-6 col-xs-12">
	                <input type="text" class="form-control col-md-7 col-xs-12" required="required" id="first-name" name="cn_gname" data-parsley-id="4702" value="<?php echo ($goodsFind["cn_gname"]); ?>">
	            </div>
	        </div>
	        <div class="form-group">
	            <label for="first-name" class="control-label col-md-3 col-sm-3 col-xs-12">类别
	            </label>
	            <div class="col-md-6 col-sm-6 col-xs-12">
		            <select name="type" style="font-size: 16px;" class="form-control col-md-7 col-xs-12" required="required" id="first-name" data-parsley-id="4702">	
		            	<option <?php if(($goodsFind["type"]) == "拿破仑"): ?>selected<?php endif; ?> >拿破仑</option>	
		            	<option <?php if(($goodsFind["type"]) == "鲜奶"): ?>selected<?php endif; ?> >鲜奶</option>	
		            	<option <?php if(($goodsFind["type"]) == "慕斯"): ?>selected<?php endif; ?> >慕斯</option>	
		            	<option <?php if(($goodsFind["type"]) == "芝士"): ?>selected<?php endif; ?> >芝士</option>	
		            	<option <?php if(($goodsFind["type"]) == "巧克力"): ?>selected<?php endif; ?> >巧克力</option>	
		            	<option <?php if(($goodsFind["type"]) == "咖啡"): ?>selected<?php endif; ?> >咖啡</option>	
		            	<option <?php if(($goodsFind["type"]) == "坚果"): ?>selected<?php endif; ?> >坚果</option>	
		            	<option <?php if(($goodsFind["type"]) == "水果"): ?>selected<?php endif; ?> >水果</option>
		            </select>
	            </div>
	        </div>
	         <div class="form-group">
	            <label for="first-name" class="control-label col-md-3 col-sm-3 col-xs-12">状态
	            </label>
	            <div class="col-md-6 col-sm-6 col-xs-12">
		            <select name="status" style="font-size: 16px;" class="form-control col-md-7 col-xs-12" required="required" id="first-name" data-parsley-id="4702">
		            	<option value="0" <?php if(($goodsFind["status"]) == "1"): ?>selected<?php endif; ?> >无</option>
		            	<option value="1" <?php if(($goodsFind["status"]) == "1"): ?>selected<?php endif; ?> >新品</option>	
		            	<option value="2" <?php if(($goodsFind["status"]) == "2"): ?>selected<?php endif; ?> >人气</option>	
		            	<option value="3" <?php if(($goodsFind["status"]) == "3"): ?>selected<?php endif; ?> >金牌</option>	
		            	<option value="4" <?php if(($goodsFind["status"]) == "4"): ?>selected<?php endif; ?> >售馨</option>
		            </select>
	            </div>
	        </div>

	        <div class="form-group">
	            <label for="first-name" class="control-label col-md-3 col-sm-3 col-xs-12">单价
	            </label>
	            <div class="col-md-6 col-sm-6 col-xs-12">
	                <input type="text" name="price" class="form-control col-md-7 col-xs-12" required="required" id="first-name" data-parsley-id="4702" value="<?php echo ($goodsFind["price"]); ?>">
	            </div>
	        </div>
	        <div class="form-group">
	            <label for="first-name" class="control-label col-md-3 col-sm-3 col-xs-12">图片
	            </label>
	            <div class="col-md-6 col-sm-6 col-xs-12">
	            	<div ><img style="border:1px solid #ccc;border-radius:4px;padding:5px;background: white;opacity:0.9;" src="/mcake/Uploads/Admin/images/GoodsImg/<?php
 $arr=explode(',',$goodsFind['picname']); $arr[0]; echo (substr($goodsFind['addtime'],0,8)."/"."s_".$arr[0]);?>" ></img><img  class="qingchu_but" title="删除" alt="删除" style="width:25px;opacity: 0.9;position:relative;left:-30px;top:37px;cursor:pointer;" src="/mcake/Public/Admin/images/icons/trash.png"/>
	            	<img  style="border:1px solid #ccc;border-radius:4px;padding:5px;background: white;opacity:0.9;" src="/mcake/Uploads/Admin/images/GoodsImg/<?php
 $arr=explode(',',$goodsFind['picname']); $arr[0]; echo (substr($goodsFind['addtime'],0,8)."/"."s_".$arr[0]);?>" ></img><img class="qingchu_but"  title="删除" alt="删除" style="width:25px;opacity: 0.9;position:relative;left:-30px;top:37px;cursor:pointer;" src="/mcake/Public/Admin/images/icons/trash.png"/>
	            	<img  style="border:1px solid #ccc;border-radius:4px;padding:5px;background: white;opacity:0.9;" src="/mcake/Uploads/Admin/images/GoodsImg/<?php
 $arr=explode(',',$goodsFind['picname']); $arr[0]; echo (substr($goodsFind['addtime'],0,8)."/"."s_".$arr[0]);?>" ></img>
	            	<img class="qingchu_but" title="删除" alt="删除" style="width:25px;opacity: 0.9;position:relative;left:-33px;top:37px;cursor:pointer;" src="/mcake/Public/Admin/images/icons/trash.png"/>
	            	</div>
	            	<div class="picnames" style="margin-top: 10px;">
		           </div>
	            </div>
	        </div>
	        
	        
	         <div class="form-group">
	            <label for="first-name" class="control-label col-md-3 col-sm-3 col-xs-12">可选尺寸
	            </label>
	            <div class="col-md-6 col-sm-6 col-xs-12">
	                <input type="text" name="size" class="form-control col-md-7 col-xs-12" required="required" id="first-name" data-parsley-id="4702" value="<?php echo ($goodsFind["size"]); ?>">
	            </div>
	        </div>
	        <div class="form-group">
	            <label for="first-name" class="control-label col-md-3 col-sm-3 col-xs-12">原材料
	            </label>
	            <div class="col-md-6 col-sm-6 col-xs-12">
	                <input type="text" style="border: 1px solid #dde2e8;box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset;font-size: 14px;height: 56px;width: 365px;line-height:14px;" value="<?php echo ($goodsFind["material_name"]); ?>">
	            </div>
	        </div>
	        <div class="form-group">
	            <label for="first-name" class="control-label col-md-3 col-sm-3 col-xs-12">口感
	            </label>
	            <div class="col-md-6 col-sm-6 col-xs-12">
	                <input type="text" name="taste" class="form-control col-md-7 col-xs-12" required="required" id="first-name" data-parsley-id="4702" value="<?php echo ($goodsFind["taste"]); ?>">
	            </div>
	        </div>
			<div class="form-group">
	            <label for="first-name" class="control-label col-md-3 col-sm-3 col-xs-12">口味
	            </label>
	            <div class="col-md-6 col-sm-6 col-xs-12">
	                <input type="text" name="feeling" class="form-control col-md-7 col-xs-12" required="required" id="first-name" data-parsley-id="4702" value="<?php echo ($goodsFind["feeling"]); ?>">
	            </div>
	        </div>
	        <div class="form-group">
	            <label for="first-name" class="control-label col-md-3 col-sm-3 col-xs-12">味基底
	            </label>
	            <div class="col-md-6 col-sm-6 col-xs-12">
	                <input type="text" name="basefeel" class="form-control col-md-7 col-xs-12" required="required" id="first-name" data-parsley-id="4702" value="<?php echo ($goodsFind["basefeel"]); ?>">
	            </div>
	        </div>
	        <div class="form-group">
	            <label for="first-name" class="control-label col-md-3 col-sm-3 col-xs-12">甜味度
	            </label>
	            <div class="col-md-6 col-sm-6 col-xs-12">
	                <input type="number" name="sweet" value="1" class="form-control col-md-7 col-xs-12" required="required" id="first-name" data-parsley-id="4702" value="<?php echo ($goodsFind["sweet"]); ?>">
	            </div>
	        </div>
	        <div class="form-group">
	            <label for="first-name" class="control-label col-md-3 col-sm-3 col-xs-12">酸味度
	            </label>
	            <div class="col-md-6 col-sm-6 col-xs-12">
	                <input type="number" name="sour" value="0" class="form-control col-md-7 col-xs-12" required="required" id="first-name" data-parsley-id="4702" value="<?php echo ($goodsFind["sour"]); ?>">
	            </div>
	        </div>
	        <div class="form-group">
                <label for="first-name" class="control-label col-md-3 col-sm-3 col-xs-12">累计限购量
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="number" name="stocks" value="<?php echo ($goodsFind["stocks"]); ?>" class="form-control col-md-7 col-xs-12" required="required" id="first-name" data-parsley-id="4702">
                </div>
            </div>
	        <div class="form-group">
	            <label for="first-name" class="control-label col-md-3 col-sm-3 col-xs-12">特别说明
	            </label>
	            <div class="col-md-6 col-sm-6 col-xs-12">
	                <textarea name="state" style="height:50px" class="form-control col-md-7 col-xs-12" requitebiered="required" id="first-name" data-parsley-id="4702"><?php echo ($goodsFind["state"]); ?></textarea><!-- <input type="text"> -->
	            </div>
	        </div>
	        <div class="form-group">
	            <label for="first-name" class="control-label col-md-3 col-sm-3 col-xs-12">简介(英文)
	            </label>
	            <div class="col-md-6 col-sm-6 col-xs-12">
	                <textarea name="descr"  class="form-control col-md-7 col-xs-12" required="required" id="first-name" data-parsley-id="4702" ><?php echo ($goodsFind["descr_en"]); ?></textarea><!-- <input type="text"> -->
	            </div>
	        </div>
	        <div class="form-group">
	            <label for="first-name" class="control-label col-md-3 col-sm-3 col-xs-12">简介(中文)
	            </label>
	            <div class="col-md-6 col-sm-6 col-xs-12">
	                <textarea name="descr"  class="form-control col-md-7 col-xs-12" required="required" id="first-name" data-parsley-id="4702" ><?php echo ($goodsFind["descr_cn"]); ?></textarea><!-- <input type="text"> -->
	            </div>
	        </div>

	        <div class="ln_solid"></div>
	        <div class="form-group">
	            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
	                <button class="btn btn-success" type="submit">更新</button>
	                <button class="btn btn-primary" type="reset">重置</button>
	            </div>
	        </div>

	    </form>
	</div>
</div>

<script type="text/javascript" src="/mcake/Public/Admin/production/js/parsley/parsley.min.js"></script>
<script type="text/javascript">
	
	$('.qingchu_but').each(function(){
		$(this).click(function(){

			$(this).prev().remove();
			$upimg = $('<input type="file" name="picname[]">');
			$('.picnames').append($upimg);
			if(!$('.form-horizontal').attr('enctype')){
				$('.form-horizontal').attr('enctype','multipart/form-data');
			}
			$(this).remove();
			

		})
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