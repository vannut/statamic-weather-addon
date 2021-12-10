@extends('statamic::layout')
@section('title', 'Weather settings')
@section('wrapper_class', 'max-w-md ml-0')

@section('content')

    <form
        title="Fetch current Weather"
        method="post"
        action="{{ cp_route('weather.data.fetchWeather') }}"
    >
        <button class="btn-primary" type="submit">Fetch/update Weather data</button>
        @csrf
    </form>

    <h1 class="mt-4">Current Data</h1>
    @if( ! $json ) 
        <p><em>No data stored yet</em></p>
    @else 
        <div name="textarea">
            <textarea 
                id="field_textarea" 
                class="input-text" 
                style="width:100%; overflow-wrap: break-word; height: 450px;"
            >{{ $json }}</textarea>
        </div>
    @endif
    
    

@endsection