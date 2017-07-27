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
                
                
<!-- 文章浏览内容 开始 -->
<div class="/mcake/Public/Admin/production/col-md-12 col-sm-12 col-xs-12">

    <div class="x_panel">
        <div class="x_title">
            <h2>友情链接浏览列表</h2>
            <ul class="nav navbar-right panel_toolbox">
            <li><a href="#"><i style="font-size: 25px;" class="fa fa-close"></i></a></li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <form action="<?php echo U(Admin/Flink/index);?>" method="get">
        <div class="x_content">
            <div role="grid" class="dataTables_wrapper" id="example_wrapper">
	            
	        	<div class="clear"></div>
	        	<div id="example_length" class="dataTables_length">
           <label>显示 <select name="n" style="width: 56px;padding: 6px;border:1px solid #ddd;border-radius:3px;height:30px;opacity:0.8;" size="1" aria-controls="example">
           <option <?php if(($n) == "6"): ?>selected="selected"<?php endif; ?> value="6">6</option>
           <option <?php if(($n) == "12"): ?>selected="selected"<?php endif; ?> value="12">12</option>
           <option <?php if(($n) == "20"): ?>selected="selected"<?php endif; ?> value="18">18</option>
           <option <?php if(($n) == "30"): ?>selected="selected"<?php endif; ?> value="24">24</option>
           <option <?php if(($n) == "100"): ?>selected="selected"<?php endif; ?> value="100">100</option>
           </select> 条</label>
	        	</div>
		<div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
		<div class="input-group">
			 <input value="<?php echo ($k); ?>" name="k" type="text" placeholder="搜索: 输入网站名称关键字..." class="form-control">
			 <span class="input-group-btn">
				<button type="submit" class="btn btn-default">点击!</button>
			</span>
		</div>
	</div>
</form>
	        	<table class="table table-striped responsive-utilities jambo_table dataTable"  id="example" aria-describedby="example_info">
	                <thead>
	                    <tr class="headings" role="row">
	                    	<th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1" style="width: 35px;" aria-label=" ">
	                            <div class="icheckbox_flat-green" style="position: relative;">
		                            <input type="checkbox" class="tableflat" style="position: absolute; opacity: 0;">
		                            <ins class="iCheck-total" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255) none repeat scroll 0% 0%; border: 0px none; opacity: 0;">	
		                            </ins>
	                            </div>
	                        </th>
	                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="example" rowspan="1" colspan="1" style="width: 65px;text-align: left;" aria-label="Invoice : activate to sort column ascending">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ID </th>
	                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="example" rowspan="1" colspan="1" style="width: 147px;" aria-label="Invoice Date : activate to sort column ascending">&nbsp;&nbsp;网站名称 </th>
	                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="example" rowspan="1" colspan="1" style="width: 187px;" aria-label="Order : activate to sort column ascending">&nbsp;网站地址 </th>
	                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="example" rowspan="1" colspan="1" style="width: 245px;" aria-label="Bill to Name : activate to sort column ascending">网站logo </th>
	                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="example" rowspan="1" colspan="1" style="width: 100px;" aria-label="Status : activate to sort column ascending">添加时间 </th>
	                         <th class="no-link last sorting" role="columnheader" tabindex="0" aria-controls="example" rowspan="1" colspan="1" style="width: 63px;text-align: center;" aria-label="Action: activate to sort column ascending"><span class="nobr"></span></th>
	                        <th class="no-link last sorting" role="columnheader" tabindex="0" aria-controls="example" rowspan="1" colspan="1" style="width: 163px;text-align: center;" aria-label="Action: activate to sort column ascending"><span class="nobr">操作</span></th>
	                    </tr>
	                </thead>
	                
	                <tbody role="alert" aria-live="polite" aria-relevant="all">

	              <!-- 遍历数据库数据 -->
	          <?php if(is_array($ResArt)): foreach($ResArt as $key=>$Art): ?><tr class="pointer" style="border-top: 1px solid #ddd;padding: 6px;height:60px;background-color: #f9f9f9;">
		<td class="a-center">
			<div class="icheckbox_flat-green" style="position: relative;"><input type="checkbox" class="tableflat" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255) none repeat scroll 0% 0%; border: 0px none; opacity: 0;"></ins></div>
             </td>
             
             <td class="gid" ><?php echo ($Art["fid"]); ?></td>
             <td class="gname" style="text-overflow:ellipsis;height: 60px;"><div style="height: 55px;overflow: hidden;"><?php echo ($Art["fname"]); ?></div><br/>
             </td>
             <td class="  "><div style="height: 55px;overflow: hidden;"><?php echo ($Art["furl"]); ?></div></td>
             <td class="  "><img src="/mcake/Uploads/Admin/images/<?php echo ($Art["fimage_c"]); ?>" style="width:120px;"></td>
             <td class="  " style="text-overflow:ellipsis;height: 60px;"><div style="height: 55px;overflow: hidden;"><?php echo ($Art["addtime"]); ?></div></td>
             <td class="a-right a-right  " style="text-align: center;" ></td>
             <td class=" last "><ul class="nav navbar-right panel_toolbox">
                
                <li class="dropdown">
                    <a href="<?php echo U('Admin/Flink/edit',array('fid'=>$Art['fid']));?>">
                    <!-- 修改图标按钮 -->
                    <i class="fa fa-wrench"></i>
                    </a>
                  
                </li>
                <li style="cursor:pointer;">
                <!-- 删除图标按钮 -->
                	<a class="delete_but" ahref="<?php echo U('Admin/Flink/delete',array('fid'=>$Art['fid']));?>">
                	<i class="fa fa-close"></i>
                	</a>
                </li>
            </ul>
             </td>
        </tr><?php endforeach; endif; ?>
	      </tbody> 
    </table>
 
			
         <div class="dataTables_info" id="example_info">共计<?php echo ($count); ?>页</div>
       	<br>
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
    	<div id="example_paginate" class="dataTables_paginate paging_full_numbers">
            <?php echo ($page); ?>
        </div>
        <br><br><br>
                
        </div>
        </div>
    </div>
    
