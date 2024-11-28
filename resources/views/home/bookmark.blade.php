@extends('home.index')
@section('сontentAdditional')
    <h1>Избранное</h1>
    <div class="row g-4 mt-3">
        @forelse($bookmarks as $bookmark)
            <div class="col-12 col-md-3">
                <div class="card h-100">
                    <div class="mt-3 d-flex justify-content-center align-items-center image-container">
                        <img src="{{Storage:: url('booksImages/'.$bookmark->book->image) }}"
                             alt="Responsive image" class="img-fluid" style="height: 170px;">
                    </div>
                    <div class="card-body ">
                        <div style="font-size: 0.8rem">
                            @if($bookmark->book->author_id)
                                <a href="{{ route('books.author', ['id' => $bookmark->book->author->id]) }}">
                                    {{ $bookmark->book->author->surname . ' ' . $bookmark->book->author->name }}</a>
                            @else
                                <div>без автора</div>
                            @endif
                        </div>
                        <div class="mb-3">
                            Отзывы: {{ $bookmark->book->commentaries_count }}
                            <i style="color:#ff9100" class="ms-2 me-1 fa-solid fa-star"></i>{{ $bookmark->book->avgRating }}
                        </div>
                        @auth
                            @if($bookmark->book->stock > 0)
                                <div class="d-flex justify-content-center align-items-center">
                                    <form action="{{ route('basket.add', ['id' => $bookmark->book->id]) }}" method="post">
                                        @csrf
                                        <button style="width: 200px; background-color: red; color: white"
                                                class="rounded-pill btn d-flex justify-content-center align-items-center">
                                            В корзину
                                        </button>
                                    </form>
                                </div>
                                <div class="d-flex justify-content-center align-items-center mt-2">
                                    <form action="{{ route('bookmark.delete', ['id' => $bookmark->id]) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button style="width: 200px; background-color: red; color: white"
                                                class="rounded-pill btn d-flex justify-content-center align-items-center">
                                            Удалить закладку
                                        </button>
                                    </form>
                                </div>
                            @else
                                <div class="d-flex justify-content-center align-items-center">
                                    <span>нет в наличии</span>
                                </div>
                            @endif
                        @endauth
                    </div>
                </div>
            </div>
        @empty
            <p>Нет избранных книг</p>
        @endforelse
    </div>

@endsection
