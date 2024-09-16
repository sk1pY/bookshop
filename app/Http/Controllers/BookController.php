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

        $categories = Category::all();
        $query = Book::withCount(['commentaries']);

        if ($request->filled('filter')) {
            switch ($request->input('filter')) {
                case 'cheap':
                    $query->orderBy('price', 'asc');
                    break;
                case 'expensive':
                    $query->orderBy('price', 'desc');
                    break;


            }

        }
        $books = $query->get();
        return view('index', compact('books', 'categories','bookmarkTaskUser'));
    }

    public function author($id)
    {
        $booksOfAuthor = Book::where('author_id', $id)->get();
        return view('author', compact('booksOfAuthor'));
    }

    public function book($id)
    {
        //id books которые юзер купил
        $orders = Order::where('user_id', Auth::id())->where('status', 'Получен')->pluck('id');
        $booksIds = OrderItem::whereIn('order_id', $orders)->pluck('book_id')->unique()->toarray();
        //
        $bought = in_array($id, $booksIds);

        $book = Book::find($id);
        $commentaries = Commentary::where('book_id', $id)->orderBy('created_at', 'desc')->get();

        return view('book', compact('book', 'commentaries','bought'));
    }

    public function categoryBooks($id)
    {
        $categories = Category::all();

        $books = Book::where('category_id', $id)->get();
        return view('category', compact('books', 'categories'));
    }

}
