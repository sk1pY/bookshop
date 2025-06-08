@extends('layouts.home')
@section('home-content')
    <h3>Мои отзывы</h3>
    <hr>
    <table id="table" class="table table-sm table-bordered table-hover m-0 ">
        <thead>
        <tr class="text-center ">
            <th class="col-3">Book</th>
            <th>Rating</th>
            <th>#</th>
            <th>#</th>
        </tr>
        </thead>
        <tbody class="">
        @foreach( $comments as $comment )
            <tr class="text-center ">
                <td  class="align-content-center">
                    <a href="{{route('books.book',$comment->book)}}">{{$comment->book->title}}</a>
                </td>
                <td class="align-content-center">
                    @php
                        $fullStars = floor($comment->rating);
                    @endphp
                    @for ($i = 0; $i < $fullStars; $i++)
                        <i class="bi bi-star-fill text-warning"></i>
                    @endfor

                </td>

                <td class="align-content-center">{{$comment -> text}}</td>
                <td class="text-center ">
                    <button class="btn btn-sm"
                            data-bs-toggle="modal"
                            data-bs-target="#update{{ $comment->id }}">
                        <i type="submit" class="bi bi-pencil-square"></i>
                    </button>
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
            <!-- Modal  UPD comment-->
            <div class="modal fade" id="update{{$comment->id}}" tabindex="-1"
                 aria-labelledby="exampleModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="myForm" action="{{route('home.comments.update',$comment)}}"
                                  method="post">
                                @csrf
                                @method('put')
                                text comment
                                <textarea class="form-control" rows="4" cols="50" type="text" name="text">{{ old('text',$comment->text) }}</textarea>

                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close
                            </button>
                            <button form="myForm" type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        </tbody>
    </table>

@endsection
