<? if(!defined('SITE_ROOT')) exit('Access Denied');?>
<? include $this->gettpl('header');?>
<div class="user">
    <div class="nav">
        <ul id="nav">
            <li><a href="<?=$php_self?>">返回</a></li>
            <li><a href="javascript:void(0);" class="song">报价详情</a></li>
        </ul>
    </div>
    <div class="clear"></div>
    <div class="user_con">
        <div class="user_con1">
            <form id="bingoprice_form" action="<?=$php_self?>update" method="post" enctype="multipart/form-data">
                <table cellpadding="0" cellspacing="0" class="table2" border="0">
            
                    <tr>
                        <td class="td_right" width="100px"> 车款名称：</td>
                        <td class="td_left"  width="600px">
                            <input type="text" name="model_name" size="50" value="<?=$list['model_name']?>">
                        </td>
                    </tr>
                     <tr>
                        <td class="td_right" width="100px"> 车系名称：</td>
                        <td class="td_left"  width="600px">
                            <input type="text" name="series_name" size="50" value="<?=$list['series_name']?>">
                        </td>
                    </tr>
                    <tr>
                        <td class="td_right" width="100px"> 厂商名称：</td>
                        <td class="td_left"  width="600px">
                            <input type="text" name="factory_name" size="50" value="<?=$list['factory_name']?>">
                        </td>
                    </tr><tr>
                        <td class="td_right" width="100px"> 品牌名称：</td>
                        <td class="td_left"  width="600px">
                            <input type="text" name="brand_name" size="50" value="<?=$list['brand_name']?>">
                        </td>
                    </tr>
                    <tr>
                        <td class="td_right" width="100px"> 厂商指导价：</td>
                        <td class="td_left"  width="600px">
                            <input type="text" name="model_price" size="50" value="<?=$list['model_price']?>">
                        </td>
                    </tr>
                    <tr>
                        <td class="td_right" width="100px"> 优惠幅度：</td>
                        <td class="td_left"  width="600px">
                            <input type="text" name="rate_price" value="<?=$list['rate_price']?>">
                        </td>
                    </tr>
                    <tr>
                        <td class="td_right" width="100px"> 经销商名称：</td>
                        <td class="td_left"  width="600px">
                            <input type="text" name="dealer_name" size="50" value="<?=$list['dealer_name']?>">
                        </td>
                    </tr>
                    <tr>
                        <td class="td_right" width="100px"> 经销商地址：</td>
                        <td class="td_left"  width="600px">
                            <input type="text" name="dealer_area" size="50" value="<?=$list['dealer_area']?>">
                        </td>
                    </tr>
                    <tr>
                        <td class="td_right" width="100px"> 活动标题：</td>
                        <td class="td_left"  width="600px">
                            <input type="text" name="title" size="50" value="<?=$list['title']?>">
                        </td>
                    </tr>
                     <tr>
                        <td class="td_right" width="100px"> 活动内容：</td>
                        <td class="td_left"  width="600px">
                  
                                <textarea name="content" style="width: 400px;height: 70px;"><?=$list['content']?></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td class="td_right" width="100px"> 有效期：</td>
                        <td class="td_left"  width="600px">
                            <input type="text" name="start_date" id="start_time" class="datepicker"
                                   value="<? if ($list['start_date']) { ?><? echo date('Y-m-d', $list['start_date']); ?><? } ?>" size="10" readonly/>  -
                            <input type="text" name="end_date" id="end_time" class="datepicker"
                                   value="<? if ($list['end_date']) { ?><? echo date('Y-m-d', $list['end_date']); ?><? } ?>" size="10" readonly/>
                        </td>
                    </tr>
                    <tr>
                        <td class="td_right" width="100px"> 销售姓名：</td>
                        <td class="td_left"  width="600px">
                            <input type="text" name="saler" value="<?=$list['saler']?>">
                        </td>
                    </tr>
                    <tr>
                        <td class="td_right" width="100px"> 销售性别：</td>
                        <td class="td_left"  width="600px">
                            <input type="radio"    name="saler_gender" <? if ($list['saler_gender']==1) { ?>checked<? } ?>  value="1"> 男 <input type="radio"   <? if ($list['saler_gender']==0) { ?>checked<? } ?> name="saler_gender" value="0"> 女
                        </td>
                    </tr>
                    <tr>
                        <td class="td_right" width="100px"> 手机号：</td>
                        <td class="td_left"  width="600px">
                            <input type="text" name="saler_tel" value="<?=$list['saler_tel']?>">
                        </td>
                    </tr>
                    <tr>
                        <td class="td_right" width="100px"> 来源渠道：</td>
                        <td class="td_left"  width="600px">
                            <input type="text" name="from_type"  value="<?=$list['from_type']?>">
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <input type="hidden" name="id" id="id" value="<?=$list['id']?>">
                            <input type="hidden" value="<?=$url?>" name="url" />
                            <input id="bingoprice_btn" type="submit" value="  提  交  " >
                        </td>
                    </tr>
                </table>
            </form>
        </div>
        <div class="user_con2"><img src="<?=$admin_path?>images/conbt.gif"  height="16" /></div>
    </div>
