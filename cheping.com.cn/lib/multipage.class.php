<?php

/**
 * 分页静态类，不用实例化，静态使用方法
 * $Id: multipage.class.php 2606 2016-05-10 09:29:54Z wangchangjiang $
 * @author David.Shaw <tudibao@163.com>
 */
class multipage {

    function multipage() {
        die('not run');
    }

    /**
     * 标准分页方法
     * 
     * @global int $maxpage
     * @param int $num 总记录数，根据总数计算实际总页数
     * @param int $perpage 每页显示的记录数
     * @param int $curpage 当前页号
     * @param string $mpurl 分页链接URL前缀
     * @param int $maxpages 显示的最大页数
     * @param int $page 显示的页码数
     * @param boolean $autogoto 允许自动跳转JS
     * @param boolean $simple 与autogoto关联，是否显示页面跳转框
     * @return string 分页html代码
     */
    
    function multi($num, $perpage, $curpage, $mpurl, $maxpages = 0, $page = 6, $autogoto = TRUE, $simple = FALSE) {
        global $maxpage;
        $purls = explode("?", $mpurl);
        $mpurl = count($purls) > 1 ? $mpurl . "&" : $mpurl . "?";
        $realpages = 1;
        if (is_numeric($num) && $num > $perpage) {
            $offset = 2;
            $realpages = ceil($num / $perpage);
            $pages = $maxpages && $maxpages < $realpages ? $maxpages : $realpages;
            if ($page > $pages) {
                $from = 1;
                $to = $pages;
            } else {
                $from = $curpage - $offset;
                $to = $from + $page - 1;
                if ($from < 1) {
                    $to = $curpage + 1 - $from;
                    $from = 1;
                    if ($to - $from < $page) {
                        $to = $page;
                    }
                } elseif ($to > $pages) {
                    $from = $pages - $page + 1;
                    $to = $pages;
                }
            }
            $multipage = '<ol>';
            $multipage .= ($curpage > 1 && !$simple ? '<li class="prevPage"><span><a href="' . $mpurl . 'page=' . ($curpage - 1) . '">上一页</a></span></li>' : '');
            $multipage .= "\n";
            $multipage .= ($curpage - $offset > 1 && $pages > $page ? '<li><a href="' . $mpurl . 'page=1">1</a></li><li class="apostrophe" >...</li>' : '');
            $multipage .= "\n";
            for ($i = $from; $i <= $to; $i++) {
                $multipage .= $i == $curpage ? '<li class="song"><a href="javascript:void(-1);">' . $i . '</a></li>' : '<li><a href="' . $mpurl . 'page=' . $i . '">' . $i . '</a></li>';
                $multipage .= "\n";
            }
            $multipage .= ($curpage > $pages ? "<li style='line-height:42px'>...</li>" : '');
            $multipage .= "\n";
            $multipage .= ($curpage < $pages && !$simple ? '<li class="nextPage"><span><a href="' . $mpurl . 'page=' . ($curpage + 1) . '">下一页</a></span></li>' : '');
            $multipage .= "\n";
            $multipage .= '</ol>';
        }
        $maxpage = $realpages;
        return $multipage;
    }
    
