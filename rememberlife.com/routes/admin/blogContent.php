<?php 

/**
 * blog管理
 */
// blog列表
Route::get('blog', 'BlogContentController@lists')->name('admin_blog_list');
// blog添加
Route::get('blogAdd', 'BlogContentController@add')->name('admin_blog_add');
// blog添加_提交数据
Route::post('blogAdd', 'BlogContentController@add')->name('admin_blog_add_data');
// blog修改
Route::get('blogModify/{$blog_id}', 'BlogContentController@modify')->name('admin_blog_modify');
// blog修改_提交数据
Route::post('blogModify/{$blog_id}', 'BlogContentController@modify')->name('admin_blog_modify_data');
// blog删除
Route::get('blogDel/{$blog_id}', 'BlogContentController@del')->name('admin_blog_del');