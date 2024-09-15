@extends('home.index')
@section('bookmark')

                <h1>Мои закладки</h1>
                @foreach($bookmarks as $bookmark)
                    {{$bookmark -> book -> title}}
                    <form action="{{ route('bookmark.delete',['id' => $bookmark->id])}}" method="post">
                        @csrf
                        @method('delete')
                        <input type="submit" value="удалить">
                    </form>
                @endforeach
@endsection
