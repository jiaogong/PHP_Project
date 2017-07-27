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
                
                
<div class="/mcake/Public/Admin/production/col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <h2>管理组列表</h2>
            <ul class="nav navbar-right panel_toolbox">
                <li>
                	<a href="#"><i class="fa fa-chevron-up"></i></a>
                </li>
                <li class="dropdown">
                    <a aria-expanded="false" role="button" data-toggle="dropdown" class="dropdown-toggle" href="#"><i class="fa fa-wrench"></i></a>
                    <ul role="menu" class="dropdown-menu">
                        <li>
                        	<a href="#">Settings 1</a>
                        </li>
                        <li>
                        	<a href="#">Settings 2</a>
                        </li>
                    </ul>
                </li>
                <li>
                	<a href="#"><i class="fa fa-close"></i></a>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div role="grid" class="dataTables_wrapper" id="example_wrapper">

	        	<div class="clear"></div>
	        	<form action="<?php echo U('Admin/Group/index');?>" method="get">
	        	<div id="example_length" class="dataTables_length">
	        		<label>显示 
	        		<select name="n" style="width: 100px;padding: 6px;" size="1" aria-controls="example">
		        		<option value="5" <?php if(($n) == "5"): ?>selected="selected"<?php endif; ?>>5</option>
		        		<option value="20" <?php if(($n) == "20"): ?>selected="selected"<?php endif; ?>>20</option>
		        		<option value="50" <?php if(($n) == "50"): ?>selected="selected"<?php endif; ?>>50</option>
	        		</select>
	        		 条</label>
	        	</div>
			        <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search" style="width:460px">
                    	<a href="<?php echo U('Admin/Group/add');?>" class="btn btn-success" style="display:block;float:right">添加管理组</a>
			            <div class="input-group" style="width:350px">
			                <input type="text" name="k" value="<?php echo ($k); ?>" placeholder="Search for..." class="form-control">
			                <span class="input-group-btn">
			        			<button class="btn btn-default">搜索!</button>
			    			</span>
			            </div>

			        </div>
			    </form>

	<table id="example" class="table table-striped responsive-utilities jambo_table dataTable" aria-describedby="example_info">
		<thead>
		    <tr role="row" class="headings">
		        <th aria-label="Invoice : activate to sort column ascending" style="width: 50px;" colspan="1" rowspan="1" aria-controls="example" tabindex="0" role="columnheader" class="sorting">ID </th>
		        <th aria-label="Invoice Date : activate to sort column ascending" style="width: 100px;" colspan="1" rowspan="1" aria-controls="example" tabindex="0" role="columnheader" class="sorting">组名称 </th>
		        <th aria-label="Order : activate to sort column ascending" style="width: 520px;" colspan="1" rowspan="1" aria-controls="example" tabindex="0" role="columnheader" class="sorting">组权限 </th>
		        <th aria-label="Order : activate to sort column ascending" style="width: 100px;" colspan="1" rowspan="1" aria-controls="example" tabindex="0" role="columnheader" class="sorting">组状态 </th>
		        <th aria-label="Bill to Name : activate to sort column ascending" style="width: 114px;" colspan="1" rowspan="1" aria-controls="example" tabindex="0" role="columnheader" class="sorting"> 操作 </th>
		    </tr>
		</thead>
		<table>
			<div class="x_content">
		    <!-- start project list -->
		        <table class="table table-striped projects">
		            <tbody>
		            <?php if(is_array($groups)): foreach($groups as $key=>$vo): ?><tr class="pointer even">
	                        <td style="width:20px"><?php echo ($vo['id']); ?></td>
	                        <td style="width:90px"><?php echo ($vo['title']); ?></td>
	                        <td style="width:540px;"><div style="width:540px;overflow:hidden"><?php echo ($vo['rules']); ?></div></td>
	                        <td style="width:100px"><?php echo (getrulestatus($vo['status'])); ?></td>
	                        <td id="del">
		                        <a class="btn btn-info btn-xs" href="<?php echo U('Admin/Group/edit',array('id'=>$vo['id']));?>"><i class="fa fa-pencil"></i> 修改 </a>
		                        <a class="btn btn-danger btn-xs" href="<?php echo U('Admin/Group/delete',array('id'=>$vo['id']));?>"><i class="fa fa-trash-o"></i> 删除 </a>
	                        </td>
	                    </tr><?php endforeach; endif; ?>
		            </tbody>
		        </table>
		    <!-- end project list -->
		    </div>
	    </table>
	    <div style="float:left">
		    <select class="form-control" name="pid" style="width:400px;">
	            <option value="0">权限对照表：下拉查看</option>
	            <?php if(is_array($res)): foreach($res as $key=>$vo): ?><option value="<?php echo ($vo['id']); ?>"><?php echo ($vo['id']); ?> => <?php echo ($vo['title']); ?></option><?php endforeach; endif; ?>
	        </select>
        </div>
	    <!--页码链接样式-->
	    <style type="text/css">	
			#example_paginate .num {
			    box-sizing: border-box;
			    background-color: #ddd;
			    border: 1px solid #aaa;
			    cursor: pointer;
			    margin: 0 3px;
			    padding: 2px 5px;
			    background-color: #ddd;
			    background: none repeat scroll 0 0 #ddd !important;
			    border-color: #ddd !important;
			    padding: 6px 9px !important;
			    text-decoration: none;
			    outline: 0 none;
			}

			#example_paginate .current {
			    box-sizing: border-box;
			    border: 1px solid #aaa;
			    cursor: pointer;
			    margin: 0 3px;
			    padding: 2px 5px;
			    background: none repeat scroll 0 0 #99b3ff !important;
			    background-color: rgba(38, 185, 154, 0.59) !important;
			    border-color: rgba(38, 185, 154, 0.59) !important;
			    padding: 6px 9px !important;
			    text-decoration: none;
			    outline: 0 none;
			}
	    </style>
	    <!--页码链接-->
    	<div id="example_paginate" class="dataTables_paginate paging_full_numbers" style="float:right">	
            <?php echo ($pages); ?>
        </div>
        <br><br><br>
	</table>
	<script type="text/javascript">
    //删除确认提示
    $('#del a:last-child').click(function(){
        var res=confirm('是否删除当前管理组？');
        if(res){
            return true;
        }else{
            return false;
        }
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