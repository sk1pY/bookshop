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
use App\Services\BasketItemService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use function PHPSTORM_META\map;
use function PHPUnit\Framework\isEmpty;
use function Sodium\increment;

class BasketItemController extends Controller
{
    public function increase(Request $request, BasketItemService $basketItemService)
    {
        $bookId = $request->input('book_id');
        $book = Book::find($bookId);

        return $basketItemService->increase($book);

    }

    public function decrease(Request $request, BasketItemService $basketItemService)
    {
        $bookId = $request->input('book_id');
        $book = Book::find($bookId);

        return $basketItemService->decrease($book);
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
        }

        return back();

    }
}
