/**
 *首页轮播图
 */
var time, nowOrder, nowLeft, banner_width;
var index = flag = 1;
var focusTime = 3000; //轮播图换图时间
$(document).ready(function () {
    banner_width = $(".banner_tu_left").width(); //轮播图宽度
    //新车上市
    //    $('.xcc_bottom').hover(function() {
    //        $('.xcc_bottom').show();
    //        $(this).hide();
    //        $('.xcc_top').hide();
    //        $(this).prev('.xcc_top').show();
    //    });
    $('.zcbf div').click(function () {
        var i = $(this).index();
        $('.items_span').hide();
        $('.items_span').eq(i).show();
    });

    $(".zhihuan_left_content dl").hover(function () {
        $(this).css("background-color", "#FFF");
        $(this).next().css("background-color", "#F1F4F6");
        $(this).prev().css("background-color", "#F1F4F6");
    }, function () {
        $(".zhihuan_left_content dl").css("background-color", "#fff");
    })
    $(".left_neirong_right dt , .mouse_p").hover(function () {
        $(this).find(".mouse_p a").css("color", "#ea1a14").css("text-decoration", "underline");
        $(this).find("a img").addClass("hover_bj");
    }, function () {
        $(this).find(".mouse_p a").css("color", "#3E4248").css("text-decoration", "none");
        $(this).find("a img").removeClass("hover_bj");
    })
    //综合优惠轮播
    zonghe_x = $(".zonghe_ul .zonghe_dong");
    zonghe = $(".zonghe_ul");
    zonghe.css("width", zonghe_x.length * 305);
    var lz1 = 1;
    $(".zh_left").click(function () {
        zonghe_x.hide();
        if (lz1 < 2) {
            lz1 = 3;
        }
        else {
            lz1--;
        }
        zonghe_x.eq(lz1 - 1).fadeIn(500);
        $('#zonghe_val').html(lz1);
    });

    $(".zh_right").click(function () {
        zonghe_x.hide();
        if (lz1 > 2) {
            lz1 = 1;
        }
        else {
            lz1++;
        }
        zonghe_x.eq(lz1 - 1).fadeIn(500);
        $('#zonghe_val').html(lz1);
    });

    //汽车图片鼠标移动事件
    $(".r_left").hover(function () {
        $(this).find(".on_show").stop(!0).animate({
            top: "90px"
        }, 700);
        $(this).find(".on_show1").stop(!0).animate({
            top: "63px"
        }, 700);
    }, function () {
        $(this).find(".on_show").stop(!0).animate({
            top: "120px"
        }, 700);
        $(this).find(".on_show1").stop(!0).animate({
            top: "93px"
        }, 700);
    })

    //showimg(index);
    time = setInterval("showimg()", focusTime);
    //首页轮播图鼠标经过图片暂停
    $(".banner_tu_left").hover(function () {
        clearInterval(time);
    }, function () {
        if (flag)
            time = setInterval("showimg()", focusTime);
    })

    /**
     * jquery touchwipe插件
     * wipeLeft:从右向左滑动
     * wiprRight:从左向右滑动
     * 现已无效
     */
    $(".banner_tu_left").touchwipe({
        wipeLeft: function () {
            clearInterval(time);
            showimg();
            time = setInterval("showimg()", focusTime);
            flag = 0;
        },
        wipeRight: function () {
            clearInterval(time);
            showimg2();
            time = setInterval("showimg()", focusTime);
            flag = 0;
        }
    });

    $('.syg_ss').click(function () {
        var sid = $('#series_id').val();
        var mid = $('#model_id').val();
        if (sid == 0) {
            window.open('/search.php?action=index');
            return false;
        }
        else {
            window.open('/modelinfo_s' + sid + '.html');
            //            if(mid == 0) window.open('modelinfo_s' + sid + '.html');
            //            else window.open('modelinfo_' + mid + '.html');
        }
    });
    //    $(".left_neirong_right dt").mouseover(function(){
    //        $(".mouse_show").css("display","block");
    //    }).mouseout(function(){
    //        $(".mouse_show").css("display","none");
    //    })

    $(".zhihuan_left_content").mouseover(function () {
        $(this).find(".zhihuan_left_tu , .zhihuan_right_tu").show();
    }).mouseout(function () {
        $(this).find(".zhihuan_left_tu, .zhihuan_right_tu").hide();
    })
    $(".zhihuan_left_dl").css({
        "left": -841
    });

    var loan_n = 1, replace_n = 1, focus_left;
    //置换贷款向右滑动
    $(".zhihuan_left_tu").click(function () {
        if (loan_n < 1 || replace_n < 1) {
            $(this).next().css({
                "left": -1682
            }).stop(true).animate({
                "left": -841
            }, 500);
            if ($(this).next().attr("class") == "zhihuan_left_dl loan")
                loan_n = 1;
            else
                replace_n = 1;
        } else {
            if ($(this).next().attr("class") == "zhihuan_left_dl loan") {
                --loan_n;
                focus_left = loan_n * -841;
            } else {
                --replace_n;
                focus_left = replace_n * -841;
            }
            $(this).next().animate({
                "left": focus_left
            }, 500);
        }
    })
    //置换贷款向左滑动
    $(".zhihuan_right_tu").click(function () {
        if (loan_n > 2 || replace_n > 2) {
            $(this).prev().css({
                "left": -841
            }).stop(true).animate({
                "left": -1682
            }, 500);
            if ($(this).prev().attr("class") == "zhihuan_left_dl loan")
                loan_n = 2;
            else
                replace_n = 2;
        } else {
            if ($(this).prev().attr("class") == "zhihuan_left_dl loan") {
                ++loan_n;
                focus_left = loan_n * -841;
            } else {
                ++replace_n;
                focus_left = replace_n * -841;
            }
            $(this).prev().animate({
                "left": focus_left
            }, 500);
        }
    })


    $(".tu").mouseover(function () {
        $(this).css("background-color", "#f7db8f").css("color", "#bf9838");

    }).mouseout(function () {
        $(this).css("background-color", "#cecece").css("color", "#fff");
    })

    $(".pk1").mouseover(function () {
        $(".pk1_hover").hide();
        $(".pk1").show();
        $(this).hide();
        $(this).prev().show();
    })
    $(".tu_right_shang, .tu_right_xia").hover(function () {
        $(this).find("span").stop(!0).animate({
            top: "-90px"
        }, 700);
        $(this).find(".banner_dibushow").stop(!0).animate({
            top: "-103px"
        }, 700);
        $(this).find(".hover_title").css("text-decoration", "underline");
    }, function () {
        $(this).find("span").stop(!0).animate({
            top: "0px"
        }, 700);
        $(this).find(".banner_dibushow").stop(!0).animate({
            top: "0px"
        }, 700);
        $(this).find(".hover_title").css("text-decoration", "none");

    })

    //排行榜效果
    $(".news_right_tu").mouseover(function () {
        $(this).find(".show_qian").show();
        $(this).find(".show_hou").hide();
        $(this).find('.img_rightx').css('background-color', '#fff');
        $(this).find('.righta').css('color', '#3E4248');
        $(this).find('.righta p span').css('color', 'red');
    }).mouseout(function () {
        $(this).find(".show_hou").show();
        $(this).find(".show_qian").hide();
        var color = $(this).find('#rightx_color').val();
        $(this).find('.img_rightx').css('background-color', color);
        $(this).find('.righta').css('color', '#fff');
        $(this).find('.righta p span').css('color', '#fff');
    })

    //大家都在看
    $(".right_content dl dt img").hover(
            function () {
                $(this).stop(!0).animate({
                    left: '-10px'
                }, 500);
            },
            function () {
                $(this).stop(!0).animate({
                    left: ''
                }, 500);
            }
    );
    /*   
     //文字向上滚动
     var myar = setInterval('AutoScroll(".li_gundong")', 2000)
     $(".li_gundong").hover(function() {
     clearInterval(myar);
     }, function() {
     myar = setInterval('AutoScroll(".li_gundong")', 2000)
     }); 
     */

    $.getJSON('/html/cpajax.php?action=jsrecommend', function (recommend) {
        var recommendHtml = '';
        $.each(recommend, function (k, v) {
            recommendHtml += '<dl><dt><a href="/modelinfo_s' + v['series_id'] + '.html"' + ' target="_blank">';
            recommendHtml += '<img width="122" height="93" src="/attach/images/model/' + v['model_id'] + '/122x93' + v['model_pic1'] + '"' + ' onerror=this.src="/images/122x93.jpg">';
            recommendHtml += '</a></dt><dd><p style="font-size:12px; color:#000; line-height:30px">' + v['factory_alias'] + '</p>';
            recommendHtml += '<p style="line-height:30px;"><a href="/modelinfo_s' + v['series_id'] + '.html"' + ' target="_blank">' + v['series_alias'] + '</a></p>';
            recommendHtml += '<p style="line-height:30px;">' + v['dealer_price_low'] + '万起</p></dd></dl>';
        })
        $("#newindex_change_modellist").html(recommendHtml);
        //换一批
        $("#change_recommend").click(function () {
            $("#newindex_change_modellist").hide();
            $("#newindex_change_modellist").children('dl').slice(0, 4).appendTo('#newindex_change_modellist');
            $("#newindex_change_modellist").fadeIn('1000');
        })
    })

    //首页图片延迟加载
    $("img.lazy").lazyload();
})

