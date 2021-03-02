<?php

namespace Vannut\StatamicWeather\Tags;

use Storage;
use Illuminate\Support\Collection;

class Forecast extends \Statamic\Tags\Tags
{
    // {{ forecast locale="nl" }} {{ /forecast }}
    public function index(): Collection
    {
        $locale = strtolower($this->params->get('locale'));

        $json = json_decode(Storage::get('weather-forecast.json'), true);
        $daily = collect($json['daily'])
            ->map(function ($item) use($locale) {

                $item['icon'] = $this->makeIcon($item['weather']);
                $item['wind_compass'] = $this->degreeesToWindDirection($item['wind_deg'], $locale);
                $item['wind_bft'] = $this->msToBft($item['wind_speed']);
                $item['uvi_color'] = $this->UVIndexToColor($item['uvi']);
                $item['uvi_percentage'] = $this->UVIndexToPercentage($item['uvi']);
                return $item;
            });

        return $daily;
    }

    private function degreeesToWindDirection($degrees, $locale): String
    {
	    return $this->directions($locale)[round($degrees / 22.5)];
    }
    private function directions($locale): Array
    {
        if ($locale === 'nl') {
            return [
                'N', 'NNO', 'NO', 'ONO',
                'O', 'OZO', 'ZO', 'ZZO',
                'Z', 'ZZW', 'ZW', 'WZW',
                'W', 'WNW', 'NW', 'NNW',
                'N'
            ];
        } else {
            return [
                'N', 'NNE', 'NE', 'ENE',
                'E', 'ESE', 'SE', 'SSE',
                'S', 'SSW', 'SW', 'WSW',
                'W', 'WNW', 'NW', 'NNW',
                'N'
            ];
        }
    }

    private function msToBft($ms): Int
    {
        if ($ms < 0.3)      { return 0; }
        else if($ms < 1.6)  { return 1;}
        else if($ms < 3.4)  { return 2;}
        else if($ms < 5.5)  { return 3;}
        else if($ms < 8)    { return 4;}
        else if($ms < 10.8)  { return 5;}
        else if($ms < 13.9)  { return 6;}
        else if($ms < 17.2)  { return 7;}
        else if($ms < 20.8)  { return 8;}
        else if($ms < 24.5)  { return 9;}
        else if($ms < 28.5)  { return 10;}
        else if($ms < 32.6)  { return 11;}
        else { return 12;}
    }
    private function UVIndexToPercentage($index): int {
        $per = round(( $index / 10 ) * 100);
        if ($per > 100) {
            $per = 100;
        }
        return $per;
    }
    private function UVIndexToColor($index): String
    {
        $index = round($index);

        if ($index <= 2) {
            // blauw
            return '#93C5FD';
        } else if ($index <= 4) {
            //geel
            return '#FDE047';
        } else if ($index <= 6) {
            //oranje
            return '#F59E0B';
        } else if ($index <= 8) {
            // rood
            return '#B91C1C';
        } else {
            // paars
            return '#BE185D';
        }
    }


    private function makeIcon($arr): String
    {
        $icon = $arr[0]['icon'];
        $lookup = collect([
            '01' => 'fa-sun', //clear sky
            '02' => 'fa-sun-cloud', // few clouds
            '03' => 'fa-clouds-sun', // scattered clouds
            '04' => 'fa-clouds', // broken clouds
            '09' => 'fa-cloud-showers', // shower rain
            '10' => 'fa-cloud-sun-rain', // rain
            '11' => 'fa-thunderstorm', // thunderstorm
            '13' => 'fa-cloud-snow', // snow
            '50' => 'fa-fog', // mist
        ]);

        return $lookup->get(
            \substr($icon,0,2),
            'fa-water'
        );
    }
}