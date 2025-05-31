@extends('layouts.home')
@section('home-content')
    <h3>Мои отзывы</h3>
    <hr>
    <table id="table" class="table table-sm table-bordered table-hover m-0">
        <thead>
        <tr class="text-center">
            <th>Book</th>
            <th>Rating</th>
            <th>#</th>
            <th>#</th>
        </tr>
        </thead>
        <tbody>
        @foreach( $comments as $comment )
            <tr class="text-center">
                <td style="width: 170px">
                    <a href="{{route('books.book',$comment->book)}}">{{$comment->book->title}}</a>
                </td>
                <td style="width: 200px">
                    @php
                        $fullStars = floor($comment->rating);
                    @endphp
                    @for ($i = 0; $i < $fullStars; $i++)
                        <i class="bi bi-star-fill text-warning"></i>
                    @endfor

                </td>

                <td>{{$comment -> text}}</td>
                <td>
                    <form action="{{ route('home.comments.destroy',$comment)}}" method="post">
                        @csrf
                        @method('delete')
                        <button class="btn btn-sm"
                                onclick="return confirm('Точно удалить?')">
                            <i type="submit" class="bi bi-x"></i>
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>


@endsection
