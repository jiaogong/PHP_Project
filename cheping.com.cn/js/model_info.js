function changeModelPrice(num, mid) {
    var priceName = new Array('model_pic', 'name', 'bingobang', 'pricelog_id_from', 'model_price', 'save', 'discount');
    var iii = $(".com" + num).css("display");
    if (iii == "none") {
        $(".com" + num).show();
        $(".coms" + num).hide();
    } else {
        $(".com" + num).hide();
        $(".coms" + num).show();
    }

    $.get('ajax.php?action=ChangeModelPrice', {model_id: mid}, function (ret) {
        var arr = eval('(' + ret + ')');
        $('#cmpmodel' + num).val(mid);
        $('a.model_link' + num).attr({href: '/modelinfo_' + mid + '.html'});
//        alert(1);
//        alert(priceName);
        $.each(priceName, function (i, v) {
            var name = v + num;

            if (arr[v]) {
                if (v == 'name') {
                    arr[v] = "<a href='modelinfo_" + mid + ".html' target='_blank'>" + arr[v] + "</a>";
                    $('#' + name).html(arr[v]);
                } else if (v != 'model_pic' && v != 'pricelog_id_from')
                    $('#' + name).html(arr[v]);
                if (v == 'model_pic') {
                    $('#' + name).attr("src", arr[v]);
                }
                if (v == 'name') {
                    $('#' + name).attr("title", arr['series_name'] + ' ' + arr['model_name']);
                }
                if (v == 'pricelog_id_from') {
                    if (arr['pricelog_id_from'] == 1) {
                        $("#bingobang" + num).append("&nbsp;<span class='biaoge_tan2' onmouseover='javascrpt:$(this).find(\"span\").toggle();'><img src='images/ss_an.jpg'><a href='#'><span style='font-size: 12px; display: none;'><div class='gzs_jtbg'><img src='images/qkgc_gzs.png'></div>“冰狗暗访价”是冰狗行情团队以“到店客户”身份获取的价格，优惠中不含官方补贴和礼包；专业的话术和议价流程，保证了我们获取的“行情”信息基本接近个人客户在该店的最终成交价；这里提取的是一定时间内最低的暗访价。</span></a></span>");
                    } else if (arr['pricelog_id_from'] == 2) {
                        $("#bingobang" + num).append("&nbsp;<span class='biaoge_tan2' onmouseover='javascrpt:$(this).find(\"span\").toggle();'><img src='images/meiti.jpg'><a href='#'><span style='font-size: 12px; display: none;'><div class='gzs_jtbg'><img src='images/qkgc_gzs.png'></div>“网络媒体价”是网络媒体公开展示的经销商报价，是由经销商报给网站的价格，可能会有概念模糊甚至不实的情况；该价格(或优惠幅度)可能含有官方补贴、置换补贴、贷款额外优惠、礼包宣称价值等；这里提取的是时间最近的网络媒体价。 </span> </a> </span>");
                    } else if (arr['pricelog_id_from'] == 3) {
                        $("#bingobang" + num).append("&nbsp;<span class='biaoge_tan2' onmouseover='javascrpt:$(this).find(\"span\").toggle();'><img src='images/shuang11_biao.jpg'><a href='#'><span style='font-size: 12px; display: none;'><div class='gzs_jtbg'><img src='images/qkgc_gzs.png'></div> “双11价格”是2013年各网站“双11”活动专题，来自于汽车行业各大门户、垂直媒体、类型网站以及电商已经公布的优惠价，由冰狗独家整理、汇总和发布，供您参阅和选择。 </span> </a> </span>");
                    }
                }

            } else
                $('#' + name).html('');
        })
        //  $(".com"+num).toggle();
        //  $(".coms"+num).toggle();



    });

    var arr = new Array(0, 1, 2);
    var mids = '';
    $.each(arr, function (i, v) {

        if (num == v) {
            mids += mid + ',';
        } else {
            mids += $('#cmpmodel' + i).val() + ',';
        }

    });

    function Trans_php_time_to_str(timestamp, n) {
        update = new Date(timestamp * 1000);//时间戳要乘1000
        year = update.getFullYear();
        month = (update.getMonth() + 1 < 10) ? ('0' + (update.getMonth() + 1)) : (update.getMonth() + 1);
        day = (update.getDate() < 10) ? ('0' + update.getDate()) : (update.getDate());
        hour = (update.getHours() < 10) ? ('0' + update.getHours()) : (update.getHours());
        minute = (update.getMinutes() < 10) ? ('0' + update.getMinutes()) : (update.getMinutes());
        second = (update.getSeconds() < 10) ? ('0' + update.getSeconds()) : (update.getSeconds());
        if (n == 1) {
            return (year + '-' + month + '-' + day + ' ' + hour + ':' + minute + ':' + second);
        } else if (n == 2) {
            return (year + '/' + month);
        } else {
            return 0;
        }
    }
    var comparepricelogmax = $("#comparepricelogmax").val();
    $.get('ajax.php?action=ChangeModelPriceLog', {
        model_id: mids
    }, function (ret) {
        var arr = eval('(' + ret + ')');
        var timeArr = '';
        var str = "<div style='margin-top:-18px;' id='TopEmployeesDiv4'>统计图生成失败</div>\n";
        str += "<script type='text/javascript'>\n";
        str += "var chart = new FusionCharts('/vendor/FusionCharts/js/MSLine.swf', 'ChartId', '790', '330');\n";
        str += "var str = \"<chart caption=' ' showValues='0' yAxisMaxValue='" + comparepricelogmax + "'  numberScaleValue='1,1' numberScaleUnit='万,万' >\"\n";
        str += "str +=\"<categories>\"\n";
        $.each(arr, function (i, v) {
            if (v) {
                $.each(v, function (j, k) {
                    if (k) {
                        timeArr = v;
                        return false;
                    }

                });

            }

        });
        $.each(timeArr, function (i, v) {

            str += "str +=\"<category label='" + Trans_php_time_to_str(v['get_time'], 2) + "'/>\"\n";
        });

        str += "str +=\"</categories>\"\n";

        $.each(arr, function (i, v) {
            str += "str +=\"<dataset  seriesName='" + i + "'>\"\n";
            $.each(v, function (j, k) {
                str += "str +=\"<set value='" + k['price'] + "'/>\"\n";
            })
            str += "str +=\"</dataset>\"\n";
        });

        str += "str +=\"</chart>\"\n";

        str += "chart.setDataXML(str);\n";
        str += "chart.render('TopEmployeesDiv4');\n";
        str += "</script>";
        //alert(str);
        if (!timeArr) {
            str = "本车款暂无历史价格数据";
        }
        $("#changepricelog").html(str);
    });

}


