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

Route::prefix('admin')->name('admin.')->group(function() {
    Route::get('sign-in', 'Auth\LoginController@getLogin')->name('login');
    Route::post('sign-in', 'Auth\LoginController@postLogin');
    Route::middleware(['admins'])->group(function (){
        Route::get('logout', 'Auth\LoginController@logout')->name('logout');
        Route::get('profile', 'AdminController@edit')->name('profile.edit');
        Route::post('profile', 'AdminController@update');
        Route::get('change-password', 'AdminController@changePassword')->name('change_password');
        Route::post('change-password', 'AdminController@updatePassword');
        Route::prefix('project')->name('project.')->group(function () {
            Route::get('', 'ProjectController@index')->name('index');
            Route::get('{id}/detail', 'ProjectController@show')->name('show');
            Route::get('delete/{id}', 'ProjectController@destroy')->name('delete');
            Route::get('{id}/edit', 'ProjectController@edit')->name('edit');
            Route::post('{id}/edit', 'ProjectController@update');
            Route::get('cancel/{id}', 'ProjectController@cancel')->name('cancel');
            Route::get('continue/{id}', 'ProjectController@continueProject')->name('continue');
        });
        Route::prefix('worker')->name('worker.')->group(function (){
           Route::get('', 'WorkerController@index')->name('index');
           Route::get('{id}/edit', 'WorkerController@edit')->name('edit');
           Route::post('{id}/edit', 'WorkerController@update');
           Route::get('create', 'WorkerController@create')->name('create');
           Route::post('create', 'WorkerController@store');
           Route::get('{id}/delete', 'WorkerController@destroy')->name('delete');
        });
        Route::prefix('user')->name('user.')->group(function (){
            Route::get('', 'UserController@index')->name('index');
            Route::get('{id}/edit', 'UserController@edit')->name('edit');
            Route::post('{id}/edit', 'UserController@update');
            Route::get('create', 'UserController@create')->name('create');
            Route::post('create', 'UserController@store');
            Route::get('{id}/delete', 'UserController@destroy')->name('delete');
        });
    });
});
