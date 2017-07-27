if(typeof G == "undefined") {
    var G = {};
}

if(typeof G.cust == "undefined") {
    G.cust = {};
}


G.cust = {

    //会员信息
    cust_id: E.getCookie("WANSONSHOP_IDENTIFIER"),

    //参数数组
    args: {},

    //设置会员cookie
    set_cookie: function( cust_id ) {
        E.setCookie("WANSONSHOP_IDENTIFIER", cust_id, 0, G.args.cookie_domain);
        E.setCookie("REMEMBER_USERNAME", cust_id, 2592000, G.args.cookie_domain);
        this.cust_id = cust_id;
    },

    //显示欢迎项
    show_IDENTIFIER: function( id ) {
        var html = "";
        var rem_user = E.getCookie('REMEMBER_USERNAME');
        /*第三方登陆*/
        if (rem_user != null) {
            html += "<li class=\"fl\">欢迎您 <a href='"+ G.args.member_center +"' target='_blank'>" + rem_user + "</a></li>";
            html += "<li class=\"fl\">[ <a href=\"" + G.args.logout + "\">退出</a> ]</li>";
        }
        /*会员登陆*/
        else if (this.cust_id != null) {
            //会员名如果是手机号隐藏中间四位
            if(E.isMobile(this.cust_id)){
                var custName = this.cust_id;
                var custStr = custName.substr(3,4);
                this.cust_id = custName.replace(custStr,'****');
            }
            html += "<li class=\"fl\">欢迎您 <a href='"+ G.args.member_center +"' target='_blank'>" + this.cust_id + "</a></li>";
            html += "<li class=\"fl\">[ <a href=\"" + G.args.logout + "\">退出</a> ]</li>";
        }
        /*未登录*/
        else{
            html += "<li><a href=\"" + G.args.login + "\" class='Gold'>LOG IN 登录</a></li>";
            html += "<li><a href=\"" + G.args.register + "\" class='Gold'>SIGN UP 注册</a></li>";
        }

        $("#" + id).html(html);
    },

    error: {
        e1: "请输入手机号码",
        e2: "该手机号码已被使用",
        e3: "请输入密码",
        e4: "密码必须是6-30位字符，可使用字母、数字或符号",
        e5: "您两次输入的密码不一致",
        e6: "请输入正确的验证码",
        e7: "短信验证码不能为空",
        e8: "用户名错误",
        e9: "短信验证码必须是6位数字"
    },

    //客户登录
    login: function( id, href ) {

        var dt = E.getFormValues(id);

        $(".err").text("");

        if (E.isEmpty(dt.loginName)) {
            $("#loginName_error").text(G.cust.error.e8);
            return false;
        }

        if (E.isEmpty(dt.loginPwd)) {
            $("#loginPwd_error").text(G.cust.error.e3);
            return false;
        }

        E.loadding.open("正在登录，请稍候...");

        E.ajax_post({
            action: "customer",
            operFlg: 2,
            data: dt,
            call: function( o ) {
                if (o.code == 200) {
                    G.cust.set_cookie(o.data);
                    self.location = href;
                } else {
                    E.loadding.close();
                    if (o.code == 2) {
                        $("#loginPwd_error").text( o.message );
                    } else {
                        $("#loginName_error").text( o.message );
                    }

                }
            }
        });

    },

    registerFlg: 0,

    check: function( regName ) {

        E.ajax_post({
            action: "customer",
            operFlg: 3,
            data: {
                regName: regName
            },
            call: function( o ) {
                G.cust.registerFlg = 0;
                if (o.code == 200) {
                    G.cust.registerFlg = 1;
                    $("#regName_error").text("");
                } else if (o.code == 400) {
                    $("#regName_error").text(G.cust.error.e1);
                } else {
                    $("#regName_error").text(G.cust.error.e2);
                }
            }
        });

    },

    //用户注册
    register: function( id, href ) {

        if (this.registerFlg == 0) {
            return false;
        }

        var dt = E.getFormValues(id);

        $(".err").text("");

        if (!E.isMobile(dt.regName)) {
            $("#regName_error").text(G.cust.error.e1);
            return false;
        }

        if (E.isEmpty(dt.smsyzm)) {
            $("#smsyzm_error").text(G.cust.error.e7);
            return false;
        } else if (!E.isDigital(dt.smsyzm) || dt.smsyzm.length > 6 || dt.smsyzm.length < 6) {
            $("#smsyzm_error").text(G.cust.error.e9);
            return false;
        }

        if (!E.isPwd(dt.regPwd)) {
            $("#regPwd_error").text(G.cust.error.e4);
            return false;
        } else if (dt.regPwd != dt.regPwd2) {
            $("#regPwd2_error").text(G.cust.error.e5);
            return false;
        }

        if ($('input[name=agreement]').attr("checked") == undefined) {
            E.alert("请先同意 《M'cake购物协议》");
            return false;
        }

        E.loadding.open("正在注册，请稍候...");

        dt.custSource = 1;
        E.ajax_post({
            action: "customer",
            operFlg: 1,
            data: dt,
            call: function( o ) {
                if (o.code == 200) {
                    G.cust.set_cookie(o.data);
                    self.location = href;
                } else {
                    E.loadding.close();
                    E.alert(o.message);
                }
            }
        });

    },
    
    //找回密码
    getPwd: function( id, href ) {

        if (this.registerFlg == 0) {
            return false;
        }

        $(".err").text("");

        var dt = E.getFormValues(id);

        if (!E.isMobile(dt.mobile)) {
            $("#mobile_error").text(G.cust.error.e1);
            return false;
        }

        if (E.isEmpty(dt.smsyzm)) {
            $("#smsyzm_error").text(G.cust.error.e7);
            return false;
        } else if (!E.isDigital(dt.smsyzm) || dt.smsyzm.length > 6 || dt.smsyzm.length < 6) {
            $("#smsyzm_error").text(G.cust.error.e9);
            return false;
        }

        if (!E.isPwd(dt.new_pwd)) {
            $("#new_pwd_error").text(G.cust.error.e4);
            return false;
        } else if (dt.new_pwd != dt.re_new_pwd) {
            $("#re_new_pwd_error").text(G.cust.error.e5);
            return false;
        }

        E.loadding.open("正在找回密码，请稍候...");

        E.ajax_post({
            action: "customer",
            operFlg: 4,
            data: dt,
            call: function( o ) {
                if (o.code == 200) {
                    G.cust.set_cookie(o.data);
                    self.location = href;
                } else {
                    E.loadding.close();
                    E.alert(o.message);
                }
            }
        });

    },

    //设定密码
    setPwd: function( id ) {

        $(".setPwd_err").text("");

        var dt = E.getFormValues(id);

        if (!E.isMobile(dt.mobile)) {
            $(".setPwd_err").text(G.cust.error.e1);
            return false;
        }

        if (E.isEmpty(dt.smsyzm)) {
            $(".setPwd_err").text(G.cust.error.e7);
            return false;
        } else if (!E.isDigital(dt.smsyzm) || dt.smsyzm.length > 6 || dt.smsyzm.length < 6) {
            $(".setPwd_err").text(G.cust.error.e9);
            return false;
        }

        if (!E.isPwd(dt.new_pwd)) {
            $(".setPwd_err").text(G.cust.error.e4);
            return false;
        } else if (dt.new_pwd != dt.re_new_pwd) {
            $(".setPwd_err").text(G.cust.error.e5);
            return false;
        }

        E.loadding.open("正在设定密码，请稍候...");

        E.ajax_post({
            action: "customer",
            operFlg: 4,
            data: dt,
            call: function( o ) {
                E.loadding.close();
                if (o.code == 200) {
                    G.cust.set_cookie(o.data);
                    G.cust.show_IDENTIFIER('welcome');
                    checkout_args.login_status = 0;
                    $("#maximPanel").hide(300);
                    $("#maximPanel").remove();
                    $("#myCover").remove();
                } else {
                    E.alert(o.message);
                }
            }
        });

    },

    //会员未读消息数量
    noReadMessageCount:function( id ){

        if(this.cust_id == null){
            $("#" + id).parent().parent().hide();
            return false;
        }

        E.ajax_post({
            action: "message",
            operFlg: 3,
            data: { },
            call: function( o ) {
                if (o.code == 200) {
                    var no_read_count = o.data.no_read_count;
                    if(no_read_count > 0){
                        $("#" + id).parent().parent().show();
                        $("#" + id).text(no_read_count);
                    }else{
                        $("#" + id).parent().parent().hide();
                    }

                    var all_count = o.data.all_count
                    if(all_count > 0)
                        $(".userMyMsg").show();
                    else
                        $(".userMyMsg").hide();

                } else {
                    E.alert(o.message);
                }
            }
        });
    }

};


