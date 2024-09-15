@extends('admin.index')
@section('categoryAdd')
<form action="{{ route('admin.addCategory') }}" method="post">
    @csrf
    <input type="text" name="category_name">
    <input type="submit">
</form>
@endsection
