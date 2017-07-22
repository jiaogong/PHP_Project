<?php

/**
 * template class, complie template file to PHP file
 * require PHP 5.2+
 * 
 * $Id: template.class.php 1064 2015-10-27 07:22:37Z xiaodawei $
 * @author David.Shaw <tudibao@163.com>
 */
class template {

    public $tplname;
    public $tpldir;
    public $objdir;
    public $tplfile;
    public $objfile;
    public $vars = array();
    public $force = 0;
    public $var_regexp = "\@?\\\$[a-z_][\\\$\w]*(?:\[[\w\-\.\"\'\[\]\$]+\])*";
    public $vtag_regexp = "\<\?=(\@?\\\$[a-zA-Z_][\\\$\w]*(?:\[[\w\-\.\"\'\[\]\$]+\])*)\?\>";
    public $const_regexp = "\{([\w]+)\}";
    public $lang = array();

    public function template($tplname = 'default') {
        $this->tplname = ($tplname !== 'default' && is_dir(SITE_ROOT . '/template/' . $tplname)) ? $tplname : 'default';
        $this->tpldir = SITE_ROOT . '/template/' . $this->tplname;
        $this->objdir = SITE_ROOT . '/data/template_c';
    }

    public function assign($k, $v) {
        $this->vars[$k] = $v;
    }

    public function setlang($langtype = 'zh', $filename) {
        include SITE_ROOT . '/lang/' . $langtype . '/' . $filename . '.php';
        $this->lang = &$lang;
    }

    public function display($file) {
        GLOBAL $starttime, $mquerynum;
        $mtime = explode(' ', microtime());
        $this->assign('runtime', number_format($mtime[1] + $mtime[0] - $starttime, 6));
        $this->assign('querynum', $mquerynum);
        extract($this->vars, EXTR_SKIP);
        include $this->gettpl($file);
    }

    private function gettpl($file) {
        if (substr($file, 0, 7) == "file://") {
            $ppos = strrpos($file, "/");
            $dir_name = explode('/', substr($file, 7));
            $this->tplfile = SITE_ROOT . "/" . substr($file, 7) . '.htm';
            $this->objfile = $this->objdir . '/' . $dir_name[1] . '_' . substr($file, $ppos + 1) . '.tpl.php';
        } else {
            if ($this->tplname !== 'default' && is_file($this->tpldir . '/' . $file . '.htm')) {
                $this->tplfile = $this->tpldir . '/' . $file . '.htm';
                $this->objfile = $this->objdir . '/' . $this->tplname . "_" . $file . '.tpl.php';
            } else {
                $this->tplfile = SITE_ROOT . '/template/default/' . $file . '.htm';
                $this->objfile = $this->objdir . '/' . $file . '.tpl.php';
            }
        }
        if (!file_exists($this->tplfile)) {
            @error_log(date('Y/m/d H:i:s') . " in." . __FILE__ . ".no." . $this->tplfile . "\n", 3, SITE_ROOT . "/data/log/tpl_err.log");
            exit;
        }
        if ($this->force || @filemtime($this->objfile) < @filemtime($this->tplfile)) {
            $this->compile();
        }
        return $this->objfile;
    }

    public function compile() {
        $template = file::readfromfile($this->tplfile);
        $template = preg_replace_callback("/\{block:([^\}]+?)\/\}/is", array(&$this, 'stripvtagArr'), $template);

        $template = preg_replace("/\<\!\-\-\{(.+?)\}\-\-\>/s", "{\\1}", $template);
        $template = preg_replace_callback("/\{lang.(\w+?)\}/is", array(&$this, 'lang'), $template);

        $template = preg_replace("/\{($this->var_regexp)\}/", "<?=\\1?>", $template);
        $template = preg_replace("/\{($this->const_regexp)\}/", "<?=\\1?>", $template);
        $template = preg_replace("/(?<!\<\?\=|\\\\)$this->var_regexp/", "<?=\\0?>", $template);
        $template = preg_replace_callback("/\{\{eval (.*?)\}\}/is", array(&$this, 'stripvtagEval'), $template);
        $template = preg_replace_callback("/\{eval (.*?)\}/is", array(&$this, 'stripvtagEval'), $template);
        $template = preg_replace_callback("/\{for (.*?)\}/is", array(&$this, 'stripvtagFor'), $template);
        $template = preg_replace_callback("/\{elseif\s+(.+?)\}/is", array(&$this, 'stripvtagElseIf'), $template);
        for ($i = 0; $i < 5; $i++) {
            $template = preg_replace_callback("/\{loop\s+$this->vtag_regexp\s+$this->vtag_regexp\s+$this->vtag_regexp\}(.+?)\{\/loop\}/is", array(&$this, 'loopsection'), $template);
            $template = preg_replace_callback("/\{loop\s+$this->vtag_regexp\s+$this->vtag_regexp\}(.+?)\{\/loop\}/is", array(&$this, 'loopsection'), $template);
        }
        $template = preg_replace_callback("/\{if\s+(.+?)\}/is", array(&$this, 'stripvtagIf'), $template);
        $template = preg_replace("/\{template\s+(\w+?)\}/is", "<? include \$this->gettpl('\\1');?>", $template);
        $template = preg_replace_callback("/\{template\s+(.+?)\}/is", array(&$this, 'stripvtagInclude'), $template);
        $template = preg_replace("/\{else\}/is", "<? } else { ?>", $template);
        $template = preg_replace("/\{\/if\}/is", "<? } ?>", $template);
        $template = preg_replace("/\{\/for\}/is", "<? } ?>", $template);
        $template = preg_replace("/$this->const_regexp/", "<?=\\1?>", $template);
        $template = "<? if(!defined('SITE_ROOT')) exit('Access Denied');?>\r\n$template";
        $template = preg_replace("/(\\\$[a-zA-Z_]\w+\[)([a-zA-Z_]\w+)\]/i", "\\1'\\2']", $template);
        $template = preg_replace_callback("/\{url.(.+?)\}/is", array(&$this, 'url'), $template);
        $template = preg_replace_callback("/\{datacall:([^\}]+?)\/\}/is", array(&$this, 'datacall'), $template);
        $fp = fopen($this->objfile, 'w');
        fwrite($fp, $template);
        fclose($fp);
    }

