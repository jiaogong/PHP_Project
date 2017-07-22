<?php

/**
 * watermark class
 * $Id: imagemark.class.php 2916 2016-06-03 11:31:47Z david $
 * @author David.Shaw
 */
class imagemark {

    /**
     * imagick watermark function
     * 
     * @param mixed $source_image 原图文件地址
     * @param mixed $water_image 水印文件地址 
     * @param mixed $postion  水印位置(0 左上,1右上，2左下，3右下,4正中,5上中,6左中,7右中,8下中)
     * @param mixed $border  边距px
     * @author David.Shaw
     * @return file
     */
    function waterMagick(
    $source_image, $water = array(
        'type' => 'file' /* text or file */,
        'file' => '' /* watermark file path */,
        'text' => 'watermark' /* watermark string */,
        'fontsize' => 15,
        'fontcolor' => '#FF0000',
        'alpha' => 0.9
    ), $postion = 0, $border = 5
    ) {
        $src = new Imagick($source_image);
        $src_height = $src->getImageHeight();
        $src_width = $src->getImageWidth();

        switch ($water['type']) {
            case 'file':
                $water = new Imagick($water['file']);
                $water_height = $water->getImageHeight();
                $water_width = $water->getImageWidth();

                switch ($postion) {
                    case 1: //top right
                        $x_pos = $src_width - $water_width - $border;
                        $src->compositeImage($water, Imagick::COMPOSITE_OVER, $x_pos, $border);
                        break;

                    case 2: //bottom left
                        $y_pos = $src_height - $water_height - $border;
                        $src->compositeImage($water, Imagick::COMPOSITE_OVER, $border, $y_pos);
                        break;

                    case 3: //bottom right
                        $x_pos = $src_width - $water_width - $border;
                        $y_pos = $src_height - $water_height - $border;
                        $src->compositeImage($water, Imagick::COMPOSITE_OVER, $x_pos, $y_pos);
                        break;

                    case 4: //center
                        $x_pos = ceil(($src_width - $water_width) / 2) - $border;
                        $y_pos = ceil(($src_height - $water_height) / 2) - $border;
                        $src->compositeImage($water, Imagick::COMPOSITE_OVER, $x_pos, $y_pos);
                        break;

                    case 5: //top center
                        $x_pos = ceil(($src_width - $water_width) / 2) - $border;
                        $src->compositeImage($water, Imagick::COMPOSITE_OVER, $x_pos, $border);
                        break;

                    case 6: //left center
                        $y_pos = ceil(($src_height - $water_height) / 2) - $border;
                        $src->compositeImage($water, Imagick::COMPOSITE_OVER, $border, $y_pos);
                        break;

                    case 7: //rigth center
                        $x_pos = $src_width - $water_width - $border;
                        $y_pos = ceil(($src_height - $water_height) / 2) - $border;
                        $src->compositeImage($water, Imagick::COMPOSITE_OVER, $x_pos, $y_pos);
                        break;

                    case 8: //bottom center
                        $x_pos = ceil(($src_width - $water_width) / 2) - $border;
                        $y_pos = $src_height - $water_height - $border;
                        $src->compositeImage($water, Imagick::COMPOSITE_OVER, $x_pos, $y_pos);
                        break;

                    default: //top left
                        $src->compositeImage($water, Imagick::COMPOSITE_OVER, $border, $border);
                }
                break;

            case 'text':
                $dw = new ImagickDraw();
                $dw->setFontSize($water['fontsize']);
                $dw->setFillColor($water['fontcolor']);

                switch ($postion) {
                    case 1: //top right
                        $dw->setGravity(Imagick::GRAVITY_NORTHEAST);
                        break;

                    case 2: //bottom left
                        $dw->setGravity(Imagick::GRAVITY_SOUTHWEST);
                        break;

                    case 3: //bottom right
                        $dw->setGravity(Imagick::GRAVITY_SOUTHEAST);
                        break;

                    case 4: //center
                        $dw->setGravity(Imagick::GRAVITY_CENTER);
                        break;

                    case 5: //top center
                        $dw->setGravity(Imagick::GRAVITY_NORTH);
                        break;

                    case 6: //left center
                        $dw->setGravity(Imagick::GRAVITY_WEST);
                        break;

                    case 7: //right center
                        $dw->setGravity(Imagick::GRAVITY_EAST);
                        break;

                    case 8: //bottom center
                        $dw->setGravity(Imagick::GRAVITY_SOUTH);
                        break;

                    default: //top left
                        $dw->setGravity(Imagick::GRAVITY_NORTHWEST);
                }

                $dw->setFillAlpha($water['alpha']);
                $dw->annotation(0, 0, $water['text']);
                $src->drawImage($dw);
                break;
        }

        if (!$src->writeImage($source_image)) {
            $src->clear();
            $src->destroy();
            return false;
        }
    }

