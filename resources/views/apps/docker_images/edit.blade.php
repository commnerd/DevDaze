@extends('layouts.page')

@section('body')
    <div class="row">
        {!! Form::open()->route('apps.docker_images.update', compact('app', 'docker_image'))->put() !!}
            @include('apps.docker_images.form')
        {!! Form::close() !!}
    </div>
@endsection