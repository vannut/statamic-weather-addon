# Weather

This addon delivers a simple way to add a weatherforecast to your Rad Statamic Website.

> This is still a very early work in progress! Find something broken or missing: make an issue!

## OpenWeatherMap
The weather data is coming from the OpenWeatherMap api. Especially the [One-Call API](https://openweathermap.org/api/one-call-api) which delivers all the relevant data in _one call_. And to make it even better: It's free for the first 1,000,000 calls/month (or 60 calls/minute)

## How to use
1 - Create an account, register an application and copy over the appid in the settings form.
2 - Specify the latitude and longitude for the location you want to get the data from.

The addon will fetch the forecast every hour for you.

## Add forecast to you page
The addon will give you a `{{ forecast }}`-tag.
Use it to loop over the daily forecast. Depending on the location you will get anywhere between 6 and 10 days of forecast.
```html
{{ forecast }}
    {{ dt }}
    {{ sunrise }}
    {{ sunset }}

    {{ temp.day }}
    {{ temp.min }}
    {{ temp.max }}
    {{ temp.night }}
    {{ temp.eve }}
    {{ temp.morn }}
    {{ feels_like.day }}
    {{ feels_like.night }}
    {{ feels_like.eve }}
    {{ feels_like.morn }}

    {{ pressure }} HPa
    {{ humidty }} %
    {{ dew_point }} Celcius

    {{ wind_speed }} in m/s
    {{ wind_deg }} in degrees

    {{ clouds }} Cloud coverage in %
    {{ pop }} Probability of percipation in %
    {{ uvi }} UV Index

    {{  weather.0.id }}
    {{  weather.0.main }}
    {{  weather.0.description }}
    {{  weather.0.icon }}

    These are additions added by the addon:<br>
    {{ icon }} A fontawesome icon derived fron weather.0.icon
    {{ wind_compass }} Converted wind direction to N/S/SSW etc
    {{ wind_bft }} Wind speed in Beaufort
    {{ uvi_color }} Color representation of  the UV Index
{{ /forecast }}
```
