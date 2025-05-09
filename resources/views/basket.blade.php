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
                            <div class="d-flex align-items-center">
                                <form action="{{ route('basket-item.decrease',$book) }}" method="post"
                                      style="margin-right: 10px;">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-light">-</button>
                                </form>

                                <div class="  d-flex text-center ">{{ $book->quantity }}</div>
                                <form action="{{ route('basket-item.increase', $book) }}" method="post"
                                      style="margin-left: 10px;">
                                    @csrf
                                    <button class="btn btn-light">+</button>
                                </form>

                            </div>
                            {{--                            Цена: {{ $book ->price * $book-> quantity  }}--}}
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
                @if(!Auth::user()->email_verified_at)
                    <span class="badge text-bg-warning p-3">Email не подтвержден

                            <form method="POST" action="{{ route('verification.send') }}">
                                @csrf
                                <button type="submit"
                                        class="btn btn-sm bg-transparent fw-bold text-decoration-underline">Отправить письмо</button>
                            </form>
                    @endif
                <div class="border rounded-5 bg-white ms-4 p-4">
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
                        <select name="address" class="form-select mb-3">
                            @foreach($addresses as $address)
                                <option value="{{$address->id}}">{{$address->name}}</option>
                            @endforeach
                        </select>

                        <input class="btn btn-danger w-25 w-auto {{!Auth::user()->email_verified_at?'disabled':''}}" type="submit" value="Сделать заказ">
                    </form>

                </div>
                <div class="border rounded-5 bg-white ms-4 p-4 mt-3 fs-5">
                    <div class="d-flex justify-content-between">
                        <div>Итого</div>
                        <div>{{ $total_price }}р.</div>
                    </div>
                </div>


            </div>
        @endauth
    </div>
@endsection
