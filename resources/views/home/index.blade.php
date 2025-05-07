@extends('layouts.app')
@section('content')
    @if (session('status'))
        <div class="mb-4 font-medium text-sm text-green-600">
            {{ session('status') }}
        </div>
    @endif
    <div class="row">
        <div class="col-2 h-100 p-3 w-auto">
            @include('home.partials.sidebar')
        </div>

        <div class="col p-3">
            @yield('content-home')
        </div>
    </div>

@endsection

