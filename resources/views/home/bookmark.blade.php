@extends('home.index')
@section('content-home')
    <h4>Избранное</h4>
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
                            <a class="card-title pt-0 mb-0 fs-5" href="{{ route('books.book', $bookmark->book) }}">
                                {{ $bookmark->book->title }}
                            </a>
                            <br>
                            @if($bookmark->book->author_id)
                                <a href="{{ route('authors.index', $bookmark->book->author->id) }}">
                                    {{ $bookmark->book->author->surname . ' ' . $bookmark->book->author->name }}
                                </a>
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
                                <div class="increase_decrease_buttons mt-auto bg-light rounded-pill ">
                                    <div class="in-basket-button
                {{ in_array($bookmark->book->id, $booksInBasketArray, true)?'d-none':'' }}"
                                         data-url="{{ route('basket-item.increase') }}"
                                         data-book-id="{{$bookmark->book->id}}">
                                        <button class="button_basket btn bg-danger w-100 rounded-pill text-white">
                                            В корзину
                                        </button>
                                    </div>

                                    <div class="button-inc-dec justify-content-between d-flex
                    {{ !in_array($bookmark->book->id,$booksInBasketArray,true)?'d-none':'' }}">
                                        <div class="decrease-button"
                                             data-url="{{ route('basket-item.decrease') }}"
                                             data-book-id="{{$bookmark->book->id}}">
                                            <button class="btn">
                                                -
                                            </button>
                                        </div>
                                        <div class="basket_item_count text-dark d-flex justify-content-center align-items-center"
                                             data-book-id="{{$bookmark->book->id}}">
                                            {{ $bookmark->quantity ?? '' }}
                                        </div>

                                        <div class="increase-button"
                                             data-url="{{ route('basket-item.increase') }}"
                                             data-book-id="{{$bookmark->book->id}}">
                                            <button class="btn">
                                                +
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <button
                                    class="w-auto rounded-pill btn d-flex justify-content-center align-items-center">
                                    нет в наличии
                                </button>
                            @endif
                                <div class="d-flex justify-content-center align-items-center mt-2">
                                    <form action="{{ route('home.bookmarks.destroy',$bookmark  ) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button style="width: 200px;  color: white"
                                                class="btn btn-danger rounded-pill btn d-flex justify-content-center align-items-center">
                                            Удалить закладку
                                        </button>
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
