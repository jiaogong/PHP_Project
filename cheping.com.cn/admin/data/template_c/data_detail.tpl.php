<? if(!defined('SITE_ROOT')) exit('Access Denied');?>
<? include $this->gettpl('header');?>
<div class="user">
    <div class="nav">
        <ul id="nav">
        <li><a href="javascript:;" class="song"><?=$page_title?></a></li>
        <li><a href="javascript:history.back(-1);">返回</a></li>
    </ul>
    </div>
    <div class="clear"></div>
    <div class="user_con">
        <div class="user_con1">
            <? if ($result) { ?>
            <table class="table2" border="0" cellpadding="0" cellspacing="0">
                <tr style="color:red;">
                    <th colspan="6" style="text-align: left;line-height:26px;"><h3>共有<? echo count($result) ?>条</h3></th>
                </tr>
                <tr align="right"  class='th'>
                    <td height="20" nowrap>ID</td>
                    <td width="20%" align="left">名称</td>
                    <td height="20" nowrap>ID</td>
                    <td width="20%" align="left">名称</td>
                    <td height="20" nowrap>ID</td>
                    <td width="20%" align="left">名称</td>
                </tr>
                <? foreach((array)$result as $k=>$v) {?>
                <? if ($k%3==0) { ?>
                <tr align="right"  class='th'>
                    <td height="20" nowrap><?=$v["id"]?></td>
                    <td width="20%" align="left"><?=$v["name"]?></td>
                    <? $i=($k+1) ?>
                    <td height="20" nowrap><?=$result[$i]["id"]?></td>
                    <td width="20%" align="left"><?=$result[$i]["name"]?></td>
                    <? $i=($k+2) ?>
                    <td height="20" nowrap><?=$result[$i]["id"]?></td>
                    <td width="20%" align="left"><?=$result[$i]["name"]?></td>
                </tr>
                <? } ?>
                <?}?>
            </table>
            <? } ?>
            <? if ($series) { ?>
            <table class="table2" border="0" cellpadding="0" cellspacing="0">
                <tr style="color:red;">
                    <th colspan="4" style="text-align: left;line-height:26px;"><h3>共有<? echo count($series) ?>条 <?=$temp?></h3></th>
                </tr>
                <tr align="right"  class='th'>
                    <th height="20" nowrap>ID</td>
                    <th width="25%" >品牌</td>
                    <th height="25%" nowrap>厂商</td>
                    <th width="25%" >车系名称</td>
                </tr>
                <? foreach((array)$series as $k=>$v) {?>
                <tr align="right"  class='th'>
                    <td height="20" nowrap><?=$v["id"]?></td>
                    <td width="25%" ><?=$v["brand_name"]?></td>
                    <td height="25%" nowrap><?=$v["factory_name"]?></td>
                    <td width="25%" ><?=$v["series_name"]?></td>
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