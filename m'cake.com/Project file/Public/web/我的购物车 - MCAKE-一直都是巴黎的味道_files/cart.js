var postIDs = [];//商品ID数组 注（MK-OT-1004-晶赞业务对接代码部署 ADD BY 赵成龙（jakie.zhao）2015-03-20  ）
var cart = {

    init: function() {

        E.ajax_get({
            action: 'cart',
            operFlg: 6,
            call: function( o ) {
                cart.display( o.data );
            }
        });

    },

    display: function( data ) {

        if ($(data.goods).length == 0) {
            E.refresh();
            return false;
        }

        var is_all_buy = 1;

        var html = '<table width="100%" border="0" cellspacing="0" cellpadding="0">';

        //var postIDs = [];//商品ID数组 注（MK-OT-1004-晶赞业务对接代码部署 ADD BY 赵成龙（jakie.zhao）2015-03-20）

        $.each(data.goods, function(k, goods) {
            postIDs.push(goods.postID);//向数组追加postID
            var fittings_text = '';
            if (goods.fittings) {
                $.each(goods.fittings, function(i, fittings) {
                    if (fittings.forsale == 1) {
                        return true;
                    }
                    if (fittings_text == '') {
                        fittings_text += fittings.fitName + fittings.quantity + fittings.unitName;
                    } else {
                        fittings_text += '&nbsp;&nbsp;' + fittings.fitName + fittings.quantity + fittings.unitName;
                    }
                });
            }


            html += '<tr>';

            html += '<td style="padding-left: 20px;" class="cartCheck">';
            html += '<span>';
            html += '<i></i>';
            if(goods.is_buy == 1){
                html += '<em class="cur"></em>';
            }else{
                is_all_buy = 0;
                html += '<em></em>';
            }
            html += '<input type="checkbox" hidden="hidden" name="id" value="'+ goods.postID +'" />';
            html += '</span>';
            html += '</td>';
            html += '<td class="pro_left">';
            html += '<div class="buy_pro_img">';
            html += '<img src="' + goods.img_link + '" width="114" height="114" alt="' + goods.goodsName + '"/>';
            html += '</div>';
            html += '<div class="aleft">';
            html += '<a href="' + goods.link + '" class="Grey"><b>' + goods.frenchName + '</b></a>';
            html += goods.goodsName + ' <br />';
            html += '<br />';
            if (fittings_text) {
                html += '赠品：' + fittings_text;
            }

            html += '</div>';
            html += '</td>';

            html += '<td width="10%">';
            html += '<div class="cake_num">' + goods.spec + '</div>';
            html += '<samp class="Grey">' + goods.edible + '</samp>';
            html += '</td>';

            /*
             if ($(goods.sync_array).length > 0) {
             html += '<td width="10%">';
             html += '<span class="butchery">';
             if (goods.choose_sync_id == 0) {
             html += '<samp>不切分</samp> <i></i>';
             } else {
             html += '<samp>' + goods.sync_array[goods.choose_sync_id] + '</samp> <i></i>';
             }
             html += '<ul>';
             html += '<li sync_id="0" index="' + k + '">不切分</li>';
             $.each(goods.sync_array, function(sync_id, sync) {
             html += '<li sync_id="' + sync_id + '" index="' + k + '">' + sync + '</li>';
             });
             html += '</ul>';
             html += '</span> ';
             html += '</td>';
             } else {
             html += '<td width="10%"><span class="butchery no_butchery"><samp>不切分</samp> <i></i></span></td>';
             }*/

            html += '<td width="10%">' + goods.price.toFixed(2) + '</td>';

            html += '<td width="10%">';
            html += '<div class="cake_num">';
            html += '<dl>';
            if (goods.goods_amount == 0) {
                html += '<dd class="n_left nopoint">-</dd>';
            } else {
                html += '<dd class="n_left">-</dd>';
            }
            html += '<dt><input type="text" value="' + goods.goods_amount + '" class="goods_amount" index="' + k + '"></dt>';
            if(goods.goods_amount >= 50){
                html += '<dd class="n_right nopoint">+</dd>';
            }else{
                html += '<dd class="n_right">+</dd>';
            }
            html += '</dl>';
            html += '</div>';
            html += '</td>';

            html += '<td width="10%">' + (goods.price * goods.goods_amount).toFixed(2) + '</td>';

            html += '<td width="10%"><a href="javascript: void(0);" class="Grey confirm_del" index="' + k + '">删除</a> <div class="pro_del_box"></div></td>';

            html += '</tr>';

        });

        html += '<tr class="border_top">';
        html += '<td colspan="7" class="Order_activity cartCheck">';
        html += '<span>';
        html += '<i></i>';

        if(is_all_buy == 1){
            html += '<em class="cur all_cur"></em>';
        }else{
            html += '<em class="all_cur"></em>';
        }

        html += '<input type="checkbox" hidden="hidden" />';
        html += '</span> 全选';
        html += '</td>';
        html += '</tr>';
        html += '</table>';

        $('#buy_car_list').html(html);

        G.cart.comm.get_amount("cart_amount");
        $('#total_amount').text(data.is_buy_total_amount);
        $('#total_money').text(' ￥' + data.is_buy_total_money.toFixed(2));
        if (data.is_buy_total_amount == 0) {
            $('#checkout').hide();
        }else{
            $('#checkout').show();
        }

    },

    //购物车商品删除
    pro_del:function(index){

        E.loadding.open('正在删除，请稍候...');
        E.ajax_get({
            action: 'cart',
            operFlg: 4,
            data: {
                index: index
            },
            call: function( o ) {
                E.loadding.close();
                if (o.code == 200) {
                    //G.cps.emar(o.data.goods, 'del_cart_goods');
                    cart.display( o.data.goods_list );
                    E.alert(o.message, 2);
                } else {
                    E.alert(o.message);
                }
            }
        });
    },

    //跳转至立刻购买
    nowbuy_login_go:function(){

        if(cart.errCount <= 1){
            self.location = G.args.nowbuy_login + '?act=cart';
        }else{
            cart.refresh_cart();
        }

    },

    //刷新购物车
    refresh_cart:function(){
        cart.init();
    }

};

