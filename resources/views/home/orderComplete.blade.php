@extends('home.index')
@section('сontentAdditional')
        @foreach( $orders as $order )
            <a href="{{ route('home.aboutBought',['order' => $order->id]) }}">
                <div class=" border rounded-4 bg-white p-4 mb-3">
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
@endsection
