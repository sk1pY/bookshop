@extends('admin.index')
@section('orders')
    <table class="table ">
        <thead>
        <tr>
            <th scope="col">id</th>
            <th scope="col">User</th>
            <th scope="col">Title</th>
            <th scope="col">Status</th>
        </tr>
        </thead>
        <tbody>
        @foreach( $orders as $order )
            <tr>
                <th scope="row">{{$order-> id}}</th>
                <td>{{$order-> user -> name}}</td>
                <td>
                    @foreach($order->order_items as $item)
                        {{ $item->book->title }}<br>
                    @endforeach
                </td>
                <td>
                    <form action="{{ route('admin.addStatusOrder', ['id' => $order->id]) }}"
                          id="statusForm{{ $order -> id }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <select name="status" id="status" form="statusForm{{ $order->id }}">
                            <option value="новый заказ" {{ $order->status == 'новый заказ'? 'selected' :''}}>Не готов</option>
                            <option value="Готов к выдаче" {{ $order->status == 'Готов к выдаче'? 'selected' :''}}>Готов к выдаче</option>
                            <option value="Получен" {{ $order->status == 'Получен'? 'selected' :''}}>Получен</option>
                        </select>
                        <input type="submit" value="Обновить статус">
                    </form>

                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