function AutoScroll(obj) {

    $(obj).find("ul:first").animate({
        marginTop: "-25px"
    }, 500, function () {
        $(this).css({
            marginTop: "0px"
        }).find("li:first").appendTo(this);
    });
}

/**
 * 轮播图滑动效果
 */

function showimg() {
    index++;
    // alert(index)
    if (index > 6) {
        index = 2;
        $(".banner_guntu").css("left", -banner_width * 1).stop(true).animate({"left": -banner_width * index}, 500);
        $(".gundong_shu ul li").removeClass("shu_1_hover").eq(index - 1).addClass("shu_1_hover");
        $(".gundong_show span").hide().eq(index - 1).show();
    } else {
        $(".banner_guntu").stop(true).animate({"left": -banner_width * index}, 500);
        if (index == 6) {
            $(".gundong_shu ul li").removeClass("shu_1_hover").first().addClass("shu_1_hover");
            $(".gundong_show span").hide().first().show();
        } else {
            $(".gundong_shu ul li").removeClass("shu_1_hover").eq(index - 1).addClass("shu_1_hover");
            $(".gundong_show span").hide().eq(index - 1).show();
        }
    }
}

/**
 * 轮播图滑动效果，手机用
 */

function showimg2() {
    index--;
    if (index < 0) {
        index = 4;
        $(".banner_guntu").css("left", -5 * banner_width).stop(true).animate({"left": -banner_width * index}, 500);
        $(".gundong_shu ul li").removeClass("shu_1_hover").eq(index - 1).addClass("shu_1_hover");
        $(".gundong_show span").hide().eq(index - 1).show();
    } else {
        $(".banner_guntu").stop(true).animate({"left": -banner_width * index}, 500);
        if (index == 0) {
            $(".gundong_shu ul li").removeClass("shu_1_hover").last().addClass("shu_1_hover");
            $(".gundong_show span").hide().last().show();
        } else {
            $(".gundong_shu ul li").removeClass("shu_1_hover").eq(index - 1).addClass("shu_1_hover");
            $(".gundong_show span").hide().eq(index - 1).show();
        }
    }
}

//轮播图点击小数字效果
function coverHover(k) {
    index = k - 1;
    showimg();
}

//最新暗访价跳转
function jump(i) {
    //window.location.href="offers_"+ i +".html";
    window.open("/offers_" + i + ".html");
}



//19个轮换判断是否有改变
function locationpan(model_id) {
    var model_id = model_id;
    $.getJSON("/cpajax.php?action=pan19", "model_id=" + model_id, function (msg) {
        if (msg[0] == "ok") {
            //window.location.href="http://www.ibuycar.com/modelinfo_m"+model_id+".html";
            window.open("http://www.ibuycar.com/modelinfo_m" + model_id + ".html");
        } else {
            //window.location.href="http://www.ibuycar.com";
            window.open("http://www.ibuycar.com");
        }
    })

}