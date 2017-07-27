<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="Content-Language" content="zh-CN">
        <title>MCAKE-一直都是巴黎的味道</title>
        <meta name="Keywords" content="Mcake,M'cake,蓝莓轻乳拿破仑,经典香草拿破仑,拿破仑莓恋,拿破仑，胡桃布拉吉，榛果摩卡布拉吉，魅影歌剧院，巧克力格调，天使巧克力，魔鬼巧克力，蒸清抹茶，蔓越莓红丝绒，沙布雷巴菲，巧克力狂想曲，卡法香缇，瑞可塔厚爱，法香奶油可丽，莓果青柠慕斯＂">
        <meta name="Description" content="Mcake把法国传统蛋糕文化带入中国，提供纯正的欧式味觉体验，同时也将欧洲的上好材质、经典工艺以及优雅的文艺气质，融入产品的每一个细节之中，带给客户更多的享受与愉悦。">
        <meta http-equiv="X-UA-Compatible" content="IE=7">
        <meta http-equiv="cache-control" content="max-age=1800">
        
        <link rel="shortcut icon" href="/mcake/Public/images/icons/favicon.ico">
        <link rel="stylesheet" type="text/css" href="/mcake/Public/Index/css/comm_header.css">
        <link rel="stylesheet" type="text/css" href="/mcake/Public/Index/css/Landing_city.css">

        <link rel="stylesheet" type="text/css" href="/mcake/Public/Index/css/ebsig.css">
        <link rel="stylesheet" type="text/css" href="/mcake/Public/Index/css/goods.css">
        <link rel="stylesheet" type="text/css" href="/mcake/Public/Index/css/login.css">
        
        <script type="text/javascript" src="/mcake/Public/Index/js/jquery.js"></script>

        <link rel="stylesheet" type="text/css" href="/mcake/Public/Index/css/index.css">
    </head>
    <body>
<!-- header开始 -->
<a name="top"></a>
<div class="header">
    
    <div class="header_top_box">
        <div class="header_top">
            <div style="width:100%; height:100px; background:#FFF; position:absolute; z-index:9;webkit-box-shadow: 3px 3px 3px #e1e1e1;-moz-box-shadow: 3px 3px 3px #e1e1e1;box-shadow: 3px 3px 3px #e1e1e1">
                <div style="width:100%; height:30px; border-bottom:1px solid #eaeaea">
                    <div class="wallbox wall_top">
                        <div id="scrollobj" style="position:absolute; left:50%;margin-left:-300px;top:0; width:560px; line-height:30px;white-space:nowrap;overflow:hidden; color:#F00"></div>
                        <div class="logoer">
                            <a href="<?php echo U(Home/Index/index);?>">
                                <img src="/mcake/Public/Index/images/logo/logo.png">
                            </a>
                        </div>
                        <ul class="navbar" id="welcome">
                            <?php if(isset($_SESSION['id'])): ?><li><a href="<?php echo U('Home/Members/center');?>" class="Gold">欢迎您<?php echo (session('usercount')); ?></a></li>
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                <li><a href="<?php echo U('Home/Login/logout');?>" class="Gold" id="clearsession">[&nbsp;退出&nbsp;]</a></li>
                            <?php else: ?>
                                <li><a href="<?php echo U('Home/Login/dologin');?>" class="Gold">LOG IN 登录</a></li>
                                <li>
                                    <a href="<?php echo U('Home/Login/signin');?>" class="Gold">SIGN UP 注册</a>
                                </li><?php endif; ?>
                        </ul>
                        <ul class="navbar">
                            <li class="m_mail" style="display: none;">
                                <a href="http://www.mcake.com/shop/member_message.html" class="Gold" target="_blank"><i></i> <span id="msg_count">0</span>封</a>
                            </li>
                            <li class="m_cart">
                                <a href="<?php echo U('Home/ShopCart/index');?>" class="Gold" target="_blank"><i></i>
                                <span id="cart_amount">
                                    <!--判断件数 session['goodsnum']-->
                                     <?php if(isset($_SESSION['goodsnum'])&&isset($_SESSION['id'])): echo (session('goodsnum')); ?>
                                    <?php else: ?>
                                        <!--判断件数 结束-->
                                        0<?php endif; ?>
                                </span>件</a>
                            </li>
                        </ul>
                        <div class="clear"></div>
                    </div>
                </div>
                <div class="wallbox">
                    <div class="header_right">
                        <ul class="phone_delivery">
                            <li class="phone">
                                <span>4006-678-678</span><i></i>
                            </li>
                            <li class="delivery">
                                <span>
                                    <a href="<?php echo U('Home/Article/express');?>" target="_blank" id="addresscity">北京配送范围免费配送</a>
                                </span><i></i>
                            </li>
                        </ul>
                    </div>
                    <ul class="menu">
                        <li>
                            <a href="<?php echo U('Home/Index/index');?>" class="ebsig_all_goods" target="_blank"><samp>Nos Produits</samp><span>全部产品</span>
                            </a>
                        </li>
                        <li>
                                    
                            <a href="<?php echo U('Home/Napolen/napolen');?>" target="_blank"><samp>Napoléon</samp><span>拿破仑系列</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo U('Home/Active/index');?>" target="_blank"><samp>Nouveauté</samp><span>最新活动</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo U('Home/Members/center');?>" target="_blank">
                                <samp>Mon M'CAKE</samp>
                                <span>会员中心</span>
                            </a>
                        </li>
                    </ul>
                    <div class="clear"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--header 结束 -->
