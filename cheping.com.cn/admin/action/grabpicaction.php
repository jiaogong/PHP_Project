<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once SITE_ROOT . 'lib/webclient.class.php';
set_time_limit(0);

class grabpicAction extends action {

    public $cardbmodel;
    public $cardbbrand;
    public $catchdate;
    public $cardbfile;
    public $xjModelInfo = array();
    public $dealerbase;
    public $dealerUrl;
    public $fileDir;
//    public $dbFileDir;
    public $xji;
    public $picUrl;
    public $pos;
    public $xjpos;
    /**
     * 抓取成功的图片总数
     * @var int  
     */
    public $picTotal = array();
    public $pcName;
    public $prevPicUrl;
    public $overwrite = false;

    function __construct() {
        parent::__construct();
        $this->cardbbrand = new brand();
        $this->cardbfile = new uploadFile();
        $this->cardbmodel = new cardbModel();
        $this->cardbcolor = new color();
        $this->catchdate = new CatchData();
    }

    /**
     * 默认方法
     */
    function doDefault() {
//        $brand = $this->cardbbrand->getAllBrand('state=3', array('letter' => 'asc'), 200);
//        $this->tpl->assign('brand', $brand);
//        $this->template('grabpic');
    }

    /**
     * 保存日志
     */
    function doXjSaveLog($name, $log) {
        $path = SITE_ROOT . 'data/log';
        file::forcemkdir($path);
        $file = $path . '/' . $name;
        if (php_sapi_name() === 'cli') {
            $file .= ".cli";
        }
        file_put_contents($file, $log, FILE_APPEND);
    }

