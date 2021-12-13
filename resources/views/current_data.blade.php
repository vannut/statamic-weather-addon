@extends('statamic::layout')
@section('title', 'Current data')
@section('wrapper_class', 'max-w-full ml-0')

@section('content')


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
                                <span class="text-neutral-700">{!! $day['temp_unit']!!}</span>
                            </td>
                            <td class="px-2">
                                {{ round($day['temp']['min']) }}
                                <span class="text-neutral-700">{!! $day['temp_unit']!!}</span>
                            </td>
                            <td class="px-2">
                                {{ $day['wind_compass']}} {{ $day['wind_bft'] }}
                                <span class="text-neutral-700">Bft</span>
                            </td>
                            <td>
                                {{ $day['pressure'] }}
                                <span class="text-neutral-700">hPa</span>
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



@endsection