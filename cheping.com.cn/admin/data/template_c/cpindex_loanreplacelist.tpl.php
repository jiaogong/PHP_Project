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
			<form method="post" action="<?=$php_self?>addFocusFive">
			<table cellpadding="0" cellspacing="0" class="table2" border="1">
				<tr>
					<td>图片顺序</td>
					<? foreach((array)$pagedate as $k=>$v) {?>
						<? if ($k==1) { ?>
							<td><?=$v?><br/>当天</td>
						<? } else { ?>
							<td><?=$v?></td>
						<? } ?>
					<?}?>
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
						<? if ($pagedata[$i]) { ?>
							<? for($j=0; $j<10; $j++) { ?>
								<? if ($pagedata[$i][$j]) { ?><td><?=$pagedata[$i][$j]['series_alias']?><br/><?=$pagedata[$i][$j]['state']?></td><? } else { ?><td style="background-color:red">未录入</td><? } ?>
							<? } ?>
						<? } else { ?>
							<td style="background-color:red">未录入</td>
							<td style="background-color:red">未录入</td>
							<td style="background-color:red">未录入</td>
							<td style="background-color:red">未录入</td>
							<td style="background-color:red">未录入</td>
							<td style="background-color:red">未录入</td>
							<td style="background-color:red">未录入</td>
							<td style="background-color:red">未录入</td>
							<td style="background-color:red">未录入</td>
							<td style="background-color:red">未录入</td>
						<? } ?>
					</tr>
				<? } ?>
				<tr>
					<td></td>
					<? foreach((array)$statedata as $val) {?>
						<? if ($val['s']==2) { ?>
							<td><a href="<?=$php_self?>loanreplaceact&start_time=<?=$val['date']?>&id=<?=$val['id']?>" target="_blank">修改</a></td>
						<? } elseif($val['s']==0) { ?>
							<td><a href="<?=$php_self?>makeloanreplace&id=<?=$val['id']?>">生成</a></td>
						<? } elseif($val['s']==3) { ?>
							<td><a href="<?=$php_self?>loanreplaceact&start_time=<?=$val['date']?>" target="_blank">录入</a></td>
						<? } else { ?>
							<td></td>
						<? } ?>
					<? } ?>
				</tr>
			</table>
			</form>
        </div>
		<div class="user_con2"><img src="<?=$admin_path?>images/conbt.gif"  height="16" /></div>
    </div>
</div>
</body>
</html>