    /**
     * 抓取图片
     */
    function doCatchPic() {
        global $watermark_opt;
        $this->timestamp = time();
        #retry 3 times
        for ($i = 0; $i < 3; $i++) {
            $this->catchdate->catchResult($this->picUrl, 0, 'http://car.autohome.com.cn/pic/');
            $this->catchdate->result = iconv('gbk', 'utf-8', $this->catchdate->result);
            $pregMatches = $this->catchdate->pregMatch('/<img.id="img".src="(.+?)".onside="-1"[^\/]+\/>/sim', 1);
            if ($pregMatches) {
                break;
            }
        }
        if (!$pregMatches) {
            $this->doXjSaveLog('insert_no_pic.txt', 'time---' . date('Y/m/d h:i:s', $this->timestamp) . '     picurl = ' . $this->picUrl . "\r\n" . $this->catchdate->result . "\r\n");
            return false;
            exit;
        }
        $nextPicUrl = $this->catchdate->pregMatch("/var.nexturl.=.'(.+?)';/sim", 1);
        $lastpic = $this->catchdate->pregMatch("/var.lastpic.=.(parseInt\(\d\));/sim", 1);
        $picColorName = $this->catchdate->pregMatch('/<li><a[^c]+class="red"href=".+?">(.+?)<span>.+?<\/span><\/a><\/li>/sim', 1);
        if ($picColorName) {
            $this->pcName = $picColorName[1];
        }
        
        if ($this->pcName && $this->pos == 1) {
            #$this->pcName = iconv('gbk', 'utf-8', $this->pcName);
            $isColor = $this->cardbcolor->getColorByColorName($this->xjModelInfo['model_id'], $this->pcName);
            if (!$isColor) {
                $this->cardbcolor->ufields = array('type_id' => $this->xjModelInfo['model_id'], 'type_name' => 'model', 'color_name' => $this->pcName, 'color_pic' => '', 'addition' => '0', 'metallic' => '0', 'state' => '0', 'created' => $this->timestamp, 'updated' => $this->timestamp);
                $this->cardbcolor->insert();
                $this->doXjSaveLog("insert_color.txt", 'time-' . date('Y/m/d h:i:s', $this->timestamp) . ' sql- ' . $this->cardbcolor->sql . "\r\n");
            }
        }
        $this->catchdate->catchResult($pregMatches[1], 0, $this->picUrl);
        $fileExt = substr($pregMatches[1], strrpos($pregMatches[1], '.') + 1);
        $fileName = util::random(16, 3) . '.' . $fileExt;
        if (!is_dir($this->fileDir) && $this->fileDir != "") {
            file::forcemkdir($this->fileDir);
        }
        $file = $this->fileDir . '/' . $fileName;
        $dbFile = $fileName;
        if (strlen($this->catchdate->result) < 5000) {
            for ($i = 0; $i < 3; $i++) {
                $this->catchdate->catchResult($pregMatches[1], 0, $this->picUrl);
                if (strlen($this->catchdate->result) > 5000) {
                    break;
                }
            }
        }
        if (strlen($this->catchdate->result) > 5000) {
            $fileReturn = file_put_contents($file, $this->catchdate->result);
            #if($this->pos == 1 && $this->xji >=1 && $this->xji <=5){
            #    imagemark::resize($file, '304x227', 304, 227,'',$watermark_opt);
            #}else{
            foreach ($this->cardbfile->pic_size as $size) {
                list($width, $height) = explode('x', $size);
                imagemark::resize($file, $size, $width, $height, '', $watermark_opt);
            }
            /* imagemark::resize($file, '304x227', 304, 227, '', $watermark_opt);
              imagemark::resize($file, '122x93', 122, 93, '', $watermark_opt);
              imagemark::resize($file, '800x600', 800, 600, '', $watermark_opt);
              imagemark::resize($file, '160x120', 160, 120, '', $watermark_opt);
              imagemark::resize($file, '242x180', 242, 180, '', $watermark_opt); */
            #}
            $this->cardbfile->ufields = array(
                'name' => $dbFile,
                'file_type' => $fileExt,
                'type_name' => 'model',
                'type_id' => $this->xjModelInfo['model_id'],
                'pos' => $this->pos,
                'ppos' => $this->xji,
                'pic_color' => $this->pcName,
                's1' => $this->xjModelInfo['s1'],
                'updated' => $this->timestamp,
                'created' => $this->timestamp);
            $this->pcName = '';
            $flag = $this->cardbfile->insert();

            if ($flag) {
                $this->doXjSaveLog("insert_pic.txt", 'time-' . date('Y/m/d h:i:s', $this->timestamp) . ' sql- ' . $this->cardbfile->sql . 'url-' . $this->picUrl . "\r\n");
            } else {
                $this->doXjSaveLog('insert_error_pic.txt', 'time-' . date('Y/m/d h:i:s', $this->timestamp) . ' sql-' . $this->cardbfile->sql . 'url-' . $this->picUrl . "\r\n");
            }
            $this->picTotal[$this->xjModelInfo['model_id']]++;
        } else {
            $this->doXjSaveLog('picsize_error.txt', 'time-' . date('Y/m/d h:i:s', $this->timestamp) . 'url-' . $this->picUrl . "\r\n");
        }
        if ($lastpic[1] == 'parseInt(0)') {
            preg_match('/bigphoto\/\d+\/(\d+)\/\d+.html/sim', $nextPicUrl[1], $pos);
            if ($pos[1] == $this->xjpos) {
                ++$this->xji;
            } else {
                $this->xji = 1;
            }
            switch ($pos[1]) {
                case '1':
                    $this->pos = 1;
                    $this->xjpos = 1;
                    break;
                case '10':
                    $this->pos = 4;
                    $this->xjpos = 10;
                    break;
                case '3':
                    $this->pos = 2;
                    $this->xjpos = 3;
                    break;
                case '12':
                    $this->pos = 3;
                    $this->xjpos = 12;
                    break;
                default :
                    return false;
            }
            $this->picUrl = $this->dealerbase . $nextPicUrl[1];
            
            $this->doCatchPic();
        }
    }

