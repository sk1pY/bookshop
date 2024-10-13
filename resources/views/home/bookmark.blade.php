@extends('home.index')
@section('сontentAdditional')
    <h1>Мои закладки</h1>
    <div class="row g-4">
        @forelse($bookmarks as $bookmark)
            <div class="col-12 col-md-3"> <!-- 1 колонка на маленьких экранах, 4 колонки на средних и выше -->
                <div class="card h-100">
                    <div class="mt-3 d-flex justify-content-center align-items-center image-container">
                        <img src="https://s5-goods.ozstatic.by/480/119/253/101/101253119_0_CHetvertoe_krilo_Rebekka_Yarros.jpg"
                             alt="Responsive image" class="img-fluid" style="height: 170px;">
                    </div>
                    <div class="card-body">
                        <p class="fw-bold" style="color: darkorange;">{{$bookmark->book->price}} р.</p>
                        <h5 class="card-title">
                            <a href="{{ route('books.book', ['id' => $bookmark->book->id]) }}">{{ $bookmark->book->title }}</a>
                        </h5>
                        <div>
                            Автор:
                            <a href="{{ route('books.author', ['id' => $bookmark->book->author->id]) }}">
                                {{ $bookmark->book->author->surname . ' ' . $bookmark->book->author->name }}
                            </a>
                        </div>
                        <div class="mb-3">
                            Отзывы: {{ $bookmark->commentaries_count }}<br>
                            Рейтинг: {{ $bookmark->avgRating }}
                        </div>
                        @auth
                            <div class="d-flex justify-content-center align-items-center">
                                <form action="{{ route('basket.add', $bookmark->book->id) }}" method="post">
                                    @csrf
                                    <input type="text" hidden name="book_id" value="{{ $bookmark->book->id }}">
                                    <button style="width: 160px; height: 30px;"
                                            class="btn btn-outline-success d-flex justify-content-center align-items-center">
                                        В корзину
                                    </button>
                                </form>
                                <form action="{{ route('bookmark.delete', $bookmark->id) }}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-danger ms-3"><i class="fa-solid fa-trash"></i></button>

                                </form>
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
        @empty
            <p>Нет избранных книг</p>
        @endforelse
    </div>

@endsection
