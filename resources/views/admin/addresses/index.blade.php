@extends('admin.layouts.index')
@section('content')
    <div class="p-3">
        <h4>Адреса</h4>
        <hr>    <a href="{{route('admin.addresses.deleted')}}"
    class="btn btn-primary m-2">Восстановить удаленные адреса</a>
    <form action="{{ route('admin.addresses.store') }}" method="post" class="d-flex mb-5">
        @csrf
        <input class="form-control w-25" type="text" name="name">
        <input  class="btn btn-sm btn-primary" type="submit" value="Добавить адрес">
    </form>

    <table class="table table-sm table-bordered table-striped m-0">
        <thead>
        <tr class="align-middle">
            <th scope="col" class="col-1 p-1">#</th>
            <th scope="col" class="col-8 p-1">Адрес</th>
            <th scope="col" class="col-1 p-1">Удалить</th>
        </tr>
        </thead>
        <tbody>
        @foreach( $addresses as $address )
            <tr class="align-middle">
                <th class="p-1">{{$address->id}}</th>
                <td class="p-1">
                    {{$address->name}}
                </td>
                <td class="d-flex p-1 justify-content-center">
                    <form action="{{ route('admin.addresses.destroy',  $address) }}" method="post" class="ms-1">
                        @csrf
                        @method('delete')
                        <button class="btn btn-sm">
                            <i type="submit" class="bi bi-x "></i>
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    </div>

@endsection
