<?php

namespace App\Model\Index;

use Illuminate\Database\Eloquent\Model;
use DB;
// use Illuminate\Support\Facades\Session;

/**
 * 前台轮播6小图
 *
 */

class HomePicture extends Model
{
    protected $table = 'home_picture';
    // protected $incrementing = false; // 非自增
    public $primaryKey = 'id';
    public $timestamps = true;


}