//mod
//订单提交临时数据容器
var bill_data = { }

var checkout = {

    //配送时间
    delivery_time:{ },

    //配送时间选择标志
    is_delivery_time:0,

    //选择支付方式标志
    is_payTypeID:0,

    //发票
    invoice:0,

    //优惠券成本
    coupon_cost:0,

    //是否异地付款
    other_address_pay:0,

    //订单应收金额
    total_receivable_money:0,

    //使用了优惠抵扣方法数量
    couponTypeSign:0,

    //卡是否开发票
    card_is_invoice: 1,

    //支付方式名称
    payTypeName: '',

    //付现方式名称
    paymentName: '',

    /**
     * 支付状态记录
     * pay_type1_1=>货到付款现金支付  pay_type1_2=>刷卡支付  pay_type1_1=>信用卡支付
     * pay_type2_1=>支付宝银行支付  pay_type2_2=>预付费支付
     */
    pay_type_:'',

    init:function() {

        E.ajax_post({
            action: 'checkout',
            operFlg: 1,
            data:{
                act: checkout_args.act,
                buy_log: checkout_args.buy_log
            },
            call: function( o ) {
                if(o.code == 200){

                    checkout.deliveryTime.getDeliveryTime();

                    var  data = o.data;
                    var log = data.log;
                    if(data.deliver){

                        checkout_args.buy_log.deliverID = log.deliverID;

                        $.each(data.deliver,function(k, v){

                            //显示收货地址
                            checkout.deliver.createList(v);

                        });

                        if (data.send) {

                            //配送区域ID
                            checkout_args.buy_log.send_region_id = log.send_region_id;

                            var is_match = 0;
                            var freight = 0;
                            $.each(o.data.send, function(k, v) {
                                is_match = v.is_match;
                                freight = v.freight;
                            });
                            if (is_match == 0) {
                                $('.deliver-line-' + log.deliverID).find('.notice').html(' 超出配送范围');
                            } else if (freight > 0) {
                                $('.deliver-line-' + log.deliverID).find('.notice').html(' 需加收服务费' + freight + '元');
                            }

                            if(data.pay){

                                checkout_args.buy_log.payTypeID = data.payTypeID;
                                checkout_args.buy_log.pay_type = data.pay_type;

                                //显示支付方式
                                checkout.pay.createList(data.pay);

                            }
                        }
                    }

                } else {
                    E.alert(o.message);
                }

            }
        });

    },

    //计算总金额
    totalCount:function(){

        E.ajax_post({
            action: 'checkout',
            operFlg: 10,
            data: {
                act: checkout_args.act
            },
            call: function( o ) {

                if(o.code == 200){
                    var total = o.data;

                    checkout.payTypeName = total.payTypeName;
                    checkout.paymentName = total.paymentName;
                    checkout.coupon_cost = 0;

                    //更新积分使用
                    if(total.bill_points_money > 0){
                        $("#cancel_use_points").show();
                    }else{
                        $("#cancel_use_points").hide();
                    }

                    //更新现金券使用
                    if($(total.use_card_list).length > 0){
                        var html = '<ul class="card_use_list">';
                        $.each(total.use_card_list,function(k, v){
                            html += '<li>';
                            html += '卡号' + v.card_no + ' , ' + v.card_name + ' , 抵扣金额:' + parseFloat(v.deducation).toFixed(2);
                            html += '<a href="javascript:void(0);" onclick="checkout.card.del(\''+ v.card_pwd +'\')">&nbsp;&nbsp;<small> 取消</small></a>';
                            html += '</li>';
                        });
                        html += '</ul>';
                        $("#card_pwd").parents('.card_box').siblings('.card_err').html('').hide();
                        $(".card_err").siblings('.card_use_list').remove();
                        $(".card_err").after(html);
                    }else{
                        $(".card_err").siblings('.card_use_list').remove();
                    }

                    //更新商品价格
                    if($(total.goods).length > 0){
                        $.each(total.goods, function(k, v){
                            var goods_price = parseFloat(v.price).toFixed(2);
                            var total_goods_price = parseFloat(goods_price* v.goods_amount).toFixed(2);
                            $("#line_goods_"+ v.postID).find('.goods_price').html(goods_price);
                            $("#line_goods_"+ v.postID).find('.goods_total_price').html(total_goods_price);
                        });
                    }

                    //更新优惠券使用
                    if($(total.use_coupon_list).length > 0){
                        var coupon_html = '';
                        var redbag_html = '';
                        $.each(total.use_coupon_list, function(k, v){
                            //券
                            if(v.useType == 1){
                                coupon_html += '<p>已使用了优惠券<span style="color: red;">'+ v.couponName +'</span>&nbsp;抵扣金额:￥'+ v.amount;
                                coupon_html += '<a href="javascript:void(0);" onclick="checkout.coupon.delCoupon(\''+ v.code +'\')">&nbsp;&nbsp;<small> 取消</small></a>';
                                coupon_html += '</p>';
                            }
                            //红包
                            if(v.useType == 2){
                                redbag_html += '<p>已使用了红包<span style="color: red;">'+ v.couponName +'</span>&nbsp;抵扣金额:￥'+ v.amount;
                                redbag_html += '<a href="javascript:void(0);" onclick="checkout.coupon.delCoupon(\''+ v.code +'\')">&nbsp;&nbsp;<small> 取消</small></a>';
                                redbag_html += '</p>';
                            }

                            checkout.coupon_cost = Math.round(parseFloat(v.cost) + parseFloat(checkout.coupon_cost)).toFixed(2);

                        });
                        $(".use_redbag").siblings().remove();
                        $(".use_coupon").siblings().remove();
                        $(".use_redbag").after(redbag_html);
                        $(".use_coupon").after(coupon_html);
                    }else{
                        $(".use_redbag").siblings().remove();
                        $(".use_coupon").siblings().remove();
                    }

                    //更新商品促销活动
                    $('div[class^=goods_promotion_]').html('');
                    $.each(total.goods_promotion, function(k, v){
                        if(v) $(".goods_promotion_"+k).html(v);
                    });

                    //更新订单促销
                    if(total.bill_promotion && !$.isEmptyObject(total.bill_promotion)){
                        var bill_promotion_info = '订单活动:'+total.bill_promotion+'<i></i>';
                        $(".goods-bottom-right").html(bill_promotion_info).parents('.border_top').show();
                    }else{
                        $(".goods-bottom-right").parents('.border_top').hide();
                    }

                    //会员等级折扣
//                    if(total.rate > 0){
//                        var rank = total.rank;
//                        var rate = total.rate+'折';
//                        var cut_rebate_money = '- ' + parseFloat(total.cut_rebate_money).toFixed(2);
//
//                    }else{
//                        var rank = total.rank;
//                        var rate = '';
//                        var cut_rebate_money = '0.00';
//
//                    }

//                    if(total.rate < 10){
//                        $("#rate").html('<strong>LV'+ rank +'会员'+ rate +'：</strong>');
//                        $("#cut_rebate_money").html(cut_rebate_money);
//                        $("#rate").parent().show();
//                    }else{
//                        $("#rate").parent().hide();
//                    }

                    $("#bill_totalPaid").text('￥'+parseFloat(total.bill_totalPaid).toFixed(2));

                    //运费
                    if(total.deliver_feePaid > 0){
                        $("#deliver_feePaid").text('+ '+parseFloat(total.deliver_feePaid).toFixed(2));
                    }else{
                        $("#deliver_feePaid").text(parseFloat(total.deliver_feePaid).toFixed(2));
                    }

                    //配件费
                    if(total.bill_accessories_money > 0){
                        $("#bill_accessories_money").text('+ '+parseFloat(total.bill_accessories_money).toFixed(2));
                    }else{
                        $("#bill_accessories_money").text(parseFloat(total.bill_accessories_money).toFixed(2));
                    }

                    //抵扣抵用
                    if(total.discount_money > 0){
                        $('#discount_money').text('- '+parseFloat(total.discount_money).toFixed(2));
                    }else{
                        $('#discount_money').text(parseFloat(total.discount_money).toFixed(2));
                    }

                    //积分
                    if(total.bill_points_money > 0){
                        $("#bill_points_money").text('- '+parseFloat(total.bill_points_money).toFixed(2));
                    }else{
                        $("#bill_points_money").text(parseFloat(total.bill_points_money).toFixed(2));
                    }

                    //优惠券
                    if(total.bill_coupon_money > 0){
                        $("#bill_coupon_money").text('- '+parseFloat(total.bill_coupon_money).toFixed(2));
                    }else{
                        $("#bill_coupon_money").text(parseFloat(total.bill_coupon_money).toFixed(2));
                    }

                    //现金券
                    if(total.bill_card_money > 0){
                        $("#bill_card_money").text('- '+parseFloat(total.bill_card_money).toFixed(2));
                    }else{
                        $("#bill_card_money").text(parseFloat(total.bill_card_money).toFixed(2));
                    }

                    if(checkout.is_payTypeID)
                        checkout.card_is_invoice = total.card_is_invoice;

                    //开票提醒：应收金额不为0，使用了现金券、积分、优惠券等抵扣方式
                    if(total.bill_card_money > 0 || total.bill_coupon_money > 0 || total.bill_points_money > 0 || total.discount_money > 0){
                        checkout.couponTypeSign = 1;
                    }else{
                        checkout.couponTypeSign = 0;
                    }

                    var invoiceText = '';

                    if(total.total_receivable_money == 0 && checkout.couponTypeSign > 0){
                        invoiceText = '(使用现金券、积分、优惠券等抵扣方式后，您的实付金额为0元，不能开具发票)';
                    }else if(total.total_receivable_money > 0 && checkout.couponTypeSign > 0){
                        invoiceText = '(发票金额仅限实付款部分，用现金券、积分、优惠券等抵扣部分不纳入发票金额内)';
                    }

                    if(checkout.card_is_invoice == 0)
                        invoiceText = '你选择使用的'+ checkout.payTypeName + ' ' + checkout.paymentName +'支付方式，不能开具发票';


                    if((total.total_receivable_money == 0 && checkout.coupon_cost <= 0 )|| checkout.card_is_invoice == 0){
                        $(".other em").removeClass('em');
                        $(".other em").removeClass('cur');
                        $(".Invoice").hide();
                    }else{
                        $(".other em").addClass('em');
                        if(checkout.invoice > 0){
                            $(".other em").addClass('cur');
                            $(".Invoice").show();
                        }

                    }

                    $(".Invoicebox").find(".Invoicebox_ys").html(invoiceText);

                    //去零取整
                    $('#erase_money').text('- '+parseFloat(total.erase_money).toFixed(2));

                    //应收金额
                    $("#total_receivable_money").text('￥'+parseFloat(total.total_receivable_money).toFixed(2));

                    //发票金额
                    $("#total_kaipiao_money").text('￥'+Math.round(parseFloat(total.total_receivable_money) + parseFloat(checkout.coupon_cost)).toFixed(2));

                    checkout.total_receivable_money = total.total_receivable_money;

                }else{
                    E.alert(o.message);
                }
            }
        });

    },

    fittings:{

        //购买配件(单个配件)
        buy_fittings:function(postID, index,fitid, buyNum, price){
        	
            bill_goods[postID][index]['fit'][fitid]['buyNum'] = buyNum;
        	
            //mod by yim.hu FUN-BK-0009  修改数量 start
            //bill_goods[postID][index]['fit'][fitid]['buyMoney'] = parseFloat(buyNum*price).toFixed(2);
            bill_goods[postID][index]['fit'][fitid]['buyMoney'] = price;
            //mod by yim.hu FUN-BK-0009  修改数量 start
            E.loadding.open('正在努力加载中，请稍后...');
            E.ajax_post({
                action:'checkout',
                operFlg:13,
                data:{
                    act: checkout_args.act,
                    postID:postID,
                    indexKey:index,
                    fit:bill_goods[postID][index]['fit']
                },
                call:function(o){
                    E.loadding.close();
                    if(o.code == 200){
                        checkout.totalCount();
                        dialog_open.close();
                    }else{
                        E.alert(o.message);
                    }
                }
            });

        }
    },

    pay:{

        createList:function(data){

            //货到付款
            var pay_1 = '';

            //在线支付
            var pay_2 = '';
            pay_2 += '<p class="pay_type2_p1" style="float: left"><samp>支付宝及银行支付</samp></p>';
            pay_2 += '<p class="pay_type2_p2"><samp style="margin-left: 10px;">预付费卡支付</samp></p>';
            pay_2 += '<ul class="pay_list">';

            var payment1 = 0;//货到付款
            var payment1_1 = 0;//现金支付
            var payment1_2 = 0;//刷卡支付
            var payment1_3 = 0;//信用卡支付

            var payment2 = 0;//在线支付
            var payment2_1 = 0;//支付宝及银行支付
            var payment2_2 = 0;//预付费卡支付

            $.each(data,function(k,v){

                $.each(v.list,function(ke,va){
                    //货到付款
                    if(v.type == 1){
                        if(va.list){
                            var cash = '';
                            var slotCard = '';
                            var sloCardFlg = 0;
                            var type1 = 0;
                            var type2 = 0;
                            var type3 = 0;
                            $.each(va.list,function(key, val){

                                //现金支付
                                if(val.type == 1){
                                    cash += '<p class="pay_append pay_type1_p1" style="float: left"><samp onclick="checkout.pay.choosePay('+ val.payTypeID + ',' + val.id +')">'+ val.name +'</samp></p>';
                                    type1++;
                                    payment1_1++;
                                }
                                if(val.type == 2 && type2 == 0){
                                    cash += '<p class="pay_append pay_type1_p2" style="float: left"><samp style="margin-left: 10px;">刷卡支付</samp></p>';
                                    type2++;
                                    payment1_2++;
                                }
                                if(val.type == 3 && type3 == 0){
                                    cash += '<p class="pay_append pay_type1_p3"><samp style="margin-left: 10px;">信用卡支付</samp></p>';
                                    type3++;
                                    payment1_3++;
                                }

                                //刷卡
                                if(val.type == 2 || val.type == 3){
                                    if(sloCardFlg == 0){
                                        slotCard += '<ul class="pay_list pay_append">';
                                    }
                                    if(val.type == 2){
                                        slotCard += '<li class="pay_type1_2">';
                                    }else if(val.type == 3){
                                        slotCard += '<li class="pay_type1_3">';
                                    }
                                    slotCard += '<img width="110" height="30" onclick="checkout.pay.choosePay('+ val.payTypeID + ',' + val.id +',\''+ val.name +'\')" src="'+ val.logo_img +'" class="img-rounded" title="'+ val.name +'" alt="'+ val.name +'"/>';
                                    slotCard += '</li>';
                                    sloCardFlg++;
                                }

                            });
                            if(sloCardFlg > 0){
                                slotCard += '</ul>';
                            }
                            pay_1 += cash + slotCard;
                            payment1++;
                        }
                    }
                    //在线支付
                    if(v.type == 2){
                        if(va.payment_platform == 1 || v.payment_platform == 2){
                            pay_2 += '<li class="pay_type2_1">';
                            payment2_1++;
                        }else{
                            pay_2 += '<li class="pay_type2_2">';
                            payment2_2++;
                        }
                        pay_2 += '<img width="110" height="30" onclick="checkout.pay.choosePay('+ va.payTypeID + ',0)" src="'+ va.logo_img +'" class="img-rounded" alt="'+ va.payTypeName +'"/>';
                        pay_2 += '</li>';
                        payment2++;
                    }

                })
            });

            pay_2 += '</ul>';

            $(".pay_append").remove();
            if(payment1>0){
                $("#pay_on_delivery").html(pay_1);
            }else{
                $("#pay_on_delivery").parent("li.Choice_pay").hide();
            }
            if(payment2>0){
                $("#pay_online").empty().html(pay_2);
            }else{
                $("#pay_online").parent("li.Choice_pay").hide();
            }

            if(payment1_1==0){$(".pay_type1_p1").hide();}
            if(payment1_2==0){$(".pay_type1_p2").hide();}
            if(payment1_3==0){$(".pay_type1_p3").hide();}
            if(payment2_1==0){$(".pay_type2_p1").hide();}
            if(payment2_2==0){$(".pay_type2_p2").hide();}

        },

        //选择支付方式
        choosePay:function(payTypeID, paymentID , paymentName){

            if(paymentID && paymentID == checkout_args.buy_log.payment_method_id){
                return false;
            }

            if(!paymentID && payTypeID == checkout_args.buy_log.payTypeID){
                return false;
            }

            E.loadding.open('正在努力加载中，请稍后...');

            E.ajax_post({
                action:'checkout',
                operFlg:12,
                data: {
                    act: checkout_args.act,
                    payTypeID:payTypeID,
                    paymentID: paymentID
                },
                call:function( o ){
                    E.loadding.close();
                    if(o.code == 200){
                        var log = o.data.log;
                        checkout_args.buy_log.payTypeID = log.payTypeID;
                        checkout_args.buy_log.pay_type = log.pay_type;
                        checkout_args.buy_log.payment_method_id = log.payment_method_id;
                        checkout.is_payTypeID = 1;
                        checkout.totalCount();
                        if(checkout_args.buy_log.payTypeID == 9)
                        {
                            $("#pay_type_title").html("货到付款 " + paymentName);
                        }
                        else
                        {
                            $("#pay_type_title").html("");
                        }


                    }else{
                        E.alert(o.message);
                    }
                }
            });
        }

    },

    deliver:{

        d_data:{ },

        createList:function(data){

            //是否站点自提
            if (data.type == 2) {
                var extract = '<samp class="Gold">[站点自提]&nbsp;</samp>';
            } else {
                var extract = '<samp class="Gold">'+ data.custName +'&nbsp;</samp>';
            }

            if (checkout.deliver.d_data[data.deliverID]) {

                //会员地址
                var address_list = '<label for="deliver-radio-'+ data.deliverID +'">' + extract + data.cityName + ' ' + data.countyName + ' ' + data.address + ' 手机：' +  data.mobile + '<font class="Gold notice"></font></label>';
                $(".deliver-line-"+data.deliverID).find('.address_content').html(address_list);

            } else {

                //是否是第一行  是第一行需要去除横线
                var noborder = '';
                var address_list_len = $(".address_list li").length;

                if(address_list_len < 2){
                    noborder = 'noborder';
                }

                //邮编
                var postalCode = '';
                if(data.postalCode){
                    postalCode = ' (邮编：'+data.postalCode+')';
                }

                //会员地址
                var address_list = extract + data.cityName + ' ' + data.countyName + ' ' + data.address + ' 手机：' +  data.mobile + postalCode + '<font class="Gold notice"></font>';

                var html = '<li class="'+ noborder +' deliver-line-'+ data.deliverID +'">';
                html += '<span>';
                html += '<i></i>';

                if(data.deliverID == checkout_args.buy_log.deliverID){
                    html += '<em class="cur" id="deliver-em-'+ data.deliverID +'"></em>';
                    html += '<input type="radio" id="deliver-radio-'+ data.deliverID +'" name="deliver_address" checked />';
                }else{
                    html += '<em id="deliver-em-'+ data.deliverID +'"></em>';
                    html += '<input type="radio" id="deliver-radio-'+ data.deliverID +'" name="deliver_address" />';
                }

                html += '</span>';
                html += '<span class="address_content" style="width: auto;">';
                html += '<label for="deliver-radio-'+ data.deliverID +'">' + address_list + '</label>';
                html += '</span>';
                html += '<div class="del_right">';

                if(data.is_default == 0 && checkout_args.login_status ==0)
                    html += '<a href="javascript:void(0)" class="d_default" onclick="checkout.deliver.set_default('+ data.deliverID +')">设为默认地址</a>';

                if(data.is_default == 1 && checkout_args.login_status ==0)
                    html += '<a href="javascript:void(0)" style="display: none;" class="d_default" onclick="checkout.deliver.set_default('+ data.deliverID +')">设为默认地址</a>';

                if(data.type == 2){
                    if(checkout_args.login_status ==0){
                        html += '<a href="javascript:void(0)" class="d_up" onclick="checkout.extract.alter.open('+ data.deliverID +')">修改</a>';
                    }
                }else{
                    if(checkout_args.login_status ==0){
                        html += '<a href="javascript:void(0)" class="d_up" onclick="checkout.deliver.alter.open('+ data.deliverID +')">修改</a>';
                    }
                }
                if(checkout_args.login_status ==0){
                    html += '<a href="javascript:void(0);" class="del" onclick="checkout.deliver.del.open('+ data.deliverID +')">删除</a>';
                }
                html += '</div></li>';

                $(".btn_li_box").before(html);

            }

            checkout.deliver.d_data[data.deliverID] = data;

        },

        choose:function( id ){

            if (checkout_args.buy_log.deliverID == id)
                return false;

            E.loadding.open('正在查询收货地址，请稍候...');

            E.ajax_post({
                action:'checkout',
                operFlg: 2,
                data: {
                    act: checkout_args.act,
                    deliverID: id,
                    buy_log: checkout_args.buy_log
                },
                call: function( o ){
                    E.loadding.close();

                    if(o.code == 200){

                        checkout.deliveryTime.getDeliveryTime();

                        var log = o.data.log;

                        $(".address_list li em").removeClass('cur');
                        $(".address_list li input").attr('checked',false);

                        $("#deliver-em-"+ log.deliverID).addClass('cur');
                        $("#deliver-radio-"+ log.deliverID).attr('checked', true);

                        //收货地址
                        checkout_args.buy_log.deliverID = log.deliverID;
                        if(o.data.send){

                            //配送区域ID
                            checkout_args.buy_log.send_region_id = log.send_region_id;

                            var is_match = 0;
                            var freight = 0;
                            $.each(o.data.send, function(k, v) {
                                is_match = v.is_match;
                                freight = v.freight;
                            });

                            $('.notice').html('');
                            if (is_match == 0) {
                                $('.deliver-line-' + log.deliverID).find('.notice').html(' 超出配送范围');
                            } else if (freight > 0) {
                                $('.deliver-line-' + log.deliverID).find('.notice').html(' 需加收服务费' + freight + '元');
                            }

                            if(o.data.pay && o.data.pay.length > 0){

                                checkout_args.buy_log.payTypeID = log.payTypeID;
                                checkout_args.buy_log.pay_type = log.pay_type;

                                //显示支付方式
                                checkout.pay.createList(o.data.pay);
                            }
                        }
                        checkout.totalCount();

                    }else{
                        E.alert(o.message);
                    }
                }
            });

        },

        del: {

            open: function( id ) {

                checkout.tempID = id;
                E.confirm("您确定要删除该收货地址吗？", "checkout.deliver.del.confirm");

            },

            confirm: function() {

                E.loadding.open("正在删除收货地址，请稍候...");
                E.ajax_get({
                    action:'deliver',
                    operFlg: 3,
                    data: {
                        id: checkout.tempID
                    },
                    call: function(o){

                        E.loadding.close()

                        if(o.code == 200){

                            delete checkout.deliver.d_data[checkout.tempID];
                            $('.deliver-line-' + checkout.tempID).remove();

                            if (checkout.tempID == checkout_args.buy_log.deliverID) {

                                var deliverID = '';
                                var d_flg = 0;
                                $.each(checkout.deliver.d_data, function(k, v) {
                                    if(d_flg == 0 || v.is_default == 1){
                                        deliverID = k;
                                    }
                                    d_flg++;
                                });

                                if (deliverID) {
                                    checkout.deliver.choose(deliverID);
                                }
                            }
                        }else{
                            E.alert(o.message);
                        }
                    }
                });
            }
        },

        alter:{

            //打开新增地址
            open:function(data){

                var html  = '';

                html +='<form id="address_form"><ul class="Remote_payment my_add">';
                html += '<li><p>使用新地址</p><div class="clear"></div></li>';
                html += '<li class="Payee_icon">';
                html += '<label for="custName"><i></i><font>收货人</font></label><input type="text" name="custName" class="input_t" value=""  id="custName"/><div class="clear"></div>';
                html += '</li>';
                html += '<li class="tel_icon">';
                html += '<label for="mobile"><i></i><font>手机号码</font></label>';
                html += '<input type="text" class="input_t" value="" name="mobile" id="mobile"/>';
                html += '<p class="Remind">*用于发送订单确认短信</p><div class="clear"></div>';
                html += '</li>';
                html += '<li>';
                html += '<div class="select_down add_txt" style="display: none;">';
                html += '<select id="province_list" name="provinceid" style="display: none;"><option value="0">请选择</option></select>';
                html += '</div>';
                html += '<div class="select_down add_txt">';
                html += '<select id="city_list" name="cityid" class="form-control"><option value="0">请选择</option></select>';
                html += '</div>';
                html += '<div class="select_down add_txt">';
                html += '<select id="county_list" name="countyid" class="form-control"><option value="0">请选择</option></select>';
                html += '</div><div class="clear"></div>';
                html += '</li>';
                html += '<li class="Address_icon">';
                html += '<label for="address"><i></i><font>详细地址</font></label><input type="text" name="address" class="input_t add_t" value="" id="address"/>';
                html += '<p class="delivery" style="float: left;color: #b0916a;" id="address_err"></p>';
                html += '<p class="delivery"><a href="/shop/article-48.html" target="_blank">查看配送说明</a></p>';
                html += '<div class="clear"></div>';
                html += '</li>';
                html += '<li class="btn_box">';
                html += '<input type="button" value="确认" onclick="E.region.shopAdd(\'address_form\',\'checkout.deliver.alter.addResult\')" class="login_btn newAddress"/>';
                html += '<input type="button" value="取消" onclick="dialog_open.close()"  class="login_btn close_btn"/>';
                html += '</li>';
                html += '</ul>';
                html += '<div class="my_add_right" style="position: relative">';
                html += '<div class="map" id="right_map" style="width: 364px;height: 380px;">';
                html += '</div>';
                html += '<ul>';
//del 20141124 sunqiang  FUN-BK-0034 运费规则调整 start    
//                html += '<li class="map_yelow"><i></i>区域免运费</li>';
//                html += '<li class="map_blue"><i></i>区域20元运费</li>';
//                html += '<li class="map_red"><i></i>区域30元运费</li>';
//del 20141124 sunqiang  FUN-BK-0034 运费规则调整 end    
                html += '</ul>';
                html += '</div>';
                html += '<input type="hidden" name="pcustID" value="' + checkout_args.pcustID + '">';
                html += '<input type="hidden" name="deliverID" id="deliverID" value="0">';
                html += '</form>';

                dialog_open.open({
                    width:730,
                    height:440,
                    content:html
                });

                mapMarker.M_type = 2;
                if(!data){      //新增地址
                    E.region.init({
                        pid: checkout_args.provinceid,
                        cid: checkout_args.cityid,
                        pShow: 'n',
                        cShow: 'n'
                    });

                    $('#custName').val(checkout_args.custname);
                    $('#mobile').val(checkout_args.mobile);

                    if(!E.empty(checkout_args.custname))
                        $('#custName').siblings('label').find('font').remove();

                    if(!E.empty(checkout_args.mobile))
                        $('#mobile').siblings('label').find('font').remove();
                    //add zan.yu 20141204 FUN-BK-0041-G7地址库平台接入---start
                     map.longitude="";
                     map.latitude="";
                    //add zan.yu 20141204 FUN-BK-0041-G7地址库平台接入---end

                }else{          //修改地址

                    var deliver_array = checkout.deliver.d_data[data];
                    $('#custName').val(deliver_array.custName);
                    E.region.init({
                        pid: deliver_array.provinceid,
                        cid: deliver_array.cityid,
                        ccid: deliver_array.countyid,
                        pShow: 'n',
                        cShow: 'n'
                    });

                    $('.my_add .input_t').siblings('label').find('font').remove();


                    $('#address').val(deliver_array.address);
                    $('#mobile').val(deliver_array.mobile);
                    $('#deliverID').val(deliver_array.deliverID);

                    mapMarker.M_address = $("#address").val();
                    mapMarker.M_city = $("#city_list").find('option:selected').text();
                    mapMarker.M_type = 1;
                    //add zan.yu 20141204 FUN-BK-0041-G7地址库平台接入---start
                    if(deliver_array!=undefined){
                        map.longitude=deliver_array.longitude;
                        map.latitude=deliver_array.latitude;
                    }
                    //add zan.yu 20141204 FUN-BK-0041-G7地址库平台接入---end
                }

                map.city_name = $("#city_list").find('option:selected').text();
                map.G_id = 'right_map';
                map.G_zoom = 10;
                //del 20141124 sunqiang  FUN-BK-0034 运费规则调整 start    
                //map.G_type = 2;
                //del 20141124 sunqiang  FUN-BK-0034 运费规则调整 end
                map.setMap();
                mapArea.search();

            },

            //新增收货地址回调
            addResult:function( o ){

                E.loadding.close();

                if (o.code == 200) {
                    dialog_open.close();
                    checkout.deliver.createList( o.data );
                    checkout_args.buy_log.deliverID = '';
                    checkout.deliver.choose(o.data.deliverID);
                } else {
                    E.alert(o.message);
                }

            }

        },

        //设置默认地址
        set_default:function(id){

            E.loadding.open('正在努力为您加载中...');
            E.ajax_post({
                action:'deliver',
                operFlg:5,
                data: {
                    id:id
                },
                call:function(o){

                    E.loadding.close();

                    if(o.code == 200){
                        $(".d_default").show();
                        $(".deliver-line-"+id).find('.d_default').hide();
                        checkout.deliver.choose(id);

                    }else{
                        E.alert(o.message);
                    }
                }
            });

        }
    },

    //自提网点
    extract:{

        tem_id : 0,

        alter:{

            //打开配送站列表
            open:function(deliverID){

                this.tem_id = deliverID;
                E.loadding.open('正在努力为您加载中...');
                E.ajax_post({
                    action:'checkout',
                    operFlg:3,
                    data: {
                        act: checkout_args.act,
                        buy_log: checkout_args.buy_log,
                        cityid: checkout_args.cityid
                    },
                    call: 'checkout.extract.alter.show'
                });

            },

            show:function(result_data){

                E.loadding.close();

                if(result_data.code == 200){

                    var html ='<div>';
                    html += '<form id="distributionForm">';
                    html += '<ul class="Remote_payment my_add">';
                    html += '<li>';
                    html += '<p>选择Mcake自提点：</p>';
                    html += '<span>收货不方便？<br /><font class="Gold">选择自提点收贷包裹，收到短信到自提点提货！</font></span>';
                    html += '<div class="clear">';
                    html += '<div class="clear"></div>';
                    html += '</li>';
                    //html += '<div style="max-height:272px;overflow-y:auto;">';

                    $.each(result_data.data, function(k, v){

                        html += '<li class="picke" id="distribution-'+ v.distribution_id +'">';
                        html += '<span>';
                        html += '<i></i>';
                        html += '<em></em>';
                        html += '<input type="radio" name="distribution_id" checked value="'+ v.distribution_id +'" address="'+ v.address +'" cityName="'+ v.cityName +'"/>';
                        html += '</span>';
                        html += '<p>';
                        html += '<span>'+ v.distribution_name +'：</span>';
                        html += '<samp>'+ v.address +'</samp>';
                        html += '</p>';
                        html += '<div class="clear"></div></li>';

                    });

                    //html += '</div>';
                    html += '<li class="Payee_icon"><label for="custName"><i></i><font>收货人</font></label>';
                    html += '<input type="text" class="input_t" name="custName" value="" id="custName"/>';
                    html += '<div class="clear"></div></li>';
                    html += '<li class="tel_icon"><label for="mobile"><i></i><font>手机号码</font></label>';
                    html += '<input type="text" class="input_t" name="mobile" value=""  id="mobile"/><p class="Remind">*用于发送订单确认短信</p>';
                    html += '<div class="clear"></div>';
                    html += '</li>';
                    html += '<li class="btn_box"></li></ul>';
                    html += '<input type="hidden" name="pcustID" value="' + checkout_args.pcustID + '">';
                    html += '<input type="hidden" name="deliverID" id="deliverID" value="0">';
                    html += '<input type="hidden" name="type" id="type" value="2">';
                    html += '</form></div>';
                    html += '<div class="my_add_right">';
                    html += '<div class="map" id="extract_map" style="width: 354px;height: 400px;"></div>';
                    html += '<div class="btn_box">';
                    html += '<input type="button" value="确认" class="login_btn newAddress" onclick="checkout.extract.alter.add()"/>';
                    html += '<input type="button" value="取消" class="login_btn close_btn" onclick="dialog_open.close()"/>';
                    html += '</div>';
                    html += '</div>';

                    //打开弹出层
                    dialog_open.open({
                        width:730,
                        height:540,
                        content:html
                    });

                    mapMarker.M_type = 2;

                    if(this.tem_id){    //修改自提点地址

                        tem_id = this.tem_id;
                        var deliver_array = checkout.deliver.d_data[tem_id];

                        $('.my_add .input_t').siblings('label').find('font').remove();
                        $('#custName').val(deliver_array.custName);
                        $("#distribution-"+deliver_array.distribution_id).find("input[type='radio']").attr('checked',true);
                        $("#distribution-"+deliver_array.distribution_id).find('em').addClass('cur');
                        $('#mobile').val(deliver_array.mobile);
                        $('#deliverID').val(deliver_array.deliverID);


                        var cityName = $("#distribution-"+deliver_array.distribution_id).find("input[type='radio']").attr('cityName');
                        var address = $("#distribution-"+deliver_array.distribution_id).find("input[type='radio']").attr('address');
                        mapMarker.M_address = address;
                        mapMarker.M_city = cityName;
                        mapMarker.M_type = 1;

                    }else{

                        $('#custName').val(checkout_args.custname);
                        $('#mobile').val(checkout_args.mobile);

                        if(!E.empty(checkout_args.custname))
                            $('#custName').siblings('label').find('font').remove();

                        if(!E.empty(checkout_args.mobile))
                            $('#mobile').siblings('label').find('font').remove();
                    }

                    map.city_name = checkout_args.cityname;
                    map.G_id = 'extract_map';
                    map.G_zoom = 10;
                    //del 20141124 sunqiang  FUN-BK-0034 运费规则调整 start    
                    //map.G_type = 1;
                    //del 20141124 sunqiang  FUN-BK-0034 运费规则调整 end
                    //add zan.yu 20141204 FUN-BK-0041-G7地址库平台接入---start
                    map.longitude="";
                    map.latitude="";
                    //add zan.yu 20141204 FUN-BK-0041-G7地址库平台接入---end
                    map.setMap();
                    mapArea.search();


                }else{
                    E.alert(result_data.message);
                }

            },

            add:function(){

                var id = "distributionForm";
                var dt = E.getFormValues(id), error_msg = '';

                //检验参数
                if(E.isEmpty(dt.distribution_id)){
                    error_msg += '配送站必须选择<br/>';
                }

                if(E.isEmpty(dt.custName)){
                    error_msg += '收货人不能为空<br/>';
                }

                if(E.isEmpty(dt.mobile)){
                    error_msg += '手机号不能为空<br/>';
                }

                if(!E.isEmpty(error_msg)){
                    E.alert(error_msg);
                    return false;
                }

                E.loadding.open('正在保存，请稍候...');

                E.ajax_post({
                    action: 'deliver',
                    operFlg: 2,
                    data: dt,
                    call: function(data){

                        E.loadding.close();
                        if(data.code == 200){

                            dialog_open.close();
                            checkout.deliver.createList( data.data );
                            checkout.deliver.choose(data.data.deliverID);
                        }else{
                            E.alert(data.message);
                        }
                    }
                });
            }
        }
    },

    deliveryTime:{

        selectSubmit:function(){

            var send_date = $("div.datelist_box ul.datelist li.cur").attr("data");
            var send_amp = $("#select_t_1 option:selected").val();
            var send_start_time = $("#select_t_2 option:selected").val();
            var send_end_time = $("#select_t_3 option:selected").val();

            if(!E.isEmpty(send_end_time) && send_end_time <= send_start_time){
                E.alert('时间段结束时间必须大于配送开始时间');
                return false;
            }

            $("#send_date").val(send_date);
            $("#send_amp").val(send_amp);
            $("#send_start_time").val(send_start_time);
            $("#send_end_time").val(send_end_time);
            $("#deliveryTime").html($("div.datelist_box").html());

            E.loadding.open('正在努力加载中,请稍后...');
            E.ajax_post({
                action:'checkout',
                operFlg:11,
                data:{
                    act: checkout_args.act,
                    send_date:send_date,
                    send_start_time:send_start_time,
                    send_end_time:send_end_time
                },
                call:function( o ){
                    E.loadding.close();
                    if(o.code == 200 ){
                        checkout.is_delivery_time = 1;


                    }else{
                        E.alert(o.message);
                    }
                }
            });
        },

        //获取配送时间
        getDeliveryTime:function(){

            E.ajax_post({
                action:'checkout',
                operFlg:4,
                data:{
                    act: checkout_args.act,
                    source: checkout_args.source
                },
                call: function(o){
                    if(o.code == 200){
                        //console.log('--------------------');
                        //console.log(o.data);

                        checkout.delivery_time = o.data;
                        checkout.totalCount()
                    }else{
                        E.alert(o.message);
                    }
                }
            });
        },

        //显示刷新配送时间
        timeDisplay:function( o ){
            checkout.delivery_time = o.data;
            var time_str = '',
                send_start_time = '',
                send_end_time = '';

            $.each(o.data.time,function(k, v){
                var selected = '';
                if(!E.empty(o.data.time_select)){
                    if(o.data.time_select == v){
                        selected = 'selected';
                    }
                }
                time_str += '<option value="'+ v +'" '+ selected +'>'+ v +'</option>';

            });

            var ST = '',
                ST_P = -1,
                warn = 0;   //爆单文案提醒

            $.each(o.data.send_start_time,function(k, v){
                var start_time = v.replace('(爆单)','');
                if(k == 0){
                    ST = start_time;
                    ST_P = v.indexOf('(爆单)');         //是否爆单标志
                    send_start_time += '<option value="'+ start_time +'" selected="selected">'+ v +'</option>';
                }else{
                    send_start_time += '<option value="'+ start_time +'">'+ v +'</option>';
                }
            })

            $.each(o.data.send_end_time,function(k, v){

                if(v > ST && ST_P > 0){
                    var start_time_obj = ST.split(':');
                    var twoHourTime = (parseInt(start_time_obj[0]) + 2).toString() + ':' + start_time_obj[1] + ':' + start_time_obj[2];
                    if(twoHourTime >= '22:00:00'){
                        warn = 1;
                        twoHourTime = '22:00:00';
                    }
                    if(v == twoHourTime && twoHourTime <= '22：00：00'){
                        send_end_time += '<option value="'+ v +'" selected="selected">'+ v +'</option>';
                    }else{
                        send_end_time += '<option value="'+ v +'">'+ v +'</option>';
                    }
                }

                if(v > ST && ST_P < 0){
                    send_end_time += '<option value="'+ v +'">'+ v +'</option>';
                }

            })

            checkout.change_time = o.data;

            $("#select_t_1").html(time_str);
            $("#select_t_2").html(send_start_time);
            $("#select_t_3").html(send_end_time);

            $("select").selectCss();

            if($("#select_t_2 option:selected").text().indexOf('(爆单)') > 0 && warn == 1 ){
                $("#hotSaleSign").show();
            }else{
                $("#hotSaleSign").hide();
            }

        },

        //自动选择自定义时间 add by jackie.zhao 2015-05-04
        autoSubmit:function(){

            var send_date = $("#send_date").val();
            var send_start_time = $("#send_start_time").val();
            var send_end_time = $("#send_end_time").val();

            E.loadding.open('正在努力加载中,请稍后...');
            E.ajax_post({
                action:'checkout',
                operFlg:11,
                data:{
                    act: checkout_args.act,
                    send_date:send_date,
                    send_start_time:send_start_time,
                    send_end_time:send_end_time
                },
                call:function( o ){
                    E.loadding.close();
                    if(o.code == 200 ){
                        checkout.is_delivery_time = 1;
                    }else{
                        E.alert(o.message);
                    }
                }
            });
        }

    },

    card:{

        open:function(){

            dialog_open.close();
            var html = '<ul class="Remote_payment Cash_coupon">';
            html += '<li><span style="padding:10px 0px;">选择您要使用的现金券种类</span></li>';
            html += '<li class="coupon_btn"><input type="button" value="现金卡" onclick="checkout.card.card_use(1)" class="login_btn Cash_card"/> ';
            html += '<input type="button" value="专享卡" onclick="checkout.card.card_use(2)" class="login_btn Exclusive_card"/></li>';
            html += '</ul>';
            dialog_open.open({
                width:410,
                height:250,
                content:html
            });
        },

        //现金卡
        card_use:function(type){

            dialog_open.close();

            var alertMsg = '';
            //现金卡
            if(type == 1){
                alertMsg = '请输入现金券密码';
            }

            //专享卡
            if(type == 2){
                alertMsg = '请输入专享卡密码';
            }

            var html = '<ul class="Remote_payment Cash_coupon">';

            html += '<li>';
            html += '<samp>';
            html += '<label for="card_pwd">'+ alertMsg +'</label>';
            html += '<input type="password" value="" class="input_t use_coupon_txt" name="card_pwd" value="" id="card_pwd"/>';
            html += '</samp>';
            html += '<input type="hidden" name="card_type" id="card_type" value="'+ type +'">';
            html += '<p class="card_err"></p>';
            html += '</li>';
            html += '<li class="coupon_btn">';
            html += '<input type="button" value="使用" class="login_btn Use_Cash_btn use_card_bt"/></li>';
            html += '</ul>';

            dialog_open.open({
                width:410,
                height:250,
                content:html
            });
        },

        del:function(data){

            var card_pwd = data;
            E.ajax_post({
                action:'checkout',
                operFlg:15,
                data: {
                    act: checkout_args.act,
                    card_pwd:card_pwd,
                    buy_log: checkout_args.buy_log,
                    source: checkout_args.source,
                    pcustID: checkout_args.pcustID
                },
                call:function(o){
                    if(o.code == 200 ){
                        checkout.totalCount();
                    }else{
                        E.alert(o.message);
                    }
                }
            });
        }
    },

    coupon:{

        //优惠券
        coupon_data:{ },

        //红包
        redBag_data:{ },

        //打开红包弹窗
        openRedBag:function(){

            //检测登陆状态
            if(!login_status.check()){
                return false;
            }

            var html = '';

            html += '<ul class="Remote_payment Cash_coupon">';
            html += '<li>';
            html += '<b class="red_box_t">选择要使用的红包</b>';
            html += '</li>';
            html += '<li>';
            html += '<form id="redCode">';
            html += '</form>';
            html += '</li>';
            html += '<li class="coupon_btn"> ';
            html += '<input type="button" value="使用" id="useRedBag" onclick="checkout.coupon.useRedBag()" class="login_btn"/>';
            html += '</li>';
            html += '</ul>';

            dialog_open.open({
                width:550,
                content:html
            });

            checkout.coupon.serachRedBag(1);

        },

        //打开优惠券弹窗
        openCoupon:function(){

            if(!login_status.check()){
                return false;
            }

            var html = '';

            html += '<ul class="Remote_payment Cash_coupon">';
            html += '<li><b>当前可使用的优惠券</b></li>';
            html += '<li id="coupon_list">';
            html += '</li>';
            html += '<li>';
            html += '<div>';
            html += '<label for="coupon_pass">输入优惠券编码</label>';
            html += '<input type="text" value="" class="input_t Discount_txt" id="coupon_pass"/>';
            html += '<input type="button" value="激活" onclick="checkout.coupon.useCoupon()" class="Discount_btn useCoupon"/>';
            html += '</div><p></p>';
            html += '</li>';
            html += '<li class="coupon_btn"><input type="button" value="使用" id="useCoupon" onclick="checkout.coupon.useCoupon()" class="login_btn"/> </li>';
            html += '</ul>';

            dialog_open.open({
                width:550,
                content:html
            });

            checkout.coupon.searchCoupon(1);

        },

        //查询红包列表
        serachRedBag:function(page){
            E.ajax_post({
                action:'checkout',
                operFlg:9,
                data:{
                    act: checkout_args.act,
                    pcustID: checkout_args.pcustID,
                    buy_log: checkout_args.buy_log,
                    page:page,
                    useType:2
                },
                call:function( o ){

                    if(o.code != 200){
                        $("#redCode").html('没有查到可用的红包');
                        return false;
                    }
                    var html = '<ul class="red_box_list">';
                    $.each(o.data.coupon,function(k, v){
                        if(v.useType == 2){
                            html += '<li class="picke">';
                            html += '<span>';
                            html += '<i></i>';
                            html += '<em></em>';
                            html += '<input type="checkbox" name="red_code" value="'+ v.code +'"/>';
                            html += '</span>';
                            html += '<p>'+ v.couponName +'      有效期至：'+ v.endDate +'</p>';
                            html += '</li>';
                        }
                    })
                    html += '</ul>';
                    html += o.data.paging;
                    $("#redCode").html(html);
                }
            });

        },

        //查询优惠券列表
        searchCoupon:function(page){
            E.ajax_post({
                action:'checkout',
                operFlg:9,
                data:{
                    act: checkout_args.act,
                    pcustID: checkout_args.pcustID,
                    buy_log: checkout_args.buy_log,
                    page:page,
                    useType:1
                },
                call:function( o ){

                    if(o.code != 200){
                        $("#coupon_list").html('没有查到可用的优惠券');
                        return false;
                    }
                    var html = '<ul class="Discount_list">';
                    $.each(o.data.coupon,function(k, v){
                        if(v.useType == 1){
                            html += '<li>';
                            html += '<a href="javascript:void(0)" onclick="checkout.coupon.codeAdd(\''+ v.code +'\')">';
                            html += '<span>'+ v.couponName +'</span>';
                            html += '<span>'+ v.endDate +'截止</span>';
                            html += '<samp>可使用</samp>';
                            html += '</a>';
                            html += '</li>';
                        }
                    })
                    html += '</ul>';
                    html += o.data.paging;
                    $("#coupon_list").html(html);
                }
            });
        },

        //使用券
        useCoupon:function(){

            //检测登陆状态
            if(!login_status.check()){
                return false;
            }

            code = $("#coupon_pass").val();
            E.ajax_post({
                action:'checkout',
                operFlg:7,
                data:{
                    act: checkout_args.act,
                    code:code,
                    pcustID: checkout_args.pcustID,
                    buy_log: checkout_args.buy_log
                },
                call:function(o){
                    if(o.code == 200){
                        checkout.totalCount();
                        dialog_open.close();
                    }else{
                        $("#coupon_pass").parent().siblings("p").html(o.message);
                    }
                }
            })
        },

        //使用红包
        useRedBag:function(){

            var dt = E.getFormValues("redCode");

            if($.isEmptyObject(dt.red_code)){
                E.alert('你没有选择要使用的红包');
                return false;
            }

            code = dt.red_code;
            E.ajax_post({
                action:'checkout',
                operFlg:16,
                data:{
                    act: checkout_args.act,
                    code:code,
                    pcustID: checkout_args.pcustID,
                    buy_log: checkout_args.buy_log
                },
                call:function(o){
                    if(o.code == 200){
                        var msg = '';
                        if(o.data){
                            $.each(o.data, function(k, v){
                                if(v.code != 200){
                                    msg += '红包' + v.red_code + ' ' + v.message + '<br/>';
                                }
                            })
                        }
                        if(!E.isEmpty(msg)){
                            E.alert(msg);
                        }
                        checkout.totalCount();
                        dialog_open.close();
                    }else{
                        E.alert('系统错误');
                    }
                }
            })
        },

        codeAdd:function(code){

            $(".Discount_txt").siblings('label').hide();
            $(".Discount_txt").val(code);

        },

        //取消使用优惠券
        delCoupon:function(code){

            E.ajax_post({
                action:'checkout',
                operFlg:17,
                data: {
                    act: checkout_args.act,
                    code:code,
                    source: checkout_args.source
                },
                call:function(o){
                    if(o.code == 200 ){
                        checkout.totalCount();
                    }else{
                        E.alert(o.message);
                    }
                }
            });
        },
        //检查是否使用现金卡、专享卡、提货卡
        checkUseCard:function(type){
            E.ajax_post({
                action:'checkout',
                operFlg:30,
                data: {
                    act: checkout_args.act
                },
                call:function(o){
                    if(o.code == 200 ){

                        switch (type){
                            case 'redbag':
                                checkout.coupon.openRedBag(1);
                                break;
                            case 'coupon':
                                checkout.coupon.openCoupon(1);
                                break;
                        }

                    }else{

                        var html = '<ul class="Remote_payment Cash_coupon Cash_coupon_2">';
                        html += '<li><span >对不起，您已使用现金卡，无法与券/红包同享，取消现金卡即可使用券/红包。</span></li>';
                        html += '<li><input type="button" value="确定" class="login_btn Exclusive_card"  onclick="dialog_open.close()"/></li>'
                        html += '</ul>';

                        dialog_open.open({
                            width:410,
                            height:250,
                            content:html
                        });

                    }
                }
            });
        }

    }


}


