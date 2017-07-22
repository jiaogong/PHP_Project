<? if(!defined('SITE_ROOT')) exit('Access Denied');?>
﻿<div id="fsD1" class="banner">  <!--轮播-->
    <div id="D1pic1" class="fPic">
        <? foreach((array)$banner as $key=>$value) {?>
        <? if ($key==0) { ?>
        <div class="fcon" style="display: none;">
            <a target="_blank" href="<?=$value['url']?>"><img src="/attach/<?=$value['pic']?>" style="opacity: 1; "  alt="<?=$value['alt']?>"></a>
                      <a href="<?=$value['url']?>" class="banner_biaoti"><?=$value['title']?></a>
           <? if ($value['taglist']) { ?>
            <? foreach((array)$value['taglist'] as $k=>$v) {?>
            <a href="/article.php?action=ActiveList&id=<?=$v[id]?>" class="bq0"><div class="red"></div><font style="float:left; margin-left:5px;"><?=$v[tag_name]?></font></a>
            <?}?>
            <? } ?>
        </div>
        <? } else { ?>
        <div class="fcon" style="display: none;">
            <a target="_blank" href="<?=$value['url']?>"><img class="lazyimg" data-original="/attach/<?=$value['pic']?>" src="../images/loading_img/1180x400.png" style="opacity: 1; "  alt="<?=$value['alt']?>"></a>
            <a href="<?=$value['url']?>" class="banner_biaoti"><?=$value['title']?></a>
            <? if ($value['taglist']) { ?>
            <? foreach((array)$value['taglist'] as $k=>$v) {?>
            <a href="/article.php?action=ActiveList&id=<?=$v[id]?>" class="bq0"><div class="red"></div><font style="float:left; margin-left:5px;"><?=$v[tag_name]?></font></a>
            <?}?>
            <? } ?>
        </div>
        <? } ?>
        <?}?>
    </div>
    <div class="fbg">  
        <div class="D1fBt" id="D1fBt">  
            <? foreach((array)$banner as $key=>$value) {?>
            <a href="javascript:void(0)" hidefocus="true" target="_self" class=""><?=$value['title3']?></a>
           <?}?>
        </div>  
    </div>  
	
    </div>  
       
</div> 
