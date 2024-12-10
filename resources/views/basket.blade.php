@extends('layouts.app')
@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if ( session('basket') )
        <div class="alert alert-danger d-flex px-4">
            <div>{{ session('basket') }}</div>
        </div>
    @endif
    @if ( session('success') )
        <div class="alert alert-success d-flex px-4">
            <div>{{ session('success') }}</div>
        </div>
    @endif
    <div class="row">

        <div class="col-6 border rounded-5 bg-white ms-4 p-4 table-responsive">

            <table class="table table-bordered " style="width: 500px">
                <thead>
                <tr>
                    <th scope="col">Книга</th>
                    <th scope="col">количество</th>
                </tr>
                </thead>

                <tbody>
                @forelse($books as $book)

                    <tr>
                        <td>
                            <div class="d-flex">
                                <img style="width: 80px" src="{{ Storage::url('booksImages/' .$book->image) }}"
                                     alt="">
                                <div class="d-flex align-items-center ms-3">
                                    <a href="{{route('books.book',['id'=> $book->id])}}">
                                        {{ $book->title }}
                                    </a>
                                </div>

                            </div>
                        </td>
                        <td>
                            <div class="row">

                            </div>
                            <div
                                style="display: inline-flex; align-items: center; border: 1px solid #ccc; padding: 5px; border-radius: 5px;">
                                <form action="{{ route('basket.delete',['id'=> $book->id]) }}" method="post"
                                      style="margin-right: 10px;">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-light">-</button>
                                </form>

                                <div class="  d-flex text-center ">{{ $book->quantity }}</div>
                                <form action="{{ route('basket.add',['id'=> $book->id]) }}" method="post"
                                      style="margin-left: 10px;">
                                    @csrf
                                    <button class="btn btn-light">+</button>
                                </form>

                            </div>
                            Цена: {{ $book ->price * $book-> quantity  }}
                        </td>
                    </tr>

                @empty
                    <h5>Пустая корзина</h5>
                @endforelse
                </tbody>
            </table>

            <h2 class="fw-normal ">Сумма: {{ $total_price }} рублей </h2>

        </div>
        @guest
        <div class="col border rounded-5 bg-white ms-4 p-4">
            <p>Зарегистрируйтесь или авторизуйтесь, чтобы сделать заказ</p>
            <a class="btn btn-secondary" href="{{ route('register') }}">Регистрация</a>
            <a class="btn btn-secondary" href="{{ route('login') }}">Войти</a>

        </div>
        @endguest
        @auth

            <div class="col border rounded-5 bg-white ms-4 p-4">
                <h1 class="fw-normal">Информация о заказе</h1>
                <form class="d-flex flex-column" action="{{ route('basket.order') }}" method="post">
                    @csrf
                                        <input class="form-control" type="hidden" name="basket" value="{{ json_encode($books) }}">
                                        <input class="form-control" type="hidden" name="total_price" value="{{ $total_price }}">
                    <label for="name">Имя</label>
                    <input class="mb-3 form-control" id="name" name="name" type="text"
                           value="{{ Auth::user()->name ?? old('name') }}">
                    <label for="surname">Фамилия</label>
                    <input class="mb-3 form-control" id="surname" name="surname" type="text"
                           value="{{ Auth::user()->surname ?? old('surname') }}">
                    <label for="phone">Телефон</label>
                    <input class="mb-3 form-control" id="phone" name="phone" type="text"
                           value="{{ Auth::user()->phone }}">
                    <label for="address">Адрес доставки</label>
                    <input class="mb-3 form-control" id="address" name="address" type="text"
                           value="{{ Auth::user()->address }}">
                    <input class="btn btn-danger w-25 w-auto" type="submit" value="Сделать заказ">
                </form>

            </div>
        @endauth
    </div>
@endsection
