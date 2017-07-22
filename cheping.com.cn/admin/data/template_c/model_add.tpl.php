<? if(!defined('SITE_ROOT')) exit('Access Denied');?>
<? include $this->gettpl('header');?> 
<!--begin浮动的保存和关闭按钮，单独打开此页面显示，否则隐藏-->
<script>
    $(function () {
        if (parent.document.getElementById('frm_left') == null) {
            $('.admin_top').show();
        }
    });
</script>
<div class="admin_top" style="display: none;">
    <input class="adm_input" name="btn_float_save" id="btn_float_save" type="button"  value="保存" />
    <input class="adm_input" name="btn_float_close" id="btn_float_close" type="button" value="关闭" />
</div>
<!--end浮动的保存和关闭按钮-->

<div class="user_wrap">
    <div class="module_con">
        <div class="module_con1">
            <form name="frm_model_add" id="frm_model_add" action="" method="post" enctype="multipart/form-data">
                <table cellpadding="0" cellspacing="0" class="table2">
                    <tr> 
                        <td width="80" height="20" align="right">所属级别:</td>
                        <td class="td_left">
                            <? if ($model) { ?>
                            <?=$brand['brand_name']?> -&gt; <?=$factory['factory_name']?> -&gt; <?=$series['series_name']?>
                            <input type="hidden" name="brand_name" id="brand_name" value="<?=$brand['brand_name']?>"> 
                            <input type="hidden" name="brand_id" id="brand_id" value="<?=$brand['brand_id']?>"> 
                            <input type="hidden" name="factory_name" id="factory_name" value="<?=$factory['factory_name']?>"> 
                            <input type="hidden" name="factory_id" id="factory_id" value="<?=$factory['factory_id']?>"> 
                            <input type="hidden" name="series_name" id="series_name" value="<?=$series['series_name']?>"> 
                            <input type="hidden" name="series_id" id="series_id" value="<?=$series['series_id']?>"> 

                            <? } else { ?>
                            <? if ($father) { ?>
                            <?=$father['brand_name']?>-><?=$father['factory_name']?>-><?=$father['series_name']?>
                            <input type="hidden" name="brand_name" id="brand_name" value="<?=$father['brand_name']?>"> 
                            <input type="hidden" name="brand_id" id="brand_id" value="<?=$father['brand_id']?>"> 
                            <input type="hidden" name="factory_name" id="factory_name" value="<?=$father['factory_name']?>"> 
                            <input type="hidden" name="factory_id" id="factory_id" value="<?=$father['factory_id']?>"> 
                            <input type="hidden" name="series_name" id="series_name" value="<?=$father['series_name']?>"> 
                            <input type="hidden" name="series_id" id="series_id" value="<?=$father['series_id']?>">

                            <? } else { ?>
                            <select name="brand_id" id="brand_id">
                                <option value="">请选择品牌</option>
                                <? foreach((array)$brand as $k=>$v) {?>
                                <option value="<?=$v[brand_id]?>"><?=$v[brand_name]?></option>
                                <?}?>
                            </select>
                            <select name="factory_id" id="factory_id">
                                <option value="">请选择厂商</option>
                                <? foreach((array)$factory as $k=>$v) {?>
                                <option value="<?=$v[factory_id]?>"><?=$v[factory_name]?></option>
                                <?}?>
                            </select>
                            <select name="series_id" id="series_id">
                                <option value="">请选择车系</option>
                                <? foreach((array)$series as $k=>$v) {?>
                                <option value="<?=$v[series_id]?>"><?=$v[series_name]?></option>
                                <?}?>
                            </select>
                            <input type="hidden" name="brand_name" id="brand_name" value=""> 
                            <input type="hidden" name="factory_name" id="factory_name" value=""> 
                            <input type="hidden" name="series_name" id="series_name" value=""> 
                            <? } ?>
                            <? } ?>

                        </td>
                    </tr>
                    <? if ($model) { ?>
                    <tr> 
                        <td width="80" height="20" align="right">移动车款:</td>
                        <td class="td_left">
                            <select name="tbrand_id" id="tbrand_id">
                                <option value="">请选择品牌</option>
                                <? foreach((array)$allbrand as $k=>$v) {?>
                                <option value="<?=$v[brand_id]?>"><?=$v[brand_name]?></option>
                                <?}?>
                            </select>
                            <select name="tfactory_id" id="tfactory_id">
                                <option value="">请选择厂商</option>
                            </select>
                            <select name="tseries_id" id="tseries_id">
                                <option value="">请选择车系</option>
                            </select> 
                            <input type="button" id="mv_model" value="确定移动">         
                        </td>
                    </tr>
                    <? } ?>
                    <tr> 
                        <td width="80" height="20" align="right">车款名称:</td>
                        <td class="td_left">
                            <input type="text" name="model_name" id="model_name" size="40" value="<?=$model['model_name']?>">
                        </td>
                    </tr>
                    <tr> 
                        <td height="20" align="right">车辆年款:</td>
                        <td class="td_left">
                            <? $max_y = date('Y')+2;$min_y = date('Y')-10; ?>
                            <select name="date_id" id="date_id">
                                <option value="0">选择年款</option>
                                <? for($i=$min_y;$i<=$max_y;$i++) { ?>
                                <option value="<?=$i?>" <? if ($model['date_id']==$i) { ?>selected<? } ?>><?=$i?>年</option>
                                <? } ?>
                            </select>
                        </td>
                    </tr>
                    <tr> 
                        <td height="20" align="right">厂商指导价:</td>
                        <td class="td_left">
                            <input type="text" name="model_price" id="model_price" size="10" value="<?=$model['model_price']?>">万
                            &nbsp;&nbsp;
                            促销价:
                            <input type="text" name="bingo_price" id="bingo_price" size="10" value="<?=$model['bingo_price']?>">万
                            &nbsp;&nbsp;
                            北京地区在售状态：
                            <select name="bjstate" id="bjstate">
                                <option value="0">选择状态</option>
                                <option value="3" selected="selected">在售</option>
                                <option value="8">停产在售</option>
                                <option value="9">停产停售</option>
                            </select>
                            <script>$('#bjstate').val(<?=$bjState?>);</script>
                        </td>
                    </tr>
                    <tr> 
                        <td height="20" align="right" nowrap>关键字：</td>
                        <td class="td_left">
                            <textarea name="keyword" cols="70" rows="5" id="keyword"><?=$model['keyword']?></textarea>
                        </td>
                    </tr>
                    <tr> 
                        <td height="20" align="right">车款图片1:</td>
                        <td class="td_left">
                            <input type="file" name="model_pic1" id="model_pic1" size="40" value="">
                            <? if ($model['model_pic1']) { ?>
                            <a href="<?=$php_self?>pic&c=<? echo base64_encode('attach/images/model/' . $model['model_id'] . '/' . $model['model_pic1']); ?>" name="车款图片" class="jTip" id="vpic">
                                查看图片
                            </a>
                            <? } ?>
                        </td>
                    </tr>
                    <tr> 
                        <td height="20" align="right">车款图片2:</td>
                        <td class="td_left">
                            <input type="file" name="model_pic2" id="model_pic2" size="40" value="">
                            <? if ($model['model_pic2']) { ?>
                            <a href="<?=$php_self?>pic&c=<? echo base64_encode('attach/images/model/' . $model['model_id'] . '/' . $model['model_pic2']); ?>" name="车款图片" class="jTip" id="vpic">
                                查看图片
                            </a>
                            <? } ?>
                        </td>
                    </tr>
                    <tr> 
                        <td height="20" align="right">竞争车款:</td>
                        <td class="td_left">
                            <input type="text" name="compete_id" id="compete_id" size="20" value="<?=$model['compete_id']?>">
                            <select name="c_brand_id" id="c_brand_id">
                                <option value="">请选择品牌</option>
                                <? foreach((array)$allbrand as $k=>$v) {?>
                                <option value="<?=$v[brand_id]?>"><?=$v[brand_name]?></option>
                                <?}?>
                            </select>
                            <select name="c_factory_id" id="c_factory_id">
                                <option value="">请选择厂商</option>
                            </select>

                            <select name="c_series_id" id="c_series_id">
                                <option value="">请选择车系</option>
                            </select>

                            <select name="c_model_id" id="c_model_id" style="width:160px">
                                <option value="">请选择车款</option>
                            </select>
                        </td>
                    </tr>
                    <!--//begin 参数列表-->
                    <tr> 
                        <td class="td_left" colspan="2">车款参数：</td>
                    </tr>
                    <tr> 
                        <td class="td_left" colspan="2">
                            <table cellpadding="0" cellspacing="0" class="table2">
                                <? foreach((array)$param_list as $pk=>$pv) {?>
                                <tr><td colspan="4" class="td_left" style="font-size: 150%;color: blue"><b><? echo $parent_category[$pk]; ?></b></td></tr>
                                <? foreach((array)$pv as $ppk=>$ppv) {?>
                                <tr><td colspan="4" class="td_left" style="color: maroon"><b><? echo $pt[$ppk][name]; ?></b></td></tr>
                                <? for($i=0; $i<count($ppv);$i++) { ?>
                                <tr>
                                    <? if ($i==count($ppv)-1) { ?>
                                    <td height="22"><? echo $ppv[$i][name]; ?></td>
                                    <td colspan="3" class="td_left">
                                        <? echo $param_html[$ppv[$i][id]]; ?>
                                    </td>
                                    <? } else { ?>
                                    <td height="22"><? echo $ppv[$i][name]; ?></td>
                                    <td class="td_left">
                                        <? echo $param_html[$ppv[$i][id]]; ?>
                                    </td>
                                    <td height="22"><? echo $ppv[++$i][name]; ?></td>
                                    <td class="td_left">
                                        <? echo $param_html[$ppv[$i][id]]; ?>
                                    </td>
                                    <? } ?>
                                </tr>
                                <? } ?>
                                <?}?>
                                <?}?>
                            </table>
                        </td>
                    </tr>
                    <!--//end 参数列表-->
                    <tr align="center"> 
                        <td height="20" colspan="2">&nbsp; 
                            <input type="hidden" name="model_id" value="<?=$model['model_id']?>"> 
                            <input type="hidden" name="fatherId" value="<?=$fatherId?>"> 
                            <input type="submit" value="保存数据" name="button_factory" class='submit'>&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="submit" value="提交审核" name="toconfirm" class='submit'>&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="button" value="关闭" name="cancel" class='submit' onclick="javascript:history.go('-1');window.close();">
                            &nbsp;&nbsp;&nbsp;
                            <input type="hidden" name="fatherId" value=""></td>
                    </tr>        
                </table>
            </form>
        </div>

    </div>
