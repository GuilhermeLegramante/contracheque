<?php

use Illuminate\Support\Facades\Route;

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

/*
Rotas de teste
 */

Route::get('testeFlash', function () {
    return view('admin.dashboard');
})->name('testeFlash');

Route::post('testeAjax', 'PrestadorController@testeAjax')->name('testeAjax');

Route::get('testeGate', function () {
    return view('admin.novoPrestador');
})->middleware('can:fiscal');

// Fim rotas de teste

/*
|--------------------------------------------------------------------------
| Rotas Válidas
|--------------------------------------------------------------------------
|
 */

Auth::routes();
Route::group(['middleware' => ['auth', 'can:fiscal']], function () {

    Route::get('/', function () {
        return view('fiscal.painel');
    })->name('fiscal.painel');
});

/*
|--------------------------------------------------------------------------
| Rotas PRESTADOR
|--------------------------------------------------------------------------
|
 */
Route::group(['middleware' => ['auth', 'can:fiscal']], function () {
    Route::get('fiscal/prestadores', 'PrestadorController@index')->name('prestadores');
    Route::get('fiscal/prestador/cadastro', 'PrestadorController@cadastro')->name('prestador.cadastro');
    Route::post('fiscal/prestador/salvar', 'PrestadorController@salvar')->name('prestador.salvar');
    Route::get('fiscal/prestador/detalhes/{id}', 'PrestadorController@detalhes')->name('prestador.detalhes');
    Route::get('fiscal/prestador/edicao/{id}', 'PrestadorController@editar')->name('prestador.edicao');
    Route::put('fiscal/prestadores/{id}', 'PrestadorController@atualizar')->name('prestador.atualizar');
    Route::delete('fiscal/prestadores/{id}', 'PrestadorController@excluir')->name('prestador.excluir');
    Route::any('fiscal/prestadores/buscaPelaRazaoSocial', 'PrestadorController@buscaPelaRazaoSocial')->name('prestador.buscaPelaRazaoSocial');
    Route::get('fiscal/prestadores/verTodos', 'PrestadorController@verTodos')->name('prestador.verTodos');
});


/*
|--------------------------------------------------------------------------
| Rotas TOMADOR
|--------------------------------------------------------------------------
|
 */
Route::group(['middleware' => ['auth', 'can:fiscal']], function () {
    Route::get('fiscal/tomadores', 'TomadorController@index')->name('tomadores');
    Route::get('fiscal/tomador/cadastro', 'TomadorController@cadastro')->name('tomador.cadastro');
    Route::post('fiscal/tomador/salvar', 'TomadorController@salvar')->name('tomador.salvar');
    Route::get('fiscal/tomador/detalhes/{id}', 'TomadorController@detalhes')->name('tomador.detalhes');
    Route::get('fiscal/tomador/edicao/{id}', 'TomadorController@editar')->name('tomador.edicao');
    Route::put('fiscal/tomadores/{id}', 'TomadorController@atualizar')->name('tomador.atualizar');
    Route::delete('fiscal/tomadores/{id}', 'TomadorController@excluir')->name('tomador.excluir');
    Route::any('fiscal/tomadores/buscaPelaRazaoSocial', 'TomadorController@buscaPelaRazaoSocial')->name('tomador.buscaPelaRazaoSocial');
    Route::get('fiscal/tomadores/verTodos', 'TomadorController@verTodos')->name('tomador.verTodos');
});

/*
|--------------------------------------------------------------------------
| Rotas Prestador NFS-e
|--------------------------------------------------------------------------
|
 */
Route::group(['middleware' => ['auth', 'can:fiscal']], function () {
    //Route::get('fiscal/nfse/', 'NotaFiscalController@index')->name('tomadores');
    Route::get('prestador/nfse/emissao/primeiraetapa', 'NfseController@emissaoPrimeiraEtapa')->name('prestador.nfse.emissao.primeiraetapa');
    Route::post('prestador/nfse/emissao/segundaetapa', 'NfseController@emissaoSegundaEtapa')->name('prestador.nfse.emissao.segundaetapa');
    Route::post('prestador/nfse/emissao/terceiraetapa', 'NfseController@emissaoTerceiraEtapa')->name('prestador.nfse.emissao.terceiraetapa');
    Route::post('prestador/nfse/emissao/emitir', 'NfseController@emitir')->name('prestador.nfse.emissao.emitir');

    //Route::post('fiscal/nfse/salvar', 'NfseController@salvar')->name('nfse.salvar');
    //Route::get('fiscal/nfse/detalhes/{id}', 'NfseController@detalhes')->name('nfse.detalhes');
    //Route::any('fiscal/nfse/buscaPrestador', 'NfseController@buscaPrestador')->name('nfse.buscaPrestador');
    //Route::any('fiscal/nfse/dadosPrestador', 'NfseController@dadosPrestador')->name('nfse.dadosPrestador');
    //Route::get('fiscal/tomadores/verTodos', 'TomadorController@verTodos')->name('tomador.verTodos');
    
});