G.sms = {

    args: {

        number: 60, //发送短信限制时间（秒）

        mobile_id: "", //手机号码input标签ID

        btn_id: "" //发送短信按钮ID

    },

    send: function( args ) {

        if (args) {
            E.concat(this.args, args);
        }

        var mobile = E.trim($("#" + this.args.mobile_id).val());
        var yzm = E.trim($("#yzm").val());

        if (!E.isMobile(mobile)) {
            E.alert(G.cust.error.e1);
        } else if (yzm == '' || yzm.length != 4) {
            E.alert('请输入图片验证码', 1, function() {
                $("#yzm").focus();
            });
        } else {
            E.loadding.open("正在发送短信，请稍候...");
            E.ajax_get({
                url: "/ajax-comm/base/sms.ajax?operFlg=1",
                data: {
                    mobile: mobile,
                    yzm: yzm,
                    template: this.args.template
                },
                call: function( o ) {
                    E.loadding.close();
                    if (o.code == 200) {
                        G.sms.showTime();
                        E.alert(o.message, 2)
                    } else {
                        E.alert(o.message);
                    }
                    if (o.code != 1) {
                        $("#yzm").val("");
                        E.captcha('yzm_img');
                    }
                }
            });
        }

    },

    showTime: function() {

        if(this.args.number <= 0) {
            $("#" + this.args.btn_id).attr("onclick", "send_sms();").html("发送验证码 <small>>></small>");
            $("#smsyzm_error").text('');
            this.args.number = 60;
        } else {
            if (this.args.number == 60) {
                $("#" + this.args.btn_id).removeAttr("onclick").text("验证码己发送");
            }
            $("#smsyzm_error").text(this.args.number + "秒后可以重新发送");
            this.args.number--;
            setTimeout("G.sms.showTime();", 1000);
        }

    }

};


