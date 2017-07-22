<? if(!defined('SITE_ROOT')) exit('Access Denied');?>
<? include $this->gettpl('header');?> 
<div class="user_wrap" style="width:800px">
  <div class="module_con" style="width:800px">
    <div class="module_con1" style="width:800px">
      <table cellpadding="0" cellspacing="0" class="table2">
        <!--tr><td colspan="6" class="td_left">
        <form action="<?=$php_self?>" method="post">
        品牌
        <select name="brand_id" id="brand_id">
          <option value="">请选择品牌</option>
          <? foreach((array)$brand_list as $bk=>$bv) {?>
          <option value="<?=$bv['brand_id']?>"><?=$bv['brand_name']?></option>
          <?}?>
        </select>
        厂商
        <select name="factory_id" id="factory_id">
          <option value="">请选择厂商</option>
          <? if ($factory_id) { ?>
          <? foreach((array)$factory_list as $fk=>$fv) {?>
          <option value="<?=$fv['factory_id']?>"><?=$fv['factory_name']?></option>
          <?}?>
          <? } ?>
        </select>
        车系名称
        <input type="text" size="20" name="keyword" id="keyword" value="">
        <input type="submit" value="  搜 索  ">
        </form>
        </td></tr-->
        
        <tr align="right"  class='th'> 
          <th height="20" nowrap>编号</th>
          <th width="30%" align="left">车系名称</th>
          <th nowrap>品牌</th>
          <th width="30%" align="left">厂商</th>
          <th nowrap>属性</th>          
          <th nowrap>操作</th>
        </tr>
        
        <? foreach((array)$list as $k=>$v) {?>
        <tr align="right">
          <td height="20" nowrap align="center"><?=$v[series_id]?></td>
          <td>
          <a href="<?=$php_self?>edit&series_id=<?=$v[series_id]?>&fatherId=<?=$v[factory_id]?>">
          <?=$v[series_name]?>
          </a>
          </td>
          <td><?=$v[brand_name]?>(<? echo getCardbState($v[bs]); ?>)</td>
          <td height="20" nowrap align="center"><?=$v[factory_name]?>(<? echo getCardbState($v[fs]); ?>)</td>
          <td><? echo getCardbState($v[state]); ?></td>          
          <td nowrap align="left">
          <!--a class="unionpic" href="javascript:void(0);" tourl="<?=$php_self?>unionpic&series_id=<?=$v[series_id]?>&fatherId=<?=$v[factory_id]?>">
          关联图片</a-->&nbsp;
          <a href="<?=$php_self?>edit&series_id=<?=$v[series_id]?>&fatherId=<?=$v[factory_id]?>">
          <img src="<?=$admin_path?>images/rewrite.gif" width="12" height="12" />修改</a>&nbsp;
          <a href="#here" class="click_pop_dialog" mt='1' icon='warnning' tourl="<?=$php_self?>del&series_id=<?=$v[series_id]?>&fatherId=<?=$v[factory_id]?>">
          <img src="<?=$admin_path?>images/del1.gif" width="9" height="9" />删除</a>
          </td>
        </tr>
        <?}?>

      </table>
      <div>
        <div class="ep-pages">
          <?=$page_bar?>
        </div>
      </div>
    </div>
    
  </div>
</div>

<script type="text/javascript">
$().ready(function(){
  //$().ajaxStop($.unblockUI);
  
  $('.click_pop_dialog').live('click', function(){
    pop_window($(this), {message:'您确定要删除该车系吗？', pos:[200,150]});
  });
  
  $('#brand_id').change(function(){
    var brand_id=$(this).val();
    var fact=$('#factory_id')[0];
    var facturl="?action=factory-json&brand_id="+brand_id;
    $.getJSON(facturl, function(ret){
      $('#factory_id option[value!=""]').remove();
      $.each(ret, function(i,v){
        fact.options.add(new Option(v['factory_name'], v['factory_id']));
      });
    });
  });
  
  <? if ($keyword) { ?>
  $('#keyword').val("<?=$keyword?>");
  <? } ?>
  
  <? if ($factory_id) { ?>
  $('#brand_id option[value="<?=$brand_id?>"]').attr({selected:true});
  $('#factory_id option[value="<?=$factory_id?>"]').attr({selected:true});
  <? } ?>
});
</script>
<? include $this->gettpl('footer');?> 
