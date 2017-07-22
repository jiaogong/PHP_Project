<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Gentallela Alela! | </title>

    <!-- Bootstrap core CSS -->

    <link href="/mcake/Public/Admin/production/css/bootstrap.min.css" rel="stylesheet">

    <link href="/mcake/Public/Admin/production/fonts/css/font-awesome.min.css" rel="stylesheet">
    <link href="/mcake/Public/Admin/production/css/animate.min.css" rel="stylesheet">

    <!-- Custom styling plus plugins -->
    <link href="/mcake/Public/Admin/production/css/custom.css" rel="stylesheet">
    <link href="/mcake/Public/Admin/production/css/icheck/flat/green.css" rel="stylesheet">


    <script src="/mcake/Public/Admin/production/js/jquery.min.js"></script>
    <style type="text/css">
    .vcode{display:none;}
    </style>

</head>

<body style="background:#F7F7F7;">
    
    <div class="">
        <a class="hiddenanchor" id="toregister"></a>
        <a class="hiddenanchor" id="tologin"></a>

        <div id="wrapper">
            <div id="login" class="animate form">
                <section class="login_content">
                    <form action="<?php echo U('Admin/Login/dologin');?>" method="post" class="denglu">
                        <h1>网站后台登陆</h1>
                        <div>
                            <input type="text" name="ausername" class="form-control" placeholder="用户名" required="" />
                        </div>
                        <div>
                            <input type="password" name="apass" class="form-control" placeholder="密码" required="" />
                        </div>
                        <div>
                            <img src="<?php echo U('Admin/Public/vcode');?>" name="vcode" style="display:none" alt="" />
                            <input type="text" name="vcode" class="form-control" placeholder="验证码" required="" /><span></span>
                        </div>
                        <div>
                            <button class="btn btn-default submit" href="">登陆</button>
                            <button class="btn btn-default reset" href="">重置</button>
                        </div>
                        <div class="clearfix"></div>
                        <div class="separator">
                            <div class="clearfix"></div>
                            <br />
                            <div>
                                <h1><i class="fa fa-birthday-cake" style="font-size: 26px;margin-right:15px;"></i> M.cake</h1>

                                <p>©2015 All Rights Reserved. Gentelella Alela! is a Bootstrap 3 template. Privacy and Terms</p>
                            </div>
                        </div>
                    </form>
                    <!-- form -->
                </section>
                <!-- content -->
            </div>
        </div>
    </div>
    <script type="text/javascript">
        var R = false;
        $('input[name=vcode]').focus(function() {
            $('img[name=vcode]').css('display',"block");
        });

        $('img[name=vcode]').click(function() {
            this.src = this.src+'?b';
        });
        
    </script>
</body>

</html>