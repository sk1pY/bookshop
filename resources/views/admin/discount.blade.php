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

    <h1>Скидки на книги</h1>
    <p>Выберите определенного автора или книгу, или введи скидку для всех книг/авторов</p>
    <form action="{{ route('admin.discount.store') }}" method="post" id="discount">
        @csrf
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Скидка на книгу/книги %</label>
            <input type="text" name="discount" class="form-control" id="exampleInputEmail1"
                   placeholder="введите % скидки">
        </div>
        {{--    SKIDKA NA KNIGY VIBRAT--}}
        <select class="form-select" name="bookName" form="discount">
            <option value="" selected>Выбрать книгу/Все книги</option>
            @foreach($booksWithoutDiscount as $book)
                <option value="{{$book->title}}">{{$book->title}}</option>
            @endforeach
        </select>
        {{--    SKIDKA NA KNIGI AUTHORS VIBRAT--}}
        <select class="form-select mt-3" name="authorPersonalDiscount" form="discount" id="authorPersonalDiscount">
            <option value="" selected>Выберите автора/Все авторы</option>
            @foreach($authors as $author)
                <option value="{{$author->surname}}">{{$author->surname. ' ' .$author->name }}</option>
            @endforeach
        </select>
        <button type="submit" class="btn btn-primary my-3">Принять</button>
    </form>

    <table class="table">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Книга</th>
            <th scope="col">Автор</th>
            <th scope="col">скидка</th>
            <th scope="col">Удалить скидку</th>
        </tr>
        </thead>
        <tbody>
        @foreach( $booksWithDiscount as $book )
            <tr>
                <th scope="row">{{$book -> id}}</th>
                <td>{{$book -> title}}</td>
                @if($book -> author)
                <td>{{$book -> author -> surname . ' ' . $book -> author->name}}</td>
                @else
                    <td>Без автора</td>

                @endif

                <td>{{$book -> discount.'%'}}</td>
                <td>
                    <form action="{{ route('admin.discount.destroy',['id'=>$book->id])}}" method="post">
                        @csrf
                        @method('delete')
                        <input class="btn btn-danger" type="submit" value="Удалить">
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    @if(count($booksWithDiscount) > 0)
        <form action="{{ route('admin.discount.destroyAll')}}" method="post">
            @csrf
            @method('delete')
            <input class="btn btn-danger" type="submit" value="Удалить все скидки">
        </form>
    @endif
@endsection