    function multis($num, $perpage, $curpage, $mpurl, $maxpages = 0, $page = 6, $autogoto = TRUE, $simple = FALSE) {
        global $maxpage;
        $purls = explode("?", $mpurl);
        $mpurl = count($purls) > 1 ? $mpurl . "&" : $mpurl . "?";
        $realpages = 1;
        if (is_numeric($num) && $num > $perpage) {
            $offset = 2;
            $realpages = ceil($num / $perpage);
            $pages = $maxpages && $maxpages < $realpages ? $maxpages : $realpages;
            if ($page > $pages) {
                $from = 1;
                $to = $pages;
            } else {
                $from = $curpage - $offset;
                $to = $from + $page - 1;
                if ($from < 1) {
                    $to = $curpage + 1 - $from;
                    $from = 1;
                    if ($to - $from < $page) {
                        $to = $page;
                    }
                } elseif ($to > $pages) {
                    $from = $pages - $page + 1;
                    $to = $pages;
                }
            }
            $multipage = '<ul>';
            $multipage .= ($curpage > 1 && !$simple ? '<li><span class="page_btn_a"><a href="' . $mpurl . 'page=' . ($curpage - 1) . '" class="on othercol">上一页</a></span></li>' : '');
            $multipage .= "\n";
            $multipage .= ($curpage - $offset > 1 && $pages > $page ? '<li class="page_num"><a href="' . $mpurl . 'page=1">1</a></li><li class="page_num">...</li>' : '');
            $multipage .= "\n";
            for ($i = $from; $i <= $to; $i++) {
                $multipage .= $i == $curpage ? '<li class="focus_num"><a href="javascript:void(-1);" class="off">' . $i . '</a></li>' : '<li class="page_num"><a href="' . $mpurl . 'page=' . $i . '" class="on">' . $i . '</a></li>';
                $multipage .= "\n";
            }
            $multipage .= ($curpage > $pages ? "<li class='page_num'>...</li>" : '');
            $multipage .= "\n";
            $multipage .= ($curpage < $pages && !$simple ? '<li><span class="page_btn_a"><a href="' . $mpurl . 'page=' . ($curpage + 1) . '" class="next">下一页</a></span></li>' : '') .
                    ($to < $pages ? '<li>共<a href="' . $mpurl . 'page=' . $pages . '" class="on">' . $realpages . '</a>页</li>' : '') . '<li>  到<input type="text" style="height:21px;" name="custompage" id="custompage" size="3" onkeydown="if(event.keyCode==13 && this.value <= ' . $pages . ') {window.location=\'' . $mpurl . 'page=' . '\'+this.value+\'\'; return false;}" />页 <span class="page_btn_a"><a href="javascript:void(0);" onclick="javascript:if(document.getElementById(\'custompage\').value <= ' . $pages . ') location.href=\'' . $mpurl . 'page=\' + document.getElementById(\'custompage\').value">确定</a></span></li>';
            $multipage .= "\n";
            #(!$simple && $pages > $page && !$ajaxtarget ? '<kbd><input type="text" name="custompage" size="3" onkeydown="if(event.keyCode==13) {window.location=\''.$mpurl.'page='.'\'+this.value+\'\'; return false;}" /></kbd>' : '');
            $multipage .= '</ul>';
            #$multipage = $multipage ? (!$simple ? '<span class="gray">&nbsp;'.$this->common_total.$num.$this->common_total_num.'&nbsp;</span>' : '').$multipage : '';
        }
        $maxpage = $realpages;
        return $multipage;
    }
    
  /**
     * 广州车展分页类
     * 
     * @global int $maxpage
     * @param int $num 总记录数，根据总数计算实际总页数
     * @param int $perpage 每页显示的记录数
     * @param int $curpage 当前页号
     * @param string $mpurl 分页链接URL前缀
     * @param int $maxpages 显示的最大页数
     * @param int $page 显示的页码数
     * @param boolean $autogoto 允许自动跳转JS
     * @param boolean $simple 与autogoto关联，是否显示页面跳转框
     * @return string 分页html代码
     */
    
    function guangzho_umulti($num, $perpage, $curpage, $mpurl, $maxpages = 0, $page = 10, $autogoto = TRUE, $simple = FALSE) {
        global $maxpage;
        $multipage = '';
        $purls = explode("?", $mpurl);
        $mpurl = count($purls) > 1 ? $mpurl . "&" : $mpurl . "?";
        $realpages = 1;
        if (is_numeric($num) && $num > $perpage) {
            $offset = 2;
            $realpages = ceil($num / $perpage);
            $pages = $maxpages && $maxpages < $realpages ? $maxpages : $realpages;
            if ($page > $pages) {
                $from = 1;
                $to = $pages;
            } else {
                $from = $curpage - $offset;
                $to = $from + $page - 1;
                if ($from < 1) {
                    $to = $curpage + 1 - $from;
                    $from = 1;
                    if ($to - $from < $page) {
                        $to = $page;
                    }
                } elseif ($to > $pages) {
                    $from = $pages - $page + 1;
                    $to = $pages;
                }
            }

            $multipage = "<ol>";
            $multipage .= ($curpage - $offset > 1 && $pages > $page ? '<li class="sz"><a href="' . $mpurl . 'page=1" >1 ...</a></li>' : '') .
                    ($curpage > 1 && !$simple ? '<li class="shangxia jgcolor"><a href="' . $mpurl . 'page=' . ($curpage - 1) . '/" >上一页</a></li>' : '');
            for ($i = $from; $i <= $to; $i++) {
                $multipage .= $i == $curpage ? '<li class="songs">' . $i . '</li>' : '<li><a href="' . $mpurl . 'page=' . $i . '/" >' . $i . '</a></li>';
            }
            $multipage .= ($curpage < $pages && !$simple ? '<li class="shangxia jgcolor"><a href="' . $mpurl . 'page=' . ($curpage + 1) . '/" >下一页</a></li>' : '') .
                    ($to < $pages ? '<li class="chang"><a href="' . $mpurl . 'page=' . $pages . '/" >... ' . $realpages . '</a></li>' : '') .
                    (!$simple && $pages > $page && !$ajaxtarget ? '<kbd><input type="text" name="custompage" size="3" onkeydown="if(event.keyCode==13) {window.location=\'' . $mpurl . 'page=' . '\'+this.value+\'\'; return false;}" /></kbd>' : '');

            // $multipage = $multipage ? (!$simple ? '<span class="gray">&nbsp;' . $this->common_total . $num . $this->common_total_num . '&nbsp;</span>' : '') . $multipage : '';
        }
        $maxpage = $realpages;
        return $multipage;
    }

