<? if(!defined('SITE_ROOT')) exit('Access Denied');?>
<? include $this->gettpl('header');?>
<div class="user">
    <div class="nav">
        <ul id="nav">
            <li><a href="<?=$php_self?>">返回</a></li>
            <li><a href="javascript:void(0);" class="song">新增报价</a></li>
        </ul>
    </div>
    <div class="clear"></div>
    <div class="user_con">
        <div class="user_con1">
            <form id="bingoprice_form" action="<?=$php_self?>addPricelog" method="post" enctype="multipart/form-data">
                <table cellpadding="0" cellspacing="0" class="table2" border="0">
                    <tr>
                        <td colspan="5" align="center">
                            <input type="radio" value="2" id="first" name="price_radio" checked="checked" onclick="radio(this.value)" /><label for="first">成本价</label>
                            <input type="radio" value="4" id="second" name="price_radio" onclick="radio(this.value)" /><label for="second">商情价</label>
                            <input type="radio" value="3" id="third" name="price_radio" onclick="radio(this.value)" /><label for="third">最多人购买价</label>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" class="td_right">
                            <font color="red"> * </font>车款名称：        
                        </td>
                        <td class="td_left">
                            <select name="brand_id" id="brand_id">
                                <option value="">==请选择品牌==</option>
                                <? foreach((array)$brand as $k=>$v) {?>
                                <option value="<?=$v[brand_id]?>"><?=$v[brand_name]?></option>
                                <?}?>
                            </select>
                            <select name="factory_id" id="factory_id">
                                <option value="">请选择厂商</option>
                            </select>
                        </td></tr>
                    <tr>
                        <td width="150" class="td_right">
                            <font color="red"> * </font>车款名称：        
                        </td>
                        <td class="td_left">
                            <select id="series_id" name="series_id">
                                <option value="">请选择车系</option>
                            </select>
                            <select id="model_id" name="model_id">
                                <option value="">请选择车款</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" class="td_right"><font color="red"> * </font>指导价：</td>
                        <td class="td_left">
                            <input type="text" name="model_price" id="model_price" disabled="disabled" />万
                        </td>
                    </tr>
                </table>
                <table cellpadding="0" cellspacing="0" class="table2" border="0" id="price2">
                    <tr>
                        <td width="150" class="td_right"><font color="red"> * </font>成本价：</td>
                        <td class="td_left">
                            <input type="text" name="price2" value="0.00" />万元
                        </td>
                    </tr>
                    <tr>
                        <td width="150" class="td_right">备注：</td>
                        <td class="td_left">
                            <textarea rows="10" cols="40" name="memo2"></textarea>
                        </td>
                    </tr>      	
                    <tr>
                        <td colspan="5" align="center">
                            <input type="submit" value=" 提 交 " />
                        </td>
                    </tr>      	     	
                </table>      
                <table cellpadding="0" cellspacing="0" class="table2" border="0" id="price4" style="display:none">
					<tr>
                        <td width="150" class="td_right">购置税：</td>
                        <td class="td_left">
                            <input type="text" disabled="disabled" id="purchase_tax">元
                        </td>
                    </tr>
					<tr>
                        <td width="150" class="td_right">交强险(950)+上牌费(373)：</td>
                        <td class="td_left">
                            <input type="text" disabled="disabled" value="1323">元
                        </td>
                    </tr>
					<tr>
                        <td width="150" class="td_right">提车价：</td>
                        <td class="td_left">
                            <input type="text" readonly="trun" id="deliver_price" name="deliver_price">元
                        </td>
                    </tr>
				<? foreach((array)$dbfields as $dfkey=>$dfval) {?>
					<tr>
                        <td width="150" class="td_right"><?=$dfval?></td>
                        <td class="td_left">
							<? if ($dfkey=='province' or $dfkey=='city' or $dfkey=='area' or $dfkey=='sale_gender' or $dfkey=='salestate') { ?>
								<select id="<?=$dfkey?>" name="<?=$dfkey?>"></select>
							<? } elseif($dfkey=='free_promotion_gift' or $dfkey=='promotion_gift' or $dfkey=='memo') { ?>
								<textarea name="<?=$dfkey?>" cols="40" rows="5"></textarea>
							<? } elseif($dfkey=='get_time') { ?>
								<input type="text" name="<?=$dfkey?>" class="datepicker" readonly="readonly">
							<? } elseif($dfkey=='ismade') { ?>
								<input type="text" id="<?=$dfkey?>" name="<?=$dfkey?>" size="50" value='在产' />
							<? } else { ?>
								<input type="text" id="<?=$dfkey?>" name="<?=$dfkey?>" size="50" />
							<? } ?>
                        </td>
                    </tr>					
				<?}?>
                    <tr>
                        <td colspan="5" align="center">
                            <input type="button" value=" 提 交 " onclick="chkbpfrom()" />
                        </td>
                    </tr>       	      	     	      	     	      	
                </table>
                <table cellpadding="0" cellspacing="0" class="table2" border="0" id="price3" style="display:none">
                    <tr>
                        <td width="150" class="td_right"><font color="red"> * </font>最多人购买价：</td>
                        <td class="td_left">
                            <input type="text" name="price3" value="0.00" />万
                        </td>
                    </tr> 
                    <tr>
                        <td colspan="5" align="center">
                            <input type="submit" value=" 提 交 " />
                        </td>
                    </tr>       	
                </table>            
            </form>
        </div>
        <div class="user_con2"><img src="<?=$admin_path?>images/conbt.gif"  height="16" /></div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
		$('.datepicker').datepicker('option', 'maxDate', new Date());
        $('#nude_car_rate').keyup(function() {
            if ($('#nude_car_rate').val() == "" || (Number($("#nude_car_rate").val()) > Number($("#model_price").val()))){
                $('#deliver_price').val('');
                return;
            }
            var trunprice = Number($("#model_price").val()) - Number($("#nude_car_rate").val());
            trunprice = trunprice.toFixed(2);
            var purchase_tax = Math.round((trunprice * 10000) / 11.7);
            var temp = Number(trunprice * 10000) + Number(purchase_tax) + Number(1323);
            $('#purchase_tax').val(purchase_tax);
            $('#deliver_price').val(temp);
            $('#nude_car_price').val(trunprice);
        });

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
                $('#model_price').val(ret['model_price']);
                $('#nude_car_rate').val('');
                $('#nude_car_price').val('');
                $("#deliver_price").val('');
				$('#purchase_tax').val('');
            });
        });
		$('#salestate').html('<option value="3">在售</option><option value="8">停产在售</option><option value="9">停产停售</option>');
		$('#province').change(function(){
			changeProvince($(this).val());
		});
		$('#city').change(function(){
			changeCity($(this).val());
		});
		$.getJSON("index.php?action=dealer-province", function(data) {
			var option = '<option value="0">==请选择省级地区==</option>';
			for (var key in data) {
				option += '<option value="' + data[key]['id'] + '|' + data[key]['name'] + '">' + data[key]['letter'] +'&nbsp;'+ data[key]['name'] + '</option>' + "n";
			}
			$('#province').html(option);
		});
    });
    function radio(id){
            if (id == 4) {
                $("#price4").show();
                $("#price2").hide();
                $("#price3").hide();
            }
            if (id == 3) {
                $("#price3").show();
                $("#price2").hide();
                $("#price4").hide();
            }
            if (id == 2) {
                $("#price2").show();
                $("#price3").hide();
                $("#price4").hide();
            }
    }
    function changeProvince(pid) {
        var option = '<option value="0">==请选择地级地区==</option>';
        $.getJSON("index.php?action=dealer-City&pid=" + pid, function(data) {
            for (var key in data) {
                option += '<option value="' + data[key]['id'] + '|' + data[key]['name'] + '">' + data[key]['letter'] +'&nbsp;'+ data[key]['name'] + '</option>' + "n";
            }
            $('#city').html(option);
            $("#area").html('<option value="0">==请选择县级地区==</option>');
        });
    }
    function changeCity(cid) {
        var option = '<option value="0">==请选择县级地区==</option>';
        $.getJSON("index.php?action=dealer-County&cid=" + cid, function(data) {
            for (var key in data) {
                option += '<option value="' + data[key]['id'] + '|' + data[key]['name'] + '">' + data[key]['letter'] +'&nbsp;'+ data[key]['name'] + '</option>' + "n";
            }
            $('#area').html(option);
        });
    }
    function chkbpfrom() {
        if ($('#nude_car_price').val()<1 || $('#province').val()=='0' || $('#city').val()=='0' || $('#area').val()=='0' || $('#get_time').val()=='' || $('#creator').val()==''){
            alert('信息不能为空!');
            return false;
        }
        $('#bingoprice_form').submit();
    }
</script>
<? include $this->gettpl('footer');?>