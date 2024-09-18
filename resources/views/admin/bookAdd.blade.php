@extends('admin.index')
@section('bookAdd')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
<form action="{{ route('admin.addBook') }}" method="post" id="addBookForm">
    @csrf
    Title<input type="text" name="title">
    textarea<textarea type="text" name="description"></textarea>
    price <input type="text" name="price">

    <select class="form-select" name="category" form="addBookForm">
        @if(count($categories)  > 0)
            @foreach($categories as $category)
                <option value="">Выберите категорию</option>
                <option value="{{$category-> name }}">{{$category-> name}}</option>
            @endforeach
        @else
            <option>Без категории</option>
        @endif
    </select>
    <select class="form-select" name="author" form="addBookForm">
        @if(count($authors) > 0)
            @foreach($authors as $author)
                <option value="">Выберите автора</option>
                <option value="{{$author->surname}}">{{$author->surname.' '.$author-> name}}</option>
            @endforeach
        @else
            <option>Без Автора</option>
        @endif
    </select>
    <input type="submit">
</form>
@endsection
