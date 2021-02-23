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
       if ($content === false) {
            return;
        }

        $jsonObj = json_decode($content);
        if ($jsonObj === null && json_last_error() !== JSON_ERROR_NONE) {
            return;
        }

        Storage::put('weather-forecast.json', json_encode($jsonObj));

    }

    public function fetch() {
        $endpoint = $this->config->get('api_url');
        return json_encode([]);
        // $postData = [
        //     "fields"    => [
        //         'temperature',
        //         'humidity',
        //         'windSpeed','windDirection', 'windGust',
        //         'pressureSurfaceLevel', 'pressureSeaLevel',
        //         'precipitationProbability',
        //         'sunriseTime','sunsetTime',
        //         'solarGHI',
        //         'cloudCover',
        //         'weatherCode'


        //     ],
        //     "timesteps" => ["1d"],
        //     'units'     => 'metric',
        //     'location'  => '6034f95b5f69510007cfff61'
        // ];
        // $headers = [
        //     'Content-Type:application/json',
        //     'apikey: '.$this->config->get('api_secret_key')
        // ];
        // $ch = curl_init($endpoint);
        // $payload = json_encode($postData);

        // curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );
        // curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers);
        // curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );

        // $result = curl_exec($ch);
        // curl_close($ch);

    //    return $result;

    }
}
