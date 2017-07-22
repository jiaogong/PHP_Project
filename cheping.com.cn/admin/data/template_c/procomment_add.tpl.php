<? if(!defined('SITE_ROOT')) exit('Access Denied');?>
<? include $this->gettpl('header');?>
<div class="user">
  <div class="nav">
    <ul id="nav">
  <li><a href="<?=$php_self?>">车系评论列表</a></li>
  <li><a href="<?=$php_self?>add"  class="song">添加车系评论</a></li>
</ul>
  </div>
  <div class="clear"></div>
<div class="user_con">
  <div class="user_con1">
    <form action="<?=$php_self?>add" method="post" name="frm_comment" id="frm_comment">
    <table class="table2" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td class="td_right" width="150">
        车款名称：        
        </td>
        <td class="td_left">
        <? if ($series) { ?>
          <?=$series['brand_name']?> <?=$series['series_name']?>
          <input type="hidden" name="series_id" id="series_id" value="<?=$series['series_id']?>">
        <? } else { ?>
          <select name="brand_id" id="brand_id">
            <option value="">请选择品牌</option>
            <? foreach((array)$brand as $k=>$v) {?>
            <option value="<?=$v[brand_id]?>"><?=$v[brand_name]?></option>
            <?}?>
          </select>
          <select name="factory_id" id="factory_id">
            <option value="">请选择厂商</option>
            <? foreach((array)$factory as $k=>$v) {?>
            <option value="<?=$v[factory_id]?>"><?=$v[factory_name]?></option>
            <?}?>
          </select>
          <select name="series_id" id="series_id">
            <option value="">请选择车系</option>
            <? foreach((array)$series as $k=>$v) {?>
            <option value="<?=$v[series_id]?>"><?=$v[series_name]?></option>
            <?}?>
          </select>
          
          <input type="hidden" name="series_name" id="series_name">
        <? } ?>
        </td>
      </tr>
      <tr>
        <td class="td_right">优点：</td>
        <td class="td_left">
          <textarea cols="50" rows="5" id="pros" name="pros"><?=$series['pros']?></textarea>
          小于<font color="red"><b>500</b></font>字
        </td>
      </tr>
      <tr>
        <td class="td_right">缺点：</td>
        <td class="td_left">
          <textarea cols="50" rows="5" id="cons" name="cons"><?=$series['cons']?></textarea>
          小于<font color="red"><b>250</b></font>字
        </td>
      </tr>
      <tr>
        <td class="td_right">介绍：</td>
        <td class="td_left">
          <textarea cols="50" rows="5" id="series_intro" name="series_intro"><?=$series['series_intro']?></textarea>
          小于<font color="red"><b>1000</b></font>字
        </td>
      </tr>
      <tr>
        <td class="td_right">评分：</td>
        <td class="td_left">
          性 &nbsp;能：<input type="text" name="p1" id="p1" value="<?=$score['p1']?>" size="5" class="series_param_score"><br>
          质 &nbsp;量：<input type="text" name="p2" id="p2" value="<?=$score['p2']?>" size="5" class="series_param_score"><br>
          安全性：<input type="text" name="p3" id="p3" value="<?=$score['p3']?>" size="5" class="series_param_score"><br>
          配 &nbsp;置：<input type="text" name="p4" id="p4" value="<?=$score['p4']?>" size="5" class="series_param_score"><br>
          设 &nbsp;计：<input type="text" name="p5" id="p5" value="<?=$score['p5']?>" size="5" class="series_param_score"><br>
          平均分：<input type="text" name="av_score" id="av_score" value="<?=$score['av_score']?>" readonly="readonly" size="5" style="background-color: #e8f8f8;"><br>
        </td>
      </tr>
      <tr>
        <td align="center" colspan="2">
        <input type="submit" name="btn" value="  提  交  ">&nbsp;&nbsp;
        <input type="reset" name="btn" value="  重  填  ">
        </td>
      </tr>
    </table>
    </form>
    </div>
    <div class="user_con2"><img src="<?=$admin_path?>images/conbt.gif" height="16" ></div>
  </div>
</div>
<script type="text/javascript">
$().ready(function(){
  $('#brand_id').change(function(){
    var brand_id=$(this).val();
    var fact=$('#factory_id')[0];
    var facturl="?action=factory-json&brand_id="+brand_id;
    var sel=$(this)[0];
    $('#brand_name').val(sel.options[sel.selectedIndex].text)
    
    $.getJSON(facturl, function(ret){
      $('#factory_id option[value!=""]').remove();
      $('#series_id option[value!=""]').remove();
      $('#model_id option[value!=""]').remove();
      
      $.each(ret, function(i,v){
        fact.options.add(new Option(v['factory_name'], v['factory_id']));
      });
    });
  });
  
  $('#factory_id').change(function(){
    var fact_id=$(this).val();
    var ser=$('#series_id')[0];
    var serurl="?action=series-json&factory_id="+fact_id;
    var sel=$(this)[0];
    $('#factory_name').val(sel.options[sel.selectedIndex].text)
    
    $.getJSON(serurl, function(ret){
      $('#series_id option[value!=""]').remove();
      $('#model_id option[value!=""]').remove();
      
      $.each(ret, function(i,v){
        ser.options.add(new Option(v['series_name'], v['series_id']));
      });
    });
  });
  
  $('#series_id').change(function(){
    var sel=$(this)[0];
    $('#series_name').val(sel.options[sel.selectedIndex].text)
  });
  
  $('#frm_comment').submit(function(){
    if(!$('#series_id').val()){
      alert('没有选择车系！');
      return false;
    }
  });
  
  $('.series_param_score').live('blur', function(){
    var total;
    total = parseInt($('#p1').val())+parseInt($('#p2').val())+parseInt($('#p3').val())+parseInt($('#p4').val())+parseInt($('#p5').val());
    $('#av_score').val(Math.ceil(total*10/5)/10);
  });
});  
</script>
</body>
</html>