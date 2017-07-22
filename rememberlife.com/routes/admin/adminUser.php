<?php 

/**
 * 后台用户管理
 */
// 后台用户列表
Route::get('adminUser', 'AdminUserController@list')->name('admin_user_list');
// 后台用户添加
Route::get('adminUserAdd', 'AdminUserController@add')->name('admin_user_add');
// 后台用户添加_提交数据
Route::post('adminUserAdd', 'AdminUserController@add')->name('admin_user_add_data');
// 后台用户修改
Route::get('adminUserModify/{$user_id}', 'AdminUserController@modify')->name('admin_user_modify');
// 后台用户修改
Route::post('adminUserModify/{$user_id}', 'AdminUserController@modify')->name('admin_user_modify_data');
// 后台用户删除
Route::get('adminUserDel/{$id}', 'AdminUserController@del')->name('admin_user_del');