@extends('layouts.admin')
@section('admin-content')
    <div class="p-3">
        <h4>Книги</h4>
        <hr>
        <table id="table" class="table table-sm table-bordered table-hover m-0">
        <thead>
        <tr class="text-center">
            <th class="col-1">Книга</th>
            <th class="col-1">Цена</th>
            <th class="col-2">Автор</th>
            <th class="col-1">В наличии</th>
            <th class="col-1">Действия</th>
        </tr>
        </thead>
        <tbody>
        @foreach($books as $book)
            <tr class="align-middle">
                <td>
                    <img src="{{ Storage::url('booksImages/' . $book->image) }}" style="width:25px;" alt="">
                    <a href="{{ route('books.book', $book) }}" class="text-black text-decoration-none">{{ $book->title }}</a>
                </td>
                <td class="text-center">{{ $book->price }} р.</td>
                <td class="text-center">
                    <a href="{{ route('authors.index',$book->author)}}"
                       class="text-decoration-none text-dark">
                        {{ $book->author ? $book->author->surname.' '.$book->author->name : 'Без автора' }}
                    </a>
                   </td>
                <td class="text-center">{{ $book->stock }}</td>
                <td>
                    <button class="btn btn-sm" data-bs-toggle="modal" data-bs-target="#update{{ $book->id }}">
                        <i class="bi bi-pencil-square"></i>
                    </button>
                    <form action="{{ route('admin.books.destroy', $book) }}" method="post" style="display:inline;">
                        @csrf @method('delete')
                        <button class="btn btn-sm"
                                onclick="return confirm('Точно удалить?')">
                            <i type="submit" class="bi bi-x"></i>
                        </button>
                    </form>
                </td>
            </tr>

            {{-- uodate Book --}}
            <div class="modal fade" id="update{{ $book->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog"><div class="modal-content">
                        <form action="{{ route('admin.books.update', $book) }}" method="post" enctype="multipart/form-data">
                            @csrf @method('put')
                            <div class="modal-header">
                                <h5 class="modal-title">Редактировать</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <label for="title" class="form-label">Title</label>
                                <input name="title" id="title" class="form-control mb-2" value="{{ old('title', $book->title) }}" placeholder="Название">

                                <label for="price" class="form-label">Price</label>
                                <input name="price" id="price" class="form-control mb-2" value="{{ $book->price }}" placeholder="Цена">

                                <label for="author" class="form-label">Author</label>
                                <select name="author_id" id="author" class="form-control mb-2">
                                    <option value="" {{ !$book->author_id ? 'selected' : '' }}>Без автора</option>
                                    @foreach($authors as $author)
                                        <option value="{{ $author->id }}" {{ $book->author_id == $author->id ? 'selected' : '' }}>
                                            {{ $author->surname . ' ' . $author->name }}
                                        </option>
                                    @endforeach
                                </select>

                                <label for="stock" class="form-label">Stock</label>
                                <input name="stock" id="stock" class="form-control mb-2" value="{{ $book->stock }}" placeholder="В наличии">

                                <label for="stock" class="form-label">Image</label>
                                <input type="file" name="image" id="iamge" class="form-control mb-2">
                                <img src="{{ Storage::url('booksImages/'.$book->image) }}" style="width:40px;height:40px;" alt="">
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success btn-sm">Сохранить</button>
                                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Отмена</button>
                            </div>
                        </form>
                    </div></div>
            </div>
        @endforeach
        </tbody>
    </table>
    <div class="mt-3">{{ $books->links('pagination::bootstrap-5') }}</div>
    </div>
@endsection
