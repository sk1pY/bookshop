@extends('layouts.base')
@section('content')
    <div class="row mt-4">
        <div class="col-2  w-auto ">
            @include('home.partials.sidebar')
        </div>

        <div class="col ">
            @yield('home-content')
        </div>
    </div>

@endsection
