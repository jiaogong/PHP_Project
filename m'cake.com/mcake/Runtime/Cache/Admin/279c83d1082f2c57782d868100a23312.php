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
                
                

    <div class="x_panel" style="">
                                <div class="x_title" style="display:block">
                                    <h2>MCAKE蛋糕网~~~系统状态详情<small>实时状态</small></h2>
                                    <ul class="nav navbar-right panel_toolbox">
                                        <li><a href="#"><i class="fa fa-chevron-up"></i></a>
                                        </li>
                                        <li class="dropdown">
                                            <a aria-expanded="false" role="button" data-toggle="dropdown" class="dropdown-toggle" href="#"><i class="fa fa-wrench"></i></a>
                                            <ul role="menu" class="dropdown-menu">
                                                <li><a href="#">Settings 1</a>
                                                </li>
                                                <li><a href="#">Settings 2</a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li><a href="#"><i class="fa fa-close"></i></a>
                                        </li>
                                    </ul>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">

                                    <div class="col-md-3 col-sm-3 col-xs-12 profile_left">

                                        <div class="profile_img">

                                            <!-- end of image cropping -->
                                            <div id="crop-avatar">
                                                <!-- Current avatar -->
                                             
                                                <div title="" class="avatar-view" data-original-title="Change the avatar">
                                                    <img alt="Avatar" src="/mcake/Public/Index/images/logo.png" style="padding-top:50px;">
                                                </div>
                                             

                                                <!-- Cropping modal -->
                                                <div tabindex="-1" role="dialog" aria-labelledby="avatar-modal-label" aria-hidden="true" id="avatar-modal" class="modal fade" style="margin-top:-30px;">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <form method="post" enctype="multipart/form-data" action="crop.php" class="avatar-form">
                                                                <div class="modal-header">
                                                                    <button type="button" data-dismiss="modal" class="close">×</button>
                                                                    <h4 id="avatar-modal-label" class="modal-title">Change Avatar</h4>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="avatar-body">

                                                                        <!-- Upload image and data -->
                                                                        <div class="avatar-upload">
                                                                            <input type="hidden" name="avatar_src" class="avatar-src">
                                                                            <input type="hidden" name="avatar_data" class="avatar-data">
                                                                            <label for="avatarInput">Local upload</label>
                                                                            <input type="file" name="avatar_file" id="avatarInput" class="avatar-input">
                                                                        </div>

                                                                        <!-- Crop and preview -->
                                                                        <div class="row">
                                                                            <div class="col-md-9">
                                                                                <div class="avatar-wrapper"></div>
                                                                            </div>
                                                                            <div class="col-md-3">
                                                                                <div class="avatar-preview preview-lg"></div>
                                                                                <div class="avatar-preview preview-md"></div>
                                                                                <div class="avatar-preview preview-sm"></div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="row avatar-btns">
                                                                            <div class="col-md-9">
                                                                                <div class="btn-group">
                                                                                    <button title="Rotate -90 degrees" type="button" data-option="-90" data-method="rotate" class="btn btn-primary">Rotate Left</button>
                                                                                    <button type="button" data-option="-15" data-method="rotate" class="btn btn-primary">-15deg</button>
                                                                                    <button type="button" data-option="-30" data-method="rotate" class="btn btn-primary">-30deg</button>
                                                                                    <button type="button" data-option="-45" data-method="rotate" class="btn btn-primary">-45deg</button>
                                                                                </div>
                                                                                <div class="btn-group">
                                                                                    <button title="Rotate 90 degrees" type="button" data-option="90" data-method="rotate" class="btn btn-primary">Rotate Right</button>
                                                                                    <button type="button" data-option="15" data-method="rotate" class="btn btn-primary">15deg</button>
                                                                                    <button type="button" data-option="30" data-method="rotate" class="btn btn-primary">30deg</button>
                                                                                    <button type="button" data-option="45" data-method="rotate" class="btn btn-primary">45deg</button>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-3">
                                                                                <button type="submit" class="btn btn-primary btn-block avatar-save">Done</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- <div class="modal-footer">
                                                  <button class="btn btn-default" data-dismiss="modal" type="button">Close</button>
                                                </div> -->
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- /.modal -->

                                                <!-- Loading state -->
                                                <div tabindex="-1" role="img" aria-label="Loading" class="loading"></div>
                                            </div>
                                            <!-- end of image cropping -->

                                        </div>
                                        <h3 id="c1"><?php echo C('COMPANYDES');?></h3>

                                        <ul class="list-unstyled user_data">
                                            <li><i class="fa fa-map-marker user-profile-icon" id="c2"></i> <?php echo C('COMPANY');?>
                                            </li>

                                            <li>
                                                <i class="fa fa-briefcase user-profile-icon" id="c3"></i> <?php echo C('ICP');?>
                                            </li>

                                            <li class="m-top-xs">
                                                <i class="fa fa-external-link user-profile-icon"></i>
                                                <a target="_blank" href="http://localhost/" id="c4"><?php echo C('HTTPURL');?></a>
                                            </li>
                                        </ul>
                                        
                                        <a class="btn btn-success xa"><i class="fa fa-edit m-right-xs"></i>信息编辑</a>
                                        <br>
                                       
                                           
                                        <!-- start skills 
                                        <h4>简要统计</h4>
                                        <ul class="list-unstyled user_data">
                                            <li>
                                                <p>截至当前订单总数/1000</p>
                                                <div class="progress progress_sm">
                                                    <div data-transitiongoal="
    
                                                    <?php echo ($ordernum); ?>" role="progressbar" class="progress-bar bg-green" style="width: 50%;" aria-valuenow="100"></div>
                                                </div>
                                            </li>
                                            <li>
                                                <p>Website Design</p>
                                                <div class="progress progress_sm">
                                                    <div data-transitiongoal="70" role="progressbar" class="progress-bar bg-green" style="width: 70%;" aria-valuenow="69"></div>
                                                </div>
                                            </li>
                                            <li>
                                                <p>Automation &amp; Testing</p>
                                                <div class="progress progress_sm">
                                                    <div data-transitiongoal="30" role="progressbar" class="progress-bar bg-green" style="width: 30%;" aria-valuenow="29"></div>
                                                </div>
                                            </li>
                                            <li>
                                                <p>UI / UX</p>
                                                <div class="progress progress_sm">
                                                    <div data-transitiongoal="50" role="progressbar" class="progress-bar bg-green" style="width: 50%;" aria-valuenow="49"></div>
                                                </div>
                                            </li>
                                        </ul>
                                        <!-- end of skills -->

                                    </div>
                                    <div class="col-md-9 col-sm-9 col-xs-12">

                                        <div class="profile_title">
                                            <div class="col-md-6">
                                                <h2>系统信息</h2>
                                            </div>
                                            
                                        <!-- end of user-activity-graph -->

                                        <div data-example-id="togglable-tabs" role="tabpanel" class="">
                                            <ul role="tablist" class="nav nav-tabs bar_tabs" id="myTab">
                                                <li class="active" role="presentation"><a aria-expanded="true" data-toggle="tab" role="tab" id="home-tab" href="#tab_content1">系统配置</a>
                                                </li>
                                                <li class="" role="presentation"><a aria-expanded="false" data-toggle="tab" id="profile-tab" role="tab" href="#tab_content2">简要统计</a>
                                                </li>
                                                <li class="" role="presentation"><a aria-expanded="false" data-toggle="tab" id="profile-tab2" role="tab" href="#tab_content3">公司简介</a>
                                                </li>
                                            </ul>
                                            <div class="tab-content" id="myTabContent">
                                                <div aria-labelledby="home-tab" id="tab_content1" class="tab-pane fade active in" role="tabpanel">

                                                    <!-- start recent activity -->
                                                    <ul class="messages">
                                                        <li>
                                                            <img alt="系统服务" class="avatar" src="/mcake/Public/Index/images/favicon.png">
                                                            <div class="message_date">
                                                                <h3 class="date text-info">MCAKE</h3>
                                                                <p class="month">Shanghai</p>
                                                            </div>
                                                            <div class="message_wrapper">
                                                                <h4 class="heading">信息</h4>
                                                                <blockquote class="message">
                                                                当前登陆主机：<?php echo ($server['HTTP_HOST']); ?><br>
                                                                <hr>
                                                                当前APACHE和PHP版本:<?php echo ($server['SERVER_SOFTWARE']); ?><br/>
                                                                <hr/>
                                                                当前使用的数据库:MYSQL 5.3

                                                                </blockquote>
                                                                <br>
                                            
                                                            </div>
                                                        </li>
