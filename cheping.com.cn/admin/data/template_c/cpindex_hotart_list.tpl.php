<? if(!defined('SITE_ROOT')) exit('Access Denied');?>
<? include $this->gettpl('header');?> 
<div class="user">
    <div class="nav">
        <ul id="nav">
        <li><a href="javascript:void(0);"  class="song">信息预览</a></li>
        <li><a href="<?=$php_self?>hotartOld">历史信息</a></li>
        <li><a href="<?=$php_self?>hotcarNotice&act=hotart">逻辑说明</a></li>
    </ul>
    </div>
    <div class="clear"></div>
    <div class="user_con">
        <div class="user_con1">           
            <div style=" width: 925px; overflow: auto;">
                <table cellpadding="0" cellspacing="0" border="0" class="table2" style="width: 1200px;">                
                <tr>
                    <td>位置</td>
                    <? foreach((array)$hotArticle as $k=>$v) {?>
                    <td><?=$k?></td>
                    <?}?>
                </tr>
                <tr>
                    <td>
                        <table class="table_list">
                        <? for($i=1; $i<9; $i++) { ?>
                        <tr <? if ($i % 2 == 0) { ?>class="deep"<? } ?>>
                            <td><?=$i?></td>
                        </tr>
                        <? } ?>
                        <tr><td>&nbsp;</td></tr>
                        </table>
                    </td>        
                    <? foreach((array)$hotArticle as $k=>$v) {?>                        
                    <td>
                        <table class="table_list">
                            <? for($i=1; $i<9; $i++) { ?>
                            <tr <? if ($i % 2 == 0) { ?>class="deep"<? } ?>>
                                <td>
                                    <? if (isset($v[$i]['short_title'])) { ?>
                                        <?=$v[$i]['short_title']?>
                                    <? } else { ?>
                                        <font style="color:red;">未录入</font>
                                    <? } ?>
                                </td>
                            </tr>
                            <? } ?>
                            <tr>
                                <td>                                
                                    <? if (!isset($v['state'])) { ?>
                                        <input type="button" value="录入" onclick="window.open('<?=$php_self?>hotartChg&date=<?=$k?>')"/>
                                    <? } elseif($v['state'] == 2) { ?>
                                        <input type="button" value="修改" onclick="window.open('<?=$php_self?>hotartChg&date=<?=$k?>&type=2')"/>
                                    <? } ?>
                                </td>
                            </tr>
                        </table>
                    </td>
                    <?}?>                                            
                </tr>
            </table>
            </div>
        </div>
        <div class="user_con2"><img src="<?=$admin_path?>images/conbt.gif"  height="16" /></div>
    </div>
</div>
    </body>
</html>