var login_status = {

    check:function(){

        if(checkout_args.login_status == 1){

            var html = '<ul class="Remote_payment quick_login">';
            html += '<li class="quick_txt" style="text-align: left;position: none;">设定密码</li>';
            html += '<li>';
            html += '<p class="warn">您的账号还没有设定过密码<br />不能使用积分、优惠券、红包</p>';
            html += '</li>';
            html += '<li class="coupon_btn">';
            html += '<input type="button" value="马上设定密码" onclick="login_status.setPwd()"  class="login_btn"/>';
            html += '</li>';
            html += '</ul>';

            $.My_order(html);
            return false;

        }else if(checkout_args.login_status == 2){

            var html = '<form id="login_form" name="login_form"><ul class="Remote_payment quick_login">';
            html += '<li class="quick_txt" style="text-align: left;">快速登录</li>';
            html += '<li class="import" style="height: 50px">';
            html += '<label for="loginName">手机号码</label>';
            html += '<input type="text" class="input_txt user_icon" name="loginName" id="loginName" disabled="disabled" value="'+ checkout_args.custID +'" />';
            html += '</li>';
            html += '<li class="import" style="height: 50px">';
            html += '<label for="loginPwd">请输入密码</label>';
            html += '<input type="password" class="input_txt password_icon" name="loginPwd" id="loginPwd" value=""/>';
            html += '<li style="height: 50px">';
            html += '<p class="warn err" id="loginName_error">积分、现金券、红包、优惠券需要登陆后才能使用!</p>';
            html += '<p class="warn err" id="loginPwd_error"></p>';
            html += '</li>';
            html += '<li class="coupon_btn">';
            html += '<input type="button" value="马上登陆" onclick="login_status.quickLogin()" class="login_btn"/>';
            html += '</li>';
            html += '<li class="link_c">';
            html += '<a href="' + G.args.cart + '" class="Grey">返回购物车</a>';
            html += '&nbsp;&nbsp;&nbsp;&nbsp;<a href="'+ G.args.getPwd +'" class="Grey">忘记密码 ?</a>';
            html += '</li>';
            html += '</ul></form>';

            $.My_order(html);
            return false;

        }else{

            return true;
        }

    },

    //设定密码
    setPwd:function(){

        var html = '<form id="get_pwd_form" onsubmit="return false;">';
        html += '<ul class="Remote_payment quick_login">';
        html += '<li class="quick_txt">设定密码</li>';
        html += '<li class="import">';
        html += '<label for="mobile">手机号码</label>';
        html += '<input type="text" class="input_txt user_icon" id="mobile" name="mobile" disabled="disabled" value="'+ checkout_args.mobile +'" />';
        html += '</li>';
        html += '<li class="import">';
        html += '<label for="smsyzm">手机验证码</label>';
        html += '<input type="text" class="input_txt Mobile_code_icon" style="width:115px" id="smsyzm" name="smsyzm" />';
        html += '<div class="send">';
        html += '<a href="javascript: void(0);" class="go" id="sms_btn" onclick="send_sms();">发送验证码 <small>>></small></a>';
        html += '</div>';
        html += '</li>';
        html += '<li><p id="smsyzm_error" style="text-align: center;color: #c4c4c4;font-size: 12px;"></p></li>';
        html += '<li class="import">';
        html += '<label for="password">新密码</label>';
        html += '<input type="password" class="input_txt password_icon" id="new_pwd" name="new_pwd" />';
        html += '</li>';
        html += '<li class="import">';
        html += '<label for="Confirm_password">密码确认</label>';
        html += '<input type="password" class="input_txt Confirm_password_icon" id="re_new_pwd" name="re_new_pwd" />';
        html += '</li>';
        html += '<li>';
        html += '<p class="warn setPwd_err"></p>';
        html += '</li>';
        html += '<li class="coupon_btn">';
        html += '<input type="button" value="提交" class="login_btn" onclick="G.cust.setPwd(\'get_pwd_form\')" />';
        html += '</li>';
        html += '</ul>';
        html += '</form>';

        $.My_order(html);

    },

    //快速登录
    quickLogin:function(){

        var dt = E.getFormValues('login_form');

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
                E.loadding.close();
                if (o.code == 200) {
                    G.cust.set_cookie(o.data);
                    G.cust.show_IDENTIFIER('welcome');
                    checkout_args.login_status = 0;
                    $("#maximPanel").hide(300);
                    $("#maximPanel").remove();
                    $("#myCover").remove();
                } else {
                    if (o.code == 2) {
                        $("#loginPwd_error").text( o.message );
                    } else {
                        $("#loginName_error").text( o.message );
                    }

                }
            }
        });
    }

}