    /**
     * 商情页分页($offersCount, $perpage, $page, $mpurl);
     * 
     * @param int $num 总记录数，根据总数计算实际总页数
     * @param int $perpage 每页显示的记录数
     * @param int $curpage 当前页号
     * @param string $mpurl 分页链接URL前缀
     * @param int $page 显示的页码数
     * @return string 分页html代码
     */
    function offer_multi($num, $perpage, $curpage, $mpurl, $page = 15) {
        $to = ceil($num / $perpage);
        if ($to < 2) {
            return;
        }
        $page = min($to, $page);
        $xx = floor($page / 2);
        if ($curpage - $xx > 1) {
            $initI = min($to - $page + 1, $curpage - $xx);
        } else {
            $initI = 1;
        }
        $multipage = '<ul>';
        $multipage .= $curpage > 1 ? '<li><span class="page_btn_a"><a href="' . $mpurl . ($curpage - 1) . '.html" class="on">上一页</a></span></li>' : '';
        $multipage .= "\n";
        $lastPage = $initI + $page;
        for ($i = $initI; $i < $lastPage; $i++) {
            if ($i == $curpage) {
                $multipage .= '<li class="focus_num"><a href="javascript:void(-1);" class="off">' . $i . '</a></li>';
            } else {
                $multipage .= '<li class="page_num"><a href="' . $mpurl . $i . '.html" class="on">' . $i . '</a></li>';
            }
            $multipage .= "\n";
        }

        $multipage .= $curpage < $to ? '<li><span class="page_btn_a"><a href="' . $mpurl . ($curpage + 1) . '.html" class="next">下一页</a></span></li>' : '';
        $multipage .= ' <li>共<a class="on" href="' . $mpurl . $to . '.html">' . $to . '</a>页</li>';
        $multipage .=
                '<li>&nbsp;&nbsp;&nbsp;到<input type="text" style="height:21px;" name="custompage" id="custompage" size="3" onkeydown="if(event.keyCode==13 && this.value <= ' . $to . ') {window.location=\'' . $mpurl . '\'+this.value+\'.html\'; return false;}" />页 &nbsp;&nbsp;<span class="page_btn_a"><a href="javascript:void(0);" onclick="javascript:if(document.getElementById(\'custompage\').value <= ' . $to . ') window.location=\'' . $mpurl . '\' + document.getElementById(\'custompage\').value+\'.html\'">确定</a></span></li>';
        $multipage .= "\n";
        $multipage .= '</ul>';
        return $multipage;
    }

