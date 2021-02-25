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
    public function today(): Collection
    {
        $jsonObject = json_decode(Storage::get('weather-forecast.json'), true);
        return collect($jsonObject['current']);
    }
}
