@extends('home.index')
@section('сontentAdditional')
        <h1>Мои отзывы</h1>


        <table class="table">
            <thead>

            </thead>
            <tbody>
            @foreach( $commentaries as $commentary )
                <tr>
                    <td style="width: 170px">
                        <a href="{{route('books.book',['id'=>$commentary -> book -> id])}}">{{$commentary -> book -> title}}</a>
                    </td>
                    <td style="width: 200px">
                        @php
                            $fullStars = floor($commentary->rating);
                            $halfStars = ($commentary->rating - $fullStars) > 0;
                        @endphp


                        @for ($i = 0; $i < $fullStars; $i++)
                            <i class="fas fa-star text-warning"></i>
                        @endfor

                        @if($halfStars)
                            {
                            <i class="fas fa-star-half-alt text-warning"></i>
                            }
                        @endif

                        @for( $i = 5 - $fullStars - ($halfStars?1:0); $i >  0; $i-- )

                            <i class="fa-regular fa-star text-warning"></i>
                        @endfor
                    </td>

                    <td>{{$commentary -> text}}</td>
                    <td>
                        <form action="{{ route('comment.destroy',['id'=>$commentary->id])}}" method="post"
                              id>
                            @csrf
                            @method('delete')
                            <button style="font-size: 1.5rem" class="btn"><i class="fa-regular fa-trash-can"></i>
                            </button>
                            {{--                        <input class="btn btn-danger" type="submit" value="Удалить">--}}
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>


@endsection
