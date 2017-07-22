<?php

header("Content-type:text/html;charset=utf-8");

class bannerPicAction extends action {

    var $indexbanner;
    public $category;
    public $article;

    function __construct() {
        parent::__construct();
        $this->indexbanner = new indexbanner();
        $this->category = new category();
        $this->article = new article();
    }


    function doDefault() {
        $this->doList();
    }

    function doList() {
        global $local_host;
        $template_name = "banner_indexo";
        $extra = "";
        $page = $this->getValue('page')->Int(1);
        $page = max(1, $page);
        $page_size = 18;
        $page_start = ($page - 1) * $page_size;

        $fields = "*";
        $where = "";
        $order= array("show_index"=>"asc");
        $list = $this->indexbanner->getBannerList($where, $fields, $page_size, $page_start,$order, 2);
        $total = $this->indexbanner->total;
        $page_bar = $this->multi($total, $page_size, $page, $_ENV['PHP_SELF'] . 'list' . $extra);
        $this->vars('list', $list);
        $this->vars('page_bar', $page_bar);
        $this->template($template_name);
    }

    function doAdd() {
        global $local_host;
        $template_name = "banner_add";
        $fields = "*";
        $where = " parentid=0 and state=1 ";
        $where = "";
        $category_list = $this->category->getlist($fields, $where, 2);
        if ($_POST) {
            $small_title = $this->postValue('small_title')->Val();
            $show_title = $this->postValue('show_title')->Val();
            $show_index = $this->postValue('show_index')->Val();
            $channel_index = $this->postValue('channel_index')->Val();
            $show_url = $this->postValue('show_url')->Val();
            $show_pic = $_FILES['show_pic'];
            
            $this->indexbanner->ufields = array(
                "channel_name" => $this->category->getlist("category_name", "id=".$channel_index[0], 3),
                "channel_index" => $channel_index[0],
                "small_title"=> $small_title[0],
                "show_title" => $show_title[0],
                "show_url" => $show_url[0],
                "show_pic" => $this->uploadPic($show_pic['tmp_name'][0], 'articlehot'),
                "show_index" => $show_index[0],
                "created" => time(),
            );      
                $a = $this->indexbanner->insert();

        }
        $this->template($template_name);
    }

    function doEdit() {
        if ($_POST) {
            $show_enable = $this->postValue('show_enable')->Val();
            $show_title = $this->postValue('show_title')->Val();
            $show_index = $this->postValue('show_index')->Val();
            $channel_index = $this->postValue('channel_index')->Val();
            $show_url = $this->postValue('show_url')->Val();
            $show_pic = $this->postValue('show_pic')->Val();
            $created = $this->postValue('created')->Val();
                      
            if ($show_title) {
                foreach ($show_title as $k => $v) {
                    $date['show_enable'] = intval($show_enable[$k]);
                    $date['show_index'] = $show_index[$k];
                    $date['show_title'] = $show_title[$k];
                    $date['channel_index'] = $channel_index[$k];
                    $date['channel_name'] = $channel_name[$k];
                    $date['show_url'] = $show_url[$k];
                    $data['show_pic'] = $show_pic[$k];
                    $date['updated'] = time();
                    
                    $this->indexbanner->where = "created='$created[$k]'";
                    $this->indexbanner->ufields = $date;
                    $update_staet= $this->indexbanner->update();
                    
                }
            }
            if($update_staet){
                    $this->alert('提交成功!', 'js', 3, $_ENV['PHP_SELF']);
            }else{
                echo "更新失败!";
            }
        }
    }

    function doDel() {
       $id = $this->getValue('id')->Int();
        $this->indexbanner->where = "id='{$id}'";
        $ret = $this->indexbanner->del();
        $msg = "删除";
        if ($ret) {
            $msg .= "成功！";
        } else {
            $msg .= "失败！";
        }
        $message = array(
            'type' => 'js',
            'act' => 3,
            'message' => $msg,
            'url' => $_ENV['PHP_SELF']
        );
        $this->alert($message);
        
    }

    function checkAuth() {
        
    }
    
