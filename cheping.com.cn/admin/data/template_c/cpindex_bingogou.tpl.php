<? if(!defined('SITE_ROOT')) exit('Access Denied');?>
<? include $this->gettpl('header');?>
        <div class="user">
            <div class="nav">
                <ul id="nav">
                    <li><a href="<?=$php_self?>focus">轮播图</a></li>
                    <li><a href="<?=$php_self?>price">首页推荐车款</a></li>
                    <li><a href="<?=$php_self?>offers">首页比价通</a></li>
                    <li><a href="<?=$php_self?>bingogou" class="song">冰狗购</a></li>
                    <li><a href="<?=$php_self?>recommendfocus">推荐手动轮播图</a></li>
                </ul>
                </div>
            <div class="clear"></div>

        <div class="user_con">
            <div class="user_con1">
              <form action="" name="frm_ad" id="frm_ad" enctype="multipart/form-data" method="post">
              <table cellpadding="0" cellspacing="0" class="table2" border="0">
                <? foreach((array)$focus as $k=>$v) {?>
                <tr> 
                  <td class="td_left blue" valign="top">
                  图片<?=$k?>：
                  </td>
                  <td class="td_left">
                  标题<?=$k?>：<input type="text" name="name_<?=$k?>" id="name_<?=$k?>" size="40" value="<?=$v['title']?>"><br>
                  链接<?=$k?>：<input type="text" name="link_<?=$k?>" id="link_<?=$k?>" size="40" value="<?=$v['link']?>"><br>
                  价格<?=$k?>：<input type="text" name="price_<?=$k?>" id="price_<?=$k?>" size="40" value="<?=$v['price']?>"><br>
                  成交数<?=$k?>：<input type="text" name="time_<?=$k?>" id="time_<?=$k?>" size="40" value="<?=$v['time']?>"><br>
                  图片<?=$k?>：<input type="file" name="pic_<?=$k?>" id="pic_<?=$k?>">
                  <? if ($v['pic']) { ?>
                  <a href="<?=$php_self?>imgcode&code=<? echo urlencode(base64_encode('images/' . $v['pic'])); ?>" name="轮播图片<?=$k?>" class="jTip" id="vpic">
                  查看图片
                  </a>
                  <input type="hidden" name="pic_h_<?=$k?>" id="pic_h_<?=$k?>" value="<?=$v['pic']?>">
                  <? } ?>
                  <br>
                  </td>
                </tr>
                <?}?>
                <tr>
                  <td colspan="2"><br>
                    <input type="submit" value="  提  交  " name="btn_adds" id="btn_adds">&nbsp;&nbsp;
                    <input type="reset" value="  重  填  ">
                  </td>
                </tr>
              </table>
              </form>
           </div>
           <div class="user_con2"><img src="<?=$admin_path?>images/conbt.gif"  height="16" /></div>
        </div>
        </div> 
    </body>
</html>
