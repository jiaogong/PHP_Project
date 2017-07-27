$(function() {

    //注册登录用户中心文本框聚焦
    $(".input_txt,#Reply,.brand_txt").each(function(){
        var thisVal=$(this).val();
        //判断文本框的值是否为空，有值的情况就隐藏提示语，没有值就显示
        if(thisVal!=""){
            $(this).siblings("label").hide();
        }else{
            $(this).siblings("label").show();
        }
        //聚焦型输入框验证
        $(this).focus(function(){
            $(this).siblings("label").hide();
        }).blur(function(){
            var val=$(this).val();
            if(val!=""){
                $(this).siblings("label").hide();
            }else{
                $(this).siblings("label").show();
            }
        });
    });

    //注册登录用户中心文本框聚焦
    $(".input_t").each(function(){
        var thisVal=$(this).val();
        //判断文本框的值是否为空，有值的情况就隐藏提示语，没有值就显示
        if(thisVal!=""){
            $(this).siblings("label").find("font").hide();
        }else{
            $(this).siblings("label").find("font").show();
        }
        //聚焦型输入框验证
        $(this).focus(function(){
            $(this).siblings("label").find("font").hide();
        }).blur(function(){
            var val=$(this).val();
            if(val!=""){
                $(this).siblings("label").find("font").hide();
            }else{
                $(this).siblings("label").find("font").show();
            }
        });
    });

    //点击登录按钮
    $('#login_btn').click(function() {
        G.cust.login('login_form', '/shop/login_success.html?redirect_url=' + referer_url);
    });


    //购物协议勾选
    $(".Agreement em").click(function(){
        if($(this).siblings("input[type='checkbox']").attr("checked")==undefined){
            $(this).css({backgroundPosition:'0 -280px'});
            $(this).siblings("input[type='checkbox']").attr("checked",true)
        }else{
            $(this).css({backgroundPosition:'0 0'});
            $(this).siblings("input[type='checkbox']").attr("checked",false)
        }
    });


    //注册时手机号输入框失去焦点后
    $('#regName').blur(function() {

        var regName = E.trim($(this).val());
        if (!E.isMobile(regName)) {
            $('#regName_error').text(G.cust.error.e1);
        } else {
            G.cust.check(regName);
        }

    }).focus(function() {
        $('#regName_error').text('');
    });

    //找回密码
    $('#mobile').blur(function() {

        var mobile = E.trim($(this).val());
        if (!E.isMobile(mobile)) {
            $('#mobile_error').text(G.cust.error.e1);
        } else {
            E.ajax_post({
                action: "customer",
                operFlg: 3,
                data: {
                    regName: mobile
                },
                call: function( o ) {
                    if (o.code == 200) {
                        G.cust.registerFlg = 0;
                        $('#mobile_error').html('手机号未注册  <a href="' + G.args.register + '">是否现在注册</a>');
                    } else {
                        G.cust.registerFlg = 1;
                        $('#mobile_error').text("");
                    }
                }
            });
        }

    }).focus(function() {
        $('#regName_error').text('');
    });

    //点击注册按钮
    $('#reg_btn').click(function() {
        G.cust.register('reg_form', '/shop/register_success.html?redirect_url=' + referer_url);
    });

    $('#loginPwd').keypress(function(event) {
        if (event.keyCode == 13) {
            $('#login_btn').trigger('click');
            $('#loginName').focus();
        }
    });

    $('.Agreement').find('a').click(function() {
        $.My_order($('#agreement_box').html());
    });

});

