<? if(!defined('SITE_ROOT')) exit('Access Denied');?>
<? include $this->gettpl('header');?>
<div class="user">
    <div class="nav">
        <ul id="nav">
        <li><a href="?action=recommend">首页推荐列表</a></li>
        <li><a href="?action=recommend-EditRecommend" class="song">增加首页推荐</a></li>
        </ul>
    </div>
    <div class="clear"></div>
 <div class="user_con">
    <div class="user_con1">    
    <form action="" method="post" enctype="multipart/form-data" >
    <table cellpadding="0" cellspacing="0" class="table2" border="0">      
          <tr> 
            <td width="18%" height="20" align="right">分类名称：</td>
            <td width="82%" style="text-align: left;padding-left: 5px;">
            <input type="text" name="name" id="name" size="20" value="<?=$category['cate']?>">
            </td>
          </tr>
          <tr> 
            <td width="18%" height="20" align="right">搜索条件及连接地址：</td>
            <td width="82%" style="text-align: left;padding-left: 5px;">
                <input type="text" name="condition1" id="condition1" size="20" value="<?=$category['value']['condition'][1]?>">&nbsp;<input type="text" name="url1" id="url1" size="20" value="<?=$category['value']['url'][1]?>"><br>
                <input type="text" name="condition2" id="condition2" size="20" value="<?=$category['value']['condition'][2]?>">&nbsp;<input type="text" name="url2" id="url2" size="20" value="<?=$category['value']['url'][2]?>">
                <br><input type="text" name="condition3" id="condition3" size="20" value="<?=$category['value']['condition'][3]?>">&nbsp;<input type="text" name="url3" id="url3" size="20" value="<?=$category['value']['url'][3]?>">
            </td>
          </tr>
          <tr>
            <td width="18%" height="20" align="right">价格区间：</td>
            <td width="82%" style="text-align: left;padding-left: 5px;">
            <input type="text" name="price1" id="price1" size="20" value="<?=$category['value']['price'][1]?>" />
            <input type="text" name="price2" id="price2" size="20" value="<?=$category['value']['price'][2]?>" />
            <input type="text" name="price3" id="price3" size="20" value="<?=$category['value']['price'][3]?>" />
            </td>
          </tr>   
          <tr>
            <td width="18%" height="20" align="right">车型图片(226x187)：</td>
            <td width="82%" style="text-align: left;padding-left: 5px;">
            <input type="file" name="rpic" id="rpic" size="20" /><font style="color: red;"><?=$v?></font>
            </td>
          </tr>  
          <tr>
            <td width="18%" height="20" align="right">推荐品牌：</td>
            <td width="82%" style="text-align: left;padding-left: 5px;">
              <? $sum=range(1,8); ?>
              <? foreach((array)$sum as $v) {?>
                <select id="brand<?=$v?>" name="brand<?=$v?>">
                <option value="0">选择品牌</option>
                <? foreach((array)$allbrand as $brand) {?>
                <option value="<?=$brand['brand_id']?>"><?=$brand['brand_name']?></option>
                <? } ?>
                </select>
              <? } ?>     
            </td>          
          </tr>
          <tr>
            <td width="18%" height="20" align="right">推荐车款及广告语：</td>
            <td width="82%" style="text-align: left;padding-left: 5px;">
            <? $sum = range(1,15); ?>
            <? foreach((array)$sum as $v) {?>
            <? $svarid = "series_".$v;$mvarid = "model_".$v;$series = $$svarid; $models = $$mvarid; ?>
            <span style="color: red"><?=$v?></span>
            <select id="brand_id<?=$v?>" name="brand_id<?=$v?>" onchange="getSeries($(this),$(this).val());" class="brand_select" style="width: 100px;">
            <option value="0">选择品牌</option>
            <? foreach((array)$allbrand as $brand) {?>
            <option value="<?=$brand['brand_id']?>"><?=$brand['brand_name']?></option>
            <? } ?>
            </select>
            <select id="series_id<?=$v?>" name="series_id<?=$v?>" class="series_select"  onchange="getModel($(this),$(this).val());" style="width: 150px;">
                <? if ($series) { ?>
                    <? foreach((array)$series as $sk=>$sv) {?>
                    <option value="<?=$sv['series_id']?>"><?=$sv['series_name']?></option>
                    <?}?>
                <? } ?>
            </select>
            <select id="model_id<?=$v?>" name="model_id<?=$v?>" class="model_select" style="width: 200px;" >
                <? if ($models) { ?>
                    <? foreach((array)$models as $mk=>$mv) {?>
                    <option value="<?=$mv['model_id']?>"><?=$mv['model_name']?></option>
                    <?}?>
                <? } ?>
            </select>
            <? $nav = array(3,4,5,8,9,10,13,14,15) ?>
            <? if (in_array($v, $nav)) { ?>
            <select id="nav<?=$v?>" name="nav<?=$v?>">
                <option value="1">特价</option>
                <option value="2">人气</option>
                <option value="3">新品</option>                
            </select>
            <script>$('#nav<?=$v?>').val(<? echo $category['value']['model']['n'][$category['value']['model']['m'][$v]] ?>)</script>
            <? } ?>
            <? $ad = array(1,2,6,7,11,12) ?>
            <? if (in_array($v, $ad)) { ?>
            <input style="margin-bottom:10px;" type="text" size="74" name="ad<?=$v?>" id="ad<?=$v?>" value="<? echo $category['value']['model']['a'][$category['value']['model']['m'][$v]] ?>">
            <? } ?>
            <br>
            <? } ?>
            </td>
          </tr>
          <tr align="center"> 
            <td height="20" colspan="2">&nbsp; 
            <input type="hidden" name="id" id="id" value="<?=$id?>"> 
            <input type="submit" value="保存数据" name="button_factory" class='submit'>&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="button" value="关闭" name="cancel" class='submit' onclick="javascript:history.go('-1');window.close();">
            &nbsp;&nbsp;&nbsp;
            <input type="hidden" name="fatherId" value=""></td>
          </tr>        
      </table>
      </form>
    </div>
   <div class="user_con2"><img src="<?=$admin_path?>images/conbt.gif"  height="16" /></div>
  </div>
