@extends('layouts.app')
@section('content')
    <div class="container mt-3">
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
                <div class="col-md-2 mx-4">

                    <ul class="list-unstyled">
                        @foreach($categories as $category)
                            <li class="list-unstyled">
                                <a href="{{ route('books.categoryBooks', ['id' => $category->id]) }}" class="text-decoration-none">
                                    <p class="fs-5  m-0">{{ $category->name }}</p>
                                </a>
                            </li>

                        @endforeach


                    </ul>
                </div>
                <div class="col-md-9">
                    <div id="demo" class="carousel slide" data-bs-ride="carousel">

                        <!-- Indicators/dots -->
                        <div class="carousel-indicators">
                            <button type="button" data-bs-target="#demo" data-bs-slide-to="0" class="active"></button>
                            <button type="button" data-bs-target="#demo" data-bs-slide-to="1"></button>
                            <button type="button" data-bs-target="#demo" data-bs-slide-to="2"></button>
                        </div>

                        <!-- The slideshow/carousel -->
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="https://fastly.picsum.photos/id/26/4209/2769.jpg?hmac=vcInmowFvPCyKGtV7Vfh7zWcA_Z0kStrPDW3ppP0iGI" alt="Los Angeles" class="d-block" style="width:100%; height:340px">
                                <div class="carousel-caption d-none d-md-block">
                                    <h5>Первый слайд</h5>
                                    <p>Описание первого слайда</p>
                                    <a href="#" class="btn btn-primary">Кнопка</a>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <img src="https://fastly.picsum.photos/id/26/4209/2769.jpg?hmac=vcInmowFvPCyKGtV7Vfh7zWcA_Z0kStrPDW3ppP0iGI" alt="Chicago" class="d-block" style="width:100%; height:340px">
                                <div class="carousel-caption d-none d-md-block">
                                    <h5>Второй слайд</h5>
                                    <p>Описание второго слайда</p>
                                    <a href="#" class="btn btn-primary">Кнопка</a>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <img src="https://fastly.picsum.photos/id/26/4209/2769.jpg?hmac=vcInmowFvPCyKGtV7Vfh7zWcA_Z0kStrPDW3ppP0iGI" alt="New York" class="d-block" style="width:100%; height:340px">
                                <div class="carousel-caption d-none d-md-block">
                                    <h5>
                                        Третий слайд</h5>
                                    <p>Описание третьего слайда</p>
                                    <a href="#" class="btn btn-primary">Кнопка</a>
                                </div>
                            </div>
                        </div>
                        <!-- Left and right controls/icons -->
                        <button class="carousel-control-prev" type="button" data-bs-target="#demo" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon"></span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#demo" data-bs-slide="next">
                            <span class="carousel-control-next-icon"></span>
                        </button>
                    </div>
                    <div class="my-4">
                        <form action="{{ route('books.index') }}" id="filterForm" method="get"  >
                            @csrf
                            <label for="rating">Фильтр: </label>
                            <select id="rating" name="filter" form="filterForm" onchange="this.form.submit()">

                                <option value="">Выберите фильтр</option>
                                <option value="cheap" {{ request('filter') === 'cheap' ? 'selected' : '' }} >Сначала дешевые</option>
                                <option value="expensive" {{ request('filter') === 'expensive' ? 'selected' : '' }}>Сначала дорогие</option>
                                <option value="rating">По рейтингу</option>
                                <option value="popularity">По популярности</option>
                            </select></form>
                    </div>

                    <div class="row row-cols-1 row-cols-md-4 g-4">

                        @forelse(@$books as $book)
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
                                            Автор: <a href="{{ route('books.author', ['id' => $book->author->id]) }}">{{ $book->author->surname.' '. $book->author->name }}</a>

                                        </div>
                                        <div class="mb-3">
                                            Отзывы: {{ $book->commentaries_count }}
                                            Рейтинг: {{ $book->avgRating }}

                                        </div>
                                        <div>

                                        </div>
                                        @auth
                                            <div class="d-flex justify-content-center align-items-center">
                                                <div class="d-flex">
                                                    <div class="mr-2">
                                                        <form action="{{ route('basket.add', $book->id) }}" method="post">
                                                            @csrf
                                                            <input type="text" hidden name="book_id" value="{{ $book->id }}">
                                                            <button style="width: 160px; height: 30px;" class="btn btn-outline-success d-flex justify-content-center align-items-center">
                                                                В корзину
                                                            </button>
                                                        </form>
                                                    </div>
                                                    <div>
{{--                                                        <form action="{{ route('bookmark.add', $book->id) }}" method="post">--}}
{{--                                                            @csrf--}}
{{--                                                            <button style="width: 40px; height: 30px;" class="btn  d-flex justify-content-center align-items-center">--}}
{{--                                                                <i class="fa-regular fa-bookmark"></i>--}}
{{--                                                            </button>--}}
{{--                                                        </form>--}}
                                                        <div style="cursor: pointer" class="bookmark-button me-3"
                                                             data-bookmark-id="{{ $book->id }}">
                                                            <i class="ms-3 fa-regular fa-bookmark text-warning {{
                                                        in_array($book->id,$bookmarkTaskUser)? 'fa-solid yellow-bookmark' : '' }}"></i>

                                                        </div>
                                                    </div>

                                                </div>
                                            </div>

                                        @endauth
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p>нет книг</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
<script>
    $(document).ready(function () {
        $('.bookmark-button').on('click', function () {
            var taskId = $(this).data('bookmark-id');
            var bookmarkButton = $(this).find('.fa-bookmark');

            $.ajax({
                url: '/bookmark/add',
                method: 'POST',
                data: {
                    bookmark_id: taskId
                },
                success: function (response) {
                    if (response.success) {
                        if (response.bookmark) {
                            bookmarkButton.addClass('fa-solid text-warning');
                        } else {
                            bookmarkButton.removeClass('fa-solid ');
                        }
                    } else {
                        $('#message').text(response.message).css('color', 'red');
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Произошла ошибка при добавлении/удалении закладки');
                }
            });
        });
    });

</script>
@endsection
