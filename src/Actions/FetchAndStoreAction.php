<?php

namespace Vannut\StatamicWeather\Actions;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Collection;

class FetchAndStoreAction {

    public function __construct(
        private Collection $config
    )  {}

    public function execute(): array
    {
        $key = config('services.weather.api_key');


        if(!$key) {
            return [
                'message' => 'no-api-key-provided',
            ];
        }

        $resultForLocations = [];

        foreach($this->config['locations'] ?? [] as $location)  {

            $content = $this->talkToWeatherService($location->lat,$location->lon, $key);

            // Do nothing when we don't get anything back
            if ($content === false) {
                $resultForLocations[$location->location_identifier] = 'no-response-from-api';
                break;
            }


            // Decode the json object, drop out when not a valid object
            $jsonObj = json_decode($content);
            if ($jsonObj === null && json_last_error() !== JSON_ERROR_NONE) {
                $resultForLocations[$location->location_identifier] = 'json-parse-error';
                break;
            }

            // add the fetch time
            $jsonObj = array_merge(["fetched_at" => now()->format('U')], (array) $jsonObj);



            // Store the JSON to be used by the tags and endpoints
            Storage::put('weather-forecast-'.$location->id.'.json', json_encode($jsonObj));
        };



        return $resultForLocations;

    }


    private function talkToWeatherService(
        $lat,
        $lng,
        string $key
    ): string|array {

        $lat = str_replace(',','.', $lat);
        $lng = str_replace(',','.', $lng);

        $endpoint = "https://weather.visualcrossing.com/VisualCrossingWebServices/rest/services/timeline"
            ."/".$lat.",".$lng
            ."?key=".$key
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
