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
// Puclic routes
Route::get('/', function () {
    return view('index');
});

Route::get('/home', function(){
    return redirect('/admin');
});

Route::get('/contact', 'ContactController@show')->name('contact');
Route::post('/contact', 'ContactController@send');

Route::get('/posts', 'PostsController@index')->name('posts');
Route::get('/posts/{year}/{month}/{day}/{slug}', 'PostsController@show')->name('post');
Route::get('/posts/tags/{name}', 'PostsController@tag')->name('tag');
Route::get('posts/tags/', 'PostsController@tags')->name('tags');
Route::get('posts/search', 'PostsController@search')->name('search');
Route::post('posts/search', 'PostsController@search')->name('search');


Route::get('/projects', 'ProjectsController@index')->name('projects');
Route::get('/projects/{year}/{month}/{day}/{slug}', 'ProjectsController@show')->name('project');
Route::get('/public/images/{image}', 'Admin\FilesController@image');


// Admin routes
Route::get('/admin{anyroute}', function () {
    return view('admin.admin', ['api_token' => Auth::user()->api_token]);
})->where('anyroute', '.*')->middleware('auth')->name('admin');


//Auth::routes(); do not use register routes
Route::post('login', 'Auth\LoginController@login');
Route::get('login', 'Auth\LoginController@showLoginForm');
Route::post('logout', 'Auth\LoginController@logout');

Route::get('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm');

