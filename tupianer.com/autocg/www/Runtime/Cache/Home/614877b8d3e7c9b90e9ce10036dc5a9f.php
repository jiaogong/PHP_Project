<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>用户订单-图片</title>
<link type="text/css" rel="stylesheet" href="/Public/Home/css/communal.css" />
<link type="text/css" rel="stylesheet" href="/Public/Home/css/userorder.css" />
<script src="/Public/Home/js/jquery.js"></script>
</head>
<body>
<div class="concent">
     <div class="header"  id="heads">
          <!--logo nav-->
                    <ul class="ull">
                      <li class="lil"><a href="#"><img src="/Public/Home/images/logo.png" width="111" height="57" alt="logo" /></a></li>
                      <li class="lil"><a href="#" class="xuanze">首页</a></li>
                      <li class="lil"><a href="#">我要查找</a></li>
                    </ul>
            <!--sousuo-->
                    <div class="sousuo">
                       <form action="#">
                         <input type="text" placeholder="请输入要搜索的内容" class="sousuok" />
                         <input type="submit" value="" class="sousuoa" />
                       </form>
                    </div>
                    <div class="wdlzc" style="display:none">
                       <a href="#">登录</a>&nbsp;/&nbsp;<a href="#">注册</a>
                    </div>
                    <div class="dlzck">
                    
                    <div class="dlzc">
                        <span><img id="tx" src="/Public/Home/images/tx.png" width="44" height="44" style="vertical-align:middle;" /></span>
                              <div id="tanchu">
                                   <ul>
                                      <li>用户名</li>
                                      <li>个人中心</li>
                                      <li>我的收藏</li>
                                      <li>我的关注</li>
                                      <li>我的作品</li>
                                      <li>我的订单</li>
                                      <li>我的交易</li>
                                      <li>我的个人页</li>
                                   </ul>
                                   <div class="tuichu">退出</div>
                              </div>             
               </div>
                <span class="dlzcld">
                <img src="/Public/Home/images/ld.png" width="44" height="44" style="vertical-align:middle;" />
                  <span class="xiaoxi">(2)</span>
                </span>
            </div>   
         </div>
<!--头部结束-->
         <div class="userorder">
              <div class="order-top">
                  <div class="fl"><img src="<?php echo ($pic_path); ?>" width="520px" height="392px" /></div> 
                  <div class="orderdis fl">
                       <span>作品名称：<?php echo ($pic_data["title"]); ?></span>
                       <span>作品分类：<?php echo ($pic_data["opus_type"]); ?></span> 
                       <span>品牌产品：<?php echo ($pic_data["car_logo"]); ?> <?php echo ($pic_data["car_type"]); ?> <?php echo ($pic_data["car_model"]); ?></span>
                       <span>标签：<?php echo ($pic_data["tags"]); ?></span> 
                       <span>创建时间：<?php echo ($pic_data["select_time"]); ?></span>
                       <span>图片用途：<?php if(($pic_data["material"]) == "1"): ?>背景图素材<?php endif; if(($pic_data["material"]) == "2"): ?>成品广告图<?php endif; ?><if name=""</span>       
                  </div>
                  <div class="clear"></div>
              </div> 
              <div class="order-bottom">
                   <h3>购买信息</h3>
                   <form>
                   <div class="choseorder">
                    <input type="hidden" name="permission" value="" />
                    <input type="hidden" name="price" value="" />
                    <input type="hidden" name="pic_opus_id" value="<?php echo ($pic_data["id"]); ?>">
                       <ul>
                          <li> 
                             <input type="radio"  checked="checked" name="sport" >
                             <label  class="checked" use='price_a' price="<?php echo ($pic_data["price_a"]); ?>" >使用许可：6个月</label>
                            
                            <span class="fr">￥<?php echo ($pic_data["price_a"]); ?>元</span>
                          </li>
                        
                            <li> 
                             <input type="radio"  name="sport"  >
                             <label use='price_b' price="<?php echo ($pic_data["price_b"]); ?>">使用许可：12个月</label>
                             <span class="fr">￥<?php echo ($pic_data["price_b"]); ?>元</span>
                          </li>
                           <li> 
                             <input type="radio"  checked="checked" name="sport"  >
                             <label use='price_c' price="<?php echo ($pic_data["price_c"]); ?>">使用许可：24个月</label>
                             <span class="fr">￥<?php echo ($pic_data["price_c"]); ?>元</span>
                          </li>
                           <li> 
                             <input type="radio"   name="sport"  >
                             <label use='price_d' price="<?php echo ($pic_data["price_d"]); ?>">著作权转让</label>
                             <span class="fr">￥<?php echo ($pic_data["price_d"]); ?>元</span>
                          </li>
                        
                       </ul> 
                   </div>
                   <button type="button" onclick="javascript:go_buy();" class="shopbtn">立即购买</button>
                   <form>
                   
              </div>        
         </div>
         <div class="footer">
                <div class="guanyv_lianxi">
                <a href="#" target="_blank" class="ys">关于我们</a>
                &nbsp;&nbsp;|&nbsp;&nbsp;
                <a href="#" target="_blank" class="ys">联系我们</a>
                </div>
                <div class="banquan">
                  版权所有:**********<br />
                  Copyright:2006-2013&nbsp;www.justeasy.cn&nbsp;All&nbsp;rights&nbsp;reserved<br />
                  南京设易网络科技有限公司&nbsp;登记序号：苏ICP备11003578号-2<br />
                </div>
        </div> 
</div>
<script>
$('.choseorder label').click(function(){
    var radioId = $(this).attr('name');
    $('.choseorder label').removeAttr('class') && $(this).attr('class', 'checked');
    $('input[type="radio"]').removeAttr('checked') && $('#' + radioId).attr('checked', 'checked');
  });

  //购买
  function go_buy(){
   var permission = $('.checked').attr('use');
   var price = $('.checked').attr('price');
   $("input[name='permission']").val(permission);
   $("input[name='price']").val(price);
   $('form').submit();
  }
  </script>
</body>
</html>