<!-- contents开始 -->
    <!-- 注册 开始 -->
    <div class="login_box">

        <form id="reg_form" action="<?php echo U('Home/Login/dosignin');?>" method="post">

            <div class="login_right Forget_box">

                <ul>
                    <li>
                        <p class="top_border">
                            <span>会员注册</span>
                        </p>
                    </li>
                    <li>
                        <input class="input_txt Mobile_icon" placeholder="手机号码" name="phone" type="text">
                        <span class="err" id="regName_error"></span>
                    </li>
                    <li>
                        <input class="input_txt Mobile_code_icon" placeholder="手机验证码" name="scode" type="text">
                        <div class="send">
                            <a href="javascript:void(0);" class="go" id="reg_sms_btn">发送验证码 <small>&gt;&gt;</small></a>
                            <p class="err" id="smsyzm_error"></p>
                        </div>
                    </li>

                    <li>
                        <input class="input_txt password_icon" placeholder="新密码" name="pass" type="password">
                        <span class="err" id="regPwd_error">密码必须是6-30位字符，可使用字母、数字</span>
                    </li>

                    <li>
                        <input class="input_txt Confirm_password_icon" placeholder="密码确认" name="repass" type="password">
                        <span class="err" id="regPwd2_error"></span>
                    </li>

                    <li class="Agreement" id="diugou">
                        <i ></i><em style="background-position:0 -280px;display:block"></em>
                        <input name="agreement" checked="checked" hidden="hidden" type="checkbox">
                        <p><a id="xieyi">同意 《M'cake购物协议》</a></p>
                    </li>

                    <li>
                        <div class="btn_c_box">
                            <input value="提交" class="login_btn" type="submit">
                        </div>
                    </li>

                </ul>

            </div>

        </form>
        

        <div class="back_right">

            <a href="<?php echo U('Home/Login/dologin');?>"><span><i></i><p>我已经注册，<br>现在就 <font class="red">登录</font></p></span></a>

        </div>

    </div>
</div>
    
    <!-- 注册 结束 -->
    <!-- 网站用户注册协议  开始 -->
<div id="myCover" class="tc-cover" style="height: 836px; display: none;"></div>
<div id="maximPanel" class="tc-con-order" style="margin-left: -310px; display: none; margin-top: -262.5px;">
    <a id="guanbi" class="close close_2" href="javascript:void(0);">关闭</a>
    <div class="tc-con-1">
        <!-- <div id="agreement_box" > -->
            <div style="width: 600px; height: 500px;overflow-y:auto; overflow-x: hidden;word-wrap: break-word;word-break: normal;">
