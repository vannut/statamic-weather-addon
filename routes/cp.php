<?php

Route::namespace('\Vannut\StatamicWeather\Controllers')->group(function () {
    Route::prefix('weather')->as('weather')->group(function () {

        Route::get('/', 'ControlPanelController@index')->name('.settings');
        Route::post('/update-settings', 'ControlPanelController@update')->name('.settings.update');

    });
});