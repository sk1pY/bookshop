@extends('layouts.app')
@section('app-content')
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
            <h1> {{ $book -> title}}</h1>


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
                    <div class="increase_decrease_buttons mt-auto bg-light rounded-pill " style="width: 200px">
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
                                {{ $bookQuantityInBakset }}

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
                    <button style="width: 160px; height: 30px;"
                            class="btn btn-danger d-flex justify-content-center align-items-center disabled ">
                        Нет в наличии
                    </button>
                @endif

            @endauth
            <p class="text-start mt-3">{{ $book -> description }}</p>
        </div>
    </div>
    <div class="mt-5">
        @auth
            {{--            БЛОК НАПИСАНИЕ КОМЕНТА--}}
            <form action="{{ route('books.comments.store',$book)  }}" id="commentaryForm"
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
            {{--            БЛОК НАПИСАНИЕ КОМЕНТА--}}
        @endauth
        {{--                    COMMENTARIES--}}
        @forelse($commentaries as $commentary)
            <div class="row py-2 justify-content-center ">
                <div class="d-flex flex-column ">
                    <div class="p-3 px-4 border rounded-4">
                        <div class="d-flex justify-content-between">
                            <div class="flex-column ">
                                <span class="text fs-5">{{ $commentary->user->name }}</span>
                                <span class="ms-3 text-muted"
                                      style="font-size: 0.9rem;">{{ $commentary->created_at->diffForHumans() }}</span>
                                <span class="ms-3" style="font-size: 0.9rem;">{{ $commentary->rating }}
                                                <i class="bi bi-star-fill text-warning"></i></span>
                            </div>

                            <div class="d-flex">
                                @can('update',$commentary)
                                    <button type="button" class="btn " data-bs-toggle="modal"
                                            data-bs-target="#updateComment-{{$commentary->id}}">
                                        <i class="bi bi-pencil-square"></i></button>
                                @endcan
                                @can('delete', $commentary)
                                    <form
                                        action="{{ route('books.comments.destroy', [$book,$commentary]) }}"
                                        method="POST"
                                        class="m-0">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="btn btn-sm btn-link text-danger p-0"
                                                title="Удалить комментарий"
                                                onclick="return confirm('Точно удалить?')">
                                            <i class="bi bi-x fs-2"></i>
                                        </button>
                                    </form>
                                @endcan
                            </div>
                            <!-- Modal  UPD comment-->
                            <div class="modal fade" id="updateComment-{{$commentary->id}}"
                                 tabindex="-1"
                                 aria-labelledby="exampleModalLabel"
                                 aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">
                                                Modal title</h1>
                                            <button type="button" class="btn-close"
                                                    data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="myForm"
                                                  action="{{route('books.comments.update',[$book,$commentary])}}"
                                                  method="post">
                                                @csrf
                                                @method('put')
                                                text comment
                                                <textarea class="form-control" rows="4" cols="50"
                                                          type="text"
                                                          name="text">{{ old('text',$commentary->text) }}</textarea>

                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close
                                            </button>
                                            <button form="myForm" type="submit"
                                                    class="btn btn-primary">Save changes
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Modal  UPD comment-->
                        </div>
                        <div>
                            <span>{{ $commentary->text }}</span>
                        </div>

                    </div>
                </div>
            </div>

        @empty
            <div class="text-center py-4">
                <p class="text-muted fs-5">Пока комментариев нет.</p>
            </div>
        @endforelse
    </div>
    <div class="mt-3">{{ $commentaries->links('pagination::bootstrap-5') }}</div>

@endsection
