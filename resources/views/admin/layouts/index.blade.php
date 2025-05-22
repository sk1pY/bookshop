<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Roboto', sans-serif;
            font-size: 16px;
        }

        .row {
            margin: 0;
        }


        .accordion-body a {
            font-size: 15px;
        }

    </style>

</head>

<body>
<div class="row min-vh-100">
    <div class="col-3 d-flex flex-column flex-shrink-0 p-3" style="background-color: #273A50;">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <a href="/admin" class="text-white text-decoration-none ms-2">
                <span class="fs-4">Admin Panel</span>
            </a>
            <a href="/" class="text-white text-decoration-none">
                выйти
            </a>
        </div>
        <ul class="according nav nav-pills flex-column p-0">
            <li >
                <div class="alert alert-danger" role="alert">
                    <a href="{{route('admin.orders.index')}}" class="nav-link text-dark">
                            <i class="bi bi-bag me-2 text-dark"></i> Активные заказы
                            {{$countOrders ?? 0}}
                    </a>
                </div>
            </li>
            <li>
                <a href="{{route('admin.orders.history')}}" class="nav-link text-white">
                    <i class="bi bi-hourglass me-2" width="16" height="16"></i>
                    История заказов
                </a>
            </li>

            <div class="accordion-item">
                <h2 class="accordion-header nav-link text-white d-flex">
                    <i class="bi bi-plus-circle-dotted me-2"></i>
                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne" >
                        Добавить
                    </button>
                    <i class="bi bi-caret-down ms-auto"></i>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse show " data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <a href="{{ route('admin.books.create') }}" class="nav-link text-white">
                            Книга
                        </a>
                    </div>
                    <div class="accordion-body">
                        <a href="{{ route('admin.authors.create') }}" class="nav-link text-white">
                            Автор
                        </a>
                    </div>
                    <div class="accordion-body">
                        <a href="{{ route('admin.categories.create') }}" class="nav-link text-white">
                            Категория
                        </a>
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header nav-link text-white d-flex">
                    <i class="bi bi-card-list me-2"></i>
                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        Список
                    </button>
                    <i class="bi bi-caret-down ms-auto"></i>
                </h2>
                <div id="collapseTwo" class="accordion-collapse collapse show " data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <a href="{{ route('admin.books.index') }}" class="nav-link text-white">
                            Книги
                        </a>
                    </div>
                    <div class="accordion-body">
                        <a href="{{ route('admin.authors.index') }}" class="nav-link text-white">
                            Авторы
                        </a>
                    </div>
                    <div class="accordion-body">
                        <a href="{{ route('admin.categories.index') }}" class="nav-link text-white">
                            Категории
                        </a>
                    </div>
                </div>
            </div>


            <li>
                <a href="{{route('admin.roles.permissions.index')}}" class="nav-link text-white">
                    <i class="bi  bi-clipboard2-check me-2" width="16" height="16"></i>
                    Настройка ролей и разрешений
                </a>

            </li>


            <li>
                <a href="{{route('admin.users.index')}}" class="nav-link text-white">
                    <i class="bi bi-people me-2" width="16" height="16"></i>
                    Юзеры
                </a>
            </li>
            <li>
                <a href="{{route('admin.discounts.index')}}" class="nav-link text-white">
                    <i class="bi bi-percent me-2" width="16" height="16"></i>
                    Настройка скидок
                </a>
            </li>

            <li>
                <a href="{{route('admin.addresses.index')}}" class="nav-link text-white">
                    <i class="bi bi-building me-2" width="16" height="16"></i>
                    Адреса самовывоза
                </a>
            </li>
            <li>
                <a href="{{route('admin.interfaces.index')}}" class="nav-link text-white">
                    <i class="bi bi-palette me-2" width="16" height="16"></i>
                    Настройка интерфейса
                </a>
            </li>
        </ul>

    </div>


    <div class="col p-4">
        @include('partials.alert.validation')
        @include('partials.alert.error')
        @include('partials.alert.success')
        @yield('content')
    </div>
</div>

</body>
</html>
