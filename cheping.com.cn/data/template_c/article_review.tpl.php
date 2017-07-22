<? if(!defined('SITE_ROOT')) exit('Access Denied');?>
<? if ($css) { ?>
<? foreach((array)$css as $k=>$v) {?>
<link rel="stylesheet" href="css/<?=$v?>.css" />
<?}?>
<? } ?>
<? if ($js) { ?>
<? foreach((array)$js as $k=>$v) {?>
<script src="js/<?=$v?>.js" type="text/javascript"></script>
<?}?>
<? } ?>

<script>
 $(function() { 
    var num = <?=$total?>;
    window.parent.document.getElementById("review_num").innerHTML = num; 
    
    var type_id = window.parent.type_id; //获取父中的js变量 
    document.getElementById('type_id').value = type_id;
});
//
function reviewfocus(){
    $("#content").val('');
    $("#content").focus();
}

function clogin(i){
    $("#uid").val(i);
}
function tabs(i) { 
    var articleid = $("#article_id").val();
    var typeid = $("#type_id").val();
    $("#select_tab"+i).addClass("ll").siblings().removeClass("ll"); 
    $("#select_tab"+i).addClass("ff").siblings().removeClass("ff");

    var tab = $("#select_tab"+i).attr("title"); 
    if(tab=='f1'){
      $("#type").val(1); 
       location.href="/review.php?action=list&type=1&article_id="+articleid+"&type_id="+typeid;
    }else{
       $("#type").val(2);
       location.href="/review.php?action=list&type=2&article_id="+articleid+"&type_id="+typeid;
    }
    //$("#" + tab).show().siblings().hide(); 
};

function sub_review(){
    var content =$("#content").val();
    var uid =$("#uid").val();
    

    if(uid==0){
        window.parent.plogin()
        return false;
    }

    if(!content||content =='请登录后评论'){
        alert("请填写评价内容");
        return false; 
    }

    $("#sub_form").submit();
}
</script>