</div>
<? include $this->gettpl('footer');?>
<script type="text/javascript">
    $(document).ready(function() {
       // $('.datepicker').datepicker('option', 'maxDate', new Date());
        $('#nude_car_rate').keyup(function(){
            getDeliverPrice();
        });
		$('#brand_id').val(<?=$model['brand_id']?>);
		$('#factory_id').val(<?=$model['factory_id']?>);
		$('#series_id').val(<?=$model['series_id']?>);
		$('#model_id').val(<?=$model['model_id']?>);
		var xjprice = $("#nude_car_price").val();
		$("#purchase_tax").val(Math.round((xjprice * 10000) / 11.7));
		$('#brand_id').change(function() {
            var brand_id = $(this).val();
            var fact = $('#factory_id')[0];
            var facturl = "?action=factory-json&brand_id=" + brand_id;
            var sel = $(this)[0];
            $('#brand_name').val(sel.options[sel.selectedIndex].text)

            $.getJSON(facturl, function(ret) {
                $('#factory_id option[value!=""]').remove();
                $('#series_id option[value!=""]').remove();
                $('#model_id option[value!=""]').remove();

                $.each(ret, function(i, v) {
                    fact.options.add(new Option(v['factory_name'], v['factory_id']));
                });
            });
        });
		 $('#factory_id').change(function() {
            var fact_id = $(this).val();
            var ser = $('#series_id')[0];
            var serurl = "?action=series-json&factory_id=" + fact_id;
            var sel = $(this)[0];
            $('#factory_name').val(sel.options[sel.selectedIndex].text)

            $.getJSON(serurl, function(ret) {
                $('#series_id option[value!=""]').remove();
                $('#model_id option[value!=""]').remove();

                $.each(ret, function(i, v) {
                    ser.options.add(new Option(v['series_name'], v['series_id']));
                });
            });
        });

        $('#series_id').change(function() {
            var sel = $(this)[0];
            $('#series_name').val(sel.options[sel.selectedIndex].text)

            var sid = $(this).val();
            var mod = $('#model_id')[0];
            var modurl = "?action=model-json&sid=" + sid;
            $.getJSON(modurl, function(ret) {
                $('#model_id option[value!=""]').remove();
                $.each(ret, function(i, v) {
                    mod.options.add(new Option(v['model_name'], v['model_id']));
                });
            });
        });
        $('#model_id').change(function() {
            var sid = $(this).val();
            var modurl = "?action=orderentry-modelPrice&sid=" + sid;
            $.getJSON(modurl, function(ret) {
                $('#bingo_price').val(ret['model_price']);
                $('#nude_car_rate').val('');
                $("#deliver_price").val('');
				$("#pricee").val('');
				$("#modelchange").val(ret['model_id']);
            });
        });
		$('#province').change(function(){
			changeProvince($(this).val());
		})
		$('#city').change(function(){
			changeCity($(this).val());
		})
    });
    var province = "<?=$pid['id']?>|<?=$pid['name']?>";
    var city = "<?=$cid['id']?>|<?=$cid['name']?>";
    var county = "<?=$countyid['id']?>|<?=$countyid['name']?>";
    $("#province").val(province);
    $("#city").val(city);
    $("#area").val(county);
    function getDeliverPrice(){
        if ($('#nude_car_rate').val() == "" || (Number($("#nude_car_rate").val()) > Number($("#bingo_price").val()))){
            $('#deliver_price').val('');
            return;
        }
        var trunprice = Number($("#bingo_price").val()) - Number($("#nude_car_rate").val());
        trunprice = trunprice.toFixed(2);
        var purchase_tax = Math.round((trunprice * 10000) / 11.7);
        var temp = Number(trunprice * 10000) + Number(purchase_tax) + Number(1323);
        $('#purchase_tax').val(purchase_tax);
        $('#deliver_price').val(temp);
        $('#nude_car_price').val(trunprice);
    }

    
</script>