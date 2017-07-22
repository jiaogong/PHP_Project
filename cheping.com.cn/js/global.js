// JavaScript Document
$(document).ready(function () {
    
    //页面图片延迟加载
    if($("img.lazyimg")[0]){
        $("img.lazyimg").lazyload();
    }
    if($("img.lazyimgs")[0]){
        $("img.lazyimgs").lazyload({
             threshold : 200
        });
    }
    /*右侧浮动begin*/
    if (!/(applewebkit|uc)[\s\S]*?mobile/i.test(window.navigator.userAgent)) {
        $('div.right_bl').show();
        $('.tan_kuangx').click(function () {
            $("#popMask").show();
            $(".open_windowx").show();
        });
        $(".bianlan_img").click(function () {
            $(".open_windowx").hide();
            $("#popMask").hide();
        });
        $('input#submit_advice').click(function () {
            var message = $('#message').val();
            var email = $('#email').val();
            if ($.trim(message) == '') {
                $('#message').focus();
                alert('您还没有填写意见反馈的信息！');
                return false;
            }
            if ($.trim(email) == '') {
                $('#email').focus();
                alert('您还没有填写电子邮箱地址！');
                return false;
            } else
            if (!chkEmail(email)) {
                $('#email').focus();
                alert('您填写的电子邮箱地址不正确！');
                return false;
            }
            $.post('ajax.php?action=advice', {message: message, email: email},
            function (ret) {
                if ($.trim(ret) == 1) {
                    alert('提交成功！');
                    $(".open_windowx").hide();
                    $("#popMask").hide();
                    $('#email').val('');
                    $('#message').val('');
                } else {
                    alert('提交失败！');
                }
            }
            );
        });

        $(".bl_shuang11").click(function () {
            $(".bl_weixin_ul").toggle();
        })
        $(".bl_close").click(function () {
            $(".bl_weixin_ul").css("display", "none")
        })
        $('.b1_fhdb > a').click(function () {
            scroll(0, 0);
        });
    }
    /*获取快速注册验证码*/
    $('.wytj_img a').click(function () {
        var phone = $('#phone').val();
        $.get('/register.php?action=sendregcode', {phone: phone}, function (ret) {
            if (ret == 2) {
                alert('发送成功！');
                var i = 60;
                var ints = setInterval(function () {
                    $(".wytj_img2").html(--i + '秒');
                    if (i == 0) {
                        clearInterval(ints);
                        $(".wytj_img2").hide();
                        $(".wytj_img").show();
                    }
                }, 1000);
                $(".wytj_img").hide();
                $(".wytj_img2").show();
            }
            else if (ret == -1)
                alert('该手机号已经注册过，请换个号码试试！');
            else if (ret == 4)
                alert('已经发送5次,请24小时之后再试！');
            else
                alert('发送失败！');
        });
    });
    
    //搜索时至少选择一个车款
    $('#form_serach').submit(function () {
        if ($('#brand_id').val() == '0') {
            alert('至少选择一个车款！');
            return false;
        } else {
            if ($('#model_id').val() != '0') {
                var model_id = $('#model_id').val();
                var url = "modelinfo_" + model_id + ".html";
                window.open(url);
                return false;
            }
        }
    });
    $("input[name='pwd']").bind('keydown', function (event) {
        if (event.keyCode == "13") {
            loginHeader();
        }
    })
    //搜索绑定回车事件
    $('#input_test').bind('keyup', function (event) {
        if (event.keyCode == "13") {
            //需要进行的处理程序
            var series_name = $("#input_test").val();
            if (series_name == "请输入车系名称 如：君威、奥迪A6" || series_name == undefined) {
                return false;
            } else {
                $.ajax({
                    type: "post",
                    url: "search.php?action=checkname",
                    data: "keyword=" + series_name,
                    success: function (msg) {
                        if (msg == -4) {
                            $("#popMask").show();
                            $(".ss_tks").show();
                        } else {
                            location.href = msg;
                        }
                    }
                });
            }
        }
    });
    $("#unameid").focus(function () {
        var uname = $("#unameid").val();
        if (uname == '用户名/手机号') {
            $("#unameid").val('');
        }
    });
    $("#unameid").blur(function () {
        var uname = $("#unameid").val();
        if (uname == '用户名/手机号' || uname == '') {
            $("#unameid").val('用户名/手机号');
        }
    });
    $(".but_sosu").click(function () {
        var series_name = $("#input_test").val();
        if (series_name == "请输入车系名称 如：君威、奥迪A6" || series_name == undefined) {
            return false;
        } else {
            $.ajax({
                type: "post",
                url: "search.php?action=checkname",
                data: "keyword=" + series_name,
                success: function (msg) {
                    if (msg == -4) {
                        $("#popMask").show();
                        $(".ss_tks").show();
                    } else {
                        location.href = msg;
                    }
                }
            });
        }

    })
    $('#fanhui').click(function () {
        $("#popMask").hide();
        $(".ss_tks").hide();
    })
    var li = $("#mainNav > li"); //找到#mainNav中子元素li；
    var ul;
    li.each(function (i) { //循环每一个LI
        li.eq(i).hover(
                function () {
                    $(this).find("ul").show(); //找到li里面的ul元素设置为显示
                },
                function () {
                    $(this).find("ul").hide();
                }
        )
    })
    $(".head_nav_r").hover(function () {
        $thisPar = $(this)
        $thisPar.children(".popPro").show()
    }, function () {
        $thisPar = $(this)
        $thisPar.children(".popPro").hide();
    })
    //处理头部登录
//    $.get('/login.php?action=checkhead', function(msg) {
//        if (msg == '00') {
//            $("#header_login").css('display', 'block');
//            $("#header_login_back").css('display', 'none');
//            $("#header_login_back > span").first().html('');
//        } else {
//            $("#header_login").css('display', 'none');
//            $("#header_login_back").css('display', 'block');
//            $("#header_login_back > span").first().html(msg);
//        }
//    });
    $.ajax({
        async: false,
        type: "get",
        url: "/login.php?action=checklogin",
        data: "",
        success: function (msg) {
            var obj = eval('(' + msg + ')');
            if (obj.msg == "ok") {
                $("#header_content").show();
                $("#header_login").hide();
                $("#header_username").html("欢迎" + obj.user);
                $("#user_id").val(obj.userid);
            } else {
                $("#header_content").hide();
                $("#header_login").show();

            }
        }
    })
    //页面模块切换
    $(".i-tabs").each(function () {
        var item = $(this);
        item.children('.i-tabs-nav').children(".i-tabs-item").each(function (i, v) {
            $(this).hover(function () {
                if ($(this).hasClass("i-tabs-item-active")) {
                    return;
                } else {
                    item.find(".i-tabs-item-active").removeClass("i-tabs-item-active");
                    $(this).addClass("i-tabs-item-active");
                    item.find('.i-tabs-content-active').removeClass('i-tabs-content-active')
                    item.children('.i-tabs-container').children('.i-tabs-content').eq($(this).index()).addClass('i-tabs-content-active');
                }
            })
        })
    })
    //头部搜索框特效
    var inputEl = $('#input_test'), defVal = inputEl.val();
    inputEl.bind({
        focus: function () {
            var _this = $(this);
            if (_this.val() == defVal) {
                _this.val('');
            }
        },
        blur: function () {
            var _this = $(this);
            if (_this.val() == '') {
                _this.val(defVal);
            }
        }
    });
    //攻城夺金
    $('#index_tan_chuang').click(function () {
        $.getJSON('invoice.php?action=getIsok', function (res) {
            if (typeof res == "object") {
                if (res[0] == 22) {
                    window.location.href = 'login.php';
                } else if (res[0] == 11) {
                    window.location.href = 'invoice.php';
                }
            } else {
                popCenter("index_tj_cg2");
                $("#popMask").show();
                $("#tj_cg2").show();
            }
        });
    })

    $(".open_window  .closebox1 > img").click(function () {
        $("#tj_cg2").hide();
        $("#popMask").hide();
    })
    $(".close_tjs_cg2").click(function () {
        $("#tj_cg2").hide();
        $("#popMask").hide();
    })
})
function show_uploadimg() {
    $.getJSON('invoice.php?action=checklogin', function (res) {
        if (typeof res == 'object') {
            if (res[0] == 11) {
                window.location.href = 'invoice.php';
            } else if (res[0] == 22) {
                window.location.href = 'login.php';
            }
        }
    })
}

