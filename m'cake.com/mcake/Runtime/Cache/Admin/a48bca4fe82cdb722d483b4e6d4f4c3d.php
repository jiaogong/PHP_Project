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
        <h3>BANNER管理</h3>
    </div>
</div>

<div style="height:600px;" class="x_panel">
    <div class="x_title">
        <h2>请合理使用每一个广告位：</h2>
        <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
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
            <li><a class="close-link"><i class="fa fa-close"></i></a>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
    
    <div class="x_content">
        <div class="row">
        
            <div class="col-md-12">

    <!-- price element -->
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="pricing">
            <div class="title">
                <h2><strong>广告位</strong></h2>
                <h1>ONE</h1>
                <span>Free</span>
            </div>
            <div class="x_content">

                <form action="<?php echo U('Admin/Banner/update');?>" method="post" enctype="multipart/form-data"><input type="hidden" name="id" value="1">

                <div class="">
                    <div class="pricing_features">
                                                       
                        <input type="text" name="theme" placeholder="主标题:20字以内" class="form-control col-md-7 col-xs-12" required="required" id="first-name" data-parsley-id="4702" style="margin-bottom:30px;width:100%;margin-top:10px">
                                                            
                        <input type="text" name="subhead" placeholder="副标题:35字以内" class="form-control col-md-7 col-xs-12" required="required" id="first-name" data-parsley-id="4702" style="margin-bottom:30px;width:100%">
                                                            
                        <input type="text" name="link" placeholder="广告链接" class="form-control col-md-7 col-xs-12" required="required" id="first-name" data-parsley-id="4702" style="margin-bottom:30px;width:100%">
                             
                        <input type="text" placeholder="广告图片617*328" id="f_file" style="width:105px;height:33px;margin-right:10px;margin-bottom:20px"><input type="button" value="浏览..." onClick="t_file.click()">
                        <input name="img" type="file" id="t_file" onchange="f_file.value=this.value" style="display:none">

                    </div>
                </div>
                <div class="pricing_footer">
                    <button class="btn btn-success btn-block" type="submit">发布广告</button>
                    <p>
                        <a href="" onclick="one.click();return false;">重置</a>
                        <input id="one" type="reset" style="display:none">
                    </p>
                </div>
                </form>
            </div>
        </div>
    </div>   
    <!-- price element -->

    <!-- price element -->
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="pricing">
            <div class="title">
                <h2><strong>广告位</strong></h2>
                <h1>TWO</h1>
                <span>Free</span>
            </div>
            <div class="x_content">
                <form action="<?php echo U('Admin/Banner/update');?>" method="post" enctype="multipart/form-data"><input type="hidden" name="id" value="2">
                <div class="">
                    <div class="pricing_features">
                               
                        <input type="text" name="theme" placeholder="主标题:20字以内" class="form-control col-md-7 col-xs-12" required="required" id="first-name" data-parsley-id="4702" style="margin-bottom:30px;width:100%;margin-top:10px">
                                                            
                        <input type="text" name="subhead" placeholder="副标题:35字以内" class="form-control col-md-7 col-xs-12" required="required" id="first-name" data-parsley-id="4702" style="margin-bottom:30px;width:100%">
                                                            
                        <input type="text" name="link" placeholder="广告链接" class="form-control col-md-7 col-xs-12" required="required" id="first-name" data-parsley-id="4702" style="margin-bottom:30px;width:100%">
                             
                        <input type="text" placeholder="广告图片617*328" id="f_file" style="width:105px;height:33px;margin-right:10px;margin-bottom:20px"><input type="button" value="浏览..." onClick="t_file.click()">
                        <input name="img" type="file" id="t_file" onchange="f_file.value=this.value" style="display:none">

                    </div>
                </div>
                <div class="pricing_footer">
                    <button class="btn btn-success btn-block" type="submit">发布广告</button>
                    <p>
                        <a href="" onclick="two.click();return false;">重置</a>
                        <input id="two" type="reset" style="display:none">
                    </p>
                </div>
                </form>
            </div>
        </div>
    </div>   
    <!-- price element -->

    <!-- price element -->
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="pricing">
            <div class="title">
                <h2><strong>广告位</strong></h2>
                <h1>THREE</h1>
                <span>Free</span>
            </div>
            <div class="x_content">
                <form action="<?php echo U('Admin/Banner/update');?>" method="post" enctype="multipart/form-data"><input type="hidden" name="id" value="3">
                <div class="">
                    <div class="pricing_features">
                               
                        <input type="text" name="theme" placeholder="主标题:20字以内" class="form-control col-md-7 col-xs-12" required="required" id="first-name" data-parsley-id="4702" style="margin-bottom:30px;width:100%;margin-top:10px">
                                                            
                        <input type="text" name="subhead" placeholder="副标题:35字以内" class="form-control col-md-7 col-xs-12" required="required" id="first-name" data-parsley-id="4702" style="margin-bottom:30px;width:100%">
                                                            
                        <input type="text" name="link" placeholder="广告链接" class="form-control col-md-7 col-xs-12" required="required" id="first-name" data-parsley-id="4702" style="margin-bottom:30px;width:100%">
                             
                        <input type="text" placeholder="广告图片617*328" id="f_file" style="width:105px;height:33px;margin-right:10px;margin-bottom:20px"><input type="button" value="浏览..." onClick="t_file.click()">
                        <input name="img" type="file" id="t_file" onchange="f_file.value=this.value" style="display:none">
                             
                    </div>
                </div>
                <div class="pricing_footer">
                    <button class="btn btn-success btn-block" type="submit">发布广告</button>
                    <p>
                        <a href="" onclick="three.click();return false;">重置</a>
                        <input id="three" type="reset" style="display:none">
                    </p>
                </div>
                </form>
            </div>
        </div>
    </div>   
    <!-- price element -->

    <!-- price element -->
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="pricing ui-ribbon-container">
            <div class="ui-ribbon-wrapper">
                <div class="ui-ribbon">
                    100% Off
                </div>
            </div>
            <div class="title">
                <h2><strong>全景底图</strong></h2>
                <h1>FOUR</h1>
            </div>
            <div class="x_content">
                <form action="<?php echo U('Admin/Banner/update');?>" method="post" enctype="multipart/form-data"><input type="hidden" name="id" value="0">
                <div class="">
                    <div class="pricing_features">

                        <input type="text" placeholder="全景图片2064*427" id="f_file" style="width:105px;height:33px;margin-right:10px;margin-bottom:118px;margin-top:104px"><input type="button" value="浏览..." onClick="t_file.click()">
                        <input name="img" type="file" id="t_file" onchange="f_file.value=this.value" style="display:none">

                    </div>
                </div>
                <div class="pricing_footer">
                    <button class="btn btn-success btn-block" type="submit">提交设置</button>
                    <p>
                        <a href="" onclick="four.click();return false;">重置</a>
                        <input id="four" type="reset" style="display:none">
                    </p>
                </div>
                </form>
            </div>
        </div>
    </div>   
    <!-- price element -->

