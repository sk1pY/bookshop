@extends('layouts.app')
@section('content')

    <div class="container">
        <div class="row">

       <div class="col-6">


        <h1>BASKET</h1>
           @if($booksInBasket === null)
               <h1>Basket is empty</h1>
           @else
        <table class="table " style="width: 500px">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">название книги</th>
                <th scope="col">количество</th>
            </tr>
            </thead>
            <tbody>

            @foreach( $booksInBasket as $basket)
                <tr>
                    <td>{{ $basket-> id }}</td>
                    <td>{{ $basket -> book -> title }}</td>
                    <td>
                        <div class="row">

                        </div>
                        <div
                            style="display: inline-flex; align-items: center; border: 1px solid #ccc; padding: 5px; border-radius: 5px;">
                            <form action="{{ route('basket.delete', $basket->book->id) }}" method="post"
                                  style="margin-right: 10px;">
                                @csrf
                                @method('delete')
                                <button class="btn btn-light"><i class="bi bi-dash-lg"></i>
                                </button>
                            </form>


                                <form action="">
                                    <input type="text" value="{{$basket->count}}"
                                           style="width:30px; text-align: center; Border: none;">
                                </form>

                            <form action="{{ route('basket.add',$basket->book->id) }}" method="post" style="margin-left: 10px;">
                                @csrf
                                <input type="text" hidden name="book_id" value="{{$basket->book->id}}">
                                <button class="btn btn-light"><i class="bi bi-plus-lg"></i>
                                </button>
                            </form>
                        </div>
                        Цена: {{ $basket-> book ->price * $basket-> count  }}
                    </td>
                </tr>
            @endforeach

            </tbody>
        </table>
               <h2>Sum: {{ $total_price }} рублей </h2>

           @endif
        <form action="{{ route('basket.order') }}" method="post">
            @csrf
            <input type="hidden" name="basket" value="{{ json_encode($booksInBasket) }}">
            <input class="btn btn-success" type="submit">
        </form>
    </div>
        <div class="col-6">
            Сделать заказ
            <form action="">
                <input type="text">
                <input type="text">
                <input type="submit">
            </form>
        </div>
    </div>
    </div>


@endsection
