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
    <div class="row">
        <div class="col">
            <form action="{{ route('admin.discounts.book') }}" method="post" >
                @csrf
                <div class="mb-3">
                    <input type="text" name="discount" class="form-control" id="exampleInputEmail1"
                           placeholder="введите % скидки">
                </div>
                <select class="form-select" name="book_id" >
                    <option value="" selected>Выбрать книгу/Все книги</option>
                    @foreach($books as $book)
                        <option value="{{$book->id}}">{{$book->title}}</option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-primary my-3">Принять</button>

            </form>
        </div>
        <div class="col">
            <form  action="{{ route('admin.discounts.author') }}" method="post">
                @csrf
                <div class="mb-3">
                    <input type="text" name="discount" class="form-control" id="exampleInputEmail1"
                           placeholder="введите % скидки">
                </div>
                <select class="form-select mt-3" name="author_id" >
                    <option value="" selected>Выберите автора/Все авторы</option>
                    @foreach($authors as $author)
                        <option value="{{$author->id}}">{{$author->surname. ' ' .$author->name }}</option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-primary my-3">Принять</button>
            </form>
        </div>
    </div>

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
                    <form action="{{ route('admin.discounts.destroy',$book)}}" method="post">
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
        <form action="{{ route('admin.discounts.destroyAll')}}" method="post">
            @csrf
            @method('delete')
            <input class="btn btn-danger" type="submit" value="Удалить все скидки">
        </form>
    @endif
    {{$booksWithDiscount->links('pagination::bootstrap-5')}}
@endsection
