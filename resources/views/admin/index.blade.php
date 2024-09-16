@extends('layouts.app')
@section('content')
<div class="row mt-3">
    <div class="col-3">
        <div class="d-flex flex-column">
            <div><a href="{{ route('admin.addBookView')}}">Добавить книгу</a></div>
            <div><a href="{{ route('admin.addCategoryView') }}">Добавить категорию</a></div>
            <div><a href="{{ route('admin.orders')}}">Активные заказы</a></div>
            <div><a href="{{ route('admin.books')}}">Книги</a></div>
            <div><a href="{{route('admin.users') }}">Пользователи</a></div>
        </div>
    </div>
    <div class="col-9">
        @yield('orders')
        @yield('bookAdd')
        @yield('categoryAdd')
        @yield('books')
        @yield('users')
    </div>
</div>

@endsection
