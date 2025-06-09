    <div class=" border rounded-4 bg-white p-2">
        <a href="{{ route('home.info') }}" class="hov d-flex align-items-center  rounded-pill p-3 ">
            <i style="font-size: 1.5rem; width: 35px;" class="bi bi-person"></i>
            <span style="font-size: 1rem" class="ms-2">Профиль</span>
        </a>

        <a href="{{ route('home.orders.index')}}" class="hov d-flex align-items-center   rounded-pill p-3">
            <i style="font-size:1.5rem;width: 35px" class="bi bi-cart3"></i>
            <span style="font-size: 1rem" class="ms-2">Заказы</span>
        </a>
        <a href="{{ route('home.bookmarks.index')}}" class="hov d-flex align-items-center  rounded-pill p-3">

            <i style="font-size:1.5rem;width: 35px" class="bi bi-bookmark"></i>
            <span style="font-size: 1rem" class="ms-2">Избранное</span>
        </a>
        <a href="{{ route('home.comments.index')}}" class="hov d-flex align-items-center rounded-pill p-3">

            <i style="font-size:1.5rem;width: 35px" class="bi bi-chat"></i>
            <span style="font-size: 1rem" class="ms-2">Отзывы</span>
        </a>
    </div>
