@extends('admin.index')
@section('section')

    <table class="table">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">имя</th>
            <th scope="col">Изменить</th>
            <th scope="col">Удалить</th>
        </tr>
        </thead>
        <tbody>
        @foreach( $users as $user )
            <tr>
                <th scope="row">{{$user -> id}}</th>
                <td>{{$user -> name}}</td>
                <td>
                    <!-- Button mdal -->
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#modal{{ $user->id }}">                        Изменить
                    </button>

                    <!-- Modal -->
                    <div class="modal fade" id="modal{{$user->id}}" data-bs-backdrop="static" data-bs-keyboard="false"
                         tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">информация о пользователе</h1>
                                </div>
                                <div class="modal-body">
                                    <p>{{$user -> name}}</p>
                                    <p>{{$user -> surname}}</p>
                                </div>
                                <div class="modal-footer">
                                    <button form="formChangeTitle" type="submit" class="btn btn-success" >Принять
                                    </button><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close
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
