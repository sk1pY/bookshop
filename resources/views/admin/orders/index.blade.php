@extends('admin.layouts.index')
@section('content')
    @if ( session('successStatusUpdate') )
        <div class="alert alert-success d-flex px-4">
            <div>{{ session('successStatusUpdate') }}</div>
        </div>
    @endif
    <table class="table ">
        <thead>
        <tr>
            <th scope="col">№</th>
            <th scope="col">Клиент</th>
            <th scope="col">Дата формирования заказа</th>
            <th scope="col">#</th>
            <th scope="col">Status</th>
        </tr>
        </thead>
        <tbody>
        @foreach( $orders as $order )
            <tr>
                <th scope="row">заказ №{{$order-> id}}</th>
                <td>{{$order-> user -> name}}</td>
                <td>

                        {{ $order->created_at->format('F j, Y, g:i a') }}
                </td>
            <td>
                <a href ="{{ route('admin.orders.show',['id'=>$order->id]) }}" class="btn btn-secondary">Подробнее</a>
            </td>
                <td>
                    <form action="{{ route('admin.orders.status.update', ['id' => $order->id]) }}"
                          id="statusForm{{ $order -> id }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <select name="status" id="status" form="statusForm{{ $order->id }}">
                            <option value="новый заказ" {{ $order->status == 'новый заказ'? 'selected' :''}}>Не готов</option>
                            <option value="Готов к выдаче" {{ $order->status == 'Готов к выдаче'? 'selected' :''}}>Готов к выдаче</option>
                            <option value="Получен" {{ $order->status == 'Получен'? 'selected' :''}}>Получен</option>
                            <option value="Отмена заказа" {{ $order->status == 'Отмена заказа'? 'selected' :''}}>Отмена Заказа</option>
                        </select>
                        <input type="submit" value="Обновить статус">
                    </form>
                </td>

            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
