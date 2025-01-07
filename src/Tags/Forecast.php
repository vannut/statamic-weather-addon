<?php

namespace Vannut\StatamicWeather\Tags;

use Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Collection;
use Vannut\StatamicWeather\Settings;
use Vannut\StatamicWeather\Actions\CreateForecastDataFromJsonAction;

class Forecast extends \Statamic\Tags\Tags
{   
    // {{ forecast locale="nl"  location-identifier="ddfgg" }} {{ /forecast }}
    public function index(): array
    {
        $locale = strtolower($this->params->get('locale'));
        $locationIdentifier = $this->params->get('location-identifier');
        $settings = (new Settings)->get();
        $fileName = 'weather-forecast-'.$locationIdentifier.'.json';
        
        if (! Storage::exists($fileName)) {
            throw new \Exception("Forecast not found", 1);
        }
        
        $json = json_decode(Storage::get($fileName), true);

        
        $data = (new CreateForecastDataFromJsonAction)
            ->json(
                $json, 
                $locale ?? 'en',
                $settings['units'] ?? 'metric'
            );

        // remove gthe first day as that is _today_
        $data['days']->shift();
        
        
        return $data['days']->toArray();
    }
}