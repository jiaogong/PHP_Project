<? if(!defined('SITE_ROOT')) exit('Access Denied');?>
<? include $this->gettpl('header');?> 
<div class="user">
<div class="nav">
    <ul id="nav">
        <li><a href="javascript:void(0);" class="song">信息预览</a></li>
        <li><a href="<?=$php_self?>searchAct">操作</a></li>
        <li><a href="<?=$php_self?>hotcarNotice&act=search">逻辑说明</a></li>
    </ul>
    <div class="user_con">
        <div class="user_con1">           
            <table cellpadding="0" cellspacing="0" border="0" class="table2">                
                <tr>
                    <td>位置</td>
                    <td>关键词</td>
                    <td>创建时间</td>
                    <td>修改次数</td>
                    <td>1次记录</td>
                    <td>2次记录</td>
                    <td>3次记录</td>
                    <td>4次记录</td>
                    <td>5次记录</td>                    
                </tr>
                <? $q = 0 ?>
                <? foreach((array)$data as $k=>$v) {?>                
                <? if ($v['alias']) { ?>
                <? $q++ ?>
                <tr <? if ($q % 2 == 0) { ?>class="deep"<? } ?>>
                    <td><?=$k?></td>
                    <td><?=$v['alias']?></td>
                    <td><? if ($v['created']) { ?><? echo date('Y-m-d', $v['created']) ?><? } ?></td>
                    <td><? echo (int)$v['times'] ?></td>
                    <? for($i=1; $i<6; $i++) { ?>
                    <td>
                        <? if (!empty($v['history'][$i])) { ?>
                            <?=$v['history'][$i]['alias']?><br>
                            <? $j = $i - 1 ?>
                            <? echo date('m-d', $v['history'][$i]['timestamp']) ?>至<? echo date('m-d', $v['history'][$j]['timestamp']) ?>
                        <? } else { ?>
                        <font style="color:red;">无记录</font>
                        <? } ?>
                    </td>
                    <? } ?>
                </tr>
                <? } ?>
                <?}?>
            </table>
        </div>
        <div class="user_con2"><img src="<?=$admin_path?>images/conbt.gif"  height="16" /></div>
    </div>
</div>
    </body>
</html>