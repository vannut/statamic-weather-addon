<?php

namespace Vannut\StatamicWeather\Commands;

use Storage;
use Illuminate\Console\Command;
use Vannut\StatamicWeather\Settings;

class FetchForecast extends Command
{
    protected $signature = 'weather:fetchForecast';

    protected $description = 'Fetches the forecast';

    protected $config;

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $this->config = (new Settings)->get();
        $content = $this->fetch();

        // Do nothing when we don't get anything back
        if ($content === false) {
            return;
        }

        // Decode the json object, drop out when not a valid object
        $jsonObj = json_decode($content);
        if ($jsonObj === null && json_last_error() !== JSON_ERROR_NONE) {
            return;
        }

        // Store the JSON to be used by the tags and endpoints
        Storage::put('weather-forecast.json', json_encode($jsonObj));

    }

    public function fetch()
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
