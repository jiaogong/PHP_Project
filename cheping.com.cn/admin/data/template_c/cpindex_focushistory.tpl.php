<? if(!defined('SITE_ROOT')) exit('Access Denied');?>
<? include $this->gettpl('header');?> 
        <div class="user">
            <div class="nav">
                <ul id="nav">
        			<li><a href="<?=$php_self?>focuslist&num=<?=$num?>">信息预览</a></li>
        			<li><a href="javascript:void(0);" class="song">历史信息</a></li>
					<? if ($num==2) { ?>
						<li><a href="<?=$php_self?>hotcarNotice&act=focustwo">逻辑说明</a></li>
					<? } else { ?>
						<li><a href="<?=$php_self?>hotcarNotice&act=focusfive">逻辑说明</a></li>
					<? } ?>
    			</ul>
    		</div>
            <div class="clear"></div>
    <div class="user_con">
        <div class="user_con1">
			<form method="post" action="<?=$php_self?>addFocusFive" enctype="multipart/form-data">
			<table cellpadding="0" cellspacing="0" class="table2" border="0">
				<tr>
					<td>图片顺序</td>
					<? foreach((array)$historydate as $val) {?>
						<td><?=$val?></td>
					<? } ?>
				</tr>
				<? foreach((array)$historyinfo as $key=>$val) {?>
					<tr>
						<td><?=$key?></td>
						<? foreach((array)$val as $v) {?>
							<td><?=$v?></td>
						<?}?>
					</tr>
				<? } ?>
			</table>
			</form>
			<? if ($page_bar) { ?>
			<div>
				<div class="ep-pages">
					<?=$page_bar?>
				</div>
			</div>
			<? } ?>
        </div>
		<div class="user_con2"><img src="<?=$admin_path?>images/conbt.gif"  height="16" /></div>
    </div>
</div>
    </body>
</html>