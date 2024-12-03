@extends('home.index')
@section('сontentAdditional')
    <form action="{{ route('home.orders.index') }}" method="get">

        <div class="d-flex mb-3">
            <div class="ms-2 me-2" >
                <button  class="btn btn-dark" value="all" name="status" >Все заказы</button>

            </div>
            <div class="ms-2 me-2">
                <button class="btn btn-dark"  value="delivered" name="status">Готовые заказы</button>
            </div>
        </div>
    </form>


    @foreach( $orders as $order )
        <a href="{{ route('home.orders.show',['order' => $order->id]) }}">
            <div class=" border rounded-4 bg-white p-4 mb-3">
                Заказ: {{ $order->id }}
                <p>цена: {{ $order -> price }}</p>
                <p>Статус заказа: {{ $order -> status }}</p>
                @if($order->status == "Новый заказ"  )
                    <form action="{{ route('admin.orders.status.update',['id'=>$order->id]) }}" method="post">
                        @csrf
                        @method('patch')
                        <input name="status" type="hidden" value="Отмена заказа">
                        <input class="btn btn-danger" type="submit" value="Отменить заказ">
                    </form>
                @endif

            </div>
        </a>
    @endforeach

@endsection
