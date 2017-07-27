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
                                        <li><a href="<?php echo U('Admin/Webconfig/mesg');?>">邮件和短信设置</a>
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
        <h3>文章管理</h3>
    </div>
</div>
<div class="x_panel">
    <div class="x_title">
        <h2>文章修改 <small></small></h2>
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
	    <form action="<?php echo U(upload);?>" class="form-horizontal form-label-left" data-parsley-validate="" id="demo-form2" name="goods_insert" novalidate="" method="post" enctype="multipart/form-data">
				
	        <div class="form-group">
	            <label for="first-name" class="control-label col-md-3 col-sm-3 col-xs-12">文章标题
	            </label>
	            <div class="col-md-6 col-sm-6 col-xs-12">
	                <input type="text" style="width: 500px;" class="form-control col-md-7 col-xs-12" required="required" id="title" name="title" data-parsley-id="4702" value="<?php echo ($art["title"]); ?>">
	            </div>
	        </div>
	        <div class="form-group">
	            <label for="first-name" class="control-label col-md-3 col-sm-3 col-xs-12">作者
	            </label>
	            <div class="col-md-6 col-sm-6 col-xs-12">
	                <input type="text" style="width: 500px;"  class="form-control col-md-7 col-xs-12" required="required" id="author" name="author" data-parsley-id="4702" value="<?php echo ($art["author"]); ?>">
	            </div>
	        </div>
	        <div class="form-group">
	            <label for="first-name" class="control-label col-md-3 col-sm-3 col-xs-12">文章出处
	            </label>
	            <div class="col-md-6 col-sm-6 col-xs-12">
	                <input type="text" style="width: 500px;" class="form-control col-md-7 col-xs-12" required="required" id="derivation" name="derivation" data-parsley-id="4702" value="<?php echo ($art["derivation"]); ?>">
	            </div>
	        </div>
	        <div class="form-group">
	            <label for="first-name" class="control-label col-md-3 col-sm-3 col-xs-12">文章类型
	            </label>
	            <div class="col-md-6 col-sm-6 col-xs-12">
	            	<select style="width:200px;height: 35px;font-size:18px;opacity: 0.7;" name="type">
	            		<option <?php if(($art["type"]) == "媒体合作"): ?>selected<?php endif; ?>>媒体合作</option>
	            		<option <?php if(($art["type"]) == "招贤纳士"): ?>selected<?php endif; ?>>招贤纳士</option>
	            		<option <?php if(($art["type"]) == "呼叫中心"): ?>selected<?php endif; ?>>呼叫中心</option>
	            		<option <?php if(($art["type"]) == "订单相关"): ?>selected<?php endif; ?>>订单相关</option>
	            		<option <?php if(($art["type"]) == "支付类"): ?>selected<?php endif; ?>>支付类</option>
	            		<option <?php if(($art["type"]) == "购物指南"): ?>selected<?php endif; ?>>购物指南</option>
	            		<option <?php if(($art["type"]) == "会员权益"): ?>selected<?php endif; ?>>会员权益</option>
	            		<option <?php if(($art["type"]) == "配送服务"): ?>selected<?php endif; ?>>配送服务</option>
	            	</select> 
	            </div>
	        </div>
	        <?php if(($art["image"]) != ""): ?><div class="form-group">
	            <label for="first-name" class="control-label col-md-3 col-sm-3 col-xs-12">原图
	            </label>
	            <div class="col-md-6 col-sm-6 col-xs-12">
	                <img style="width:210px;padding:5px;border: 1px solid #ddd;" src="<?php echo ($art["image"]); ?>">
	            </div>
	        </div><?php endif; ?>
	        <div class="form-group">
	            <label for="first-name" class="control-label col-md-3 col-sm-3 col-xs-12">新图
	            </label>
	            <div class="col-md-6 col-sm-6 col-xs-12">
	                <input type="file" id="images" name="image" data-parsley-id="4702" value="" onchange="javascript:setImagePreview();"><span></span>
	            </div>
	            <div id="localImag" style="margin-left: 250px;margin-top:35px;width:210px;height:auto;border: 1px solid #ddd;padding:5px;display: none;" ><img  id="preview" width=-1 height=-1 style="diplay:none" />
				</div>
			</div>
	        <div class="form-group">
	            <label for="first-name" class="control-label col-md-3 col-sm-3 col-xs-12">文章内容
	            </label>
	            <!-- 文本编辑区 开始 -->
			<script type="text/javascript" charset="utf-8" src="/Public/ueditor/ueditor.config.js"></script>
    		<script type="text/javascript" charset="utf-8" src="/Public/ueditor/ueditor.all.js"> </script>
			<script id="editor" type="text/plain" style="width:624px;height:400px;margin-left: 250px;"><?php echo (strip_tags(htmlspecialchars_decode($art["content"]))); ?></script>
			<script type="text/javascript">
				var ue = UE.getEditor('editor');
			</script>

			

            <!-- 文本编辑区 结束 -->
	          <!--   <div class="col-md-6 col-sm-6 col-xs-12">
	                <textarea style="border-radius: 3px;width: 500px;height: 300px;" rows="20"  name="content"  class="form-control col-md-7 col-xs-12" required="required" id="content" data-parsley-id="4702" ><?php echo ($art["content"]); ?></textarea>
	            </div> -->
	        </div>

	        <div class="ln_solid"></div>
	        <div class="form-group">
	        <input type="hidden" name="id" value="<?php echo ($art["id"]); ?>" />
	            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
	                <button class="btn btn-success" type="submit">更新</button>
	                <button class="btn btn-primary" type="reset">重置</button>
	            </div>
	        </div>

	    </form>
	</div>
