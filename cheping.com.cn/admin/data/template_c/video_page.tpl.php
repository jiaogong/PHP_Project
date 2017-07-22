<? if(!defined('SITE_ROOT')) exit('Access Denied');?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=$page_title?></title>
<!--#include virtual="/ssi/article_header.shtml"-->
<!--content-->
<div class="wenzhang_main">
<a href="#">车评首页</a> > <a href="#"><?=$p_category['category_name']?></a> > <a href="#"><?=$category['category_name']?></a>
<div class="chepai"><img src="images/QC_logo.png"></div>
<div class="chexi"><?=$series['series_name']?></div>

<div class="tab" style="margin-top:20px;">
    <ul> 
    <li class="ll" title="d1">综述</li> 
    <li title="d2">评测</li> 
    <li title="d3">导购</li> 
	<li title="d4">视频</li> 
    </ul> 
</div>
<hr style=" margin-top:0px; margin-left:0px;">
<div class="con"> 
    <div id="d1" class="zongshu">
	  <div class="zongshu_right">
	    <!--#include virtual="/ssi/ssi_index_tag.shtml"-->
            <!--精品分类结束-->
            <!--#include virtual="/ssi/ssi_index_video.shtml"-->
            <!--精彩视频结束-->
	  </div>
	  <div class="zongshu_left">
              
              <div class="zongshu_njj">
		<div class="sp_bt"><?=$article['title']?></div>
                <div class="time" style="color:red;"><? echo date("Y-m-d",$article['uptime']) ?></div>
                   <iframe src="<?=$article['source']?>" width="820" height='620' style="margin-top:10px;" scrolling="no" frameborder="0"></iframe> 
                   <? foreach((array)$article['seriesname_list'] as $key=>$val) {?>
		   <div class="chexingsp" style="color:red;"><?=$val?></div>
                   <?}?>
		   <div class="spjieshao">视频介绍：</div>
		   <div class="shipinjieshao">
		        <?=$article['chief']?>
				<br />
				<br />
                                <? if ($article['relative_title']) { ?>
				相关视频：<a href="<?=$article['relative_url']?>"><?=$article['relative_title']?></a>
                                <? } ?>
		   </div>
		   <? foreach((array)$taglist as $k=>$v) {?>
		   <span class="bq1"><a href=""><div class="redf"></div><font style="float:left; margin-left:5px;"><?=$v[tag_name]?></font></a></span>
		   <?}?>
		</div>

	  </div>
	</div> 

</div>
<!--content-->
<input id='article_id' type='hidden' value="<?=$article['id']?>">
<? if ($s==1) { ?>
<? } else { ?>
<div  style='margin-left: 150px; border: solid 1px;width: 500px;margin-top: 85px;'>
    <h1 style='color: royalblue'>文章审核信息</h1>
    <div>审核内容：<textarea id='content' cols="30"></textarea></div>
    <p style='padding-left: 80px;margin-top: 20px;'><input type="radio" name="state" value="3" >通过&nbsp;&nbsp;<input type="radio" name="state" value="1" >不通过&nbsp;&nbsp;<!--<input type="radio" name="state" value="2" >首页焦点：--></p>
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
 //       alert(state);
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
<!--#include virtual="/ssi/article_footer.shtml"-->