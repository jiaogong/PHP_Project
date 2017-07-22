<?php

class seoAction extends action{
    public $article;
    public $tags;
    public $url_prefix;
    public $url_prefix_m;
    
    function __construct() {
        parent::__construct();
        $this->article = new article();
        $this->tags = new tags();
        $this->url_prefix = array(
//            7 => 'http://news.' . DOMAIN . '/',
//            8 => 'http://pingce.' . DOMAIN . '/',
//            10 => 'http://wenhua.' . DOMAIN . '/',
//            9 => 'http://v.' . DOMAIN . '/',
            7 => 'http://news.cheping.com.cn/',
            8 => 'http://pingce.cheping.com.cn/',
            10 => 'http://wenhua.cheping.com.cn/',
            9 => 'http://v.cheping.com.cn/',
        );
        $this->url_prefix_m = array(
            7 => 'news',
            8 => 'pingce',
            10 => 'wenhua',
            9 => 'v',
        );
        $this->checkAuth(1201);
    }
    
    function doSilian(){
        $tpl_name = "silian";
        $this->template($tpl_name);
    }
    
    function doMakeSilianXml(){
        $msg = '';
        $tpl_name = 'silian_xml';
        $filename_pc = WWW_ROOT . "silian.xml";
        $src_file = pathinfo($_FILES['silian']['name']);
        if($_FILES['silian']['size'] && strtolower($src_file['extension']) == 'txt'){
            if(FALSE !== ($file = file($_FILES['silian']['tmp_name']))){
                foreach ($file as $v){
                    #$silian[] = str_replace('&', '&amp;', trim($v));
                    $v = $this->addValue($v)->Url();
                    if($v){
                        $v = str_replace('&', '&amp;', $v);
                        $silian[] = $v;
                    }
                }
                $this->vars('silian', $silian);
                $this->vars('date', date('Y-m-d'));
                
                #判断是追加，还是覆盖
                $writemode = $this->postValue('writemode')->Int();
                #覆盖模式，原文件不存在
                if(!$writemode || file_exists($filename_pc) === FALSE){
                    $xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n" . $this->fetch($tpl_name);
                }
                #追加到原文件后
                else{
                    $xml = file_get_contents($filename_pc);
                    $xml = str_replace('</urlset>', '', $xml);
                    $xml .= str_replace('<urlset>', '', $this->fetch($tpl_name));
                }
                
                $len = file_put_contents($filename_pc, $xml);
                if($len == strlen($xml)){
                    $msg = "死链接文件生成成功！" . ($writemode ? "新链接内容已经追加到原文件末尾！" : "");
                }else{
                    $msg = "死链接文件生成失败！";
                }
            }else{
                $msg = "上传文件读取失败！";
            }
        }else{
            $msg = "死链接文件不正确，请检查之后重新上传！";
        }
        $this->alert($msg, 'js', 3, $_ENV['PHP_SELF']."silian");
    }

    //自动或手动生成xml
    function doautoMakeXml(){
        $this->autoMakeArticleXml(TRUE);
        $this->autoMakeCarXml(TRUE);
    }
    
