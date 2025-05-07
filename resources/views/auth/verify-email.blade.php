@extends('layouts.app')
@section('content')
    @if (session('status') === 'verification-link-sent')
        <div class="mb-4 font-medium text-sm text-green-600">
            A new email verification link has been emailed to you!
        </div>
    @endif
    <hr>
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
