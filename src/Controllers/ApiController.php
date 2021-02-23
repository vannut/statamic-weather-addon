<?php

namespace Vannut\StatamicWeather\Controllers;

use Storage;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Vannut\StatamicWeather\Settings;
use Statamic\Http\Controllers\CP\CpController;

class ApiController extends CpController
{


    public function today() :Collection
    {
        // $nu = date('Y-m-d');
        // $jsonObject = json_decode(Storage::get('hetweer-forecast.json'), true);

        // $timeline = collect($jsonObject['data']['timelines'][0]['intervals'])
        //     ->first(function ($interval) use ($nu) {
        //         return Str::startsWith($interval['startTime'], $nu);
        //     })
        //     ;


        // return collect($timeline['values']);


    }
}
