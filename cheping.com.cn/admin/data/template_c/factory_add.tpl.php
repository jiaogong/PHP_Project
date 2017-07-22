<? if(!defined('SITE_ROOT')) exit('Access Denied');?>
<? include $this->gettpl('header');?> 
<div class="user_wrap" style="width:780px">
  <div class="module_con" style="width:780px">
    <div class="module_con1" style="width:780px">
    <form action="" method="post" enctype="multipart/form-data">
      <table cellpadding="0" cellspacing="0" class="table2">
        <tr> 
            <td width="80" height="20" align="right">所属品牌:</td>
            <td class="td_left">
            <? if ($factory) { ?>
            <?=$factory['brand_name']?> <!--<a href="javascript:void(0);" onclick="javascript:$('.newbrand').show();">修改</a>
            <div class="newbrand" style="display:none">
            <select name="brand_id" id="brand_id">
              <option value="">请选择品牌</option>
              <? foreach((array)$brand as $k=>$v) {?>
              <option value="<?=$v[brand_id]?>"><?=$v[brand_name]?></option>
              <?}?>-->
            </select>
            <input type="hidden" name="brand_name" id="brand_name" value="<?=$factory['brand_name']?>">
            <input type="hidden" name="brand_id" id="brand_id" value="<?=$factory['brand_id']?>">
            </div>
            <? } else { ?>
            <select name="brand_id" id="brand_id">
              <option value="">请选择品牌</option>
              <? foreach((array)$brand as $k=>$v) {?>
              <option value="<?=$v[brand_id]?>"><?=$v[brand_name]?></option>
              <?}?>
            </select>
            <input type="hidden" name="brand_name" id="brand_name" value=""> 
            <? } ?>
            </td>
          </tr>
          <tr> 
            <td height="20" align="right">厂商名称:</td>
            <td class="td_left">
              <input type="text" name="factory_name" id="factory_name" size="20" value="<?=$factory['factory_name']?>">
            </td>
          </tr>
          <tr> 
            <td height="20" align="right" nowrap>简&nbsp;&nbsp;&nbsp;&nbsp;称：</td>
            <td class="td_left">
              <input name="factory_alias" id="factory_alias" value="<?=$factory['factory_alias']?>">
            </td>
          </tr>
          
          <tr> 
            <td height="20" align="right" nowrap>厂商性质：</td>
            <td class="td_left">
              <select id="factory_import" name="factory_import">
                <? foreach((array)$fi_list as $k=>$v) {?>
                <option value="<?=$k?>"><?=$v?></option>
                <?}?>
              </select>
            </td>
          </tr>
          
          <tr align="center"> 
            <td height="20" colspan="2">&nbsp; 
            <input type="hidden" name="factory_id" value="<?=$factory['factory_id']?>"> 
            <input type="hidden" name="fatherId" value="<?=$factory['brand_id']?>"> 
            <input type="submit" value="保存数据" name="button_factory" class='submit'>&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="submit" value="提交审核" name="toconfirm" class='submit'>&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="button" value="关闭" name="cancel" class='submit' onclick="javascript:history.go('-1');window.close();">
            &nbsp;&nbsp;&nbsp;
            </td>
          </tr>        
      </table>
      </form>
    </div>
    
  </div>
</div>
<script type="text/javascript">
$().ready(function(){
  $('#brand_id').change(function(){
    var sel=$(this)[0];
    $('#brand_name').val(sel.options[sel.selectedIndex].text)
  });
  
  <? if ($factory) { ?>
  $('#factory_import option[value="<?=$factory['factory_import']?>"]').attr({selected: 'true'});
  <? } ?>
  
  <? if ($fatherid) { ?>
 // var sel=$('#brand_id')[0];
 $('#brand_id option[value="<?=$fatherid?>"]').attr({selected:true});
 // $('input#brand_name').val(sel.options[sel.selectedIndex].text);
  <? } ?>
});
</script>
<? include $this->gettpl('footer');?> 