@extends('admin.layouts.index')
@section('content')
    <style>


    </style>
    <table class="table table-sm table-bordered table-striped w-auto ">
        <thead>
        <tr class="align-middle">
            <th scope="col" class="col-1">#</th>
            <th scope="col" class="col-8">имя</th>
            <th scope="col" class="col-1">Изменить/Удалить</th>
        </tr>
        </thead>
        <tbody>
        @foreach( $categories as $category )
            <tr class="align-middle">
                <th>{{$category -> id}}</th>
                <td class=""><a href="{{ route('categories.public.show',['category' => $category->id]) }}"
                                class="text-decoration-none text-dark ">{{$category -> name}}</a>
                </td>
                <td class="d-flex">
                    <button type="button" class="btn btn-sm" data-bs-toggle="modal"
                            data-bs-target="#modal-{{ $category->id }}">
                        <i class="bi bi-pencil-square "></i>
                    </button>
                    <form action="{{ route('admin.categories.destroy', ['category' => $category->id])}}" method="post"
                          id>
                        @csrf
                        @method('delete')
                        <button class="btn btn-sm fs-3 ">
                            <i type="submit" class="bi bi-x "></i>
                        </button>
                    </form>
                    {{--                    MODAL--}}
                    <div class="modal fade" id="modal-{{$category->id}}" data-bs-backdrop="static"
                         data-bs-keyboard="false"
                         tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">информация о пользователе</h1>
                                </div>
                                <div class="modal-body">
                                    <form id="formChangeTitle-{{$category->id}}"
                                          action="{{ route('admin.categories.update',['category'=>$category->id]) }}"
                                          method="post">
                                        @csrf
                                        @method('patch')
                                        <input class="form-control" type="text" name="name" value="{{$category->name}}">

                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button form="formChangeTitle-{{$category->id}}" type="submit"
                                            class="btn btn-success">Принять
                                    </button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>

            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