/*定时执行程序*/
function sleep(numberMillis) {
    var now = new Date();
    var exitTime = now.getTime() + numberMillis;
    while (true) {
        now = new Date();
        if (now.getTime() > exitTime)
            return;
    }
}
//跳转到QQ登录页面
function toQzoneLogin() {
    var A = window.open("vendor/qq_sdk/oauth/qq_login.php", "TencentLogin", "width=450,height=320,menubar=0,scrollbars=1, resizable=1,status=1,titlebar=0,toolbar=0,location=1");
}
function logout(id) {
    $.get("/login.php?action=Logout&id=" + id, {}, function (msg) {
//        alert(msg);
        var obj = eval('(' + msg + ')');
        if (msg == 1) {
            $("#header_content").hide();
            $("#header_login").show();
            $("#collect_state").addClass("left1").removeClass("left1_dl");
        } else {
            $("#header_content").hide();
            $("#header_login").show();
            $("#collect_state").addClass("left1").removeClass("left1_dl");
            window.location.href = obj;
        }
    })
}
//检查邮箱格式
function chkEmail(strEmail) {
    if (strEmail.search(/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/) != -1)
        return true;
    else
        return false;
}
function brand_select(obj, bid) {
    var bid = arguments[1] ? arguments[1] : 0;
    $.each(brand_js, function (i, v) {
        if (bid != 0 && v['brand_id'] == bid)
            document.write("<option selected=\"selected\" value='" + v['brand_id'] + "'>" + v['letter'] + ' ' + v['brand_name'] + "</option>\n");
        else
            document.write("<option value='" + v['brand_id'] + "'>" + v['letter'] + ' ' + v['brand_name'] + "</option>\n");
    });
}
function series_select(obj, brand_id, sid) {
    var sid = arguments[2] ? arguments[2] : 0;
    var defSeries = '<option value=0>车系</option>\n';
    var dftModel = '<option value=0>车款</option>\n';
    if (obj.attr("id") == "brbox1") {
        $("#model_id").empty().append(dftModel).attr({
            disabled: true
        });
    } else if (obj.attr("id") == "brbox2") {
        $("#model_id2").empty().append(dftModel).attr({
            disabled: true
        });
    } else if (obj.attr("id") == "brbox3") {
        $("#model_id3").empty().append(dftModel).attr({
            disabled: true
        });
    }
    if ($.isPlainObject(series_js) && brand_id > 0) {
        obj.empty();
        js = defSeries;
        $.each(series_js[brand_id], function (i, v) {
            if (sid != 0 && sid == v['series_id'])
                js += "<option selected=\"selected\" value='" + v['series_id'] + "'>" + v['series_name'] + "</option>\n";
            else
                js += "<option value='" + v['series_id'] + "'>" + v['series_name'] + "</option>\n";
        });
        obj.append(js);
        obj.attr({
            disabled: false
        });
    } else {
        obj.empty().append(defSeries).attr({
            disabled: true
        });
    }
}
function model_selected(obj, series_id, model_id) {
    if (series_id > 0) {
        $.ajax({
            type: "POST",
            url: "../ajax.php?action=models",
            data: {
                series_id: series_id
            },
            error: function () {
                alert("网络异常，请求失败！！");
            },
            success: function (data) {
                if (data == -4) {
                    alert("系统错误，请联系管理员!!");
                    return false;
                } else {
                    var models = eval("(" + data + ")");
                    if (models) {
                        obj.empty();
                        var js;
                        $.each(models, function (i, n) {
                            js += '<option';
                            if (model_id == n.model_id)
                                js += ' selected="selected"';
                            js += " value='" + n.model_id + "' title='" + n.model_name + "'>" + n.model_name + "</option>\n";
                        });
                        obj.append(js);
                        obj.attr({
                            disabled: false
                        });
                    }
                }
            }
        });
    } else {
        obj.empty().append("<option value='0'>配置</option>").attr({
            disabled: true
        });
    }
}
function series_selected(obj, brand_id, series_id) {
    if (brand_id > 0) {
        $.ajax({
            type: "POST",
            url: "../ajax.php?action=series",
            data: {
                brand_id: brand_id
            },
            error: function () {
                alert("网络异常，请求失败！！");
            },
            success: function (data) {
                if (data == -4) {
                    alert("系统错误，请联系管理员!!");
                    return false;
                } else {
                    var models = eval("(" + data + ")");
                    if (models) {
                        obj.empty();
                        var js;
                        $.each(models, function (i, n) {
                            js += '<option';
                            if (series_id == n.series_id)
                                js += ' selected="selected"';
                            js += " value='" + n.series_id + "' title='" + n.series_name + "'>" + n.series_name + "</option>\n";
                        });
                        obj.append(js);
                        obj.attr({
                            disabled: false
                        });
                    }
                }
            }
        });
    } else {
        obj.empty().append("<option value='0'>配置</option>").attr({
            disabled: true
        });
    }
}
function model_select(obj, series_id) {

    if (series_id > 0) {
        $.ajax({
            type: "POST",
            url: "../ajax.php?action=models",
            data: {
                series_id: series_id
            },
            error: function () {
                alert("网络异常，请求失败！！");
            },
            success: function (data) {
                if (data == -4) {
                    alert("系统错误，请联系管理员!!");
                    return false;
                } else {
                    var models = eval("(" + data + ")");
                    if (models) {
                        obj.empty();
                        var js;
                        js = "<option value='0'>车款</option>";
                        $.each(models, function (i, n) {
                            js += "<option value='" + n.model_id + "' title='" + n.model_name + "'>" + n.model_name + "</option>\n";
                        });
                        obj.append(js);
                        obj.attr({
                            disabled: false
                        });
                    }
                }
            }
        });
    } else {
        obj.empty().append("<option value='0'>配置</option>").attr({
            disabled: true
        });
    }
}
function over(div) {
    $('#' + div).css('visibility', '');
}
function out(div) {
    $('#' + div).css('visibility', 'hidden');
}
/**
 * 验证身份证号码
 */
