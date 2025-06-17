<?php

namespace App\Http\Controllers;

use App\Http\Requests\MakeOrderRequest;
use App\Models\Address;
use App\Models\BasketItem;
use App\Models\Book;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BasketController extends Controller
{
    public function index(request $request)
    {
        $basket = app('basket');
        $books = collect(session()->get('books', collect()));
        $basket_full_price = 0;
        // ЕСЛИ ЮЗЕР НЕ АВТОРИЗОВАН
        if (session()->has('books')) {
            $basket_full_price = $books->sum(function ($item) {
                return $item->quantity * $item->price;
            });
        }
        // ЕСЛИ ЮЗЕР АВТОРИЗОВАН
        if (Auth::check()) {
            $books = $basket->basket_items()
                ->with('book')
                ->get()
                ->map(function ($item) {
                    $book = $item->book;
                    $book->quantity = $item->quantity;
                    $book->fullPrice = $book->quantity * $book->price;
                    return $book;
                });

            //dd($books);
            $basket_full_price = $books->sum(function ($item) {
                return $item->quantity * $item->price;
            });

            $basket->price = $basket_full_price;
            $basket->save();
        }

        $addresses = Address::latest()->get();

        return view('front.basket', compact('books', 'basket_full_price', 'addresses'));
    }

    public function makeOrder(MakeOrderRequest $request)
    {
        $validated = $request->validated();

        $basket = app('basket');
        $user = Auth::user();
        $books = $basket->basket_items()->get();

        if ($basket->price == 0) {
            return redirect()->route('basket.index')->with('error', 'Корзина пуста');
        } elseif (empty($books)) {
            return redirect()->route('basket.index')->with('error', 'Выберите книги для покупки');
        }

        $user->update($validated);

        $order_user = Order::create([
            'user_id' => Auth::id(),
            'price' => $basket->price,
            'address_id' => $request->input('addressId'),
            'status' => 'Новый заказ'
        ]);

        foreach ($books as $basket_item) {
            OrderItem::create([
                'book_id' => $basket_item->book_id,
                'quantity' => $basket_item->quantity,
                'order_id' => $order_user->id,
            ]);
        }
        $booksStockUpdate = $order_user->order_items()->get();
        $booksStockUpdate->each(function ($item) {
            $book = Book::where(['id' => $item->book_id])->first();
            $book->stock -= $item->quantity;
            $book->save();
        });

        ///ОБНОВЛЕНИЕ ВСЕХ БАСКЕТ ИТЕМСОВ ВСЕ ЮЗЕРОВ С УЧЕТОМ СДЕЛАННОГО ЗАКАЗА
        $basket_items = BasketItem::with('book')->get()
            ->map(function ($item) {
                if ($item->book->stock > 0) {
                    if ($item->quantity <= $item->book->stock) {
                        return $item;

                    } else {
                        $item->quantity = $item->book->stock;
                        return $item;
                    }
                } else {
                    return null;
                }
            })->filter();
        $basket_items->each->save();
        ///ОБНОВЛЕНИЕ ВСЕХ БАСКЕТ ИТЕМСОВ ВСЕ ЮЗЕРОВ С УЧЕТОМ СДЕЛАННОГО ЗАКАЗА

        $basket->delete();
        return to_route('basket.index')->with('success', 'Заказ успешно оформлен');
    }

}
