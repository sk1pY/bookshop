@extends('layouts.app')
@section('content')
    <form action="{{ route('password.email') }}" method="post">
        @csrf
        <input type="text" name="email">
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection
