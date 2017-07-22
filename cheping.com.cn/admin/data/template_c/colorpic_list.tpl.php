<? if(!defined('SITE_ROOT')) exit('Access Denied');?>
<? include $this->gettpl('header');?>
<div class="user_wrap">
<ul class="nav2">
  <li class="li1"><a href="<?=$php_self?>list">车身颜色列表</a></li>
  <li><a href="<?=$php_self?>add">添加车身颜色</a></li>
</ul>
<div class="clear"></div>
<div class="user_con">
<div class="user_con1">
 

  <table class="table2" border="0" cellpadding="0" cellspacing="0">
    <tbody>
      <tr class="th">
        <th>ID</th>
        <th>颜色图片</th>
        <th>颜色名称</th>
        <th>操作</th>
      </tr>
      <? foreach((array)$list as $k=>$v) {?>
      <tr align="center">
        <td><?=$v['id']?></td>
        <td><img src="<?=$v['pic']?>" width="17" height="17" title="<?=$v['name']?>"/></td>
        <td><?=$v['name']?></td>
        <td><a href="<?=$php_self?>edit&id=<?=$v['id']?>"><img src="<?=$admin_path?>images/rewrite.gif" width="12" height="12" />修改</a>
        <a href="#here" mt='1' icon='warnning' tourl="<?=$php_self?>del&id=<?=$v['id']?>" class="click_pop_dialog">
        <img src="<?=$admin_path?>images/del1.gif" height="9" width="9">删除
        </a>
        </td>
      </tr>
      <?}?>
      <tr class="page_bar_css"><td colspan="5" height="20"><?=$page_bar?></td></tr>
    </tbody>
  </table>
</div>
</div>
</div>
<script type="text/javascript">
$().ready(function(){
  <? if ($model_r) { ?>
  $('#brand_id option[value="<?=$model_r['brand_id']?>"]').attr({selected:true});
  $('#factory_id option[value="<?=$model_r['factory_id']?>"]').attr({selected:true});
  $('#series_id option[value="<?=$model_r['series_id']?>"]').attr({selected:true});
  $('#model_id option[value="<?=$model_r['model_id']?>"]').attr({selected:true});
  <? } ?>

  $('#pcategory').change(function(){
    var cate = $('#category')[0];
    var pid = $(this).val();
    var cateurl = "?action=paramtype-json&pid="+pid;
    if(!pid) {
      $('#category option[value!=""]').remove();
    }else{
      //alert(pid);
      $.getJSON(cateurl, function(ret){
        $('#category option[value!=""]').remove();
        $.each(ret, function(i,v){
          cate.options.add(new Option(v['name'], v['id']));
        });
      });
    }
  });

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

  <? if ($pcategory) { ?>
  $('#pcategory option[value="<?=$pcategory?>"]').attr({selected:true});
  <? } ?>

  <? if ($keyword) { ?>
  $('#keyword').val('<?=$keyword?>');
  <? } ?>

  <? if ($state) { ?>
  $('#state option[value="<?=$state?>"]').attr({selected:true});
  <? } ?>

  $('.click_pop_dialog').live('click', function(){
    pop_window($(this), {message:'您确定要删除该文本参数吗？', pos:[200,150]});
  });
});

</script>
<? include $this->gettpl('footer');?>
