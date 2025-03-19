@extends('admin.layouts.index')
@section('content')

        <table id="table" class="table table-sm table-bordered table-striped ">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">имя</th>
            <th scope="col">Роль</th>
            <th scope="col">#</th>
        </tr>
        </thead>
        <tbody>
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
                        <button class="btn btn-sm btn-danger" type="submit">удалить</button>
                    </form>

                </td>

            </tr>
        </tbody>

        @endforeach

    </table>
        <div class="mt-4">
            {{ $users->links('pagination::bootstrap-5') }}
        </div>
@endsection
