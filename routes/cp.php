<?php

Route::namespace('\Vannut\ClimaCell\Controllers')->group(function () {
    Route::prefix('climacell')->as('climacell')->group(function () {

        Route::get('/', 'ControlPanelController@index')->name('.settings');
        Route::post('/update-settings', 'ControlPanelController@update')->name('.settings.update');

    });
});