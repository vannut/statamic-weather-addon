<?php

namespace Vannut\StatamicWeather\Tags;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Collection;
use Vannut\StatamicWeather\Actions\CreateForecastDataFromJsonAction;
use Vannut\StatamicWeather\Settings;

class CurrentWeather extends \Statamic\Tags\Tags
{
    use \Vannut\StatamicWeather\ConversionTrait;

    protected static $aliases = ['current_weather'];


    // {{ current_weather locale="nl"  location-identifier="ddfgg" }} {{ /current_weather }}
    public function index(): Collection
    {
        $locale = strtolower($this->params->get('locale'));
        $locationIdentifier = $this->params->get('location-identifier');
        $settings = (new Settings)->get();
        $units = $settings['units'] ?? 'metric';

        $json = json_decode(Storage::get('weather-forecast-'.$locationIdentifier.'.json'), true);
        $data = (new CreateForecastDataFromJsonAction)
            ->json(
                $json,
                $locale ?? 'en',
                $units
            );
        return $data['current'];

    }
}
