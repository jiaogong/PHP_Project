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
        <h3>修改用户信息</h3>
    </div>
</div>
<div class="x_panel">
    <div class="x_title">
        <h2>修改用户信息 <small>请认真填写</small></h2>
        <div class="clearfix"></div>
    </div>
	<div class="x_content">
	    <br>
	    <form class="form-horizontal form-label-left" method="post" action="<?php echo U('Admin/Auser/update');?>" data-parsley-validate="" id="demo-form2" novalidate="">

	        <div class="form-group">
	            <label for="first-name" class="control-label col-md-3 col-sm-3 col-xs-12">用户账号 <span class="required">*</span>
	            </label>
	            <div class="col-md-6 col-sm-6 col-xs-12">
	                <input type="text" class="form-control col-md-7 col-xs-12" required="required" id="first-name" data-parsley-id="4702" name="ausername" value="<?php echo ($ausers['ausername']); ?>"><span></span>
	            </div>
	        </div>
	        
	        <div class="form-group">
	            <label class="control-label col-md-3 col-sm-3 col-xs-12">性别</label>
	            <div class="col-md-6 col-sm-6 col-xs-12">
	                <div data-toggle="buttons" class="btn-group" id="gender">
	                	<?php if($ausers['asex'] == 1 ): ?><label data-toggle-passive-class="btn-default" data-toggle-class="btn-primary" class="btn btn-primary active">
	                        	<input type="radio" checked="" value='1' name="asex" data-parsley-multiple="gender" data-parsley-id="5600"> &nbsp; 男 &nbsp;
		                    </label>
		                    <label data-toggle-passive-class="btn-default" data-toggle-class="btn-primary" class="btn btn-default">
		                        <input type="radio"  value='0' name="asex" data-parsley-multiple="gender" data-parsley-id="5600"> &nbsp; 女 &nbsp; 
		                    </label>
	                	<?php else: ?>
		                    <label data-toggle-passive-class="btn-default" data-toggle-class="btn-primary" class="btn btn-default">
		                        <input type="radio" checked="" value='1' name="asex" data-parsley-multiple="gender" data-parsley-id="5600"> &nbsp; 男 &nbsp;
		                    </label>
		                    <label data-toggle-passive-class="btn-default" data-toggle-class="btn-primary" class="btn btn-primary active">
		                        <input type="radio"  value='0' name="asex" data-parsley-multiple="gender" data-parsley-id="5600"> &nbsp; 女 &nbsp; 
		                    </label><?php endif; ?>
	                </div>
	            </div>
	        </div>
	        <div class="form-group">
	            <label class="control-label col-md-3 col-sm-3 col-xs-12">邮箱 <span class="required">*</span>
	            </label>
	            <div class="col-md-6 col-sm-6 col-xs-12">
	                <input type="text" required="required" class="date-picker form-control col-md-7 col-xs-12" id="birthday" data-parsley-id="3087" name="aemail" value="<?php echo ($ausers['aemail']); ?>"><span></span>
	            </div>
	        </div>
	        <div class="form-group">
	            <label class="control-label col-md-3 col-sm-3 col-xs-12">电话 <span class="required">*</span>
	            </label>
	            <div class="col-md-6 col-sm-6 col-xs-12">
	                <input type="text" required="required" class="date-picker form-control col-md-7 col-xs-12" id="birthday" data-parsley-id="3087" name="aphone" value="<?php echo ($ausers['aphone']); ?>"><span></span>
	            </div>
	        </div>
	        <div class="form-group">
	        		<label class="control-label col-md-3 col-sm-3 col-xs-12">组别 <span class="required">*</span></label>
	        		<select name="group_id" style="width: 150px;height:30px;margin-left:10px; padding: 2px;" size="1" aria-controls="example">
	        		<option value="">所属组别</option>
	        		<?php if(is_array($groups)): foreach($groups as $key=>$vo): ?><option value="<?php echo ($vo['id']); ?>" <?php if(($group_ids['group_id']) == $vo['id']): ?>selected='selected'<?php endif; ?>><?php echo ($vo['title']); ?></option><?php endforeach; endif; ?>
	        		</select>
	        </div>
	        <div class="form-group">
	            <label class="control-label col-md-3 col-sm-3 col-xs-12">验证码 <span class="required">*</span>
	            </label>
	            <div class="col-md-6 col-sm-6 col-xs-12">
	            	<img src="<?php echo U('Admin/Public/vcode');?>" alt="" onclick="this.src=this.src+'?b'">
	                <input type="text" required="required" class="date-picker form-control col-md-7 col-xs-12" id="birthday" data-parsley-id="3087" name="vcode"><span></span>
	            </div>
	        </div>
	        <input type="hidden" name="id" value="<?php echo ($ausers['id']); ?>">
	        <div class="ln_solid"></div>
	        <div class="form-group">
	            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
	                <button class="btn btn-success" type="submit">修改</button>
	                <button class="btn btn-primary" type="reset">重置</button>
	            </div>
	        </div>

	    </form>
	</div>
</div>


<script type="text/javascript">
	//性别点击事件
	$('#gender label').click(function(){
		$('#gender label').attr('class','');
		$(this).attr('class','btn btn-primary active');
		$(this).siblings('label').attr('class','btn btn-default');
	})
	
	//检测邮箱格式
	var E = false;
	var R = false;
	$('input[name=aemail]').blur(function() {
		/* Act on the event */
		//获取邮箱值
		var v = $(this).val();
		var reg = /^\w+@\w+\.(com|cn|net|hk|org|jp|com.cn)$/;
		//判断
		if(!reg.test(v)){
			E = false;
			$(this).next().html('请正确填写邮箱').css('color','red');
		}else{
			E = true;
			$(this).next().html('')
		}
	});

	$('input[name=aphone]').blur(function(){
            var v = $(this).val();
            var reg = /^1([3,5,8]{1})\d{9}$/;
            if(!reg.test(v)){
                R = false;
                $(this).next().html('手机号输入有误,请重新输入').css('color','red');
            }else{
                R = true;
                $(this).next().html('');
            }
        })
		
	//绑定提交
	$('#demo-form2').submit(function() {
		var vcode = $('input[name=vcode]').val();
		var ausername = $('input[name=ausername]').val();
		var group_id = $('select[name=group_id]').val();
		if(!ausername){
			$('input[name=ausername]').next().html('用户名不能为空').css('color','red');
			return false;
		}else{
			$('input[name=ausername]').next().html('');
		};
		if(!vcode){
			$('input[name=vcode]').next().html('请填写验证码').css('color','red');
			return false;
		}else{
			$('input[name=vcode]').next().html('');
		};

		if(!group_id){
			$('select[name=group_id]').next().html('请填写验证码').css('color','red');
			return false;
		}else{
			$('select[name=group_id]').next().html('');
		}
		
		$('input[name=reapass]').trigger('blur');
		$('input[name=aemail]').trigger('blur');
		$('input[name=apass]').trigger('blur');
		$('input[name=ausername]').trigger('blur');
		if(E){
			return true;
		}else{
			return false;
		}
	});
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