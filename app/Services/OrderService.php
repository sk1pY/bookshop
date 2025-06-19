<?php

namespace App\Services;

use App\Models\BasketItem;
use App\Models\Book;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class OrderService
{
    protected BasketService $basketService;

    public function __construct(BasketService $basketService)
    {
        $this->basketService = $basketService;
    }

    public function makeOrder(User $user, array $validated)
    {

        $booksInBasket = $this->basketService->booksInBasket();
        $basket = $this->basketService->getBasket();
        $basketFullPrice = $this->basketService->basketFullPrice($booksInBasket);

        $order = Order::create([
            'user_id' => $user->id,
            'price' => $basketFullPrice,
            'address_id' => $validated['addressId'],
            'status' => 'Новый заказ'
        ]);

        $user->update($validated);

        $this->orderCreateItem($order, $booksInBasket);
        $this->updateBookStock($order);
        $this->updateUsersBasketItems();
        $basket->delete();
        return $order;
    }

    protected function orderCreateItem(Order $order, $booksInBasket): void
    {
        foreach ($booksInBasket as $book) {
            OrderItem::create([
                'book_id' => $book->id,
                'quantity' => $book->quantity,
                'order_id' => $order->id,
            ]);
        }

    }

    protected function updateUsersBasketItems():void
    {

        BasketItem::with('book')->get()->each(function ($item) {
            if ($item->book && $item->book->stock > 0) {
                if ($item->quantity > $item->book->stock) {
                    $item->quantity = $item->book->stock;
                    $item->save();
                }
            } else {
                $item->delete();
            }
        });

    }

    protected function updateBookStock(Order $order): void
    {
        $order->order_items()->each(function ($item) {
            $book = Book::find($item->book_id);
            $book->stock -= $item->quantity;
            $book->save();
        });
    }


}
