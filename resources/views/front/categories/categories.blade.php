@extends('layouts.app')
@section('content')
    <h4 class="text-center">{{ $category->name }}</h4>
    <hr>
    @include('partials.filter')
    <input type="hidden" id="category-slug" value="{{ $category->slug }}">

    {{--BOOKS--}}
    <div class="row row-cols-2 row-cols-md-4 row-cols-lg-5 g-4" id="search-cards">
        @forelse($books as $book)
            <div class="col">
                @include('partials.book-card')
            </div>
        @empty
                <h3 class="w-auto">Ничего не найдено</h3>
        @endforelse
    </div>
    {{--BOOKS--}}
    <div class="mt-3 ">{{$books->links('pagination::bootstrap-5')}}</div>

@endsection
