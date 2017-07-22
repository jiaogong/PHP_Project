// JavaScript Document

$(document).ready(function () {
    $(".chexi_right").click(function () {
        $("#chexi_dn").hide()
        $(".chexi_right").css({display: 'none'})
        $(".chexi_right1").css({display: 'block'})
    })
    $(".chexi_right1").click(function () {
        $("#chexi_dn").show()
        $(".chexi_right").css({display: 'block'})
        $(".chexi_right1").css({display: 'none'})
    })
    //左侧导航树字母滑动
    $("ul#navul li").click(function () {
        $(this).addClass("selected").siblings().removeClass("selected");
        var name = $('.selected a').attr('name');
        name = '#brand_' + name;
        var tgtop = $(name).position().top + $(".frame_tree").scrollTop();
        // 取字母标记位置top值 + 当前dl滚动条的top值 = 当前需要的top值
        $(".frame_tree").animate({scrollTop: tgtop}, 500);

    });

    //这里是搜索
    $("#image_search").focus(function () {
        var uname = $("#image_search").val();
        if (uname == '输入车系或者品牌：奥迪、宝马3系') {
            $("#image_search").val('');
        }
    });
    $("#image_search").blur(function () {
        var uname = $("#image_search").val();
        if (uname == '输入车系或者品牌：奥迪、宝马3系' || uname == '') {
            $("#image_search").val('输入车系或者品牌：奥迪、宝马3系');
        }
    });

    $(".serch_btton").click(function () {
        var searchname = $("#image_search").val();
        if (searchname == "输入车系或者品牌：奥迪、宝马3系" || searchname == undefined) {
            // alert("请按要求输入车系名称，否则你将搜索不到相应的内容");
            return false;
        } else {
            $.ajax({
                type: "post",
                url: "image.php?action=searchcheck",
                data: "searchname=" + searchname,
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

    $('#image_search').bind('keyup', function (event) {
        if (event.keyCode == "13") {
            //需要进行的处理程序
            var searchname = $("#image_search").val();
            if (searchname == "输入车系或者品牌：奥迪、宝马3系" || searchname == undefined) {
                // alert("请按要求输入车系名称，否则你将搜索不到相应的内容");
                return false;
            } else {
                $.ajax({
                    type: "post",
                    url: "image.php?action=searchcheck",
                    data: "searchname=" + searchname,
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

    $('.color_img a').click(function () {
        $("#chexi_dn").find(".color_click").hide();
        $(this).parent('dt').find('span').toggle();
    })
    $('.click_title a').click(function () {
        $(this).parent("b").parent("div").parent("span").hide();
    })

});

var state = 0;
function brandjia(id, brand) {
    var brandul = $("#list" + id).html();
    if (brandul == " " || brandul == undefined || brandul == "") {
        window.location.href = '/image_searchbrandlist_brand_id_' + id + '.html';
    } else {
        $(brand).hide();
        if (state == 1) {
            $("#list" + id).show();
            $(brand).next("em").show();
            state = 0;
        } else {
            $("#list" + id).hide();
            $(brand).prev("em").show();
            state = 1;
        }
    }
}
function factoryjia(brand) {
    $(brand).next('ul').toggle();
}