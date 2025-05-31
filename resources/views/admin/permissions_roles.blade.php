@extends('layouts.admin')
@section('admin-content')
    <div class="container-fluid p-3">

        <div class="row mb-4">
            <div class="col-md-5">
                <h5 class="mb-3">Добавить роль</h5>
                <hr>
                <form action="{{ route('admin.roles.store') }}" method="POST" class="d-flex gap-2">
                    @csrf
                    <input type="text" name="name" placeholder="Название роли" class="form-control form-control-sm" required>
                    <button type="submit" class="btn btn-sm btn-primary">Добавить</button>
                </form>
            </div>
            <div class="col-md-7">
                <h5 class="mb-3">Добавить разрешение</h5>
                <hr>
                <form action="{{ route('admin.permissions.store') }}" method="POST" class="d-flex gap-2">
                    @csrf
                    <input type="text" name="name" placeholder="Название разрешения" class="form-control form-control-sm" required>
                    <button type="submit" class="btn btn-sm btn-primary">Добавить</button>
                </form>
            </div>

        </div>
        <hr>


        <div class="row mb-4">
            <div class="col-md-5">
                <h5 class="mb-3">Список ролей</h5>
                <hr>
                <table class="table table-sm table-bordered table-striped align-middle mb-0">

                    <thead class="table-light text-center">
                    <tr>
                        <th class="col-1">#</th>
                        <th>Роль</th>
                        <th class="col-1">Удалить</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($roles as $role)
                        <tr>
                            <td class="text-center">{{ $role->id }}</td>
                            <td>{{ $role->name }}</td>
                            <td class="text-center">
                                <form action="{{ route('admin.roles.destroy', $role) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm"
                                            onclick="return confirm('Точно удалить?')">
                                        <i type="submit" class="bi bi-x"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="col-md-7">
                <h5 class="mb-3">Список разрешений</h5>
                <hr>
                <table class="table table-sm table-bordered table-striped align-middle text-center mb-0">
                    <thead class="table-light text-center">
                    <tr>
                        <th class="col-1">#</th>
                        <th>Разрешение</th>
                        <th class="col-1">Удалить</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($permissions as $permission)
                        <tr>
                            <td class="text-center">{{ $permission->id }}</td>
                            <td>{{ $permission->name }}</td>
                            <td class="text-center">
                                <form action="{{ route('admin.permissions.destroy', $permission) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm"
                                            onclick="return confirm('Точно удалить?')">
                                        <i type="submit" class="bi bi-x"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <h5 class="mb-3">Права ролей</h5>
                <hr>
                <table class="table table-sm table-bordered table-striped align-middle text-center small mb-0">
                    <thead class="table-light text-center">
                    <tr>
                        <th class="col-2">Роль</th>
                        <th>Разрешения</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($rolesWithPermissions as $role)
                        <tr>
                            <td class="fw-semibold">{{ $role->name }}</td>
                            <td>
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach($permissions as $permission)
                                        <div class="form-check form-check-inline permission-update"
                                             data-url="{{ route('admin.roles.permissions.update', $role) }}"
                                             data-permission-id="{{ $permission->id }}">
                                            <input class="form-check-input"
                                                   type="checkbox"
                                                @checked($role->permissions->contains($permission))>
                                            <label class="form-check-label small">
                                                {{ $permission->name }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection
