@extends('layouts.app')
@section('content')
<a href="{{ route('books.index') }}">home</a>
<h1>СПИСОК ЗАКАЗОВ</h1>

<h1>ADMIN</h1>
{{--ADD BOOK--}}
<form action="{{route('admin.addBook')}}" method="post">
    @csrf
    Title<input type="text" name="title">
    price<input type="text" name="price">

    <select class="form-select" name="category_id">
        @if(count($categories) > 0)
            @foreach($categories as $category)
                <option >{{$category-> name}}</option>
            @endforeach
        @else
            <option>Без категории</option>
        @endif
    </select>
    <select class="form-select" name="author_id">
        @if(count($authors) > 0)
            @foreach($authors as $author)
                <option >{{$author-> name}}</option>
            @endforeach
        @else
            <option>Без Автора</option>
        @endif
    </select>
    <input type="submit">
</form>
{{--ADD CATEGORY--}}
<form action="{{ route('admin.addCategory') }}" method="post">
    @csrf
    <input type="text" name="category_name">
    <input type="submit">
</form>

    @foreach( $books as $book )
        <h1>{{$book -> title}}</h1>
        <form action="{{ route('admin.deleteBook', $book->id)}}" method="post">
            @csrf
            @method('delete')
            <input  type="submit" value="delete">
        </form>
        <form action="{{ route('admin.updateBook',$book->id)}}" method="post">
            @csrf
            @method('put')
            <input name="title" value="{{$book->title}}">
            <input  type="submit" value="edit">
        </form>

    @endforeach

@endsection
