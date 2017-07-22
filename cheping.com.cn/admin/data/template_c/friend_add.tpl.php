<? if(!defined('SITE_ROOT')) exit('Access Denied');?>
<? include $this->gettpl('header');?>
<div class="user-add">
    <div class="navs" >
        <ul class="nav">
            <li  ><a href="?action=friend-add" class="song">添加友链</a></li>   
        </ul>
    </div>
    <div class="clear"></div>
    <div class="user-add-con">
        <div style=" padding:0 10px;">
            <form name="add_friend" method="post" action=""onsubmit="return checkUrl()" >
                <table border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td class="right" >链接名称:</td>
                        <td class="margin46">
                            <input type="text" name="title" id="title" size="20" value="<?=$list['title']?>" >
                            <span id="msg_username" style="color: #FF0000"></span>       
                        </td>
                    </tr>
                    <tr>
                        <td class="right" >链接地址:</td>
                        <td class="margin46">
                            <input type="text" name="url" id="url" size="20" value="<?=$list['url']?>" >
                            <span id="msg_username" style="color: #FF0000"></span>       
                        </td>
                    </tr>
                    <tr>
                        <td class="right" >频道：</td>
                        <td class="margin46">
                            <select name="category_id">
                                <option value='0' <? if ($list['category_id']==0) { ?>selected<? } ?>>首页</option>
                                <? foreach((array)$category as $key=>$v) {?>
                                <option value='<?=$v[id]?>' <? if ($v[id] == $list['category_id']) { ?>selected<? } ?>><?=$v[category_name]?></option>
                                <?}?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="right" >排序序号:</td>
                        <td class="margin46">
                            <input type="text" name="seq" id="seq" size="20" value="<?=$list['seq']?>" >
                            <span id="msg_username" style="color: #FF0000"></span>       
                        </td>
                    </tr>
                    <tr>
                        <td class="right" >链接类型：</td>
                        <td class="margin46">
                            <select name="url_type">
                                <option value='1' <? if ($list['url_type']==1) { ?>selected<? } ?>>友情链接</option>
                                <option value='2' <? if ($list['url_type']==2) { ?>selected<? } ?>>合作媒体</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="right" >nofollow:</td>
                        <td class="margin46">
                            <select name="nofollow">
                                <option value='0' <? if ($list['nofollow']==0) { ?>selected<? } ?>>否</option>
                                <option value='1' <? if ($list['nofollow']==1) { ?>selected<? } ?>>是</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="right" >备注：</td>
                        <td class="margin46">
                            <input type="text" name="memo" size="20" value="<?=$list['memo']?>">
                        </td>
                    </tr>
                    <tr>
                        <td class="right" >联系人：</td>
                        <td class="margin46">
                            <input type="text" name="linkman" id="linkman" size="20" value="<?=$list['linkman']?>">
                        </td>
                    </tr>
                    <tr>
                        <td class="right" >链接描述 : </td>
                        <td class="margin46">
                            <input type="text" name="linkmemo" id="realname" size="20" value="<?=$list['linkmemo']?>">
                        </td>
                    </tr>
                    <tr style="border:none;">
                        <input type="hidden" name="id" value="<?=$list['id']?>">
                        <td class="link_right" style=" border:none;width:36%"><div style="margin-left:90%;width:300px;"><button style=" margin-left:5%;"  type=" submit" id="btn_submit1">确定</button>&nbsp;&nbsp;&nbsp;&nbsp;<button type="reset" id="btn_submit2">取消</button>&nbsp;&nbsp;&nbsp;&nbsp; <button  onclick="javascript:window.location.href='<?=$php_self?>friends'" type="reset" id="btn_submit3">返回</button></div></td>
                </tr>
                </table> 
            </form>
        </div>  
    </div>
</div>
</body>
<script type="text/javascript">
function checkUrl() {
		var url = document.getElementById('url').value;
		if (url==''){
			alert('URL 地址不能为空');
                        return false;
		} else {
			var RegUrl = new RegExp();
			RegUrl.compile("[A-Za-z]+://");//jihua.cnblogs.com
			if (!RegUrl.test(url)) {
				alert('地址不正确');
				return false;
			}
		}
            return  true;
	}
</script>
</html>
