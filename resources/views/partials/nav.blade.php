<nav class="sticky-top navbar navbar-expand-lg bg-white">

    <a class="navbar-brand fw-bold navbar-brand-custom" href="{{ route('books.index') }}">
        #BookShop <i class="fa-solid fa-book"></i>
    </a>
    <div class="dropdown">
        <button class="btn btn-danger dropdown-toggle" type="button" data-bs-toggle="dropdown"
                aria-expanded="false">
            Категории книг

        </button>

        <ul class="dropdown-menu p-2 w-auto">
            @foreach($categories as $category)
                <li style="font-size: 1rem" class=" ">
                    <a class="text dropdown-item"
                       href="{{route('categories.show',$category)}}">{{ $category->name }}</a>
                </li>
            @endforeach
        </ul>
    </div>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        {{--            SEARCH--}}
        <div class="d-flex justify-content-center align-items-center  search-container mx-4 w-100">
            <div class="input-group " style=" position: relative; ">
                    <span class="input-group-text border-0 rounded-left-5" id="basic-addon1"
                          style="background-color: #f4f4f5">
                        <i class="bi bi-search"></i>
                    </span>

                <input id="search"
                       class="form-control border-0 rounded-right-4"
                       style=" background-color: #f4f4f5"
                       placeholder="Поиск книг"
                       aria-describedby="search-addon" name="search">
            </div>
        </div>
        {{--          END  SEARCH--}}
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0 ">
            @auth
                <li class="nav-item">
                    <div class="dropdown mt-2">
                        <button class="btn  dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                aria-expanded="false">

                            <i class="bi bi-bell fs-6 d-flex  p-0 m-0">
                                    <span class="text text-sm-center badge rounded-pill text-bg-danger">
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
                <li class="nav-item">
                    <div class="dropdown-center">
                        <div class="nav-link d-flex flex-column align-items-center dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="bi bi-person fs-5 d-flex p-0 m-0"></i>
                            <span>{{ Auth::user() ? Auth::user()->name : 'guest' }}</span>
                        </div>
                        <ul class="dropdown-menu p-2 w-auto">
                            <li class="d-flex align-items-center p-2  rounded-pill">
                                <i class="bi bi-person fs-3 d-flex p-0 m-0 me-2"></i>
                                <a style="font-size: 0.8rem" class="dropdown-item p-0 ms-auto"
                                   href="{{ route('home.info') }}">Мой профиль</a>
                            </li>
                            <li class="d-flex align-items-center p-2  rounded-pill">
                                <i class="bi bi-gear fs-3 d-flex p-0 m-0 me-2"
                                   style="font-size:1.4rem;width: 35px"></i>
                                <a style="font-size: 0.8rem" class="dropdown-item p-0 ms-auto"
                                   href="{{ route('admin.index') }}">Админ панель</a>
                            </li>
                            <li class="p-2 d-flex align-items-center  rounded-pill">
                                <i class="bi bi-chat fs-3 d-flex p-0 m-0 me-2"
                                   style="font-size:1.4rem;width: 35px"></i>
                                <a style="font-size: 0.8rem" class="dropdown-item p-0 ms-auto"
                                   href="{{ route('home.comments.index')}}">Мои отзывы</a>
                            </li>
                            <li class="p-2 d-flex align-items-center  rounded-pill">
                                <i class="bi bi-box-arrow-left fs-3 d-flex p-0 m-0 me-2"
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
                        <i class="bi bi-bag fs-5  d-flex  p-0 m-0"></i>
                        <span>Заказы</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex flex-column align-items-center"
                       href="{{ route('home.bookmarks.index') }}">
                        <i class="bi bi-heart fs-5 d-flex  p-0 m-0"></i>
                        <span>Избранное</span>
                    </a>
                </li>
            @endauth
            @guest
                <li class="nav-item">
                    <a class="nav-link d-flex flex-column align-items-center"
                       href="{{ route('login') }}">
                        <i class="bi bi-box-arrow-in-right fs-5 d-flex justify-content-center"></i>

                        <span>Войти</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex flex-column align-items-center"
                       href="{{ route('register') }}">
                        <i class="bi bi-journal-plus fs-5 d-flex justify-content-center"></i>

                        <span>Регистрация</span>
                    </a>
                </li>
            @endguest
            <li class="nav-item">
                <a href="{{ route('basket.index') }}" type="button"
                   class="nav-link d-flex flex-column align-items-center ">
                    <i class="bi bi-cart fs-5 d-flex justify-content-center"></i>
                    <div class="d-flex ">
                        <span class="">Корзина</span>
                        <span id="basket-count"
                              class="badge text-bg-danger ms-1 align-content-center">{{ $bookInBasketQuantity }}</span>
                    </div>

                </a>
            </li>


        </ul>

    </div>

</nav>

<div class="container my-2">
    <div class="d-flex justify-content-start gap-3 fs-5">
        <a class="nav-link" href="{{ route('specialCategories.show','sales') }}">Акции</a>
        <a class="nav-link" href="{{ route('specialCategories.show','bestsellers') }}">Бестселлеры</a>
        <a class="nav-link" href="{{ route('specialCategories.show','newest') }}">Новинки</a>
    </div>
</div>

