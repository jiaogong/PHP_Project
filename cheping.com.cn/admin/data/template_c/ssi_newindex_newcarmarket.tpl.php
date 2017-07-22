<? if(!defined('SITE_ROOT')) exit('Access Denied');?>
<div class="xin_che">
    <h3 class="xin_title">新车上市</h3>
    <div class="xin_che_content">
        <? for($i=0; $i<8; $i += 2) { ?>
        <? $j = $i + 1 ?>
        <? if ($i < 1) { ?>
        <div class="xcc_top xcc_top_hover">
            <dl>
                <dt><a href="/modelinfo_<?=$result[$i]['model_id']?>.html" target="_blank" title="<?=$result[$i]['series_name']?> <?=$result[$i]['date_id']?>款"><img src="/attach/images/model/<?=$result[$i]['model_id']?>/122x93<?=$result[$i]['model_pic1']?>" width="122" height="93" onerror="this.src='/images/122x93.jpg'"></a></dt>
                <dd><a href="/modelinfo_<?=$result[$i]['model_id']?>.html" target="_blank"><?=$result[$i]['series_name']?> <?=$result[$i]['date_id']?>款</a></dd>
            </dl>
            <dl>
                <dt><a href="/modelinfo_<?=$result[$j]['model_id']?>.html" target="_blank" title="<?=$result[$j]['series_name']?> <?=$result[$j]['date_id']?>款"><img src="/attach/images/model/<?=$result[$j]['model_id']?>/122x93<?=$result[$j]['model_pic1']?>" width="122" height="93" onerror="this.src='/images/122x93.jpg'"></a></dt>
                <dd><a href="/modelinfo_<?=$result[$j]['model_id']?>.html" target="_blank"><?=$result[$j]['series_name']?> <?=$result[$j]['date_id']?>款</a></dd>
            </dl>
        </div>        
        <? } ?>
        <div class="xcc_bottom" <? if ($i == 0) { ?>style="display: none;"<? } ?>>
            <ul>
                <li><a href="/modelinfo_<?=$result[$i]['model_id']?>.html" target="_blank"><?=$result[$i]['series_name']?> <?=$result[$i]['date_id']?>款</a></li>
                <li><a href="/modelinfo_<?=$result[$j]['model_id']?>.html" target="_blank"><?=$result[$j]['series_name']?> <?=$result[$j]['date_id']?>款</a></li>
            </ul>
        </div>        
        <? } ?>        
    </div>
</div>