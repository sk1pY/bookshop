@extends('admin.index')
@section('categoryAdd')
<form action="{{ route('admin.addCategory') }}" method="post">
    @csrf
    <div class="d-flex mb-2">
        <input class="form-control w-25 me-2" type="text" name="category_name">
        <input class="btn btn-primary" type="submit">
    </div>


</form>
@endsection
