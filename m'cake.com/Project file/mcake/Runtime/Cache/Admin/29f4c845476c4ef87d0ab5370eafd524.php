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
        <h3>友情链接管理</h3>
    </div>
</div>
<div class="x_panel">
    <div class="x_title">
        <h2>友链添加 <small></small></h2>
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
	    <form action="<?php echo U(insert);?>" class="form-horizontal form-label-left" data-parsley-validate="" id="demo-form2" name="goods_insert" novalidate="" method="post" enctype="multipart/form-data">
				
	        <div class="form-group">
	            <label for="first-name" class="control-label col-md-3 col-sm-3 col-xs-12">网站名称
	            </label>
	            <div class="col-md-6 col-sm-6 col-xs-12">
	                <input type="text" style="width: 500px;" class="form-control col-md-7 col-xs-12" required="required" id="fname" name="fname" data-parsley-id="4702" value=""><span></span>
	            </div>
	        </div>
	        <div class="form-group">
	            <label for="first-name" class="control-label col-md-3 col-sm-3 col-xs-12">网址
	            </label>
	            <div class="col-md-6 col-sm-6 col-xs-12">
	                <input type="text" style="width: 500px;"  class="form-control col-md-7 col-xs-12" required="required" id="furl" name="furl" data-parsley-id="4702" value=""><span></span>
	            </div>
	        </div>
	        <div class="form-group">
	            <label for="first-name" class="control-label col-md-3 col-sm-3 col-xs-12">彩色标志(logo)
	            </label>
	            <div class="col-md-6 col-sm-6 col-xs-12">
	                <input type="file" id="image_c" name="fimage[]" data-parsley-id="4702" value="" onchange="javascript:setImagePreviewC();"><span><span style="font-size:12px;"> ! 建议上传图片大小 规格:200px(像素)*100px(像素)</span></span>
	            </div>
				<div id="localImag_c" style="margin-left: 250px;margin-top:50px;width:212px;height:111px;border: 1px solid #ddd;padding:5px;" ><img  id="preview_c" width=-1 height=-1 style="diplay:none" />
				</div>
	        </div>
	        <div class="form-group">
	            <label for="first-name" class="control-label col-md-3 col-sm-3 col-xs-12">黑白标志(logo)
	            </label>
	            <div class="col-md-6 col-sm-6 col-xs-12">
	                <input type="file" id="image_bw" name="fimage[]" data-parsley-id="4702" value="" onchange="javascript:setImagePreviewB();"><span><span style="font-size:12px;"> ! 建议上传图片大小 规格:200px(像素)*100px(像素)</span></span>
	            </div>
				<div id="localImag_bw" style="margin-left: 250px;margin-top:50px;width:212px;height:111px;border: 1px solid #ddd;padding:5px;" ><img  id="preview_bw" width=-1 height=-1 style="diplay:none" />
				</div>
	        </div>
	        <div class="form-group">
	            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
	                <button class="btn btn-success" type="submit">添加</button>
	                <button class="btn btn-primary" type="reset">重置</button>
	            </div>
	        </div>

	    </form>
	</div>
</div>

<script type="text/javascript" src="/mcake/Public/Admin/production/js/parsley/parsley.min.js"></script>
<script type="text/javascript">

/*添加内容判断  以及样式 开始*/
	var T = false;
	var A = false;
	var D = false;
	var C = false;
	
	$('#fname').blur(function(){
		var tit = $(this).val();
		var re = /^[\u4e00-\u9fa5_a-zA-Z0-9]+[\s]?[\u4e00-\u9fa5_a-zA-Z0-9]+$/;
		var r = tit.match(re);
		// alert(111);
		if(tit=='' || tit.length>50 || r==null){
			$(this).css({border:'1px solid rgba(230,3,3,0.3)',borderRadius:'3px',boxShadow:'2px 1px 4px 1px rgba(230,3,3,0.2)'});
			var s = '[ 网站名称 ]不能为空,或格式不正确,且不能超出50个字符'
			$(this).siblings('span').html(s);
			return T=false;
		}else{
			$(this).css({border:'1px solid rgba(3,130,3,0.3)',borderRadius:'3px',boxShadow:'2px 1px 4px 1px rgba(3,230,3,0.2)'});
			$(this).siblings('span').remove();
			return T=true;
		}
	})
