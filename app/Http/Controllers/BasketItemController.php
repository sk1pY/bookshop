<?php

namespace App\Http\Controllers;

use App\Models\Basket;
use App\Models\BasketItem;
use App\Models\Book;
use App\Models\DeliveryAddress;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use function PHPSTORM_META\map;
use function PHPUnit\Framework\isEmpty;

class BasketItemController extends Controller
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

        $addresses = DeliveryAddress::all();

        return view('basket', compact('books', 'total_price', 'addresses'));
    }


    public function addToBasket(Request $request, $id)
    {
        $basket = app('basket');
        $books = collect(session()->get('books', []));


        if (Auth::check()) {
            if (session()->has('books')) {

                $books->each(function ($item) use ($basket) {
                    $stock = Book::where(['id' => $item->id])->first()->stock;

                    $basket_item_book = BasketItem::where(['book_id' => $item->id, 'basket_id' => $basket->id])->first();

                    if (!$basket_item_book) {
                        BasketItem::create(
                            ['book_id' => $item->id,
                                'basket_id' => $basket->id,
                                'quantity' => $item->quantity
                            ]);
                    } elseif ($basket_item_book->quantity < $stock) {

                        $basket_item_book->increment('quantity');
                        $basket->price += $basket_item_book->book->price;
                        $basket->save();
                        return redirect()->route('basket.index');

                    }
                });
                $request->session()->forget('books');
            }
            //  $basketUser = Basket::firstOrCreate(['user_id' => Auth::id()]);
            $basket_item_book = BasketItem::where(['book_id' => $id, 'basket_id' => $basket->id])->first();
            $stock = Book::where(['id' => $id])->first()->stock;
            if (!$basket_item_book) {
                $basket_item_book = BasketItem::create(
                    ['book_id' => $id,
                        'basket_id' => $basket->id,
                        'quantity' => 1
                    ]
                );
                $basket->price += $basket_item_book->book->price;
                $basket->save();
                return redirect()->route('basket.index')->with('success', 'Успешно добавлена в корзину');
            } elseif ($basket_item_book->quantity < $stock) {

                $basket_item_book->increment('quantity');
                $basket->price += $basket_item_book->book->price;
                $basket->save();
                return redirect()->route('basket.index');

            } elseif ($basket_item_book->quantity == $stock) {
                return redirect()->route('basket.index')->with('error', 'Выбрано максимальное количество книг');
            }
        } else {
            $books = collect(session()->get('books', []));
            $book_exist = false;
            $stock = false;
            $books = $books->map(function ($item) use (&$stock, &$book_exist, $id) {
                if ($item->id == $id) {
                    if ($item->quantity < $item->stock) {
                        $item->quantity++;
                        $book_exist = true;
                        return $item;
                    } else {
                        $stock = true;
                    }
                }
                return $item;
            });
            if ($stock) {
                return redirect()->route('basket.index')->with('error', 'Выбрано максимальное количество книг');
            }
            if (!$book_exist) {
                $book = Book::find($id);
                $book->quantity = 1;
                $books->push($book);
            }
            session(['books' => $books]);

        }
        return redirect()->route('basket.index');


    }

    public function delete($id)
    {
        if (session()->has('books')) {

            $books = collect(session()->get('books', []));
            $update = false;
            $books = $books->map(function ($book) use ($id, &$update) {
                if ($book->id == $id && $book->quantity > 1) {
                    $book->quantity--;
                    $update = true;
                    return $book;
                } else {
                    $book = null;
                    $update = true;
                }
                return $book;
            })->filter();
            session(['books' => $books]);
            if ($update) {
                return redirect()->route('basket.index');
            }
        }

        if (Auth::check()) {

            $basket = app('basket');

            $bookInBasket = BasketItem::where('book_id', $id)->first();
            //dd($bookInBasket);
            if ($bookInBasket->quantity == 1) {
                $bookInBasket->delete();
                if (BasketItem::where('basket_id', $basket->id)->count() == 0) {
                    $basket->delete();
                }
                return redirect()->route('basket.index');
            }
            $bookInBasket->decrement('quantity');
            $basket->price -= $bookInBasket->book->price;
            $basket->save();
        }

        return redirect()->route('basket.index');
    }

    public function delete_from_basket(Request $request, Book $book)
    {
        $basket = app('basket');

        BasketItem::where(['book_id' => $book->id, 'basket_id' => $basket->id])->delete();
        $request->session()->forget('books');

        return redirect()->route('basket.index');

    }

    public function orderAdd(Request $request)
    {
        //  dd($request->all());
        $validated = $request->validate([
            'name' => 'required|alpha|string',
            'surname' => 'required|alpha|string',
            'address' => 'required|string',
            'phone' => ['required', 'regex:/^\+375(25|29|33|44|17)\d{7}$/'],
        ], [
            'phone.regex' => 'Номер телефона должен начинаться с +375 и содержать 7 цифр после кода оператора.'
        ]);
        if ($request->input('basket') !== []) {


            Auth::user()->update($validated);

            $order_user = Order::create([
                'user_id' => Auth::id(),
                'price' => $request->input('total_price'),
                'address' => $request->input('address'),
                'status' => 'Новый заказ'
            ]);
            $basketJson = $request->input('basket');
            $basket = collect(json_decode($basketJson));

            //КОЛЛЕКЦИЯ КНИГ КОТОРЫЕ ЗАКАЗАЛ ЮЗЕР
            foreach ($basket as $basket_item) {
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
        } else {
            return redirect()->route('basket.index')->with('error', 'Корзина пуста');
        }


        return redirect()->route('basket.index')->with('success', 'Заказ успешно оформлен');
    }
}
