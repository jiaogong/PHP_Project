<? if(!defined('SITE_ROOT')) exit('Access Denied');?>
﻿<div class="main_left"><!--首页视频列表-->
    <div class="hot_chexing"><a class="a1" href="javascript:void(0)" style="margin-left:5px;cursor:default"></a></div>
    <? foreach((array)$value as $k=>$v) {?>
    <? if ($k<30) { ?>
    <? if ($v[cname]=='article') { ?>
    <h5>
        <div class="left_list" style="">
            <div class="list_tupian" style=""><a href="<?=$v['url']?>" target="_blank"><img src="/attach/<?=$v[pic]?>" width="280" height="186"  alt="<?=$v[alt]?>"></a></div>
            <a href="/article.php?action=CarReview&id=<?=$v[p_category_id]?>" target="_blank"><div class="fanwei"><?=$v[p_category_name]?></div></a>
            <div class="jieshao" ><a href="<?=$v['url']?>" target="_blank"><?=$v[title]?></a></div>
            <div class="list_biaoqian"><? foreach((array)$v[tag_list] as $kk=>$vv) {?><? if ($kk<3) { ?><a href="/article.php?action=ActiveList&id=<?=$vv['tag_id']?>" target="_blank"><?=$vv['tag_name']?></a>&nbsp;<? } ?><?}?></div>
            <div class="list_time"><? echo date('Y.m.d',$v[uptime]) ?></div>
        </div>
    </h5>
    <? } else { ?>
    <h5>
        <div class="left_list">
            <span><a href="<?=$v['url']?>" target="_blank"><img src="/attach/<?=$v[pic]?>" width="280" height="186"  alt="<?=$v[alt]?>"/></a></span>
            <span class="span-img"><a href="<?=$v['url']?>" target="_blank"><img src="images/point2.png"  /></a></span>
            <a href="/video.php?action=Video&id=<?=$v[p_category_id]?>" target="_blank"><span class="span-zi" style="width: 55px; height:30px; line-height:30px;"><?=$v[p_category_name]?></span></a>
            <span class="span1" style="margin-top:5px;"><a href="<?=$v['url']?>" target="_blank"><?=$v[title]?></a></span>
            <p class="pred ">
                <span><? foreach((array)$v[tag_list] as $kk=>$vv) {?><? if ($kk<3) { ?><a href="/article.php?action=ActiveList&id=<?=$vv['tag_id']?>" target="_blank"><?=$vv['tag_name']?></a>&nbsp;<? } ?><?}?></span>
            </p>
            <div class="list_time fr" ><? echo date('Y.m.d',$v[uptime]) ?></div>
        </div>
    </h5>
    <? } ?>
    <? } ?>
    <?}?>
</div> 