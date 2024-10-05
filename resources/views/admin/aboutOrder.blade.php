@extends('admin.index')
@section('section')
    <h4>Заказ №{{$order->id}}</h4>
    <table class="table">
        <tbody>
        @foreach($order_items as $item)
            @php
                $book = $item->book;
            @endphp
            <tr>
                <td>
                    <img style="width: 100px" src="{{ Storage::url('booksImages/' . $book -> image) }}" alt="">
                    {{ $book->title }}
                </td>
                <td>{{ $book->price }} р.</td>
                <td>
                    {{ $item->quantity }} шт.
                </td>
            </tr>
        @endforeach
        </tbody>

    </table>

    <h1>Сумма заказа {{ $order -> price }}р.</h1>
@endsection