<pre>                          <b>MCAKE网站用户注册协议</b>
                          <br>
本协议是您与MCAKE网站（网址：www.mcake.com）所有者（以下简称为"MCAKE"或"本站"）之间就MCAKE网站服务等相关事宜所订立的契约，请您仔细阅读本注册协议，您勾选"同意《MCAKE购物协议》"复选框按钮并提交后，本协议即构成对双方有约束力的法律文件。
第1条 本站服务条款的确认和接纳
1.1本站的各项电子服务的所有权和运作权归MCAKE所有。您同意所有注册协议条款并完成注册程序，才能成为本站的正式用户。您确认：本协议条款是处理双方权利义务的依据，始终有效，法律另有强制性规定或双方另有特别约定的，依其规定或约定。
1.2您点击同意本协议的，即视为您确认自己具有享受本站服务、下单购物等相应的权利能力和行为能力，能够独立承担法律责任。
1.3您确认，如果您在18周岁以下，您只能在父母或其他监护人的监护参与下才能使用本站。
1.4MCAKE保留在中华人民共和国大陆地区施行之法律允许的范围内独自决定拒绝服务、关闭用户账户、清除或编辑内容或取消订单的权利。
1.5您使用本站提供的服务时，应同时接受适用于本站特定服务、活动等的准则、条款和协议（以下统称为“其他条款”）；如果以下使用条件与“其他条款”有不一致之处，则以“其他条款”为准。
1.6为表述便利，商品和服务简称为“商品”或“货物”。
第2条 本站服务
2.1 MCAKE运用自己的操作系统通过国际互联网络依法为用户提供网络服务，用户在完全同意本协议及本站规定的情况下，方有权使用本站的相关服务。

2.2 用户必须自行准备如下设备和承担如下开支：（1）上网设备，包括并不限于电脑或者其他上网终端、调制解调器及其他必备的上网装置；（2）上网开支，包括并不限于网络接入费、上网设备租用费、手机流量费等。
第3条 用户信息
3.1 用户应自行诚信向本站提供注册资料，用户同意其提供的注册资料真实、准确、完整、合法有效，用户注册资料如有变动的，应及时更新其注册资料。如果用户提供的注册资料不合法、不真实、不准确、不详尽的，用户需承担因此引起的相应责任及后果，并且MCAKE保留终止用户使用本站各项服务的权利。

3.2 用户在本站进行浏览、下单购物等活动时，涉及用户真实姓名/名称、通信地址、联系电话、电子邮箱等隐私信息的，本站将予以严格保密，除非得到用户的授权或法律另有规定，本站不会向外界披露用户隐私信息。

3.3 用户注册成功后，将产生用户名和密码等账户信息，您可以根据本站规定改变您的密码。用户应谨慎合理的保存、使用其用户名和密码。用户若发现任何非法使用用户账号或存在安全漏洞的情况，请立即通知本站并向公安机关报案。

3.4 每位用户只允许在MCAKE拥有一个有效账户，如有证据证明或MCAKE有理由相信用户存在恶意注册多个账户的情形，MCAKE有权采取取消订单、冻结或关闭账户等措施，给MCAKE造成损失的，用户应承担赔偿责任。

3.5 用户同意，MCAKE拥有通过邮件、短信电话等形式，向在本站注册、购物用户、收货人发送订单信息、促销活动等告知信息的权利。

