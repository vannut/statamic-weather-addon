<?php

namespace Vannut\StatamicWeather\Tags;

use Storage;
use Illuminate\Support\Collection;

class CurrentWeather extends \Statamic\Tags\Tags
{
    use \Vannut\StatamicWeather\ConversionTrait;

    protected static $aliases = ['current_weather'];

    // {{ current_weather }} {{ /current_weather }}
    public function index(): Collection
    {
        $locale = strtolower($this->params->get('locale'));

        $json = json_decode(Storage::get('weather-forecast.json'), true);
        $current = collect($json['current']);

        // Enrich
        $current['icon'] = $this->makeIcon($current['weather']);
        $current['wind_compass'] = $this->degreeesToWindDirection($current['wind_deg'], $locale);
        $current['wind_bft'] = $this->msToBft($current['wind_speed']);
        $current['uvi_color'] = $this->UVIndexToColor($current['uvi']);
        $current['uvi_percentage'] = $this->UVIndexToPercentage($current['uvi']);

        return $current;
    }
}
