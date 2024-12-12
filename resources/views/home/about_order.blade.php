@extends('home.index')
@section('сontentAdditional')
    <h4>Заказ №{{ $order->id }}</h4>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th scope="col">Книга</th>
            <th scope="col">Сумма</th>
            <th scope="col">Адрес самовывоза</th>
            @if($order->status == "Получен")
                <th scope="col">Оценить товар</th>
            @endif
        </tr>
        </thead>
        <tbody>
        @foreach($orderItems as $or)

            <tr>
                <td>
                    <img src="{{ Storage::url('booksImages/'.$or->book->image) }}" alt="404" style="width: 45px; height: 65px">

                <a href="{{route('books.book',['book'=> $or->book->id])}}">{{ $or->book -> title }}</a></td>
                <td>{{ $or -> book -> price }}</td>
                <td>{{ $or -> order-> address }}</td>
                @if($order->status == "Получен")
                    <td>

                        <form action="{{ route('books.book',['id' => $or->book->id])}}">
                            <input class="btn btn-primary" type="submit" value="Оценить">
                        </form>
                    </td>
                @endif
            </tr>
        @endforeach

        </tbody>
    </table>


@endsection
