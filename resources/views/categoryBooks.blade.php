@extends('layouts.app')
@section('content')
    <h1>{{ $category->name }}</h1>
    {{--FILTER--}}
    <div class="my-4">
        <form  id="filterForm" method="get">
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
        <div class="row row-cols-1 row-cols-md-5 g-5">
            @forelse($books as $book)
                <div class="col">
                    <div class="card border-0 " style="height: 459px;width: 214px">
                        @auth
                            {{-- BOOKMARK --}}
                            <div style="cursor: pointer" class="d-flex justify-content-end bookmark-button m-3 fs-4"
                                 data-bookmark-id="{{ $book->id }}">
                                <i class="fa-regular fa-heart bg-red-bookmark {{
                        in_array($book->id, $bookmarkTaskUser) ? 'fa-solid' : '' }}"></i>
                            </div>
                        @endauth
                        {{-- BOOKMARK --}}
                        <a href="{{ route('books.book', ['book' => $book->id]) }}" style="text-decoration: none; color: inherit;">
                            <div class="d-flex justify-content-center align-items-center image-container">
                                <img src="{{ Storage::url('booksImages/' . $book->image) }}" alt="Responsive image" class="img-fluid" style="height: 170px">
                            </div>
                            <div class="card-body pb-0 pt-0">
                                <div class="d-flex mt-2">
                                    @if($book->discount > 0)
                                        <div class="fw-bold text-danger" style="font-size: 1.5rem">{{$book->price}} р.</div>
                                        <div class="ms-2 fw-bold text-secondary">
                                            <del>{{$book->priceBeforeDiscount}} р.</del>
                                        </div>
                                    @else
                                        <div class="fw-bold" style="font-size: 1.5rem">{{$book->price}} р.</div>
                                    @endif
                                </div>
                                <span class="card-title pt-0 mb-0">
                                            {{ substr($book->title,0,18)}}
                                        </span>
                            </div>
                        </a>
                        <div class="card-body ">
                            <div style="font-size: 0.8rem">
                                @if($book->author_id)
                                    <a href="{{ route('author.index', ['id' => $book->author->id]) }}">
                                        {{ $book->author->surname . ' ' . $book->author->name }}</a>
                                @else
                                    <div>без автора</div>
                                @endif
                            </div>
                            <div class="mb-3">
                                Отзывы: {{ $book->commentaries_count }}
                                <i style="color:#ff9100" class="ms-2 me-1 fa-solid fa-star"></i>{{ $book->avgRating }}
                            </div>
                            @auth
                                @if($book->stock > 0)
                                    <div class="d-flex justify-content-center align-items-center">
                                        <form action="{{ route('basket.add', ['id' => $book->id]) }}" method="post">
                                            @csrf
                                            <button style="width: 200px; background-color: red; color: white"
                                                    class="rounded-pill btn d-flex justify-content-center align-items-center">
                                                В корзину
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
                <p>нет книг</p>
            @endforelse
        </div>
        {{--BOOKS--}}
@endsection