<!--第一块结束-->
<!--第二块开始-->
<li>
                                                            <img alt="数据库" class="avatar" src="/mcake/Public/Index/images/favicon.png">
                                                            <div class="message_date">
                                                                <h3 class="date text-info">MCAKE</h3>
                                                                <p class="month">Shanghai</p>
                                                            </div>
                                                            
                                           <form data-parsley-validate="" id="demo-form" novalidate="">
            <label for="fullname" class=""><h2>数据库配置*</h2> </label><br/>
             <i class="fa fa-cog">数据库类型&nbsp;:&nbsp;</i><input type="text" required="" name="DB_TYPE" class="dbtype" id="full" data-parsley-id="9619" value="<?php echo C('DB_TYPE');?>" >
            <br style="margin-top:10px;">
            <i class="fa fa-cog">数据库名字&nbsp;:&nbsp;</i><input type="text" required="" name="DB_NAME" class="dbname" data-parsley-id="9619" value="<?php echo C('DB_NAME');?>" >
            <br style="margin-top:10px;">
            <i class="fa fa-cog">数据用户名&nbsp;:&nbsp;</i><input type="text" required="" name="DB_USER" class="dbuser" data-parsley-id="9619"value="<?php echo C('DB_USER');?>" >
            <br style="margin-top:10px;">
            <i class="fa fa-cog">数据库密码&nbsp;:&nbsp;</i><input type="text" required="" name="DB_PWD" class="dbpwd" data-parsley-id="9619" value="<?php echo C('DB_PWD');?>" >
            <br style="margin-top:10px;">
            <i class="fa fa-cog">主机的名称&nbsp;:&nbsp;</i><input type="text" required="" name="DB_HOST" class="dbht" data-parsley-id="9619"value="<?php echo C('DB_HOST');?>">
            <br style="margin-top:10px;">
            <i class="fa fa-toggle-on">网站的开关&nbsp;&nbsp;</i><input type="text" required="" name="WEBPOW" class="webpow" data-parsley-id="9619"value="<?php echo C('WEBPOWER');?>">
            <br style="margin-top:10px;">
            <i class="fa fa-cog">暂停的理由&nbsp;:&nbsp;</i><input type="text" required="" name="WEBPOW" class="webpow" data-parsley-id="9619"value="<?php echo C('WEBPOWER');?>">
            <br style="margin-top:5px;">
            <hr style="margin-top:10px;">
            <!--ajax修改 数据库配置-->
          
            <script type="text/javascript">
          $(function(){
            $('.dbtype').blur(function(){
                var database=$('.dbtype').val();
                $.post('/mcake/index.php/Admin/Webconfig/update',{DB_TYPE:database},function(){alert('修改成功!');console.log(data);});
            });
            $('.dbname').blur(function(){
                var database=$('.dbname').val();
                $.post('/mcake/index.php/Admin/Webconfig/update',{DB_NAME:database},function(){alert('修改成功!');console.log(data);});
           });
            $('.dbuser').blur(function(){
                var database=$('.dbuser').val();
                $.post('/mcake/index.php/Admin/Webconfig/update',{DB_USER:database},function(){alert('修改成功!');console.log(data);});
          });
            $('.dbpwd').blur(function(){
                var database=$('.dbpwd').val();
                $.post('/mcake/index.php/Admin/Webconfig/update',{DB_PWD:database},function(){alert('修改成功!');console.log(data);});
            });
           
            $('.dbht').blur(function(){
                var database=$('.dbht').val();
                $.post('/mcake/index.php/Admin/Webconfig/update',{DB_HOST:database},function(){alert('修改成功!');console.log(data);});
            });
            $('.webpow').blur(function(){
                var database=$('.webpow').val();
                $.post('/mcake/index.php/Admin/Webconfig/update',{WEBPOWER:database},function(){alert('修改成功!');console.log(data);});
            });
        });
            </script>
            <!--数据库修改完成-->   
   </form>    
                                                        </li>
