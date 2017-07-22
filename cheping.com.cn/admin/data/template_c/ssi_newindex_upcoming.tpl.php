<? if(!defined('SITE_ROOT')) exit('Access Denied');?>
<div class="new_car">
	<div class="car_title">
		<h3 style=" color:#666666; font-size:16px; margin-left:10px; float:left;">即将上市</h3>
	</div>
	<ul class="have_xian">
		<li style="width:100px;">时间</li>
		<li style="width:118px;">品牌/车系</li>
		<li style="width:83px;">预售价格</li>
	</ul>
	<div class="car_list">
		<div style="position: absolute; height: 36px; margin-top: 0px;" class="car_list_gun">
		<? foreach((array)$result as $val) {?>
			<ul>
				<li style="width:100px;"><?=$val['date']?></li>
				<li style="width:118px;"><a href="<?=$val['url']?>" target="_blank"><?=$val['car_name']?></a></li>
				<li style="width:83px;"><span style="color:#ed5050;"><?=$val['price']?></span> </li>
			</ul>
		<? } ?>
		</div>
	</div>
</div>