<? if(!defined('SITE_ROOT')) exit('Access Denied');?>
<? include $this->gettpl('header');?> 
<div class="user">
    <div class="nav">
        <ul id="nav">
        <li><a href="<?=$php_self?>hotartList">信息预览</a></li>
        <li><a href="javascript:void(0);"  class="song">历史信息</a></li>
        <li><a href="<?=$php_self?>hotcarNotice&act=hotart">逻辑说明</a></li>
    </ul>
    </div>
    <div class="clear"></div>
    <div class="user_con">
        <div class="user_con1">           
            <table cellpadding="0" cellspacing="0" border="0" class="table2">                
                <tr>
                    <td>位置</td>
                    <? foreach((array)$history as $k=>$v) {?>
                    <td style="height: 25px;"><?=$k?></td>
                    <?}?>
                </tr>
                <tr>
                    <td>
                        <center>
                            <table class="table_list">
                            <? for($i=1; $i<9; $i++) { ?>
                            <tr <? if ($i % 2 == 0) { ?>class="deep"<? } ?>>
                                <td><?=$i?></td>
                            </tr>
                            <? } ?>
                            </table>
                        </center>
                    </td>        
                    <? foreach((array)$history as $k=>$v) {?>                        
                    <td>
                        <center>
                            <table class="table_list">
                                <? for($i=1; $i<9; $i++) { ?>
                                <tr <? if ($i % 2 == 0) { ?>class="deep"<? } ?>>
                                    <td>
                                        <?=$v[$i]['short_title']?>
                                    </td>
                                </tr>
                                <? } ?>
                            </table>
                        </center>
                    </td>
                    <?}?>                                            
                </tr>
            </table>
            <div>
                <div class="ep-pages">
                    <?=$page_bar?>
                </div>
            </div>
        </div>
        <div class="user_con2"><img src="<?=$admin_path?>images/conbt.gif"  height="16" /></div>
    </div>
</div>
    </body>
</html>