<?php

namespace Vannut\StatamicWeather\Controllers;

use Storage;
use Illuminate\Http\Request;
use Statamic\Facades\CP\Toast;

use Vannut\StatamicWeather\Settings;

use Statamic\Http\Controllers\CP\CpController;
use Vannut\StatamicWeather\Actions\FetchAndStoreAction;
use Vannut\StatamicWeather\Actions\CreateForecastDataFromJsonAction;


class ControlPanelController extends CpController
{
    public $settings;

    public function __construct() {
        $this->settings = new Settings;
    }

    public function cpIndex() {
        return redirect()->to(cp_route('weather.data'));
    }

    public function currentData(){
        $settings = $this->settings->get();
        $locations = collect($settings['locations']);

        $locations->transform(function ($location) use ($settings) {
            $fileName = 'weather-forecast-'.$location->id.'.json';

            if (Storage::exists($fileName)) {
                $json = json_decode(Storage::get($fileName), true);

                $location->data = (new CreateForecastDataFromJsonAction)
                    ->json(
                        $json, 
                        $settings['locale'] ?? 'en',
                        $settings['units'] ?? 'metric'
                     );
            } else {
                $location->data = null;
            }

            return collect($location);

        });
     
        



        return view('weather::current_data', [
            'locations' => $locations
        ]);
    }

    public function index()
    {

        // Get an array of values from the item that you want to be populated
        // in the form. eg. ['title' => 'My Product', 'slug' => 'my-product']
        $values = $this->settings->get();
                
        $values['locations'] = collect($values['locations'])->transform(function ($item) {
            return (array) $item;
        })->toArray();
        
        // Get a Fields object, a representation of the fields in a blueprint
        // that factors in imported fieldsets, config overrides, etc.
        $fields = $this->settings->blueprint->fields()
            ->addValues($values->toArray())
            ->preProcess();

        // The vue component will need these three values at a minimum.
        return view('weather::settings', [
            'blueprint' => $this->settings->blueprint->toPublishArray(),
            'values'    => $fields->values(),
            'meta'      => $fields->meta(),
        ]);
    }


    public function update(Request $request)
    {

        // Get a Fields object, and populate it with the submitted values.
        $fields = $this->settings->blueprint
            ->fields()
            ->addValues($request->all());

        // Perform validation. Like Laravel's standard validation, if it fails,
        // a 422 response will be sent back with all the validation errors.
        $fields->validate();

        // Perform post-processing. This will convert values the Vue components
        // were using into values suitable for putting into storage.
        $values = $fields->process()->values();

        // Do something with the values. Here we'll update the product model.
        $this->settings->save($values);

        // Return something if you want. But it's not even necessary.
    }


    public function fetchWeather()
    {

        $success = (new FetchAndStoreAction($this->settings->get()))->execute();

        if ($success) {
            Toast::success('Data updated');
        } else {
            Toast::error('Something went wrong');
        }
        return redirect()->back();

    }




}