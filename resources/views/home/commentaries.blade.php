@extends('home.index')
@section('commentaries')

    <h1>Мои отзывы</h1>
    @foreach( $commentaries as $commentary )
        <p>{{ $commentary -> text }}</p>
    @endforeach
        @endsection
