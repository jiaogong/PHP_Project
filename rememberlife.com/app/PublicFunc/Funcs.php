<?php

namespace App\PublicFunc;

use League\Flysystem\Util\MimeType;

/**
 *  私有公共方法
 */

class Funcs
{
    /**
     * getLoadFileTOExtension 获取上传文件的后缀名
     * 
     * @param  string $fileMimeType  fileMimeType
     * @return mixed               fileExtension or false
     */
    public static function getLoadFileTOExtension($fileMimeType) {
        $MimeTypeMapArray =  MimeType::getExtensionToMimeTypeMap();
        if ( $fileExtension = array_search($fileMimeType, $MimeTypeMapArray) ){
            return '.' . $fileExtension;
        }
        return false;
    }

    /**
     * isImage 判断上传文件的类型是否是图片
     * 
     * @param  object  $file 上传文件对象,如$request->file('file1')
     * @return boolean       
     */
    public static function isImage($file) {
        $mimeType = $file->getMimetype();
        return starts_with($mimeType, 'image/');
    }

    public static function getFileSize($fileSize, $decimals=2) {
        $size = ['B', 'KB', 'MB', 'GB', 'TB', 'PB'];
        $factor = floor((strlen($fileSize) - 1) / 3);
        return sprintf("%.{$decimals}f", $fileSize / pow(1024, $factor)) .@$size[$factor];
    }

    /**
     * uploadOneImage 单个图片文件上传
     * 不改变图片大小
     * 
     * @param  [type]  $fileRequestObj  上传图片对象 如：$request->file('filename')
     * @param  string  $saveDir         保存图片的路径
     * @param  boolean $replaceFileName 是否替换文件名
     * @return array                   [description]
     */
    public static function uploadOneImage($fileRequestObj, $saveDir='', $replaceFileName=true) {
        $fileExtensionName = '';
        $fileUploadObj = '';
        $fileName = '';
        $firstFileName = '';
        if ($fileRequestObj->isValid() && self::isImage($fileRequestObj) && !empty($saveDir)){
            $fileExtensionString = $fileRequestObj->getClientMimeType();
            $fileExtensionName = self::getLoadFileTOExtension($fileExtensionString);
            if ( !$fileExtensionName ){
                return false;
            }
            if ( $replaceFileName ) {
                $fileName =  time().rand(111, 999) . $fileExtensionName;
                $firstFileName = $fileRequestObj->getClientOriginalName();
            } else {
                $fileName = $fileRequestObj->getClientOriginalName();
                $firstFileName = $fileName;
            }
            $fileUploadObj = $fileRequestObj->move(
                    $saveDir, $fileName
                );
            $savePath = '/'. $fileUploadObj->getPathName();
            $savePath = str_replace('\\', '/', $savePath);
            $size = self::getFileSize($fileRequestObj->getClientSize());
            $firstFilePath = $fileRequestObj->getPathname();

            return [
                'savePath' => $savePath // 保存后的完整路径
                , 'saveDir' => $saveDir // 保存时的目录名
                , 'saveFileName' => $fileName // 保存时的图片名
                , 'saveFileSize' => $size // 图片大小
                , 'fileExtension' => $fileExtensionName // 图片的后缀
                , 'firstFileName' => $firstFileName // 上传时的图片名
                , 'firstFilePath' => $firstFilePath // 上传时的图片完整路径
            ];
        }
        return false;
    }

    /**
     * getPasswordSalt 获取密码加盐字符串
     * 
     * @param  integer $length 想要的盐字符串的长度，默认为6位
     * @return string          生成后的盐(字符串)
     */
    public static function getPasswordSalt($length = 6) {
    	$salt = array_merge(range('a', 'z'), range('A','Z'));
		shuffle($salt);
		return join('', array_slice($salt, 0, $length));
    }

}
