<? if(!defined('SITE_ROOT')) exit('Access Denied');?>
<? include $this->gettpl('header');?>
<div class="user">
    <div class="nav">
        <ul id="nav">
            <li><a href="<?=$php_self?>">返回</a></li>
            <li><a href="javascript:void(0);" class="song">导出详情</a></li>
        </ul>
    </div>
    <div class="clear"></div>
 <div class="user_con">
    <div class="user_con1">
    <form action="<?=$php_self?>importantEdit" method="post" name="form2" id="form">
                <table class="table2" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td>
                            <select name="brand_id" id="brand_id">
                            <option value="">请选择品牌</option>
                            <? foreach((array)$brand as $k=>$v) {?>
                            <option value="<?=$v[brand_id]?>" <? if ($v[brand_id]==$brand_id) { ?>selected<? } ?>><?=$v[brand_name]?></option>
                            <?}?>
                          </select>
                          <select name="factory_id" id="factory_id">
                            <option value="">请选择厂商</option>
                            <? foreach((array)$factory as $k=>$v) {?>
                            <option value="<?=$v[factory_id]?>" <? if ($v[factory_id]==$factroy_id) { ?>selected<? } ?>><?=$v[factory_name]?></option>
                            <?}?>
                          </select>
                          <select name="series_id" id="series_id">
                            <option value="">请选择车系</option>
                            <? foreach((array)$series as $k=>$v) {?>
                            <option value="<?=$v[series_id]?>" <? if ($v[series_id]==$series_id) { ?>selected<? } ?>><?=$v[series_name]?></option>
                            <?}?>
                          </select>
                          <select name="model_id" id="model_id" style="width:160px">
                            <option value="">请选择车款</option>
                            <? foreach((array)$model as $k=>$v) {?>
                            <option value="<?=$v[model_id]?>" <? if ($v[model_id]==$model_id) { ?>selected<? } ?>><?=$v[model_name]?></option>
                            <?}?>
                          </select>
                         </td>
                    </tr>
                    <tr>
                        <td>
                            <font style="color:red">*</font> 添加日期
			    <input type="text" name="s_created" id="s_created" class="datepicker"
                                   value="<? if ($created) { ?><? echo date('Y-m-d', $created); ?><? } ?>" size="10" readonly/>  -
                            <input type="text" name="e_created" id="e_created" class="datepicker"
                                   value="<? if ($e_created) { ?><? echo date('Y-m-d', $e_created); ?><? } ?>" size="10" readonly/>
                         有效日期
			    <input type="text" name="start_date" id="start_time" class="datepicker"
                                   value="<? if ($start_date) { ?><? echo date('Y-m-d', $start_date); ?><? } ?>" size="10" readonly/>  -
                            <input type="text" name="end_date" id="end_time" class="datepicker"
                                   value="<? if ($end_date) { ?><? echo date('Y-m-d', $end_date); ?><? } ?>" size="10" readonly/>
                        </td>
                    </tr>
                       <tr>
                        <td>
                            <font style="color:red">可以选择不同的条件，导出不同的内容*****两个时间必须选择一个</font><br>
                          <input type="button" id="butt" name="search" value=" 导出">
                        </td>
                    </tr>
                    </tbody>
                </table>
            </form>
      
   </div>
   <div class="user_con2"><img src="<?=$admin_path?>images/conbt.gif"  height="16" /></div>
</div>
</div> 
<script language="javascript">
$("#butt").click(function(){
var reason1 = $("#s_created").val();
var state1 = $("#e_created").val();
var reason2 = $("#start_time").val();
var state2 = $("#end_time").val();
if(reason1!=''&&state1!=''||reason2!=''&&state2!=''){
$("#form").submit();
}else{
alert("至少要选择一个时间");
return false;
}
}) 
</script>
<script>
    
$().ready(function(){
   $('#brand_id').change(function(){
    var brand_id=$(this).val();
    var fact=$('#factory_id')[0];
    var facturl="?action=factory-json&brand_id="+brand_id;
    var sel=$(this)[0];
    $('#brand_name').val(sel.options[sel.selectedIndex].text)

    $.getJSON(facturl, function(ret){
      $('#factory_id option[value!=""]').remove();
      $('#series_id option[value!=""]').remove();
      $('#model_id option[value!=""]').remove();

      $.each(ret, function(i,v){
        fact.options.add(new Option(v['factory_name'], v['factory_id']));
      });
    });
  });

  $('#factory_id').change(function(){
    var fact_id=$(this).val();
    var ser=$('#series_id')[0];
    var serurl="?action=series-json&factory_id="+fact_id;
    var sel=$(this)[0];
    $('#factory_name').val(sel.options[sel.selectedIndex].text)

    $.getJSON(serurl, function(ret){
      $('#series_id option[value!=""]').remove();
      $('#model_id option[value!=""]').remove();

      $.each(ret, function(i,v){
        ser.options.add(new Option(v['series_name'], v['series_id']));
      });
    });
  });

  $('#series_id').change(function(){
    var sel=$(this)[0];
    $('#series_name').val(sel.options[sel.selectedIndex].text)

    var sid=$(this).val();
    var mod=$('#model_id')[0];
    var modurl="?action=model-json&sid="+sid;
    $.getJSON(modurl, function(ret){
      $('#model_id option[value!=""]').remove();
      $.each(ret, function(i,v){
        mod.options.add(new Option(v['model_name'], v['model_id']));
      });
    });
  });

  $('#model_id').change(function(){
    var mod=$(this)[0];
    $('#model_name').val(mod.options[mod.selectedIndex].text)
  });
  
 <? if ($brand_id) { ?>
  $('#brand_id option[value="<?=$brand_id?>"]').attr({selected:true});
    <? } ?>
 <? if ($factory_id) { ?>
  $('#factory_id option[value="<?=$factory_id?>"]').attr({selected:true});
    <? } ?>
    <? if ($series_id) { ?>
  $('#series_id option[value="<?=$series_id?>"]').attr({selected:true});
    <? } ?>
 <? if ($model_id) { ?>
  $('#model_id option[value="<?=$model_id?>"]').attr({selected:true});
  <? } ?>
  
  
});

</script>
<? include $this->gettpl('footer');?>      
