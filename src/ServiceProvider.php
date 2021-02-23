<?php

namespace Vannut\StatamicClimacell;

use Statamic\Facades\CP\Nav;
use Statamic\Providers\AddonServiceProvider;

class ServiceProvider extends AddonServiceProvider
{
    protected $routes = [
        // 'actions' => __DIR__.'/../routes/actions.php',
        'cp' => __DIR__.'/../routes/cp.php',
    ];

    protected $tags = [
    ];

    // protected $modifiers = [
    // ];

    // protected $middlewareGroups = [
    //     'statamic.cp.authenticated' => [
    //     ],
    //     'web' => [
    //     ],
    // ];

    public function boot()
    {
        parent::boot();
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'climacell');

        $this->app->booted(function () {
            $this->navigation();
        });
    }

    protected function navigation()
    {
        Nav::extend(function ($nav) {
            $nav->content('ClimaCell')
                ->route('climacell.settings')
                ->icon('sun');
        });
    }
}