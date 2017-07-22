<? if(!defined('SITE_ROOT')) exit('Access Denied');?>
<? include $this->gettpl('header');?>
<div class="user">
    <div class="nav">
        <ul id="nav">
            <li><a href="?action=cardbpricelog-list&pType=2"  <? if ($type == '2') { ?>class="song"<? } ?>>成本价历史记录</a></li>
            <li><a href="?action=cardbpricelog-list&pType=4" <? if ($type == '4') { ?>class="song"<? } ?>>暗访价历史记录</a></li>
            <li><a href="?action=cardbpricelog-list&pType=3" <? if ($type == '3') { ?>class="song"<? } ?>>最多人购买价历史记录</a></li>
        </ul>
    </div>
    <div class="clear"></div>
    <div class="user_con">
        <div class="user_con1">
            <form id="search_form" name="search_form" method="post" action="index.php?action=cardbpricelog-list">
                <input type="hidden" name="state" value="<?=$state?>" />
            <table class="table2" border="0" cellpadding="0" cellspacing="0" style="text-align:left;">
                   <? if ($type==4) { ?>
				   <tr>
                    <td><select name="isorder" id="isorder">
                        <option value="1"<? if ($xj_order=='1') { ?>selected<? } ?>>修改时间排序</option>
                        <option value="2" <? if ($xj_order=='2') { ?>selected<? } ?>>获取时间排序</option>
                        <option value="3"<? if ($xj_order=='3') { ?>selected<? } ?>>商情价格排序</option>
                        <!--<option value="4" <? if ($xj_order=='4') { ?>selected<? } ?>>指导价格排序</option>-->
                        <option value="5" <? if ($xj_order=='5') { ?>selected<? } ?>>报价id排序</option>
                        <option value="6" <? if ($xj_order=='6') { ?>selected<? } ?>>优惠幅度排序</option>
                    </select></td>
                    <td>责任人<select name="creator" id="creator">
                        <option value="0"<? if ($xj_creator=='0') { ?>selected<? } ?>>全部</option>
                        <option value="1"<? if ($xj_creator=='1') { ?>selected<? } ?>>田伟</option>
                        <option value="2"<? if ($xj_creator=='2') { ?>selected<? } ?>>麦锐</option>
                        <option value="3"<? if ($xj_creator=='3') { ?>selected<? } ?>>于文浩</option>
                        <option value="4"<? if ($xj_creator=='4') { ?>selected<? } ?>>侯永超</option>
                        <option value="5"<? if ($xj_creator=='5') { ?>selected<? } ?>>无人名</option>
                    </select></td>
					<td>
						报价id<input type="text" name="priceid" value="<?=$priceid?>" />
					</td>
					<td>&nbsp;&nbsp;</td><td>&nbsp;&nbsp;</td>
					
					</tr>
					
					<tr>
					<td>
						<select name="dateselect" class="dateselect">
							<option value="1">获取时间</option>
							<option value="2">修改时间</option>
							<option value="3">录入时间</option>
						</select>
						<script type="text/javascript">
							$(".dateselect").val("<?=$dateselect?>");
						</script>
					</td>
					
				   <td>
						起始日期<input type="text" readonly="readonly" class="datepicker" name="startdate" value="<?=$startdate?>" style="width:110px;" />
				  </td>
				  <td>
				  
						结束日期<input type="text" readonly="readonly" class="datepicker" name="enddate" value="<?=$enddate?>"  style="width:110px;"/>
					</td><td>&nbsp;&nbsp;</td><td>&nbsp;&nbsp;</td>
					</tr>
                    <? } ?>
                <tr>
                <td>
                        <select name="brand_id" id="brand_id">
                        <option value="">==请选择品牌==</option>
                        <? foreach((array)$brand as $k=>$v) {?>
                        <option value="<?=$v['brand_id']?>" <? if ($brand_id==$v['brand_id']) { ?>selected="selected"<? } ?>><?=$v['letter']?> <?=$v['brand_name']?></option>
                        <?}?>
                      </select>
			    </td>
                <td>
                      <select name="factory_id" id="factory_id">
                        <option value="">==请选择厂商==</option>
                        <? foreach((array)$factory_data as $k=>$v) {?>
                        <option value="<?=$v['factory_id']?>" <? if ($factory_id==$v['factory_id']) { ?>selected="selected"<? } ?>><?=$v['factory_name']?></option>
                        <?}?>                        
                      </select> 
				</td>
				<td>
                      <select name="series_id" id="series_id">
                        <option value="">==请选择车系==</option>
                        <? foreach((array)$series_data as $k=>$v) {?>
                        <option value="<?=$v['series_id']?>" <? if ($series_id==$v['series_id']) { ?>selected="selected"<? } ?>><?=$v['series_name']?></option>
                        <?}?>                        
                      </select>  
				</td>
				<td>
                      <select name="model_id" id="model_id" style="width:160px">
                        <option value="">==请选择车款==</option>
                        <? foreach((array)$model_data as $k=>$v) {?>
                        <option value="<?=$v['model_id']?>" <? if ($model_id==$v['model_id']) { ?>selected="selected"<? } ?>><?=$v['model_name']?></option>
                        <?}?>                        
                      </select> 
			    </td>
				<td>
				
                      <input type="hidden" value="<?=$type?>" name="pType" />
                      <input id="search_btn" name="search_btn" type="submit" value="搜索" />                    
                  </td>
                </tr>
            </table>
            </form>
            <form id="del_form" method="post" action="index.php?action=cardbpricelog-delprice">
			<input type="hidden" value="<?=$php_self?>" name="phpself" />
            <table class="table2" id="pricelist" border="0" cellpadding="0" cellspacing="0" style="table-layout:fixed;word-wrap: break-word;">
                <tr align="right"  class='th'>
                    <? if ($type==4) { ?><td width="10%">id</td><? } ?>
                    <td width="<? if ($type==4) { ?>30%<? } else { ?>50%<? } ?>">车款</td>
                    <td width="<? if ($type==4) { ?>8%<? } else { ?>10%<? } ?>">指导价</td>                    
                    <td width="<? if ($type==4) { ?>8%<? } else { ?>10%<? } ?>"><? if ($type==2) { ?>成本价<? } elseif($type==4) { ?>商情价<? } else { ?>最多人购买价<? } ?></td>
					<? if ($type==4) { ?><td width="9%">优惠幅度</td><? } ?>
                    <td width="10%"><? if ($type==4) { ?>获取时间<? } else { ?>录入时间<? } ?></td>
                    <td width="10%">上次修改时间</td>
                    <? if ($type==4) { ?><td width="10%">责任人</td><? } ?>
                    <td width="<? if ($type==4) { ?>5%<? } else { ?>10%<? } ?>">操作</td>
                </tr>
				<? if ($type==4) { ?><tr class='th'><td><input style="float:left" type="checkbox" onclick="selectAllorNone()" /></td><td>全选/全不选<input type="button" onclick="delButton()" value="批量删除" /></td><td></td><td></td><td></td></tr><? } ?>
                <? foreach((array)$list as $k=>$v) {?>
                <tr class='th'>
                    <? if ($type==4) { ?><td><input style="float:left" type="checkbox" name="delist[]" value="<?=$v['id']?>-<?=$v['model_id']?>"/> <span style="float:left"><?=$v['id']?></span></td><? } ?>
                    <td><?=$v['factory_name']?> <?=$v['series_name']?> <?=$v['model_name']?></td>
                    <td><? if ($v['model_price'] > 0) { ?><? echo floatval($v['model_price']) ?>万<? } else { ?>空<? } ?></td>
                    <td><? if ($v['price'] > 0) { ?><? echo floatval($v['price']) ?>万<? } else { ?>空<? } ?></td>
					<? if ($type==4) { ?><td><? if ($v['preferential'] > 0) { ?>优<? echo floatval($v['preferential']) ?>万<? } elseif($v['preferential'] == 0) { ?>--<? } else { ?>加<? echo floatval(abs($v['preferential'])) ?>万<? } ?></td><? } ?>
                    <td><? if ($v['get_time']) { ?><? echo date("Y-m-d", $v['get_time']) ?><? } ?></td>
                    <td><? if ($v['updated']) { ?><? echo date("Y-m-d", $v['updated']) ?><? } ?></td>
					<? if ($type==4) { ?><td><?=$v['creator']?></td><? } ?>
                    <td><a href="index.php?action=bingoprice-edit&model_id=<?=$v['model_id']?>&type=<?=$type?>&id=<?=$v['id']?>&page=<?=$page?>&phpself=<?=$php_self?>">修改</a><? if ($type==4) { ?><a href="index.php?action=cardbpricelog-delprice&delist=<?=$v['id']?>-<?=$v['model_id']?>&phpself=<?=$php_self?>" onclick="return confirm('确定将此记录删除?')">删除</a><? } ?></td>
                </tr>
                <?}?>
                <tr class='ep-pages'>
                    <td colspan="7">
                        <? if ($type==4) { ?><input style="float:left" type="checkbox" onclick="selectAllorNone()" />全选/全不选<input style="float:left" type="button" onclick="delButton()" value="批量删除" /><? } ?><? if ($page_bar) { ?><?=$page_bar?><? } elseif($total) { ?>共<?=$total?>条<? } else { ?>&nbsp<? } ?>
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
	$(".datepicker").datepicker("option","maxDate",new Date());
	
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