$(function () {
    $(".ul_left").click(function () {
        var num = $("#liangdian_pz").val();
        if (num > 0) {
            var left_n = Number(num) - 1;
        } else {
            var left_n = Number(num);
        }
        $("#liangdian_pz").val(left_n);
    })

    $(".ul_right").click(function () {
        var num = $("#liangdian_pz").val();
        if (num < 3) {
            var right_n = Number(num) + 1;
        } else {
            var right_n = num;
        }
        $("#liangdian_pz").val(right_n);
    })
})

$(document).ready(function () {

    $(".apply_close").click(function () {
        $("#wx-popup").css("display", "none");
        $(".wrapGrayBg").css("display", "none");
    })

    $(".wx").click(function () {
        $("#wx-popup").css("display", "block");
        $(".wrapGrayBg").css("display", "block");
    })




    $(".sq_bg tr").hover(function () {
        var ii = $(this).attr("id");
        if (ii == "not_class") {
        } else {
            $(this).siblings().removeClass("bg_hua");
            $(this).addClass("bg_hua");
        }
    })

    $(".biaoge_tan").hover(function () {
        $(this).find("span").toggle();

    });
    $(".biaoge_tan1").hover(function () {
        $(this).find("span").toggle();

    });
    $(".biaoge_tan2").hover(function () {
        $(this).find("span").toggle();

    });

    $("#ckdt_datu").hover(function () {
        $(".zi_title").toggle();
    })

    var sWidth = $('#ckdt_datu').width();//获取焦点图的宽度（显示面积）
    var len = $('#ckdt_datu ul li').length; //获取焦点图个数
    var index = 0;
    var pic_length = $('#ss_ul li').size();//获取小图的个数
    var pic_height = $('#ss_ul').height();//获取盛放所有图片的ul的高度
    var times = 0;

    /* 大图轮播*/
    $('#ckdt_datu ul').css("width", sWidth * (len));//所有li元素都是在同一排向左浮动，所以这里计算出外围ul元素的宽度	
    $('#left_btn').click(function () {
        if (index > 0) {
            index -= 1;
            showPics(index);

        }
        if (len - index > 3) {
            $('#ss_ul').animate({
                'margin-top': -index * 130 + 'px'
            }, 'slow');
        }

    });

    $('#right_btn').click(function () {
        if (index < len - 1) {
            index += 1;
            showPics(index);
        }

        if (index > 3) {
            $('#ss_ul').animate({
                'margin-top': -(index - 3) * 130 + 'px'
            }, 'slow');
        }
    });

    //显示图片函数，根据接收的index值显示相应的内容
    function showPics(index) {
        var nowLeft = -index * sWidth; //根据index值计算ul元素的left值
        $('#ckdt_datu ul').stop(true, false).animate({
            "left": nowLeft
        }, 300);
        /*为当前的小图切换到选中的样式*/
        $('#ckdt_xiaotu li').stop(true, false).removeClass("focus").eq(index).stop(true, false).addClass("focus");

    }


    /* 小图上下滚动*/
    $('.ckdt_s').click(function () {
        if (pic_length > 4 && times < pic_length) {
            if (times * 130 <= pic_height - 535) {
                times++;
                $('#ss_ul').animate({
                    'margin-top': -times * 130 + 'px'
                }, 'slow');
            }
        }
    })

    $('.ckdt_x').click(function () {
        if (pic_length > 4 && times > 0) {
            times--;
            $('#ss_ul').animate({
                'margin-top': -times * 130 + 'px'
            }, 'slow');

        }
    })

    /* 点击小图，显示相应大图*/
    $('#ckdt_xiaotu li').hover(function () {
        index = $("#ckdt_xiaotu li").index(this);
        $('#ckdt_xiaotu li.focus').removeClass("focus");
        $(this).parents("li").addClass("focus");
        showPics(index);
    }).eq(0).trigger("click");


    //限时抢购,限量抢购
    $(".wrap1_v1 .left1_v1 .Round_bus li").live('click',function () {
        var i = $(this).index();
        $(this).siblings("li").find("a").removeClass("focus");
        $(this).find("a").addClass("focus");
        $(this).parents(".left1_v1").find(".column_list2t li").hide().eq(i).show();
        $(this).parents(".left1_v1").children(".rightw_v1").hide().eq(i).show();
        $(this).parents(".left1_v1").find(".header4_v1 span,.header3_v1 span").hide().eq(i).show();
        $(this).parents(".left1_v1").find(".show_index").val(i);
    });

    $(".left1_v1 .lsi_v").live('click',function () {
        var left1_v1 = $(this).parents(".left1_v1");
        var i_num = $(this).parents(".Round_bus").find("li").length - 1;
        var i = left1_v1.find(".show_index").val();
        if (i > 0) {
            i--;
        } else {
            i = i_num;
        }

        left1_v1.find(".Round_bus").find("a").removeClass("focus");
        left1_v1.find(".Round_bus").find("li").eq(i).find("a").addClass("focus");
        left1_v1.find(".column_list2t li").hide().eq(i).show();
        left1_v1.children(".rightw_v1").hide().eq(i).show();
        left1_v1.find(".header4_v1 span,.header3_v1 span").hide().eq(i).show();
        left1_v1.find(".show_index").val(i);
    })

    $(".left1_v1 .lsi_v1").live('click',function () {
        var left1_v1 = $(this).parents(".left1_v1");
        var i_num = $(this).parents(".Round_bus").find("li").length - 1;
        var i = left1_v1.find(".show_index").val();
        if (i < i_num) {
            i++;
        } else {
            i = 0;
        }
        left1_v1.find(".Round_bus").find("a").removeClass("focus");
        left1_v1.find(".Round_bus").find("li").eq(i).find("a").addClass("focus");
        left1_v1.find(".column_list2t li").hide().eq(i).show();
        left1_v1.children(".rightw_v1").hide().eq(i).show();
        left1_v1.find(".header4_v1 span,.header3_v1 span").hide().eq(i).show();
        left1_v1.find(".show_index").val(i);
    })

    $(".cky_img").hover(function () {
        $(this).find(".cky_show").toggle();
        $(this).find(".cky_show2").toggle();
        $(this).find(".cky_show3").toggle();
    })

    $(".LeftBotton").click(function () {

        var left = document.getElementById(".LeftBotton").offsetLeft - 29;
        left += 'px';
        alert(111);
        $(".ScrCont").animate({
            left: '-29px'
        }, "slow");

    })

    $(".lintab2_tt li").hover(function () {
        $(this).attr("Class", ".cky_hover").siblings().attr("Class", ".cky_hover")
    })



    $(".ckxx a").hover(function () {
        $("#span2").toggle();
    });

    $(".anfang img").hover(function () {
        $(".an_span").toggle();
    })

    $(".rg_show a").live('click',function () {
        var pz3 = $(".qbpz_tabs").css("display");
        if (pz3 == "block") {
            $(".qbpz_tabs").css("display", "none");
            $("#i-tabs-container").empty()
            $(".up_pz").css("display", "block");
            $(".down_pz").css("display", "none");
        } else {
            $(".up_pz").css("display", "block");
            $(".down_pz").css("display", "none");

        }
    })


    $(".rg_close a").click(function () {
        var pz3 = $(".qbpz_tabs").css("display");
        if (pz3 == "block") {
            $(".qbpz_tabs").css("display", "none");
            $("#i-tabs-container").empty()
            $(".up_pz").css("display", "block");
            $(".down_pz").css("display", "none");
        } else {
            $(".up_pz").css("display", "block");
            $(".down_pz").css("display", "none");

        }
    })
    $(".xl_down a").click(function () {
        $(".topv1_nr").hide();
    })

    $(".xl_bg").hover(
            function () {
                var up = $(".topv1_nr").css("display");
                if (up == "block") {

                } else {
                    $(".xl_bg").css("background", "url(../images/lan_hover.png) no-repeat right 23px");
                }

            },
            function () {
                var up1 = $(".topv1_nr").css("display");
                if (up1 == "block") {
                    $(".xl_bg").css("background", "url(../images/up_xl.png) no-repeat right 23px");
                } else {
                    $(".xl_bg").css("background", "url(../images/down_xl.png) no-repeat right 23px");
                }

            }
    )
    $(".xl_bg").click(function () {
        $(".topv1_nr").toggle();
        var bg = $(".topv1_nr").css("display");
        if (bg == "block") {
            $(".xl_bg").css("background", "url(../images/up_xl.png) no-repeat right 23px");
        } else {
            $(".xl_bg").css("background", "url(../images/down_xl.png) no-repeat right 23px");
        }

    })

    $(".dlpz_right").click(function () {
        $(this).children("a").toggle();
        var pz3 = $(".qbpz_tabs").css("display");
        if (pz3 == "block") {
            $(".qbpz_tabs").css("display", "none");
            $("#i-tabs-container").empty()
            $(".up_pz").css("display", "block");
            $(".down_pz").css("display", "none");
        } else {
            var mid = $(".up_pz").attr('url');
            $.ajax({
                url: '/modelinfo.php?action=AjaxLd',
                type: "GET",
                data: ({mid: mid}),
                success: function (ret) {
                    $('#i-tabs-container').append(ret);
                }
            });
            $(".qbpz_tabs").css("display", "block");
            $(".up_pz").css("display", "none");
            $(".down_pz").css("display", "block");
        }
    })


    $('.lintab2_tt li').hover(function () {
        var i = $(this).index();
        $(this).attr("class", "cky_hover");
        $(this).siblings().attr("class", "cky_link");
        $(this).parent().siblings().css({
            display: 'none',
            "border-right": "1px solid #F3F3F3"
        });
        $(this).parent().siblings().css("border-right", "1px solid #F3F3F3");
        $(this).parent().parent().find('.lr' + i).css({
            display: 'block'
        });
    });

    $('.ckpz_id').click(
            function () {
                var name_back = $(this).css("background-Image");
                if (name_back.indexOf("ck_left_jt") > 0) {
                    $(".peizhi_tab").css("display", "none");
                    $('.ckpz_id').html("查看");
                    $('.ckpz_id').css({
                        color: "#ea1a14",
                        bolder: "none"
                    });
                }
                $(this).css({
                    background: '',
                    height: ''
                });
                $(this).parent().prev().find(".peizhi_tab").toggle();
                var aa = $(this).parent().prev().find(".peizhi_tab").css("display");
                if (aa == "block") {
                    $(this).html("收起");
                    $(this).css({
                        color: "#000",
                        bolder: "font-weight"
                    });
                } else if (aa == "none") {
                    $(this).html("查看");
                    $(this).css({
                        color: "#ea1a14",
                        bolder: "none"
                    });
                }
            }
    );
    $(".intr_tu").click(function () {
        $(".peizhi_tab").css("display", "none");
        $('.ckpz_id').html("查看");
        $('.ckpz_id').css({
            color: "#ea1a14",
            bolder: "none"
        });
    })
    $(".chekuan_td").click(function () {
        $(".peizhi_tab").css("display", "none");
        $('.ckpz_id').html("查看");
        $('.ckpz_id').css({
            color: "#ea1a14",
            bolder: "none"
        });
    })

    $('.ckpz').hover(
            function () {
                var name = $(this).find(".ckpz_id").html();
                if (name == '查看') {
                    $(this).find(".ckpz_id").html("");
                    $(this).find(".ckpz_id").css({
                        background: 'url(images/ck_left_jt.jpg) no-repeat',
                        height: "26px"
                    });
                } else if (name == '收起') {
                    $(this).find(".ckpz_id").html("");
                    $(this).find(".ckpz_id").css({
                        background: 'url(images/ck_right_jt.jpg) no-repeat',
                        height: "26px"
                    });
                }
            },
            function () {
                var name_back = $(this).find(".ckpz_id").css("background-Image");

                if (name_back.indexOf("ck_left_jt") > 0) {
                    $(this).find(".ckpz_id").css({
                        background: '',
                        height: ''
                    });
                    $(this).find(".ckpz_id").html("查看");
                    $(this).find(".ckpz_id").css({
                        color: "#ea1a14",
                        bolder: "none"
                    });

                } else if (name_back.indexOf("ck_right_jt") > 0) {
                    $(this).find(".ckpz_id").css({
                        background: '',
                        height: ''
                    });
                    $(this).find(".ckpz_id").html("收起");
                    $(this).find(".ckpz_id").css({
                        color: "#000",
                        bolder: "font-weight"
                    });

                }

            }
    )


    $(".cs").click(function () {

        var ck = $(this).parent("div").find(".chekuan").css('display');
        if (ck == 'none') {
            $(".cs").css("background-Image", "url(images/canshu.jpg)");
            $(".chekuan").css("display", "none");
            $(this).css("background-Image", "url(images/shouqi.jpg)");
            $(this).parent("div").find(".chekuan").css('display', "block");
        }
        else {
            $(this).css("background-Image", "url(images/canshu.jpg)");
            $(".chekuan").css("display", "none");
        }

    })


    $(".jgz").click(function () {
        var mid = $(this).attr("name");
        $.get("modelinfo.php?action=attention", {
            mid: mid
        }, function (data) {
            if (data == 3) {
                // window.open("login.php?lurl=modelinfo_"+mid+".html");
                //  window.location.href="login.php?lurl=modelinfo_"+mid+".html";
                alert("未登录用户不能关注，请先通过网站上方的登录功能进行登录后，再对该车进行关注!");
            } else if (data == 2) {
                alert("您已经关注该车款");
            } else {
                alert('关注成功!');
            }
        });

    })

    $("#daikuan").click(function () {
        var view = $(this).find(".xczx span").css("display");
        if (view == 'none') {
            $(".xczx span").css("display", "none");
            $(this).find(".xczx span").css("display", "block");
        } else {
            $(".xczx span").css("display", "none");
        }
    })
    $("#ckxx5").click(function () {
        var view = $(this).find(".xczx span").css("display");
        if (view == 'none') {
            $(".xczx span").css("display", "none");
            $(this).find(".xczx span").css("display", "block");
        } else {
            $(".xczx span").css("display", "none");
        }
    })


    $("#pl").click(
            function () {
                if ($(this).hasClass('ppjj')) {
                    $(".ppjj span").css('background', 'url(images/ckyx_pj_hover2.jpg) repeat');
                    $(".ppjj").css('height', 'auto');
                    $(".ppjj span").css('height', 'auto');
                    $(".pj_sj").css('background', 'url(images/pj_sj_hover.jpg) no-repeat');
                    $(this).removeClass('ppjj');
                    $(this).addClass('ppkk');
                }
                else {
                    $(".ppkk span").css('background', '');
                    $(".ppkk span").css('height', '');
                    $(".pj_sj").css('background', '');
                    $(this).removeClass('ppkk');
                    $(this).addClass('ppjj');
                }
            }
    );
    $('.qbzk').click(function () {
        if ($(this).text() == '全部展开') {
            $(this).parent().parent().parent().parent().parent().parent().parent().find('.table_dis').show();
            // $('.table_dis').show();     
            $(this).html('<a href="javascript:void(0);">全部收拢</a>');
        }
        else {
            $(this).parent().parent().parent().parent().parent().parent().parent().find('.table_dis').hide();
            //$('.table_dis').hide();     
            $(this).html('<a href="javascript:void(0);">全部展开</a>');
        }
    });
    $('.change_model').each(function (i) {
        $(this).click(function () {
            if (i == 0 || i == 1) {
                $(".com" + 0).toggle();
                $(".coms" + 0).toggle();
            }
            if (i == 2 || i == 3) {
                $(".com" + 1).toggle();
                $(".coms" + 1).toggle();
            }
            if (i == 4 || i == 5) {
                $(".com" + 2).toggle();
                $(".coms" + 2).toggle();
            }

        });
    });


    /*展开 收起 车款按钮*/
    $(".intr_car_con .intr_toggle").click(function () {
        $(this).children("a").toggle();
        $(this).parents("ul").next(".table_dis").toggle();
    }).focus(function () {
        $(this).blur();
    });
    $('#tab_tit1 li').mouseover(function () {
        var i = $(this).parent("ul").find(".focus").index();
        var j = $(this).index();
        $(this).parent("ul").find(".focus").removeClass("focus");
        $(this).parent("ul").find(".focus_1").removeClass("focus_1");
        $(this).addClass("focus");
        $(this).find("a").addClass("focus_1");
        $('#lintab1' + i).css({
            display: 'none'
        });
        $('#lintab1' + i + i).css({
            display: 'none'
        });
        $('#lintab1' + j).css({
            display: 'block'
        });
        $('#lintab1' + j + j).css({
            display: 'block'
        });
    });

    $('.suport_comment').click(function () {
        var id = $(this).next().val();
        var ip = $('#ip').val();
        if (ip == $.cookie('suport_comment' + id)) {
            alert('一天只能提交一次，您今天已经表达过您的观点了^^');
        }
        else {
            $.get('modelinfo.php?action=suportComment', {
                id: id
            }, function (data) {

                if (data == 1) {
                    alert('成功赞同!');
                    var count = parseFloat($('#suport_comment' + id).html()) + 1;
                    $('#suport_comment' + id).html(count);
                    $.cookie('suport_comment' + id, ip, {
                        expires: 1
                    });
                }
                else
                    alert('赞同失败！');
            });
        }
    });
});
function peizhi(i) {
    var mid = i;
    var htm = $("#pz0_" + i).html().length;

    if (htm == 0) {
        $("#pz0_" + i).css("display", "block");
        $.post("modelinfo.php?action=ajaxpeizhilist", {
            model_id: mid
        },
        function (data) {
            if (data == -4) {
            } else {
                var obj = eval('(' + data + ')');
                var pz0 = '';
                var pz = '';
                $.each(obj['pz_newss'], function (i, v) {

                    pz0 += "<dl><dt><img oldwidth=\"22\" oldheight=\"22\" onmouseover=\"zoom(this)\" onmouseout=\"this.width = this.getAttribute('oldwidth'); this.height = this.getAttribute('oldheight');\"  onerror = \"this.src='images/50x50.jpg'\" src='images/peizi/" + v[0] + "' ></dt><dd>" + v[1] + "</dd></dl>";
                })

                $.each(obj['pz_type'], function (i, v) {
                    $("#pz" + i + '_' + obj["mid"]).detach();
                    pz += "<ul class='lintab2_list lr" + i + "'style='display:none;' id='pz" + i + '_' + obj["mid"] + "'>";
                    $.each(v, function (ii, vv) {
                        pz += "<dl><dt><img  oldwidth=\"22\" oldheight=\"22\" onmouseover=\"zoom(this)\" onmouseout=\"this.width = this.getAttribute('oldwidth'); this.height = this.getAttribute('oldheight');\" onerror = \"this.src='images/50x50.jpg'\" src='images/peizi/" + vv[0] + "' ></dt><dd>" + vv[1] + "</dd></dl>"
                    })
                    pz += "</ul>";
                })
                $("#pz0_" + obj["mid"]).empty();
                $("#pz0_" + obj["mid"]).append(pz0);
                $("#pz0_" + obj["mid"]).after(pz);

            }

        })
    }

}

