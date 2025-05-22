@extends('admin.layouts.index')
@section('content')
    <div class="p-3">
        <h4>Пользователи</h4>
        <hr>
        <table id="table" class="table table-sm table-bordered table-striped ">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">имя</th>
                <th scope="col">Роль</th>
                <th scope="col">#</th>
            </tr>
            </thead>
            <tbody id="tablecontents">
            @foreach( $users as $user )
                <tr>
                    <th scope="row">{{$user -> id}}</th>
                    <td>{{$user -> name}}</td>
                    <td>
                        <select name="role" class="role-update form-select form-select-sm"
                                data-url="{{route('admin.roles.users.update', $user->id)}}">
                            @foreach($roles as $role)
                                <option value="{{ $role->name }}"
                                    {{ $user->roles->contains('name', $role->name) ? 'selected' : '' }}>
                                    {{ $role->name ?? 'without role' }}
                                </option>
                            @endforeach
                        </select>
                    </td>

                    <td>
                        <form action="{{ route('admin.users.destroy',['user'=> $user->id]) }}" method="post">
                            @csrf
                            @method('delete')
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
        <div class="mt-4">
            {{ $users->links('pagination::bootstrap-5') }}
        </div>
    </div>
@endsection
