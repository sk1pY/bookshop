@extends('layouts.app')
@section('content')
    <div class="container">
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ route('books.index') }}">BookShop</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                        <li class="nav-item">
                            <a class="nav-link" href="#">Features</a>
                        </li>
                    </ul>
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('basket.index') }}">Корзина: {{ $bookInBasket }}</a>
                            <span></span>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="container">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
            <div class="row">
                <div class="col-md-3">
                    <h4>Категории</h4>

                    <ul class="list-unstyled">
                        @foreach($categories as $category)
                            <li><a href="{{route('books.categoryBooks',['id' => $category->id])}}">{{ $category->name }}</a>
                            </li>
                        @endforeach


                    </ul>
                </div>

                <div class="col-md-9">
                    <div class="row row-cols-1 row-cols-md-4 g-4">
                        @foreach($books as $book)
                            <div class="col">
                                <div class="card " style="width: 200px">
                                    <img src="https://fastly.picsum.photos/id/24/4855/1803.jpg?hmac=ICVhP1pUXDLXaTkgwDJinSUS59UWalMxf4SOIWb9Ui4"
                                         class="card-img-top" alt="Book image">
                                    <div class="card-body">
                                        <h5 class="card-title"><a
                                                    href="{{ route('books.book', ['id' => $book->id]) }}">{{ $book->title }}</a>
                                        </h5>
                                        <p class="card-text">
                                            <a href="{{ route('books.categoryBooks',[$category->id])}}">{{ $book->category->name }}</a>
                                        </p>
                                        <p class="card-text">
                                            <a href="{{ route('books.author', ['id' => $book->author->id]) }}">{{ $book->author->name }}</a>
                                        </p>
                                        <form action="{{route('basket.add')}}" method="post">
                                            @csrf
                                            <input type="text" hidden name="book_id" value="{{$book->id}}">
                                            <button class="btn btn-outline-primary">Добавить в корзину</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