<!--第二块结束-->
<!--第三块开始-->
         <li>
                                                            <img alt="CURL短信" class="avatar" src="/mcake/Public/Index/images/favicon.png">
                                                            <div class="message_date">
                                                                <h3 class="date text-info">MCAKE</h3>
                                                                <p class="month">Shanghai</p>
                                                            </div>
                                                        <form data-parsley-validate="" id="demo-form" novalidate="">
            <label for="fullname" class=""><h2>CURL短信配置</h2></label><br/>
            <i class="fa fa-cog">MESG_URL&nbsp;:&nbsp;</i><input type="text" value="<?php echo C('MESG_URL');?>" id="inputSuccess4" class="form-control has-feedback-left MESG_URL" name="MESG_URL">
             <i class="fa fa-cog">WEB您要在信息中显示的网站名字&nbsp;:&nbsp;</i><input type="text" required="" name="WEB" id="inputSuccess4" class="form-control has-feedback-left WEB" data-parsley-id="9619" value="<?php echo C('WEB');?>" >
            <br style="margin-top:10px;">
            <i class="fa fa-cog">CODE短信内容&nbsp;:&nbsp;</i><input type="text" required="" name="CODE" id="inputSuccess4" class="form-control has-feedback-left CODE" data-parsley-id="9619" value="<?php echo C('CODE');?>" >
            <i class="fa fa-cog">CLASS&nbsp;:&nbsp;</i><input type="text" required="" name="NEW_RULE" id="inputSuccess4" class="NEW_RULE form-control has-feedback-left"data-parsley-id="9619"value="<?php echo C('CLASS');?>" >
            <br style="margin-top:10px;">
             
   </form>                
                                                        </li>
