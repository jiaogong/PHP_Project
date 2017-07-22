<? if(!defined('SITE_ROOT')) exit('Access Denied');?>
<div class="s_right_shang">
    <div class="i-tabs">
        <div class="i-tabs-nav" style="cursor: pointer;">
            <? foreach((array)$pr as $k=>$v) {?>
            <span class="i-tabs-item <? if ($k == 1) { ?>i-tabs-item-active<? } ?>" ><a target="_blank" href="<? if ($k == 10) { ?>/search.php?action=index&pr=9&pr=10<? } else { ?>/search.php?action=index&pr=<? echo $k-1 ?><? } ?>"><?=$v?></a></span>
            <?}?>
        </div>   
        <div class="i-tabs-container">
            <? for($i=0; $i<10; $i++) { ?>
            <div class="i-tabs-content <? if ($i == 0) { ?>i-tabs-content-active<? } ?>">
                <div class="tabs-news-module">
                    <? for($j=1; $j<4; $j++) { ?>
                    <ul <? if ($j == 3) { ?>style="background:none;"<? } ?>>
                        <? for($k=1; $k<11; $k++) { ?>
                        <? $key = $j + ($k - 1) * 3 ?>
                        <li><a target="_blank" href="/modelinfo_s<? echo $result[$i][$key]['series_id'] ?>.html"><? echo $result[$i][$key]['alias'] ?></a></li>
                        <? } ?>
                    </ul>
                    <? } ?>
                </div>
            </div>
            <? } ?>
        </div>
    </div>
</div>
