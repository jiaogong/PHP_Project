<? if(!defined('SITE_ROOT')) exit('Access Denied');?>
<? include $this->gettpl('header');?> 
<div class="user">
    <div class="nav">
        <ul id="nav">
        <li><a href="javascript:void(0);" class="song">信息预览</a></li>
        <li><a href="<?=$php_self?>modelpkact">操作</a></li>
    </ul>
    </div>
    <div class="clear"></div>
    <div class="user_con">
        <div class="user_con1">
			<form method="post" action="<?=$php_self?>addFocusFive" enctype="multipart/form-data">
			<table cellpadding="0" cellspacing="0" class="table2">
				<? if ($pkinfo) { ?>
					<? foreach((array)$pkinfo as $key=>$val) {?>
					<tr>
						<td><? echo $key+1 ?></td>
						<td><?=$val[0]['series_alias']?></td>
						<td><?=$val[1]['series_alias']?></td>
						<td><? if ($val['created']) { ?><? echo date('Y-m-d h:i:s', $val['created']) ?><? } ?></td>
						<td><a href="<?=$php_self?>ModelPKAct&id=<?=$val['id']?>&event=edit">修改</a></td>
					</tr>
					<?}?>
				<? if ($page_bar) { ?>
					<tr>
						<td colspan="3">
							<div class="ep-pages">
								<?=$page_bar?>
							</div>
						</td>
					</tr>
				<? } ?>
				<? } else { ?>
				<tr><td>没有信息！</td></tr>
				<? } ?>
			</table>
			</form>
			<p>请确认当前pk车款有5个时才点击生成&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?=$php_self?>makemodelpk">生成</a></p>
        </div>
		<div class="user_con2"><img src="<?=$admin_path?>images/conbt.gif"  height="16" /></div>
    </div>
</div>
    </body>
</html>