//地图区域
var mapArea = {

    areaBox: {},

    checkedBox: {},

    pathOverlay: function( area_obj ) {

        //设置多边形样式
        var polygon = new BMap.Polygon();
        polygon.setPath( area_obj.path );
        polygon.setStrokeColor(area_obj.colour);
        polygon.setFillColor(area_obj.colour);
        polygon.setStrokeOpacity(0.8);
        polygon.setFillOpacity(0.6);
        polygon.setStrokeWeight(1);
        polygon.setStrokeStyle('solid');
        map.G_map.addOverlay(polygon);

    },

    search:function(){
        E.ajax_post({
            action: 'mapAreaZoning',
            operFlg: 1,
            data: {
                cityID:checkout_args.cityid
            },
            call: 'mapArea.result'
        });
    },

    result:function(o){

        map.G_map.clearOverlays();

        if (o.code == 200) {

            $.each(o.data, function(k, v) {

                //运费
                if(k == map.G_type){

                    $.each(v, function(i, j) {

                        var points_array = new Array();

                        $.each(j.path, function(x, y) {

                            points_array[x] = {
                                //mod by allen.qiang 20150422 坐标数据类似改为 浮点数 --start
                                lat: parseFloat(y.latitude),
                                lng: parseFloat(y.longitude)
                                //mod by allen.qiang 20150422 坐标数据类似改为 浮点数 --end
                            };

                        });

                        mapArea.areaBox[j.areaID] = {
                            path: points_array,
                            colour: j.colour,
                            areaID: j.areaID,
                            areaName: j.areaName,
                            type: j.type,
                            areaCode: j.areaCode
                        };
                        mapArea.checkedBox[j.areaID] = 1;

                        if (mapArea.checkedBox[j.areaID]) {
                            mapArea.pathOverlay( mapArea.areaBox[j.areaID] );
                        }
                    });
                }

            });

            if(mapMarker.M_type == 1){
                mapMarker.setMarker();
            }

        }
    }

}

