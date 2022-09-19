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

Route::prefix('')->name('user.')->group(function() {
    Route::get('clear-cache', function (){
        Artisan::call('cache:clear');
        Artisan::call('config:cache');
        Artisan::call('view:clear');
        return "Cleared!";
    });
    Route::get('sign-in', 'Auth\LoginController@getLogin')->name('login');
    Route::post('sign-in', 'Auth\LoginController@postLogin');
    Route::get('search-project', 'ProjectController@search')->name('project.search');
    Route::middleware(['users'])->group(function (){
        Route::get('profile', 'UserController@edit')->name('profile.edit');
        Route::post('profile', 'UserController@update');
        Route::get('logout', 'UserController@logOut')->name('logout');
        Route::get('change-password', 'UserController@changePassword')->name('change_password');
        Route::post('change-password', 'UserController@updatePassword');
        Route::prefix('project')->name('project.')->group(function (){
            Route::get('', 'ProjectController@index')->name('index');
            Route::get('all', 'ProjectController@all')->name('all');
            Route::get('create', 'ProjectController@create')->name('create');
            Route::post('create', 'ProjectController@store');
            Route::get('{id}/edit', 'ProjectController@edit')->name('edit');
            Route::post('{id}/edit', 'ProjectController@update');
            Route::get('{id}/detail', 'ProjectController@show')->name('show');
            Route::get('destroy/{id}', 'ProjectController@destroy')->name('delete');
            Route::post('{id}/update-additional', 'ProjectController@updateAdditional')->name('update_additional');
            Route::post('{id}/add-message', 'ProjectController@addMessage')->name('add_message');
            Route::get('{id}/done', 'ProjectController@done')->name('done');
            Route::prefix('{project_id}')->group(function (){
                Route::prefix('feedback')->name('feedback.')->group(function (){
                    Route::post('create', 'FeedbackController@store')->name('create');
                    Route::get('{id}/show', 'FeedbackController@show')->name('detail');
                });
            });

        });
    });
    Route::post('upload-file', 'UserController@uploadFile')->name('upload_file');
});
