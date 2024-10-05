@extends('admin.index')
@section('section')
    <table class="table">
        <thead>
        <tr class=" text-center ">
            <th scope="col">Книга</th>
            <th scope="col" >Цена</th>
            <th scope="col">Автор</th>
            <th scope="col">В наличии</th>
            <th scope="col">Изменить/Удалить</th>
        </tr>
        </thead>

        @foreach( $books as $book )
            <tbody class="  ">
            <tr>
                <td style="width: 200px;"><img alt="logo" src="{{ Storage::url('booksImages/'.$book->image) }}  " style="width: 50px;">
                    <a href="{{ route('books.book',['id' => $book ->id] )}}">{{$book -> title}}</a>
                </td>
                <td class=" text-center ">
                    {{$book->price}}
                </td>
                @if($book->author !== null)
                    <td class=" text-center ">
                        <p>{{$book->author->name}}</p>
                    </td>
                @else
                    <td class=" text-center ">
                        без автора
                    </td>
                @endif
            <td class="text-center">
                {{$book->stock}}
            </td>
                <td class=" text-center ">
                    <!-- Button trigger modal -->
                    <button type="button" class="btn fs-3" data-bs-toggle="modal"
                            data-bs-target="#staticBackdrop">
                        <i class="fa-solid fa-pencil"></i>
                    </button>

                    <!-- Modal -->
                    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false"
                         tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Изменить данные книги</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                </div>
                                <div class="modal-body">

                                    <form id="formChangeTitle" action="{{ route('admin.updateBook',$book->id)}}"
                                          method="post">
                                        @csrf
                                        @method('put')
                                        <label for="title" class="form-label">Title</label>
                                        <input id="title" class="form-control" name="title" value="{{$book->title}}">
                                        {{--                                        <input type="submit" value="edit">--}}
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button form="formChangeTitle" type="submit" class="btn btn-success">Принять
                                    </button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('admin.deleteBook', $book->id)}}" method="post"
                          id>
                        @csrf
                        @method('delete')
                        <button class="btn fs-3">
                            <i type="submit" class="fa-solid fa-trash"></i>

                        </button>
                    </form>
                </td>
            </tr>
            @endforeach

            </tbody>

    </table>
    <div class="mt-4">
        {{ $books->links('pagination::bootstrap-5') }}

    </div>
@endsection
