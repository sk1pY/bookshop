@extends('layouts.app')
@section('content')
    <h1>Книги на акции</h1>
    @include('partials.filter')

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
@endsection('content')
