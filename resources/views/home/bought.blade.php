@extends('home.index')
@section('сontentAdditional')
    <div class="col border rounded-5 bg-white ms-4 p-4">
    <h1>Мои заказы</h1>
    @foreach( $orders as $order )
        <a href="{{ route('home.aboutBought',['order' => $order->id]) }}">
            <div class="border border-2 m-1 p-2">
                Заказ: {{ $order->id }}
                <p>цена: {{ $order -> price }}</p>
                <p>Статус заказа: {{ $order -> status }}</p>
                @if($order->status == "Новый заказ"  )
                    <form action="{{ route('admin.addStatusOrder',['id'=>$order->id]) }}" method="post">
                        @csrf
                        @method('patch')
                        <input name="status" type="hidden" value="Отмена заказа">
                        <input class="btn btn-danger" type="submit" value="Отменить заказ">
                    </form>
                @endif

            </div>
        </a>
    @endforeach
    </div>
@endsection
