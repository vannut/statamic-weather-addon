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
                    'default' => 'https://api.openweathermap.org/data/2.5/',
                    'placeholder' => 'https://api.openweathermap.org/data/2.5/'
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
                'units' => [
                    'validate' => 'required',
                    'width' => 50,
                    'type' => 'select',
                    'default' => 'metric',
                    'options' => [
                        'metric' => 'Metric (Celcius, meter/s)',
                        'imperial' => 'Imperial (Fahrenheit, miles/hour)',
                    ]
                ],
                'lang' => [
                    'width' => 100,
                    'type' => 'select',
                    'default' => 'en',
                    'options' => [
                        'af' => 'Afrikaans',
                        'al' => 'Albanian',
                        'ar' => 'Arabic',
                        'az' => 'Azerbaijani',
                        'bg' => 'Bulgarian',
                        'ca' => 'Catalan',
                        'cz' => 'Czech',
                        'da' => 'Danish',
                        'de' => 'German',
                        'el' => 'Greek',
                        'en' => 'English',
                        'eu' => 'Basque',
                        'fa' => 'Persian (Farsi)',
                        'fi' => 'Finnish',
                        'fr' => 'French',
                        'gl' => 'Galician',
                        'he' => 'Hebrew',
                        'hi' => 'Hindi',
                        'hr' => 'Croatian',
                        'hu' => 'Hungarian',
                        'id' => 'Indonesian',
                        'it' => 'Italian',
                        'ja' => 'Japanese',
                        'kr' => 'Korean',
                        'la' => 'Latvian',
                        'lt' => 'Lithuanian',
                        'mk' => 'Macedonian',
                        'no' => 'Norwegian',
                        'nl' => 'Dutch',
                        'pl' => 'Polish',
                        'pt' => 'Portuguese',
                        'pt_br' => 'Português Brasil',
                        'ro' => 'Romanian',
                        'ru' => 'Russian',
                        'se' => 'Swedish',
                        'sk' => 'Slovak',
                        'sl' => 'Slovenian',
                        'es' => 'Spanish',
                        'sr' => 'Serbian',
                        'th' => 'Thai',
                        'tr' => 'Turkish',
                        'uk' => 'Ukrainian',
                        'vi' => 'Vietnamese',
                        'zh_cn' => 'Chinese Simplified',
                        'zh_tw' => 'Chinese Traditional',
                        'zu' => 'Zulu',
                    ],
                    'instructions' => 'select your language of choice, default EN',
                ]


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