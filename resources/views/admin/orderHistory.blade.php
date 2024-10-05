@extends('admin.index')
@section('section')

    <table class="table ">
        <thead>
        <tr>
            <th scope="col">№</th>
            <th scope="col">Клиент</th>
            <th scope="col">Дата завершения заказа</th>
            <th scope="col">#</th>
        </tr>
        </thead>
        <tbody>
        @foreach( $orders as $order )
            <tr>
                <th scope="row">заказ №{{$order-> id}}</th>
                <td>{{$order-> user -> name}}</td>
                <td>
                    {{ $order->updated_at->format('F j, Y, g:i a') }}
                </td>
                <td>
                    <a href="{{ route('admin.order',['id'=>$order->id]) }}" class="btn btn-secondary">Подробнее</a>
                </td>


            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
