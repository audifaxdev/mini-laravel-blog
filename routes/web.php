<?php

Route::get('/', function () {
    return view('welcome')->with(['posts' => \App\Post::orderByDesc('created_at')->get()]);
});

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
	Route::get('/admin', 'AdminController@index')->name('admin');
	Route::get('/admin/edit-post/{ID?}', 'AdminController@editPost')->name('editPost');
	Route::get('/laravel-filemanager', '\UniSharp\LaravelFilemanager\Controllers\LfmController@show');
	Route::post('/laravel-filemanager/upload', '\UniSharp\LaravelFilemanager\Controllers\UploadController@upload');
});
Route::get('/posts', 'AdminApiController@getALlPosts');
Route::prefix("admin")->group(function () {
	Route::group(['middleware' => 'auth'], function () {
		Route::post('/posts', 'AdminApiController@createPost');
		Route::put('/posts/{ID}', 'AdminApiController@updatePost');
		Route::delete('/posts/{ID}', 'AdminApiController@deletePost');
	});
});