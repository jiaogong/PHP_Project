<?php
  /**
  * 参数分类组
  * $Id: param.php 4377 2013-12-19 08:43:20Z yinliuhui $
  * @author David.Shaw
  */

  class param extends model{

      var $paramattr = array(
            array("title"=>"动力传动系统",
                  "attr"=>array(
                            array("name"=>"车体结构","pid"=>"55"),
                            array("name"=>"驱动方式","pid"=>"51"),
                            array("name"=>"发动机型号","pid"=>"25"),
                            array("name"=>"发动机形式","pid"=>"1"),
                            array("name"=>"排量(L)","pid"=>"27"),
                            array("name"=>"汽缸容积(mL)","pid"=>"26"),
                            array("name"=>"工作方式","pid"=>"28"),
                            array("name"=>"燃料形式","pid"=>"41"),
                            array("name"=>"燃油标号","pid"=>"42"),
                            array("name"=>"缸数","pid"=>"30"),
                            array("name"=>"汽缸排列形式","pid"=>"29"),
                            array("name"=>"每缸气门数","pid"=>"31"),
                            array("name"=>"供油方式","pid"=>"43"),
                            array("name"=>"最大马力(Ps)","pid"=>"36"),
                            array("name"=>"最大功率/转速","pid"=>"37-38"),
                            array("name"=>"比功率(kw/kg)","pid"=>"37-19"),
                            array("name"=>"最大扭矩/转速","pid"=>"39-185"),
                            array("name"=>"缸体材料","pid"=>"45"),
                            array("name"=>"缸盖材料","pid"=>"44"),
                            array("name"=>"发动机特有技术","pid"=>"40"),
                            array("name"=>"缸径/行程","pid"=>"34-35"),
//                            array("name"=>"冲程","pid"=>"35"),
//                            array("name"=>"缸径","pid"=>"34"),
                            array("name"=>"配气机构","pid"=>"33"),
                            array("name"=>"压缩比","pid"=>"32"),
                            array("name"=>"变速箱形式","pid"=>"2"),
                            array("name"=>"挡位个数","pid"=>"49"),
                            array("name"=>"变速箱类型","pid"=>"50"),
                            array("name"=>"变速箱简称","pid"=>"48"),
                            array("name"=>"综合工况(L)","pid"=>"10"),
                            array("name"=>"市区/市郊油耗","pid"=>"200-9"),
                            array("name"=>"实测100-0制动(m)","pid"=>"8"),
                            array("name"=>"实测0-100加速(s)","pid"=>"7"),
                            array("name"=>"官方0-100加速(s)","pid"=>"6"),
                            array("name"=>"最高车速(km/h)","pid"=>"5"),
                            array("name"=>"环保标准","pid"=>"47"),
                            array("name"=>"整车质保","pid"=>"11"),
                            )
                  ),
          array("title"=>"尺寸、重量及空间",
                  "attr"=>array(
//                            array("name"=>"车顶类型","pid"=>"209"),
//                            array("name"=>"重量分配-后","pid"=>"208"),
//                            array("name"=>"重量分配-前","pid"=>"207"),
                            array("name"=>"长×宽×高(mm)","pid"=>"3"),
                            array("name"=>"长度(mm)","pid"=>"12"),
                            array("name"=>"宽度(mm)","pid"=>"13"),
                            array("name"=>"高度(mm)","pid"=>"14"),
                            array("name"=>"轴距(mm)","pid"=>"15"),
                            array("name"=>"前轮距(mm)","pid"=>"16"),
                            array("name"=>"后轮距(mm)","pid"=>"17"),
                            array("name"=>"最小离地间隙(mm)","pid"=>"18"),
                            array("name"=>"整备质量(Kg)","pid"=>"19"),
                            array("name"=>"车门数(个)","pid"=>"21"),
                            array("name"=>"座位数(个)","pid"=>"22"),
                            array("name"=>"油箱容积(L)","pid"=>"23"),
                            array("name"=>"行李厢容积(L)","pid"=>"24"),
                            
                            )
                  ),
          array("title"=>"制动、转向、悬挂及轮胎",
                  "attr"=>array(
//                            array("name"=>"轮胎类型","pid"=>"214"),
//                            array("name"=>"转向半径（右）","pid"=>"213"),
//                            array("name"=>"转向半径（左）","pid"=>"212"),
//                            array("name"=>"转向器结构","pid"=>"211"),
                            array("name"=>"前制动器类型","pid"=>"56"),
                            array("name"=>"后制动器类型","pid"=>"57"),
                            array("name"=>"驻车制动类型","pid"=>"58"),
//                            array("name"=>"轮胎类型","pid"=>"214"),
                            array("name"=>"前轮胎规格","pid"=>"59"),
                            array("name"=>"后轮胎规格","pid"=>"60"),
                            array("name"=>"备胎规格","pid"=>"61"),
//                            array("name"=>"转向器结构","pid"=>"211"),
                            array("name"=>"助力类型","pid"=>"54"),
                            array("name"=>"前悬挂类型","pid"=>"52"),
                            array("name"=>"后悬挂类型","pid"=>"53"),
                            
                            )
                  ),
//          array("title"=>"外部尺寸及重量",
//                  "attr"=>array(
//                            array("name"=>"整备质量(Kg)","pid"=>"19"),
//                            array("name"=>"离地间隙(mm)","pid"=>"18"),
//                            array("name"=>"长度(mm)","pid"=>"12"),
//                            array("name"=>"宽度(mm)","pid"=>"13"),
//                            array("name"=>"高度(mm)","pid"=>"14"),
//                            array("name"=>"轴距(mm)","pid"=>"15"),
//                            array("name"=>"前轮距(mm)","pid"=>"16"),
//                            array("name"=>"后轮距(mm)","pid"=>"17"),
////                            array("name"=>"重量分配-前","pid"=>"207"),
////                            array("name"=>"重量分配-后","pid"=>"208"),
//                            array("name"=>"车门数","pid"=>"21"),
//                            array("name"=>"座位数","pid"=>"22")
////                            ,
////                            array("name"=>"车顶类型","pid"=>"209")
//                            )
//                  ),
          
          //后加的 配置参数
          array("title"=>"防盗配置",
                          "attr"=>array(
                                          array("name"=>"发动机电子防盗","pid"=>"72"),
                                          array("name"=>"车内中控锁","pid"=>"73"),
                                          array("name"=>"遥控钥匙","pid"=>"73"),
                                          array("name"=>"无钥匙启动系统","pid"=>"75")
                          )
          ),
          array("title"=>"主动安全",
                          "attr"=>array(
                                          array("name"=>"ABS防抱死","pid"=>"76"),
                                          array("name"=>"制动力分配(EBD/CBC等)","pid"=>"77"),
                                          array("name"=>"刹车辅助(EBA/BAS/BA等)","pid"=>"78"),
                                          array("name"=>"牵引力控制<br/>(ASR/TCS/TRC等)","pid"=>"79"),
                                          array("name"=>"车身稳定控制<br/>(ESP/DSC/VSC等)","pid"=>"80"),
                                          array("name"=>"胎压监测装置","pid"=>"69"),
                                          array("name"=>"零胎压继续行驶","pid"=>"70"),
                                          array("name"=>"安全带未系提示","pid"=>"71"),
                                          array("name"=>"电动吸合门","pid"=>"90")
                          )
          ),
          array("title"=>"被动安全",
                          "attr"=>array(
                                          array("name"=>"驾驶座安全气囊","pid"=>"62"),
                                          array("name"=>"副驾驶安全气囊","pid"=>"63"),
                                          array("name"=>"前排侧气囊","pid"=>"64"),
                                          array("name"=>"后排侧气囊","pid"=>"65"),
                                          array("name"=>"前排头部气囊(气帘)","pid"=>"66"),
                                          array("name"=>"后排头部气囊(气帘)","pid"=>"67"),
                                          array("name"=>"膝部气囊","pid"=>"68")
                          )
          ),
          array("title"=>"驾驶辅助",
                          "attr"=>array(
                                          array("name"=>"定速巡航","pid"=>"97"),
                                          array("name"=>"自适应巡航","pid"=>"183"),
                                          array("name"=>"自动驻车/上坡辅助","pid"=>"81"),
                                          array("name"=>"陡坡缓降","pid"=>"82"),
                                          array("name"=>"并线辅助","pid"=>"178"),
                                          array("name"=>"泊车辅助","pid"=>"98"),
                                          array("name"=>"自动泊车入位","pid"=>"177"),
                                          array("name"=>"倒车视频影像","pid"=>"99"),
                                          array("name"=>"行车电脑显示屏","pid"=>"100"),
                                          array("name"=>"夜视系统","pid"=>"181"),
                                          array("name"=>"中控液晶屏分屏显示","pid"=>"182"),
                                          array("name"=>"全景摄像头","pid"=>"184"),
                                          array("name"=>"HUD抬头数字显示","pid"=>"101"),
                                          array("name"=>"整体主动转向系统","pid"=>"85"),
                                          array("name"=>"可变转向比","pid"=>"217"),
                                          array("name"=>"可变悬挂","pid"=>"83"),
                                          array("name"=>"空气悬挂","pid"=>"84")
                          )
          ),
          array("title"=>"车身外饰",
                          "attr"=>array(
                                          array("name"=>"运动外观套件","pid"=>"88"),
                                          array("name"=>"铝合金轮毂","pid"=>"89")
                          )
          ),
          array("title"=>"车窗、后视镜及雨刷",
                          "attr"=>array(
                                          array("name"=>"前电动车窗","pid"=>"156"),
                                          array("name"=>"后电动车窗","pid"=>"157"),
                                          array("name"=>"防紫外线/隔热玻璃","pid"=>"159"),
                                          array("name"=>"车窗防夹手功能","pid"=>"158"),
                                          array("name"=>"电动天窗","pid"=>"86"),
                                          array("name"=>"全景天窗","pid"=>"87"),
                                          array("name"=>"感应雨刷","pid"=>"169"),
                                          array("name"=>"后雨刷","pid"=>"168"),
                                          array("name"=>"后排侧遮阳帘","pid"=>"166"),
                                          array("name"=>"后风挡遮阳帘","pid"=>"165"),
                                          array("name"=>"后视镜记忆","pid"=>"164"),
                                          array("name"=>"后视镜电动折叠","pid"=>"163"),
                                          array("name"=>"后视镜自动防炫目","pid"=>"162"),
                                          array("name"=>"后视镜加热","pid"=>"161"),
                                          array("name"=>"后视镜电动调节","pid"=>"160"),
                                          array("name"=>"遮阳板化妆镜","pid"=>"167"),
                                          array("name"=>"内后视镜自动防炫目","pid"=>"225"),
                                          array("name"=>"外后视镜自动防炫目","pid"=>"226")
                          )
          ),
          array("title"=>"灯光照明",
                          "attr"=>array(
                                          array("name"=>"氙气大灯","pid"=>"148"),
                                          array("name"=>"日间行车灯","pid"=>"149"),
                                          array("name"=>"自动头灯","pid"=>"150"),
                                          array("name"=>"转向头灯(辅助灯)","pid"=>"151"),
                                          array("name"=>"前雾灯","pid"=>"152"),
                                          array("name"=>"大灯高度可调","pid"=>"153"),
                                          array("name"=>"大灯清洗装置","pid"=>"154"),
                                          array("name"=>"车内氛围灯","pid"=>"155")
                          )
          ),
          array("title"=>"中控、方向盘及换挡",
                          "attr"=>array(
                                          array("name"=>"真皮方向盘","pid"=>"91"),
                                          array("name"=>"方向盘上下调节","pid"=>"92"),
                                          array("name"=>"方向盘前后调节","pid"=>"93"),
                                          array("name"=>"方向盘电动调节","pid"=>"94"),
                                          array("name"=>"多功能方向盘","pid"=>"95"),
                                          array("name"=>"方向盘换挡","pid"=>"96")
                          )
          ),
          array("title"=>"座椅及储物",
                          "attr"=>array(
                                          array("name"=>"真皮/仿皮座椅","pid"=>"102"),
                                          array("name"=>"运动座椅","pid"=>"103"),
                                          array("name"=>"座椅高低调节","pid"=>"104"),
                                          array("name"=>"腰部支撑调节","pid"=>"105"),
                                          array("name"=>"肩部支撑调节","pid"=>"106"),
                                          /*array("name"=>"座椅通风","pid"=>"114"),*/
                                          array("name"=>"前排座椅通风","pid"=>"221"),
                                          array("name"=>"后排座椅通风","pid"=>"222"),
                                          array("name"=>"前排座椅按摩","pid"=>"223"),
                                          array("name"=>"后排座椅按摩","pid"=>"224"),
                                          /*array("name"=>"座椅按摩","pid"=>"115"),*/
                                          array("name"=>"前排座椅加热","pid"=>"112"),
                                          array("name"=>"后排座椅加热","pid"=>"113"),
                                          array("name"=>"前排座椅电动调节","pid"=>"107"),
                                          array("name"=>"后排座椅电动调节","pid"=>"110"),
                                          array("name"=>"第二排靠背角度调节","pid"=>"108"),
                                          array("name"=>"第二排座椅移动","pid"=>"109"),
                                          array("name"=>"后排座椅整体放倒","pid"=>"116"),
                                          array("name"=>"后排座椅比例放倒","pid"=>"117"),
                                          array("name"=>"第三排座椅","pid"=>"118"),
                                          array("name"=>"前座中央扶手","pid"=>"125"),
                                          array("name"=>"后座中央扶手","pid"=>"126"),
                                          array("name"=>"后排杯架","pid"=>"127"),
                                          array("name"=>"电动后备厢","pid"=>"128"),
                                          array("name"=>"主驾驶座椅电动调节","pid"=>"227"),
                                          array("name"=>"副驾驶座椅电动调节","pid"=>"228")
                          )
          ),
          array("title"=>"加热、通风及空调",
                          "attr"=>array(
                                          array("name"=>"手动空调","pid"=>"170"),
                                          array("name"=>"自动空调","pid"=>"171"),
                                          array("name"=>"后排独立空调","pid"=>"172"),
                                          array("name"=>"后座出风口","pid"=>"173"),
                                          array("name"=>"温度分区控制","pid"=>"174"),
                                          array("name"=>"空气调节/花粉过滤","pid"=>"175"),
                                          array("name"=>"车载冰箱","pid"=>"176")
                          )
          ),
          array("title"=>"娱乐、通讯及导航",
                          "attr"=>array(
                                          array("name"=>"GPS导航系统","pid"=>"129"),
                                          array("name"=>"蓝牙/车载电话","pid"=>"134"),
                                          array("name"=>"定位互动服务","pid"=>"130"),
                                          array("name"=>"人机交互系统","pid"=>"132"),
                                          array("name"=>"车载电视","pid"=>"135"),
                                          array("name"=>"中控台彩色大屏","pid"=>"131"),
                                          array("name"=>"内置硬盘","pid"=>"133"),
                                          array("name"=>"后排液晶屏","pid"=>"136"),
                                          array("name"=>"外接音源接口<br/>(AUX/USB/iPod等)","pid"=>"137"),
                                          array("name"=>"CD支持MP3/WMA","pid"=>"138"),
                                          array("name"=>"单碟CD","pid"=>"139"),
                                          array("name"=>"多碟CD系统","pid"=>"141"),
                                          array("name"=>"虚拟多碟CD","pid"=>"140"),
                                          array("name"=>"单碟DVD","pid"=>"142"),
                                          array("name"=>"多碟DVD系统","pid"=>"143"),
                                          array("name"=>"2-3喇叭扬声器系统","pid"=>"144"),
                                          array("name"=>"4-5喇叭扬声器系统","pid"=>"145"),
                                          array("name"=>"6-7喇叭扬声器系统","pid"=>"146"),
                                          array("name"=>"≥8喇叭扬声器系统","pid"=>"147")
                          )
          )
          
        );

//      var $paramattrs = array(
//            array("title"=>"防盗及锁",
//                  "attr"=>array(
//                            array("name"=>"发动机电子防盗","pid"=>"72"),
//                            array("name"=>"车内中控锁","pid"=>"73"),
//                            array("name"=>"遥控钥匙","pid"=>"73"),
//                            array("name"=>"无钥匙启动系统","pid"=>"75")
//                            )
//                  ),
//          array("title"=>"制动及牵引力",
//                  "attr"=>array(
//                            array("name"=>"ABS防抱死","pid"=>"76"),
//                            array("name"=>"制动力分配(EBD/CBC等)","pid"=>"77"),
//                            array("name"=>"刹车辅助(EBA/BAS/BA等)","pid"=>"78"),
//                            array("name"=>"制动力分配(EBD/CBC等)","pid"=>"79"),
//                            array("name"=>"车身稳定控制<br/>(ESP/DSC/VSC等)","pid"=>"80"),
//                            array("name"=>"自动驻车/上坡辅助","pid"=>"81"),
//                            array("name"=>"陡坡缓降","pid"=>"82")
//                            )
//                  ),
//          array("title"=>"娱乐、通讯及导航",
//                  "attr"=>array(
//                            array("name"=>"车载电视","pid"=>"135"),
//                            array("name"=>"后排液晶屏","pid"=>"136"),
//                            array("name"=>"外接音源接口<br/>(AUX/USB/iPod等)","pid"=>"137"),
//                            array("name"=>"CD支持MP3/WMA","pid"=>"138"),
//                            array("name"=>"单碟CD","pid"=>"139"),
//                            array("name"=>"虚拟多碟CD","pid"=>"140"),
//                            array("name"=>"多碟CD系统","pid"=>"141"),
//                            array("name"=>"单碟DVD","pid"=>"142"),
//                            array("name"=>"多碟DVD系统","pid"=>"143"),
//                            array("name"=>"2-3喇叭扬声器系统","pid"=>"144"),
//                            array("name"=>"4-5喇叭扬声器系统","pid"=>"145"),
//                            array("name"=>"6-7喇叭扬声器系统","pid"=>"146"),
//                            array("name"=>"≥8喇叭扬声器系统","pid"=>"147")
//
//                            )
//                  ),
//          array("title"=>"灯光照明",
//                  "attr"=>array(
//                            array("name"=>"氙气大灯","pid"=>"148"),
//                            array("name"=>"日间行车灯","pid"=>"149"),
//                            array("name"=>"自动头灯","pid"=>"150"),
//                            array("name"=>"转向头灯(辅助灯)","pid"=>"151"),
//                            array("name"=>"前雾灯","pid"=>"152"),
//                            array("name"=>"大灯高度可调","pid"=>"153"),
//                            array("name"=>"大灯清洗装置","pid"=>"154"),
//                            array("name"=>"车内氛围灯","pid"=>"155")
//                            )
//                  ),
//          array("title"=>"加热、通风及空调",
//                  "attr"=>array(
//                            array("name"=>"手动空调","pid"=>"170"),
//                            array("name"=>"自动空调","pid"=>"171"),
//                            array("name"=>"后排独立空调","pid"=>"172"),
//                            array("name"=>"后座出风口","pid"=>"173"),
//                            array("name"=>"温度分区控制","pid"=>"174"),
//                            array("name"=>"空气调节/花粉过滤","pid"=>"175"),
//                            array("name"=>"车载冰箱","pid"=>"176")
//                            )
//                  ),
//          array("title"=>"仪表",
//                  "attr"=>array(
//                            array("name"=>"HUD抬头数字显示","pid"=>"101"),
//                            array("name"=>"胎压监测装置","pid"=>"69"),
//                            array("name"=>"倒车视频影像","pid"=>"99"),
//                            array("name"=>"行车电脑显示屏","pid"=>"100"),
//                            array("name"=>"GPS导航系统","pid"=>"129"),
//                            array("name"=>"定位互动服务","pid"=>"130"),
//                            array("name"=>"中控台彩色大屏","pid"=>"131"),
//                            array("name"=>"人机交互系统","pid"=>"132"),
//                            array("name"=>"蓝牙/车载电话","pid"=>"134"),
//                            array("name"=>"夜视系统","pid"=>"181"),
//                            array("name"=>"中控液晶屏分屏显示","pid"=>"182"),
//                            array("name"=>"自适应巡航","pid"=>"183"),
//                            array("name"=>"内置硬盘","pid"=>"133")
//                            )
//                  ),
//          array("title"=>"遥控及远程开闭",
//                  "attr"=>array(
//                            array("name"=>"遥控钥匙","pid"=>"74"),
//                            array("name"=>"电动后备厢","pid"=>"128")
//                            )
//                  ),
//          array("title"=>"安全",
//                  "attr"=>array(
//                            array("name"=>"驾驶座安全气囊","pid"=>"62"),
//                            array("name"=>"副驾驶安全气囊","pid"=>"63"),
//                            array("name"=>"前排侧气囊","pid"=>"64"),
//                            array("name"=>"后排侧气囊","pid"=>"65"),
//                            array("name"=>"前排头部气囊(气帘)","pid"=>"66"),
//                            array("name"=>"后排头部气囊(气帘)","pid"=>"67"),
//                            array("name"=>"膝部气囊","pid"=>"68"),
//                            array("name"=>"安全带未系提示","pid"=>"71"),
//                            array("name"=>"零胎压继续行驶","pid"=>"70"),
//                            array("name"=>"主动刹车/主动安全系统","pid"=>"179"),
//                            array("name"=>"并线辅助","pid"=>"178"),
//                            array("name"=>"自动泊车入位","pid"=>"177"),
//                            array("name"=>"全景摄像头","pid"=>"184"),
//                            array("name"=>"定速巡航","pid"=>"97"),
//                            array("name"=>"泊车辅助","pid"=>"98"),
//                            array("name"=>"电动吸合门","pid"=>"90")
//                            )
//                  ),
//          array("title"=>"座椅",
//                  "attr"=>array(
//                            array("name"=>"真皮/仿皮座椅","pid"=>"102"),
//                            array("name"=>"运动座椅","pid"=>"103"),
//                            array("name"=>"座椅高低调节","pid"=>"104"),
//                            array("name"=>"腰部支撑调节","pid"=>"105"),
//                            array("name"=>"肩部支撑调节","pid"=>"106"),
//                            array("name"=>"前排座椅电动调节","pid"=>"107"),
//                            array("name"=>"第二排靠背角度调节","pid"=>"108"),
//                            array("name"=>"第二排座椅移动","pid"=>"109"),
//                            array("name"=>"后排座椅电动调节","pid"=>"110"),
//                            array("name"=>"电动座椅记忆","pid"=>"111"),
//                            array("name"=>"前排座椅加热","pid"=>"112"),
//                            array("name"=>"后排座椅加热","pid"=>"113"),
//                            array("name"=>"座椅通风","pid"=>"114"),
//                            array("name"=>"座椅按摩","pid"=>"115"),
//                            array("name"=>"后排座椅整体放倒","pid"=>"116"),
//                            array("name"=>"后排座椅比例放倒","pid"=>"117"),
//                            array("name"=>"第三排座椅","pid"=>"118"),
//                            array("name"=>"前座中央扶手","pid"=>"125"),
//                            array("name"=>"后座中央扶手","pid"=>"126")
//                            )
//                  ),
//          array("title"=>"储物",
//                  "attr"=>array(
//                            array("name"=>"后排杯架","pid"=>"127")
//                            )
//                  ),
//          array("title"=>"转向",
//                  "attr"=>array(
//                            array("name"=>"真皮方向盘","pid"=>"91"),
//                            array("name"=>"多功能方向盘","pid"=>"95"),
//                            array("name"=>"方向盘上下调节","pid"=>"92"),
//                            array("name"=>"方向盘前后调节","pid"=>"93"),
//                            array("name"=>"方向盘电动调节","pid"=>"94"),
//                            array("name"=>"可变转向比","pid"=>"217"),
//                            array("name"=>"整体主动转向系统","pid"=>"85")
//                            )
//                  ),
//          array("title"=>"悬挂",
//                  "attr"=>array(
//                            array("name"=>"可变悬挂","pid"=>"84"),
//                            array("name"=>"空气悬挂","pid"=>"83")
//                            )
//                  ),
//          array("title"=>"变速箱",
//                  "attr"=>array(
//                            array("name"=>"方向盘换挡","pid"=>"96")
//                            )
//                  ),
//          array("title"=>"轮毂及轮胎",
//                  "attr"=>array(
//                            array("name"=>"铝合金轮毂","pid"=>"89")
//                            )
//                  ),
//          array("title"=>"车窗、镜子及雨刷",
//                  "attr"=>array(
//                            array("name"=>"前电动车窗","pid"=>"156"),
//                            array("name"=>"后电动车窗","pid"=>"157"),
//                            array("name"=>"车窗防夹手功能","pid"=>"158"),
//                            array("name"=>"防紫外线/隔热玻璃","pid"=>"159"),
//                            array("name"=>"后视镜电动调节","pid"=>"160"),
//                            array("name"=>"后视镜加热","pid"=>"161"),
//                            array("name"=>"后视镜自动防眩目","pid"=>"162"),
//                            array("name"=>"后视镜电动折叠","pid"=>"163"),
//                            array("name"=>"后视镜记忆","pid"=>"164"),
//                            array("name"=>"后风挡遮阳帘","pid"=>"165"),
//                            array("name"=>"后排侧遮阳帘","pid"=>"166"),
//                            array("name"=>"遮阳板化妆镜","pid"=>"167"),
//                            array("name"=>"后雨刷","pid"=>"168"),
//                            array("name"=>"感应雨刷","pid"=>"169"),
//                            array("name"=>"电动天窗","pid"=>"86"),
//                            array("name"=>"全景天窗","pid"=>"87")
//                            )
//                  )
//
//
//        );

    function __construct(){
      $this->table_name = "cardb_param";
      parent::__construct();
    }

    function getParamlist($fileds="*",$where="1",$order=null){
      $this->reset();
      $this->fields = $fileds;
      $this->where = $where;
      if(!empty($order)){$this->order = $order;}
      return $this->getResult(2);
    }
    
    function getParam($fileds,$where,$flag){
        $this->fields = $fileds;
        $this->where = $where;
        $result =$this->getResult($flag);
        return $result;
    }
  }

?>
