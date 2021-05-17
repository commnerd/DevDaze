@extends('layouts.page')

@section('body')
    <div class="row">
        {!! Form::open()->route('groups.docker_images.update', compact('group', 'docker_image'))->put() !!}
            @include('groups.docker_images.form')
        {!! Form::close() !!}
    </div>
@endsection