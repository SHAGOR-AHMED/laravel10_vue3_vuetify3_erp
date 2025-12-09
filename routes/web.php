<?php

use Illuminate\Support\Facades\Route;

Route::namespace('App\Http\Controllers')->group(function(){ 

    Route::get('/', 'Auth\LoginController@index')->name('login');
    Route::post('login-check', 'Auth\LoginController@authenticate');
    Route::get('do-logout',     'Auth\LoginController@logout');
    
});

Route::namespace('App\Http\Controllers')->group(function(){ 
 
    // Admin
    Route::namespace('Admin')->prefix('admin')->group(function(){

        Route::get('/dashboard', 'DashboardController@index');
        Route::get('{any?}', 'DashboardController@index');

        //Users
        Route::middleware('can:administration')->namespace('User')->prefix('user')->group(function(){
            Route::get('/index',                 'IndexController@index');
            Route::post('/store',                'IndexController@store');
            Route::put('/update',                'IndexController@update');
            Route::delete('/destroy/{id}',       'IndexController@destroy');
            Route::post('/status/{id}',          'IndexController@status');
            Route::get('/get-roles',             'IndexController@getRoles');
            Route::put('/role-update',           'IndexController@updateRole');
        });

        //Employee
        Route::middleware('can:employee')->namespace('Employee')->prefix('employee')->group(function(){
            Route::get('/index',                 'IndexController@index');
            Route::post('/store',                'IndexController@store');
            Route::put('/update',                'IndexController@update');
            Route::delete('/destroy/{id}',       'IndexController@destroy');
            Route::post('/status/{id}',          'IndexController@status');
        });

         //Role 
        Route::namespace('Role')->prefix('role')->group(function(){
            Route::get('/index',                'IndexController@index');
            Route::post('/store',               'IndexController@store');
            Route::put('/update',               'IndexController@update');
            Route::delete('/destroy/{id}',      'IndexController@destroy');
            Route::post('/delete-all',          'IndexController@deleteAll');
        });

    });

    // User
    Route::namespace('Frontend')->group(function(){

        Route::get('/frontend', 'IndexController@index');
        Route::get('{any?}', 'IndexController@index');
    });

});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