    /**
     * 个人中心分页
     * 
     * @global int $maxpage
     * @param int $num 总记录数，根据总数计算实际总页数
     * @param int $perpage 每页显示的记录数
     * @param int $curpage 当前页号
     * @param string $mpurl 分页链接URL前缀
     * @param int $maxpages 显示的最大页数
     * @param int $page 显示的页码数
     * @param boolean $autogoto 允许自动跳转JS
     * @param boolean $simple 与autogoto关联，是否显示页面跳转框
     * @return string 分页html代码
     */
    function user_multi($num, $perpage, $curpage, $mpurl, $maxpages = 0, $page = 6, $autogoto = TRUE, $simple = FALSE) {
        global $maxpage;
        $multipage = '<ul>';
        $purls = explode("?", $mpurl);
        $mpurl = count($purls) > 1 ? $mpurl . "&" : $mpurl . "?";
        $realpages = 1;
        if (is_numeric($num) && $num > $perpage) {
            $offset = 2;
            $realpages = ceil($num / $perpage);
            $pages = $maxpages && $maxpages < $realpages ? $maxpages : $realpages;
            if ($page > $pages) {
                $from = 1;
                $to = $pages;
            } else {
                $from = $curpage - $offset;
                $to = $from + $page - 1;
                if ($from < 1) {
                    $to = $curpage + 1 - $from;
                    $from = 1;
                    if ($to - $from < $page) {
                        $to = $page;
                    }
                } elseif ($to > $pages) {
                    $from = $pages - $page + 1;
                    $to = $pages;
                }
            }
            $multipage .= ($curpage > 1 && !$simple ? '<li><span class="page_btn_a"><a href="' . $mpurl . 'page=' . ($curpage - 1) . '" class="on">上一页</a></span></li>' : '');
            $multipage .= "\n";
            $multipage .= ($curpage - $offset > 1 && $pages > $page ? '<li class="page_num"><a href="' . $mpurl . 'page=1">1</a></li><li class="page_num">...</li>' : '');
            $multipage .= "\n";
            for ($i = $from; $i <= $to; $i++) {
                $multipage .= $i == $curpage ? '<li class="focus_num"><a href="javascript:void(-1);" class="off">' . $i . '</a></li>' : '<li class="page_num"><a href="' . $mpurl . 'page=' . $i . '" class="on">' . $i . '</a></li>';
                $multipage .= "\n";
            }
            $multipage .= ($curpage > $pages ? "<li class='page_num'>...</li>" : '');
            $multipage .= "\n";
            $multipage .= ($curpage < $pages && !$simple ? '<li><span class="page_btn_a"><a href="' . $mpurl . 'page=' . ($curpage + 1) . '" class="next">下一页</a></span></li>' : '') .
                    ($to < $pages ? '<li>共<a href="' . $mpurl . 'page=' . $pages . '" class="on">' . $realpages . '</a>页</li>' : '') . '<li>  到<input type="text" style="height:21px;" name="custompage" id="custompage" size="3" onkeydown="if(event.keyCode==13 && this.value <= ' . $pages . ') {window.location=\'' . $mpurl . 'page=' . '\'+this.value+\'\'; return false;}" />页</li><li> <span class="page_btn_a"><a href="javascript:void(0);" onclick="javascript:if(document.getElementById(\'custompage\').value <= ' . $pages . ') location.href=\'' . $mpurl . 'page=\' + document.getElementById(\'custompage\').value">确定</a></span></li>';
            $multipage .= "\n";
            #(!$simple && $pages > $page && !$ajaxtarget ? '<kbd><input type="text" name="custompage" size="3" onkeydown="if(event.keyCode==13) {window.location=\''.$mpurl.'page='.'\'+this.value+\'\'; return false;}" /></kbd>' : '');
            $multipage .= '</ul>';
            #$multipage = $multipage ? (!$simple ? '<span class="gray">&nbsp;'.$this->common_total.$num.$this->common_total_num.'&nbsp;</span>' : '').$multipage : '';
        }
        $maxpage = $realpages;
        return self::replaceRwURL($multipage);
    }

