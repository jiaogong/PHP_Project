<?php

/*
|--------------------------------------------------------------------------
| Index Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// 前台

// 首页
Route::get('/', 'IndexController')->name('home');
// about页
Route::get('about', 'IndexController@about')->name('about');

// blog
Route::group(['prefix' => 'blog'], function () {
    // blog文章列表页
    Route::get('/', 'BlogController@blogList')->name('blog');
    // blog文章详情页
    Route::get('/{blogId}', 'BlogController@blogInfo')->where('blogId', '\d+');
});

// pages页
Route::get('pages', 'IndexController@pages')->name('pages');
// gallery页
Route::get('gallery', 'IndexController@gallery')->name('gallery');
// contact页
Route::match(['get', 'post'], 'contact', 'IndexController@contact')->name('contact');

// 用户页
Route::group(['prefix' => 'user'/*, 'middleware' => 'auth' */], function (){
    Route::get('account', 'UserController@account')->name('account');
    // 注册用户
    Route::get('register', 'UserController@register')->name('signin');
    // 添加用户信息到数据库
    Route::post('add', 'UserController@add');
    // 登录
    Route::match(['get', 'post'], 'login', 'UserController@login')->name('login');
    // 退出登录
    Route::get('logout', 'UserController@logout')->name('logout');
});

Route::resource('home', 'HomeController');