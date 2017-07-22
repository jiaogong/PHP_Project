<? if(!defined('SITE_ROOT')) exit('Access Denied');?>
<? include $this->gettpl('header');?> 
        <div class="user-add">
            <div class="nav">
                <ul>
                    <li><a class="song" href="?action=user-changepassword">用户密码修改</a></li>
                </ul>
            </div>
            <div class="clear"></div>
            <div class="user-add-con">
                <div style=" padding:0 10px;">
                    <form name="user_pass" method='post' action="?action=user-updatepassword" onsubmit="javascript: return check_submit();" >
                        <table border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td class="right" >用&nbsp;户&nbsp;名：</td>
                                <td class="margin46">
                                    <input type=text size=20 name='username' id='username' value="<?=$username?>" readonly>
                                    <span id="msg_username" style="color: #FF0000"></span>
                                </td>
                            </tr>
                            <tr>
                                <td class="right" >旧&nbsp;密&nbsp;码：</td>
                                <td class="margin46">
                                    <input type=password maxlength=20 name='oldpass' id='oldpass'>
                                    <span id="msg_oldpass" style="color: #FF0000"></span>
                                </td>
                            </tr>
                            <tr>
                                <td class="right" >新&nbsp;密&nbsp;码：</td>
                                <td class="margin46">
                                    <input type=password maxlength=20 name='newpass1' id='newpass1' onblur="javascript:passwordStrong(this)">
                                    <span id="msg_newpass1" style="color: #FF0000"></span>
                                </td>
                            </tr>
                            <tr>
                                <td class="right" >确认新密码：</td>
                                <td class="margin46">
                                    <input type=password size=20 name='newpass2' id='newpass2'>
                                    <span id="msg_newpass2" style="color: #FF0000"></span>
                                </td>
                            </tr>
                            <tr>
                                <td  colspan="2" align="center" >
                                    <button type=" submit" class="button" id="btn_submit">确定</button>&nbsp;&nbsp;<button type=" reset" class="button">取消</button>
                                </td>
                            </tr>
                        </table> 
                    </form>
                </div>  
            </div>
        </div>  
    <script>
        var ret = 0;
        function check_submit()
        {
            if ($('#oldpass').val() == "") {
                $('#msg_oldpass').html('旧密码不能为空！');
                return false;
            }
            if ($('#newpass1').val() == "") {
                $('#msg_newpass1').html('新密码不能为空！');
                return false;
            }
            if (!/(?=\S*?[a-zA-Z])(?=\S*?[0-9])\S{6,}/im.test($('#newpass1').val())) {
                $('#msg_newpass1').html('密码太弱，要求大小写英文+数字组成，长度至少6位！');
                $('#newpass1').focus();
                return false;
            }
            if ($('#newpass2').val() == "") {
                $('#msg_newpass2').html('确认密码不能为空！');
                return false;
            }
            if ($('#newpass1').val() != $('#newpass2').val()) {
                $('#msg_newpass2').html('两次密码输入不一致！');
                return false;
            }
        }
        
        function passwordStrong(obj){
            $.getJSON('<?=$php_self?>passwordstrong',{password:obj.value}, function(r){
                if(r['password']==''){
                    $('#msg_newpass1').html('密码太弱，要求大小写英文+数字组成，长度至少6位！');
                    return false;
                }else{
                    $('#msg_newpass1').html('');
                }
            });
        }
        //document.body.className = "upload";
    </script>
    </body>
</html>