</div>
<script type="text/javascript" src="/Public/Admin/production/js/parsley/parsley.min.js"></script>
<script type="text/javascript">

/*图片上传预览 开始*/
$('#images').focus(function(){
	$('#localImag').show();
})
function setImagePreview() {  
        var docObj=document.getElementById("images");  
   
        var imgObjPreview=document.getElementById("preview");  
                if(docObj.files &&    docObj.files[0]){  
                        //火狐下，直接设img属性  
                        imgObjPreview.style.display = 'block';  
                        imgObjPreview.style.width = '200px';  
                        imgObjPreview.style.height = 'auto';                     
      //火狐7以上版本不能用上面的getAsDataURL()方式获取，需要一下方式    
      imgObjPreview.src = window.URL.createObjectURL(docObj.files[0]);  
  
  
                }
                return true;    
        }
/*图片上传预览 结束*/


	/*修改内容判断  以及样式 开始*/
	var T = false;
	var A = false;
	var D = false;
	var C = false;
	
	// $('#title').blur(function(){
	// 	var tit = $(this).val();
	// 	var re = /^\S+$/;
	// 	var r = tit.match(re);
	// 	// alert(r);
	// 	if(tit=='' || tit.length>20 || r==null){
	// 		$(this).css({border:'1px solid rgba(230,3,3,0.3)',borderRadius:'3px',boxShadow:'2px 1px 4px 1px rgba(230,3,3,0.2)'});
	// 		var s = '[ 标题 ]不能为空,且不能超出20个字符'
	// 		$(this).siblings('span').html(s);
	// 		return T=false;
	// 	}else{
	// 		$(this).css({border:'1px solid rgba(3,130,3,0.3)',borderRadius:'3px',boxShadow:'2px 1px 4px 1px rgba(3,230,3,0.2)'});
	// 		$(this).siblings('span').remove();
	// 		return T=true;
	// 	}
	// })

	// $('#author').blur(function(){
	// 	var aut = $(this).val();
	// 	var re = /^\S+$/;
	// 	var r  = aut.match(re);
	// 	if(aut=='' || aut.length>20 || r==null){
	// 		$(this).css({border:'1px solid rgba(230,3,3,0.3)',borderRadius:'3px',boxShadow:'2px 1px 4px 1px rgba(230,3,3,0.2)'});
	// 		var s = '[ 作者 ]不能为空,且不能超出20个字符'
	// 		$(this).siblings('span').html(s);
	// 		return A=false;
	// 	}else{
	// 		$(this).css({border:'1px solid rgba(3,130,3,0.3)',borderRadius:'3px',boxShadow:'2px 1px 4px 1px rgba(3,230,3,0.2)'});
	// 		$(this).siblings('span').remove();
	// 		return A=true;
	// 	}
	// })
	// $('#derivation').blur(function(){
	// 	var der = $(this).val();
	// 	var re = /^\S+$/;
	// 	var r  = der.match(re);
	// 	if(der=='' || der.length>20 || r==null){
	// 		$(this).css({border:'1px solid rgba(230,3,3,0.3)',borderRadius:'3px',boxShadow:'2px 1px 4px 1px rgba(230,3,3,0.2)'});
	// 		var s = '[ 出处 ]不能为空,且不能超出20个字符';
	// 		$(this).siblings('span').html(s);
	// 		return D=false;
	// 	}else{
	// 		$(this).css({border:'1px solid rgba(3,130,3,0.3)',borderRadius:'3px',boxShadow:'2px 1px 4px 1px rgba(3,230,3,0.2)'});
	// 		$(this).siblings('span').remove();
	// 		return D=true;
	// 	}
	// })
	// $('#content').blur(function(){
	// 	var con = $(this).val();
	// 	if(con=='' || con.length>1000){
	// 		$(this).css({border:'1px solid rgba(230,3,3,0.3)',borderRadius:'3px',boxShadow:'2px 1px 4px 1px rgba(230,3,3,0.2)'});
	// 		var s = '[ 内容 ]不能为空,且不能超出1000个字符';
	// 		$(this).siblings('span').html(s);
	// 		return C=false;
	// 	}else{
	// 		$(this).css({border:'1px solid rgba(3,130,3,0.3)',borderRadius:'3px',boxShadow:'2px 1px 4px 1px rgba(3,230,3,0.2)'});
	// 		$(this).siblings('span').remove();
	// 		return C=true;
	// 	}
	// })
	$('form').submit(function(){

		//如果没有上传图片,就不处理图片
		if($('#images').val()==""){
			$('form').removeAttr('enctype');
			$('#images').attr('name','');
		}
		
		var tit = $('#title').val();
		if(tit=='' || tit.length>20){
			$('#title').css({border:'1px solid rgba(230,3,3,0.3)',borderRadius:'3px',boxShadow:'2px 1px 4px 1px rgba(230,3,3,0.2)'});
			alert('标题不能为空,且不能超出20个字符');
			return T;
		}
		var aut = $('#author').val();
		if(aut=='' || aut.length>20){
			$('#author').css({border:'1px solid rgba(230,3,3,0.3)',borderRadius:'3px',boxShadow:'2px 1px 4px 1px rgba(230,3,3,0.2)'});
			alert('作者不能为空,且不能超出20个字符');
			return A;
		}
		var der = $('#derivation').val();
		if(der=='' || der.length>20){
			$('#derivation').css({border:'1px solid rgba(230,3,3,0.3)',borderRadius:'3px',boxShadow:'2px 1px 4px 1px rgba(230,3,3,0.2)'});
			alert('文章出处不能为空,且不能超出20个字符');
			return D;
		}
		var con = $('#content').val();
		if(con=='' || con.length>1000){
			$('#content').css({border:'1px solid rgba(230,3,3,0.3)',borderRadius:'3px',boxShadow:'2px 1px 4px 1px rgba(230,3,3,0.2)'});
			alert('文章内容不能为空,且不能超出1000个字符');
			return C;
		}
		if(T==false || A==false || D==false || C==false){
			return false;
		}

	})
	/*修改内容判断  以及样式 结束*/

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