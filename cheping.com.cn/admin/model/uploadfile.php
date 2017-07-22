<?php

/**
 * upload
 * $Id: uploadfile.php 2709 2016-05-19 04:20:45Z david $
 * @author David.Shaw
 */
class uploadFile extends model {

    var $upload_dir;
    var $video_category = array(
        '事件',
        '花边',
        '新车',
        '试车',
        '技术',
        '广告',
        '其它',
    );
    var $video_pic_size = array(
        /* '140x80', */
        '320x240',
        '430x325',
        '110x62',
        '480x360',
        '170x95',
    );
    var $pic_type = array(
        1 => '车身外观',
        2 => '车厢座椅',
        3 => '其他细节',
        4 => '中控方向盘',
    );
    var $pic_size = array(
        /*
          '80x45',
          '770x430',
          '140x80',
          '180x100',
          '440x250',
          '236x132',
          '170x65',
          '120x68',
         */
        '304x227',
        '122x93',
        '800x600',
        '160x120',
        '190x142',
        '242x180',
    );
    var $style_size = array(
        '80x45',
        '140x80',
        '180x100',
        '190x142',
        '136x132',
        '120x68',
        '122x93',
        '160x120',
        '240x180',
    );
    var $series_size = array(
        '180x100',
        '140x80',
        '160x120',
        '190x142',
        '130x73',
        '122x93',
    );

    function __construct() {
        global $upload_basedir;
        parent::__construct();
        $this->table_name = "cardb_file";
        $this->upload_dir = $upload_basedir;
        if (!$this->timestamp)
            $this->timestamp = time();
    }

    function uploadBrandLogo($file) {
        $type_id = $file['type_id'];
        $type_name = $file['type_name'];
        if (!$type_id)
            return false;

        $sub_dir = "logo/";
        $upload_dir = ATTACH_DIR . "images/brand/" . $sub_dir;

        $file_ext = file::extname($file['name']);
        $filename = util::Pinyin($type_name, 2) . "." . $file_ext;
        @file::forcemkdir($upload_dir);
        @move_uploaded_file($file['tmp_name'], $upload_dir . $filename);
        return file_exists($upload_dir . $filename) ? $sub_dir . $filename : false;
    }

    function uploadBrandPic($file) {
        $type_name = $file['type_name'];
        $sub_dir = date('Ym', $this->timestamp) . "/" . date('m', $this->timestamp) . "/";
        $upload_dir = ATTACH_DIR . "images/{$type_name}/" . $sub_dir;

        $file_ext = file::extname($file['name']);
        $filename = util::random(16, 3) . "." . $file_ext;
        @file::forcemkdir($upload_dir);
        @move_uploaded_file($file['tmp_name'], $upload_dir . $filename);

        if ($file['thumb_size']) {
            $thump_size = $file['thumb_size'];
            list($width, $height) = explode('x', $thump_size);
            imagemark::resize($upload_dir . $filename, $thump_size, $width, $height, '', $watermark_opt);
        }
        return file_exists($upload_dir . $filename) ? $sub_dir . ($file['thumb_size'] ? $file['thumb_size'] : "") . $filename : false;
    }

    function uploadCmsFile($file) {
        $attach_dir = ATTACH_DIR . 'images/';
        $type = 'article';
        $sFileName = $file['name'];
        $sExtension = file::extname($sFileName);

        $sOriginalFileName = $sFileName;
        $dFileName = util::random(16) . "." . $sExtension;
        if (empty($file['created'])) {
            $created = time();
        } else {
            $created = $file['created'];
        }

        $sDate = date('Ym', $created) . '/' . date('d', $created);
        $attach_dir .= $type . '/' . $sDate . '/';
        file::forcemkdir($attach_dir);

        $image_url = UPLOAD_DIR . 'images/' . $type . '/' . $sDate . '/' . $dFileName;
        $sFilePath = $attach_dir . $dFileName;
        @move_uploaded_file($file['tmp_name'], $sFilePath);

        imagemark::resize($sFilePath, "305x220", 305, 220, '', 1);
        imagemark::resize($sFilePath, "180x100", 180, 100, '', 1);
        imagemark::resize($sFilePath, "188x140", 188, 140, '', 1);
        return $dFileName ? $dFileName : false;
    }

    function uploadSeriesPic($file) {
        $series_obj = new series();
        if ($file['model_id']) {
            $series_obj->table_name = "cardb_model";
            $series_obj->where = "model_id='{$file['model_id']}'";
            $series_obj->fields = "series_id";
            $file['series_id'] = $series_id = $series_obj->getResult(3);
            $series_obj->reset();
        }
        $series_obj->table_name = "cardb_series";
        $series_obj->where = "series_id='{$file['series_id']}'";
        $series_obj->fields = "series_pic";
        $series_pic = $series_obj->getResult(3);

        if (empty($series_pic)) {
            $r = $this->uploadPicFromModel($file);
            if ($r) {
                $series_obj->ufields = array(
                    'series_pic' => $r,
                );
                $series_obj->where = "series_id='{$file['series_id']}'";
                $ret = $series_obj->update();
            }
            return $r;
        } else {
            return $series_pic;
        }
    }

