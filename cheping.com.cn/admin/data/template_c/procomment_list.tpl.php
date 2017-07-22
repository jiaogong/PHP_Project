<? if(!defined('SITE_ROOT')) exit('Access Denied');?>
<? include $this->gettpl('header');?>
<div class="user">
  <div class="nav">
      <ul id="nav">
          <li><a href="<?=$php_self?>"  class="song">车系评论列表</a></li>
          <li><a href="<?=$php_self?>add">添加车系评论</a></li>
      </ul>
  </div>
  <div class="clear"></div>
<div class="user_con">
<div class="user_con1">
  <form action="<?=$php_self?>" method="post">
  <table class="table2" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td>
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
      名称
      <input size="12" name="keyword" id="keyword">
      <input type="submit" name="search" value=" 搜 索 ">
      </td>
    </tr>
  </table>
  </form>
  
  <table class="table2" border="0" cellpadding="0" cellspacing="0">
    <tr align="right"  class='th'> 
      <th height="20" nowrap>编号</th>
      <th width="20%" align="left">车系名称</th>
      <th width="15%">优点</th>
      <th width="15%">缺点</th>
      <th width="15%">介绍</th>          
      <th width="30%">评分</th>          
      <th nowrap>操作</th>
    </tr>
    
    <? foreach((array)$list as $k=>$v) {?>
    <tr align="right">
      <td height="20" nowrap align="center"><?=$v[series_id]?></td>
      <td><?=$v[series_name]?></td>
      <td>
      <? if ($v[pros]) { ?>
      有
      <? } else { ?>
      无
      <? } ?>
      </td>
      <td>
      <? if ($v[cons]) { ?>
      有
      <? } else { ?>
      无
      <? } ?>
      </td>
      <td>
      <? if ($v[series_intro]) { ?>
      有
      <? } else { ?>
      无
      <? } ?>
      </td>   
      <td>
      <? if ($v[series_intro]) { ?>
      <?=$v[score_str]?>
      <? } else { ?>
      无
      <? } ?>
      </td>       
      <td nowrap align="left">
      <a href="<?=$php_self?>edit&series_id=<?=$v[series_id]?>&fatherId=<?=$v[factory_id]?>">
      <img src="<?=$admin_path?>images/rewrite.gif" width="12" height="12" />修改</a>&nbsp;
      </td>
    </tr>
    <?}?>
  </table>
  <? if ($page_bar) { ?>
  <div>
    <div class="ep-pages">
      <?=$page_bar?>
    </div>
  </div>
  <? } ?>
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
  
  <? if ($keyword) { ?>
  $('#keyword').val('<?=$keyword?>');
  <? } ?>
  
  <? if ($factory_id) { ?>
  $('#brand_id option[value="<?=$brand_id?>"]').attr({selected:true});
  $('#factory_id option[value="<?=$factory_id?>"]').attr({selected:true});
  <? } ?>
  
});

</script>
  </body>
  </html>