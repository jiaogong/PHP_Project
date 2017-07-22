<? if(!defined('SITE_ROOT')) exit('Access Denied');?>
<? include $this->gettpl('header');?> 
        <div class="user">
            <div class="nav">
                <ul id="nav">
			        <li><a href="<?=$php_self?>discountlist">信息预览</a></li>
			        <li><a href="javascript:void(0);"  class="song">添加</a></li>
			        <li><a href="<?=$php_self?>hotcarNotice&act=discount">逻辑说明</a></li>
			    </ul>
                </div>
            <div class="clear"></div>
		    <div class="user_con">
		        <div class="user_con1">
					<form method="post" action="<?=$php_self?>discountadd" enctype="multipart/form-data" id="form<?=$key?>">
						<table cellpadding="0" cellspacing="0" class="table2" border="0">
							<? for($i=0; $i<1; $i++) { ?>
								<tr>
									<td><? echo $i+1 ?>&nbsp;&nbsp;</td>
									<? if ($discountact) { ?>
										<td><label for="profile<?=$i?>">显示前台显示文字，须在45个字符之间</label><textarea id="profile<?=$i?>" name="profile[]"><?=$discountact[$i]['profile']?></textarea></td>
										<td><label for="detail<?=$i?>">显示商情页模块<font color="red">(只能添数字或者空)</font></label><textarea id="detail<?=$i?>" name="detail[]"><?=$discountact[$i]['detail']?></textarea></td>
										<td><label for="index<?=$i?>">显示推荐指数</label><input type="text" value="<?=$discountact[$i]['index']?>" name="index[]" id="index<?=$i?>" /></td>
										<td><label for="bingoid<?=$i?>">录入暗访价ID</label><input type="text" value="<?=$discountact[$i]['bingoid']?>" name="bingokey[]" id="bingoid<?=$i?>" /></td>
									<? } else { ?>
										<td><label for="profile<?=$i?>">显示前台显示文字，须在45个字符之间</label><textarea id="profile<?=$i?>" name="profile[]"></textarea></td>
										<td><label for="detail<?=$i?>">显示商情页模块<font color="red">(只能添数字或者空)</font></label><textarea id="detail<?=$i?>" name="detail[]"></textarea></td>
										<td><label for="index<?=$i?>">显示推荐指数</label><input type="text" value="" name="index[]" id="index<?=$i?>" /></td>
										<td><label for="bingoid<?=$i?>">录入暗访价ID</label><input type="text" value="" name="bingokey[]" id="bingoid<?=$i?>" /></td>
									<? } ?>
								</tr>
							<? } ?>
							<tr><td><input type="hidden" value="<?=$start_time?>" name="start_time" /><input type="hidden" value="<?=$id?>" name="dbid" /><input type="submit" /></td></tr>
						</table>
					</form>
		        </div>
		        <div class="user_con2"><img src="<?=$admin_path?>images/conbt.gif"  height="16" /></div>
		    </div>
			<p>显示商情页模块：11=贷款方案是固定的，商情页填的值按顺序，填的第一个就填1</p>
		</div>
		<script type="text/javascript">
			$(function(){
				var cur_val,cur_word_total,word_total_title2=45;
				$("textarea[name='profile[]']").keyup(function(){
					cur_val = $(this).val();
					cur_word_total = cur_val.length;
					if(cur_word_total > word_total_title2){
						$(this).val(cur_val.substr(0,word_total_title2));
					}
				})
			})
		</script>
    </body>
</html>