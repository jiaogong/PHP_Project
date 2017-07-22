<? if(!defined('SITE_ROOT')) exit('Access Denied');?>
<? include $this->gettpl('header');?>
<div class="user">
	<div class="nav">
		<ul id="nav">
	  <li class="li2"><a href="" class="song">全库价格管理</a></li>
	  <li><a href="<?=$php_self?>yu2">全车款价格管理</a></li>
	</ul>
	</div>
	<div class="clear"></div>
    <div style="padding-top: 13px;">
        <div style="padding: 10px 0;">
            <form id="search_form" name="search_form" method="post" action="?action=yu">
				<table class="table2" border="0" cellpadding="0" cellspacing="0" style="text-align:left; width:1100px;">
					<tr>
						<td colspan="2">获取时间：<input type="text" readonly="readonly" class="datepicker" style="width:110px;" name="date_start" />--<input type="text" readonly="readonly" class="datepicker" style="width:110px;" name="date_end" /></td>
						<td><a href="<?=$jump_url1?>">导出搜索表格</a></td><td></td><td></td><td></td><td></td>
					</tr>
					<tr>
						<td>信息获取方式-<select name="from_type">
							<option value="0">全部</option>
							<option value="到店暗访">到店暗访</option>
							<option value="电话暗访">电话暗访</option>
							<option value="网络双11">网络双11</option>
							<option value="网络报价">网络报价</option>
						</select></td>
						<td colspan="2">信息获取渠道-<select name="from_channel">
							<option value="0">全部</option>
							<option value="汽车之家">汽车之家</option>
							<option value="车多少">车多少</option>
							<option value="搜狐汽车">搜狐汽车</option>
							<option value="天猫">天猫</option>
							<option value="易车网">易车网</option>
							<option value="冰狗购车网">冰狗购车网</option>
						</select></td>
						<td colspan="2">信息获取渠道分支-<select name="activity_property">
							<option value="0">全部</option>
							<option value="车多少">车多少</option>
							<option value="汽车之家">汽车之家</option>
							<option value="搜狐汽车">搜狐汽车</option>
							<option value="天猫">天猫</option>
							<option value="易车惠大团购">易车惠大团购</option>
							<option value="易车惠特卖场">易车惠特卖场</option>
							<option value="常规报价">常规报价</option>
							<option value="冰狗暗访员">冰狗暗访员</option>
						</select></td>
						<td></td><td></td><td></td>
					</tr>
					<tr>
						<td width="20%">
							<select name="brand_id" class="brand_id">
								<option value="">==请选择品牌==</option>
								<? foreach((array)$brand as $k=>$v) {?>
								<option value="<?=$v['brand_id']?>"><?=$v['letter']?> <?=$v['brand_name']?></option>
								<?}?>
							</select>
						</td>
						<td width="25%">
							<select name="factory_id" class="factory_id">
								<option value="">==请选择厂商==</option>
								<? foreach((array)$factory as $k=>$v) {?>
								<option value="<?=$v['factory_id']?>" <? if ($factory_id==$v['factory_id']) { ?>selected="selected"<? } ?>><?=$v['factory_name']?></option>
								<?}?>
							</select> 
						</td>
						<td width="25%">
							<select name="series_id" class="series_id">
								<option value="">==请选择车系==</option>
								<? foreach((array)$series as $k=>$v) {?>
								<option value="<?=$v['series_id']?>" <? if ($series_id==$v['series_id']) { ?>selected="selected"<? } ?>><?=$v['series_name']?></option>
								<?}?>
							</select>  
						</td>
						<td width="10%">
							<select name="brand_import" class="model_id">
								<option value="">==国别==</option>
								<option value="1">自主</option>
								<option value="2">美系</option>
								<option value="3">日系</option>
								<option value="4">欧系</option>
								<option value="5">韩系</option>
							</select>  
						</td><td width="10%">
							<select name="type_name" id="series_id">
								<option value="">==级别==</option>
								<option value="微型车">微型车</option>
								<option value="小型车">小型车</option>
								<option value="紧凑型车">紧凑型车</option>
								<option value="中型车">中型车</option>
								<option value="中大型车">中大型车</option>
								<option value="豪华车">豪华车</option>
								<option value="小型SUV">小型SUV</option>
								<option value="小型MPV">小型MPV</option>
								<option value="跑车">跑车</option>
								<option value="中大型SUV">中大型SUV</option>
								<option value="中大型MPV">中大型MPV</option>
							</select>  
						</td><td width="10%">
							<select name="rate" id="rate">
								<option value="">==0利率==</option>
								<option value="有">有</option>
								<option value="无">无</option>
								<option value="不详">不详</option>
							</select>
						</td>
					</tr>
					<tr>
					<? for($i=1; $i<5; $i++) { ?>
						<? if ($i==4) { ?>
							<td colspan="2"><!--排序方式<?=$i?>-->
						<? } else { ?>
							<td>
						<? } ?>
							<select name="order_name[]">
								<option value="0">排序方式<?=$i?></option>
								<? foreach((array)$temp_order_arr as $orderk=>$orderv) {?>
								<option value="<?=$orderk?>"><?=$orderv?></option>
								<?}?>
							</select>
							<select name="order_mode[]"><option value="0">无</option><option value="asc">升序</option><option value="desc">降序</option></select>
						</td>
					<? } ?>
						<!--<td></td>
						<td>排序方式-折扣<select name="discount"><option value="0">无</option><option value="1">升序</option><option value="2">降序</option></select></td>
						<td>平均折扣<select name="avg_discount"><option value="0">无</option><option value="1">升序</option><option value="2">降序</option></select></td>
						<td>现惠幅度<select name="price_rate"><option value="0">无</option><option value="1">升序</option><option value="2">降序</option></select></td>
						<td>裸车价（万）<select name="nude_car_price"><option value="0">无</option><option value="1">升序</option><option value="2">降序</option></select></td>
					</tr>
					<tr>
						<td>排序方式-均价（万）<select name="avg_price"><option value="0">无</option><option value="1">升序</option><option value="2">降序</option></select></td>
						<td>最低价（万）<select name="price_low"><option value="0">无</option><option value="1">升序</option><option value="2">降序</option></select></td>
						<td>变化值（万）<select name="variation_val"><option value="0">无</option><option value="1">升序</option><option value="2">降序</option></select></td>
						<td>均比<select name="avg_ratio"><option value="0">无</option><option value="1">升序</option><option value="2">降序</option></select></td>
					</tr>
					<tr>
						<td>排序方式-最低比<select name="low_ratio"><option value="0">无</option><option value="1">升序</option><option value="2">降序</option></select></td>
						<td>获取时间<select name="get_time"><option value="0">无</option><option value="1">升序</option><option value="2">降序</option></select></td>
						<td><input type="submit" value="搜索" /></td><td></td>
					</tr>-->
					<td><input type="submit" value="搜索" /></td><td></td></tr>
				</table>
			</form>
					
            <table class="table2" id="pricelist" border="0" cellpadding="0" cellspacing="0" style="table-layout:fixed;word-wrap: break-word;width: 1100px;">
                <tr align="right"  class='th'>
                    <td width="10%" align="center">厂商</td>
                    <td width="10%" align="center">车系</td>
                    <td width="20%" align="center">车款</td>
                    <td width="6%" align="center">折扣</td>
                    <td width="8%" align="center">平均折扣</td>
					<td width="5%" align="center">现惠幅度</td>
                    <td width="8%" align="center">裸车价</td>
                    <td width="8%" align="center">均价</td>
                    <td width="8%" align="center">最低价</td>
                    <td width="8%" align="center">变化值</td>
                    <td width="8%" align="center">均比</td>
					<td width="8%" align="center">最低比</td>
                    <td width="12%" align="center">获取时间</td>
                    <td width="5%" align="center">次数</td>
                    <td width="12%" align="center">信息获取渠道分支</td>
                    <td width="8%" align="center">价格ID</td>
                </tr>
                <? foreach((array)$priceadmin_list as $k=>$v) {?>
                <tr class='th'>
                    <td><?=$v['factory_name']?></td>
                    <td><?=$v['series_name']?></td>
                    <td><?=$v['model_name']?></td>
                    <td><? echo floatval($v['discount']) ?>%</td>
                    <td><? echo floatval($v['avg_discount']) ?>%</td>
                    <td><?=$v['price_rate']?></td>
                    <td><?=$v['nude_car_price']?></td>
                    <td><?=$v['avg_price']?></td>
                    <td><?=$v['price_low']?></td>
                    <td><?=$v['variation_val']?></td>
                    <td><? echo floatval($v['avg_ratio']) ?>%</td>
                    <td><? echo floatval($v['low_ratio']) ?>%</td>
                    <td><? if ($v['get_time']) { ?><? echo date('Y-m-d',$v['get_time']) ?><? } ?></td>
                    <td><?=$v['model_number']?></td>
                    <td><?=$v['activity_property']?></td>
					<? if ($v['price_type']==0) { ?>
						<td><a href="index.php?action=bingoprice-edit&id=<?=$v['source_id']?>&type=4&model_id=<?=$v['model_id']?>&phpself=<?=$jump_url?>"><?=$v['source_id']?></a></td>
					<? } elseif($v['price_type']==5) { ?>
						<td><a href="javascript:void(0);"><?=$v['source_id']?></a></td>
					<? } elseif($v['price_type']==6) { ?>
					    <td><a href="index.php?action=websaleinfo-nov11editlist&id=<?=$v['source_id']?>&price_admin=<?=$jump_url?>"><?=$v['source_id']?></a></td>
					<? } ?>
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
    </div>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$(".datepicker").datepicker("option","maxDate",new Date());

	$('.brand_id').change(function(){
		var brand_id=$(this).val();
		var facturl="?action=factory-json&brand_id="+brand_id;
		var sel=this;
		//$('#brand_name').val(sel.options[sel.selectedIndex].text)

		$.getJSON(facturl, function(ret){
			$(sel).parent().next().find("select option[value!='']").remove();
			$.each(ret, function(i,v){
				$(sel).parent().next().find('select').append('<option value='+v['factory_id']+'>'+v['factory_name']+'</option>');
			});
		});
	});
  
	$('.factory_id').change(function(){
		var fact_id=$(this).val();
		var serurl="?action=series-json&factory_id="+fact_id;
		var sel=this;

		$.getJSON(serurl, function(ret){
			$(sel).parent().next().find("select option[value!='']").remove();
			$.each(ret, function(i,v){
				$(sel).parent().next().find('select').append('<option value='+v['series_id']+'>'+v['series_name']+'</option>');
			});
		});
	});
  
	/*$('#series_id').change(function(){
		var sid=$(this).val();
		var modurl="?action=model-json&sid="+sid;
		var sel=this;
		$.getJSON(modurl, function(ret){
			$(sel).parent().next().find("select option[value!='']").remove();
			$.each(ret, function(i,v){
				$(sel).parent().next().find('select').append('<option>'+v['series_name']+'</option>');
			});
		});
	});*/
	var receiver = <?=$receiver?>;
	$.each(receiver, function(i,v){
		$("[name='"+i+"']").val(v);
	});
	var receiver1 = <?=$receiver1?>;
	$.each(receiver1, function(i,v){
		$("[name='order_name[]']").eq(i).val(v);
	})
	var receiver2 = <?=$receiver2?>;
	$.each(receiver2, function(i,v){
		$("[name='order_mode[]']").eq(i).val(v);
	})
});
function exportSeries(){
	var sid = $(this).parent().prev().find('select').val();
	var url = "?action=yu-exportSeries&sid="+sid;
	$.get(url);
}

</script>
<? include $this->gettpl('footer');?>
