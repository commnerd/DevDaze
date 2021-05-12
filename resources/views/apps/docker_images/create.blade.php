@extends('layouts.page')

@section('body')
    {!! Form::open()->route('apps.docker_images.store', compact('app')) !!}
        @include('apps.docker_images.form')
    {!! Form::close() !!}
@endsection
