<? if(!defined('SITE_ROOT')) exit('Access Denied');?>
<rss version="2.0">
  <channel>
    <title><?=$title?></title>
    <link><?=$startpage?></link>
    <description>ams车评网</description>
    <language>zh-cn</language>
    <copyright>ams车评网</copyright>
    <pubDate><? echo date("Y-m-d H:i:s +0800",$current_date); ?></pubDate>
    <ttl>10</ttl>
    <? foreach((array)$list as $k=>$v) {?>
    <item>
      <title><? echo htmlspecialchars($v[title]); ?></title>
      <link><?=$v[url]?></link>
      <description><![CDATA[<?=$v[contents]?>]]></description>
      <pubDate><? echo date("Y-m-d H:i:s +0800",$v["uptime"]); ?></pubDate>
      <author><?=$v[author]?></author>
      <guid isPermaLink="false" />
    </item>
    <?}?>
  </channel>
</rss>

