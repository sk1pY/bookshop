<?php

namespace App\Http\Controllers;

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
        $total_price = 0;
        $books_auth = collect();
        $books_session = collect(session()->get('books', collect()));
        $books = collect(session()->get('books', []));

        // ЕСЛИ ЮЗЕР НЕ АВТОРИЗОВАН, КНИГИ БЕРУТСЯ ИЗ СЕССИИ
        if (session()->has('books')) {
            $total_price = $books_session->sum(function ($item) {
                return $item->quantity * $item->price;
            });
        }
        // ЕСЛИ ЮЗЕР АВТОРИЗОВАН
        if (Auth::check()) {
            $books_auth = $basket->basket_items()
                ->with('book')
                ->get()
                ->map(function ($item) {
                    $book = $item->book;
                    $book->quantity = $item->quantity;
                    return $book;
                });
            $books = $books_session->merge($books_auth)
                //групирует дубликаты из сессии и auth
                ->groupBy('id')
                ->map(function ($group_item_book) {
                    $book = $group_item_book->first();
                    $book->quantity = min($group_item_book->sum('quantity'), $book->stock);
                    $book->fullPrice = $book->quantity * $book->price;
                    return $book;
                });

            $books->each(function ($book) use ($basket) {
                $basketitem = BasketItem::firstOrCreate(
                    [   'book_id' => $book->id,
                        'basket_id' => $basket->id],
                    [   'quantity' => $book->quantity]);
                $basketitem->update([
                    'quantity' => $book->quantity,
                ]);
                $basketitem->save();

            });

            $total_price = $books->sum(function ($item) {
                return $item->quantity * $item->price;
            });

            $basket->price = $total_price;
            $basket->save();

            session()->forget('books');

        }

        $addresses = Address::latest()->get();

        return view('basket', compact('books', 'total_price', 'addresses'));
    }

    public function makeOrder(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|alpha|string',
            'surname' => 'alpha|string|nullable',
            'phone' => ['required', 'regex:/^\+375(25|29|33|44|17)\d{7}$/'],
        ], [
            'phone.regex' => 'Номер телефона должен начинаться с +375 и содержать 7 цифр после кода оператора. 25|29|33|44'
        ]);

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
        $basket->delete();
        return to_route('basket.index')->with('success', 'Заказ успешно оформлен');
    }

}
