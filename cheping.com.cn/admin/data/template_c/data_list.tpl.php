<? if(!defined('SITE_ROOT')) exit('Access Denied');?>
<? include $this->gettpl('header');?>
<div class="user">
    <div class="nav">
        <ul id="nav">
        <li><a href="<?=$php_self?>" class="song">数据统计</a></li>
        <li><a href="<?=$php_self?>pic">图片关联统计</a></li>
        <li><a href="<?=$php_self?>keyword">关键字统计</a></li>
        <li ><a href="<?=$php_self?>series">车系</a></li>
         <li ><a href="<?=$php_self?>carmodel">车型</a></li>
         <li ><a href="<?=$php_self?>model">车款</a></li>
    </ul>
    </div>
    <div class="clear"></div>
    <div class="user_con">
        <div class="user_con1" style="margin-top:20px;margin-left:40px;">
            <? foreach((array)$data as $key=>$value) {?>
            <table class="table2" border="0" cellpadding="0" cellspacing="0">
                <tr style="color:red;">
                    <th colspan="4" style="text-align: left;line-height:26px;"><h3>共有<?=$key?>数(<?=$value["total"]?>)</h3></th>
                </tr>
                <tr align="right"  class='th'>
                    <td height="30" nowrap>状态</td>
                    <td width="50%" align="left">描述</td>
                    <td width="15%">数量</td>
                    <td width="15%"></td>
                </tr>
                <? foreach((array)$value["state"] as $k=>$v) {?>
                <tr class='th'>
                    <td height="30" style="text-align:left;" nowrap><?=$k?></td>
                    <td width="50%" style="text-align:left;">处于 <font style="color:red;"><?=$k?></font> 状态 <font style="color:red;"><?=$key?></font></td>
                    <td width="15%"><strong style="color:red;"><?=$v?></strong></td>
                    <td width="15%"><? if ($value["detail"]) { ?><a href="<?=$php_self?><?=$value['detail']?>&state=<? echo array_search($k,$state); ?>">查看详细</a><? } ?></td>
                </tr>
                <?}?>
            </table>
            <div style="height:40px;"></div>
            <?}?>
        </div>
        <div class="user_con2">
            <img src="<?=$admin_path?>images/conbt.gif" height="16" >
        </div>
    </div>
</div>
</body>
</html>
