<?php

namespace Vannut\StatamicWeather\Actions;

use Storage;
use Illuminate\Support\Collection;

class FetchAndStoreAction {

    public function __construct(
        Collection $config
    ) {
        $this->config = $config;
    }

    public function execute(): bool 
    {

        foreach($this->config['locations'] as $location) {
            
            $content = $this->talkToWeatherService($location->lat,$location->lon);

            // Do nothing when we don't get anything back
            if ($content === false) {
                return false;
            }

            // Decode the json object, drop out when not a valid object
            $jsonObj = json_decode($content);
            if ($jsonObj === null && json_last_error() !== JSON_ERROR_NONE) {
                return false;
            }

            
            // Store the JSON to be used by the tags and endpoints
            Storage::put('weather-forecast_'.$location->id.'.json', json_encode($jsonObj));
        };

        

        return true;

    }


    private function talkToWeatherService(
        $lat,
        $lng
    ): string 
    {
        $lat = str_replace(',','.', $lat);
        $lng = str_replace(',','.', $lng);
        // $endpoint = $this->config->get('api_url')
        //     .'onecall?lat='.$this->config->get('lat')
        //     .'&lon='.$this->config->get('lon')
        //     .'&exclude=minutely,hourly,alerts'
        //     .'&units='.$this->config->get('units', 'metric')
        //     .'&appid='.$this->config->get('api_secret_key')
        //     .'&lang='.$this->config->get('lang','en');
        
        $endpoint = "https://weather.visualcrossing.com/VisualCrossingWebServices/rest/services/timeline"
            ."/".$lat.",".$lng
            ."?key=".$this->config->get('api_secret_key')
            ."&unitGroup=".$this->config->get('units', 'metric')
            ."&iconSet=icons2"
            ."&include=days,current,alerts";

        $headers = [
            'Content-Type:application/json',
        ];
        $ch = curl_init($endpoint);


        curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );

        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }

}