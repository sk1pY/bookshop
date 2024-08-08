@extends('layouts.app')
@section('content')
    @foreach($categoryBooks as $books)

        {{$books->id}}
        {{$books->title}}
    @endforeach
@endsection