/**
 * 设置标点覆盖物类
 * @type {{M_marker: {}, M_address: string, M_city: string, M_zoom: number, setMarker: Function}}
 * 根据地理位置获取和设置
 */
var mapMarker = {

    M_marker:{ },

    M_address:'',

    M_city:'',

    M_zoom: 12,

    M_type:0,

    setMarker:function(){

//        map.G_map.clearOverlays();

        mapMarker.M_marker = new BMap.Geocoder();

        //mod zan.yu 20141204 FUN-BK-0041-G7地址库平台接入---start
        if(map.longitude==""||map.latitude==""||map.longitude==null||map.latitude==null){ //如果地址的经纬度没有则调用百度
            // 将地址解析结果显示在地图上,并调整地图视野
            mapMarker.M_marker.getPoint(mapMarker.M_address, function(point){
                if (point) {
                    map.G_map.centerAndZoom(point, mapMarker.M_zoom);
                    map.G_map.addOverlay(new BMap.Marker(point));
                }
            }, mapMarker.M_city);
        }else{
            var point = new BMap.Point(map.longitude, map.latitude);//定义一个中心点坐标
            map.G_map.centerAndZoom(point, mapMarker.M_zoom);
            map.G_map.addOverlay(new BMap.Marker(point));
        }
        //mod zan.yu 20141204 FUN-BK-0041-G7地址库平台接入---end
    }

}


