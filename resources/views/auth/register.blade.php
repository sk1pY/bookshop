@extends('layouts.app')
@section('content')

    <h3 class="text-center">Регистрация</h3>
    <hr>
    <div class="d-flex justify-content-center">
        <div class="bg-white rounded-3 p-3 w-50  ">
            <form action="{{ route('register') }}" method="POST">
                @csrf
                <div>
                    <label for="name">Имя:</label>
                    <input class="form-control" type="text" id="name" name="name" value="{{ old('name') }}" required>
                </div>

                <div>
                    <label for="email">Почта:</label>
                    <input class="form-control" type="email" id="email" name="email" value="{{ old('email') }}"
                           required>
                </div>

                <div>
                    <label for="password">Пароль:</label>
                    <input class="form-control" type="password" id="password" name="password" required>
                </div>

                <div>
                    <label for="password_confirmation">Подтвердите пароль:</label>
                    <input class="form-control" type="password" id="password_confirmation" name="password_confirmation"
                           required>
                </div>

                <button class="btn btn-secondary my-2" type="submit">Принять</button>
            </form>
        </div>
    </div>


@endsection
