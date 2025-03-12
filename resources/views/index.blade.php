@extends('layouts.app')
@section('content')
    @if (session('success'))
        <div class="alert alert-success d-flex px-4">
            <div>{{ session('success') }}</div>
            <a href="{{route('basket.index')}}" class="alert-link ms-auto">Перейти в корзину</a>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <div class="d-flex gap-3 my-2">
        <a class="navbar-brand" href="{{ route('sale') }}">Акции</a>
        <a class="nav-link d-inline-block" href="{{ route('bestsellers') }}">Бестселлеры</a>
        <a class="nav-link d-inline-block" href="{{ route('newest') }}">Новинки</a>
    </div>

    <div class="row">
        <div class="col">
            {{--слайдшоу--}}
            <div id="demo" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#demo" data-bs-slide-to="0" class="active"></button>
                    <button type="button" data-bs-target="#demo" data-bs-slide-to="1"></button>
                    <button type="button" data-bs-target="#demo" data-bs-slide-to="2"></button>
                </div>
                <div class="carousel-inner rounded-5">
                    <div class="carousel-item active">
                        <a href="#" class=" ">
                            <img
                                src="{{ asset('imageSlide/1.jpg')}}"
                                alt="#" class="d-block" style="width:100%; height:340px">
                        </a>
                    </div>
                    <div class="carousel-item ">
                        <a href="#">
                            <img
                                src="{{ asset('imageSlide/2.jpg') }}"
                                alt="Chicago" class="d-block" style="width:100%; height:340px">
                        </a>
                    </div>
                    <div class="carousel-item">
                        <a href="#">
                            <img
                                src="{{ asset('imageSlide/3.jpg') }}"
                                alt="New York" class="d-block" style="width:100%; height:340px">
                        </a>
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#demo" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#demo" data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </button>
            </div>
            {{--слайдшоу--}}
            {{--FILTER--}}
            <div class="my-4">
                <form action="{{ route('books.index') }}" id="filterForm" method="get">
                    <select class="form-select w-25" name="filter" onchange="this.form.submit()">
                        <option value="">Выберите фильтр</option>
                        @foreach(['cheap' => 'Сначала дешевые', 'expensive' => 'Сначала дорогие', 'rating' => 'По рейтингу'] as $key => $value)
                            <option
                                value="{{ $key }}" {{ request('filter') === $key ? 'selected' : '' }}>{{ $value }}</option>
                        @endforeach
                    </select></form>
            </div>
            {{--FILTER--}}
            {{--BOOKS--}}
            @include('partials.book_card')
            {{--BOOKS--}}
            <div class="mt-4">
                {{ $books->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>

@endsection
