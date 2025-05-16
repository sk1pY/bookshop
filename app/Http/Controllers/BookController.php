<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Basket;
use App\Models\Basket_items;
use App\Models\BasketItem;
use App\Models\Book;
use App\Models\Bookmark;
use App\Models\Category;
use App\Models\Commentary;
use App\Models\InterfaceSite;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use function Termwind\ask;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $slides = InterfaceSite::where('type', 'slide')->get();
        $basket = app('basket');


        $books = Book::latest();

        if ($request->filled('filter')) {
            switch ($request->input('filter')) {
                case 'cheap':
                    $books->orderBy('price');
                    break;
                case 'expensive':
                    $books->orderBy('price', 'desc');
                    break;
                case 'rating':
                    $books->orderBy('avgRating', 'desc');
            }
        }
        $books = $books->get();

        $books = $books->map(function ($book) {
            $basketitem = BasketItem::where('book_id', $book->id)->first();
            if (BasketItem::where('book_id', $book->id)->exists()) {
                $book->quantity = $basketitem->quantity;
            }
            return $book;
        });

        return view('index', compact('books', 'slides'));
    }


    public function show(Book $book)
    {
        $orders = Order::where('user_id', Auth::id())->where('status', 'Получен')->pluck('id');
        $book_id = OrderItem::whereIn('order_id', $orders)->pluck('book_id')->toArray();

        $bookQuantityInBakset = BasketItem::where('book_id', $book->id)->first()->quantity?:0;

        in_array($book->id, $book_id) ? $bought = true : $bought = false;

        $commentaries = Commentary::where('book_id', $book->id)->orderBy('created_at', 'desc')->get();

        return view('book', compact('book', 'commentaries', 'bought','bookQuantityInBakset'));
    }


}
