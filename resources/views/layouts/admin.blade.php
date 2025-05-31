@extends('layouts.base')
@section('content')
    <div class="container-fluid min-vh-100 d-flex">
        <div class="row flex-grow-1 w-100">
            @include('admin.partials.sidebar')
            <div class="col p-4">
                @yield('admin-content')
            </div>
        </div>
    </div>
@endsection
