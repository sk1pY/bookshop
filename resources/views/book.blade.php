@extends('layouts.app')
@section('content')
    <div class="row mt-5">
        <div class="col-4">
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
            @if($book->author_id)
                <a href="{{route('author.index',['id' => $book->author->id])}}">
                    <h5> {{ $book -> author -> name .' '. $book -> author -> surname  }}</h5></a>
                <p>
                    @endif

                    @php
                        $fullStars = floor($book->avgRating);

                        $halfStars = ($book->avgRating - $fullStars) > 0;

                    @endphp

                    @for ($i = 0; $i < $fullStars; $i++)
                        <i class="fas fa-star text-warning"></i>
                    @endfor

                    @if($halfStars)
                        <i class="fas fa-star-half-alt text-warning"></i>
                    @endif

                    @for( $i = 5 - $fullStars - ($halfStars?1:0); $i >  0; $i-- )

                        <i class="fa-regular fa-star text-warning"></i>
                    @endfor

                    {{ $book -> avgRating }}
                </p>
                <div class="d-flex align-items-center">
                    <h2 class="fw-bold mb-0">{{ $book->price }}р.</h2>

                </div>



                @auth()
                    <form action="{{ route('basket.add', $book->id) }}" method="post">
                        @csrf
                        <input type="text" hidden name="book_id" value="{{ $book->id }}">
                        <button style="width: 160px; height: 30px;"
                                class="btn btn-outline-success d-flex justify-content-center align-items-center">
                            В корзину
                        </button>
                    </form>
                @endauth
                <p class="text-start mt-3">{{ $book -> description }}</p>
        </div>
    </div>

    @if($bought)
        <div class="container mt-5">
            <div class="col-md-12 bootstrap snippets">
                {{--            БЛОК НАПИСАНИЕ КОМЕНТА--}}
                <div class="panel">
                    <div class="panel-body">
                        <form action="{{ route('comment.store',['id'=>$book->id])  }}" id="commentaryForm"
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

                        @else
                            <h5 class="mt-5">Вы не приобрели данный товар для его оценки</h5>
                        @endif
{{--                    COMMENTARIES--}}
                        @forelse($commentaries as $commentary)
                            <div class="w-100 py-4">
                                <div class="d-flex justify-content-center row  ">
                                    <div class="d-flex flex-column col-md-8">

                                        <div class="coment-bottom bg-white p-2 px-4 border rounded-4">
                                            <div
                                                class="commented-section mt-2">
                                                <div class="d-flex flex-row align-items-center commented-user">
                                                    <span class="text fs-5">
                                                        {{$commentary->user->name}}
                                                    </span>
                                                        <span style="margin-left:12px;font-size: 0.9rem;">{{ $commentary->created_at->diffforhumans()}}</span>
                                                    <span style="margin-left:12px;font-size: 0.9rem;">{{ $commentary->rating}}⭐</span>

                                                </div>

                                                <div class="comment-text-sm"><span>{{$commentary->text}}</span>
                                                </div>
                                                <div
                                                    class="reply-section">
                                                    <div class="my-3 d-flex flex-row align-items-center voting-icons">
                                                        <i class="fa-regular fa-heart"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
                @empty
                    <p>Комментарии отсутствуют</p>
        @endforelse
        @endsection