//地图设置类
var map = {

    G_map:{},

    city_name:'',

    G_zoom:12,

    //区域类型：1、配送站 2、运费

    //mod 20141124 sunqiang  FUN-BK-0034 运费规则调整 start    
    G_type:1,
    //G_type:2,
    //mod 20141124 sunqiang  FUN-BK-0034 运费规则调整 end

    //id
    G_id:'',

    //add zan.yu 20141204 FUN-BK-0041-G7地址库平台接入---start
    longitude:'',
    latitude:'',
    //mod zan.yu 20141204 FUN-BK-0041-G7地址库平台接入---end

    setMap:function(){
        map.G_map = new BMap.Map(map.G_id, {enableMapClick:false}),  // 创建Map实例

            map.G_map.enableScrollWheelZoom();                                   //启动鼠标滚轮操作
        map.G_map.disableDoubleClickZoom();                                   //禁用双击放大
        map.G_map.addControl(new BMap.NavigationControl());                  //添加默认缩放平移控件

        //移动地图中心点
        map.G_map.centerAndZoom(map.city_name, map.G_zoom);
    }
}


//弹出框
dialog_open = {

    m_id : 'd_open',

    //打开弹出层
    open:function(args){

        if(args.width){
            w = args.width/2;
            args.width += 'px';
            args.margin_left = '-'+w+'px!important';
        }

        if(args.height){
            t = args.height/2;
            args.height += 'px';
            args.margin_top = '-'+t+'px!important';
        }

        if(!args.content){
            args.content = '';
        }

        $("div[class='tc-con tc-con-b-1']").remove();
        $("div[class='tc-cover']").remove();

        var style = 'width:'+ args.width +';height:'+ args.height +';margin-left:'+ args. margin_left +';margin-top:'+args.margin_top;
        var sm_alert_html = '<div class="tc-cover" id="myCover">&nbsp;</div>';
        sm_alert_html += '<div class="tc-con" style="'+ style +'" id="maximPanel-'+ this.m_id +'">';
        sm_alert_html += '<a href="javascript:void(0);" class="close close_2" onclick="dialog_open.close()">关闭</a>';
        sm_alert_html += '<div  class="tc-con-1">'+ args.content +'</div>';
        sm_alert_html += '</div>';

        $(document.body).append(sm_alert_html);
        $("#myCover").height($(document.body).height());
        $("#maximPanel").show(400).focus();

    },

    //关闭弹出层
    close: function() {
        $("#maximPanel-" + this.m_id).hide(300).remove();
        $("#myCover").remove();
    }

}

