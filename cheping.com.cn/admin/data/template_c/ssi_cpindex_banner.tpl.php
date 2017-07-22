<? if(!defined('SITE_ROOT')) exit('Access Denied');?>
<div class="ct_v_b">
<div class="content_v3_banner">
    <div class="hot">
        <div style="float:left;" id="cover">
        <ul>
            <? foreach((array)$focus as $key=>$row) {?>
            <? if ($row['title']) { ?>
            <li id="cover<?=$key?>"><a target="_blank" href="<? if ($row['link']=='') { ?>javascript:void(0);<? } else { ?><?=$row['link']?><? } ?>"><img alt="<?=$row['title']?>" <? if ($key == 1) { ?>src="attach/images/<?=$row['pic']?>"<? } else { ?>src2="attach/images/<?=$row['pic']?>"<? } ?> onerror="this.src='images/440x251.jpg'" width="659" height="273"></a></li>
            <? } ?>
            <?}?>
        </ul>
         </div>
        <ul id="idNum" class="num1">
            <? foreach((array)$focus as $key=>$row) {?>
            <? if ($row['title']) { ?>
            <li class="num_now<?=$key?>"><a href="javascript:void(0);" id="num<?=$key?>" <? if ($key == 1) { ?>class="num_now"<? } else { ?>class="num_other"<? } ?> onmouseover="coverHover(<?=$key?>);"></a></li>
            <? } ?>
            <?}?>
        </ul>
        <input type="hidden" value="1" id="count">
    </div>
</div>
<!-- 推荐轮播图-->
<div>
  <div class="v_content">
    <div class="img_l"><img id="img_l_1" src="images/roll_left.png"  style="display:none"/></div>
    <div class="v_content_nav">
      <div class="v_content_w">
         <? foreach((array)$recommendfocus as $key=>$row) {?>
            <div class="v_content_array">
                <div class="v_content_img">
                    <a style="text-decoration:none" target="_blank" href="<? if ($row['link']) { ?><?=$row['link']?><? } else { ?>javascript:void(0)<? } ?>">
                        <img src<? if ($key > 4 || $key < 2) { ?>2<? } ?>="attach/images/<?=$row['pic']?>" width="218" height="135" onerror="this.src='images/220x155.jpg'" />
                        <span class="zi"></span>
                        <p class="zi_about">
                            <?=$row['mname']?> <?=$row['title']?>
                        </p>
                    </a>
                </div>
            </div>
        <?}?>
      </div>
    </div>
    <div class="img_r"><img id="img_r_1" src="images/roll_right.png" style="display:none" /></div>
  </div>
</div>

</div>
     