<?php

    /*
    |--------------------------------------------------------------------------
    | Rota de Exemplo
    |--------------------------------------------------------------------------
    |
    | Esta é uma rota de exemplo apenas para teste.
    | Está disponivel apenas quando o Laravel é executado em modo de Debug.
    | Com as diretivas do arquivo .env setadas adequadamente:
    |
    | APP_DEBUG=true
    | APP_ENV=local
    */

    Route::namespace('OldExtended\Http\Controllers')->group(function () {

        Route::get('/old-extended', 'ExampleController@edit')->name('old-extended.edit');
        Route::put('/old-extended', 'ExampleController@update')->name('old-extended.update');
        Route::put('/old-extended/reset', 'ExampleController@reset')->name('old-extended.reset');

    });
