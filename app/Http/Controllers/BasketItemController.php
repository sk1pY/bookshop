<?php

namespace App\Http\Controllers;

use App\Models\Address;
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
    public function increase(Request $request, Book $book)
    {
        $basket = app('basket');
        $books = collect(session()->get('books', []));
        $bookId = $book->id;
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
                        return to_route('basket.index');

                    }
                });
                $request->session()->forget('books');
            }
            $basket_item_book = BasketItem::where(['book_id' => $bookId, 'basket_id' => $basket->id])->first();
            $stock = Book::where(['id' => $book->id])->first()->stock;
            if (!$basket_item_book) {
                $basket_item_book = BasketItem::create(
                    [   'book_id' => $bookId,
                        'basket_id' => $basket->id,
                        'quantity' => 1
                    ]
                );
                $basket->price += $basket_item_book->book->price;
                $basket->save();
                return to_route('basket.index')->with('success', 'Успешно добавлена в корзину');
            } elseif ($basket_item_book->quantity < $stock) {

                $basket_item_book->increment('quantity');
                $basket->price += $basket_item_book->book->price;
                $basket->save();
                return to_route('basket.index');

            } elseif ($basket_item_book->quantity == $stock) {
                return to_route('basket.index')->with('error', 'Выбрано максимальное количество книг');
            }
        } else {
            $books = collect(session()->get('books', []));
            $book_exist = false;
            $stock = false;
            $books = $books->map(function ($item) use (&$stock, &$book_exist, $bookId) {
                if ($item->id == $bookId) {
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
                return to_route('basket.index')->with('error', 'Выбрано максимальное количество книг');
            }
            if (!$book_exist) {
                $book->quantity = 1;
                $books->push($book);
            }
            session(['books' => $books]);

        }
        return to_route('basket.index');


    }

    public function decrease(Book $book)
    {
        $bookId = $book->id;

        if (session()->has('books')) {

            $books = collect(session()->get('books', []));
            $update = false;
            $books = $books->map(function ($book) use ($bookId, &$update) {
                if ($book->id == $bookId && $book->quantity > 1) {
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
                return to_route('basket.index');
            }
        }

        if (Auth::check()) {

            $basket = app('basket');

            $bookInBasket = BasketItem::where('book_id', $bookId)->first();
            //dd($bookInBasket);
            if ($bookInBasket->quantity == 1) {
                $bookInBasket->delete();
                if (BasketItem::where('basket_id', $basket->id)->count() == 0) {
                    $basket->price -= $bookInBasket->book->price;
                    $basket->delete();
                }
                return to_route('basket.index');
            }
            $bookInBasket->decrement('quantity');
            $basket->price -= $bookInBasket->book->price;
            $basket->save();
        }

        return to_route('basket.index');
    }

    public function deleteAllByBook(Request $request, Book $book)
    {
        $basket = app('basket');

        BasketItem::where(['book_id' => $book->id, 'basket_id' => $basket->id])->delete();
        $request->session()->forget('books');

        return to_route('basket.index');

    }
}
