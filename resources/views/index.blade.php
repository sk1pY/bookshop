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


    <div class="row">
        <div class="col ">
            {{--слайдшоу--}}
            <div id="demo" class="carousel slide " data-bs-ride="carousel">
                <div class="carousel-indicators">

                    @foreach($slides as $key => $slide)
                        <button type="button" data-bs-target="#demo" data-bs-slide-to="{{$key}}"
                                class="active"></button>
                    @endforeach
                </div>

                <div class="carousel-inner rounded-5">
                    @foreach($slides as $key =>$slide)
                        <div class="carousel-item  {{$key == 0? 'active':''}}">
                            <a href="#" class="">
                                <img src="{{ Storage::url('slideImages/' . $slide->image) }}"
                                     alt="#" class="d-block w-100 " style="height: 400px;">
                            </a>

                        </div>
                    @endforeach

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
                    </select>
                </form>
            </div>
            {{--FILTER--}}
            {{--BOOKS--}}
            @include('partials.book-card')
            {{--BOOKS--}}
            <div class="mt-4">
                {{ $books->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>

@endsection
