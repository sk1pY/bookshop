@extends('home.index')
@section('сontentAdditional')

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
                    <p class=" fs-5  text mb-0">{{ $user->name. ' ' .$user->surname   }}</p>
                    <i data-bs-target="#exampleModal" type="button" data-bs-toggle="modal"
                       class="fa-solid fa-pencil ms-3    ms-auto"></i>
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
                                <form action="{{ route('home.infoUpdate', ['id' => $user->id]) }}" method="post">
                                    @csrf
                                    @method('PATCH')

                                    <label for="name">Ваше имя</label>
                                    <input class="form-control my-3" id="name" type="text" name="name" value="{{  $user->name }}">

                                    <label for="address">Адрес доставки</label>
                                    <input class="form-control my-3" id="address" type="text" name="address" value="{{  $user->address }}">

                                    <fieldset>
                                        <legend>Выберите ваш пол</legend>
                                        <div>
                                            <input type="radio" id="choose"   name="gender" value=""  {{ $user->gender === null ? 'checked' : '' }} >
                                            <label for="choose">Пол не выбран</label>
                                        </div>
                                        <div>
                                            <input type="radio" id="huey" name="gender" value="M" {{ $user->gender == 'M' ? 'checked' : '' }} />
                                            <label for="huey">Мужской</label>
                                        </div>

                                        <div>
                                            <input type="radio" id="dewey" name="gender" value="F" {{ $user->gender == 'F' ? 'checked' : '' }} />
                                            <label for="dewey">Женский</label>
                                        </div>
                                    </fieldset>

                                    <label for="date">День рождения</label>
                                    <input class="form-control my-3" id="date" type="date" name="birthday" value="{{ $user->birthday }}">

                                    <label for="phone">Телефон</label>
                                    <input class="form-control" id="phone" type="text" name="phone" value="{{  $user->phone }}">

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                                        <button type="submit" class="btn btn-primary">Сохранить изменения</button>
                                    </div>
                                </form>

                            </div>

                        </div>
                    </div>
                </div>
                {{--            <p>Пол: {{ $user->gender !== null ? $user->gender : 'не указано' }}</p>--}}
                {{--            <p>Дата рождения: {{ $user->birthday !== null ? $user->birthday->format('d-m-Y') : 'не указана' }}</p>--}}
                <div class="d-flex flex-column">
                    <p class="mb-1 text-body-tertiary">{{ $user->email !== null ? $user->email : 'не указана' }}</p>
                    <p class="mb-0 text-body-tertiary">+{{ $user->phone !== null ? $user->phone : 'не указан' }}</p>
                </div>


            </div>
            <div class="col border rounded-5 bg-white p-4 ms-3">
                <h4>Адрес доставки</h4>
                <p class="mb-0 text-body-tertiary">{{ $user->address !== null ? $user->address : 'не указан' }}</p>
            </div>


        </div>
    </div>

@endsection
