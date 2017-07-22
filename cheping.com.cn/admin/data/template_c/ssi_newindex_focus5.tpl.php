<? if(!defined('SITE_ROOT')) exit('Access Denied');?>
<div class="banner_tu_left">
	<ul class="banner_guntu" style="width:2534px; left:-362px;">
		<? $firstResult = reset($result); ?>
		<? $lastResult = end($result); ?>
		<? $firstTitle = explode('|', $firstResult['title']) ?>
		<? $lastTitle = explode('|', $lastResult['title']) ?>
		<li><a href="<?=$lastResult['url']?>" target="_blank"> <img title="<?=$lastTitle[0]?>" src="<? if ($lastResult['createfiletime']) { ?>/attach/images/focus/<?=$lastResult['createfiletime']?>/<?=$lastResult['pic']?><? } else { ?>/attach/images/adpic/focus/<?=$lastResult['pic']?><? } ?>" width="362" height="274" alt="<?=$lastResult['picalt']?>"></a></li>
		<? foreach((array)$result as $k=>$v) {?>
			<? $titleArr = explode('|', $v['title']) ?>
			<? $title = $titleArr[0] ?>
			<li><a href="<?=$v['url']?>" target="_blank"> <img title="<?=$title?>" src="<? if ($v['createfiletime']) { ?>/attach/images/focus/<?=$v['createfiletime']?>/<?=$v['pic']?><? } else { ?>/attach/images/adpic/focus/<?=$v['pic']?><? } ?>" width="362" height="274" alt="<?=$v['picalt']?>"></a></li>
        <?}?>
		<li><a href="<?=$firstResult['url']?>" target="_blank"> <img title="<?=$firstTitle[0]?>" src="<? if ($firstResult['createfiletime']) { ?>/attach/images/focus/<?=$firstResult['createfiletime']?>/<?=$firstResult['pic']?><? } else { ?>/attach/images/adpic/focus/<?=$firstResult['pic']?><? } ?>" width="362" height="274" alt="<?=$firstResult['picalt']?>"></a></li>
	</ul>
	<div class="gundong_show">
		<em class="gd_show"></em>
		<? foreach((array)$result as $k=>$v) {?>
			<? $titleArr = explode('|', $v['title']) ?>
			<? $title = $titleArr[0] ?>
			<? if ($k==1) { ?>
				<span><a href="<?=$v['url']?>" target="_blank"><?=$title?></a></span>
			<? } else { ?>
				<span style="display:none"><a href="<?=$v['url']?>" target="_blank"><?=$title?></a></span>
			<? } ?>
        <?}?>
	</div>
	<div class="gundong_shu">
		<ul>
		<? foreach((array)$result as $k=>$v) {?>
			<? if ($k==1) { ?>
				<li style="cursor: pointer" class="shu_1 shu_1_hover" onmouseover="coverHover(<?=$k?>);"><?=$k?></li>
			<? } else { ?>
				<li style="cursor: pointer" class="shu_1" onmouseover="coverHover(<?=$k?>);"><?=$k?></li>
			<? } ?>
        <?}?>
		</ul>
	</div>
</div>