        /**
     * 生成首页及频道页面的轮播SSI文件
     * type编号说明：1="banner_index",2="banner_news",3="banner_pingce",4="banner_video",5="banner_wenhua"
     * 
     * @global type $local_host 站点的url，带http://
     */
    function domake() {
        global $local_host;
        $this->checkAuth(207);
        $id = $this->postValue('id')->Val();
        if($id){
            $id = implode(',',$id);
            $where = "id in ($id)";
            $fields = "*";
            $banner = $this->indexbanner->getList($where, $fields, 2);
            $tplName = 'ssi_banner_bannerpic_index';
            $fileName = WWW_ROOT . 'ssi/ssi_banner_bannerpic_index.shtml';

            $this->vars("banner", $banner);
            $html = $this->fetch($tplName);
            $html = str_replace($local_host, '', $html);
            $html = replaceArticleUrl($html);
            $html = replaceVideoUrl($html);
            $html = preg_replace('/href="(.+?)\.html([^\'">]+)/im', 'href="\1.html', $html);

            //生成文件
            $length = file_put_contents($fileName, $html);  
            if (empty($length)) {   
                echo 0;
            } else {
                $this->alert('生成成功!', 'js', 3, $_ENV['PHP_SELF']);
            }
        }
    
    }

    function doArticleHeader() {
        $template_name = "article_header";
        $html = $this->fetch($template_name);
        $html = replaceNewsChannel($html);
        echo $html;
    }

     
    //上传文章所需图片
    function doajaxBannerPic() {
        if ($_FILES['show_pic']) {
            $pic = $_FILES['show_pic'];
        }
        if ($pic['size']) {
            $pic_name = $pic['tmp_name'];
            $pic_path = $this->uploadPic($pic_name, 'articletitle');
            if ($pic_path) {
                echo json_encode($pic_path);
            } else {
                echo 1;
            }
        }
    }
    
    /**
     * 上传图片
     * @param type $file 上传的临时文件
     * @param type $dir 上传目录
     * @return type  $file_name. $fileName 图片地址名称
     */
    function uploadPic($file, $dir = 'articlehot') {
        global $watermark_opt;
        $uploadRootDir = ATTACH_DIR . "images/$dir/";
        file::forcemkdir($uploadRootDir);
        $uploadDir = $uploadRootDir . date("Y/m/d") . '/';
        file::forcemkdir($uploadDir);
        $file_name = "images/$dir/" . date("Y/m/d") . '/';
        $fileName = util::random(12);
        $fileName .= '.jpg';
        move_uploaded_file($file, $uploadDir . $fileName);

        if ($dir == 'articlehot') {
            imagemark::resize($uploadDir . $fileName, "820x550", 820, 550, '', $watermark_opt);
            imagemark::resize($uploadDir . $fileName, "344x258", 344, 258, '', $watermark_opt);
            imagemark::resize($uploadDir . $fileName, "280x186", 280, 186, '', $watermark_opt);
            imagemark::resize($uploadDir . $fileName, "160x120", 160, 120, '', $watermark_opt);
        } else {
            imagemark::resize($uploadDir . $fileName, "1180x400", 1180, 400, '', $watermark_opt);
        }
        return $file_name . $fileName;
    }

    function doArticlePicList() {
        $type_id = $this->getValue('id')->Int();
        $piclist = $this->cardbfile->getlist("id,name,DATE_FORMAT(FROM_UNIXTIME(created), '%Y/%m/%d') as created", "type_id='{$type_id}'", 2);
        echo json_encode($piclist);
    }

    function doPic() {
        $a = $this->article->getArticle($this->getValue('id')->Int());
        $pic = RELAT_DIR . "attach/images/banner/" . date('Ym', $a['created']) . "/" . date('d', $a['created']) . "/" . $a['pic'];
        echo "<img src='{$show_pic}', width='200'>";
        exit;
    }
    
     function doajaxarticle() {
        $this->checkAuth(201);
        $id = $this->getValue('id')->Int();
        $article = $this->article->getArticleFields("id,title,uptime,pic,title2,type_id", "id=$id", 1);
        if ($article) {
            if ($article['type_id'] == 1) {
                $article['type'] = '文章';
            } else {
                $article['type'] = '视频';
            }
            $article['day'] = date("Y-m-d", $article['uptime']);
            echo json_encode($article);
        } else {
            echo -1;
        }
    }
}

?>
