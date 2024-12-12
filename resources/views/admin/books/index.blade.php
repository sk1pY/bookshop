@extends('admin.layouts.index')
@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <table class="table table-sm table-bordered table-striped">
        <thead>
        <tr class="text-center align-middle">
            <th scope="col" class="col-5">Книга</th>
            <th scope="col" class="col-1">Цена</th>
            <th scope="col" class="col-2">Автор</th>
            <th scope="col" class="col-1">В наличии</th>
            <th scope="col" class="col-1">Удалить/изменить</th>
        </tr>
        </thead>
        <tbody>
        @foreach( $books as $book )
            <tr class="align-middle">
                <td>
                    <img alt="logo" src="{{ Storage::url('booksImages/' . $book->image) }}" style="width: 30px;">
                    <a class="text-decoration-none text-black "
                       href="{{ route('books.book',['id' => $book ->id] )}}">{{$book -> title}}</a>
                </td>
                <td class=" text-center ">
                    {{$book->price}} р.
                </td>
                <td class=" text-center ">
                    <p>{{$book->author? $book->author->surname.' '.$book->author->name: 'Без автора'}}</p>
                </td>
                <td class="text-center">
                    {{$book->stock}}
                </td>
                <td class="text-center d-flex ">
                    <button type="button" class="btn btn-sm" data-bs-toggle="modal"
                            data-bs-target="#update.{{$book->id}}">
                        <i class="bi bi-pencil-square"></i>
                    </button>
                    <form action="{{ route('admin.books.destroy', $book->id)}}" method="post"
                          id>
                        @csrf
                        @method('delete')
                        <button class="btn btn-sm fs-3">
                            <i type="submit" class="bi bi-x"></i>
                        </button>
                    </form>
                </td>
            </tr>
            <!-- Modal -->
            <div class="modal fade" id="update.{{$book->id}}" data-bs-backdrop="static" data-bs-keyboard="false"
                 tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Изменить данные книги</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('admin.books.update',['book'=>$book->id])}}"
                                  method="post">
                                @csrf
                                @method('put')
                                <label for="title" class="form-label">Title</label>
                                <input id="title" class="form-control" name="title"
                                       value="{{ old('title',$book->title) }}">
                                <label for="price" class="form-label">Price</label>
                                <input id="price" class="form-control" name="price" value="{{$book->price}}">
                                <label for="author" class="form-label">author</label>
                                <select class="form-control" name="author_id">
                                    <option value="" {{ !$book->author? 'selected' : '' }}>Без автора</option>
                                    @foreach($authors as $author)
                                        <option
                                            value="{{$author->id}}"
                                            {{$book->author && $book->author->id == $author->id? 'selected':''}}>
                                            {{$author->surname.' '.$author->name}}
                                        </option>
                                    @endforeach
                                </select>

                                <label for="stock" class="form-label">stock</label>

                                <input id="stock" class="form-control" name="stock" value="{{$book->stock}}">
                                <input type="file" name="image">
                                <img src="{{ Storage::url('booksImages/'.$book->image) }}" alt="123"
                                     style="width: 40px;height: 40px;">
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-success">Принять
                                    </button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close
                                    </button>
                                </div>
                            </form>

                        </div>

                    </div>
                </div>
            </div>
        @endforeach

        </tbody>

    </table>
    <div class="mt-4">
        {{ $books->links('pagination::bootstrap-5') }}
    </div>

@endsection
