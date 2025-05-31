@extends('layouts.admin')
@section('admin-content')
    <div class="p-3">
        <h4>Добавить автора</h4>
        <hr>
        <form action="{{ route('admin.authors.store') }}" method="post">
            @csrf
            <div class="input-group mb-3">

                <input placeholder="Имя" class="form-control" type="text" name="name">
                <input placeholder="Фамилия" class="form-control " type="text" name="surname">
            </div>
            <input type="submit">
        </form>
    </div>
@endsection
