<? if(!defined('SITE_ROOT')) exit('Access Denied');?>
<? include $this->gettpl('header');?>
<div class="user">
<div class="nav">
    <ul id="nav">
    <li ><a href="<?=$phpSelf?>">经销商反馈列表</a></li>
    <li><a href="#" class="song"><?=$page_title?></a></li>
</ul>
    </div>
    <div class="clear"></div>
 <div class="user_con">
  <div class="user_con1">
      <form name="add_user" method="post" action="<?=$phpSelf?>dealeradvice" onsubmit="">
      <table cellpadding="0" cellspacing="0" class="table2" border="0">
        <tr>
          <td width="22%" height="20" align=right> 经销商：</td>
          <td class="td_left"><?=$advice['dealer_name']?></td>
        </tr>

        <tr>
          <td width="22%" height="20" align=right> 内容：</td>
          <td class="td_left"><?=$advice['message']?></td>
        </tr>

        <tr>
          <td width="22%" height="20" align=right> 提交时间：</td>
          <td class="td_left"><? if ($advice['created']) { ?><? echo date('Y/m/d H:i:s',$advice["created"]) ?><? } ?></td>
        </tr>
        <tr>
          <td width="22%" height="20" align=right> 冰狗网回复：</td>
          <td class="td_left"><? if ($advice['answer']) { ?><?=$advice['answer']?><? } else { ?><textarea  cols="50" rows="5"  name="answer" ></textarea><? } ?></td>
        </tr>
        <? if ($advice['answertime']) { ?>
         <tr>
          <td width="22%" height="20" align=right> 回复时间：</td>
          <td class="td_left"><? echo date('Y/m/d H:i:s',$advice["answertime"]) ?></td>
        </tr>
        <? } ?>
        <tr>
          <td colspan="2">
              <input name="id" type="hidden" value="<?=$advice['id']?>">
              <? if (empty($advice['answer'])) { ?><input id="edit_cancel" type="submit" value="回复"><? } ?>
              <!--<input id="edit_cancel" type="submit" value="回复">-->
              <input id="edit_cancel" type="button" onclick="javascript:history.go('-1');" value="返回" name="edit_cancel">
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