<? if(!defined('SITE_ROOT')) exit('Access Denied');?>
<? if ($garage !== 'garage') { ?>
<div class="footer" id="wei">
<div id="cen_right_top">
        <span id ="links" class="active">友情链接</span>
        <span id="cooperative" class="">合作伙伴</span>
        
	<div id="links-content-div" style="display:block">
        <? foreach((array)$linklist as $k=>$v) {?>
            <? if ($v[url_type]==1) { ?>
                <a href="<?=$v[url]?>" title="<?=$v[memo]?>" displaying="ok" target="view_window" class="youlian" <? if ($v[nofollow]==1) { ?> rel="nofollow" <? } ?>><?=$v[title]?></a>
            <? } ?>
        <?}?>
    </div>
	<div id="cooperative-content-div">
            <? foreach((array)$linklist as $k=>$v) {?>
                <? if ($v[url_type]==2) { ?>
                    <a href="<?=$v[url]?>" title="<?=$v[memo]?>" displaying="ok" target="view_window"  class="hezuo" <? if ($v[nofollow]==1) { ?> rel="nofollow" <? } ?>><?=$v[title]?></a>
                <? } ?>
            <?}?>
	</div>
	
</div>
</div>
<? } else { ?>
<!--//右边浮动-->
<div class="right_bl" style="display: none;">
    <ul class="bl_weixin_ul" style="float:left; display:none;">
        <li class="bl_weixin"><a href="javascript:void(0);"><img class="bl_close" src="http://img2.bingocar.cn/images/bl_close.jpg" /></a></li>
    </ul>
    <ul style="width:62px; float:left">
        <li class="b1_fhdb"><a href="javascript:void(0);"></a></li>
    </ul>
</div>
<!--//右边浮动-->
<? } ?>
<div class="banquan">
<div class="yllx">友情链接请联系: QQ 171479684 &nbsp;&nbsp;&nbsp;&nbsp;商务合作：caotingting#connect.com.cn（将"#"替换为"@"）</div>
京ICP备:05067646&nbsp;&nbsp;|&nbsp;&nbsp;京公网安备:1101055366&nbsp;&nbsp;|&nbsp;&nbsp;Copyright&copy; 2005-2015&nbsp;&nbsp;|&nbsp;&nbsp;www.cheping.com.cn,All Rights Reserved&nbsp;&nbsp;ams车评网&nbsp;&nbsp;版权所有
</div>
    
    
    
<!--登陆弹框-->
<!--<div class="denglu">
<div class="theme-popover">
<div class="theme-poptit">
<br /><a href="javascript:;" title="关闭" class="close">×</a>
</div>

<div class="tc_denglu"><font style="font-size:24px;">登陆</font>&nbsp;&nbsp;&nbsp;&nbsp;未注册账号，请 <a href="/register.php" target="_blank" >注册</a></div>
<hr>
<div class="fanweik">

    <p>用户名/手机号</p>
	<p><input type="text" id="ajax_name" name="name" /></p>
	<p>密码</p>
	<p><input type="password" id="ajax_password" name="password"/></p>
	<div class="jizhu"><input name="type" id="ajax_type" type="checkbox" value=""/>&nbsp;下次自动登录</div>
	<div  class="wangji_1"><a href="/login.php?action=getpassword">忘记密码？</a></div>
	<div class="dl_anniu_1">
            <a href="javascript:void(0)" onclick="ajaxlogin()"><img src="/images/denglu.jpg"></a>
	  </div>
	  <div class="cuowu_1" id="ajax_show" style="display:none;">您输入的用户名/密码有误</div>
</div>-->
<!--<hr>
<div class="fanweik1">
    <div class="zh_xz">其他账户登录</div>
	  <div class="zh_1"><a href="#"><img src="/images/qq.jpg"></a></div>
	  <div class="zhz_1"><a href="#">腾讯QQ</a></div>
	  <div class="zh1_1"><a href="#"><img src="/images/xl.jpg"></a></div>
	  <div class="zhz1_1"><a href="#">新浪微博</a></div>
	  <div class="zh2_1"><a href="#"><img src="/images/tx.jpg"></a></div>
	  <div class="zhz2_1"><a href="#">腾讯微博</a></div>
</div>-->
<!--</div>-->
<!--</div>-->
<!--<div class="theme-popover-mask"></div>-->
<!--弹框结束-->	
<script>
//(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
//            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
//            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
//            })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
//            ga('create', 'UA-65271533-1', 'auto');
//            ga('send', 'pageview');
//            
//var _hmt = _hmt || [];
(function() {
  var hm = document.createElement("script");
  hm.src = "//hm.baidu.com/hm.js?dc8e773ec8ea678079073eb92e8dbe92";
  var s = document.getElementsByTagName("script")[0]; 
  s.parentNode.insertBefore(hm, s);
})();

</script>
<script type="text/javascript">
    
    $(function(){
        //选项卡
         var oTab=document.getElementById("cen_right_top");
         if(oTab){
            var aH3=oTab.getElementsByTagName("span");
            var aDiv=oTab.getElementsByTagName("div");
            for(var i=0;i<aH3.length;i++)
            {
                    aH3[i].index=i;
                    aH3[i].onmouseover=function()
                    {
                            for(var i=0;i<aH3.length;i++)
                            {
                                    aH3[i].className="";
                                    aDiv[i].style.display="none";
                            }
                            this.className="active";
                            aDiv[this.index].style.display="block";
                    }
            }
         }    
        //定义在选项卡内没有内容时，不显示
        var youlian_display = $('.youlian').attr('displaying');
        if(!youlian_display){
            $('#links').hide();
            $('#links-content-div').hide();
            $('#cooperative').attr('class','active');
            $('#cooperative-content-div').show();
        }else{
            $('#links').show();
        }
        var hezuo_display = $('.hezuo').attr('displaying');
        if(!hezuo_display){
            $('#cooperative').hide();
        }else{
             $('#cooperative').show();
        }
    })

</script>
</body>
</html>