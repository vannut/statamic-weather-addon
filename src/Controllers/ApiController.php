<?php

namespace Vannut\StatamicWeather\Controllers;

use Storage;
use Vannut\StatamicWeather\Settings;
use Statamic\Http\Controllers\CP\CpController;
use Vannut\StatamicWeather\Actions\CreateForecastDataFromJsonAction;

class ApiController extends CpController
{
    public function today(
        string $locationIdentifier
    )
    {
        $settings = (new Settings)->get();
        $fileName = 'weather-forecast-'.$locationIdentifier.'.json';
        
        if (! Storage::exists($fileName)) {
            return response(['not found'], 404);
        }
        
        $json = json_decode(Storage::get($fileName), true);

        return (new CreateForecastDataFromJsonAction)
        ->json(
            $json, 
            $settings['locale'] ?? 'en',
            $settings['units'] ?? 'metric'
        )['current'];
       
        
     
    }
}