<!--第三块结束-->
<!--第四块开始-->
<li>
                                                            <img alt="邮件服务" class="avatar" src="/mcake/Public/Index/images/favicon.png">
                                                            <div class="message_date">
                                                                <h3 class="date text-info">MCAKE</h3>
                                                                <p class="month">Shanghai</p>
                                                            </div>
                                                            
                                         <label for="fullname" class=""><h2>邮件服务配置* :</h2></label><br/>
            <i class="fa fa-cog">Host邮件主机&nbsp;:&nbsp;</i><input type="text" required="" name="Host" id="inputSuccess4" class="Host form-control has-feedback-left"data-parsley-id="9619"value="<?php echo C('Host');?>" >
            <br style="margin-top:10px;">
            <i class="fa fa-cog">Port发送邮件端口&nbsp;:&nbsp;</i><input type="text" required="" name="Port" id="inputSuccess4" class="Port form-control has-feedback-left" data-parsley-id="9619" value="<?php echo C('Port');?>" >
            <br style="margin-top:10px;">
            <i class="fa fa-cog">username邮箱名&nbsp;:&nbsp;</i><input type="text" required="" name="username" id="inputSuccess4" class="form-control has-feedback-left username"data-parsley-id="9619"value="<?php echo C('username');?>">
            <br style="margin-top:10px;">
            <i class="fa fa-cog">mailname邮件主题&nbsp;:&nbsp;</i><input type="text" required="" name="mailname" id="inputSuccess4" class="mailname form-control has-feedback-left" data-parsley-id="9619"value="<?php echo C('mailname');?>">
            <br style="margin-top:10px;">
            <i class="fa fa-cog">mailpwd邮件密码&nbsp;:&nbsp;</i><input type="text" required="" name="mailpwd" id="inputSuccess4" class="form-control has-feedback-left mailpwd" data-parsley-id="9619"value="<?php echo C('mailpwd');?>">
            <br style="margin-top:10px;">
            <i class="fa fa-cog">mailtitle邮件标题&nbsp;:&nbsp;</i><input type="text" required="" name="mailtitle" id="inputSuccess4" class="mailtitle form-control has-feedback-left"data-parsley-id="9619"value="<?php echo C('mailtitle');?>">
            <br style="margin-top:14px;">

            <!--ajax修改 数据库配置-->
          
            <script type="text/javascript">
          $(function(){
            $('.MESG_URL').blur(function(){
                var database=$('.MESG_URL').val();
                $.post('/mcake/index.php/Admin/Webconfig/update',{MESG_URL:database},function(){alert('修改成功!');console.log(data);});
            });
            $('.WEB').blur(function(){
                var database=$('.WEB').val();
                $.post('/mcake/index.php/Admin/Webconfig/update',{WEB:database},function(){alert('修改成功!');console.log(data);});
           });
             $('.CODE').blur(function(){
                var database=$('.CODE').val();
                $.post('/mcake/index.php/Admin/Webconfig/update',{CODE:database},function(){alert('修改成功!');console.log(data);});
           });
            $('.NEW_RULE').blur(function(){
                var database=$('.NEW_RULE').val();
                $.post('/mcake/index.php/Admin/Webconfig/update',{NEW_RULE:database},function(){alert('修改成功!');console.log(data);});
          });
            $('.Host').blur(function(){
                var database=$('.Host').val();
                $.post('/mcake/index.php/Admin/Webconfig/update',{Host:database},function(){alert('修改成功!');console.log(data);});
            });
           
            $('.Port').blur(function(){
                var database=$('.Port').val();
                $.post('/mcake/index.php/Admin/Webconfig/update',{Port:database},function(){alert('修改成功!');console.log(data);});
            });
            $('.username').blur(function(){
                var database=$('.username').val();
                $.post('/mcake/index.php/Admin/Webconfig/update',{username:database},function(){alert('修改成功!');console.log(data);});
            });
            $('.mailname').blur(function(){
                var database=$('.mailname').val();
                $.post('/mcake/index.php/Admin/Webconfig/update',{mailname:database},function(){alert('修改成功!');console.log(data);});
            });
            $('.mailpwd').blur(function(){
                var database=$('.mailpwd').val();
                $.post('/mcake/index.php/Admin/Webconfig/update',{mailpwd:database},function(){alert('修改成功!');console.log(data);});
            });
            $('.mailtitle').blur(function(){
                var database=$('.mailtitle').val();
                $.post('/mcake/index.php/Admin/Webconfig/update',{mailtitle:database},function(){alert('修改成功!');console.log(data);});
            });
            $('.COMPANY').blur(function(){
                var database=$('.COMPANY').val();
                $.post('/mcake/index.php/Admin/Webconfig/update',{COMPANY:database},function(){alert('修改成功!');console.log(data);});
            });
            $('.ICP').blur(function(){
                var database=$('.ICP').val();
                $.post('/mcake/index.php/Admin/Webconfig/update',{ICP:database},function(){alert('修改成功!');console.log(data);});
            });
            $('.HTTPURL').blur(function(){
                var database=$('.HTTPURL').val();
                $.post('/mcake/index.php/Admin/Webconfig/update',{HTTPURL:database},function(){alert('修改成功!');console.log(data);});
            });
            $('.COMPANYDES').blur(function(){
                var database=$('.COMPANYDES').val();
                $.post('/mcake/index.php/Admin/Webconfig/update',{COMPANYDES:database},function(){alert('修改成功!');console.log(data);});
            });
        });
            </script>
            <!--修改完成-->   
                                                        </li>
