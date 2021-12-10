<?php

namespace Vannut\StatamicWeather\Commands;

use Storage;
use Illuminate\Console\Command;
use Vannut\StatamicWeather\Settings;
use Vannut\StatamicWeather\Actions\FetchAndStoreAction;

class FetchForecast extends Command
{
    protected $signature = 'weather:fetchForecast';

    protected $description = 'Fetches the forecast';

    protected $config;

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $settings = (new Settings)->get();

        $success = (new FetchAndStoreAction($settings))->execute();

    }

    
}