    /**
     * 上传车款实拍图压缩包
     * 压缩包格式：zip
     * 压缩名命名：m+{车款ID}.zip
     * error code: -1 => 目录无写权限，-2 => 目录不存在
     * 
     * @param mixed $file
     * @return bool
     */
    function uploadModelZip($file) {
        $dir = FTP_DIR;

        if (!is_writeable($dir)) {
            return -1;
        }

        if (!is_dir($dir)) {
            file::forcemkdir($dir);
        }

        $model_id = $file['type_id'];
        $r = move_uploaded_file($file['tmp_name'], $dir . 'm' . $model_id . ".zip");
        if (!$r || !file_exists($dir . 'm' . $model_id . ".zip")) {
            error_log("model_id:" . $file['type_id'] . " upload error(" . $dir . 'm' . $model_id . ".zip" . ")\n", 3, SITE_ROOT . "upload_err.log");
        }
        return $r;
    }

    function uploadPicFromModel($file) {
        $sub_dir = "images/series/{$file['series_id']}/";
        $upload_dir = ATTACH_DIR . $sub_dir;
        if (!is_dir($upload_dir)) {
            file::forcemkdir($upload_dir);
        }

        $file_ext = file::extname($file['name']);
        $filename = util::random(16, 3) . "." . $file_ext;
        @copy($file['tmp_name'], $upload_dir . $filename);

        #生成缩略图
        foreach ($this->series_size as $k => $v) {
            list($width, $height) = explode('x', $v);
            util::image_compress($upload_dir . $filename, $v, $width, $height, '');
        }

        return file_exists($upload_dir . $filename) ? $filename : false;
    }

    /**
     * 上传首页焦点车系图。
     * 使用cardb_series表中的series_pic2字段
     * 
     * @param mixed $file
     * @return bool
     */
    function uploadSeriesFoucsPic($file) {
        global $watermark_opt;
        $sub_dir = "images/series/{$file['series_id']}/";
        $upload_dir = ATTACH_DIR . $sub_dir;
        if (!is_dir($upload_dir)) {
            file::forcemkdir($upload_dir);
        }

        $file_ext = file::extname($file['name']);
        $filename = util::random(16, 3) . "." . $file_ext;
        @move_uploaded_file($file['tmp_name'], $upload_dir . $filename);

        #生成缩略图
        foreach ($this->series_size as $k => $v) {
            list($width, $height) = explode('x', $v);
            #util::image_compress($upload_dir . $filename, $v, $width, $height, '');
            imagemark::resize($upload_dir . $filename, $v, $width, $height, '', $watermark_opt);
        }

        return file_exists($upload_dir . $filename) ? $filename : false;
    }

    /**
     * 将车系外观拷贝到车款
     * @param $type 0外观白底图，1外观实拍图
     */
    function copyStylePic($sid, $mid, $st, $date_id = 0, $type = 0) {
        global $watermark_opt;
        $series_obj = new series();
        $st4 = array_search($st['st4'], $series_obj->st4_list);
        $st21 = array_search($st['st21'], $series_obj->st21_list);
        $stylepic = $this->getStylePic($sid, $st4, $st21, $date_id, $type);

        if (empty($stylepic['name']) || !file_exists(ATTACH_DIR . "images/series/{$sid}/{$stylepic['name']}")) {
            return false;
        } else {
            $seriespic_path = ATTACH_DIR . "images/series/" . $sid . "/";
            $modelpic_path = ATTACH_DIR . "images/model/" . $mid . "/";
            if (!is_dir($modelpic_path)) {
                file::forcemkdir($modelpic_path);
            }

            if (!file_exists($seriespic_path . $stylepic['name'])) {
                return false;
            } else {
                copy($seriespic_path . $stylepic['name'], $modelpic_path . $stylepic['name']);
                foreach ($this->style_size as $k => $v) {
                    if(file_exists($seriespic_path . $v . $stylepic['name'])){
                        copy($seriespic_path . $v . $stylepic['name'], $modelpic_path . $v . $stylepic['name']);
                    }else{
                        list($width, $height) = explode('x', $v);
                        imagemark::resize($seriespic_path . $stylepic['name'], $v, $width, $height, '', $watermark_opt);
                        imagemark::resize($modelpic_path . $stylepic['name'], $v, $width, $height, '', $watermark_opt);
                        #@copy($seriespic_path . $v . $stylepic['name'], $modelpic_path . $v . $stylepic['name']);
                    }
                }

                #返回图片，用于更新车款表
                return $stylepic['name'];
            }
        }
    }

