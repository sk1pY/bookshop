<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.css"
          integrity="sha512-U9Y1sGB3sLIpZm3ePcrKbXVhXlnQNcuwGQJ2WjPjnp6XHqVTdgIlbaDzJXJIAuCTp3y22t+nhI4B88F/5ldjFA=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <title>Document</title>
</head>
<style>
    a {
        color: black;
        text-decoration: none;
    }

    a:hover {
        color: grey;
    }
</style>
<body>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container">
        <a class="navbar-brand" href="{{ route('books.index') }}">BookShop</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav   ms-auto     mb-2 mb-lg-0">
                <div class="d-flex justify-content-center align-items-center me-auto search-container">
                    <div class="input-group rounded" style="width: 600px; margin-left: 65px; position: relative;">
                        <input type="search" class="form-control rounded" placeholder="Search" aria-label="Search"
                               aria-describedby="search-addon" id="search" name="search">
                        <ul class="list-group search-result"
                            style="position: absolute; top: 100%; left: 0; width: 100%; z-index: 1000; display: none;"></ul>
                    </div>
                </div>
                @guest
                    <li class="nav-item ">
                        <a class="nav-link" href="{{ route('login') }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">Register</a>
                    </li>
                @endguest
                @auth
                    <li class="nav-item">
                        <div class="dropdown-center">
                            <button class=" btn  dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Мой профиль
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('home.info')}}">Мои данные</a></li>
                                <li><a class="dropdown-item" href="{{ route('home.bought')}}">Мои заказы</a></li>
                                <li><a class="dropdown-item" href="{{ route('home.bookmark') }}">Избранные товары</a></li>
                                <li><a class="dropdown-item" href="{{ route('home.commentaries') }}">Мои отзывы </a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('admin.index')}}">Admin</a>
                    </li>
                    <li class="nav-item">
                        <button onclick="document.getElementById('logout-form').submit();" class="btn ">
                            Logout
                        </button>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('basket.index') }}">Корзина: {{ $bookInBasket }}</a>
                        <span></span>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 ">
            @yield('content')
        </div>
{{--        <footer class="bg-body-tertiary">--}}
{{--            footer--}}
{{--        </footer>--}}
    </div>
</div>

{{--SEARCH JS--}}
<script type="text/javascript">
    $(document).ready(function () {
        $('#search').on('keyup', function () {
            var value = $(this).val();
            $.ajax({
                type: 'get',
                url: '{{ route('live.search') }}',
                data: {'search': value},
                success: function (data) {
                    $('.search-result').html(data).show();
                }
            });
        });
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(document).click(function(event) {
            let target = $(event.target);
            if (!target.closest('#search').length && !target.closest('.search-result').length) {
                $('.search-result').hide();
            }
        });

    });
</script>
</body>
</html>
