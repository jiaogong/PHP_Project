<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
    <head>
        <title>上传模型</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="/Public/Home/css/upload.css" rel="stylesheet"  type="text/css"/>
        <link href="/Public/Home/css/communal.css"  rel="stylesheet"   type="text/css"/>
        <script src="/Public/Home/js/jquerya.js"></script>
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
         <div class="uploadvideo-con">
             <div class="upload-title tab">
                 <ul>
                    <a href="<?php echo U('pic_upload');?>"><li title="uploadpic" >图片</li></a>
                    <a href="<?php echo U('model_upload');?>"><li title="uploadmodel" class="uploadcss">模型</li></a>
                    <a href="<?php echo U('video_upload');?>"><li title="uploadvideo" >视频</li></a>
                 </ul>
             </div> 
             <div class="upload-title-con">
                  <div class="uploadmodel upload" > <!--模型-->   
                     <form action="<?php echo U();?>" method="post" enctype="multipart/form-data">
                        <div class="workname inputpub"><!--作品名称-->
                        <label class="padfr fl">作品名称<i>*</i></label>
                        <input type="text"  name="title" class="wnip1 fl marlf"/>
                        <label class="fl px10" style=" font-size:12px">30字以内</label>
                        <div class="clear"></div>
                        </div><!--作品名称结束-->
                        <div class="inline"></div> 
                        <div class="workjj inputpub"><!--作品简介-->
                            <span class="padfr fl">作品简介<i>*</i></span>
                            <textarea name="instruct" class="fl marlf"></textarea>
                            <label style=" font-size:12px" class="fl px10">1000字以内</label>
                            <div class="clear"></div>
                        </div><!--作品简介结束-->
                        <div class="inline"></div> 
                        <input type="hidden" name="opus_type" value="" />
                        <input type="hidden" name="car_logo" value="" />
                        <input type="hidden" name="car_type" value="" />
                        <input type="hidden" name="car_model" value="" />
                        <input type="hidden" name="year" value="" />
                        <input type="hidden" name="month" value="" />
                        <input type="hidden" name="day" value="" />
                        <input type="hidden" name="select_time" value="" />
                        <input type="hidden" name="state" value="" />
                        <input type="hidden" name="model_format" value="" />
        <script type="text/javascript">
        // 下拉框赋值
              $(function(){

                $('.opus_type_select').children("dd").find("a").click(function(){
                    $("input[name='opus_type']").val($(this).html());
                });

                $('.car_logo_select').children("dd").find("a").click(function(){
                    $("input[name='car_logo']").val($(this).html());
                }); 
 
                $('.car_type_select').children("dd").find("a").click(function(){
                    $("input[name='car_type']").val($(this).html());
                }); 

                $('.car_model_select').children("dd").find("a").click(function(){
                    $("input[name='car_model']").val($(this).html());
                }); 

                $('.year_select').children("dd").find("a").click(function(){
                    $("input[name='year']").val($(this).html());
                }); 
 
                $('.month_select').children("dd").find("a").click(function(){
                    $("input[name='month']").val($(this).html());
                }); 

                $('.day_select').children("dd").find("a").click(function(){
                    $("input[name='day']").val($(this).html());
                });   
                
            })
        </script>
                        <div class="worfl inputpub"><!--作品分类-->
                                    <span class="padfr disblo fl">作品分类<i>*</i></span>
                                   <div class="selecss fl marlf">
                                        <dl class="select wid134 seletop opus_type_select">
                                            <dt>-选择作品分类-</dt>
                                            <dd>
                                                <ul>
                                                    <li><a href="#">机械/交通</a></li>
                                                    <li><a href="#">人物/生物</a></li> 
                                                    <li><a href="#">场景</a></li> 
                                                    <li><a href="#">动画/影视</a></li> 
                                                    <li><a href="#">建筑空间</a></li> 
                                                    <li><a href="#">其他三维</a></li>     
                                                    <li><a href="#">动漫</a></li> 
                                                    <li><a href="#">展览</a></li> 
                                                </ul>
                                            </dd>
                                        </dl>
                                   </div>
                                   <div class="clear"></div>
                        </div><!--作品分类结束-->
                        <div class="inline"></div> 
                         <div class="brand inputpub"><!--品牌产品-->
                                   <span class="padfr disblo fl">品牌产品<i>*</i></span>
                                   <div class="selecss fl marlf">
                                      <dl class="select wid134 seletop car_logo_select">
                                           <dt >-选择品牌-</dt>
                                        <dd>
                                            <ul>
                                                <?php if(!empty($carLogoList)): if(is_array($carLogoList)): $i = 0; $__LIST__ = $carLogoList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$carLogo): $mod = ($i % 2 );++$i;?><li><a href="#"><?php echo ($carLogo["brand"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; endif; ?>
                                            </ul>
                                        </dd> 
                                        </dl>
                                        
                                       <dl class="select wid134 seletop car_type_select">
                                            <dt>-选择车系-</dt>
                                            <dd>
                                                <ul>
                                                    <?php if(!empty($carTypeList)): if(is_array($carTypeList)): $i = 0; $__LIST__ = $carTypeList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$carType): $mod = ($i % 2 );++$i;?><li><a href="#"><?php echo ($carType["series"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; endif; ?>   
                                                </ul>
                                            </dd> 
                                            <span><input type="text" name="car_type_s" placeholder="请填写车系名称" /></span>
                                        </dl> 
                                        
                                          <dl class="select wid134 seletop car_model_select">
                                            <dt>-选择车款-</dt>
                                            <dd>
                                                <ul>
                                                    <?php if(!empty($carModelList)): if(is_array($carModelList)): $i = 0; $__LIST__ = $carModelList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$carModel): $mod = ($i % 2 );++$i;?><li><a href="#"><?php echo ($carModel["car"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; endif; ?>  
                                                </ul>
                                            </dd> 
                                            <span><input type="text" name="car_model_s"  placeholder="请填写车款名称" /></span>
                                        </dl> 
                                   </div>  
                                   <div class="clear"></div>
                        </div><!--品牌产品结束-->
                        <div class="inline"></div>  
                        <div class=" inputpub custom"><!--自定义标签-->
                            <span class="padfr tag fl">自定义标签</span>
                                <input type="text" class="fl marlf" name="tags" />
                                <label style=" font-size:12px" class="fl px10">以逗号或空格隔开</label>
                                <div class="clear"></div>
                        </div><!--<!--自定义标签结束-->
                        <div class="inline"></div> 
                        
                        <div class=" inputpub time"><!--创建时间-->
                            <span class="padfr timezi fl">创建时间<i>*</i></span>
                             <div class="fl marlf">
                                     <dl class="select wid134 seleleft year_select">
                                            <dt>--年--</dt>
                                            <dd>
                                                <ul>
                                                    <?php $__FOR_START_4884__=2013;$__FOR_END_4884__=2023;for($i=$__FOR_START_4884__;$i < $__FOR_END_4884__;$i+=1){ ?><li><a href="#"><?php echo ($i); ?></a></li><?php } ?>
                                                </ul>
                                            </dd>
                                            <span>年</span>
                                        </dl> 
                                        
                                <dl class="select wid134 seleleft month_select">
                                            <dt>--月--</dt>
                                            <dd>
                                                <ul>
                                                    <?php $__FOR_START_26557__=1;$__FOR_END_26557__=13;for($i=$__FOR_START_26557__;$i < $__FOR_END_26557__;$i+=1){ ?><li><a href="#"><?php echo ($i); ?></a></li><?php } ?>     
                                                </ul>
                                            </dd>
                                            <span>月</span>
                                        </dl>
                                <dl class="select wid134 seleleft day_select">
                                            <dt>--日--</dt>
                                            <dd>
                                                <ul>
                                                <?php $__FOR_START_29106__=1;$__FOR_END_29106__=32;for($i=$__FOR_START_29106__;$i < $__FOR_END_29106__;$i+=1){ ?><li><a href="#"><?php echo ($i); ?></a></li><?php } ?>    
                                                </ul>
                                            </dd>
                                            <span>日</span>
                                        </dl> 
                              </div>
                              <div class="clear"></div>
                                
                        </div><!--<!--创建时间结束-->
                        <div class="inline"></div>
                        <div class="inputpub"> 
                           <span class="videoinfor">模型信息:</span>
                        </div>
                        <div class="inline"></div>
                        <div class="money inputpub"><!--模型面数-->
                                   <span class="padfr fl">模型面数（参数）<i>*</i></span>
                                   <input type="text" class="dollar fl marlf" name="model_faces" /> 
                                   <label class="px10 fl">面</label>
                                   <div class="clear"></div>
                        </div><!--模型面数结束-->
                        <div class="inline"></div>
                        <div class="choseformat radiocss inputpub"><!--模型格式-->
                                   <span class="padfr fl mar7">模型格式<i>*</i></span>
                                   <div class="fl marlf" style=" margin-top:10px;">
                                   <label>
                                    MAX<input type="radio" name="model_format_s" value="max" class="marlf">
                                   </label>
                                   <label style=" margin-left:40px;">
                                   MYAY<input type="radio" name="model_format_s" value="myay"  class="marlf">
                                   </label>
                                   <label style=" margin-left:40px;">
                                   其他<input type="radio" name="model_format_s" value="其他" class="marlf">
                                   </label> 
                                   <input type="text" name="model_format_other" style="background:none; width:134px; height:36px;"/>
                                   </div>
                                   <div class="clear"></div>
                        </div><!--模型格式结束-->
                        <div class="inline"></div>
                        <div class="choseprecision radiocss inputpub"><!--模型精度-->
                                   <span class="padfr fl">模型精度<i>*</i></span>
                                   <div class="fl marlf" style=" margin-top:10px;"> 
                                   <label >
                                   高精度模型<input type="radio"   checked="checked" name="precision" value="高精度模型" class="marlf">
                                   </label>
                                   <label style="margin-left:40px">
                                   一般精度模型<input type="radio"  name="precision" value="一般精度模型" class="marlf">
                                   </label> 
                                   <label style=" margin-left:40px">
                                   底精度模型<input type="radio"  name="precision" value="底精度模型" class="marlf">
                                   </label>
                                   </div>
                                   <div class="clear"></div>
                        </div><!--模型精度结束-->
                        <div class="inline"></div>
                        <div class="chosemodel radiocss inputpub"><!--是否销售（模型）-->
                                   <span class="padfr fl">是否销售<i>*</i></span>
                                   <div class="fl marlf" style=" margin-top:10px;">
                                   <label >
                                   销售<input type="radio" checked="checked" name="sales" class="marlf" value="1">
                                   </label> 
                                   <label style=" margin-left:40px;">
                                   展示<input type="radio"  name="sales" value="2" class="marlf">
                                   </label>
                                   </div>
                                   <div class="clear"></div>
                        </div><!--是否销售结束-->
                        <div class="inline"></div> 
                        <div class="money inputpub"><!--定价-->
                                   <span class="padfr fl mar7">定价<i>*</i></span>
                                   <div class=" marlf fl">
                                        <table>
                                           <tr>
                                               <td>使用许可：6个月</td>
                                               <td><input type="text" name="price_a" /></td>
                                               <td>元</td>
                                           </tr>
                                            <tr>
                                               <td>使用许可：12个月</td>
                                               <td><input type="text" name="price_b" /></td>
                                               <td>元</td>
                                           </tr>
                                            <tr>
                                               <td>使用许可：24个月</td>
                                               <td><input type="text" name="price_c" /></td>
                                               <td>元</td>
                                           </tr>
                                            <tr>
                                               <td>著作财产转让权</td>
                                               <td><input type="text" name="price_d" /></td>
                                               <td>元</td>
                                           </tr>
                                        </table>
                                   </div>
                                <div class="clear"></div>
                        </div><!--定价结束-->
                        <div class="inline"></div>
                        <div class="surface  inputpub"><!--上传缩略图-->
                                   <span class="padfr fl">上传缩略图<i>*</i></span>
                                   <input type="" class="fl marlf"/> 
                                   <label><input  type="file"  name="covers_s" class="flie fl btn" value="上传" /></label> 
                                   <div class="clear"></div>
                        </div><!--上传缩略图结束-->
                        <div class="inline"></div> 
                        <div class="surface  inputpub"><!--上传附件-->
                                   <span class="padfr fl">上传附件<i>*</i></span>
                                   <input type="text" class="fl marlf" /> 
                                   <label><input  type="file" name="file1" class="flie fl btn" value="上传" /></label>
                                   <div class="clear"></div> 
                        </div><!--上传附件结束-->
                        <div class="inline"></div> 
                        <div class="chosesmodel radiocss inputpub"><!--是否同步至官网-->
                                   <span class="padfr fl">是否同步至官网首页<i>*</i></span>
                                   <div class="fl marlf" style=" margin-top:10px;">
                                   <label >
                                   是<input type="radio" name="homepage" value="1"  checked="checked"  class="marlf">
                                   </label>
                                   <label  style=" margin-left:40px;">
                                   否<input type="radio"  name="homepage" value="2" class="marlf">
                                   </label>
                                   </div>
                                   <div class="clear"></div>
                        </div><!--是否同步至官网结束-->
                        <div class="inline"></div> 
                          <div class="inputpub videobanquan"><!--模型版权所有认证-->                        
                                <input type="checkbox" value="模型版权所有认证"/>
                                <img src="/Public/Home/images/checked.png" style=" vertical-align:middle;" onclick="javascript:copyright(this);" />
                                <span class="banquan">模型版权所有认证</span>
                        </div><!--模型版权所有认证-->
                        <div class="inline"></div> 
                         <div class="inputpub videobanquan"><!--视频版权说明-->                        
                                <input type="checkbox" value="我同意网站的规则"/>
                                <img src="/Public/Home/images/checked.png" style=" vertical-align:middle;" onclick="javascript:site_rule(this);" />
                                <span class="banquan">我同意网站的规则</span>
                        </div><!--视频版权说明结束-->
                        <div class="inline"></div>
                         <div class="anniu">
                             <button type="button" onclick="model_upload('save')" >保存</button>
                             <button type="button" onclick="model_upload('publish')" >发布</button>
                         </div>
                     </form>       
                  </div><!--模型结束--> 
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
 <div class="gjl">
 <a href=""><div class="gjl_1"></div></a>
 <a href=""><div class="gjl_2"></div></a>
 
 <a href=""><div class="gjl_3"></div></a>
 <a href=""><div class="gjl_4"></div></a>
 <a href=""><div class="gjl_5"></div></a>
 <a href="#heads"><div class="gjl_6"></div></a>
</div>
 <script>
    $(function(){
    $('.tab ul a li').click(function(){
      // $(this).addClass('uploadcss').siblings().removeClass('uploadcss')
      var $tab = $(this).attr('title');
         $("." + $tab).show().siblings().hide()
      })

<!--是否销售-->（模型）     
   $('.chosemodel label').each(function(){
        $(this).bind('click',function(){
            $('.chosemodel label').removeAttr('class');
            $(this).attr('class', 'checked');
            $('.chosemodel label').find('input').removeAttr('checked', 'checked');
            $(this).find('input').attr('checked', 'checked');
        });
    });

  <!--模型格式-->（模型）
   $('.choseformat label').each(function(){
        $(this).bind('click',function(){
            $('.choseformat label').removeAttr('class');
            $(this).attr('class', 'checked');
            $('.choseformat label').find('input').removeAttr('checked', 'checked');
            $(this).find('input').attr('checked', 'checked');
        });
    });
 <!--模型精度-->（模型）
   $('.choseprecision label').each(function(){
        $(this).bind('click',function(){
            $('.choseprecision label').removeAttr('class');
            $(this).attr('class', 'checked');
            $('.choseprecision label').find('input').removeAttr('checked', 'checked');
            $(this).find('input').attr('checked', 'checked');
        });
    });
   <!--是否同步至官网首页-->（模型） 
   $('.chosesmodel label').each(function(){
        $(this).bind('click',function(){
            $('.chosesmodel label').removeAttr('class');
            $(this).attr('class', 'checked');
            $('.chosesmodel label').find('input').removeAttr('checked', 'checked');
            $(this).find('input').attr('checked', 'checked');
        });
    });
 
  $(".select").each(function(){
    var s=$(this);
    var z=parseInt(s.css("z-index"));
    var dt=$(this).children("dt");
    var dd=$(this).children("dd");
    var _show=function(){dd.slideDown(200);dt.addClass("cur");s.css("z-index",z+1);};   //展开效果
    var _hide=function(){dd.slideUp(200);dt.removeClass("cur");s.css("z-index",z);};    //关闭效果
    dt.click(function(){dd.is(":hidden")?_show():_hide();});
    dd.find("a").click(function(){dt.html($(this).html());_hide();});     //选择效果（如需要传值，可自定义参数，在此处返回对应的“value”值 ）
    $("body").click(function(i){ !$(i.target).parents(".select").first().is(s) ? _hide():"";});
  })  
  
  $('.chosepic ul li').click(function(){
      var $tab = $(this).attr('title');
      $("."+ $tab).show().siblings().hide();
    })
    
    });
    

   // 模型版权所有认证
 function copyright(obj)
        {  
          var fn=obj.src;
          var pclass = obj.parentNode.getAttribute('class');
          var pdd = obj.parentNode.getAttribute('pdd');
            fn=fn.substring(fn.lastIndexOf("/")+1);
            if(fn=='checked.png'){
                obj.src='/Public/Home/images/checks.png';
                obj.parentNode.setAttribute('class',pclass+' copyright_explain');
                obj.parentNode.setAttribute('pdd',pclass);
            }else{
                obj.src='/Public/Home/images/checked.png';
                obj.parentNode.setAttribute('class',pdd);
                obj.parentNode.removeAttribute('pdd');
            }
        }
        
// 网站的规则
 function site_rule(obj)
        {  
          var fn=obj.src;
          var pclass = obj.parentNode.getAttribute('class');
          var pdd = obj.parentNode.getAttribute('pdd');
            fn=fn.substring(fn.lastIndexOf("/")+1);
            if(fn=='checked.png'){
                obj.src='/Public/Home/images/checks.png';
                obj.parentNode.setAttribute('class',pclass+' site_rule');
                obj.parentNode.setAttribute('pdd',pclass);
            }else{
                obj.src='/Public/Home/images/checked.png';
                obj.parentNode.setAttribute('class',pdd);
                obj.parentNode.removeAttribute('pdd');
            }
        }
        </script>
        <script type="text/javascript">
 function model_upload(types) {

//判断值 列表
            var title =  $("input[name='title']").val();//作品名称 
            var instruct = $("textarea[name='instruct']").val();//作品简介 
            var opus_type = $("input[name='opus_type']").val();//作品类别 
            var car_logo = $("input[name='car_logo']").val();//产品车型-品牌 
            var car_type = $("input[name='car_type']").val();//产品车型-车型
            var car_type_s = $("input[name='car_type_s']").val();//产品车型-车型
            var car_model = $("input[name='car_model']").val();//产品车型-车款
            var car_model_s = $("input[name='car_model_s']").val();//产品车型-车款   
            var tags = $("input[name='tags']").val(); //标签
            var year = $("input[name='year']").val();//创建时间-年
            var month = $("input[name='month']").val();//创建时间-月
            var day = $("input[name='day']").val();//创建时间-日

            var model_faces = $("input[name='model_faces']").val();//模型面数（参数）
            var model_format_s = $("input[name='model_format_s']:checked").val();//模型格式
            var model_format_other = $("input[name='model_format_other']").val();//模型格式
            var precision = $("input[name='precision']:checked").val();//模型精度
            var sales = $("input[name='sales']:checked").val();//是否销售 
            var price_a = $("input[name='price_a']").val();//使用许可：6个月-价格  
            var price_b = $("input[name='price_b']").val();//使用许可：12个月-价格
            var price_c = $("input[name='price_c']").val();//使用许可：24个月-价格  
            var price_d = $("input[name='price_d']").val();//著作财产转让权-价格

            var covers_s = $("input[name='covers_s']").val();//作品封面
            var file1 = $("input[name='file1']").val();//上传附件
            var homepage = $("input[name='homepage']:checked").val();//是否同步至官网首页
            
            var error_message="";
                if(!title){error_message += '“作品名称” 不能为空\n';}
                if(!instruct){error_message += '“作品简介” 不能为空\n';}
                if(!opus_type){error_message += '“作品类别” 没有选择\n';}
                if(!car_logo){error_message += '“产品车型-品牌” 不没有选择\n';}
                if(!car_type){
                  if(!car_type_s){
                      error_message += '“车系” 没有选择或不能为空\n';
                  }else{
                      $("input[name='car_type']").val(car_type_s);
                  }
                }else{
                  if(car_type=="其他"){
                    if(!car_type_s){
                      error_message += '“车系” 没有选择或不能为空\n';
                    }else{
                       $("input[name='car_type']").val(car_type_s);
                    }
                  }
                }
                if(!car_model){
                  if(!car_model_s){
                      error_message += '“车款” 没有选择或不能为空\n';
                  }else{
                      $("input[name='car_model']").val(car_model_s);
                  }
                }else{
                  if(car_model=="其他"){
                    if(!car_model_s){
                      error_message += '“车系” 没有选择或不能为空\n';
                    }else{
                       $("input[name='car_model']").val(car_model_s);
                    }
                  }
                }
                if(!tags){error_message += '“自定义标签” 不能为空\n';}
                if(!year){error_message += '“创建时间-年份” 没有选择\n';}
                if(!month){error_message += '“创建时间-月份” 没有选择\n';}
                if(!day){error_message += '“创建时间-日” 没有选择\n';}
                if(year && month && day){
                   $("input[name='select_time']").val(year+','+month+','+day);
                }

                if(!model_faces){error_message += '“模型面数（参数）” 不能为空\n';}
                if(!model_format_s){
                  error_message += '“模型格式” 没有选择或不能为空\n';
                }else{
                  if(model_format_s=="其他"){
                    if(!model_format_other){
                      error_message += '“模型格式” 不能为空\\n';
                    }else{
                      $("input[name='model_format']").val(model_format_other.toLowerCase());
                    }
                  }else{
                    $("input[name='model_format']").val(model_format_s.toLowerCase());
                  }
                }
                if(!precision){error_message += '“模型精度” 没有选择\n';}
                if(!sales){error_message += '“是否销售” 没有选择\n';}
                if(!price_a){error_message += '“使用许可：6个月-价格” 不能为空\n';}
                if(!price_b){error_message += '“使用许可：12个月-价格” 不能为空\n';}
                if(!price_c){error_message += '“使用许可：24个月-价格” 不能为空\n';}
                if(!price_d){error_message += '“著作财产转让权-价格” 不能为空\n';}


                if(!covers_s){error_message += '“缩略图” 没有上传\n';}
                if(!file1){error_message += '“附件” 没有上传\n';}
                if(!homepage){error_message += '“是否同步至官网首页” 没有选择\n';}
                if(!$('div').hasClass('copyright_explain')){error_message += '“视频版权说明” 没有选择\n';}
                if(!$('div').hasClass('site_rule')){error_message += '“网站的规则” 未被用户同意\n';}
                
            if(types=='save'){
              $("input[name='state']").val(1);
              if(error_message){
                    alert(error_message); 
                }else{
                  $('form').submit();
                }
            }else if(types=='publish'){
              $("input[name='state']").val(2);
              if(error_message){
                    alert(error_message); 
                }else{
                  $('form').submit();
                }
            }
        }
</script>
 </script>
</body>
</html>