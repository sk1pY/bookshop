@extends('layouts.app')
@section('content')
<h1>BASKET</h1>

@foreach( $baskets as $basket)
   <p> {{ $basket-> book_id }}</p>
   <p> {{ $basket-> book -> title }}</p>
       <form action="{{ route('basket.delete',['id'=>$basket->book->id]) }}" method="post">
           @csrf
           @method('delete')
       <button class="btn btn-danger">delete</button>
       </form>

@endforeach
@endsection
