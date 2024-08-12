@extends('layouts.app')
@section('content')

    <div class="container">

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
                    @auth()
                        <h1>{{Auth::user()->name}}</h1>
                    @endauth
                    <h4>Категории</h4>

                    <ul class="list-unstyled">
                        @foreach($categories as $category)
                            <li>
                                <a href="{{route('books.categoryBooks',['id' => $category->id])}}">{{ $category->name }}</a>
                            </li>
                        @endforeach


                    </ul>
                </div>
                <div class="col-md-9">
                    <div class="row row-cols-1 row-cols-md-4 g-4">
                        @foreach($books as $book)
                            <div class="col">
                                <div class="card " style="width: 200px">
                                    <img
                                        src="https://fastly.picsum.photos/id/24/4855/1803.jpg?hmac=ICVhP1pUXDLXaTkgwDJinSUS59UWalMxf4SOIWb9Ui4"
                                        class="card-img-top" alt="Book image">
                                    <div class="card-body">
                                        <h5 class="card-title"><a
                                                href="{{ route('books.book', ['id' => $book->id]) }}">{{ $book->title }}</a>
                                        </h5>
                                        <div>
                                            <a href="{{ route('books.categoryBooks',[$book->category->name])}}">{{ $book->category->name }}</a>
                                            <a href="{{ route('books.author', ['id' => $book->author->id]) }}">{{ $book->author->name }}</a>
                                            <p>Цена: {{$book->price}}</p>
                                        </div>
                                        @auth
                                            <div class="">
                                                <form action="{{route('basket.add')}}" method="post">
                                                    @csrf
                                                    <input type="text" hidden name="book_id" value="{{$book->id}}">
                                                    <button style=" height: 40px;" class="btn btn-outline-success"> <i class="bi bi-cart"></i></button>
                                                </form>
                                            </div>
                                        @endauth
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
