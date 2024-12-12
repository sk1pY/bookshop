@extends('admin.layouts.index')
@section('content')
    <h1>Адреса самовывоза</h1>

    <form action="{{ route('admin.addresses.store') }}" method="post" class="d-flex mb-5">
        @csrf
        <input class="form-control w-25" type="text" name="address">
        <input  class="btn" type="submit">
    </form>

    <table class="table table-sm table-bordered table-striped w-auto ">
        <thead>
        <tr class="align-middle">
            <th scope="col" class="col-1">#</th>
            <th scope="col" class="col-8">Адрес</th>
            <th scope="col" class="col-1">Изменить/Удалить</th>
        </tr>
        </thead>
        <tbody>
        @foreach( $addresses as $address )
            <tr class="align-middle">
                <th>{{$address -> id}}</th>
                <td>
                    {{$address->address}}
                </td>
                <td class="d-flex">
                    <button type="button" class="btn btn-sm" data-bs-toggle="modal"
                            data-bs-target="#modal-{{ $address->id }}">
                        <i class="bi bi-pencil-square "></i>
                    </button>
                    <form action="{{ route('admin.addresses.destroy', ['address' => $address->id])}}" method="post"
                          id>
                        @csrf
                        @method('delete')
                        <button class="btn btn-sm fs-3 ">
                            <i type="submit" class="bi bi-x "></i>
                        </button>
                    </form>
{{--                                        MODAL--}}
                    <div class="modal fade" id="modal-{{$address->id}}" data-bs-backdrop="static"
                         data-bs-keyboard="false"
                         tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">информация о пользователе</h1>
                                </div>
                                <div class="modal-body">
                                    <form id="formChangeTitle-{{$address->id}}"
                                          action="{{ route('admin.addresses.update',['address'=>$address->id]) }}"
                                          method="post">
                                        @csrf
                                        @method('patch')
                                        <input class="form-control" type="text" name="address" value="{{$address->address}}">

                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button form="formChangeTitle-{{$address->id}}" type="submit"
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
