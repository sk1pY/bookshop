@extends('admin.index')
@section('books')
@foreach( $books as $book )
    <h1>{{$book -> title}}</h1>
    <form action="{{ route('admin.deleteBook', $book->id)}}" method="post">
        @csrf
        @method('delete')
        <input type="submit" value="delete">
    </form>
    <form action="{{ route('admin.updateBook',$book->id)}}" method="post">
        @csrf
        @method('put')
        <input name="title" value="{{$book->title}}">
        <input type="submit" value="edit">
    </form>

@endforeach
@endsection
