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
use Illuminate\Support\Facades\Log;
use function PHPSTORM_META\map;
use function PHPUnit\Framework\isEmpty;

class BasketItemController extends Controller
{
    public function increase(Request $request)
    {

        $bookId = $request->input('book_id');
        $book = Book::find($bookId);
        $basket = app('basket');
        $books = collect(session()->get('books', []));
        // ЕСЛИ АВТОРИЗОВАН
        if (Auth::check()) {
            if (session()->has('books')) {
                //ПЕРЕБОР КНИГ ИЗ  СЕССИИ
                $books->each(function ($item) use ($basket) {
                    $stock = Book::where(['id' => $item->id])->first()->stock;
                    $basket_item_book = BasketItem::where(['book_id' => $item->id, 'basket_id' => $basket->id])->first();
                    // ЕСЛИ КНИГА ВПЕРВЫЕ В КОРЗИНЕ
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

                        $bookFullPrice = $basket_item_book->book->price * $basket_item_book->quantity;
                          Log::info($bookFullPrice);

                        return response()->json([
                            'success' => true,
                            'quantity' => $basket_item_book->quantity,
                            'basketPrice' => round($basket->price, 2),
                            'bookFullPrice' => round($bookFullPrice, 2),
                            'message' => 'книг прабавлено 1']);
                    }
                });
                $request->session()->forget('books');
            }
            $basket_item_book = BasketItem::where(['book_id' => $bookId, 'basket_id' => $basket->id])->first();
            $stock = $book->stock;
            if (!$basket_item_book) {
                $basket_item_book = BasketItem::create([
                        'book_id' => $bookId,
                        'basket_id' => $basket->id,
                        'quantity' => 1]
                );
                $basket->price += $basket_item_book->book->price;
                $basket->save();
                $bookInBasketQuantity = $basket->basket_items()->pluck('quantity')->sum();
                $bookFullPrice = $basket_item_book->book->price * $basket_item_book->quantity;

                return response()->json([
                    'success' => true,
                    'quantity' => $basket_item_book->quantity,
                    'basketPrice' => round($basket->price, 2),
                    'bookInBasketQuantity' => $bookInBasketQuantity,
                    'bookFullPrice' => round($bookFullPrice, 2),
                    'message' => 'успешно добавлена в коризину']);
            } elseif ($basket_item_book->quantity < $stock) {
                $basket_item_book->increment('quantity');
                $basket->price += $basket_item_book->book->price;
                $basket->save();
                $bookInBasketQuantity = $basket->basket_items()->pluck('quantity')->sum();

                $bookFullPrice = $basket_item_book->book->price * $basket_item_book->quantity;


                return response()->json([
                    'success' => true,
                    'quantity' => $basket_item_book->quantity,
                    'basketPrice' => round($basket->price, 2),
                    'bookInBasketQuantity' => $bookInBasketQuantity,
                    'bookFullPrice' => round($bookFullPrice, 2),
                ]);

            } elseif ($basket_item_book->quantity == $stock) {
                $bookInBasketQuantity = $basket->basket_items()->pluck('quantity')->sum();
                $bookFullPrice = $basket_item_book->book->price * $basket_item_book->quantity;

                return response()->json([
                    'success' => true,
                    'quantity' => $basket_item_book->quantity,
                    'bookInBasketQuantity' => $bookInBasketQuantity,
                    'basketPrice' => round($basket->price, 2),
                    'bookFullPrice' => round($bookFullPrice, 2),
                    'message' => 'Выбрано максимальное количество книг']);

            }
        } // ЕСЛИ НЕ АВТОРИЗОВАН
        else {
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
                return response()->json(['success' => false, 'message' => 'Выбрано максимальное количество книг',]);
            }
            if (!$book_exist) {
                $book->quantity = 1;
                $books->push($book);
            }
            session(['books' => $books]);
        }
        $bookInBasketQuantity = $books->pluck('quantity')->sum();

        return response()->json(['success' => true, 'quantity' => $book->quantity, 'bookInBasketQuantity' => $bookInBasketQuantity]);
    }

    public function decrease(Request $request)
    {
        $bookId = $request->input('book_id');
        $book = Book::find($bookId);

        // ЕСЛИ НЕ АВТОРИЗОВАН
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
                return response()->json(['success' => true, 'quantity' => $book->quantity]);
            }
        }
        //ЕСЛИ АВТОРИЗОВАН
        if (Auth::check()) {
            $basket = app('basket');
            $bookInBasket = BasketItem::where(['basket_id' => $basket->id])->firstWhere('book_id', $bookId);
            if ($bookInBasket->quantity == 1) {
                $bookInBasket->delete();
                if (BasketItem::where('basket_id', $basket->id)->count() === 0) {
                    $basket->price -= $bookInBasket->book->price;
                    $basket->delete();
                }
                $bookInBasketQuantity = $basket->basket_items()->pluck('quantity')->sum();
                $bookFullPrice = $bookInBasket->book->price * $bookInBasket->quantity;

                return response()->json([
                    'success' => true,
                    'quantity' => 0,
                    'basketPrice' => round($basket->price, 2),
                    'bookInBasketQuantity' => $bookInBasketQuantity,
                    'bookFullPrice' => round($bookFullPrice, 2),
                    'message' => 'последняя книга удалена из корзины']);
            }
            $bookInBasket->decrement('quantity');
            $basket->price -= $bookInBasket->book->price;
            $basket->save();
        }
        $bookInBasketQuantity = $basket->basket_items()->pluck('quantity')->sum();
        $bookFullPrice = $bookInBasket->book->price * $bookInBasket->quantity;


        return response()->json([
            'success' => true,
            'quantity' => $bookInBasket->quantity,
            'basketPrice' => round($basket->price, 2),
            'bookInBasketQuantity' => $bookInBasketQuantity,
            'bookFullPrice' => round($bookFullPrice, 2),
            'message' => 'книг уменьшено на 1']);
    }

    public function deleteAllByBook(Request $request, Book $book)
    {
        $basket = app('basket');

        BasketItem::where(['book_id' => $book->id, 'basket_id' => $basket->id])->delete();
        $request->session()->forget('books');

        return to_route('basket.index');

    }
}
