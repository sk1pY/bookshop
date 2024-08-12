@extends('layouts.app')
@section('content')

    <div class="container">
        <h1>BASKET</h1>
        <table class="table " style="width: 500px">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">название книги</th>
                <th scope="col">количество</th>
            </tr>
            </thead>
            <tbody>
            @foreach( $baskets as $basket)
                <tr>
                    <td>{{ $basket-> book_id }}</td>
                    <td>{{ $basket-> title }}</td>
                    <td>
                        <div class="row">

                        </div>
                        <div
                            style="display: inline-flex; align-items: center; border: 1px solid #ccc; padding: 5px; border-radius: 5px;">
                            <form action="{{ route('basket.delete',['id'=>$basket->id]) }}" method="post"
                                  style="margin-right: 10px;">
                                @csrf
                                @method('delete')
                                <button class="btn btn-light"><i class="bi bi-dash-lg"></i>
                                </button>
                            </form>


                            <form action="">
                                <input type="text" value="{{ $basket->baskets_count }}"
                                       style="width:30px; text-align: center; Border: none;">
                            </form>
                            <form action="{{ route('basket.add') }}" method="post" style="margin-left: 10px;">
                                @csrf
                                <input type="text" hidden name="book_id" value="{{$basket->id}}">
                                <button class="btn btn-light"><i class="bi bi-plus-lg"></i>
                                </button>
                            </form>
                        </div>
                       Цена:  {{ $basket->price  }}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <h2>Sum: {{ $sum }} рублей </h2>
        <form action="">
            <input class="btn btn-success" type="submit">
        </form>

    </div>

@endsection