checkout.init();


$(window).ready(function() {

    $("select").selectCss();

    //地图坐标变动
    $(document).on('change','#address',function(){

        var city_name = $("#city_list").find('option:selected').text();
        var county_name = $("#county_list").find('option:selected').text();
        var address = $("#address").val();

        mapMarker.M_city = city_name;
        mapMarker.M_address = city_name + county_name + address;
        mapMarker.M_type = 1;
        map.city_name = city_name;
        map.G_id = 'right_map';
        map.G_zoom = 10;
        //del 20141124 sunqiang  FUN-BK-0034 运费规则调整 start    
        //map.G_type = 2;
        //del 20141124 sunqiang  FUN-BK-0034 运费规则调整 end
        //add zan.yu 20141204 FUN-BK-0041-G7地址库平台接入---start
        map.longitude="";
        map.latitude="";
        //add zan.yu 20141204 FUN-BK-0041-G7地址库平台接入---end
        map.setMap();
        mapArea.search();

    });


    //会员收货地址选择样式控制
    $(document).on('click', '.address_list li em', function(){
        var deliver_array = $(this).attr('id').split('deliver-em-');
        checkout.deliver.choose(deliver_array[1]);

    });

    //站点自提选择样式控制
    $(document).on('click', '.my_add em', function(){

        var cityName = $(this).siblings('input').attr('cityName');
        var address = $(this).siblings('input').attr('address');

        $(".my_add").find('em').removeClass('cur');
        $(".my_add").find('input').attr('checked',false);
        $(this).addClass('cur');
        $(this).siblings('input').attr('checked', true);

        mapMarker.M_city = cityName;
        mapMarker.M_address = address;
        mapMarker.M_type = 1;

        map.city_name = cityName;
        map.G_id = 'extract_map';
        map.G_zoom = 10;
        //del 20141124 sunqiang  FUN-BK-0034 运费规则调整 start    
        //map.G_type = 1;
        //del 20141124 sunqiang  FUN-BK-0034 运费规则调整 end    
        map.setMap();
        mapArea.search();

    });

    //配送时间
    $("#delivery_time").on("click",function(){

        var date_box = $("#deliveryTime").html();

        var send_date = $("#send_date").val();
        var send_amp = $("#send_amp").val();
        var send_start_time = $("#send_start_time").val();
        var send_end_time = $("#send_end_time").val();

        var html='<ul class="Remote_payment delivery_time_ul">';
        html += '<li style="height:40px;">';
        html += '<div class="left_btn"></div>';
        html += '<div class="datelist_box">';
        //html += '<ul class="datelist">'+ date_box +'</ul>';
        html += date_box;
        html += '</div>';
        html += '<div class="right_btn"></div>';
        html += '</li>';
        html += '<li class="select_down_box">';
        html += '<span>配送时间</span>';
        html += '<div class="select_down am_txt">';
        html += '<select id="select_t_1" name="">';

        //上午下午
        $.each(checkout.delivery_time.time,function(k, v){
            if(send_amp != '' && send_amp == v){
                html += '<option value="'+ v +'" selected="selected" >'+ v +'</option>';
            }else if(k == 0){
                html += '<option value="'+ v +'" selected="selected" >'+ v +'</option>';
            }else{
                html += '<option value="'+ v +'">'+ v +'</option>';
            }
        });
        html += '</select>';

        html += '</div>';
        html += '<div class="select_down timeslot_txt">';

        html += '<select id="select_t_2">';

        var ST = '',
            ST_P = -1,
            warn = 0;

        //开始配送时间
        if(checkout.delivery_time.send_start_time){
            $.each(checkout.delivery_time.send_start_time,function(k, v){
                var start_time = v.replace('(爆单)','');
                if(k == 0){
                    ST = start_time;
                    ST_P = v.indexOf('(爆单)');         //是否爆单标志
                }
                if(send_start_time != '' && send_start_time == v){
                    html += '<option value="'+ start_time +'" selected="selected">'+ v +'</option>';
                }else{
                    html += '<option value="'+ start_time +'">'+ v +'</option>';
                }

            })
        }

        html += '</select>';
        html += '</div>';
        html += '<span>至</span><div class="select_down timeslot_txt">';
        html += '<select id="select_t_3">';

        if(checkout.delivery_time.send_start_time){

            $.each(checkout.delivery_time.send_end_time,function(k, v){
                if(v > ST){
                    if(send_end_time != '' && send_end_time == v){
                        html += '<option value="'+ v +'" selected="selected">'+ v +'</option>';
                    }else if(k == 0){
                        html += '<option value="'+ v +'" selected="selected">'+ v +'</option>';
                    }else{
                        if(ST_P > 0){
                            var start_time_obj = ST.split(':');
                            var twoHourTime = (parseInt(start_time_obj[0]) + 2).toString() + ':' + start_time_obj[1] + ':' + start_time_obj[2];
                            if(twoHourTime >= '22:00:00'){
                                warn = 1;
                                twoHourTime = '22:00:00';
                            }
                            if(v == twoHourTime && twoHourTime <= '22：00：00'){
                                html += '<option value="'+ v +'" selected="selected">'+ v +'</option>';
                            }else{
                                html += '<option value="'+ v +'">'+ v +'</option>';
                            }
                        }else{
                            html += '<option value="'+ v +'">'+ v +'</option>';
                        }
                    }
                }
            })
        }
        html += '</select>';
        html += '</div>';
        html += '<div class="clear"></div></li>';
        html += '<li id="hotSaleSign" style="display:none;text-align: center;color: #b0916a;margin-top: -10px;padding-bottom: 10px;">该时间段已爆单，可能会产生延误，建议选择非爆单时间点，或选择自提。</li>';
        html += '<li class="coupon_btn"> ';
        html += '<input type="button" value="确定" onclick="checkout.deliveryTime.selectSubmit()" class="login_btn" id="selected_time"/>';
        html += '</li>';
        html += '</ul>';
        $.Alert_coupon(html);

        if($("#select_t_2 option:selected").text().indexOf('(爆单)') > 0 && warn == 1 ){
            $("#hotSaleSign").show();
        }else{
            $("#hotSaleSign").hide();
        }

    });

    //点击日期，刷新配送时间
    $(document).on('click','.date_li',function(){
        E.ajax_post({
            action:'checkout',
            data : {
                act: checkout_args.act,
                date : $(this).attr('data')
            },
            operFlg:4,
            call:'checkout.deliveryTime.timeDisplay'
        });

    });

    //点击上午、下午时间段，刷新配送时间
    $(document).on('click', '.am_txt li', function(){

        //var date = $('.datelist').find('.cur').attr('data');
        var date = $("div.datelist_box ul.datelist li.cur").attr("data");
        var time_quantum = $('#select_t_1').siblings('.tag_select').text();

        E.ajax_post({
            action:'checkout',
            data : {
                act: checkout_args.act,
                date : date,
                time_quantum : time_quantum
            },
            operFlg:4,
            call:'checkout.deliveryTime.timeDisplay'
        });

    });

    //起始时间端 => 联动结束时间段
    $(document).on('change', '#select_t_2', function(){

        var start_time = $('#select_t_2 option:selected').text();
        var ST = start_time.replace('(爆单)',''),
            ST_P = start_time.indexOf('(爆单)'),         //是否爆单标志
            warn = 0;

        if(checkout.delivery_time.send_start_time){


            var html = '';
            $.each(checkout.delivery_time.send_end_time,function(k, v){

                if( v > ST){
                    if(k == 0){
                        html += '<option value="'+ v +'" selected="selected">'+ v +'</option>';
                    }else{
                        if(ST_P > 0){
                            var start_time_obj = ST.split(':');
                            var twoHourTime = (parseInt(start_time_obj[0]) + 2).toString() + ':' + start_time_obj[1] + ':' + start_time_obj[2];
                            if(twoHourTime >= '22:00:00'){
                                warn = 1;
                                twoHourTime = '22:00:00';
                            }
                            if(v == twoHourTime && twoHourTime <= '22：00：00')
                                html += '<option value="'+ v +'" selected="selected">'+ v +'</option>';
                            else
                                html += '<option value="'+ v +'">'+ v +'</option>';
                        }else{
                            html += '<option value="'+ v +'">'+ v +'</option>';
                        }
                    }
                }
            });

            $("#select_t_3").html(html);
            $("select").selectCss();

            if($("#select_t_2 option:selected").text().indexOf('(爆单)') > 0 && warn == 1 ){
                $("#hotSaleSign").show();
            }else{
                $("#hotSaleSign").hide();
            }
        }

    });


    //配送时间：结束时间段事件
    $(document).on('change', '#select_t_3', function(){

        var start_time = $('#select_t_2').val();
        var end_time = $('#select_t_3').val();
        var start_time_obj = start_time.split(':');
        var twoHourTime = (parseInt(start_time_obj[0]) + 2).toString() + ':' + start_time_obj[1] + ':' + start_time_obj[2];
        if($("#select_t_2 option:selected").text().indexOf('(爆单)') > 0 && end_time < twoHourTime){
            $("#hotSaleSign").show();
        }else{
            $("#hotSaleSign").hide();
        }

    });


    $(document).on('click','ul.datelist li',function(){

        $("div.datelist_box ul.datelist li").removeClass("cur");
        $(this).addClass("cur");

    });

    //用户输入地址获取外环费提示
    $(document).on('blur','#address', function(){

        var address = $(this).val();
        var provinceid = $("#province_list").val();
        var cityid = $("#city_list").val();
        var countyid = $("#county_list").val();

        E.ajax_post({
            action:'deliver',
            operFlg:4,
            data : {
                provinceid : provinceid,
                cityid : cityid,
                countyid : countyid,
                address : address
            },
            call:function(o){
                if(o.code == 200){
                    if(o.data){
                        if(o.data.freight && o.data.freight > 0){
                            $("#address_err").html('需加收环外费'+o.data.freight+'元');
                        }else{
                            $("#address_err").html('');
                        }
                    }
                }else{
                    $("#address_err").html(o.message);
                }
            }
        });

    });

    //支付方式
    $(".Choice_pay em").click(function(){

        //如果是异地选择
        if($(this).parents('li').hasClass('pay_othor_address')){
            if($(this).hasClass('cur')){
                $(this).siblings('input').attr('checked',false);
                $(this).removeClass('cur');
                $(this).parent().parent().find("div").hide();
                $(this).parent().parent().find(".Remote_payment").hide();
            }else{
                $(this).siblings('input').attr('checked',true);
                $(this).addClass('cur');
                $(this).parent().parent().find("div").show();
                $(this).parent().parent().find(".Remote_payment").show();
            }
            return false;
        }else{
            $(".Choice_pay input:not(.pay_othor_address span input)").attr('checked',false);
            $(".Choice_pay em:not(.pay_othor_address span em)").removeClass('cur');
            $(".Choice_pay > div").hide();
            $(".Choice_pay .Remote_payment:not(.pay_othor_address .Remote_payment)").hide();

            $(this).siblings('input').attr('checked',true);
            $(this).addClass("cur");
            $(this).parent().parent().find("div").show();
            $(this).parent().parent().find(".Remote_payment").show();

            $('.pay_othor_address').hide();
            if((checkout.pay_type_ == 'pay_type1_1' || checkout.pay_type_ == 'pay_type1_2' || checkout.pay_type_ == 'pay_type1_3') && $(this).siblings('input').val() == 2){
                $('.pay_othor_address').show();
            }

            if(checkout.pay_type_ != ''){
                $("#pay_online p").find('samp').removeClass('cur');
                $('#pay_on_delivery p').find('samp').removeClass('cur');
                $('.pay_list li').hide();
            }
            if(checkout.pay_type_ == 'pay_type1_1'){
                $('.pay_type1_p1').find('samp').addClass('cur');
                $('.pay_type1_1').show();
            }else if(checkout.pay_type_ == 'pay_type1_2'){
                $('.pay_type1_p2').find('samp').addClass('cur');
                $('.pay_type1_2').show();
            }else if(checkout.pay_type_ == 'pay_type1_3'){
                $('.pay_type1_p3').find('samp').addClass('cur');
                $('.pay_type1_3').show();
            }else if(checkout.pay_type_ == 'pay_type2_1'){
                $('.pay_type2_p1').find('samp').addClass('cur');
                $('.pay_type2_1').show();
                $('.pay_othor_address span').find('input').attr('checked', false);
                $('.pay_othor_address span').find('em').removeClass('cur');
            }else if(checkout.pay_type_ == 'pay_type2_2'){
                $('.pay_type2_p2').find('samp').addClass('cur');
                $('.pay_type2_2').show();
                $('.pay_othor_address span').find('input').attr('checked', false);
                $('.pay_othor_address span').find('em').removeClass('cur');
            }
        }
    });

    $(document).on('click', '.pay_type1_p1', function(){
        $(this).siblings().find('samp').removeClass('cur');
        $('.pay_list li').removeClass('cur');
        $(this).find('samp').addClass('cur');
        $('.pay_type1_2').hide();
        $('.pay_type1_3').hide();
        $('.pay_othor_address').show();
        checkout.pay_type_ = 'pay_type1_1';
    });

    $(document).on('click', '.pay_type1_p2', function(){
        $(this).siblings().find('samp').removeClass('cur');
        $(this).find('samp').addClass('cur');
        $('.pay_type1_2').show();
        $('.pay_type1_3').hide();
    });

    $(document).on('click', '.pay_type1_p3', function(){
        $(this).siblings().find('samp').removeClass('cur');
        $(this).find('samp').addClass('cur');
        $('.pay_type1_3').show();
        $('.pay_type1_2').hide();
    });

    $(document).on('click', '.pay_type2_p1', function(){
        $(this).siblings().find('samp').removeClass('cur');
        $(this).find('samp').addClass('cur');
        $('.pay_type2_1').show();
        $('.pay_type2_2').hide();
    });

    $(document).on('click', '.pay_type2_p2', function(){
        $(this).siblings().find('samp').removeClass('cur');
        $(this).find('samp').addClass('cur');
        $('.pay_type2_2').show();
        $('.pay_type2_1').hide();
    });

    $(document).on('click', '.pay_list li', function(){
        $('.pay_list li').removeClass('cur');
        $('.pay_type2_p1').removeClass('cur');
        $(this).addClass('cur');
        checkout.pay_type_ = $(this).attr('class').replace(' cur', '');
        if(checkout.pay_type_ == 'pay_type2_2' || checkout.pay_type_ == 'pay_type2_1'){
            $('.pay_othor_address').hide();
            $('.pay_othor_address .Remote_payment').hide();
            $('.pay_othor_address span').find('input').attr('checked',false);
        }else if(checkout.pay_type_ == 'pay_type1_2' || checkout.pay_type_ == 'pay_type1_3'){
            $('.pay_othor_address').show();
        }
    });

    //发票类型
    $(".Invoice font").click(function(){
        var _index=$(this).index();
        if(_index == 0){
            $("#invoice_title").hide();
        }else{
            $("#invoice_title").show();
        }
        $(".Invoice font").removeClass("Gold");
        $(this).addClass("Gold");
    });


    //选择发票
    $(document).on('click','.other .em',function(){
        if(checkout.invoice == 0){
            $(this).addClass('cur');
            $(this).parent().parent().find("div").show();
            checkout.invoice = 1;
        }else{
            $(this).removeClass('cur');
            $(this).parent().parent().find("div").hide();
            checkout.invoice = 0;
        }
    });


    //订单备注 3.12mark
    $(document).on('click','.Remarks em',function(){
        if($(this).hasClass('cur'))
        {
            $(this).removeClass('cur');
            $(this).parent().parent().find("div").first().hide();
        }
        else
        {
            $(this).addClass('cur');
            $(this).parent().parent().find("div").first().show();
        }

    });

    //发票内容选择
    $('.Invoice .open_selected').click(function(){
        var _index = $(this).index();
        $('.Invoice select').find('option').eq(_index).attr('selected',true).siblings('option').attr('selected',false);
    });

    //聚焦型输入框验证
    $(document).on('focus', '.Discount_txt, .use_coupon_txt, .brand_txt', function() {
        $(this).siblings("label").hide();
    }).on('blur', 'input_t,.Discount_txt, .use_coupon_txt, .brand_txt', function(){
            var val = $(this).val();
            if(val!=""){
                $(this).siblings("label").hide();
            }else{
                $(this).siblings("label").show();
            }
        });

    //聚焦型输入框验证
    $(document).on('focus', '.my_add .input_t, .Remote_payment .input_t', function() {
        $(this).siblings("label").find("font").hide();
    }).on('blur', '.my_add .input_t, .Remote_payment .input_t', function(){
            var val = $(this).val();
            if(val!=""){
                $(this).siblings("label").find("font").hide();
            }else{
                $(this).siblings("label").find("font").show();
            }
        });


    //货到付款
    $(document).on('click','.pay_type1',function(){
        $(".pay_type1").removeClass("cur");
        $(".pay_type2").removeClass("cur");
        $(this).addClass("cur");
    });

    //在线支付
    $(document).on('click','.pay_type2',function(){
        $(".pay_type1").removeClass("cur");
        $(".pay_type2").removeClass("cur");
        $(this).addClass("cur");
    });


    $("a.use_integral").click(function(){
        $(this).parent().find("div").toggle();
    });

    $("#use_points").click(function(){
        if(!login_status.check()){
            return false;
        }
    });

    //红包选项框控制
    $(document).on('click', '.red_box_list .picke em',function(){
        if($(this).hasClass('cur')){
            $(this).removeClass('cur');
            $(this).siblings('input').attr('checked',false);
        }else{
            $(this).addClass('cur');
            $(this).siblings('input').attr('checked',true);
        }
    });

    //使用旧积分
    var oldPoints = $('#use_points').val();
    if(E.isEmpty(oldPoints)){
        oldPoints = 0;
    }

    //使用积分
    $(document).on('change','#use_points',function(){

        var err_msg = '积分使用最小单位为100积分';
        var points = $(this).val();
        $('#points_err').empty().hide();

        if(E.isEmpty(points)){
            $('#points_err').html(err_msg).show();
            $(this).val(oldPoints);
            return false;
        }

        if(!E.isInt(points)){
            $('#points_err').html(err_msg).show();
            $(this).val(oldPoints);
            return false;
        }

        points = parseInt(points);
        if( points%100 != 0 ){
            points = points-points%100;
            $(this).val(points);
            $('#points_err').html('积分使用最小单位为100积分').show();
        }

        E.ajax_post({
            action:'checkout',
            operFlg:5,
            data:{ act: checkout_args.act, points:points },
            call:function( o ){
                if(o.code == 200 ){
                    $('#use_points').val(o.data.points);
                    checkout.totalCount();
                }else{
                    $('#use_points').val(oldPoints);
                    E.alert(o.message);
                }
            }

        });

    });

    //取消使用积分
    $(document).on('click','#cancel_use_points',function(){
        E.ajax_post({
            action:'checkout',
            operFlg:8,
            data:{ act: checkout_args.act },
            call:function(o){
                $('#points_err').hide();
                $("#use_points").val('');
                checkout.totalCount();
            }
        });
    });

    //使用现金卡/专享卡     start
    $(document).on('click','.use_card_bt', function(){

        var card_pwd = $("#card_pwd").val();

        if(E.isEmpty(card_pwd)){
            $(this).parent('.card_box').siblings('.card_err').html('请输入现金卡/专享卡').show();
            return false;
        }

        if(checkout.total_receivable_money <= 0){
            $(this).parent('.card_box').siblings('.card_err').html('货款已付清，无需再使用现金卡/专享卡').show();
            return false;
        }

        E.ajax_post({
            action:'checkout',
            operFlg:31,
            data:{act: checkout_args.act},
            call:function( o ){
                if(o.code == 400){

                    var html = '<ul class="Remote_payment Cash_coupon Cash_coupon_2">';
                    html += '<li><span >对不起，您已使用了券/红包，无法与现金卡同享，取消券/红包，可使用现金卡。</span></li>';
                    html += '<li><input type="button" value="确定" class="login_btn Exclusive_card"  onclick="dialog_open.close()"/></li>'
                    html += '</ul>';

                    dialog_open.open({
                        width:410,
                        height:250,
                        content:html
                    });

                    return false;

                }else{

                    var data = {act: checkout_args.act,card_pwd:card_pwd};

                    E.ajax_post({
                        action:'checkout',
                        operFlg:6,
                        data:data,
                        call:function( o ){
                            if(o.code == 200){
                                checkout.totalCount();//计算金额
                            }else{
                                $("#card_pwd").parents('.card_box').siblings('.card_err').html(o.message).show();
                            }
                        }
                    });
                }
            }
        });





    });
    //使用现金卡/专享卡     end

    var old_birthday_card = '';

    //巧克力牌赋值
    $(".birthday_card").blur(function() {

        var birthday_card = E.trim($(this).val());

        if (E.len(birthday_card) > 18) {
            E.alert('生日牌请填写9个汉字或18个英文字母');
            return false;
        }else{
            $(this).parents('.goods_line').next('.bs_err').hide();
        }

        if(!E.isBirthday_card(birthday_card))
        {
            E.alert('生日牌请填写汉字、英文、数字');
        }


        var postID = $(this).parents('.goods_line').attr('postid');
        var index = $(this).parents('.goods_line').attr('line');
        bill_goods[postID][index]['birthday_card'] = birthday_card;

    }).focus(function() {
        old_birthday_card = E.trim($(this).val());
    }).keyup(function() {

        var val = E.trim($(this).val());
        if (E.len(val) > 18) {
            $(this).val(old_birthday_card);
            $(this).parents('.goods_line').next('.bs_err').show();
        } else {
            old_birthday_card = val;
            $(this).parents('.goods_line').next('.bs_err').hide();
        }

    });

    //订单备注字数控制
    var remark_str = '';

    $("#remark").blur(function(){

        var value = E.trim($(this).val());
        if(E.len(value) > 100){
            $(this).parent().next('.re_err').show();
            return false;
        }else{
            $(this).parent().next('.re_err').hide();
        }
    }).focus(function(){
            remark_str = E.trim($(this).val());
        }).keyup(function(){

            var val = E.trim($(this).val());
            if(E.len(val) > 100){
                $(this).val(remark_str);
                $(this).parent().next('.re_err').show();
            }else{
                remark_str = val;
                $(this).parent().next('.re_err').hide();
            }
        });


    $(".other_1 em").click(function(){

        if($(this).siblings("input[type='checkbox']").attr("checked")==undefined){

            $(this).css({backgroundPosition:'0 -280px'});
            $(this).siblings("input[type='checkbox']").attr("checked",true)
            $(this).parents(".other_1").find("div").addClass("cur");

        }else{

            var buyNum = $(this).parents('.addTableware').find('.other_num').val();
            //取消配件购买
            if(parseInt(buyNum) != 0){
                var postID = $(this).parents('.goods_line').attr('postid'),
                    index = $(this).parents('.goods_line').attr('line'),
                    fitid = $(this).parents('.addTableware').attr('fitid'),
                    buyNum = 0,
                    price = $(this).parents('.addTableware').attr('price');

                $(this).parents('.addTableware').find('.other_num').val(buyNum);
                checkout.fittings.buy_fittings(postID, index,fitid, buyNum, price);
            }

            $(this).css({backgroundPosition:'0 0'});
            $(this).siblings("input[type='checkbox']").attr("checked",false)
            $(this).parents(".other_1").find("div").removeClass("cur");
        }

    });

    //生日牌选择控制
    $(".other_bs em").click(function(){
        var postID = $(this).parents('.goods_line').attr('postid');
        var index = $(this).parents('.goods_line').attr('line');
        if($(this).siblings("input[type='checkbox']").attr("checked")==undefined){
            var bs_card = 1;
            $(this).css({backgroundPosition:'0 -280px'});
            $(this).siblings("input[type='checkbox']").attr("checked",true);
            $(this).parents(".other_bs").find("div").addClass("cur");
        }else{
            var bs_card = 0;
            $(this).css({backgroundPosition:'0 0'});
            $(this).siblings("input[type='checkbox']").attr("checked",false);
            $(this).parents(".other_bs").find("div").removeClass("cur");
            $('.other_bs').find('input[name=birthday_card]').val('');
        }
        bill_goods[postID][index]['bs_card'] = bs_card;
    });

    //生日蜡烛选择控制
    $(".other_bs_candle em").click(function(){
        var postID = $(this).parents('.goods_line').attr('postid');
        var index = $(this).parents('.goods_line').attr('line');
        if($(this).siblings("input[type='checkbox']").attr("checked")==undefined){
            var bs_candle = 1;
            $(this).css({backgroundPosition:'0 -280px'});
            $(this).siblings("input[type='checkbox']").attr("checked",true);
            $(this).parents(".other_bs_candle").find("div").addClass("cur");
        }else{
            var bs_candle = 0;
            $(this).css({backgroundPosition:'0 0'});
            $(this).siblings("input[type='checkbox']").attr("checked",false);
            $(this).parents(".other_bs_candle").find("div").removeClass("cur");
        }
        bill_goods[postID][index]['bs_candle'] = bs_candle;
    });

    //MK-FUN-BK-005-巧克力牌&蜡烛图片优化 start update by 宋国焌 2015-04-013
    //鼠标悬浮时生日牌、生日蜡烛悬浮图片
    $(".birthday_img").mouseover(function(){
        var src = $(this).find('img').attr('src');
		if(!E.empty(src)){
			var big_img_obj = $(this).next('div');
			if(big_img_obj.is(":hidden")){
				big_img_obj.css('display','block');
			}else{
				big_img_obj.css('display','none');			
			}
		}
        /*if(!E.empty(src)){
            $(this).parents('.goods_line').find('.img_show').find('img').attr('src',src);
            $(this).parents('.goods_line').find('.img_show').show();
        }else{
            $(this).parents('.goods_line').find('.img_show').find('img').attr('src',src);
            $(this).parents('.goods_line').find('.img_show').hide();
        }*/
    });

    //鼠标离开时生日牌、生日蜡烛悬浮图片
    $(".birthday_img").mouseout(function(){
        $(this).next('div').hide();
    });
    //MK-FUN-BK-005-巧克力牌&蜡烛图片优化 end update by 宋国焌 2015-04-13
	
	
    //购买配件
    var old_buyNum = 0;

    $(".other_1 .other_num").keyup(function(){

        var numValue = $(this).val();
        if(E.empty(numValue))
            numValue = 0;

        if(!E.isInt(numValue)){
            $(this).val('');
            return false;
        }

        if(numValue != old_buyNum){
            var postID = $(this).parents('.goods_line').attr('postid'),
                index = $(this).parents('.goods_line').attr('line'),
                fitid = $(this).parents('.addTableware').attr('fitid'),
                buyNum = numValue,
                price = $(this).parents('.addTableware').attr('price');

            checkout.fittings.buy_fittings(postID, index,fitid, buyNum, price);
        }

    }).keydown(function(){
        old_buyNum = E.trim($(this).val());
    });

    //提交订单
    $("#billSubmit").click(function(){

        //默认实付款大于0
        bill_data.is_zero = 0;

        bill_data.pay_type_radio = $('input[name="pay_type_radio"]:checked').val();
        bill_data.is_pay_other = 0;
        if($('input[name="is_pay_other"]:checked').val() != undefined){
            bill_data.is_pay_other = 1;
        }

        if(!checkout.is_delivery_time ){
            E.alert('请选择配送时间');
            return false;
        }

        if(!checkout.is_payTypeID && checkout.total_receivable_money > 0){
            E.alert('请选择支付方式');
            return false;
        }

        //应收金额和优惠券成本小于等于0
        if(checkout.total_receivable_money <= 0){
            bill_data.is_zero = 1;
        }

        var is_birthday_card_flag = true;
        $.each(bill_goods,function(key,val){
            $.each(val,function(index,item){
               if(!E.isBirthday_card( item.birthday_card ))
               {
                   is_birthday_card_flag = false;
               }

            });


        });

        if(!is_birthday_card_flag)
        {
            E.alert('生日牌请填写汉字、英文、数字');
            return false;
        }

        //验证异地付款
        if(bill_data.is_pay_other == 1){

            //异地付款
            bill_data.other_dt = E.getFormValues("otherForm");

            if(E.isEmpty(bill_data.other_dt.address)){
                E.alert('请输入异地付款详细地址');
                return false;
            }

            if(E.isEmpty(bill_data.other_dt.date)){
                E.alert('请选择异地付款日期');
                return false;
            }

            if(E.isEmpty(bill_data.other_dt.time)){
                E.alert('请输入异地付款时间');
                return false;
            }

            if(E.isEmpty(bill_data.other_dt.custName)){
                E.alert('请输入异地付款收款人姓名');
                return false;
            }

            if(E.isEmpty(bill_data.other_dt.mobile)){
                E.alert('请输入异地付款手机号码');
                return false;
            }
        }

        bill_data.invoice_title_type = 0;
        bill_data.invoice_title = '';
        bill_data.invoice_content_id = 0;
        bill_data.invoice_content = '';

        //需要开发票
        if(checkout.invoice > 0 && (bill_data.is_zero == 0 || checkout.coupon_cost > 0) && checkout.card_is_invoice == 1){

            bill_data.invoice_title_type = $(".Invoice .Gold").attr('invoice_title_type');

            if(!E.empty(bill_data.invoice_title_type)){
                if(bill_data.invoice_title_type != 1 && bill_data.invoice_title_type != 2){
                    E.alert('发票类型不正确');
                    return false;
                }

                bill_data.invoice_title = $("#invoice_title").val();
                if(bill_data.invoice_title_type != 1 && E.empty(bill_data.invoice_title)){
                    E.alert('发票抬头必须填写');
                    return false;
                }
            }

            bill_data.invoice_content_id = $("#invoice_content").val();
            bill_data.invoice_content = $("#invoice_content").find('option:selected').text();
            if(E.empty(bill_data.invoice_content) || E.empty(bill_data.invoice_content_id)){
                E.alert('发票内容必须选择');
                return false;
            }
        }




        //订单备注
        bill_data.remark = $("#remark").val();
        if(!E.empty(bill_data.remark) && bill_data.remark.length > 50){
            E.alert('订单备注必须在50个汉字以内');
            return false;
        }

        if(checkout.card_is_invoice == 0 && checkout.invoice > 0){
            E.confirm("您选择使用"+ checkout.payTypeName + ' ' + checkout.paymentName +"，将不能开具发票。继续提交订单或返回修改？","bill_submit");
        }else if(bill_data.is_zero && checkout.invoice > 0 && checkout.coupon <= 0){
            E.confirm("使用现金券等抵扣方式后，您的实付款金额为￥0，将不能开具发票。继续提交订单或返回修改？","bill_submit");
        }else{
            bill_submit();
        }

    });

});