    //（自动生成根据每天的发布的文章和视频 或 手动生成发布的所有文章和视频）的sitemap_1_pc_1.xml或sitemap_1_mobile_1.xml
    private function autoMakeArticleXml($is_manually){
        global $local_host;
        $file_num = $file_num_m = $record_pc_num = $record_mobile_num = 0;
        $record_pc_max_num = 10000 * 1 ; //文件在1M（1万条）左右，超出则自动创建 sitemap_1_pc_【0,1,2,3。。。】.xml 当前文件的下一个
        $record_mobile_max_num = 10000 * 1 ; //文件在1.2M（1万条）左右 ，超出则自动创建 sitemap_1_mobile_【0,1,2,3。。。】.xml 当前文件的下一个
        $file_max_size = 4.8 * (1024 * 1024); //文件最大不超过4.8M
        $filename_pc = $filename_mobile = $article_auto_sql = $new_add_data_pc = $new_add_data_mobile = "";
        $yesterday = strtotime("-1 day"); //昨天
        $date = date('Y-m-d');
        //选车与图片的一些
        $car_and_photo = array(
            'xuanche/',
            'photo/',
            'search.php?action=index&amp;sale=1',
            'search.php?action=index&amp;sale=2',
            'login.php',
            'register.php',
            'user.php',
            'pic.html'
            );
        if(!$is_manually){
            $article_auto_sql = "ca.uptime>{$yesterday} and ";
        }
        $filename_pc = $this->fileFunc(1, 'pc', $file_num, $file_max_size, $is_manually);
        $filename_mobile = $this->fileFunc(1, 'mobile', $file_num, $file_max_size, $is_manually, 'is_mobile');
        //文章和视频内容页的    
        $article_data = $this->article->getArticleAndCategory("ca.id,ca.uptime,cac.parentid","{$article_auto_sql}cac.state=1 and ca.state=3 and cac.id=ca.category_id",array("ca.uptime"=>"ASC"));
        $url_prefix = $this->url_prefix;
        $url_prefix_m = $this->url_prefix_m;
        //二级域名和二级域名下的栏目
        $model = new model();
        $model->table_name ='cp_article_category';
        $model->where = "state=1";
        $SLD_data = $model->getResult(2);
        //分类标签
        $tags_data = $this->tags->getTagFields("id", 'state=1',2);

        //首页
        $new_add_data_pc .= "\t<url>\n";
        $new_add_data_pc .= "\t\t<loc>". $local_host ."</loc>\n";
        $new_add_data_pc .= "\t\t<lastmod>$date</lastmod>\n";
        $new_add_data_pc .= "\t</url>\n";

        $new_add_data_mobile .= "\t<url>\n";
        $new_add_data_mobile .= "\t\t<loc>". "m.". DOMAIN ."</loc>\n";
        $new_add_data_mobile .= "\t\t<mobile:mobile type=\"mobile\"/>\n";
        $new_add_data_mobile .= "\t\t<lastmod>{$date}</lastmod>\n";
        $new_add_data_mobile .= "\t</url>\n";

        $record_pc_num++;
        $record_mobile_num++;

        //二级域名和二级域名下的栏目
        if($SLD_data){
            foreach($SLD_data as $k=>$v){//二级域名
                if(in_array($v['parentid'], array_keys($url_prefix)) || in_array($v['id'], array_keys($url_prefix))){
                    $new_add_data_pc .= "\t<url>\n";
                    if($v['parentid']){
                        if($v['parentid']!=9){
                            $SLD_column_url = "article.php?action=CarReview&id={$v['parentid']}&ids={$v['id']}";
                            $SLD_column_url_pc = replaceNewsChannel($SLD_column_url);
                            $SLD_column_url_mobile = $this->replaceWapNewsUrl($SLD_column_url);
                        }else{
                            $SLD_column_url = "video.php?action=Video&id={$v['parentid']}&ids={$v['id']}";
                            $SLD_column_url_pc = replaceVideoUrl($SLD_column_url);
                            $SLD_column_url_mobile = $this->replaceWapNewsUrl($SLD_column_url);
                        }
                    }else{
                        $SLD_column_url_pc = $url_prefix[$v['id']];
                        $SLD_column_url_mobile = "http://m.cheping.com.cn/".$url_prefix_m[$v['id']]."/";
                    }
                    $new_add_data_pc .= "\t\t<loc>". $SLD_column_url_pc ."</loc>\n";
                    $new_add_data_pc .= "\t\t<lastmod>$date</lastmod>\n";
                    $new_add_data_pc .= "\t</url>\n";

                    $new_add_data_mobile .= "\t<url>\n";
                    $new_add_data_mobile .= "\t\t<loc>{$SLD_column_url_mobile}</loc>\n";
                    $new_add_data_mobile .= "\t\t<mobile:mobile type=\"mobile\"/>\n";
                    $new_add_data_mobile .= "\t\t<lastmod>{$date}</lastmod>\n";
                    $new_add_data_mobile .= "\t</url>\n";

                    $record_pc_num++;
                    if($record_pc_num >= $record_pc_max_num){
                        $this->fileRAndW($filename_pc, $new_add_data_pc);
                        $new_add_data_pc = "";
                        $record_pc_num = 0;
                        $file_num++;
                        $filename_pc = $this->fileFunc(1, 'pc', $file_num, $file_max_size, $is_manually);
                    }
                    $record_mobile_num++;
                    if($record_mobile_num >= $record_mobile_max_num){
                        $this->fileRAndW($filename_mobile, $new_add_data_mobile);
                        $new_add_data_mobile = "";
                        $record_mobile_num = 0;
                        $file_num_m++;
                        $filename_mobile = $this->fileFunc(1, 'mobile', $file_num_m, $file_max_size, $is_manually, 'is_mobile');
                    }
                }
            }
        }
        //选车与图片的一些
        if($car_and_photo){
            foreach($car_and_photo as $k=>$v){
                $new_add_data_pc .= "\t<url>\n";
                $new_add_data_pc .= "\t\t<loc>". $local_host . $v ."</loc>\n";
                $new_add_data_pc .= "\t\t<lastmod>$date</lastmod>\n";
                $new_add_data_pc .= "\t</url>\n";

                $record_pc_num++;
                if($record_pc_num >= $record_pc_max_num){
                    $this->fileRAndW($filename_pc, $new_add_data_pc);
                    $new_add_data_pc = "";
                    $record_pc_num = 0;
                    $file_num++;
                    $filename_pc = $this->fileFunc(1, 'pc', $file_num, $file_max_size, $is_manually);
                }
                $record_mobile_num++;
                if($record_mobile_num >= $record_mobile_max_num){
                    $this->fileRAndW($filename_mobile, $new_add_data_mobile);
                    $new_add_data_mobile = "";
                    $record_mobile_num = 0;
                    $file_num_m++;
                    $filename_mobile = $this->fileFunc(1, 'mobile', $file_num_m, $file_max_size, $is_manually, 'is_mobile');
                }
            }
        }
        //分类标签
        if($tags_data){
            foreach($tags_data as $k=>$v){//分类标签
                $new_add_data_pc .= "\t<url>\n";
                $new_add_data_pc .= "\t\t<loc>". $local_host . "article.php?action=ActiveList&amp;id=". $v['id'] ."</loc>\n";
                $new_add_data_pc .= "\t\t<lastmod>$date</lastmod>\n";
                $new_add_data_pc .= "\t</url>\n";

                $record_pc_num++;
                if($record_pc_num >= $record_pc_max_num){
                    $this->fileRAndW($filename_pc, $new_add_data_pc);
                    $new_add_data_pc = "";
                    $record_pc_num = 0;
                    $file_num++;
                    $filename_pc = $this->fileFunc(1, 'pc', $file_num, $file_max_size, $is_manually);
                }
                $record_mobile_num++;
                if($record_mobile_num >= $record_mobile_max_num){
                    $this->fileRAndW($filename_mobile, $new_add_data_mobile);
                    $new_add_data_mobile = "";
                    $record_mobile_num = 0;
                    $file_num_m++;
                    $filename_mobile = $this->fileFunc(1, 'mobile', $file_num_m, $file_max_size, $is_manually, 'is_mobile');
                }
            }
        }
        //文章和视频内容页的 
        if($article_data){
            foreach($article_data as $k=>$v){//文章和视频内容页的
                if($v['parentid'] != 9){
                    $article_path_pc = date('Ym', $v['uptime']) . '-' . date('d',  $v['uptime']) . '-' . $v['id'] . '.html';
                    $article_path_mobile = "http://m." . DOMAIN . "/" . $url_prefix_m[$v['parentid']] . "/". $article_path_pc;
                }else{
                    $article_path_pc = $v['id'] . '.html';
                    $article_path_mobile = "http://m." . DOMAIN . "/" . $url_prefix_m[$v['parentid']] . "/". $v['id'] .".html";
                }

                $article_date = date('Y-m-d', $v['uptime']);
                $new_add_data_pc .= "\t<url>\n";
                $new_add_data_pc .= "\t\t<loc>". $url_prefix[$v['parentid']] . $article_path_pc ."</loc>\n";
                $new_add_data_pc .= "\t\t<lastmod>$article_date</lastmod>\n";
                $new_add_data_pc .= "\t</url>\n";

                $new_add_data_mobile .= "\t<url>\n";
                $new_add_data_mobile .= "\t\t<loc>{$article_path_mobile}</loc>\n";
                $new_add_data_mobile .= "\t\t<mobile:mobile type=\"mobile\"/>\n";
                $new_add_data_mobile .= "\t\t<lastmod>{$article_date}</lastmod>\n";
                $new_add_data_mobile .= "\t</url>\n";

                $record_pc_num++;
                if($record_pc_num >= $record_pc_max_num){
                    $this->fileRAndW($filename_pc, $new_add_data_pc);
                    $new_add_data_pc = "";
                    $record_pc_num = 0;
                    $file_num++;
                    $filename_pc = $this->fileFunc(1, 'pc', $file_num, $file_max_size, $is_manually);
                }
                $record_mobile_num++;
                if($record_mobile_num >= $record_mobile_max_num){
                    $this->fileRAndW($filename_mobile, $new_add_data_mobile);
                    $new_add_data_mobile = "";
                    $record_mobile_num = 0;
                    $file_num_m++;
                    $filename_mobile = $this->fileFunc(1, 'mobile', $file_num_m, $file_max_size, $is_manually, 'is_mobile');
                }
            }
        }
        //读取并写入文件
        if($new_add_data_pc){
            $pc_file_make_ok = $this->fileRAndW($filename_pc, $new_add_data_pc);
        }
        if($new_add_data_mobile){
            $mobile_file_make_ok = $this->fileRAndW($filename_mobile, $new_add_data_mobile);
        }
    }
    
