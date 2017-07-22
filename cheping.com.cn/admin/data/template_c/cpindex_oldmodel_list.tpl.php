<? if(!defined('SITE_ROOT')) exit('Access Denied');?>
<? include $this->gettpl('header');?> 
<div class="user">
    <div class="nav">
        <ul id="nav">
        <li><a href="<?=$php_self?>allModelList">信息预览</a></li>
        <li><a href="javascript:void(0);" class="song">历史信息</a></li>
        <li><a href="<?=$php_self?>modelCountList">数据分析</a></li>
        <li><a href="<?=$php_self?>hotcarNotice&act=allmodel">逻辑说明</a></li>
    </ul>
    </div>
    <div class="clear"></div>
    <div class="user_con">
        <div class="user_con1">           
            <div style=" width: 925px; overflow: auto;">
                <table cellpadding="0" cellspacing="0"  class="table2 table_border" style="width:1100px;">                
                    <tr>
                        <td style="width: 85px;">名称</td>
                        <? foreach((array)$result as $k=>$v) {?>
                        <td style="width: 100px;"><?=$k?></td>
                        <?}?>
                    </tr>
                    <? $j = 0 ?>
                    <? foreach((array)$allModel as $kk=>$vv) {?>                                    
                    <? $j++ ?>
                    <tr>
                        <td <? if ($j % 2 == 0) { ?>class="deep"<? } ?>><?=$vv?></td>
                        <? foreach((array)$result as $k=>$v) {?>
                            <? if (!empty($result[$k][$kk])) { ?>
                                <td <? if ($j % 2 == 0) { ?>class="deep"<? } ?>><? echo implode(' ', $result[$k][$kk]) ?></td>
                            <? } else { ?>
                                <td <? if ($j % 2 == 0) { ?>class="deep"<? } ?>><font style="color:red;">未录入</font></td>
                            <? } ?>         
                        <?}?>
                    </tr>
                    <?}?>
                </table>
                <? if ($pageBar) { ?>
                <div>
                    <div class="ep-pages">
                        <?=$pageBar?>
                    </div>
                </div>
            </div>
            <? } ?>
        </div>
        <div class="user_con2"><img src="<?=$admin_path?>images/conbt.gif"  height="16" /></div>
    </div>
</div>
    </body>
</html>