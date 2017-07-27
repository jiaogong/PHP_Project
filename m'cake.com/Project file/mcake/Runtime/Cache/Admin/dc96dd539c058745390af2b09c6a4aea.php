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
        <h3>广告管理</h3>
    </div>
</div>
<div class="x_panel">
    <div class="x_title">
        <h2>广告添加 <small></small></h2>
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
	    <form action="<?php echo U(insert);?>" class="form1 form-horizontal form-label-left" data-parsley-validate="" id="demo-form2" name="goods_insert" novalidate="" method="post" enctype="multipart/form-data">
				
	        <div class="form-group">
	            <label for="first-name" class="control-label col-md-3 col-sm-3 col-xs-12">广告标题
	            </label>
	            <div class="col-md-6 col-sm-6 col-xs-12">
	                <input type="text" style="width: 300px;" class="form-control col-md-7 col-xs-12" required="required" id="title" name="title" data-parsley-id="4702" value=""><span></span>
	            </div>
	        </div>
	         <div class="form-group">
	            <label for="first-name" class="control-label col-md-3 col-sm-3 col-xs-12">广告图片
	            </label>
	            <div class="col-md-6 col-sm-6 col-xs-12">
	                <input type="file" id="image" name="image" data-parsley-id="4702" value="" onchange="javascript:setImagePreview();"><span style="line-height: 10px;" class="tupian_guige">[ 上传广告图片规格 ] <p>header:1280px(像素)*500px(像素)</p> <p>left&right:150px(像素)*400px(像素)</p> <p>footer:1280px(像素)*400px(像素)</p></span>
	            </div>
	            <div id="localImag" style="margin-left: 250px;margin-top:35px;width:310px;height:auto;border: 1px solid #ddd;padding:5px;display: none;" ><img  id="preview" width=-1 height=-1 style="diplay:none" />
				</div>
	        </div>
	        <div class="form-group">
	        	<label for="first-name" class="control-label col-md-3 col-sm-3 col-xs-12">是否开启广告前提示语
	            </label>
	            <label class="">
                       <div class="icheckbox_flat-green checked tishi" style="position: relative;margin-left: 10px;"><input name="prompt" value="1" type="checkbox" checked="checked" class="flat tishi_text" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255) none repeat scroll 0% 0%; border: 0px none; opacity: 0;"></ins></div> 
                    </label>
	        </div>
	        <div class="form-group">
	            <label for="first-name" class="control-label col-md-3 col-sm-3 col-xs-12">广告位置
	            </label>
	            <input class="position_ad" type="hidden" name="position" value="header">
	            <div class="col-md-6 col-sm-6 col-xs-12" style="margin-left: -10px;margin-bottom: -10px;">
	            	<ul style="width:200px;list-style: none;padding:10px;">
	            	<li>
	                <div class="header_ad" style="width:200px;height: 50px;background: #26b99a;color:#fff;text-align: center;line-height: 50px;cursor: pointer;border-radius: 3px;">header</div>
	                </li>
	                <li style="margin-left: -40px;margin-top: 10px;margin-bottom: 10px;">
		                <ul style="list-style: none;">
		                	<li style="float: left;"><div class="left_ad" style="width:50px;height:120px;background: #ddd;margin-left: 0px;text-align: center;line-height: 100px;cursor: pointer;border-radius: 3px;">left</div></li>
		                	<li><div class="right_ad" style="width:50px;height:120px;background: #ddd;margin-left: 150px;text-align: center;line-height: 100px;cursor: pointer;border-radius: 3px;">right</div></li>
						</ul>
	                </li>
	                <li><div class="footer_ad" style="width:200px;height: 50px;background: #ddd;text-align: center;line-height: 50px;cursor: pointer;border-radius: 3px;">footer</div></li>
	                </ul>
	            </div>
	        </div>
	        <div class="form-group">
	            <label for="first-name" class="control-label col-md-3 col-sm-3 col-xs-12">广告出现的时间
	            </label>
	            <div class="col-md-6 col-sm-6 col-xs-12">
	            	<select style="width:100px;height: 25px;font-size:18px;opacity: 0.7;" name="adtime">
	            		<option>5</option>
	            		<option>10</option>
	            		<option>50</option>
	            		<option>100</option>
	            		<option>600</option>
	            		<option>3600</option>
	            	</select> 秒后 
	            </div>
	        </div>
	        <div class="form-group">
	            <label for="first-name" class="control-label col-md-3 col-sm-3 col-xs-12">广告出现的次数
	            </label>
	            <div class="col-md-6 col-sm-6 col-xs-12">
	                <input type="number" style="width: 100px;height: 30px;" class="form-control col-md-7 col-xs-12" min='0' max="1" required="required" name="num" data-parsley-id="4702" value="1">&nbsp;次<span></span>
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


