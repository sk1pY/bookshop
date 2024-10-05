<nav style="background-color: white" class="navbar navbar-expand-lg  ">
    <div class="container">
        <a style="font-size: 2rem; color:red" class="fw-bold navbar-brand" href="{{ route('books.index') }}">#BookShop
            <i class="fa-solid fa-shop"></i></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            {{--            SEARCH--}}
            <div class="d-flex justify-content-center align-items-center  search-container mx-4" style="width: 500px;">
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
                        <div class="dropdown mt-2">
                            <button class="btn  dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                    aria-expanded="false">

                                <i style="font-size: 1.5rem;" class="fa-regular fa-bell">
                                    <span style="font-size: 0.6rem" class=" badge rounded-pill text-bg-danger">
                                        {{ $countOrdersforUser }}
                                    </span>

                                </i>
                                <span>Уведомления</span>
                            </button>
                            <ul class="dropdown-menu">
                                @foreach($notifOrders as $not)
                                    <li><a class="dropdown-item" href="{{route('home.aboutBought',$not)}}">Ваш заказ
                                            №{{$not}} готов к получению</a></li>
                                @endforeach
                            </ul>
                        </div>

                    </li>
                    <li class="nav-item ">
                        {{--                        DROPDOWN MENU--}}
                        <div class="dropdown-center">
                            <button class="nav-link d-flex flex-column align-items-center btn  " type="button"
                                    data-bs-toggle="dropdown"
                                    aria-expanded="false">

                                <i style="font-size: 1.5rem" class="fa-solid fa-user"></i>{{Auth::user()->name}}
                            </button>
                            <ul class="dropdown-menu border rounded-4">
                                <li class=" p-2 d-flex align-items-center">
                                    <i class="fa-solid fa-user me-2" style="font-size:1.7rem;width: 35px"></i>
                                    <a class="dropdown-item p-0" href="{{ route('home.info') }}">Мои данные</a>
                                </li>
                                <li class="p-2 d-flex align-items-center">
                                    <i class="fa-solid fa-screwdriver-wrench me-2" style="font-size:1.7rem;width: 35px"></i>
                                    <a class="dropdown-item p-0" href="{{ route('admin.index') }}">Админ панель</a>
                                </li>

                                <li class="p-2 d-flex align-items-center">
                                    <i class="fa-solid fa-cart-shopping me-2" style="font-size:1.7rem;width: 35px"></i>
                                    <a class="dropdown-item p-0" href="{{ route('home.bought') }}">Мои заказы</a>
                                </li>
                                <li class="p-2 d-flex align-items-center">
                                    <i class="fa-regular fa-bookmark me-2" style="font-size:1.7rem;width: 35px"></i>
                                    <a class="dropdown-item p-0" href="{{ route('home.bookmark') }}">Избранные
                                        товары</a>
                                </li>
                                <li class="p-2 d-flex align-items-center">
                                    <i class="fa-regular fa-comment me-2" style="font-size:1.7rem;width: 35px"></i>
                                    <a class="dropdown-item p-0" href="{{ route('home.commentaries') }}">Мои отзывы</a>
                                </li>
                                <li class="p-2 d-flex align-items-center">
                                    <i class="fa-solid fa-right-from-bracket me-2" style="font-size:1.7rem;width: 35px"></i>
                                    <button class="dropdown-item p-0"
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
                           href="{{ route('home.bought') }}">
                            <i style="font-size: 1.5rem;" class="fa-solid fa-bag-shopping"></i>
                            <span>Заказы</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link d-flex flex-column align-items-center"
                           href="{{ route('home.bookmark') }}">
                            <i style="font-size: 1.5rem;" class="fa-regular fa-heart"></i>
                            <span>Избранное</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link d-flex flex-column align-items-center"
                           href="{{ route('basket.index') }}">
                            <i style="font-size: 1.5rem" class="fa-solid fa-basket-shopping"></i>
                            <span>Корзина: {{ $bookInBasket }}</span>
                        </a>
                    </li>

                @endauth
            </ul>
        </div>
    </div>
</nav>

