<? if(!defined('SITE_ROOT')) exit('Access Denied');?>
<div class="rr_right">
    <? $type = array('家用舒适', '个性运动', '商务行政', 'SUV/MPV'); ?>
    <? for($i=0; $i<4; $i++) { ?>
    <div class="rl_right">        
        <div class="right_right">
            <h3 class="r_r_title">近期热点<span style="color:#ff8f34; margin-left:5px; font-size:12px;"><? echo $type[$i] ?></span></h3>
            <? for($j=1; $j<7; $j++) { ?>
            <? $k = $i * 6 + $j ?>
            <div class="r_r_news" <? if ($j == 6) { ?>style="background:none;"<? } ?>>
                 <a target="_blank" href="offers_<? echo $result[$k]['model_id'] ?>.html#shangqing_<? echo $result[$k]['price_id'] ?>" title="<? echo $result[$k]['alias'] ?>"><? echo mb_substr($result[$k]['alias'],0, 18,'utf-8') ?></a>
            </div>
            <? } ?>
        </div>        
    </div>
    <? } ?>
</div>