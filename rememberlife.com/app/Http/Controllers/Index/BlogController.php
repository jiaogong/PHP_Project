<?php

namespace App\Http\Controllers\Index;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Index\Blog as blogModel;

class BlogController extends Controller
{

    /**
    * blog文章列表页
    *
    */
    public static function blogList()
    {
        return view('index.blog.blog', [
            'htmlTitle'=>'blog'
        ]);
    }

    /**
    * blog文章详情页
    *
    */
    public static function blogInfo($blogId)
    {
        // echo $blogId;
        // $blogInfo = blogModel::findInfo($blogId);
        return view('index.blog.info',
        [
            'htmlTitle' => isset($blogInfo['title']) ? $blogInfo['title'] : 'blogInfo'
        ]);
    }

}
