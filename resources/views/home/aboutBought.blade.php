@extends('home.index')
@section('myorders')
    <h1>Заказ {{ $order->id }}</h1>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th scope="col">Название книги</th>
            <th scope="col">Цена</th>
            @if($order->status == "Получен")
            <th scope="col">Оценить товар</th>
            @endif
        </tr>
        </thead>
        <tbody>
        @foreach($orderItems as $or)

            <tr>
                <td>{{ $or->book -> title }}</td>
                <td>{{ $or -> book -> price }}</td>
                @if($order->status == "Получен")
                <td>

                    <form action="{{ route('books.book',['id' => $or->book->id])}}">
                        <input class="btn btn-primary" type="submit" value="Оценить">
                    </form></td>
                @endif
            </tr>
        @endforeach

        </tbody>
    </table>


    <h1>сумма заказа: {{ $order -> price }} $</h1>

@endsection
