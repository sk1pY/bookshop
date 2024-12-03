@extends('admin.layouts.index')
@section('content')
<table class="table table-sm table-bordered table-striped">
    <thead>
    <tr>
        <th scope="col" class="col-1">#</th>
        <th scope="col" class="col-7">Автор</th>
        <th scope="col" class="col-1">Удалить</th>
    </tr>
    </thead>
    <tbody>
    @foreach( $authors as $author )
        <tr>
            <th scope="row">{{$author -> id}}</th>
            <td>
                <a class="text-decoration-none text-dark" href="{{ route('author.index',['id'=>$author->id]) }}">{{$author -> surname.' '.$author -> name}}</td></a>
            <td>
                <form action="{{ route('admin.authors.destroy',['author'=>$author->id])}}" method="post"
                      id>
                    @csrf
                    @method('delete')
                    <button class="btn btn-sm fs-3">
                        <i type="submit" class="bi bi-x"></i>
                    </button>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
@endsection
