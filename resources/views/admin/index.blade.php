@extends('layouts.app')
@section('content')

    <div class="row ">
        <div class="col-2 border rounded-5 bg-white p-4">
            <div class="d-flex flex-column">
                <div><a href="{{ route('admin.addBookView') }}">Добавить книгу</a></div>
                <div><a href="{{ route('admin.addCategoryView') }}">Добавить категорию</a></div>
                <div><a href="{{ route('admin.addAuthorsView') }}">Добавить автора</a></div>
                <div><a href="{{ route('admin.orders') }}">Активные заказы</a></div>
                <div><a href="{{ route('admin.books') }}">Книги</a></div>
                <div><a href="{{ route('admin.users') }}">Пользователи</a></div>
                <div><a href="{{ route('admin.discount') }}">Настройка скидок</a></div>
            </div>
        </div>

        <div class="col border rounded-5 bg-white ms-4 p-4">
            @yield('orders')
            @yield('bookAdd')
            @yield('categoryAdd')
            @yield('books')
            @yield('users')
            @yield('discount')
            @yield('authorAdd')
        </div>
    </div>




@endsection