    /**
     * 图片抓取
     */
    function doPic($brandId = '', $seriesId = '', $modelId = '') {
        $this->dealerbase = 'http://car.autohome.com.cn';
        $this->dealerUrl = 'http://car.autohome.com.cn/bigphoto/spec/';
        $model_pic_dir = ATTACH_DIR . "images/model/";

        $where = 'state in (3,8) and src_id >0 ';
        if ($brandId)
            $where .= " and brand_id = $brandId";
        if ($seriesId)
            $where .= " and series_id = $seriesId";
        if ($modelId)
            $where .= " and model_id = $modelId";

        $modelInfo = $this->cardbmodel->chkModel('src_id,model_id,series_id,model_name', $where, array(), $flag = 2);
        if ($modelInfo) {
            foreach ($modelInfo as $key => $mlist) {
                if (!$mlist['src_id']) {
                    continue;
                }
                #初始化车款图抓取的张数
                $this->picTotal[$mlist['model_id']] = 0;
                #取车款下头图数(pos=1)
                $_pos_cnt = $this->cardbfile->getModelFousPicNum($mlist['model_id']);

                #如果实拍图头图数不足4张，开始抓取
                if ($_pos_cnt < 4 || $this->overwrite) {
                    $res = $this->cardbfile->getOneUploadFile("type_name='model' and type_id={$mlist['model_id']} and ppos<900");
                    if ($res) {
                        foreach ($res as $reslist) {
                            if (!$reslist['id']) {
                                continue;
                            }
                            #删除旧文件
                            @unlink($model_pic_dir . "{$reslist['type_id']}/{$reslist['name']}");
                            foreach ($this->cardbfile->pic_size as $size) {
                                @unlink($model_pic_dir . "{$reslist['type_id']}/{$size}{$reslist['name']}");
                            }
                            /* @unlink($model_pic_dir . "{$reslist['id']}/{$reslist['name']}");
                              @unlink($model_pic_dir . "{$reslist['id']}/122x93{$reslist['name']}");
                              @unlink($model_pic_dir . "{$reslist['id']}/800x600{$reslist['name']}");
                              @unlink($model_pic_dir . "{$reslist['id']}/160x120{$reslist['name']}");
                              @unlink($model_pic_dir . "{$reslist['id']}/242x180{$reslist['name']}");
                              @unlink($model_pic_dir . "{$reslist['id']}/304x227{$reslist['name']}");
                             */
                            $this->cardbfile->where = "id={$reslist['id']}";
                            $this->cardbfile->del();
                            $this->doXjSaveLog('delete_pic.txt', 'time-' . date('Y/m/d h:i:s', $this->timestamp) . ' sql- ' . $this->cardbfile->sql . "\r\n");
                        }
                    }
                    $this->xjModelInfo = array('src_id' => $mlist['src_id'], 'model_id' => $mlist['model_id'], 's1' => $mlist['series_id']);
                    $this->fileDir = SITE_ROOT . '../attach/images/model/' . $mlist['model_id'];
                    //                $this->dbFileDir = '/attach/images/model/' . $mlist['model_id'];
                    $this->xji = 1;
                    $this->picUrl = $this->dealerUrl . $this->xjModelInfo['src_id'] . '/1/';
                    $this->prevPicUrl = $this->dealerbase;
                    $this->pos = 1;
                    $this->xjpos = 1;
                    $this->doCatchPic();
                }
                #如果抓取到车款图，更新车款实拍图关联的状态=1
                if($this->picTotal[$mlist['model_id']]>0){
                    $this->cardbmodel->updateModel(array('unionpic' => 1), "model_id='{$mlist['model_id']}'");
                }
            }
        }
        return $this->picTotal;
    }

    function do1PicModel() {
        $mid = '';
        $autohomeUrl = 'http://car.autohome.com.cn/bigphoto/spec/[srcid]/1/';
        $cardbfile = new cardbFile();
        $catchdate = new CatchData();
        $models = $cardbfile->getModelByPics(5);
        #cho count($models);exit;

        foreach ($models as $k => $v) {
            #检查汽车之家网站图片数，如果和本网图片数不同记录本网车款ID
            $catchUrl = str_replace('[srcid]', $v['src_id'], $autohomeUrl);
            $catchResult = $catchdate->catchResult($catchUrl);
            $matchData = $catchdate->pregmatch('/<li><a[^>]+>(.+?)<span>\((\d+).*?\)<\/span><\/a><\/li>/sim');
            $catchdate->result = '';
            $tmpArray = array('外观', '中控', '座椅', '细节');
            $autohomeCount = 0;
            for ($i = 0; $i < 4; $i++) {
                if (in_array($matchData[1][$i], $tmpArray)) {
                    $autohomeCount += $matchData[2][$i];
                }
            }
            $difference = $autohomeCount-$v['total'];
            if($difference>1){
                $mid .= $v['model_id'] . ",";
            }
        }
        $mid = rtrim($mid, ',');
        #echo $mid;
        file_put_contents(SITE_ROOT . 'data/log/onepicmodels.txt', $mid);
        #$this->overwrite = true;
        #$this->doPic('', '', $mid);
        #return $models;
    }

}

?>
