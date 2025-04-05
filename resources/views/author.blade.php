@extends('layouts.app')
@section('content')
        <h1>{{$author->name.' '. $author->surname}}</h1>

        {{--BOOKS--}}
        @include('partials.book-card')
        {{--BOOKS--}}

@endsection