if(typeof G.cart == "undefined") {
    G.cart = {};
}

G.cart.comm = {

    show_flg: 0,

    get_amount: function( id ) {
        var cart_amount = E.getCookie("cart_amount");
        if (cart_amount == null) {
            cart_amount = 0;
        }
        $("#" + id).text(cart_amount);
    }

};

G.cart.general = {

    //添加商品
    add: function( postID, goods_amount ) {
        E.loadding.open("正在添加商品到购物车，请稍候...");
        E.ajax_post({
            action: "cart",
            operFlg: 2,
            data: {
                postID: postID,
                goods_amount: goods_amount
            },
            call: function( o ) {
                E.loadding.close();
                if (o.code == 200) {
                    //G.cps.emar(o.data, 'add_cart_goods');//调用亿码跟踪代码
                    G.cart.comm.get_amount("cart_amount");
                    self.location = G.args.cart
                } else {
                    E.alert(o.message);
                }
            }
        });
    }

};

G.cart.now_buy = function( postID, goods_amount ) {

    E.loadding.open('正在购买商品，请稍候...');
    E.ajax_post({
        action: 'cart',
        operFlg: 10,
        data: {
            postID: postID,
            goods_amount: goods_amount
        },
        call: function( o ) {
            E.loadding.close();
            if (o.code == 200) {
                self.location.href = G.args.nowbuy_login;
            } else {
                //G.cps.emar(o.data, 'add_cart_goods');//调用亿码跟踪代码
                E.alert(o.message);
            }
        }
    });

}