    /**
     * 上传车款外面图
     * 
     * <b>$file数组元素示例：</b>
     * <pre>
        $file = $_FILES[$k];#图片文件数组
        $file['series_id'] = $series_id;
        $file['st4'] = $tmp[$k]['st4'];
        $file['st4_str'] = $this->series->st4_list[$file['st4']];
        $file['st21'] = $tmp[$k]['st21'];
        $file['date_id'] = $tmp[$k]['date_id'];
        $file['st21_str'] = $this->series->st21_list[$file['st21']];
     * </pre>
     * @param int $type 1外观白底，2外观实拍
     * @param mixed $file
     */
    function uploadStylePic($file, $type = 1) {
        global $watermark_opt;

        $sub_dir = "images/series/{$file['series_id']}/";
        $upload_dir = ATTACH_DIR . $sub_dir;
        if (!is_dir($upload_dir)) {
            file::forcemkdir($upload_dir);
        }

        $file_ext = file::extname($file['name']);
        #$filename = "style_{$file['st4']}_{$file['st21']}." . $file_ext;
        $filename = util::random(16, 3) . "." . $file_ext;
        @move_uploaded_file($file['tmp_name'], $upload_dir . $filename);

        #生成缩略图
        foreach ($this->style_size as $k => $v) {
            list($width, $height) = explode('x', $v);
            #util::image_compress($upload_dir . $filename, $v, $width, $height, '');
            imagemark::resize($upload_dir . $filename, $v, $width, $height, '', $watermark_opt);
        }
        
        #插入 "cardb_file" 表
        if ($type == 1)
            $r = $this->getStylePic($file['series_id'], $file['st4'], $file['st21'], $file['date_id']);
        else
            $r = $this->getOneUploadFile("type_name='stylepic' and type_id='{$file['series_id']}' and pos='{$file['st4']}' and ppos='{$file['st21']}' and s1='{$file['date_id']}'");
        if (!empty($r)) {
            if ($type == 1)
                $this->where = "type_name='style' and type_id='{$file['series_id']}' and pos='{$file['st4']}' and ppos='{$file['st21']}' 
        and s1='{$file['date_id']}'";
            else
                $this->where = "type_name='stylepic' and type_id='{$file['series_id']}' and pos='{$file['st4']}' and ppos='{$file['st21']}' 
        and s1='{$file['date_id']}'";
            $this->ufields = array(
                'name' => $filename,
                'updated' => $this->timestamp,
            );
            $r = $this->update();
        } else {
            $this->ufields = array(
                'name' => $filename,
                'type_name' => $type == 1 ? 'style' : 'stylepic',
                'type_id' => $file['series_id'],
                'file_type' => $file_ext,
                'pos' => $file['st4'],
                'ppos' => $file['st21'],
                's1' => $file['date_id'],
                'created' => $this->timestamp,
                'updated' => $this->timestamp,
            );
            
            $r = $this->insert();
        }
        #更新到车系外观数据表
        $style_obj = new seriesStyle();
        $style_obj->updateStyle(
                        array(
                            'series_id' => $file['series_id'],
                            'st4' => $file['st4'],
                            'st21' => $file['st21'],
                            'st15' => '',
                            'date' => $file['date_id'],
                            'pic' => $filename,
                            'type' => $type == 1 ? 0 : 1,
                        )
                    );

        #处理同外观下的车款图片
        $model_obj = new cardbModel();
        $modelpic_pre = ATTACH_DIR . "images/model/";

        if ($type == 1) {
            $model = $model_obj->getSimpleModel(
                    "series_id='{$file['series_id']}' and (state=3 or state=8 or state=7) and st4='{$file['st4_str']}' and st21='{$file['st21_str']}' and date_id='{$file['date_id']}' and model_pic1=''", 100
            );
        } else {
            $model = $model_obj->getSimpleModel(
                    "series_id='{$file['series_id']}' and (state=3 or state=8 or state=7) and st4='{$file['st4_str']}' and st21='{$file['st21_str']}' and date_id='{$file['date_id']}'", 100
            );
        }

        foreach ($model as $mk => $mv) {
            $modelpic_dir = $modelpic_pre . $mv['model_id'] . "/";
            if (!is_dir($modelpic_dir)) {
                file::forcemkdir($modelpic_dir);
            }

            #拷贝到车款目录
            @copy($upload_dir . $filename, $modelpic_dir . $filename);
            foreach ($this->style_size as $k => $v) {
                @copy($upload_dir . $v . $filename, $modelpic_dir . $v . $filename);
            }

            #更新到model_pic2字段
            if ($type == 1) {
                $model_obj->ufields = array(
                    'model_pic2' => $filename,
                    'updated' => $this->timestamp,
                );
            } else {
                $model_obj->ufields = array(
                    'model_pic1' => $filename,
                    'updated' => $this->timestamp,
                );
            }
            $model_obj->where = "model_id='{$mv['model_id']}'";
            $r = $model_obj->update();
        }
        return $r;
    }

