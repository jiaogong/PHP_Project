<? if(!defined('SITE_ROOT')) exit('Access Denied');?>
<? foreach((array)$value as $k=>$v) {?>
<? if ($k<20) { ?>
<? if ($v[cname]=='article') { ?>
<li>
    <div class="tupian">
        <span><a href="/wapindex.php/action=final?id=<?=$v[id]?>"><img src="/attach/<?=$v[pic1]?>" width="100%"/></a></span>
        <p><a href="/wapindex.php/action=final?id=<?=$v[id]?>"><?=$v[title]?></a></p>
    </div>     
</li>
<? } else { ?>
<li>
    <div class="video">
        <div class="video-img"> 
            <span><a href="/wapindex.php/action=final?id=<?=$v[id]?>"><img src="/attach/<?=$v[pic1]?>" width="100%"/></a></span>
            <span class="videoimg"><img src="/images/player.png" /></span>
        </div>
        <p><a href="/wapindex.php/action=final?id=<?=$v[id]?>"><?=$v[title]?></a></p>
    </div>     
</li>
<? } ?>
<? } ?>
<?}?>