3.6 用户不得将在本站注册获得的账户借给他人使用，否则用户应承担由此产生的全部责任，并与实际使用人承担连带责任。
3.7 用户同意，MCAKE有权使用用户的注册信息、用户名、密码等信息，登陆进入用户的注册账户，进行证据保全，包括但不限于公证、见证等。
3.8用户同意，用户个人对网络服务的使用承担风险。MCAKE不担保服务一定能满足用户的要求，也不担保服务不会因某些特殊原因中断，对服务的及时性，安全性，出错发生均不作担保。
第4条 用户依法言行义务
本协议依据国家相关法律法规规章制定，用户同意严格遵守以下义务：
（1）不得传输或发表：煽动抗拒、破坏宪法和法律、行政法规实施的言论，煽动颠覆国家政权，推翻社会主义制度的言论，煽动分裂国家、破坏国家统一的的言论，煽动民族仇恨、民族歧视、破坏民族团结的言论；
（2）从中国大陆向境外传输资料信息时必须符合中国有关法规；
（3）不得利用本站从事洗钱、窃取商业秘密、窃取个人信息等违法犯罪活动；
（4）不得干扰本站的正常运转，不得侵入本站及国家计算机信息系统；
（5）不得传输或发表任何违法犯罪的、骚扰性的、中伤他人的、辱骂性的、恐吓性的、伤害性的、庸俗的，淫秽的、不文明的等信息资料；
（6）不得传输或发表损害国家社会公共利益和涉及国家安全的信息资料或言论；
（7）不得教唆他人从事本条所禁止的行为；
（8）不得利用在本站注册的账户进行牟利性经营活动；
（9）不得发布任何侵犯他人著作权、商标权等知识产权或合法权利的内容；用户应不时关注并遵守本站不时公布或修改的各类合法规则规定。本站保有删除站内各类不符合法律政策或不真实的信息内容而无须通知用户的权利。

若用户未遵守以上规定的，本站有权作出独立判断并采取暂停或关闭用户帐号等措施。用户须对自己在网上的言论和行为承担法律责任。
第5条 商品信息
本站上的商品价格、数量、是否有货等商品信息随时都有可能发生变动，本站不作特别通知。由于网站上商品信息较多，虽然本站会尽最大努力保证您所浏览商品信息的准确性，但由于众所周知的互联网技术因素等客观原因存在，本站网页显示的信息可能会有一定的滞后性或差错，对此情形您知悉并理解；MCAKE欢迎纠错，并会视情况给予纠错者一定的奖励。
第6条 订单
6.1 在您下订单时，请您仔细确认所购商品的名称、价格、数量、尺寸、联系地址、电话、收货人等信息。收货人与用户本人不一致的，收货人的行为和意思表示视为用户的行为和意思表示，用户应对收货人的行为及意思表示的法律后果承担连带责任。

6.2 除法律另有强制性规定外，双方约定如下：本站上销售方展示的商品和价格等信息 仅仅是要约邀请，您下单时须填写您希望购买的商品数量、价款及支付方式、 收货人、联系方式、收货地址（合同履行地点）、合同履行方式等内容；系统生成的订单信息是计算机信息系统根据您填写的内容自动生成的数据，仅是您向销售方发出的合同要约；销售方收到您的订单信息后，只有在销售方将您在订单中订购的商品从仓库实际直接向您发出时（ 以商品出库为标志），方视为您与销售方之间就实际直接向您发出的商品建立了合同关系；如果您在一份订单里订购了多种商品并且销售方只给您发出了部分商品时，您与销售方之间仅就实际直接向您发出的商品建立了合同关系；只有在销售方实际直接向您发出了订单中订购的其他商品时，您和销售方之间就订单中该其他已实际直接向您发出的商品才成立合同关系。您可以随时登陆您在本站注册的账户，查询您的订单状态。

6.3 由于市场变化及各种以合理商业努力难以控制的因素的影响，本站无法保证您提交的订单信息中希望购买的商品都会有货；如您拟购买的商品，发生缺货，您有权取消订单。
第7条 配送
7.1 MCAKE将会把商品送到您所指定的收货地址，所有在本站上列出的送货时间为参考时间，参考时间的计算是根据库存状况、正常的处理过程和送货时间、送货地点的基础上估计得出的。送货费用根据用户选择的配送方式的不同而异。

