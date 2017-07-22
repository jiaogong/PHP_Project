<? if(!defined('SITE_ROOT')) exit('Access Denied');?>
<ul>
    <? foreach((array)$result as $k=>$v) {?>
        <? if ($v['alias']) { ?>
        <? $url = 'search.php?action=index' ?>
        <? foreach((array)$v['option_key'] as $key=>$value) {?>
            <? if ($value) { ?>
                <? if ($value == 'pr' && $v['option_value'][$key] == 9) { ?>
                    <? $url .= '&pr=9&pr=10' ?>
                <? } elseif($value == 'sp') { ?>
                    <? $url .= '&' . $v['option_value'][$key] . '=1' ?>
                <? } else { ?>
                    <? $url .= '&' . $value . '=' . $v['option_value'][$key] ?>
                <? } ?>
            <? } ?>
        <?}?>
        <li>
            <a href="/<?=$url?>" target="_blank">
                <?=$v['alias']?>
            </a>
        </li>
        <? } ?>
    <?}?>
</ul>