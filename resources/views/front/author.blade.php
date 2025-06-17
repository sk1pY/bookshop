@extends('layouts.app')
@section('app-content')
    <h3 class="text-center"> {{$author->name.' '. $author->surname}}</h3>
    <hr>
    <input type="hidden" id="author-id" value="{{ $author->id }}">

    {{--BOOKS--}}
    <div class="row row-cols-2 row-cols-md-4 row-cols-lg-5 g-4" id="search-cards">
        @forelse($books as $book)
            <div class="col">
                @include('partials.book-card')
            </div>
        @empty
            <div class="col">
                <h3>Ничего не найдено</h3>
            </div>
        @endforelse
    </div>
    {{--BOOKS--}}

@endsection
