@extends('home.index')
@section('content-home')
    @if ($errors->updateProfileInformation->any())
        <ul>
            @foreach ($errors->updateProfileInformation->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif
    @if ($errors->updatePassword->any())
        <ul>
            @foreach ($errors->updatePassword->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif
    @if (session('status'))
        <div class="mb-4 font-medium text-sm text-green-600">
            {{ session('status') }}
        </div>
    @endif

    <div class="row ">
        <div class="col-3 border rounded-5 bg-white p-4 ms-2">
            <div class="d-flex align-items-center">
                <p class=" fs-5  text mb-0">{{ $user->name}}</p>
                <i data-bs-target="#exampleModal" type="button" data-bs-toggle="modal"
                   class="bi bi-gear fs-5 ms-auto"></i>
            </div>


            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('home.info.update',$user) }}" method="post">
                                @csrf
                                @method('PATCH')
                                <label for="name">Ваше имя</label>
                                <input class="form-control my-3" id="name" type="text" name="name"
                                       value="{{  $user->name }}">

                                <label for="address">Адрес самовывоза</label>

                                <select name="address" class="form-select mb-3">
                                    @foreach($addresses as $address)
                                        <option value="{{$address->name}}">{{$address->name}}</option>
                                    @endforeach
                                </select>

                                <fieldset>
                                    <legend>Выберите ваш пол</legend>
                                    <div>
                                        <input type="radio" id="choose" name="gender"
                                               value="" {{ $user->gender === null ? 'checked' : '' }} >
                                        <label for="choose">Пол не выбран</label>
                                    </div>
                                    <div>
                                        <input type="radio" id="huey" name="gender"
                                               value="M" {{ $user->gender === 'M' ? 'checked' : '' }} />
                                        <label for="huey">Мужской</label>
                                    </div>

                                    <div>
                                        <input type="radio" id="dewey" name="gender"
                                               value="F" {{ $user->gender === 'F' ? 'checked' : '' }} />
                                        <label for="dewey">Женский</label>
                                    </div>
                                </fieldset>

                                <label for="date">День рождения</label>
                                <input class="form-control my-3" id="date" type="date" name="birthday"
                                       value="{{ $user->birthday?date('Y-m-d',strtotime($user->birthday)):'' }}">

                                <label for="phone">Телефон</label>
                                <input class="form-control" id="phone" type="text" name="phone"
                                       value="{{  $user->phone??'+375' }}" maxlength="13">

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                        Закрыть
                                    </button>
                                    <button type="submit" class="btn btn-primary">Сохранить изменения</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex flex-column">
                <p class="mb-1 text-body-tertiary">{{ $user->email ?:'не указана' }}</p>
                <p class="mb-0 text-body-tertiary">{{ $user->phone ?: 'не указан' }}</p>
            </div>

        </div>
        <div class="col border rounded-5 bg-white p-4 ms-3">
            <h4>Адрес доставки</h4>
            <p class="mb-0 text-body-tertiary">{{ $user->address?: 'не указан' }}</p>
        </div>
    </div>
    <div class="mt-4 border rounded-5 p-3 w-25">
        <button type="button" class="btn " data-bs-toggle="modal" data-bs-target="#passwordChangeModal">
            Сменить пароль
        </button>
        <!-- Modal PASSWORD CHANGE-->
        <div class="modal fade" id="passwordChangeModal" tabindex="-1" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Сменить пароль</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('user-password.update') }}" method="post">
                        @csrf
                        @method('put')
                        <div class="modal-body ">
                            <input class="form-control my-2" type="password" name="current_password" required
                                   placeholder="Текущий пароль">
                            <input class="form-control my-2" type="password" name="password" required
                                   placeholder="Новый пароль">
                            <input class="form-control" type="password" name="password_confirmation" required
                                   placeholder="Подтверждение пароля">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                            <button type="submit" class="btn btn-primary">Сменить пароль</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#mailChangeModal">
            Сменить почту
        </button>
        <!-- Modal MAIL CHANGE-->
        <div class="modal fade" id="mailChangeModal" tabindex="-1" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Сменить почту</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('user-profile-information.update') }}" method="post">
                        @csrf
                        @method('put')
                        <div class="modal-body ">
                            <input class="form-control" type="text" name="email" placeholder="email">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                            <button type="submit" class="btn btn-primary">Сменить почту</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="d-flex align-items-center rounded-pill p-2">
            <form action="{{route('logout')}}" id="logout-form" method="post">
                @csrf
                <button type="submit" class="btn  p-0" style="font-size: 1rem; text-decoration: none;">
                    Выйти из аккаунта
                </button>
            </form>
        </div>

        <div class=" rounded-pill ">
            <button style="font-size: 1rem" type="button" class="btn " data-bs-toggle="modal"
                    data-bs-target="#deleteuser">
                Удалить аккаунт
            </button>

            <!-- Modal DELETE-->
            <div class="modal fade" id="deleteuser" tabindex="-1" aria-labelledby="exampleModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <h5>Вы точно хотите удалить аккаунт?</h5>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <form action="{{route('home.users.destroy',$user)}}" method="post">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection
