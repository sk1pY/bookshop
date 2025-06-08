<div id="book-{{$book->id }}" class="card border-0 h-100 d-flex flex-column" style="max-width: 220px;">
    @auth
        {{-- BOOKMARK --}}
        <div style="cursor: pointer"
             class="d-flex justify-content-end bookmark-button m-3 fs-4"
             data-book-id="{{ $book->id }}"
             data-url="{{route('home.bookmarks.store')}}">
            <i class="bookmark_button bi text-danger {{
                        in_array($book->id, $bookmarkBookUser, true) ? 'bi-heart-fill' : 'bi-heart' }}"></i>
        </div>
        {{-- BOOKMARK end--}}
    @endauth
    <a href="{{ route('books.book', $book) }}"
       style="text-decoration: none; color: inherit;">
        <div class="d-flex justify-content-center align-items-center image-container">
            <img src="{{ Storage::url('booksImages/' . $book->image) }}"
                 alt="Responsive image" class="img-fluid" style="height: 200px">
        </div>
        <div class="card-body pb-0 pt-0">
            <div class="d-flex mt-2">
                @if($book->discount > 0)
                    <div class="fw-bold text-danger"
                         style="font-size: 1.5rem">{{$book->price}} р.
                    </div>
                    <div class="ms-2 fw-bold text-secondary">
                        <del>{{$book->original_price}}</del>
                    </div>
                @else
                    <div class="fw-bold" style="font-size: 1.5rem">{{$book->price}} р.</div>
                @endif
            </div>
            <span class="card-title pt-0 mb-0 fs-5">
                            {{ substr($book->title,0,18)}}
                        </span>
        </div>
    </a>
    <div class="card-body d-flex flex-column ">
        <div style="font-size: 0.9rem">
            @if($book->category)
                <a href="{{ route('categories.show', $book->category->slug) }}">
                    {{ $book->category->name ?? 'Без категории' }}
                </a>
            @else
                <span class="text-muted">Без категории</span>
            @endif
            <br>
            @if($book->author)
                <a href="{{ route('authors.index',$book->author) }}">
                    {{ $book->author->surname . ' ' . $book->author->name }}</a>
            @else
                <span class="text-muted"> Без автора </span>
            @endif
        </div>
        <div class="mb-3">
            Отзывы: {{ $book->commentaries_count }}
            <i style="color:#ff9100"
               class="ms-2 me-1 bi bi-star-fill"></i>{{ $book->avgRating }}
        </div>

        @if($book->stock > 0)
            <div class="increase_decrease_buttons mt-auto bg-light rounded-pill ">
                <div class="in-basket-button
                {{ in_array($book->id, $booksInBasketArray, true)?'d-none':'' }}"
                     data-url="{{ route('basket-item.increase', $book) }}"
                     data-book-id="{{$book->id}}">
                    <button class="button_basket btn bg-danger w-100 rounded-pill text-white">
                        В корзину
                    </button>
                </div>

                <div class="button-inc-dec justify-content-between d-flex
                    {{ !in_array($book->id,$booksInBasketArray,true)?'d-none':'' }}">
                    <div class="decrease-button"
                         data-url="{{ route('basket-item.decrease', $book) }}"
                         data-book-id="{{$book->id}}">
                        <button class="btn">
                            -
                        </button>
                    </div>
                    <div class="basket_item_count text-dark d-flex justify-content-center align-items-center"
                         data-book-id="{{$book->id}}">
                        {{ $book->quantity }}
                    </div>

                    <div class="increase-button"
                         data-url="{{ route('basket-item.increase', $book) }}"
                         data-book-id="{{$book->id}}">
                        <button class="btn">
                            +
                        </button>
                    </div>
                </div>
            </div>
        @else
            <button
                class="w-auto rounded-pill btn d-flex justify-content-center align-items-center mt-auto">
                нет в наличии
            </button>
        @endif
    </div>
</div>
