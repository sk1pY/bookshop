<nav style="background-color: white" class="navbar navbar-expand-lg w-100 sticky-top">
        <div class="container">
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
                            <div class="dropdown-center ">
                                <button class="nav-link d-flex flex-column align-items-center btn  " type="button"
                                        data-bs-toggle="dropdown"
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
                                <a class="nav-link d-flex flex-column align-items-center"
                                   href="{{ route('home.bookmark') }}">
                                    <i style="font-size: 1.5rem;" class="fa-regular fa-heart"></i>
                                    <span>Избранное</span>
                                </a>
                            </li>
                        </div>
                        <div>
                            <li class="nav-item">
                                <a class="nav-link d-flex flex-column align-items-center"
                                   href="{{ route('basket.index') }}">
                                    <i style="font-size: 1.5rem" class="fa-solid fa-basket-shopping"></i>
                                    <span>Корзина: {{ $bookInBasket }}</span>
                                </a>
                            </li>
                        </div>

                    @endauth
                </ul>
            </div>
        </div>
    </nav>

