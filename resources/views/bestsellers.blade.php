@extends('layouts.app')
@section('content')
    <h1>Bestsellers</h1>
    {{--FILTER--}}
    <div class="my-4">
        <form  id="filterForm" method="get">

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
    {{--BOOKS--}}
    @include('partials.book-card')
    {{--BOOKS--}}
    <div class="mt-4">
        {{ $books->links('pagination::bootstrap-5') }}
    </div>
@endsection('content')
