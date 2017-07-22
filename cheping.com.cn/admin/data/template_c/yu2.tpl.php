<? if(!defined('SITE_ROOT')) exit('Access Denied');?>
<? include $this->gettpl('header');?>
<div class="user">
	<div class="nav">
		<ul id="nav">
	  <li><a href="<?=$php_self?>">全库价格管理</a></li>
	  <li><a href="" class="song">全车款价格管理</a></li>
	</ul>
	</div>
	<div class="clear"></div>
    <div style="padding-top: 13px;">
        <div style="padding: 10px 0;">
            <form id="search_form" name="search_form" method="post" action="?action=yu-yu2">
				<table class="table2" border="0" cellpadding="0" cellspacing="0" style="text-align:left; width: 1500px;;">
					<tr>
						<td colspan="3">获取时间：<input type="text" class="datepicker" style="width:110px;" name="date_start" />--<input type="text" class="datepicker" style="width:110px;" name="date_end" /></td>
						<td><a href="<?=$jump_url?>">导出搜索表格</a></td><td></td><td></td><td></td><td></td>
					</tr>
					<tr>
						<td width="20%">信息获取方式-<select name="from_type">
							<option value="0">全部</option>
							<option value="到店暗访">到店暗访</option>
							<option value="电话暗访">电话暗访</option>
							<option value="网络双11">网络双11</option>
							<option value="网络报价">网络报价</option>
						</select></td>
						<td width="20%">信息获取渠道-<select name="from_channel">
							<option value="0">全部</option>
							<? foreach((array)$from_channel as $fck=>$fcv) {?>
								<option value="<?=$fck?>"><?=$fck?></option>
							<?}?>
							<!--<option value="汽车之家">汽车之家</option>
							<option value="车多少">车多少</option>
							<option value="搜狐汽车">搜狐汽车</option>
							<option value="天猫">天猫</option>
							<option value="易车网">易车网</option>
							<option value="冰狗购车网">冰狗购车网</option>-->
						</select></td>
						<td width="20%">信息获取渠道分支-<select name="activity_property">
							<option value="0">全部</option>
							<? foreach((array)$activity_property as $apk=>$apv) {?>
								<option value="<?=$apv?>"><?=$apv?></option>
							<?}?>
							<!--<option value="车多少">车多少</option>
							<option value="汽车之家">汽车之家</option>
							<option value="搜狐汽车">搜狐汽车</option>
							<option value="天猫">天猫</option>
							<option value="易车惠大团购">易车惠大团购</option>
							<option value="易车惠特卖场">易车惠特卖场</option>
							<option value="常规报价">常规报价</option>
							<option value="冰狗暗访员">冰狗暗访员</option>-->
						</select></td>
						<td width="13%">
							<select name="brand_id" class="brand_id">
								<option value="">==请选择品牌==</option>
								<? foreach((array)$brand as $k=>$v) {?>
								<option value="<?=$v['brand_id']?>"><?=$v['letter']?> <?=$v['brand_name']?></option>
								<?}?>
							</select>
						</td>
						<td width="13%">
							<select name="factory_id" class="factory_id">
								<option value="">==请选择厂商==</option>
								<? foreach((array)$factory as $k=>$v) {?>
								<option value="<?=$v['factory_id']?>" <? if ($factory_id==$v['factory_id']) { ?>selected="selected"<? } ?>><?=$v['factory_name']?></option>
								<?}?>
							</select> 
						</td>
						<td width="13%">
							<select name="series_id" class="series_id">
								<option value="">==请选择车系==</option>
								<? foreach((array)$series as $k=>$v) {?>
								<option value="<?=$v['series_id']?>" <? if ($series_id==$v['series_id']) { ?>selected="selected"<? } ?>><?=$v['series_name']?></option>
								<?}?>
							</select>  
						</td>
					</tr>
						<tr>
						<td>
							<select name="brand_import" class="model_id">
								<option value="">==国别==</option>
								<option value="1">自主</option>
								<option value="2">美系</option>
								<option value="3">日系</option>
								<option value="4">欧系</option>
								<option value="5">韩系</option>
							</select>  
						</td><td>
							<select name="type_name" id="series_id">
								<option value="">==级别==</option>
								<option value="微型车（A00级）">微型车（A00级）</option>
								<option value="小型车（A0）">小型车（A0）</option>
								<option value="紧凑型车（A级）">紧凑型车（A级）</option>
								<option value="中型车（B级车）">中型车（B级车）</option>
								<option value="中大型车（C级车）">中大型车（C级车）</option>
								<option value="豪华车（D级车）">豪华车（D级车）</option>
								<option value="小型SUV">小型SUV</option>
								<option value="小型MPV">小型MPV</option>
								<option value="跑车">跑车</option>
								<option value="中大型SUV">中大型SUV</option>
								<option value="中大型MPV">中大型MPV</option>
							</select>  
						</td><td></td><td></td><td></td>
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
							<select name="order_mode[]"><option value="0">无</option><option value="SORT_ASC">升序</option><option value="SORT_DESC">降序</option></select>
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
					<td><input type="hidden" name="date_start1" value="<?=$date_start1?>" /><input type="hidden" name="date_end1" value="<?=$date_end1?>" /><input type="hidden" name="from_type1" value="<?=$from_type1?>" /><input type="hidden" name="fstate" value="1" /><input type="hidden" name="dstate" value="1" /><input type="button" value="搜索" onclick="checkSub()" /></td><td></td></tr>
				</table>
			</form>
					
            <table class="table2" id="pricelist" border="0" cellpadding="0" cellspacing="0" style="table-layout:fixed;word-wrap: break-word;width: 1500px;">
                <tr align="right"  class='th'>
                    <td width="5%" align="center">品牌</td>
                    <td width="10%" align="center">厂商</td>
                    <td width="10%" align="center">车系</td>
                    <td width="15%" align="center">车款</td>
                    <td width="1%" align="center">入库总数</td>
                    <td align="center">指导价</td>
					<td align="center">均价</td>
                    <td align="center">变化值</td>
                    <td align="center">最低价</td>
                    <td align="center">最低价渠道</td>
                    <td align="center">最低价时间</td>
					<td align="center">暗访均价</td>
                    <td align="center">暗访最低价</td>
                    <td align="center">获取时间</td>
                    <td align="center">暗访最近价</td>
                    <td align="center" >获取时间</td>
					<td width="1%" align="center">暗访总数</td>
                </tr>
				<? foreach((array)$list as $k=>$v) {?>
				<tr class='th'>
					<td><?=$v['brand_name']?></td>
					<td><?=$v['factory_name']?></td>
					<td><?=$v['series_name']?></td>
					<td><?=$v['model_name']?></td>
					<td><?=$v['all_total']?></td>
					<td><?=$v['model_price']?></td>
					<td><?=$v['avg_price']?></td>
					<td><?=$v['variation_val']?></td>
					<td><?=$v['low_price']?></td>
					<!--<td><?=$v['lowprice_fromchannel']?></td>-->
					<td><?=$v['lowprice_fromchannel']?></td>
					<td><? if ($v['lowprice_gettime']>1) { ?><? echo date('Y-m-d',$v['lowprice_gettime']) ?><? } ?></td>
					<td><?=$v['bg_avg_price']?></td>
					<td><?=$v['bg_low_price']?></td>
					<td><? if ($v['bg_get_time']>1) { ?><? echo date('Y-m-d',$v['bg_get_time']) ?><? } ?></td>
					<td><?=$v['bg_last_price']?></td>
					<td><? if ($v['bg_last_gettime']>1) { ?><? echo date('Y-m-d',$v['bg_last_gettime']) ?><? } ?></td>
					<td><?=$v['bg_total']?></td>
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
var searchHtml = {
	'到店暗访':{'冰狗购车网':['冰狗暗访员']},
	'电话暗访':{'冰狗购车网':['冰狗暗访员']},
	'网络双11':{'汽车之家':['汽车之家'],'车多少':['车多少'],'搜狐汽车':['搜狐汽车'],'天猫':['天猫'],'易车网':['易车惠大团购','易车惠特卖场']},
	'网络报价':{'汽车之家':['汽车之家']}
}
$(document).ready(function(){
	$(".datepicker").datepicker("option","maxDate",new Date());
	//var s1 = 
	$("select[name='from_type']").change(function(){
		var selectVal = $(this).val();
		$(this).parent().next().find("select option[value!='0']").remove();
		$(this).parent().next().next().find("select option[value!='0']").remove();
		$.each(searchHtml[selectVal],function(i,v){
			$("select[name='from_channel']").append('<option value='+i+'>'+i+'</option>');
		})
	})

	$("select[name='from_channel']").change(function(){
		var selectVal2 = $(this).val();
		var selectVal = $("select[name='from_type']").val();
		$(this).parent().next().find("select option[value!='0']").remove();
		$.each(searchHtml[selectVal][selectVal2],function(i,v){
			$("select[name='activity_property']").append('<option value='+v+'>'+v+'</option>');
		})
	})


	$('.brand_id').change(function(){
		var brand_id=$(this).val();
		var facturl="?action=factory-json&brand_id="+brand_id;
		var sel=this;
		//$('#brand_name').val(sel.options[sel.selectedIndex].text)

		$.getJSON(facturl, function(ret){
			$(sel).parent().next().find("select option[value!='']").remove();
			$(sel).parent().next().next().find("select option[value!='']").remove();
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

})
function exportSeries(){
	var sid = $(this).parent().prev().find('select').val();
	var url = "?action=yu-exportSeries&sid="+sid;
	$.get(url);
}

function checkSub(){
	$("#search_form").submit();
	return false;
	var seriesInfo = $(".series_id").val();
	if(seriesInfo){
		$("#search_form").submit();
	}else{
		alert('必须选择一个车系');
		return false;
	}
}
</script>
<? include $this->gettpl('footer');?>