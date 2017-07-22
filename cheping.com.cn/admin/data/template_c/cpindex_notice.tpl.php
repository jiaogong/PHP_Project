<? if(!defined('SITE_ROOT')) exit('Access Denied');?>
<? include $this->gettpl('header');?> 
<div class="user">
    <div class="nav">
        <ul id="nav">
        <? foreach((array)$title as $k=>$v) {?>
        <li><a <? if ($v == '逻辑说明') { ?>class="song"<? } ?> href="<? echo $url[$k] ?>"><?=$v?></a></li>
        <?}?>
    </ul>
    </div>
    <div class="clear"></div>
    <div class="user_con">
        <div class="user_con1">           
            <form method="post" action="<?=$php_self?>hotcarNotice&act=<?=$act?>">
                <ul style="margin-left:45px; ">
                    <li><textarea cols="100" rows="25" id="content" name="content"><?=$notice?></textarea></li>
                    <li>
                        <p style="text-align: center; margin-top: 10px;">
                        <input type="submit" value="提交"/>
                        </p>
                    </li>
                </ul>
            </form>
        </div>
        <div class="user_con2"><img src="<?=$admin_path?>images/conbt.gif"  height="16" /></div>
    </div>
</div>
    </body>
</html 