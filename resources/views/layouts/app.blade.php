<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <title>Document</title>
</head>
<style>
    body {
        margin-top: 20px;
        background: #ebeef0;
    }

    .img-sm {
        width: 46px;
        height: 46px;
    }

    .panel {
        box-shadow: 0 2px 0 rgba(0, 0, 0, 0.075);
        border-radius: 0;
        border: 0;
        margin-bottom: 15px;
    }

    .panel .panel-footer, .panel > :last-child {
        border-bottom-left-radius: 0;
        border-bottom-right-radius: 0;
    }

    .panel .panel-heading, .panel > :first-child {
        border-top-left-radius: 0;
        border-top-right-radius: 0;
    }

    .panel-body {
        padding: 25px 20px;
    }


    .media-block .media-left {
        display: block;
        float: left
    }

    .media-block .media-right {
        float: right
    }

    .media-block .media-body {
        display: block;
        overflow: hidden;
        width: auto
    }

    .middle .media-left,
    .middle .media-right,
    .middle .media-body {
        vertical-align: middle
    }

    .thumbnail {
        border-radius: 0;
        border-color: #e9e9e9
    }

    .tag.tag-sm, .btn-group-sm > .tag {
        padding: 5px 10px;
    }

    .tag:not(.label) {
        background-color: #fff;
        padding: 6px 12px;
        border-radius: 2px;
        border: 1px solid #cdd6e1;
        font-size: 12px;
        line-height: 1.42857;
        vertical-align: middle;
        -webkit-transition: all .15s;
        transition: all .15s;
    }

    .text-muted, a.text-muted:hover, a.text-muted:focus {
        color: #acacac;
    }

    .text-sm {
        font-size: 0.9em;
    }

    .text-5x, .text-4x, .text-5x, .text-2x, .text-lg, .text-sm, .text-xs {
        line-height: 1.25;
    }

    .btn-trans {
        background-color: transparent;
        border-color: transparent;
        color: #929292;
    }

    .btn-icon {
        padding-left: 9px;
        padding-right: 9px;
    }

    .btn-sm, .btn-group-sm > .btn, .btn-icon.btn-sm {
        padding: 5px 10px !important;
    }

    .mar-top {
        margin-top: 15px;
    }

    a {
        color: black;
        text-decoration: none;
    }

    a:hover {
        color: grey;
    }

    body {
        background-color: #f7f7f7; /* Цвет фона за контейнером */
    }
</style>
<body>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container ">
        <a style="font-size: 2rem;" class="navbar-brand" href="{{ route('books.index') }}">#BookShop
            <i class="fa-solid fa-shop"></i></a>
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
                            <button  class="nav-link d-flex flex-column align-items-center btn  " type="button" data-bs-toggle="dropdown"
                                    aria-expanded="false">

                                <i style="font-size: 1.5rem" class="fa-solid fa-user"></i>Мой профиль
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{route('admin.index')}}">Админ панель</a>

                                </li>
                                <li><a class="dropdown-item" href="{{ route('home.info')}}">Мои данные</a></li>
                                <li><a class="dropdown-item" href="{{ route('home.bought')}}">Мои заказы</a></li>
                                <li><a class="dropdown-item" href="{{ route('home.bookmark') }}">Избранные товары</a>
                                </li>
                                <li><a class="dropdown-item" href="{{ route('home.commentaries') }}">Мои отзывы </a>
                                </li>

                                <button class="dropdown-item"
                                        onclick="document.getElementById('logout-form').submit();">
                                    Выйти
                                </button>

                            </ul>
                        </div>
                    </li>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    <div>
                        <li class="nav-item">
                            <a  class="nav-link d-flex flex-column align-items-center" href="{{ route('home.bookmark') }}">
                                <i style="font-size: 1.5rem;" class="fa-regular fa-heart"></i>
                                <span>Избранное</span>
                            </a>
                        </li>
                    </div>
                    <div>
                        <li class="nav-item">
                            <a  class="nav-link d-flex flex-column align-items-center" href="{{ route('basket.index') }}">
                                <i style="font-size: 1.5rem" class="fa-solid fa-basket-shopping"></i>                                <span>Корзина: {{ $bookInBasket }}</span>
                            </a>
                        </li>
                    </div>

                @endauth
            </ul>
        </div>
    </div>
</nav>
<div class="container border border-1 bg-white">
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
        $(document).click(function (event) {
            let target = $(event.target);
            if (!target.closest('#search').length && !target.closest('.search-result').length) {
                $('.search-result').hide();
            }
        });

    });
</script>
</body>
</html>
