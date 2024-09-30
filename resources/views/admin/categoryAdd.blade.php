@extends('admin.index')
@section('section')
    @if ( session('successCategoryAdd') )
        <div class="alert alert-success d-flex px-4">
            <div>{{ session('successCategoryAdd') }}</div>
        </div>
    @endif
<form action="{{ route('admin.addCategory') }}" method="POST">
    @csrf
    <div class="d-flex mb-2">
        <input class="form-control w-25 me-2" type="text" name="category_name">
        <input class="btn btn-primary" type="submit" value="Добавить">
    </div>


</form>
@endsection
