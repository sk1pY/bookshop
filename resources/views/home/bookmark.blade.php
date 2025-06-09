@extends('layouts.home')
@section('home-content')
    <h4>Избранное</h4>

    <div class="row g-4 mt-3">
        @forelse($bookmarks as $bookmark)
            @include('partials.book-card',['book'=> $bookmark->book])
        @empty
            <p>Нет избранных книг</p>
        @endforelse
    </div>

@endsection