<div class="say-con">
    <div class="say-con-title">
        <span class="saysp1">评论</span>
        <span class="saysp2">(<?=$total?>)</span>
    </div>
    <div class="say-text" >
        <i class="fl"><img src="/images/user.png" /></i>
        <span class="fr">
        <form action='/review.php?action=submitreview' method="post" id='sub_form'>
            <textarea style=" resize:none; padding: 10px;" name='content' id='content' value="请登录后评论" onClick="if(this.value=='请登录后评论'){this.value='';}" onBlur="if(this.value==''){this.value='请登录后评论';this}">请登录后评论</textarea>
            <button class="butt fr" style="cursor:pointer;" type='button' name="fb" onclick='sub_review()'>发表评论</button>
            <input type='hidden' value="<?=$uid?>" id='uid' name='uid'>
            <input type='hidden' value="<?=$type_id?>" id='type_id' name='type_id'>
            <input type='hidden' value="<?=$article_id?>" id='article_id' name='article_id'>
        </form>
        </span>
    </div>
    <div class="clear"></div>
    <input type="hidden" id="type" name="type" value="<?=$type?>">
    <div class="say-change" style="margin-top:-60px; margin-bottom: 115px;">
        <div class="tab" style="margin-bottom: 20px;">
            <ul> 
            <li id='select_tab1'<? if ($type==1) { ?>class="ff"<? } ?> title="f1" onclick="tabs(1)">最新</li> 
            <li id='select_tab2' <? if ($type==2) { ?>class="ff"<? } ?>  title="f2" onclick="tabs(2)">最认可</li> 
            </ul> 
        </div>
        <div class="say-main"> 
            <div id="f1">
                <? if ($page_bar) { ?>
                <div class="ep-pages" style="padding:0px;"><?=$page_bar?></div>
                <? } ?>
                <? if ($list) { ?>
                <div class="say-dl-con">
                    <ul>
                       <? foreach((array)$list as $key=>$value) {?>
                        <li>
                        <div class="say-discus-img fl"><span><img src="images/user.png" /></span></div>
                        <div class="say-discus fl">
                            <div class="say-discus-ti" style='width: 800px;'>
                              <span style=" color:#5188a6; font-size:14px;"><?=$value['username']?></span>
                                <div class="say-discus-xi fr">
                                    <span style=" color:#727271; font-size:12px;"><? echo date("i",time()-$value['created']) ?>分钟前</span>
                                    <span style=" color:#727271; font-size:12px; margin-left:20px;"><?=$num?>楼</span> 
                                </div>
                                <div class="clear"></div>
                            </div>

                            <div class="say-repeat" id="return_content<?=$value['id']?>">
                            <? if ($value['child']) { ?>
                                <? if ($uid!==0) { ?>
                                    <? $c_num=count($value['child']) ?>
                                    <? foreach((array)$value['child'] as $k=>$v) {?>
                                        <? if (intval($v[uid])==$uid) { ?>
                                            <? if ($v[state]==2) { ?>
                                                <div class="repeat">
                                                    <span class="repeatsp1 fl"><?=$v[username]?></span>
                                                    <span class="repeatsp2 fl" style="color:#ed2d28;">提交成功，您的回复内容正在审核中，请耐心等待</span>
                                                    <span class="repeatsp3 fr"><?=$c_num?></span>
                                                    <div class="clear"></div>  
                                                </div>
                                            <? } elseif($v[state]==1) { ?>
                                             <div class="repeat">
                                                 <span class="repeatsp1 fl"><?=$v[username]?></span>
                                                 <span class="repeatsp2 fl" ><?=$v[content]?></span>
                                                 <span class="repeatsp3 fr"><?=$c_num?></span>
                                                 <div class="clear"></div>  
                                             </div>
                                            <? } ?>
                                        <? } else { ?>
                                            <? if ($v[state]==1) { ?>
                                                <div class="repeat">
                                                    <span class="repeatsp1 fl"><?=$v[username]?></span>
                                                    <span class="repeatsp2 fl" ><?=$v[content]?></span>
                                                    <span class="repeatsp3 fr"><?=$c_num?></span>
                                                    <div class="clear"></div>  
                                                </div>
                                            <? } ?>
                                        <? } ?>
                                    <? $c_num-- ?>
                                    <?}?>
                                <? } else { ?>
                                    <? $c_num=count($value['child']) ?>
                                    <? foreach((array)$value['child'] as $k=>$v) {?>
                                        <? if ($v[state]==1) { ?>
                                            <div class="repeat">
                                                <span class="repeatsp1 fl"><?=$v[username]?></span>
                                                <span class="repeatsp2 fl" ><?=$v[content]?></span>
                                                <span class="repeatsp3 fr"><?=$c_num?></span>
                                                <div class="clear"></div>  
                                            </div>
                                       <? } else { ?>
                                       <? } ?>
                                    <? $c_num-- ?>
                                    <?}?>
                                <? } ?>
                            <? } ?>
                            </div>
                            <? if ($uid!==0) { ?>
                                
                                <? if ($value['state']==2) { ?>
                                    <? if ($uid==$value['uid']) { ?>
                                        <div class="saysay">
                                            <div style="margin-left: 15px; margin-top:20px;color:#ed2d28;">提交成功，您的评论内容正在审核中，请耐心等待</div>
                                        </div> 
                                    <? } ?>
                                <? } else { ?>
                                    <div class="saysay">
                                        <?=$value['content']?>
                                    </div> 
                                <? } ?>
                            <? } else { ?>
                                <? if ($value['state']==1) { ?>
                                    <div class="saysay">
                                        <?=$value['content']?>
                                    </div>
                                <? } ?>
                            <? } ?>
                            <? if ($value['state']==2) { ?>
                            <? } else { ?>
                            <div style="width:800px;"> 
                                <p class="praise fr"><span onclick="praise(<?=$value['id']?>)" id="praise<?=$value['id']?>" style="cursor:pointer;">赞(<?=$value['praise']?>)</span><span style="cursor:pointer;" class="hui" onclick='return_review(<?=$value['id']?>)'>回复</span></p> 
                                <div class='review_all' id="review_id<?=$value['id']?>" style='display: none;'>
                                <textarea id="content_value<?=$value['id']?>" style="width:780px;" rows="2" class="huifukuang"></textarea>
                                <button  style="cursor:pointer;" class="huifupinglun" onclick="submitreview(<?=$value['id']?>)">确认回复</button>
                                </div>
                            </div>
                            <? } ?>
                        </div>
                        <div class="clear"></div>   
                     </li>

                    <? $num-- ?>
                     <?}?>
                    </ul>
                </div>
                <? } else { ?>
                <div style="margin-left: 15px; margin-top:60px;">暂无评论</div>
                <? } ?>
                <? if ($page_bar) { ?>
                <div class="ep-pages"><?=$page_bar?></div>
            <? } ?>
            </div> 
            <div id="f2" style="display:none">dsgjkhghjksdfhgshdgshg</div> 
        </div> 
    </div>
</div>  

<script>
    function return_review(i){
        window.parent.iFrameHeight();
        var dis = $("#review_id"+i).css("display");
        if(dis=='none'){
            $(".review_all").css("display","none")
            $("#review_id"+i).toggle("slow");
        }else{
            $("#review_id"+i).toggle("slow");
        }
    }
    function submitreview(i){
        var articleid = $("#article_id").val();
        var contents = $("#content_value"+i).val();
        var uid =$("#uid").val();
        if(uid==0){
            window.parent.plogin()
            return false;
        }

        if(!contents){
            alert("请填写评价内容");
            return false;
        }
        
        $.get("/review.php?action=ReviewAnswer",{"contents":contents,"id":i,"article_id":articleid},function(msg){
            if(msg){
                $("#return_content"+i).prepend(msg);
                $("#content_value"+i).val('');
                $("#review_id"+i).toggle("slow");
            }else{
                alert("评论失败");
            }
        })
    }
    function praise(i){
         $.get("/review.php?action=ReviewPraise",{"id":i},function(msg){
            if(msg==-4){
                alert("今天已赞，可以明天再来！");
            }else{
                $("#praise"+i).html(msg);
            }
        })
    }
</script>