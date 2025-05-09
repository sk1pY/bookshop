@extends('home.index')
@section('content-home')
    <h4>Заказ №{{ $order->id }}</h4>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th scope="col">Книга</th>
            <th scope="col">Сумма</th>
            <th scope="col">Кол-во</th>
            <th scope="col">Адрес самовывоза</th>
            @if($order->status == "Получен")
                <th scope="col">Оценить товар</th>
            @endif
        </tr>
        </thead>
        <tbody>
        @foreach($orderItems as $item)

            <tr>
                <td>
                    <img src="{{ Storage::url('booksImages/'.$item->book->image) }}" alt="404" style="width: 45px; height: 65px">

                <a href="{{route('books.book',['book'=> $item->book])}}">{{ $item->book -> title }}</a></td>
                <td>{{ $item -> book -> price }}</td>
                <td>{{ $item->quantity }}</td>
                <td>{{ $item->order->address->name }}</td>
                @if($order->status == "Получен")
                    <td>

                        <form action="{{ route('books.book',['book' => $item->book]) }}">
                            <input class="btn btn-primary" type="submit" value="Оценить">
                        </form>
                    </td>
                @endif
            </tr>
        @endforeach

        </tbody>
    </table>
    <h3>Сумма заказа: {{$order->price}}р.</h3>

@endsection
