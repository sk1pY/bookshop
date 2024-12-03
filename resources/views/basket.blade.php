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
        @if($booksInBasket === null)
            <h1>Basket is empty</h1>
        @else
            <div class="col-6 border rounded-5 bg-white ms-4 p-4 table-responsive">
                <h1 class="fw-normal">Корзина</h1>
                <table class="table table-bordered " style="width: 500px">
                    <thead>
                    <tr>
                        <th scope="col">Книга</th>
                        <th scope="col">количество</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach( $booksInBasket as $basket)
                        <tr>
                            <td>
                                <div class="d-flex">
                                    <img style="width: 80px" src="{{ Storage::url('booksImages/' . $basket->book -> image) }}" alt="">
                                    <div class="d-flex align-items-center ms-3">
                                        <a href="{{route('books.book',['id'=> $basket->book->id])}}">
                                            {{ $basket->book->title }}
                                        </a>
                                    </div>

                                </div>
                            </td>
                            <td>
                                <div class="row">

                                </div>
                                <div style="display: inline-flex; align-items: center; border: 1px solid #ccc; padding: 5px; border-radius: 5px;">
                                    <form action="{{ route('basket.delete',['id'=> $basket->book->id]) }}" method="post"
                                          style="margin-right: 10px;">
                                        @csrf
                                        @method('delete')
                                        <button class="btn btn-light">-</button>
                                    </form>

                                    <div class="  d-flex text-center ">{{$basket->quantity}}</div>
                                    <form action="{{ route('basket.add',['id'=> $basket->book->id]) }}" method="post"
                                          style="margin-left: 10px;">
                                        @csrf
                                        <button class="btn btn-light" >+</button>
                                    </form>

                                </div>
                                Цена: {{ $basket-> book ->price * $basket-> quantity  }}
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
                <h2 class="fw-normal ">Сумма: {{ $total_price }} рублей </h2>
            </div>

            <div class="col border rounded-5 bg-white ms-4 p-4">
                <h1 class="fw-normal">Информация о заказе</h1>
                <form class="d-flex flex-column" action="{{ route('basket.order') }}" method="post">
                    @csrf
                    <input class="form-control" type="hidden" name="basket" value="{{ json_encode($booksInBasket) }}">
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
    </div>
    @endif
@endsection
