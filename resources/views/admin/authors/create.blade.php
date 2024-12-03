@extends('admin.layouts.index')
@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('admin.authors.store') }}" method="post">
        @csrf
        <div class="input-group mb-3">

        <input  placeholder="Имя" class="form-control" type="text" name="name">
            <input placeholder="Фамилия" class="form-control " type="text" name="surname">
        </div>
        <input type="submit">
    </form>

@endsection
