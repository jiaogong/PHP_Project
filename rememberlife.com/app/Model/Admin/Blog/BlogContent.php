<?php

namespace App\Model\Admin\Blog;

use Illuminate\Database\Eloquent\Model;
use DB;
// use Illuminate\Support\Facades\Session;

/**
 * 前台轮播6小图
 *
 */

class BlogContent extends Model
{
    protected $table = 'blog_content';
    // protected $incrementing = false; // 非自增
    public $primaryKey = 'id';
    public $timestamps = true;

}
