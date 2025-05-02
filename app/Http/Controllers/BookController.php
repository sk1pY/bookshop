<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Basket;
use App\Models\Basket_items;
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
        $bookQuery = Book::latest();

        if ($request->filled('filter')) {
            switch ($request->input('filter')) {
                case 'cheap':
                    $bookQuery->orderBy('price');
                    break;
                case 'expensive':
                    $bookQuery->orderBy('price', 'desc');
                    break;
                case 'rating':
                    $bookQuery->orderBy('avgRating', 'desc');
            }
        }
        $books = $bookQuery->paginate(10);

        return view('index', compact('books', 'slides'));
    }


    public function show(Book $book)
    {
        $orders = Order::where('user_id', Auth::id())->where('status', 'Получен')->pluck('id');
        $book_id = OrderItem::whereIn('order_id', $orders)->pluck('book_id')->toArray();


        in_array($book->id, $book_id) ? $bought = true : $bought = false;

        $commentaries = Commentary::where('book_id', $book->id)->orderBy('created_at', 'desc')->get();

        return view('book', compact('book', 'commentaries', 'bought'));
    }


}
