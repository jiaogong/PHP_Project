<? if(!defined('SITE_ROOT')) exit('Access Denied');?>
<? include $this->gettpl('header');?>
<div class="user">
<div class="nav">
    <ul id="nav">
        <li ><a <? if ($state=='' || $state==1 || $state==4) { ?>class="song"<? } ?> href="index.php?action=dealerprice-list&state=1">车辆报价列表</a></li>
        <li ><a <? if ($state==2) { ?>class="song"<? } ?> href="index.php?action=dealerprice-list&state=2">最新添加报价</a></li>
        <li ><a <? if ($state==3) { ?>class="song"<? } ?> href="index.php?action=dealerprice-list&state=3">最新修改报价</a></li>
        <li ><a <? if ($state==5) { ?>class="song"<? } ?> href="index.php?action=dealerprice-list&state=5">删除报价申请</a></li>
        <li><a href="index.php?action=dealerprice-add">添加车辆报价</a></li>
    </ul>
    </div>
    <div class="clear"></div>
    <div class="user_con">
        <div class="user_con1">
            <form id="search_form" name="search_form" method="post" action="index.php?action=dealerprice-list">
                <input type="hidden" name="state" value="<?=$state?>" />
            <table class="table2" border="0" cellpadding="0" cellspacing="0">
                <tr>
                <td>
            <? if ($state==1 || $state==4) { ?>
            <select name="state" id="changestate" onchange="search_state(this.value)" style="width: 90px;">
                <option value="1" <? if ($state==1) { ?> selected<? } ?>>正常</option>
                <option value="4" <? if ($state==4) { ?> selected<? } ?>>未通过</option>
                </select>
            <? } ?>
                </td>
                    <td align="left">                                        
                        <select id="province_id" name="province_id" onchange="changeProvince(this.value);">
                            <option value="0">==请选择省份==</option>
                            <option value="24">A 安徽</option>
                            <option value="29">A 澳门</option>
                            <option value="1">B 北京</option>
                            <option value="4">C 重庆</option>
                            <option value="33">F 福建</option>
                            <option value="12">G 甘肃</option>
                            <option value="30">G 广东</option>
                            <option value="31">G 广西</option>
                            <option value="19">G 贵州</option>
                            <option value="34">H 海南</option>
                            <option value="8">H 河北</option>
                            <option value="22">H 河南</option>
                            <option value="5">H 黑龙江</option>
                            <option value="21">H 湖北</option>
                            <option value="20">H 湖南</option>
                            <option value="7">J 吉林</option>
                            <option value="25">J 江苏</option>
                            <option value="32">J 江西</option>
                            <option value="41">J 九龙</option>
                            <option value="43">L 离岛</option>
                            <option value="6">L 辽宁</option>
                            <option value="9">N 内蒙</option>
                            <option value="13">N 宁夏</option>
                            <option value="150">Q 其它</option>
                            <option value="16">Q 青海</option>
                            <option value="23">S 山东</option>
                            <option value="11">S 山西</option>
                            <option value="10">S 陕西</option>
                            <option value="2">S 上海</option>
                            <option value="17">S 四川</option>
                            <option value="27">T 台湾北部</option>
                            <option value="146">T 台湾东部</option>
                            <option value="147">T 台湾离岛</option>
                            <option value="145">T 台湾南部</option>
                            <option value="144">T 台湾中部</option>
                            <option value="3">T 天津</option>
                            <option value="15">X 西藏</option>
                            <option value="28">X 香港岛</option>
                            <option value="14">X 新疆</option>
                            <option value="42">X 新界</option>
                            <option value="18">Y 云南</option>
                            <option value="26">Z 浙江</option>
                        </select>         
                        <select id="city_id" name="city_id">
                            <option value="0">==请选择城市==</option>
                            <? if ($city) { ?>
                            <? foreach((array)$city as $k=>$v) {?>
                                <option value="<?=$v['id']?>"><?=$v['letter']?> <?=$v['name']?></option>
                            <?}?>
                            <? } ?>                            
                        </select>
                        经销商名称：
                         <input type="text" id="dealer_name" name="dealer_name" size="10" value="<?=$conditionArr['dealer_name']?>" />
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td align="left">
                        <select name="brand_id" id="brand_id">
                        <option value="">==请选择品牌==</option>
                        <? foreach((array)$brand as $k=>$v) {?>
                        <option value="<?=$v[brand_id]?>"><?=$v[brand_name]?></option>
                        <?}?>
                      </select>
                      <select name="factory_id" id="factory_id">
                        <option value="">==请选择厂商==</option>
                        <? foreach((array)$factory as $k=>$v) {?>
                        <option value="<?=$v[factory_id]?>"><?=$v[factory_name]?></option>
                        <?}?>                        
                      </select>                            
                      <select name="series_id" id="series_id">
                        <option value="">==请选择车系==</option>
                        <? foreach((array)$series as $k=>$v) {?>
                        <option value="<?=$v[series_id]?>"><?=$v[series_name]?></option>
                        <?}?>                        
                      </select>               
                      <select name="model_id" id="model_id" style="width:160px">
                        <option value="">==请选择车款==</option>
                        <? foreach((array)$model as $k=>$v) {?>
                        <option value="<?=$v[model_id]?>"><?=$v[model_name]?></option>
                        <?}?>                        
                      </select>         
                      <input id="search_btn" name="search_btn" type="submit" value="搜索" />                    
                    </td>                    
                </tr>
            </table>
            </form>
            <table class="table2" border="0" cellpadding="0" cellspacing="0" style="table-layout:fixed;word-wrap: break-word;">
                <tr align="right"  class='th'>
                    <td width="24%">车款</td>
                    <td width="20%">经销商</td>
                    <td width="6%">地区</td>
                    <td width="8%">指导价</td>
                    <td width="8%">经销商最低报价</td>
                    <td width="8%">报价<br>(万元)</td>
                    <? if ($state==1) { ?>
                    <td width="10%">入库日期</td><? } else { ?>
                    <td width="10%">提交日期</td>
                    <? } ?>
                    <td width="16%">操作</td>
                </tr>
                <? foreach((array)$list as $k=>$v) {?>
                <tr class='th'>
                    <td><?=$v['factory_name']?> <?=$v['series_name']?> <br/><?=$v['model_name']?></td>
                    <td><?=$v['dealer_name']?></td>
                    <td><?=$v['province_name']?><?=$v['city_name']?></td>
                    <td><?=$v['model_price']?></td>
                    <td><?=$v['dealer_price_low']?></td>
                    <td><?=$v['bingo_price']?></td>
                    <td><? echo date("Y-m-d H:i:s", $v['updated']) ?></td>
                    <? if ($v[state]<>5) { ?>
                    <td><a href="index.php?action=dealerprice-edit&id=<?=$v['id']?>"><img src="<?=$admin_path?>images/rewrite.gif" width="12" height="12" />修改</a>
                        <a class="click_pop_dialog" href="javascript:void(0);" mt='1' icon='warnning' tourl="index.php?action=dealerprice-delete&id=<?=$v['id']?>&dealer_id=<?=$v['dealer_id']?>&modelid=<?=$v['model_id']?>&seriesid=<?=$v['series_id']?><?=$condition?>"><img src="<?=$admin_path?>images/del1.gif" width="9" height="9" />删除</a>&nbsp;&nbsp;&nbsp;<br/>
                        <select name="state" id="state_<?=$v[id]?>" class="state" onchange="change_aa(<?=$v['id']?>,<?=$v['dealer_id']?>,<?=$v['series_id']?>,<?=$v['model_id']?>,<?=$v['state']?>,this.value,<?=$state?>,'<?=$condition?>')" style="width: 75px;">
        <option value="1" <? if (($v['state']==1) ) { ?>selected <? } ?>>正常</option>
        <option value="3" <? if (($v['state']==2 || $v['state']==3) ) { ?>selected <? } ?>>待审核</option>
        <option value="4" <? if (($v['state']==4) ) { ?>selected <? } ?>>未通过</option>
    </select>
    <font <? if ($v['state']==3 || $v['state']==2) { ?>color="yellow"<? } elseif($v['state']==1) { ?>color="green"<? } elseif($v['state']==4) { ?>color="blue"<? } else { ?>color="red"<? } ?>>■</font><br/>
    
     
                    </td>
                    <? } else { ?>
                    <td><a href="index.php?action=dealerprice-edit&id=<?=$v['id']?>"><img src="<?=$admin_path?>images/rewrite.gif" width="12" height="12" />修改</a>
                        <a class="click_pop_dialog" href="javascript:void(0);" mt='1' icon='warnning' tourl="index.php?action=dealerprice-delete&id=<?=$v['id']?>&dealer_id=<?=$v['dealer_id']?>&modelid=<?=$v['model_id']?>&seriesid=<?=$v['series_id']?><?=$condition?>"><img src="<?=$admin_path?>images/del1.gif" width="9" height="9" />删除</a>&nbsp;&nbsp;&nbsp;<br/>
                        <select name="state" id="state_<?=$v[id]?>" class="state" onchange="change_aa(<?=$v['id']?>,<?=$v['dealer_id']?>,<?=$v['series_id']?>,<?=$v['model_id']?>,<?=$v['state']?>,this.value,<?=$state?>,'<?=$condition?>')" style="width: 75px;">
                            <option value="5" <? if (($v['state']==5) ) { ?>selected <? } ?>>删除申请</option>
        <option value="6">通过</option>
        <option value="1" >未通过</option>
    </select>
    <font <? if ($v['state']==3 || $v['state']==2) { ?>color="yellow"<? } elseif($v['state']==1) { ?>color="green"<? } elseif($v['state']==4) { ?>color="blue"<? } else { ?>color="red"<? } ?>>■</font><br/>
                    </td>
                    <? } ?>
                </tr>
                <?}?>
                <tr class='ep-pages'>
                    <td colspan="8">
                        <? if ($page_bar) { ?><?=$page_bar?><? } elseif($total) { ?>共<?=$total?>条<? } else { ?>&nbsp<? } ?>
                    </td>
                </tr>
            </table>
            <div style="height:40px;"></div>
        </div>
        <div class="user_con2">
            <img src="<?=$admin_path?>images/conbt.gif" height="16" >
        </div>
    </div>
