<? if(!defined('SITE_ROOT')) exit('Access Denied');?>
<? include $this->gettpl('header');?>
<div class="user">
<div class="nav">
    <ul id="nav">
    <li><a href="<?=$php_self?>focus">轮播图</a></li>
    <li><a href="<?=$php_self?>price" class="song">首页推荐车款</a></li>
    <li><a href="<?=$php_self?>offers">首页比价通</a></li>
    <li><a href="<?=$php_self?>bingogou">冰狗购</a></li>
    <li><a href="<?=$php_self?>recommendfocus">推荐手动轮播图</a></li>
</ul>
</div>
<div class="clear"></div>
<div class="user_con">
    <div class="user_con1">
      <form name="hotcar_from" id="hotcar_from" action="" method="post" enctype="multipart/form-data">
      <table cellpadding="0" cellspacing="0" class="table2" border="0">

        <? for($i=0;$i<=7;$i++) { ?>
        <? $fvarid = "factory_" . $i;$svarid = "series_" . $i;$mvarid = "model_" . $i; $factory = $$fvarid; $series = $$svarid; $models = $$mvarid; ?>
        <tr>
          <td class="td_left blue" width="15%">
          广告：
          </td>
          <td class="td_left">
          <input type="text" name="title_<?=$i?>" id="title_<?=$i?>" value="<? echo $hotcarseries[$i]['title'] ?>" size="50">
          <font color="red"></font>
          </td>
        </tr>
        <tr>
          <td class="td_left blue" width="15%">车系 <? echo $i + 1 ?>：</td>
          <td class="td_left">
          <select name="brand_id_<?=$i?>" id="brand_id_<?=$i?>" seq="<?=$i?>" class="brand_select">
            <option value="">请选择</option>
            <? foreach((array)$brand as $k=>$v) {?>
            <option value="<?=$v[brand_id]?>"><?=$v[letter]?> <?=$v[brand_name]?></option>
            <?}?>
          </select>
          <select name="factory_id_<?=$i?>" id="factory_id_<?=$i?>" seq="<?=$i?>" class="series_select">
            <option value="">请选择</option>
            <? foreach((array)$factory as $k=>$v) {?>
            <option value="<?=$v[factory_id]?>"><?=$v[factory_name]?></option>
            <?}?>
          </select>
          <select name="series_id_<?=$i?>" id="series_id_<?=$i?>" seq="<?=$i?>" class="model_select">
            <option value="">请选择</option>
            <? foreach((array)$series as $k=>$v) {?>
            <option value="<?=$v[series_id]?>"><?=$v[series_name]?></option>
            <?}?>
          </select>
              <select name="model_id_<?=$i?>" id="model_id_<?=$i?>" seq="<?=$i?>" onchange="getPrice(this.value, <?=$i?>)">
            <option value="">请选择</option>
            <? foreach((array)$models as $k=>$v) {?>
            <option value="<?=$v[model_id]?>"><?=$v[model_name]?></option>
            <?}?>
          </select>
          </td>
        </tr>
        <tr><td colspan="2" height="1" name="price_<?=$i?>" id="price_<?=$i?>"></td></tr>
        <tr><td colspan="2" height="1"></td></tr>
        <? } ?>
        <tr>
          <td colspan="2">
            <input type="submit" value=" 提&nbsp;&nbsp;交 ">&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="reset" value=" 重&nbsp;&nbsp;填 ">
          </td>
        </tr>
      </table>
      </form>
   </div>
   <div class="user_con2"><img src="<?=$admin_path?>images/conbt.gif"  height="16" /></div>
</div>
</div>
<script type="text/javascript">
function getPrice(modelId, i) {
    $.get('?action=static-ajaxgetprice', {mid:modelId}, function(data) {        
        $('#price_' + i).html(data);
    });
}    
$().ready(function(){
  $(".brand_select").change(function(){
    var brand_id=$(this).val();
    var seq = $(this).attr('seq');
    var fact=$('#factory_id_'+seq)[0];
    var facturl="?action=factory-json&brand_id="+brand_id;

    $.getJSON(facturl, function(ret){
      $('#factory_id_'+seq+' option[value!=""]').remove();
      $('#series_id_'+seq+' option[value!=""]').remove();
      $('#model_id_'+seq+' option[value!=""]').remove();

      $.each(ret, function(i,v){
        fact.options.add(new Option(v['factory_name'], v['factory_id']));
      });
    });
  });

  $('.series_select').change(function(){
    var fact_id=$(this).val();
    var seq = $(this).attr('seq');
    setSeriesByFctory(fact_id, 'series_id_'+seq);
  });

  $('.model_select').change(function(){
    var series_id=$(this).val();
    var seq = $(this).attr('seq');
    setModelBySeries(series_id, 'model_id_'+seq);
  });

  $('#hotcar_from').submit(function(){
    if($('#brand_id_1').val() && !$('#series_id_1').val()){
      alert('请选择车系 1！');
      return false;
    }
    if($('#brand_id_2').val() && !$('#series_id_2').val()){
      alert('请选择车系 2！');
      return false;
    }
  });

  <? foreach((array)$hotcarseries as $k=>$v) {?>
  <? $n = $k ?>
  $('#brand_id_<?=$n?> option[value="<?=$v['brand_id']?>"]').attr({selected:true});
  $('#factory_id_<?=$n?> option[value="<?=$v['factory_id']?>"]').attr({selected:true});
  $('#series_id_<?=$n?> option[value="<?=$v['series_id']?>"]').attr({selected:true});
  $('#model_id_<?=$n?> option[value="<?=$v['model_id']?>"]').attr({selected:true});
  <? if ($v['model_id']) { ?>
  getPrice(<?=$v['model_id']?>, <?=$n?>);
  <? } ?>
  <?}?>
});
</script>
    </body>
</html>