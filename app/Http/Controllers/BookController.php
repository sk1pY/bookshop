<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Basket;
use App\Models\Basket_items;
use App\Models\Book;
use App\Models\Bookmark;
use App\Models\Category;
use App\Models\Commentary;
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
        $bookmarkTaskUser = Bookmark::where('user_id', Auth::id())->pluck('book_id')->toArray();

        $query = Book::withCount(['commentaries']);

        if ($request->filled('filter')) {
            switch ($request->input('filter')) {
                case 'cheap':
                    $query->orderBy('price', 'asc');
                    break;
                case 'expensive':
                    $query->orderBy('price', 'desc');
                    break;
                case 'rating':
                    $query->orderBy('avgRating', 'desc');
            }

        }

        $books = $query->get();

        return view('index', compact('books', 'bookmarkTaskUser'));
    }



    public function book($id)
    {
        //id books которые юзер купил
        $orders = Order::where('user_id', Auth::id())->where('status', 'Получен')->pluck('id');
        $book_id = OrderItem::whereIn('order_id', $orders)->pluck('book_id')->toArray();


        in_array($id,$book_id) ? $bought= true : $bought = false;

        $book = Book::find($id);
        $commentaries = Commentary::where('book_id', $id)->orderBy('created_at', 'desc')->get();

        return view('book', compact('book', 'commentaries', 'bought'));
    }



}