    //手动生成车型产品库和图片库的sitemap_2_pc_1.xml或sitemap_2_mobile_1.xml
    private function autoMakeCarXml($is_manually){
        global $local_host;
        $file_num = $file_num_m = $record_pc_num = $record_mobile_num = 0;
        $record_pc_max_num = 10000 * 1; //文件在1M（1万条）左右，超出则自动创建 sitemap_2_pc_【0,1,2,3。。。】.xml 当前文件的下一个
        //$record_mobile_max_num = 10000 * 1; //最多条数大于0.96万条数据时，重新生成一个文件
        $file_max_size = 4.8 * (1024 * 1024); //文件最大不超过4.8M
        $filename_pc = $filename_mobile = $new_add_data_pc = $new_add_data_mobile = "";
        $date = date('Y-m-d');
        $filename_pc = $this->fileFunc(2, 'pc', $file_num, $file_max_size, $is_manually);
        #$filename_mobile = $this->fileFunc(2, 'mobile', $file_num, $file_max_size, $is_manually, 'is_mobile');
        //产品库-顶部url
        $this->index = new index();
        //价格区间
        $price = $this->index->priceSelect;
        //车身形式
        $cs = $this->index->cs;
        //厂商性质
        $fi = $this->index->fi;
        //国别
        $bi = $this->index->bi;
        //级别
        $ct = $this->index->ct;
        //排量
        $pl = $this->index->pl;
        //变速箱
        $bsx = $this->index->bsx;
        //进气形式
        $jq = $this->index->jq;
        // 座位数
        $zw = $this->index->zw;
        //汽缸数
        $qg = $this->index->qg;
        //车体结构
        $st = $this->index->st;
        //驱动形式
        $dr = $this->index->dr;
        //燃料类型
        $ot = array(1=>'汽油', 2=>'柴油', 3=>'油电混合', 4=>'纯电动');
        //车辆配置
        $sp = $this->index->sp;

        $tags_arr = array(
            'pr' => $price,
            'cs' => $cs,
            'fi' => $fi,
            'bi' => $bi,
            'ct' => $ct,
            'pl' => $pl,
            'bsx' => $bsx,
            'jq' => $jq,
            'zw' => $zw,
            'qg' => $qg,
            'st' => $st,
            'dr' => $dr,
            'ot' => $ot,
            'sp' => $sp,
            );
        //车款详情页
        $this->models = new cardbModel();
        $model = $this->models->getSimp('model_id,series_id','state in(3,8)');

        //图片库页-品牌
        $this->brand = new brand();
        $brand = $this->brand->getBrandlist('brand_id','state=3', 2);
        //图片库页-车系
        $this->series = new series();
        $series = $this->series->getSeriesdata('series_id','state=3', 2);

        //车款图片分类
        $this->uploadfile = new uploadFile();
        $pic_type = $this->uploadfile->pic_type;
        //产品库-上部分标签url
        if($tags_arr){
            foreach($tags_arr as $k=>$v) {
                if(is_array($v)){
                    foreach($v as $key=>$val){
                        $new_add_data_pc .= "\t<url>\n";
                        if($k=='sp') {
                            $key_str = str_replace('sp','',$key);
                            $new_add_data_pc .= "\t\t<loc>" . $local_host . "search.php?action=index&amp;{$key}=1</loc>\n";
                        }else{
                            $new_add_data_pc .= "\t\t<loc>" . $local_host . "search.php?action=index&amp;{$k}={$key}</loc>\n";
                        }
                        $new_add_data_pc .= "\t\t<lastmod>$date</lastmod>\n";
                        $new_add_data_pc .= "\t</url>\n";

                        $record_pc_num++;
                        if($record_pc_num >= $record_pc_max_num){
                            $this->fileRAndW($filename_pc, $new_add_data_pc);
                            $new_add_data_pc = "";
                            $record_pc_num = 0;
                            $file_num++;
                            $filename_pc = $this->fileFunc(2, 'pc', $file_num, $file_max_size, $is_manually);
                        }
                    }
                }
            }
        }

       //车款详情页\车款配置详情页\价格详情页
        if($model){
            foreach($model as $k=>$v){
                $new_add_data_pc .= "\t<url>\n";
                $new_add_data_pc .= "\t\t<loc>". $local_host . "modelinfo_". $v['model_id'] .".html</loc>\n";
                $new_add_data_pc .= "\t\t<lastmod>$date</lastmod>\n";
                $new_add_data_pc .= "\t</url>\n";

                $new_add_data_pc .= "\t<url>\n";
                $new_add_data_pc .= "\t\t<loc>". $local_host . "offers_". $v['model_id'] .".html</loc>\n";
                $new_add_data_pc .= "\t\t<lastmod>$date</lastmod>\n";
                $new_add_data_pc .= "\t</url>\n";

                $new_add_data_pc .= "\t<url>\n";
                $new_add_data_pc .= "\t\t<loc>". $local_host . "param_". $v['model_id'] .".html</loc>\n";
                $new_add_data_pc .= "\t\t<lastmod>$date</lastmod>\n";
                $new_add_data_pc .= "\t</url>\n";

                $record_pc_num += 3;
                if($record_pc_num >= $record_pc_max_num){
                    $this->fileRAndW($filename_pc, $new_add_data_pc);
                    $new_add_data_pc = "";
                    $record_pc_num = 0;
                    $file_num++;
                    $filename_pc = $this->fileFunc(2, 'pc', $file_num, $file_max_size, $is_manually);
                }
            }
        }
        //图片库页-品牌
        if($brand){
            foreach($brand as $k=>$v){
                $new_add_data_pc .= "\t<url>\n";
                $new_add_data_pc .= "\t\t<loc>". $local_host . "image_searchbrandlist_brand_id_{$v['brand_id']}.html</loc>\n";
                $new_add_data_pc .= "\t\t<lastmod>$date</lastmod>\n";
                $new_add_data_pc .= "\t</url>\n";

                $record_pc_num++;
                if($record_pc_num >= $record_pc_max_num){
                    $this->fileRAndW($filename_pc, $new_add_data_pc);
                    $new_add_data_pc = "";
                    $record_pc_num = 0;
                    $file_num++;
                    $filename_pc = $this->fileFunc(2, 'pc', $file_num, $file_max_size, $is_manually);
                }
            }
        }
        //图片库页-车系
        if($series){
            foreach($series as $k=>$v){
                $new_add_data_pc .= "\t<url>\n";
                $new_add_data_pc .= "\t\t<loc>". $local_host . "image_searchlist_series_id_{$v['series_id']}.html</loc>\n";
                $new_add_data_pc .= "\t\t<lastmod>$date</lastmod>\n";
                $new_add_data_pc .= "\t</url>\n";

                $record_pc_num++;
                if($record_pc_num >= $record_pc_max_num){
                    $this->fileRAndW($filename_pc, $new_add_data_pc);
                    $new_add_data_pc = "";
                    $record_pc_num = 0;
                    $filename_pc = $this->fileFunc(2, 'pc', $file_num++, $file_max_size, $is_manually);
                }
            }
        }
        //按车款
        if($model){
            foreach($model as $k=>$v){
                $new_add_data_pc .= "\t<url>\n";
                $new_add_data_pc .= "\t\t<loc>". $local_host . "modelpicselect/{$v['series_id']}_{$v['model_id']}_0.html</loc>\n";
                $new_add_data_pc .= "\t\t<lastmod>$date</lastmod>\n";
                $new_add_data_pc .= "\t</url>\n";

                $record_pc_num++;
                if($record_pc_num >= $record_pc_max_num){
                    $this->fileRAndW($filename_pc, $new_add_data_pc);
                    $new_add_data_pc = "";
                    $record_pc_num = 0;
                    $file_num++;
                    $filename_pc = $this->fileFunc(2, 'pc', $file_num, $file_max_size, $is_manually);
                }
            }
        }
        //车款按图片分类
        if($model && $pic_type){
            foreach($model as $k=>$v){
                foreach($pic_type as $key=>$val) {
                    $new_add_data_pc .= "\t<url>\n";
                    $new_add_data_pc .= "\t\t<loc>" . $local_host . "modelpicselect/{$v['series_id']}_{$v['model_id']}_0_{$key}.html</loc>\n";
                    $new_add_data_pc .= "\t\t<lastmod>$date</lastmod>\n";
                    $new_add_data_pc .= "\t</url>\n";

                    $record_pc_num++;
                    if($record_pc_num >= $record_pc_max_num){
                        $this->fileRAndW($filename_pc, $new_add_data_pc);
                        $new_add_data_pc = "";
                        $record_pc_num = 0;
                        $file_num++;
                        $filename_pc = $this->fileFunc(2, 'pc', $file_num, $file_max_size, $is_manually);
                    }
                }
            }
        }

        //读取并写入文件
        if($new_add_data_pc){
            $pc_file_make_ok = $this->fileRAndW($filename_pc, $new_add_data_pc);
        }
        //if($new_add_data_mobile){
            #$new_add_data_mobile = $this->replaceWapNewsUrl($new_add_data_pc);
            #$mobile_file_make_ok = $this->fileRAndW($filename_mobile, $new_add_data_mobile);
        //}
    }
    
