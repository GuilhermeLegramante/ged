<?php

use Illuminate\Support\Facades\Route;

Route::get('/login', 'AuthController@loginView')->name('loginView');
Route::post('/login', 'AuthController@login')->name('login');
Route::get('/sair', 'AuthController@logout')->name('logout');

Route::get('/contador', 'AuthController@countPages')->name('count-pages');


Route::group(['middleware' => ['auth']], function () {
    Route::get('/', 'MainController@dashboard')->name('dashboard');

    Route::prefix('/documento')->group(function () {
        Route::get('/', 'DocumentController@table')->name('document.table');
    });

    Route::prefix('/pessoa')->group(function () {
        Route::get('/', 'PersonController@table')->name('person.table');
    });

    Route::prefix('/tipo-de-documento')->group(function () {
        Route::get('/', 'DocumentTypeController@table')->name('document-type.table');
    });

    Route::prefix('/usuario')->group(function () {
        Route::get('/', 'UserController@table')->name('user.table');
    });

    /**
     * ReportFilterController => Chama as views dos filtros
     * ReportController => Emite o pdf
     */
    Route::prefix('/relatorio')->group(function () {
        Route::get('/filtro/resumo-de-produtividade', 'ReportFilterController@productivityResume')->name('report.filter.productivityResume');
        Route::get('/resumo-de-produtividade', 'ReportController@productivityResume')->name('report.productivityResume');
    });
});
