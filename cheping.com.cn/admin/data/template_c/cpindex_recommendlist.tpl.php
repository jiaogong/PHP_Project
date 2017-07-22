<? if(!defined('SITE_ROOT')) exit('Access Denied');?>
<? include $this->gettpl('header');?> 
<div class="user">
    <div class="nav">
        <ul id="nav">
            <li><a href="javascript:void(0);" class="song">信息预览</a></li>
            <li><a href="<?=$php_self?>recommendact">操作</a></li>
            <li><a href="<?=$php_self?>hotcarNotice&act=recommend">逻辑说明</a></li>
        </ul>
    </div>
    <div class="clear"></div>
    <div class="user_con">
        <div class="user_con1">
            <table cellpadding="0" cellspacing="0" class="table2" border="0">
                <tr>
                    <td>序列</td>
                    <td>当前车系</td>
                    <td>创建时间</td>
                    <td>1次记录</td>
                    <td>2次记录</td>
                    <td>3次记录</td>
                    <td>4次记录</td>
                    <td>5次记录</td>
                </tr>
                <? for($i=0; $i<12; $i++) { ?>
                <tr>
                    <td><? echo $i+1 ?></td>
                    <? for($j=0; $j<6; $j++) { ?>
                    <? if ($j==0) { ?>
                    <? if ($recommendlist[$j][$i]) { ?>
                    <td><?=$recommendlist[$j][$i]['series_alias']?></td>
                    <td><?=$recommendlist[$j][$i]['created']?></td>
                    <? } else { ?>
                    <td>无记录</td>
                    <td>无记录</td>
                    <? } ?>
                    <? } else { ?>
                    <td><? if ($recommendlist[$j][$i]) { ?><?=$recommendlist[$j][$i]['series_alias']?><br/><?=$recommendlist[$j][$i]['start_time']?>至<?=$recommendlist[$j][$i]['end_time']?><? } else { ?>无记录<? } ?></td>
                    <? } ?>
                    <? } ?>

                </tr>
                <? } ?>
            </table>
            <p>请确认信息后点击生成&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value="生成" onclick="newMakefile('recommend')" /></p>
        </div>
        <div class="user_con2"><img src="<?=$admin_path?>images/conbt.gif"  height="16" /></div>
    </div>
</div>
</body>
</html>