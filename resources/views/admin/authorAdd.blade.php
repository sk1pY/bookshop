@extends('admin.index')
@section('authorAdd')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('admin.addAuthor') }}" method="post">
        @csrf
        <div class="input-group mb-3">

        <input  placeholder="Имя" class="form-control" type="text" name="name">
            <input placeholder="Фамилия" class="form-control " type="text" name="surname">
        </div>
        <input type="submit">
    </form>
    <table class="table">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Имя</th>
            <th scope="col">Фамилия</th>
            <th scope="col">Удалить</th>
        </tr>
        </thead>
        <tbody>
        @foreach( $authors as $author )
            <tr>
                <th scope="row">{{$author -> id}}</th>
                <td>{{$author -> name}}</td>
                <td>{{$author -> surname}}</td>
{{--                <td>--}}
{{--                    <!-- Button trigger modal -->--}}
{{--                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"--}}
{{--                            data-bs-target="#staticBackdrop">--}}
{{--                        Изменить--}}
{{--                    </button>--}}

{{--                    <!-- Modal -->--}}
{{--                    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false"--}}
{{--                         tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">--}}
{{--                        <div class="modal-dialog">--}}
{{--                            <div class="modal-content">--}}
{{--                                <div class="modal-header">--}}
{{--                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Изменить данные книги</h1>--}}
{{--                                    <button type="button" class="btn-close" data-bs-dismiss="modal"--}}
{{--                                            aria-label="Close"></button>--}}
{{--                                </div>--}}
{{--                                <div class="modal-body">--}}

{{--                                    <form id="formChangeTitle" action="{{ route('admin.updateBook',$book->id)}}" method="post">--}}
{{--                                        @csrf--}}
{{--                                        @method('put')--}}
{{--                                        <label for="title" class="form-label">Title</label>--}}
{{--                                        <input  id="title" class="form-control" name="title" value="{{$book->title}}">--}}
{{--                                        --}}{{--                                        <input type="submit" value="edit">--}}
{{--                                    </form>--}}
{{--                                </div>--}}
{{--                                <div class="modal-footer">--}}
{{--                                    <button form="formChangeTitle" type="submit" class="btn btn-success" >Принять--}}
{{--                                    </button><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close--}}
{{--                                    </button>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </td>--}}
                <td>
                    <form action="{{ route('admin.deleteAuthor',['id'=>$author->id])}}" method="post"
                          id>
                        @csrf
                        @method('delete')
                        <input class="btn btn-danger" type="submit" value="Удалить">
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>


@endsection