//     //
	$('#furl').blur(function(){
		var aut = $(this).val();
		var re = /^[A-Za-z0-9]*[\.]?[A-Za-z0-9]+\.[A-Za-z]+$/;
		var r  = aut.match(re);
		if(aut=='' || aut.length>50 || r==null){
			$(this).css({border:'1px solid rgba(230,3,3,0.3)',borderRadius:'3px',boxShadow:'2px 1px 4px 1px rgba(230,3,3,0.2)'});
			var s = '[ 网址 ]不能为空,或格式不正确,且不能超出50个字符'
			$(this).siblings('span').html(s);
			return A=false;
		}else{
			$(this).css({border:'1px solid rgba(3,130,3,0.3)',borderRadius:'3px',boxShadow:'2px 1px 4px 1px rgba(3,230,3,0.2)'});
			$(this).siblings('span').remove();
			return A=true;
		}
	})
	
	$('form').submit(function(){
		//如果没有上传图片,提示
		//彩色
		if($('#image_c').val()==""){
			$('localImag_c').css({border:'1px solid rgba(230,3,3,0.8)',boxShadow:'2px 1px 4px 1px rgba(230,3,3,0.2)'});
			alert('没有上传彩色logo图片');
			return D;
		}
		//黑白
		if($('#image_bw').val()==""){
			$('localImag_bw').css({border:'1px solid rgba(230,3,3,0.8)',boxShadow:'2px 1px 4px 1px rgba(230,3,3,0.2)'});
			alert('没有上传黑白logo图片');
			return C;
		}
		if(T!=true){
			$('#fname').css({border:'1px solid rgba(3,3,230,0.3)',borderRadius:'3px',boxShadow:'2px 1px 4px 1px rgba(3,3,230,0.2)'});
			alert('网站格式确认');
			return T;
		}
		var aut = $('#furl').val();
		if(A!=true){
			$('#furl').css({border:'1px solid rgba(3,3,230,0.3)',borderRadius:'3px',boxShadow:'2px 1px 4px 1px rgba(3,3,230,0.2)'});
			alert('网址格式确认');
			return A;
		}
		
		if(T==false || A==false){
			return false;
		}
		return true;
	})
/*添加内容判断  以及样式 结束*/

/*图片上传预览 开始*/
//彩色图片处理
function setImagePreviewC() {  
        var docObj=document.getElementById("image_c");  
   
        var imgObjPreview=document.getElementById("preview_c");  
                if(docObj.files &&    docObj.files[0]){  
                        //火狐下，直接设img属性  
                        imgObjPreview.style.display = 'block';  
                        imgObjPreview.style.width = '200px';  
                        imgObjPreview.style.height = '99px';                     
      //火狐7以上版本不能用上面的getAsDataURL()方式获取，需要一下方式    
      imgObjPreview.src = window.URL.createObjectURL(docObj.files[0]);  
  
  
                }   
                return true;  
        }  
//黑白图片处理
function setImagePreviewB() {  
        var docObj=document.getElementById("image_bw");  
   
        var imgObjPreview=document.getElementById("preview_bw");  
                if(docObj.files &&    docObj.files[0]){  
                        //火狐下，直接设img属性  
                        imgObjPreview.style.display = 'block';  
                        imgObjPreview.style.width = '200px';  
                        imgObjPreview.style.height = '99px';                     
      //火狐7以上版本不能用上面的getAsDataURL()方式获取，需要一下方式    
      imgObjPreview.src = window.URL.createObjectURL(docObj.files[0]);  
  
  
                }
                return true;    
        }
/*图片上传预览 结束*/


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