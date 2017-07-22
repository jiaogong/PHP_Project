<? if(!defined('SITE_ROOT')) exit('Access Denied');?>
<? include $this->gettpl('header');?>
<div class="user">
	<div class="nav">
		<ul id="nav">
        <li><a href="javascript:void(0);" class="song">信息预览</a></li>
		<li><a href="<?=$php_self?>hotcarNotice&act=loanreplace">逻辑说明</a></li>
    	</ul>
	</div>
	<div class="clear"></div>
    <div class="user_con">
        <div class="user_con1">
			<form method="post" action="<?=$php_self?>loanreplaceadd">
			<table cellpadding="0" cellspacing="0" class="table2">
				<tr>
					<td>模块名称</td>
					<td>昨日车系</td>
					<td>今日车系</td>
					<td>暗访价ID</td>
				</tr>
				<? for($i=0; $i<8; $i++) { ?>
					<tr>
						<td>
							<? if ($i<4) { ?>
								<? echo '置换' . ($i+1) ?>
							<? } else { ?>
								<? echo '贷款' . ($i-3) ?>
							<? } ?>
						</td>
						<td>
							<? if ($yesterdaydata[$i]) { ?>
								<?=$yesterdaydata[$i]['series_alias']?>
							<? } else { ?>
								无更新
							<? } ?>
						</td>
						<td>
							<? if ($loanreplacedata[$i]) { ?>
								<?=$loanreplacedata[$i]['series_alias']?>
							<? } else { ?>
								无更新
							<? } ?>
						</td>
						<td>
							<? if ($loanreplacedata[$i]) { ?>
								<input type="text" value="<?=$loanreplacedata[$i]['pricelog_id']?>" name="bingoprice_i[]" />
							<? } else { ?>
								<input type="text" value="无更新" name="bingoprice_i[]" />
							<? } ?>
						</td>
					</tr>
				<? } ?>
				<tr><td><input type="hidden" value="<?=$start_time?>" name="start_time" /><input type="hidden" value="<?=$id?>" name="id" /><input type="submit" /></td></tr>
			</table>
			</form>
        </div>
		<div class="user_con2"><img src="<?=$admin_path?>images/conbt.gif"  height="16" /></div>
    </div>
</div>
</body>
</html>