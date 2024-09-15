@extends('admin.index')
@section('bookAdd')
<form action="{{ route('admin.addBook') }}" method="post">
    @csrf
    Title<input type="text" name="title">
    price<input type="text" name="price">

    <select class="form-select" name="category_id">
        @if(count($categories)  > 0)
            @foreach($categories as $category)
                <option>{{$category-> name}}</option>
            @endforeach
        @else
            <option>Без категории</option>
        @endif
    </select>
    <select class="form-select" name="author_id">
        @if(count($authors) > 0)
            @foreach($authors as $author)
                <option>{{$author-> name}}</option>
            @endforeach
        @else
            <option>Без Автора</option>
        @endif
    </select>
    <input type="submit">
</form>
@endsection
