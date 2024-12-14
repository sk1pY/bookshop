@extends('admin.layouts.index')
@section('content')
    <form action="{{ route('admin.roles.store') }}" method="post">
        @csrf
        <input type="text" placeholder="роль" name="role">
        <input type="submit">
    </form>
    <h1>Roles</h1>
    <table class="table table-sm table-bordered table-striped">
        <thead>
        <tr>
            <th scope="col" class="col-1">#</th>
            <th scope="col" class="col-7">Автор</th>
            <th scope="col" class="col-1">Удалить</th>
        </tr>
        </thead>
        <tbody>
        @forelse($roles as $role)
            <tr>
                <th scope="row">{{$role -> id}}</th>
                <td>
                    {{$role->name}}
                <td>
                    <form action="{{ route('admin.roles.destroy',['role' => $role->id]) }}" method="post">
                        @csrf
                        @method('delete')
                        <input type="submit">
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <form action="{{ route('admin.permissions.store') }}" method="post">
        @csrf
        <select>
            @foreach($roles as $role)
                <option value="{{$role->name}}">{{$role->name}}</option>

            @endforeach
        </select>
        <input type="text" placeholder="разрешение" name="permission">
        <input type="submit">
    </form>


    <h1>Permissions</h1>
    <table class="table table-sm table-bordered table-striped">
        <thead>
        <tr>
            <th scope="col" class="col-1">#</th>
            <th scope="col" class="col-7">Автор</th>
            <th scope="col" class="col-1">Удалить</th>
        </tr>
        </thead>
        <tbody>
        @forelse($permissions as $permission)
            <tr>
                <th scope="row">{{$permission -> id}}</th>
                <td>
                {{$permission->name}}
                <td>
                    <form action="{{ route('admin.permissions.destroy',['permission' => $permission->id]) }}" method="post">
                        @csrf
                        @method('delete')
                        <input type="submit">
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>


    <form action="{{ route('admin.permissions_roles.store') }}" method="post">
        @csrf
        <select>
            @foreach($roles as $role)
                <option value="{{$role->name}}">{{$role->name}}</option>

            @endforeach
                @foreach($permissions as $permission)
                <option value="{{$permission->name}}">{{$permission->name}}</option>

            @endforeach
        </select>
        <input type="submit">
    </form>

@endsection