//订单提交函数
function bill_submit(){

    if((bill_data.is_zero && checkout.invoice > 0 && checkout.coupon_cost == 0) || checkout.card_is_invoice == 0)
        checkout.invoice = 0;

    E.loadding.open('正在努力加载，请稍候...');

    E.ajax_post({
        action:'bill',
        operFlg:1,
        data:{
            act: checkout_args.act,
            source:checkout_args.source,
            goods_info:bill_goods,
            other_address_pay:bill_data.other_dt,
            invoice:checkout.invoice,
            invoice_title:bill_data.invoice_title,
            invoice_title_type:bill_data.invoice_title_type,
            invoice_content:bill_data.invoice_content,
            invoice_content_id:bill_data.invoice_content_id,
            remark:bill_data.remark,
            pay_type_radio:bill_data.pay_type_radio,
            is_zero:bill_data.is_zero,
            is_pay_other:bill_data.is_pay_other
        },
        call:function(o){
            if(o.code == 200){
                E.loadding.close();
                self.location.href = '/shop/payment.html?bill_no='+ o.data.bill_no + '&act=' + checkout_args.act;
            }else if(o.code == 201){
                E.loadding.close();
                E.alert(o.message, 3, 'E.refresh');
            }else{
                E.loadding.close();
                E.alert(o.message);
            }
        }
    })
}



