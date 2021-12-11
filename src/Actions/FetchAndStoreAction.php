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

        $content = $this->talkToOpenweathermap();

        // Do nothing when we don't get anything back
        if ($content === false) {
            return false;
        }

        // Decode the json object, drop out when not a valid object
        $jsonObj = json_decode($content);
        if ($jsonObj === null && json_last_error() !== JSON_ERROR_NONE) {
            return false;
        }

        // add the fetch time
        $jsonObj = array_merge(["fetched_at" => now()->format('U')], (array) $jsonObj);

        // Store the JSON to be used by the tags and endpoints
        Storage::put('weather-forecast.json', json_encode($jsonObj));

        return true;

    }


    private function talkToOpenweathermap(): string 
    {
        $endpoint = $this->config->get('api_url')
            .'onecall?lat='.$this->config->get('lat')
            .'&lon='.$this->config->get('lon')
            .'&exclude=minutely,hourly,alerts'
            .'&units='.$this->config->get('units', 'metric')
            .'&appid='.$this->config->get('api_secret_key')
            .'&lang='.$this->config->get('lang','en');


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