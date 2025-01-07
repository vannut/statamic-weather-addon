<?php
// Use for FRONTEND
Route::namespace('\Vannut\StatamicWeather\Controllers')
    ->name('weather.action')
    ->middleware(['throttle:60,1'])
    ->group(function () {

        Route::get(
            '/today/{identifier}',
            'ApiController@today'
        )->name('.today');

    });