<!--第四块结束-->
                                          </ul>
                                                    <!-- end recent activity -->

                                                </div>
                                                <div aria-labelledby="profile-tab" id="tab_content2" class="tab-pane fade" role="tabpanel">

                                                    <!-- start user projects -->
                                                    <table class="data table table-striped no-margin">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>实时统计<br>(real-time)</th>
                                                                <th>分类</th>
                                                                <th class="hidden-phone">当前销售量</th>
                                                                <th>评论数量</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>1</td>
                                                                <td>商品总数量</td>
                                                                <td>拿破仑4096层</td>
                                                                <td class="hidden-phone">18</td>
                                                                <td class="vertical-align-mid">
                                                                    <div class="progress">
                                                                        <div data-transitiongoal="35" class="progress-bar progress-bar-success" style="width: 35%;" aria-valuenow="35"></div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>2</td>
                                                                <td>当前新订单</td>
                                                                <td>未处理</td>
                                                                <td class="hidden-phone">13</td>
                                                                <td class="vertical-align-mid">
                                                                    <div class="progress">
                                                                        <div data-transitiongoal="15" class="progress-bar progress-bar-danger" style="width: 15%;" aria-valuenow="15"></div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>3</td>
                                                                <td>当前待发货数量</td>
                                                                <td>状态已出发货单待发货</td>
                                                                <td class="hidden-phone">30</td>
                                                                <td class="vertical-align-mid">
                                                                    <div class="progress">
                                                                        <div data-transitiongoal="45" class="progress-bar progress-bar-success" style="width: 45%;" aria-valuenow="45"></div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>4</td>
                                                                <td>当前会员总数</td>
                                                                <td>新会员</td>
                                                                <td class="hidden-phone">28</td>
                                                                <td class="vertical-align-mid">
                                                                    <div class="progress">
                                                                        <div data-transitiongoal="75" class="progress-bar progress-bar-success" style="width: 75%;" aria-valuenow="75"></div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <!-- end user projects -->

                                                </div>
                                                <div aria-labelledby="profile-tab" id="tab_content3" class="tab-pane fade" role="tabpanel">
                                                    <p style="font-size:"14px;>
