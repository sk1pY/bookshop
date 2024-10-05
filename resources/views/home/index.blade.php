@extends('layouts.app')
@section('content')
    <div class="row ">
        <div class="col-2 border rounded-5 bg-white p-4 h-100   ">
            <div class="d-flex flex-column">

            <div class="d-flex align-items-center my-2">
                <i style="font-size:1.7rem;width: 35px" class="fa-regular fa-user "></i>
                <a style="font-size: 1.2rem" class="ms-2" href="{{ route('home.info')}}">Профиль</a>
            </div>
            <div class="d-flex align-items-center my-2">
                <i style="font-size:1.7rem;width: 35px" class="fa-regular fa-credit-card "></i>
                <a style="font-size: 1.2rem" class="  ms-2" href="{{ route('home.bought')}}">Заказы</a>
            </div>
            <div class="d-flex align-items-center my-2">

                <i style="font-size:1.7rem;width: 35px" class="fa-regular fa-bookmark"></i>
                <a style="font-size: 1.2rem" class="ms-2" href="{{ route('home.bookmark')}}">Избранное</a>
            </div>
            <div class="d-flex align-items-center my-2">

                <i style="font-size:1.7rem;width: 35px" class="fa-regular fa-comment"></i>
                <a style="font-size: 1.2rem" class="ms-2" href="{{ route('home.commentaries')}}">Отзывы</a>
            </div>
        </div>
    </div>
    @yield('сontentAdditional')
    </div>
@endsection

