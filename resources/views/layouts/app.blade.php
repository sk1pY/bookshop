<!doctype html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <title>#BookShop</title>
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

    .dropdown-center:hover .dropdown-menu {
        display: block;
        margin-top: 0;

    }


</style>
<body class="container " style="max-width: 1200px">
@include('partials.nav')
<div>
    @include('partials.alert.validation')
    @include('partials.alert.error')
    @include('partials.alert.success')
    @yield('content')

    <footer >
        @include('partials.footer')
    </footer>
</div>
</body>
</html>