if (is_init_cart) {
    cart.init();
}


$(window).ready(function() {

    $(document).on('click', '.butchery', function() {

        if ($(this).hasClass('no_butchery')) {
            return false;
        }

        $(this).find('ul').show();

    });

    $(document).on('click', '.butchery li', function(event) {

        event.stopPropagation();

        E.ajax_get({
            action: 'cart',
            operFlg: 7,
            data: {
                sync_id: $(this).attr('sync_id'),
                index: $(this).attr('index')
            },
            call: function( o ) {

            }
        });

        var butchery = $(this).parent().parent();
        butchery.find('samp').html($(this).html());
        butchery.find('ul').hide();

    });

    $(document).on('click', '.confirm_del', function(){

        var index = $(this).attr('index');

        var html = '<div class="del_confirm_box">';
        html += '<input type="button" class="btn_del" value="确定" onclick="cart.pro_del('+index+')">';
        html += '<input type="button" class="btn_del" value="取消">';
        html += '</div>';

        $(this).next().append(html);

        $(".pro_del_box input").on("click",function(){
            $(this).parents(".pro_del_box").empty();
        });

    });

    //加减按钮
    $(document).on('click', '.n_right', function() {

        var num = $(this).parent().find('.goods_amount');

        var oldValue=parseInt(num.val()); //取出现在的值，并使用parseInt转为int类型数据

        if(oldValue >= 50){
            $(this).addClass('nopoint');
            return false;
        }

        oldValue++;  //自加1

        num.val(oldValue);  //将增加后的值付给控件

        $('.n_left').removeClass('nopoint');

        E.ajax_get({
            action: 'cart',
            operFlg: 3,
            data: {
                index: num.attr('index'),
                goods_amount: oldValue
            },
            call: function( o ) {
                if (o.code == 200) {
                    //G.cps.emar(o.data.goods, 'add_cart_goods');
                    cart.display( o.data.goods_list );
                }
            }
        });

    });

    $(document).on('click', '.n_left', function() {

        if ($(this).hasClass('nopoint')) {
            return false;
        }

        if($(".n_right").hasClass('nopoint'))
            $(".n_right").removeClass('nopoint');

        var num = $(this).parent().find('.goods_amount');

        var oldValue=parseInt(num.val()); //取出现在的值，并使用parseInt转为int类型数据

        oldValue--;   //自减1

        if (oldValue == 0) {

            $(this).addClass('nopoint');
            return false;

        } else {

            num.val(oldValue);  //将增加后的值付给控件

            E.ajax_get({
                action: 'cart',
                operFlg: 3,
                data: {
                    index: num.attr('index'),
                    goods_amount: oldValue
                },
                call: function( o ) {
                    if (o.code == 200) {
                        //G.cps.emar(o.data.goods, 'add_cart_goods');
                        cart.display( o.data.goods_list );
                    }
                }
            });

        }

    });

    $('#continue_shopping').click(function() {
        self.location = G.args.domain;
    });


    $('#checkout').click(function() {

        E.loadding.open('正在检查购物车，请稍候...');
        E.ajax_get({
            action: 'cart',
            operFlg: 12,
            data: { },
            call: function( o ) {
                E.loadding.close();

                if(!o){
                    return false;
                }

                if(o.code == 200){
                    cart.errCount = o.data.errCount;
                }else{
                    cart.errCount = 0;
                }

                if(cart.errCount == 0){
                    cart.nowbuy_login_go();
                }else{
                    E.confirm(o.data.errMessage, "cart.nowbuy_login_go", "cart.refresh_cart");
                }
            }
        });

    });

    var temp_goods_amount = 0;
    $(document).on('focus', '.goods_amount', function() {
        temp_goods_amount = E.trim($(this).val());
    });

    //购物车商品选择/全选/全取消
    $(document).on('click', '.cartCheck em', function(){

        var id, sign;

        if($(this).hasClass('cur')){
            sign = 0;
            if($(this).hasClass('all_cur')){
                id = 0;
                $(".cartCheck em").removeClass('cur');
            }else{
                id = $(this).next('input').val();
                $(this).removeClass('cur');
            }
        }else{
            sign = 1;
            if($(this).hasClass('all_cur')){
                id = 0;
                $(".cartCheck em").addClass('cur');
            }else{
                id = $(this).next('input').val();
                $(this).addClass('cur');
            }
        }

        E.loadding.open('正在加载中，请稍候...');

        E.ajax_post({
            action:'cart',
            operFlg:11,
            data:{
                id:id,
                sign:sign
            },
            call:function(o){

                E.loadding.close();
                if(o.code == 200){
                    cart.init();
                }else{
                    E.alert(o.message);
                }
            }
        });

    });



    $(document).on('blur', '.goods_amount', function() {
        var goods_amount = E.trim($(this).val());
        if (goods_amount == temp_goods_amount) {
            return false;
        } else if (goods_amount > 50) {
            $(this).val(temp_goods_amount);
            return false;
        } else if (!E.isDigital(goods_amount)) {
            $(this).val(temp_goods_amount);
            return false;
        }
        var index = $(this).attr('index');
        var _this = this;
        if (goods_amount <= 0) {
            E.confirm('您确认要删除该商品吗？', function() {

                E.loadding.open('正在删除，请稍候...');
                E.ajax_get({
                    action: 'cart',
                    operFlg: 4,
                    data: {
                        index: index
                    },
                    call: function( o ) {
                        E.loadding.close();
                        if (o.code == 200) {
                            //G.cps.emar(o.data.goods, 'del_cart_goods');
                            cart.display( o.data.goods_list );
                            E.alert(o.message, 2);
                        } else {
                            E.alert(o.message);
                        }
                    }
                });

            }, function() {
                $(_this).val(temp_goods_amount);
            });
        } else {
            E.ajax_get({
                action: 'cart',
                operFlg: 3,
                data: {
                    index: index,
                    goods_amount: goods_amount
                },
                call: function( o ) {
                    if (o.code == 200) {
                        //G.cps.emar(o.data.goods, 'add_cart_goods');
                        cart.display( o.data.goods_list );
                    }
                }
            });
        }
    });
});

