<? if(!defined('SITE_ROOT')) exit('Access Denied');?>
<? include $this->gettpl('header');?>
<div class="user_wrap">
<ul class="nav2">
  <li class="li1"><a href="<?=$php_self?>">参数列表</a></li>
  <li><a href="<?=$php_self?>add">添加参数</a></li>
</ul>
    <div class="clear"></div>
<div class="user_con">
<div class="user_con1">
  <form action="<?=$php_self?>" method="post">
  <table class="table2" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td>
      产品分类
      <select name="pcategory" id="pcategory">
        <option value="">请选择</option>
        <? foreach((array)$category_list as $ck=>$cv) {?>
        <option value="<?=$ck?>"><?=$cv?></option>
        <?}?>
      </select>
      产品名称
      <select name="category" id="category">
        <option value="">请选择</option>
        <? if ($cate) { ?>
        <? foreach((array)$cate as $sk=>$sv) {?>
        <option value="<?=$sv['id']?>"><?=$sv['name']?></option>
        <?}?>
        <? } ?>
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
        <th>参数类别ID</th>
        <th>参数类别名称</th>
        <th>所属参数组</th>
        <th>排序</th>
        <th>操作</th>
      </tr>
      <? foreach((array)$list as $k=>$v) {?>
      <tr align="center">
        <td><?=$v['id']?></td>
        <td><a href="<?=$php_self?>edit&id=<?=$v['id']?>&qs=<?=$query_string?>&page=<?=$page?>"><?=$v['name']?></a></td>
        <td><?=$v['pname_str']?></td>
        <td>
        <? if ($v[pid1] ) { ?>
          <?=$v['type_order1']?>
        <? } elseif($v[pid2] ) { ?>
          <?=$v['type_order2']?>
        <? } else { ?>
          <?=$v['type_order3']?>
        <? } ?>
        
        </td>
        <td><a href="<?=$php_self?>edit&id=<?=$v['id']?>&qs=<?=$query_string?>&page=<?=$page?>">
        <img src="<?=$admin_path?>images/rewrite.gif" width="12" height="12" />修改</a>
        <a href="#here" mt='1' icon='warnning' tourl="<?=$php_self?>del&id=<?=$v['id']?>&qs=<?=$query_string?>&page=<?=$page?>" class="click_pop_dialog">
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
  $('#pcategory').change(function(){
    var cate = $('#category')[0];
    var pid = $(this).val();
    var cateurl = "?action=paramtype-json&pid="+pid;
    if(!pid) {
      $('#category option[value!=""]').remove();
    }else{
      //alert(pid);
      $.getJSON(cateurl, function(ret){
        $('#category option[value!=""]').remove();
        $.each(ret, function(i,v){
          cate.options.add(new Option(v['name'], v['id']));
        });
      });
    }
  });
  
  <? if ($pcategory && empty($category)) { ?>
  $('#pcategory option[value="<?=$pcategory?>"]').attr({selected:true});
  <? } elseif($category) { ?>
  $('#category option[value="<?=$category?>"]').attr({selected:true});
  $('#pcategory option[value="<?=$pcategory?>"]').attr({selected:true});
  <? } ?>
  
  <? if ($keyword) { ?>
  $('#keyword').val('<?=$keyword?>');
  <? } ?>
  
  $('.click_pop_dialog').live('click', function(){
    pop_window($(this), {message:'您确定要删除该参数吗？', pos:[200,150]});
  });
});

</script>
<? include $this->gettpl('footer');?>
