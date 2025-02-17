<?php
namespace Vannut\StatamicWeather;

trait ConversionTrait {

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
	} elseif ($locale == 'de') {
            return [
                'N', 'NNO', 'NO', 'ONO',
                'O', 'OSO', 'SO', 'SSO',
                'S', 'SSW', 'SW', 'WSW',
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

    private function mphToBft($mph): Int
    {
        if ($mph < 1)      { return 0; }
        else if($mph < 4)  { return 1;}
        else if($mph < 8)  { return 2;}
        else if($mph < 13)  { return 3;}
        else if($mph < 19)    { return 4;}
        else if($mph < 25)  { return 5;}
        else if($mph < 32)  { return 6;}
        else if($mph < 39)  { return 7;}
        else if($mph < 47)  { return 8;}
        else if($mph < 54)  { return 9;}
        else if($mph < 64)  { return 10;}
        else if($mph < 73)  { return 11;}
        else { return 12;}
    }

    private function kphToBft($kph): Int
    {
        if ($kph < 1)      { return 0; }
        else if($kph < 6)  { return 1;}
        else if($kph < 12)  { return 2;}
        else if($kph < 20)  { return 3;}
        else if($kph < 29)    { return 4;}
        else if($kph < 39)  { return 5;}
        else if($kph < 50)  { return 6;}
        else if($kph < 62)  { return 7;}
        else if($kph < 75)  { return 8;}
        else if($kph < 89)  { return 9;}
        else if($kph < 103)  { return 10;}
        else if($kph < 117)  { return 11;}
        else { return 12;}
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
    private function UVIndexToPercentage($index): int
    {
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
