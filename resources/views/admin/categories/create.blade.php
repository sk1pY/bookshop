@extends('admin.layouts.index')
@section('content')
    <div class="p-3">
        <h4>Добавить категорию</h4>
        <hr>
        <form action="{{ route('admin.categories.store') }}" method="POST">
            @csrf
            <div class="d-flex mb-2">
                <input class="form-control w-25 me-2" type="text" name="name">
                <input class="btn btn-primary" type="submit" value="Добавить">
            </div>
        </form>
    </div>
@endsection
