<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Basket;
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
        $books_session = collect(session()->get('books', []));
        $books = collect(session()->get('books', []));
        $books_auth = [];

        // ЕСЛИ ЮЗЕР НЕ АВТОРИЗОВАН, КНИГИ БЕРУТСЯ ИЗ СЕССИИ
        if (session()->has('books')) {
            $books = collect(session()->get('books', []));
            $total_price = $books->sum(function ($item) {
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


            // группировка по айди и не больше стока колво книг
            $books = $books_session->merge($books_auth)
                ->groupBy('id')
                ->map(function ($group) {
                    $firstBook = $group->first();
                    $firstBook->quantity = min($group->sum('quantity'), $firstBook->stock);
                    return $firstBook;
                })
                ->values();
            $books->each(function ($book) use ($basket) {
                $basketitem = BasketItem::where(['book_id' => $book->id, 'basket_id' => $basket->id])->first();

                if ($basketitem) {
                    $basketitem->update([
                        'quantity' => $book->quantity,
                    ]);
                    $basketitem->save();
                }
            });
            $total_price = $books->sum(function ($item) {
                return $item->quantity * $item->price;
            });
            session()->forget('books');
        }

        $addresses = Address::all();

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

        $books = json_decode($request->input('basket'));
        $basket = app('basket');

        if($basket->price == 0 ) {
            return redirect()->route('basket.index')->with('error', 'Корзина пуста');
        }elseif(empty($books)){
            return redirect()->route('basket.index')->with('error', 'Выберите книги для покупки');
        }

        Auth::user()->update($validated);
        $order_user = Order::create([
            'user_id' => Auth::id(),
            'price' => $request['total_price'],
            'address_id' => $request['address'],
            'status' => 'Новый заказ'
        ]);

        foreach ($books as $basket_item) {
            OrderItem::create([
                'book_id' => $basket_item->id,
                'quantity' => $basket_item->quantity,
                'order_id' => $order_user->id,
            ]);
        }

        $booksStockUpdate = OrderItem::where(['order_id' => $order_user->id])->get();

        $booksStockUpdate->each(function ($item) {
            $book = Book::where(['id' => $item->book_id])->first();
            $book->stock -= $item->quantity;
            $book->save();
        });

        if ($basket = Auth::user()->basket) {
            BasketItem::where('basket_id', $basket->id)->delete();
            $basket->delete();
            $request->session()->forget('books');

        }

        return redirect()->route('basket.index')->with('success', 'Заказ успешно оформлен');
    }

}
