<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <title>Main</title>
</head>
<style>
    body {
        font-family: 'Inter', sans-serif;
        font-weight: 400;
        font-size: 14px;
        margin: 0;
        padding: 0;

    }

    a {
        color: black;
        text-decoration: none;
    }

     .modal-open .modal-backdrop {
         backdrop-filter: blur(5px);
         background-color: rgba(0, 0, 0, 0.5);
         opacity: 1 !important;
     }
</style>
<body>
@include('partials.alert.toast')
@include('partials.alert.auth')
@include('partials.alert.validation')
@include('partials.alert.error')
@include('partials.alert.success')
@if (Request::is('admin*'))
        @yield('content')
@else
    <div class="container" style="max-width: 1100px">
        @if (!Request::is('admin*'))
            @include('partials.nav')
        @endif
        @yield('content')
    </div>
@endif
@if (!Request::is('admin*'))
    <footer>
        @include('partials.footer')
    </footer>
@endif

</body>
</html>
