@extends('layouts.base')

@section('content')
    <div class="container-fluid min-vh-100 d-flex flex-column">
        <div class="row flex-grow-1">
            <div class="col-3  p-0" style="background-color: #273A50;">
                @include('admin.partials.sidebar')
            </div>
            <div class="col-9 p-4">
                @yield('admin-content')
            </div>
        </div>
    </div>
@endsection