    /**
     * 搜车页上面分页
     * 
     * @global int $maxpage
     * @param int $num 总记录数，根据总数计算实际总页数
     * @param int $perpage 每页显示的记录数
     * @param int $curpage 当前页号
     * @param string $mpurl 分页链接URL前缀
     * @param int $maxpages 显示的最大页数
     * @param int $page 显示的页码数
     * @param boolean $autogoto 允许自动跳转JS
     * @param boolean $simple 与autogoto关联，是否显示页面跳转框
     * @param int $type 根据标识显示不同上一页，下一页样式
     * @return string 分页html代码
     */
    function search_multi($num, $perpage, $curpage, $mpurl, $maxpages = 0, $page = 6, $autogoto = TRUE, $simple = FALSE, $type = 1) {
        global $maxpage;
        $multipage = '';
        $purls = explode("?", $mpurl);
        $mpurl = count($purls) > 1 ? $mpurl . "&" : $mpurl . "?";
        $realpages = 1;
        if (is_numeric($num) && $num > $perpage) {
            $offset = 2;
            $realpages = ceil($num / $perpage);

            $pages = $maxpages && $maxpages < $realpages ? $maxpages : $realpages;
            if ($page > $pages) {
                $from = 1;
                $to = $pages;
            } else {
                $from = $curpage - $offset;
                $to = $from + $page - 1;
                if ($from < 1) {
                    $to = $curpage + 1 - $from;
                    $from = 1;
                    if ($to - $from < $page) {
                        $to = $page;
                    }
                } elseif ($to > $pages) {
                    $from = $pages - $page + 1;
                    $to = $pages;
                }
            }
            if ($type == 1) {
                $multipage = //                ($curpage - $offset > 1 && $pages > $page ? '<a href="'.$mpurl.'page=1" class="on">1 ...</a>' : '').
                        ($curpage > 1 && !$simple ? '<li><span class="page_btn_a"><a href="' . $mpurl . 'page=' . ($curpage - 1) . '" >上一页</a></span></li>' : '');
                for ($i = $from; $i <= $to; $i++) {
                    $multipage .= $i == $curpage ? '<li class="focus_num"><a href="javascript:void(-1);" >' . $i . '</a></li>' : '<li class="page_num"><a href="' . $mpurl . 'page=' . $i . '" >' . $i . '</a></li>';
                }
                $multipage .= ($to < $pages ? '<li>…</li><li class="page_num"><a href="' . $mpurl . 'page=' . $pages . '" >' . $realpages . '</a></li>' : '') .
                        ($curpage < $pages && !$simple ? '<li><span class="page_btn_a"><a href="' . $mpurl . 'page=' . ($curpage + 1) . '">下一页</a></span></li>' : '') .
                        (!$simple && $pages > $page && !$ajaxtarget ? '<li>&nbsp;到<input type="text" id="custompage" name="custompage" size="3" onkeydown="if(event.keyCode==13) {window.location=\'' . $mpurl . 'page=' . '\'+this.value+\'\'; return false;}" />页</li>' : '') . '';

                #$multipage = $multipage ? (!$simple ? '<span class="gray">&nbsp;'.$this->common_total.$num.$this->common_total_num.'&nbsp;</span>' : '').$multipage : '';
            } else if ($type == 2) {
                $multipage = "<li>$curpage/$realpages</li>" . ($curpage > 1 && !$simple ? "<li><a href='" . $mpurl . "page=" . ($curpage - 1) . "'>上一页</a></li>" : '') . ($curpage < $pages && !$simple ? '<li><a href="' . $mpurl . 'page=' . ($curpage + 1) . '">下一页</a></li>' : '');
            }
        }
        $maxpage = $realpages;
        return self::replaceRwURL($multipage);
    }

