@extends('home.index')
@section('content-home')

    <div class="col ms-4 mb-4 ">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="row ">
            <div class="col-3 border rounded-5 bg-white p-4">

                <div class="d-flex align-items-center">
                    <p class=" fs-5  text mb-0">{{ $user->name  }}</p>
                    <i data-bs-target="#exampleModal" type="button" data-bs-toggle="modal"
                       class="bi bi-pencil-square ms-3    ms-auto"></i>
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
                                                   value="M" {{ $user->gender == 'M' ? 'checked' : '' }} />
                                            <label for="huey">Мужской</label>
                                        </div>

                                        <div>
                                            <input type="radio" id="dewey" name="gender"
                                                   value="F" {{ $user->gender == 'F' ? 'checked' : '' }} />
                                            <label for="dewey">Женский</label>
                                        </div>
                                    </fieldset>

                                    <label for="date">День рождения</label>
                                    <input class="form-control my-3" id="date" type="date" name="birthday"
                                           value="{{ $user->birthday?date('Y-m-d',strtotime($user->birthday)):'' }}">

                                    <label for="phone">Телефон</label>
                                    <input class="form-control" id="phone" type="text" name="phone"
                                           value="{{  $user->phone??'+375' }}"  maxlength="13">

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
                {{--                            <p>Пол: {{ $user->gender !== null ? $user->gender : 'не указано' }}</p>--}}
                {{--                            <p>Дата рождения: {{ $user->birthday !== null ? $user->birthday->format('d-m-Y') : 'не указана' }}</p>--}}
                <div class="d-flex flex-column">
                    <p class="mb-1 text-body-tertiary">{{ $user->email !== null ? $user->email : 'не указана' }}</p>
                    <p class="mb-0 text-body-tertiary">{{ $user->phone !== null ? $user->phone : 'не указан' }}</p>
                </div>


            </div>
            <div class="col border rounded-5 bg-white p-4 ms-3">
                <h4>Адрес доставки</h4>
                <p class="mb-0 text-body-tertiary">{{ $user->address !== null ? $user->address : 'не указан' }}</p>
            </div>

        </div>
        <div class="mt-4 border rounded-5 p-3 w-25">

{{--            <div class="d-flex align-items-center   rounded-pill p-2">--}}
{{--                <a style="font-size: 1rem" href="">Сменить пароль</a>--}}
{{--            </div>--}}
            <div class="d-flex align-items-center rounded-pill p-2">
                <form id="logout-form" >
                    @csrf
                    <button type="submit" class="btn  p-0" style="font-size: 1rem; text-decoration: none;">
                        Выйти из аккаунта
                    </button>
                </form>
            </div>

            <div class="d-flex align-items-center   rounded-pill p-2">
                <!-- Button trigger modal -->
                <button style="font-size: 1rem" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#deleteuser">
                    Удалить аккаунт
                </button>

                <!-- Modal -->
                <div class="modal fade" id="deleteuser" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
    </div>

@endsection
