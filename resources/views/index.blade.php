<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous"></script>
    <title>Document</title>
</head>
<body>
<div class="container">
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('books.index') }}">BookShop</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
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
                        <a class="nav-link" href="#">Корзина</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <h4>Категории</h4>

                <ul class="list-unstyled">
                    @foreach($categories as $category)
                        <li><a href="{{route('books.categoryBooks',[$category->id])}}">{{ $category->name }}</a></li>
                    @endforeach


                </ul>
            </div>

            <div class="col-md-9">
                <div class="row row-cols-1 row-cols-md-4 g-4">
                    @foreach($books as $book)
                        <div class="col">
                            <div class="card " style="width: 200px">
                                <img src="https://fastly.picsum.photos/id/24/4855/1803.jpg?hmac=ICVhP1pUXDLXaTkgwDJinSUS59UWalMxf4SOIWb9Ui4" class="card-img-top" alt="Book image">
                                <div class="card-body">
                                    <h5 class="card-title"><a href="{{ route('books.book', ['id' => $book->id]) }}">{{ $book->title }}</a></h5>
                                    <p class="card-text">
                                        <a href="{{route('books.categoryBooks',[$category->id])}}">{{ $book->category->name }}</a>
                                    </p> <p class="card-text">
                                        <a href="{{ route('books.author', ['id' => $book->author->id]) }}">{{ $book->author->name }}</a>
                                    </p>
                                    <form action="{{route('basket.add')}}" method="post">
                                        @csrf
                                        <input type="text" hidden name="book_id" value="{{$book->id}}">
                                        <button class="btn btn-outline-primary" >Добавить в корзину</button>
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

</body>
</html>
