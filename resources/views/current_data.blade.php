@extends('statamic::layout')
@section('title', 'Current data')
@section('wrapper_class', 'max-w-2xl ml-0')

@section('content')


<div>
    <header class="mt-3 mb-2">
        <div class="flex items-center justify-between">
            <h1>Current Data</h1>
            <form
                title="Fetch current Weather"
                method="post"
                action="{{ cp_route('weather.data.fetchWeather') }}"
            >
                <button class="btn-primary" type="submit">Fetch/update</button>
                @csrf
            </form>
        </div>
    </header>
    <div class="card overflow-hidden p-0">
        <table class="data-table">
            <thead>
                <tr>
                    <th class="group rounded-none"
                    style="width:75px">
                        Identifier
                    </th>
                    <th class="group rounded-none"
                        style="width: 250px">
                        Location
                    </th>
                    <th class="group rounded-none">
                        Current
                    </th>
                    <th class="group rounded-none"
                        style="width: 250px">
                        Fetched At
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach($locations as $location)
                    <tr>
                        <td>
                            <code>{{ $location['id'] }}</code>
                        </td>
                        <td>
                            <span class="text-primary text-lg">
                                {{ $location['location_identifier']}}
                            </span>
                        </td>
                        <td class="flex items-center gap-6">
                            @if(isset($location['data']['current']))
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-thermometer-half" viewBox="0 0 16 16">
                                        <path d="M9.5 12.5a1.5 1.5 0 1 1-2-1.415V6.5a.5.5 0 0 1 1 0v4.585a1.5 1.5 0 0 1 1 1.415z"/>
                                        <path d="M5.5 2.5a2.5 2.5 0 0 1 5 0v7.55a3.5 3.5 0 1 1-5 0V2.5zM8 1a1.5 1.5 0 0 0-1.5 1.5v7.987l-.167.15a2.5 2.5 0 1 0 3.333 0l-.166-.15V2.5A1.5 1.5 0 0 0 8 1z"/>
                                    </svg>
                                    {{ round($location['data']['current']['temp']) }}
                                    <span class="text-gray-700">{!! $location['data']['current']['units']['temp'] !!}</span>
                                </div>
                                <div>
                                    {{ $location['data']['current']['pressure'] }}
                                    <span class="text-gray-700">hPa</span>
                                </div>
                                <div class="flex items-center ">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-wind" viewBox="0 0 16 16">
                                        <path d="M12.5 2A2.5 2.5 0 0 0 10 4.5a.5.5 0 0 1-1 0A3.5 3.5 0 1 1 12.5 8H.5a.5.5 0 0 1 0-1h12a2.5 2.5 0 0 0 0-5zm-7 1a1 1 0 0 0-1 1 .5.5 0 0 1-1 0 2 2 0 1 1 2 2h-5a.5.5 0 0 1 0-1h5a1 1 0 0 0 0-2zM0 9.5A.5.5 0 0 1 .5 9h10.042a3 3 0 1 1-3 3 .5.5 0 0 1 1 0 2 2 0 1 0 2-2H.5a.5.5 0 0 1-.5-.5z"/>
                                    </svg>
                                    <span>&nbsp;
                                        {{ $location['data']['current']['wind_compass']}} {{ $location['data']['current']['wind_bft'] }}<span
                                            class="text-gray-700">Bft</span>
                                    </span>
                                </div>
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 256 256"><path d="M160,40A88.09,88.09,0,0,0,81.29,88.67,64,64,0,1,0,72,216h88a88,88,0,0,0,0-176Zm0,160H72a48,48,0,0,1,0-96c1.1,0,2.2,0,3.29.11A88,88,0,0,0,72,128a8,8,0,0,0,16,0,72,72,0,1,1,72,72Z"></path></svg>
                                    <span>&nbsp;
                                        {{ $location['data']['current']['cloudcover']}} 
                                        <span class="text-gray-700">%</span>
                                    </span>
                                </div>
                                <div class="flex items-center">
                                    <svg style="color:{{$location['data']['current']['uvi_color']}}"
                                        xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-sun-fill" viewBox="0 0 16 16">
                                        <path d="M8 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8zM8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0zm0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13zm8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5zM3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8zm10.657-5.657a.5.5 0 0 1 0 .707l-1.414 1.415a.5.5 0 1 1-.707-.708l1.414-1.414a.5.5 0 0 1 .707 0zm-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0zm9.193 2.121a.5.5 0 0 1-.707 0l-1.414-1.414a.5.5 0 0 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .707zM4.464 4.465a.5.5 0 0 1-.707 0L2.343 3.05a.5.5 0 1 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .708z"/>
                                    </svg>
                                    <span style="font-weight: 300; color:{{$location['data']['current']['uvi_color']}}">{{$location['data']['current']['uvindex']}}</span>
                                </div>
                            @else 
                                No data fetched
                            @endif
                        </td>
                        <td >
                            <span class="">
                                @if(isset($location['data']['current']))
                                    {{ \Carbon\Carbon::createFromTimestamp($location['data']['fetched_at'], 'Europe/Amsterdam')
                                        ->format('d M Y H:i ') }}
                                @endif
                            </span>
                        </td>
                    </tr>
                    
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-10 text-gray-700">
        Displaying the forecast in your templates is done through its forecast-tag. Use the identifier to specify which location to show.
        
    </div>
