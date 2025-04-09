<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>

        .row {
            margin: 0;
        }

        .col-2 {
            color: white;
        }


    </style>
</head>
<body>
<div class="row">
    <div class="col-2 d-flex flex-column flex-shrink-0 p-3 bg-dark w-auto h-auto">
        <a href="/" class="d-flex align-items-center mb-3 text-white text-decoration-none">
            <svg class="bi me-2" width="40" height="32">

            </svg>
            <span class="fs-4">Admin Panel</span>
        </a>
        <hr class="bg-white">


        <ul class="according nav nav-pills flex-column mb-auto ">
            <li>
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
                            data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        Добавить
                    </button>
                    <i class="bi bi-caret-down ms-auto"></i>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
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
                <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
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
        <hr>

        <div class="dropdown">
            <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle"
               id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                @auth()
                    <strong>{{Auth::user()->name}}</strong>
                @endauth
            </a>
            <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">

                <li><a class="dropdown-item" href="{{route('home.info.index')}}">Profile</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li>
                    <form action="{{ route('logout') }}" method="post">
                        @csrf
                        <button type="submit" class="dropdown-item">Sign out</button>

                    </form>
                </li>

            </ul>
        </div>
    </div>


    <div class="col bg-secondary-subtle p-4">
        @yield('content')
    </div>
</div>

</body>
</html>
