@extends('layouts.app')
@section('content')
    <h1>Личный данные</h1>
    <p>имя: {{$user -> name}}</p>
    <p>почта: {{$user -> email}}</p>

    <h1>мои заказы</h1>
    @foreach( $orders as $order )

        @foreach($order -> order_items as $item)
            {{$item -> book ->title}}
        @endforeach
        <p>{{ $order -> price }}</p>
    @endforeach
    <h1>Мои закладки</h1>
    @foreach($bookmarks as $bookmark)
        {{$bookmark -> book -> title}}
        <form action="{{ route('bookmark.delete',['id' => $bookmark->id])}}" method="post">
            @csrf
            @method('delete')
            <input type="submit" value="удалить">
        </form>
    @endforeach
@endsection

