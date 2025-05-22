@extends('layouts.app')
@section('content')
        <h1>{{$author->name.' '. $author->surname}}</h1>

        {{--BOOKS--}}
        @forelse($books as $book)
        @include('partials.book-card')
        @empty
            <div class="col">
                <h3>Ничего не найдено</h3>
            </div>
        @endforelse
        {{--BOOKS--}}

        @endsection
