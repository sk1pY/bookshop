@extends('layouts.app')
@section('content')

    <h4>Forgot password page</h4>
    <form action="{{ route('password.update') }}" method="post">
        @csrf
        <input type="hidden" value="{{request()->route('token')}}" name="token">
        <input type="text" name="email" value="{{old('email',$request->email)}}">
        <input type="text" name="password">
        <input type="text" name="password_confirmation">
        <input type="submit">
    </form>
@endsection

