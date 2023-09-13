<?php

use Illuminate\Support\Facades\Route;

Route::get('/login', 'AuthController@loginView')->name('loginView');
Route::post('/login', 'AuthController@login')->name('login');
Route::get('/sair', 'AuthController@logout')->name('logout');

Route::group(['middleware' => ['auth']], function () {
    Route::get('/', 'MainController@dashboard')->name('dashboard');

    Route::prefix('/usuario')->group(function () {
        Route::get('/', 'UserController@table')->name('user.table');
    });

    Route::prefix('/tipo-de-documento')->group(function () {
        Route::get('/', 'DocumentTypeController@table')->name('document-type.table');
    });
});