</div>
<script>
$().ready(function(){
  /*
  $('.brand_select').live('change', function(){
    var brand_id=$(this).val();
    var subobj = $(this).next('select');
    var subobj1 = $(this).next('select').get(0);
    var subobj2 = $(this).next('select').next('select');
    
    var remote_url='?action=series-json&t=brand&brand_id='+brand_id;
    var sel=$(this)[0];
    
    $.getJSON(remote_url, function(ret){
      $('option[value!="0"]', subobj).remove();
      $('option[value!="0"]', subobj2).remove();
      
      $.each(ret, function(i,v){
        subobj1.options.add(new Option(v['series_name'], v['series_id']));
      });
    });
  });
  
  
  $('.series_select').live('change', function(){
    var sel=$(this)[0];
    var sid=$(this).val();
    var remote_url="?action=model-json&sid="+sid;
    var subobj = $(this).next('select');
    var subobj1 = $(this).next('select').get(0);
    
    $.getJSON(remote_url, function(ret){
      $('option[value!="0"]', subobj).remove();
      $.each(ret, function(i,v){
        subobj1.options.add(new Option(v['model_name'], v['model_id']));
      });
    });
  });*/
  
});

$('select[name^="model_id"]').change(function() {
    var model_id = $(this).val();
    var obj = $(this);
    $('select[name^="model_id"]').not($(this)).each(function() {
        if($(this).val() == model_id) {
            alert("选择车款重复,请重新选择!");            
            obj.val(0);
            return false;
        }
    });                  
});

function getSeries(obj,brand_id){
    var brand_id=obj.val();
    var subobj = obj.next('select');
    var subobj1 = obj.next('select').get(0);
    var subobj2 = obj.next('select').next('select');

    var remote_url='?action=series-json&t=brand&brand_id='+brand_id;
    //var sel=$(this)[0];
    
    $.getJSON(remote_url, function(ret){
        $('option[value!="0"]', subobj).remove();
        $('option[value!="0"]', subobj2).remove();

        $.each(ret, function(i,v){
            subobj1.options.add(new Option(v['series_name'], v['series_id']));
        });
         getModel(subobj,ret.series_id);
    });
}

function getModel(obj,sid){
    var sid=obj.val();
    var remote_url="?action=model-json&sid="+sid;
    var subobj = obj.next('select');
    var subobj1 = obj.next('select').get(0);

    $.getJSON(remote_url, function(ret){
      $('option[value!="0"]', subobj).remove();
      $.each(ret, function(i,v){
        subobj1.options.add(new Option(v['model_name'], v['model_id']));
      });
    });
}

<? foreach((array)$category['value']['brand'] as $k=>$brand) {?>
    $('#brand<?=$k?> option[value="<?=$brand?>"]').attr("selected", true);
<?}?>

<? foreach((array)$category['value']['model']['b'] as $k=>$brand_id) {?>    
    $('#brand_id<?=$k?> option[value="<?=$brand_id?>"]').attr("selected", true);
<?}?>   
<? foreach((array)$category['value']['model']['s'] as $k=>$series_id) {?>
    $('#series_id<?=$k?> option[value="<?=$series_id?>"]').attr("selected", true);
    chk_model_select($('#model_id<?=$k?>'), <?=$series_id?>, <?=$k?>, <?=$category['value']['model']['m'][$k]?>);    
<?}?>
</script>
<? include $this->gettpl('footer');?> 