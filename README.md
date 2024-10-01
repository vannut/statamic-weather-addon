# Weather Forecast

Display the current weather or a 7-day forecast for any lat/lon on earth.

> Attention: This version (2) is a complete rewrite of the addon. Although it does the same: display a weather forecast; the used weatherprovider is different and some of the fields are renamed. So please pay attention when upgrading.

## Visual Crossing
The weather data itself is coming from the Visual Crossing api. [It's free for the first 1,000 records a day.](https://www.visualcrossing.com/weather-data-editions)

## Installation
1. Install add on through composer: `composer require vannut/statamic-weather-addon "^2.0"`
2. [Create an account](https://www.visualcrossing.com/sign-up) at Visual Crossing.
3.  After signing in go to your account, you'll find a `Key`
4.  Go to your Statamic Control Panel and look for the Weather entry in the sidebar.
5. Fill out the settings-form with your api-key and create a location to fetch the forecast for.
6. Hit the fetch forecast button.
6. Or Go to the Command line and perform the first initial fetch of your specific data: `php artisan weather:fetchForecast`


## Renewing the forecast
Nothing is as changeable as the weather. Therefore this addon adds [a hourly call](https://github.com/vannut/statamic-weather-addon/blob/master/src/ServiceProvider.php#L25) to the scheduler of Statamic/Laravel.
All you have to do is make sure the scheduler is run, by means of a cron-job. Take a look at [Laravels documentation](https://laravel.com/docs/10.x/scheduling#running-the-scheduler) on this!

## Usage
This addon does not provide any styling, it _just_ caches the json response and passes the raw data through to the two tags.

You can find every field in the api-response on [the api-docs of Visual Crossing](https://www.visualcrossing.com/resources/documentation/weather-api/timeline-weather-api/).

Next to the data provided by the API, the addon adds a couple of nice additional fields:
```
{{ icon_fa }}           A fontawesome icon derived fron weather.0.icon
{{ wind_compass }}   Converted wind direction to N/S/SSW etc
{{ wind_bft }}       Wind speed in Beaufort
{{ uvi_color }}      Color representation of  the UV Index
{{ uvi_percentage }} Percentage where UVI 10 = 100%;
{{ fetched_at }}     Unix Epoch timestamp of the datetime when fetched from API
```

You'll have two tags to your disposal: `{{ forecast }}` and `{{ current_weather }}`

## Simple 7 day forecast
With the `{{ forecast }}` tag you will be able to display a card per day with the forecast.
It's a loop of different days in the forecast. Typically 7 or 15 days depending on the location.

Make sure you specify from which location you want the forecast: 
```html
<div class="flex bg-neutral-100">
    {{ forecast :locale="site" location-identifier="xyz123" }}
        <div class="rounded-xl bg-white">
            <div class="lining-nums p-4 text-center">
                {{ datetimeEpoch | iso_format("dddd") }}<br>
                {{ datetimeEpoch | iso_format("D MMM Y") }}<br>
            </div>
            <div class="pb-4 text-5xl flex justify-center">
                <i class="fal {{ icon_fa }}"></i>
            </div>
            <div class="pb-2 flex items-center justify-center">
                <div>
                    {{ tempmax | round }}<span class="text-neutral-700">&deg;C</span>
                </div>
                <div class="text-sm">
                    <span class="text-neutral-700">&nbsp;&nbsp; / </span>
                    {{ tempmin | round }}<span class="text-neutral-700">&deg;C</span>
                </div>
            </div>
            <div class="flex items-center justify-center pb-4">
                <div>
                    <i class="fal fa-wind"></i>
                    {{ wind_compass }} {{ wind_bft  }}<span class="text-neutral-700">Bft</span>
                </div>
            </div>
        </div>
    {{/forecast }}
</div>
```

## Current weather
Want to display the current weather of your location? Use the `{{ current_weather }}` tag. As this is a json-collection you can get its data as following:

```html
    {{ current_weather :locale="site" location-identifier="xyz123" }}
        <div class="bg-neutral-200 rounded-xl p-4 m-4">
            <div class="pb-4 text-5xl flex justify-center">
                <i class="fal {{ icon }}"></i>
            </div>
            <div>
                Current temperature: {{  temp }}<span class="text-neutral-700">&deg;C</span>
            </div>
            <div>
                Feels like: {{ feels_like }}<span class="text-neutral-700">&deg;C</span>
            </div>
        </div>
    {{ /current_weather }}
```

---
<p>
<a href="https://statamic.com"><img src="https://img.shields.io/badge/Statamic-5.0+-FF269E?style=for-the-badge" alt="Compatible with Statamic v5"></a>
<a href="https://packagist.org/packages/vannut/statamic-weather-addon/stats"><img src="https://img.shields.io/packagist/v/vannut/statamic-weather-addon?style=for-the-badge" alt="Addon on Packagist"></a>
</p>