function checkIdcard(idcard) {
    var Errors = new Array(
            "验证通过!",
            "身份证号码位数不对!",
            "身份证号码出生日期超出范围或含有非法字符!",
            "身份证号码校验错误!",
            "身份证地区非法!"
            );
    var area = {
        11: "北京",
        12: "天津",
        13: "河北",
        14: "山西",
        15: "内蒙古",
        21: "辽宁",
        22: "吉林",
        23: "黑龙江",
        31: "上海",
        32: "江苏",
        33: "浙江",
        34: "安徽",
        35: "福建",
        36: "江西",
        37: "山东",
        41: "河南",
        42: "湖北",
        43: "湖南",
        44: "广东",
        45: "广西",
        46: "海南",
        50: "重庆",
        51: "四川",
        52: "贵州",
        53: "云南",
        54: "西藏",
        61: "陕西",
        62: "甘肃",
        63: "青海",
        64: "宁夏",
        65: "新疆",
        71: "台湾",
        81: "香港",
        82: "澳门",
        91: "国外"
    }
    var retflag = false;
    var idcard, Y, JYM;
    var S, M;
    var idcard_array = new Array();
    idcard_array = idcard.split("");
    //地区检验
    if (area[parseInt(idcard.substr(0, 2))] == null)
        return Errors[4];
    //身份号码位数及格式检验
    switch (idcard.length) {
        case 15:
            if ((parseInt(idcard.substr(6, 2)) + 1900) % 4 == 0 || ((parseInt(idcard.substr(6, 2)) + 1900) %
                    100 == 0 && (parseInt(idcard.substr(6, 2)) + 1900) % 4 == 0)) {
                ereg = /^[1-9][0-9]{5}[0-9]{2}((01|03|05|07|08|10|12)(0[1-9]|[1-2][0-9]|3[0-1])|(04|06|09|11)(0[1-9]|[1-2][0-9]|30)|02(0[1-9]|[1-2][0-9]))[0-9]{3}$/;//测试出生日期的合法性
            } else {
                ereg = /^[1-9][0-9]{5}[0-9]{2}((01|03|05|07|08|10|12)(0[1-9]|[1-2][0-9]|3[0-1])|(04|06|09|11)(0[1-9]|[1-2][0-9]|30)|02(0[1-9]|1[0-9]|2[0-8]))[0-9]{3}$/;//测试出生日期的合法性
            }
            if (ereg.test(idcard))
                return Errors[0];
            else
            {
                return Errors[2];
            }
            break;
        case 18:
            //18位身份号码检测
            //出生日期的合法性检查
            //闰年月日:((01|03|05|07|08|10|12)(0[1-9]|[1-2][0-9]|3[0-1])|(04|06|09|11)(0[1-9]|[1-2][0-9]|30)|02(0[1-9]|[1-2][0-9]))
            //平年月日:((01|03|05|07|08|10|12)(0[1-9]|[1-2][0-9]|3[0-1])|(04|06|09|11)(0[1-9]|[1-2][0-9]|30)|02(0[1-9]|1[0-9]|2[0-8]))
            if (parseInt(idcard.substr(6, 4)) % 4 == 0 || (parseInt(idcard.substr(6, 4)) % 100 == 0 && parseInt(idcard.substr(6, 4)) % 4 == 0)) {
                ereg = /^[1-9][0-9]{5}19[0-9]{2}((01|03|05|07|08|10|12)(0[1-9]|[1-2][0-9]|3[0-1])|(04|06|09|11)(0[1-9]|[1-2][0-9]|30)|02(0[1-9]|[1-2][0-9]))[0-9]{3}[0-9Xx]$/;//闰年出生日期的合法性正则表达式
            } else {
                ereg = /^[1-9][0-9]{5}19[0-9]{2}((01|03|05|07|08|10|12)(0[1-9]|[1-2][0-9]|3[0-1])|(04|06|09|11)(0[1-9]|[1-2][0-9]|30)|02(0[1-9]|1[0-9]|2[0-8]))[0-9]{3}[0-9Xx]$/;//平年出生日期的合法性正则表达式
            }
            if (ereg.test(idcard)) {//测试出生日期的合法性
                //计算校验位
                S = (parseInt(idcard_array[0]) + parseInt(idcard_array[10])) * 7
                        + (parseInt(idcard_array[1]) + parseInt(idcard_array[11])) * 9
                        + (parseInt(idcard_array[2]) + parseInt(idcard_array[12])) * 10
                        + (parseInt(idcard_array[3]) + parseInt(idcard_array[13])) * 5
                        + (parseInt(idcard_array[4]) + parseInt(idcard_array[14])) * 8
                        + (parseInt(idcard_array[5]) + parseInt(idcard_array[15])) * 4
                        + (parseInt(idcard_array[6]) + parseInt(idcard_array[16])) * 2
                        + parseInt(idcard_array[7]) * 1
                        + parseInt(idcard_array[8]) * 6
                        + parseInt(idcard_array[9]) * 3;
                Y = S % 11;
                M = "F";
                JYM = "10X98765432";
                M = JYM.substr(Y, 1);//判断校验位
                if (M == idcard_array[17])
                    return Errors[0]; //检测ID的校验位
                else
                    return Errors[3];
            }
            else
                return Errors[2];
            break;
        default:
            return Errors[1];
            break;
    }
}
function changeProvince(pid, obj) {
    var option = '<option value="0">市</option>';
    if (pid > 3) {
        $.ajax({
            type: "POST",
            url: "ajax.php?action=city",
            data: {
                pid: pid
            },
            error: function () {
                alert("网络异常，请求失败！！");
            },
            success: function (data) {
                $('#city_id').css("display", "block");
                var json = eval(data);
                for (var key in json) {
                    id = json[key]['id'];
                    name = json[key]['name'];
                    letter = json[key]['letter'];
                    option += '<option value="' + id + '">' + letter + ' ' + name + '</option>' + "\n";
                }
                obj.html(option);
            }
        });
    }
    else {
        $('#city_id').css("display", "none");
    }
}
//居中弹出框
function popCenter(name) {
    var screenWidth = $(window).width();
    var screenHeight = $(window).height();
    var obj = $('.' + name);
    var width = obj.width();
    var height = obj.height();
    var left = screenWidth / 2 - width / 2;
    var top = screenHeight / 2 - height / 2;
    obj.css('left', left);
    obj.css('top', top);
}
function popLogin() {
    var uname = $('#uname').val();
    var password = $('#password').val();
    $.post('login.php?action=checkpoplogin', {uname: uname, password: password}, function (ret) {
        switch (ret) {
            case '1':
                closeLoginpop('login_open_window');
                location.href = 'active.php';
                break;
            case '2':
                alert('密码不正确！');
                break;
            case '3':
                alert('用户名不存在！');
                break;
        }
    });
}
function openLoginpop() {
    $.get('/login.php?action=checkhead', function (msg) {
        if (msg == 00) {
            $("#popMask").show();
            $(".wytj_tank").show();
            popCenter('wytj_tank');
        }
    });
}
function closeLoginpop(name) {
    $("#popMask").hide();
    $("." + name).hide();
}
function showFastReg() {
    $('.wytj_tank').hide();
    $('.wytj_zct').show();
    popCenter('wytj_zct');
}
function sendRegPwd() {
    var phone = $('#phone').val();
    var code = $('#code').val();
    $.get('/register.php?action=fastreg', {phone: phone, code: code}, function (ret) {
        if (ret == 1) {
            $('.open_window2').hide();
            $('.open_window3').show();
            popCenter('open_window3');
        }
        else if (ret == -1)
            alert('验证码不正确!');
        else if (ret == -2)
            alert('该手机号已经注册过,请换个号码试试!');
        else if (ret == -3)
            alert('手机格式不正确，请重新输入!');
        else
            alert('注册失败！');
    });
}
//登陆
function loginHeader() {
    var user = $("input[name='user']").val();
    var pwd = $("input[name='pwd']").val();
    $.getJSON('/login.php?action=loginHeader', {user: user, pwd: pwd}, function (relogin) {
        if (relogin[0] == 'success') {
            $("#header_login_back").css('display', 'block');
            $("#header_login_back > span").first().html(relogin[1]);
            $("#header_login").css('display', 'none');
        } else {
            alert(relogin[1]);
            $("input[name='pwd']").val('');
            $("#header_login_back").css('display', 'none');
            $("#header_login_back > span").first().html('');
            $("#header_login").css('display', 'block');
        }
    });
}
//加关注
function addattention(id) {
    var checkh = $(".login_uname").css("display");
    if (checkh == 'none') {
        alert('未登录用户不能关注，请先通过网站上方的登录功能进行登录后，再对该车进行关注!');
        return;
    }
    var url = 'bingo.php?action=attention';
    var data = {
        id: id
    };
    $.get(url, data, function (msg) {
        if (msg == '00') {
            alert('关注失败');
        } else if (msg == '11') {
            alert('关注成功');
        } else if (msg == '55') {
            alert('未登录用户不能关注，请先通过网站上方的登录功能进行登录后，再对该车进行关注!');
        } else {
            alert('您已经关注过该车');
        }
    });
}
//检查意见反馈长度
function checkAdviceLen() {
    var maxlen = 200;
    var message = $('#message').val().replace(/(^\s*)|(\s*$)/g, "");
    var message_len = message.length;//message.replace(/[\u4e00-\u9fa5]/g,'aa').length;
    var _len = maxlen - message_len;
    if (_len < 0) {
        _message = message.substring(0, message.length - 1);
        var i = 1;
        while (1) {
            _message = message.substring(0, message.length - i);
            _len = maxlen - _message.length;

            if (_len >= 0) {
                break;
            }
            i++;
        }
        $('#message').val(message.substring(0, message.length - i));
    } else {
        $('#allow_lenstr').html(_len);
    }
}