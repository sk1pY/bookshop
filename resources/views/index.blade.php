@extends('layouts.app')
@section('content')
    @if (session('success'))
        <div class="alert alert-success d-flex px-4">
            <div>{{ session('success') }}</div>
            <a href="{{route('basket.index')}}" class="alert-link ms-auto">Перейти в корзину</a>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    {{-----------------------------------------------}}
    <div class="row my-4">
        <div class="col-2 border rounded-5 bg-white p-4 h-100 sticky-top sticky-element ">
            @include('category')
        </div>
        <div class="col border rounded-5 bg-white ms-4 p-4">
            {{--слайдшоу--}}
            <div id="demo" class="carousel slide" data-bs-ride="carousel">

                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#demo" data-bs-slide-to="0" class="active"></button>
                    <button type="button" data-bs-target="#demo" data-bs-slide-to="1"></button>
                    <button type="button" data-bs-target="#demo" data-bs-slide-to="2"></button>
                </div>

                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img
                            src="https://fastly.picsum.photos/id/26/4209/2769.jpg?hmac=vcInmowFvPCyKGtV7Vfh7zWcA_Z0kStrPDW3ppP0iGI"
                            alt="Los Angeles" class="d-block" style="width:100%; height:340px">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>Первый слайд</h5>
                            <p>Описание первого слайда</p>
                            <a href="#" class="btn btn-primary">Кнопка</a>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img
                            src="https://fastly.picsum.photos/id/26/4209/2769.jpg?hmac=vcInmowFvPCyKGtV7Vfh7zWcA_Z0kStrPDW3ppP0iGI"
                            alt="Chicago" class="d-block" style="width:100%; height:340px">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>Второй слайд</h5>
                            <p>Описание второго слайда</p>
                            <a href="#" class="btn btn-primary">Кнопка</a>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img
                            src="https://fastly.picsum.photos/id/26/4209/2769.jpg?hmac=vcInmowFvPCyKGtV7Vfh7zWcA_Z0kStrPDW3ppP0iGI"
                            alt="New York" class="d-block" style="width:100%; height:340px">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>
                                Третий слайд</h5>
                            <p>Описание третьего слайда</p>
                            <a href="#" class="btn btn-primary">Кнопка</a>
                        </div>
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#demo" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#demo" data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </button>
            </div>
            {{--слайдшоу--}}
            {{--FILTER--}}
            <div class="my-4">
                <form action="{{ route('books.index') }}" id="filterForm" method="get">
                    @csrf
                    <select class="form-select w-25" id="rating" name="filter" form="filterForm"
                            onchange="this.form.submit()">

                        <option value="">Выберите фильтр</option>
                        <option value="cheap" {{ request('filter') === 'cheap' ? 'selected' : '' }} >Сначала дешевые
                        </option>
                        <option value="expensive" {{ request('filter') === 'expensive' ? 'selected' : '' }}>Сначала
                            дорогие
                        </option>
                        <option value="rating" {{ request('filter') === 'rating' ? 'selected' : '' }}>По рейтингу
                        </option>
                    </select></form>
            </div>
            {{--FILTER--}}
            {{--BOOKS--}}
            <div class="row row-cols-1 row-cols-md-4 g-4">
                @forelse($books as $book)
                    <div class="col-2">

                        <div class="card">
                            <div>
                                <div style="cursor: pointer" class="d-flex justify-content-end bookmark-button m-3 fs-4"
                                     data-bookmark-id="{{ $book->id }}">
                                    <i class="ms-3 fa-regular fa-bookmark text-warning {{
                                                        in_array($book->id,$bookmarkTaskUser)? 'fa-solid yellow-bookmark' : '' }}"></i>

                                </div>
                            </div>
                            <a href="{{ route('books.book', ['id' => $book->id]) }}" style="text-decoration: none; color: inherit;">
                                <div class="mt-3 d-flex justify-content-center align-items-center image-container">
                                    <img
                                        src="{{ url($book->image) }}"
                                        alt="Responsive image" class="img-fluid " style="height: 170px">
                                </div>
                                <div class="card-body  pb-0">
                                    <p class="fw-bold " style="color: darkorange">{{$book->price}} р.</p>
                                    <h5 class="card-title">
                                        <p> {{ $book->title }}</p>
                                    </h5>
                                </div>
                                </a>
                        <div class="card-body ">
                                    <div>
                                        @if($book->author_id)
                                            Автор: <a
                                                href="{{ route('books.author', ['id' => $book->author->id]) }}">{{ $book->author->surname.' '. $book->author->name }}</a>
                                        @endif

                                    </div>
                                    <div class="mb-3">
                                        Отзывы: {{ $book->commentaries_count }}
                                        <i style="color:#ff9100" class="ms-2 me-1 fa-solid fa-star"></i>{{ $book->avgRating }}

                                    </div>
                                    @auth
                                        <div class="d-flex justify-content-center align-items-center">
                                            <div class="d-flex">
                                                <div class="mr-2">
                                                    <form action="{{ route('basket.add', $book->id) }}" method="post">
                                                        @csrf
                                                        <input type="text" hidden name="book_id"
                                                               value="{{ $book->id }}">
                                                        <button style="width:200px;background-color: red;color:white"
                                                                class=" rounded-pill   btn  d-flex justify-content-center align-items-center">
                                                            В корзину
                                                        </button>
                                                    </form>
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
            {{--BOOKS--}}

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
