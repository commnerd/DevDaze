@extends('layouts.page')

@section('body')
    <header class="row">
        <div class="col-12">
            <h1>Dev Daze</h1>
        </div>
    </header>
    @foreach($apps ?? '' as $app)
        <div class="row">
            <div class="col-6">
                <a href="#">{{ $app->title }}</a>
            </div>
            <div class="col-6">
                <a href="{{ $app->url }}">{{ $app->url }}</a>
            </div>
        </div>
    @endforeach
    <div class="row">
        <div class="col-12">
            <a href="{{ route('apps.create') }}" class="btn btn-primary">Add Project</a>
        </div>
    </div>
@endsection