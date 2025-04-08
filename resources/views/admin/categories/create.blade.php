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
    @if ( session('successCategoryAdd') )
        <div class="alert alert-success d-flex px-4">
            <div>{{ session('successCategoryAdd') }}</div>
        </div>
    @endif
<form action="{{ route('admin.categories.store') }}" method="POST">
    @csrf
    <div class="d-flex mb-2">
        <input class="form-control w-25 me-2" type="text" name="name">
        <input class="btn btn-primary" type="submit" value="Добавить">
    </div>


</form>
@endsection
