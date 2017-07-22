<? if(!defined('SITE_ROOT')) exit('Access Denied');?>
<? include $this->gettpl('header');?>
<div class="user">
    <div class="nav">
        <ul id="nav">
            <li><a href="javascript:void(0);" class="song">双11活动列表</a></li>

        </ul>
    </div>
    <div class="clear"></div>
<div class="user_con">
<div class="user_con1">
  <form action="<?=$php_self?>nov11" method="post">
  <table class="table2" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td>
       品牌
      <select name="brand_id" id="brand_id">
        <option value="0">请选择</option>
        <? foreach((array)$brand as $k=>$v) {?>
        <option value="<?=$v[brand_id]?>"><?=$v['letter']?> <?=$v['brand_name']?></option>
        <?}?>
      </select>
      厂商
      <select name="factory_id" id="factory_id">
        <option value="0">请选择</option>
        <? foreach((array)$factory as $k=>$v) {?>
        <option value="<?=$v['factory_id']?>"><?=$v['factory_name']?></option>
        <?}?>
      </select>
      车系
      <select name="series_id" id="series_id">
        <option value="0">请选择</option>
        <? foreach((array)$series as $k=>$v) {?>
        <option value="<?=$v['series_id']?>"><?=$v['series_name']?></option>
        <?}?>
      </select>
      车款
      <select name="model_id" id="model_id">
        <option value="0">请选择</option>
        <? foreach((array)$model as $k=>$v) {?>
        <option value="<?=$v['model_id']?>"><?=$v['model_name']?></option>
        <?}?>
      </select><br/>
	  来源网站
	  <select name="from_channel" id="from_channel">
        <option value="0">请选择</option>
        <? foreach((array)$from_arr as $k=>$v) {?>
        <option value="<?=$v['from_channel']?>"><?=$v['from_channel']?></option>
        <?}?>
      </select>
	  排序方式
	  <select name="order_mode" id="order_mode">
        <option value="0">请选择</option>
        <option value="get_time">获取时间</option>
        <option value="discount_val">优惠幅度</option>
		<option value="discount">折扣</option>
      </select>
	  线下提车结束时间
	  <input type="text" class="datepicker" name="offline_end_date" id="offline_end_date" />
      <input type="submit" name="search" value=" 搜 索 ">
	  <a href="<?=$php_self?>nov11&export=ok&brand_id=<?=$brand_id?>&factory_id=<?=$factory_id?>&series_id=<?=$series_id?>&model_id=<?=$model_id?>&from_channel=<?=$from_channel?>&order_mode=<?=$order_mode?>&offline_end_date=<?=$offline_end_date?>">导出搜索结果</a><br/>
      </td>
    </tr>
  </table>
  </form>
  <table class="table2" border="0" cellpadding="0" cellspacing="0">
    <tbody>
      <tr class="th">
        <th>来源网站</th>
        <th>厂商名称</th>
        <th>车系名称</th>
        <th>车款名称</th>
        <th>获取时间</th>
        <th>优惠幅度</th>
        <th>折扣</th>
        <th>操作</th>
      </tr>
      <? foreach((array)$websaleinfo as $infok=>$infov) {?>
      <tr align="center">
        <td><?=$infov['from_channel']?></td>
        <td><?=$infov['factory_name']?></td>
        <td><?=$infov['series_name']?></td>
        <td><?=$infov['model_name']?></td>
        <td><? echo date('Y-m-d',$infov['get_time']) ?></td>
        <td><?=$infov['discount_val']?></td>
        <td><?=$infov['discount']?></td>
        <td><a href="<?=$php_self?>nov11editlist&brand_id=<?=$brand_id?>&factory_id=<?=$factory_id?>&series_id=<?=$series_id?>&model_id=<?=$model_id?>&from_channel=<?=$from_channel?>&order_mode=<?=$order_mode?>&offline_end_date=<?=$offline_end_date?>&page=<?=$page?>&id=<?=$infov['id']?>">详情列表</a></td>
      </tr>
       <?}?>
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
<div class="user_con2"><img src="<?=$admin_path?>images/conbt.gif" height="16" ></div>
</div>
</div>
<script type="text/javascript">
$().ready(function(){
	$('#brand_id').val(<?=$brand_id?>);
	$('#factory_id').val(<?=$factory_id?>);
	$('#series_id').val(<?=$series_id?>);
	$('#model_id').val(<?=$model_id?>);
	$('#from_channel').val('<?=$from_channel?>');
	$('#order_mode').val('<?=$order_mode?>');
	$('#offline_end_date').val('<?=$offline_end_date?>');
	$('#brand_id').change(function(){
		var brand_id=$(this).val();
		var fact=$('#factory_id')[0];
		var facturl="?action=factory-json&brand_id="+brand_id;
		var sel=$(this)[0];
		$('#brand_name').val(sel.options[sel.selectedIndex].text);

		$.getJSON(facturl, function(ret){
			$('#factory_id option[value!="0"]').remove();
			$('#series_id option[value!="0"]').remove();
			$('#model_id option[value!="0"]').remove();		  
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
			$('#series_id option[value!="0"]').remove();
			$('#model_id option[value!="0"]').remove();
			$.each(ret, function(i,v){
				ser.options.add(new Option(v['series_name'], v['series_id']));
			});
		});
	});
	$('#series_id').change(function() {
		var sel = $(this)[0];
		var sid = $(this).val();
		var mod = $('#model_id')[0];
		var modurl = "?action=model-json&sid=" + sid;
		$('#series_name').val(sel.options[sel.selectedIndex].text)

		$.getJSON(modurl, function(ret) {
			$('#model_id option[value!="0"]').remove();
			$.each(ret, function(i, v) {
				mod.options.add(new Option(v['model_name'], v['model_id']));
			});
		});
	});
});

</script>
<? include $this->gettpl('footer');?>
