@extends('layouts.page')

@section('body')
    <header class="row">
        <div class="col-12">
            <h1 class="d-flex justify-content-center">Dev Daze</h1>
        </div>
    </header>
    <div class="col-12">
        <h2 class="d-flex justify-content-center">Projects</h2>
    </div
    @if(sizeof($apps) > 0)
        <div class="row">
            <table width="100%">
                @foreach($apps as $app)
                <tr>
                    <td>
                        <a href="{{ route('apps.edit', $app->id) }}">{{ $app->title }}</a>
                    </td>
                    <td>
                        <a href="{{ $app->url }}">{{ $app->url }}</a>
                    </td>
                    <td>
                        {!! Form::open()->formInLine()->route('apps.destroy', compact('app'))->delete() !!}
                            <input type="submit" value="Delete" />
                        {!! Form::close() !!}
                    </td>
                </tr>
                @endforeach
            </table>
        </div>
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