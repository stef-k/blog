<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::group(['middleware' => ['auth:api'], 'prefix' => 'admin'], function () {
    Route::post('files/upload', 'Admin\FilesController@upload');
    Route::post('files/delete', 'Admin\FilesController@delete');
    Route::get('files/{start?}/{batch?}', 'Admin\FilesController@index');

    Route::post('posts/create', 'Admin\PostsController@create');
    Route::post('posts/update', 'Admin\PostsController@update');
    Route::post('posts/delete', 'Admin\PostsController@delete');
    Route::get('posts/{id}', 'Admin\PostsController@post');
    Route::get('posts', 'Admin\PostsController@index');
    Route::post('posts/search', 'Admin\PostsController@search');

    Route::post('projects/create', 'Admin\ProjectsController@create@create');
    Route::post('projects/update', 'Admin\ProjectsController@update');
    Route::post('projects/delete', 'Admin\ProjectsController@delete');
    Route::get('projects/{id}', 'Admin\ProjectsController@project');
    Route::get('projects', 'Admin\ProjectsController@index');
    Route::post('projects/search', 'Admin\ProjectsController@search');

    Route::get('integrations', 'Admin\IntegrationsController@index');
    Route::post('integrations/analytics/save', 'Admin\IntegrationsController@saveAnalytics');
    Route::post('integrations/analytics/clear', 'Admin\IntegrationsController@clearAnalytics');
    Route::post('integrations/disqus/save', 'Admin\IntegrationsController@saveDisqus');
    Route::post('integrations/disqus/clear', 'Admin\IntegrationsController@clearDisqus');

    Route::get('security', 'Admin\SecurityController@index');
    Route::post('security/name/save', 'Admin\SecurityController@saveName');
    Route::post('security/email/save', 'Admin\SecurityController@saveEmail');
    Route::post('security/password/save', 'Admin\SecurityController@savePassword');
});
