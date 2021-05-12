@extends('layouts.page')

@section('body')
    <div class="row">
        {!! Form::open()->route('apps.update', ['app' => $app, 'docker_images' => $app->docker_images ?? []])->put() !!}
            @include('apps.form')
        {!! Form::close() !!}
    </div>
@endsection