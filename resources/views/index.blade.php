@extends('layouts.page')

@section('body')
    <header class="row">
        <div class="col-12">
            <h1>Dev Daze</h1>
        </div>
    </header>
    @if(sizeof($apps) > 0)
        @foreach($apps as $app)
            <div class="row">
                <div class="col-6">
                    <a href="{{ route('apps.edit', $app->id) }}">{{ $app->title }}</a>
                </div>
                <div class="col-6">
                    <a href="{{ $app->url }}">{{ $app->url }}</a>
                </div>
            </div>
        @endforeach
    @else
        <div class="row">
                <div class="col-12">
                    No applications currently running.
                </div>
        </div>
    @endif
    <div class="row">
        <div class="col-12">
            <a href="{{ route('apps.create') }}" class="btn btn-primary">Add Project</a>
        </div>
    </div>
@endsection