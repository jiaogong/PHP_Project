<? if(!defined('SITE_ROOT')) exit('Access Denied');?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=$page_title?></title>
<meta name="keywords" content="<?=$keywords?>" />
<meta name="description" content="<?=$description?>" /> 
<? if ($pic_num == 0) { ?>
<? } else { ?>
<style>
  .allview, .allcc{cursor: pointer;}
</style>
<? } ?>
<!--#include virtual="/ssi/article_header.shtml"-->
<script>
 $(document).ready(function(){
  $(".tanchu").slideToggle()
  $(".cha").click(function(){
  $(".tanchu").css({"display":"none"})
  $(".beijing").css({"display":"none"})
  })
   $(".tupian").mouseover(function(){
   $(".text",this).stop().animate({"top":0,})
 })
  $(".tupian").mouseout(function(){
   $(".text",this).stop().animate({"top":-52})
 })
  })
</script>
<!--content-->
<div class="wenzhang_main">
<a href="http://www.cheping.com.cn">车评首页</a> > <a href="/article.php?action=CarReview&id=<?=$p_category['id']?>" id="header_title1"><?=$p_category['category_name']?></a> > <a href="/article.php?action=CarReview&id=<?=$p_category['id']?>&ids=<?=$category['id']?>"><?=$category['category_name']?></a> > <?=$article['title']?>
<? if ($series['series_name']) { ?>
<div class="chepai"><img height="40px" width="40px" src="/attach/images/brand/<?=$brand_logo?>"></div>
<div class="chexi"><?=$series['series_name']?></div>
<? } ?>
<div class="tab" style="margin-top:-10px;">
</div>
<div class="con"> 
    <div id="d1" class="zongshu">
	  <div class="zongshu_right">
	   <? if ($videoseries) { ?>
           <div class="xgsp" style="margin-bottom: 15px;">
               <div class="xgsp_1"><a class="axg" href="javascript:void(0)" style="margin-left:5px;cursor:default;">相关视频<a class="agd" href="/video.php?action=Video&id=9" target="_blank">&raquo;</a></a></div>
		 <? foreach((array)$videoseries as $key=>$value) {?>
		  <div class="wz_list_sp">
	      <div class="wz_list_sp1"><a href="<?=$value['url']?>"><img src="/attach/<?=$value['pic']?>" width="139" height="92"></div>
		  <div class="wz_list_sm1"><a href="<?=$value['url']?>" style="font-size:14px;"><?=$value['title']?></a></div>
	      </div>
              <?}?>
		
	   </div>
           <? } ?>
	  <!--#include virtual="/ssi/ssi_page_article.shtml"-->
	   <div class="erweima">
	    <div class="erweima_nr">
		   <div class="erweima_tu"></div>
		   <div class="wenzi">
		      <p>车评网</p>
			  <p>官方微信公众号</p>
			  <p style="color:#fd0e0b;">amscheping</p>
			  <p style="font-size:16px; margin-top:5px; font-weight:bold;">专业车评天天看</p>
		   </div>
		</div>
            
	</div>
          <div style="margin-top:10px;margin-left:2.5px;"><a href="/myurl.php?cname=myurl&c1=1&c2=1&c3=2" target="_blank"><img src="/images/guanggao.jpg" style="width:280px;height:280px"></a></div>
	   
	  </div>
	  <div class="zongshu_left" style="background-color:#FFF;">
	    <div class="zongshu_njj">
		   <div class="biaoti">
                      <p style="font-size:28px;"><?=$article['title']?></p>
	              <p style="font-size:18px; margin-top:10px;"><?=$article['title2']?></p>
                      <div class="zongshu_xx">
                       <span class="XX_yi"><a href="http://www.cheping.com.cn">ams车评</a></span>
			  <span class="xx_jianjv">编辑：<?=$article['author']?></span>
			  <? if ($article['photor']) { ?><span class="xx_jianjv">摄影：<?=$article['photor']?></span>  <? } ?>
                          <span class="xx_jianjv">类型：<?=$category['category_name']?></span>
                          <span class="xx_jianjv"><font style="color:#989EAD"><? echo date("Y-m-d",$article['uptime']) ?>&nbsp;<? echo date("H:s",$h) ?></font></span>
		   </div>
                      <div class="daoy" style="line-height:20px;font-size:16px;margin-top:10px">
                        　　<?=$article['chief']?>
                      </div>
		   </div>
                    
                    <!--文章头图-->
			<div class="tupian" style="margin-top:20px;">
				<a <? if ($pic_num == 0) { ?>href="javascript:void(0);"<? } else { ?>href="<?=$news_domain?>articlepic.php?action=final&type_id=<?=$article['pic_org_id']?>" target="_blank"<? } ?>><img src="/attach/<?=$article['pic']?>" width="820" height="550"  alt="<?=$article['title']?>" class="Img"/></a>
				<div class="text">
					<div class="imgtext"><a <? if ($pic_num == 0) { ?>href="javascript:void(0);"<? } else { ?>href="<?=$news_domain?>articlepic.php?action=final&type_id=<?=$article['pic_org_id']?>" target="_blank"<? } ?>><img src="images/antm.png"></a></div>
				</div>
			</div>
			<!--文章头图结束-->
		   <!--相关文章-->
                <div style="width:820px; margin:0 auto; margin-top:-20px;">
		   <div class="zs_xinwen">
		   　　<?=$article['content']?>
		   </div>
                   <? foreach((array)$taglist as $k=>$v) {?>
                   <span class="bq1" style=" background-color: #EFEFEF;float: left;margin-top: 0px;"><a href="/article.php?action=ActiveList&id=<?=$v[id]?>" target="_blank"><div class="redf"></div><font style="float:left; margin-left:5px;"><?=$v[tag_name]?></font></a></span>
		   <?}?>
		   <div class="bianji" style="padding: 0 5px; margin-top: 10px;"><? if ($article['editor']) { ?>特约编辑：<?=$article['editor']?><? } else { ?>编辑：<?=$article['author']?><? } ?></div>
		   <!--相关文章-->
		</div>
            </div> 
              <!--评论-->
                <? if ($articleseries) { ?>
		<div class="xiangguan">
		    <div class="xiangguanzi">相关文章</div>
			<? foreach((array)$articleseries as $key=>$value) {?>
			<div class="xiangguan_list">
			  <div class="xg_tu">
			     <a href="<?=$value['url']?>"><img src="/attach/<?=$value['pic']?>" width="279" height="186" alt="<?=$value['title']?>"></a>
				 <div class="fanwei1"><?=$value['p_category_name']?></div>
				 <br />
				 <div class="xg_tu_zi"><a href="<?=$value['url']?>"><?=$value['title']?></a></div>
			  </div>
			</div>
			<?}?>
			
			
		   </div>
                <? } ?>
	  </div>
    
        
        
