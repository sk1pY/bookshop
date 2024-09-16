@extends('layouts.app')
@section('content')
    <div class="row mt-5">
        <div class="col-4">
            <img
                src="https://s5-goods.ozstatic.by/480/119/253/101/101253119_0_CHetvertoe_krilo_Rebekka_Yarros.jpg"
                alt="Responsive image">
        </div>
        <div class="col-8 ">
            <h1> {{ $book -> title }}</h1>
            <a href="{{route('books.author',['id' => $book->author->id])}}"><h5 > {{ $book -> author -> name .' '. $book -> author -> surname  }}</h5></a>
            <p>рейтинг: {{ $book -> avgRating }}</p>
            <h2 class="fw-bold">{{ $book -> price }}р.</h2>
            @auth()
            <form action="{{ route('basket.add', $book->id) }}" method="post">
                @csrf
                <input type="text" hidden name="book_id" value="{{ $book->id }}">
                <button style="width: 160px; height: 30px;" class="btn btn-outline-success d-flex justify-content-center align-items-center">
                    В корзину
                </button>
            </form>
            @endauth
            <p class="text-start mt-3">{{ $book -> description }}</p>
        </div>

    </div>
    <div class="mt-3 d-flex  image-container">

    </div>
        @if($bought)
    <div class="container bootdey">
        <div class="col-md-12 bootstrap snippets">
{{--            БЛОК НАПИСАНИЕ КОМЕНТА--}}
            <div class="panel">
                <div class="panel-body">
                    <form action="{{ route('comment.add',['id'=>$book->id])  }}" id="commentaryForm" method="post">
                        @csrf
                        <textarea name="text" class="form-control" rows="2"
                                  placeholder="What are you thinking?"></textarea>
                        <button class="btn btn-sm btn-primary pull-right" type="submit"><i
                                class="fa fa-pencil fa-fw"></i> Share
                        </button>
                        <select id="rating" name="rating" form="commentaryForm">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5" selected>5</option>
                        </select>
                    </form>
                    @endif
                </div>
            </div>
{{--            --}}
{{--            КОММЕНТЫ    --}}
            <div class="panel">
                <div class="panel-body">
                    @forelse($commentaries as $commentary)
                        <div class="media-block">
                          <img class="media-left img-circle img-sm" alt="Profile Picture"
                                                                src="https://bootdey.com/img/Content/avatar/avatar1.png">
                            <div class="media-body">
                                <div class="mar-btm mx-2">
                                    <a href="#"
                                       class="btn-link text-semibold media-heading box-inline">{{$commentary -> user -> name}}</a>
                                    <p class="text-muted text-sm">
                                        {{ $commentary->created_at->diffforhumans()}}
                                    </p>
                                </div>
                                <p>{{$commentary -> text}}</p>
                                <div class="pad-ver">
                                    <div class="btn-group">
                                        <a class="btn btn-sm btn-default btn-hover-success" href="#"><i
                                                class="fa fa-thumbs-up"></i></a>
                                        <a class="btn btn-sm btn-default btn-hover-danger" href="#"><i
                                                class="fa fa-thumbs-down"></i></a>
                                    </div>
                                </div>
                                <hr>
                            </div>
                        </div>
                    @empty
                        <p>No comments</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

@endsection
