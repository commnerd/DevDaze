@extends('layouts.page')

@section('body')
    <div class="row">
        {!! Form::open()->route('apps.update', ['app' => $app, 'docker_images' => $app->docker_images ?? []])->put() !!}
            @include('apps.form')
        {!! Form::close() !!}
    </div>
    <h2>Docker Images</h2>
    <div class="row">
        <div class="col-12 well">
            @include('apps.docker_images.form-index', ['docker_images' => $app->docker_images])
        </div>
    </div>
@endsection