@extends('admin.layouts.index')
@section('content')
    <div class="p-3">
        <h4>Категории</h4>
        <hr>
        <table id="table" class="table table-sm table-bordered table-hover m-0">
        <thead>
        <tr class=>
            <th scope="col" >#</th>
            <th scope="col" >имя</th>
            <th scope="col" >Изменить/Удалить</th>
        </tr>
        </thead>
        <tbody>
        @foreach( $categories as $category )
            <tr >
                <th class="text-center p-0">{{$category -> id}}</th>
                <td class="text-center p-0"><a href="{{ route('categories.show',$category->slug) }}"
                                class="text-decoration-none text-dark ">{{$category -> name}}</a>
                </td>
                <td class="d-flex text-center p-0">
                    <button type="button" class="btn btn-sm" data-bs-toggle="modal"
                            data-bs-target="#modal-{{ $category->id }}">
                        <i class="bi bi-pencil-square "></i>
                    </button>
                    <form action="{{ route('admin.categories.destroy', $category)}}" method="post"
                          id>
                        @csrf
                        @method('delete')
                        <button class="btn btn-sm"
                                onclick="return confirm('Точно удалить?')">
                            <i type="submit" class="bi bi-x"></i>
                        </button>
                    </form>
                    {{--                    MODAL--}}
                    <div class="modal fade" id="modal-{{$category->id}}" data-bs-backdrop="static"
                         data-bs-keyboard="false"
                         tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Категория</h1>
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
                                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close
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
    <div class="mt-4">
        {{ $categories->links('pagination::bootstrap-5') }}
    </div>
    </div>
@endsection