</div>
<script type="text/javascript">
    $().ready(function () {
        $('#btn_float_save').click(function () {
            $('#frm_model_add')[0].submit();
        });

        $('#btn_float_close').click(function () {
            if (confirm('您确定要关闭当前窗口吗？')) {
                window.close();
            }
        });

        $('#brand_id,#tbrand_id').change(function () {
            var obj = $(this);
            var brand_id = obj.val();
            var fact = obj.siblings('select[name$="factory_id"]')[0];
            var facturl = "?action=factory-json&brand_id=" + brand_id;
            var sel = obj[0];
            obj.siblings('#brand_name').val(sel.options[sel.selectedIndex].text)

            $.getJSON(facturl, function (ret) {
                obj.siblings('select[name$="factory_id"]').find('option').remove('[value!=""]');
                $.each(ret, function (i, v) {
                    fact.options.add(new Option(v['factory_name'], v['factory_id']));
                });
            });
        });

        $('#factory_id, #tfactory_id').change(function () {
            var obj = $(this);
            var fact_id = obj.val();
            var ser = obj.siblings('select[name$="series_id"]')[0];
            var serurl = "?action=series-json&factory_id=" + fact_id;
            var sel = obj[0];
            obj.siblings('#factory_name').val(sel.options[sel.selectedIndex].text)

            $.getJSON(serurl, function (ret) {
                obj.siblings('select[name$="series_id"]').find('option').remove('[value!=""]');
                $.each(ret, function (i, v) {
                    ser.options.add(new Option(v['series_name'], v['series_id']));
                });
            });
        });

        $('#series_id').change(function () {
            var obj = $(this);
            var sel = obj[0];
            $('#series_name').val(sel.options[sel.selectedIndex].text)
        });

        //
        $('#c_brand_id').change(function () {
            var brand_id = $(this).val();
            var fact = $('#c_factory_id')[0];
            var facturl = "?action=factory-json&brand_id=" + brand_id;
            var sel = $(this)[0];

            $.getJSON(facturl, function (ret) {
                $('#c_factory_id option[value!=""]').remove();
                $('#c_series_id option[value!=""]').remove();
                $('#c_model_id option[value!=""]').remove();

                $.each(ret, function (i, v) {
                    fact.options.add(new Option(v['factory_name'], v['factory_id']));
                });
            });
        });

        $('#c_factory_id').change(function () {
            var fact_id = $(this).val();
            var ser = $('#c_series_id')[0];
            var serurl = "?action=series-json&factory_id=" + fact_id;
            var sel = $(this)[0];

            $.getJSON(serurl, function (ret) {
                $('#c_series_id option[value!=""]').remove();
                $('#c_model_id option[value!=""]').remove();

                $.each(ret, function (i, v) {
                    ser.options.add(new Option(v['series_name'], v['series_id']));
                });
            });
        });

        $('#c_series_id').change(function () {
            var sel = $(this)[0];
            var sid = $(this).val();
            var mod = $('#c_model_id')[0];
            var modurl = "?action=model-json&sid=" + sid;
            $.getJSON(modurl, function (ret) {
                $('#c_model_id option[value!=""]').remove();
                $.each(ret, function (i, v) {
                    mod.options.add(new Option(v['model_name'], v['model_id']));
                });
            });
        });

        $('#c_model_id').change(function () {
            var compete_id = $.trim($('#compete_id').val());
            if (compete_id != "") {
                $('#compete_id').val(compete_id + ',' + $(this).val());
            } else {
                $('#compete_id').val($(this).val());
            }
            //$('#model_name').val(mod.options[mod.selectedIndex].text)
        });

<? if ($model) { ?>
        //移动车款
        $('#mv_model').click(function () {
            if (confirm('您确定要移动该车款吗？')) {
                if ($('#tseries_id').val() < 1) {
                    alert('请选择车系后再移动！');
                    return false;
                }

                if ($('#tseries_id').val() == '<?=$model['series_id']?>') {
                    var series_name = $('#tseries_id option:selected').text();
                    alert('目的车系“' + series_name + '”与当前车系相同，不需要移动！');
                    return false;
                }

                location.href = '<?=$php_self?>move&model_id=<?=$model['model_id']?>&series_id=' + $('#tseries_id').val();
            }
        });
<? } ?>
    });
</script>
<? include $this->gettpl('footer');?> 