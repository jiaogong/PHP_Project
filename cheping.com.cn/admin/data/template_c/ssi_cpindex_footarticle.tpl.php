<? if(!defined('SITE_ROOT')) exit('Access Denied');?>
<div class="baojia_left">
    <h3 class="baojia_left_title">新闻中心</h3>
    <div class="baojia_left_content">
        <div class="table_left">
            <div class="xinwen_title"><span style="float:left; font-size:14px;"><a href="more_news.html" target="_blank">汽车导购</a></span><span style="float:right;"><a href="more_news.html" target="_blank">更多</a></span></div>
            <div class="xinwen_list">
                <? if (!empty($article['dynamic'])) { ?>                        
                <? foreach((array)$article['dynamic'] as $art) {?>
                <ul>
                    <li style=" width:87px;">[ <? echo $type[$art['channel_id']] ?> ]</li>
                    <li style=" width:235px;">
                        <a title="<?=$art['title']?> <?=$art['title2']?>" href="html/article/<? echo date('Ym', $art['created']) ?>/<? echo date('d', $art['created']) ?>/<?=$art['id']?>.html" target="_blank">
                            <? echo mb_substr($art['short_title'],0,18,'utf-8') ?>
                        </a>
                    </li>
                    <? if ($art['created']) { ?>
                    <li style=" color:#b9b9b9;"><? echo date('Y-m-d', $art['created']) ?></li>
                    <? } ?>
                </ul>
                <? } ?>
                <? } ?>
            </div>
        </div>
        <div class="table_right">
            <div class="xinwen_title"><span style="float:left; font-size:14px;"><a href="more_active_news.html" target="_blank">汽车资讯</a></span><span style="float:right;"><a href="more_active_news.html" target="_blank">更多</a></span></div>
            <div class="xinwen_list">
                <? if (!empty($article['market'])) { ?>
                <? foreach((array)$article['market'] as $art) {?>
                <ul>
                    <li style=" width:87px;">[ <? echo $type[$art['channel_id']] ?> ]</li>
                    <li style=" width:235px;">
                        <a title="<?=$art['title']?> <?=$art['title2']?>" href="html/article/<? echo date('Ym', $art['created']) ?>/<? echo date('d', $art['created']) ?>/<?=$art['id']?>.html" target="_blank">
                            <? echo mb_substr($art['short_title'],0,18,'utf-8') ?>
                        </a>
                    </li>
                    <? if ($art['created']) { ?>
                    <li style=" color:#b9b9b9;"><? echo date('Y-m-d', $art['created']) ?></li>
                    <? } ?>
                </ul>
                <? } ?>
                <? } ?>
            </div>
        </div>
    </div>
</div>
