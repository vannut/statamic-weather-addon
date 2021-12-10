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
                // ->route('')
                ->icon('<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-cloud-sun" viewBox="0 0 16 16">
                        <path d="M7 8a3.5 3.5 0 0 1 3.5 3.555.5.5 0 0 0 .624.492A1.503 1.503 0 0 1 13 13.5a1.5 1.5 0 0 1-1.5 1.5H3a2 2 0 1 1 .1-3.998.5.5 0 0 0 .51-.375A3.502 3.502 0 0 1 7 8zm4.473 3a4.5 4.5 0 0 0-8.72-.99A3 3 0 0 0 3 16h8.5a2.5 2.5 0 0 0 0-5h-.027z"/>
                        <path d="M10.5 1.5a.5.5 0 0 0-1 0v1a.5.5 0 0 0 1 0v-1zm3.743 1.964a.5.5 0 1 0-.707-.707l-.708.707a.5.5 0 0 0 .708.708l.707-.708zm-7.779-.707a.5.5 0 0 0-.707.707l.707.708a.5.5 0 1 0 .708-.708l-.708-.707zm1.734 3.374a2 2 0 1 1 3.296 2.198c.199.281.372.582.516.898a3 3 0 1 0-4.84-3.225c.352.011.696.055 1.028.129zm4.484 4.074c.6.215 1.125.59 1.522 1.072a.5.5 0 0 0 .039-.742l-.707-.707a.5.5 0 0 0-.854.377zM14.5 6.5a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1h-1z"/>
                    </svg>')
                ->children([
                    'Settings' => cp_route('weather.settings'),
                    'Current Data' => cp_route('weather.data'),
                ]);
        });
    }
}