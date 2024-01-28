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

Route::prefix('worker')->name('worker.')->group(function () {
    Route::get('sign-in', 'Auth\LoginController@getLogin')->name('login');
    Route::post('sign-in', 'Auth\LoginController@postLogin');
    Route::middleware(['workers'])->group(function () {
        Route::get('logout', 'Auth\LoginController@logout')->name('logout');
        Route::get('profile', 'WorkerController@edit')->name('profile.edit');
        Route::post('profile', 'WorkerController@update');
        Route::get('change-password', 'WorkerController@changePassword')->name('change_password');
        Route::post('change-password', 'WorkerController@updatePassword');
        Route::prefix('project')->name('project.')->group(function () {
            Route::get('', 'ProjectController@index')->name('index');
            Route::get('zumen', 'ProjectController@indexNoMerge')->name('index_no_merge');
            Route::get('mark', 'ProjectController@indexMark')->name('index_mark');
            Route::get('{id}/detail', 'ProjectController@show')->name('show');
            Route::get('{id}/do-project', 'ProjectController@doProject')->name('do_project');
            Route::prefix('{project_id}')->name('feedback.')->group(function (){
               Route::prefix('feedback')->group(function (){
                  Route::get('{id}/show', 'FeedbackController@show')->name('detail');
               });
            });
            Route::get('analytics-by-year', 'ProjectController@analyticsByYear')->name('analytics_by_year');
        });
        Route::prefix('order')->name('order.')->group(function () {
            Route::get('', 'OrderController@index')->name('index');
            Route::get('{id}/detail', 'OrderController@show')->name('show');
            Route::post('{id}/detail', 'OrderController@update');
            Route::get('leave-project/{id}', 'OrderController@leaveProject')->name('leave_project');
            Route::get('{id}/done-project', 'OrderController@doneProject')->name('done_project');
            Route::get('{id}/request-confirmation', 'OrderController@requestConfirmation')->name('request_confirmation_project');
            Route::post('{id}/add-message', 'OrderController@addMessage')->name('add_message');
        });
    });
});
