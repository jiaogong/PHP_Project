<? if(!defined('SITE_ROOT')) exit('Access Denied');?>
<? include $this->gettpl('index_header');?>

<script>
    
    function plogin(){
        $('.theme-popover-mask').fadeIn(100);
        $('.theme-popover').slideDown(200);
    }
    
    function ajaxlogin(){
       var name = $("#ajax_name").val();
       var pd = $("#ajax_password").val();
       var type = $("#ajax_type").val();

       if(name||pd){
           $("#ajax_show").hide();
             $.post("/login.php?action=ajaxlogin",{"name":name,"password":pd,"type":type},function(msg){
                 if(msg==-4){
                     $("#ajax_show").show();
                 }else{
                     $("#user_id").val(msg);
                     $('.theme-popover-mask').fadeOut(100);
		     $('.theme-popover').slideUp(200);
                     $("#ajax_show").hide();
                     window.location.reload();
                     document.getElementById('iframepage').contentWindow.clogin(msg);
                      
                 }
            })
       }else{
            $("#ajax_show").show();
            
       }
     
    }
    
    //评论框获取焦点
    function reviewfoucs(){
        document.getElementById('iframepage').contentWindow.reviewfocus();
    }
    
     $(function() { 
         var header_title1 = $("#header_title1").html();
         $("#header_title").html(header_title1);

         $('.theme-poptit .close').click(function(){
		$('.theme-popover-mask').fadeOut(100);
		$('.theme-popover').slideUp(200);
	})
        
        var id =  $("#yl_article_id").val();
        $.get("/collect.php?action=show",{"article_id":id,"type":1,type_id:2},function(msg){
               var  arr = eval('(' + msg + ')');
               if(arr['state']==1){
                   $("#collect_state").addClass("left1_dl").removeClass("left1");
               }else{
                  $("#collect_state").addClass("left1").removeClass("left1_dl");
               }

               $("#collect_num").html(arr['num']);

           })
           
           var aid = $("#yl_article_id").val();
           
//           $("#num_span > span").css({ 'background-image': "none", 'margin-left': "4px", 'margin-top':"-18px" });
//           $(".jiathis_bubble_style").css({ 'background-image': "none", 'margin-left': "4px", 'margin-top':"-18px" });
            $(".left3").mouseover(function(){
                $("#fenxiang").attr("src","/images/left3_hg.jpg")
                $("#jiathis_counter_"+aid).css("color","#fff");
            })
             $(".left3").mouseout(function(){
                $("#fenxiang").attr("src","/images/left3.jpg")
                 $("#jiathis_counter_"+aid).css("color","#333");
            })
          var ua = navigator.userAgent.toLowerCase();
          if(ua.match(/MicroMessenger/i)=="micromessenger") {
              location.replace("http://m.cheping.com.cn/v/<?=$list[0][id]?>.html");
          }
     }); 
    function collect(i){
        var uid= $("#user_id").val();
    
        if(!uid){
            $('.theme-popover-mask').fadeIn(100);
            $('.theme-popover').slideDown(200);

        }else{
               $.get("/collect.php",{"article_id":i, type_id:2},function(msg){
                   var  arr = eval('(' + msg + ')');
                   if(arr['state']==1){
                       $("#collect_state").addClass("left1_dl").removeClass("left1");
                   }else if(arr['state']==-1){
                      $('.theme-popover-mask').fadeIn(100);
                      $('.theme-popover').slideDown(200);
                      $("#collect_state").addClass("left1").removeClass("left1_dl");
                   }else{
                      $("#collect_state").addClass("left1").removeClass("left1_dl");
                   }
   
                   $("#collect_num").html(arr['num']);
                  
               })
        }
     
    }
    var type_id = 2;
    
