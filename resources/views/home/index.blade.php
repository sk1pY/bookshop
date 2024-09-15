@extends('layouts.app')
@section('content')
    <div class="row mt-3">
        <div class="col-3">
            <div class="d-flex flex-column">
                <div><a href="{{ route('home.bought')}}">Мои заказы</a></div>
                <div><a href="{{ route('home.bookmark') }}">Избранные товары</a></div>
                <div><a href="{{ route('home.info')}}">Личный данные</a></div>
                <div><a href="{{ route('home.commentaries')}}">Мои отзывы</a></div>
            </div>
        </div>
        <div class="col-9">

                @yield('myorders')
                @yield('info')
                @yield('bookmark')
                @yield('commentaries')

        </div>
    </div>

@endsection

