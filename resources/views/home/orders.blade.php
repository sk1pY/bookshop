@extends('layouts.home')
@section('home-content')
    <form action="{{ route('home.orders.index') }}" method="get">

        <div class="d-flex mb-3">
            <div class="ms-2 me-2" >
                <button  class="btn btn-outline-dark" value="all" name="status" >Все заказы</button>

            </div>
            <div class="ms-2 me-2">
                <button class="btn btn-outline-dark"  value="delivered" name="status">Готовые заказы</button>
            </div>
        </div>
    </form>


    @foreach( $orders as $order )
        <a href="{{ route('home.orders.show', $order ) }}">
                <div class=" border rounded-4 bg-white p-4 mb-3">
                Заказ: {{ $order->id }}
                <p>Сумма: {{ $order -> price }} р.</p>
                <p>Статус заказа: {{ $order -> status }}</p>
                @if($order->status === "Новый заказ"  )
                    <form action="{{ route('home.orders.destroy',$order) }}" method="post">
                        @csrf
                        @method('delete')
                        <input name="status" type="hidden" value="Отмена заказа">
                        <input class="btn btn-outline-danger" type="submit" value="Отменить заказ">
                    </form>
                @endif

            </div>
        </a>
    @endforeach

@endsection
