<? if(!defined('SITE_ROOT')) exit('Access Denied');?>
<? include $this->gettpl('header');?>
<div class="user">
  <div class="nav">
    <ul id="nav">
  <li ><a href="<?=$php_self?>setting">车系亮点配置</a></li>
  <li><a href="<?=$php_self?>orderlist" class="song">全车款配置排序列表</a></li>
  <li ><a href="<?=$php_self?>orderimportant">导入全车款配置排序</a></li>
</ul>
  </div>
  <div class="clear"></div>
<div class="user_con">
<div class="user_con1">
  <form action="<?=$php_self?>orderlist" method="post">
  <table class="table2" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td>

      配置分类
      <select name="category" id="category">
        <option value="">请选择</option>
        <? if ($cate) { ?>
        <? foreach((array)$cate as $sk=>$sv) {?>
        <option value="<?=$sv['id']?>"><?=$sv['name']?></option>
        <?}?>
        <? } ?>
      </select>
      <input type="submit" name="search" value=" 搜 索 ">
      </td>
    </tr>
  </table>
  </form>
  <form action="<?=$php_self?>orderlist" method="post" id="form_name">
  <table class="table2" border="0" cellpadding="0" cellspacing="0">
    <tbody>
      <tr class="th">
        <th>序号</th>
        <th>配置id</th>
        <th>标配名称</th>
        <th>排序</th>
        <th>排序(优先级)</th>

      </tr>
      <? foreach((array)$list as $key=>$value) {?>
      <tr align="center">
        <td><? echo $key+1 ?></td>
        <td><input type="text" value="<?=$value['id']?>" size="5" name="id[]" readonly></td>
        <td><? if ($value['id']==28) { ?>涡轮增压<? } else { ?><?=$value['name']?><? } ?></td>
        <td><input type="text" value="<?=$value['orderby']?>" size="5" name="orderby[]" class="check"> <input type="hidden" value="<?=$value['orderby']?>" name="old_orderby[]"></td>
        <td><input type="text" value="<?=$value['p_id']?>" size="10" name="p_id[]" class="check"> <input type="hidden" value="<?=$value['p_id']?>" name="old_p_id[]"></td>

      </tr>
       <?}?>
       <input type="hidden" value="<?=$catename?>" size="5" name="category" > 
      <tr class="page_bar_css"><td colspan="5" height="20" ><?=$page_bar?></td></tr>
    </tbody>
  </table>
  </form>
</div>

</div>
</div>
<script type="text/javascript">
    $(".check").change(function(){
        $("#form_name").submit();
    })
$('#category').change(function(){
    var cate = $('#pcategory')[0];
    var pid = $(this).val();
    var cateurl = "?action=param-json&pid="+pid;
    if(!pid) {
      $('#pcategory option[value!=""]').remove();
    }else{
      //alert(pid);
      $.getJSON(cateurl, function(ret){
        $('#pcategory option[value!=""]').remove();
        $.each(ret, function(i,v){
          cate.options.add(new Option(v['name'], v['id']));
        });
      });
    }
  });
 <? if ($category && empty($pcategory)) { ?>
  $('#category option[value="<?=$category?>"]').attr({selected:true});
  <? } elseif($pcategory) { ?>
  $('#category option[value="<?=$category?>"]').attr({selected:true});
  $('#pcategory option[value="<?=$pcategory?>"]').attr({selected:true});
  <? } ?>
</script>
</body>
</html>
