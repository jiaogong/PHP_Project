<? if(!defined('SITE_ROOT')) exit('Access Denied');?>
<? include $this->gettpl('header');?>

<style>
   .page_bar_css a{width:20px; display:block;float:left;}
   .page_bar_css span{float:left;}
</style>
	<form action="index.php?action=priceerrorlog-search" method="post">
	<table class="table2" id="pricelist" border="0" cellpadding="0" cellspacing="0" style="table-layout:fixed;word-wrap: break-word;" width="795">
	<tr align="right" class='th'>
		<td>责任人
			<select name='creator'><option value='田伟'>田伟</option><option value='麦锐'>麦锐</option><option value='彭开祺'>彭开祺</option><option value='于文浩'>于文浩</option></select>
		</td>
		
		<td width="60%"><b style="float:left;">操作时间</b>
			<div>
				<input type="text" name="get_time1" class="datepicker" readonly="readonly" style="width:100px; float:left;display:block;" /><span style="width:30px;float:left">:</span>
				<input style="width:30px;float:left" type="text" name="timeh1" size="3" /><span style="width:30px;float:left">:</span>
				<input style="width:30px;float:left" type="text" name="timei1" size="3" /><span style="width:30px;float:left">:</span>
				<input style="width:30px;float:left" type="text" name="times1" size="3" />
			</div>
			<div style="margin-top:20px;">
				<input type="text" name="get_time2" class="datepicker" readonly="readonly" style="width:100px; float:left;display:block;"/><span style="width:30px;float:left">:</span>
				<input style="width:30px;float:left" type="text" name="timeh2" size="3" /><span style="width:30px;float:left">:</span>
				<input style="width:30px;float:left" type="text" name="timei2" size="3" /><span style="width:30px;float:left">:</span>
				<input style="width:30px;float:left" type="text" name="times2" size="3" />
			</div>
		</td>
		<td>
			<input type="submit" value="搜索" />
		</td>
		
	</tr>
	</table>
	</form>
	<div style="color:red;text-align:center;">车款对不上有可能是数据库车款状态不对，导入价格只导入在售的车款</div>
	<table width="795" style="text-align:center;">
	<tr align="center"  class='th'>
		<td>表格名称</td>
		<td >责任人</td>
		<td >未匹配行号</td>
		<td>不匹配项</td>
		<td>操作时间</td>
	</tr>
	<? foreach((array)$allerrorlog as $k=>$v) {?>
	<tr class='th'>
		<td><?=$v['csv_name']?></td>
		<td><?=$v['creator']?></td>
		<td><?=$v['excel_row']?></td>
		<td><?=$v['content']?></td>
		<td><? echo date('Y/m/d h:i:s', $v['created']) ?></td>
		</td>
	</tr>
	<?}?>
</table>
<? if ($page_bar) { ?>
<div>
	<div class="ep-pages">
		<? if ($total) { ?>共<?=$total?>条&nbsp<? } ?><?=$page_bar?>
	</div>
</div>
<? } ?>
<script type="text/javascript">
	$('.datepicker').datepicker();
	$('.datepicker').datepicker('option', 'maxDate', new Date());
</script>
<? include $this->gettpl('footer');?>