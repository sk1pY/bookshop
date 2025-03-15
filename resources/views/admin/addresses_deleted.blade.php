@extends('admin.layouts.index')
@section('content')
    <table class="table table-sm table-bordered table-striped m-0">
        <thead>
        <tr class="align-middle">
            <th scope="col" class="col-1 p-1">#</th>
            <th scope="col" class="col-8 p-1">Адрес</th>
            <th scope="col" class="col-1 p-1">Восстановить</th>
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
                    <form action="{{route('admin.addresses.restore',$address)}}">
                        <button type="submit" class="btn btn-success">Восстановить</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

@endsection
