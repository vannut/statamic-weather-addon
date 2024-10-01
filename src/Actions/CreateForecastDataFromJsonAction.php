<?php

namespace Vannut\StatamicWeather\Actions;

use Storage;
use Illuminate\Support\Collection;
use Vannut\StatamicWeather\Settings;
use \Vannut\StatamicWeather\ConversionTrait;

class CreateForecastDataFromJsonAction {

    use ConversionTrait;

    public function json(
        array $json,
        string $locale,
        string $units
    ) {

        
        $current = $this->createCurrentConditions($json['currentConditions'], $locale, $units);
        $daily = $this->createDailyForecast($json['days'], $locale, $units);

        return collect([
            'fetched_at' => $json['fetched_at'], 
            'current' => $current,
            'days' => $daily
        ]);
    }

    private function createDailyForecast(
        array $source,
        string $locale,
        string $units
    ) : Collection {

        return collect($source)
            // transform the others
            ->transform(function ($item) use ($locale, $units) {

            $item['icon_fa'] = $this->transformToFontawesome($item['icon']);
            $item['wind_compass'] = $this->degreeesToWindDirection($item['winddir'], $locale);
            $item['wind_bft'] = ($units === 'metric')
                ? $this->kphToBft($item['windspeed'])
                : $this->mphToBft($item['windspeed']);
            $item['uvi_color'] = $this->UVIndexToColor($item['uvindex']);
            $item['uvi_percentage'] = $this->UVIndexToPercentage($item['uvindex']);
            $item['pop_per'] = $item['precipprob'];

            if ($units == 'metric') {
                $item['units'] = [
                    'temp' => '&deg;C'
                ];
            } else {
                $item['units'] = [
                    'temp' => '&deg;F'
                ];
                
            }
            return $item;
        });

    }

    private function transformtoFontawesome(
        string $icon
    ) : string {
        $lu = collect([
            'snow' => 'fa-snow-flake',
            'snow-showers-day' => 'fa-cloud-snow',
            'snow-showers-night' => 'fa-cloud-snow',

            'thunder-rain' => 'fa-cloud-bolt',
            'thunder-showers-day' => 'fa-cloud-bolt',
            'thunder-showers-night' => 'fa-cloud-bolt',

            'rain' => 'fa-cloud-showers',
            'showers-day' => 'fa-cloud-showers',
            'showers-night' => 'fa-cloud-showers',

            'fog' => 'fa-cloud-fog',
            'wind' => 'fa-wind',
            'cloudy' => 'fa-clouds',
            'partly-cloudy-day' => 'fa-cloud-sun',
            'partly-cloudy-night' => 'fa-cloud-moon',

            'clear-day' => 'fa-sun',
            'clear-night' => 'fa-moon-stars',
        ]);

        return $lu->get($icon, 'kkk');

    }



    private function createCurrentConditions(
        array $source,
        string $locale,
        string $units
    ) : Collection {

        $source['wind_compass'] = $this->degreeesToWindDirection($source['winddir'], $locale);
        $source['wind_bft'] = ($units === 'metric')
            ? $this->kphToBft($source['windspeed'])
            : $this->mphToBft($source['windspeed']);
        $source['uvi_color'] = $this->UVIndexToColor($source['uvindex']);
        $source['uvi_percentage'] = $this->UVIndexToPercentage($source['uvindex']);
        $source['pop_per'] = $source['precipprob'];

        if ($units == 'metric') {
            $source['units'] = [
                'temp' => '&deg;C'
            ];
        } else {
            $source['units'] = [
                'temp' => '&deg;F'
            ];
            
        }

        return collect($source);
                
        
    }   

}