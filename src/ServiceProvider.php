<?php

namespace Vannut\StatamicWeather;

use Statamic\Facades\CP\Nav;
use Statamic\Providers\AddonServiceProvider;

class ServiceProvider extends AddonServiceProvider
{
    protected $routes = [
        'actions' => __DIR__.'/../routes/actions.php',
        'cp' => __DIR__.'/../routes/cp.php',
    ];

    protected $tags = [
        \Vannut\StatamicWeather\Tags\Forecast::class,
        \Vannut\StatamicWeather\Tags\CurrentWeather::class,
    ];

    protected $commands = [
        \Vannut\StatamicWeather\Commands\FetchForecast::class
    ];
    protected function schedule($schedule)
    {
        $schedule->command('weather:fetchForecast')->hourly();
    }

    public function boot()
    {
        parent::boot();
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'weather');

        $this->app->booted(function () {
            $this->navigation();
        });
    }

    protected function navigation()
    {
        Nav::extend(function ($nav) {
            $nav->content('Weather')
                ->route('weather.settings')
                ->icon('cloud');
        });
    }
}