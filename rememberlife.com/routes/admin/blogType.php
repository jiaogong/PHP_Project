<?php 

/**
 * blogType管理
 */
// blogType列表
Route::get('blogType', 'BlogTypeController@lists')->name('admin_blog_type_list');
// blogType添加
Route::get('blogTypeAdd', 'BlogTypeController@add')->name('admin_blog_type_add');
// blogType添加_提交数据
Route::post('blogTypeAdd', 'BlogTypeController@add')->name('admin_blog_type_add_data');
// blogType修改
Route::get('blogTypeModify/{$blogType_id}', 'BlogTypeController@modify')->name('admin_blog_type_modify');
// blogType修改_提交数据
Route::post('blogTypeModify/{$blogType_id}', 'BlogTypeController@modify')->name('admin_blog_type_modify_data');
// blog删除
Route::get('blogTypeDel/{$blogType_id}', 'BlogTypeController@del')->name('admin_blog_type_del');