    function checkAuth($id, $module_type = 'sys_module', $type_value = "A") {
        global $adminauth, $login_uid;
        $adminauth->checkAuth($login_uid, $module_type, $id, 'A');
    }
    
    /**
     * 判断文件是否存在 或 超出大小，并创建文件
     * 
     * @param integer $file_tag xml文件内容的url:$file_tag=1 首页\视频\评测\资讯\文化 的url $file_tag=2 选车\图片
     * @param string $file_type $file_type="pc" or $file_type="mobile"
     * @param integer $file_num 所属下的第几个文件
     * @param integer $file_max_size 文件大小的最大限额
     * @param boolean $is_manually 是否是手动，如果手动删除所有xml的相关文件，重新创建
     * @param boolean $is_mobile 如果是wap版，则用mobile信息
     * @return string $filename 返回最后的文件名
     */
    private function fileFunc($file_tag, $file_type, $file_num, $file_max_size, $is_manually, $is_mobile=Null){
        global $local_host;
        $filename = WWW_ROOT . "sitemap_{$file_tag}_{$file_type}_{$file_num}.xml";
        $mobile_xml_url = $local_host . "sitemap_{$file_tag}_{$file_type}_{$file_num}.xml";
        $file_data_size = $xml_header = '';
        //判断文件是否存在 或 超出大小
        if(!is_file($filename)){//创建文件
            $xml_header .= "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
            if($is_mobile){
                $xml_header .= "<urlset xmlns:mobile=\"" . $mobile_xml_url . "\">\n";
            }else {
                $xml_header .= "<urlset>\n";
            }
            $xml_header .= "</urlset>";
            $file_data_size = file_put_contents($filename, $xml_header);
        }else{
            if($is_manually){//如果手动，则删除重新创建
                $file_nums = $file_num + 1;
                $filenames = WWW_ROOT . "sitemap_{$file_tag}_{$file_type}_{$file_nums}.xml";
                while(is_file($filenames)){
                    unlink($filenames);
                    $file_nums++;
                    $filenames = WWW_ROOT . "sitemap_{$file_tag}_{$file_type}_{$file_nums}.xml";
                }
                $filename = WWW_ROOT . "sitemap_{$file_tag}_{$file_type}_{$file_num}.xml";
                $xml_header .= "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
                if($is_mobile){
                    $xml_header .= "<urlset xmlns:mobile=\"" . $mobile_xml_url . "\">\n";
                }else {
                    $xml_header .= "<urlset>\n";
                }
                $xml_header .= "</urlset>";
                $file_data_size = file_put_contents($filename, $xml_header);
            }else{
                $filesize = filesize($filename);
                if($filesize >= $file_max_size){ //如果文件大于4.8M 再生成一个sitemap_1_1.xml的文件
                    $file_nums = $file_num + 1;
                    $filename = WWW_ROOT . "sitemap_{$file_tag}_{$file_type}_{$file_nums}.xml";
                    while(is_file($filename)){
                        $filesize = filesize($filename);
                        if($filesize >= $file_max_size){
                            $file_nums++;
                            $filename = WWW_ROOT . "sitemap_{$file_tag}_{$file_type}_{$file_nums}.xml";
                        }
                    }
                    if(!is_file($filename)){ //如果sitemap_1_pc_1.xml或sitemap_1_mobile_1.xml不文件，创建它
                        $xml_header .= "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
                        if($is_mobile){
                            $xml_header .= "<urlset xmlns:mobile=\"" . $mobile_xml_url . "\">\n";
                        }else {
                            $xml_header .= "<urlset>\n";
                        }
                        $xml_header .= "</urlset>";
                        $file_data_size = file_put_contents($filename, $xml_header);
                    }
                }
            }
        }
        return $filename;
    }
    
