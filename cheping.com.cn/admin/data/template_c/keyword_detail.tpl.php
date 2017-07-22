<? if(!defined('SITE_ROOT')) exit('Access Denied');?>
<? include $this->gettpl('header');?>
<div class="user">
    <div class="nav">
        <ul id="nav">
        <li class="li1"><a href="javascript:;" class="song"><?=$page_title?></a></li>
        <li><a href="javascript:history.back(-1);">返回</a></li>
    </ul>
    </div>
    <div class="clear"></div>
    <div class="user_con">
        <div class="user_con1">
            <? if ($brand) { ?>
            <table class="table2" border="0" cellpadding="0" cellspacing="0">
                <tr style="color:red;">
                    <th colspan="3" style="text-align: left;line-height:26px;"><h3>共有<?=$total?>条 <?=$temp?></h3></th>
                </tr>
                <tr align="right"  class='th'>
                    <td width="20" nowrap>ID</td>
                    <td width="30%" >品牌</td>
                    <td width="60%" nowrap>关键字</td>
                    <!--<th width="25%" >车系名称</th>-->
                </tr>
                <? foreach((array)$brand as $k=>$v) {?>
                <tr align="right"  class='th'>
                    <td width="20" nowrap><?=$v["brand_id"]?></td>
                    <td width="25%" ><?=$v["brand_name"]?></td>
                    <td width="25%" nowrap><? if ($v["keyword"]) { ?><?=$v["keyword"]?><? } else { ?>无<? } ?></td>
                    <!--<th width="25%" ><?=$v["series_name"]?></th>-->
                </tr>
                <?}?>
            </table>
            <? } ?>
            <? if ($series) { ?>
            <table class="table2" border="0" cellpadding="0" cellspacing="0">
                <tr style="color:red;">
                    <th colspan="5" style="text-align: left;line-height:26px;"><h3>共有<?=$total?>条 <?=$temp?></h3></th>
                </tr>
                <tr align="right"  class='th'>
                    <td width="20" nowrap>ID</td>
                    <td width="40" >品牌</td>
                    <td width="20%" nowrap>厂商</td>
                    <td width="20%" >车系名称</td>
                    <td width="30%" >关键字</td>
                </tr>
                <? foreach((array)$series as $k=>$v) {?>
                <tr align="right"  class='th'>
                    <td width="20" nowrap><?=$v["series_id"]?></td>
                    <td width="50" ><?=$v["brand_name"]?></td>
                    <td width="20%" nowrap><?=$v["factory_name"]?></td>
                    <td width="20%" ><?=$v["series_name"]?></td>
                    <td width="30%" ><? if ($v["keyword"]) { ?><?=$v["keyword"]?><? } else { ?>无<? } ?></td>
                </tr>
                <?}?>
            </table>
            <? } ?>
        </div>
        <div class="user_con2">
            <img src="<?=$admin_path?>images/conbt.gif" height="16" >
        </div>
    </div>
</div>
</body>
</html>