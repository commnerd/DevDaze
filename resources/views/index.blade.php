@extends('layouts.page')

@section('body')
    <header class="row">
        <div class="col-12">
            <h1 class="d-flex justify-content-center">Dev Daze</h1>
        </div>
    </header>
    <div class="col-12">
        <div id="terminal"></div>
    </div>
    <div class="col-12">
        <h2 class="d-flex justify-content-center">Projects</h2>
    </div
    @if(sizeof($groups) > 0)
        <div class="row">
            <table width="100%">
                @foreach($groups as $group)
                <tr>
                    <td>
                        <a href="{{ route('groups.edit', $group->id) }}">{{ $group->title }}</a>
                    </td>
                    <td>
                        <a href="{{ $group->url }}">{{ $group->url }}</a>
                    </td>
                    <td>
                        {!! Form::open()->formInLine()->route('groups.destroy', compact('group'))->delete() !!}
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
                    No groups.
                </div>
        </div>
    @endif
    <div class="row">
        <div class="col-12">
            <a href="{{ route('groups.create') }}" class="btn btn-primary">Add Group</a>
        </div>
    </div>
    <div class="row snap-bottom" style="align-self: flex-end">
        <div class="col-12">
            <iframe src="http://localhost:7681" width="100%"></iframe>
        </div>
    </div>
@endsection
