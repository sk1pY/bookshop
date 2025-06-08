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
use function Sodium\increment;

class BasketItemController extends Controller
{
    public function increase(Request $request)
    {
        $bookId = $request->input('book_id');
        $book = Book::find($bookId);
        $basket = app('basket');
        // ЕСЛИ АВТОРИЗОВАН
        if (Auth::check()) {
            $stock = $book->stock;
            // ЕСЛИ КНИГА ВПЕРВЫЕ В КОРЗИНЕ то создат баскетитем с quantity
            $basket_item_book = BasketItem::firstOrCreate([
                'book_id' => $bookId,
                'basket_id' => $basket->id,],
                ['quantity' => 0]);
            //ЕСЛИ ВСЕ ОК И МЕНЬШЕ СТОКА ТО +1 QUANTITY
            if ($basket_item_book->quantity < $stock) {
                $basket_item_book->increment('quantity');
                $basket->price += $basket_item_book->book->price;
                $basket->save();
                $bookFullPrice = $basket_item_book->book->price * $basket_item_book->quantity;
                $bookInBasketQuantity = $basket->basket_items()->pluck('quantity')->sum();

                return response()->json([
                    'success' => true,
                    'quantity' => $basket_item_book->quantity,
                    'bookInBasketQuantity' => $bookInBasketQuantity,
                    'basketPrice' => round($basket->price, 2),
                    'bookFullPrice' => round($bookFullPrice, 2),
                    'message' => 'книг прабавлено 1']);
            } //ЕСЛИ КНИГ === СТОК
            elseif ($basket_item_book->quantity == $stock) {
                $bookInBasketQuantity = $basket->basket_items()->pluck('quantity')->sum();
                $bookFullPrice = $basket_item_book->book->price * $basket_item_book->quantity;

                return response()->json([
                    'success' => true,
                    'quantity' => $basket_item_book->quantity,
                    'bookInBasketQuantity' => $bookInBasketQuantity,
                    'basketPrice' => round($basket->price, 2),
                    'bookFullPrice' => round($bookFullPrice, 2),
                    'bookMax' => true,
                    'message' => 'Выбрано максимальное количество книг']);
            }
        } // ЕСЛИ НЕ АВТОРИЗОВАН
        else {
            $books = collect(session()->get('books', []));
            $book_exist = false;
            $stock_max = false;
            $books = $books->map(function ($item) use (&$stock_max, &$book_exist, $bookId) {
                if ($item->id == $bookId) {
                    if ($item->quantity < $item->stock) {
                        Log::info($item->quantity);
                        $item->quantity++;
                    } else {
                        $stock_max = true;
                    }
                    $book_exist = true;
                }
                return $item;
            });
            session(['books' => $books]);
            $bookInBasketQuantity = $books->pluck('quantity')->sum();

            if (!$stock_max && $book_exist) {
                $book = $books->where('id', $bookId)->first();

                return response()->json([
                    'success' => true,
                    'quantity' => $book->quantity,
                    'bookInBasketQuantity' => $bookInBasketQuantity,
                    'message' => '+1 book']);
            } elseif ($stock_max && $book_exist) {
                $book = $books->where('id', $bookId)->first();

                return response()->json([
                    'success' => true,
                    'quantity' => $book->quantity,
                    'bookInBasketQuantity' => $bookInBasketQuantity,
                    'bookMax' => true,
                    'message' => 'max book quantity'
                ]);
            } //ЕСЛИ НЕТ ВООБЩЕ КНИГИ В БАСКЕТЕ
            elseif (!$book_exist) {
                $book->quantity = 1;
                $books->push($book);
                $bookInBasketQuantity = $books->pluck('quantity')->sum();

                return response()->json([
                    'success' => true,
                    'quantity' => $book->quantity,
                    'bookInBasketQuantity' => $bookInBasketQuantity,
                    'message' => 'first book'
                ]);
            }
        }
    }


    public function decrease(Request $request)
    {
        $bookId = $request->input('book_id');
        $book = Book::find($bookId);

        // ЕСЛИ НЕ АВТОРИЗОВАН
        if (session()->has('books')) {
            $books = collect(session()->get('books', []));
            $book_zero = false;
            $books = $books->map(function ($book) use ($bookId, &$book_zero) {
                if ($book->id == $bookId) {
                    if ($book->quantity > 1) {
                        $book->quantity--;
                    } else {
                        $book = null;
                        $book_zero = true;
                    }
                }
                return $book;
            })->filter();

            session(['books' => $books]);
            $bookInBasketQuantity = $books->pluck('quantity')->sum();
            if ($book_zero) {
                $quantity = 0;
            } else {
                $book = $books->where('id', $bookId)->firstOrFail();
                $quantity = $book->quantity;

            }
            return response()->json([
                'success' => true,
                'quantity' => $quantity,
                'bookInBasketQuantity' => $bookInBasketQuantity,
                'message' => '-1']);
        }
        //ЕСЛИ АВТОРИЗОВАН
        if (Auth::check()) {
            $basket = app('basket');
            $bookInBasket = BasketItem::where('basket_id', $basket->id)->where('book_id', $bookId)->first();
            //ЕСЛИ 1 КНИГА ОСТАЛАСЬ
            if ($bookInBasket->quantity == 1) {
                $bookInBasket->delete();
                //ЕСЛИ ЭТО ПОСЛЕДНЯЯ КНИГА В БАСКЕТЕ
                if (BasketItem::where('basket_id', $basket->id)->count() == 0) {
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

    }

    public function deleteAllByBook(Request $request, Book $book)
    {
        $basket = app('basket');
        $books = collect(session()->get('books', []));
        if (!auth()->check()) {
            $books = $books->reject(function ($item) use ($books, $book) {
                return $item->id == $book->id;
            });
            session(['books' => $books]);
        } else {
            BasketItem::where(['book_id' => $book->id, 'basket_id' => $basket->id])->delete();
            // $request->session()->forget('books');
        }


        return back();

    }
}
