<? if(!defined('SITE_ROOT')) exit('Access Denied');?>
<div class="hd">
    <span></span>
    <? foreach((array)$bulletin as $k=>$art) {?>
        <a class="a<?=$k?>" href="html/article/<? echo date('Ym', $art['created']) ?>/<? echo date('d', $art['created']) ?>/<?=$art['id']?>.html"><?=$art['title']?> <?=$art['title2']?></a>
    <?}?>
</div>    