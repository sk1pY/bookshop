@extends('layouts.app')
@section('content')
    <div class="row ">
        <div class="col-2 border rounded-5 bg-white p-4 h-100">
            <div class="d-flex flex-column">
                <div><a href="{{ route('home.bought')}}">Мои заказы</a></div>
                <div><a href="{{ route('home.bookmark') }}">Избранные товары</a></div>
                <div><a href="{{ route('home.info')}}">Личныe данные</a></div>
                <div><a href="{{ route('home.commentaries')}}">Мои отзывы</a></div>
            </div>
        </div>
            @yield('сontentAdditional')
        </div>
@endsection

