<? if(!defined('SITE_ROOT')) exit('Access Denied');?>
<? include $this->gettpl('header');?> 
<div class="user">
    <div class="nav">
        <ul>
            <li><a href="<?=$php_self?>advice" class="song">app用户反馈</a></li> 
        </ul>
    </div>
    <div class="clear"></div>
    <div class="user-con">
        <div style=" padding:20px 5px; width：98%; border-bottom:1px solid #ccc; ">
            <form id="search_form" name="search_form" method="post" action="">
                <table style=" table-layout: auto; width:100%; "border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>ID:<input type="text" name="id" size="4" value="<?=$id?>"/></td>
                        <td>
                            <input id="search_btn" name="search_btn" type="submit" value="搜索" />
                        </td>
                    </tr>
                </table>
            </form>
        </div>
        <div class="user-table">
            <table border="0" cellspacing="0" cellpadding="0">

                <tr>
                    <td  style=" padding-top:20px;">ID</td>
                    <td style=" padding-top:20px;">用户ID</td>
                    <td style=" padding-top:20px;">用户登录名称</td>
                    <td style=" padding-top:20px;">建议内容</td>
                    <td style=" padding-top:20px;">状态</td>
                    <td style=" padding-top:20px;">提交时间</td>
                    <td style=" padding-top:20px;">更新时间</td>
                    <td style=" padding-top:20px;">操作</td>
                </tr>



                <tbody id="tobdy">
                    <? foreach((array)$list as $k=>$v) {?>
                    <tr>
                        <td style="width:150px;"><?=$v[id]?></td>
                        <td style="width:150px;"><?=$v[uid]?></td>
                        <td ><?=$v[username]?></td>
                        <td><? echo dstring::substring($v[content],0,24),'...' ?></td>
                        <td><? if ($v[state] == 0) { ?>已删除<? } elseif($v[state] == 1) { ?>未处理<? } else { ?>已处理<? } ?></td>
                        <td><? echo date('Y/m/d', $v[created]); ?></td>
                        <td><? if ($v[updated]) { ?><? echo date('Y/m/d', $v[updated]); ?><? } ?></td>
                        <td>
                            <span>
                                <a href="<?=$php_self?>advicef&id=<?=$v[id]?>" class="but_del">详情</a>
                            </span>
                        </td>
                    </tr>
                    <?}?>

                </tbody>

            </table>
        </div>
        <div>
            <div class="ep-pages">
                <?=$page_bar?>
            </div>
        </div>
    </div>
</div>
</body>
</html>
