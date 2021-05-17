@extends('layouts.page')

@section('body')
    <div class="row">
        {!! Form::open()->route('groups.update', ['group' => $group, 'docker_images' => $group->docker_images ?? []])->put() !!}
            @include('groups.form')
        {!! Form::close() !!}
    </div>
    <h2>Docker Images</h2>
    <div class="row">
        <div class="col-12 well">
            @include('groups.docker_images.form-index', ['docker_images' => $group->docker_images])
        </div>
    </div>
@endsection