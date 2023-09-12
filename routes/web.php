<?php

use Illuminate\Support\Facades\Route;

Route::get('/login', 'AuthController@loginView')->name('loginView');
Route::post('/login', 'AuthController@login')->name('login');
Route::get('/sair', 'AuthController@logout')->name('logout');

Route::group(['middleware' => ['auth']], function () {
    Route::get('/', 'MainController@dashboard')->name('dashboard');

    // Route::prefix('/cliente')->group(function () {
    //     Route::get('/', 'CustomerController@table')->name('customer.table');
    // });
});