</div>
        
        </div>
    </div>
    
</div>

<script type="text/javascript">
    //设置检测变量
    var t=false;
    var s=false;
    var i=false;
    //主标题绑定失去焦点事件
    $('input[name=theme]').blur(function(){
       //获取主标题文本框的值
       var text=$(this).val();
       //判断输入字数
       if(text.length>20){
           alert('请精简至20字以内!');
           $(this).css('color','red');
       }else{
           i=true;
       }
       $(this).focus(function(){
           $(this).css('color','#73879c');
       })
    })
    //副标题绑定失去焦点事件
    $('input[name=subhead]').blur(function(){
        //获取副标题文本框的值
        var text=$(this).val();
        //判断输入字数
        if(text.length>35){
            alert('请精简至35字以内!');
            $(this).css('color','red');
        }else{
            s=true;
        }
        $(this).focus(function(){
            $(this).css('color','#73879c');
        })
    })

    //上图片框绑定失去焦点事件
    //$('input[name=uploadImg]').blur(function(){
        //发送ajax请求获取服务器图片路径
        // $.ajax({
        //     type:'psot',
        //     url:<?php echo U('Admin/Banner/find');?>,
        //     data:{name:id},
        //     async:false,
        //     success:function(data){
        //         if(data==0){

        //         }
        //     }
        // })

    //             var file = $(this).val();
    //             if(!/.(gif|jpg|jpeg|png|GIF|JPG|png)$/.test(file)){
    //                 alert("图片类型必须是.gif,jpeg,jpg,png中的一种"); 
    //                 return false;
    //             }else{
    //                 var image = new Image(); 
    //                 image.src = file; 
    //                 console.log(image);//die;
    //                 var height = image.height; 
    //                 var width = image.width; 
    //                 var filesize = image.filesize;  
    //                 alert(height+"X"+filesize); 
    //                 if(width>617 && height>328 && filesize>409600){ 
    //                     alert('请上传617*328像素 或者大小小于400k的图片');  
    //                     return false; 
    //                     }
    //             } 
    //                 alert("图片通过");
    // })

    //表单绑定提交事件
    // $('form').submit(function(){
    //     //程序内触发事件
    //     $('input[name=theme]').trigger('blur');
    //     $('input[name=subhead]').trigger('blur');
    //     $('input[name=img]').trigger('blur');
    //     //判断
    //     if(t && s){
    //         return true;
    //     }else{
    //         return false;
    //     }
    // })
</script>




<!-- <script type="text/javascript" src="/mcake/Public/Admin/production/js/parsley/parsley.min.js"></script> -->
        
       

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