</div>
<script>
var pid = '<?=$conditionArr['province_id']?>';
var cid = '<?=$conditionArr['city_id']?>';
var did = '<?=$conditionArr['dealer_id']?>';
var bid = '<?=$conditionArr['brand_id']?>';
var fid = '<?=$conditionArr['factory_id']?>';
var sid = '<?=$conditionArr['series_id']?>';
var mid = '<?=$conditionArr['model_id']?>'; 
$('#province_id option[value="' + pid + '"]').attr({selected:true});
$('#city_id option[value="' + cid + '"]').attr({selected:true});
$('#dealer_id option[value="' + did + '"]').attr({selected:true});
$('#brand_id option[value="' + bid + '"]').attr({selected:true});
$('#factory_id option[value="' + fid + '"]').attr({selected:true});
$('#series_id option[value="' + sid + '"]').attr({selected:true});
$('#model_id option[value="' + mid + '"]').attr({selected:true});
$(document).ready(function(){
  $('.click_pop_dialog').live('click', function(){
    pop_window($(this), {message:'您确定要删除该经销商报价吗？', pos:[200,150]});
  });
  
});
function change_aa(id,dealer_id,seriesid,modelid,oldstate,type,state,condition){
    if(confirm('您确认要修改该经销商报价审核状态吗？')){
        location.href='index.php?action=dealerprice-update&id='+id+'&dealer_id='+dealer_id+'&seriesid='+seriesid+'&modelid='+modelid+'&type='+type+'&state='+state+'&condition='+condition
    }else{
        var state_id="state_"+id;
        $("#"+state_id).val(oldstate);
        return false;
    }
}
function changeProvince(pid) {
    var option = '<option value="0">==请选择城市==</option>';
    if(pid > 0) {
        $.getJSON("index.php?action=dealer-city", {pid:pid}, function(json) {
            for(var key in json) {
                id = json[key]['id'];
                name = json[key]['name'];
                letter = json[key]['letter'];
                option += '<option value="'+ id + '">' + letter + ' '+ name + '</option>' + "\n";                    
            }
            $('#city_id').html(option);
        }); 
    }
    else {
        $('#city_id').html(option);
    }
}
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
  $('#color').focus(function(){
      $('#color').val('');
  });
function search_state(state){
    location.href='index.php?action=dealerprice&state='+state
}
  
</script>
    </body>
</html> 
