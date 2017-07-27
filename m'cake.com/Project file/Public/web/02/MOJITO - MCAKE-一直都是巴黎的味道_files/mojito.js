
window.onload=function(){
    $(window).bind("scroll",scrollFun);
    //console.log($.NV('version')+"版本")
//  if ($.NV('name')=="ie"||$.NV('name')=="unkonw") {   //判断是不是ie浏览器
    //alert("ie")
//	}
    if (($.NV('name')=="ie" && $.NV('version')=="8.0") || ($.NV('name')=="ie" && $.NV('version')=="7.0") || ($.NV('name')=="unkonw" && $.NV('version')=="7.0") || ($.NV('name')=="unkonw" && $.NV('version')=="7.0")) {   //判断是不是ie浏览器
        //alert("不支持");
        //$(".video").html("<img src='images/video.png' />");
    }

}



var state=false;
function scrollFun(){
    var Height = $(".video").offset().top;
    var scrollTop = $(window).scrollTop();
    if(scrollTop>=Height){
        state=true;
        if(state==true){
            $(".face_png,.texi_png").hide(); $(".face_gif,.texi_gif").show();
            imgShow($(".face_gif"));
            $(window).unbind("scroll",scrollFun);
            $(window).bind("scroll",scrollFun2);
        }
    }
}


var state2=false;
function scrollFun2(){
    var Height = $(".select").offset().top;
    var scrollTop = $(window).scrollTop();
    if(scrollTop>=Height){
        state2=true;
        if(state2==true){
            $(".dagu_png").hide(); $(".dagu_gif").show();
            $(window).unbind("scroll");
        }
    }
}




function imgShow(ele){
    var i=-1;
    var len=ele.children("img").length;
    function imgAnimate(){   //设置动画
        i++;
        if(i<len){
            setTimeout(function(){
                ele.children("img").eq(i).show().siblings().hide();
                imgAnimate(); //内部回调

            },200);  //间隔时间
        }
    }
    imgAnimate();  //执行一次动画,否则其他动画不隐藏
}

$(function(){

    objAlert = function (msg) {
        try {
            $("div[class='tc-con']").remove();
            $("div[class='tc-cover']").remove();
            $cover = $("<div class='tc-cover' id='myCover' >&nbsp;</div>");
            $main = $("<div class=\"tc-con\" id='maximPanel'></div>");
            $close = $("<a href='javascript:void(0);'class='close close_2'>关闭</a>");
            $content = $("<div  class='tc-con-1'></div>");
            $content.html(msg);
            $main.append($close);
            $main.append($content);
            $(document.body).append($cover);
            $(document.body).append($main);
            $main.show(400);
            $main.focus();
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
                    if(E.isMobile($(this).val())){
                        login.check();//检测
                    }
                });
            })
            $(".tc-con-order").css({"margin-left":-($(".tc-con-order").innerWidth()/2),"margin-top":-($(".tc-con-order").innerHeight()/2)});
            $cover.height($("html").height());
            $close.click(function () {
                $main.hide(500);
                $main.remove();
                $cover.remove();
            });
        }
        catch (ex) { alert(ex); }
    }

    $(".poundsbtn").click(function(){
        $(".pounds").toggle();
        $(".number").hide();
        return false;
    });

    $(".numberbtn").click(function(){
        $(".number").toggle();
        $(".pounds").hide();
        return false;
    });

    $("body").click(function(){
        $(".pounds").hide();
        $(".number").hide();
    });

    $(".button2").click(function(){
        $(this).toggleClass("on");
    });

    /*
     *磅数
     */
    $(".pounds li").click(function () {
        $(".poundsbtn i").text($(this).text());
        var price = currten[$(this).text()].price;
        $(".price i").text(price);
        $(".pounds").hide();
        return false;
    });

    /*
     *数量
     */
    $(".number li").click(function(){
        $(".numberbtn i").text($(this).text());
        $(".number").hide();
        return false;
    });

    /*
     *商品详情
     */
    $('.sec3_right').click(function () {
        window.open("/shop/goods-" + currten[2].id + ".html");
    });

    /*
     *结算
     */
    $(".gobuy").click(function () {
        nowBuy();
    });

});