7.2请清楚准确地填写用户的真实姓名、送货地址及联系方式。因如下情况造成订单延迟或无法配送等，MCAKE不承担延迟配送的责任：
（1）用户提供的信息错误、地址不详细等原因导致的；
（2）货物送达后无人签收，导致无法配送或延迟配送的；
（3）情势变更因素导致的；
（4）不可抗力因素导致的，例如：自然灾害、交通戒严、突发战争等。
第8条 所有权及知识产权条款
8.1 用户一旦接受本协议，即表明该用户主动将其在任何时间段在本站发表的任何形式的信息内容（包括但不限于客户评价、客户咨询、各类话题文章等信息内容）的财产性权利等任何可转让的权利，如著作权财产权（包括并不限于：复制权、发行 权、出租权、展览权、表演权、放映权、广播权、信息网络传播权、摄制权、改编权、翻译权、汇编权以及应当由著作权人享有的其他可转让权利），全部独家且不可撤销地转让给MCAKE所有，用户同意MCAKE有权就任何主体侵权而单独提起诉讼。

8.2 本协议已经构成《中华人民共和国著作权法》第二十五条（条文序号依照2011年版著作权法确定）及相关法律规定的著作财产权等权利转让书面协议，其效力及于用户在MCAKE网站上发布的任何受著作权法保护的作品内容，无论该等内容形成于本协议订立前还是本协议订立后。

8.3 用户同意并已充分了解本协议的条款，承诺不将已发表于本站的信息，以任何形式发布或授权其它主体以任何方式使用（包括但限于在各类网站、媒体上使用）。

8.4 MCAKE是本站的制作者,拥有此网站内容及资源的著作权等合法权利,受国家法律保护,有权不时地对本协议及本站的内容进行修改，并在本站张贴，无须另行通知用户。在法律允许的最大限度范围内，MCAKE对本协议及本站内容拥有解释权。

8.5 除法律另有强制性规定外，未经MCAKE明确的特别书面许可,任何单位或个人不得以任何方式非法地全部或部分复制、转载、引用、链接、抓取或以其他方式使用本站的信息内容，否则，MCAKE有权追究其法律责任。

8.6 MCAKE网站上的图表、标识、网页页眉、按钮图标、文字、服务品名等标示在网站上的信息都是MCAKE网站运营方及其关联方的财产，受中国和国际知识产权法的保护。未经MCAKE网站许可，任何人不得使用、复制或用作其他用途。在MCAKE网站上出现的其他商标是其商标权利人各自的财产，未经MCAKE网站运营方或相关商标所有人的书面许可，任何第三方都不得使用。
第9条 责任限制及不承诺担保
9.1除非另有明确的书面说明,本站及其所包含的或以其它方式通过本站提供给您的全部信息、内容、材料、产品（包括软件）和服务，均是在"按现状"和"按现有"的基础上提供的。

9.2除非另有明确的书面说明,MCAKE不对本站的运营及其包含在本网站上的信息、内容、材料、产品（包括软件）或服务作任何形式的、明示或默示的声明或担保（根据中华人民共和国法律另有规定的以外）。

9.3MCAKE不担保本站所包含的或以其它方式通过本站提供给您的全部信息、内容、材料、产品（包括软件）和服务、其服务器或从本站发出的电子信件、信息没有病毒或其他有害成分。

9.4如因不可抗力或其它本站无法控制的原因使本站销售系统崩溃或无法正常使用导致网上交易无法完成或丢失有关的信息、记录等，MCAKE会合理地尽力协助处理善后事宜。
9.5您了解并同意，MCAKE有权应国家有关机关的要求，向其提供您在京东的用户信息和交易记录等必要信息。如您涉嫌侵犯他人合法权益，则京东有权在初步判断涉嫌侵权行为可能存在的情况下，向权利人提供您必要的个人信息。
第10条 协议更新及用户关注义务
根据国家法律法规变化及网站运营需要，MCAKE有权对本协议条款不时地进行修改，修改后的协议一旦被张贴在本站上即生效，并代替原来的协议。用户可随时登陆查阅最新协议；用户有义务不时关注并阅读最新版的协议及网站公告。如用户不同意更新后的协议，可以且应立即停止接受MCAKE网站依据本协议提供的服务；如用户继续使用本网站提供的服务的，即视为同意更新后的协议。MCAKE建议您在使用本站之前阅读本协议及本站的公告。 如果本协议中任何一条被视为废止、无效或因任何理由不可执行，该条应视为可分的且并不影响任何其余条款的有效性和可执行性。
第11条 法律管辖和适用
本协议的订立、执行和解释及争议的解决均应适用在中华人民共和国大陆地区适用之有效法律（但不包括其冲突法规则）。 如发生本协议与适用之法律相抵触时，则这些条款将完全按法律规定重新解释，而其它有效条款继续有效。 如缔约方就本协议内容或其执行发生任何争议，双方应尽力友好协商解决；协商不成时，任何一方均可向有管辖权的中华人民共和国大陆地区法院提起诉讼。
第12条 其他
12.1 MCAKE网站所有者是指在政府部门依法许可或备案的MCAKE网站经营主体。