    /**
     * 将文件内容追加到指定的文件内容后
     * 
     * @param type $filename 文件名
     * @param string $new_content 要追加的文件内容
     * @return type 合计文件的大小
     */
    private function fileRAndW($filename,$new_content){
        $xml = @file_get_contents($filename);
        $new_content .= "</urlset>";
        $xml = str_replace('</urlset>', $new_content, $xml);
        $file_data_size = @file_put_contents($filename, $xml);
        return $file_data_size;
    }

    /**
     * 替换wap站的文章链接
     *
     * @param string $str 文章链接或相关字符串
     * @return string 替换完成之后的链接，如果无RWURL常量，返回原链接
     */
    function replaceWapNewsUrl($str) {
        global $local_host;
        if (RWURL) {
            $str = str_replace($local_host, 'http://m.' . DOMAIN . '/', $str);
            $str = str_replace('href="article.php?action=ActiveList', 'http://m.' . DOMAIN . '/article.php?action=ActiveList', $str);
            $str = str_replace('/article.php?action=CarReview&id', 'article.php?action=CarReview&id', $str);
            $str = str_replace('/video.php?action=Video&id', 'video.php?action=Video&id', $str);
            $str = str_replace('article.php?action=CarReview&id=7&ids=54', 'http://m.' . DOMAIN . '/news/xinche/', $str);
            $str = str_replace('article.php?action=CarReview&id=7&ids=55', 'http://m.' . DOMAIN . '/news/zixun/', $str);
            $str = str_replace('article.php?action=CarReview&id=8&ids=16', 'http://m.' . DOMAIN . '/pingce/jiashi/', $str);
            $str = str_replace('article.php?action=CarReview&id=8&ids=56', 'http://m.' . DOMAIN . '/pingce/ceshi/', $str);
            $str = str_replace('article.php?action=CarReview&id=10&ids=50', 'http://m.' . DOMAIN . '/wenhua/jingdianche/', $str);
            $str = str_replace('article.php?action=CarReview&id=10&ids=52', 'http://m.' . DOMAIN . '/wenhua/fengyunche/', $str);
            $str = str_replace('article.php?action=CarReview&id=10&ids=51', 'http://m.' . DOMAIN . '/wenhua/saiche/', $str);
            $str = str_replace('article.php?action=CarReview&id=8&ids=59', 'http://m.' . DOMAIN . '/pingce/duibi/', $str);
            $str = str_replace('article.php?action=CarReview&id=7&ids=60', 'http://m.' . DOMAIN . '/wenhua/quwen/', $str);
            $str = str_replace('article.php?action=CarReview&id=7&ids=63', 'http://m.' . DOMAIN . '/news/hangye/', $str);
            $str = str_replace('article.php?action=CarReview&id=10&ids=65', 'http://m.' . DOMAIN . '/wenhua/lvxing/', $str);
            $str = str_replace('article.php?action=CarReview&id=7', 'http://m.' . DOMAIN . '/news/', $str);
            $str = str_replace('article.php?action=CarReview&id=8', 'http://m.' . DOMAIN . '/pingce/', $str);
            $str = str_replace('article.php?action=CarReview&id=10', 'http://m.' . DOMAIN . '/wenhua/', $str);
            $str = str_replace('video.php?action=Video&id=9&ids=33', 'http://m.' . DOMAIN . "/v/xiadongpingche/", $str);
            $str = str_replace('video.php?action=Video&id=9&ids=34', 'http://m.' . DOMAIN . "/v/jingtai/", $str);
            $str = str_replace('video.php?action=Video&id=9&ids=35', 'http://m.' . DOMAIN . "/v/feichedang/", $str);
            $str = str_replace('video.php?action=Video&id=9&ids=40', 'http://m.' . DOMAIN . "/v/guanfang/", $str);
            $str = str_replace('video.php?action=Video&id=9&ids=57', 'http://m.' . DOMAIN . "/v/ttyhs/", $str);
            $str = str_replace('video.php?action=Video&id=9&ids=58', 'http://m.' . DOMAIN . "/v/huodong/", $str);
            $str = str_replace('video.php?action=Video&id=9&ids=61', 'http://m.' . DOMAIN . '/v/wscsc/', $str);
            $str = str_replace('video.php?action=Video&id=9&ids=62', 'http://m.' . DOMAIN . '/v/cxkdp/', $str);
            $str = str_replace('video.php?action=Video&id=9&ids=66', 'http://m.' . DOMAIN . '/v/ttsrx/', $str);
            $str = str_replace('video.php?action=Video&id=9&ids=67', 'http://m.' . DOMAIN . '/v/deguo/', $str);
            $str = str_replace('video.php?action=Video&id=9&ids=70', 'http://m.' . DOMAIN . '/v/bjpc/', $str);
            $str = str_replace('video.php?action=Video&id=9&ids=71', 'http://m.' . DOMAIN . '/v/sportauto/', $str);
            $str = str_replace('article.php?action=CarReview&id=9', 'http://m.' . DOMAIN . '/v/', $str);
            $str = str_replace('video.php?action=Video&id=9', 'http://m.' . DOMAIN . '/v/', $str);
        }
        return $str;
    }
}

