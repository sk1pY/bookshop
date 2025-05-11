@extends('layouts.app')
@section('content')
    <div class="row mt-5">
        <div class="col-4 p-0">
            <img
                style="width: 350px;height: 500px"
                src="{{Storage::url('booksImages/'.$book->image)}}"
                alt="Responsive image">
        </div>
        <div class="col-8 ">
            <div style="background-color: #daebe6; color: #10b37e" class="px-1 border rounded-4  d-inline-block">
                Купили {{ $book->numberOfPurchased }} раз
            </div>
            <h1> {{ $book -> title }}</h1>


            <div class="d-flex align-items-center gap-3 flex-wrap">
                @if($book->author)
                    <div>
                        <a href="{{route('authors.index', $book->author )}}">
                            <h5> {{ $book -> author -> name .' '. $book -> author -> surname  }}</h5>

                        </a>
                    </div>

                @endif
                <div class="d-flex align-items-center gap-1 fs-5">
                    @php
                        $fullStars = floor($book->avgRating);

                        $halfStars = ($book->avgRating - $fullStars) > 0;
                    @endphp
                    @for ($i = 0; $i < $fullStars; $i++)
                        <i class="bi bi-star-fill text-warning"></i>
                    @endfor
                    @if($halfStars)
                        <i class="bi bi-star-half text-warning"></i>
                    @endif
                    @for( $i = 5 - $fullStars - ($halfStars?1:0); $i >  0; $i-- )

                        <i class="bi bi-star text-warning"></i>
                    @endfor
                    <span> {{ $book -> avgRating }}</span>
                </div>
            </div>

            <a><h6> {{ $book -> category->name?? 'без категории'}}</h6></a>
            <p>

            </p>
            <div class="d-flex align-items-center">
                @if($book->discount > 0)
                    <div class="fw-bold text-danger fs-2"
                         style="font-size: 1.5rem">{{$book->price}} р.
                    </div>
                    <div class="ms-1 mb-3 fw-bold text-secondary">
                        <del>{{$book->original_price}}</del>

                    </div>
                    <span class="ms-2">Ваша скидка {{$book->discount .'%'}}</span>
                @else
                    <div class="fw-bold" style="font-size: 1.5rem">{{$book->price}} р.</div>
                @endif            </div>
            @auth()
                @if($book->stock > 0)
                    <form action="{{ route('basket-item.increase', $book) }}" method="post">
                        @csrf
                        <button style="width: 350px; height: 55px;"
                                class="btn btn-danger d-flex justify-content-center align-items-center">

                            <span class="fw-bold fs-5"><i class="bi bi-cart-fill me-2"></i>ДОБАВИТЬ В КОРЗИНУ</span>
                        </button>
                    </form>
                @else
                    <button style="width: 160px; height: 30px;"
                            class="btn btn-danger d-flex justify-content-center align-items-center disabled ">
                        Нет в наличии
                    </button>
                @endif

            @endauth
            <p class="text-start mt-3">{{ $book -> description }}</p>
        </div>
    </div>

    @can('check-bought-book',$book)
        <div class="container mt-5">
            <div class="col-md-12 bootstrap snippets">
                {{--            БЛОК НАПИСАНИЕ КОМЕНТА--}}
                <div class="panel">
                    <div class="panel-body">
                        <form action="{{ route('comments.store',$book)  }}" id="commentaryForm"
                              method="post" class="d-flex gap-3">
                            @csrf
                            <textarea name="text" class="form-control" rows="2"
                                      placeholder="Какие ваши впечатления о книге?"></textarea>
                            <button class="btn btn-sm btn-primary pull-right" type="submit"><i
                                    class="fa fa-pencil fa-fw"></i> Отправить
                            </button>
                            <select style="width: 160px" class="form-control p-0" id="rating" name="rating"
                                    form="commentaryForm">
                                <option value="5" selected>⭐⭐⭐⭐⭐</option>
                                <option value="4">⭐⭐⭐⭐</option>
                                <option value="3">⭐⭐⭐</option>
                                <option value="2">⭐⭐</option>
                                <option value="1">⭐</option>

                            </select>
                        </form>
                        @endcan

                        {{--                    COMMENTARIES--}}
                        @forelse($commentaries as $commentary)
                            <div class="row py-2">
                                <div class="d-flex justify-content-center">
                                    <div class="d-flex flex-column col-md-8">
                                        <div class="bg-white p-3 px-4 border rounded-4">
                                            <div class="commented-section mt-2">
                                                <div class="d-flex flex-row align-items-center commented-user">
                                                    <span class="text fs-5">{{ $commentary->user->name }}</span>
                                                    <span class="ms-3 text-muted" style="font-size: 0.9rem;">
                                {{ $commentary->created_at->diffForHumans() }}
                            </span>
                                                    <span class="ms-3" style="font-size: 0.9rem;">
                                    {{ $commentary->rating }}
                                    <i class="bi bi-star-fill text-warning"></i>
                                </span>
                                                </div>

                                                <div class="comment-text-sm mt-2">
                                                    <span>{{ $commentary->text }}</span>
                                                </div>

                                                <div class="reply-section mt-3">
                                                    <div class="d-flex flex-row align-items-center voting-icons">
                                                        <i class="fa-regular fa-heart"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-4">
                                <p class="text-muted fs-5">Пока комментариев нет.</p>
                            </div>
        @endforelse

        @endsection