/**
 * 商品收藏
 * @type {{add: Function, result: Function}}
 */
G.collection = {

    add: function( postID ) {
    	if (G.cust.cust_id == null) {
    		G.cust.open({});
    	} else {
	        E.ajax_post({
	            action: "customer",
	            operFlg: 4,
	            data:{
	                postID : postID
	            },
	            call: "G.collection.result"
	        });
    	}
    },


    result: function( o ) {

        if (o.code == 200 ){
            E.alert(o.message, 2);
        } else {
            E.alert(o.message);
        }

    }

};

function choose_city() {

    var EBSIG_CITY_ID = E.getCookie('EBSIG_CITY_ID');
    if (EBSIG_CITY_ID) {
        $('#city-' + EBSIG_CITY_ID).addClass('cur');
    } else {

        var obj = $($('#city').find('li')[0]);
        EBSIG_CITY_ID = obj.attr('data-id');

        E.setCookie('EBSIG_CITY_ID', EBSIG_CITY_ID, 8640000, G.args.cookie_domain);
        obj.addClass('cur');
    }

    var deliver_reminder_info = {
        '110': '配送范围内实行环外费全免',
        '641': '杭州绕城高速以内免费配送',
        // add 20141126 sunqiang 38-FUN-BK-0037 苏州新城市 start
        '665':'苏州配送范围内免费配送',
        // add 20141126 sunqiang 38-FUN-BK-0037 苏州新城市 end
        '675':'北京配送范围内免费配送'
    };
    $('li.delivery').find('span').html('<a href="/shop/article-48.html#city_' + EBSIG_CITY_ID + '" target="_blank">'+ deliver_reminder_info[EBSIG_CITY_ID] +'</a>');

    $('.ebsig_all_goods, .blue_link').attr('href', G.args.domain + '/shop/' + EBSIG_CITY_ID + '/index.html#mainer');

}

choose_city();

$(window).ready(function() {

    $('#city').find('samp').click(function() {
        $('#city').find('li').addClass('cur');
    });

    $('#city').find('li').click(function() {

        var cart_amount = E.getCookie("cart_amount");
        var index = $(this).index();
        var city_id = $(this).attr('data-id');

        if (city_id == E.getCookie('EBSIG_CITY_ID')) {
            $('#city').find('li').removeClass('cur').eq(index).addClass('cur');
            return false;
        }

        if (cart_amount > 0) {

            E.confirm('切换城市您的购物车将被清空！', function() {

                E.loadding.open('正在清空购物车，请稍候...');
                E.ajax_get({
                    action: 'cart',
                    operFlg: 5,
                    call: function( o ) {

                        E.loadding.close();

                        if (o.code == 200) {
							E.setCookie('EBSIG_CITY_ID', city_id, 8640000, G.args.cookie_domain);
                            $('#city').find('li').removeClass('cur').eq(index).addClass('cur');
                            self.location = G.args.domain + '/shop/' + city_id + '/index.html';
                        }

                    }
                });

            });

        } else {

			E.setCookie('EBSIG_CITY_ID', city_id, 8640000, G.args.cookie_domain);
            $('#city').find('li').removeClass('cur').eq(index).addClass('cur');
            self.location = G.args.domain + '/shop/' + city_id + '/index.html';

        }

    });
	
});