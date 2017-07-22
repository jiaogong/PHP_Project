<?php 

/**
 * 管理前台首页
 *
 * 列表、预览、添加、修改、删除
 */
// 列表页
Route::get('homeShow', 'HomeShowController@lists')->name('admin_homeShow_list');
// 预览页
Route::get('homeShow_preview/{id}', 'HomeShowController@review')->name('admin_homeShow_review');
// 添加数据页
Route::get('homeShow_add', 'HomeShowController@add')->name('admin_homeShow_add');
// 提交数据页
Route::post('homeShow_add', 'HomeShowController@add')->name('admin_homeShow_add_data');
// 修改数据页
Route::get('homeShow_modify/{id}', 'HomeShowController@modify')->name('admin_homeShow_modify');
// 提交修改数据
Route::post('homeShow_modify/{id}', 'HomeShowController@modify')->name('admin_homeShow_modify_data');
// 删除数据
Route::get('homeShow_del/{id}', 'HomeShowController@del')->name('admin_homeShow_del');