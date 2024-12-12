@extends('layouts.app')
@section('content')
    <style>
        .hov:hover {
            background-color: white;
        }
    </style>
    <div class="row  ">
        <div class="col-2   h-100  p-3 w-auto">
            <div class=" w-auto">

                <a href="{{ route('home.info.index') }}" class="hov d-flex align-items-center  rounded-pill p-3"
                   style="text-decoration: none;">
                    <i style="font-size: 1.5rem; width: 35px;" class="fa-regular fa-user"></i>
                    <span style="font-size: 1rem" class="ms-2">Профиль</span>
                </a>

                <a href="{{ route('home.orders.index')}}" class="hov d-flex align-items-center   rounded-pill p-3">
                    <i style="font-size:1.5rem;width: 35px" class="fa-regular fa-credit-card "></i>
                    <span style="font-size: 1rem" class="ms-2">Заказы</span>
                </a>
                <a href="{{ route('home.bookmarks.index')}}" class="hov d-flex align-items-center  rounded-pill p-3">

                    <i style="font-size:1.5rem;width: 35px" class="fa-regular fa-bookmark"></i>
                    <span style="font-size: 1rem" class="ms-2">Избранное</span>
                </a>
                <a href="{{ route('home.commentaries.index')}}" class="hov d-flex align-items-center rounded-pill p-3">

                    <i style="font-size:1.5rem;width: 35px" class="fa-regular fa-comment"></i>
                    <span style="font-size: 1rem" class="ms-2">Отзывы</span>
                </a>
                <hr>
                <a href="#" class="hov d-flex align-items-center  rounded-pill p-3">

                    <i style="font-size:1.5rem;width: 35px" class="fa-regular fa-newspaper"></i>
                    <span style="font-size: 1rem" class="ms-2">Новости</span>
                </a>
                <a href="#" class="hov d-flex align-items-center rounded-pill p-3 ">

                    <i style="font-size:1.5rem;width: 35px" class="fa-regular fa-circle-question"></i>
                    <span style="font-size: 1rem" class="ms-2">Помощь</span>
                </a>
                <a href="#" class="hov d-flex align-items-center  rounded-pill p-3">

                    <i style="font-size:1.5rem;width: 35px" class="fa-regular fa-building"></i>
                    <span style="font-size: 1rem" class="ms-2">О компании</span>
                </a>
                <a href="#" class="hov d-flex align-items-center   rounded-pill p-3">

                    <i style="font-size:1.5rem;width: 35px" class="fa-solid fa-briefcase"></i>
                    <span style="font-size: 1rem" class="ms-2" href="#">Вакансии</span>
                </a>
            </div>
        </div>
        <div class="col p-3">
            @yield('сontentAdditional')
        </div>
    </div>

@endsection

