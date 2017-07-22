<? if(!defined('SITE_ROOT')) exit('Access Denied');?>
<? include $this->gettpl('header');?>
<div class="user">
            <div class="nav">
                <ul id="nav">
        			<li><a href="javascript:void(0);" class="song">操作</a></li>
    			</ul>
    		</div>
            <div class="clear"></div>
    <div class="user_con">
        <div class="user_con1">
			<form method="post" action="<?=$php_self?>addFocus" enctype="multipart/form-data">
			<table cellpadding="0" cellspacing="0" class="table2" border="0">
				<? foreach((array)$focusact as $key=>$val) {?>
				<tr height="100px;">
					<td style="width:50px;"><?=$key?></td>
                                        <td style="width:60px;">&nbsp;</td>
                                        <td style="text-align: left;">
						<select name="flag[]" class="flag">
							<option value="">请选择</option>
							<option value="1">文章页</option>
							<option value="2">车款页</option>
							<option value="3">商情页</option>
						</select>
                                            <? if ($num==5) { ?><input type="file" name="focus_pic[]" />&nbsp;&nbsp;
											<a class="jTip" id="focuspic<?=$key?>" href="<?=$_ENV['PHP_SELF']?>pic&pic=<? if ($val) { ?><? if ($num==5 && $val['createfiletime']!='' ) { ?><?=$val['createfiletime']?>/<? } ?><?=$val['pic']?>&mid=<?=$val['model_id']?>&state=focus<?=$num?><? } ?>">
											查看图片</a>&nbsp;&nbsp;&nbsp;&nbsp;
											图片标签：<input type="text" name="picalt[]" value="<? if ($val and $val['picalt']) { ?><?=$val['picalt']?><? } ?>"><br/><? } ?>
						<? if ($val and $val['str']) { ?>
							<span><?=$val['str']?></span>
						<? } ?>                                            
						<input type="hidden" value="<? if ($val) { ?><?=$val['flag']?><? } ?>" id="flag<?=$key?>" />
						<input type="hidden" value="<? if ($val) { ?><?=$val['pic']?><? } ?>" name = "prev_pic[]" />
                                                <input type="text" value="<? if ($val and $val['title']) { ?><?=$val['title']?><? } ?>" name="title[]" size="30" />
                                                <? if ($num == 2) { ?>(20个字符或10个汉字)<? } ?>
                                                <input type="text" value="<? if ($val and $val['title2']) { ?><?=$val['title2']?><? } ?>" name="title2[]" size="96" />
                                                <? if ($num == 2) { ?>(96个字符或48个汉字)<? } ?>
					</td>
				</tr>
				<?}?>
				<tr>
					<td colspan="3">
						<input type="hidden" name="start_time" value="<?=$start_time?>" />
						<input type="hidden" value="<?=$num?>" id="num" name="num" />
						<input type="hidden" value="<?=$id?>" id="num_id" />
						<input type="submit" value="提交" />
					</td>
				</tr>
			</table>
			</form>
        </div>
		<div class="user_con2"><img src="<?=$admin_path?>images/conbt.gif"  height="16" /></div>
    </div>
