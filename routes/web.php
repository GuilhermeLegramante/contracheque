<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Rotas Contracheque
|--------------------------------------------------------------------------
|
 */

Route::group(['middleware' => ['web']], function () {
    Route::get('/', 'ContrachequeController@verificaLogin')->name('verificaLogin');
    Route::get('/recuperarSenha', 'ContrachequeController@recuperarSenha')->name('resgateSenha');
    Route::get('/buscarPin', 'ContrachequeController@buscarPin')->name('buscarPin');
    Route::post('salvarNovaSenha', 'ContrachequeController@salvarNovaSenha')->name('salvarNovaSenha');
    Route::post('enviarPin', 'ContrachequeController@enviarPin')->name('enviarPin');
    Route::post('login', 'ContrachequeController@login')->name('login');
    Route::get('/painel', 'ContrachequeController@painel')->name('painel');

    Route::get('/sair', 'ContrachequeController@sair')->name('sair');
    Route::get('/consultaDemonstrativoMensal', 'ContrachequeController@consultaDemonstrativoMensal')->name('consultaDemonstrativoMensal');
    Route::get('/consultaDemonstrativoPeriodo', 'ContrachequeController@consultaDemonstrativoPeriodo')->name('consultaDemonstrativoPeriodo');
    Route::post('buscaContrachequeMensal', 'ContrachequeController@buscaContrachequeMensal')->name('buscaContrachequeMensal');
    Route::post('geraPdfMensal', 'ContrachequeController@geraPdfMensal')->name('geraPdfMensal');
    Route::post('geraPdfPeriodo', 'ContrachequeController@geraPdfPeriodo')->name('geraPdfPeriodo');
});