</div>


{{-- 

    @if( ! $json )
        <div>
            <header>
                <h1 class="mb-2">
                    No data stored
                </h1>
            </header>
            <div class="card content">
                <p>
                    We don't have any data stored yet.
                </p>
                <form
                    title="Fetch current Weather"
                    method="post"
                    action="{{ cp_route('weather.data.fetchWeather') }}"
                >
                    <button class="btn-primary" type="submit">Fetch/update</button>
                    @csrf
                </form>
            </div>
        </div>
    @else
        <div>
            <header class="mt-3 mb-2">
                <div class="flex items-center justify-between">
                    <h1>Current Data</h1>
                    <form
                        title="Fetch current Weather"
                        method="post"
                        action="{{ cp_route('weather.data.fetchWeather') }}"
                    >
                        <button class="btn-primary" type="submit">Fetch/update</button>
                        @csrf
                    </form>
                </div>
            </header>
            <div class="card p-2 content">
                <table>
                    @foreach($forecast['days'] as $day)
                        <tr>
                            <td>
                                <span
                                    class="text-primary text-lg">{{date('l',$day['dt'])}}</span>

                                <span class="text-xs">{{date('Y-m-d',$day['dt'])}}</span>
                            </td>
                            <td class="px-2">
                                {{$day['weather'][0]['description']}}
                            </td>
                            <td class="px-2">
                                {{ round($day['temp']['max']) }}
                                <span class="text-gray-700">{!! $day['temp_unit']!!}</span>
                            </td>
                            <td class="px-2">
                                {{ round($day['temp']['min']) }}
                                <span class="text-gray-700">{!! $day['temp_unit']!!}</span>
                            </td>
                            <td class="px-2">
                                {{ $day['wind_compass']}} {{ $day['wind_bft'] }}
                                <span class="text-gray-700">Bft</span>
                            </td>
                            <td>
                                {{ $day['pressure'] }}
                                <span class="text-gray-700">hPa</span>
                            </td>

                        </tr>
                    @endforeach
                </table>
                <div class="text-sm mt-2">
                    Fetched at {{ $forecast['fetched_at'] }}
                </div>
            </div> 

            <header class="mt-3 mb-2">
                <h1>Raw JSON</h1>
            </header>
            <div class="card p-2 content">
                <textarea
                    id="field_textarea"
                    class="input-text"
                    style="width:100%; overflow-wrap: break-word; height: 450px;"
                >{{ $json }}</textarea>
            </div> 
        </div>
    @endif
    --}}


@endsection