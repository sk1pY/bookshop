<nav style="background-color: white" class="navbar navbar-expand-lg  ">
    <div class="container">

        <a style="font-size: 2rem; color:red" class="fw-bold navbar-brand" href="{{ route('books.index') }}">#BookShop
            <i class="fa-solid fa-book"></i> </a>
        <div class="dropdown">
            <button class="btn btn-danger dropdown-toggle" type="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                Категории книг

            </button>

            <ul class="dropdown-menu p-2 w-auto">

                @foreach($categories as $category)
                    <li style="font-size: 1rem" class=" ">
                        <a class="text dropdown-item"
                           href="{{route('categories.public.show',['category' => $category->id])}}">{{ $category->name }}</a>
                    </li>
                @endforeach
            </ul>
        </div>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        {{--        <button id="btnSwitch" class="btn  ">Dark mode</button>--}}

        <div class="collapse navbar-collapse" id="navbarNav">
            {{--            SEARCH--}}
            <div class="d-flex justify-content-center align-items-center  search-container mx-4" style="width: 300px;">
                <div class="input-group " style="  position: relative;">
                    <input type="search" class="form-control rounded-pill" style="background-color: #f4f4f5"
                           placeholder="Поиск книг" aria-label="Search"
                           aria-describedby="search-addon" id="search" name="search">
                    <ul class="list-group search-result"
                        style="position: absolute; top: 100%; left: 0; width: 100%; z-index: 1000; display: none;"></ul>
                </div>
            </div>
            {{--          END  SEARCH--}}
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 ">

                @auth
                    <li class="nav-item">
                        <div class="dropdown mt-2">
                            <button class="btn  dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                    aria-expanded="false">

                                <i class="fa-regular fa-bell fs-6">
                                    <span class=" badge rounded-pill text-bg-danger">
                                                                               {{ $countOrdersforUser }}

                                    </span>

                                </i>
                            </button>
                            <ul class="dropdown-menu">
                                @foreach($notifOrders as $not)
                                    <li><a class="dropdown-item" href="{{route('home.orders.show',$not)}}">Ваш заказ
                                            №{{$not}} готов к получению</a></li>
                                @endforeach
                            </ul>
                        </div>

                    </li>
                    {{--                        DROPDOWN MENU--}}

                    <li class="nav-item ">

                        <div class="dropdown-center">
                            <button class="nav-link d-flex flex-column align-items-center" type="button"
                                    data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                <i class="bi bi-person fs-3 p-0 text-center" ></i>
                                <span>{{Auth::user()?Auth::user()->name:'guest'}}</span>

                            </button>
                            <ul class="dropdown-menu  p-2 w-auto">

                                <li class="d-flex align-items-center p-2 drowdownnav rounded-pill">
                                    <i class="bi bi-person" style="font-size:1.4rem;width: 35px"></i>
                                    <a style="font-size: 0.8rem" class="dropdown-item p-0 ms-auto"
                                       href="{{ route('home.info.index') }}">Мои данные</a>
                                </li>
                                <li class="d-flex align-items-center p-2 drowdownnav rounded-pill ">
                                    <i class="fa-solid fa-screwdriver-wrench me-2"
                                       style="font-size:1.4rem;width: 35px"></i>
                                    <a style="font-size: 0.8rem" class="dropdown-item p-0 ms-auto "
                                       href="{{ route('admin.index') }}">Админ панель</a>
                                </li>

                                <li class="d-flex align-items-center p-2 drowdownnav rounded-pill">
                                    <i class="fa-solid fa-cart-shopping me-2" style="font-size:1.4rem;width: 35px"></i>
                                    <a style="font-size: 0.8rem;" class="dropdown-item p-0 ms-auto"
                                       href="{{ route('home.orders.index') }}">Мои заказы</a>
                                </li>
                                <li class="p-2 d-flex align-items-center drowdownnav rounded-pill">
                                    <i class="fa-regular fa-bookmark me-2"
                                       style="font-size:1.4rem;width: 35px"></i>
                                    <a style="font-size: 0.8rem" class="dropdown-item p-0 ms-auto"
                                       href="{{ route('home.bookmarks.index') }}">Избранные
                                        товары</a>
                                </li>
                                <li class="p-2 d-flex align-items-center  drowdownnav rounded-pill">
                                    <i class="fa-regular fa-comment me-2"
                                       style="font-size:1.4rem;width: 35px"></i>
                                    <a style="font-size: 0.8rem" class="dropdown-item p-0 ms-auto"
                                       href="{{ route('home.commentaries.index') }}">Мои отзывы</a>
                                </li>
                                <li class="p-2 d-flex align-items-center drowdownnav rounded-pill">
                                    <i class="fa-solid fa-right-from-bracket me-2"
                                       style="font-size:1.4rem;width: 35px"></i>
                                    <button style="font-size: 0.8rem" class="dropdown-item p-0 ms-auto"
                                            onclick="document.getElementById('logout-form').submit();">Выйти
                                    </button>
                                </li>
                            </ul>

                        </div>
                    </li>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>

                    <li class="nav-item">
                        <a class="nav-link d-flex flex-column align-items-center"
                           href="{{ route('home.orders.index') }}">
                            <i class="bi bi-bag fs-3 " style="height: 40px; width: 30px"></i>
                            <span>Заказы</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link d-flex flex-column align-items-center"
                           href="{{ route('home.bookmarks.index') }}">
                            <i class="bi bi-heart fs-3 " style="height: 40px; width: 30px"></i>
                            <span>Избранное</span>
                        </a>
                    </li>
                @endauth
                <li class="nav-item">
                    <a class="nav-link d-flex flex-column align-items-center"
                       href="{{ route('basket.index') }}">
                        <i class="bi bi-cart fs-3 " style="height: 40px; width: 30px"></i>
                        <span>Корзина</span>
                    </a>
                </li>
                @guest
                    <li class="nav-item mt-3">
                        <a class="nav-link" href="{{ route('login') }}">Войти</a>
                    </li>
                    <li class="nav-item mt-3">
                        <a class="nav-link" href="{{ route('register') }}">Регистрация</a>
                    </li>
                @endguest

            </ul>
        </div>

    </div>
</nav>
<nav class="navbar navbar-expand-lg navbar-light bg-white ">
    <div class="container">
        <a class="navbar-brand" href="#">Акции</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">Бестселлеры</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Новинки</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Скоро в продаже</a>
                </li>
            </ul>
        </div>
    </div>
</nav>


