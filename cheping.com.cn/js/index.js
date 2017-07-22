// JavaScript Document
$(function () {
    $("ul#navul li").live('click', function () {
        $(this).addClass("selected").siblings().removeClass("selected");
        var name = $('.selected a').attr('name');
        name = '#pinpai_' + name;
        var tgtop = $(name).position().top + $(".select_second").scrollTop();
        // 取字母标记位置top值 + 当前dl滚动条的top值 = 当前需要的top值
        $(".select_second").animate({scrollTop: tgtop}, 500);
    });
});
/*滚动条滚动*/
function windowScroll() {
    var scrollPos;
    if (typeof window.pageYOffset != 'undefined') {
        scrollPos = window.pageYOffset;
    }
    else if (typeof document.compatMode != 'undefined' &&
            document.compatMode != 'BackCompat') {
        scrollPos = document.documentElement.scrollTop;
    }
    else if (typeof document.body != 'undefined') {
        scrollPos = document.body.scrollTop;
    }

    if (scrollPos >= 240) {
        $('.float').css({
            'position': 'fixed',
            'height': '215px'
        });

    } else {
        $('.float').css({
            'position': 'static',
            'height': '230px'
        });
    }
}

/**
 * index_v2.js
 */
var t, wallpaper;
$(document).ready(function () {

    jQuery(function () {
        function b() {
            img.each(function () {
                typeof $(this).attr("imgsrc") != "undefined" && $(document).scrollTop() > 0 && $(this).offset().top < $(document).scrollTop() + $(window).height() && $(this).attr("src", $(this).attr("imgsrc")).removeAttr("imgsrc")
            });
        }
        var img = $(".wrap1_v1 img,.recent_con_v1 img,.focus_con_v1 img,.new_v1 img,#index_wallpaper img,li img");
        $(window).scroll(function () {
            b();
        });
        b();
    });

    window.onscroll = windowScroll;
    $(".pos_Expansion a").eq(0).click(function () {
        $(".index_banner").animate({height: "0"}, {queue: false, duration: "slow"});
        $(".pos_Expansion a").toggle();
    });
    $(".pos_Expansion a").eq(1).click(function () {
        $(".index_banner").show().animate({height: "226"}, {queue: false, duration: "slow"});
        $(".pos_Expansion a").toggle();
    });

    var li_index_v1 = $('.item_v1 li').size();
    $('.item_v1 li').hover(function () {
        $(this).addClass('active');
        $(this).find('.items_v1').show();
        if ($(this).index() == 0) {
            $(this).find('.items_v1').css('top', '-170px');
        } else if ($(this).index() == li_index_v1 - 1) {
            $(this).find('.items_v1').css('top', '170px');
        } else if ($(this).index() == 1) {
            $(this).find('.items_v1').css('top', '-78px');
        } else {
            $(this).find('.items_v1').css('top', '-78px');
        }
        $(this).find('em').hide();
    }, function () {
        $(this).removeClass('active');
        $(this).find('.items_v1').hide();
        $(this).find('em').show();
    });

    /*top anniu*/

    $(function () {
        $(".site-nav-bd-r li").hover(function () {
            $(this).addClass("menu-hover").siblings().removeClass("menu-hover"), function () {
                $(this).removeClass("menu-hover");
            }
        });
        $(".site-nav-bd-r li").mouseleave(function () {
            $(this).removeClass("menu-hover");
        });
    });

    /*xiala*/
    $(".mting h2.js").hover(function () {
        var $hid = $(this).siblings("dl");
        if ($hid.is(":hidden")) {
            $(this).hide().parent('.mting').siblings('.mting').find('h2.js').show();
            $hid.show().parent('.mting').siblings('.mting').find('dl').hide();

        }
    });
    
    /* 点击车的品牌 */
    $(".select_second4").live('click', function () {
        var brandid = $(this).attr("brandid");
        $.get('/ajax.php?action=jsondata&getseriesdata=get',{brandid:brandid},function(data){
            if(data){
                $('.series_content').empty();
                $('.series_content').append(data);
                $(".select_03").addClass("selected").siblings();
                $(".select_03").show();
            }
        })
    });

    $(".xs_left2").mouseover(function () {
        $(this).css("left", "172px");
    });
    $(".xs_left3").mouseover(function () {
        $(this).css("left", "350px");
    });
    
    /* 点击车型大全按钮 */
    $(".sy_ss").click(function () {
        if(!$('ul#navul')[0]){
            $.get('/ajax.php?action=jsondata&getbranddata=get',function(data){
                if(data){
                    $('.spzc_content2').empty();
                    $('.spzc_content2').append(data);
                    $(".spzc_content").show();
                    $(".spzc_content").hover(
                            function () {
                                $(".spzc_content").show();
                            },
                            function () {
                                $(".spzc_content").hide();
                                $(".select_03").hide();
                                $(".sy_ss input").blur();
                            }
                    );
                }
            });
        }else{
            $(".spzc_content").show();
            $(".spzc_content").hover(
                    function () {
                        $(".spzc_content").show();
                    },
                    function () {
                        $(".spzc_content").hide();
                        $(".select_03").hide();
                        $(".sy_ss input").blur();
                    }
            );
        }
    });

    $(".pp_07_one").hover(function () {
        $(this).find(".zhegai").css("display", "block");
    }, function () {
        $(this).find(".zhegai").css("display", "none");
    })

    $(".tt_05").hover(function () {
        $(this).find(".on_tt").css("display", "block");
    }, function () {
        $(this).find(".on_tt").css("display", "none");
    })

});		  		  