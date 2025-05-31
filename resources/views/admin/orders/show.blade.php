@extends('layouts.admin')
@section('admin-content')
    <h4>Заказ №{{$order->id}}</h4>
    <div class="row">
        <div class="col-6">
            <table class="table table-sm table-bordered table-striped">
            <tbody>
            @foreach($order_items as $item)
                @php
                    $book = $item->book;
                @endphp
                <tr>
                    <td>
                        <img src="{{ Storage::url('booksImages/'.$book->image) }}" alt="123"
                             style ="width:30px; height: 40px" >
                        <a class="text-decoration-none text-dark" href="{{route('books.book',$book)}}">{{ $book->title }}</a>
                    </td>
                    <td>{{ $item->sum_res }} р.</td>
                    <td>
                        {{ $item->quantity }} шт.
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        </div>
    <div class="col-4 bg-white rounded-3">
        <p>Имя: {{$order->user->name}}</p>
        <p>Адрес самовывоза: {{$order->address->name}}</p>
        <p>Номер телефона: {{$order->user->phone}}</p>
    </div>
    </div>


    <h1 class="text fs-4 ">Сумма заказа {{ $order -> price }}р.</h1>
@endsection
