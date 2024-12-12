<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous"></script>

    <title>Admin</title>
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
    <div class="col-2 d-flex flex-column flex-shrink-0 p-3 bg-dark" style=" height: 100vh;">
        <a href="/" class="d-flex align-items-center mb-3 text-white text-decoration-none">
            <svg class="bi me-2" width="40" height="32">

            </svg>
            <span class="fs-4">Admin Panel</span>
        </a>
        <hr class="bg-white">


        <ul class="according nav nav-pills flex-column mb-auto ">
            <li>
                <a href="{{route('admin.orders.index')}}" class="nav-link text-white">
                    <i class="bi bi-bag me-2" width="16" height="16"></i>
                    Активные заказы
                </a>

            </li>
            <div class="accordion-item">
                <h2 class="accordion-header nav-link text-white d-flex">
                    <i class="bi bi-plus-circle-dotted me-2" width="16" height="16"></i>
                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        Добавить
                    </button>
                    <i class="bi bi-caret-down" width="16" height="16"></i>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <li>
                            <a href="{{ route('admin.books.create') }}" class="nav-link text-white">
                                Книга
                            </a>

                        </li>
                    </div>
                    <div class="accordion-body">
                        <li>
                            <a href="{{ route('admin.authors.create') }}" class="nav-link text-white">
                                Автор
                            </a>

                        </li>
                    </div>
                    <div class="accordion-body">
                        <li>
                            <a href="{{ route('admin.categories.create') }}" class="nav-link text-white">
                                Категорию
                            </a>

                        </li>
                    </div>
                </div>
            </div>

            <li>
                <a href="{{route('admin.books.index')}}" class="nav-link text-white">
                    <i class="bi bi-book me-2" width="16" height="16"></i>
                    Все книги
                </a>

            </li>


            <li>
                <a href="{{route('admin.authors.index')}}" class="nav-link text-white">
                    <i class="bi bi-person-gear me-2" width="16" height="16"></i>
                    Все авторы
                </a>
            </li>

            <li>
                <a href="{{route('admin.categories.index')}}" class="nav-link text-white">
                    <i class="bi bi-journal-check me-2" width="16" height="16"></i>
                    Все категории
                </a>
            </li>
            <li>
                <a href="{{route('admin.users.index')}}" class="nav-link text-white">
                    <i class="bi bi-people me-2" width="16" height="16"></i>
                    Юзеры
                </a>
            </li>
            <li>
                <a href="{{route('admin.discount.index')}}" class="nav-link text-white">
                    <i class="bi bi-percent me-2" width="16" height="16"></i>
                    Настройка скидок
                </a>
            </li>
            <li>
                <a href="{{route('admin.orders.history')}}" class="nav-link text-white">
                    <i class="bi bi-hourglass me-2" width="16" height="16"></i>
                    История заказов
                </a>
            </li>
            <li>
                <a href="{{route('admin.addresses.index')}}" class="nav-link text-white">
                    <i class="bi bi-building me-2" width="16" height="16"></i>
                    Адреса самовывоза
                </a>
            </li>
            <li>
                <a href="{{route('admin.interface.index')}}" class="nav-link text-white">
                    <i class="bi bi-palette me-2" width="16" height="16"></i>
                    Настройка интерфейса
                </a>
            </li>
        </ul>
        <hr>

        <div class="dropdown">
            <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle"
               id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="https://github.com/mdo.png" alt="" width="32" height="32" class="rounded-circle me-2">
                <strong>mdo</strong>
            </a>
            <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
                <li><a class="dropdown-item" href="#">New project...</a></li>
                <li><a class="dropdown-item" href="#">Settings</a></li>
                <li><a class="dropdown-item" href="#">Profile</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="#">Sign out</a></li>
            </ul>
        </div>
    </div>


    <div class="col bg-secondary-subtle p-4">
        @yield('content')
    </div>
</div>

</body>
</html>
