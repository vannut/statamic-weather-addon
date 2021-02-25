<?php
namespace Vannut\StatamicWeather;

use Storage;
use Statamic\Facades\Blueprint;
use Illuminate\Support\Collection;

class Settings
{

    public $blueprint;
    private $values;
    private $settingsFileName = 'weather_settings.json';

    public function __construct()
    {
        // load the values
        $this->values = $this->retrieveSettingsFromDisk();

        $this->blueprint = Blueprint::makeFromFields([
                'api_url' => [
                    'type' => 'text',
                    'validate' => 'required',
                    'width' => 100,
                    'default' => 'https://api.met.no/weatherapi/locationforecast/2.0/',
                    'placeholder' => 'https://api.met.no/weatherapi/locationforecast/2.0'
                ],
                'api_secret_key' => [
                    'type' => 'text',
                    'validate' => 'required',
                    'width' => 100,
                ],
                'lat' => [
                    'type' => 'text',
                    'validate' => 'required',
                    'width' => 50,
                ],
                'lon' => [
                    'type' => 'text',
                    'validate' => 'required',
                    'width' => 50,
                ],


        ]);

    }

    public function get() :Collection
    {
        return $this->values;
    }

    public function save($values) :void
    {
        // store the settings into a json file
        Storage::put($this->settingsFileName, json_encode($values));
    }


    private function retrieveSettingsFromDisk() :Collection
    {
        $this->ensureSettingsFileExists();
        return collect(json_decode(Storage::get($this->settingsFileName)));
    }

    private function ensureSettingsFileExists() :void
    {
        if (Storage::missing($this->settingsFileName)) {
            Storage::put(
                $this->settingsFileName,
                json_encode([
                    'api_url' => null,
                    'api_secret_key' => null
                ])
            );
        };
    }

}