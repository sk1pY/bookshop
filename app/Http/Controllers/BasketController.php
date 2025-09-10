<?php

namespace App\Http\Controllers;

use App\Events\OrderPlaced;
use App\Http\Requests\MakeOrderRequest;
use App\Models\Address;
use App\Models\BasketItem;
use App\Models\Book;
use App\Models\Order;
use App\Models\OrderItem;
use App\Services\BasketService;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class BasketController extends Controller
{
    public function index(request $request, BasketService $basketService)
    {
        $basket_full_price = 0;
        $books = $basketService->booksInBasket();
        $basketfullPrice = $basketService->basketFullPrice();
        $addresses = Address::latest()->get();

        return view('front.basket', [
            'books' => $books,
            'basket_full_price' => $basketfullPrice,
            'addresses' => $addresses,
        ]);
    }

    public function makeOrder(MakeOrderRequest $request,OrderService $orderService)
    {
        $validated = $request->validated();
        $user = Auth::user();
        $order = $orderService->makeOrder($user,$validated);
        event(new OrderPlaced($order));
        return to_route('basket.index')->with('success', 'Заказ успешно оформлен');
    }
}