    /**
     * 首页焦点，转播图
     * 
     * @param mixed $file
     */
    function uploadIndexFoucsPic($file) {
        global $watermark_opt;
        $sub_dir = "images/series/{$file['series_id']}/";
        $upload_dir = ATTACH_DIR . $sub_dir;
        if (!is_dir($upload_dir)) {
            file::forcemkdir($upload_dir);
        }

        $file_ext = file::extname($file['name']);
        $filename = util::random(16, 3) . "." . $file_ext;
        @move_uploaded_file($file['tmp_name'], $upload_dir . $filename);

        #生成缩略图
        $thump_size = "450x337";
        list($width, $height) = explode('x', $thump_size);
        imagemark::resize($upload_dir . $filename, $thump_size, $width, $height, '', $watermark_opt);

        return file_exists($upload_dir . $thump_size . $filename) ? $thump_size . $filename : false;
    }

    /**
     * 关联车系图片
     * 
     * @param mixed $zip
     */
    function unionSeriesPic($id) {
        #此方法已弃用
        return false;
        global $watermark;
        $wm = SITE_ROOT . 'images/watermark/watermark.png';

        #sleep(2);echo 1;exit;
        set_time_limit(0);
        $zip = new ZipArchive;

        $zip_file = FTP_DIR . "s{$id}.zip";
        if (!file_exists($zip_file)) {
            #echo "$zip_file file not found!";
            echo 0;
        } else {
            #判断是否zip文件
            if ($zip->open($zip_file) === TRUE) {
                $tmp_dir = FTP_DIR . util::random(8) . "/";
                @file::forcemkdir($tmp_dir);

                $zip->extractTo($tmp_dir);
                $zip->close();

                #判断，生成目标目录
                $series_dir = ATTACH_DIR . "images/series/{$id}/";
                @file::forcemkdir($series_dir);

                #生成缩略图到指定目录
                foreach ($this->pic_type as $k => $v) {
                    foreach (glob($tmp_dir . "{$k}/*.jpg") as $filename) {
                        #echo $filename . "<br>\n";
                        $fileinfo = @pathinfo($filename);
                        if ($fileinfo['basename'] == "1.jpg") {
                            $ppos = 1;
                        } else {
                            $ppos = 0;
                        }

                        $file_ext = $fileinfo['extension'];
                        $dfilename = util::random(16, 3) . "." . $file_ext;
                        @copy($filename, $series_dir . $dfilename);

                        foreach ($this->pic_size as $kk => $vv) {
                            if ($kk > 1 && !$ppos)
                                break;
                            list($width, $height) = explode('x', $vv);
                            util::image_compress($series_dir . $dfilename, $vv, $width, $height, '');
                            #加水印
                            if ($watermark && $vv == "770x430") {
                                util::watermark($wm, $series_dir . $vv . $dfilename, 2, 5, 147, 12);
                            }
                        }

                        #图片信息入库
                        $this->ufields = array(
                            'name' => $dfilename,
                            'file_type' => 'jpg',
                            'type_name' => 'series',
                            'type_id' => $id,
                            'pos' => $k,
                            'ppos' => $ppos,
                            'created' => $this->timestamp,
                            'updated' => $this->timestamp,
                        );
                        $t = $this->insert();
                    }
                }
                @file::cleardir(substr($tmp_dir, 0, -1), true);
                @rmdir($tmp_dir);
                echo 1;
            } else {
                echo 0;
            }
        }
    }

