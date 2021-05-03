<?php

namespace Vannut\StatamicWeather\Tags;

use Storage;
use Illuminate\Support\Collection;

class Forecast extends \Statamic\Tags\Tags
{
    use \Vannut\StatamicWeather\ConversionTrait;

    // {{ forecast locale="nl" }} {{ /forecast }}
    public function index(): Collection
    {
        $locale = strtolower($this->params->get('locale'));

        $json = json_decode(Storage::get('weather-forecast.json'), true);
        $daily = collect($json['daily'])
            ->map(function ($item) use ($locale) {

                $item['icon'] = $this->makeIcon($item['weather']);
                $item['wind_compass'] = $this->degreeesToWindDirection($item['wind_deg'], $locale);
                $item['wind_bft'] = $this->msToBft($item['wind_speed']);
                $item['uvi_color'] = $this->UVIndexToColor($item['uvi']);
                $item['uvi_percentage'] = $this->UVIndexToPercentage($item['uvi']);
                $item['pop_per'] = $item['pop'] * 100;
                return $item;
            });

        return $daily;
    }


}