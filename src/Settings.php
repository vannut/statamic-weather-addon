<?php
namespace Vannut\StatamicClimacell;

use Statamic\Facades\Blueprint;
use Illuminate\Support\Collection;
use Storage;

class Settings
{

    public $blueprint;
    private $values;
    private $settingsFileName = 'climacell_settings.json';

    public function __construct()
    {
        // load the values
        $this->values = $this->retrieveSettingsFromDisk();

        $this->blueprint = Blueprint::makeFromFields([
                'api_url' => [
                    'type' => 'text',
                    'validate' => 'required',
                    'width' => 100,
                    'default' => 'https://data.climacell.co/v4/',
                    'placeholder' => 'https://data.climacell.co/v4/'
                ],
                'api_secret_key' => [
                    'type' => 'text',
                    'validate' => 'required',
                    'width' => 100,
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