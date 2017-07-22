<? if(!defined('SITE_ROOT')) exit('Access Denied');?>
<div class="banquan" style="background-color:#141414; width:100%;height:auto; color:#999; text-align:center; padding-top:30px;padding-bottom:30px; font-size:14px;">
京ICP备:05067646&nbsp;&nbsp;|&nbsp;&nbsp;京公网安备:1101055366&nbsp;&nbsp;|&nbsp;&nbsp;Copyright&copy; 2005-2015&nbsp;&nbsp;|&nbsp;&nbsp;www.cheping.com.cn,All Rights Reserved&nbsp;&nbsp;ams车评网&nbsp;&nbsp;版权所有
</div>
<script type="text/javascript">
    //版权定位
    $(function(){
        var banquan = $('.banquan').offset().top;
        var pingmu = $(window).height();
        var wendang = $(document).height();
        pingmu = parseInt(pingmu);
        wendang = parseInt(wendang);
        var position;
        if(pingmu>wendang){
            position = pingmu-banquan-80;
        }else{
            position = wendang-banquan;
        }
        position = parseInt(position)+"px";
        $('.banquan').before('<div style="width:100%;height:'+position+';"></div>');
    })
</script>
</body>
</html>