var oimage = null;
function zoom()
{
    if (arguments.length > 0)
        oimage = arguments[0];
    oimage.height += 1;
    oimage.width += 1;

}
function modelinfo_s(i) {
    window.open("modelinfo_s" + i + ".html");
}
function ajaxshangqing(i) {
    var priceid = i;
    var model_id = $("#modelcolor_id").val();
    var model_price = $("#model_price").val();
    var st22 = $("#st22").val();
    $.post("modelinfo.php?action=ajaxshangqing", {
        priceid: priceid,
        model_id: model_id,
        model_price: model_price,
        st22: st22
    },
    function (data) {
        if (data == -4) {

        } else {
            var obj = eval('(' + data + ')');
            if (obj['state'] == 8) {
                $("#price_state").html("停产在售");
            } else {
                $("#price_state").html("在售");
            }
            $("#bingo_price").html(obj['price']);
            $("#youhui_price").html(obj['youhui_price']);

            $("#lcprice").html(obj['lcprice'] + '万元');
            $("#gouzhi").html(obj['gouzhi'] + '元');
            $("#quanxian").html(obj['quanxian'] + '元');

            var a = $("#calculaor").attr("href").split("&");
            a.pop();
            var url = a.join("&");
            var href = url + "&price=" + obj['price'];
            $(".tcj_right").find('a').attr("href", href);
        }

    })
}

$(function () {
    var li1 = $(".v_content_nav .v_content_array");
    var window1 = $(".v_content .v_content_w");
    var left1 = $(".v_content .img_l");
    var right1 = $(".v_content .img_r");
    window1.css("width", li1.length * 181);

    var lc1 = 0;
    var rc1 = li1.length / 8;
    left1.click(function () {
        if (lc1 < 1) {
            return;
        }
        lc1--;
        rc1++;
        window1.animate({
            left: '+=230px'
        }, 1000);
    });
    right1.click(function () {
        if (rc1 <= 1) {
            return;
        }
        lc1++;
        rc1--;
        window1.animate({
            left: '-=230px'
        }, 1000);
    });

})// JavaScript Document