    /**
     * 图片水印(gd lib)
     * 
     * @param resource $source_image
     * @param Imagick $water
     * @param mixed $postion
     * @param mixed $border
     * @param resource $watermark
     * @param mixed $watermark_location(1为左下角,2为右下角,3为左上角,4为右上角,5为居中)
     * @param mixed $wm_w
     * @param mixed $wm_h
     * @return file
     */
    function waterGD($watermark, $source_image, $watermark_location = 3, $border = 5, $wm_w = 0, $wm_h = 0) {
        $source_filename = $source_image;
        $watermark_size = getimagesize($watermark); //取得水印图片的长宽
        $source_image_size = getimagesize($source_image); //取得源图片的长宽
        $watermark_width = $watermark_size[0];
        $watermark_height = $watermark_size[1];
        $source_image_width = $source_image_size[0];
        $source_image_height = $source_image_size[1];

        //如果水印图片的宽超过要加水印图片宽度的二分之一
        if ($wm_w && $wm_h) {
            $watermark_width = $wm_w;
            $watermark_height = $wm_h;
        } else {
            if ($source_image_size[0] / 2 < $watermark_size[0]) {
                $watermark_width = (int) $source_image_size[0] / 2 - $border;
                $watermark_height = $watermark_width * $watermark_size[1] / $watermark_size[0];
            }
        }

        switch ($watermark_location) {
            case 1: //top right
                $src_width = $source_image_width - $watermark_width - $border;
                $src_height = $border;
                break;

            case 2: //bottom left
                $src_width = $border;
                $src_height = $source_image_height - $watermark_height - $border;
                break;

            case 3: //bottom right
                $src_width = $source_image_width - $watermark_width - $border;
                $src_height = $source_image_height - $watermark_height - $border;
                break;

            case 4: //center
                $src_width = (int) ($source_image_width - $watermark_width) / 2;
                $src_height = (int) ($source_image_height - $watermark_height) / 2;
                break;

            case 5: //top center
                $src_width = (int) ($source_image_width - $watermark_width) / 2;
                $src_height = $border;
                break;

            case 6: //left center
                $src_width = $border;
                $src_height = (int) ($source_image_height - $watermark_height) / 2;
                break;

            case 7: //rigth center
                $src_width = $source_image_width - $watermark_width - $border;
                $src_height = (int) ($source_image_height - $watermark_height) / 2;
                break;

            case 8: //bottom center
                $src_width = (int) ($source_image_width - $watermark_width) / 2;
                $src_height = $source_image_height - $watermark_height - $border;
                break;

            default: //top left
                $src_width = $border;
                $src_height = $border;
        }

        #压缩合成方法
        if (function_exists('imagecopyresampled')) {
            $merge_func = 'imagecopyresampled';
        } else {
            $merge_func = 'imagecopyresized';
        }
        $nimage = imagecreatetruecolor($source_image_size[0], $source_image_size[1]); //建立一张和源图片同样大小的新图
        $watermark = imagecreatefrompng($watermark); //取出水印图片
        if ($source_image_size[2] == 2) {
            $source_image = imagecreatefromjpeg($source_image); //取出源图片

            @imagecopy($nimage, $source_image, 0, 0, 0, 0, $source_image_width, $source_image_height); //复制源图片到新建图片
            $merge_func($nimage, $watermark, $src_width, $src_height, 0, 0, $watermark_width, $watermark_height, $watermark_size[0], $watermark_size[1]); //复制水印图片到新建图片
            $ret = imagejpeg($nimage, $source_filename); //保存此图片,如无$target_image则输出到浏览器一个jpeg格式图片
            //ImagePNG($image,"photoName.png");//加上文件名则生成一个PNG图像文件
        } elseif ($source_image_size[2] == 3) {
            $source_image = imagecreatefrompng($source_image); //取出源图片

            imagecopy($nimage, $source_image, 0, 0, 0, 0, $source_image_width, $source_image_height); //复制源图片到新建图片
            $merge_func($nimage, $watermark, $src_width, $src_height, 0, 0, $watermark_width, $watermark_height, $watermark_size[0], $watermark_size[1]); //复制水印图片到新建图片
            $ret = imagepng($nimage, $source_filename); //保存此图片,如无$target_image则输出到浏览器一个jpeg格式图片
        } else {
            return false;
        }
        imagedestroy($nimage); //销毁此图片
        return $ret;
    }
    
