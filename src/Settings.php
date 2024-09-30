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

        $this->blueprint = Blueprint::make()->setContents([
            'sections' => [
                'main' => [
                    'display' => 'Locations',
                    'fields' => [
                        ['handle' => 'locations',  
                            'field' => [
                                'type'=>'grid', 
                                'display'=> 'Locations',
                                'fields' => [
                                    ['handle' => 'location_identifier',
                                        'field' => [
                                            'type' => 'text',
                                            'display' => 'Location identifier'
                                        ]
                                    ],
                                    ['handle' => 'lat',
                                        'field' => [
                                            'type' => 'text',
                                            'display' => 'Latitude'
                                        ]
                                    ],
                                    ['handle' => 'lon',
                                        'field' => [
                                            'type' => 'text',
                                            'display' => 'Longitude'
                                        ]
                                    ],

                                ]
                            ]
                        ]
                    ]
                ],
                'settings' => [
                    'display' => 'Settings',
                    'fields' => [
                        ['handle' => 'api_secret_key', 
                            'field' => [
                                'display' => 'API key',
                                'validate' => 'required',
                                'type'=>'text'
                            ]
                        ],
                        ['handle' => 'units', 
                            'field' => [
                                'display' => 'Units',
                                'validate' => 'required',
                                'type'=>'select',
                                'default' => 'metric',
                                'options' => [
                                    'metric' => 'Metric (Celcius, meter/s)',
                                    'us' => 'US (Fahrenheit, miles/hour)',
                                ]
                            ]
                        ]
                    ]
                ]
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