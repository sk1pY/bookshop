@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-6 rounded-5 bg-white ms-4 p-4 table-responsive">

            <table class="table table-sm" style="width: 500px">

                <tbody>
                @forelse($books as $book)
                    <tr>
                        <td class="align-middle">

                            <div class="d-flex w-auto align-items-center">
                                <img style="width: 80px" src="{{ Storage::url('booksImages/' .$book->image) }}"
                                     alt="">
                                <div class="ms-3">
                                    <a href="{{route('books.book',$book)}}">
                                        {{ $book->title }}
                                    </a>
                                </div>
                            </div>
                        </td>
                        <td class="align-middle">
                            <div class="d-flex flex-column">

                            </div>
                            <div class="increase_decrease_buttons mt-auto bg-light rounded-pill ">
                                <div
                                    class="button-inc-dec justify-content-between d-flex">
                                    <div class="decrease-button"
                                         data-url="{{ route('basket-item.decrease', $book) }}"
                                         data-book-id="{{$book->id}}">
                                        <button class="btn">
                                            -
                                        </button>
                                    </div>
                                    <div
                                        class="basket_item_count text-dark d-flex justify-content-center align-items-center"
                                        data-book-id="{{$book->id}}">
                                        {{ $book->quantity ?? '' }}
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
                            <div class="d-flex justify-content-center text-muted " style="font-size: 0.7rem">
                                {{$book->price }} р./шт
                            </div>
                        </td>
                        <td class="align-middle">
                        </td>
                        <td class="align-middle">
                            <span id="full-price-book-{{$book->id}}">
                                {{$book->fullPrice}}
                            </span>р.
                        </td>
                        <td class="align-middle">
                            <form action="{{ route('basket-item.deleteAll', $book)}}" method="post"
                                  id>
                                @csrf
                                @method('delete')
                                <button class="btn btn-sm fs-3">
                                    <i type="submit" class="bi bi-x"></i>
                                </button>
                            </form>
                        </td>
                    </tr>

                @empty
                    <h5>Пустая корзина</h5>
                @endforelse
                </tbody>
            </table>


        </div>
        @guest
            <div class="col border rounded-5 bg-white ms-4 p-4">
                <p>Зарегистрируйтесь или авторизуйтесь, чтобы сделать заказ</p>
                <a class="btn btn-secondary" href="{{ route('register') }}">Регистрация</a>
                <a class="btn btn-secondary" href="{{ route('login') }}">Войти</a>
            </div>
        @endguest
        @auth

            <div class="col">
                <div class="border rounded-5 bg-white ms-4 p-4">
                    <div class="d-flex justify-content-center">
                        @if(!Auth::user()->email_verified_at)
                            <span class="badge text-bg-danger p-3">Email не подтвержден</span>
                            <form method="POST" action="{{ route('verification.send') }}">
                                @csrf
                                <button type="submit"
                                        class="btn btn-sm bg-transparent fw-bold text-decoration-underline">Отправить письмо
                                </button>
                            </form>
                        @endif
                    </div>

                    <form id="bookForm" class="d-flex flex-column" action="{{ route('basket.order') }}" method="post">
                        @csrf
                        <input type="hidden" id="basket" name="basket">
                        <input class="form-control" type="hidden" name="total_price" value="{{ $total_price }}">
                        <label for="name">Имя</label>
                        <input class="mb-3 form-control" id="name" name="name" type="text"
                               value="{{ Auth::user()->name ?? old('name') }}">
                        <label for="surname">Фамилия</label>
                        <input class="mb-3 form-control" id="surname" name="surname" type="text"
                               value="{{ Auth::user()->surname ?? old('surname') }}">
                        <label for="phone">Телефон</label>
                        <input class="mb-3 form-control" id="phone" name="phone" type="text"
                               value="{{ Auth::user()->phone?? '+375'}}" maxlength="13">
                        <label for="address">Самовывоз</label>
                        <select name="addressId" class="form-select mb-3">
                            @foreach($addresses as $address)
                                <option value="{{$address->id}}">{{$address->name}}</option>
                            @endforeach
                        </select>


                        <input class="btn btn-danger w-25 w-auto {{!Auth::user()->email_verified_at?'disabled':''}}"
                               type="submit" value="Сделать заказ">
                    </form>

                </div>
                <div class="border rounded-5 bg-white ms-4 p-4 mt-3 fs-5">
                    <div class="d-flex justify-content-between">
                        <div>Итого</div>
                        <div class="basket_price">{{ $total_price }}</div>
                    </div>
                </div>


            </div>
        @endauth
    </div>
@endsection