</div>
<script type="text/javascript">
	var s1 = '<select name="brand_i[]" class="brand_id" onchange="javascript:brandChange(this);"><option value="">==请选择品牌==</option></select>&nbsp;&nbsp;<select class="factory_id" name="factory_i[]" onchange="javascript:factoryChange(this);"><option value="">==请选择厂商==</option></select>&nbsp;&nbsp;<select name="series_i[]" class="series_id" onchange="javascript:seriesChange(this);"><option value="">==请选择车系==</option></select>';
	var s2 = '&nbsp;&nbsp;<select name="model_i[]" class="model_id"><option value="">==请选择车款==</option></select>';
	var s3 = '&nbsp;&nbsp;文章id:<input type="text" size="5" name="article_i[]">';
	var s4 = '&nbsp;&nbsp;商情价id:<input type="text" size="5" name="bingoprice_i[]">';
	var s5 = '&nbsp;&nbsp;<input type="text" size="5">';
	$(function(){
		var num = $("#num").val();
		var brand_op;
		if(num==2){
			word_total_title = 20;
			word_total_title2 = 96;
			$('.flag:eq(0)').val(3);
			$('.flag:eq(1)').val(3);
			$('.flag').attr('disabled','true');
			var numId = $("#num_id").val();
			if(!numId){
				$('select').parent().append('<div>' + s4 +'</div>');
				/*if(brand_op){
						$('.brand_id').append(brand_op);
				}else{
					$.getJSON("?action=brand-json", function(ret){
						$('select').parent().append('<div>' + s1 + s2 + s4 +'</div>');
						$.each(ret, function(i,v){
							brand_op += '<option value='+v['brand_id']+'>'+v['letter']+'&nbsp;&nbsp;'+v['brand_name']+'</option>';
							//$('.brand_id').append('<option value='+v['brand_id']+'>'+v['letter']+'&nbsp;&nbsp;'+v['brand_name']+'</option>');
						})
						$('.brand_id').append(brand_op);
					})
				}*/
			}

		}else{
			$('.flag:eq(0)').val($("#flag1").val());
			$('.flag:eq(1)').val($("#flag2").val());
			$('.flag:eq(2)').val($("#flag3").val());
			$('.flag:eq(3)').val($("#flag4").val());
			$('.flag:eq(4)').val($("#flag5").val());
			$("select[name='flag[]']").change(function(){
				var selectVal = $(this).val();
				var currentObj = $(this);
				$(currentObj).parent().find("div").remove();
				switch(selectVal){
					case "1":
						currentObj.parent().append('<div>' + s3 + '</div>');
					break;
					case "2":
						currentObj.parent().append('<div>' + s1 + s2 + '</div>');
					break;
					case "3":
						currentObj.parent().append('<div>' + s4 + '</div>');
					break;
					case "4":
						currentObj.parent().append(s1);
					break;
				}
				if(selectVal == "2"){
					if(brand_op){
						$('.brand_id').append(brand_op);
					}else{
						$.getJSON("?action=brand-json", function(ret){
							$.each(ret, function(i,v){
								brand_op += '<option value='+v['brand_id']+'>'+v['letter']+'&nbsp;&nbsp;'+v['brand_name']+'</option>';
							})
							$('.brand_id').append(brand_op);
						})
					}
				}
			})
		}
         
		$("input[name='title[]']").keyup(function(){
			substrTitle(this, word_total_title);
		})

		$("input[name='title2[]']").keyup(function(){
			substrTitle(this, word_total_title2);
		})
        
		/*$('.model_id').live('change', function(){
			$(this).parent().find('input').val($(this).val());
		})*/
	})
	//var word_regexp = /[\u4e00-\u9fa5]/g;
	var cur_word_total, cur_val;
	var word_total_title = 22, word_total_title2 = 100;
    
    function brandChange(obj){
        var brand_id=$(obj).val();
        var facturl="?action=factory-json&brand_id="+brand_id;
        var sel=obj;
        $.getJSON(facturl, function(ret){
            $(sel).next().find("option[value!='']").remove();
            $(sel).next().next().find("option[value!='']").remove();
            $(sel).next().next().next().find("option[value!='']").remove();
            $.each(ret, function(i,v){
                //$(sel).next().append('<option value='+v['factory_id']+'>'+v['factory_name']+'</option>');
                $(sel).next()[0].add(new Option(v['factory_name'], v['factory_id']));
            })
        })
    }
    function factoryChange(obj){
        var fact_id=$(obj).val();
        var serurl="?action=series-json&factory_id="+fact_id;
        var sel=obj;

        $.getJSON(serurl, function(ret){
            $(sel).next().find("option[value!='']").remove();
            $(sel).next().next().find("option[value!='']").remove();
            $.each(ret, function(i,v){
                $(sel).next()[0].add(new Option(v['series_name'], v['series_id']));
                //$(sel).next().append('<option value='+v['series_id']+'>'+v['series_name']+'</option>');
            })
        })
    }
    function seriesChange(obj){
        var sel=obj;
        var series_id = $(obj).val();
        var modurl="?action=model-json&sid="+series_id;
        $.getJSON(modurl, function(ret){
            $(sel).next().find("option[value!='']").remove();
            $.each(ret, function(i,v){
                $(sel).next()[0].add(new Option(v['model_name'], v['model_id']));
                //$(sel).next().append('<option value='+v['model_id']+'>'+v['model_name']+'</option>');
            })
        })
    }
	function substrTitle(obj, word_total){
		cur_val = $(obj).val();
		cur_word_total = cur_val.length;
		if(cur_word_total > word_total){
			$(obj).val(cur_val.substr(0,word_total));
		}
	}
</script>
    </body>
</html>