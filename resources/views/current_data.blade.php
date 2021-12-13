@extends('statamic::layout')
@section('title', 'Current data')
@section('wrapper_class', 'max-w-full ml-0')

@section('content')

    <form
        title="Fetch current Weather"
        method="post"
        action="{{ cp_route('weather.data.fetchWeather') }}"
    >
        <button class="btn-primary" type="submit">Fetch/update Weather data</button>
        @csrf
    </form>
    @if( ! $json ) 
        <p><em>No data stored yet</em></p>
    @else
        <div class="flex flex-wrap">
            <div class="lg:w-3/5 px-2">
                <h1 class="mt-4">Forecast</h1>
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
            <div class="lg:w-2/5 w-full">
                <h2 class="mt-4">Raw JSON Data</h2>
                    <div name="textarea">
                        <textarea 
                            id="field_textarea" 
                            class="input-text" 
                            style="width:100%; overflow-wrap: break-word; height: 450px;"
                        >{{ $json }}</textarea>
                    </div>    
            </div>
        </div>
    @endif
    
    

@endsection