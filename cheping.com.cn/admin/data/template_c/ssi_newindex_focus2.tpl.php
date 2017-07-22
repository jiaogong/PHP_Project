<? if(!defined('SITE_ROOT')) exit('Access Denied');?>
<div class="banner_tu_right">
    <? foreach((array)$result as $k=>$v) {?>
    <? $titleArr = explode('|', $v['title']) ?>
    <? $title1 = $titleArr[0] ?>
    <? $title2 = $titleArr[1] ?>
    <div class="<? if ($k == 1) { ?>tu_right_shang<? } else { ?>tu_right_xia<? } ?>">
        <img title="<?=$title1?>" src="/attach/images/model/<?=$v['model_id']?>/<?=$v['pic']?>" onerror="this.src='/images/180x100.jpg'" width="178" height="135" >
        <div style="display: block; top: 103px;" class="banner_dibu">
            <em class="banner_dibushow"></em>
            <a href="<?=$v['url']?>" target="_blank" style="cursor: pointer;">
                <span style="top: 0px;">
                    <p class="hover_title" style="text-decoration: none;"><?=$title1?></p>
                    <p style=" line-height:20px; font-size:12px; width:147px; margin:0 15px;"><?=$title2?></p>
                </span>
            </a>
        </div>
    </div>
    <?}?>
</div>