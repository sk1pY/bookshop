<?php

namespace App\Services;

use App\Models\Basket;
use App\Models\BasketItem;
use App\Models\Book;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class BasketItemService
{
    protected BasketService $basketService;

    public function __construct(BasketService $basketService)
    {
        $this->basketService = $basketService;

    }

    public function increase(Book $book): JsonResponse
    {
        $basket = $this->basketService->getBasket();

        $data = Auth::check() ?
            $this->increaseBookAuth($basket, $book) :
            $this->increaseBookGuest($book);

        return response()->json($data);
    }

    public function decrease($book): JsonResponse
    {
        $basket = $this->basketService->getBasket();

        $data = Auth::check() ?
            $this->decreaseBookAuth($basket, $book) :
            $this->decreaseBookGuest($book);

        return response()->json($data);
    }

    //AUTH
    protected function increaseBookAuth(Basket $basket, Book $book): array
    {
        $bookId = $book->id;
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

            return [
                'success' => true,
                'quantity' => $basket_item_book->quantity,
                'bookInBasketQuantity' => $bookInBasketQuantity,
                'basketPrice' => round($basket->price, 2),
                'bookFullPrice' => round($bookFullPrice, 2),
                'message' => 'книг прабавлено 1'];
        }

        if ($basket_item_book->quantity === $stock) {
            $bookInBasketQuantity = $basket->basket_items()->pluck('quantity')->sum();
            $bookFullPrice = $basket_item_book->book->price * $basket_item_book->quantity;

            return [
                'success' => true,
                'quantity' => $basket_item_book->quantity,
                'bookInBasketQuantity' => $bookInBasketQuantity,
                'basketPrice' => round($basket->price, 2),
                'bookFullPrice' => round($bookFullPrice, 2),
                'bookMax' => true,
                'message' => 'Выбрано максимальное количество книг'];
        }
        return [];
    }

    protected function decreaseBookAuth(Basket $basket, Book $book): array
    {
        $bookId = $book->id;
        $bookInBasket = BasketItem::where('basket_id', $basket->id)->where('book_id', $bookId)->first();
        //ЕСЛИ 1 КНИГА ОСТАЛАСЬ
        if ($bookInBasket->quantity == 1) {
            $bookInBasket->delete();

            $bookInBasketQuantity = $basket->basket_items()->pluck('quantity')->sum();
            $bookFullPrice = $bookInBasket->book->price * $bookInBasket->quantity;
            $basket->price -= $bookInBasket->book->price;
            $basket->save();
            return [
                'success' => true,
                'quantity' => 0,
                'basketPrice' => round($basket->price, 2),
                'bookInBasketQuantity' => $bookInBasketQuantity,
                'bookFullPrice' => round($bookFullPrice, 2),
                'message' => 'последняя книга удалена из корзины'];
        }

        $bookInBasket->decrement('quantity');
        $basket->price -= $bookInBasket->book->price;
        $basket->save();
        $bookInBasketQuantity = $basket->basket_items()->pluck('quantity')->sum();
        $bookFullPrice = $bookInBasket->book->price * $bookInBasket->quantity;


        return [
            'success' => true,
            'quantity' => $bookInBasket->quantity,
            'basketPrice' => round($basket->price, 2),
            'bookInBasketQuantity' => $bookInBasketQuantity,
            'bookFullPrice' => round($bookFullPrice, 2),
            'message' => 'книг уменьшено на 1'];
    }

    //GUEST
    protected function increaseBookGuest(Book $book): array
    {
        $bookId = $book->id;
        $books = $this->basketService->booksInBasket();
        $book_exist = false;
        $stock_max = false;
        $books = $books->map(function ($item) use (&$stock_max, &$book_exist, $bookId) {
            if ($item->id === $bookId) {
                if ($item->quantity < $item->stock) {
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

        $basketPrice = $books->sum(function ($item) {
            return $item->quantity * $item->price;
        });
        if (!$stock_max && $book_exist) {
            $book = $books->where('id', $bookId)->first();

            return [
                'success' => true,
                'quantity' => $book->quantity,
                'bookInBasketQuantity' => $bookInBasketQuantity,
                'basketPrice' => round($basketPrice, 2),
                'message' => '+1 book'];
        }

        if ($stock_max && $book_exist) {
            $book = $books->where('id', $bookId)->first();

            return [
                'success' => true,
                'quantity' => $book->quantity,
                'bookInBasketQuantity' => $bookInBasketQuantity,
                'bookMax' => true,
                'basketPrice' => round($basketPrice, 2),

                'message' => 'max book quantity'];
        }

        if (!$book_exist) {
            $book->quantity = 1;
            $books->push($book);
            $bookInBasketQuantity = $books->pluck('quantity')->sum();
            $basketPrice = $books->sum(function ($item) {
                return $item->quantity * $item->price;
            });
            return [
                'success' => true,
                'quantity' => $book->quantity,
                'bookInBasketQuantity' => $bookInBasketQuantity,
                'basketPrice' => round($basketPrice, 2),

                'message' => 'first book'
            ];
        }
        return [];
    }

    protected function decreaseBookGuest(Book $book): array
    {
        $bookId = $book->id;
        $books = $this->basketService->booksInBasket();
        $book_zero = false;
        $books = $books->map(function ($book) use ($bookId, &$book_zero) {
            if ($book->id === $bookId) {
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
        $basketPrice = $books->sum(function ($item) {
            return $item->quantity * $item->price;
        });
        if ($book_zero) {
            $quantity = 0;
        } else {
            $book = $books->where('id', $bookId)->firstOrFail();
            $quantity = $book->quantity;

        }
        return [
            'success' => true,
            'quantity' => $quantity,
            'bookInBasketQuantity' => $bookInBasketQuantity,
            'basketPrice' => round($basketPrice, 2),
            'message' => '-1'];

    }
}
