<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Rotas Munícipe
|--------------------------------------------------------------------------
|
 */

Route::group(['middleware' => ['web']], function () {
    Route::get('/', 'ContrachequeController@verificaLogin')->name('verificaLogin');
    Route::post('login', 'ContrachequeController@login')->name('login');
    Route::get('/sair', 'ContrachequeController@sair')->name('sair');
    Route::get('/consultaDemonstrativoMensal', 'ContrachequeController@consultaDemonstrativoMensal')->name('consultaDemonstrativoMensal');
    Route::get('/consultaDemonstrativoPeriodo', 'ContrachequeController@consultaDemonstrativoPeriodo')->name('consultaDemonstrativoPeriodo');
    Route::post('buscaContrachequeMensal', 'ContrachequeController@buscaContrachequeMensal')->name('buscaContrachequeMensal');
    Route::post('geraPdfMensal', 'ContrachequeController@geraPdfMensal')->name('geraPdfMensal');
    Route::post('geraPdfPeriodo', 'ContrachequeController@geraPdfPeriodo')->name('geraPdfPeriodo');


});
