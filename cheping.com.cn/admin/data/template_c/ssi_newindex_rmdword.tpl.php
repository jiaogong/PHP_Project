<? if(!defined('SITE_ROOT')) exit('Access Denied');?>
<div class="left_neirong">
    <? $type = array('家用舒适', '个性运动', '商务行政', 'SUV/MPV'); ?>
    <? for($i=0; $i<4; $i++) { ?>
    <div class="left_neirong_left">
        <h2 style=" height:35px; line-height:35px; text-align:center; font-size:18px; color:#fff; background-color:#ea1a14;" class="neirong_zi">
            <? echo $type[$i] ?>
        </h2>
        <? for($j=1; $j<5; $j++) { ?>
        <? $k = $i * 4 + $j ?>                
        <p class="neirong_zi">
            <? if ($result[$k]['keyword']) { ?>
            <a target="_blank" href="<? echo $result[$k]['url'] ?>"><? echo $result[$k]['keyword'] ?></a>
            <? } ?>
        </p>        
        <? } ?>
    </div>
    <? } ?>
</div>