    /**
     * image watermark function
     * 
     * @param string $source_image 原图文件地址
     * @param array $water 水印文件地址 
     * @example array('type' => 'file' // text or file, 'file' => '' // watermark file path ,'text' => 'watermark' //watermark string ,'fontsize' => 15,'fontcolor' => '#FF0000','alpha' => 0.9)
     * @param mixed $postion  水印位置(0 左上,1右上，2左下，3右下,4正中,5上中,6左中,7右中,8下中)
     * @param mixed $border  边距px
     * @param int $lib 0 = GD lib, 1 = imagick lib
     * @author David.Shaw
     * @return file
     */
    function watermark($source_image, $water = array(), $postion = 0, $border = 5, $lib = 0) {
        if ($lib) {
            self::waterMagick($source_image, $water, $postion, $border);
        } else {
            self::waterGD($water['file'], $source_image, $postion, $border);
        }
    }

    /**
     * 生成不同尺寸图片
     * 
     * @param mixed $url
     * @param mixed $prefix
     * @param float $width
     * @param float $height
     * @param mixed $suffix
     * @param mixed $strip_str
     */
    function resizeGD($url, $prefix = 's_', $width = 80, $height = 60, $suffix = '', $strip_str = '') {
        $result = array('result' => false, 'tempurl' => '', 'msg' => 'something Wrong');
        if (is_array($url)) {
            $src_path = $url['src'];
            $dest_dir = $url['dest'];
        } else {
            $src_path = $url;
        }

        if (!file_exists($src_path)) {
            $result['msg'] = $src_path . 'img is not exist';
            return $result;
        }
        $src_pathinfo = pathinfo($src_path);
        $ext = strtolower($src_pathinfo['extension']);
        if ($strip_str)
            $src_pathinfo['basename'] = str_replace($strip_str, '', $src_pathinfo['basename']);
        if (!is_array($url)) {
            $dest_path = $src_pathinfo['dirname'] . '/' . $prefix . substr($src_pathinfo['basename'], 0, -1 - strlen($ext)) . $suffix . '.' . $ext;
        } else {
            file::forcemkdir($dest_dir);
            $dest_path = $dest_dir . '/' . $prefix . substr($src_pathinfo['basename'], 0, -1 - strlen($ext)) . $suffix . '.' . $ext;
        }

        if (!in_array($ext, array('jpg', 'jpeg', 'png', 'gif'))) {
            $result['msg'] = 'img must be gif|jpg|jpeg|png';
            return $result;
        }
        $ext = ($ext == 'jpg') ? 'jpeg' : $ext;
        $createfunc = 'imagecreatefrom' . $ext;
        $imagefunc = 'image' . $ext;
        if (function_exists($createfunc)) {
            list($actualWidth, $actualHeight) = getimagesize($src_path);
            if ($actualWidth < $width && $actualHeight < $height) {
                copy($src_path, $dest_path);
                $result['tempurl'] = $dest_path;
                $result['result'] = true;
                return $result;
            }
            if ($actualWidth < $actualHeight) {
                $width = round(($height / $actualHeight) * $actualWidth);
            } else {
                $height = round(($width / $actualWidth) * $actualHeight);
            }
            $tempimg = imagecreatetruecolor($width, $height);
            $img = $createfunc($src_path);
            imagecopyresampled($tempimg, $img, 0, 0, 0, 0, $width, $height, $actualWidth, $actualHeight);
            $result['result'] = ($ext == 'png') ? $imagefunc($tempimg, $dest_path) : $imagefunc($tempimg, $dest_path, 80);

            imagedestroy($tempimg);
            imagedestroy($img);
            if (file_exists($dest_path)) {
                $result['tempurl'] = $dest_path;
            } else {
                $result['tempurl'] = $src_path;
            }
        } else {
            copy($src_path, $dest_path);
            if (file_exists($dest_path)) {
                $result['result'] = true;
                $result['tempurl'] = $dest_path;
            } else {
                $result['tempurl'] = $src_path;
            }
        }
        return $result;
    }

