@extends('layouts.page')

@section('body')
    {!! Form::open()->route('groups.docker_images.store', compact('group')) !!}
        @include('groups.docker_images.form')
    {!! Form::close() !!}
@endsection
