<? if(!defined('SITE_ROOT')) exit('Access Denied');?>
<? include $this->gettpl('header');?>
<div class="user_wrap">
<ul class="nav2">
  <li><a href="<?=$php_self?>list">车身颜色列表</a></li>
  <li class="li1"><a href="<?=$php_self?>add">添加车身颜色</a></li>
</ul>
<div class="clear"></div>
<div class="user_con">
<div class="user_con1">
  <form action="<?=$php_self?>edit" method="post" enctype="multipart/form-data">
  <table class="table2" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td width="20%">
      颜色名称
      </td>
      <td class="td_left">
      <input type="text" size="20" name="name" id="name" value="<?=$list['name']?>">
      </td>
    </tr>
    
    <tr>
      <td>
      颜色图片
      </td>
      <td class="td_left">
      <img src="<?=$list['pic']?>" width="17" height="17" title="<?=$list['name']?>" style="vertical-align:middle;"/>&nbsp;&nbsp;
      <input type="file" size="30" name="pic" id="pic">
      </td>
    </tr>
 
    <tr>
      <td colspan="2" align="center">
      <input type="hidden" name="id" id="id" value="<?=$list['id']?>">
      <input type="submit" name="adbtn" value=" 提 交 ">&nbsp;&nbsp;
      <input type="reset" name="rebtn" value=" 重 填 ">
      </td>
    </tr>
  </table>
  </form>
</div>
</div>
</div>

<? include $this->gettpl('footer');?>
