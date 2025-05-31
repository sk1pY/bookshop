@extends('layouts.app')
@section('app-content')

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
                                     alt="#" class="d-block w-100 " style="height: 300px;">
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

        </div>

@endsection