    /**
     * 关联车款图片
     * s1 => 车系ID
     * @param mixed $mid
     * @param ZipArchive $zip
     */
    function unionModelPic($id, $ret = false) {
        global $watermark, $watermark_opt;
        $wm = SITE_ROOT . 'images/watermark/watermark.png';

        #sleep(2);echo 1;exit;
        set_time_limit(0);
        $zip = new ZipArchive;

        $zip_file = FTP_DIR . "m{$id}.zip";
        if (!file_exists($zip_file)) {
            #echo "$zip_file file not found!";
            $code = -1;
        } else {
            #判断是否zip文件
            if ($zip->open($zip_file) === TRUE) {
                $model_obj = new cardbModel();
                $m_series = $model_obj->getModel($id);
                $series_id = $m_series['series_id'];

                $tmp_dir = FTP_DIR . util::random(8) . "/";

                file::forcemkdir($tmp_dir);
                $zip->extractTo($tmp_dir);
                $zip->close();

                #判断，生成目标目录
                $model_dir = ATTACH_DIR . "images/model/{$id}/";
                @file::forcemkdir($model_dir);

                #生成缩略图到指定目录
                $ppos_filename = array(
                    '1',
                    '2',
                    '3',
                    '4',
                );
                foreach ($this->pic_type as $k => $v) {
                    #每个子文件夹下图片计数器
                    $pic_count = 0;
                    $other_ppos = 5;
                    foreach (glob($tmp_dir . "{$k}/*.*") as $filename) {
                        #echo $filename . "<br>\n";
                        $fileinfo = @pathinfo($filename);
                        $file_ext = strtolower($fileinfo['extension']);
                        if ($file_ext != 'jpg')
                            continue;
                        if (in_array($fileinfo['filename'], $ppos_filename)) {
                            $ppos = intval($fileinfo['filename']);
                        } else {
                            $ppos = $other_ppos;
                            $other_ppos++;
                        }

                        #车系图
                        if ($ppos == 1 && $k == 1) {
                            $file['model_id'] = $id;
                            $this->uploadSeriesPic(
                                    array(
                                        'model_id' => $file['model_id'],
                                        'name' => '1.jpg',
                                        'tmp_name' => $filename,
                                    )
                            );
                        }

                        #$file_ext = $fileinfo['extension'];
                        $dfilename = util::random(16, 3) . "." . $file_ext;
                        @copy($filename, $model_dir . $dfilename);
                        @copy($filename, $model_dir . '770x430' . $dfilename);
                        imagemark::waterMark(
                                $model_dir . '770x430' . $dfilename, array(
                            'type' => 'file',
                            'file' => $wm,
                                ), 3, 5, $watermark_opt
                        );
                        foreach ($this->pic_size as $kk => $vv) {
                            if ($kk > 1 && !$ppos) {
                                break;
                            }
                            list($width, $height) = explode('x', $vv);
                            #util::image_compress($model_dir . $dfilename, $vv, $width, $height, '');
                            imagemark::resize($model_dir . $dfilename, $vv, $width, $height, '', $watermark_opt);
                            #加水印
                            /*
                              if($watermark && $vv == "770x430"){
                              util::watermark($wm, $model_dir . $vv . $dfilename, 2, 5, 147, 12);
                              }
                             */
                        }

                        #图片信息入库
                        $this->ufields = array(
                            'name' => $dfilename,
                            'file_type' => 'jpg',
                            'type_name' => 'model',
                            'type_id' => $id,
                            'pos' => $k,
                            'ppos' => $ppos,
                            's1' => $series_id, /* 车款对应的车系ID */
                            'created' => $this->timestamp,
                            'updated' => $this->timestamp,
                        );
                        $t = $this->insert();

                        #图片计数器+1
                        if ($t)
                            ++$pic_count;
                    }#图片子文件夹处理结束
                    
                    if(0){//cardb_model表的pictype1 - pictype4已删除，功能作废
                    #将子文件夹下的图片数入库, s2 => 对应分类（pos）下的图片总数
                    $model_obj->ufields = array(
                        "pictype{$k}" => $pic_count,
                    );
                    $model_obj->where = "model_id='{$id}'";
                    $sr = $model_obj->update();
                    }
                }

                #更新series's last_picid
                $series_obj = new series();
                if (!empty($m_series)) {
                    $s_series = $series_obj->getSeries($m_series['series_id']);
                    if (!$s_series['last_picid']) {
                        $series_obj->ufields = array(
                            'last_picid' => $id
                        );
                        $series_obj->where = "series_id='{$m_series['series_id']}'";
                        $ut = $series_obj->update();

                        #更新last_picid 失败
                        if (!$ut)
                            $code = -3;
                    }

                    #更新车款表中的图片关联状态unionpic=1
                    $model_obj->ufields = array(
                        'unionpic' => 1
                    );
                    $model_obj->where = "model_id='{$id}'";
                    $r = $model_obj->update();
                }

                #$zip->close();
                @file::cleardir(substr($tmp_dir, 0, -1), true);
                @rmdir($tmp_dir);
                $code = 1;
            } else {
                $code = -2;
            }
        }

        if ($ret) {
            return $code;
        } else {
            echo $code;
        }
    }

    function uploadCarPic($file) {
        global $watermark_opt;
        $type_name = $file['type_name'];
        $type_id = $file['type_id'];
        if (!$type_name || !$type_id)
            return false;

        #$sub_dir = date('Ym', $this->timestamp) . "/" . date('m', $this->timestamp) . "/";
        $upload_dir = ATTACH_DIR . "images/{$type_name}/{$type_id}/" . $sub_dir;

        $file_ext = file::extname($file['name']);
        $filename = util::random(16, 3) . "." . $file_ext;
        @file::forcemkdir($upload_dir);
        @move_uploaded_file($file['tmp_name'], $upload_dir . $filename);

        foreach ($this->style_size as $k => $v) {
            list($width, $height) = explode('x', $v);
            imagemark::resize($upload_dir . $filename, $v, $width, $height, '', $watermark_opt);
        }

        return file_exists($upload_dir . $filename) ? $sub_dir . $filename : false;
    }

    /**
     * 上传车辆颜色图片
     * 
     * @param mixed $file
     */
    function uploadColorPic($file) {
        global $watermark_opt;

        //if(!$type_name || !$type_id) return false;
        #$sub_dir = date('Ym', $this->timestamp) . "/" . date('m', $this->timestamp) . "/";
        $upload_dir = ATTACH_DIR . "images/color/";
        //$file_ext = file::extname($file['name']);

        $filename = util::Pinyin($file['name'], 2) . strrchr($file['name'], '.');
        @file::forcemkdir($upload_dir);
        @move_uploaded_file($file['tmp_name'], $upload_dir . $filename);
        return file_exists($upload_dir . $filename) ? $filename : false;
    }

