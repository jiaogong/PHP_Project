<? if(!defined('SITE_ROOT')) exit('Access Denied');?>
<? include $this->gettpl('header');?>
<div class="user">
    <div class="nav">
        <ul id="nav">
            <li><a href="javascript:;"  class="song">媒体价列表</a></li>
        </ul>
    </div>
    <div class="clear"></div>
    <div class="user_con">
        <div class="user_con1">
            <form id="search_form" name="search_form" method="post" action="index.php?action=cardbprice-mediaprice">
            <table class="table2" border="0" cellpadding="0" cellspacing="0">
                <tr>
				<td style="float:left">
                        <select name="brand_id" id="brand_id">
                        <option value="">==请选择品牌==</option>
                        <? foreach((array)$brand as $k=>$v) {?>
                        <option value="<?=$v['brand_id']?>" <? if ($brand_id==$v['brand_id']) { ?>selected="selected"<? } ?>><?=$v['letter']?> <?=$v['brand_name']?></option>
                        <?}?>
                      </select>
                      <select name="factory_id" id="factory_id">
                        <option value="">==请选择厂商==</option>
                        <? foreach((array)$factory_data as $k=>$v) {?>
                        <option value="<?=$v['factory_id']?>" <? if ($factory_id==$v['factory_id']) { ?>selected="selected"<? } ?>><?=$v['factory_name']?></option>
                        <?}?>                        
                      </select>                            
                      <select name="series_id" id="series_id">
                        <option value="">==请选择车系==</option>
                        <? foreach((array)$series_data as $k=>$v) {?>
                        <option value="<?=$v['series_id']?>" <? if ($series_id==$v['series_id']) { ?>selected="selected"<? } ?>><?=$v['series_name']?></option>
                        <?}?>                        
                      </select>               
                      <select name="model_id" id="model_id" style="width:160px">
                        <option value="">==请选择车款==</option>
                        <? foreach((array)$model_data as $k=>$v) {?>
                        <option value="<?=$v['model_id']?>" <? if ($model_id==$v['model_id']) { ?>selected="selected"<? } ?>><?=$v['model_name']?></option>
                        <?}?>                        
                      </select>                         
                      <input id="search_btn" name="search_btn" type="submit" value="搜索" />                    
                    </td>
                </tr>
            </table>
            </form>
			<input type="hidden" value="<?=$jump_url?>" id="jump_url" />
            <table class="table2" id="pricelist" border="0" cellpadding="0" cellspacing="0" style="table-layout:fixed;word-wrap: break-word;">
                <tr align="right"  class='th'>
                    <td width="30%" align="center">车款</td>
                    <td width="10%" align="center">上次价格</td>
                    <td width="10%" align="center">新抓价格</td>
                    <td width="10%" align="center">差价</td>
                    <td width="10%" align="center">本月商情价</td>
                    <td width="10%" align="center">获取时间</td>
                    <td width="10%" align="center">操作</td>
                </tr>
                <? foreach((array)$mediainfo as $mikey=>$milist) {?>
                <tr class='th' id='tr<?=$mikey?>'>
                    <td><?=$milist['series_name']?> <?=$milist['model_name']?></td>
                    <td><? if ($milist['prev_media_price'] == "") { ?>无<? } else { ?><?=$milist['prev_media_price']?>万<? } ?></td>
                    <td><? if ($milist['price'] == "") { ?>无<? } else { ?><?=$milist['price']?>万<? } ?></td>
                    <td><? if ($milist['spread'] != '0.00' && $milist['spread'] != "") { ?><span style="color:red"><? if ($milist['spread'] > 0) { ?>升<? echo abs($milist['spread']) ?><? } else { ?>降<? echo abs($milist['spread']) ?><? } ?>万</span><? } else { ?>0<? } ?></td>
                    <td><? if (empty($milist['bingo_price'])) { ?>暂无<? } else { ?><?=$milist['bingo_price']?>万<? } ?></td>
                    <td><? echo date('Y-m-d H:i:s',$milist['get_time']) ?></td>
                    <td><a href="javascript:addinput('<?=$mikey?>','<?=$milist['model_id']?>', '<?=$milist['price']?>')">修改</a></td>
                </tr>
                <?}?>
                <tr class='ep-pages'>
                    <td colspan="7">
					<? if ($type==4) { ?><input style="float:left" type="checkbox" onclick="selectAllorNone()" />全选/全不选<input style="float:left" type="button" onclick="delButton()" value="批量删除" /><? } ?> <? if ($page_bar) { ?><?=$page_bar?><? } elseif($total) { ?>共<?=$total?>条<? } else { ?>&nbsp<? } ?>
                    </td>
                </tr>
            </table>
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

function addinput(id,model_id,price){
	if(model_id == "" || price == '' || price == '0.00'){
		alert('该车款id没有或者没有新抓价格');
		return;	
	}
	$('#tr' + id).after('<tr style="border: 1px solid red" id="tr16" class="th"><td></td><td></td><td><input id="input' + id +'" type="text" value="" size="5" />万</td><td></td><td><a href="javascript:urljump(' + id + ',' + model_id + ',' + price + ')">保存</a></td></tr>');
}
function urljump(id,model_id,price){
	if(model_id == "" || price == '' || price == '0.00'){
		alert('该车款id没有或者没有新抓价格');
		return;	
	}
	var inputvalue = $('#input' + id).val();
	var jump_url = $('#jump_url').val();
	window.location.href='index.php?action=cardbprice-UpdateMediaprice&id=' + model_id + '&price=' + inputvalue + '&oldprice=' + price + '&jump_url=' + jump_url;
}
</script>
<? include $this->gettpl('footer');?>
