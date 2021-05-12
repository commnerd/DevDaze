@extends('layouts.page')

@section('body')
    {!! Form::open()->route('apps.store') !!}
        @include('apps.form')
    {!! Form::close() !!}
@endsection
