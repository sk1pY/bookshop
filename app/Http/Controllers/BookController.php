<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Basket;
use App\Models\Basket_items;
use App\Models\BasketItem;
use App\Models\Book;
use App\Models\Bookmark;
use App\Models\Category;
use App\Models\Comment;

use App\Models\InterfaceSite;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;
use function Termwind\ask;

class BookController extends Controller
{
    public function index(Request $request)
    {
        //  dd(Book::get());

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
//////////////// ПРИ ЗАХОДЕ ПОСЛЕ АВТОРИЗАЦИИ НА iNDEX ИДЕТ MERGE КНИГ ИЗ SESSIO И AUTH
        //перебор книг сессии
        if (Auth::check()) {
            $books_session = collect(session('books', []));
            $books_session->each(function ($book) use ($basket) {
                $basketitem = BasketItem::firstOrCreate([
                    'book_id' => $book->id,
                    'basket_id' => $basket->id],
                    ['quantity' => 0]);
                if ($basketitem->quantity < $basketitem->book->stock) {
                    $basketitem->update([
                        'quantity' => $basketitem->quantity + $book->quantity,
                    ]);
                    $basketitem->save();
                }

                session()->forget('books');

            });

            $quantities = $basket->basket_items()->pluck('quantity', 'book_id');
                $books->map(function ($book) use ($quantities) {
                    $book->quantity = $quantities[$book->id] ?? 0;
                    return $book;
                });
        }
        /////////////////////////////////////////////////////////////////////////////////////////

        //ДЛЯ SESSIII
        else {
            $books_session = collect(session('books', []))->keyBy('id');
            $books->map(function ($book) use ($books_session) {
                if ($books_session->has($book->id)) {
                    $book->quantity = $books_session->get($book->id)->quantity;
                }
                return $book;
            });
        }
        return view('front.index', compact('books', 'slides'));
    }

    public function show(Book $book)
    {
        $orders = Order::where('user_id', Auth::id())->where('status', 'Получен')->pluck('id');
        $book_id = OrderItem::whereIn('order_id', $orders)->pluck('book_id')->toArray();

        $bookQuantityInBakset = BasketItem::where('book_id', $book->id)->first()->quantity ?? 0;

        in_array($book->id, $book_id) ? $bought = true : $bought = false;

        $commentaries = Comment::where('book_id', $book->id)->orderBy('created_at', 'desc')->paginate(6);


        return view('front.book', compact('book', 'commentaries', 'bought', 'bookQuantityInBakset'));
    }


}
