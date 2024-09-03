@extends('layouts.app')
@section('content')
    <h1> {{ $book -> title }}</h1>
    <p>рейтинг: {{ $book -> avgRating }}</p>

    <form action="{{ route('comment.add',['id'=>$book->id])  }}" id="commentaryForm" method="post">
        @csrf
        <input type="text" name="text">
        <input type="submit">
    </form>

    <label for="rating">Choose a rating:</label>
    <select id="rating" name="rating" form="commentaryForm">
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
    </select>
    @foreach($commentaries as $commentary)
        <div class="d-flex flex-column">
            <div><p>{{$commentary -> text}}</p>
                <p>оценка {{ $commentary->rating }}</p>
            <form action="{{route('comment.delete',$commentary->id)}}" method="post">
                @csrf
                @method('DELETE')
                <input class="btn btn-danger" type="submit" value="Удалить">
            </form>
            </div>
        </div>

    @endforeach
@endsection
