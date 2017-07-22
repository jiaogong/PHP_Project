<? if(!defined('SITE_ROOT')) exit('Access Denied');?>
<? include $this->gettpl('header');?>
<div class="user">
    <div class="nav">
        <ul id="nav">
        <li><a href="javascript:void(0);" class="song">首页推荐列表</a></li>
        <li><a href="?action=recommend-EditRecommend">增加首页推荐</a></li>
    </ul>
    </div>
    <div class="clear"></div>
    <div class="user_con">
        <div class="user_con1">
            <table class="table2" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <th width="25%">编号</th>
                    <th width="25%">名称</th>
                    <th width="25%">提交日期</th>
                    <th width="10%">操作</th>
                </tr>    
                <? $i = 0 ?>
                <? foreach((array)$list as $val) {?>
                <? $i++ ?>
                <tr>
                    <td><?=$i?></td>
                    <td><?=$val['cate']?></td>
                    <td><? echo date("Y-m-d H:i:s", $val['created']) ?></td>
                    <td><a href="?action=recommend-EditRecommend&id=<?=$val['id']?>">查看</a>&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" mt='1' icon='warnning' tourl="?action=recommend-del&id=<?=$val['id']?>" class="click_pop_dialog">删除</a></td>
                </tr>
                <? } ?>
            </table>
        </div>
        <div class="user_con2">
            <img src="<?=$admin_path?>images/conbt.gif" height="16" >
        </div>
    </div>
</div>
<script>
$('.click_pop_dialog').live('click', function(){
    pop_window($(this), {message:'您确定要删除该推荐车型内容吗？', pos:[200,150]});
});
</script>
<? include $this->gettpl('footer');?>
