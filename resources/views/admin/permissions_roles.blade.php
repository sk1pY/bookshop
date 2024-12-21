@extends('admin.layouts.index')
@section('content')
    @if ( session('success') )
        <div class="alert alert-success d-flex px-4">
            <div>{{ session('success') }}</div>
        </div>
    @endif

    <div class="row">
        <div class="col-5">
            <form action="{{ route('admin.roles.store') }}" method="post" class="d-flex align-items-center gap-2">
                @csrf
                <input type="text" placeholder="роль" name="role">
                <input  class="btn btn-sm btn-primary" type="submit" value="Добавить">
            </form>
            <h1>Роли</h1>
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
                                <input class="btn btn-sm btn-danger" type="submit" value="Удалить">
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="col-5">
            <form action="{{ route('admin.permissions.store') }}" method="post" class="d-flex align-items-center gap-2">
                @csrf
                <input class="form-control" type="text" placeholder="Разрешение" name="permission">
                <input class="btn btn-sm btn-primary" type="submit" value="Добавить">
            </form>



            <h1>Разрешения</h1>
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
                            <form action="{{ route('admin.permissions.destroy',['permission' => $permission->id]) }}"
                                  method="post">
                                @csrf
                                @method('delete')
                                <input class="btn btn-sm btn-danger" type="submit" value="Удалить">
                            </form>
                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>

        </div>
    </div>

    <table class="table table-sm table-bordered table-striped">
        <thead>
        <tr>
            <th scope="col" class="col-3">Роль</th>
            <th scope="col" class="col-7 text-center">Разрешения</th>
        </tr>
        </thead>
        <tbody>
        @forelse($rolesWithPermissions as $role)
            <tr>
                <td>
                    {{$role->name}}
                </td>
                <td>
                    <form id="formPermission" action="{{ route('admin.permissions_roles.update',['role'=>$role->id]) }}"
                          method="post">
                        @csrf
                        @method('PUT')
                        <input type="text" hidden value="{{$role->id}}" name="role">
                        @foreach($permissions as $permission)

                            <div class="form-check form-check-inline">
                                <input id="permission_{{ $permission->id }}" class="form-check-input" type="checkbox"

                                       name="permissions[]"
                                       value="{{ $permission->id }}"
                                       @if($role->permissions->contains($permission)) checked @endif

                                >
                                <label class="form-check-label" for="inlineCheckbox1">{{$permission->name}}</label>
                            </div>

                        @endforeach
                        <button type="submit" class="btn btn-sm btn-primary">Принять</button>

                    </form>
                </td>

            </tr>

            @endforeach

        </tbody>

    </table>

@endsection