</div>
<!-- 删除遮罩层 开始 -->
<div tabindex="-1" role="dialog" aria-labelledby="avatar-modal-label" aria-hidden="false" id="avatar-modal" class="modal fade in" style="display: none/*block*/;"><div class="modal-backdrop fade in" id="heimu" style="height: 650px;"></div>
   <div class="modal-dialog modal-lg" id="qrc" style="width: 400px;height: 200px;opacity:1;">
       <div class="modal-content">
           <div class="modal-header">
           <input type="hidden" name="id" value="" />
           <button id="close_but" type="button" data-dismiss="modal" class="close">×</button>
           <h4 id="avatar-modal-label" class="modal-title">删除确认</h4>
           </div>
           <div class="modal-body">
           <div class="avatar-body" style="height: 200px;">

               <!-- Upload image and data -->
               <label for="avatarInput" style="width:500px;font-size:20px;color:#999;text-align: center;line-height: 40px;margin-top: 20px;font-weight:normal;">你确定要删除这条数据吗?</label>
               <!-- 删除确认按钮 -->
               <div style="margin-left: 60px;margin-top: 30px">
	               <div style="width: 100px;float:left;margin-right: 30px;">
					<a href="" class="del_buta btn btn-primary btn-block avatar-save"  type="button">确认删除</a>
					</div>
					<div style="width: 100px;">
					<button class="btn btn-primary btn-block avatar-save" id="cancel_but" type="button">取消</button>
					</div>
               </div>
               </div>
           </div>
           </div>
           <!-- <div class="modal-footer">
     <button class="btn btn-default" data-dismiss="modal" type="button">Close</button>
   </div> -->
       </div>
   </div>

   </div>
  
   <!-- 删除遮罩层 结束 -->
<script type="text/javascript">
	
	//设置全选\反选选择按钮事件
	$('ins.iCheck-total').click(function(){
		var divt = $(this).parent('div');
		var trt = $(this).parents('tr');
		if(divt.attr('class')=='icheckbox_flat-green'){
			divt.attr('class','icheckbox_flat-green checked');
			trt.attr('class','pointer even selected');
			$('ins.iCheck-helper').each(function(){
				var div = $('ins.iCheck-helper').parent('div')
				var tr = $('ins.iCheck-helper').parents('tr')
					
				div.attr('class','icheckbox_flat-green checked');
				tr.attr('class','pointer even selected');
					
			})
		}else{
			divt.attr('class','icheckbox_flat-green');
			trt.attr('class','pointer even');
			$('ins.iCheck-helper').each(function(){
				var div = $('ins.iCheck-helper').parent('div')
				var tr = $('ins.iCheck-helper').parents('tr')
					
				div.attr('class','icheckbox_flat-green ');
				tr.attr('class','pointer even ');
					
			})

		}
		

	})

	var gids;
	//设置单行选择按钮事件
	$('ins.iCheck-helper').each(function(){
		$(this).click(function(){
			var div = $(this).parent('div');
			var tr = $(this).parents('tr');
			var gid_td = $(this).parents('tr').find('td:nth-child(2)').html(); 
			if(div.attr('class')=='icheckbox_flat-green'){
				div.attr('class','icheckbox_flat-green checked');
				tr.attr('class','pointer even selected');
				gids = [gid_td];
				console.log(gids);
			}else{
				div.attr('class','icheckbox_flat-green');
				tr.attr('class','pointer even');
			}
		})
		
	})
	 

	//设置删除按钮事件
	var zhezhao = false;	
	$('a.delete_but').each(function(){
		$(this).click(function(){
		// return zhezhao;
			//获取遮罩层对象
			$('#avatar-modal').removeAttr('style').attr('style','display:block');
			// alert($(this).attr('ahref'));
			$('.del_buta').attr('href',$(this).attr('ahref'));
			// return false;
		})
	})
	//获取可视区域的高度
		var w = $(window).height();
		// alert(w+"px");
		//计算确认层的Y轴的位置
		var zy = (w/2)-180+"px";
		// alert(zy);
		//读确认层的style样式
		var qrcStyle = $('#qrc').attr('style');
		//拼接确认层样式
		var qrcStyleNew = qrcStyle+'margin-top:'+zy+';';
		//修改确认层样式
		// alert(qrcStyleNew);
		$('#qrc').removeAttr('style').attr('style',qrcStyleNew);

		$('#heimu').removeAttr('style').attr('style','height:'+w+'px');

		//当点击X的时候退出遮罩层事件
		$('#close_but').click(function(){

			$('#avatar-modal').removeAttr('style').attr('style','display:none');
			return false;
			})
		
		//当点击取消时退出遮罩层事件
		$('#cancel_but').click(function(){
			$('#avatar-modal').removeAttr('style').attr('style','display:none');
			return false;
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