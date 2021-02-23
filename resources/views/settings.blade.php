@extends('statamic::layout')
@section('title', 'Climacell settings')
@section('wrapper_class', 'max-w-md ml-0')

@section('content')

    <publish-form
        title="ClimaCell api settings"
        action="{{ cp_route('climacell.settings.update') }}"
        :blueprint='@json($blueprint)'
        :meta='@json($meta)'
        :values='@json($values)'
    ></publish-form>

@endsection