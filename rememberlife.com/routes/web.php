<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// 前台
Route::group(
    ['namespace' => 'Index'],

    function () {
        // 首页
        Route::get('/', 'IndexController');
        // 用户页
        Route::get('user/{id}', 'UserController@show');
    }
);


// 后台
Route::group(
    [
        'namespace' => 'Admin',
        'profix'    => 'admin'
    ],

    function () {
        // 后台首页
        Route::get('/', 'AdminController');
        Route::get('a', function () {
            return '后台首页';
        });
    }
);
