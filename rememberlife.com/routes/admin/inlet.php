<?php 

/**
 * 后台入口管理
 */
// 后台登录 入口
Route::get('/', 'AdminController')->name('admin_login');
// 提交登录数据
Route::post('login', 'AdminUserController@login')->name('admin_login_submit');
// 注册页
Route::get('register', 'AdminUserController@register')->name('admin_register');
// 注册数据提交
Route::post('register', 'AdminUserController@register')->name('admin_register_submit');
// 退出登录
Route::get('logout', 'AdminUserController@logout')->name('admin_logout');
// 后台登录 ajax 验证
// Route::get('index', 'AdminController@loginAjax')->name('admin_loginAjax');
// 后台首页
// Route::get('index', 'AdminController@index')->name('admin_index');