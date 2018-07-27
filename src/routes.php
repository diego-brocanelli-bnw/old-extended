<?php
/**
 * @see       https://github.com/rpdesignerfly/old-extended
 * @copyright Copyright (c) 2018 Ricardo Pereira Dias (https://rpdesignerfly.github.io)
 * @license   https://github.com/rpdesignerfly/old-extended/blob/master/license.md
 */

declare(strict_types=1);

// Este arquivo só é carregado quando o ambiente estiver configurado
// para APP_DEBUG = true ou APP_ENV = local
Route::namespace('OldExtended\Http\Controllers')->middleware(['web'])->group(function () {

    Route::get('/old-extended', 'ExampleController@edit')->name('old-extended.edit');
    Route::put('/old-extended', 'ExampleController@update')->name('old-extended.update');
    Route::put('/old-extended/reset', 'ExampleController@reset')->name('old-extended.reset');

});
