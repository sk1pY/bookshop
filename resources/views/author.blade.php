@extends('layouts.app')@section('content')
@foreach($booksOfAuthor as $book)

    {{ $book -> id }}
    {{ $book -> title }}
@endforeach
@endsection
