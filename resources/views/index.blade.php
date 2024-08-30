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
                <div class="col-md-2">
                    @auth()
                        <h1 style="color: orange" >{{Auth::user()->name}}</h1>
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
                            <div class="col-2">
                                <div class="card">
                                    <div class="mt-3 d-flex justify-content-center align-items-center image-container">
                                        <img src="https://s5-goods.ozstatic.by/480/119/253/101/101253119_0_CHetvertoe_krilo_Rebekka_Yarros.jpg" alt="Responsive image" class="img-fluid " style="height: 170px">
                                    </div>
                                    <div class="card-body">
                                        <p class="fw-bold " style="color: darkorange">{{$book->price}} р.</p>
                                        <h5 class="card-title"><a
                                                href="{{ route('books.book', ['id' => $book->id]) }}">{{ $book->title }}</a>
                                        </h5>
                                        <div>
                                            <a href="{{ route('books.author', ['id' => $book->author->id]) }}">{{ $book->author->name }}</a>

                                        </div>
                                        @auth
                                        <div class="d-flex justify-content-center align-items-center">
                                            <form action="{{route('basket.add',$book->id)}}" method="post">
                                                @csrf
                                                <input type="text" hidden name="book_id" value="{{$book->id}}">
                                                <button style=" width:160px;height: 30px;" class="btn btn-outline-success d-flex justify-content-center align-items-center"> В корзину</button>
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