/*广告位置定位 开始*/
		
	//广告位置 选择

		$('.header_ad').click(function(){
			$(this).css({background:'#26b99a',color:'#fff'});
			$('.left_ad').css({background:'#ddd',color:'#999'});
			$('.right_ad').css({background:'#ddd',color:'#999'});
			$('.footer_ad').css({background:'#ddd',color:'#999'});
			$('.position_ad').val('header');
		})
		$('.left_ad').click(function(){
			$(this).css({background:'#26b99a',color:'#fff'});
			$('.right_ad').css({background:'#26b99a',color:'#fff'});
			$('.header_ad').css({background:'#ddd',color:'#999'});
			$('.footer_ad').css({background:'#ddd',color:'#999'});
			$('.position_ad').val('left+right');

		})
		$('.right_ad').click(function(){
			$(this).css({background:'#26b99a',color:'#fff'});
			$('.left_ad').css({background:'#26b99a',color:'#fff'});
			$('.header_ad').css({background:'#ddd',color:'#999'});
			$('.footer_ad').css({background:'#ddd',color:'#999'});
			$('.position_ad').val('left+right');
		})
		$('.footer_ad').click(function(){
			$(this).css({background:'#26b99a',color:'#fff'});
			$('.left_ad').css({background:'#ddd',color:'#999'});
			$('.right_ad').css({background:'#ddd',color:'#999'});
			$('.header_ad').css({background:'#ddd',color:'#999'});
			$('.position_ad').val('footer');
		})

	//广告提示语的 选择
		$('.tishi').click(function(){
			if(!$(this).attr('d')){
			$(this).attr('d','d');
			$('.tishi_text').val('0');
			}else{
				$(this).removeAttr('d');
				$('.tishi_text').val('1');
			}

		})

/*广告位置定位 结束*/


/*图片上传预览 开始*/
$('#image').focus(function(){
	$('#localImag').show();
})
function setImagePreview() {  
        var docObj=document.getElementById("image");  
   
        var imgObjPreview=document.getElementById("preview");  
                if(docObj.files &&    docObj.files[0]){  
                        //火狐下，直接设img属性  
                        imgObjPreview.style.display = 'block';  
                        imgObjPreview.style.width = '300px';  
                        imgObjPreview.style.height = 'auto';                     
      //火狐7以上版本不能用上面的getAsDataURL()方式获取，需要一下方式    
      imgObjPreview.src = window.URL.createObjectURL(docObj.files[0]);
	$('.tupian_guige').hide();

  
  
                }
                return true;    
        }
/*图片上传预览 结束*/


/*添加内容判断  以及样式 开始*/
	var T = false;
	var A = false;
	
	$('#title').blur(function(){
		var tit = $(this).val();
		var re = /^\S+$/;
		var r = tit.match(re);
		// alert(r);
		if(tit=='' || tit.length>20 || r==null){
			$(this).css({border:'1px solid rgba(230,3,3,0.3)',borderRadius:'3px',boxShadow:'2px 1px 4px 1px rgba(230,3,3,0.2)'});
			var s = '[ 标题 ]不能为空,且不能超出20个字符'
			$(this).siblings('span').html(s);
			return T=false;
		}else{
			$(this).css({border:'1px solid rgba(3,130,3,0.3)',borderRadius:'3px',boxShadow:'2px 1px 4px 1px rgba(3,230,3,0.2)'});
			$(this).siblings('span').remove();
			return T=true;
		}
	})

	
	$('form').submit(function(){
		
		var tit = $('#title').val();
		if(tit=='' || tit.length>20){
			$('#title').css({border:'1px solid rgba(3,3,230,0.3)',borderRadius:'3px',boxShadow:'2px 1px 4px 1px rgba(3,3,230,0.2)'});
			alert('广告标题确认是否有误');
			return T;
		}
		如果没有上传图片,就不处理图片
		var img = $('#image').val();
		if(img==''){
			alert('没有上传广告图片');
			return A;
		}else{
			return A=true;
		}
		
		if(T==false ||A==false){
			return false;
		}
		return true;
		
	})
/*添加内容判断  以及样式 结束*/
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