    private function stripvtag($s) {
        return preg_replace("/$this->vtag_regexp/is", "\\1", str_replace("\\\"", '"', $s));
    }
    
    private function stripvtagArr($s) {
        return preg_replace("/$this->vtag_regexp/is", "\\1", str_replace("\\\"", '"', $s[1]));
    }
    
    private function stripvtagIf($s){
        return preg_replace("/$this->vtag_regexp/is", "\\1", str_replace("\\\"", '"', "<? if ($s[1]) { ?>"));
    }
    
    private function stripvtagElseIf($s){
        return preg_replace("/$this->vtag_regexp/is", "\\1", str_replace("\\\"", '"', "<? } elseif($s[1]) { ?>"));
    }
    
    private function stripvtagEval($s){
        return preg_replace("/$this->vtag_regexp/is", "\\1", str_replace("\\\"", '"', "<? $s[1] ?>"));
    }
    
    private function stripvtagFor($s){
        return preg_replace("/$this->vtag_regexp/is", "\\1", str_replace("\\\"", '"', "<? for($s[1]) { ?>"));
    }
    
    private function stripvtagInclude($s){
        return preg_replace("/$this->vtag_regexp/is", "\\1", str_replace("\\\"", '"', "<? include ".$this->gettpl($s[1])." ?>"));
    }

    private function loopsection($arr = array()) {
        $arr1 = $k = $v = $statement = '';
        $len = count($arr);
        array_shift($arr);
        if ($len == 5) {
            list($arr1, $k, $v, $statement) = $arr;
        } elseif ($len == 4) {
            $k = '';
            list($arr1, $v, $statement) = $arr;
        }
        $arr1 = $this->stripvtag($arr1);
        $k = $this->stripvtag($k);
        $v = $this->stripvtag($v);
        $statement = str_replace("\\\"", '"', $statement);
        return $k ? "<? foreach((array){$arr1} as {$k}=>{$v}) {?>{$statement}<?}?>" : "<? foreach((array){$arr1} as {$v}) {?>{$statement}<? } ?>";
    }

    private function lang($k) {
        $k = $k[1];
        return !empty($this->lang[$k]) ? stripslashes($this->lang[$k]) : "{ $k }";
    }

    private function url($u) {
        $u = $u[1];
        if (substr($u, 0, 10) == 'user-login' || substr($u, 0, 11) == 'user-logout' || substr($u, 0, 13) == 'user-register' || substr($u, 0, 9) == 'user-code' || substr($u, 0, 10) == 'pic-search' || substr($u, 0, 7) == 'search-') {
            return 'index.php?' . $u;
        } elseif ('1' == $this->vars['setting']['seo_type'] && '1' == $this->vars['setting']['seo_type_doc'] && 'doc-view-' == substr($u, 0, 9)) {
            return "wiki/" . substr($u, 9);
        } else {
            return $this->vars['setting']['seo_prefix'] . $u . $this->vars['setting']['seo_suffix'];
        }
    }

    private function splittag($taglist, $statement = '') {
        $tag = preg_split("/\s+/", trim($taglist)); //接收到参数按空格分开。
        $taglist = str_replace("'", "\'", $taglist);
        if ('' != $statement) {
            $statement = str_replace("\\\"", '"', $statement);
            $statement = preg_replace_callback("/\[field:([^\]]+?)\/\]/is", array(&$this, 'callback'), $statement);

            return "<?foreach((array)\$_ENV['tag']->$tag[0]('$taglist') as \$data) {?>$statement<? } ?>";
        } else {
            return "<?echo \$_ENV['tag']->$tag[0]('$taglist');?>";
        }
    }

    private function callback($matches) {
        $cmd = trim($matches[1]);
        $firstspace = strpos($cmd, ' ');
        if (!$firstspace) {
            return '<?=$data[' . $cmd . ']?>';
        } else {
            $field = substr($cmd, 0, $firstspace);
            $func = substr($cmd, $firstspace);
            return '<? echo ' . str_replace('@me', '$data[' . $field . ']', $func) . " ?>";
        }
    }

    private function datacall($datatag) {
        $datatag = trim($datatag[1]);
        return "<? \$_ENV['datacall']->call('$datatag');?>";
    }

    private function block($area) {
        $area = trim($area);
        $datastr = '';
        foreach ((array) $GLOBALS['blocklist'][$area] as $block) {
            $datastr.='{eval $data= $GLOBALS[\'blockdata\'][' . $block['id'] . '];$bid="' . $block['id'] . '"}';
            $tplfile = SITE_ROOT . '/block/' . $block['theme'] . '/' . $block['block'] . '/' . $block['tpl'];
            if (!file_exists($tplfile)) {
                $tplfile = SITE_ROOT . '/block/default/' . $block['block'] . '/' . $block['tpl'];
            }
            $datastr.=file::readfromfile($tplfile);
        }
        return $datastr;
    }

    public function fetch($file) {
        ob_start();
        $this->display($file);
        $tpl_string = ob_get_contents();
        ob_end_clean();
        return $tpl_string;
    }

}

?>