“M'CAKE”是法国百年品牌“马克西姆”为全球美食者打造的专属蛋糕品牌，目前服务上海、杭州、苏州三大城市，自主研发了24款主打蛋糕，尤其是Mcake的4096层的拿破仑酥皮系列蛋糕，颇受消费者喜爱。

中文名
    马克西姆 
外文名
    MCAKE 

创立时间
    1893年 
经营公司
    上海麦心食品有限公司  </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                                                    
                            </div>  
                            <!--插入一个信息遮罩层 用于修改 网站所属信息-->
                           
    <div id="cardetail" style="display:None;width:100%;height:100%;position:absolute;background:rgba(100,100,100,0.5);z-index:1001;">
            <!--关闭遮罩层-->
<div style="border-radius:4px;width:270px;height:350px;position:absolute;background:white;z-index:1001;border:boxshadow:5px;margin-right:20px;margin-top:10%;margin-left:40%;">
       <span class="off" style="position:relative;font-size:20px; color:black;float:right;margin-right:10px;margin-top:10px;">X
            </span>
            <ul>
            <label for="fullname" class=""><h2>网站经营信息修改</h2> </label><br/>
             <i class="fa fa-cog btn btn-info">公司名&nbsp;:&nbsp;</i><input type="text" required="" name="COMPANY" class="COMPANY" id="full" data-parsley-id="9619" value="<?php echo C('COMPANY');?>" >
            <br style="margin-top:10px;">
            <i class="fa fa-cog btn btn-info">ICP备案&nbsp;:&nbsp;</i><input type="text" required="" name="ICP" class="ICP" data-parsley-id="9619" value="<?php echo C('ICP');?>" >
            <br style="margin-top:10px;">
            <i class="fa fa-cog btn btn-info">网站地址&nbsp;:&nbsp;</i><input type="text" required="" name="HTTPURL" class="HTTPURL" data-parsley-id="9619"value="<?php echo C('HTTPURL');?>" >
            <br style="margin-top:10px;">
            <i class="fa fa-cog btn btn-info">公司简介&nbsp;:&nbsp;</i><input type="text" required="" name="COMPANYDES" class="COMPANYDES" data-parsley-id="9619" value="<?php echo C('COMPANYDES');?>" >
            <br style="margin-top:10px;"><br>
            <button class="btn btn-round btn-success off fsh" type="button">确定修改</button>
            </ul>
</div>         
    </div>
    <script type="text/javascript">
    window.onload=function(){
        $('.xa').click(function(){
            $('#cardetail').css('display','block');
        });
        $('.off').click(function(){
            $('.off').hover(function(){
                $('.off').css('course','pointer');
            });
            $('#cardetail').css('display','none');
            $('.fsh').click(function(){
                window.location.reload();
            });
        });
    };
    </script>

                                    <!--修改结束-->
<!--网站所属信息修改弹出层-->
               
<!--网站信息所属修改弹出层结束-->
<!--xa 与xb只能显示一个show hidden-->


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