12.2 MCAKE尊重用户和消费者的合法权利，本协议及本网站上发布的各类规则、声明等其他内容，均是为了更好的、更加便利的为用户和消费者提供服务。本站欢迎用户和社会各界提出意见和建议，MCAKE将虚心接受并适时修改本协议及本站上的各类规则。

12.3 本协议内容中以黑体、加粗、下划线、斜体等方式显著标识的条款，请用户着重阅读。

12.4 您勾选复选框按钮"同意《MCAKE购物协议》"，提交后即视为您完全接受本协议，在点击之前请您再次确认已知悉并完全理解本协议的全部内容。

                </pre>
            <!-- </div> -->
        </div>
    </div>
</div>
    <!-- 网站用户注册协议 结束 -->

    <!-- contents 结束-->



<!-- footer开始 -->
    
<div id="footer">
    <!-- 底部小活动li 开始 -->
    <div id="wallbox" class="wallbox">
        <ul class="activity_list" id="activity_list">
            <li>
                <a href="" target="_blank">
                    <img src="/mcake/Public/Index/images/2015072811191115080.jpg" alt="" width="100%">
                </a>
            </li>
            <li>
                <a href="" target="_blank">
                    <img src="/mcake/Public/Index/images/2015082009154299636.jpg" alt="" width="100%">
                </a>
            </li>
            <li>
                <a href="" target="_blank"><img src="/mcake/Public/Index/images/2015070313312260770.jpg" alt="" width="100%">
                </a>
            </li>
        </ul>
        <div class="clear"></div>
    </div>
    <!-- 底部小活动li 结束 -->
    <div class="wallbox_1000">
        <div class="m_copy">
            <ul class="Share">
                <li class="Swb">
                    <a href="http://weibo.com/mcake1893" target="_blank"></a>
                </li>
                <li class="Twx">
                    <a href="javascript:void(0);"></a>
                </li><!--<li class="Tkj"><a href="#"></a></li>-->
            </ul>
            <div class="wxqr"><samp></samp></div>
            <p>Copyright © 2012-2015            </p>
            <p>上海卡法电子商务有限公司 版权所有</p>
            <p class="icp_no">沪ICP备12022075号</p>
            <p class="icp_no">地址：上海市普陀区同普路1130弄3号</p>
            <p class="icp_no">客服热线：4006-678-678</p>
            <p class="icp_no">客服邮箱：cs@mcake.com</p>
        </div>
        <div class="foot_nav_bar">
            <dl>
                <dt>
                    <a href="<?php echo U('Home/Article/express');?>">发现</a>
                </dt>
                <dd>
                    <a href="<?php echo U('Home/Article/express');?>" target="_blank">配送服务</a>
                </dd>
                <dd>
                    <a href="http://weibo.com/mcake1893" target="_blank">微博</a>
                </dd>
            </dl>
            <dl>
                <dt>
                    <a href="<?php echo U('Home/Article/express');?>">关于我们</a>
                </dt>
                <dd>
                    <a href="<?php echo U('Home/Article/index');?>" target="_blank">媒体合作</a>
                </dd>
                <dd>
                    <a href="<?php echo U('Home/Article/job');?>" target="_blank">招贤纳士</a>
                </dd>
                <dd>
                    <a href="<?php echo U('Home/Article/call');?>" target="_blank">呼叫中心</a>
                </dd>
            </dl>
            <dl>
                <dt>
                    <a href="<?php echo U('Home/Article/express');?>">帮助中心</a>
                </dt>
                <dd>
                    <a href="<?php echo U('Home/Article/vip');?>" target="_blank">会员权益</a>
                </dd>
                <dd>
                    <a href="<?php echo U('Home/Article/shop');?>" target="_blank">购物指南</a>
                </dd>
                <dd>
                    <a href="<?php echo U('Home/Article/pay');?>" target="_blank">支付类</a>
                </dd>
                <dd>
                    <a href="<?php echo U('Home/Article/order');?>" target="_blank">订单相关</a>
                </dd>
            </dl>
        </div>
        <div class="m_wb" style="text-align: center;">
            <img src="/mcake/Public/Index/images/icons/wx_icon.png" <="" div="">
            <div class="clear"></div>
        </div>
        <div class="clear"></div>
    </div>
