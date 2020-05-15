<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Rotas Munícipe
|--------------------------------------------------------------------------
|
 */

Route::group(['middleware' => ['web']], function () {
    Route::get('/', 'MunicipeController@verificaLogin')->name('verificaLogin');
    Route::post('login', 'MunicipeController@login')->name('login');
    Route::get('/sair', 'MunicipeController@sair')->name('sair');
    Route::get('/consultaDemonstrativoMensal', 'MunicipeController@consultaDemonstrativoMensal')->name('consultaDemonstrativoMensal');
    Route::post('buscaContrachequeMensal', 'MunicipeController@buscaContrachequeMensal')->name('buscaContrachequeMensal');
    Route::post('geraPdfMensal', 'MunicipeController@geraPdfMensal')->name('geraPdfMensal');


});
