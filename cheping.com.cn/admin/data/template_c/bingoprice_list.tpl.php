<? if(!defined('SITE_ROOT')) exit('Access Denied');?>
<? include $this->gettpl('header');?>
<div class="user">
    <div class="nav">
        <ul id="nav">
        <li><a href="<?=$php_self?>list&type=5"  <? if ($type==5) { ?>class="song"<? } ?>>冰狗参考</a></li>
        <li><a href="<?=$php_self?>list"  <? if ($type==2) { ?>class="song"<? } ?>>成本价列表</a></li>
        <li><a href="<?=$php_self?>list&type=4"  <? if ($type==4) { ?>class="song"<? } ?>>暗访价列表</a></li>
        <li><a href="<?=$php_self?>list&type=3"  <? if ($type==3) { ?>class="song"<? } ?>>最多人购买价列表</a></li>
        <li><a href="<?=$php_self?>importView">导入报价</a></li>      
        <li><a href="<?=$php_self?>addView">新增报价</a></li>     
    </ul>
    </div>
    <div class="clear"></div>
    <div class="user_con">
        <div class="user_con1">
            <form id="search_form" name="search_form" method="post" action="index.php?action=bingoprice-list">
                <input type="hidden" name="state" value="<?=$state?>" />
            <table class="table2" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td style="float:left;"><select name="isquote" id="isquote">
                        <option value="1"<? if ($xj_isquote=='1') { ?>selected<? } ?>>已报价</option>
                        <option value="2" <? if ($xj_isquote=='2') { ?>selected<? } ?>>未报价</option>
                      </select></td>
                      <? if ($type==4) { ?>
                    <td style="float:left"><select name="isorder" id="isorder">
                        <option value="1"<? if ($xj_order=='1') { ?>selected<? } ?>>修改时间排序</option>
                        <option value="2" <? if ($xj_order=='2') { ?>selected<? } ?>>获取时间排序</option>
                        <option value="3"<? if ($xj_order=='3') { ?>selected<? } ?>>商情价格排序</option>
                        <!--<option value="4" <? if ($xj_order=='4') { ?>selected<? } ?>>指导价格排序</option>-->
                        <option value="5" <? if ($xj_order=='5') { ?>selected<? } ?>>报价id排序</option>
                    </select></td>
                    <? } ?>
                    <td style="float:left">
                        <select name="brand_id" id="brand_id">
                        <option value="">==请选择品牌==</option>
                        <? foreach((array)$brand as $k=>$v) {?>
                        <option value="<?=$v[brand_id]?>" <? if ($brand_id==$v[brand_id]) { ?>selected="selected"<? } ?>><?=$v[brand_name]?></option>
                        <?}?>
                      </select>
                      <select name="factory_id" id="factory_id">
                        <option value="">==请选择厂商==</option>
                        <? foreach((array)$factory_data as $k=>$v) {?>
                        <option value="<?=$v[factory_id]?>" <? if ($factory_id==$v[factory_id]) { ?>selected="selected"<? } ?>><?=$v[factory_name]?></option>
                        <?}?>                        
                      </select>                            
                      <select name="series_id" id="series_id">
                        <option value="">==请选择车系==</option>
                        <? foreach((array)$series_data as $k=>$v) {?>
                        <option value="<?=$v[series_id]?>" <? if ($series_id==$v[series_id]) { ?>selected="selected"<? } ?>><?=$v[series_name]?></option>
                        <?}?>                        
                      </select>               
                      <select name="model_id" id="model_id" style="width:160px">
                        <option value="">==请选择车款==</option>
                        <? foreach((array)$model_data as $k=>$v) {?>
                        <option value="<?=$v[model_id]?>" <? if ($model_id==$v[model_id]) { ?>selected="selected"<? } ?>><?=$v[model_name]?></option>
                        <?}?>                        
                      </select> 
                      <input type="hidden" value="<?=$type?>" name="type" />                            
                      <input id="search_btn" name="search_btn" type="submit" value="搜索" />                    
                    </td>
                </tr>
            </table>
            </form>
            <form id="del_form" method="post" action="index.php?action=bingoprice-deleteprice">
			<input type="hidden" value="<?=$php_selfs?>" name="phpself" />
            <table class="table2" id="pricelist" border="0" cellpadding="0" cellspacing="0" style="table-layout:fixed;word-wrap: break-word;">
                <tr align="right"  class='th'>
                    <? if ($type==4) { ?><td width="10%">id</td><? } ?>
                    <td width="50%">车款</td>
                    <td width="10%">指导价</td>
                    <td width="10%"><? if ($type==2) { ?>成本价<? } elseif($type==3) { ?>最多人购买价<? } elseif($type==4) { ?>商情价<? } else { ?>冰狗参考价<? } ?></td>
                    <td width="10%"><? if ($type==4) { ?>价格获取日期<? } else { ?>价格录入日期<? } ?></td>
                    <td width="10%">操作</td>
                </tr>
				<? if ($type==4) { ?><tr class='th'><td><input style="float:left" type="checkbox" onclick="selectAllorNone()" /></td><td>全选/全不选<input type="button" onclick="delButton()" value="批量删除" /></td><td></td><td></td><td></td></tr><? } ?>
                <? foreach((array)$list as $k=>$v) {?>
                <tr class='th'>
                    <? if ($type==4) { ?><td><input style="float:left" type="checkbox" name="delist[]" value="<?=$v['id']?>-<?=$v['model_id']?>"/> <span style="float:left"><?=$v['id']?></span></td><? } ?>
                    <!--<td><input type="checkbox" name="mid[]" value="<?=$v['model_id']?>_<?=$v['series_id']?>" /></td>-->
                    <td><?=$v['factory_name']?> <?=$v['series_name']?> <?=$v['model_name']?></td>
                    <td><?=$v['model_price']?>万</td>
                    <td><? if ($type==5) { ?><? echo empty($v['bingo_price']) ? 0 : $v['bingo_price'] ?><? } else { ?><?=$v['price']?><? } ?>万</td>
                    <td><? echo $type==4 ? date("Y-m-d", $v['get_time']) : date("Y-m-d", $v['created']) ?></td>
                    <td><a href="index.php?action=bingoprice-edit&model_id=<?=$v['model_id']?>&type=<?=$type?>&id=<?=$v['id']?>&page=<?=$page?>&phpself=<?=$php_selfs?>"><img src="<?=$admin_path?>images/rewrite.gif" width="12" height="12" />查看详情<? if ($type==4) { ?><a href="index.php?action=bingoprice-deleteprice&delist=<?=$v['id']?>-<?=$v['model_id']?>&phpself=<?=$php_selfs?>" onclick="return confirm('确定将此记录删除?')">删除</a><? } ?></a>
                    </td>
                </tr>
                <?}?>
                <tr class='ep-pages'>
                    <td colspan="7">
					<? if ($type==4) { ?><input style="float:left" type="checkbox" onclick="selectAllorNone()" />全选/全不选<input style="float:left" type="button" onclick="delButton()" value="批量删除" /><? } ?> <? if ($page_bar) { ?><?=$page_bar?><? } elseif($total) { ?>共<?=$total?>条<? } else { ?>&nbsp<? } ?>
                    </td>
                </tr>
            </table>
            </form>
            <div style="height:40px;"></div>
        </div>
        <div class="user_con2">
            <img src="<?=$admin_path?>images/conbt.gif" height="16" >
        </div>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function(){
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

var state = 1;
function selectAllorNone(){
	if(state == 1){
		$("input:checkbox").attr("checked","checked");
		//$("input:checkbox[name*='delist']").attr("checked","checked");
		state = 0;
	}else{
		$("input:checkbox").attr("checked",false);
		//$("input:checkbox[name*='delist']").attr("checked",false);;
		state = 1;
	}
}

function delButton(){
	if($("input:checkbox[name*='delist']:checked").size() == 0){
		alert('一个都没有选中');
		return false;
	}else{
		$("#del_form").submit();
	}
}
</script>
<? include $this->gettpl('footer');?>
