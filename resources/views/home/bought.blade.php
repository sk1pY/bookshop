@extends('home.index')
@section('myorders')
    <h1>мои заказы</h1>
    @foreach( $orders as $order )
        <a href="{{ route('home.aboutBought',['order' => $order->id]) }}">
            <div class="border border-2 m-1 p-2">
                Заказ: {{ $order->id }}
                <p>цена: {{ $order -> price }}</p>
                <p>Статус заказа: {{ $order -> status }}</p>

            </div>
        </a>
    @endforeach
@endsection