<div class="right_xuanfu">
		<a href="#tou" class="shang"></a>
                <a href="#review" class="zhong" onclick="reviewfoucs()"></a>
		<a href="#wei" class="xia"></a>
	</div>
<!-- 左右浮动-->	
<script>
    //评论框获取焦点
    function reviewfoucs(){
        document.getElementById('iframepage').contentWindow.reviewfocus();
    }
     $(function() { 
         var header_title1 = $("#header_title1").html();
         $("#header_title").html(header_title1);
         var numm = $('#numm').text();
         if(numm == 0){
            
         }else{
          $(".allview,.allcc").click(function(){
              var url = $("#allview_url").attr("href")
              window.open(url);
           })
         }  
         
        
        
         $('.theme-poptit .close').click(function(){
		$('.theme-popover-mask').fadeOut(100);
		$('.theme-popover').slideUp(200);
	})
        
        var id =  $("#yl_article_id").val();
        $.get("/collect.php?action=show",{"article_id":id,"type":1,type_id:1},function(msg){
               if(msg['state']==1){
                   $("#collect_state").addClass("left1_dl").removeClass("left1");
               }else{
                  $("#collect_state").addClass("left1").removeClass("left1_dl");
               }
               $("#collect_num").html(msg['num']);
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
     
     }); 
    function collect(i){
        var uid= $("#user_id").val();
    
        if(uid==0){
            $('.theme-popover-mask').fadeIn(100);
            $('.theme-popover').slideDown(200);

        }else{
               $.get("/collect.php",{"article_id":i, type_id:1},function(msg){
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
    var type_id = 1; 
    
</script>
	<div class="left_xuanfu">
	      <a href="javascript:void(0)" onclick="collect(<?=$article['id']?>)" class="left1" id="collect_state"><div class="shuzi" id="collect_num">0</div></a>
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

                    <a id='allview_url' href="<?=$news_domain?>articlepic.php?action=final&type_id=<?=$article['pic_org_id']?>" class="left4" target="_blank" ><div class="shuzi" id="numm"><?=$pic_num?></div></a>
		  
	</div>
    <div class="left_xuanfu1" style="display:none;">
	      <a href="#" class="left1_dl"></a>
		  <a href="#" class="left2_dl"></a>
		  <a href="#" class="left3_dl"></a>
		  <a href="#" class="left4_dl"></a>
	</div>

     <!-- 左右浮动-->	   
        <input id='yl_article_id' type='hidden' value="<?=$article['id']?>">
<!--        <input id='user_id' type='hidden' value="<?=$uid?>">-->
    <div class="clear"></div>       
<? if ($make_flag) { ?>
    <div id='review' style="background-color:#F8F8F8;float: left;/*margin-left: -285px;*/height: auto;">
        <iframe src="/review.php?action=list&type=1&article_id=<?=$article['id']?>&type_id=1" width="882" height=100% marginheight="0" marginwidth="0" frameborder="0" scrolling="no" id="iframepage" name="iframepage" frameborder="0"  onLoad="iFrameHeight()"></iframe> 
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
        if(userid){
            $("#user_id").val(userid);
        }
    }
    
    function reviewnum(i){
        $("#review_num").val(i);
    }
    </script> 
    <script src='/js/counter.php?cname=article&c1=<?=$p_category['id']?>&c2=<?=$article['category_id']?>&c3=<?=$article['id']?>'></script>
<? } else { ?>
<? if ($s==1) { ?>
<? } elseif($allow_audit ) { ?>
    <div  style='margin-left: 150px; border: solid 1px;width: 500px;margin-top: 15px;'>
        <h1 style='color: royalblue'>文章审核信息</h1>
        <div>审核内容：<textarea id='content' cols="30"></textarea></div>
        <p style='padding-left: 80px;margin-top: 20px;'><input type="radio" name="state" <? if ($seo==1) { ?>value="4"<? } else { ?>value="2"<? } ?> >通过&nbsp;&nbsp;<input type="radio" name="state" value="1" >不通过&nbsp;&nbsp;<!--<input type="radio" name="state" value="3" >首页焦点：--></p>
        <p style='padding-left: 200px;margin-top: 20px;'><input type="button" onclick="sub_form()" value="提交"></p>
        <input type='hidden' id='article_id' value="<?=$article['id']?>">
        <input type='hidden' id='articlelog_id' value="<?=$articlelog['id']?>">
    </div>
<? } ?>
    <script>
    function sub_form(){
        var content =  $("#content").val();
        var article_id =  $("#article_id").val();
        var articlelog_id =  $("#articlelog_id").val();
   
        var state= $('input:radio[name="state"]:checked').val();
        if(content){
            if(state){
                 $.post("<?=$php_self?>articlecomment",{"content":content,"article_id":article_id,"articlelog_id":articlelog_id,'state':state},function(msg){
                       custom_close();
                });
            }else{
                alert("请填写审核状态");
            }
        }else{
            alert("请填写审核意见");
        }
    }
    
    function custom_close(){
        if(confirm("审核意见提交成功.您确定要关闭本页吗？")){
            window.opener=null;
            window.open('','_self');
            window.close();
        }
        else{}
        }
    </script>
<? } ?>
    </div> 
    <div id="d2" style="display:none">22222</div> 
    <div id="d3" style="display:none">33333</div> 
     <div id="d4" style="display:none">44444</div> 
</div>

</div>
<div class="clear"></div>



<!--#include virtual="/template/default/article_footer.htm"-->