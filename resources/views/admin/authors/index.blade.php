@extends('admin.layouts.index')
@section('content')
    <div class="p-3">
        <h4>Авторы</h4>
        <hr>
        <table id="table" class="table table-sm table-bordered table-hover m-0">
            <thead>
            <tr>
                <th scope="col" class="text-center">#</th>
                <th scope="col" class="col-2 text-center">Количество книг</th>
                <th scope="col" class="text-center">Автор</th>
                <th scope="col" class="text-center">#</th>
            </tr>
            </thead>
            <tbody>
            @foreach( $authors as $author )
                <tr>
                    <td class="text-center p-0">{{$author->id}}</td>
                    <td class="text-center p-0">{{$author->books_count}}</td>
                    <td class="p-0 ps-2">
                        <a href="{{ route('authors.index',$author) }}"
                           class="text-decoration-none text-dark small">
                            {{$author->surname.' '.$author->name}}
                        </a>
                    </td>
                    <td class="text-center p-0">
                        <form action="{{ route('admin.authors.destroy',$author)}}" method="post">
                            @csrf
                            @method('delete')
                            <button class="btn btn-sm"
                                    onclick="return confirm('Точно удалить?')">
                                <i type="submit" class="bi bi-x"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="mt-4">
            {{ $authors->links('pagination::bootstrap-5') }}
        </div>
    </div>
@endsection

