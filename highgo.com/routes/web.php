<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return view('index' 
    	, ['slide'=>false]
    	);
})->name('index');
Route::group(['prefix'=>'Home','namespace'=>'Home'], function () {
	Route::get('user/add', 'UserController@add')->name('user.add');
	Route::post('user/addData', 'UserController@addData')->name('user.addData');
	Route::get('signin', 'UserController@signIn')->name('signIn');
	Route::post('signin', 'UserController@signIn')->name('signIn.data');
	Route::get('signup', 'UserController@signUp')->name('signUp');
	Route::post('signup', 'UserController@signUp')->name('signUp.data');
});

Route::get('/login', function() {
    return view('login');
});
