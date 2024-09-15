@extends('layouts.app')
@section('content')
<div class="row mt-3">
    <div class="col-3">
        <div class="d-flex flex-column">
            <div><a href="{{ route('admin.addBookView')}}">добавить книгу</a></div>
            <div><a href="{{ route('admin.addCategoryView') }}">добавить категорию</a></div>
            <div><a href="{{ route('admin.orders')}}">заказы</a></div>
            <div><a href="{{ route('admin.books')}}">все книги</a></div>
        </div>
    </div>
    <div class="col-9">
        @yield('orders')
        @yield('bookAdd')
        @yield('categoryAdd')
        @yield('books')
    </div>
</div>

@endsection
