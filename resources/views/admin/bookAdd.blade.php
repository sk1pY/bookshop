@extends('admin.index')
@section('section')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if ( session('successBookAdd') )
        <div class="alert alert-success d-flex px-4">
            <div>{{ session('successBookAdd') }}</div>
        </div>
    @endif
    <div class="row">
        <div class="col-4">
            <select class="form-select" name="category" form="addBookForm">
                @if(count($categories)  > 0)
                    <option value="">Категория не выбрана</option>
                @foreach($categories as $category)
                        <option value="{{$category-> name }}">{{$category-> name}}</option>
                    @endforeach
                @else
                    <option>Без категории</option>
                @endif
            </select>
            <select class="form-select" name="author" form="addBookForm">
                @if(count($authors) > 0)
                    <option value="">Автор не выбран</option>

                @foreach($authors as $author)
                        <option value="{{$author->surname}}">{{$author->surname.' '.$author-> name}}</option>
                    @endforeach
                @else
                    <option>Без Автора</option>
                @endif
            </select>

        </div>
        <div class="col">
            <form action="{{ route('admin.addBook') }}" method="post" id="addBookForm" enctype="multipart/form-data">
                @csrf

                <label for="title" class=" form-label">Название книги</label>
                <input class="form-control" id="title" type="text" name="title" value="{{old('title')}}">
                <label for="description" class="form-label">Описание</label>
                <textarea class="form-control" id="description" type="text" name="description" >{{old('description')}}</textarea>
                <label for="price" class="form-label">Цена</label>
                <input class="form-control" id="price" type="text" name="price" value="{{old('price')}}">
                <input class="my-3 form-control" type="file" name="file" value="{{old('file')}}">

                <input type="submit">
            </form>
        </div>
    </div>

@endsection
