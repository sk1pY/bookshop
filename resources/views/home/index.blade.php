@extends('layouts.app')
@section('content')

    <div class="row">
        <div class="col-2 h-100 p-3 w-auto">
            @include('home.partials.sidebar')
        </div>

        <div class="col p-3">
            @yield('content-home')
        </div>
    </div>

@endsection