</script>
<style>
    .bq1{ background-color:#e41b14; height:30px;  margin:5px 10px 5px 0px; line-height:30px; color:#fff;}
</style>

<div class="wenzhang_main" style="margin-top: 100px;">
<div style="margin-top:5px; margin-left:0px; line-height: 25px; border-bottom: 1px solid #333;"><a href="/">车评首页</a> > <a href="video.php?action=Video&id=<?=$category['id']?>"><?=$category['category_name']?></a> > <a href="video.php?action=Video&id=<?=$category['id']?>&ids=<?=$lists['cacid']?>"><?=$lists['category_name']?></a> > <?=$list[0][title]?></div>

<!--<hr style=" margin-top:5px; margin-left:0px;">-->
<div class="con"> 

	<div id="d4" class="zongshu">
	  <div class="zongshu_right">
              
	   <!--#include virtual="/ssi/ssi_index_tag.shtml"-->
            <!--精品分类结束-->
       
	   <!--#include virtual="/ssi/ssi_index_video.shtml"-->
            <!--精彩视频结束-->
            
            <!--<div style="margin-top:10px;margin-left:2.5px;"><a href="/myurl.php?cname=myurl&c1=1&c2=1&c3=3" target="_blank"><img src="/images/guanggao.jpg" style="width:280px;height:280px"></a></div>-->
	   
	  </div>
	  <div class="zongshu_left">
              <? foreach((array)$list as $k=>$v) {?>
	    <div class="zongshu_njj" style="margin-top:-20px;">
                <div class="times" ><? echo date("Y-m-d",$v["uptime"]); ?></div>
                <!--<div class="sp_bt">--><h1 ><?=$v[title]?></h1><!--</div>-->
                
		   <iframe src="<?=$v[source]?>" width="880" height='620' style="margin-top:10px;" scrolling="no" frameborder="0"></iframe>
                   <? foreach((array)$v[series_name] as $key=>$val) {?>
		   <div class="chexingsp" style="color:red;"><?=$val['series_name']?></div>
                   <?}?>
		   <div class="spjieshao">视频介绍：</div>
		   <div class="shipinjieshao">
		        <?=$v['chief']?>
				<br />
				<br />
                                <? if ($v[relative_title]) { ?>
				相关视频：<a href="<?=$v[relative_url]?>"><?=$v[relative_title]?></a>
                                <? } ?>
		   </div>
		   <? foreach((array)$v[tag_name] as $keys=>$value) {?>
                   <span class="bq1" style="background-color:#efefef; float: left; margin-top: 20px;margin-left: 0px;"><a href="article.php?action=ActiveList&id=<?=$value['id']?>"style="color:#fff;"><div class="redf"></div>&nbsp;<font style="color:#000;"><?=$value['tag_name']?></font></a></span>
                   
                    <?}?>
		  
		   
		   <div class="bianji"></div>

		</div>
                <script>
                    (function() {
                        var bct = document.createElement("script");
                        bct.src = "/js/counter.php?cname=video&c1=<?=$v[parentid]?>&c2=<?=$v[cacid]?>&c3=<?=$v[id]?>";
                        bct.src += "&df="+document.referrer;
                        document.getElementsByTagName('head')[0].appendChild(bct);
                    })();
                </script>
              <?}?>
              <input id='yl_article_id' type='hidden' value="<?=$lists['id']?>">
              <input id='user_id' type='hidden' value="<?=$uid?>">
<!-- 左右浮动-->	
              <div class="right_xuanfu">
		<a href="#tou" class="shang"></a>
                <a href="#review" class="zhong" onclick="reviewfoucs()"></a>
		<a href="#wei" class="xia"></a>
	</div>
<!-- 左右浮动-->	

<div class="left_xuanfu">
	      <a href="javascript:void(0)" onclick="collect(<?=$lists['id']?>)" class="left1" id="collect_state"><div class="shuzi" id="collect_num">0</div></a>
		  <a href="#review" class="left2"><div class="shuzi" id='review_num'>0</div></a>
          
                    <!-- JiaThis Button BEGIN -->
                    <div class="jiathis_style left3">
                    <a href="http://www.jiathis.com/share" class="jiathis jiathis_txt" target="_blank">
                        <img src="/images/left3.jpg" id='fenxiang' border="0" /></a>
                    <a class="jiathis_counter_style_margin shuzi" id='num_span'></a>
                    </div>
                    <script type="text/javascript" >
                    var jiathis_config={
                            summary:"",
                            shortUrl:false,
                            hideMore:false
                    }
                    </script>
                    <script type="text/javascript" src="http://v3.jiathis.com/code/jia.js" charset="utf-8"></script>
                    <!-- JiaThis Button END -->
	</div>
<div id='review' style="background-color:#F8F8F8;float: left;/*margin-left: -285px;*/height: auto;">
<iframe src="/review.php?action=list&type=1&article_id=<?=$lists['id']?>&type_id=2" width="880" height=100% marginheight="0" marginwidth="0" frameborder="0" scrolling="no" id="iframepage" name="iframepage" frameborder="0"  onLoad="iFrameHeight()"></iframe> 
</div>
<script type="text/javascript" language="javascript">
    function iFrameHeight() {
        var ifm= document.getElementById("iframepage");
        var subWeb = document.frames ? document.frames["iframepage"].document :
           ifm.contentDocument;
            if(ifm != null && subWeb != null) {
            ifm.height = subWeb.body.scrollHeight;
            }
            
         
     var userid = window.frames["iframepage"].document.getElementById('uid').value; 
      // var userid = document.getElementById('iframepage').contentWindow.document.getElementById('uid').value;
      
        if(!userid){
            $("#user_id").val(userid);
        }
    }
    
    function reviewnum(i){
        $("#review_num").val(i);
    }
</script> 
</div>
        </div>
</div>
	
</div>

</div>
<div class="clear"></div>
<? include $this->gettpl('article_footer');?>
