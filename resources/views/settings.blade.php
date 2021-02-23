@extends('statamic::layout')
@section('title', 'Weather settings')
@section('wrapper_class', 'max-w-md ml-0')

@section('content')

    <publish-form
        title="Weather api settings"
        action="{{ cp_route('weather.settings.update') }}"
        :blueprint='@json($blueprint)'
        :meta='@json($meta)'
        :values='@json($values)'
    ></publish-form>

@endsection