@extends('layouts.app')
@section('content')
    @if (session('success'))
        <div class="alert alert-success d-flex px-4">
            <div>{{ session('success') }}</div>
            <a href="{{route('basket.index')}}" class="alert-link ms-auto">Перейти в корзину</a>
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="row ">
        <div class="col-3 border rounded-5 bg-white p-4 h-100">
            <div class="row fs-5 text">
                <div class="col-12">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <a href="{{ route('admin.orders') }}">Активные заказы
                            <span class="ms-2 badge rounded-pill text-bg-danger">{{ $countOrders }}</span>
                        </a>
                        <i class="fa-solid fa-cart-shopping"></i>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <a href="{{ route('admin.addBookView') }}">Добавить книгу</a>
                        <i class="fa-solid fa-book"></i>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <a href="{{ route('admin.addCategoryView') }}">Добавить категорию</a>
                        <i class="fa-solid fa-list"></i>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <a href="{{ route('admin.addAuthorsView') }}">Добавить автора</a>
                        <i class="fa-regular fa-id-badge"></i>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <a href="{{ route('admin.books') }}">Книги</a>
                        <i class="fa-solid fa-book"></i>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <a href="{{ route('admin.users') }}">Пользователи</a>
                        <i class="fa-solid fa-users"></i>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <a href="{{ route('admin.discount') }}">Настройка скидок</a>
                        <i class="fa-solid fa-percent"></i>
                    </div><div class="d-flex justify-content-between align-items-center mb-2">
                        <a href="{{ route('admin.orderHistory') }}">История заказов</a>
                        <i class="fa-solid fa-clock-rotate-left"></i>                    </div>
                </div>
            </div>
        </div>

        <div class="col border rounded-5 bg-white ms-4 p-4">
            @yield('section')
        </div>
    </div>

@endsection