    function uploadAdPic($file) {
        $sub_dir = "carouselpic/" . date('Ym') . "/" . date("Ymd") . "/";
        $upload_dir = ATTACH_DIR . "images/" . $sub_dir;
        $file_ext = file::extname($file['name']);
        $filename = util::random(16, 3) . "." . $file_ext;
        @file::forcemkdir($upload_dir);
        @move_uploaded_file($file['tmp_name'], $upload_dir . $filename);
        return file_exists($upload_dir . $filename) ? $sub_dir . $filename : false;
    }

    /**
     * 上传视频图片
     * 
     * @param array $file,  require type_id
     * @return int
     */
    function uploadVideoPic($file) {
        $type_name = 'videopic';
        $type_id = $file['type_id'];
        $sub_dir = date('Ym', $this->timestamp) . "/" . date('d', $this->timestamp) . "/";
        $upload_dir = ATTACH_DIR . "images/{$type_name}/" . $sub_dir;
        $file_ext = file::extname($file['name']);
        $filename = util::random(16, 3) . "." . $file_ext;
        @file::forcemkdir($upload_dir);
        @move_uploaded_file($file['tmp_name'], $upload_dir . $filename);

        #insert into cardb_pic
        $this->ufields = array(
            'name' => $filename,
            'file_type' => $file_ext,
            'type_id' => $type_id,
            'created' => $this->timestamp,
            'updated' => $this->timestamp,
        );

        foreach ($this->video_pic_size as $k => $v) {
            list($width, $height) = explode('x', $v);
            util::image_compress($upload_dir . $filename, $v, $width, $height, '');
        }

        $this->where = "type_id='{$type_id}' and file_type='{$file_ext}'";
        $this->fields = "count(id)";
        $cnt = $this->getResult(3);
        if ($cnt) {
            $ret = $this->update();
        } else {
            $ret = $this->insert();
        }
        return $ret;

        #return file_exists($upload_dir . $filename) ? $sub_dir . $filename : false;
    }

    function getFiles($where = '1', $order = array(), $limit = 1, $offset = 0) {
        
    }

    function getVideo($where = '1', $order = array(), $limit = 1, $offset = 0) {
        $this->tables = array(
            'f' => 'cardb_file',
            's' => 'cardb_series',
        );

        $this->where = "f.type_id=s.series_id and f.type_name='seriesvideo' and s.state=3 and " . $where;
        $this->fields = "count(f.id)";
        $this->total = $this->joinTable(3, 1);

        $this->order = $order;
        $this->limit = $limit;
        $this->offset = $offset;
        $this->fields = "f.*, s.series_name,s.brand_name,s.factory_name";

        $ret = $this->joinTable(2, 1);
        return $ret;
    }

    function getFile($id) {
        $this->fields = "*";
        $this->where = "id='{$id}'";
        return $this->getResult();
    }

    function getVideoPic($id) {
        $this->fields = "*";
        $this->where = "type_id='{$id}' and file_type='jpg'";
        return $this->getResult();
    }

    /**
     * 取车系外观图片
     * @param $id 车系ID
     * @param $pos st4
     * @param $ppos $st21
     * @param $type 1外观实拍图，0外观白底图
     * return array
     */
    function getStylePic($id, $pos = 1, $ppos = 1, $date = 0, $type = 0) {
        $type_name = $type ? "stylepic" : "style";
        $this->where = "type_name='{$type_name}' and type_id='{$id}'" . ($pos ? " and pos='{$pos}'" : "")
                . ($ppos ? " and ppos='{$ppos}'" : "") . ($date ? " and s1='{$date}'" : "");
        $this->fields = "*";
        #$this->order = array('id' => 'desc');
        return $this->getResult();
    }

    /**
     * 取车系图片
     * 
     * @param mixed $id
     * @param mixed $pos 0表示所有分类
     * @param mixed $ppos 0表示忽略此字段
     */
    function getSeriesPic($id, $pos = 1, $ppos = 1) {
        $this->where = "type_name='series' and type_id='{$id}'" . ($pos ? " and pos='{$pos}'" : "") . ($ppos ? " and ppos='{$ppos}'" : "");
        $this->fields = "*";
        return $this->getResult();
    }

    function getAllSeriesPic($id, $pos = 1) {
        $this->where = "type_name='series' and type_id='{$id}'" . ($pos ? " and pos='{$pos}'" : "");
        $this->fields = "*";
        return $this->getResult(2);
    }

    function getSeriesPicByMid($mid, $pos = 1, $ppos = 1) {
        if (empty($mid))
            return false;

        $this->where = "type_name='model' and (";
        foreach ($mid as $k => $v) {
            if ($k)
                $this->where .= " or ";
            $this->where .= " type_id='{$v}'";
        }
        $this->where .= " )" . ($pos ? " and pos='{$pos}'" : "") . ($ppos ? " and ppos='{$ppos}'" : "") . " order by id desc";
        $this->fields = "*";
        return $this->getResult();
    }

