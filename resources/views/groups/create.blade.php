@extends('layouts.page')

@section('body')
    {!! Form::open()->route('groups.store') !!}
        @include('groups.form')
    {!! Form::close() !!}
@endsection