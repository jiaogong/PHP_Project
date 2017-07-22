<? if(!defined('SITE_ROOT')) exit('Access Denied');?>
<? include $this->gettpl('header');?>
<script>
function series_select(obj, bid, sid) {
    $.post('index.php?action=static-ajaxseries', {bid:bid}, function(data){
        var js = '<option value="0">车系</option>';
         var data = eval('(' + data + ')');
        $.each(data, function(i, v) {
            js += '<option value="' + v['series_id'] + '">' + v['series_name'] + '</option>\n';
        });
        obj.empty();
        obj.html(js);
        if(sid != 0) obj.val(sid);
    });
}    
function model_select(obj, sid, mid) {
    $.post('index.php?action=static-ajaxmodel', {sid:sid}, function(data){
        var js = '<option value="0">车款</option>';
         var data = eval('(' + data + ')');
        $.each(data, function(i, v) {
            js += '<option value="' + v['model_id'] + '">' + v['model_name'] + '</option>\n';
        });
        obj.empty();
        obj.html(js);
        if(mid != 0) obj.val(mid);
    });
}
</script>
<div class="user">
    <div class="nav">
        <ul id="nav">
            <li><a href="<?=$php_self?>focus">轮播图</a></li>
            <li><a href="<?=$php_self?>price">首页推荐车款</a></li>
            <li><a href="<?=$php_self?>offers">首页比价通</a></li>
            <li><a href="<?=$php_self?>bingogou">冰狗购</a></li>
            <li><a href="<?=$php_self?>recommendfocus" class="song">推荐手动轮播图</a></li>
        </ul>
    </div>
    <div class="clear"></div>
<div class="user_con">
    <div class="user_con1">
      <form action="" name="frm_ad" id="frm_ad" enctype="multipart/form-data" method="post">
      <table cellpadding="0" cellspacing="0" class="table2" border="0">
        <? foreach((array)$recommendfocus as $k=>$v) {?>
        <tr> 
          <td class="td_left blue" valign="top">
          图片<?=$k?>：
          </td>
          <td class="td_left">
           车型<?=$k?>：<select id="brand_id_<?=$k?>" name="brand_id_<?=$k?>" class="brand_select" onchange="series_select($('#series_id_<?=$k?>'), this.value, 0);">
                <option value="0">品牌</option>
                <? foreach((array)$brand as $b) {?>
                <option value="<?=$b['brand_id']?>"><?=$b['letter']?>   <?=$b['brand_name']?></option>
                <?}?>
          </select>&nbsp;&nbsp;&nbsp;
         <select id="series_id_<?=$k?>" name="series_id_<?=$k?>" class="series_select" onchange="model_select($('#model_id_<?=$k?>'), this.value, 0);"><option value="0">车系</option></select>&nbsp;&nbsp;&nbsp;
         <select id="model_id_<?=$k?>" name="model_id_<?=$k?>" class="model_select"><option value="0">车款</option></select>                   
          <script>
              <? if ($v['brand']) { ?>$('#brand_id_<?=$k?>').val(<?=$v['brand']?>);<? } ?>
              <? if ($v['series']) { ?>
                series_select($('#series_id_<?=$k?>'), <?=$v['brand']?>, <?=$v['series']?>);
              <? } ?>
              <? if ($v['model']) { ?>
                model_select($('#model_id_<?=$k?>'), <?=$v['series']?>, <?=$v['model']?>);
              <? } ?>
          </script>   
          <br>
          链接<?=$k?>：<input type="text" name="link_<?=$k?>" id="link_<?=$k?>" size="40" value="<?=$v['link']?>"><br>
          公告语<?=$k?>：<input type="text" name="title<?=$k?>" id="title<?=$k?>" size="40" value="<?=$v['title']?>"><br> 
          图片<?=$k?>：<input type="file" name="pic_<?=$k?>" id="pic_<?=$k?>">
          <? if ($v['pic']) { ?>
          <a href="<?=$php_self?>imgcode&code=<? echo urlencode(base64_encode('images/' . $v['pic'])); ?>" name="轮播图片<?=$k?>" class="jTip" id="vpic">
          查看图片
          </a>
          <input type="hidden" name="pic_h_<?=$k?>" id="pic_h_<?=$k?>" value="<?=$v['pic']?>"><br>   
          <? } ?>          
          </td>
        </tr>
        <? } ?>
        <tr>
          <td colspan="2"><br>
            <input type="submit" value="  提  交  " name="btn_adds" id="btn_adds">&nbsp;&nbsp;
            <input type="reset" value="  重  填  ">
          </td>
        </tr>
      </table>
      </form>
   </div>
   <div class="user_con2"><img src="<?=$admin_path?>images/conbt.gif"  height="16" /></div>
   <p id="axx"></p>
</div>
</div>
<? include $this->gettpl('footer');?>
