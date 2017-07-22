<? if(!defined('SITE_ROOT')) exit('Access Denied');?>
<? include $this->gettpl('header');?>
<script type="text/javascript"><?=$bjs?></script>
<script type="text/javascript"><?=$sjs?></script>
<div class="user">
    <div class="nav">
        <ul id="nav">
        <li><a href="<?=$php_self?>focus">轮播图</a></li>
        <li><a href="<?=$php_self?>price">首页推荐车款</a></li>
        <li><a href="<?=$php_self?>offers" class="song">首页比价通</a></li>
        <li><a href="<?=$php_self?>bingogou">冰狗购</a></li>
        <li><a href="<?=$php_self?>recommendfocus">推荐手动轮播图</a></li>
    </ul>
    </div>
    <div class="clear"></div>
    <div class="user_con">
        <div class="user_con1">
            <form name="hotcar_from" id="hotcar_from" action="index.php?action=static-offers" method="post">
                <table cellpadding="0" cellspacing="0" class="table2" border="0">

                    <? for($i=0;$i<=6;$i++) { ?>
                    <tr>
                        <td class="td_left blue" width="15%"><? if ($i != 0) { ?>星期<? echo $i ?>：<? } else { ?>星期天<? } ?></td>
                        <td class="td_left">
                            <select name="brand_id_<?=$i?>" id="brand_id_<?=$i?>" seq="<?=$i?>" class="brand_select" onchange="series_select($('#series_id_<?=$i?>'), this.value);" style="width:150px;">
                                <option value="">请选择</option>
                                <script>brand_select($('#brand_id_<?=$i?>'));</script>
                            </select>
                            <select name="series_id_<?=$i?>" id="series_id_<?=$i?>" seq="<?=$i?>" class="model_select" style="width:280px;">
                                <option value="">请选择</option>
                                <? foreach((array)$series as $k=>$v) {?>
                                <option value="<?=$v[series_id]?>"><?=$v[series_name]?></option>
                                <?}?>
                            </select>
                        </td>
                    </tr>
                    <tr><td colspan="2" height="1"></td></tr>
                    <? } ?>
                    <tr>
                        <td colspan="2">
                            <input type="submit" value=" 提&nbsp;&nbsp;交 ">&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="reset" value=" 重&nbsp;&nbsp;填 ">
                        </td>
                    </tr>
                </table>
            </form>
        </div>
        <div class="user_con2"><img src="<?=$admin_path?>images/conbt.gif"  height="16" /></div>
    </div>
</div>
<script type="text/javascript">
$().ready(function(){
    <? if (!empty($offers)) { ?>
        <? foreach((array)$offers['bid'] as $k=>$v) {?>
            $('#brand_id_<?=$k?> option[value="<?=$v?>"]').attr({selected:true});
            <? if ($v) { ?>series_select($('#series_id_<?=$k?>'), <?=$v?>);<? } ?>
            $('#series_id_<?=$k?> option[value="<? echo $offers["sid"][$k] ?>"]').attr({selected:true});
        <?}?>
    <? } ?>
});
</script>

    </body>
</html>