    /**
     * 壁纸库分页
     * 
     * @global int $maxpage
     * @param int $num 总记录数，根据总数计算实际总页数
     * @param int $perpage 每页显示的记录数
     * @param int $curpage 当前页号
     * @param string $mpurl 分页链接URL前缀
     * @param int $maxpages 显示的最大页数
     * @param int $page 显示的页码数
     * @param boolean $autogoto 允许自动跳转JS
     * @param boolean $simple 与autogoto关联，是否显示页面跳转框
     * @param int $type 根据标识显示不同上一页，下一页样式
     * @return string 分页html代码
     */
    function wallpaper_multi($num, $perpage, $curpage, $mpurl, $maxpages = 0, $page = 6, $autogoto = TRUE, $simple = FALSE, $type = 1) {
        global $maxpage;
        $multipage = '';
        $purls = explode("?", $mpurl);
        $mpurl = count($purls) > 1 ? $mpurl . "&" : $mpurl . "?";
        $realpages = 1;
        if (is_numeric($num) && $num > $perpage) {
            $offset = 2;
            $realpages = ceil($num / $perpage);

            $pages = $maxpages && $maxpages < $realpages ? $maxpages : $realpages;
            if ($page > $pages) {
                $from = 1;
                $to = $pages;
            } else {
                $from = $curpage - $offset;
                $to = $from + $page - 1;
                if ($from < 1) {
                    $to = $curpage + 1 - $from;
                    $from = 1;
                    if ($to - $from < $page) {
                        $to = $page;
                    }
                } elseif ($to > $pages) {
                    $from = $pages - $page + 1;
                    $to = $pages;
                }
            }
            if ($type == 1) {
                $multipage = ($curpage - $offset > 1 && $pages > $page ? '<a href="' . $mpurl . 'page=1">1 ...</a>' : '') .
                        ($curpage > 1 && !$simple ? '<a href="' . $mpurl . 'page=' . ($curpage - 1) . '">上一页</a>' : '');
                for ($i = $from; $i <= $to; $i++) {
                    $multipage .= $i == $curpage ? '<a href="javascript:void(-1);"  class="focus" >' . $i . '</a>' : '<a href="' . $mpurl . 'page=' . $i . '" >' . $i . '</a>';
                }
                $multipage .= ($to < $pages ? '<a>…</a><a href="' . $mpurl . 'page=' . $pages . '" class="page_num">' . $realpages . '</a>' : '') .
                        ($curpage < $pages && !$simple ? '<a href="' . $mpurl . 'page=' . ($curpage + 1) . '" >下一页</a>' : '') .
                        (!$simple && $pages > $page && !$ajaxtarget ? '<label>到<input type="text" id="custompage" name="custompage" size="3" onkeydown="if(event.keyCode==13) {window.location=\'' . $mpurl . 'page=' . '\'+this.value+\'\'; return false;}" />页</label><a href="javascript:void(-1);" mpurl="' . $mpurl . '" id="wp_page_btn">确定</a>' : '') . '';

                #$multipage = $multipage ? (!$simple ? '<span class="gray">&nbsp;'.$this->common_total.$num.$this->common_total_num.'&nbsp;</span>' : '').$multipage : '';
            } else if ($type == 2) {
                $multipage = "<li>$curpage/$realpages</li>" . ($curpage > 1 && !$simple ? "<li><a href='" . $mpurl . "page=" . ($curpage - 1) . "'>上一页</a></li>" : '') . ($curpage < $pages && !$simple ? '<li><a href="' . $mpurl . 'page=' . ($curpage + 1) . '">下一页</a></li>' : '');
            }
        }
        $maxpage = $realpages;
        return self::replaceRwURL($multipage);
    }

    /**
     * 专题分页
     * 
     * @param int $num 总记录数，根据总数计算实际总页数
     * @param int $perpage 每页显示的记录数
     * @param int $curpage 当前页号
     * @param string $mpurl 分页链接URL前缀
     * @param int $page 显示的页码数
     * @return string 分页html代码
     */
    function st_multi($num, $perpage, $curpage, $mpurl, $page = 15) {
        $to = ceil($num / $perpage);
        if ($to < 2) {
            return;
        }
        $page = min($to, $page);
        $xx = floor($page / 2);
        if ($curpage - $xx > 1) {
            $initI = min($to - $page + 1, $curpage - $xx);
        } else {
            $initI = 1;
        }
        $multipage = '<ul>';
        $multipage .= $curpage > 1 ? '<li><span class="fenye_next"><a href="' . $mpurl . ($curpage - 1) . '.html">上一页</a></span></li>' : '';
        $multipage .= "\n";
        $lastPage = $initI + $page;
        for ($i = $initI; $i < $lastPage; $i++) {
            if ($i == $curpage) {
                $multipage .= '<li class="fenye_focus"><a href="javascript:void(-1);" class="on">' . $i . '</a></li>';
            } else {
                $multipage .= '<li class="fenye_yema"><a href="' . $mpurl . $i . '.html" class="off">' . $i . '</a></li>';
            }
            $multipage .= "\n";
        }

        $multipage .= $curpage < $to ? '<li><span class="fenye_next"><a href="' . $mpurl . ($curpage + 1) . '.html">下一页</a></span></li>' : '';
        $multipage .= ' <li style="line-height:42px; font-size:12px">共<a href="' . $mpurl . $to . '.html">' . $to . '</a>页</li>';
        $multipage .=
                '<li class="fenxi_qd" style="font-size:12px;">去第<input type="text" style="height:21px;" id="custompage" size="3" onkeydown="if(event.keyCode==13 && this.value <= ' . $to . ') {window.location=\'' . $mpurl . '\'+this.value+\'.html\'; return false;}" />页<li><div style="margin-top:10px;"><input type="button" name="" class="sure" onclick="javascript:if(document.getElementById(\'custompage\').value <= ' . $to . ') window.location=\'' . $mpurl . '\' + document.getElementById(\'custompage\').value+\'.html\'"></div></li>';
        $multipage .= "\n";
        $multipage .= '</ul>';
        return self::replaceRwURL($multipage);
    }

}
