<? if(!defined('SITE_ROOT')) exit('Access Denied');?>
<? include $this->gettpl('header');?>
<div class="user_wrap">
<ul class="nav2">
  <li><a href="<?=$php_self?>">参数列表</a></li>
  <li class="li1"><a href="<?=$php_self?>add">添加添加</a></li>
</ul>
<div class="clear"></div>
<div class="user_con">
<div class="user_con1">
  <form action="" method="post">
  <table class="table2" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td width="20%">
      分类名称
      </td>
      <td class="td_left">
      <select name="pcategory" id="pcategory">
        <option value="">请选择</option>
        <? foreach((array)$category_list as $ck=>$cv) {?>
        <option value="<?=$ck?>"><?=$cv?></option>
        <?}?>
      </select>
      </td>
    </tr>
    
    <tr>
      <td>
      参数组名称
      </td>
      <td class="td_left">
      <input type="text" size="20" name="name" id="name" value="<?=$category['name']?>">
      </td>
    </tr>
    
    <tr>
      <td>
      排序
      </td>
      <td class="td_left">
      <input type="text" size="4" name="type_order" id="type_order" value="<?=$category['type_order']?>">
      </td>
    </tr>
    
    <tr>
      <td colspan="2" align="center">
      <input type="hidden" name="id" value="<?=$category['id']?>">
      <input type="submit" name="adbtn" value=" 提 交 ">&nbsp;&nbsp;
      <input type="reset" name="rebtn" value=" 重 填 ">
      </td>
    </tr>
  </table>
  </form>
</div>

</div>
</div>
<script type="text/javascript">
$().ready(function(){
  <? if ($pid) { ?>
  $('#pcategory option[value="<?=$pid?>"]').attr({selected:true});
  <? } ?>
  
  <? if ($keyword) { ?>
  $('#keyword').val('<?=$keyword?>');
  <? } ?>
  
  <? if ($parm) { ?>
  $('#category option[value="<?=$category_id?>"]').attr({selected:true});
  $('#subcategory option[value="<?=$parm['subcategoryid']?>"]').attr({selected:true});
  $('#parmtype option[value="<?=$parm['paramtypeid']?>"]').attr({selected:true});
  $('#fieldtype option[value="<?=$parm['field_type']?>"]').attr({selected:true});
  $('#ismainshow option[value="<?=$parm['ismainshow']?>"]').attr({selected:true});
  <? } ?>
});

</script>
<? include $this->gettpl('footer');?>
