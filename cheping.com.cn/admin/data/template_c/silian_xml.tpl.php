<? if(!defined('SITE_ROOT')) exit('Access Denied');?>
<urlset>
    <? foreach((array)$silian as $v) {?>
    <url>
        <loc><?=$v?></loc>
        <lastmod><?=$date?></lastmod>
    </url>
    <? } ?>
</urlset>