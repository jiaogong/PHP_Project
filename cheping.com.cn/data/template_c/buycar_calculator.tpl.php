<? if(!defined('SITE_ROOT')) exit('Access Denied');?>
<? include $this->gettpl('index_header');?>
<div class="content">
    <div class="i-tabs">
        <div class="i-tabs-nav"> 
            <span class="i-tabs-item <? if ($allid == 1) { ?>i-tabs-item-active<? } ?>" id="nv1" onmouseout="boss()">全款购车</span> 
            <span class="i-tabs-item <? if ($allid == 2) { ?>i-tabs-item-active<? } ?>" id="nv2" onmouseout="boss()">贷款购车</span>
            <span class="i-tabs-item <? if ($allid == 3) { ?>i-tabs-item-active<? } ?>" id="nv3" onmouseout="boss()"> 保险计算</span> 
        </div>
        <div class="i-tabs-container">
            <div class="i-tabs-content<? if (!$mid||$allid==1) { ?> i-tabs-content-active<? } ?>">
                <div class="tabs-news-module">
                    <p><span style="font-weight:bold;font-size:14px;">选择车型：</span>
                        <select id="fctbox1" onchange="javascript:series_select($('#brbox1'), this.value);">
                            <option value="">品牌</option>
                            <? if (!$bid) { ?><script>brand_select($('#fctbox1'));</script><? } else { ?><script>brand_select($('#fctbox1'), <?=$bid?>);</script><? } ?>

                        </select>
                        <select id="brbox1" onchange="javascript:model_select($('#model_id'), this.value);" <? if (!$sid) { ?> disabled="disabled" <? } ?>>
                                <option value="">车系</option>
                            <? if ($bid&&$sid) { ?><script> series_selected($('#brbox1'), <?=$bid?>, <?=$sid?>)</script><? } ?>

                        </select>
                        <select style="margin-right:15px;" id="model_id" <? if (!$mid) { ?> disabled="disabled" <? } ?>>
                                <option value="">车型</option>
                            <? if ($sid&&$mid) { ?> <script> model_selected($('#model_id'), <?=$sid?>, <?=$mid?>)</script><? } ?>
                        </select>
                        <span style="font-weight:bold; font-size:14px;">购车价格：</span>
                        <input type="text" value="0" id="txtCarPrice" />
                        元<span style="color:#797979;">（可自行填入或修改）</span></p>
                    <p style="margin-top:15px;"><img src="images/qkgc_bg.gif" /></p>
                    <div class="content_qkgc">
                        <p><span style="font-size:16px;">全款购车共需花费：<span style="color:#ee7810; font-size:18px;" id="spanTotalTop">0 </span>元 </span><span style="font-size:12px;">( <span style="color:#ee7810;">此结果仅供参考，实际应缴费以当地为准。</span>)</span></p>
                        <table width="923" border="0" style="border:solid 1px #d7dfe4; margin-top:10px;">
                            <tr style=" background-color:#dee4e9; font-size:14px; color:#3e4248;">
                                <th width="150" scope="col">项目明细</th>
                                <th width="268" scope="col" style="text-align:center;"> 选项 </th>
                                <th width="202" scope="col">金额 </th>
                                <th width="303" scope="col"> 计算公式及备注 </th>
                            </tr>
                            <tr style="background-color:#f1f4f6; font-size:14px; color:#ee7810; height:30px;">
                                <td colspan="4">必要花费</td>
                            </tr>
                            <tr>
                                <td class="gzs">购置税<a href="#" onmousemove="over()" onmouseout="out()"><img src="images/qkgc_-.jpg" /></a>
                                    <div id="div" style="visibility:hidden;"><div class="cont"><div class="gzs_jtbg"><img src="images/qkgc_gzs.jpg" /></div>车辆购置税是对在我国境内购置规定车辆的单位和个人征收的一种税，它由车辆购置附加费演变而来。现行车辆购置税法的基本规范，是从2001年1月1日起实施的《中华人民共和国车辆购置税暂行条例》。车辆购置税的纳税人为购置（包括购买、进口、自产、受赠、获奖或以其他方式取得并自用）应税车辆的单位和个人，征税范围为汽车、摩托车、电车、挂车、农用运输车，税率为10%，应纳税额的计算公式为：应纳税额=计税价格×税率。（2009年1月20日至12月31日，对1.6升及以下排量乘用车减按5%征收车辆购置税。自2010年1月1日至12月31日，对1.6升及以下排量乘用车减按7.5%征收车辆购置税。）</div></div></td>
                                <td>&nbsp;</td>
                                <td><input type="text" value="0" id="txtPurchaseTax" />
                                    元</td>
                                <td>购置税＝购车款／（1＋17％）× 购置税率(10%)</td>
                            </tr>
                            <tr>
                                <td>上牌费用</td>
                                <td>&nbsp;</td>
                                <td><input type="text" value="0" id="txtLicenseTax" />
                                    元</td>
                                <td>通常商家提供的一条龙服务收费约500元，个人办理
                                    约373元，其中工商验证、出库150元、移动证30元、
                                    环保卡3元、拓号费40元、行驶证相片20元、托盘费
                                    130元</td>
                            </tr>
                            <tr>
                                <td>车船使用税<img src="images/qkgc_-.jpg" /></td>
                                <td>
                                    <ul>
                                        <li>
                                            <label><input type="radio" <? if ($st==1) { ?>checked="checked"<? } ?> value="1" name="rdDisplacement" id="rdDisplacement10">1.0L（含）以下</label></li>
                                        <li>
                                            <label><input type="radio" <? if ($st==1.6) { ?>checked="checked"<? } ?> value="1.6" name="rdDisplacement" id="rdDisplacement16">1.0-1.6L（含）</label></li>
                                        <li>
                                            <label><input type="radio" <? if ($st==2) { ?>checked="checked"<? } ?> value="2" name="rdDisplacement" id="rdDisplacement20">1.6-2.0L(含）</label></li>
                                        <li>
                                            <label><input type="radio" <? if ($st==2.5) { ?>checked="checked"<? } ?> value="2.5" name="rdDisplacement" id="rdDisplacement25">2.0-2.5L（含）</label></li>
                                        <li>
                                            <label><input type="radio" <? if ($st==3) { ?>checked="checked"<? } ?> value="3" name="rdDisplacement" id="rdDisplacement30">2.5-3.0L（含）</label></li>
                                        <li>
                                            <label><input type="radio" <? if ($st==4) { ?>checked="checked"<? } ?> value="4" name="rdDisplacement" id="rdDisplacement40">3.0-4.0L（含）</label></li>
                                        <li>
                                            <label><input type="radio" <? if ($st==4.1) { ?>checked="checked"<? } ?> value="4.1" name="rdDisplacement" id="rdDisplacement40s">4.0以上</label></li>
                                    </ul>
                                </td>
                                <td><input type="text" value="0" id="txtUsageTax" />
                                    元</td>
                                <td>
                                    <div>各省不统一，以北京为例(单位/年)。</div>
                                    <ul>
                                        <li>1.0L(含)以下300元；</li>
                                        <li>1.0-1.6L(含)420元；</li>
                                        <li>1.6-2.0L(含)480元；</li>
                                        <li>2.0-2.5L(含)900元；</li>
                                        <li>2.5-3.0L(含)1920元；</li>
                                        <li>3.0-4.0L(含)3480元；</li>
                                        <li>4.0L以上5280元；不足一年按当年剩余月算。</li>
                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <td>交强险<img src="images/qkgc_-.jpg" /></td>
                                <td><input type="radio" checked="checked" id="rdSeatCount6" name="rdSeatCount" value="6" />
                                    家用6座及以下
                                    <input type="radio" id="rdSeatCount7" name="rdSeatCount" value="7" />
                                    家用6座以上</td>
                                <td><input type="text" value="0" id="txtTrafficInsurance" />
                                    元</td>
                                <td>家用6座及以下950元/年，家用6座以上1100元/年</td>
                            </tr>
                            <tr style="background-color:#f1f4f6; font-size:14px; color:#ee7810; height:30px;">
                                <td colspan="4">商业保险</td>
                            </tr>
                            <tr>
                                <td class="cgbx">常规保险合计</td>
                                <td></td>
                                <td><input type="text" value="0" id="spanCommerceTotal" />
                                    元</td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" checked="checked" value="" id="cbThirdCheck" />
                                    第三者责任险<img src="images/qkgc_-.jpg" /></td>
                                <td>赔付额度：<br />
                                    <input type="radio" checked="checked" id="rdThirdInsureClaim5" name="rdThirdInsureClaim" value="50000" />
                                    5万
                                    <input type="radio" id="rdThirdInsureClaim10" name="rdThirdInsureClaim" value="100000" />
                                    10万
                                    <input type="radio" id="rdThirdInsureClaim20" name="rdThirdInsureClaim" value="200000" />
                                    20万
                                    <input type="radio" id="rdThirdInsureClaim50" name="rdThirdInsureClaim" value="500000" />
                                    50万<br />
                                    <input type="radio" id="rdThirdInsureClaim100" name="rdThirdInsureClaim" value="1000000" />
                                    100万</td>
                                <td><input type="text" value="0" id="txtThirdInsurance" />
                                    元</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" id="cbDamageCheck" />
                                    车辆损失险<img src="images/qkgc_-.jpg" /></td>
                                <td></td>
                                <td><input type="text" value="0" id="txtDamageInsurance" />
                                    元</td>
                                <td>基础保费+裸车价格×1.0880%</td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" id="cbStolenCheck" disabled="disabled" />
                                    全车盗抢险<img src="images/qkgc_-.jpg" /></td>
                                <td></td>
                                <td><input type="text" value="0" id="txtStolenInsurance" />
                                    元</td>
                                <td>基础保费+裸车价格×费率 </td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" id="cbGlassCheck" />
                                    玻璃单独破碎险<img src="images/qkgc_-.jpg" /></td>
                                <td><input type="radio" checked="checked" id="rdImport1" name="rdImport" value="1" />
                                    进口
                                    <input type="radio" id="rdImport0" name="rdImport" value="0" />
                                    国产</td>
                                <td><input type="text" value="0" id="txtGlassInsurance" />
                                    元</td>
                                <td>进口新车购置价×0.25%，国产新车购置价×0.15%</td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" id="cbCombustCheck" />
                                    自燃损失险<img src="images/qkgc_-.jpg" /></td>
                                <td></td>
                                <td><input type="text" value="0" id="txtCombustInsurance" />
                                    元</td>
                                <td>新车购置价×0.15%</td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" id="cbNoDeductibleCheck" disabled="disabled" />
                                    不计免赔特约险<img src="images/qkgc_-.jpg" /></td>
                                <td></td>
                                <td><input type="text" value="0" id="txtNoDeductibleInsurance" />
                                    元</td>
                                <td>(车辆损失险+第三者责任险)×20%</td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" id="cbNoLiabilityCheck" />
                                    无过责任险<img src="images/qkgc_-.jpg" /></td>
                                <td></td>
                                <td><input type="text" value="0" id="txtNoLiabilityInsurance" />
                                    元</td>
                                <td>第三者责任险保险费×20%</td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" id="cbPassengerCheck" />
                                    车上人员责任险<img src="images/qkgc_-.jpg" /></td>
                                <td></td>
                                <td><input type="text" value="0" id="txtPassengerInsurance" />
                                    元</td>
                                <td>每人保费50元，可根据车辆的实际座位数填写</td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" id="cbCarBodyCheck" disabled="disabled" />
                                    车身划痕险<img src="images/qkgc_-.jpg" /></td>
                                <td>赔付额度：<br />
                                    <input type="radio" checked="checked" id="rdCarBodyInsure2000" name="rdCarBodyInsure" value="2000" />
                                    2千
                                    <input type="radio" id="rdCarBodyInsure5000" name="rdCarBodyInsure" value="5000" />
                                    5千
                                    <input type="radio" id="rdCarBodyInsure10000" name="rdCarBodyInsure" value="10000" />
                                    1万
                                    <input type="radio" id="rdCarBodyInsure20000" name="rdCarBodyInsure" value="20000" />
                                    2万</td>
                                <td><input type="text" value="0" id="txtCarBodyInsurance" />
                                    元</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="4"><span style="font-size:16px;">全款购车共需花费：<span style="color:#ee7810; font-size:18px;" id="spanTotalBottom" >0 </span>元 </span><span style="font-size:12px;">( <span style="color:#ee7810;">此结果仅供参考，实际应缴费以当地为准。</span>)</span></td>
                            </tr>
                        </table>
                        <p style="text-align:center; height:30px; line-height:30px; background-color:#f1f4f6; margin-top:10px;"><a href="javascript:window.print();">打印本页</a></p>
                    </div>
                </div>
            </div>

            <div class="i-tabs-content<? if ($mid) { ?> i-tabs-content-active<? } ?>">
                <div class="tabs-news-module"> <div class="tabs-news-module">
                        <p><span style="font-weight:bold;font-size:14px;">选择车型：</span>
                            <select id="fctbox2" onchange="javascript:series_select($('#brbox2'), this.value);">
                                <option value="">品牌</option>
                                <? if (!$bid) { ?><script>brand_select($('#fctbox1'));</script><? } else { ?><script>brand_select($('#fctbox1'), <?=$bid?>);</script><? } ?>
                            </select>
                            <select id="brbox2" onchange="javascript:model_select($('#model_id2'), this.value);" <? if (!$sid) { ?>disabled="disabled"<? } ?>>
                                    <option value="">车系</option>
                                <? if ($bid&&$sid) { ?><script> series_selected($('#brbox2'), <?=$bid?>, <?=$sid?>)</script><? } ?>
                            </select>
                            <select style="margin-right:15px; " id="model_id2" <? if (!$mid) { ?>disabled="disabled"<? } ?>>
                                    <option value="">车型</option>
                                <? if ($sid&&$mid) { ?> <script> model_selected($('#model_id2'), <?=$sid?>, <?=$mid?>)</script><? } ?>
                            </select>
                            <span style="font-weight:bold; font-size:14px;">购车价格：</span>
                            <input type="text" value="0" id="txtCarPrice2" />
                            元<span style="color:#797979;">（可自行填入或修改）</span></p>
                        <p style="margin-top:15px;"><img src="images/qkgc_bg.gif" /></p>
                        <div class="content_qkgc">
                            <p style="height:40px; line-height:40px;"><span style="font-size:16px;">按贷款购车计算，您需要首付<span style="color:#ee7810; font-size:18px;" id="spanPrepaymentTop"> 0 </span>元，月供<span style="color:#ee7810; font-size:18px;" id="spanMonthPayTop"> 0 </span>元(<span style="color:#ee7810; font-size:18px;" id="spanMonthsTop"> 0 </span>个月)</span></p>
                            <p><span style="font-size:16px;">总计花费：<span style="color:#ee7810; font-size:18px;" id="spanRepaymentTop">0 </span>元 </span><span style="font-size:16px;">比全款购车多花费<span style="color:#ee7810; font-size:18px;" id="spanLoanMoreCostTop">0 </span>元 </span><span style="font-size:12px;">( <span style="color:#ee7810;">此结果仅供参考，实际应缴费以当地为准。</span>)</span></p>
                            <table width="923" border="0" style="border:solid 1px #d7dfe4; margin-top:10px;">
                                <tr style=" background-color:#dee4e9; font-size:14px; color:#3e4248; ">
                                    <th width="150" scope="col">项目明细</th>
                                    <th width="268" scope="col" style="text-align:center;"> 选项 </th>
                                    <th width="202" scope="col">金额 </th>
                                    <th width="303" scope="col"> 计算公式及备注 </th>
                                </tr>

                                <tr>
                                    <td>首付款</td>
                                    <td>首付额度：<br /><input type="radio" checked="checked" id="rdPrepayment30" name="rdPrepayment" value="0.3" />
                                        30%
                                        <input type="radio" id="rdPrepayment40" name="rdPrepayment" value="0.4" />
                                        40%
                                        <input type="radio" id="rdPrepayment50" name="rdPrepayment" value="0.5" />
                                        50%<br />
                                        <input type="radio" id="rdPrepaymentCustom" name="rdPrepayment" value="0" />
                                        自定义</td>
                                    <td><input type="text" value="0" id="txtPrepayment" />
                                        元</td>
                                    <td>购置税＝购车款／（1＋17％）× 购置税率(10%)</td>
                                </tr>
                                <tr>
                                    <td>贷款额</td>
                                    <td>&nbsp;</td>
                                    <td><input type="text" value="0" id="txtBankLoan" />
                                        元</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>月付款</td>
                                    <td>还款年限：<br /><input type="radio"  id="rdLoanYears1" name="rdLoanYears" value="1" />
                                        1年
                                        <input type="radio" id="rdLoanYears2" name="rdLoanYears" value="2" />
                                        2年<input type="radio" checked="checked" id="rdLoanYears3" name="rdLoanYears" value="3" />
                                        3年<input type="radio" id="rdLoanYears4" name="rdLoanYears" value="4" />
                                        4年<input type="radio" id="rdLoanYears5" name="rdLoanYears" value="5" />
                                        5年</td>
                                    <td><input type="text" value="0" id="txtMonthPay" />
                                        元</td>
                                    <td>银行贷款月利率：1年期0.5025%，2年期0.5025%，
                                        3年期0.5025%，5年期0.51%</td>
                                </tr>
                                <tr>
                                    <td>首期付款额</td>
                                    <td></td>
                                    <td><input type="text" value="0" id="txtTotalPrepayment" />
                                        元</td>
                                    <td>首期付款总额=首付款+必要花费+商业保险</td>
                                </tr>
                                <tr style="background-color:#f1f4f6; font-size:14px; color:#ee7810; height:30px;">
                                    <td colspan="4">必要花费</td>
                                </tr>
                                <tr>
                                    <td class="gzs">购置税<a href="#" onmousemove="over()" onmouseout="out()"><img src="images/qkgc_-.jpg" /></a>
                                        <div id="div" style="visibility:hidden;"><div class="cont"><div class="gzs_jtbg"><img src="images/qkgc_gzs.jpg" /></div>车辆购置税是对在我国境内购置规定车辆的单位和个人征收的一种税，它由车辆购置附加费演变而来。现行车辆购置税法的基本规范，是从2001年1月1日起实施的《中华人民共和国车辆购置税暂行条例》。车辆购置税的纳税人为购置（包括购买、进口、自产、受赠、获奖或以其他方式取得并自用）应税车辆的单位和个人，征税范围为汽车、摩托车、电车、挂车、农用运输车，税率为10%，应纳税额的计算公式为：应纳税额=计税价格×税率。（2009年1月20日至12月31日，对1.6升及以下排量乘用车减按5%征收车辆购置税。自2010年1月1日至12月31日，对1.6升及以下排量乘用车减按7.5%征收车辆购置税。）</div></div></td>

                                    <td>&nbsp;</td>
                                    <td><input type="text" value="0" id="txtPurchaseTax2" />
                                        元</td>
                                    <td>购置税＝购车款／（1＋17％）× 购置税率(10%)</td>
                                </tr>
                                <tr>
                                    <td>上牌费用</td>
                                    <td>&nbsp;</td>
                                    <td><input type="text" value="0" id="txtLicenseTax2" />
                                        元</td>
                                    <td>通常商家提供的一条龙服务收费约500元，个人办理
                                        约373元，其中工商验证、出库150元、移动证30元、
                                        环保卡3元、拓号费40元、行驶证相片20元、托盘费
                                        130元</td>
                                </tr>
                                <tr>
                                    <td>车船使用税<img src="images/qkgc_-.jpg" /></td>
                                    <td>
                                        <ul>
                                            <li>
                                                <label><input type="radio" <? if ($st==1) { ?>checked="checked"<? } ?>  value="1" name="rdDisplacement2" id="rdDisplacement102">1.0L（含）以下</label></li>
                                            <li>
                                                <label><input type="radio" <? if ($st==1.6) { ?>checked="checked"<? } ?> value="1.6" name="rdDisplacement2" id="rdDisplacement162">1.0-1.6L（含）</label></li>
                                            <li>
                                                <label><input type="radio" <? if ($st==2) { ?>checked="checked"<? } ?>  value="2" name="rdDisplacement2" id="rdDisplacement202">1.6-2.0L(含）</label></li>
                                            <li>
                                                <label><input type="radio"  <? if ($st==2.5) { ?>checked="checked"<? } ?> value="2.5" name="rdDisplacement2" id="rdDisplacement252">2.0-2.5L（含）</label></li>
                                            <li>
                                                <label><input type="radio" <? if ($st==3) { ?>checked="checked"<? } ?> value="3" name="rdDisplacement2" id="rdDisplacement302">2.5-3.0L（含）</label></li>
                                            <li>
                                                <label><input type="radio"  <? if ($st==4) { ?>checked="checked"<? } ?> value="4" name="rdDisplacement2" id="rdDisplacement402">3.0-4.0L（含）</label></li>
                                            <li>
                                                <label><input type="radio" <? if ($st==4.1) { ?>checked="checked"<? } ?> value="4.1" name="rdDisplacement2" id="rdDisplacement40s2">4.0以上</label></li>
                                        </ul>
                                    </td>
                                    <td><input type="text" value="0" id="txtUsageTax2" />
                                        元</td>
                                    <td>
                                        <div>各省不统一，以北京为例(单位/年)。</div>
                                        <ul>
                                            <li>1.0L(含)以下300元；</li>
                                            <li>1.0-1.6L(含)420元；</li>
                                            <li>1.6-2.0L(含)480元；</li>
                                            <li>2.0-2.5L(含)900元；</li>
                                            <li>2.5-3.0L(含)1920元；</li>
                                            <li>3.0-4.0L(含)3480元；</li>
                                            <li>4.0L以上5280元；不足一年按当年剩余月算。</li>
                                        </ul>
                                    </td>
                                </tr>
                                <tr>
                                    <td>交强险<img src="images/qkgc_-.jpg" /></td>
                                    <td><input type="radio" checked="checked" id="rdSeatCount62" name="rdSeatCount2" value="6" />
                                        家用6座及以下
                                        <input type="radio" id="rdSeatCount72" name="rdSeatCount2" value="7" />
                                        家用6座以上</td>
                                    <td><input type="text" value="0" id="txtTrafficInsurance2" />
                                        元</td>
                                    <td>家用6座及以下950元/年，家用6座以上1100元/年</td>
                                </tr>
                                <tr style="background-color:#f1f4f6; font-size:14px; color:#ee7810; height:30px;">
                                    <td colspan="4">商业保险</td>
                                </tr>
                                <tr>
                                    <td class="cgbx">常规保险合计</td>
                                    <td></td>
                                    <td><input type="text" value="0" id="spanCommerceTotal2" />
                                        元</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td><input type="checkbox" checked="checked" value="" id="cbThirdCheck2" />
                                        第三者责任险<img src="images/qkgc_-.jpg" /></td>
                                    <td>赔付额度：<br />
                                        <input type="radio" checked="checked" id="rdThirdInsureClaim52" name="rdThirdInsureClaim2" value="50000" />
                                        5万
                                        <input type="radio" id="rdThirdInsureClaim102" name="rdThirdInsureClaim2" value="100000" />
                                        10万
                                        <input type="radio" id="rdThirdInsureClaim202" name="rdThirdInsureClaim2" value="200000" />
                                        20万
                                        <input type="radio" id="rdThirdInsureClaim502" name="rdThirdInsureClaim2" value="500000" />
                                        50万<br />
                                        <input type="radio" id="rdThirdInsureClaim1002" name="rdThirdInsureClaim2" value="1000000" />
                                        100万</td>
                                    <td><input type="text" value="0" id="txtThirdInsurance2" />
                                        元</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td><input type="checkbox" id="cbDamageCheck2" />
                                        车辆损失险<img src="images/qkgc_-.jpg" /></td>
                                    <td></td>
                                    <td><input type="text" value="0" id="txtDamageInsurance2" />
                                        元</td>
                                    <td>基础保费+裸车价格×1.0880%</td>
                                </tr>
                                <tr>
                                    <td><input type="checkbox" id="cbStolenCheck2" disabled="disabled" />
                                        全车盗抢险<img src="images/qkgc_-.jpg" /></td>
                                    <td></td>
                                    <td><input type="text" value="0" id="txtStolenInsurance2" />
                                        元</td>
                                    <td>基础保费+裸车价格×费率</td>
                                </tr>
                                <tr>
                                    <td><input type="checkbox" id="cbGlassCheck2" />
                                        玻璃单独破碎险<img src="images/qkgc_-.jpg" /></td>
                                    <td><input type="radio" checked="checked" id="rdImport12" name="rdImport2" value="1" />
                                        进口
                                        <input type="radio" id="rdImport02" name="rdImport2" value="0" />
                                        国产</td>
                                    <td><input type="text" value="0" id="txtGlassInsurance2" />
                                        元</td>
                                    <td>进口新车购置价×0.25%，国产新车购置价×0.15%</td>
                                </tr>
                                <tr>
                                    <td><input type="checkbox" id="cbCombustCheck2" />
                                        自燃损失险<img src="images/qkgc_-.jpg" /></td>
                                    <td></td>
                                    <td><input type="text" value="0" id="txtCombustInsurance2" />
                                        元</td>
                                    <td>新车购置价×0.15%</td>
                                </tr>
                                <tr>
                                    <td><input type="checkbox" id="cbNoDeductibleCheck2" disabled="disabled" />
                                        不计免赔特约险<img src="images/qkgc_-.jpg" /></td>
                                    <td></td>
                                    <td><input type="text" value="0" id="txtNoDeductibleInsurance2" />
                                        元</td>
                                    <td>(车辆损失险+第三者责任险)×20%</td>
                                </tr>
                                <tr>
                                    <td><input type="checkbox" id="cbNoLiabilityCheck2" />
                                        无过责任险<img src="images/qkgc_-.jpg" /></td>
                                    <td></td>
                                    <td><input type="text" value="0" id="txtNoLiabilityInsurance2" />
                                        元</td>
                                    <td>第三者责任险保险费×20%</td>
                                </tr>
                                <tr>
                                    <td><input type="checkbox" id="cbPassengerCheck2" />
                                        车上人员责任险<img src="images/qkgc_-.jpg" /></td>
                                    <td></td>
                                    <td><input type="text" value="0" id="txtPassengerInsurance2" />
                                        元</td>
                                    <td>每人保费50元，可根据车辆的实际座位数填写</td>
                                </tr>
                                <tr>
                                    <td><input type="checkbox" id="cbCarBodyCheck2" disabled="disabled" />
                                        车身划痕险<img src="images/qkgc_-.jpg" /></td>
                                    <td>赔付额度：<br />
                                        <input type="radio" checked="checked" id="rdCarBodyInsure20002" name="rdCarBodyInsure2" value="2000" />
                                        2千
                                        <input type="radio" id="rdCarBodyInsure50002" name="rdCarBodyInsure2" value="5000" />
                                        5千
                                        <input type="radio" id="rdCarBodyInsure100002" name="rdCarBodyInsure2" value="10000" />
                                        1万
                                        <input type="radio" id="rdCarBodyInsure200002" name="rdCarBodyInsure2" value="20000" />
                                        2万</td>
                                    <td><input type="text" value="0" id="txtCarBodyInsurance2" />
                                        元</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td colspan="4"><p style="height:40px; line-height:40px;"><span style="font-size:16px;">按贷款购车计算，您需要首付<span style="color:#ee7810; font-size:18px;" id="spanPrepaymentBottom"> 0 </span>元，月供<span style="color:#ee7810; font-size:18px;" id="spanMonthPayBottom"> 0 </span>元(<span style="color:#ee7810; font-size:18px;" id="spanMonthsBottom"> 0 </span>个月)</span></p>
                                        <p><span style="font-size:16px;">总计花费：<span style="color:#ee7810; font-size:18px;" id="spanRepaymentBottom">0 </span>元 </span><span style="font-size:16px;">比全款购车多花费<span style="color:#ee7810; font-size:18px;" id="spanLoanMoreCostBottom">0 </span>元 </span><span style="font-size:12px;">( <span style="color:#ee7810;">此结果仅供参考，实际应缴费以当地为准。</span>)</span></p></td>
                                </tr>
                            </table>
                            <p style="text-align:center; height:30px; line-height:30px; background-color:#f1f4f6; margin-top:10px;"><a href="javascript:window.print();" >打印本页</a></p>
                        </div>
                    </div> </div>
            </div>

            <div class="i-tabs-content">
                <div class="tabs-news-module"> <div class="tabs-news-module">
                        <p><span style="font-weight:bold;font-size:14px;">选择车型：</span>
                            <select id="fctbox3" onchange="javascript:series_select($('#brbox3'), this.value);">
                                <option value="">品牌</option>
                                <? if (!$bid) { ?><script>brand_select($('#fctbox1'));</script><? } else { ?><script>brand_select($('#fctbox1'), <?=$bid?>);</script><? } ?>
                            </select>
                            <select id="brbox3" onchange="javascript:model_select($('#model_id3'), this.value);" <? if (!$sid) { ?>disabled="disabled"<? } ?>>
                                    <option value="">车系</option>
                                <? if ($bid&&$sid) { ?><script> series_selected($('#brbox3'), <?=$bid?>, <?=$sid?>)</script><? } ?>
                            </select>
                            <select style="margin-right:15px;" id="model_id3" <? if (!$mid) { ?>disabled="disabled"<? } ?>>
                                    <option value="">车型</option>
                                <? if ($sid&&$mid) { ?> <script> model_selected($('#model_id3'), <?=$sid?>, <?=$mid?>)</script><? } ?>
                            </select>
                            <span style="font-weight:bold; font-size:14px;">购车价格：</span>
                            <input type="text" value="0" id="txtCarPrice3" />
                            元<span style="color:#797979;">（可自行填入或修改）</span></p>
                        <p style="margin-top:15px;"><img src="images/qkgc_bg.gif" /></p>
                        <div class="content_qkgc">
                            <p><span style="font-size:16px;">购车保险费用共计 <span style="color:#ee7810; font-size:18px;" id="spanTotalInsuranceTop3" >0 </span>元 </span><span style="font-size:12px;">( <span style="color:#ee7810;">此结果仅供参考，实际应缴费以当地为准。</span>)</span></p>
                            <table width="923" border="0" style="border:solid 1px #d7dfe4; margin-top:10px;">
                                <tr style=" background-color:#dee4e9; font-size:14px; ">
                                    <th width="150" scope="col">项目明细</th>
                                    <th width="268" scope="col" style="text-align:center;"> 选项 </th>
                                    <th width="202" scope="col">金额 </th>
                                    <th width="303" scope="col"> 计算公式及备注 </th>
                                </tr>
                                <tr style="background-color:#f1f4f6; font-size:14px; color:#ee7810; height:30px;">
                                    <td colspan="4">强制保险</td>
                                </tr>

                                <tr>
                                    <td>交强险<img src="images/qkgc_-.jpg" /></td>
                                    <td><input type="radio" checked="checked" id="rdSeatCount63" name="rdSeatCount3" value="6" />
                                        家用6座及以下
                                        <input type="radio" id="rdSeatCount73" name="rdSeatCount3" value="7" />
                                        家用6座以上</td>
                                    <td><input type="text" value="0" id="txtTrafficInsurance3" />
                                        元</td>
                                    <td>家用6座及以下950元/年，家用6座以上1100元/年</td>
                                </tr>
                                <tr style="background-color:#f1f4f6; font-size:14px; color:#ee7810; height:30px;">
                                    <td colspan="4">商业保险</td>
                                </tr>
                                <tr>
                                    <td class="cgbx">常规保险合计</td>
                                    <td></td>
                                    <td><input type="text" value="0" id="spanCommerceTotal3" />
                                        元</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td><input type="checkbox" checked="checked" value="" id="cbThirdCheck3" />
                                        第三者责任险<img src="images/qkgc_-.jpg" /></td>
                                    <td>赔付额度：<br />
                                        <input type="radio" checked="checked" id="rdThirdInsureClaim53" name="rdThirdInsureClaim3" value="50000" />
                                        5万
                                        <input type="radio" id="rdThirdInsureClaim103" name="rdThirdInsureClaim3" value="100000" />
                                        10万
                                        <input type="radio" id="rdThirdInsureClaim203" name="rdThirdInsureClaim3" value="200000" />
                                        20万
                                        <input type="radio" id="rdThirdInsureClaim503" name="rdThirdInsureClaim3" value="500000" />
                                        50万<br />
                                        <input type="radio" id="rdThirdInsureClaim1003" name="rdThirdInsureClaim3" value="1000000" />
                                        100万</td>
                                    <td><input type="text" value="0" id="txtThirdInsurance3" />
                                        元</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td><input type="checkbox" id="cbDamageCheck3" />
                                        车辆损失险<img src="images/qkgc_-.jpg" /></td>
                                    <td></td>
                                    <td><input type="text" value="0" id="txtDamageInsurance3" />
                                        元</td>
                                    <td>基础保费+裸车价格×1.0880%</td>
                                </tr>
                                <tr>
                                    <td><input type="checkbox" id="cbStolenCheck3" disabled="disabled" />
                                        全车盗抢险<img src="images/qkgc_-.jpg" /></td>
                                    <td></td>
                                    <td><input type="text" value="0" id="txtStolenInsurance3" />
                                        元</td>
                                    <td>基础保费+裸车价格×费率</td>
                                </tr>
                                <tr>
                                    <td><input type="checkbox" id="cbGlassCheck3" />
                                        玻璃单独破碎险<img src="images/qkgc_-.jpg" /></td>
                                    <td><input type="radio" checked="checked" id="rdImport13" name="rdImport3" value="1" />
                                        进口
                                        <input type="radio" id="rdImport03" name="rdImport3" value="0" />
                                        国产</td>
                                    <td><input type="text" value="0" id="txtGlassInsurance3" />
                                        元</td>
                                    <td>进口新车购置价×0.25%，国产新车购置价×0.15%</td>
                                </tr>
                                <tr>
                                    <td><input type="checkbox" id="cbCombustCheck3" />
                                        自燃损失险<img src="images/qkgc_-.jpg" /></td>
                                    <td></td>
                                    <td><input type="text" value="0" id="txtCombustInsurance3" />
                                        元</td>
                                    <td>新车购置价×0.15%</td>
                                </tr>
                                <tr>
                                    <td><input type="checkbox" id="cbNoDeductibleCheck3" disabled="disabled" />
                                        不计免赔特约险<img src="images/qkgc_-.jpg" /></td>
                                    <td></td>
                                    <td><input type="text" value="0" id="txtNoDeductibleInsurance3" />
                                        元</td>
                                    <td>(车辆损失险+第三者责任险)×20%</td>
                                </tr>
                                <tr>
                                    <td><input type="checkbox" id="cbNoLiabilityCheck3" />
                                        无过责任险<img src="images/qkgc_-.jpg" /></td>
                                    <td></td>
                                    <td><input type="text" value="0" id="txtNoLiabilityInsurance3" />
                                        元</td>
                                    <td>第三者责任险保险费×20%</td>
                                </tr>
                                <tr>
                                    <td><input type="checkbox" id="cbPassengerCheck3" />
                                        车上人员责任险<img src="images/qkgc_-.jpg" /></td>
                                    <td></td>
                                    <td><input type="text" value="0" id="txtPassengerInsurance3" />
                                        元</td>
                                    <td>每人保费50元，可根据车辆的实际座位数填写</td>
                                </tr>
                                <tr>
                                    <td><input type="checkbox" id="cbCarBodyCheck3" disabled="disabled" />
                                        车身划痕险<img src="images/qkgc_-.jpg" /></td>
                                    <td>赔付额度：<br />
                                        <input type="radio" checked="checked" id="rdCarBodyInsure20003" name="rdCarBodyInsure3" value="2000" />
                                        2千
                                        <input type="radio" id="rdCarBodyInsure50003" name="rdCarBodyInsure3" value="5000" />
                                        5千
                                        <input type="radio" id="rdCarBodyInsure100003" name="rdCarBodyInsure3" value="10000" />
                                        1万
                                        <input type="radio" id="rdCarBodyInsure200003" name="rdCarBodyInsure3" value="20000" />
                                        2万</td>
                                    <td><input type="text" value="0" id="txtCarBodyInsurance3" />
                                        元</td>
                                    <td></td>
                                </tr>

                            </table>
                            <p style="text-align:center; height:30px; line-height:30px; background-color:#f1f4f6; margin-top:10px;"><a href="javascript:window.print();">打印本页</a></p>
                        </div>
                    </div> </div>
            </div>



        </div>
    </div>
</div>
<div class="clear"></div>
<!--foot-->
<? include $this->gettpl('index_footer');?>
<script type="text/javascript">
            $(document).ready(function () {
        var i = <?=$model_price?>;
        var st = <?=$st?>;
        $("#txtCarPrice").val(i);
        $("#txtCarPrice2").val(i);
        $("#txtCarPrice3").val(i);
        $("input[name='rdDisplacement2'][value='" + st + "']").attr("checked", true);
        $("input[name='rdDisplacement'][value='" + st + "']").attr("checked", true);
        boss();

    });
    function print() {
        window.print();
    }

    function boss() {
        var carCostParseFloat = function (val) {
            if (val == undefined) {
                return 0;
            }
            if (isNaN(val)) {
                return 0;
            }
            if (val == "") {
                return 0;
            }
            var result = parseFloat(val);
            if (result < 0) {
                result = 0;
            }
            return result;
        };

        var validate = function (val) {
            if (val == undefined) {
                return true;
            }
            if (val == "") {
                return true;
            }
            var reg = new RegExp("^[0-9]+(.)?([0-9]{0,8})?$");
            if (!reg.test(val)) {
                //alert("请输入数字");
                return false;
            }
            return true;
        };
        var formatNum = function (num, n) {//参数说明：num 要格式化的数字 n 保留小数位
            num = String(parseFloat(num).toFixed(n));
            var re = /(-?\d+)(\d{3,3})/;
            while (re.test(num)) {
                num = num.replace(re, "$1,$2");
            }
            return num;
        }
        if ($('#nv1').attr("class") == "i-tabs-item i-tabs-item-active" || parseInt($('#txtCarPrice').val() > 0)) {
            //必要花费
            var txtCarPrice = jQuery("#txtCarPrice"),
                    spanTotalTop = jQuery("#spanTotalTop"),
                    txtPurchaseTax = jQuery("#txtPurchaseTax"),
                    txtLicenseTax = jQuery("#txtLicenseTax"),
                    rdDisplacement10 = jQuery("#rdDisplacement10"),
                    rdDisplacement16 = jQuery("#rdDisplacement16"),
                    rdDisplacement20 = jQuery("#rdDisplacement20"),
                    rdDisplacement25 = jQuery("#rdDisplacement25"),
                    rdDisplacement30 = jQuery("#rdDisplacement30"),
                    rdDisplacement40 = jQuery("#rdDisplacement40"),
                    rdDisplacement40s = jQuery("#rdDisplacement40s"),
                    txtUsageTax = jQuery("#txtUsageTax"),
                    rdSeatCount6 = jQuery("#rdSeatCount6"),
                    rdSeatCount6s = jQuery("#rdSeatCount7"),
                    txtTrafficInsurance = jQuery("#txtTrafficInsurance"),
                    //商业保险
                    spanCommerceTotal = jQuery("#spanCommerceTotal"),
                    rdThirdInsureClaim5 = jQuery("#rdThirdInsureClaim5"),
                    rdThirdInsureClaim10 = jQuery("#rdThirdInsureClaim10"),
                    rdThirdInsureClaim20 = jQuery("#rdThirdInsureClaim20"),
                    rdThirdInsureClaim50 = jQuery("#rdThirdInsureClaim50"),
                    rdThirdInsureClaim100 = jQuery("#rdThirdInsureClaim100"),
                    txtThirdInsurance = jQuery("#txtThirdInsurance"),
                    txtDamageInsurance = jQuery("#txtDamageInsurance"),
                    txtStolenInsurance = jQuery("#txtStolenInsurance"),
                    rdImport0 = jQuery("#rdImport0"),
                    rdImport1 = jQuery("#rdImport1"),
                    txtGlassInsurance = jQuery("#txtGlassInsurance"),
                    txtCombustInsurance = jQuery("#txtCombustInsurance"),
                    txtNoDeductibleInsurance = jQuery("#txtNoDeductibleInsurance"),
                    txtNoLiabilityInsurance = jQuery("#txtNoLiabilityInsurance"),
                    txtPassengerInsurance = jQuery("#txtPassengerInsurance"),
                    rdCarBodyInsure2000 = jQuery("#rdCarBodyInsure2000"),
                    rdCarBodyInsure5000 = jQuery("#rdCarBodyInsure5000"),
                    rdCarBodyInsure10000 = jQuery("#rdCarBodyInsure10000"),
                    rdCarBodyInsure20000 = jQuery("#rdCarBodyInsure20000"),
                    txtCarBodyInsurance = jQuery("#txtCarBodyInsurance"),
                    spanTotalBottom = jQuery("#spanTotalBottom");
            (function () {
                var carCostManager = (function () {
                    var _carCostManager = {};
                    var carCostParam = {
                        reSetCustom: true,
                        //购车价格
                        carPrice: 0,
                        //自定义上牌费用
                        licenseTaxCustom: 0,
                        //自定义车船使用税
                        usageTaxCustom: 0,
                        //排量
                        displacement: 1.6,
                        //座位数
                        seatCount: 5,
                        //是否进口车
                        isImport: 0,
                        //第三者责任险 赔付额度
                        thirdInsureClaim: 50000,
                        //自定义车上人员责任险
                        passengerInsureCustom: 0,
                        //车身划痕险 赔付额度
                        carBodyInsureClaim: 2000,
                        //是否勾选
                        CommInsureCheck: {
                            //第三者责任险
                            thirdCheck: true,
                            //车辆损失险
                            damageCheck: false,
                            //全车盗抢险
                            stolenCheck: false,
                            //玻璃单独破碎险
                            glassCheck: false,
                            //自燃损失险
                            combustCheck: false,
                            //不计免赔特约险
                            noDeductibleCheck: false,
                            //无过责任险
                            noLiabilityCheck: false,
                            //车上人员责任险
                            passengerCheck: false,
                            //车身划痕险
                            carBodyCheck: false
                        }
                    };
                    var getCarCostParam = function () {
//		            if (txtPassengerInsurance.val() === "") {
//		                txtPassengerInsurance.val("50");
//		            }
                        carCostParam.carPrice = carCostParseFloat(carCostParseFloat(txtCarPrice.val()));
                        carCostParam.licenseTaxCustom = carCostParseFloat(txtLicenseTax.val());
                        carCostParam.usageTaxCustom = carCostParseFloat(txtUsageTax.val());
                        carCostParam.displacement = carCostParseFloat(jQuery("input[name='rdDisplacement']:checked").val());

                        carCostParam.seatCount = carCostParseFloat(jQuery("input[name='rdSeatCount']:checked").val());

                        carCostParam.isImport = carCostParseFloat(jQuery("input[name='rdImport']:checked").val());

                        carCostParam.thirdInsureClaim = carCostParseFloat(jQuery("input[name='rdThirdInsureClaim']:checked").val());
                        carCostParam.passengerInsureCustom = carCostParseFloat(parseFloat(txtPassengerInsurance.val()));
                        carCostParam.carBodyInsureClaim = carCostParseFloat(jQuery("input[name='rdCarBodyInsure']:checked").val());


                        carCostParam.CommInsureCheck.thirdCheck = jQuery("#cbThirdCheck").attr("checked");
                        carCostParam.CommInsureCheck.damageCheck = jQuery("#cbDamageCheck").attr("checked");
                        carCostParam.CommInsureCheck.stolenCheck = jQuery("#cbStolenCheck").attr("checked");
                        carCostParam.CommInsureCheck.glassCheck = jQuery("#cbGlassCheck").attr("checked");
                        carCostParam.CommInsureCheck.combustCheck = jQuery("#cbCombustCheck").attr("checked");
                        carCostParam.CommInsureCheck.noDeductibleCheck = jQuery("#cbNoDeductibleCheck").attr("checked");
                        carCostParam.CommInsureCheck.noLiabilityCheck = jQuery("#cbNoLiabilityCheck").attr("checked");
                        carCostParam.CommInsureCheck.passengerCheck = jQuery("#cbPassengerCheck").attr("checked");
                        carCostParam.CommInsureCheck.carBodyCheck = jQuery("#cbCarBodyCheck").attr("checked");
                        return carCostParam;
                    };
                    _carCostManager.reSetCustom = function () {
                        carCostParam.reSetCustom = true;
                    }

                    _carCostManager.refreshFee = function () {
                        carCostParam = getCarCostParam();
                        var carPurchaseCost = new CarPurchaseCost();
                        carCostParam.carPrice = parseFloat(carCostParseFloat(txtCarPrice.val()));

                        if (carCostParam.carPrice <= 0) {
                            _carCostManager.reset();

                            return;
                        }

                        var carPurchaseFee = carPurchaseCost.getCarPurchaseCost(carCostParam);

                        spanTotalTop.html(formatNum(carPurchaseFee.getTotal(), 0));
                        txtPurchaseTax.val(carPurchaseFee.carPurchaseTax.purchaseTax == 0 ? "0" : carPurchaseFee.carPurchaseTax.purchaseTax);
                        txtLicenseTax.val(carPurchaseFee.carPurchaseTax.licenseTax == 0 ? "0" : carPurchaseFee.carPurchaseTax.licenseTax);
                        txtUsageTax.val(carPurchaseFee.carPurchaseTax.usageTax == 0 ? "0" : carPurchaseFee.carPurchaseTax.usageTax);
                        txtTrafficInsurance.val(carPurchaseFee.carInsurance.trafficInsurance == 0 ? "0" : carPurchaseFee.carInsurance.trafficInsurance);
                        spanCommerceTotal.val(carPurchaseFee.getCommerceInsurance() == 0 ? "0" : formatNum(carPurchaseFee.getCommerceInsurance(), 0));
                        txtThirdInsurance.val(carPurchaseFee.carInsurance.thirdInsurance == 0 ? "0" : carPurchaseFee.carInsurance.thirdInsurance);
                        txtDamageInsurance.val(carPurchaseFee.carInsurance.damageInsurance == 0 ? "0" : carPurchaseFee.carInsurance.damageInsurance);
                        txtStolenInsurance.val(carPurchaseFee.carInsurance.stolenInsurance == 0 ? "0" : carPurchaseFee.carInsurance.stolenInsurance);
                        txtGlassInsurance.val(carPurchaseFee.carInsurance.glassInsurance == 0 ? "0" : carPurchaseFee.carInsurance.glassInsurance);
                        txtCombustInsurance.val(carPurchaseFee.carInsurance.combustInsurance == 0 ? "0" : carPurchaseFee.carInsurance.combustInsurance);
                        txtNoDeductibleInsurance.val(carPurchaseFee.carInsurance.noDeductibleInsurance == 0 ? "0" : carPurchaseFee.carInsurance.noDeductibleInsurance);
                        txtNoLiabilityInsurance.val(carPurchaseFee.carInsurance.noLiabilityInsurance == 0 ? "0" : carPurchaseFee.carInsurance.noLiabilityInsurance);
                        txtPassengerInsurance.val(carPurchaseFee.carInsurance.passengerInsurance == 0 ? "0" : carPurchaseFee.carInsurance.passengerInsurance);
                        txtCarBodyInsurance.val(carPurchaseFee.carInsurance.carBodyInsurance == 0 ? "0" : carPurchaseFee.carInsurance.carBodyInsurance);
                        spanTotalBottom.html(carPurchaseFee.getTotal() == 0 ? "0" : formatNum(carPurchaseFee.getTotal(), 0));
                        carCostParam.reSetCustom = false;
                    }
                    _carCostManager.reset = function () {
                        spanTotalTop.html("0");
                        txtPurchaseTax.val("0");
                        txtLicenseTax.val("0");
                        txtUsageTax.val("0");
                        txtTrafficInsurance.val("0");
                        spanCommerceTotal.html("0");
                        txtThirdInsurance.val("0");
                        txtDamageInsurance.val("0");
                        txtStolenInsurance.val("0");
                        txtGlassInsurance.val("0");
                        txtCombustInsurance.val("0");
                        txtNoDeductibleInsurance.val("0");
                        txtNoLiabilityInsurance.val("0");
                        txtPassengerInsurance.val("0");
                        txtCarBodyInsurance.val("0");
                        spanTotalBottom.html("0");

                    };

                    return _carCostManager;
                })();
                jQuery.each(["#txtCarPrice", "#txtLicenseTax", "#txtUsageTax", "#txtPassengerInsurance"], function () {
                    jQuery(this.toString()).bind("change", function (event) {
                        if (!validate(jQuery(this).val())) {
                            jQuery(this).val('');
                            return;
                        }
                        carCostManager.refreshFee();
                    });
                });

                jQuery.each(["#txtCarPrice", "#txtLicenseTax", "#txtUsageTax", "#txtPassengerInsurance"], function () {
                    jQuery(this.toString()).bind("keyup", function (event) {
                        if (!validate(jQuery(this).val())) {
                            alert("请输入数字");
                            jQuery(this).val('');
                            return;
                        }
                        carCostManager.refreshFee();
                    });
                });
                jQuery("input[name='rdDisplacement']").bind("change", function (event) {
                    var carPurchaseCost = new CarPurchaseCost();
                    var usageTax = carPurchaseCost.getUsageTax(carCostParseFloat(jQuery(this).val()));
                    txtUsageTax.val(usageTax);
                    carCostManager.refreshFee();
                });


                jQuery.each(["input[name='rdSeatCount']", "input[name='rdThirdInsureClaim']", "input[name='rdImport']", "input[name='rdCarBodyInsure']"], function () {
                    jQuery(this.toString()).bind("change", function (event) {
                        carCostManager.refreshFee();
                    });
                });

                jQuery.each(["#cbStolenCheck", "#cbGlassCheck", "#cbCombustCheck", "#cbNoDeductibleCheck", "#cbNoLiabilityCheck", "#cbPassengerCheck", "#cbCarBodyCheck"], function () {
                    jQuery(this.toString()).bind("change", function (event) {
                        carCostManager.refreshFee();
                    });
                });

                jQuery("#cbThirdCheck").bind("change", function (event) {
                    if (!jQuery(this).attr("checked")) {
                        jQuery("#cbNoLiabilityCheck").attr("checked", false);
                        jQuery("#cbNoDeductibleCheck").attr("disabled", true);
                        jQuery("#cbNoLiabilityCheck").attr("disabled", true);
                    } else {
                        jQuery("#cbNoLiabilityCheck").attr("disabled", false);
                    }

                    if (jQuery(this).attr("checked") && jQuery("#cbDamageCheck").attr("checked")) {
                        jQuery("#cbNoDeductibleCheck").attr("disabled", false);
                    } else {
                        jQuery("#cbNoDeductibleCheck").attr("checked", false);
                        jQuery("#cbNoDeductibleCheck").attr("disabled", true);
                    }

                    carCostManager.refreshFee();
                });
                jQuery("#cbDamageCheck").bind("change", function (event) {
                    if (!jQuery(this).attr("checked")) {
                        jQuery("#cbStolenCheck").attr("checked", false);
                        jQuery("#cbCarBodyCheck").attr("checked", false);
                        jQuery("#cbStolenCheck").attr("disabled", true);
                        jQuery("#cbCarBodyCheck").attr("disabled", true);
                    } else {
                        jQuery("#cbStolenCheck").attr("disabled", false);
                        jQuery("#cbCarBodyCheck").attr("disabled", false);
                    }

                    if (jQuery(this).attr("checked") && jQuery("#cbThirdCheck").attr("checked")) {
                        jQuery("#cbNoDeductibleCheck").attr("disabled", false);
                    } else {
                        jQuery("#cbNoDeductibleCheck").attr("checked", false);
                        jQuery("#cbNoDeductibleCheck").attr("disabled", true);
                    }
                    carCostManager.refreshFee();
                });
                <? if ($mid) { ?>
                $(document).ready(function () {
                    carCostManager.reSetCustom();
                            var specid = <?=$mid?>;
                    var modurl = "?action=GetModelPrice&mid=" + specid;
                    $.getJSON(modurl, function (ret) {
                        var p1 = /\d+[.]\d<?=2?>/g;
                        var p2 = /\d+[.]\d<?=1?>/g;
                        var p3 = /\d/g;
                        model_price = Number(ret['model_price']);
                        if (p3.test(ret['model_price'])) {
                            model_price *= 10000;
                        }
                        if (p2.test(ret['model_price'])) {
                            model_price *= 1000;
                        }
                        if (p1.test(ret['model_price'])) {
                            model_price *= 100;
                        }
                        model_price = Math.round(model_price);
                        jQuery('#txtCarPrice').val(model_price);
                        carCostManager.refreshFee();
                    });
                });
                <? } ?>                        
                        jQuery("#model_id").bind("change", function () {
                    carCostManager.reSetCustom();
                    var specid = jQuery("#model_id").val();
                    var modurl = "?action=GetModelPrice&mid=" + specid;
                    $.getJSON(modurl, function (ret) {
                        var p1 = /\d+[.]\d<?=2?>/g;
                        var p2 = /\d+[.]\d<?=1?>/g;
                        var p3 = /\d/g;
                        model_price = Number(ret['model_price']);
                        if (p3.test(ret['model_price'])) {
                            model_price *= 10000;
                        }
                        if (p2.test(ret['model_price'])) {
                            model_price *= 1000;
                        }
                        if (p1.test(ret['model_price'])) {
                            model_price *= 100;
                        }
                        model_price = Math.round(model_price);
                        var st = ret['st'];

                        $("input[name='rdDisplacement'][value='" + st + "']").attr("checked", true);
                        jQuery('#txtCarPrice').val(model_price);
                        carCostManager.refreshFee();
                    });
                });
            })();
        }
        if ($('#nv2').attr("class") == "i-tabs-item i-tabs-item-active" || parseInt($('#txtCarPrice2').val() > 0)) {
            var txtCarPrice = jQuery("#txtCarPrice2"),
                    //贷款项
                    spanPrepaymentTop = jQuery("#spanPrepaymentTop"),
                    spanMonthPayTop = jQuery("#spanMonthPayTop"),
                    spanMonthsTop = jQuery("#spanMonthsTop"),
                    spanRepaymentTop = jQuery("#spanRepaymentTop"),
                    spanLoanMoreCostTop = jQuery("#spanLoanMoreCostTop"),
                    rdPrepayment30 = jQuery("#rdPrepayment30"),
                    rdPrepayment40 = jQuery("#rdPrepayment40"),
                    rdPrepayment50 = jQuery("#rdPrepayment50"),
                    rdPrepayment60 = jQuery("#rdPrepayment60"),
                    rdPrepaymentCustom = jQuery("#rdPrepaymentCustom"),
                    txtPrepayment = jQuery("#txtPrepayment"),
                    txtBankLoan = jQuery("#txtBankLoan"),
                    rdLoanYears1 = jQuery("#rdLoanYears1"),
                    rdLoanYears2 = jQuery("#rdLoanYears2"),
                    rdLoanYears3 = jQuery("#rdLoanYears3"),
                    rdLoanYears4 = jQuery("#rdLoanYears4"),
                    rdLoanYears5 = jQuery("#rdLoanYears5"),
                    txtMonthPay = jQuery("#txtMonthPay"),
                    txtTotalPrepayment = jQuery("#txtTotalPrepayment"),
                    //必要花费
                    txtPurchaseTax = jQuery("#txtPurchaseTax2"),
                    txtLicenseTax = jQuery("#txtLicenseTax2"),
                    rdDisplacement10 = jQuery("#rdDisplacement102"),
                    rdDisplacement16 = jQuery("#rdDisplacement162"),
                    rdDisplacement20 = jQuery("#rdDisplacement202"),
                    rdDisplacement25 = jQuery("#rdDisplacement252"),
                    rdDisplacement30 = jQuery("#rdDisplacement302"),
                    rdDisplacement40 = jQuery("#rdDisplacement402"),
                    rdDisplacement40s = jQuery("#rdDisplacement40s2"),
                    txtUsageTax = jQuery("#txtUsageTax2"),
                    rdSeatCount6 = jQuery("#rdSeatCount62"),
                    rdSeatCount6s = jQuery("#rdSeatCount72"),
                    txtTrafficInsurance = jQuery("#txtTrafficInsurance2"),
                    spanCommerceTotal = jQuery("#spanCommerceTotal2"),
                    rdThirdInsureClaim5 = jQuery("#rdThirdInsureClaim52"),
                    rdThirdInsureClaim10 = jQuery("#rdThirdInsureClaim102"),
                    rdThirdInsureClaim20 = jQuery("#rdThirdInsureClaim202"),
                    rdThirdInsureClaim50 = jQuery("#rdThirdInsureClaim502"),
                    rdThirdInsureClaim100 = jQuery("#rdThirdInsureClaim1002"),
                    txtThirdInsurance = jQuery("#txtThirdInsurance2"),
                    txtDamageInsurance = jQuery("#txtDamageInsurance2"),
                    txtStolenInsurance = jQuery("#txtStolenInsurance2"),
                    rdImport0 = jQuery("#rdImport02"),
                    rdImport1 = jQuery("#rdImport12"),
                    txtGlassInsurance = jQuery("#txtGlassInsurance2"),
                    txtCombustInsurance = jQuery("#txtCombustInsurance2"),
                    txtNoDeductibleInsurance = jQuery("#txtNoDeductibleInsurance2"),
                    txtNoLiabilityInsurance = jQuery("#txtNoLiabilityInsurance2"),
                    txtPassengerInsurance = jQuery("#txtPassengerInsurance2"),
                    rdCarBodyInsure2000 = jQuery("#rdCarBodyInsure20002"),
                    rdCarBodyInsure5000 = jQuery("#rdCarBodyInsure50002"),
                    rdCarBodyInsure10000 = jQuery("#rdCarBodyInsure100002"),
                    rdCarBodyInsure20000 = jQuery("#rdCarBodyInsure200002"),
                    txtCarBodyInsurance = jQuery("#txtCarBodyInsurance2"),
                    spanPrepaymentBottom = jQuery("#spanPrepaymentBottom"),
                    spanMonthPayBottom = jQuery("#spanMonthPayBottom"),
                    spanMonthsBottom = jQuery("#spanMonthsBottom"),
                    spanRepaymentBottom = jQuery("#spanRepaymentBottom"),
                    spanLoanMoreCostBottom = jQuery("#spanLoanMoreCostBottom");

            (function () {
                var carCostManager = (function () {
                    var _carCostManager = {};
                    var carCostParam = {
                        reSetCustom: true,
                        //购车价格
                        carPrice: 0,
                        //首付自定义
                        prepaymentCustom: 0,
                        //首付比例
                        prepaymentPercent: 0.1,
                        //还款年限
                        loanYears: 3,
                        //自定义上牌费用
                        licenseTaxCustom: 0,
                        //自定义车船使用税
                        usageTaxCustom: 0,
                        //排量
                        displacement: 1.6,
                        //座位数
                        seatCount: 5,
                        //是否进口车
                        isImport: 0,
                        //第三者责任险 赔付额度
                        thirdInsureClaim: 50000,
                        //自定义车上人员责任险
                        passengerInsureCustom: 0,
                        //车身划痕险 赔付额度
                        carBodyInsureClaim: 2000,
                        //是否勾选
                        CommInsureCheck: {
                            //第三者责任险
                            thirdCheck: true,
                            //车辆损失险
                            damageCheck: false,
                            //全车盗抢险
                            stolenCheck: false,
                            //玻璃单独破碎险
                            glassCheck: false,
                            //自燃损失险
                            combustCheck: false,
                            //不计免赔特约险
                            noDeductibleCheck: false,
                            //无过责任险
                            noLiabilityCheck: false,
                            //车上人员责任险
                            passengerCheck: false,
                            //车身划痕险
                            carBodyCheck: false
                        }
                    };



                    var getCarCostParam = function () {
//                    if (txtPassengerInsurance.val() === "") {
//                        txtPassengerInsurance.val("50");
//                    }

                        carCostParam.prepaymentPercent = carCostParseFloat(jQuery("input[name='rdPrepayment']:checked").val());
                        if (rdPrepaymentCustom.attr("checked")) {
                            carCostParam.prepaymentCustom = carCostParseFloat(txtPrepayment.val());
                        } else {
                            carCostParam.prepaymentCustom = 0;
                        }
                        carCostParam.loanYears = carCostParseFloat(jQuery("input[name='rdLoanYears']:checked").val());

                        carCostParam.carPrice = carCostParseFloat(txtCarPrice.val());

                        carCostParam.licenseTaxCustom = carCostParseFloat(txtLicenseTax.val());
                        carCostParam.usageTaxCustom = carCostParseFloat(txtUsageTax.val());
                        carCostParam.displacement = carCostParseFloat(jQuery("input[name='rdDisplacement2']:checked").val());

                        carCostParam.seatCount = carCostParseFloat(jQuery("input[name='rdSeatCount2']:checked").val());

                        carCostParam.isImport = carCostParseFloat(jQuery("input[name='rdImport2']:checked").val());

                        carCostParam.thirdInsureClaim = carCostParseFloat(jQuery("input[name='rdThirdInsureClaim2']:checked").val());

                        carCostParam.passengerInsureCustom = carCostParseFloat(parseFloat(txtPassengerInsurance.val()));
                        carCostParam.carBodyInsureClaim = carCostParseFloat(jQuery("input[name='rdCarBodyInsure2']:checked").val());


                        carCostParam.CommInsureCheck.thirdCheck = jQuery("#cbThirdCheck2").attr("checked");
                        carCostParam.CommInsureCheck.damageCheck = jQuery("#cbDamageCheck2").attr("checked");
                        carCostParam.CommInsureCheck.stolenCheck = jQuery("#cbStolenCheck2").attr("checked");
                        carCostParam.CommInsureCheck.glassCheck = jQuery("#cbGlassCheck2").attr("checked");
                        carCostParam.CommInsureCheck.combustCheck = jQuery("#cbCombustCheck2").attr("checked");
                        carCostParam.CommInsureCheck.noDeductibleCheck = jQuery("#cbNoDeductibleCheck2").attr("checked");
                        carCostParam.CommInsureCheck.noLiabilityCheck = jQuery("#cbNoLiabilityCheck2").attr("checked");
                        carCostParam.CommInsureCheck.passengerCheck = jQuery("#cbPassengerCheck2").attr("checked");
                        carCostParam.CommInsureCheck.carBodyCheck = jQuery("#cbCarBodyCheck2").attr("checked");
                        return carCostParam;

                    };

                    _carCostManager.reSetCustom = function () {
                        carCostParam.reSetCustom = true;
                    }

                    _carCostManager.refreshFee = function () {
                        carCostParam = getCarCostParam();
                        var carPurchaseCost = new CarPurchaseCost();
                        carCostParam.carPrice = parseFloat(carCostParseFloat(txtCarPrice.val()));

                        if (carCostParam.carPrice <= 0) {
                            _carCostManager.reset();
                            return;
                        }

                        var carPurchaseFee = carPurchaseCost.getCarPurchaseCost(carCostParam);
                        spanPrepaymentTop.html(carPurchaseFee.getTotalPrepayment() == 0 ? "0" : formatNum(carPurchaseFee.getTotalPrepayment(), 0));
                        spanMonthPayTop.html(carPurchaseFee.carLoanFee.monthPay == 0 ? "0" : formatNum(carPurchaseFee.carLoanFee.monthPay, 0));
                        spanMonthsTop.html(carPurchaseFee.carLoanFee.months == 0 ? "0" : carPurchaseFee.carLoanFee.months, 0);
                        spanRepaymentTop.html(carPurchaseFee.getTotalLoan() == 0 ? "0" : formatNum(carPurchaseFee.getTotalLoan(), 0));
                        spanLoanMoreCostTop.html(carPurchaseFee.getLoanMoreCost() == 0 ? "0" : formatNum(carPurchaseFee.getLoanMoreCost(), 0));

                        spanPrepaymentBottom.html(carPurchaseFee.getTotalPrepayment() == 0 ? "0" : formatNum(carPurchaseFee.getTotalPrepayment(), 0));
                        spanMonthPayBottom.html(carPurchaseFee.carLoanFee.monthPay == 0 ? "0" : formatNum(carPurchaseFee.carLoanFee.monthPay, 0));
                        spanMonthsBottom.html(carPurchaseFee.carLoanFee.months == 0 ? "0" : carPurchaseFee.carLoanFee.months);
                        spanRepaymentBottom.html(carPurchaseFee.getTotalLoan() == 0 ? "0" : formatNum(carPurchaseFee.getTotalLoan(), 0));
                        spanLoanMoreCostBottom.html(carPurchaseFee.getLoanMoreCost() == 0 ? "0" : formatNum(carPurchaseFee.getLoanMoreCost(), 0));

                        txtPrepayment.val(carPurchaseFee.carLoanFee.prepayment == 0 ? "0" : carPurchaseFee.carLoanFee.prepayment);
                        txtBankLoan.val(carPurchaseFee.carLoanFee.bankLoan == 0 ? "0" : carPurchaseFee.carLoanFee.bankLoan);
                        txtMonthPay.val(carPurchaseFee.carLoanFee.monthPay == 0 ? "0" : carPurchaseFee.carLoanFee.monthPay);
                        txtTotalPrepayment.val(carPurchaseFee.getTotalPrepayment() == 0 ? "0" : carPurchaseFee.getTotalPrepayment());

                        //spanTotalTop.html(carPurchaseFee.getTotal());
                        txtPurchaseTax.val(carPurchaseFee.carPurchaseTax.purchaseTax == 0 ? "0" : carPurchaseFee.carPurchaseTax.purchaseTax);
                        txtLicenseTax.val(carPurchaseFee.carPurchaseTax.licenseTax == 0 ? "0" : carPurchaseFee.carPurchaseTax.licenseTax);
                        txtUsageTax.val(carPurchaseFee.carPurchaseTax.usageTax == 0 ? "0" : carPurchaseFee.carPurchaseTax.usageTax);
                        txtTrafficInsurance.val(carPurchaseFee.carInsurance.trafficInsurance == 0 ? "0" : carPurchaseFee.carInsurance.trafficInsurance);
                        spanCommerceTotal.val(carPurchaseFee.getCommerceInsurance() == 0 ? "0" : formatNum(carPurchaseFee.getCommerceInsurance(), 0));
                        txtThirdInsurance.val(carPurchaseFee.carInsurance.thirdInsurance == 0 ? "0" : carPurchaseFee.carInsurance.thirdInsurance);
                        txtDamageInsurance.val(carPurchaseFee.carInsurance.damageInsurance == 0 ? "0" : carPurchaseFee.carInsurance.damageInsurance);
                        txtStolenInsurance.val(carPurchaseFee.carInsurance.stolenInsurance == 0 ? "0" : carPurchaseFee.carInsurance.stolenInsurance);
                        txtGlassInsurance.val(carPurchaseFee.carInsurance.glassInsurance == 0 ? "0" : carPurchaseFee.carInsurance.glassInsurance);
                        txtCombustInsurance.val(carPurchaseFee.carInsurance.combustInsurance == 0 ? "0" : carPurchaseFee.carInsurance.combustInsurance);
                        txtNoDeductibleInsurance.val(carPurchaseFee.carInsurance.noDeductibleInsurance == 0 ? "0" : carPurchaseFee.carInsurance.noDeductibleInsurance);
                        txtNoLiabilityInsurance.val(carPurchaseFee.carInsurance.noLiabilityInsurance == 0 ? "0" : carPurchaseFee.carInsurance.noLiabilityInsurance);
                        txtPassengerInsurance.val(carPurchaseFee.carInsurance.passengerInsurance == 0 ? "0" : carPurchaseFee.carInsurance.passengerInsurance);
                        txtCarBodyInsurance.val(carPurchaseFee.carInsurance.carBodyInsurance == 0 ? "0" : carPurchaseFee.carInsurance.carBodyInsurance);
                        carCostParam.reSetCustom = false;
                    };

                    _carCostManager.reset = function () {
                        //spanTotalTop.html("0");
                        rdPrepayment30.attr("checked", true);
                        txtPrepayment.val("0");
                        txtBankLoan.val("0");
                        txtMonthPay.val("0");
                        txtTotalPrepayment.val("0");
                        txtPurchaseTax.val("0");
                        txtLicenseTax.val("0");
                        txtUsageTax.val("0");
                        txtTrafficInsurance.val("0");
                        spanCommerceTotal.html("0");
                        txtThirdInsurance.val("0");
                        txtDamageInsurance.val("0");
                        txtStolenInsurance.val("0");
                        txtGlassInsurance.val("0");
                        txtCombustInsurance.val("0");
                        txtNoDeductibleInsurance.val("0");
                        txtNoLiabilityInsurance.val("0");
                        txtPassengerInsurance.val("0");
                        txtCarBodyInsurance.val("0");
                        spanPrepaymentBottom.html("0");
                        spanMonthPayBottom.html("0");
                        spanMonthsBottom.html("0");
                        spanRepaymentBottom.html("0");
                        spanLoanMoreCostBottom.html("0");
                        ;
                    };

                    return _carCostManager;
                })();


                jQuery.each(["#rdPrepayment30", "#rdPrepayment40", "#rdPrepayment50", "#rdPrepayment60"], function () {
                    jQuery(this.toString()).bind("change", function (event) {
                        txtPrepayment.attr("disabled", true);
                        txtPrepayment.attr("class", "input2");
                        carCostManager.refreshFee();
                    });
                });

                jQuery.each(["#rdPrepaymentCustom"], function () {
                    jQuery(this.toString()).bind("change", function (event) {
                        txtPrepayment.attr("disabled", false);
                        txtPrepayment.attr("class", "input3");
                        carCostManager.refreshFee();
                    });
                });

                jQuery.each(["input[name='rdLoanYears']"], function () {
                    jQuery(this.toString()).bind("change", function (event) {
                        carCostManager.refreshFee();
                    });
                });

                jQuery.each(["#txtCarPrice2"], function () {
                    jQuery(this.toString()).bind("change", function (event) {
                        ;
                        if (!validate(jQuery(this).val())) {

                            carCostManager.reset();

                            return;
                        }

                        carCostManager.refreshFee();
                        ;
                    });
                });

                jQuery.each(["#txtPrepayment", "#txtLicenseTax", "#txtUsageTax", "#txtPassengerInsurance"], function () {
                    jQuery(this.toString()).bind("change", function (event) {

                        if (!validate(jQuery(this).val())) {
                            return;
                        }

                        carCostManager.refreshFee();
                    });
                });

                jQuery.each(["#txtCarPrice2", "#txtPrepayment", "#txtLicenseTax", "#txtUsageTax", "#txtPassengerInsurance"], function () {
                    jQuery(this.toString()).bind("keyup", function (event) {

                        if (!validate(jQuery(this).val())) {
                            alert("请输入数字");
                            jQuery(this).val('');
                            return;
                        }

                        carCostManager.refreshFee();
                    });
                });

                jQuery("input[name='rdDisplacement2']").bind("change", function (event) {
                    var carPurchaseCost = new CarPurchaseCost();
                    var usageTax = carPurchaseCost.getUsageTax(carCostParseFloat(jQuery(this).val()));
                    txtUsageTax.val(usageTax);
                    carCostManager.refreshFee();
                });


                jQuery.each(["input[name='rdSeatCount2']", "input[name='rdThirdInsureClaim2']", "input[name='rdImport2']", "input[name='rdCarBodyInsure2']"], function () {
                    jQuery(this.toString()).bind("change", function (event) {
                        carCostManager.refreshFee();
                    });
                });

                jQuery.each(["#cbStolenCheck2", "#cbGlassCheck2", "#cbCombustCheck2", "#cbNoDeductibleCheck2", "#cbNoLiabilityCheck2", "#cbPassengerCheck2", "#cbCarBodyCheck2"], function () {
                    jQuery(this.toString()).bind("change", function (event) {
                        carCostManager.refreshFee();
                    });
                });
                <? if ($mid) { ?>
                $(document).ready(function () {
                    carCostManager.reSetCustom();
                            var specid = <?=$mid?>;
                    var modurl = "?action=GetModelPrice&mid=" + specid;
                    $.getJSON(modurl, function (ret) {
                        var p1 = /\d+[.]\d<?=2?>/g;
                        var p2 = /\d+[.]\d<?=1?>/g;
                        var p3 = /\d/g;
                        model_price = Number(ret['model_price']);
                        if (p3.test(ret['model_price'])) {
                            model_price *= 10000;
                        }
                        if (p2.test(ret['model_price'])) {
                            model_price *= 1000;
                        }
                        if (p1.test(ret['model_price'])) {
                            model_price *= 100;
                        }
                        model_price = Math.round(model_price);
                        jQuery('#txtCarPrice').val(model_price);
                        carCostManager.refreshFee();
                    });
                });
                <? } ?>
                        jQuery("#cbThirdCheck2").bind("change", function (event) {
                    if (!jQuery(this).attr("checked")) {
                        jQuery("#cbNoLiabilityCheck2").attr("checked", false);
                        jQuery("#cbNoDeductibleCheck2").attr("disabled", true);
                        jQuery("#cbNoLiabilityCheck2").attr("disabled", true);
                    } else {
                        jQuery("#cbNoLiabilityCheck2").attr("disabled", false);
                    }

                    if (jQuery(this).attr("checked") && jQuery("#cbDamageCheck2").attr("checked")) {
                        jQuery("#cbNoDeductibleCheck2").attr("disabled", false);
                    } else {
                        jQuery("#cbNoDeductibleCheck2").attr("checked", false);
                        jQuery("#cbNoDeductibleCheck2").attr("disabled", true);
                    }

                    carCostManager.refreshFee();
                });

                jQuery("#cbDamageCheck2").bind("change", function (event) {
                    if (!jQuery(this).attr("checked")) {
                        jQuery("#cbStolenCheck2").attr("checked", false);
                        jQuery("#cbCarBodyCheck2").attr("checked", false);
                        jQuery("#cbStolenCheck2").attr("disabled", true);
                        jQuery("#cbCarBodyCheck2").attr("disabled", true);
                    } else {
                        jQuery("#cbStolenCheck2").attr("disabled", false);
                        jQuery("#cbCarBodyCheck2").attr("disabled", false);
                    }

                    if (jQuery(this).attr("checked") && jQuery("#cbThirdCheck2").attr("checked")) {
                        jQuery("#cbNoDeductibleCheck2").attr("disabled", false);
                    } else {
                        jQuery("#cbNoDeductibleCheck2").attr("checked", false);
                        jQuery("#cbNoDeductibleCheck2").attr("disabled", true);
                    }
                    carCostManager.refreshFee();
                });
                jQuery("#model_id2").bind("change", function () {
                    carCostManager.reSetCustom();
                    var specid = jQuery("#model_id2").val();
                    var modurl = "?action=GetModelPrice&mid=" + specid;
                    $.getJSON(modurl, function (ret) {
                        var p1 = /\d+[.]\d<?=2?>/g;
                        var p2 = /\d+[.]\d<?=1?>/g;
                        var p3 = /\d/g;
                        model_price = Number(ret['model_price']);
                        if (p3.test(ret['model_price'])) {
                            model_price *= 10000;
                        }
                        if (p2.test(ret['model_price'])) {
                            model_price *= 1000;
                        }
                        if (p1.test(ret['model_price'])) {
                            model_price *= 100;
                        }
                        model_price = Math.round(model_price);
                        var st = ret['st'];
                        // alert(st);
                        $("input[name='rdDisplacement2'][value='" + st + "']").attr("checked", "checked");

                        jQuery('#txtCarPrice2').val(model_price);
                        carCostManager.refreshFee();
                    });
                });
            })();
        }
        if ($('#nv3').attr("class") == "i-tabs-item i-tabs-item-active") {
            var txtCarPrice = jQuery("#txtCarPrice3"),
                    spanTotalInsuranceTop = jQuery("#spanTotalInsuranceTop3"),
                    txtTrafficInsurance = jQuery("#txtTrafficInsurance3"),
                    spanCommerceTotal = jQuery("#spanCommerceTotal3"),
                    rdThirdInsureClaim5 = jQuery("#rdThirdInsureClaim53"),
                    rdThirdInsureClaim10 = jQuery("#rdThirdInsureClaim103"),
                    rdThirdInsureClaim20 = jQuery("#rdThirdInsureClaim203"),
                    rdThirdInsureClaim50 = jQuery("#rdThirdInsureClaim503"),
                    rdThirdInsureClaim100 = jQuery("#rdThirdInsureClaim1003"),
                    txtThirdInsurance = jQuery("#txtThirdInsurance3"),
                    txtDamageInsurance = jQuery("#txtDamageInsurance3"),
                    txtStolenInsurance = jQuery("#txtStolenInsurance3"),
                    rdImport0 = jQuery("#rdImport03"),
                    rdImport1 = jQuery("#rdImport13"),
                    txtGlassInsurance = jQuery("#txtGlassInsurance3"),
                    txtCombustInsurance = jQuery("#txtCombustInsurance3"),
                    txtNoDeductibleInsurance = jQuery("#txtNoDeductibleInsurance3"),
                    txtNoLiabilityInsurance = jQuery("#txtNoLiabilityInsurance3"),
                    txtPassengerInsurance = jQuery("#txtPassengerInsurance3"),
                    rdCarBodyInsure2000 = jQuery("#rdCarBodyInsure20003"),
                    rdCarBodyInsure5000 = jQuery("#rdCarBodyInsure50003"),
                    rdCarBodyInsure10000 = jQuery("#rdCarBodyInsure100003"),
                    rdCarBodyInsure20000 = jQuery("#rdCarBodyInsure200003"),
                    txtCarBodyInsurance = jQuery("#txtCarBodyInsurance3");

            (function () {
                var carCostManager = (function () {
                    var _carCostManager = {};
                    var carCostParam = {
                        reSetCustom: true,
                        //购车价格
                        carPrice: 0,
                        //自定义上牌费用
                        licenseTaxCustom: 0,
                        //自定义车船使用税
                        usageTaxCustom: 0,
                        //排量
                        displacement: 1.6,
                        //座位数
                        seatCount: 5,
                        //是否进口车
                        isImport: 0,
                        //第三者责任险 赔付额度
                        thirdInsureClaim: 50000,
                        //自定义车上人员责任险
                        passengerInsureCustom: 0,
                        //车身划痕险 赔付额度
                        carBodyInsureClaim: 2000,
                        //是否勾选
                        CommInsureCheck: {
                            //第三者责任险
                            thirdCheck: true,
                            //车辆损失险
                            damageCheck: false,
                            //全车盗抢险
                            stolenCheck: false,
                            //玻璃单独破碎险
                            glassCheck: false,
                            //自燃损失险
                            combustCheck: false,
                            //不计免赔特约险
                            noDeductibleCheck: false,
                            //无过责任险
                            noLiabilityCheck: false,
                            //车上人员责任险
                            passengerCheck: false,
                            //车身划痕险
                            carBodyCheck: false
                        }
                    };

                    var getCarCostParam = function () {
//		            if (txtPassengerInsurance.val() === "") {
//		                txtPassengerInsurance.val("50");
//		            }
                        carCostParam.carPrice = carCostParseFloat(carCostParseFloat(txtCarPrice.val()));
                        carCostParam.seatCount = carCostParseFloat(jQuery("input[name='rdSeatCount3']:checked").val());

                        carCostParam.isImport = carCostParseFloat(jQuery("input[name='rdImport3']:checked").val());

                        carCostParam.thirdInsureClaim = carCostParseFloat(jQuery("input[name='rdThirdInsureClaim3']:checked").val());
                        carCostParam.passengerInsureCustom = carCostParseFloat(parseFloat(txtPassengerInsurance.val()));
                        carCostParam.carBodyInsureClaim = carCostParseFloat(jQuery("input[name='rdCarBodyInsure3']:checked").val());


                        carCostParam.CommInsureCheck.thirdCheck = jQuery("#cbThirdCheck3").attr("checked");
                        carCostParam.CommInsureCheck.damageCheck = jQuery("#cbDamageCheck3").attr("checked");
                        carCostParam.CommInsureCheck.stolenCheck = jQuery("#cbStolenCheck3").attr("checked");
                        carCostParam.CommInsureCheck.glassCheck = jQuery("#cbGlassCheck3").attr("checked");
                        carCostParam.CommInsureCheck.combustCheck = jQuery("#cbCombustCheck3").attr("checked");
                        carCostParam.CommInsureCheck.noDeductibleCheck = jQuery("#cbNoDeductibleCheck3").attr("checked");
                        carCostParam.CommInsureCheck.noLiabilityCheck = jQuery("#cbNoLiabilityCheck3").attr("checked");
                        carCostParam.CommInsureCheck.passengerCheck = jQuery("#cbPassengerCheck3").attr("checked");
                        carCostParam.CommInsureCheck.carBodyCheck = jQuery("#cbCarBodyCheck3").attr("checked");
                        return carCostParam;

                    };

                    _carCostManager.reSetCustom = function () {
                        carCostParam.reSetCustom = true;
                    }

                    _carCostManager.refreshFee = function () {
                        carCostParam = getCarCostParam();
                        var carPurchaseCost = new CarPurchaseCost();
                        carCostParam.carPrice = parseFloat(carCostParseFloat(txtCarPrice.val()));

                        if (carCostParam.carPrice <= 0) {
                            _carCostManager.reset();

                            return;
                        }
                        var carPurchaseFee = carPurchaseCost.getCarPurchaseCost(carCostParam);
                        spanTotalInsuranceTop.html(carPurchaseFee.getTotalInsurance() == 0 ? "0" : formatNum(carPurchaseFee.getTotalInsurance(), 0));
                        txtTrafficInsurance.val(carPurchaseFee.carInsurance.trafficInsurance == 0 ? "" : carPurchaseFee.carInsurance.trafficInsurance);
                        spanCommerceTotal.val(carPurchaseFee.getCommerceInsurance() == 0 ? "0" : formatNum(carPurchaseFee.getCommerceInsurance(), 0));
                        txtThirdInsurance.val(carPurchaseFee.carInsurance.thirdInsurance == 0 ? "0" : carPurchaseFee.carInsurance.thirdInsurance);
                        txtDamageInsurance.val(carPurchaseFee.carInsurance.damageInsurance == 0 ? "0" : carPurchaseFee.carInsurance.damageInsurance);
                        txtStolenInsurance.val(carPurchaseFee.carInsurance.stolenInsurance == 0 ? "0" : carPurchaseFee.carInsurance.stolenInsurance);
                        txtGlassInsurance.val(carPurchaseFee.carInsurance.glassInsurance == 0 ? "0" : carPurchaseFee.carInsurance.glassInsurance);
                        txtCombustInsurance.val(carPurchaseFee.carInsurance.combustInsurance == 0 ? "0" : carPurchaseFee.carInsurance.combustInsurance);
                        txtNoDeductibleInsurance.val(carPurchaseFee.carInsurance.noDeductibleInsurance == 0 ? "0" : carPurchaseFee.carInsurance.noDeductibleInsurance);
                        txtNoLiabilityInsurance.val(carPurchaseFee.carInsurance.noLiabilityInsurance == 0 ? "0" : carPurchaseFee.carInsurance.noLiabilityInsurance);
                        txtPassengerInsurance.val(carPurchaseFee.carInsurance.passengerInsurance == 0 ? "0" : carPurchaseFee.carInsurance.passengerInsurance);
                        txtCarBodyInsurance.val(carPurchaseFee.carInsurance.carBodyInsurance == 0 ? "0" : carPurchaseFee.carInsurance.carBodyInsurance);
                        carCostParam.reSetCustom = false;

                    }

                    _carCostManager.reset = function () {
                        txtTrafficInsurance.val("0");
                        spanCommerceTotal.html("0");
                        txtThirdInsurance.val("0");
                        txtDamageInsurance.val("0");
                        txtStolenInsurance.val("0");
                        txtGlassInsurance.val("0");
                        txtCombustInsurance.val("0");
                        txtNoDeductibleInsurance.val("0");
                        txtNoLiabilityInsurance.val("0");
                        txtPassengerInsurance.val("0");
                        txtCarBodyInsurance.val("0");
                    };

                    return _carCostManager;
                })();

                jQuery.each(["#txtCarPrice3", "#txtPassengerInsurance3"], function () {
                    jQuery(this.toString()).bind("change", function (event) {
                        if (!validate(jQuery(this).val())) {
                            jQuery(this).val('');
                            return;
                        }
                        carCostManager.refreshFee();
                    });
                });

                jQuery.each(["#txtCarPrice3"], function () {
                    jQuery(this.toString()).bind("keyup", function (event) {
                        if (!validate(jQuery(this).val())) {
                            alert("请输入数字");
                            jQuery(this).val('');
                            carCostManager.reset();
                            return;
                        }
                        carCostManager.reSetCustom();
                        carCostManager.refreshFee();
                        ;

                    });
                });

                jQuery.each(["#txtPassengerInsurance3"], function () {
                    jQuery(this.toString()).bind("keyup", function (event) {

                        if (!validate(jQuery(this).val())) {
                            alert("请输入数字");
                            jQuery(this).val('');
                            return;
                        }
                        carCostManager.refreshFee();
                    });
                });

                jQuery.each(["input[name='rdSeatCount3']", "input[name='rdThirdInsureClaim3']", "input[name='rdImport3']", "input[name='rdCarBodyInsure3']"], function () {
                    jQuery(this.toString()).bind("change", function (event) {
                        carCostManager.refreshFee();
                    });
                });

                jQuery.each(["#cbStolenCheck3", "#cbGlassCheck3", "#cbCombustCheck3", "#cbNoDeductibleCheck3", "#cbNoLiabilityCheck3", "#cbPassengerCheck3", "#cbCarBodyCheck3"], function () {
                    jQuery(this.toString()).bind("change", function (event) {
                        carCostManager.refreshFee();
                    });
                });
                <? if ($mid) { ?>
                $(document).ready(function () {
                    carCostManager.reSetCustom();
                            var specid = <?=$mid?>;
                    var modurl = "?action=GetModelPrice&mid=" + specid;
                    $.getJSON(modurl, function (ret) {
                        var p1 = /\d+[.]\d<?=2?>/g;
                        var p2 = /\d+[.]\d<?=1?>/g;
                        var p3 = /\d/g;
                        model_price = Number(ret['model_price']);
                        if (p3.test(ret['model_price'])) {
                            model_price *= 10000;
                        }
                        if (p2.test(ret['model_price'])) {
                            model_price *= 1000;
                        }
                        if (p1.test(ret['model_price'])) {
                            model_price *= 100;
                        }
                        model_price = Math.round(model_price);
                        jQuery('#txtCarPrice').val(model_price);
                        carCostManager.refreshFee();
                    });
                });
                <? } ?>
                        jQuery("#cbThirdCheck3").bind("change", function (event) {
                    if (!jQuery(this).attr("checked")) {
                        jQuery("#cbNoLiabilityCheck3").attr("checked", false);
                        jQuery("#cbNoDeductibleCheck3").attr("disabled", true);
                        jQuery("#cbNoLiabilityCheck3").attr("disabled", true);
                    } else {
                        jQuery("#cbNoLiabilityCheck3").attr("disabled", false);
                    }

                    if (jQuery(this).attr("checked") && jQuery("#cbDamageCheck3").attr("checked")) {
                        jQuery("#cbNoDeductibleCheck3").attr("disabled", false);
                    } else {
                        jQuery("#cbNoDeductibleCheck3").attr("checked", false);
                        jQuery("#cbNoDeductibleCheck3").attr("disabled", true);
                    }

                    carCostManager.refreshFee();
                });

                jQuery("#cbDamageCheck3").bind("change", function (event) {
                    if (!jQuery(this).attr("checked")) {
                        jQuery("#cbStolenCheck3").attr("checked", false);
                        jQuery("#cbCarBodyCheck3").attr("checked", false);
                        jQuery("#cbStolenCheck3").attr("disabled", true);
                        jQuery("#cbCarBodyCheck3").attr("disabled", true);
                    } else {
                        jQuery("#cbStolenCheck3").attr("disabled", false);
                        jQuery("#cbCarBodyCheck3").attr("disabled", false);
                    }

                    if (jQuery(this).attr("checked") && jQuery("#cbThirdCheck3").attr("checked")) {
                        jQuery("#cbNoDeductibleCheck3").attr("disabled", false);
                    } else {
                        jQuery("#cbNoDeductibleCheck3").attr("checked", false);
                        jQuery("#cbNoDeductibleCheck3").attr("disabled", true);
                    }
                    carCostManager.refreshFee();
                });
                jQuery("#model_id3").bind("change", function () {
                    carCostManager.reSetCustom();
                    var specid = jQuery("#model_id3").val();
                    var modurl = "?action=GetModelPrice&mid=" + specid;
                    $.getJSON(modurl, function (ret) {
                        var p1 = /\d+[.]\d<?=2?>/g;
                        var p2 = /\d+[.]\d<?=1?>/g;
                        var p3 = /\d/g;
                        model_price = Number(ret['model_price']);
                        if (p3.test(ret['model_price'])) {
                            model_price *= 10000;
                        }
                        if (p2.test(ret['model_price'])) {
                            model_price *= 1000;
                        }
                        if (p1.test(ret['model_price'])) {
                            model_price *= 100;
                        }
                        model_price = Math.round(model_price);
                        jQuery('#txtCarPrice3').val(model_price);
                        carCostManager.refreshFee();
                    });
                });
            })();
        }
    }

</script>
<script type="text/javascript">
    function over() {
        div.style.visibility = '';
    }
    function out() {
        div.style.visibility = 'hidden';
    }
</script>