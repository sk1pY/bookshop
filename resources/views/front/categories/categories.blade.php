@extends('layouts.app')
@section('content')
    <h4 class="text-center">{{ $category->name }}</h4>
    <hr>
    {{--FILTER--}}
    <div class="my-4">
        <form id="filterForm" method="get">
            <select class="form-select w-25" id="rating" name="filter" form="filterForm"
                    onchange="this.form.submit()">

                <option value="">Выберите фильтр</option>
                <option value="cheap" {{ request('filter') === 'cheap' ? 'selected' : '' }} >Сначала дешевые
                </option>
                <option value="expensive" {{ request('filter') === 'expensive' ? 'selected' : '' }}>Сначала
                    дорогие
                </option>
                <option value="rating" {{ request('filter') === 'rating' ? 'selected' : '' }}>По рейтингу
                </option>
            </select></form>
    </div>
    {{--FILTER--}}
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