</div>
<!-- footer结束 -->
<script type="text/javascript">
    var R = false;
    var E = false;
    var S = false;
    var W = false;
    //检测手机号
    $('input[name=phone]').blur(function(){
        var v = $(this).val();
        var reg = /^1([3,5,8]{1})\d{9}$/;
        if(!reg.test(v)){
            R = false;
            $(this).next().html('手机号输入有误,请重新输入');
        }else{
            R = true;
            $(this).next().html('');
        }
    })
    // 检测密码
    $('input[name=pass]').blur(function(){
        var v = $(this).val();
        var reg = /^([A-Za-z0-9]){6,30}$/;
        if(!reg.test(v)){
            E = false;
            $(this).next().html('密码格式有误,请输入6-30位字母,数字')
        }else{
            E = true;
            $(this).next().html('');
        }
    })

    //检测确认密码
    $('input[name=repass]').blur(function(){
        var v = $('input[name=pass]').val();
        var rv = $(this).val();
        if(rv!=v){
            W = false;
            $(this).next().html('两次密码不一致,请重新输入');
        }else{
            W = true;
            $(this).next().html('');
        }
    })

    //检测同意协议 class="tc-cover" style="height: 836px;

    $('#diugou').children('em').click(function(){
        if(!$('#diugou').attr('d')){
            $('#diugou').attr('d','d');
            $(this).css('display','none');
            $('input[name=agreement]').removeAttr('checked');
        }
    })
    $('#diugou').children('i').click(function(){
        if($('#diugou').attr('d')){
            $('#diugou').removeAttr('d');
            $(this).next().css('display','block');
            $('input[name=agreement]').attr('checked','checked');
        }
    })

    $('#xieyi').click(function(){
        $('#myCover').css('display','');
        $('#maximPanel').css('display','');
        
        return false;
    })

    $('.close').click(function(){
        $('#myCover').css('display','none');
        $('#maximPanel').css('display','none');
    })
            
    //绑定提交
    $('#reg_form').submit(function(){
        $('input[name=phone]').trigger('blur');
        $('input[name=scode]').trigger('blur');
        $('input[name=pass]').trigger('blur');
        $('input[name=repass]').trigger('blur');

        if(!$('input[name=scode]').val()){
            alert('请输入手机验证码');
        }

        if(!$('input[name=agreement]').attr("checked")){
            alert("请先同意 《M'cake购物协议》");
            return false;
        };

        if(R && E && W){
            return true;
        }else{
            return false;
        }
    })

    //点击发送验证码
    $('#reg_sms_btn').click(function(){
        var phone = $('input[name=phone]').val();
        // alert(phone);
        if(!phone){
            alert('请填写手机号码');
            return false;
        }
        $.get("<?php echo U('Home/Login/scode');?>",{phone:phone});
        alert('验证码已发送到手机');
        return false;
        
    });
</script>

    </body>
</html>