    function resizeMagick($src, $prefix = 's_', $width = 80, $height = 60, $suffix = '', $strip_str = '', $quality = '', $sizefit = 1) {
        if (is_array($src)) {
            $src_path = $src['src'];
            $dest_dir = $src['dest'];
        } else {
            $src_path = $src;
        }

        if (!file_exists($src_path))
            return false;
        $fileinfo = pathinfo($src_path);
        if (!is_array($src)) {
            $dest_path = $fileinfo['dirname'] . DIRECTORY_SEPARATOR . $prefix . str_replace($strip_str, '', $fileinfo['filename']) . $suffix . '.' . $fileinfo['extension'];
        } else {
            file::forcemkdir($dest_dir);
            $dest_path = $dest_dir . DIRECTORY_SEPARATOR . $prefix . str_replace($strip_str, '', $fileinfo['filename']) . $suffix . '.' . $fileinfo['extension'];
        }

        @copy($src_path, $dest_path);
        try {
            $im = new Imagick($src_path);
            //$im = $image->clone();
            //compress image
            if (strtolower($fileinfo['extension']) == 'jpg' && $quality) {
                $im->setimagecompression(IMAGICK::COMPRESSION_JPEG);
                $im->setimagecompressionquality($quality);
            }
            $im->stripimage();
            $im->thumbnailImage($width, $height, $sizefit);
            $ret = $im->writeImage($dest_path);
            $im->clear();
            $im->destroy();
        } catch (Exception $e) {
            var_dump($e->getMessage());
        }
        return $ret ? array('tempurl' => $dest_path) : false;
        #return $im->scaleImage($width, $height);
    }

    /**
     * 生成指定的尺寸的缩略图
     * 
     * @param string    $src        原图路径含文件名
     * @param string    $prefix     输出的文件名前缀，默认为：s_
     * @param int       $width      生成的小图宽度
     * @param int       $height     生成的小图高度
     * @param string    $strip_str  在文件名中，想要删除的字符串
     * @param int       $lib        指定使用图形库，0：GDlib 1:ImageMagick
     * @param int       $quality    图片压缩质量，只在使用imagick扩展时有效，即$lib=1时
     * @param int       $sizefit    压缩尺寸的适应，防止图片变形，只在使用imagick扩展有效，即$lib=1时
     * @return mixed    处理失败返回false, 否则返回array('tempurl')，tempurl为压缩成功的小图地址
     */
    function resize($src, $prefix = 's_', $width = 80, $height = 60, $strip_str = '', $lib = 0, $quality = 80, $sizefit = 1) {
        if (!$lib) {
            return self::resizeGD($src, $prefix, $width, $height, '', $strip_str);
        } else {
            return self::resizeMagick($src, $prefix, $width, $height, '', $strip_str, $quality, $sizefit);
        }
    }

}

?>