//显示登陆框
function showLogin(){
    var html = '<form id="login_form" name="login_form"><ul class="Remote_payment quick_login">';
    html += '<li class="quick_txt" style="text-align: left;">快速登录</li>';
    html += '<li class="import" style="height: 50px">';
    html += '<label for="loginName">手机号码</label>';
    html += '<input type="text" class="input_txt user_icon" name="loginName" id="loginName" value="" maxlength="11"/>';
    html += '</li>';
    html += '<li class="import" id="pwd_box" style="height: 50px">';
    html += '<label for="loginPwd" id="labloginPwd">请输入密码</label>';
    html += '<input type="password" class="input_txt password_icon" name="loginPwd" id="loginPwd" value="" maxlength="30"/>';
    html += '</li>';
    html += '<li>';
    html += '<p class="warn err" id="error_msg" style="display: none;"></p>';
    html += '</li>';
    html += '<li class="coupon_btn">';
    html += '<input type="button" value="马上登录" onclick="login.quickLogin()" class="login_btn"/>';
    html += '</li>';
    html += '<li class="link_c"><a href="/shop/register.html" class="Grey">立即注册</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="/shop/getPwd.html" class="Grey">忘记密码 ?</a></li>';
    html += '</ul></form>';
    objAlert(html);
    $('#loginPwd').hide();
    $('#labloginPwd').hide();
    $("#myCover").css('height','3365px');
}

//立即购买
function nowBuy() {

    if (G.args.login_status == 1) {

        if(!currten[$('.poundsbtn i').text()]){
            E.alert("当前城市没有该商品！");
            return false;
        }

        var goods_id = currten[$('.poundsbtn i').text()].id;

        if (goods_id == '') {
            E.alert("请选择磅数！");
            return false;
        }

        var ids = [];
        ids.push(goods_id);

        var num = $(".numberbtn i").text();

        if (num == '') {
            E.alert("请选择数量！");
            return false;
        }

        var nums = [];
        nums.push(num);

        E.loadding.open("正在提交订单，请稍候...");
        E.ajax_post({
            action: "cart",
            operFlg: 13,
            data: {
                ids: ids,
                nums: nums,
                act: 'MOJITO'
            },
            call: function (o) {
                E.loadding.close();
                if (o.code == 200) {
                    self.location.href = "/shop/checkout.html?act=MOJITO";
                } else {
                    E.alert(o.message);
                }
            }
        });
    } else {
        showLogin();
    }
}

//登陆操作
var login = {
    quickLogin: function () {
        var dt = E.getFormValues('login_form');
        $(".err").text("");
        if (E.isEmpty(dt.loginName)) {
            $("#error_msg").text(G.cust.error.e8);
            return false;
        }
        if (E.isEmpty(dt.loginPwd) && G.cust.registerFlg == 0) {
            $("#error_msg").text(G.cust.error.e3);
            return false;
        }
        E.loadding.open("正在登录，请稍候...");
        E.ajax_post({
            action: "customer",
            operFlg: 7,
            data: dt,
            call: function (o) {
                E.loadding.close();
                if (o.code == 200) {
                    G.cust.set_cookie(o.data.id);
                    G.args.login_status = 1;
                    $("div[class='tc-con']").remove();
                    $("div[class='tc-cover']").remove();
                    nowBuy();
                } else {
                    if (o.code == 2) {
                        $("#error_msg").text(o.message).show();
                    } else {
                        $("#error_msg").text(o.message).show();
                    }
                }
            }
        });
    },
    check: function () {
        var dt = E.getFormValues('login_form');
        var regName = dt.loginName;
        E.ajax_post({
            action: "customer",
            operFlg: 3,
            data: {
                regName: regName
            },
            call: function (o) {
                G.cust.registerFlg = 0;
                if (o.code == 200) {
                    //新用户
                    G.cust.registerFlg = 1;
                    $(".err").text("");
                    $("#loginPwd").hide();
                    $("#labloginPwd").hide();
                } else if (o.code == 404) {
                    //老用户
                    $(".err").text("");
                    $("#loginPwd").show();
                    $("#labloginPwd").show();
                } else {
                    //缺少参数
                    $("#error_msg").text(o.message);
                    return false;
                }
            }
        });
    }
}