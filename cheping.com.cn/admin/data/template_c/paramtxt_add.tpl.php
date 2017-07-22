<? if(!defined('SITE_ROOT')) exit('Access Denied');?>
<? include $this->gettpl('header');?>
<div class="user">
  <div class="nav">
    <ul id="nav">
      <li><a href="<?=$php_self?>">文本参数列表</a></li>
      <li><a href="<?=$php_self?>add"  class="song">添加文本参数</a></li>
    </ul>
  </div>
  <div class="clear"></div>
<div class="user_con">
  <div class="user_con1">
    <form action="<?=$php_self?>add" method="post">
    <table class="table2" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td class="td_right" width="150">
        车款名称：        
        </td>
        <td class="td_left">
        <? if ($paramtxt) { ?>
          <?=$model['brand_name']?> <?=$model['series_name']?> <?=$model['model_name']?>
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
          <select name="model_id" id="model_id">
            <option value="">请选择车款</option>
            <? foreach((array)$model as $k=>$v) {?>
            <option value="<?=$v[model_id]?>"><?=$v[model_name]?></option>
            <?}?>
          </select>
          <input type="hidden" name="model_name" id="model_name">
        <? } ?>
        </td>
      </tr>
      <tr>
        <td class="td_right">是否标配：</td>
        <td class="td_left">
          <select name="state" id="state">
            <option value="0">是</option>
            <option value="1">否</option>
          </select>
        </td>
      </tr>
      <tr>
        <td class="td_right">配置分类：</td>
        <td class="td_left">
          <select name="param_type" id="param_type">
            <? foreach((array)$list as $k=>$v) {?>
            <option value="<?=$v[id]?>"><?=$v[name]?></option>
            <?}?>
          </select>
        </td>
      </tr>
      <tr>
        <td class="td_right">文本内容：</td>
        <td class="td_left">
          <textarea cols="50" rows="5" id="paramtxt" name="paramtxt"></textarea>
        </td>
      </tr>
      
      <tr>
        <td align="center" colspan="2">
        <input type="hidden" name="id" id="id" value="<?=$model['model_id']?>">
        <input type="submit" name="btn" value="  提  交  ">&nbsp;&nbsp;
        <input type="reset" name="btn" value="  重  填  ">&nbsp;&nbsp;
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
    
    var sid=$(this).val();
    var mod=$('#model_id')[0];
    var modurl="?action=model-json&sid="+sid;
    $.getJSON(modurl, function(ret){
      $('#model_id option[value!=""]').remove();
      $.each(ret, function(i,v){
        mod.options.add(new Option(v['model_name'], v['model_id']));
      });
    });
  });
  
  $('#model_id').change(function(){
    var mod=$(this)[0];
    $('#model_name').val(mod.options[mod.selectedIndex].text)
  });
  
});  
</script>
</body>
</html>