$(function() {

    /*加入购物车，立即购买按钮经过效果*/
    $(".add_cart").hover(function(){
        //判断按钮是否可用
        if($(this).attr("class").indexOf("disable")>0)
            return false;
        $(this).val("Ajouter au panier");
    },function(){
        if($(this).attr("class").indexOf("disable")>0)
            return false;
        $(this).val("加入购物车");
    });

    $(".buy_now").hover(function(){
        if($(this).attr("class").indexOf("disable")>0)
            return false;
        $(this).val("Commander");
    },
    function(){
        if($(this).attr("class").indexOf("disable")>0)
            return false;
        $(this).val("立即购买");
    });

    // /*材料点评信息切换*/
    // $("ul.Select_view li").click(function(){
    //     var _index=$(this).index();
    //     $("ul.Select_view li,ul.view_list > li").removeClass("cur");
    //     $(this).addClass("cur");
    //     $("ul.view_list > li").eq(_index).addClass("cur");
    // });

    /*选择磅数*/
    $("ul.change_p li").click(function(){
        
        $(this).addClass("");
        G.goods.sizeChange($(this).attr('id').replace('size_id_', ''), 1);
    });

    //加减按钮
    $(".n_right").click(function(){
        //判断按钮是否可用
        if($(this).attr("class").indexOf("nopoint")>0)
            return false;
        var num = $('#buy_number');
        var oldValue = parseInt(num.val()); //取出现在的值，并使用parseInt转为int类型数据

        if(oldValue >= 49)
            $(this).addClass('nopoint');

        if(oldValue >= 50)
            return false;

        oldValue++;   //自加1
        num.val(oldValue);  //将增加后的值付给控件
        $(".n_left").removeClass("nopoint");
    });
    $(".n_left").click(function(){
        //判断按钮是否可用
        if($(this).attr("class").indexOf("nopoint")>0)
            return false;
        var num = $('#buy_number');
        var oldValue = parseInt(num.val()); //取出现在的值，并使用parseInt转为int类型数据
        oldValue--;   //自减1
        num.val(oldValue);  //将增加后的值付给控件
        $(".n_right").removeClass('nopoint');
        if ( num.val() < 2) {
            $(this).addClass("nopoint");
            num.val(1);
        }
    });

    //手动输入商品数量控制
    $(document).on('keyup', '#buy_number', function(){
        var value = E.trim($(this).val());
        if(!E.isInt(value) || value < 1)
            value = 1;

        if(value > 50)
            value = 50;

        $(this).val(value);
    });

    var temp_buy_number = 0;
    $('#buy_number').focus(function() {
        temp_buy_number = $(this).val();
    }).blur(function() {
        var buy_number = $(this).val();
        if (buy_number <= 0 || buy_number > 99) {
            $(this).val(temp_buy_number);
        }
    });


    /*鼠标经过产品*/
    // $(document).on("mouseover", ".image-grid li", function(){
    //     $(this).parent().find("div.mask").stop().animate({"bottom":"-55px"},100);
    //     $(this).find("div.mask").stop().animate({"bottom":"0px"});
    // }).on("mouseout", ".image-grid li", function(){
    //     $(this).find("div.mask").stop().animate({"bottom":"-55px"},100);
    // });


    /* 图片放大镜 */
    // $('.jqzoom').jqzoom({
    //     zoomType: 'standard',
    //     lens:true,
    //     preloadImages: false,
    //     alwaysOn:false
    // });

//     //加入购物车
//     $('#add_cart').click(function() {
//         //判断按钮是否可用
//         if($(this).attr("class").indexOf("disable")>0)
//             return false;

//         var goods_amount = E.trim($("#buy_number").val());
//         if (!E.isDigital(goods_amount)) {
//             goods_amount = 1;
//         }
//         G.cart.general.add($("#pro_id").val(), goods_amount);
//     });

//     //立即购买
//     $('#buy_now').click(function() {
//         //判断按钮是否可用
//         if($(this).attr("class").indexOf("disable")>0)
//             return false;
//         var goods_amount = E.trim($("#buy_number").val());
//         if (!E.isDigital(goods_amount)) {
//             goods_amount = 1;
//         }
//         G.cart.now_buy($("#pro_id").val(), goods_amount);
//     });

// });


G.goods.init = function() {
    E.ajax_get({
        action: "goods",
        operFlg: 2,
        data: {
            id: this.postID
        },
        call: "G.goods.display"
    });
    if(G.goods.useFlg==2){
        //增减按钮样式处理
        $(".n_right,.n_left").addClass("nopoint");
        //数量0
        $("#buy_number").attr("disabled","disabled").val(0);
        //立即购买和加入购物车按钮样式处理
        $(".add_cart,.buy_now").addClass("disable");
        $("#buy_now").val("已售罄");
    }
}

G.goods.display = function( o ) {

    if (o.code == 200) {

        if (o.data.goodsList.length == 1) {

            $("body").append("<input type='hidden' value='0' id='size_id_" + this.postID + "' />");
            $("#size_id_" + this.postID).data(o.data.goodsList[0]);
            this.sizeChange(this.postID, 0);

        } else {

            var id = "";
            $.each(o.data.goodsList, function(k, v) {
                if (v.useFlg == 1) {
                    if (id == "" || v.postID == G.goods.postID)
                        id = v.postID;
                    $("#size_id_" + v.postID).data(v);
                } else {
                    //MK-FUN-1018-MCAKE-商品售罄功能 add by jackie.zhao Start
                    if (id == "" || v.postID == G.goods.postID)
                        id = v.postID;
                    $("#size_id_" + v.postID).data(v);
                    //MK-FUN-1018-MCAKE-商品售罄功能 add by jackie.zhao End
                    $("#size_id_" + v.postID).addClass("stockout");
                }
            });
            if (id != "") {
                this.sizeChange(id, 1);
            } else {
                $("#addCart").text("当前商品已下架或库存不足，请选择其他商品").addClass("empty");
            }

        }

        $('#comments_count').html('累计点评(' + o.data.comment_count + ')');

        if (o.data.comment_item) {
            $.each(o.data.comment_item, function(k, v) {
                if (k == 1) {
                    var item = '非常好吃';
                } else if (k == 2) {
                    var item = '配送服务好';
                } else if (k == 3) {
                    var item = '口感细腻';
                } else if (k == 4) {
                    var item = '清甜可口';
                } else if (k == 5) {
                    var item = '蛋糕很漂亮';
                }
                $('.Review_top').find('dl').append('<dd><a href="javascript: void(0);" onclick="G.goods.commentForItem(' + k +', 1);">' + item + '<span>(' + v +')</span></a></dd>');
            });
        }

    }

}

G.goods.init();

G.goods.sizeChange = function( id, flg ) {

    $("#size_id_" + id).addClass("cur");
    $("#size_id_" + id).siblings('li').removeClass("cur");

    var obj = $("#size_id_" + id);
    var dt = obj.data();

    //商品销售状态
    var useFlg = dt.useFlg;
    //判断销售状态
    if(useFlg != 1){
        //增减按钮样式处理
        $(".n_right,.n_left").addClass("nopoint");
        //数量0
        $("#buy_number").attr("disabled","disabled").val(0);
        //立即购买和加入购物车按钮样式处理
        $(".add_cart,.buy_now").addClass("disable");
        $("#buy_now").val("已售罄");
    }else{
        //增减按钮样式处理
        $(".n_right").removeClass("nopoint");
        //数量1
        $("#buy_number").attr("disabled",false).val(1);
        //立即购买和加入购物车按钮样式处理
        $(".add_cart,.buy_now").removeClass("disable");
        $("#buy_now").val("立即购买");
    }

    $("#price").text(parseFloat(dt.price).toFixed(2));
    $("#pro_id").val(dt.postID);
    $('#g_edible').text(obj.attr('edible'));
    $('#g_size').text(obj.attr('size'));
    $('#g_aheadTime').text(obj.attr('aheadTime'));

    if (dt.promotion || dt.bill) {
        var html = "";
        if (dt.promotion) {
            $.each(dt.promotion, function(k, v) {
                if (html != "")
                    html += "， ";
                html += v.remark
            });
        }
        if (dt.bill) {
            $.each(dt.bill, function(k, v) {
                if (html != "") {
                    html += "， ";
                }
                html += v.remark
            });
        }
        $("#promotionInfo").html(html).show();
    } else {
        $("#promotionInfo").html("").hide();
    }

}

G.goods.comment = function( page ) {
    E.ajax_get({
        action: 'goodsComment',
        operFlg: 1,
        data: {
            twoPostID: this.twoPostID,
            page: page
        },
        call: function( o ) {
            if (o.code == 200) {
                var html = '';
                $.each(o.data.comment, function(k, v) {
                    html += '<li>';
                    html += '<p class=\'com_txt\'>';
                    html += v.comment_content;
                    html += '</p>';
                    html += '<div><p><span>' + v.creator + '</span></p><small>' + v.createTime + '</small></div>';
                    html += '</li>';
                });
                $('#comment_list').html(html);
                $('#paging').html(o.data.paging);
            } else {
                $('.Review_top').hide();
                $('#comment_list').html('<li>暂无点评</li>');
                $('#paging').hide();
            }
        }
    });
}

G.goods.comment(1);


G.goods.commentForItem = function( item, page ) {

    E.ajax_get({
        action: 'goodsComment',
        operFlg: 4,
        data: {
            twoPostID: this.twoPostID,
            item: item,
            page: page
        },
        call: function( o ) {
            if (o.code == 200) {
                var html = '';
                $.each(o.data.comment, function(k, v) {
                    html += '<li>';
                    html += v.comment_content;
                    html += '<div><p><span>' + v.creator + '</span></p><small>' + v.createTime + '</small></div>';
                    html += '</li>';
                });
                $('#comment_list').html(html);
                $('#paging').html(o.data.paging);
            }
        }
    });

}

