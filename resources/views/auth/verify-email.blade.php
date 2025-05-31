@extends('layouts.app')
@section('content')

    <h4>Письмо для подтверждения вашей почты отправлено</h4>
    <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button type="submit" class="btn btn-success">Повторно отправьте электронное письмо с подтверждением</button>
    </form>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="btn btn-secondary my-2">Выйти</button>
    </form>
    <hr>
@endsection
