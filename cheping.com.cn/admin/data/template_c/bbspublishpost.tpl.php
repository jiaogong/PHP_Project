<? if(!defined('SITE_ROOT')) exit('Access Denied');?>
<? include $this->gettpl('header');?> 
        <div class="user">
            <div class="nav">
                <ul>
                    <? if ($pid) { ?><li><a href="<?=$php_self?>postslist">返回</a></li><? } ?>
                    <li><a href="<?=$php_self?>PublishPost<? if ($pid) { ?>&pid=<?=$pid?>&event=edit<? } ?>" class="song"><? if ($pid) { ?>编辑<? } else { ?>发布<? } ?>帖子</a></li>
                </ul>
            </div>
            <div class="clear"></div>
            <div class="user-con">
                <div class="user-table">
                    <form action="" method="post" enctype="multipart/form-data">
                        <table border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td class="td_right"  width="200px;" >
                                    <span>标题 ：</span>
                                </td>
                                <td  class="td_left">
                                    <? if ($list['pid']) { ?><input type="hidden" name="pid" value="<?=$list['pid']?>" /><? } ?>
                                    <input type="text" style="border:1px solid #cdcdcd;  background:none;" name="subject" id="subject" size="50" value="<?=$list['subject']?>" />
                                </td>
                            </tr>
                            <tr>
                                <td class="td_right">所属论坛版块 ：</td>
                                <td class="td_left">
                                    <select name="fid" id="fid">
                                        <? if ($forum_name) { ?>
                                        <option  value="">-选择论坛版块-</option>
                                        <? foreach((array)$forum_name as $key=>$val) {?>
                                        <option <? if ($list['fid']==$val['fid']) { ?>selected="selected"<? } ?> value="<?=$val['fid']?>"><?=$val['name']?></option>
                                        <?}?>
                                        <? } ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="td_right" width="150px;" >所属版块下的主题 ：</td>
                                <td class="td_left">
                                    <select name="tid" id="tid" >
                                        <? if ($theme_data) { ?>
                                        <? foreach((array)$theme_data as $key=>$val) {?>
                                        <option <? if ($list['tid']==$val['tid']) { ?>selected="selected"<? } ?> value="<?=$val['tid']?>"><?=$val['name']?></option>
                                        <?}?>
                                        <? } else { ?>
                                        <option  value="">暂无主题</option>
                                        <? } ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="td_right" width="150px;" >帖子内容 ：</td>
                                <td class="td_left">
                                    <textarea   class="text2" name="ke_text" id="ke_text"><?=$list['message']?></textarea>
                                    <!--p>
                                    您当前输入了 <span class="word_count1">0</span> 个文字。（字数统计包含HTML代码。）<br />
                                    您当前输入了 <span class="word_count2">0</span> 个文字。（字数统计包含纯文本、IMG、EMBED，不包含换行符，IMG和EMBED算一个文字。）
                                    </p-->
                                </td>
                            </tr>
                            <tr>
                                <td class="td_right">是否帖子置顶 ：</td>
                                <td class="td_left">
                                    <select name="toppost" id="toppost" >
                                        <option <? if ($list['toppost']==0 || !$list['toppost']) { ?>selected="selected"<? } ?> value="0">不置顶</option>
                                        <option <? if ($list['toppost']==1 ) { ?>selected="selected"<? } ?> value="1">置顶</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="td_right">是否精华 ：</td>
                                <td class="td_left">
                                    <select name="digest" id="digest" >
                                        <option <? if ($list['digest']==0 || !$list['digest']) { ?>selected="selected"<? } ?> value="0">否</option>
                                        <option <? if ($list['digest']==1 ) { ?>selected="selected"<? } ?> value="1">是</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="td_right">是否以官方发帖 ：</td>
                                <td class="td_left">
                                    <select name="authority" id="authority" >
                                        <option <? if ($list['authority']==0 || !$list['authority']) { ?>selected="selected"<? } ?> value="0">否</option>
                                        <option <? if ($list['authority']==1 ) { ?>selected="selected"<? } ?> value="1">是</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="td_right">状态 ：</td>
                                <td class="td_left">
                                    <select name="status" id="status" >
                                        <option <? if ($list['status']==0 || !$list['status']) { ?>selected="selected"<? } ?> value="0">正常</option>
                                        <option <? if ($list['status']==1 ) { ?>selected="selected"<? } ?> value="1">关闭评论</option>
                                        <? if ($list['status']) { ?><option <? if ($list['status']==2 ) { ?>selected="selected"<? } ?> value="2">关闭帖子</option><? } ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="td_right">
                                    <button class="tijiao" id="btn" name="btn">提 交</button>
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>
        </div>
<script charset="utf-8" src="<?=$relative_dir?>vendor/editor/kindeditor.js"></script>
<script type="text/javascript">
    $(function() {
        $('#fid').change(function () {
            var fid = $(this).children('option:selected').val();
            if(fid) {
                $.post("<?=$php_self?>ajaxFidTOTheme", {fid: fid}, function (res) {
                    if (res) {
                        $('#tid').html(res);
                    } else {
                        alert('主题获取失败！\n');
                    }
                });
            }else{
                $('#tid').html('');
            }
        });
        //提交
        $('#btn').click(function () {
            var arr = new Array("subject","fid","ke_text");
            var arrname = new Array('标题','所属论坛版块','内容');
            var str ='';

            $.each(arr,function(i,n){
                var  content = $('#'+n).val();
                var str_name = arrname[i];
                if(!content) {
                    str += str_name +'\n'
                }
            });

            if(str){
                str +='这些都是必填项！！';
                alert(str);
                return false;
            }else{
                $('#article_form').submit();
            }
        });
    });
    //编辑器
    $(function(){
        editor = KindEditor.create('#ke_text',{
            width : "580px",
            height: "400px",
            filterMode:false,//是否开启过滤模式;
            uploadJson : '<?=$php_self?>ajaxPostPic&ret=json&sfid=imgFile',
            fileManagerJson: '<?=$admin_path?>ajaxPostPic&ret=json&sfid=imgFile',
            allowFileManager: true,
            urlType : 'domain',
            allowImageUpload: true,
            allowMediaUpload: false,
            allowFlashUpload: false,
            cssData: 'body {font-family: "微软雅黑"; font-size: 16px}',
            items : [   //文章编辑功能, 快速格式化: 'quickformat'
                'source', '|','undo', 'redo','cut', 'copy', 'paste', '|','fontname', 'fontsize', '|',
                'forecolor', 'hilitecolor', 'bold',  'underline','removeformat', '|', 'justifyleft',
                'justifycenter', 'justifyright', 'hr','|','image','media','table', 'indent', 'outdent', 'link','forecolor', 'unlink','-','preview','clearhtml','fullscreen'],
            afterBlur: function(){this.sync();},
            afterChange:function(){
                $('.word_count1').html(this.count());
                $('.word_count2').html(this.count('text'));
                show_pic();
            }
        });
        show_pic();
    });
    //图片
    function show_pic() {
        var arr = $(".tishi_pic");
        kehtml  = editor.html();
        if(arr){
            $.each(arr,function(i,n){
                var src =  $(this).attr("src").replace("<?=$main_site?>/attach/","/");
                var cl =  $(this).attr("class").split(" ")[1];
                if(kehtml.indexOf(src)>0){
                    $("#"+cl).css("display","block")
                }
            })
        }
    }
</script>
</body>
</html>
