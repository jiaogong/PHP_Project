<? if(!defined('SITE_ROOT')) exit('Access Denied');?>
<? include $this->gettpl('header');?>
<? if (!$loginUser) { ?>
<div class="warp_login">
    <div class="content_login" style="height:335px;overflow: hidden;">
        <div class="login_left">
            <img src="images/login_logo.gif"/>
        </div>
        <form name="adminform" id="adminform" style="margin: 0;" action="<?=$admin_path?>index.php?action=login-checklogin&ref=<? echo $_SERVER['HTTP_REFERER']; ?>" method="post">
            <div class="login_right">
                <div class="login_right_top"><font>登录</font></div>
                <div class="xian"></div>
                <div class="login_right_bottom">
                    <ul>
                        <li><font>用户名:</font><input type="text" name="username" id="username"/></li>
                        <li><font>密&nbsp;&nbsp;码:</font><input type="password" name="password" id="password"/></li>
                        <li><input class="login_sumbit" type="submit"  name="submit" value="登&nbsp;&nbsp;&nbsp;&nbsp;录" style="width:130px; height:35px; line-height:33px;margin-left: 130px;" /></li>
         
                    </ul>
                </div>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $('form#adminform').submit(function () {
            var status = false;
            $.post(
                    //'index.php?action=rchecklogin&username='+$('#username').val(), 
                    'index.php?action=login-rchecklogin',
                    {username: $('#username').val(), password: $('#password').val()},
            function (ret) {
                if (parseInt(ret) == "1") {
                    location.reload();
                    status = true;
                } else {
                    alert('用户名或密码错误，请重试！');
                }
            }
            );
            return status;
        });
    })
</script>
<? } else { ?>
<div class="topmainda" target="_paren">
    <div class="topnav">
        <div class="topnav-main">
            <div class="topnav-main-left fl"><span class="date"></span></div>
            <div class="topnav-main-right fr">
                <span class="pinyin"><?=$loginUser?>!</span>
                <span class="lian"><a href="?action=login-logout">退出</a></span>
            </div>
            <div class="clear"></div>
        </div>  
    </div> 
    <div class="top-baikuai"></div>
    <div class="top-logo">
        <div class="top-logoo">
            <span><img src="images/logo.jpg" /></span>
        </div>
    </div>
</div>
<div class="main_s" style="width:1300px;">
    <iframe id="leftfrm" src="index.php?action=login-showleft" target="pageFrame" scrolling="auto" width="262" height="700" frameborder="0" marginwidth="10" style="float:left; border:1px solid #ccc; border-radius:6px; -webkit-border-radius:6px; -moz-border-radius:6px; background:#FFF;">
    </iframe>
    <div class="right_r" style="">
        <iframe id="rightfrm" src="blank.html" name="pageFrame" scrolling="auto" width="1020px" height="700" frameborder="0" align="center" style=" float:right; border-left:1px solid #cdcdcd; background:#fff;"></iframe>
    </div>
    <div class="clear"></div>
</div>
<div class="footer"></div>
<form name='module' id="module">
    <!--以下是每一个模块传过来标示变量-->
    <input type=hidden name="module_id" id="module_id" value=0>
    <input type=hidden name="cardb_type_name" id="cardb_type_name" value="-1">
    <input type=hidden name="cur_id" id="cur_id" value="-1">
    <!--模块标示变量结束-->
</form>
<script type="text/javascript" src="<?=$admin_path?>js/chinese_date.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        var today = new Date();
        var str = GetLunarDateString(today);
        $('span.date').html("今天是：" + today.getFullYear() + "年" + (today.getMonth() + 1) + "月" + today.getDate() + "日 " + d[today.getDay() + 1] + " 农历：" + str.substr(3, 6));
        var w = $(document).width();
        var h = $(document).height();
        $('.top,.main,.footer').width(w);
        $('.right').width(w - 240);
    });
</script>
<? } ?>
</body>
</html>
