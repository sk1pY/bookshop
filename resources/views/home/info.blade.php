@extends('home.index')
@section('info')
    <h1>Личный данные</h1>
    <div class="d-flex align-items-center gap-3">
        <p>Имя: {{ $user->name }}</p>
        <p>Пол: {{ $user->gender !== null ? $user->gender : 'не указано' }}</p>
        <p>Дата рождения: {{ $user->birthday !== null ? $user->birthday->format('d-m-Y') : 'не указана' }}</p>
        <form action="{{ route('home.infoUpdate',['id' => $user->id ])}}" method="post">
            @csrf
            @method('PATCH')
            <label for="name">Ваше имя</label>
            <input id="name" type="text" name="name">
            <fieldset>
                <legend>Выберите ваш пол</legend>
                <div>
                    <input  type="radio" id="huey" name="gender"  value="M" checked />
                    <label for="huey">Мужской</label>
                </div>

                <div>
                    <input type="radio" id="dewey" name="gender"  value="F" />
                    <label for="dewey">Женский</label>
                </div>

            </fieldset>
            <label for="date">День рождения</label>
            <input id="date" type="date" name="birthday">
            <label for="phone">Телефон</label>
            <input id="phone" type="text" name="phone">
            <input type="submit">
        </form>
    </div>


    <p>Почта: {{ $user -> email !== null? $user->email : 'не указана' }}</p>
    <p>Телефон: {{ $user -> phone !== null? $user->phone : 'не указан' }}</p>

@endsection
