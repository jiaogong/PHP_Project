<? if(!defined('SITE_ROOT')) exit('Access Denied');?>
<? include $this->gettpl('header');?>
<div class="user">
<div class="nav">
  <ul id="nav">
      <li><a href="<?=$php_self?>" class="song">参数组列表</a></li>
      <li><a href="<?=$php_self?>add">添加参数组</a></li>
  </ul>
</div>
<div class="clear"></div>
<div class="user_con">
<div class="user_con1">
  <form action="<?=$php_self?>" method="post">
  <table class="table2" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td class="td_left">
      分类名称
      <select name="pcategory" id="pcategory">
        <option value="">请选择</option>
        <? foreach((array)$category_list as $ck=>$cv) {?>
        <option value="<?=$ck?>"><?=$cv?></option>
        <?}?>
      </select>
      
      参数名称
      <input size="20" name="keyword" id="keyword">
      <input type="submit" name="search" value=" 搜 索 ">
      </td>
    </tr>
  </table>
  </form>
  <table class="table2" border="0" cellpadding="0" cellspacing="0">
    <tbody>
      <tr class="th">
        <th>参数ID</th>
        <th>参数名称</th>
        <th>所属分类</th>
        <th>排序</th>
        <th>操作</th>
      </tr>
      <? foreach((array)$list as $k=>$v) {?>
      <tr align="center">
        <td><?=$v['id']?></td>
        <td><a href="<?=$php_self?>edit&id=<?=$v['id']?>"><?=$v['name']?></a></td>
        <td><?=$v['pname']?></td>
        <td><?=$v['type_order']?></td>
        <td><a href="<?=$php_self?>edit&id=<?=$v['id']?>"><img src="<?=$admin_path?>images/rewrite.gif" width="12" height="12" />修改</a>
        <a href="#here" mt='1' icon='warnning' tourl="<?=$php_self?>del&id=<?=$v['id']?>" class="click_pop_dialog">
        <img src="<?=$admin_path?>images/del1.gif" height="9" width="9">删除
        </a>
        </td>
      </tr>
      <?}?>
      <? if (!$page_bar) { ?><tr><td colspan="5" height="20"><?=$page_bar?></td></tr><? } ?>
    </tbody>
  </table>
  <? if ($page_bar) { ?>
  <div>
    <div class="ep-pages">
      <?=$page_bar?>
    </div>
  </div>
  <? } ?>
</div>

</div>
</div>
<script type="text/javascript">
$().ready(function(){
  <? if ($subcategory_id) { ?>
  $('#category option[value="<?=$category_id?>"]').attr({selected:true});
  $('#subcategory option[value="<?=$subcategory_id?>"]').attr({selected:true});
  <? } ?>
  
  <? if ($keyword) { ?>
  $('#keyword').val('<?=$keyword?>');
  <? } ?>
  
  $('.click_pop_dialog').live('click', function(){
    pop_window($(this), {message:'您确定要删除该参数分类吗？', pos:[200,150]});
  });
});

</script>
<? include $this->gettpl('footer');?>