    /**
     * 取车款图片
     * 
     * @param mixed $id
     * @param mixed $pos 0表示忽略此字段
     * @param mixed $ppos 0表示忽略此字段
     */
    function getModelPic($id, $pos = 1, $ppos = 1) {
        $this->where = "type_name='model' and type_id='{$id}'" . ($pos ? " and pos='{$pos}'" : "") . ($ppos ? " and ppos='{$ppos}'" : "");
        $this->fields = "*";
        return $this->getResult();
    }

    function getAllModelPic($id, $pos = 1, $extra = false, $limit = 0) {
        $this->where = "type_name='model' and type_id='{$id}'" . ($pos ? " and pos='{$pos}'" : "")
                . ($extra ? "" : " and ppos<900");
        $this->fields = "*";
        $this->order = array('pos' => 'asc', 'ppos' => 'asc');
        if($limit) $this->limit = $limit;
        return $this->getResult(2);
    }

    /**
     * 返回车款实拍图位置编号1的图片数
     * 用于检验车款实拍图四个分类是否齐全
     * 
     * @param type $id
     * @return type
     */
    function getModelFousPicNum($id) {
        $this->where = "type_name='model' and type_id='{$id}' and ppos='1' and ppos<900";
        $this->fields = "count(*)";
        return $this->getResult(3);
    }

    function checkUnion($id, $type) {
        $this->where = "type_name='{$type}' and type_id='{$id}'";
        $this->fields = "id";
        return $this->getResult(3);
    }

    function delUnionPic($id, $type = 'model') {
        $dir_pre = ATTACH_DIR . 'images/model/' . $id . '/';

        #先删除图片
        $model_pic = $this->getAllModelPic($id);
        $txt = '';
        foreach ($model_pic as $k => $v) {
            #删除原图片
            @unlink($dir_pre . $v['name']);
            @unlink($dir_pre . '770x430' . $v['name']);

            #删除缩略图
            foreach ($this->pic_size as $pv) {
                @unlink($dir_pre . $pv . $v['name']);
            }
        }

        $this->limit = 1500;
        $this->where = "type_name='{$type}' and type_id='{$id}'";
        $ret = $this->del();

        #del pic files
        #@file::cleardir(ATTACH_DIR . 'images/' . $type . '/' . $id);
        return $ret;
    }

    //上传壁纸品牌logo
    function uploadWp_BrandLogo($file) {
        $brand_name = $file['brand_name'];
        if (!$brand_name)
            return false;

        $sub_dir = "wp_brand_logo/";
        $upload_dir = ATTACH_DIR . $sub_dir;

        $file_ext = file::extname($file['name']);
        $filename = $brand_name . "." . $file_ext;
        @file::forcemkdir($upload_dir);
        @move_uploaded_file($file['tmp_name'], $upload_dir . $filename);
        return file_exists($upload_dir . $filename) ? $filename : false;
    }

    //上传壁纸品牌主图
    function uploadWp_Brandpic($file) {
        $brand_id = $file['brand_id'];
        if (!$brand_id)
            return false;

        $sub_dir = "wp_small/upload_brand_pic/";
        $upload_dir = ATTACH_DIR . $sub_dir;

        $file_ext = file::extname($file['name']);
        $filename = "brand_pic_" . $brand_id . "." . $file_ext;
        @file::forcemkdir($upload_dir);
        @move_uploaded_file($file['tmp_name'], $upload_dir . $filename);
        $src = array("src" => $file['tmp_name'], "dest" => $upload_dir);
        imagemark::resize($src, "126x93" . $filename, 126, 93, $strip_str, 1);
        imagemark::resize($src, "185x139" . $filename, 185, 139, $strip_str, 1);
        imagemark::resize($src, "440x580" . $filename, 440, 580, $strip_str, 1);
        imagemark::resize($src, "130x97" . $filename, 130, 97, $strip_str, 1);
        imagemark::resize($src, "770x577" . $filename, 770, 577, $strip_str, 1);
        return file_exists($upload_dir . $filename) ? $filename : false;
    }

