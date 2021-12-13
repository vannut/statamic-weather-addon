<?php

Route::namespace('\Vannut\StatamicWeather\Controllers')->group(function () {
    Route::prefix('weather')
    ->as('weather')
    ->group(function () {
        Route::get(
            '/',
            'ControlPanelController@cpIndex'
        )->name('.index');

        // Data routes
        Route::get(
            '/data',
            'ControlPanelController@currentData'
        )->name('.data');
        Route::post(
            '/fetch-weather',
            'ControlPanelController@fetchWeather'
        )->name('.data.fetchWeather');


        // Settings
        Route::get('/settings', 'ControlPanelController@index')->name('.settings');
        Route::post('/update-settings', 'ControlPanelController@update')->name('.settings.update');

    });
});