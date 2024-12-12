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


        return view('index', compact( 'bookmarkTaskUser'));
    }



    public function book(Book $book)
    {
        //id books которые юзер купил
        $orders = Order::where('user_id', Auth::id())->where('status', 'Получен')->pluck('id');
        $book_id = OrderItem::whereIn('order_id', $orders)->pluck('book_id')->toArray();


        in_array($book->id,$book_id) ? $bought= true : $bought = false;

        $commentaries = Commentary::where('book_id', $book->id)->orderBy('created_at', 'desc')->get();

        return view('book', compact('book', 'commentaries', 'bought'));
    }

    public function category_bestsellers(){
        $bookmarkTaskUser = Bookmark::where('user_id', Auth::id())->pluck('book_id')->toArray();

        $books = \App\Models\Book::orderBy('numberOfPurchased','desc')->get();
        return view('bestsellers',compact('books','bookmarkTaskUser'));
    }
    public function category_newest(){
        $bookmarkTaskUser = Bookmark::where('user_id', Auth::id())->pluck('book_id')->toArray();

        $books = \App\Models\Book::orderBy('created_at','asc')->get();
        return view('newest',compact('books','bookmarkTaskUser'));
    }
 public function category_sale(){
        $bookmarkTaskUser = Bookmark::where('user_id', Auth::id())->pluck('book_id')->toArray();

        $books = \App\Models\Book::where('discount','>',0)->get();
       // dd($books);
        return view('sale',compact('books','bookmarkTaskUser'));
    }

}