    /**
     * 重新生成指定类型，指定车的缩略图
     * 
     * @param mixed $type 图片类型，车系图(srpic)/外观图(stpic)/车款实拍图(pic)
     * @param mixed $id 指定车的ID，车系ID(车系图和外观图)/车款ID(实拍图)
     * @return boolean ture/false
     */
    function reThumbCarPic($type, $id) {
        global $watermark_opt;

        $model_obj = new cardbModel();
        $series_obj = new series();
        $ret_stat = array(
            'stylecount' => 0, //要处理的总外观数
            'modelcount' => 0, //要处理的总车款数
            'modelcount_ext' => 0, //单独上传过车款图的车款数
            'ok' => 0,
            'err' => 0,
        );

        switch ($type) {
            #外观图
            case 'stpic':
                #取车系下所有车款的外观图参数集合, st4, st21, date_id
                $all_model = $model_obj->getModelBySid($id);
                $param = $model_pic = $model_pic1 = $model_pic2 = $date_arr = array();

                foreach ($all_model as $key => $value) {
                    $st4 = array_search($value['st4'], $series_obj->st4_list);
                    $st21 = array_search($value['st21'], $series_obj->st21_list);

                    #if(empty($value['model_pic1']))
                    $param[$st4 . '_' . $st21 . '_' . $value['date_id']][] = $key;
                    if ($value['model_pic1']) {
                        $model_pic[$key] = $value['model_pic1'];

                        $model_pic1 = ATTACH_DIR . "images/model/{$key}/{$value['model_pic1']}";
                        $model_pic1[$st4 . '_' . $st21 . '_' . $value['date_id']] = $model_pic1;
                    } elseif ($value['model_pic2']) {
                        $series_style_pic = ATTACH_DIR . "images/series/{$id}/{$value['model_pic2']}";
                        if (file_exists($series_style_pic)) {
                            $model_pic2[$st4 . '_' . $st21 . '_' . $value['date_id']] = $value['model_pic2'];
                        }
                    }
                }

                $ret_stat['stylecount'] = count($param);
                $ret_stat['modelcount'] = count($param, 1) - $ret_stat['stylecount'];
                $ret_stat['modelcount_ext'] = count($model_pic);

                #先查询指定车系白底图
                foreach ($param as $key => $value) {
                    list($st4, $st21, $date_id) = explode('_', $key);
                    $this->where = "type_name='style' and type_id='{$id}' and pos='{$st4}' 
                            and ppos='{$st21}' and s1='{$date_id}' and name<>''";
                    $this->fields = 'name';
                    $style_pic = $this->getResult(3);

                    #处理cardb_file表中外观图异常的情况
                    if (empty($style_pic)) {
                        $style_pic = $model_pic2[$st4 . '_' . $st21 . '_' . $date_id];

                        #更新正确的图片名称
                        $this->ufields = array(
                            'name' => $model_pic2[$st4 . '_' . $st21 . '_' . $date_id],
                        );
                        $this->where = "type_name='style' and type_id='{$id}' and pos='{$st4}' 
                            and ppos='{$st21}' and s1='{$date_id}' and name=''";
                        $r = $this->update();
                    }

                    #处理车系图片目录下的图片
                    $series_style_pic = ATTACH_DIR . "images/series/{$id}/{$style_pic}";
                    if (file_exists($series_style_pic) && !empty($style_pic)) {
                        foreach ($this->style_size as $sk => $sv) {
                            $new_style_pic = ATTACH_DIR . "images/series/{$id}/{$sv}{$style_pic}";
                            if (!file_exists($new_style_pic)) {
                                list($x, $y) = explode('x', $sv);
                                imagemark::resize($series_style_pic, $sv, $x, $y, '', $watermark_opt);
                            }

                            #复制到对应车款图片目录下
                            foreach ($value as $mk => $mv) {
                                $model_dir = ATTACH_DIR . "images/model/{$mv}/";
                                @file::forcemkdir($model_dir);
                                @copy($new_style_pic, $model_dir . $sv . $style_pic);
                            }
                        }
                        $ret_stat['ok']++;
                    }
                    #如果cardb_file表中无记录，cardb_model表中model_pic1又无记录
                    elseif (!$model_pic1[$st4 . '_' . $st21 . '_' . $date_id]) {
                        $ret_stat['err']++;
                        $ret_stat['errstr'] .= $this->sql . ";";
                        $ret_stat['errser'] .= $id . ";";
                    }

                    #检查车款是否单独上传过车款，处理
                    if (!empty($model_pic)) {
                        foreach ($model_pic as $pk => $pv) {
                            $model_pic1 = ATTACH_DIR . "images/model/{$pk}/{$pv}";
                            if (file_exists($model_pic1)) {
                                foreach ($this->style_size as $sk => $sv) {
                                    $new_style_pic = ATTACH_DIR . "images/model/{$pk}/{$sv}{$pv}";
                                    if (!file_exists($new_style_pic)) {
                                        list($x, $y) = explode('x', $sv);
                                        imagemark::resize($model_pic1, $sv, $x, $y, '', $watermark_opt);
                                    }
                                }
                                $ret_stat['ok']++;
                            }
                            else
                                $ret_stat['err']++;
                        }
                    }
                }
                return $ret_stat;
                break;

            case 'srpic':

                break;

            case 'pic':

                break;
        }
    }

    function getOneUploadFile($where, $flag = 2) {
        $this->fields = "*";
        $this->where = $where;
        $this->order = array('id' => 'desc');
        return $this->getResult($flag);
    }
    
     function getlist($field,$where, $flag = 2) {
        $this->fields = "$field";
        $this->where = $where;
        return $this->getResult($flag);
    }

}

?>
