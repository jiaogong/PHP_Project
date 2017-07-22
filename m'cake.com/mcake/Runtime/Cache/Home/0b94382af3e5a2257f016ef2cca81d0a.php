<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="Content-Language" content="zh-CN">
        <title>完善资料 - MCAKE-一直都是巴黎的味道</title>
        <meta name="Keywords" content="Mcake,M'cake,蓝莓轻乳拿破仑,经典香草拿破仑,拿破仑莓恋,拿破仑，胡桃布拉吉，榛果摩卡布拉吉，魅影歌剧院，巧克力格调，天使巧克力，魔鬼巧克力，蒸清抹茶，蔓越莓红丝绒，沙布雷巴菲，巧克力狂想曲，卡法香缇，瑞可塔厚爱，法香奶油可丽，莓果青柠慕斯＂">
        <meta name="Description" content="Mcake把法国传统蛋糕文化带入中国，提供纯正的欧式味觉体验，同时也将欧洲的上好材质、经典工艺以及优雅的文艺气质，融入产品的每一个细节之中，带给客户更多的享受与愉悦。">
        <meta http-equiv="X-UA-Compatible" content="IE=7">
        <meta http-equiv="cache-control" content="max-age=1800">
        
        <link rel="shortcut icon" href="/mcake/Public/Index/images/icons/favicon.ico">
        <link rel="stylesheet" type="text/css" href="/mcake/Public/Index/css/comm_header.css">
        <link rel="stylesheet" type="text/css" href="/mcake/Public/Index/css/Landing_city.css">

        <link rel="stylesheet" type="text/css" href="/mcake/Public/Index/css/ebsig.css">
        <link rel="stylesheet" type="text/css" href="/mcake/Public/Index/css/goods.css">
        <link rel="stylesheet" type="text/css" href="/mcake/Public/Index/css/0720.css">
        <link rel="stylesheet" type="text/css" href="/mcake/Public/Index/css/member.css">
        <link rel="stylesheet" type="text/css" href="/mcake/Public/Index/css/index.css">

        <script type="text/javascript" src="/mcake/Public/Index/js/jquery.js"></script>
    </head>
    <body>
        <!--header 开始 -->
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

        <div id="page_mainer">

            <div class="user_box">

                <div class="user_title">
                    <p class="user_t_img">
                        <i></i><span>会员中心</span>
                    </p>
                </div>
                <div class="user_left">

                    <div class="showtime">

                        <span>Vendredi , <?php echo ($time); ?></span>

                        <p id="week"></p>

                    </div>
                    <ul class="user_nav" style="width: 200px;">
                        <li><a href="<?php echo U('Home/Members/edit');?>">完善个人资料</a> <i></i></li>
                        <li><a href="<?php echo U('Home/Members/order');?>">我的订单</a> <i id="i_id"></i>
                        </li>
                        <li><a href="<?php echo U('Home/Members/shoucang');?>">我的收藏</a> <i></i>
                        </li>
                        <li><a href="<?php echo U('Home/Members/rank');?>">我的权益</a>
                            <dl class="my_Interest">
                                <dd><span></span><a href="<?php echo U('Home/Members/rank');?>">我的会员等级</a> <em></em></dd>
                            </dl>
                        </li>
                        <li><a href="<?php echo U('Home/Members/coupons');?>">我的优惠/分享券</a> <i></i></li>
                        <li><a href="<?php echo U('Home/Members/points');?>">我的积分</a> <i></i></li>
                        <li class="userMyMsg" style="display: none;"><a href="">我的消息</a> <i></i></li>
                    </ul>
                    <div class="user_exit"><a href="<?php echo U('Home/Login/logout');?>">退出登录</a></div>
                </div>
                    <div class="login_right mynews_box order_list">
                       <!--修改个人资料-->
                      <ul>
                        <form id="form" action="<?php echo U('Home/Members/doedit');?>" method="post">
                           <input type="hidden" name="id" value="<?php echo ($users['id']); ?>" >
                           <li>
                               <p>
                                   <span>个人资料</span>
                               </p>
                           </li>
                           <li>
                               <label for="name">姓名</label>
                               <input type="text" class="input_txt Nickname_icon Nickname_icon_name"  id="name" name='name' value="<?php echo ($users['name']); ?>"/>

                               <div class="send">
                                最多填写10个汉字<br />
                                或20个英文字母与数字<br />
                               </div>
                           </li>
                           <li>
                               <label for="usercount">昵称</label>
                               <input type="text" class="input_txt Nickname_icon"  value="<?php echo ($users['usercount']); ?>" id="usercount" name="usercount" />
                           </li>
                           <li>
                               <label for="phone">手机号码</label>
                               <input type="text" class="input_txt Mobile_icon" value="<?php echo ($users['phone']); ?>"  id="phone" name='phone' maxlength="11"/>
                           </li>
                           <li>
                               <label for="pass">密码</label>
                               <input type="password" class="input_txt PWord_icon" value="<?php echo ($users['pass']); ?>"  id="pass" name='pass' disabled="disabled"/>

                               <div class="toModify">
                                   <a href="<?php echo U('Home/Members/pwd');?>?id=<?php echo ($users['id']); ?>" class="go">修改 <small>>></small></a>
                               </div>
                           </li>
                           <li>
                               <label for="email">我的邮箱</label>
                               <input type="text" class="input_txt mail_icon" name="email" id="email" value="<?php echo ($users['email']); ?>"/>
                               <samp>M'CAKE会发送最新的活动信息给您哒</samp>
                           </li>
                           <li class="sax">
                               <span class="select_sex">性别</span>
                                   <div>
                                       <i></i>
                                       <em id="msex"></em>
                                       <p val="1">男</p>
                                   </div>
                                   <div>
                                       <i></i>
                                       <em id="nsex"></em>
                                       <p val="0">女</p>
                                   </div>
                               <input type='text' name="sex" value="<?php echo ($users['sex']); ?>" id="sexy" style="display:none" />
                           </li>
                           <li class="hobby_0721">
                               <span class="select_hobby">爱好</span>
                               <div class="hobby_list">
                                  <dl>
                                     <dd  class="" >
                                        <span val="1">拿破仑</span>
                                     </dd>
                                     <dd  class="" >
                                        <span val="2">鲜奶</span>
                                     </dd>
                                     <dd  class="" >
                                        <span val="3">慕斯</span>
                                     </dd>
                                     <dd  class="" >
                                        <span val="4">芝士</span>
                                     </dd>
                                     <dd  class="" >
                                        <span val="5">巧克力</span>
                                     </dd>
                                     <dd  class="" >
                                        <span val="6">咖啡</span>
                                     </dd>
                                     <dd  class="" >
                                        <span val="7">坚果</span>
                                     </dd>
                                     <dd  class="" >
                                        <span val="8">水果</span>
                                     </dd>
                                  </dl> 
                               </div>
                               <input type="text"  name="hover" value="<?php echo ($users['hover']); ?>" id="hobby_list" hidden="hidden" style="display:none;"/>
                           </li>
                           <?php if(is_array($anniversarie)): foreach($anniversarie as $key=>$vo): ?><input type="hidden" name="anni_id[]" value="<?php echo ($vo['id']); ?>">
                               <li class="select_box" name="jinian<?php echo ($vo['id']); ?>">
                                   <span class="select_name" ><?php echo ($vo['anni_name']); ?></span>
                                  <?php if($vo['calendar'] == 0): ?><div>
                                      <i></i>
                                      <em  id="gjinian<?php echo ($vo['id']); ?>" style="background-position:0px -280px;"></em>
                                      <p val='0'>公历</p>
                                   </div>
                                   <div>
                                      <i></i>
                                      <em id="njinian[]" style=""></em>
                                      <p val='1'>农历</p>
                                   </div>
                                  <?php else: ?>
                                   <div>
                                      <i></i>
                                      <em id="gjinian[]" style=""></em>
                                      <p val='0'>公历</p>
                                   </div>
                                   <div>
                                      <i></i>
                                      <em id="njinian<?php echo ($vo['id']); ?>" style="background-position:0px -280px;"></em>
                                      <p val='1'>农历</p>
                                   </div><?php endif; ?>
                                   <input type="hidden" id="calendar<?php echo ($vo['id']); ?>" name="calendar[]" value="<?php echo ($vo['calendar']); ?>" style="display:none;"/>
                                   <div class="select_box_date">
                                      <div class="select_down select_year">
                                          <select id="year<?php echo ($vo['id']); ?>" name='year[]'>
                                              <option value="">年</option>
                                              <option value="1900" <?php if(($vo['year']) == "1900"): ?>selected='selected'<?php endif; ?>>1900</option>
                                              <option value="1901" <?php if(($vo['year']) == "1901"): ?>selected='selected'<?php endif; ?>>1901</option>
                                              <option value="1902" <?php if(($vo['year']) == "1902"): ?>selected='selected'<?php endif; ?>>1902</option>
                                              <option value="1903" <?php if(($vo['year']) == "1903"): ?>selected='selected'<?php endif; ?>>1903</option>
                                              <option value="1904" <?php if(($vo['year']) == "1904"): ?>selected='selected'<?php endif; ?>>1904</option>
                                              <option value="1905" <?php if(($vo['year']) == "1905"): ?>selected='selected'<?php endif; ?>>1905</option>
                                              <option value="1906" <?php if(($vo['year']) == "1906"): ?>selected='selected'<?php endif; ?>>1906</option>
                                              <option value="1907" <?php if(($vo['year']) == "1907"): ?>selected='selected'<?php endif; ?>>1907</option>
                                              <option value="1908" <?php if(($vo['year']) == "1908"): ?>selected='selected'<?php endif; ?>>1908</option>
                                              <option value="1909" <?php if(($vo['year']) == "1909"): ?>selected='selected'<?php endif; ?>>1909</option>
                                              <option value="1910" <?php if(($vo['year']) == "1910"): ?>selected='selected'<?php endif; ?>>1910</option>
                                              <option value="1911" <?php if(($vo['year']) == "1911"): ?>selected='selected'<?php endif; ?>>1911</option>
                                              <option value="1912" <?php if(($vo['year']) == "1912"): ?>selected='selected'<?php endif; ?>>1912</option>
                                              <option value="1913" <?php if(($vo['year']) == "1913"): ?>selected='selected'<?php endif; ?>>1913</option>
                                              <option value="1914" <?php if(($vo['year']) == "1914"): ?>selected='selected'<?php endif; ?>>1914</option>
                                              <option value="1915" <?php if(($vo['year']) == "1915"): ?>selected='selected'<?php endif; ?>>1915</option>
                                              <option value="1916" <?php if(($vo['year']) == "1916"): ?>selected='selected'<?php endif; ?>>1916</option>
                                              <option value="1917" <?php if(($vo['year']) == "1917"): ?>selected='selected'<?php endif; ?>>1917</option>
                                              <option value="1918" <?php if(($vo['year']) == "1918"): ?>selected='selected'<?php endif; ?>>1918</option>
                                              <option value="1919" <?php if(($vo['year']) == "1919"): ?>selected='selected'<?php endif; ?>>1919</option>
                                              <option value="1920" <?php if(($vo['year']) == "1920"): ?>selected='selected'<?php endif; ?>>1920</option>
                                              <option value="1921" <?php if(($vo['year']) == "1921"): ?>selected='selected'<?php endif; ?>>1921</option>
                                              <option value="1922" <?php if(($vo['year']) == "1922"): ?>selected='selected'<?php endif; ?>>1922</option>
                                              <option value="1923" <?php if(($vo['year']) == "1923"): ?>selected='selected'<?php endif; ?>>1923</option>
                                              <option value="1924" <?php if(($vo['year']) == "1924"): ?>selected='selected'<?php endif; ?>>1924</option>
                                              <option value="1925" <?php if(($vo['year']) == "1925"): ?>selected='selected'<?php endif; ?>>1925</option>
                                              <option value="1926" <?php if(($vo['year']) == "1926"): ?>selected='selected'<?php endif; ?>>1926</option>
                                              <option value="1927" <?php if(($vo['year']) == "1927"): ?>selected='selected'<?php endif; ?>>1927</option>
                                              <option value="1928" <?php if(($vo['year']) == "1928"): ?>selected='selected'<?php endif; ?>>1928</option>
                                              <option value="1929" <?php if(($vo['year']) == "1929"): ?>selected='selected'<?php endif; ?>>1929</option>
                                              <option value="1930" <?php if(($vo['year']) == "1930"): ?>selected='selected'<?php endif; ?>>1930</option>
                                              <option value="1931" <?php if(($vo['year']) == "1931"): ?>selected='selected'<?php endif; ?>>1931</option>
                                              <option value="1932" <?php if(($vo['year']) == "1932"): ?>selected='selected'<?php endif; ?>>1932</option>
                                              <option value="1933" <?php if(($vo['year']) == "1933"): ?>selected='selected'<?php endif; ?>>1933</option>
                                              <option value="1934" <?php if(($vo['year']) == "1934"): ?>selected='selected'<?php endif; ?>>1934</option>
                                              <option value="1935" <?php if(($vo['year']) == "1935"): ?>selected='selected'<?php endif; ?>>1935</option>
                                              <option value="1936" <?php if(($vo['year']) == "1936"): ?>selected='selected'<?php endif; ?>>1936</option>
                                              <option value="1937" <?php if(($vo['year']) == "1937"): ?>selected='selected'<?php endif; ?>>1937</option>
                                              <option value="1938" <?php if(($vo['year']) == "1938"): ?>selected='selected'<?php endif; ?>>1938</option>
                                              <option value="1939" <?php if(($vo['year']) == "1939"): ?>selected='selected'<?php endif; ?>>1939</option>
                                              <option value="1940" <?php if(($vo['year']) == "1940"): ?>selected='selected'<?php endif; ?>>1940</option>
                                              <option value="1941" <?php if(($vo['year']) == "1941"): ?>selected='selected'<?php endif; ?>>1941</option>
                                              <option value="1942" <?php if(($vo['year']) == "1942"): ?>selected='selected'<?php endif; ?>>1942</option>
                                              <option value="1943" <?php if(($vo['year']) == "1943"): ?>selected='selected'<?php endif; ?>>1943</option>
                                              <option value="1944" <?php if(($vo['year']) == "1944"): ?>selected='selected'<?php endif; ?>>1944</option>
                                              <option value="1945" <?php if(($vo['year']) == "1945"): ?>selected='selected'<?php endif; ?>>1945</option>
                                              <option value="1946" <?php if(($vo['year']) == "1946"): ?>selected='selected'<?php endif; ?>>1946</option>
                                              <option value="1947" <?php if(($vo['year']) == "1947"): ?>selected='selected'<?php endif; ?>>1947</option>
                                              <option value="1948" <?php if(($vo['year']) == "1948"): ?>selected='selected'<?php endif; ?>>1948</option>
                                              <option value="1949" <?php if(($vo['year']) == "1949"): ?>selected='selected'<?php endif; ?>>1949</option>
                                              <option value="1950" <?php if(($vo['year']) == "1950"): ?>selected='selected'<?php endif; ?>>1950</option>
                                              <option value="1951" <?php if(($vo['year']) == "1951"): ?>selected='selected'<?php endif; ?>>1951</option>
                                              <option value="1952" <?php if(($vo['year']) == "1952"): ?>selected='selected'<?php endif; ?>>1952</option>
                                              <option value="1953" <?php if(($vo['year']) == "1953"): ?>selected='selected'<?php endif; ?>>1953</option>
                                              <option value="1954" <?php if(($vo['year']) == "1954"): ?>selected='selected'<?php endif; ?>>1954</option>
                                              <option value="1955" <?php if(($vo['year']) == "1955"): ?>selected='selected'<?php endif; ?>>1955</option>
                                              <option value="1956" <?php if(($vo['year']) == "1956"): ?>selected='selected'<?php endif; ?>>1956</option>
                                              <option value="1957" <?php if(($vo['year']) == "1957"): ?>selected='selected'<?php endif; ?>>1957</option>
                                              <option value="1958" <?php if(($vo['year']) == "1958"): ?>selected='selected'<?php endif; ?>>1958</option>
                                              <option value="1959" <?php if(($vo['year']) == "1959"): ?>selected='selected'<?php endif; ?>>1959</option>
                                              <option value="1960" <?php if(($vo['year']) == "1960"): ?>selected='selected'<?php endif; ?>>1960</option>
                                              <option value="1961" <?php if(($vo['year']) == "1961"): ?>selected='selected'<?php endif; ?>>1961</option>
                                              <option value="1962" <?php if(($vo['year']) == "1962"): ?>selected='selected'<?php endif; ?>>1962</option>
                                              <option value="1963" <?php if(($vo['year']) == "1963"): ?>selected='selected'<?php endif; ?>>1963</option>
                                              <option value="1964" <?php if(($vo['year']) == "1964"): ?>selected='selected'<?php endif; ?>>1964</option>
                                              <option value="1965" <?php if(($vo['year']) == "1965"): ?>selected='selected'<?php endif; ?>>1965</option>
                                              <option value="1966" <?php if(($vo['year']) == "1966"): ?>selected='selected'<?php endif; ?>>1966</option>
                                              <option value="1967" <?php if(($vo['year']) == "1967"): ?>selected='selected'<?php endif; ?>>1967</option>
                                              <option value="1968" <?php if(($vo['year']) == "1968"): ?>selected='selected'<?php endif; ?>>1968</option>
                                              <option value="1969" <?php if(($vo['year']) == "1969"): ?>selected='selected'<?php endif; ?>>1969</option>
                                              <option value="1970" <?php if(($vo['year']) == "1970"): ?>selected='selected'<?php endif; ?>>1970</option>
                                              <option value="1971" <?php if(($vo['year']) == "1971"): ?>selected='selected'<?php endif; ?>>1971</option>
                                              <option value="1972" <?php if(($vo['year']) == "1972"): ?>selected='selected'<?php endif; ?>>1972</option>
                                              <option value="1973" <?php if(($vo['year']) == "1973"): ?>selected='selected'<?php endif; ?>>1973</option>
                                              <option value="1974" <?php if(($vo['year']) == "1974"): ?>selected='selected'<?php endif; ?>>1974</option>
                                              <option value="1975" <?php if(($vo['year']) == "1975"): ?>selected='selected'<?php endif; ?>>1975</option>
                                              <option value="1976" <?php if(($vo['year']) == "1976"): ?>selected='selected'<?php endif; ?>>1976</option>
                                              <option value="1977" <?php if(($vo['year']) == "1977"): ?>selected='selected'<?php endif; ?>>1977</option>
                                              <option value="1978" <?php if(($vo['year']) == "1978"): ?>selected='selected'<?php endif; ?>>1978</option>
                                              <option value="1979" <?php if(($vo['year']) == "1979"): ?>selected='selected'<?php endif; ?>>1979</option>
                                              <option value="1980" <?php if(($vo['year']) == "1980"): ?>selected='selected'<?php endif; ?>>1980</option>
                                              <option value="1981" <?php if(($vo['year']) == "1981"): ?>selected='selected'<?php endif; ?>>1981</option>
                                              <option value="1982" <?php if(($vo['year']) == "1982"): ?>selected='selected'<?php endif; ?>>1982</option>
                                              <option value="1983" <?php if(($vo['year']) == "1983"): ?>selected='selected'<?php endif; ?>>1983</option>
                                              <option value="1984" <?php if(($vo['year']) == "1984"): ?>selected='selected'<?php endif; ?>>1984</option>
                                              <option value="1985" <?php if(($vo['year']) == "1985"): ?>selected='selected'<?php endif; ?>>1985</option>
                                              <option value="1986" <?php if(($vo['year']) == "1986"): ?>selected='selected'<?php endif; ?>>1986</option>
                                              <option value="1987" <?php if(($vo['year']) == "1987"): ?>selected='selected'<?php endif; ?>>1987</option>
                                              <option value="1988" <?php if(($vo['year']) == "1988"): ?>selected='selected'<?php endif; ?>>1988</option>
                                              <option value="1989" <?php if(($vo['year']) == "1989"): ?>selected='selected'<?php endif; ?>>1989</option>
                                              <option value="1990" <?php if(($vo['year']) == "1990"): ?>selected='selected'<?php endif; ?>>1990</option>
                                              <option value="1991" <?php if(($vo['year']) == "1991"): ?>selected='selected'<?php endif; ?>>1991</option>
                                              <option value="1992" <?php if(($vo['year']) == "1992"): ?>selected='selected'<?php endif; ?>>1992</option>
                                              <option value="1993" <?php if(($vo['year']) == "1993"): ?>selected='selected'<?php endif; ?>>1993</option>
                                              <option value="1994" <?php if(($vo['year']) == "1994"): ?>selected='selected'<?php endif; ?>>1994</option>
                                              <option value="1995" <?php if(($vo['year']) == "1995"): ?>selected='selected'<?php endif; ?>>1995</option>
                                              <option value="1996" <?php if(($vo['year']) == "1996"): ?>selected='selected'<?php endif; ?>>1996</option>
                                              <option value="1997" <?php if(($vo['year']) == "1997"): ?>selected='selected'<?php endif; ?>>1997</option>
                                              <option value="1998" <?php if(($vo['year']) == "1998"): ?>selected='selected'<?php endif; ?>>1998</option>
                                              <option value="1999" <?php if(($vo['year']) == "1999"): ?>selected='selected'<?php endif; ?>>1999</option>
                                              <option value="2000" <?php if(($vo['year']) == "2000"): ?>selected='selected'<?php endif; ?>>2000</option>
                                              <option value="2001" <?php if(($vo['year']) == "2001"): ?>selected='selected'<?php endif; ?>>2001</option>
                                              <option value="2002" <?php if(($vo['year']) == "2002"): ?>selected='selected'<?php endif; ?>>2002</option>
                                              <option value="2003" <?php if(($vo['year']) == "2003"): ?>selected='selected'<?php endif; ?>>2003</option>
                                              <option value="2004" <?php if(($vo['year']) == "2004"): ?>selected='selected'<?php endif; ?>>2004</option>
                                              <option value="2005" <?php if(($vo['year']) == "2005"): ?>selected='selected'<?php endif; ?>>2005</option>
                                              <option value="2006" <?php if(($vo['year']) == "2005"): ?>selected='selected'<?php endif; ?>>2006</option>
                                              <option value="2007" <?php if(($vo['year']) == "2007"): ?>selected='selected'<?php endif; ?>>2007</option>
                                              <option value="2008" <?php if(($vo['year']) == "2008"): ?>selected='selected'<?php endif; ?>>2008</option>
                                              <option value="2009" <?php if(($vo['year']) == "2009"): ?>selected='selected'<?php endif; ?>>2009</option>
                                              <option value="2010" <?php if(($vo['year']) == "2010"): ?>selected='selected'<?php endif; ?>>2010</option>
                                              <option value="2011" <?php if(($vo['year']) == "2011"): ?>selected='selected'<?php endif; ?>>2011</option>
                                              <option value="2012" <?php if(($vo['year']) == "2012"): ?>selected='selected'<?php endif; ?>>2012</option>
                                              <option value="2013" <?php if(($vo['year']) == "2013"): ?>selected='selected'<?php endif; ?>>2013</option>
                                              <option value="2014" <?php if(($vo['year']) == "2014"): ?>selected='selected'<?php endif; ?>>2014</option>
                                              <option value="2015" <?php if(($vo['year']) == "2015"): ?>selected='selected'<?php endif; ?>>2015</option>
                                          </select>
                                          <span>年</span>
                                      </div>
                                      <div class="select_down">
                                        <select id="month<?php echo ($vo['id']); ?>" name="month[]">
                                              <option value="">月</option>
                                              <option value="1" <?php if(($vo['month']) == "1"): ?>selected='selected'<?php endif; ?>>1</option>
                                              <option value="2" <?php if(($vo['month']) == "2"): ?>selected='selected'<?php endif; ?>>2</option>
                                              <option value="3" <?php if(($vo['month']) == "3"): ?>selected='selected'<?php endif; ?>>3</option>
                                              <option value="4" <?php if(($vo['month']) == "4"): ?>selected='selected'<?php endif; ?>>4</option>
                                              <option value="5" <?php if(($vo['month']) == "5"): ?>selected='selected'<?php endif; ?>>5</option>
                                              <option value="6" <?php if(($vo['month']) == "6"): ?>selected='selected'<?php endif; ?>>6</option>
                                              <option value="7" <?php if(($vo['month']) == "7"): ?>selected='selected'<?php endif; ?>>7</option>
                                              <option value="8" <?php if(($vo['month']) == "8"): ?>selected='selected'<?php endif; ?>>8</option>
                                              <option value="9" <?php if(($vo['month']) == "9"): ?>selected='selected'<?php endif; ?>>9</option>
                                              <option value="10" <?php if(($vo['month']) == "10"): ?>selected='selected'<?php endif; ?>>10</option>
                                              <option value="11" <?php if(($vo['month']) == "11"): ?>selected='selected'<?php endif; ?>>11</option>
                                              <option value="12" <?php if(($vo['month']) == "12"): ?>selected='selected'<?php endif; ?>>12</option>
                                        </select>
                                        <span>月</span>
                                      </div>
                                      <div class="select_down">
                                          <select id="day<?php echo ($vo['id']); ?>" name="day[]">
                                              <option value="">日</option>
                                              <option value="1" <?php if(($vo['day']) == "1"): ?>selected='selected'<?php endif; ?>>1</option>
                                              <option value="2" <?php if(($vo['day']) == "2"): ?>selected='selected'<?php endif; ?>>2</option>
                                              <option value="3" <?php if(($vo['day']) == "3"): ?>selected='selected'<?php endif; ?>>3</option>
                                              <option value="4" <?php if(($vo['day']) == "4"): ?>selected='selected'<?php endif; ?>>4</option>
                                              <option value="5" <?php if(($vo['day']) == "5"): ?>selected='selected'<?php endif; ?>>5</option>
                                              <option value="6" <?php if(($vo['day']) == "6"): ?>selected='selected'<?php endif; ?>>6</option>
                                              <option value="7" <?php if(($vo['day']) == "7"): ?>selected='selected'<?php endif; ?>>7</option>
                                              <option value="8" <?php if(($vo['day']) == "8"): ?>selected='selected'<?php endif; ?>>8</option>
                                              <option value="9" <?php if(($vo['day']) == "9"): ?>selected='selected'<?php endif; ?>>9</option>
                                              <option value="10" <?php if(($vo['day']) == "10"): ?>selected='selected'<?php endif; ?>>10</option>
                                              <option value="11" <?php if(($vo['day']) == "11"): ?>selected='selected'<?php endif; ?>>11</option>
                                              <option value="12" <?php if(($vo['day']) == "12"): ?>selected='selected'<?php endif; ?>>12</option>
                                              <option value="13" <?php if(($vo['day']) == "13"): ?>selected='selected'<?php endif; ?>>13</option>
                                              <option value="14" <?php if(($vo['day']) == "14"): ?>selected='selected'<?php endif; ?>>14</option>
                                              <option value="15" <?php if(($vo['day']) == "15"): ?>selected='selected'<?php endif; ?>>15</option>
                                              <option value="16" <?php if(($vo['day']) == "16"): ?>selected='selected'<?php endif; ?>>16</option>
                                              <option value="17" <?php if(($vo['day']) == "17"): ?>selected='selected'<?php endif; ?>>17</option>
                                              <option value="18" <?php if(($vo['day']) == "18"): ?>selected='selected'<?php endif; ?>>18</option>
                                              <option value="19" <?php if(($vo['day']) == "19"): ?>selected='selected'<?php endif; ?>>19</option>
                                              <option value="20" <?php if(($vo['day']) == "20"): ?>selected='selected'<?php endif; ?>>20</option>
                                              <option value="21" <?php if(($vo['day']) == "21"): ?>selected='selected'<?php endif; ?>>21</option>
                                              <option value="22" <?php if(($vo['day']) == "22"): ?>selected='selected'<?php endif; ?>>22</option>
                                              <option value="23" <?php if(($vo['day']) == "23"): ?>selected='selected'<?php endif; ?>>23</option>
                                              <option value="24" <?php if(($vo['day']) == "24"): ?>selected='selected'<?php endif; ?>>24</option>
                                              <option value="25" <?php if(($vo['day']) == "25"): ?>selected='selected'<?php endif; ?>>25</option>
                                              <option value="26" <?php if(($vo['day']) == "26"): ?>selected='selected'<?php endif; ?>>26</option>
                                              <option value="27" <?php if(($vo['day']) == "27"): ?>selected='selected'<?php endif; ?>>27</option>
                                              <option value="28" <?php if(($vo['day']) == "28"): ?>selected='selected'<?php endif; ?>>28</option>
                                              <option value="29" <?php if(($vo['day']) == "29"): ?>selected='selected'<?php endif; ?>>29</option>
                                              <option value="30" <?php if(($vo['day']) == "30"): ?>selected='selected'<?php endif; ?>>30</option>
                                              <option value="31" <?php if(($vo['day']) == "31"): ?>selected='selected'<?php endif; ?>>31</option>
                                         </select>
                                         <span>日</span>
                                      </div>
                                      <a href="<?php echo U('Home/Members/dodel');?>?id=<?php echo ($vo['id']); ?>">
                                          <img src="/mcake/Public/Index/images/stop_d.png" alt="" style="width:45px;">
                                      </a>
                                   </div>
                               </li>
                               <li style="height:50px;"></li>

                               <script type="text/javascript">
                                  var val = '';
                                  $("li[name=jinian<?php echo ($vo['id']); ?>] em").click(function(){
                                      $("li[name=jinian<?php echo ($vo['id']); ?>] em").css('backgroundPosition','0 0');
                                      $(this).css('backgroundPosition','0 -280px');
                                      val = $(this).siblings('p').attr('val');
                                      // alert(val);
                                      $("#calendar<?php echo ($vo['id']); ?>").attr('value',val);
                                  });
                               </script><?php endforeach; endif; ?>
                           <li class="markday_btn">
                               <input type="submit" value="保存" class="login_btn" />
                           </li>
                        </form>
                      </ul>
                          <!-- <li class="select_box select_box_2 "> -->
                              <!--更多纪念日模板-->
                             <!--  <dl id="anniver_other">
                                  <dd>
                                      <div class="select_memorial" style="z-index:100">
                                        <span class="tt_left">纪念日1:</span>
                                        <div class="select_down select_box_option" >
                                           <select id="anniver1" name="anni_name[]">
                                            <option value="1" selected>孩子生日</option>
                                            <option value="2" >父亲生日</option>
                                            <option value="3" >母亲生日</option>
                                            <option value="4" >老公生日</option>
                                            <option value="5" >老婆生日</option>
                                            <option value="6" >死党生日</option>
                                            <option value="7" >结婚纪念日</option>
                                            <option value="8" >恋爱纪念日</option>
                                            <option value="9" >失恋纪念日</option>
                                           </select>
                                        </div>
                                        <samp>请填写完整的纪念日</samp>
                                      </div>
                                      <div class="select_box_date" style="z-index:99">
                                         <div class="select_down select_down_0">
                                           <select id="calendar1" name='calendar[]'>
                                             <option value='0' selected>公历</option>
                                             <option value='1' >农历</option>
                                           </select>
                                         </div>
                                         <div class="select_down select_year">
                                            <select id="anniver_year1" name='year[]' >
                                                <option value="">年</option>
                                                <option value="1900" >1900</option>
                                                <option value="1901" >1901</option>
                                                <option value="1902" >1902</option>
                                                <option value="1903" >1903</option>
                                                <option value="1904" >1904</option>
                                                <option value="1905" >1905</option>
                                                <option value="1906" >1906</option>
                                                <option value="1907" >1907</option>
                                                <option value="1908" >1908</option>
                                                <option value="1909" >1909</option>
                                                <option value="1910" >1910</option>
                                                <option value="1911" >1911</option>
                                                <option value="1912" >1912</option>
                                                <option value="1913" >1913</option>
                                                <option value="1914" >1914</option>
                                                <option value="1915" >1915</option>
                                                <option value="1916" >1916</option>
                                                <option value="1917" >1917</option>
                                                <option value="1918" >1918</option>
                                                <option value="1919" >1919</option>
                                                <option value="1920" >1920</option>
                                                <option value="1921" >1921</option>
                                                <option value="1922" >1922</option>
                                                <option value="1923" >1923</option>
                                                <option value="1924" >1924</option>
                                                <option value="1925" >1925</option>
                                                <option value="1926" >1926</option>
                                                <option value="1927" >1927</option>
                                                <option value="1928" >1928</option>
                                                <option value="1929" >1929</option>
                                                <option value="1930" >1930</option>
                                                <option value="1931" >1931</option>
                                                <option value="1932" >1932</option>
                                                <option value="1933" >1933</option>
                                                <option value="1934" >1934</option>
                                                <option value="1935" >1935</option>
                                                <option value="1936" >1936</option>
                                                <option value="1937" >1937</option>
                                                <option value="1938" >1938</option>
                                                <option value="1939" >1939</option>
                                                <option value="1940" >1940</option>
                                                <option value="1941" >1941</option>
                                                <option value="1942" >1942</option>
                                                <option value="1943" >1943</option>
                                                <option value="1944" >1944</option>
                                                <option value="1945" >1945</option>
                                                <option value="1946" >1946</option>
                                                <option value="1947" >1947</option>
                                                <option value="1948" >1948</option>
                                                <option value="1949" >1949</option>
                                                <option value="1950" >1950</option>
                                                <option value="1951" >1951</option>
                                                <option value="1952" >1952</option>
                                                <option value="1953" >1953</option>
                                                <option value="1954" >1954</option>
                                                <option value="1955" >1955</option>
                                                <option value="1956" >1956</option>
                                                <option value="1957" >1957</option>
                                                <option value="1958" >1958</option>
                                                <option value="1959" >1959</option>
                                                <option value="1960" >1960</option>
                                                <option value="1961" >1961</option>
                                                <option value="1962" >1962</option>
                                                <option value="1963" >1963</option>
                                                <option value="1964" >1964</option>
                                                <option value="1965" >1965</option>
                                                <option value="1966" >1966</option>
                                                <option value="1967" >1967</option>
                                                <option value="1968" >1968</option>
                                                <option value="1969" >1969</option>
                                                <option value="1970" >1970</option>
                                                <option value="1971" >1971</option>
                                                <option value="1972" >1972</option>
                                                <option value="1973" >1973</option>
                                                <option value="1974" >1974</option>
                                                <option value="1975" >1975</option>
                                                <option value="1976" >1976</option>
                                                <option value="1977" >1977</option>
                                                <option value="1978" >1978</option>
                                                <option value="1979" >1979</option>
                                                <option value="1980" >1980</option>
                                                <option value="1981" >1981</option>
                                                <option value="1982" >1982</option>
                                                <option value="1983" >1983</option>
                                                <option value="1984" >1984</option>
                                                <option value="1985" >1985</option>
                                                <option value="1986" >1986</option>
                                                <option value="1987" selected>1987</option>
                                                <option value="1988" >1988</option>
                                                <option value="1989" >1989</option>
                                                <option value="1990" >1990</option>
                                                <option value="1991" >1991</option>
                                                <option value="1992" >1992</option>
                                                <option value="1993" >1993</option>
                                                <option value="1994" >1994</option>
                                                <option value="1995" >1995</option>
                                                <option value="1996" >1996</option>
                                                <option value="1997" >1997</option>
                                                <option value="1998" >1998</option>
                                                <option value="1999" >1999</option>
                                                <option value="2000" >2000</option>
                                                <option value="2001" >2001</option>
                                                <option value="2002" >2002</option>
                                                <option value="2003" >2003</option>
                                                <option value="2004" >2004</option>
                                                <option value="2005" >2005</option>
                                                <option value="2006" >2006</option>
                                                <option value="2007" >2007</option>
                                                <option value="2008" >2008</option>
                                                <option value="2009" >2009</option>
                                                <option value="2010" >2010</option>
                                                <option value="2011" >2011</option>
                                                <option value="2012" >2012</option>
                                                <option value="2013" >2013</option>
                                                <option value="2014" >2014</option>
                                                <option value="2015" >2015</option>
                                            </select>
                                            <span>年</span>
                                         </div>
                                         <div class="select_down select_month">
                                             <select id="anniver_month1" name='month[]' onchange="changeMonth(this);">
                                                <option value="">月</option>
                                                <option value="1" >1</option>
                                                <option value="2" >2</option>
                                                <option value="3" selected>3</option>
                                                <option value="4" >4</option>
                                                <option value="5" >5</option>
                                                <option value="6" >6</option>
                                                <option value="7" >7</option>
                                                <option value="8" >8</option>
                                                <option value="9" >9</option>
                                                <option value="10" >10</option>
                                                <option value="11" >11</option>
                                                <option value="12" >12</option>
                                             </select>
                                             <span>月</span>
                                         </div>
                                         <div class="select_down select_day">
                                            <select id="anniver_day1" name='day[]' class="show_day">
                                                <option value="">日</option>
                                                <option value="1" >1</option>
                                                <option value="2" selected>2</option>
                                                <option value="3" >3</option>
                                                <option value="4" >4</option>
                                                <option value="5" >5</option>
                                                <option value="6" >6</option>
                                                <option value="7" >7</option>
                                                <option value="8" >8</option>
                                                <option value="9" >9</option>
                                                <option value="10" >10</option>
                                                <option value="11" >11</option>
                                                <option value="12" >12</option>
                                                <option value="13" >13</option>
                                                <option value="14" >14</option>
                                                <option value="15" >15</option>
                                                <option value="16" >16</option>
                                                <option value="17" >17</option>
                                                <option value="18" >18</option>
                                                <option value="19" >19</option>
                                                <option value="20" >20</option>
                                                <option value="21" >21</option>
                                                <option value="22" >22</option>
                                                <option value="23" >23</option>
                                                <option value="24" >24</option>
                                                <option value="25" >25</option>
                                                <option value="26" >26</option>
                                                <option value="27" >27</option>
                                                <option value="28" >28</option>
                                                <option value="29" >29</option>
                                                <option value="30" >30</option>
                                                <option value="31" >31</option>
                                            </select>
                                            <span>日</span>
                                         </div>
                                      </div>
                                  </dd>
                                  <dd>
                                      <div class="select_memorial" style="z-index:98">
                                         <span class="tt_left">纪念日2:</span>
                                         <div class="select_down select_box_option">
                                           <select id="anniver2" name='anni_name[]'>
                                              <option value=""></option>
                                              <option value="1" >孩子生日</option>
                                              <option value="2" >父亲生日</option>
                                              <option value="3" >母亲生日</option>
                                              <option value="4" >老公生日</option>
                                              <option value="5" >老婆生日</option>
                                              <option value="6" >死党生日</option>
                                              <option value="7" >结婚纪念日</option>
                                              <option value="8" >恋爱纪念日</option>
                                              <option value="9" >失恋纪念日</option>
                                           </select>
                                         </div>
                                         <samp>请填写完整的纪念日</samp>
                                      </div>
                                      <div class="select_box_date" style="z-index:97">
                                         <div class="select_down select_down_0">
                                           <select id="calendar2" name="calendar[]">
                                             <option value='0' >公历</option>
                                             <option value='1' >农历</option>
                                           </select>
                                         </div>
                                         <div class="select_down select_year">
                                            <select id="anniver_year2" name="year[]">
                                              <option value="">年</option>
                                              <option value="1900" >1900</option>
                                              <option value="1901" >1901</option>
                                              <option value="1902" >1902</option>
                                              <option value="1903" >1903</option>
                                              <option value="1904" >1904</option>
                                              <option value="1905" >1905</option>
                                              <option value="1906" >1906</option>
                                              <option value="1907" >1907</option>
                                              <option value="1908" >1908</option>
                                              <option value="1909" >1909</option>
                                              <option value="1910" >1910</option>
                                              <option value="1911" >1911</option>
                                              <option value="1912" >1912</option>
                                              <option value="1913" >1913</option>
                                              <option value="1914" >1914</option>
                                              <option value="1915" >1915</option>
                                              <option value="1916" >1916</option>
                                              <option value="1917" >1917</option>
                                              <option value="1918" >1918</option>
                                              <option value="1919" >1919</option>
                                              <option value="1920" >1920</option>
                                              <option value="1921" >1921</option>
                                              <option value="1922" >1922</option>
                                              <option value="1923" >1923</option>
                                              <option value="1924" >1924</option>
                                              <option value="1925" >1925</option>
                                              <option value="1926" >1926</option>
                                              <option value="1927" >1927</option>
                                              <option value="1928" >1928</option>
                                              <option value="1929" >1929</option>
                                              <option value="1930" >1930</option>
                                              <option value="1931" >1931</option>
                                              <option value="1932" >1932</option>
                                              <option value="1933" >1933</option>
                                              <option value="1934" >1934</option>
                                              <option value="1935" >1935</option>
                                              <option value="1936" >1936</option>
                                              <option value="1937" >1937</option>
                                              <option value="1938" >1938</option>
                                              <option value="1939" >1939</option>
                                              <option value="1940" >1940</option>
                                              <option value="1941" >1941</option>
                                              <option value="1942" >1942</option>
                                              <option value="1943" >1943</option>
                                              <option value="1944" >1944</option>
                                              <option value="1945" >1945</option>
                                              <option value="1946" >1946</option>
                                              <option value="1947" >1947</option>
                                              <option value="1948" >1948</option>
                                              <option value="1949" >1949</option>
                                              <option value="1950" >1950</option>
                                              <option value="1951" >1951</option>
                                              <option value="1952" >1952</option>
                                              <option value="1953" >1953</option>
                                              <option value="1954" >1954</option>
                                              <option value="1955" >1955</option>
                                              <option value="1956" >1956</option>
                                              <option value="1957" >1957</option>
                                              <option value="1958" >1958</option>
                                              <option value="1959" >1959</option>
                                              <option value="1960" >1960</option>
                                              <option value="1961" >1961</option>
                                              <option value="1962" >1962</option>
                                              <option value="1963" >1963</option>
                                              <option value="1964" >1964</option>
                                              <option value="1965" >1965</option>
                                              <option value="1966" >1966</option>
                                              <option value="1967" >1967</option>
                                              <option value="1968" >1968</option>
                                              <option value="1969" >1969</option>
                                              <option value="1970" >1970</option>
                                              <option value="1971" >1971</option>
                                              <option value="1972" >1972</option>
                                              <option value="1973" >1973</option>
                                              <option value="1974" >1974</option>
                                              <option value="1975" >1975</option>
                                              <option value="1976" >1976</option>
                                              <option value="1977" >1977</option>
                                              <option value="1978" >1978</option>
                                              <option value="1979" >1979</option>
                                              <option value="1980" >1980</option>
                                              <option value="1981" >1981</option>
                                              <option value="1982" >1982</option>
                                              <option value="1983" >1983</option>
                                              <option value="1984" >1984</option>
                                              <option value="1985" >1985</option>
                                              <option value="1986" >1986</option>
                                              <option value="1987" >1987</option>
                                              <option value="1988" >1988</option>
                                              <option value="1989" >1989</option>
                                              <option value="1990" >1990</option>
                                              <option value="1991" >1991</option>
                                              <option value="1992" >1992</option>
                                              <option value="1993" >1993</option>
                                              <option value="1994" >1994</option>
                                              <option value="1995" >1995</option>
                                              <option value="1996" >1996</option>
                                              <option value="1997" >1997</option>
                                              <option value="1998" >1998</option>
                                              <option value="1999" >1999</option>
                                              <option value="2000" >2000</option>
                                              <option value="2001" >2001</option>
                                              <option value="2002" >2002</option>
                                              <option value="2003" >2003</option>
                                              <option value="2004" >2004</option>
                                              <option value="2005" >2005</option>
                                              <option value="2006" >2006</option>
                                              <option value="2007" >2007</option>
                                              <option value="2008" >2008</option>
                                              <option value="2009" >2009</option>
                                              <option value="2010" >2010</option>
                                              <option value="2011" >2011</option>
                                              <option value="2012" >2012</option>
                                              <option value="2013" >2013</option>
                                              <option value="2014" >2014</option>
                                              <option value="2015" >2015</option>
                                            </select>
                                            <span>年</span>
                                         </div>
                                         <div class="select_down select_month">
                                              <select id="anniver_month2" name="month[]" onchange="changeMonth(this);">
                                                <option value="">月</option>
                                                <option value="1" >1</option>
                                                <option value="2" >2</option>
                                                <option value="3" >3</option>
                                                <option value="4" >4</option>
                                                <option value="5" >5</option>
                                                <option value="6" >6</option>
                                                <option value="7" >7</option>
                                                <option value="8" >8</option>
                                                <option value="9" >9</option>
                                                <option value="10" >10</option>
                                                <option value="11" >11</option>
                                                <option value="12" >12</option>
                                              </select>
                                              <span>月</span>
                                         </div>
                                         <div class="select_down select_day">
                                             <select id="anniver_day2" name="day[]" class="show_day">
                                                <option value="">日</option>
                                                <option value="1" >1</option>
                                                <option value="2" >2</option>
                                                <option value="3" >3</option>
                                                <option value="4" >4</option>
                                                <option value="5" >5</option>
                                                <option value="6" >6</option>
                                                <option value="7" >7</option>
                                                <option value="8" >8</option>
                                                <option value="9" >9</option>
                                                <option value="10" >10</option>
                                                <option value="11" >11</option>
                                                <option value="12" >12</option>
                                                <option value="13" >13</option>
                                                <option value="14" >14</option>
                                                <option value="15" >15</option>
                                                <option value="16" >16</option>
                                                <option value="17" >17</option>
                                                <option value="18" >18</option>
                                                <option value="19" >19</option>
                                                <option value="20" >20</option>
                                                <option value="21" >21</option>
                                                <option value="22" >22</option>
                                                <option value="23" >23</option>
                                                <option value="24" >24</option>
                                                <option value="25" >25</option>
                                                <option value="26" >26</option>
                                                <option value="27" >27</option>
                                                <option value="28" >28</option>
                                                <option value="29" >29</option>
                                                <option value="30" >30</option>
                                                <option value="31" >31</option>
                                             </select>
                                             <span>日</span>
                                         </div>
                                      </div>
                                  </dd>
                                  <dd>
                                    <div class="select_memorial" style="z-index:96">
                                       <span class="tt_left">纪念日3:</span>
                                       <div class="select_down select_box_option">
                                          <select id="anniver3" name="anni_name[]">
                                              <option value=""></option>
                                              <option value="1" >孩子生日</option>
                                              <option value="2" >父亲生日</option>
                                              <option value="3" >母亲生日</option>
                                              <option value="4" >老公生日</option>
                                              <option value="5" >老婆生日</option>
                                              <option value="6" >死党生日</option>
                                              <option value="7" >结婚纪念日</option>
                                              <option value="8" >恋爱纪念日</option>
                                              <option value="9" >失恋纪念日</option>
                                          </select>
                                       </div>
                                       <samp>请填写完整的纪念日</samp>
                                    </div>
                                    <div class="select_box_date" style="z-index:95">
                                        <div class="select_down select_down_0">
                                           <select id="calendar3" name='calendar[]'>
                                             <option value='0' >公历</option>
                                             <option value='1' >农历</option>
                                           </select>
                                        </div>
                                        <div class="select_down select_year">
                                             <select id="anniver_year3" name="year[]">
                                                <option value="">年</option>
                                                <option value="1900" >1900</option>
                                                <option value="1901" >1901</option>
                                                <option value="1902" >1902</option>
                                                <option value="1903" >1903</option>
                                                <option value="1904" >1904</option>
                                                <option value="1905" >1905</option>
                                                <option value="1906" >1906</option>
                                                <option value="1907" >1907</option>
                                                <option value="1908" >1908</option>
                                                <option value="1909" >1909</option>
                                                <option value="1910" >1910</option>
                                                <option value="1911" >1911</option>
                                                <option value="1912" >1912</option>
                                                <option value="1913" >1913</option>
                                                <option value="1914" >1914</option>
                                                <option value="1915" >1915</option>
                                                <option value="1916" >1916</option>
                                                <option value="1917" >1917</option>
                                                <option value="1918" >1918</option>
                                                <option value="1919" >1919</option>
                                                <option value="1920" >1920</option>
                                                <option value="1921" >1921</option>
                                                <option value="1922" >1922</option>
                                                <option value="1923" >1923</option>
                                                <option value="1924" >1924</option>
                                                <option value="1925" >1925</option>
                                                <option value="1926" >1926</option>
                                                <option value="1927" >1927</option>
                                                <option value="1928" >1928</option>
                                                <option value="1929" >1929</option>
                                                <option value="1930" >1930</option>
                                                <option value="1931" >1931</option>
                                                <option value="1932" >1932</option>
                                                <option value="1933" >1933</option>
                                                <option value="1934" >1934</option>
                                                <option value="1935" >1935</option>
                                                <option value="1936" >1936</option>
                                                <option value="1937" >1937</option>
                                                <option value="1938" >1938</option>
                                                <option value="1939" >1939</option>
                                                <option value="1940" >1940</option>
                                                <option value="1941" >1941</option>
                                                <option value="1942" >1942</option>
                                                <option value="1943" >1943</option>
                                                <option value="1944" >1944</option>
                                                <option value="1945" >1945</option>
                                                <option value="1946" >1946</option>
                                                <option value="1947" >1947</option>
                                                <option value="1948" >1948</option>
                                                <option value="1949" >1949</option>
                                                <option value="1950" >1950</option>
                                                <option value="1951" >1951</option>
                                                <option value="1952" >1952</option>
                                                <option value="1953" >1953</option>
                                                <option value="1954" >1954</option>
                                                <option value="1955" >1955</option>
                                                <option value="1956" >1956</option>
                                                <option value="1957" >1957</option>
                                                <option value="1958" >1958</option>
                                                <option value="1959" >1959</option>
                                                <option value="1960" >1960</option>
                                                <option value="1961" >1961</option>
                                                <option value="1962" >1962</option>
                                                <option value="1963" >1963</option>
                                                <option value="1964" >1964</option>
                                                <option value="1965" >1965</option>
                                                <option value="1966" >1966</option>
                                                <option value="1967" >1967</option>
                                                <option value="1968" >1968</option>
                                                <option value="1969" >1969</option>
                                                <option value="1970" >1970</option>
                                                <option value="1971" >1971</option>
                                                <option value="1972" >1972</option>
                                                <option value="1973" >1973</option>
                                                <option value="1974" >1974</option>
                                                <option value="1975" >1975</option>
                                                <option value="1976" >1976</option>
                                                <option value="1977" >1977</option>
                                                <option value="1978" >1978</option>
                                                <option value="1979" >1979</option>
                                                <option value="1980" >1980</option>
                                                <option value="1981" >1981</option>
                                                <option value="1982" >1982</option>
                                                <option value="1983" >1983</option>
                                                <option value="1984" >1984</option>
                                                <option value="1985" >1985</option>
                                                <option value="1986" >1986</option>
                                                <option value="1987" >1987</option>
                                                <option value="1988" >1988</option>
                                                <option value="1989" >1989</option>
                                                <option value="1990" >1990</option>
                                                <option value="1991" >1991</option>
                                                <option value="1992" >1992</option>
                                                <option value="1993" >1993</option>
                                                <option value="1994" >1994</option>
                                                <option value="1995" >1995</option>
                                                <option value="1996" >1996</option>
                                                <option value="1997" >1997</option>
                                                <option value="1998" >1998</option>
                                                <option value="1999" >1999</option>
                                                <option value="2000" >2000</option>
                                                <option value="2001" >2001</option>
                                                <option value="2002" >2002</option>
                                                <option value="2003" >2003</option>
                                                <option value="2004" >2004</option>
                                                <option value="2005" >2005</option>
                                                <option value="2006" >2006</option>
                                                <option value="2007" >2007</option>
                                                <option value="2008" >2008</option>
                                                <option value="2009" >2009</option>
                                                <option value="2010" >2010</option>
                                                <option value="2011" >2011</option>
                                                <option value="2012" >2012</option>
                                                <option value="2013" >2013</option>
                                                <option value="2014" >2014</option>
                                                <option value="2015" >2015</option>
                                             </select>
                                             <span>年</span>
                                        </div>
                                        <div class="select_down select_month">
                                             <select id="anniver_month3" name="month[]" onchange="changeMonth(this);">
                                                  <option value="">月</option>
                                                  <option value="1" >1</option>
                                                  <option value="2" >2</option>
                                                  <option value="3" >3</option>
                                                  <option value="4" >4</option>
                                                  <option value="5" >5</option>
                                                  <option value="6" >6</option>
                                                  <option value="7" >7</option>
                                                  <option value="8" >8</option>
                                                  <option value="9" >9</option>
                                                  <option value="10" >10</option>
                                                  <option value="11" >11</option>
                                                  <option value="12" >12</option>
                                             </select>
                                             <span>月</span>
                                        </div>
                                        <div class="select_down select_day">
                                             <select id="anniver_day3" name="day[]" class="show_day">
                                                <option value="">日</option>
                                                <option value="1" >1</option>
                                                <option value="2" >2</option>
                                                <option value="3" >3</option>
                                                <option value="4" >4</option>
                                                <option value="5" >5</option>
                                                <option value="6" >6</option>
                                                <option value="7" >7</option>
                                                <option value="8" >8</option>
                                                <option value="9" >9</option>
                                                <option value="10" >10</option>
                                                <option value="11" >11</option>
                                                <option value="12" >12</option>
                                                <option value="13" >13</option>
                                                <option value="14" >14</option>
                                                <option value="15" >15</option>
                                                <option value="16" >16</option>
                                                <option value="17" >17</option>
                                                <option value="18" >18</option>
                                                <option value="19" >19</option>
                                                <option value="20" >20</option>
                                                <option value="21" >21</option>
                                                <option value="22" >22</option>
                                                <option value="23" >23</option>
                                                <option value="24" >24</option>
                                                <option value="25" >25</option>
                                                <option value="26" >26</option>
                                                <option value="27" >27</option>
                                                <option value="28" >28</option>
                                                <option value="29" >29</option>
                                                <option value="30" >30</option>
                                                <option value="31" >31</option>
                                             </select>
                                             <span>日</span>
                                         </div>
                                    </div>
                                  </dd>
                              </dl>
                           </li> --> 
                      <ul>
                        <form id="form2" action="<?php echo U('Home/Members/doadd');?>" method="post">
                         <li class="select_box select_box_2" id="add_anni" style="float:left;height:20px;">
                           <div class="select_memorial others">
                               <div class="select_down">
                                  <input type="text"  class=".tag_select select_input" placeholder="请填写纪念日" name="anni_name" value=''/>
                                  <span></span>
                               </div>
                           </div>
                         </li>
                         <li class="select_box" style="height:20px;">
                           <div>
                              <i></i>
                              <em style="background-position:0 -280px;"></em>
                              <p val='0'>公历</p>
                           </div>
                           <div>
                              <i></i>
                              <em ></em><p val='1'>农历</p>
                           </div>
                           <input type="text" name='calendar' value="0" id="shriRili" hidden="hidden" style="display:none;"/>
                         </li>
                         <li style="height:150px;">
                           <div class="select_box_date">
                              <div class="select_down select_year">
                                  <select id="years" name='year'>
                                      <option value="">年</option>
                                      <option value="1900" >1900</option>
                                      <option value="1901" >1901</option>
                                      <option value="1902" >1902</option>
                                      <option value="1903" >1903</option>
                                      <option value="1904" >1904</option>
                                      <option value="1905" >1905</option>
                                      <option value="1906" >1906</option>
                                      <option value="1907" >1907</option>
                                      <option value="1908" >1908</option>
                                      <option value="1909" >1909</option>
                                      <option value="1910" >1910</option>
                                      <option value="1911" >1911</option>
                                      <option value="1912" >1912</option>
                                      <option value="1913" >1913</option>
                                      <option value="1914" >1914</option>
                                      <option value="1915" >1915</option>
                                      <option value="1916" >1916</option>
                                      <option value="1917" >1917</option>
                                      <option value="1918" >1918</option>
                                      <option value="1919" >1919</option>
                                      <option value="1920" >1920</option>
                                      <option value="1921" >1921</option>
                                      <option value="1922" >1922</option>
                                      <option value="1923" >1923</option>
                                      <option value="1924" >1924</option>
                                      <option value="1925" >1925</option>
                                      <option value="1926" >1926</option>
                                      <option value="1927" >1927</option>
                                      <option value="1928" >1928</option>
                                      <option value="1929" >1929</option>
                                      <option value="1930" >1930</option>
                                      <option value="1931" >1931</option>
                                      <option value="1932" >1932</option>
                                      <option value="1933" >1933</option>
                                      <option value="1934" >1934</option>
                                      <option value="1935" >1935</option>
                                      <option value="1936" >1936</option>
                                      <option value="1937" >1937</option>
                                      <option value="1938" >1938</option>
                                      <option value="1939" >1939</option>
                                      <option value="1940" >1940</option>
                                      <option value="1941" >1941</option>
                                      <option value="1942" >1942</option>
                                      <option value="1943" >1943</option>
                                      <option value="1944" >1944</option>
                                      <option value="1945" >1945</option>
                                      <option value="1946" >1946</option>
                                      <option value="1947" >1947</option>
                                      <option value="1948" >1948</option>
                                      <option value="1949" >1949</option>
                                      <option value="1950" >1950</option>
                                      <option value="1951" >1951</option>
                                      <option value="1952" >1952</option>
                                      <option value="1953" >1953</option>
                                      <option value="1954" >1954</option>
                                      <option value="1955" >1955</option>
                                      <option value="1956" >1956</option>
                                      <option value="1957" >1957</option>
                                      <option value="1958" >1958</option>
                                      <option value="1959" >1959</option>
                                      <option value="1960" >1960</option>
                                      <option value="1961" >1961</option>
                                      <option value="1962" >1962</option>
                                      <option value="1963" >1963</option>
                                      <option value="1964" >1964</option>
                                      <option value="1965" >1965</option>
                                      <option value="1966" >1966</option>
                                      <option value="1967" >1967</option>
                                      <option value="1968" >1968</option>
                                      <option value="1969" >1969</option>
                                      <option value="1970" >1970</option>
                                      <option value="1971" >1971</option>
                                      <option value="1972" >1972</option>
                                      <option value="1973" >1973</option>
                                      <option value="1974" >1974</option>
                                      <option value="1975" >1975</option>
                                      <option value="1976" >1976</option>
                                      <option value="1977" >1977</option>
                                      <option value="1978" >1978</option>
                                      <option value="1979" >1979</option>
                                      <option value="1980" >1980</option>
                                      <option value="1981" >1981</option>
                                      <option value="1982" >1982</option>
                                      <option value="1983" >1983</option>
                                      <option value="1984" >1984</option>
                                      <option value="1985" >1985</option>
                                      <option value="1986" >1986</option>
                                      <option value="1987" >1987</option>
                                      <option value="1988" >1988</option>
                                      <option value="1989" >1989</option>
                                      <option value="1990" >1990</option>
                                      <option value="1991" >1991</option>
                                      <option value="1992" >1992</option>
                                      <option value="1993" >1993</option>
                                      <option value="1994" >1994</option>
                                      <option value="1995" >1995</option>
                                      <option value="1996" >1996</option>
                                      <option value="1997" >1997</option>
                                      <option value="1998" >1998</option>
                                      <option value="1999" >1999</option>
                                      <option value="2000" >2000</option>
                                      <option value="2001" >2001</option>
                                      <option value="2002" >2002</option>
                                      <option value="2003" >2003</option>
                                      <option value="2004" >2004</option>
                                      <option value="2005" >2005</option>
                                      <option value="2006" >2006</option>
                                      <option value="2007" >2007</option>
                                      <option value="2008" >2008</option>
                                      <option value="2009" >2009</option>
                                      <option value="2010" >2010</option>
                                      <option value="2011" >2011</option>
                                      <option value="2012" >2012</option>
                                      <option value="2013" >2013</option>
                                      <option value="2014" >2014</option>
                                      <option value="2015" >2015</option>
                                  </select>
                                  <span>年</span>
                              </div>
                              <div class="select_down">
                                <select id="months" name="month">
                                      <option value="">月</option>
                                      <option value="1" >1</option>
                                      <option value="2" >2</option>
                                      <option value="3" >3</option>
                                      <option value="4" >4</option>
                                      <option value="5" >5</option>
                                      <option value="6" >6</option>
                                      <option value="7" >7</option>
                                      <option value="8" >8</option>
                                      <option value="9" >9</option>
                                      <option value="10" >10</option>
                                      <option value="11" >11</option>
                                      <option value="12" >12</option>
                                </select>
                                <span>月</span>
                              </div>
                              <div class="select_down">
                                  <select id="days" name="day">
                                      <option value="">日</option>
                                      <option value="1" >1</option>
                                      <option value="2" >2</option>
                                      <option value="3" >3</option>
                                      <option value="4" >4</option>
                                      <option value="5" >5</option>
                                      <option value="6" >6</option>
                                      <option value="7" >7</option>
                                      <option value="8" >8</option>
                                      <option value="9" >9</option>
                                      <option value="10" >10</option>
                                      <option value="11" >11</option>
                                      <option value="12" >12</option>
                                      <option value="13" >13</option>
                                      <option value="14" >14</option>
                                      <option value="15" >15</option>
                                      <option value="16" >16</option>
                                      <option value="17" >17</option>
                                      <option value="18" >18</option>
                                      <option value="19" >19</option>
                                      <option value="20" >20</option>
                                      <option value="21" >21</option>
                                      <option value="22" >22</option>
                                      <option value="23" >23</option>
                                      <option value="24" >24</option>
                                      <option value="25" >25</option>
                                      <option value="26" >26</option>
                                      <option value="27" >27</option>
                                      <option value="28" >28</option>
                                      <option value="29" >29</option>
                                      <option value="30" >30</option>
                                      <option value="31" >31</option>
                                 </select>
                                 <span>日</span>
                              </div>
                              <samp id='kong' >M‘CAKE会员生日有惊喜哦</samp>
                           </div>
                         </li>
                         <li class="markday_btn">
                             <input type="submit" value="添加纪念日" class="login_btn" />
                         </li>
                        </form>
                      </ul>
                        <!--修改个人资料 end-->
                    </div>
                
            </div>  
        </div>

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
        
        <script type="text/javascript" src="/mcake/Public/Index/js/jquery-migrate-1.js"></script>
        <script type="text/javascript" src="/mcake/Public/Index/js/ebsig.js"></script>
        <script type="text/javascript" src="/mcake/Public/Index/js/share.js"></script>
        <script type="text/javascript" src="/mcake/Public/Index/js/selectCss.js"></script> 
        <script type="text/javascript" src="/mcake/Public/Index/js/0720.js"></script>
        <script type=text/javascript>
            var birthday = '';
            function checkanniversary(){
               var obj = $("#anniver_other").children('dd');
               var message = '';
               if(obj.length > 0 ){
                  obj.each(function(){
                      var selectid = $(this).find('select').attr('id');
                      var yearobj = $(this).find('.select_box_date').find('.select_year').find('.tag_select');
                      var monthobj = $(this).find('.select_box_date').find('.select_month').find('.tag_select');
                      var dayobj = $(this).find('.select_box_date').find('.select_day').find('.tag_select');
                      var yeartext = yearobj.text();
                      var monthtext = monthobj.text();
                      var daytext = dayobj.text();
                      if($("#"+selectid+ " option:selected").text() == ''){
                        if((!E.isEmpty(yeartext) && !isNaN(yeartext)) || (!E.isEmpty(monthtext) && !isNaN(monthtext))  || (!E.isEmpty(daytext) && !isNaN(daytext))){
                            message += "请填写完整的纪念日<br>";
                         }
                      }

                      if(selectid.indexOf('anniver') > -1 && $("#"+selectid+ " option:selected").text() != ''){
                        if(E.isEmpty(yeartext) || isNaN(yeartext) || E.isEmpty(monthtext) || isNaN(monthtext)  || E.isEmpty(daytext) || isNaN(daytext)){
                            message += "请填写完整的纪念日<br>";
                         }
                      }
                  });
               }

               if($(".select_memorial.others").length > 0){
                    var obj = $(".select_memorial.others");
                    var objlength = obj.length;
                    $.each(obj, function(i,val){     
                         var inputid = $("#"+$(this).find("input").attr('id')).val();
                         var yearobj  = $(this).next().find('.select_year').find('.tag_select');
                         var monthobj = $(this).next('.select_box_date').find('.select_month').find('.tag_select');
                         var dayobj   = $(this).next('.select_box_date').find('.select_day').find('.tag_select');
                         var yeartext = yearobj.text();
                         var monthtext = monthobj.text();
                         var daytext = dayobj.text();

                         if(E.isEmpty(inputid)){
                          if((!E.isEmpty(yeartext) && !isNaN(yeartext)) || (!E.isEmpty(monthtext) && !isNaN(monthtext))  || (!E.isEmpty(daytext) && !isNaN(daytext))){
                            message += "请填写完整的纪念日<br>";
                           }
                         }

                         if(!E.isEmpty(inputid)){

                             if(inputid.length > 18){
                              message += "纪念日名称最多填写18个汉字<br>";
                             }

                             if(E.isEmpty(inputid) || E.isEmpty(yeartext) || isNaN(yeartext) || E.isEmpty(monthtext) || isNaN(monthtext)  || E.isEmpty(daytext) || isNaN(daytext)){
                                  message += "请填写完整的纪念日<br>";
                             }
                         }   
                    });            
               }

               if(!E.isEmpty(message)){
                  E.alert(message);
                  return false;
               }else{
                return true;
               }

            }

            $(document).ready(function() {

                // 验证
                $('#name').blur(function(){
                    if($(this).val() && (E.len($(this).val()) > 20)){
                        E.alert('姓名最多填写10个汉字或20个英文字母与数字');
                    }
                });

                $('#usercount').blur(function(){
                  if($(this).val() && (E.len($(this).val()) > 20)){
                    E.alert('昵称最多填写10个汉字或20个英文字母与数字');
                  }
                });

                $('#phone').blur(function(){
                    if (E.isEmpty($(this).val())) {
                        E.alert('手机号码不能为空');
                    } else if (!E.isphone($(this).val())) {
                        E.alert('请输入正确的手机号码');
                    }
                });
                
                $('#email').blur(function(){
                     if (!E.isEmpty($(this).val()) && !E.isEmail($(this).val())) {
                        E.alert('请输入正确的邮箱');
                     }
                });
               
                $("select").selectCss();

                $(".input_txt,#Reply,.brand_txt").each(function(){
                    var thisVal=$(this).val();
                    //判断文本框的值是否为空，有值的情况就隐藏提示语，没有值就显示
                    if(thisVal!=""){
                        $(this).siblings("label").hide();
                    }else{
                        $(this).siblings("label").show();
                    }
                    //聚焦型输入框验证
                    $(this).focus(function(){
                        $(this).siblings("label").hide();
                    }).blur(function(){
                        var val=$(this).val();
                        if(val!=""){
                            $(this).siblings("label").hide();
                        }else{
                            $(this).siblings("label").show();
                        }
                    });

                });

                //日根据月份联动
                $("#month").change(function(){
                    var month = parseInt($(this).val());
                    var year = parseInt($("#year").val());
                    var birth_calendar = parseInt($('#calendar').val());
                    var day = $("#day");

                    dayByYearAndByMonth(year, month, birth_calendar, day);
                });

                //日根据年联动
                $("#year").change(function(){
                    var year = parseInt($(this).val());
                    var month = parseInt($("#month").val());
                    var birth_calendar = parseInt($('#calendar').val());
                    var day = $("#day");

                    dayByYearAndByMonth(year, month, birth_calendar,day);
                });
                
                $("#birthday .em").click(function(){
                    $("#birthday .em").css({backgroundPosition:'0 0'})
                        $(this).css({backgroundPosition:'0 -280px'});

                    $("#shriRili").attr('value',$(this).siblings("p").attr("val"));
                });

                $(".sax em").click(function(){
                    $(".sax em").css({backgroundPosition:'0 0'})
                    $(this).css({backgroundPosition:'0 -280px'});
                    $(".sax input").val($(this).siblings("p").attr("val"));
                });
                

                //性别默认显示
                var msex = $('#msex').next().attr('val');
                var nsex = $('#nsex').next().attr('val');
                var sex = <?php echo ($users['sex']); ?>;
                if(msex == sex){
                    $('#msex').css('background-position' , '0px -280px');
                    $('#nsex').css('background-position' , '0px 0px');
                }
                if(nsex == sex){
                    $('#msex').css('background-position' , '0px 0px');
                    $('#nsex').css('background-position' , '0px -280px');
                }

                //爱好默认显示
                var counthover = $('#hobby_list').attr('value').split(',').length-1;
                var hover = ($('#hobby_list').attr('value').split(',')).slice(0,counthover+1);
                var hovers = '';
                for(i=0;i<8;i++){
                    hovers = $('.login_right .hobby_0721 .hobby_list dl dd').eq(i).children('span').attr('val');
                    for(j=0;j<hover.length;j++){
                        if(hovers == hover[j]){
                          $('.login_right .hobby_0721 .hobby_list dl dd').eq(i).attr('class','checked');
                        }
                    }
                }
            });
            

            $("#gjinian<?php echo ($vo['id']); ?>").click(function(){
              if($(this).css('backgroundPosition') == '0px -280px'){
                  var va0 = $(this).siblings('p').attr('val');
                  $(this).parents('div').siblings('input').attr('value',va0);
              }else{
                  var va1 = $("#njinian<?php echo ($vo['id']); ?>").siblings('p').attr('val');
                  $(this).parents('div').siblings('input').attr('value',va1);
              }
            })

            $("#njinian<?php echo ($vo['id']); ?>").click(function(){
              alert('hehe');
              if($(this).css('backgroundPosition') == '0px -280px'){
                  var va0 = $(this).siblings('p').attr('val');
                  $(this).parents('div').siblings('input').attr('value',va0);
              }else{
                  var va1 = $("#gjinian<?php echo ($vo['id']); ?>").siblings('p').attr('val');
                  $(this).parents('div').siblings('input').attr('value',va1);
              }
            })

            
            //修改提交

            $('#form').submit(function(){
              
                var phone = E.trim($('#phone').val());

                var name = $('#name').val();

                // var calendar = E.trim($('#calendar').val());

                var usercount = $('#usercount').val();
                // alert('hehe');
                var email = $('#email').val();
                var sexy = $('#sexy').val();
                // var hobby_list = $('#hobby_list').val();

                //爱好设置
                var hobby_list = [];
                for(var i=0 ; i<8 ; i++){
                    if($('.login_right .hobby_0721 .hobby_list dl dd').eq(i).attr('class') == 'checked'){
                        hobby_list.push($('.login_right .hobby_0721 .hobby_list dl dd').eq(i).children('span').attr('val'));
                    }
                }
                $("#hobby_list").val(hobby_list);


                if (!birthday) {
                    var year = $('#year').val();
                    var month = $('#month').val();
                    var day = $('#day').val();
                } else {
                    var year = '';
                    var month = '';
                    var day = '';
                }
                var error_msg = '';

                if (E.isEmpty(phone)) {
                    error_msg += '手机号码不能为空<br>';
                } else if (!E.isphone(phone)) {
                    error_msg += '请输入正确的手机号码<br>';
                }

                if(E.isEmpty(E.trim(name)))
                    name = '';

                if(!E.isEmpty(name))

                if (!E.isEmpty(name) && E.len(name) > 20) {
                    error_msg += '姓名最多填写10个汉字或20个英文字母与数字<br>';
                }
                
                if(E.isEmpty(E.trim(usercount)))
                    usercount = '';

                if(!E.isEmpty(usercount))

                if (!E.isEmpty(usercount) && E.len(usercount) > 20) {
                    error_msg += '昵称最多填写10个汉字或20个英文字母与数字<br>';
                }

                if (!E.isEmpty(email) && !E.isEmail(email)) {
                    error_msg += '请输入正确的邮箱<br>';
                }

                if (!birthday) {
                    if (!E.isEmpty(month)) {
                        if (E.isEmpty(day) || E.isEmpty(year)) {
                            error_msg += '生日不完整<br>';
                        }
                    } else if (!E.isEmpty(day)) {
                        if (E.isEmpty(month) || E.isEmpty(year)) {
                            error_msg += '生日不完整<br>';
                        }
                    } else if (!E.isEmpty(year)) {
                        if (E.isEmpty(month) || E.isEmpty(day)) {
                            error_msg += '生日不完整<br>';
                        }
                    }
                }

                var type =document.getElementsByName("");
                var name =document.getElementsByName("anni_name[]");
                var anniversary_id =document.getElementsByName("anniversary_id[]");
                if(type || name || anniversary_id){

                  var result1 = checkanniversary();
                  if(result1 == true){
                    var result2 = addanniver();
                    if(result2 == false){
                      return false;
                    }
                  }else{
                    return false;
                  }
                }

                if (!E.isEmpty(error_msg)) {
                    E.alert(error_msg);
                    return false;
                } else {
                    E.loadding.open('正在修改资料，请稍候...');
                    E.ajax_post({
                        action: 'customer',
                        operFlg: 5,
                        data: {
                            phone: phone,
                            usercount: usercount,
                            email: email,
                            sexy: sexy,
                            year: year,
                            month: month,
                            name: name,
                            calendar: calendar,
                            hobby: hobby_list,
                            day: day
                        },
                        call: function( o ) {
                            if (o.code == 200) {
                                E.alert('资料修改成功', 2, 'E.refresh');
                            } else {
                                E.loadding.close();
                                E.alert(o.message);
                            }
                        }
                    });
                }
            })
            //添加纪念日
            function addanniver()
            {
              var message = '';
              //纪念日id
              var anniversary_id =document.getElementsByName("anniversary_id");
              var anniversary_idArr = [];
              for(var i = 0;i<anniversary_id.length;i++)
              {
                  anniversary_idArr.push(anniversary_id[i].value);
              } 
              
              //纪念日名称
              var name =document.getElementsByName("anni_name");
              var nameArr = [];
              for(var i = 0;i<name.length;i++)
              {
                nameArr.push(name[i].value);
              }
              //纪念日名称类别
              var type =document.getElementsByName("");
              var typeArr = [];
              for(var i = 0;i<type.length;i++)
              {
                typeArr.push(type[i].value);
              }
              //判断纪念日名称是否相同
              if(isRepeat(typeArr)== true || isRepeat(nameArr)== true){
                message +='纪念日的名称不可以相同<br>';
              }
              //纪念日级别
              var level =document.getElementsByName("level[]");
              var levelArr = [];
              for(var i = 0;i<level.length;i++)
              {
                levelArr.push(level[i].value);
              } 
              纪念日日历
              var calendar =document.getElementsByName("calendar");
              var calendarArr = [];
              for(var i = 0;i<calendar.length;i++)
              {
                calendarArr.push(calendar[i].value);
              } 
              纪念日年份
              var year =document.getElementsByName("year[]");
              var yearArr = [];
              for(var i = 0;i<year.length;i++)
              {
                yearArr.push(year[i].value);
              }
              //纪念日月份 
              var month =document.getElementsByName("month[]");
              var monthArr = [];
              for(var i = 0;i<month.length;i++)
              {
                 monthArr.push(month[i].value);
              } 
              //纪念日日子
              var day =document.getElementsByName("day[]");
              var dayArr = [];
              for(var i = 0;i<day.length;i++)
              {
                 dayArr.push(day[i].value);
              } 
              if (!E.isEmpty(message)) {
                 E.alert(message);
                 return false;
                }else{
                  E.ajax_post({
                    action: 'customer',
                    operFlg: 12,
                    data: {
                        typeArr: typeArr,
                        levelArr: levelArr,
                        calendarArr: calendarArr,
                        yearArr: yearArr,
                        monthArr: monthArr,
                        nameArr:nameArr,
                        anniversary_idArr:anniversary_idArr,
                        dayArr: dayArr
                    },
                    call: function( o ) {
                        if (o.code == 200) {
                          return true;
                        } else {
                          return false;
                        }
                    }
                 });
              }

            }

            //根据月、年联动日
            function dayByYearAndByMonth(year, month, calendar,day){
                var end; 
                switch (parseInt(month)){
                    case 1:
                    case 3:
                    case 5:
                    case 7:
                    case 8:
                    case 10:
                    case 12:
                        if(calendar==0){
                        end = 30;
                        }else{
                        end = 31;
                        }
                        break;
                    case 2:
                        var year = year;
                        if((year % 4 == 0) && (year % 100 != 0) || (year % 400 == 0)){
                            end = 29;
                        }else{
                            end = 28;
                        }               
                        break;
                    case 4:
                    case 6:
                    case 9:
                    case 11:
                        end = 30;
                        break;

                }
                //alert(day);
                var html = '<option value="">日</option>';
                for(var i = 1; i <= end; i++){
                    html += '<option value="'+ i +'">'+ i +'</option>';
                }
                
                $(day).html(html);
                $("select").selectCss();
            }

            //新增其它按钮
             function addOther(){
              var count = $(".select_memorial.others").length;
              var new_id = 'ather_name'+count;
              var new_count = count -1;
              var id = 'ather_name'+new_count;

              var yeartext = $("#"+id).closest('.select_memorial.others').next(".select_box_date").find('.select_down.select_year').find('.tag_select').text();
              var monthtext = $("#"+id).closest('.select_memorial.others').next(".select_box_date").find('.select_down.select_month').find('.tag_select').text();
              var daytext = $("#"+id).closest('.select_memorial.others').next(".select_box_date").find('.select_down.select_day').find('.tag_select').text();

              var show_style = $("#"+id).closest('.select_memorial.others').next(".select_box_date").attr('date') - 1;
             
              var ather_name = $("#"+id).val();
              if(E.isEmpty(ather_name) || E.isEmpty(yeartext) || isNaN(yeartext) || E.isEmpty(monthtext) || isNaN(monthtext)  || E.isEmpty(daytext) || isNaN(daytext)){
                  alert("请把上一个纪念日填写完整");
                }else{
                var other_html = '';
                   other_html += "<dd>";
                   other_html += "<div class=\"select_memorial others\">";
                   other_html += "<span class=\"tt_left\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;其他:</span>";
                   other_html += "<div class=\"select_down\">";
                   other_html += "<input type=\"text\" id='"+new_id+"' class=\".tag_select select_input\" placeholder=\"请填写纪念日\" name=\"\" value=''/>";
                   other_html += "</div>";
                   other_html += "<input type='hidden' value='' name=\"jinian[]\">";
                   other_html += "<input type='hidden' value='4' name=\"level[]\">";
                   other_html += "<input type='hidden' value='' name=\"anniversary_id[]\">";
                   other_html += "<samp>请填写完整的纪念日</samp>";
                   other_html += "</div>";
                   other_html += "<div class=\"select_box_date\" style=\"z-index:"+show_style+"\">";
                   other_html += "<div class=\"select_down select_down_0\">";
                   other_html += "<select id='ather_calendar' name=\"calendar[]\">";
                   other_html += "<option value='0' selected>公历</option>";
                   other_html += "<option value='1'>农历</option>";
                   other_html += "</select>";
                   other_html += "</div>";
                   other_html += " <div class=\"select_down select_year\">";
                   other_html += "<select id='ather_month' name=\"year[]\">";
                   other_html += "<option value=\"\">年</option>"
                              other_html += "<option value=\""+1900+"\">"+1900+"</option>";
                              other_html += "<option value=\""+1901+"\">"+1901+"</option>";
                              other_html += "<option value=\""+1902+"\">"+1902+"</option>";
                              other_html += "<option value=\""+1903+"\">"+1903+"</option>";
                              other_html += "<option value=\""+1904+"\">"+1904+"</option>";
                              other_html += "<option value=\""+1905+"\">"+1905+"</option>";
                              other_html += "<option value=\""+1906+"\">"+1906+"</option>";
                              other_html += "<option value=\""+1907+"\">"+1907+"</option>";
                              other_html += "<option value=\""+1908+"\">"+1908+"</option>";
                              other_html += "<option value=\""+1909+"\">"+1909+"</option>";
                              other_html += "<option value=\""+1910+"\">"+1910+"</option>";
                              other_html += "<option value=\""+1911+"\">"+1911+"</option>";
                              other_html += "<option value=\""+1912+"\">"+1912+"</option>";
                              other_html += "<option value=\""+1913+"\">"+1913+"</option>";
                              other_html += "<option value=\""+1914+"\">"+1914+"</option>";
                              other_html += "<option value=\""+1915+"\">"+1915+"</option>";
                              other_html += "<option value=\""+1916+"\">"+1916+"</option>";
                              other_html += "<option value=\""+1917+"\">"+1917+"</option>";
                              other_html += "<option value=\""+1918+"\">"+1918+"</option>";
                              other_html += "<option value=\""+1919+"\">"+1919+"</option>";
                              other_html += "<option value=\""+1920+"\">"+1920+"</option>";
                              other_html += "<option value=\""+1921+"\">"+1921+"</option>";
                              other_html += "<option value=\""+1922+"\">"+1922+"</option>";
                              other_html += "<option value=\""+1923+"\">"+1923+"</option>";
                              other_html += "<option value=\""+1924+"\">"+1924+"</option>";
                              other_html += "<option value=\""+1925+"\">"+1925+"</option>";
                              other_html += "<option value=\""+1926+"\">"+1926+"</option>";
                              other_html += "<option value=\""+1927+"\">"+1927+"</option>";
                              other_html += "<option value=\""+1928+"\">"+1928+"</option>";
                              other_html += "<option value=\""+1929+"\">"+1929+"</option>";
                              other_html += "<option value=\""+1930+"\">"+1930+"</option>";
                              other_html += "<option value=\""+1931+"\">"+1931+"</option>";
                              other_html += "<option value=\""+1932+"\">"+1932+"</option>";
                              other_html += "<option value=\""+1933+"\">"+1933+"</option>";
                              other_html += "<option value=\""+1934+"\">"+1934+"</option>";
                              other_html += "<option value=\""+1935+"\">"+1935+"</option>";
                              other_html += "<option value=\""+1936+"\">"+1936+"</option>";
                              other_html += "<option value=\""+1937+"\">"+1937+"</option>";
                              other_html += "<option value=\""+1938+"\">"+1938+"</option>";
                              other_html += "<option value=\""+1939+"\">"+1939+"</option>";
                              other_html += "<option value=\""+1940+"\">"+1940+"</option>";
                              other_html += "<option value=\""+1941+"\">"+1941+"</option>";
                              other_html += "<option value=\""+1942+"\">"+1942+"</option>";
                              other_html += "<option value=\""+1943+"\">"+1943+"</option>";
                              other_html += "<option value=\""+1944+"\">"+1944+"</option>";
                              other_html += "<option value=\""+1945+"\">"+1945+"</option>";
                              other_html += "<option value=\""+1946+"\">"+1946+"</option>";
                              other_html += "<option value=\""+1947+"\">"+1947+"</option>";
                              other_html += "<option value=\""+1948+"\">"+1948+"</option>";
                              other_html += "<option value=\""+1949+"\">"+1949+"</option>";
                              other_html += "<option value=\""+1950+"\">"+1950+"</option>";
                              other_html += "<option value=\""+1951+"\">"+1951+"</option>";
                              other_html += "<option value=\""+1952+"\">"+1952+"</option>";
                              other_html += "<option value=\""+1953+"\">"+1953+"</option>";
                              other_html += "<option value=\""+1954+"\">"+1954+"</option>";
                              other_html += "<option value=\""+1955+"\">"+1955+"</option>";
                              other_html += "<option value=\""+1956+"\">"+1956+"</option>";
                              other_html += "<option value=\""+1957+"\">"+1957+"</option>";
                              other_html += "<option value=\""+1958+"\">"+1958+"</option>";
                              other_html += "<option value=\""+1959+"\">"+1959+"</option>";
                              other_html += "<option value=\""+1960+"\">"+1960+"</option>";
                              other_html += "<option value=\""+1961+"\">"+1961+"</option>";
                              other_html += "<option value=\""+1962+"\">"+1962+"</option>";
                              other_html += "<option value=\""+1963+"\">"+1963+"</option>";
                              other_html += "<option value=\""+1964+"\">"+1964+"</option>";
                              other_html += "<option value=\""+1965+"\">"+1965+"</option>";
                              other_html += "<option value=\""+1966+"\">"+1966+"</option>";
                              other_html += "<option value=\""+1967+"\">"+1967+"</option>";
                              other_html += "<option value=\""+1968+"\">"+1968+"</option>";
                              other_html += "<option value=\""+1969+"\">"+1969+"</option>";
                              other_html += "<option value=\""+1970+"\">"+1970+"</option>";
                              other_html += "<option value=\""+1971+"\">"+1971+"</option>";
                              other_html += "<option value=\""+1972+"\">"+1972+"</option>";
                              other_html += "<option value=\""+1973+"\">"+1973+"</option>";
                              other_html += "<option value=\""+1974+"\">"+1974+"</option>";
                              other_html += "<option value=\""+1975+"\">"+1975+"</option>";
                              other_html += "<option value=\""+1976+"\">"+1976+"</option>";
                              other_html += "<option value=\""+1977+"\">"+1977+"</option>";
                              other_html += "<option value=\""+1978+"\">"+1978+"</option>";
                              other_html += "<option value=\""+1979+"\">"+1979+"</option>";
                              other_html += "<option value=\""+1980+"\">"+1980+"</option>";
                              other_html += "<option value=\""+1981+"\">"+1981+"</option>";
                              other_html += "<option value=\""+1982+"\">"+1982+"</option>";
                              other_html += "<option value=\""+1983+"\">"+1983+"</option>";
                              other_html += "<option value=\""+1984+"\">"+1984+"</option>";
                              other_html += "<option value=\""+1985+"\">"+1985+"</option>";
                              other_html += "<option value=\""+1986+"\">"+1986+"</option>";
                              other_html += "<option value=\""+1987+"\">"+1987+"</option>";
                              other_html += "<option value=\""+1988+"\">"+1988+"</option>";
                              other_html += "<option value=\""+1989+"\">"+1989+"</option>";
                              other_html += "<option value=\""+1990+"\">"+1990+"</option>";
                              other_html += "<option value=\""+1991+"\">"+1991+"</option>";
                              other_html += "<option value=\""+1992+"\">"+1992+"</option>";
                              other_html += "<option value=\""+1993+"\">"+1993+"</option>";
                              other_html += "<option value=\""+1994+"\">"+1994+"</option>";
                              other_html += "<option value=\""+1995+"\">"+1995+"</option>";
                              other_html += "<option value=\""+1996+"\">"+1996+"</option>";
                              other_html += "<option value=\""+1997+"\">"+1997+"</option>";
                              other_html += "<option value=\""+1998+"\">"+1998+"</option>";
                              other_html += "<option value=\""+1999+"\">"+1999+"</option>";
                              other_html += "<option value=\""+2000+"\">"+2000+"</option>";
                              other_html += "<option value=\""+2001+"\">"+2001+"</option>";
                              other_html += "<option value=\""+2002+"\">"+2002+"</option>";
                              other_html += "<option value=\""+2003+"\">"+2003+"</option>";
                              other_html += "<option value=\""+2004+"\">"+2004+"</option>";
                              other_html += "<option value=\""+2005+"\">"+2005+"</option>";
                              other_html += "<option value=\""+2006+"\">"+2006+"</option>";
                              other_html += "<option value=\""+2007+"\">"+2007+"</option>";
                              other_html += "<option value=\""+2008+"\">"+2008+"</option>";
                              other_html += "<option value=\""+2009+"\">"+2009+"</option>";
                              other_html += "<option value=\""+2010+"\">"+2010+"</option>";
                              other_html += "<option value=\""+2011+"\">"+2011+"</option>";
                              other_html += "<option value=\""+2012+"\">"+2012+"</option>";
                              other_html += "<option value=\""+2013+"\">"+2013+"</option>";
                              other_html += "<option value=\""+2014+"\">"+2014+"</option>";
                              other_html += "<option value=\""+2015+"\">"+2015+"</option>";
                              other_html += "</select>";
                   other_html += "<span>年</span>";
                   other_html += "</div>";
                   other_html += "<div class=\"select_down select_month\">";
                   other_html += "<select id=\"ather_month\" name=\"month[]\" onchange=\"changeMonth(this);\">";
                   other_html += "<option value=\"\">月</option>";
                              other_html += "<option value=\""+1+"\">"+1+"</option>";
                              other_html += "<option value=\""+2+"\">"+2+"</option>";
                              other_html += "<option value=\""+3+"\">"+3+"</option>";
                              other_html += "<option value=\""+4+"\">"+4+"</option>";
                              other_html += "<option value=\""+5+"\">"+5+"</option>";
                              other_html += "<option value=\""+6+"\">"+6+"</option>";
                              other_html += "<option value=\""+7+"\">"+7+"</option>";
                              other_html += "<option value=\""+8+"\">"+8+"</option>";
                              other_html += "<option value=\""+9+"\">"+9+"</option>";
                              other_html += "<option value=\""+10+"\">"+10+"</option>";
                              other_html += "<option value=\""+11+"\">"+11+"</option>";
                              other_html += "<option value=\""+12+"\">"+12+"</option>";
                              other_html += "</select>";
                   other_html += " <span>月</span>";
                   other_html += "</div>";
                   other_html += "<div class=\"select_down select_day\">";
                   other_html += "<select id=\"ather_day\" name=\"day[]\" class=\"show_day\">";
                   other_html += "<option value=\"\">日</option>";
                              other_html += "<option value=\""+1+"\">"+1+"</option>";
                              other_html += "<option value=\""+2+"\">"+2+"</option>";
                              other_html += "<option value=\""+3+"\">"+3+"</option>";
                              other_html += "<option value=\""+4+"\">"+4+"</option>";
                              other_html += "<option value=\""+5+"\">"+5+"</option>";
                              other_html += "<option value=\""+6+"\">"+6+"</option>";
                              other_html += "<option value=\""+7+"\">"+7+"</option>";
                              other_html += "<option value=\""+8+"\">"+8+"</option>";
                              other_html += "<option value=\""+9+"\">"+9+"</option>";
                              other_html += "<option value=\""+10+"\">"+10+"</option>";
                              other_html += "<option value=\""+11+"\">"+11+"</option>";
                              other_html += "<option value=\""+12+"\">"+12+"</option>";
                              other_html += "<option value=\""+13+"\">"+13+"</option>";
                              other_html += "<option value=\""+14+"\">"+14+"</option>";
                              other_html += "<option value=\""+15+"\">"+15+"</option>";
                              other_html += "<option value=\""+16+"\">"+16+"</option>";
                              other_html += "<option value=\""+17+"\">"+17+"</option>";
                              other_html += "<option value=\""+18+"\">"+18+"</option>";
                              other_html += "<option value=\""+19+"\">"+19+"</option>";
                              other_html += "<option value=\""+20+"\">"+20+"</option>";
                              other_html += "<option value=\""+21+"\">"+21+"</option>";
                              other_html += "<option value=\""+22+"\">"+22+"</option>";
                              other_html += "<option value=\""+23+"\">"+23+"</option>";
                              other_html += "<option value=\""+24+"\">"+24+"</option>";
                              other_html += "<option value=\""+25+"\">"+25+"</option>";
                              other_html += "<option value=\""+26+"\">"+26+"</option>";
                              other_html += "<option value=\""+27+"\">"+27+"</option>";
                              other_html += "<option value=\""+28+"\">"+28+"</option>";
                              other_html += "<option value=\""+29+"\">"+29+"</option>";
                              other_html += "<option value=\""+30+"\">"+30+"</option>";
                              other_html += "<option value=\""+31+"\">"+31+"</option>";
                              other_html += "</select>";
                   other_html += "<span>日</span>";
                   other_html += "</div>";                          
                   other_html += "</div>";
                   other_html += "</dd>";
         
                $('#anniver_other').append(other_html);
                $("select").selectCss();
              }
            }
              // 验证重复元素，有重复返回true；否则返回false
              function isRepeat(arr) {
                 var hash = {};
                 for(var i in arr) {
                     if(hash[arr[i]] && !E.isEmpty(arr[i]))
                     {
                         return true;
                     }
                     // 不存在该元素，则赋值为true，可以赋任意值，相应的修改if判断条件即可
                     hash[arr[i]] = true;
                  }
                 return false;
              }
              // 获取选中的月份
              function changeMonth(obj)
              {
                var month = obj.value;
                var year = $(obj).parent('.select_down.select_month').prev('.select_down.select_year').find('.tag_select').html();
                if($(obj).parent('.select_down.select_month').prev('.select_down.select_year').prev('.select_down.select_down_0').find('.tag_select').html()=='公历'){
                  var anniver_calendar = 0;
                }else{
                  var anniver_calendar = 1;
                } 
                var day = $(obj).parent('.select_down.select_month').next('.select_down.select_day').find('.show_day');
                
                dayByYearAndByMonth(year, month, anniver_calendar,day);
              }

              //给纪念日名称赋值
              function changeAnniver(number)
              {
                var Annivername=$("#anniver"+number).find("option:selected").text();
                $("#anniverName"+number).val(Annivername);
              }
        </script>

        <script type="text/javascript">

            // 设置星期
            var d = new Date();
            var week = d.getDay();
            switch (week) {
                case 0:
                    $('#week').html('今天是星期日');
                    break;
                case 1:
                    $('#week').html('今天是星期一');
                    break;
                case 2:
                    $('#week').html('今天是星期二');
                    break;
                case 3:
                    $('#week').html('今天是星期三');
                    break;
                case 4:
                    $('#week').html('今天是星期四');
                    break;
                case 5:
                    $('#week').html('今天是星期五');
                    break;
                case 6:
                    $('#week').html('今天是星期六');
                    break;
            }

            $('#form2').submit(function(){
                var Q = false;
                var W = false;
                var E = false;
                var R = false;
                //纪念日名不为空
                var anni = $('#add_anni input').val();
                if(!anni){
                    Q = false;
                    $('#add_anni input').next().html('请填写纪念日名称').css('color','red');
                }else{
                    Q = true;
                    $('#add_anni input').next().html('');
                }

                //判断年月日
                var year = $('#years').val();
                if(!year){
                    W = false;
                    $('#kong').html('请填写完整的纪念日').css('color','red');
                }else{
                    W = true;
                    $('#kong').html('M‘CAKE会员生日有惊喜哦');
                }

                var month = $('#months').val();
                if(!month){
                    E = false;
                    $('#kong').html('请填写完整的纪念日').css('color','red');
                }else{
                    E = true;
                    $('#kong').html('M‘CAKE会员生日有惊喜哦');
                }

                var day = $('#days').val();
                if(!day){
                    R = false;
                    $('#kong').html('请填写完整的纪念日').css('color','red');
                }else{
                    R = true;
                    $('#kong').html('M‘CAKE会员生日有惊喜哦');
                }

                //判断公历农历
                  if($('#shriRili').siblings('div').eq(0).children('em').css('background-position')=='0px -280px'){
                    var val = $('#shriRili').siblings('div').eq(0).children('p').attr('val');
                    $('#shriRili').attr('value',val);
                }else{
                    var val2 = $('#shriRili').siblings('div').eq(1).children('p').attr('val');
                    $('#shriRili').attr('value',val2);
                }

                if(Q && W && E && R){
                    return true;
                }else{
                    return false;
                }
            })
              
        </script>
    </body>
</html>