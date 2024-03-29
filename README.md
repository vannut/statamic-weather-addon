# Weather Forecast

Display the current weather or a 7-day forecast for any lat/lon on earth.

> Attention: Find something broken or missing: please create [an issue](https://github.com/vannut/statamic-weather-addon/issues)!

## OpenWeatherMap
The weather data itself is coming from the OpenWeatherMap api. Especially the [One-Call API](https://openweathermap.org/api/one-call-api) which delivers all the relevant data in _one call_. And to make it even better: It's free for the first 1,000,000 calls/month (or 60 calls/minute)

## Installation
1. Install add on through composer: `composer require vannut/statamic-weather-addon`
2. [Create an account](https://home.openweathermap.org/users/sign_up) at OpenWeatherMap.
3.  After signing in go to API keys and generate a new one.
4.  Go to your Statamic Control Panel and look for the Weather entry. It should be in the sidebar.
5. Fill out the settings-form with your api-key, latitude & longitude
6. Go to the Current Data page and fetch your first weather forecast!
6. Or Go to the Command line and perform the first initial fetch of your specific data: `php artisan weather:fetchForecast`


## Renewing the forecast
Nothing is as changeable as the weather. Therefore this addon adds [a hourly call](https://github.com/vannut/statamic-weather-addon/blob/master/src/ServiceProvider.php#L25) to the scheduler of Statamic/Laravel.
All you have to do is make sure the scheduler is run, by means of a cron-job. Take a look at [Laravels documentation](https://laravel.com/docs/8.x/scheduling#running-the-scheduler) on this!

## Usage
This addon does not provide any styling, it _just_ caches the json response and passes the raw data through to the two tags.

You can find every field in the api-response on [the api-docs of openweathermap](https://openweathermap.org/api/one-call-api).

Next to the data provided by the API, the addon adds a couple of nice additional fields:
```
{{ icon }}           A fontawesome icon derived fron weather.0.icon
{{ wind_compass }}   Converted wind direction to N/S/SSW etc
{{ wind_bft }}       Wind speed in Beaufort
{{ uvi_color }}      Color representation of  the UV Index
{{ uvi_percentage }} Percentage where UVI 10 = 100%;
{{ fetched_at }}     Unix Epoch timestamp of the datetime when fetched from API
```

You'll have two tags to your disposal: `{{ forecast }}` and `{{ current_weather }}`

## Simple 7 day forecast
With the `{{ forecast }}` tag you will be able to display a card per day with the forecast.
This data is located in the `days` array which you can traverse and add your styling magic.

This is a very simple example:
```html
<div class="flex bg-neutral-100">
    {{ forecast :locale="site" }}
        {{ days }}
            <div class="rounded-xl bg-white">
                <div class="lining-nums p-4 text-center">
                    {{ dt format_localized="%A" }}<br>
                    {{ dt format_localized="%e %b %Y"  }}
                </div>
                <div class="pb-4 text-5xl flex justify-center">
                    <i class="fal {{ icon }}"></i>
                </div>
                <div class="pb-2 flex items-center justify-center">
                    <div>
                        {{ temp.max | round }}<span class="text-neutral-700">&deg;C</span>
                    </div>
                    <div class="text-sm">
                        <span class="text-neutral-700">&nbsp;&nbsp; / </span>
                        {{ temp.min | round }}<span class="text-neutral-700">&deg;C</span>
                    </div>
                </div>
                <div class="flex items-center justify-center pb-4">
                    <div>
                        <i class="fal fa-wind"></i>
                        {{ wind_compass }} {{ wind_bft  }}<span class="text-neutral-700">Bft</span>
                    </div>
                </div>
            </div>
        {{ /days }}
        <div>
            Forecast feched at: {{ fetched_at format_localized="%e %b %Y %H:%M" }} server time
        </div>
    {{/forecast }}
</div>
```

## Current weather
Want to display the current weather of your location? Use the `{{ current_weather }}` tag. As this is a json-collection you can get its data as following:

```html
    {{ current_weather }}
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

## Widget

You can add a basic Forecast widget to your CP dashboard, by adding it in your `/config/statamic/cp.php`:
```php
'widgets' => [
    'current_forecast',
]
```

---
<p>
<a href="https://statamic.com"><img src="https://img.shields.io/badge/Statamic-3.0+-FF269E?style=for-the-badge" alt="Compatible with Statamic v3"></a>
<a href="https://packagist.org/packages/vannut/statamic-weather-addon/stats"><img src="https://img.shields.io/packagist/v/vannut/statamic-weather-addon?style=for-the-badge" alt="Addon on Packagist"></a>
</p>